<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
include('mail.php');
$pageIndex = 11;
$ptab = 1;
$action = "add";
//echo $_SERVER['HTTP_REFERER'];

if (isset($_POST['projectTitle']) && trim($_POST['projectTitle']) != '') {


	$projId = $_POST['saveprojId'];
	$projectTitle = clean($_POST['projectTitle']);
	$protIndusCategory = trim($_POST['protIndusCategory']);
	$proStartDate = trim($_POST['proStartDate']);
	$proCountry = normalclean($_POST['proCountry']);
	$proCity = normalclean($_POST['proCity']);
	$proPreferredLocation = normalclean($_POST['proPreferredLocation']);
	$proWorkLocation = clean($_POST['proWorkLocation']);
	$proDuration = normalclean($_POST['proDuration']);
	$proEstimatedBudget = normalclean($_POST['proEstimatedBudget']);
	$proCurrency = normalclean($_POST['proCurrency']);
	$projectDetails = addslashes($_POST['projectDetails']);
	if ($projectDetails == '') {
		$projectDetails = '';
	}
	$proSkills = trim($_POST['proSkills']);
	$proNature = normalclean($_POST['proNature']);
	$projectStatus = isset($_POST['projectStatus']) ? normalclean($_POST['projectStatus']) : '';

}


if (
	isset($_POST['action'], $_POST['projectTitle'], $_POST['protIndusCategory'], $_POST['proCountry'], $_POST['proCity'], $_POST['projectDetails'], $_POST['proDuration']) &&
	trim($_POST['action']) == 'add' &&
	trim($_POST['projectTitle']) != '' &&
	intval($_POST['protIndusCategory']) != 0 &&
	trim($_POST['proCountry']) != '' &&
	trim($_POST['proCity']) != '' &&
	trim($_POST['projectDetails']) != '' &&
	intval($_POST['projectStatus'] ?? 0) == 1 &&
	trim($_POST['proDuration']) != ''
) {



	unset($insertFields);
	unset($insertVals);

	$insertFields[0] = "userId";
	$insertFields[1] = "projectTitle";
	$insertFields[2] = "protIndusCategory";
	$insertFields[3] = "proStartDate";
	$insertFields[4] = "dateAdded";
	$insertFields[5] = "projectStatus";
	$insertFields[6] = "proCountry";
	$insertFields[7] = "proCity";
	$insertFields[8] = "proPreferredLocation";
	$insertFields[9] = "proWorkLocation";
	$insertFields[10] = "proDuration";
	$insertFields[11] = "proEstimatedBudget";
	$insertFields[12] = "proCurrency";
	$insertFields[13] = "projectDetails";
	$insertFields[14] = "proSkills";
	$insertFields[15] = "proNature";

	$insertVals[0] = $_SESSION["sessUserId"];
	$insertVals[1] = $projectTitle;
	$insertVals[2] = $protIndusCategory;
	$insertVals[3] = $proStartDate;
	$insertVals[4] = time();
	$insertVals[5] = $projectStatus;
	$insertVals[6] = $proCountry;
	$insertVals[7] = $proCity;
	$insertVals[8] = $proPreferredLocation;
	$insertVals[9] = $proWorkLocation;
	$insertVals[10] = $proDuration;
	$insertVals[11] = $proEstimatedBudget;
	$insertVals[12] = $proCurrency;
	$insertVals[13] = $projectDetails;
	$insertVals[14] = $proSkills;
	$insertVals[15] = $proNature;

	$resUpdate = insertDB(_PROJECT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	$projId = $resUpdate;
	$_SESSION["s"] = 1;

	$mailBodyContent = '';
	$mailBodyContent = $myname . ' created a project <strong>' . $projectTitle . '</strong> - ' . date("H:i:s - d/m/Y") . '';

	$subject = $myname . ' (' . $myemail . ') created a project';

	adminnotification($subject, $mailBodyContent);

	header('Location:manage-projects.html');
	exit();

}
if (
	isset($_POST['action'], $_POST['projectTitle'], $_POST['protIndusCategory'], $_POST['proCountry'], $_POST['proCity'], $_POST['projectDetails'], $_POST['proDuration']) &&
	trim($_POST['action']) == 'edit' &&
	trim($_POST['projectTitle']) != '' &&
	intval($_POST['protIndusCategory']) != 0 &&
	trim($_POST['proCountry']) != '' &&
	trim($_POST['proCity']) != '' &&
	trim($_POST['projectDetails']) != '' &&
	trim($_POST['proDuration']) != ''
) {


	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);

	$insertFields[0] = "proNature";
	$insertFields[1] = "projectTitle";
	$insertFields[2] = "protIndusCategory";
	$insertFields[3] = "proStartDate";
	$insertFields[4] = "proSkills";
	$insertFields[5] = "projectStatus";
	$insertFields[6] = "proCountry";
	$insertFields[7] = "proCity";
	$insertFields[8] = "proPreferredLocation";
	$insertFields[9] = "proWorkLocation";
	$insertFields[10] = "proDuration";
	$insertFields[11] = "proEstimatedBudget";
	$insertFields[12] = "proCurrency";
	$insertFields[13] = "projectDetails";

	$insertVals[0] = $proNature;
	$insertVals[1] = $projectTitle;
	$insertVals[2] = $protIndusCategory;
	$insertVals[3] = $proStartDate;
	$insertVals[4] = $proSkills;
	$insertVals[5] = 1;
	$insertVals[6] = $proCountry;
	$insertVals[7] = $proCity;
	$insertVals[8] = $proPreferredLocation;
	$insertVals[9] = $proWorkLocation;
	$insertVals[10] = $proDuration;
	$insertVals[11] = $proEstimatedBudget;
	$insertVals[12] = $proCurrency;
	$insertVals[13] = $projectDetails;


	$whereFields[0] = "id";
	$whereFields[1] = "userId";

	$whereVals[0] = $projId;
	$whereVals[1] = $_SESSION['sessUserId'];

	$resUpdate = updateDB(_PROJECT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	$_SESSION["s"] = 2;
	if ($_POST["finalPost"] == 1) {
		header('Location:manage-projects.html');
		exit();
	} else {
		header('Location:manage-projects.html');
		//header('Location:preview-project.html?inpreview=1&projId='.encodeStr($projId));
		exit();
	}
}

if (isset($_REQUEST['projId']) && trim($_REQUEST['projId']) != '') {

	$sqlProjects = "SELECT * FROM " . _PROJECT_MASTER_TABLE_ . " WHERE id= " . intval(decodeStr($_REQUEST['projId']));
	$resProjects = mysqli_query($conn, $sqlProjects) or die(mysqli_error($conn));
	$rowProjects = mysqli_fetch_array($resProjects);

	$createdby = $rowProjects['userId'];
	if ($createdby != $_SESSION["sessUserId"]) {
		header('Location:projects.html');
		exit();
	}
	if ($rowProjects['projectTitle'] == '') {
		header('Location:projects.html');
		exit();
	}

	$projId = trim($rowProjects['id']);
	$projectTitle = stripslashes($rowProjects['projectTitle']);
	$protIndusCategory = trim($rowProjects['protIndusCategory']);
	$proStartDate = trim($rowProjects['proStartDate']);
	$proCountry = stripslashes($rowProjects['proCountry']);
	$proCity = stripslashes($rowProjects['proCity']);
	$proPreferredLocation = stripslashes($rowProjects['proPreferredLocation']);
	$proWorkLocation = stripslashes($rowProjects['proWorkLocation']);
	$proDuration = stripslashes($rowProjects['proDuration']);
	$proEstimatedBudget = stripslashes($rowProjects['proEstimatedBudget']);
	$proCurrency = stripslashes($rowProjects['proCurrency']);
	$projectDetails = stripslashes($rowProjects['projectDetails']);
	$proSkills = $rowProjects['proSkills'];
	$proNature = stripslashes($rowProjects['proNature']);
	$projectStatus = stripslashes($rowProjects['projectStatus']);
	$finalPost = trim($rowProjects['finalPost']);
	$action = "edit";


}
$btnname = 'Submit Project';
?>
<!DOCTYPE html>
<html>

<head>
	<title>Internship - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/default.css">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/zebra_datepicker.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<script>
		$(document).ready(function () {

			$('#proStartDate').Zebra_DatePicker({

				format: 'Y-m-d',

				// direction: [1, 400]

			});
		});

	</script>
</head>

<body>
	<div id="wrapper" class="active">
		<?php include('header.php'); ?>
		<div class="container main">
			<div class="premium_tag"><a href="#">Go Premium</a>
				<p id="typewriter"></p>
			</div>
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>

			</div>
			<div class="center_content">

				<div class="groups">
					<?php include('project_top.inc.php'); ?>
					<div class="create-projct">
						<h2>Post a internship</h2>
						<div class="post-prjct">
							<span class="prjdtail">INTERNSHIP DETAILS</span>

							<form class="post-aprjct" name="frmpostevnt" id="frmpostevnt" method="post"
								enctype="multipart/form-data">
								<label>Internship title<span class="reqstar">*</span></label>
								<input type="text" name="projectTitle" id="projectTitle"
									value="<?php echo isset($projectTitle) ? $projectTitle : ''; ?>" maxlength="150"
									class="validate">
								<!-- <input type="text" name="proCity" id="proCity"
									value="<?php echo isset($proCity) ? $proCity : ''; ?>" maxlength="150"
									class="validate"> -->


								<label>Industry category<span class="reqstar">*</span></label>
								<select name="protIndusCategory" id="protIndusCategory" class="validate"
									onChange="hideerrordiv(this.id);">
									<option value="0">Select</option>
									<?php
									unset($selectFields);
									unset($whereFields);
									unset($whereVals);

									$sqlOptions = "SELECT id, optionName FROM " . _OPTION_MASTER_TABLE_;
									$resOptions = mysqli_query($conn, $sqlOptions) or die(mysqli_error($conn));

									if ($resOptions) {
										while ($rowOptions = mysqli_fetch_array($resOptions)) {
											$strSelected = ($protIndusCategory == $rowOptions['id']) ? 'selected="selected"' : "";
											?>
											<option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected; ?>>
												<?php echo trim($rowOptions['optionName']); ?>
											</option>
											<?php
										}
									}
									?>
								</select>

								<label>Country<span class="reqstar">*</span></label>
								<select name="proCountry" id="proCountry" class="validate"
									onChange="hideerrordiv(this.id);">
									<option value="">Select</option>
									<?php
									unset($selectFields);
									unset($whereFields);
									unset($whereVals);

									$sqlOptions1 = "SELECT country_name FROM " . _COUNTRIES_TABLE_ . " ORDER BY country_name";
									$resOptions1 = mysqli_query($conn, $sqlOptions1) or die(mysqli_error($conn));

									if ($resOptions1) {
										while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
											$strSelected = ($proCountry == $rowOptions1['country_name']) ? 'selected="selected"' : "";
											?>
											<option value="<?php echo trim($rowOptions1['country_name']); ?>" <?php echo $strSelected; ?>>
												<?php echo trim($rowOptions1['country_name']); ?>
											</option>
											<?php
										}
									}
									?>
								</select>

								<label>City<span class="reqstar">*</span></label>
								<input type="text" name="proCity" id="proCity"
									value="<?php echo isset($proCity) ? $proCity : ''; ?>" maxlength="150"
									class="validate">

								<label>Internship Start date<span class="reqstar">*</span></label>
								<input type="text" name="proStartDate" id="proStartDate"
									value="<?php echo isset($proStartDate) ? $proStartDate : ''; ?>" maxlength="150"
									class="validate cal-icon">

								<label>Preferred location of the Internship Seeker</label>
								<input type="text" name="proPreferredLocation" id="proPreferredLocation"
									value="<?php echo isset($proPreferredLocation) ? $proPreferredLocation : ''; ?>">

								<?php
								// ===== Initialization to avoid undefined variable warnings =====
								$proWorkLocation = $proWorkLocation ?? '';
								$proDuration = $proDuration ?? '';
								$proEstimatedBudget = $proEstimatedBudget ?? '';
								$proCurrency = $proCurrency ?? '';
								$proSkills = $proSkills ?? '';

								?>

								<label>Work location </label>
								<input type="text" name="proWorkLocation" id="proWorkLocation"
									value="<?php echo $proWorkLocation; ?>" maxlength="250">

								<label>Duration of the Internship<span class="reqstar">*</span></label>
								<select name="proDuration" id="proDuration" class="validate">
									<option value="1 day" <?php if ($proDuration == "1 day") {
										echo "selected";
									} ?>>1 day
									</option>
									<option value="2 days" <?php if ($proDuration == "2 days") {
										echo "selected";
									} ?>>2
										days</option>
									<option value="3 days" <?php if ($proDuration == "3 days") {
										echo "selected";
									} ?>>3
										days</option>
									<option value="7 days(1 week)" <?php if ($proDuration == "7 days(1 week)") {
										echo "selected";
									} ?>>7 days(1 week)</option>
									<option value="14 days(2 weeks)" <?php if ($proDuration == "14 days(2 weeks)") {
										echo "selected";
									} ?>>14 days(2 weeks)</option>
									<option value="21 days(3 weeks)" <?php if ($proDuration == "21 days(3 weeks)") {
										echo "selected";
									} ?>>21 days(3 weeks)</option>
									<option value="28 days(1 month)" <?php if ($proDuration == "28 days(1 month)") {
										echo "selected";
									} ?>>28 days(1 month)</option>
									<option value="60 days(2 months)" <?php if ($proDuration == "60 days(2 months)") {
										echo "selected";
									} ?>>60 days(2 months)</option>
									<option value="90 days(3 months)" <?php if ($proDuration == "90 days(3 months)") {
										echo "selected";
									} ?>>90 days(3 months)</option>
								</select>

								<label>Stipend for the Duration</label>
								<input type="text" class="half" placeholder="Amount" name="proEstimatedBudget"
									id="proEstimatedBudget"
									onKeyPress="return blockNonNumbers(this, event, true, false);"
									value="<?php echo $proEstimatedBudget; ?>">

								<select class="half" name="proCurrency" id="proCurrency">
									<option value="INR" <?php if ($proCurrency == "INR") {
										echo "selected";
									} ?>>INR
									</option>
									<option value="USD" <?php if ($proCurrency == "USD") {
										echo "selected";
									} ?>>USD
									</option>
								</select>
								<label>Description<span class="reqstar">*</span> <span>max 5000
										characters</span></label>
								<textarea
									name="projectDetails"><?php echo isset($projectDetails) ? $projectDetails : ''; ?></textarea>
								<label>Skills<span class="reqstar">*</span></label>
								<?php
								// Ensure the variable exists to avoid undefined variable warning
								if (!isset($proSkills)) {
									$proSkills = '';
								}
								?>
								<input type="hidden" name="proSkills" id="proSkills"
									value="<?php echo htmlspecialchars($proSkills ?? '', ENT_QUOTES, 'UTF-8'); ?>">

								<div id="skillsbox">
									<div style="
									position: absolute;
									top: 7px;
									right: 8px;
									font-size: 14px;
									padding: 4px 10px;
									background-color: #00a0af;
									color: #fff;
									border-radius: 4px; cursor:pointer;
								" onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=skillbox','Add Skill');">
										+ Add Skill</div>
									<div id="skilllist" style="overflow:hidden; min-height:30px;">
										<?php
										if (!empty($proSkills)) { // check if $proSkills is defined and not empty
											$string = ltrim($proSkills, ',');
											$string = preg_replace('/\.$/', '', $string); // Remove dot at end if exists
											$array = explode(',', $string); // split string into array separated by ', '
											foreach ($array as $value) { // loop over values
												$a = mt_rand(100000, 999999);
												?>
												<div class="skillb" id="sk<?php echo $a; ?>">
													<div id="dk<?php echo $a; ?>"><?php echo $value; ?></div>
													<span onClick="dltskill(<?php echo $a; ?>);"><i
															class="fa fa-times"></i></span>
												</div>
											<?php }
										}
										?>
									</div>

								</div>
								<style>
									#skillsbox {
										border: 1px solid #e7e7e7;
										border-radius: 4px;
										overflow: hidden;
										margin-bottom: 15px;
										margin-top: 5px;
										padding: 5px;
										position: relative;
										padding-right: 100px;
									}

									#skillsbox .skillb {
										padding: 5px;
										background-color: #e7e7e7;
										margin: 2px 5px 2px 2px;
										padding-right: 30px;
										position: relative;
										float: left;
										border-radius: 3px;
									}

									#skillsbox .skillb span {
										position: absolute;
										right: 0px;
										top: 0px;
									}
								</style>
								<script>

									function dltskill(id) {
										var name = $("#dk" + id).text();

										$("#sk" + id).remove();
										var proSkills = $("#proSkills").val();
										var name = ',' + name;

										proSkills = proSkills.replace(name, "");

										$("#proSkills").val(proSkills);
									}
								</script>
								<label>Nature of Internship duration</label>
								<select name="proNature" id="proNature">
									<option value="Part time" <?php if (!empty($proNature) && $proNature == "Part time") {
										echo "selected";
									} ?>>Part time</option>
									<option value="Full time" <?php if (!empty($proNature) && $proNature == "Full time") {
										echo "selected";
									} ?>>Full time</option>
									<option value="Flexible" <?php if (!empty($proNature) && $proNature == "Flexible") {
										echo "selected";
									} ?>>Flexible</option>
								</select>


								<?php if (empty($projId)) { ?>
									<label class="trms">
										<table width="100%;" border="0">
											<tr>
												<td width="19px" valign="top">
													<input type="checkbox" name="projectStatus" id="projectStatus" value="1"
														<?php if (!empty($projectStatus) && $projectStatus == "1") {
															echo "checked";
														} ?>>
												</td>
												<td>
													I confirm that this is a commercial internship. I am aware that I may
													receive a written warning for violating the General
													<a href="<?php echo !empty($fullurl) ? $fullurl : ''; ?>terms.html"
														target="_blank">Terms and
														Conditions</a>
													and that my internship may be deactivated.
												</td>
											</tr>
										</table>
									</label>
								<?php } ?>


								<div class="frm-fttr">
									<a
										href="<?php echo !empty($fullurl) ? $fullurl : ''; ?>manage-projects.html">Cancel</a>

									<input type="hidden" id="action" name="action"
										value="<?php echo !empty($action) ? $action : ''; ?>">
									<input type="hidden" id="saveprojId" name="saveprojId"
										value="<?php echo !empty($projId) ? $projId : ''; ?>">
									<input type="hidden" id="finalPost" name="finalPost"
										value="<?php echo !empty($finalPost) ? $finalPost : ''; ?>">

									<?php if (empty($finalPost) || $finalPost == 0) { ?>
										<button type="button" name="btnsubmit"
											onClick="formValidation('frmpostevnt');">Save</button>
									<?php } ?>


									<?php if (!empty($finalPost) && $finalPost == 1) { ?>
										<button type="button" name="btnsubmit"
											onClick="formValidation('frmpostevnt');">Update Internship</button>
									<?php } ?>

								</div>

							</form>
						</div>
					</div>
				</div>


			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>
	<script>
		$("#projectTitle").focus();

		function blockNonNumbers(obj, e, allowDecimal, allowNegative) {
			var key;
			var isCtrl = false;
			var keychar;
			var reg;
			if (window.event) {
				key = e.keyCode;
				isCtrl = window.event.ctrlKey

			}

			else if (e.which) {
				key = e.which;
				isCtrl = e.ctrlKey;
			}

			if (isNaN(key)) return true;
			keychar = String.fromCharCode(key);
			// check for backspace or delete, or if Ctrl was pressed
			if (key == 8 || isCtrl) {
				return true;
			}
			reg = /\d/;

			var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;
			var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;
			return isFirstN || isFirstD || reg.test(keychar);
		}
	</script>
</body>

</html>