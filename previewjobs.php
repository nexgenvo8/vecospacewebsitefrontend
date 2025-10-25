<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 8;
$ptab = 3;

if ($_REQUEST['id'] != '') {

	$sqlDetails = "SELECT * FROM " . _JOBS_MASTER_TABLE_ . " 
               WHERE id = " . intval(decodeStr($_REQUEST['id']));

	$resDetails = mysqli_query($conn, $sqlDetails);

	if (!$resDetails) {
		die("MySQLi Error: " . mysqli_error($conn));
	}

	$rowDetails = mysqli_fetch_assoc($resDetails);

	if ($rowDetails['jobTitle'] == '') {
		header('Location:company-jobs.html');
		exit();
	}
	$createdby = $rowDetails["userId"];
	if ($createdby != $_SESSION["sessUserId"]) {
		unset($insertFields);
		unset($insertVals);
		unset($whereFields);
		unset($whereVals);

		$insertFields[0] = "viewStatus";
		$insertVals[0] = $rowDetails['viewStatus'] + 1;
		$whereFields[0] = "id";
		$whereVals[0] = decodeStr($_REQUEST['id']);

		$resUpdate = updateDB(_JOBS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	}
	$friendnameurl = '';
	$userphoto = '';

	$a = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = " . intval($createdby);
	$b = mysqli_query($conn, $a);

	if (!$b) {
		die("MySQLi Error: " . mysqli_error($conn));
	}

	$userres = mysqli_fetch_assoc($b);

	$friendnameurl = $userres['userurl'];

	if ($userres["profilePhoto"] != '') {
		$userphoto = $userres["profilePhoto"];
	} else {
		$userphoto = 'user-placeholder.jpg';
	}

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE id=" . intval($rowDetails["jobCatId"]);
	$resOptions1 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
	if ($resOptions1) {
		while ($rowOptions1 = mysqli_fetch_assoc($resOptions1)) {
			$jobCategoryname = trim($rowOptions1['optionName']);
			$jobCategoryId = trim($rowOptions1['id']);
		}
	}

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE id=" . intval($rowDetails["jobCatId"]);
	$resOptions1 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);

	if ($resOptions1) {
		while ($rowOptions1 = mysqli_fetch_assoc($resOptions1)) {
			$jobLevelname = trim($rowOptions1['optionName']);
			$jobLevelId = trim($rowOptions1['id']);
		}
	}
}

$aap5 = "SELECT id FROM " . _JOB_INTRESTED_TABLE_ . " 
         WHERE jobId=" . intval(decodeStr($_REQUEST['id'])) . " 
         AND userId='" . intval($_SESSION["sessUserId"]) . "'";

$res5p5 = mysqli_query($conn, $aap5);

if (!$res5p5) {
	die("MySQLi Error: " . mysqli_error($conn));
}

$interestedpro = mysqli_num_rows($res5p5);
?>



<!DOCTYPE html>
<html>

<head>
	<title><?php echo $rowDetails['jobTitle']; ?> - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/default.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">


	<meta property="og:title" content="<?php echo stripslashes($rowDetails['jobTitle']); ?>" />
	<meta property="og:image" content="<?php echo $fullurl; ?>images/alumni-alumni-logo.png" />
	<meta property="og:site_name" content="<?php echo $fullurl; ?>" />
	<meta property="og:description"
		content="<?php echo substr(stripslashes(strip_tags($rowDetails['jobDetails'])), 0, 250); ?>" />
	<meta property="og:type" content="Jobs" />
	<meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />


	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>

</head>

