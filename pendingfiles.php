<?php
include_once('inc.php');
include_once('config/session-check.inc.php');

// Define cleanquestionmark if not already defined
if (!function_exists('cleanquestionmark')) {
	function cleanquestionmark($str)
	{
		return str_replace('?', '', $str);
	}
}

?>

<?php
if ($_GET["eid"] == '') {
	$strWhere = " and name='' ";
} else {
	$strWhere = " and name!='' and id=" . decodeStr($_GET["eid"]) . " ";


}

$a = "";
$n = 1;

// ✅ Proper MySQLi query with connection variable
$a = mysqli_query($conn, "SELECT * FROM " . _VAULT_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' " . $strWhere . " ORDER BY id DESC");

// ✅ Use mysqli_num_rows instead of mysql_num_rows
$totaldocuments = mysqli_num_rows($a);

// ✅ Use mysqli_fetch_assoc or mysqli_fetch_array
while ($rowpendingfile = mysqli_fetch_array($a)) {

	$strFileExtention = findExtension($rowpendingfile["documentFile"]);
	?>
	<form class="edit-layer" enctype="multipart/form-data" name="uploadpendingdocuments<?php echo $rowpendingfile["id"]; ?>"
		id="uploadpendingdocuments<?php echo $rowpendingfile["id"]; ?>" method="post" target="actionfrm"
		action="<?php echo $fullurl; ?>common_action.php">
		<div class="file-uploded"><span id="gotoedit"></span>
			<div class="uploded-headng" id="<?php echo $rowpendingfile["id"]; ?>">
				<h2><?php if ($_GET["eid"] == '') { ?>Upload <?php echo $n; ?> of <?php echo $totaldocuments; ?>
					<?php } else { ?>Edit this document<?php } ?>
				</h2>
				<a title="Delete Document"
					onClick="alertpopupmain('<?php echo encodeStr($rowpendingfile['id']); ?>','deldocument');"><i
						class="fa fa-trash-o" aria-hidden="true"></i></a>
			</div>
			<div class="uploded-wrap">
				<div class="uploded-file-sec">
					<img src="<?php echo $fullurl; ?><?php if (file_exists('uploads/' . $rowpendingfile["documentFile"] . '.jpg')) { ?>uploads/<?php echo $rowpendingfile["documentFile"] . '.jpg';
					   } else { ?>images/<?php if ($strFileExtention == 'doc') {
							 echo 'doc.png';
						 }
						 if ($strFileExtention == 'xls') {
							 echo 'xls.png';
						 }
						 if ($strFileExtention == 'ppt') {
							 echo 'ppt.png';
						 }
						 if ($strFileExtention == 'pdf') {
							 echo 'pdf.png';
						 }
					   } ?>" width="100%" height="100%">
				</div>
				<div class="uploded-from">
					<div class="form-group">
						<label>Title</label>
						<input type="text" name="name" id="name<?php echo $rowpendingfile["id"]; ?>" class="validate"
							maxlength="150" value="<?php echo cleanquestionmark($rowpendingfile["name"]); ?>">
					</div>
					<div class="form-group">
						<label>Description</label>
						<textarea rows="4" name="longDescription" id="longDescription<?php echo $rowpendingfile["id"]; ?>"
							class="validate"
							maxlength="500"><?php echo cleanquestionmark($rowpendingfile["longDescription"]); ?></textarea>
					</div>
					<div class="form-group half pd-right">
						<label>Category</label>
						<select name="catIds" id="catIds<?php echo $rowpendingfile["id"]; ?>" class="validate">
							<option value="">Select</option>
							<?php
							$selectFields = [];
							$whereFields = [];
							$whereVals = [];

							$sqlOptions1 = "";
							$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry' ";
							$resOptions1 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
							if ($resOptions1) {
								while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
									if ($rowpendingfile["catIds"] == $rowOptions1['id']) {
										$strSelected = 'selected="selected"';
									} else {
										$strSelected = "";
									}
									?>
									<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>>
										<?php echo trim($rowOptions1['optionName']); ?>
									</option>
									<?php
								}
							}
							?>
						</select>
					</div>
					<div class="form-group half pd-left">
						<label>Privacy</label>
						<select name="privacy" id="privacy<?php echo $rowpendingfile["id"]; ?>">
							<option value="1" <?php if ($rowpendingfile["privacy"] == 1) {
								echo "selected";
							} ?>>Public
							</option>
							<option value="2" <?php if ($rowpendingfile["privacy"] == 2) {
								echo "selected";
							} ?>>Private
							</option>
						</select>
					</div>
					<div class="form-group">
						<label>Tag</label>
						<input type="text" name="documentKeyword" id="documentKeyword"
							placeholder="Enter comma saprated keywords" maxlength="250"
							value="<?php echo $rowpendingfile["documentKeyword"]; ?>">
					</div>
					<?php if ($_GET["eid"] == '') { ?>
						<div class="trms tlntssss">
							<div class="form-group">
								<input type="checkbox" name="publishStatus" id="publishStatus" value="1" checked="checked"
									onclick="return false;" autocomplete="off">
								&nbsp; I confirm that I am authorized to Post this document on <?php echo $companNameTitle; ?>
								and if any image is used, I have the rights to use the image.
							</div>
						</div><input type="hidden" name="p" id="p" value="0" /><?php } else { ?><input type="hidden" name="p"
							id="p" value="1" />
					<?php } ?>
				</div>
			</div>
			<div class="uploded-fttr">
				<button class="uploded-sbmitbtn" type="button"
					onClick="formValidation('uploadpendingdocuments<?php echo $rowpendingfile["id"]; ?>');">Publish</button>
			</div>
		</div>
		<input type="hidden" name="fileId" id="fileId" value="<?php echo $rowpendingfile["id"]; ?>" />
		<input type="hidden" name="action" id="action" value="updatedocuments" />


	</form>

	<?php
	$n++;
}
?>


