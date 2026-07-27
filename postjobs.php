<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
include('mail.php');
$pageIndex = 14;

$action = 'add';
$btnValue = 'Submit Job';
if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
	$sqlDetails = "SELECT * from " . _JOBS_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['id']) . " ";
	$resDetails = mysqli_query($conn, $sqlDetails) or die(mysqli_error($conn));
	$rowDetails = mysqli_fetch_array($resDetails);
	$createdby = $rowDetails["userId"];
	if ($createdby != $_SESSION["sessUserId"]) {
		header('Location:jobs.html');
		exit();
	}
	if ($rowDetails['jobTitle'] == '') {
		header('Location:jobs.html');
		exit();
	}

	$id = trim($rowDetails['id']);

	$careerJobTitle = stripslashes($rowDetails['jobTitle']);
	$companyTypeId = stripslashes($rowDetails['companyTypeId']);
	$jobCatId = stripslashes($rowDetails['jobCatId']);
	$appliedType = trim($rowDetails['appliedType']);
	$jobDetails = trim($rowDetails['jobDetails']);
	$companyId = encodeStr($rowDetails['companyId']);
	$levelId = trim($rowDetails['levelId']);
	$proSkills = trim($rowDetails['proSkills']);
	$minAnnualSalary = trim($rowDetails['minAnnualSalary']);
	$maxAnnualSalary = trim($rowDetails['maxAnnualSalary']);
	$postalCode = trim($rowDetails['postalCode']);
	$companyName = trim($rowDetails['companyName']);
	$jobLocation = trim($rowDetails['jobLocation']);
	$companyJobUrl = trim($rowDetails['companyJobUrl']);
	$jobConsultant = trim($rowDetails['jobConsultant']);

	$companyAddress = trim($rowDetails['companyAddress']);

	$jobKeywords = trim($rowDetails['jobKeywords']);
	$jobStatus = trim($rowDetails['jobStatus']);

	$fulljoblocation = $jobLocation;

	$action = 'edit';
	$btnValue = 'Update Job';

} else {

    if(isset($_GET['type']) && $_GET['type'] == 'market'){
        
        // Market job ke liye default values
        $companyId = 0;
        $companyTypeId = '';
        $companyAddress = '';
        $postalCode = '';
        $companyName = '';
        $fulljoblocation = '';

    } else {

        $sqlDetails = "SELECT * from " . _COMPANY_MASTER_TABLE_ . " WHERE id= " . decodeStr($_GET['companyId']) . " ";
        $resDetails = mysqli_query($conn, $sqlDetails) or die(mysqli_error($conn));
        $companyInfo = mysqli_fetch_array($resDetails);

        $companyId = $_GET['companyId'];
        $companyTypeId = $companyInfo["companyTypeId"] ?? '';

        $empcountry_name = '';
        $empstate_name = '';

        if ($companyInfo["countryId"] != 0 && $companyInfo["countryId"] != '') {
            $atac = "select * from " . _COUNTRIES_TABLE_ . " where id= " . $companyInfo["countryId"];
            $ptac = mysqli_query($conn, $atac) or die(mysqli_error($conn));
            $rowcmpdetails = mysqli_fetch_array($ptac);
            $empcountry_name = $rowcmpdetails['country_name'] ?? '';
        }

        if ($companyInfo["stateId"] != 0 && $companyInfo["stateId"] != '') {
            $atac = "select * from " . _STATE_MASTER_TABLE_ . " where id= " . $companyInfo["stateId"];
            $ptac = mysqli_query($conn, $atac) or die(mysqli_error($conn));
            $rowcmpdetails = mysqli_fetch_array($ptac);
            $empstate_name = $rowcmpdetails['name'] ?? '';
        }

        $fulljoblocation = $empcountry_name . ', ' . $empstate_name;
        $companyAddress = trim($companyInfo['companyAddress'] ?? '');
        $postalCode = trim($companyInfo['postalCode'] ?? '');
        $companyName = trim($companyInfo['companyName'] ?? '');
    }
}


