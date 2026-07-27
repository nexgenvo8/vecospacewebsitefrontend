<?php
include_once('inc.php');
include_once('config/session-check.inc.php');
include('mail.php');
$pageIndex = 13;
$action = isset($_POST['action']) ? trim($_POST['action']) : '';


if (isPost()) {
	$id = clean($_POST['id']);

	//print_r($_POST);

	$myname = clean($_POST['talentName']);
	$shortDescription = addslashes($_POST['shortDescription']);
	$longDescription = addslashes($_POST['longDescription']);
	$contactPerson = isset($_POST['contactPerson']) ? normalclean($_POST['contactPerson']) : '';



	if (empty($_POST['categoryId']) || count($_POST['categoryId']) <= 0) {
		$errorMsg = "Please select atleast one category";
	}

	if (empty($_POST['categoryId']) || count($_POST['categoryId']) <= 0) {
		$categoryId = '';
		if (!empty($_POST['categoryId']) && is_array($_POST['categoryId'])) {
			if (trim($_POST["categoryId"][$k]) != '' && trim($_POST["categoryId"][$k]) != '0') {
				if (is_numeric(trim($_POST["categoryId"][$k]))) {
					$categoryId .= ',' . $_POST["categoryId"][$k];
				}
			}
		}
		$categoryId = trim($categoryId, ',');
		$categoryIdArr = explode(",", $categoryId);
	}




	$file_name = $_FILES['talentProfilePhoto']['name'];
	$timename = time();
	if ($file_name != '') {
		$fileExt = findExtension($file_name);

		if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {
			$file_name = $timename . $file_name;
			copy($_FILES['talentProfilePhoto']['tmp_name'], "uploads/" . $file_name);
			if ($_POST['oldtalentProfilePhoto'] != '') {
				unlink("uploads/" . $_POST["oldtalentProfilePhoto"]);
			}

			$upimg = 'uploads/' . $file_name;

			//image_fix_orientation($upimg);

		}

	} else {
		$file_name = $_POST["oldtalentProfilePhoto"];
	}


	if ($myname != '' && $action == 'add') {
		unset($insertFields);
		$insertVals = [];
		$whereFields = [];
		$whereVals = [];


		$insertFields[0] = "talentName";
		$insertFields[1] = "userId";
		$insertFields[2] = "shortDescription";
		$insertFields[3] = "longDescription";
		$insertFields[4] = "catIds";
		$insertFields[5] = "talentProfilePhoto";
		$insertFields[6] = "dateAdded";

		$insertVals[0] = $myname;
		$insertVals[1] = $_SESSION["sessUserId"];
		$insertVals[2] = $shortDescription;
		$insertVals[3] = $longDescription;
		$insertVals[4] = $categoryId;
		$insertVals[5] = $file_name;
		$insertVals[6] = date("Y-m-d H:i:s");


		$resUpdate = insertDB(_TALENT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		$_SESSION["s"] = 1;

		$mailBodyContent = '';
		$mailBodyContent = $myfirstName . ' ' . $mylastName . ' created a Talent Profile <strong>' . $myname . '</strong> - ' . date("H:i:s - d/m/Y") . '';

		$subject = $myfirstName . ' ' . $mylastName . ' (' . $myemail . ') created a Talent Profile';

		adminnotification($subject, $mailBodyContent);


		header('Location:my-talent-profiles.html');
		exit();

	}

	if ($myname != '' && $action == 'edit') {


		unset($insertFields);
		unset($insertVals);
		unset($whereFields);
		unset($whereVals);


		$insertFields[0] = "talentName";
		$insertFields[1] = "catIds";
		$insertFields[2] = "shortDescription";
		$insertFields[3] = "longDescription";
		$insertFields[4] = "talentProfilePhoto";
		$insertFields[5] = "modifyDate";

		$insertVals[0] = $myname;
		$insertVals[1] = $categoryId;
		$insertVals[2] = $shortDescription;
		$insertVals[3] = $longDescription;
		$insertVals[4] = $file_name;
		$insertVals[5] = date("Y-m-d H:i:s");

		$whereFields[0] = "id";

		$whereVals[0] = $id;

		$resUpdate = updateDB(_TALENT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
		$postId = $id;
		$_SESSION["s"] = 2;

		header('Location:my-talent-profiles.html');
		exit();

	}
}

$action = 'add';
$btnValue = 'Save';
if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
	$sqlCompany = "SELECT * from " . _TALENT_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['id']) . " ";
	$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
	$rowCompany = mysqli_fetch_array($resCompany);
	$createdby = $rowCompany["userId"];
	if ($createdby != $_SESSION["sessUserId"]) {
		header('Location:my-talent-profiles.html');
		exit();
	}
	if ($rowCompany['talentName'] == '') {
		header('Location:my-talent-profiles.html');
		exit();
	}

	$id = trim($rowCompany['id']);
	$myname = stripslashes($rowCompany['talentName']);

	$shortDescription = stripslashes($rowCompany['shortDescription']);
	$longDescription = stripslashes($rowCompany['longDescription']);
	$talentProfilePhoto = trim($rowCompany['talentProfilePhoto']);

	$categoryId = stripslashes($rowCompany['catIds']);
	$categoryIdArr = explode(",", $categoryId);


	$action = 'edit';
	$btnValue = 'Save';

}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Talent - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<script>
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();

				reader.onload = function (e) {
					$('#blah')
						.attr('src', e.target.result)
						.width(375)
						.height(200);
				};

				reader.readAsDataURL(input.files[0]);
			}
		}

	</script>
