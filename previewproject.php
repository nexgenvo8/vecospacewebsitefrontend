<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 11;
$ptab = 3;
if (isset($_POST['projPostId']) && $_REQUEST['projPostId'] != '') {
	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);

	$insertFields[0] = "finalPost";

	$insertVals[0] = 1;

	$whereFields[0] = "id";

	$whereVals[0] = decodeStr($_REQUEST["projPostId"]);

	$resUpdate = updateDB(_PROJECT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	header('Location:manage-projects.html');
	exit();

}


if ($_REQUEST['projId'] != '') {


	$aaView = "SELECT id,userId,projectViews from " . _PROJECT_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['projId']) . " ";
	$res5View = mysqli_query($conn, $aaView) or die(error_found(mysqli_error($conn)));
	$projectView = mysqli_fetch_array($res5View);

	if ($projectView['userId'] != $_SESSION["sessUserId"]) {

		unset($insertFields);
		unset($insertVals);
		unset($whereFields);
		unset($whereVals);

		$insertFields[0] = "projectViews";

		$insertVals[0] = $projectView['projectViews'] + 1;

		$whereFields[0] = "id";

		$whereVals[0] = decodeStr($_REQUEST["projId"]);

		$resUpdate = updateDB(_PROJECT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, ''); //Count project views
	}


	if ($projectView['id'] == '') {
		header("Location: " . $fullurl . "404error.html");
		exit();
	}


	$sqlProjects = "SELECT * from " . _PROJECT_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['projId']) . " ";
	$resProjects = mysqli_query($conn, $sqlProjects) or die(mysqli_error($conn));
	$rowProjects = mysqli_fetch_array($resProjects);

	if ($rowProjects['projectTitle'] == '') {
		header('Location:projects.html');
		exit();
	}

	$projId = trim($rowProjects['id']);
	$projectTitle = stripslashes($rowProjects['projectTitle']);
	$protIndusCategory = trim($rowProjects['protIndusCategory']);
	$proStartDate = trim($rowProjects['proStartDate']);
	$dateAdded = trim($rowProjects['dateAdded']);
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
	$projectViews = $rowProjects['projectViews'];
	$prouserid = $rowProjects["userId"];

	$friendnameurl = '';
	$userphoto = '';
	$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $prouserid . "";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$userres = mysqli_fetch_array($b);

	$friendnameurl = $userres['userurl'];

	if ($userres["profilePhoto"] != '') {
		$userphoto = $userres["profilePhoto"];
	} else {
		$userphoto = 'user-placeholder.jpg';
	}

	$aa = "SELECT id from " . _PROJECT_BOOKMARK_TABLE_ . " WHERE projectId= " . decodeStr($_REQUEST['projId']) . " and userId='" . $_SESSION["sessUserId"] . "' ";
	$res5 = mysqli_query($conn, $aa);
	$checkBookmark = mysqli_num_rows($res5);
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];
	$sqlBookmProject = "";
	$sqlBookmProject = "SELECT id FROM " . _PROJECT_BOOKMARK_TABLE_ . " WHERE projectId= " . decodeStr($_REQUEST['projId']);

	$resBookmProject = getRecords(_PROJECT_BOOKMARK_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlBookmProject);

	// Check if $resBookmProject is valid before counting rows
	if ($resBookmProject) {
		$totalBookmproject = mysqli_num_rows($resBookmProject);
	} else {
		$totalBookmproject = 0; // No rows found or query failed
	}



	$aap5 = "SELECT id from " . _PROJECT_INTRESTED_TABLE_ . " WHERE projectId= " . decodeStr($_REQUEST['projId']) . " and userId='" . $_SESSION["sessUserId"] . "' ";
	$res5p5 = mysqli_query($conn, $aap5);
	$interestedpro = mysqli_num_rows($res5p5);

}
$btnname = 'Preview';
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $projectTitle; ?> - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/default.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

	<meta property="og:title" content="<?php echo stripslashes($projectTitle); ?>" />
	<meta property="og:image" content="<?php echo $fullurl; ?>uploads/<?php echo $eventBgphoto; ?>" />
	<meta property="og:site_name" content="<?php echo $fullurl; ?>" />
	<meta property="og:description"
		content="<?php echo substr(stripslashes(strip_tags($projectDetails)), 0, 250); ?>" />
	<meta property="og:type" content="PROjects" />
	<meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />


	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>

	<script>
		function bookmarkfun(id) {
			$('#loadbookmarkdiv').load('<?php echo $fullurl; ?>common_action.php?action=bookmark&pid=' + id);
		}
	</script>
	<style type="text/css">
		ul.prjct-list li a.frlcr {
			color: #C02621;
			background-color: inherit;
		}

		ul.prjct-list li a.frlcr:hover {
			background-color: #e7e7e7;
		}

		ul.prjct-list li a.frlcr i.fa {
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
				<?php
				if ($proDuration == '1 day') {
					$first = '1';
					$last = 'day';
				}
				if ($proDuration == '2 days') {
					$first = '2';
					$last = 'days';
				}
				if ($proDuration == '3 days') {
					$first = '3';
					$last = 'days';
				}
				if ($proDuration == '7 days(1 week)') {
					$first = '1';
					$last = 'week';
				}
				if ($proDuration == '14 days(2 weeks)') {
					$first = '2';
					$last = 'weeks';
				}
				if ($proDuration == '21 days(3 weeks)') {
					$first = '3';
					$last = 'weeks';
				}
				if ($proDuration == '28 days(1 month)') {
					$first = '1';
					$last = 'month';
				}
				if ($proDuration == '60 days(2 months)') {
					$first = '2';
					$last = 'months';
				}
				if ($proDuration == '90 days(3 months)') {
					$first = '3';
					$last = 'months';
				}

				?>
				<div class="groups">
					<?php include('project_top.inc.php'); ?>
					<div class="create-projct prview">
						<div class="prview-projct">

							<div class="prview-main">
								<div class="prview-left"><?php if ($interestedpro > 0) { ?>
										<div class="aplied">
											<?php if (isset($_SESSION['smg8']) && $_SESSION["smg8"] == 1) {
												echo "You have successfully applied for this project.";
												$_SESSION["smg8"] = '';
											} else { ?>You
												are already applied for this project.<?php } ?>
										</div><?php } ?>
									<label class="nm"><?php echo $projectTitle; ?></label>
									<span class="dt">Posted: <?php echo date("d/m/Y", $dateAdded); ?></span>
									<ul class="prview-desc">
										<li class="one">
											<h1><?php echo $first; ?> <?php echo $last; ?></h1>
											<span>Duration</span>
										</li>
										<li class="two">
											<h1><?php echo date("d/m/Y", strtotime($proStartDate)); ?></h1>
											<span>Start date</span>
										</li>
										<li class="three">
											<h1><?php echo $proNature; ?></h1>
											<span>Working hours</span>
										</li>
									</ul>
									<?php if ($proEstimatedBudget != '') { ?>

										<div class="amount">
											<h1 class="prviw-heading" style="font-weight:normal;">Stipend</h1>
											<p style="font-size:30px;">
												<?php echo $proCurrency . ' ' . $proEstimatedBudget; ?>
											</p>
										</div>

									<?php }
									if ($proWorkLocation != '') { ?>
										<div class="prjct-loaction">
											<span>Work Location</span>
											<h1><a href="https://www.google.co.in/maps/place/<?php echo $proWorkLocation; ?>"
													target="_blank"><?php echo $proWorkLocation; ?></a></h1>
											<img src="<?php echo $fullurl; ?>images/map.png">
										</div>
									<?php } ?>
									<div class="prvw-desc-cont">
										<?php
										if ($proSkills != '') { ?>

											<h1 class="prviw-heading">Skills</h1>
											<ul class="skill-list">
												<?php
												if ($proSkills != '') {
													$string = ltrim($proSkills, ',');
													$string = preg_replace('/\.$/', '', $string); //Remove dot at end if exists
													$array = explode(',', $string); //split string into array seperated by ', '
													foreach ($array as $value) //loop over values
													{
														?>
														<li><?php echo $value; ?></li>
													<?php }
												} ?>
											</ul>
										<?php }
										if ($projectDetails != '') { ?>
											<h1 class="prviw-heading">Description</h1>
											<p class="desc-txt"><?php echo nl2br($projectDetails); ?></p>

										<?php } ?>
									</div>

									<?php

									$selectFields = [];
									$whereFields = [];
									$whereVals = [];

									$sqlProject = "SELECT * 
               FROM " . _PROJECT_USER_MASTER_TABLE_ . " 
               WHERE projectId = " . intval(decodeStr($_REQUEST['projId'])) . " 
                 AND contactId = " . intval($_SESSION["sessUserId"]) . " 
               ORDER BY dateAdded DESC";

									$resProject = mysqli_query($conn, $sqlProject);

									if ($resProject === false) {
										// Query failed — debug info
										die("Query Error: " . mysqli_error($conn) . " SQL: " . $sqlProject);
									}

									$totalAppliedProjects = mysqli_num_rows($resProject);

									if ($totalAppliedProjects > 0) {
										?>
										<div class="biding">
											<h3><?php echo $totalAppliedProjects;
											if ($totalAppliedProjects > 1) {
												$s = 's';
											} ?>
												freelancer<?php echo $s;
												if ($totalAppliedProjects > 1) {
													echo " have";
												} else {
													echo " has";
												} ?>
												applied for this project</h3>
											<ul class="biding-list">
												<?php

												while ($rowProject = mysqli_fetch_array($resProject)) {

													$friendnameurl2 = '';
													$userphoto2 = '';
													$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowProject["userId"] . "";
													$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
													$userres2 = mysqli_fetch_array($b);

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
																	<div class="ttl"><?php echo $rowProject['userSubject']; ?>
																	</div>
																	<?php echo nl2br($rowProject['projectdescription']); ?>
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

									<?php if (!isset($_POST['inpreview']) || $_REQUEST["inpreview"] != 1) { ?>
										<?php if ($rowProjects["userId"] != $_SESSION["sessUserId"]) { ?>
											<?php if ($interestedpro == 0) { ?>
												<a onClick="funcommonpopupwin('680px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo $_REQUEST['projId']; ?>&type=applyproject&uid=<?php echo encodeStr($prouserid); ?>','Apply now');"
													class="apply-btn"><i class="fa fa-check" aria-hidden="true"></i><span>Apply
														now</span></a>
											<?php } ?>
											<a class="apply-btn g <?php if ($checkBookmark > 0) { ?>bookmarked<?php } ?>"
												onClick="bookmarkfun('<?php echo $_REQUEST['projId']; ?>');"
												id="bookmarktextdivouter">
												<i class="fa fa-bookmark" aria-hidden="true"></i><i class="fa fa-star"
													aria-hidden="true"></i>
												<span id="bookmarktextdiv"><?php if ($checkBookmark > 0) { ?>Remove
														bookmark<?php } else { ?>Bookmark Internships<?php } ?></span></a>
										<?php } ?>
										<div id="loadbookmarkdiv" style="display:none;"></div>
										<?php if ($totalBookmproject > 0) { ?>
											<ul class="print-right">
												<li><i class="fa fa-eye" aria-hidden="true"></i>
													<?php if ($projectViews > 0) {
														echo '(' . $projectViews . ')';
													} ?></a>
												</li>
												<?php if ($totalBookmproject > 0) { ?>
													<li><i class="fa fa-bookmark" aria-hidden="true"></i>
														<?php echo '(' . $totalBookmproject . ')'; ?></a></li><?php } ?>
											</ul>
										<?php }
									} ?>
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
								<?php if ($rowProjects["userId"] == $_SESSION["sessUserId"]) { ?>
									<?php if (isset($_GET["inpreview"]) && $_GET["inpreview"] == 1) { ?>

										<div style="overflow:hidden; background-color:#fff;" class="continuebutton">
											<div class="frm-fttr">
												<a
													href="<?php echo $fullurl; ?>post-project.html?projId=<?php echo $_REQUEST['projId']; ?>">Edit</a>
												<form method="post">
													<input type="hidden" id="projPostId" name="projPostId"
														value="<?php echo $_REQUEST['projId']; ?>">
													<button type="submit" name="btnsubmit">Continue</button>
												</form>
											</div>
										</div>
									<?php }
								} ?>
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
	<script>
		<?php
		if ($_SESSION["s"] == 1) {
			?>
			showsusmsg('SUCCESS', 'Thank you for posting your Project on <?php echo $companNameTitle; ?>. We are reviewing the same and will come back to you shortly.', '');
			<?php
			$_SESSION["s"] = '';
		}

		if ($_SESSION["s"] == 2) {
			?>
			showsusmsg('SUCCESS', 'Project page updated successfully', '');
			<?php
			$_SESSION["s"] = '';
		}

		?>
	</script>
</body>

</html>