if (isset($_POST['jobTitle']) && $_POST['jobTitle'] != '') {
	$action = trim($_POST['action']);
	$id = clean($_POST['editId']);

	//print_r($_POST);

	$careerJobTitle = clean($_POST['jobTitle']);
	$appliedType = trim($_POST['appliedType']);
	$jobDetails = addslashes($_POST['jobDetails']);
	$companyAddress = clean($_POST['companyAddress']);
	$companyTypeId = clean($_POST['companyTypeId']);
	$jobCatId = clean($_POST['jobCatId']);
	$companyId = decodeStr($_POST['postId']);
	$levelId = trim($_POST['levelId']);
	$proSkills = clean($_POST['proSkills']);
	$minAnnualSalary = trim($_POST['minAnnualSalary']);
	$maxAnnualSalary = trim($_POST['maxAnnualSalary']);
	$postalCode = clean($_POST['postalCode']);
	$companyName = clean($_POST['companyName']);
	$jobLocation = clean($_POST['jobLocation']);

	$status = normalclean($_POST['status']);
$jobStatus = isset($_POST['jobStatus']) ? trim($_POST['jobStatus']) : 0;
$jobConsultant = isset($_POST['jobConsultant']) ? trim($_POST['jobConsultant']) : 0;
	$jobKeywords = normalclean($_POST['jobKeywords']);
	$fulljoblocation = $jobLocation;
	if ($appliedType == 1) {
		$companyJobUrl = addslashes(trim($_POST['companyJobUrl']));
	} else {
		$companyJobUrl = '';
	}

	$tc = 0;

if(isset($_GET['type']) && $_GET['type'] == 'market'){
    // Market job ke liye company check skip
    $tc = 1;
}else{

    $sqlcmp = "SELECT id from " . _COMPANY_MASTER_TABLE_ . " 
               WHERE id= " . $companyId . " 
               and userId='" . $_SESSION["sessUserId"] . "'";

    $rescmp = mysqli_query($conn, $sqlcmp);

    while ($getCompany = mysqli_fetch_array($rescmp)) {
        $tc++;
    }
}

	if ($tc == 0) {
		header("Location: " . $fullurl . "jobs.html");
		exit();
	}

	if ($tc > 0) {

		if ($careerJobTitle != '' && $companyTypeId != '' && $levelId != '' && $proSkills != '' && $status == 1 && $action == 'add') {


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
			$insertFields[19] = "jobConsultant";

			$insertVals[0] = $careerJobTitle;
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
			$insertVals[19] = $jobConsultant;


			$resUpdate = insertDB(_JOBS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

			$_SESSION["s"] = 1;
			$_SESSION["post"] = 1;
			$postId = $resUpdate;
			$pageulr = makeContentUrl($careerJobTitle);

			$mailBodyContent = '';
			$mailBodyContent = $myname . ' created a Job <strong>' . $careerJobTitle . '</strong> - ' . date("H:i:s - d/m/Y") . '';

			$subject = $myname . ' (' . $myemail . ') created a Job';

			//adminnotification($subject,$mailBodyContent);

			//header('Location:'.$fullurl._SMBURL_TEXT_.'/'.encodeStr($postId).'/'.$pageulr.'.html');
			if(isset($_GET['type']) && $_GET['type'] == 'market'){
				header('Location:' . $fullurl . 'jobs.html');
			}else{
				header('Location:' . $fullurl . 'company-jobs.html?companyId=' . encodeStr($companyId));
			}
			exit();
			exit();

		} elseif ($jobTitle != '' && $companyTypeId != '' && $levelId != '' && $proSkills != '' && $action == 'edit') {


			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);


			$insertFields[0] = "jobTitle";
			$insertFields[1] = "companyTypeId";
			$insertFields[2] = "jobDetails";
			$insertFields[3] = "appliedType";
			$insertFields[4] = "modifyDate";
			$insertFields[5] = "jobStatus";
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
			$insertFields[17] = "jobConsultant";

			$insertVals[0] = $careerJobTitle;
			$insertVals[1] = $companyTypeId;
			$insertVals[2] = $jobDetails;
			$insertVals[3] = $appliedType;
			$insertVals[4] = date("Y-m-d H:i:s");
			$insertVals[5] = $jobStatus;
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
			$insertVals[17] = $jobConsultant;

			$whereFields[0] = "id";

			$whereVals[0] = $id;

			$resUpdate = updateDB(_JOBS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
			$postId = $id;
			$_SESSION["s"] = 2;
			$_SESSION["post"] = 1;

			if(isset($_GET['type']) && $_GET['type'] == 'market'){
    header('Location:' . $fullurl . 'jobs.html');
}else{
    header('Location:' . $fullurl . 'company-jobs.html?companyId=' . encodeStr($companyId));
}
exit();
			exit();

		}
	}

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
				<div class="center_content <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
				} else {
					echo 'nologin';
				} ?>">

					<div class="submit-job-cont">
						<h2>Create Job profile</h2>
						<form class="job-submit" name="frmJobs" id="frmJobs" method="post"
							enctype="multipart/form-data">
							<?php
							if (!isset($careerJobTitle)) {
								$careerJobTitle = "";
							}
							?>

							<div class="form-grp">
								<label>Job Title<span class="reqstar">*</span></label>
								<input type="text" name="jobTitle" id="jobTitle" value="<?php echo $careerJobTitle; ?>"
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
												<?php echo trim($rowOptions1['optionName']); ?>
											</option>
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
												<?php echo trim($rowOptions1['optionName']); ?>
											</option>
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
									rows="5" name="jobDetails" id="jobDetails" maxlength="5000"
									class="validate"><?php echo isset($jobDetails) ? $jobDetails : ''; ?></textarea>

							</div>
							<div class="form-grp">
								<label>Required skills and experience<span class="reqstar">*</span></label>
								<?php
								// Ensure $proSkills exists
								if (!isset($proSkills)) {
									$proSkills = "";
								}
								?>

								<input type="hidden" name="proSkills" id="proSkills" value="<?php echo $proSkills; ?>">


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

							<?php
							// Ensure $jobConsultant exists
							if (!isset($jobConsultant)) {
								$jobConsultant = 0;
							}
							?>
							<div class="form-grp">
								<input type="checkbox" name="jobConsultant" id="jobConsultant" value="1"
									style="width:14px !important;" <?php if ($jobConsultant == 1) {
										echo "checked";
									} ?>>
								&nbsp;This job by consultant
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
												<?php echo trim($rowOptions1['optionName']); ?>
											</option>
											<?php
										}
									}
									?>
								</select>
							</div>

							<div class="form-grp seventy pd-right">
								<label>Job location</label>
								<input type="text" name="jobLocation" id="jobLocation"
									value="<?php echo $fulljoblocation; ?>" class="validate" maxlength="250"
									onKeyUp="hideerrordiv(this.id);" />
							</div>
							<div class="form-grp thirty pd-left">
								<label>Postcode</label>
								<input type="text" name="postalCode" id="postalCode" value="<?php echo $postalCode; ?>"
									maxlength="6" class="validate"
									onKeyPress="return blockNonNumbers(this, event, true, false);">
							</div>
							<div class="form-grp">
								<label>Address<span class="reqstar">*</span></label>
								<textarea rows="3" name="companyAddress" id="companyAddress" maxlength="200"
									class="validate"><?php echo $companyAddress; ?></textarea>
							</div>
							<?php
							// Ensure variables exist
							if (!isset($appliedType)) {
								$appliedType = "";
							}
							if (!isset($companNameTitle)) {
								$companNameTitle = "";
							}
							?>
							<div class="employer-hdng">How to apply<span class="reqstar">*</span></div>
							<div class="form-grp fifty pd-right">
								<select name="appliedType" id="appliedType"
									onChange="changedurationfun();hideerrordiv(this.id);" class="validate">
									<option value="1" <?php echo ($appliedType == '1') ? 'selected' : ''; ?>>Send to
										Website</option>
									<option value="2" <?php echo ($appliedType == '2') ? 'selected' : ''; ?>>By
										<?php echo $companNameTitle; ?> Messaging
									</option>
								</select>
							</div>
							<?php
							// Ensure $companyJobUrl and $appliedType exist
							if (!isset($companyJobUrl)) {
								$companyJobUrl = "";
							}
							if (!isset($appliedType)) {
								$appliedType = "";
							}
							?>
							<div class="form-grp fifty pd-left" id="showfldsdiv"
								style="display:<?php echo ($appliedType == '2') ? 'none' : 'block'; ?>;">
								<input type="text" name="companyJobUrl" id="companyJobUrl"
									value="<?php echo $companyJobUrl; ?>"
									placeholder="Enter the link (URL) to your online form" maxlength="500">
							</div>

							<div class="employer-hdng">Help jobseekers find your job ad</div>
							<?php
							// Ensure $jobKeywords exists
							if (!isset($jobKeywords)) {
								$jobKeywords = "";
							}
							?>
							<div class="form-grp">
								<textarea rows="3" placeholder="Which keywords should be assigned to this job ad?"
									name="jobKeywords" id="jobKeywords"
									maxlength="500"><?php echo $jobKeywords; ?></textarea>
							</div>

							<?php
							// Ensure variables exist
							if (!isset($jobStatus)) {
								$jobStatus = 0;
							}
							if (!isset($_REQUEST['id'])) {
								$_REQUEST['id'] = '';
							}
							if (!isset($companNameTitle)) {
								$companNameTitle = '';
							}
							?>
							<div class="trms tlnt">
								<label style="margin-top:0;margin-bottom: 0;">
									<input type="checkbox" name="jobStatus" id="jobStatus" class="validate" value="1"
										readonly="readonly" <?php echo ($jobStatus == 1) ? 'checked="checked"' : ''; ?>>
									&nbsp;Display job ad on the <?php echo $companNameTitle; ?> Jobs
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
								<?php if ($_REQUEST['id'] != '' && $createdby == $_SESSION["sessUserId"]) { ?>
									<a onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo $_REQUEST["id"]; ?>','deljob');"
										style="float: left;color: #ea4335;margin-top: 16px;text-decoration: underline;">Delete
										this job</a>
								<?php } ?>
								<button class="submit" type="button" onClick="formValidation('frmJobs');"
									style="width:130px;"><?php echo $btnValue; ?></button>
							</div>
							<input type="hidden" id="action" name="action" value="<?php echo $action; ?>">
							<input type="hidden" id="editId" name="editId" value="<?php echo $id; ?>">
							<input type="hidden" id="postId" name="postId" value="<?php echo $companyId; ?>">
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