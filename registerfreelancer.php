<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 11;
$ptab = 3;
$action = "add";
//echo $_SERVER['HTTP_REFERER'];

if (isset($_POST['action']) && trim($_POST['action']) == 'edit') {



	$serviceOffered = trim($_POST['serviceOffered']);
	$professionalTitle = normalclean($_POST['professionalTitle']);
	$experienceLevel = normalclean($_POST['experienceLevel']);
	$professionalBrief = normalclean($_POST['professionalBrief']);
	$proSkills = trim($_POST['proSkills']);
	$freelancerStatus = trim($_POST['freelancerStatus']);
	$reghidden = trim($_POST['reghidden']);
}


if (
	isset($_POST['action']) && trim($_POST['action']) == 'edit' &&
	isset($serviceOffered) && $serviceOffered != 0 &&
	isset($proSkills) && $proSkills != '' &&
	isset($experienceLevel) && $experienceLevel != '' &&
	isset($professionalTitle) && $professionalTitle != '' &&
	isset($professionalBrief) && $professionalBrief != ''
) {


	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);

	$insertFields[0] = "serviceOffered";
	$insertFields[1] = "professionalTitle";
	$insertFields[2] = "experienceLevel";
	$insertFields[3] = "professionalBrief";
	$insertFields[4] = "jobSkills";
	$insertFields[5] = "freelancerStatus";
	if ($reghidden == 1) {
		$insertFields[6] = "freelancerRegDate";
	}

	$insertVals[0] = $serviceOffered;
	$insertVals[1] = $professionalTitle;
	$insertVals[2] = $experienceLevel;
	$insertVals[3] = $professionalBrief;
	$insertVals[4] = $proSkills;
	$insertVals[5] = $freelancerStatus;
	if ($reghidden == 1) {
		$insertVals[6] = time();
	}

	$whereFields[0] = "userId";

	$whereVals[0] = $_SESSION['sessUserId'];

	$resUpdate = updateDB(_USERS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	if ($reghidden == 1) {
		header('Location:register-freelancer.html?r=1');
	}
	if ($reghidden == 0) {
		header('Location:freelancer-profile.html?fid=' . encodeStr($_SESSION['sessUserId']));
	}

}

if ($_SESSION["sessUserId"] != '') {
	// Sanitize the user ID to prevent SQL injection
	$userId = intval($_SESSION["sessUserId"]);

	// MySQLi query
	$sqlFreelancer = "SELECT serviceOffered, jobSkills, experienceLevel, professionalTitle, professionalBrief, freelancerStatus 
                      FROM " . _USERS_MASTER_TABLE_ . " 
                      WHERE userId = $userId";

	$resFreelancer = mysqli_query($conn, $sqlFreelancer);

	if (!$resFreelancer) {
		die("MySQLi Error: " . mysqli_error($conn));
	}

	$rowFreelancer = mysqli_fetch_assoc($resFreelancer);

	$serviceOffered = trim($rowFreelancer['serviceOffered']);
	$proSkills = trim($rowFreelancer['jobSkills']);
	$experienceLevel = trim($rowFreelancer['experienceLevel']);
	$professionalTitle = trim($rowFreelancer['professionalTitle']);
	$professionalBrief = trim($rowFreelancer['professionalBrief']);
	$freelancerStatus = trim($rowFreelancer['freelancerStatus']);
	$action = "edit";
}