</head>

<body>
	<div id="wrapper">
		<?php include('header.php'); ?>
		<div class="container main">
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
				} else {
					echo 'nologin';
				} ?>">
					<div class="smb-cont">
						<div class="cbp-wrap">
							<h1>Create Talent Profile</h1>
							<form name="frmkonectt" id="frmkonectt" method="post" enctype="multipart/form-data">
								<div class="cbp-row">
									<label>Name<span class="reqstar">*</span> </label>
									<input type="text" name="talentName" id="talentName" maxlength="150"
										class="validate" onKeyUp="hideerrordiv(this.id);"
										value="<?php echo $myname; ?>">
								</div>
								<div class="cbp-row">
									<label style="font-size: 18px; margin-bottom: 10px;">Select Topics</label>
									<div
										style="    overflow: auto; height: 176px; border: solid 1px #e7e7e7; padding: 20px;">
										<div style="display:block;" class="notif-sttng-box">
											<?php
											$selectFields = [];
											$whereFields = [];
											$whereVals = [];

											$sqlOptions = "";
											$categoryIdArr = [];
											$sqlOptions = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='talent' order by optionName";
											$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
											if ($resOptions) {
												while ($rowOptions = mysqli_fetch_array($resOptions)) {
													if (is_array($categoryIdArr)) {
														if (in_array($rowOptions["id"], $categoryIdArr))
															$strSelected = "checked='checked'";
														else
															$strSelected = "";
													} else {
														$strSelected = "";
													}
													?>
													<label>
														<div><input type="checkbox" name="categoryId[]" id="categoryId"
																value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected; ?> />
															<?php echo trim($rowOptions['optionName']); ?></div>
													</label>
													<?php
												}
											}
											?>
										</div>



									</div>
								</div>

								<div class="cbp-row">
									<label>Short Description (maximum 150 characters)<span
											class="reqstar">*</span></label>
									<?php
									$shortDescription = isset($shortDescription) ? $shortDescription : '';
									?>
									<input type="text" name="shortDescription" id="shortDescription" maxlength="150"
										class="validate" onKeyUp="hideerrordiv(this.id);"
										value="<?php echo htmlspecialchars($shortDescription); ?>" placeholder="">

								</div>
								<?php
								$longDescription = isset($longDescription) ? $longDescription : '';
								?>
								<div class="cbp-row">
									<label>Detailed Description (maximum 5000 characters)</label>
									<textarea name="longDescription" style="height:200px;" rows="3" id="longDescription"
										maxlength="5000" class="validate" onKeyUp="hideerrordiv(this.id);">
<?php echo $longDescription; ?></textarea>
								</div>

								<div class="cbp-row">

									<div class="talent-photo">

										<?php
										$talentProfilePhoto = isset($talentProfilePhoto) ? $talentProfilePhoto : '';
										?>

										<div class="photo-left">
											<img id="blah"
												 src="<?php echo ($talentProfilePhoto != '') ? $fullurl.'uploads/'.$talentProfilePhoto : ''; ?>"
												 style="max-width:200px;">
										</div>

										<div class="photo-right">
											<div class="uplod-txt">
												Upload Profile Photo 
												<span>For best view 370px - 410px</span>
											</div>

											<div class="uplod-btn">
												<input name="talentProfilePhoto"
													   id="talentProfilePhoto"
													   type="file"
													   onChange="readURL(this);"
													   accept="image/x-png,image/gif,image/jpeg">
											</div>
										</div>

									</div>

								</div>
								<div class="trms tlnt">
									<label style="margin-top:0;margin-bottom: 0;">

										<input type="checkbox" name="status" id="enquiryStatus" class="validate"
											value="1" checked="checked" onClick="return false;">
										&nbsp;I confirm that I am authorized to create this talent profile and the
										information given is correct.
									</label>
								</div>
								<div class="cbp-row">
									<?php if (isset($_REQUEST['id']) && $_REQUEST['id'] != '' && $createdby == $_SESSION["sessUserId"]) {
										?>
										<script>
											function reloadPage() {
												location.reload(true);
											}
										</script>
										<a onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo $_REQUEST['id']; ?>','deltalentp');"
											style="float: left;color: #ea4335;margin-top: 30px;
text-decoration: underline;">Delete this page</a>&nbsp;
									<?php } ?>
									<button class="submit" type="button"
										onClick="formValidation('frmkonectt');"><?php echo $btnValue; ?></button>
								</div>


								<input type="hidden" id="oldtalentProfilePhoto" name="oldtalentProfilePhoto"
									value="<?php echo $talentProfilePhoto; ?>">
								<input type="hidden" id="action" name="action" value="<?php echo $action; ?>">
								<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
							</form>
						</div>
					</div>
				</div> <!-- [End center content] -->
			</div>
		</div>
	</div>


	</div>
	</div>



	</div>
	<?php include('footer.php'); ?>

	</div>

</body>

</html>
<script>
function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            if (!document.getElementById('blah')) {
                var img = document.createElement("img");
                img.id = "blah";
                img.style.maxWidth = "100px";
                img.style.marginTop = "10px";
                input.closest('.photo-left')?.appendChild(img);
            }
            document.getElementById('blah').src = e.target.result;
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>