<body>
	<div id="wrapper" class="active">
		<?php include('header.php'); ?>
		<div class="container main">

			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content">
					<div class="jobdtail-cont">
						<div class="prview-left">
							<div style="margin-bottom:10px; font-size:12px; text-transform:uppercase;"><a
									href="<?php echo $fullurl; ?>jobs.html">Jobs</a>&nbsp; -&nbsp; <a
									href="<?php echo $fullurl; ?>search-job.html?industry=<?php echo $jobCategoryId; ?>"><?php echo $jobCategoryname; ?></a>&nbsp;
								-&nbsp; <a
									href="<?php echo $fullurl; ?>search-job.html?careerlevel=<?php echo $jobLevelId; ?>"><?php echo $jobLevelname; ?></a>
							</div>
							<?php if ($createdby == $_SESSION["sessUserId"]) { ?>
								<div style="margin-bottom:10px;">This job is posted by you <a
										href="<?php echo $fullurl; ?>add-job.html?id=<?php echo $_REQUEST["id"]; ?>"
										class="edit-btn-job">Edit Job</a></div><?php } ?>
							<?php if ($interestedpro > 0) { ?>
								<div class="aplied">
									<?php if ($_SESSION["smg8"] == 1) {
										echo "You have successfully applied for this job.";
										$_SESSION["smg8"] = '';
									} else { ?>You
										are already applied for this job.<?php } ?>
								</div><?php } ?>
							<label class="nm"><?php echo stripslashes($rowDetails['jobTitle']); ?></label>
							<span class="dt">Posted: <?php echo date("m/d/Y", (strtotime($rowDetails["dateAdded"]))); ?>
								&nbsp; - &nbsp; Views: <?php echo $rowDetails["viewStatus"]; ?> </span>


							<div class="sallery">
								<h3>Skills</h3>
								<ul class="skill-list">
									<?php if ($rowDetails["proSkills"] != '') {
										$string = ltrim($rowDetails["proSkills"], ',');
										$string = preg_replace('/\.$/', '', $string); //Remove dot at end if exists
										$array = explode(',', $string); //split string into array seperated by ', '
										foreach ($array as $value) //loop over values
										{ ?>
											<li><?php echo $value; ?></li>
										<?php }
									} ?>
								</ul>
								<h3>Description</h3>
								<p class="job-description"><?php echo nl2br(stripslashes($rowDetails['jobDetails'])); ?>
								</p>

							</div>
							<div class="employr">
								<h2>Employer Detail</h2>
								<ul class="employr-dtaillist">
									<li>
										<label>Company: </label>
										<span><?php echo nl2br(stripslashes($rowDetails['companyName'])); ?></span>
									</li>

									<li>
										<label>Industry: </label>
										<span>
											<?php
											$sqlDetails = "SELECT id, optionName 
                       FROM " . _OPTION_MASTER_TABLE_ . " 
                       WHERE id = " . intval($rowDetails['companyTypeId']);

											$resDetails = mysqli_query($conn, $sqlDetails);

											if (!$resDetails) {
												die("MySQLi Error: " . mysqli_error($conn));
											}

											$companyInfo = mysqli_fetch_assoc($resDetails);

											if ($companyInfo) {
												echo htmlspecialchars($companyInfo["optionName"]);
											}
											?>
										</span>
									</li>


									<li>
										<label>Job Location: </label>
										<span><?php echo stripslashes($rowDetails['jobLocation']); ?></span>
									</li>

									<li>
										<label>Postal Code: </label>
										<span><?php echo stripslashes($rowDetails['postalCode']); ?></span>
									</li>

									<li>
										<label>Address: </label>
										<span><?php echo stripslashes($rowDetails['companyAddress']); ?> &nbsp;&nbsp;
											<a href="https://www.google.co.in/maps/place/<?php echo stripslashes($rowDetails['companyAddress']); ?>"
												target="_blank" class="openingooglemap"> <i class="fa fa-map-marker"
													aria-hidden="true"></i> Open in Google Maps</a></span>
									</li>
								</ul>
							</div>
							<?php

							unset($selectFields);
							unset($whereFields);
							unset($whereVals);

							$sqlProject = "SELECT * 
							FROM " . _JOB_USER_TABLE_ . " 
							WHERE jobId = " . intval(decodeStr($_REQUEST['id'])) . " 
							AND contactId = " . intval($_SESSION["sessUserId"]) . " 
							ORDER BY dateAdded DESC";

							$resProject = mysqli_query($conn, $sqlProject);

							if (!$resProject) {
								die("MySQLi Error: " . mysqli_error($conn));
							}

							$totalAppliedProjects = mysqli_num_rows($resProject);
							if ($totalAppliedProjects > 0) {
								?>
								<div class="biding">
									<h3><?php echo $totalAppliedProjects;
									if ($totalAppliedProjects > 1) {
										$s = 's';
									} ?>
										user<?php echo $s;
										if ($totalAppliedProjects > 1) {
											echo " have";
										} else {
											echo " has";
										} ?>
										applied for this job</h3>
									<ul class="biding-list">
										<?php

										while ($rowProject = mysqli_fetch_array($resProject)) {

											$friendnameurl2 = '';
											$userphoto2 = '';
											$a = "SELECT * 
											FROM " . _USERS_MASTER_TABLE_ . " 
											WHERE userId = " . intval($rowProject["userId"]);

											$b = mysqli_query($conn, $a);

											if (!$b) {
												die("MySQLi Error: " . mysqli_error($conn));
											}

											$userres2 = mysqli_fetch_assoc($b);


											$friendnameurl2 = $userres2['userurl'];

											if ($userres2["profilePhoto"] != '') {
												$userphoto2 = $userres2["profilePhoto"];
											} else {
												$userphoto2 = 'user-placeholder.jpg';
											}
											?>

											<li>
												<div class="hedr">
													<div class="prfl_img"> <a
															href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2['userId']); ?>/<?php echo $friendnameurl2; ?>.html"
															target="_blank"><img
																src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto2)); ?>"></a>
													</div>
													<div class="hdr_right"><a
															href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2['userId']); ?>/<?php echo $friendnameurl2; ?>.html"
															target="_blank"><?php echo $userres2['firstName']; ?>
															<?php echo $userres2['lastName']; ?></a><span> </span>
														<label class="time"><?php echo $userres2['jobTitle']; ?> at
															<?php echo $userres2['companyName']; ?></label>

														<div class="descrp" id="desc<?php echo $rowProject['id']; ?>"
															style="position:relative; padding-bottom:30px; height:140px;">
															<div class="ttl"><?php echo $rowProject['userSubject']; ?></div>
															<?php echo nl2br($rowProject['jobDescription']); ?>
														</div>
														<a style=" margin-top:10px; float:right; font-size:12px;"
															id="readtext<?php echo $rowProject['id']; ?>"
															onClick="showmoreless('<?php echo $rowProject['id']; ?>');">Read
															More</a>
													</div>
													<div class="bid-date">
														<label><?php echo date("d/m/Y", $rowProject['dateAdded']); ?></label>
														<span><?php echo $userres2['cityName']; ?>,
															<?php echo $userres2['countryName']; ?></span>
													</div>
												</div>

											</li>
											<?php

										}
										?>
									</ul>
								</div>
								<script>
									function showmoreless(id) {
										var text = $('#readtext' + id).text();
										if (text == 'Read More') {
											$('#desc' + id).css('height', 'auto');
											$('#readtext' + id).text('Less');
										}
										else {
											$('#desc' + id).css('height', '140px');
											$('#readtext' + id).text('Read More');
										}
									}
								</script>
							<?php } ?>
						</div>
						<div class="prview-right">
							<ul class="catogry-job">
								<li>
									<label>Job Category</label>
									<span><?php echo $jobCategoryname; ?></span>
								</li>
								<li>
									<label>Career Level</label>
									<span><?php echo $jobLevelname; ?></span>
								</li>
								<li>
									<label>Salary</label>
									<span>
										<?php
										echo is_numeric($rowDetails["minAnnualSalary"]) ? number_format((float) $rowDetails["minAnnualSalary"], 2) : "0.00";
										?> -
										<?php
										echo is_numeric($rowDetails["maxAnnualSalary"]) ? number_format((float) $rowDetails["maxAnnualSalary"], 2) : "0.00";
										?>
									</span>
								</li>

							</ul>
							<?php if ($interestedpro < 1) { ?>
								<?php if ($createdby != $_SESSION["sessUserId"]) {
									if ($rowDetails["appliedType"] == 1) {
										if ($rowDetails["companyJobUrl"] != '') { ?>

											<a href="http://www.<?php echo str_replace("http://", "", str_replace("https://", "", str_replace("www.", "", $rowDetails["companyJobUrl"]))); ?>"
												target="_blank" class="apply-btn"><span>Apply</span></a>
										<?php }
									} else { ?>
										<a onClick="funcommonpopupwin('680px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo $_REQUEST['id']; ?>&type=applyjob','Apply Job');"
											class="apply-btn"><span>Apply</span></a>
									<?php }
								} ?>
							<?php } ?>
							<div class="tstmnl-profile">
								<span class="ownr-nm">Posted By</span>
								<div class="img"><img
										src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>">
								</div>
								<div class="right"><a
										href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo $userres['firstName']; ?>
										<?php echo $userres['lastName']; ?></a>
									<label><?php echo $userres['jobTitle']; ?> at
										<?php echo $userres['companyName']; ?></label>
								</div>
							</div>
						</div>
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

	</script>

</body>

</html>