if ($serviceOffered == '0') {
	$freelancerStatus = 1;
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Register as a Project Seeker on <?php echo $companNameTitle; ?> - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/default.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<style type="text/css">
		ul.prjct-list li a.active {
			color: #C02621;
		}

		ul.prjct-list li a.active i.fa {
			background-color: #C02621;
		}

		ul.prjct-list li a.active:hover i.fa {
			background-color: #1280ab;
		}

		ul.prjct-list li a.active:hover {
			color: #1280ab;
		}
	</style>
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

						<?php if (isset($_GET["r"]) && $_GET["r"] > 0) { ?>

							<div class="wlcome" style="margin-bottom:30px;">
								<h2 style="margin-bottom:10px;">Congratulatios!</h2>
								<p style="text-align:center; font-size:14px;">Your Project Seeker account successfully
									created</p>
								<div style="margin:20px 0px; text-align:center;" class="freelancerbuttons">
									<a href="register-freelancer.html">Edit my Project Seeker profile</a>
									<a
										href="<?php echo $fullurl; ?>freelancer-profile.html?fid=<?php echo encodeStr($_SESSION["sessUserId"]); ?>">My
										Project Seeker profile page</a>
								</div>
							</div>
						<?php } else { ?>
							<div class="wlcome" style="margin-bottom:30px;">
								<?php if ($serviceOffered != 0) { ?>
									<h2 style="margin-bottom:10px;">Update Project Seeker profile</h2>
								<?php } else { ?>
									<h2 style="margin-bottom:10px;">Register as a Project Seeker on
										<?php echo $companNameTitle; ?>
									</h2>
									<p>At the outset, it will be great to know your expertise which will help us connect you
										with relevant projects and help you grow your business.</p>
								<?php } ?>
							</div>
							<div class="post-prjct">

								<form class="post-aprjct" name="frmFreelancer" id="frmFreelancer" method="post"
									enctype="multipart/form-data">
									<label>Your area of service offered<span class="reqstar">*</span></label>
									<select name="serviceOffered" id="serviceOffered" class="validate">
										<option value="0">Select</option>
										<?php
										unset($selectFields);
										unset($whereFields);
										unset($whereVals);

										// MySQLi query
										$sqlOptions = "SELECT id, optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='projectindustries'";

										$resOptions = mysqli_query($conn, $sqlOptions);

										if ($resOptions) {
											while ($rowOptions = mysqli_fetch_assoc($resOptions)) {
												$strSelected = ($serviceOffered == $rowOptions['id']) ? 'selected="selected"' : "";
												?>
												<option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected; ?>>
													<?php echo trim($rowOptions['optionName']); ?>
												</option>
												<?php
											}
										} else {
											echo "<option value=''>Error loading options</option>";
											// For debugging:
											// echo mysqli_error($conn);
										}
										?>
									</select>

									<label>Your core skill sets are<span> (you can add upto 5 skill sets)</span><span
											class="reqstar">*</span></label>
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
													if ($value != '') {
														?>
														<div class="skillb" id="sk<?php echo $a; ?>">
															<div id="dk<?php echo $a; ?>"><?php echo $value; ?></div><span
																onClick="dltskill(<?php echo $a; ?>);"><i
																	class="fa fa-times"></i></span>
														</div>
													<?php }
												}
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

											if (proSkills == '') {
												$("#skillsbox").addClass('redborderfield');
												$("#proSkills").addClass('validate');
											}
											else {
												$("#skillsbox").removeClass('redborderfield');
												$("#proSkills").removeClass('validate');
											}

										}
									</script>
									<label>Work experience level<span class="reqstar">*</span></label>
									<select name="experienceLevel" id="experienceLevel" class="validate">
										<option value="">Please select</option>
										<option value="Entry level" <?php if ($experienceLevel == "Entry level") {
											echo "selected";
										} ?>>Entry level</option>
										<option value="Intermediary" <?php if ($experienceLevel == "Intermediary") {
											echo "selected";
										} ?>>Intermediary</option>
										<option value="Expert" <?php if ($experienceLevel == "Expert") {
											echo "selected";
										} ?>>
											Expert</option>
									</select>
									<label>Professional title that best describes your work<span
											class="reqstar">*</span></label>
									<input type="text" name="professionalTitle" id="professionalTitle"
										value="<?php echo $professionalTitle; ?>" maxlength="200" class="validate">
									<label>Brief professional overview <span>(maximum 5000 characters)</span><span
											class="reqstar">*</span></label>
									<textarea rows="8" name="professionalBrief" id="professionalBrief" maxlength="5000"
										class="validate"><?php echo $professionalBrief; ?></textarea>

									<label>Project Seeker profile status</label>
									<select name="freelancerStatus" id="freelancerStatus">
										<option value="1" <?php if ($freelancerStatus == "1") {
											echo "selected";
										} ?>>Active
										</option>
										<option value="0" <?php if ($freelancerStatus == "0") {
											echo "selected";
										} ?>>Inactive
										</option>
									</select>
									<div class="frm-fttr">
										<a href="<?php echo $fullurl; ?>freelancers.html">Cancel</a>
										<input type="hidden" id="action" name="action" value="<?php echo $action; ?>">

										<input type="hidden" id="reghidden" name="reghidden" value="<?php if ($serviceOffered == 0) {
											echo '1';
										} else {
											echo '0';
										} ?>">
										<!--onClick="formValidation('sendmsg');" --><!--$('#frmFreelancer').submit();-->
										<button type="button" name="btnsubmit"
											onClick="formValidation('frmFreelancer');"><?php if ($serviceOffered == 0) { ?>Submit<?php } else { ?>Save<?php } ?></button>
									</div>
								</form>
							</div>
						<?php } ?>
					</div>
				</div>


			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>
	<script>
		$("#serviceOffered").focus();
	</script>
</body>

</html>