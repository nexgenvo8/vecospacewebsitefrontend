<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$countlanguage = 1;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlLogin = "";
$sqlLogin = "select id from " . _LANGUAGES_KONECTT_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' ";
$resLogin = getRecords(_LANGUAGES_KONECTT_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
if ($resLogin) {
	while ($row = mysqli_fetch_array($resLogin)) {
		$countlanguage = $countlanguage + 1;
	}
}


?>
<?php
unset($selectFields);
$whereFields = [];
$whereVals = [];
$selectFields = [];
$sqlOptions = "SELECT id,languagesName FROM " . _LANGUAGES_MASTER_TABLE_ . " ORDER BY languagesName ASC ";
$resOptions = getRecords(_LANGUAGES_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);

$optionsHTML = '';
if ($resOptions) {
	while ($rowOptions = mysqli_fetch_array($resOptions)) {
		$optionsHTML .= '<option value="' . trim($rowOptions['languagesName']) . '">' . trim($rowOptions['languagesName']) . '</option>';
	}
}
$optionsHTML = addslashes($optionsHTML); // escape quotes for JS
?>



<script>
	window.addnewlanguage = function (id, limt) {
		id = Number(id);
		limt = Number(limt);

		if ($('#newlanguage' + id).length || limt < id) {
			return;
		}

		var displayremove = '<a onClick="removelanguage(' + Number(id) + ');" class="remove">-</a>';

		var optionsHTML = "<?php echo $optionsHTML; ?>"; // safely injected

		$('#editlanguage ul').append(
			'<li id="newlanguageli' + id + '">' +
			'<select name="check_list[]" id="newlanguage' + id + '" onChange="addnewlanguage(' + Number(id + 1) + ',100);">' +
			'<option value="">Select</option>' + optionsHTML +
			'</select>' +
			'<select name="check_listlang[]" id="languageExpertId' + id + '">' +
			'<option value="0"> - </option>' +
			'<option value="25">Basic knowledge</option>' +
			'<option value="50">Good knowledge</option>' +
			'<option value="75">Fluent</option>' +
			'<option value="100">First language</option>' +
			'</select>' +
			displayremove +
			'</li>'
		);
	};

	window.removelanguage = function (id) {
		$("#newlanguageli" + id).remove();
	};
</script>


<h3>Languages</h3><a class="add_btn"
	onClick="$('#editlanguage').show();$('#defaultlanguage').hide();addnewlanguage(<?php echo $countlanguage; ?>,100);$('#languagecontentboxs').hide();">
	<i class="fa fa-plus-circle" aria-hidden="true"></i>
	<?php if ($countlanguage > 1) { ?>Edit<?php } else { ?>Add<?php } ?>
</a>

<?php if ($countlanguage == 1) { ?>
	<div class="add_more" id="defaultlanguage">
		<h4>Do you speak any foreign languages?</h4>
		<span>Basic language skills are also worth noting.</span>
		<span class="addmore_icon"
			onClick="$('#editlanguage').show();$('#defaultlanguage').hide();addnewlanguage(<?php echo $countlanguage; ?>,100);$('#languagecontentboxs').hide();">
			<i class="fa fa-plus-circle" aria-hidden="true"></i></span>
	</div>
<?php } else { ?>

	<div class="intrs-list" id="languagecontentboxs">
		<ul class="list language"
			onClick="$('#editlanguage').show();$('#defaultlanguage').hide();addnewlanguage(<?php echo $countlanguage; ?>,100);$('#languagecontentboxs').hide();"
			style="cursor:pointer;">
			<?php

			$countlanguage = 1;
			$selectFields = [];
			$whereFields = [];
			$whereVals = [];

			$sqlLogin = "";
			$sqlLogin = "select * from " . _LANGUAGES_KONECTT_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' order by languageText asc ";
			$resLogin = getRecords(_LANGUAGES_KONECTT_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
			if ($resLogin) {
				while ($row = mysqli_fetch_array($resLogin)) {
					?>
					<li class="color<?php echo $row["experties"]; ?>">
						<span> <?php echo sanitizedboutput($row["languageText"]); ?> 			<?php if ($row["experties"] != 0) { ?> <label
									style="font-size: 12px;">(<?php if ($row["experties"] == 25) {
										echo "Basic knowledge";
									} else if ($row["experties"] == 50) {
										echo "Good knowledge";
									} else if ($row["experties"] == 75) {
										echo "Fluent";
									} else if ($row["experties"] == 100) {
										echo "First language";
									} ?>)</label><?php } ?></span>

					</li>
					<?php
				}
			}
			?>
		</ul>
	</div>

<?php } ?>


<div class="edit_box" id="editlanguage" style="display:none;">
	<form class="edit-layer" method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
		<h2></h2>
		<a onClick="$('#editlanguage').hide();$('#defaultlanguage').show();$('#languagecontentboxs').show();"
			class="close"><i class="fa fa-times" aria-hidden="true"></i></a>
		<ul class="textfieldwithdropddown">
			<?php

			$countlanguage = 1;
			$selectFields = [];
			$whereFields = [];
			$whereVals = [];

			$sqlLogin = "";
			$sqlLogin = "select * from " . _LANGUAGES_KONECTT_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' order by languageText asc ";
			$resLogin = getRecords(_LANGUAGES_KONECTT_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
			if ($resLogin) {
				while ($row = mysqli_fetch_array($resLogin)) {
					?>

					<li id="newlanguageli<?php echo $countlanguage; ?>">
						<select name="check_list[]" id="newlanguage<?php echo $countlanguage; ?>"
							onChange="addnewlanguage(Number(<?php echo $countlanguage; ?>+1),100);">
							<option value="">Select</option>
							<?php
							$selectFields = [];
							$whereFields = [];
							$whereVals = [];

							$sqlOptions = "";
							$sqlOptions = "SELECT id,languagesName FROM " . _LANGUAGES_MASTER_TABLE_ . " ORDER BY languagesName ASC ";
							$resOptions = getRecords(_LANGUAGES_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
							if ($resOptions) {
								while ($rowOptions = mysqli_fetch_array($resOptions)) {
									if ($row["languageText"] == $rowOptions['languagesName']) {
										$strSelected = 'selected="selected"';
									} else {
										$strSelected = "";
									}
									?>
									<option value="<?php echo trim($rowOptions['languagesName']); ?>" <?php echo $strSelected; ?>>
										<?php echo trim($rowOptions['languagesName']); ?>
									</option>
									<?php
								}
							}
							?>
						</select>

						<select name="check_listlang[]" id="languageExpertId">
							<option value="0"> - </option>
							<?php
							$selectFields = [];
							$whereFields = [];
							$whereVals = [];

							$sqlOptions = "";
							$sqlOptions = "SELECT id,languagesExpert FROM " . _LANGUAGES_EXPERT_TABLE_ . " ORDER BY id ASC ";
							$resOptions = getRecords(_LANGUAGES_EXPERT_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
							if ($resOptions) {
								while ($rowOptions = mysqli_fetch_array($resOptions)) {
									if ($row["experties"] == $rowOptions['id']) {
										$strSelected = 'selected="selected"';
									} else {
										$strSelected = "";
									}
									?>
									<option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected; ?>>
										<?php echo trim($rowOptions['languagesExpert']); ?>
									</option>
									<?php
								}
							}
							?>
						</select>

						<a onClick="removelanguage(Number(<?php echo $countlanguage; ?>));" class="remove">-</a>
					</li>
					<?php
					$countlanguage = $countlanguage + 1;
				}
			}
			?>

		</ul>
		<input type="hidden" name="addlanguageaction" id="addlanguageaction" value="add">
		<div class="submit-now">
			<button class="cancel" type="button" onClick="loadlanguages();">cancel</button>
			<button type="submit">Save</button>
		</div>
	</form>

</div>

<!-- <script>
	function addnewlanguage(id, limt) {
		var id = Number(id);
		var limt = Number(limt);


		if ($('#newlanguage' + id).length || limt < id) {


		} else {


			var displayremove = '<a onClick="removelanguage(' + Number(id) + ');" class="remove" >-</a></li>';


			$('#editlanguage ul').append('<li id="newlanguageli' + id + '"><select name="check_list[]" id="newlanguage' + id + '" onChange="addnewlanguage(' + Number(id + 1) + ',100);"><option value="">Select</option><?php unset($selectFields);
			$whereFields = [];
			$whereVals = [];
			$selectFields = [];
			$sqlOptions = "";
			$sqlOptions = "SELECT id,languagesName FROM " . _LANGUAGES_MASTER_TABLE_ . " ORDER BY languagesName ASC ";
			$resOptions = getRecords(_LANGUAGES_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
			if ($resOptions) {
				while ($rowOptions = mysqli_fetch_array($resOptions)) {
					if ($row["languageText"] == $rowOptions['languagesName']) {
						$strSelected = 'selected="selected"';
					} else {
						$strSelected = "";
					} ?> <option value="<?php echo trim($rowOptions['languagesName']); ?>" <?php echo $strSelected; ?> ><?php echo trim($rowOptions['languagesName']); ?></option> <?php }
			} ?></select><select name="check_listlang[]" id="languageExpertId' + id + '"><option value="0"> - </option><option value="25">Basic knowledge</option><option value="50">Good knowledge</option><option value="75">Fluent</option><option value="100">First language</option></select>' + displayremove);

			//var value = $("#newlanguage"+(id-1)+" :selected").text();

			//$("#newlanguage"+id+" option[value="+value+"]").remove();		
			//alert("#newlanguage"+id+'-----'+value);


		}
	}



	function removelanguage(id) {
		$("#newlanguageli" + id).remove();
	}


</script> -->