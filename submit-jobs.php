<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
include('mail.php');
$pageIndex = 12;
$action = trim($_POST['action']);



$id = clean($_POST['id']);

//print_r($_POST);

$jobTitle = clean($_POST['jobTitle']);
$appliedType = trim($_POST['appliedType']);
$jobDetails = clean($_POST['jobDetails']);
$companyAddress = clean($_POST['companyAddress']);
$companyTypeId = clean($_POST['companyTypeId']);
$jobCatId = clean($_POST['jobCatId']);
$companyId = clean($_POST['companyId']);
$levelId = trim($_POST['levelId']);
$proSkills = clean($_POST['proSkills']);
$minAnnualSalary = trim($_POST['minAnnualSalary']);
$maxAnnualSalary = trim($_POST['maxAnnualSalary']);
$postalCode = clean($_POST['postalCode']);
$companyName = clean($_POST['companyName']);
$jobLocation = clean($_POST['jobLocation']);
$companyJobUrl = addslashes(trim($_POST['companyJobUrl']));
$status = normalclean($_POST['status']);
$jobStatus = trim($_POST['jobStatus']);
$jobKeywords = normalclean($_POST['jobKeywords']);


if ($jobTitle != '' && $companyTypeId != '' && $levelId != '' && $proSkills != '' && $minAnnualSalary != '' && $empnoId != '' && $status == 1 && $action == 'add') {


	$insertFields = [];
	$insertVals = [];
	$whereFields = [];
	$whereVals = [];


	$insertFields[0] = "jobTitle";
	$insertFields[1] = "companyTypeId";
	$insertFields[2] = "jobDetails";
	$insertFields[3] = "appliedType";
	$insertFields[4] = "dateAdded";
	$insertFields[5] = "companyId";
	$insertFields[6] = "jobCatId";
	$insertFields[7] = "levelId";
	$insertFields[8] = "proSkills";
	$insertFields[9] = "minAnnualSalary";
	$insertFields[10] = "maxAnnualSalary";
	$insertFields[11] = "postalCode";
	$insertFields[12] = "companyName";
	$insertFields[13] = "jobLocation";
	$insertFields[14] = "companyJobUrl";
	$insertFields[15] = "companyAddress";
	$insertFields[16] = "jobKeywords";
	$insertFields[17] = "userId";
	$insertFields[18] = "jobStatus";

	$insertVals[0] = $jobTitle;
	$insertVals[1] = $companyTypeId;
	$insertVals[2] = $jobDetails;
	$insertVals[3] = $appliedType;
	$insertVals[4] = date("Y-m-d H:i:s");
	$insertVals[5] = $companyId;
	$insertVals[6] = $jobCatId;
	$insertVals[7] = $levelId;
	$insertVals[8] = $proSkills;
	$insertVals[9] = $minAnnualSalary;
	$insertVals[10] = $maxAnnualSalary;
	$insertVals[11] = $postalCode;
	$insertVals[12] = $companyName;
	$insertVals[13] = $jobLocation;
	$insertVals[14] = $companyJobUrl;
	$insertVals[15] = $companyAddress;
	$insertVals[16] = $jobKeywords;
	$insertVals[17] = $_SESSION["sessUserId"];
	$insertVals[18] = $jobStatus;


	$resUpdate = insertDB(_BUSINESS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$_SESSION["s"] = 1;
	$_SESSION["post"] = 1;
	$postId = $resUpdate;
	$pageulr = makeContentUrl($jobTitle);

	$mailBodyContent = '';
	$mailBodyContent = $myname . ' created a SMB page <strong>' . $jobTitle . '</strong> - ' . date("H:i:s - d/m/Y") . '';

	$subject = $myname . ' (' . $myemail . ') created a SMB page';

	adminnotification($subject, $mailBodyContent);

	header('Location:' . $fullurl . _SMBURL_TEXT_ . '/' . encodeStr($postId) . '/' . $pageulr . '.html');
	exit();

}

if ($jobTitle != '' && $companyTypeId != '' && $levelId != '' && $proSkills != '' && $minAnnualSalary != '' && $companyId != '' && $action == 'edit') {


	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);


	$insertFields[0] = "jobTitle";
	$insertFields[1] = "companyTypeId";
	$insertFields[2] = "jobDetails";
	$insertFields[3] = "appliedType";
	$insertFields[4] = "modifyDate";
	$insertFields[5] = "companyId";
	$insertFields[6] = "jobCatId";
	$insertFields[7] = "levelId";
	$insertFields[8] = "proSkills";
	$insertFields[9] = "minAnnualSalary";
	$insertFields[10] = "maxAnnualSalary";
	$insertFields[11] = "postalCode";
	$insertFields[12] = "companyName";
	$insertFields[13] = "jobLocation";
	$insertFields[14] = "companyJobUrl";
	$insertFields[15] = "companyAddress";
	$insertFields[16] = "jobKeywords";
	$insertFields[17] = "jobStatus";

	$insertVals[0] = $jobTitle;
	$insertVals[1] = $companyTypeId;
	$insertVals[2] = $jobDetails;
	$insertVals[3] = $appliedType;
	$insertVals[4] = date("Y-m-d H:i:s");
	$insertVals[5] = $companyId;
	$insertVals[6] = $jobCatId;
	$insertVals[7] = $levelId;
	$insertVals[8] = $proSkills;
	$insertVals[9] = $minAnnualSalary;
	$insertVals[10] = $maxAnnualSalary;
	$insertVals[11] = $postalCode;
	$insertVals[12] = $companyName;
	$insertVals[13] = $jobLocation;
	$insertVals[14] = $companyJobUrl;
	$insertVals[15] = $companyAddress;
	$insertVals[16] = $jobKeywords;
	$insertVals[17] = $jobStatus;

	$whereFields[0] = "id";

	$whereVals[0] = $id;

	$resUpdate = updateDB(_BUSINESS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	$postId = $id;
	$_SESSION["s"] = 2;
	$_SESSION["post"] = 1;
	$pageulr = makeContentUrl($jobTitle);
	header('Location:' . $fullurl . _SMBURL_TEXT_ . '/' . encodeStr($postId) . '/' . $pageulr . '.html');
	exit();

}

$action = 'add';
$btnValue = 'Submit Job';
if ($_REQUEST['id'] != '') {
	$sqlDetails = "SELECT * from " . _BUSINESS_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['id']) . " ";
	$resDetails = mysqli_query($conn, $sqlDetails) or die(mysqli_error($conn));
	$rowDetails = mysqli_fetch_array($resDetails);

	if ($rowDetails['jobTitle'] == '') {
		header('Location:smb.html');
		exit();
	}

	$id = trim($rowDetails['id']);
	$createdby = $rowDetails["userId"];
	$jobTitle = stripslashes($rowDetails['jobTitle']);
	$companyTypeId = stripslashes($rowDetails['companyTypeId']);
	$jobCatId = stripslashes($rowDetails['jobCatId']);
	$appliedType = trim($rowDetails['appliedType']);
	$jobDetails = trim($rowDetails['jobDetails']);
	$companyId = trim($rowDetails['companyId']);
	$levelId = trim($rowDetails['levelId']);
	$proSkills = trim($rowDetails['proSkills']);
	$minAnnualSalary = trim($rowDetails['minAnnualSalary']);
	$myblocationName = trim($rowDetails['maxAnnualSalary']);
	$postalCode = trim($rowDetails['postalCode']);
	$companyName = trim($rowDetails['companyName']);
	$jobLocation = trim($rowDetails['jobLocation']);
	$companyJobUrl = trim($rowDetails['companyJobUrl']);

	$companyAddress = trim($rowDetails['companyAddress']);

	$jobKeywords = trim($rowDetails['jobKeywords']);
	$jobStatus = trim($rowDetails['jobStatus']);
	$action = 'edit';
	$btnValue = 'Update Job';

}