<?php
$a = "";
$n = 1;

// ✅ Run query using mysqli_query (requires $conn connection)
$a = mysqli_query($conn, "SELECT * FROM " . _VAULT_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' AND name!='' ORDER BY id DESC");

// ✅ Get total number of documents
$totaldocuments = mysqli_num_rows($a);

// ✅ Loop through all fetched records
while ($rowpendingfile = mysqli_fetch_array($a)) {
	$strFileExtention = findExtension($rowpendingfile["documentFile"]);
	?>
	<div class="file-uploded">
		<div class="uploded-headng published">
			<h2>Upload <?php echo $n; ?> of <?php echo $totaldocuments; ?> </h2>
			<h2 style="text-align: right;">Published</h2>
		</div>
		<div class="uploded-wrap">
			<div class="publish-doc">
				<a href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>"><img
						src="<?php echo $fullurl; ?><?php if (file_exists('uploads/' . $rowpendingfile["documentFile"] . '.jpg')) { ?>uploads/<?php echo $rowpendingfile["documentFile"] . '.jpg';
						   } else { ?>images/<?php if ($strFileExtention == 'doc') {
								 echo 'doc.png';
							 }
							 if ($strFileExtention == 'xls') {
								 echo 'xls.png';
							 }
							 if ($strFileExtention == 'ppt') {
								 echo 'ppt.png';
							 }
							 if ($strFileExtention == 'pdf') {
								 echo 'pdf.png';
							 }
						   } ?>" width="100%" height="100%"></a>
			</div>

			<div class="published-rightdtail">

				<a href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>"
					class="nm"><?php echo stripslashes(cleanquestionmark($rowpendingfile["name"])); ?></a>
				<div class="desc">
					<?php echo getStrLength(strip_tags(stripslashes(cleanquestionmark($rowpendingfile["longDescription"]))), 150); ?>
				</div>
				<label class="time"><?php echo makedatetime($rowpendingfile["dateAdded"]); ?></label>
				<?php if ($rowpendingfile["privacy"] == 1) { ?>
					<div class="privacy-tag">Public</div><?php } else { ?>
					<div class="privacy-tag" style=" background-color:#f4bc2d;">Private</div><?php } ?>
				<ul class="hover-btn">
					<li><a class="edit"
							href="<?php echo $fullurl; ?>upload-documents.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>"><i
								class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a>
					</li>
					<li style="display:none;"><a href="#" class="dlt"><i class="fa fa-trash-o"
								aria-hidden="true"></i>&nbsp;</a></li>
				</ul>
			</div>
		</div>
	</div>

	<?php
	$n++;
}
?>
<script>
	$("#name<?php echo decodeStr($_GET["eid"]); ?>").focus();
</script>