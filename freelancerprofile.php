<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 11;
$ptab = 3;


if ($_REQUEST['fid'] != '') {

	$sqlFreelancer = "SELECT userId,serviceOffered,jobSkills,experienceLevel,professionalTitle,professionalBrief,freelancerStatus,userurl,firstName,lastName,profilePhoto from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . decodeStr($_REQUEST['fid']) . " ";
	$resFreelancer = mysqli_query($conn, $sqlFreelancer) or die(mysqli_error($conn));
	$rowFreelancer = mysqli_fetch_array($resFreelancer);

	$serviceOffered = trim($rowFreelancer['serviceOffered']);
	$proSkills = trim($rowFreelancer['jobSkills']);
	$experienceLevel = trim($rowFreelancer['experienceLevel']);
	$professionalTitle = trim($rowFreelancer['professionalTitle']);
	$professionalBrief = trim($rowFreelancer['professionalBrief']);
	$freelancerStatus = trim($rowFreelancer['freelancerStatus']);

	$freelancerurl = $rowFreelancer['userurl'];
	$frlcfirstName = $rowFreelancer['firstName'];
	$frlclastName = $rowFreelancer['lastName'];

	if ($rowFreelancer["profilePhoto"] != '') {
		$freelancerphoto = $rowFreelancer["profilePhoto"];
	} else {
		$freelancerphoto = 'user-placeholder.jpg';
	}

}
$checkFrelnce = "SELECT userId from " . _USERS_MASTER_TABLE_ . " WHERE serviceOffered!=0 and userId='" . $_SESSION["sessUserId"] . "' ";
$rescheckFrelnce = mysqli_query($conn, $checkFrelnce);
$totalcheckFrelnce = mysqli_num_rows($rescheckFrelnce);
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $professionalTitle; ?> - <?php echo $companNameTitle; ?></title>
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
			color: #FF0000;
		}

		ul.prjct-list li a.active i.fa {
			background-color: #FF0000;
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

					<div class="frlncer">
						<div class="hding">
							<h2>Freelancers</h2>
							<?php if ($totalcheckFrelnce > 0) { ?>
								<a class="rgstr-btn" href="<?php echo $fullurl; ?>register-freelancer.html">Edit my Project
									Seeker profile</a>
							<?php } else { ?>
								<a href="<?php echo $fullurl; ?>register-freelancer.html" class="rgstr-btn">Register as a
									Project Seeker</a>
							<?php } ?>
						</div>
						<div class="frlncr-prfl">
							<div class="frlncr-img">
								<img src="<?php echo $fullurl; ?>uploads/<?php echo $freelancerphoto; ?>">
							</div>
							<div class="frlncr-dtail">
								<div class="frlncr-nm">
									<a><?php echo $frlcfirstName . ' ' . $frlclastName; ?></a>
									<?php if (decodeStr($_REQUEST['fid']) != $_SESSION["sessUserId"]) { ?>
										<a onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=sendmsgtocontact&id=<?php echo $_REQUEST['fid']; ?>','Send a Message');"
											class="rgstr-btn">Send message</a>
									<?php } ?>
								</div>
								<div class="offerd-sec">
									<span class="ttl">Service Offered</span>
									<h3>
										<?php
										$whereFields = [];
										$selectFields = []; // Empty because we are passing raw SQL
										$whereVals = [];
										$sqlOptions1 = "SELECT optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='projectindustries' and id='" . $serviceOffered . "' ";

										$resOptions1 = getRecords(_OPTION_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);

										// ✅ Safe check to avoid mysqli_num_rows() on bool (false)
										if ($resOptions1 && mysqli_num_rows($resOptions1) > 0) {
											while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
												echo trim($rowOptions1['optionName']);
											}
										} else {
											// Optional fallback if no record or query failed
											// echo "N/A";
										}
										?>
									</h3>
								</div>

								<div class="frlncr-tagline">
									<?php echo $professionalTitle; ?>
								</div>
								<div class="offerd-sec">
									<span class="ttl">Skills</span>
									<ul class="skill-list">
										<?php
										if ($proSkills != '') {
											$string = ltrim($proSkills, ',');
											$string = preg_replace('/\.$/', '', $string); //Remove dot at end if exists
											$array = explode(',', $string); //split string into array seperated by ', '
											foreach ($array as $value) //loop over values
											{
												if ($value != '') { ?>
													<li><?php echo trim($value); ?></li>
												<?php }
											}
										} ?>
									</ul>
								</div>
								<div class="offerd-sec">
									<span class="ttl">Work Experience</span>
									<h3><?php echo $experienceLevel; ?></h3>
								</div>

								<div class="brief-about">
									<span class="ttl">Brief Professonal overview</span>
									<p><?php echo nl2br($professionalBrief); ?></p>
								</div>
							</div>
						</div>
						<div class="ftrd-frlncrs">
							Featured Project Seeker
						</div>
						<ul class="frlncer-list">
							<?php
							$sqlFreelancer = "SELECT userId,serviceOffered,jobSkills,experienceLevel,professionalTitle,professionalBrief,freelancerStatus,userurl,firstName,lastName,profilePhoto from " . _USERS_MASTER_TABLE_ . " WHERE freelancerStatus=1 and userId!=" . $_SESSION["sessUserId"] . " and userId!= " . decodeStr($_REQUEST['fid']) . " ORDER BY rand() LIMIT 0,3  ";
							$resFreelancer = mysqli_query($conn, $sqlFreelancer) or die(mysqli_error($conn));
							$totaRows = mysqli_num_rows($resFreelancer);

							if ($totaRows > 0) {
								while ($getResults = mysqli_fetch_array($resFreelancer)) {
									?>
									<li>
										<div class="frlncr_box">
											<div class="frlncr-hd">
												<div class="img"><img
														src="<?php echo $fullurl; ?>uploads/<?php echo $getResults["profilePhoto"]; ?>">
												</div>
												<div class="nm">
													<a
														href="<?php echo $fullurl; ?>freelancer-profile.html?fid=<?php echo encodeStr($getResults['userId']); ?>"><?php echo $getResults['firstName']; ?>
														<?php echo $getResults['lastName']; ?></a>
												</div>
											</div>
											<div class="srvc-offer">
												<span>Service offered</span>
												<h3>
													<?php
													$whereFields = [];
													$selectFields = []; // Empty because we are passing raw SQL
													$whereVals = [];
													$sqlOptions1 = "SELECT optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='projectindustries' and id='" . $getResults["serviceOffered"] . "' ";

													$resOptions1 = getRecords(_OPTION_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);

													// ✅ Prevent fatal error if query failed
													if ($resOptions1 && mysqli_num_rows($resOptions1) > 0) {
														while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
															echo trim($rowOptions1['optionName']);
														}
													} else {
														// optional: show nothing or fallback text
														// echo "N/A";
													}
													?>
												</h3>
											</div>

											<div class="srvc-offer">
												<span>Work Experience</span>
												<h3><?php echo $getResults['experienceLevel']; ?></h3>
											</div>
											<a href="<?php echo $fullurl; ?>freelancer-profile.html?fid=<?php echo encodeStr($getResults['userId']); ?>"
												class="full-dtail"> <i class="fa fa-eye"></i> View Full Profile</a>
										</div>
									</li>
									<?php
								}
							}
							?>
						</ul>
					</div>
				</div>


			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>

</body>

</html>