?>
<!DOCTYPE html>
<html>

<head>
	<title>Jobs - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
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
				<div
					class="center_content <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
					} else {
						echo 'nologin';
					} ?>">

					<div class="submit-job-cont">
						<h2>Create Job profile</h2>
						<form class="job-submit" name="frmJobs" id="frmJobs" method="post"
							enctype="multipart/form-data">
							<div class="form-grp">
								<label>Job Title<span class="reqstar">*</span></label>
								<input type="text" name="jobTitle" id="jobTitle" value="<?php echo $jobTitle; ?>"
									maxlength="150" class="validate">
							</div>

							<div class="form-grp fifty pd-right">
								<label>Job Category<span class="reqstar">*</span></label>
								<select name="jobCatId" id="jobCatId" onChange="hideerrordiv(this.id);"
									class="validate">
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
											if ($jobCatId == $rowOptions1['id']) {
												$strSelected = 'selected="selected"';
											} else {
												$strSelected = "";
											}
											?>
											<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>>
												<?php echo trim($rowOptions1['optionName']); ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
							<div class="form-grp fifty pd-left">
								<label>Career level<span class="reqstar">*</span></label>
								<select name="levelId" id="levelId" onChange="hideerrordiv(this.id);" class="validate">
									<option value="">Select career level</option>
									<?php
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];

									$sqlOptions1 = "";
									$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='careerlevel' ";
									$resOptions1 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
									if ($resOptions1) {
										while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
											if ($levelId == $rowOptions1['id']) {
												$strSelected = 'selected="selected"';
											} else {
												$strSelected = "";
											}
											?>
											<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>>
												<?php echo trim($rowOptions1['optionName']); ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>
							<div class="form-grp">
								<label>Job description<span class="reqstar">*</span></label>
								<textarea
									placeholder="Please enter a brief description of the position as well as the specific role and duties."
									rows="5" name="jobDetails" id="jobDetails"
									maxlength="5000"><?php echo $jobDetails; ?></textarea>
							</div>
							<div class="form-grp">
								<label>Required skills and experience<span class="reqstar">*</span></label>
								<input type="hidden" name="proSkills" id="proSkills" value="<?php echo $proSkills; ?>">
								<div id="skillsbox">
									<div style="
				   position: absolute;
				   top: 7px;
				   right: 8px;
				   font-size: 14px;
				   padding: 4px 10px;
				   background-color: #1a94c3;
				   color: #fff;
				   border-radius: 4px; cursor:pointer;
				" onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=skillbox','Add Skill');">
										+ Add Skill</div>
									<div id="skilllist" style="overflow:hidden; min-height:30px;">
										<?php
										if ($proSkills != '') {
											$string = ltrim($proSkills, ',');
											$string = preg_replace('/\.$/', '', $string); //Remove dot at end if exists
											$array = explode(',', $string); //split string into array seperated by ', '
											foreach ($array as $value) //loop over values
											{
												$a = mt_rand(100000, 999999);
												?>
												<div class="skillb" id="sk<?php echo $a; ?>">
													<div id="dk<?php echo $a; ?>"><?php echo $value; ?></div><span
														onClick="dltskill(<?php echo $a; ?>);"><i
															class="fa fa-times"></i></span>
												</div>
											<?php }
										} ?>
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
							</div>
							<div class="form-grp fifty pd-right">
								<label>Min. annual salary</label>
								<input type="number" name="minAnnualSalary" id="minAnnualSalary"
									value="<?php echo $minAnnualSalary; ?>" maxlength="20">
							</div>
							<div class="form-grp fifty pd-left">
								<label>Max. annual salary</label>
								<input type="number" name="maxAnnualSalary" id="maxAnnualSalary"
									value="<?php echo $maxAnnualSalary; ?>" maxlength="20">
							</div>
							<div class="employer-hdng">Employer</div>
							<div class="form-grp">
								<label>Company</label>
								<input type="text" name="companyName" id="companyName"
									value="<?php echo $companyName; ?>" maxlength="250" class="validate">
							</div>
							<div class="form-grp fifty pd-right">
								<label>Industry<span class="reqstar">*</span></label>
								<select name="companyTypeId" id="companyTypeId" onChange="hideerrordiv(this.id);"
									class="validate">
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
											if ($companyTypeId == $rowOptions1['id']) {
												$strSelected = 'selected="selected"';
											} else {
												$strSelected = "";
											}
											?>
											<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>>
												<?php echo trim($rowOptions1['optionName']); ?></option>
											<?php
										}
									}
									?>
								</select>
							</div>

							<div class="form-grp seventy pd-right">
								<label>Job location</label>
								<input type="text" name="jobLocation" id="jobLocation" value=" <?php
								$sqlOptions1 = "SELECT id,country_name FROM " . _COUNTRIES_TABLE_ . " ORDER BY country_name ";
								$resOptions1 = mysqli_query($conn, $sqlOptions1) or die(mysqli_error($conn));
								$rowOptions1 = mysqli_fetch_array($resOptions1);
								if ($countryId == $rowOptions1['id']) {
									echo trim($rowOptions1['country_name']);
								}

								$sqlOptions12 = "SELECT id,name FROM " . _STATE_MASTER_TABLE_ . " WHERE country_id='" . $countryId . "' ORDER BY name ";
								$resOptions12 = mysqli_query($conn, $sqlOptions12) or die(mysqli_error($conn));
								$rowOptions12 = mysqli_fetch_array($resOptions12);
								if ($statename == $rowOptions12['id']) {
									echo ', ' . trim($rowOptions12['name']);
								}

								if ($cityName != '') {
									echo ', ' . $cityName;
								}
								?>" class="validate" maxlength="250" onKeyUp="hideerrordiv(this.id);" />
							</div>
							<div class="form-grp thirty pd-left">
								<label>Postcode</label>
								<input type="text" name="postalCode" id="postalCode" value="<?php echo $postalCode; ?>"
									maxlength="6" class="validate"
									onKeyPress="return blockNonNumbers(this, event, true, false);">
							</div>
							<div class="form-grp">
								<label>Address<span class="reqstar">*</span></label>
								<textarea rows="3" name="companyAddress" id="companyAddress"
									maxlength="200"><?php echo $companyAddress; ?></textarea>
							</div>
							<div class="employer-hdng">How to apply<span class="reqstar">*</span></div>
							<div class="form-grp fifty pd-right">
								<select name="appliedType" id="appliedType"
									onChange="changedurationfun();hideerrordiv(this.id);">
									<option value="1" <?php if ($appliedType == '1') {
										echo 'selected';
									} ?>>Send to website
									</option>
									<option value="2" <?php if ($appliedType == '2') {
										echo 'selected';
									} ?>>By
										<?php echo $companNameTitle; ?> messaging</option>
								</select>
							</div>

							<div class="form-grp fifty pd-left" id="showfldsdiv"
								style="display:<?php if ($appliedType == '2') { ?>none<?php } else { ?>block<?php } ?>;">
								<input type="text" name="companyJobUrl" id="companyJobUrl"
									value="<?php echo $companyJobUrl; ?>"
									placeholder="Enter the link (URL) to your online form" maxlength="500">
							</div>
							<div class="employer-hdng">Help jobseekers find your job ad</div>
							<div class="form-grp">

								<textarea rows="3" placeholder="Which keywords should be assigned to this job ad?"
									name="jobKeywords" id="jobKeywords"
									maxlength="500"><?php echo $jobKeywords; ?></textarea>
							</div>
							<div class="trms tlnt">

								<label style="margin-top:0;margin-bottom: 0;">
									<input type="checkbox" name="jobStatus" id="jobStatus" class="validate" value="1"
										<?php if ($jobStatus == 1 || $jobStatus == '') {
											echo 'checked="checked"';
										} ?>>
									&nbsp;Active/Inactive
								</label>

								<?php if ($_REQUEST['id'] == '') { ?>
									<label style="margin-top:10px;">
										<input type="checkbox" name="status" id="status" class="validate" value="1"
											checked="checked" onClick="return false;">
										&nbsp;I confirm that I am authorized to create this Job and the information given is
										correct.
									</label>
								<?php } ?>


							</div>
							<div class="form-grp">
								<button class="submit" type="button" onClick="formValidation('frmJobs');"
									style="width:130px;"><?php echo $btnValue; ?></button>
							</div>
							<input type="hidden" id="action" name="action" value="<?php echo $action; ?>">
							<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
						</form>
					</div>


				</div>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>
	<script>
		function reloadPage() {
			location.reload(true);
		}

		function changedurationfun() {
			var appliedType = $("#appliedType").val();
			if (appliedType == '1') {
				$("#showfldsdiv").show();
			}
			else {
				$("#showfldsdiv").hide();
			}

		}
	</script>
</body>

</html>