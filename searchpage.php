<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$keyword = clean($_REQUEST['keywordsearch']);
//$keyword=preg_replace('!\s+!', '', trim($keyword));//added new line
?>
<?php
/*photos*/

if ($keyword != '') {
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];
	$sqlSearch = "";
	$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
	$userId = isset($_SESSION['sessUserId']) ? intval($_SESSION['sessUserId']) : 0;
	$sqlSearch = "select id from " . _IMAGE_MASTER_TABLE_ . " where  postId IN(select id from " . _SHAREANDUPDATES_TABLE_ . " where articleBlogStatus=0 and userId IN(select userId from " . _USERS_MASTER_TABLE_ . "  where (firstName like '%" . $keyword . "%' OR lastName like '%" . $keyword . "%') and userId!=" . $_SESSION['sessUserId'] . " ) ) ";
	$resSearch = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlSearch);
	$totalRow8 = mysqli_num_rows($resSearch);

	if ($totalRow8 == '') {
		$totalRow8 = 0;
	}


	/*users*/
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];
	$sqlSearch = "";

	$sqlSearch = "select userId from " . _USERS_MASTER_TABLE_ . " where userId IN (SELECT userId from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE allowSearchEngines=1) and (firstName like '%" . $keyword . "%' OR lastName like '%" . $keyword . "%') and userId!=" . $_SESSION['sessUserId'] . " and activeYN='Y' and userId!=106 and companyName!='' LIMIT 0,50";
	$resSearch = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlSearch);
	$totalRow1 = mysqli_num_rows($resSearch);

	if ($totalRow1 == '') {
		$totalRow1 = 0;
	}


	/*groups*/

	$sqlGroup = "";
	$sqlGroup = "select id from " . _GROUP_MASTER_TABLE_ . " WHERE userId IN (SELECT userId from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE postGroupSearchEngine=1) and (groupName like '%" . $keyword . "%') and  groupType=0 and status=0 and userGroupStatus=1  LIMIT 0,50";
	$resGroup = getRecords(_GROUP_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroup);
	$totalRow2 = mysqli_num_rows($resGroup);

	if ($totalRow2 == '') {
		$totalRow2 = 0;
	}

	/*Companies*/

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];
	$sqlCompany = "";
	$sqlCompany = "select id from " . _COMPANY_MASTER_TABLE_ . " where (companyName like '%" . $keyword . "%' OR companyTypeId IN(SELECT id from " . _OPTION_MASTER_TABLE_ . " WHERE optionName like '%" . $keyword . "%' ))  and status=0 order by id desc LIMIT 0,50 ";
	$resCompany = getRecords(_COMPANY_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
	$totalRow3 = mysqli_num_rows($resCompany);

	if ($totalRow3 == '') {
		$totalRow3 = 0;
	}

	/*Companies*/

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$articlephoto = '';
	$sqlLatestArticle = "";
	$sqlLatestArticle = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId IN (SELECT userId from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE postGroupSearchEngine=1) and (postTitle like '%" . $keyword . "%')  and postType=3 and articleBlogStatus=0 ORDER BY postTitle LIMIT 0,50 ";
	$resLatestArticle = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLatestArticle);
	$totalRow4 = mysqli_num_rows($resLatestArticle);

	if ($totalRow4 == '') {
		$totalRow4 = 0;
	}

	/*Events*/

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlFeaturedEvents = "";
	$sqlFeaturedEvents = "select id from " . _EVENT_MASTER_TABLE_ . " where (eventName like '%" . $keyword . "%') order by id desc LIMIT 0,50 ";
	$resFeaturedEvents = getRecords(_EVENT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlFeaturedEvents);
	$totalRow5 = mysqli_num_rows($resFeaturedEvents);

	if ($totalRow5 == '') {
		$totalRow5 = 0;
	}

	/*Projects*/

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlProjects = "";
	$sqlProjects = "SELECT id from " . _PROJECT_MASTER_TABLE_ . " WHERE (projectTitle like '%" . $keyword . "%' OR proCity like '%" . $keyword . "%' OR proCountry like '%" . $keyword . "%' OR proNature like '%" . $keyword . "%' OR proSkills like '%" . $keyword . "%') ORDER BY projectTitle LIMIT 0,50 ";
	$resProjects = getRecords(_PROJECT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlProjects);
	$totalRow9 = mysqli_num_rows($resProjects);

	if ($totalRow9 == '') {
		$totalRow9 = 0;
	}

	/*SME Connect*/

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlSmb = "";
	$sqlSmb = "SELECT id from " . _BUSINESS_MASTER_TABLE_ . " WHERE (companyBusinessName like '%" . $keyword . "%' OR cityName like '%" . $keyword . "%' OR completeAddress like '%" . $keyword . "%' OR contactPerson like '%" . $keyword . "%' OR postalCode like '%" . $keyword . "%') ORDER BY companyBusinessName LIMIT 0,50 ";
	$resSmb = getRecords(_BUSINESS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlSmb);
	$totalRow12 = mysqli_num_rows($resSmb);

	if ($totalRow12 == '') {
		$totalRow12 = 0;
	}

	/*Talent Connect*/

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlTalent = "";
	$sqlTalent = "SELECT id from " . _TALENT_MASTER_TABLE_ . " WHERE (talentName like '%" . $keyword . "%' OR shortDescription like '%" . $keyword . "%' OR longDescription like '%" . $keyword . "%') ORDER BY talentName LIMIT 0,50 ";
	$resTalent = getRecords(_TALENT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlTalent);
	$totalRow13 = mysqli_num_rows($resTalent);

	if ($totalRow13 == '') {
		$totalRow13 = 0;
	}

	/*Jobs*/

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlJobs = "";
	$sqlJobs = "SELECT id from " . _JOBS_MASTER_TABLE_ . " WHERE status=1 and jobStatus=1 and (jobTitle like '%" . $keyword . "%' OR jobLocation like '%" . $keyword . "%' OR companyName like '%" . $keyword . "%' OR companyAddress like '%" . $keyword . "%' OR jobKeywords like '%" . $keyword . "%') ORDER BY jobTitle LIMIT 0,50 ";
	$resJobs = getRecords(_TALENT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlJobs);
	$totalRow14 = mysqli_num_rows($resJobs);

	if ($totalRow14 == '') {
		$totalRow14 = 0;
	}




	$selectFields = [];
	$whereFields = [];
	$whereVals = [];
	$totalPosts = 0;
	$sqlPosts = "";
	$sqlPosts = "select id,postId from " . _TIMELINE_MASTER_TABLE_ . " where postId IN (select id from " . _SHAREANDUPDATES_TABLE_ . " where (postTitle like '%" . $keyword . "%' OR postText like '%" . $keyword . "%')  and articleBlogStatus=0) and userId='" . $_SESSION['sessUserId'] . "' and postId!=0 OR (userId IN(SELECT contactId FROM " . _CONTACT_MASTER_TABLE_
		. " WHERE  userId='" . $_SESSION['sessUserId'] . "' and status=1 and shareType=2)) order by dateAdded desc limit 0,50";
	$resPosts = getRecords(_TIMELINE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlPosts);
	while ($rowp = mysqli_fetch_array($resPosts)) {
		if ($rowp["postId"] != '' && $rowp["postId"] != 0) {
			$totalPosts++;
		}
	}


}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Search results for <?php echo $keyword; ?> - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<?php if (($_REQUEST['type'] ?? '') == 7) { ?>
		<script src="<?php echo $fullurl; ?>js/jquery.min-imgslider.js"></script>

		<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/TechcareGallery.css">
		<script src="<?php echo $fullurl; ?>js/TechcareGallery.js"></script>
	<?php } ?>
	<style type="text/css">
		ul.cntr_tab li a {
			padding: 10px 10px;
		}

		@media only screen and (min-width: 800px) {
			.left_menu_sec {
				width: 60px;
				float: left;
				overflow: inherit;
			}
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
				<div class="center_content">
					<div class="artcle">
						<div class="cntr_cntnt" style="width:100%">
							<div style="padding:15px; font-size:16px; font-weight:bold;">Search results for &ldquo;<span
									style="font-size:15px;font-weight: normal;"><?php echo $keyword; ?></span>&rdquo;
							</div>

							<ul class="cntr_tab horizontal" style="border-top: solid 1px #e7e7e7;font-size: 13px;">
								<?php $totalRow1 = $totalRow1 ?? 0; // Use existing value or 0 if undefined
								
								if ($totalRow1 > 0) { ?>
									<?php
									$type = $_REQUEST['type'] ?? '';

									?>
									<li>
										<a href="<?php echo $fullurl; ?>search.html?keywordsearch=<?php echo $keyword; ?>&type=1"
											<?php if ($type == 1 || $type == '') { ?>class="active" <?php } ?>>
											Contacts(<?php echo $totalRow1; ?>)
										</a>
									</li>

								<?php }
								$totalRow1 = $totalRow1 ?? 0;
								$totalRow2 = $totalRow2 ?? 0;
								$totalRow3 = $totalRow3 ?? 0; // do the same for other totals if used
								$totalRow4 = $totalRow4 ?? 0; // do the same for other totals if used
								$totalRow5 = $totalRow5 ?? 0; // do the same for other totals if used
								$totalRow9 = $totalRow9 ?? 0; // do the same for other totals if used
								$totalRow12 = $totalRow12 ?? 0; // do the same for other totals if used
								$totalRow13 = $totalRow13 ?? 0; // do the same for other totals if used
								$totalRow14 = $totalRow14 ?? 0; // do the same for other totals if used
								$totalPosts = $totalPosts ?? 0; // do the same for other totals if used
								
								if ($totalRow2 > 0) { ?>
									<li><a href="<?php echo $fullurl; ?>search.html?keywordsearch=<?php echo $keyword; ?>&type=2"
											<?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 2) { ?>class="active"
											<?php } ?>>Groups(<?php echo $totalRow2; ?>)</a></li>
								<?php }
								if ($totalRow3 > 0) { ?>
									<li><a href="<?php echo $fullurl; ?>search.html?keywordsearch=<?php echo $keyword; ?>&type=3"
											<?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 3) { ?>class="active"
											<?php } ?>>Companies(<?php echo $totalRow3; ?>)</a></li>
								<?php }
								if ($totalRow4 > 0) { ?>
									<li><a href="<?php echo $fullurl; ?>search.html?keywordsearch=<?php echo $keyword; ?>&type=4"
											<?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 4) { ?>class="active"
											<?php } ?>>Articles and
											Trivia(<?php echo $totalRow4; ?>)</a></li>
								<?php }
								if ($totalRow5 > 0) { ?>
									<li><a href="<?php echo $fullurl; ?>search.html?keywordsearch=<?php echo $keyword; ?>&type=5"
											<?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 5) { ?>class="active"
											<?php } ?>>Events(<?php echo $totalRow5; ?>)</a></li>
								<?php }
								if ($totalRow9 > 0) { ?>
									<li><a href="<?php echo $fullurl; ?>search.html?keywordsearch=<?php echo $keyword; ?>&type=9"
											<?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 9) { ?>class="active"
											<?php } ?>>Projects(<?php echo $totalRow9; ?>)</a></li>
								<?php }
								if ($totalRow12 > 0) { ?>
									<li><a href="<?php echo $fullurl; ?>search.html?keywordsearch=<?php echo $keyword; ?>&type=12"
											<?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 12) { ?>class="active"
											<?php } ?>>SME
											Connect(<?php echo $totalRow12; ?>)</a></li>
								<?php }
								if ($totalRow13 > 0) { ?>
									<li><a href="<?php echo $fullurl; ?>search.html?keywordsearch=<?php echo $keyword; ?>&type=13"
											<?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 13) { ?>class="active"
											<?php } ?>>Talent
											Connect(<?php echo $totalRow13; ?>)</a></li>
								<?php }
								if ($totalRow14 > 0) { ?>
									<li><a href="<?php echo $fullurl; ?>search.html?keywordsearch=<?php echo $keyword; ?>&type=14"
											<?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 14) { ?>class="active"
											<?php } ?>>Jobs(<?php echo $totalRow14; ?>)</a></li>
								<?php }
								if ($totalPosts > 0) { ?>
									<li><a href="<?php echo $fullurl; ?>search.html?keywordsearch=<?php echo $keyword; ?>&type=6"
											<?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 6) { ?>class="active"
											<?php } ?>>Posts(<span
												id="totalRow6xxxxxxxx"><?php echo $totalPosts; ?></span>)</a></li>
								<?php }
								if ($totalRow1 > 0 && $totalRow8 > 0) { ?>
									<li id="photoid"><a
											href="<?php echo $fullurl; ?>search.html?keywordsearch=<?php echo $keyword; ?>&type=7"
											<?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 7) { ?>class="active"
											<?php } ?>>Photos(<?php echo $totalRow8; ?>)</a></li><?php } ?>


							</ul>
							<?php
							$srch = 0;
							if ($keyword != '') { ?>
								<div style="padding:10px; clear:both;">
									<?php if (isset($_REQUEST['type']) && $_REQUEST['type'] == 1 || $_REQUEST['type'] == '') { ?>
										<?php

										$selectFields = [];
										$whereFields = [];
										$whereVals = [];
										$sqlSearch = "";

										$sqlSearch = "select * from " . _USERS_MASTER_TABLE_ . " where userId IN (SELECT userId from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE allowSearchEngines=1) and (firstName like '%" . $keyword . "%' OR lastName like '%" . $keyword . "%') and userId!=" . $_SESSION['sessUserId'] . " and activeYN='Y' and userId!=106 and companyName!='' LIMIT 0,50";
										$resSearch = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlSearch);
										if ($resSearch) {
											$s = 1;
											$srch = 1;
											while ($rowSearch = mysqli_fetch_array($resSearch)) {

												$friendnameurl = $rowSearch['userurl'];
												if ($rowSearch["profilePhoto"] != '') {
													$userphoto = $rowSearch["profilePhoto"];
												} else {
													$userphoto = 'user-placeholder.jpg';
												}

												?>
												<div class="topsearchlist"
													onClick="location.href='<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowSearch['userId']); ?>/<?php echo $friendnameurl; ?>.html';">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td width="1%">
																<div
																	style="width:35px;    border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
																	<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"
																		width="100%">
																</div>
															</td>
															<td width="99%">
																<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
																	<?php echo $rowSearch['firstName']; ?>
																	<?php echo $rowSearch['lastName']; ?>
																</div>
																<div style="font-size:12px; color:#9a9a9a;">
																	<?php echo $rowSearch["jobTitle"]; ?> at
																	<?php echo $rowSearch["companyName"]; ?>
																</div>
															</td>
														</tr>
													</table>

												</div>
												<?php
											}
										}

										if ($totalRow1 == 0) {
											?>
											<div style="padding-top:78px; text-align:center;">No result found.</div>
											<?php
										}
									}
									if ($_REQUEST['type'] == 2) { ?>
										<?php

										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$sqlGroup = "";
										$sqlGroup = "select * from " . _GROUP_MASTER_TABLE_ . " WHERE userId IN (SELECT userId from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE postGroupSearchEngine=1) and (groupName like '%" . $keyword . "%') and  groupType=0 and status=0 and userGroupStatus=1  LIMIT 0,50";
										$resGroup = getRecords(_GROUP_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroup);
										if ($resGroup) {
											$s = 1;
											$srch = 1;
											$mytotalgroups = mysqli_num_rows($resGroup);
											?>
											<?php

											while ($rowgroup = mysqli_fetch_array($resGroup)) {

												$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $rowgroup["id"] . "";
												$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
												$row = mysqli_fetch_array($resgroup);

												if ($row["groupThumb"] != '') {
													$groupThumb = $row["groupThumb"];
												} else {
													$groupThumb = 'group.png';
												}

												$totalgroupmembers = 0;
												$sqlGroupTotal = "";
												$sqlGroupTotal = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " where groupId='" . $row["id"] . "' and status=1 ";
												$resGroupTotal = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupTotal);
												if ($resGroupTotal) {
													$totalgroupmembers = mysqli_num_rows($resGroupTotal);
												}

												?>
												<div class="topsearchlist"
													onClick="location.href='<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($rowgroup['id']); ?>';">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td width="1%">
																<div
																	style="width:35px;    border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
																	<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>"
																		width="100%">
																</div>
															</td>
															<td width="99%">
																<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
																	<?php echo stripslashes(trim($row["groupName"])); ?>
																</div>
																<div style="font-size:12px; color:#9a9a9a;">Members
																	(<?php echo $totalgroupmembers; ?>)</div>
															</td>
														</tr>
													</table>

												</div>
												<?php

											}
										}

										if ($totalRow2 == 0) {
											?>
											<div style="padding-top:78px; text-align:center;">No result found.</div>
											<?php
										}
									} ?>

									<?php if ($_REQUEST['type'] == 3) {


										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$sqlCompany = "";
										$sqlCompany = "select * from " . _COMPANY_MASTER_TABLE_ . " where (companyName like '%" . $keyword . "%' OR companyTypeId IN(SELECT id from " . _OPTION_MASTER_TABLE_ . " WHERE optionName like '%" . $keyword . "%' ))  and status=0 order by id desc LIMIT 0,50 ";
										$resCompany = getRecords(_COMPANY_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
										if ($resCompany) {
											$s = 1;
											$srch = 1;
											?>
											<?php
											while ($rowCompany = mysqli_fetch_array($resCompany)) {
												$companyPhoto = '';
												$companyTypeName = '';
												if ($rowCompany["companyTypeId"] != 0 && $rowCompany["companyTypeId"] != '') {
													$a = "SELECT * from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $rowCompany["companyTypeId"] . "";
													$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
													$rowCompanyTypeName = mysqli_fetch_array($b);
													$companyTypeName = $rowCompanyTypeName["optionName"];
												}

												if ($rowCompany['id'] != 0 && $rowCompany['id'] != '') {
													$ap = "select imageName from " . _IMAGE_MASTER_TABLE_ . " where  postId= " . $rowCompany['id'] . " and imageType=8 ";
													$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
													$rowLogoImg = mysqli_fetch_array($bp);

													if ($rowLogoImg["imageName"] != '') {
														$companyPhoto = $rowLogoImg["imageName"];
													} else {
														$companyPhoto = 'company.png';
													}

												}


												?>
												<div class="topsearchlist"
													onClick="location.href='<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo encodeStr($rowCompany['id']); ?>';">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td width="1%">
																<div
																	style="width:35px;    border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
																	<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>"
																		title="<?php echo stripslashes($rowCompany["companyName"]); ?>"
																		width="100%">
																</div>
															</td>
															<td width="99%">
																<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
																	<?php echo substr(stripslashes($rowCompany["companyName"]), 0, 100); ?>
																</div>
																<div style="font-size:12px; color:#9a9a9a;">
																	<?php echo stripslashes($companyTypeName); ?>
																</div>
															</td>
														</tr>
													</table>

												</div>
												<?php

											}
										}
										if ($totalRow3 == 0) {
											?>
											<div style="padding-top:78px; text-align:center;">No result found.</div>
											<?php
										}
									} ?>

									<?php if ($_REQUEST['type'] == 4) {
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$articlephoto = '';
										$sqlLatestArticle = "";
										$sqlLatestArticle = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId IN (SELECT userId from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE postGroupSearchEngine=1) and  (postTitle like '%" . $keyword . "%')  and postType=3 and articleBlogStatus=0 ORDER BY postTitle LIMIT 0,50 ";
										$resLatestArticle = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLatestArticle);
										if ($resLatestArticle) {
											$s = 1;
											$srch = 1;
											?>
											<?php
											while ($rowLatestArticle = mysqli_fetch_array($resLatestArticle)) {


												$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLatestArticle["userId"] . "";
												$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
												$userres = mysqli_fetch_array($b);

												$aimg = "select * from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $rowLatestArticle['id'] . " and imageType=3";
												$bimg = mysqli_query($conn, $aimg) or die(mysqli_error($conn));
												$rowimg = mysqli_fetch_array($bimg);

												if ($rowimg['imageName'] != '') {
													$articlephoto = $rowimg['imageName'];
												} else {
													$articlephoto = 'articleicon.png';
												}




												?>
												<div class="topsearchlist"
													onClick="location.href='<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowLatestArticle['id']); ?>';">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td width="1%">
																<div
																	style="width:35px;    border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
																	<img src="<?php echo $fullurl; ?>uploads/<?php echo $articlephoto; ?>"
																		title="<?php echo stripslashes($rowLatestArticle["postTitle"]); ?>"
																		width="100%" style="min-height:100%;">
																</div>
															</td>
															<td width="99%">
																<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
																	<?php echo substr(strip_tags(stripslashes(trim($rowLatestArticle["postTitle"]))), 0, 100); ?>
																</div>
																<div style="font-size:12px; color:#9a9a9a;">By
																	<?php echo stripslashes(trim($userres["firstName"])); ?>
																	<?php echo stripslashes(trim($userres["lastName"])); ?>
																</div>
															</td>
														</tr>
													</table>

												</div>
												<?php

											}
										}
										if ($totalRow4 == 0) {
											?>
											<div style="padding-top:78px; text-align:center;">No result found.</div>
											<?php
										}
									} ?>

									<?php if ($_REQUEST['type'] == 5) {
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$sqlFeaturedEvents = "";
										$sqlFeaturedEvents = "select * from " . _EVENT_MASTER_TABLE_ . " where (eventName like '%" . $keyword . "%') order by id desc LIMIT 0,50 ";
										$resFeaturedEvents = getRecords(_EVENT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlFeaturedEvents);
										if ($resFeaturedEvents) {
											$s = 1;
											$srch = 1;
											?>
											<div class="topsearchheader">Events</div>
											<?php
											while ($rowFeaturedEvents = mysqli_fetch_array($resFeaturedEvents)) {

												if ($rowFeaturedEvents["eventThumb"] != '') {
													$eventphoto = $rowFeaturedEvents["eventThumb"];
												} else {
													$eventphoto = 'events-placeholder.jpg';
												}
												?>
												<div class="topsearchlist"
													onClick="location.href='<?php echo $fullurl; ?>events-detail.html?eventId=<?php echo encodeStr($rowFeaturedEvents['id']); ?>';">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td width="1%">
																<div
																	style="width:35px;    border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
																	<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($eventphoto)); ?>"
																		title="<?php echo stripslashes($rowFeaturedEvents["eventName"]); ?>"
																		width="100%" style="min-height:100%;">
																</div>
															</td>
															<td width="99%">
																<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
																	<?php echo substr(stripslashes($rowFeaturedEvents["eventName"]), 0, 100); ?>
																</div>
																<div style="font-size:12px; color:#9a9a9a;">
																	<?php $strstrtdate = strtotime($rowFeaturedEvents["eventDate"]);
																	echo date("j M", $strstrtdate); ?>
																	-
																	<?php $strenddate = strtotime($rowFeaturedEvents["eventTillDate"]);
																	echo date("j M Y", $strenddate); ?>
																	<?php echo stripslashes(strip_tags($rowFeaturedEvents["eventVenue"])); ?>
																	<?php echo stripslashes($rowFeaturedEvents["eventCountryAddress"]); ?>
																</div>
															</td>
														</tr>
													</table>

												</div>
												<?php

											}
										}
										if ($totalRow5 == 0) {
											?>
											<div style="padding-top:78px; text-align:center;">No result found.</div>
											<?php
										}
									} ?>

									<?php if ($_REQUEST['type'] == 9) {
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$sqlProjects = "";
										$sqlProjects = "SELECT * from " . _PROJECT_MASTER_TABLE_ . " WHERE (projectTitle like '%" . $keyword . "%' OR proCity like '%" . $keyword . "%' OR proCountry like '%" . $keyword . "%' OR proNature like '%" . $keyword . "%' OR proSkills like '%" . $keyword . "%') ORDER BY projectTitle LIMIT 0,50 ";
										$resProjects = getRecords(_PROJECT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlProjects);
										if ($resProjects) {
											$s = 1;
											$srch = 1;
											?>
											<div class="topsearchheader">Projects</div>
											<?php
											while ($rowProjects = mysqli_fetch_array($resProjects)) {
												$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowProjects["userId"] . "";
												$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
												$userres = mysqli_fetch_array($b);
												?>
												<div class="topsearchlist"
													onClick="location.href='<?php echo $fullurl; ?>preview-project.html?projId=<?php echo encodeStr($rowProjects['id']); ?>';">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td width="100%">
																<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
																	<?php echo substr(stripslashes($rowProjects["projectTitle"]), 0, 100); ?>
																</div>
																<div style="font-size:12px; color:#9a9a9a;">
																	<div class="posted">Posted:
																		<span><?php echo date("d/m/Y", $rowProjects["dateAdded"]); ?></span>
																		Start:
																		<span><?php echo date("d/m/Y", strtotime($rowProjects["proStartDate"])); ?></span>
																	</div>
																	<?php echo stripslashes(strip_tags($rowProjects["proCity"])); ?>,
																	<?php echo stripslashes($rowProjects["proCountry"]); ?>
																</div>
																<div style="font-size:12px; color:#000;">By
																	<?php echo stripslashes(trim($userres["firstName"])); ?>
																	<?php echo stripslashes(trim($userres["lastName"])); ?>
																</div>
															</td>
														</tr>
													</table>

												</div>
												<?php

											}
										}
										if ($totalRow9 == 0) {
											?>
											<div style="padding-top:78px; text-align:center;">No result found.</div>
											<?php
										}
									} ?>



									<?php if ($_REQUEST['type'] == 12) {
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$sqlSmb = "";
										$sqlSmb = "SELECT id,companyBusinessName,completeAddress,shortDescription,fileUploaded from " . _BUSINESS_MASTER_TABLE_ . " WHERE (companyBusinessName like '%" . $keyword . "%' OR cityName like '%" . $keyword . "%' OR completeAddress like '%" . $keyword . "%' OR contactPerson like '%" . $keyword . "%' OR postalCode like '%" . $keyword . "%') ORDER BY companyBusinessName LIMIT 0,50 ";
										$resSmb = getRecords(_BUSINESS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlSmb);
										if ($resSmb) {
											$s = 1;
											$srch = 1;
											?>
											<div class="topsearchheader">SME Connect</div>
											<?php
											while ($rowSmb = mysqli_fetch_array($resSmb)) {
												if ($rowSmb["fileUploaded"] != '') {
													$companyPhoto = $rowSmb["fileUploaded"];
												} else {
													$companyPhoto = 'businessimg.png';
												}
												?>
												<div class="topsearchlist"
													onClick="location.href='<?php echo $fullurl; ?><?php echo _SMBURL_TEXT_; ?>/<?php echo encodeStr($rowSmb['id']); ?>/<?php echo makeContentUrl($rowSmb['companyBusinessName']); ?>.html';">

													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td width="1%">
																<div
																	style="width:35px; border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
																	<img src="<?php echo $fullurl; ?>uploads/<?php echo $companyPhoto; ?>"
																		title="<?php echo stripslashes($rowSmb["companyBusinessName"]); ?>"
																		width="100%" style="min-height:100%;">
																</div>
															</td>
															<td width="99%">
																<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
																	<?php echo stripslashes($rowSmb["companyBusinessName"]); ?>
																</div>
																<div style="font-size:12px; color:#9a9a9a;">
																	<?php if ($rowSmb['completeAddress'] != '') { ?><i
																			class="fa fa-map-marker" aria-hidden="true"
																			style="color: #3294c3; font-size: 16px; margin-right: 7px;"></i>
																		<?php echo $rowSmb['completeAddress'];
																	} ?>
																</div>
																<div class="descr">
																	<?php echo getStrLength(strip_tags(stripslashes($rowSmb["shortDescription"])), 150); ?>
																</div>
															</td>
														</tr>
													</table>
												</div>
												<?php
											}
										}

										if ($totalRow12 == 0) {
											?>
											<div style="padding-top:78px; text-align:center;">No result found.</div>
											<?php
										}
									} ?>

									<?php if ($_REQUEST['type'] == 13) {
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];


										$sqlTalent = "";
										$sqlTalent = "SELECT * from " . _TALENT_MASTER_TABLE_ . " WHERE (talentName like '%" . $keyword . "%' OR shortDescription like '%" . $keyword . "%' OR longDescription like '%" . $keyword . "%') ORDER BY talentName LIMIT 0,50  ";
										$resTalent = getRecords(_TALENT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlTalent);
										if ($resTalent) {
											$s = 1;
											$srch = 1;
											?>
											<?php
											while ($rowTalent = mysqli_fetch_array($resTalent)) {

												$talentProfilePhoto = '';
												if ($rowTalent["talentProfilePhoto"] != '') {
													$talentProfilePhoto = $rowTalent["talentProfilePhoto"];
												} else {
													$talentProfilePhoto = 'talentimgthumb.png';
												}

												?>
												<div class="topsearchlist"
													onClick="location.href='<?php echo $fullurl; ?>talent-profile-detail.html?id=<?php echo encodeStr($rowTalent['id']); ?>';">
													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td width="1%">
																<div
																	style="width:35px; border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
																	<img src="<?php echo $fullurl; ?>uploads/<?php echo $talentProfilePhoto; ?>"
																		title="<?php echo stripslashes($rowTalent["talentName"]); ?>"
																		width="100%" style="min-height:100%;">
																</div>
															</td>
															<td width="99%">
																<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
																	<?php echo stripslashes($rowTalent["talentName"]); ?>
																</div>
																<div style="font-size:12px; color:#9a9a9a;"><span class="catgr"
																		style="color: #1a94c3;">
																		<?php
																		$selectFields = [];
																		$whereFields = [];
																		$whereVals = [];
																		$in = 0;
																		$sqlOptions = "";
																		$sqlOptions = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='talent' and id IN (" . $rowTalent['catIds'] . ") ";
																		$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
																		if ($resOptions) {
																			$totrowOptions = mysqli_num_rows($resOptions);
																			while ($rowOptions = mysqli_fetch_array($resOptions)) {
																				$in++;

																				if ($in == $totrowOptions) {
																					$coma = '';
																				} else {
																					$coma = ', ';
																				}
																				echo $rowOptions['optionName'] . $coma;
																			}
																		}
																		?>
																	</span></div>
																<div class="descr">
																	<?php echo stripslashes($rowTalent['shortDescription']); ?>
																</div>
															</td>
														</tr>
													</table>

												</div>
												<?php

											}
										}
										if ($totalRow13 == 0) {
											?>
											<div style="padding-top:78px; text-align:center;">No result found.</div>
											<?php
										}
									} ?>


									<?php if ($_REQUEST['type'] == 14) {
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];


										$sqlJobs = "";
										$sqlJobs = "SELECT * from " . _JOBS_MASTER_TABLE_ . " WHERE status=1 and jobStatus=1 and (jobTitle like '%" . $keyword . "%' OR jobLocation like '%" . $keyword . "%' OR companyName like '%" . $keyword . "%' OR companyAddress like '%" . $keyword . "%' OR jobKeywords like '%" . $keyword . "%') ORDER BY jobTitle LIMIT 0,50 ";
										$resJobs = getRecords(_JOBS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlJobs);
										if ($resJobs) {
											$s = 1;
											$srch = 1;
											?>
											<?php
											while ($rowJobs = mysqli_fetch_array($resJobs)) {
												?>
												<div class="topsearchlist"
													onClick="location.href='<?php echo $fullurl; ?>view-job.html?id=<?php echo encodeStr($rowJobs['id']); ?>';">

													<table width="100%" border="0" cellspacing="0" cellpadding="0">
														<tr>
															<td width="99%">
																<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
																	<?php echo stripslashes($rowJobs["jobTitle"]); ?>
																</div>
																<div style="font-size:12px; color:#9a9a9a;"><i class="fa fa-map-marker"
																		aria-hidden="true"
																		style="color: #3294c3; font-size: 16px; margin-right: 7px;"></i>
																	<?php echo $rowJobs['jobLocation']; ?></div>
																<div style="font-size:12px; color:#d2953b;"><span
																		style="color:#000000;"><strong>Career Level:</strong></span> <?php
																		$selectFields = [];
																		$whereFields = [];
																		$whereVals = [];

																		$sqlOptions1 = "";
																		$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE  id=" . $rowJobs["levelId"] . " ";
																		$resOptions1 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
																		if ($resOptions1) {
																			while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
																				if ($levelId == $rowOptions1['id']) {
																					$strSelected = 'selected="selected"';
																				} else {
																					$strSelected = "";
																				}
																				echo trim($rowOptions1['optionName']);
																			}
																		}
																		?></div>

																<div style="font-size:12px;color:#000000;"><strong>Industry
																		Type:</strong> <?php
																		$selectFields = [];
																		$whereFields = [];
																		$whereVals = [];

																		$sqlOptions1 = "";
																		$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE  id=" . $rowJobs["jobCatId"] . " ";
																		$resOptions1 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
																		if ($resOptions1) {
																			while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
																				if ($levelId == $rowOptions1['id']) {
																					$strSelected = 'selected="selected"';
																				} else {
																					$strSelected = "";
																				}
																				echo trim($rowOptions1['optionName']);
																			}
																		}
																		?></div>
																<div class="descr">
																	<?php echo getStrLength(strip_tags(stripslashes($rowJobs["jobDetails"])), 150); ?>
																</div>
															</td>
														</tr>
													</table>
												</div>
												<?php

											}
										}
										if ($totalRow14 == 0) {
											?>
											<div style="padding-top:78px; text-align:center;">No result found.</div>
											<?php
										}
									}
									?>


									<?php if ($_REQUEST['type'] == 6) {
										?>
										<div class="serach-result-timeline">
											<?php

											$startpage = $_REQUEST['startpage'];
											$endpage = $_REQUEST['endpage'];
											$pageid = $_REQUEST['pageid'];

											$n = 0;
											$selectFields = [];
											$whereFields = [];
											$whereVals = [];

											$sqlLogin = "";
											$sqlLogin = "select * from " . _TIMELINE_MASTER_TABLE_ . " where postId IN (select id from " . _SHAREANDUPDATES_TABLE_ . " where (postTitle like '%" . $keyword . "%' OR postText like '%" . $keyword . "%')  and articleBlogStatus=0) and userId='" . $_SESSION['sessUserId'] . "' and postId!=0 OR (userId IN(SELECT contactId FROM " . _CONTACT_MASTER_TABLE_
												. " WHERE  userId='" . $_SESSION['sessUserId'] . "' and status=1 and shareType=2)) order by dateAdded desc limit 0,30 ";
											$resLogin = getRecords(_TIMELINE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
											if ($resLogin) {
												$s = 1;
												$srch = 1;
												while ($row = mysqli_fetch_array($resLogin)) {

													if ($row["status"] == 1) {

														$ha = "SELECT id from " . _HIDDEN_POSTS_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " and timeLineId=" . $row["postId"] . " ";
														$hb = mysqli_query($conn, $ha) or die(mysqli_error($conn));
														$hidpost = mysqli_num_rows($hb);
														if ($hidpost == 0) {


															$aa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= " . $row["postId"] . " and postType= " . $row["postType"] . "";
															$res5 = mysqli_query($conn, $aa);
															$totalpostlike = mysqli_num_rows($res5);

															$aa = "SELECT * from " . _COMMENT_MASTER_TABLE_ . " WHERE postId= " . $row["postId"] . " and postType= " . $row["postType"] . "";
															$res5 = mysqli_query($conn, $aa);
															$totalpostcomment = mysqli_num_rows($res5);

															$aas = "SELECT * from " . _SHARE_MASTER_TABLE_ . " WHERE postId= " . $row["postId"] . " and postType= " . $row["postType"] . "";
															$res5s = mysqli_query($conn, $aas);
															$totalpostshared = mysqli_num_rows($res5s);

															$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $row["userId"] . "";
															$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
															$userres = mysqli_fetch_array($b);



															$jobTitle = $userres["jobTitle"];
															$companyName = $userres["companyName"];

															$friendnameurl = $userres['userurl'];

															if ($userres["profilePhoto"] != '') {
																$userphoto = $userres["profilePhoto"];
															} else {
																$userphoto = 'user-placeholder.jpg';
															}



															if ($row["postType"] == 1 || $row["postType"] == 2 || $row["postType"] == 3) {

																$sql_inss = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE id= " . $row["postId"] . " and articleBlogStatus=0 ";
																$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
																$rowResults = mysqli_fetch_array($resresults);

																if ($row["postId"] == $rowResults["id"]) {
																	?>

																	<div class="timlist" id="<?php echo $rowResults['id']; ?>">
																		<div class="hedr">
																			<div class="prfl_img"> <a
																					href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
																						src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
																			</div>
																			<div class="hdr_right"><a
																					href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes(trim($userres["firstName"])); ?>
																					<?php echo stripslashes(trim($userres["lastName"])); ?></a>
																				<?php if ($row["postType"] == 3 && $rowResults["sharePost"] != 1) { ?>
																					<span class="timelinecontantsubline"></span>
																				<?php } ?>
																				<label class="time"><?php echo $jobTitle; ?>
																					<?php if ($companyName != '') {
																						echo 'at ' . $companyName;
																					} ?>
																				</label>
																				<label class="time"><?php if ($row["postType"] == 3 && $rowResults["sharePost"] != 1) {
																					echo 'Posted an article';
																				} else {
																					if ($rowResults["sharePost"] == 1) {
																						if ($row["postType"] == 3) {
																							echo 'Shared an article';
																						} else {
																							echo 'Shared a post';
																						}
																					}
																				} ?>
																					<?php echo makedatetime($row["dateAdded"]); ?></label>
																			</div>

																			<?php if ($row["postType"] == 1 || $row["postType"] == 2) { ?>
																				<div class="errow-drop"> <span class="errow"
																						onclick="accordion('<?php echo $row['id']; ?>');"><i
																							class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
																					<ul class="erow-list" id="<?php echo $row['id']; ?>">
																						<li>
																							<div style="display:none;"
																								id="clipboard<?php echo ($rowResults['id']); ?>">
																								<?php echo $fullurl . "single-post.html?postId=" . encodeStr($rowResults['id']) . "&postType=" . $row["postType"]; ?>
																							</div>
																							<a style="cursor:pointer;"
																								onClick="copyToClipboard('#clipboard<?php echo ($rowResults['id']); ?>');"><i
																									class="fa fa-link" aria-hidden="true"></i> Copy link to
																								post</a>
																						</li>
																						<?php if ($userres['userId'] == $_SESSION['sessUserId']) { ?>
																							<li> <!--<a href="common_action.php?dltid=<?php echo encodeStr($rowResults['id']); ?>&action=dlt" target="actionfrm"><i class="fa fa-window-close-o" aria-hidden="true"></i> Remove</a>-->
																								<a
																									onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo encodeStr($rowResults['id']); ?>','dltpost');"><i
																										class="fa fa-window-close-o" aria-hidden="true"></i>
																									Remove</a>
																							</li>
																						<?php } else { ?>
																							<li><a
																									onclick="alertpopupmain('<?php echo encodeStr($row["postId"]); ?>','hidepost22');"><i
																										class="fa fa-eye-slash" aria-hidden="true"></i> Hide
																									this post</a></li>
																							<li><a
																									onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo encodeStr($rowResults['id']); ?>&type=reportpost','Why are you reporting this?');"><i
																										class="fa fa-flag" aria-hidden="true"></i> Report this
																									post</a></li>
																						<?php } ?>
																					</ul>
																				</div>
																			<?php } ?>

																			<?php if ($row["postType"] == 3) { ?>
																				<div class="errow-drop"> <span class="errow"
																						onclick="accordion('<?php echo $row['id']; ?>');"><i
																							class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
																					<ul class="erow-list" id="<?php echo $row['id']; ?>">
																						<?php if ($userres['userId'] == $_SESSION['sessUserId']) { ?>
																							<?php if ($rowResults["sharePost"] != 1) { ?>
																								<li><a
																										href="<?php echo $fullurl; ?>edit-article.html?editid=<?php echo encodeStr($rowResults['id']); ?>&action=edit"><i
																											class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
																								</li><?php } ?>
																							<li><a
																									onClick="alertpopupmain('<?php echo encodeStr($rowResults['id']); ?>','deletearticlepost');"><i
																										class="fa fa-window-close-o" aria-hidden="true"></i>
																									Remove</a></li>
																						<?php } ?>
																						<div style="display:none;"
																							id="clipboard<?php echo ($rowResults['id']); ?>">
																							<?php echo $fullurl . "view-article.html?postId=" . encodeStr($rowResults['id']) . "&postType=" . $row["postType"]; ?>
																						</div>
																						<li>
																							<a style="cursor:pointer;"
																								onClick="copyToClipboard('#clipboard<?php echo ($rowResults['id']); ?>');"><i
																									class="fa fa-link" aria-hidden="true"></i> Copy link to
																								post</a>
																						</li>
																						<li><a
																								onClick="alertpopupmain('<?php echo encodeStr($row["postId"]); ?>','hidepost');"><i
																									class="fa fa-eye-slash" aria-hidden="true"></i> Hide
																								this article</a></li>
																					</ul>
																				</div>
																			<?php } ?>

																		</div>
																		<div class="txtarea" id="txtarea<?php echo $rowResults['id']; ?>">
																			<div style=" margin-bottom:10px;">
																				<?php if ($row["postType"] == 1 || $row["postType"] == 2 || $rowResults["sharePost"] == 1) { ?>

																					<div id="shortdesc<?php echo $rowResults['id']; ?>" style="position:relative; height:<?php if ($rowResults["websiteshare"] == 0 && $rowResults["sharePost"] == 0 && $rowResults["postText"] != '' && strlen((stripslashes($rowResults["postText"]))) > 200) {
																						   echo '140px';
																					   } else {
																						   echo 'auto';
																					   } ?>; overflow:hidden;">
																						<?php echo stripslashes(nl2br($rowResults["postText"])); ?>
																					</div>
																					<?php
																					if (strlen((stripslashes($rowResults["postText"]))) > 200 && $rowResults["websiteshare"] == 0 && $rowResults["sharePost"] == 0 && $rowResults["postText"] != '') {
																						?>
																						<div style="margin-top:10px; padding-left:0px; text-align:right;"
																							id="hideafterreadmore<?php echo $rowResults['id']; ?>"><a
																								style="cursor:pointer"
																								id="readtext<?php echo $rowResults['id']; ?>"
																								onClick="showmoreless('<?php echo $rowResults['id']; ?>');">read
																								more</a></div>
																						<?php
																					}

																					?>

																				<?php } ?>
																				<?php if ($row["postType"] == 3) { ?>
																					<div style="font-size:15px; font-weight:bold; margin-bottom:5px;"><a
																							href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($row['postId']); ?>"><?php echo stripslashes(strip_tags($rowResults["postTitle"])); ?></a>
																					</div>
																					<div class="timelinelistingcontant">
																						<?php echo getStrLength(strip_tags(stripslashes($rowResults["postText"])), 210); ?>

																						<div style="margin-top:10px; float:right; padding:10px;"><a
																								href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($row['postId']); ?>">read
																								more</a></div>
																					</div>
																				<?php } ?>
																			</div>
																			<?php

																			$a = "";
																			$a = "select * from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $row['postId'] . "";
																			$b = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $a);
																			if ($b) {
																				$numrows = mysqli_num_rows($b);
																				$width = '100%';

																				while ($rowimg = mysqli_fetch_array($b)) {
																					?>
																					<img src="<?php echo $fullurl; ?>uploads/<?php echo $rowimg['imageName']; ?>"
																						style="position:inline-block; cursor:pointer;"
																						onClick="countpostview('<?php echo encodeStr($row['postId']); ?>');imagepopupmain('<?php echo $rowimg['id']; ?>');">
																				<?php }
																			}


																			?>

																			<?php if ($userres['userId'] == $_SESSION['sessUserId']) {

																				if (($row["postType"] == 1 || $row["postType"] == 2) && $rowResults["sharePost"] != 1) { ?>
																					<!-- <div class="promote-btn">
						<a onclick="createadwindow('p','1','<?php echo ($row['postId']); ?>');">Promote</a>
					</div>-->
																				<?php }
																				if ($row["postType"] == 3) { ?>
																					<!-- <div class="promote-btn">
						<a onclick="createadwindow('a','1','<?php echo ($row['postId']); ?>');">Promote</a>
					</div>-->
																				<?php }
																			} ?>
																			<div class="timeline-img"> </div>
																		</div>
																		<div class="timlist-fttr">
																			<table width="100%" cellpadding="0" cellspacing="0" border="0">
																				<tr>
																					<td width="15%">
																						<div id="post<?php echo $row["postId"]; ?><?php echo $row["postType"]; ?>"
																							onClick="postlike(<?php echo $row["postId"]; ?>,<?php echo $row["postType"]; ?>,<?php if ($totalpostlike != '') {
																									  echo $totalpostlike;
																								  } else {
																									  echo '0';
																								  } ?>);">
																							<a><i class="fa fa-thumbs-up" aria-hidden="true"
																									style="color: #860E66;"></i><span>
																									<?php if ($totalpostlike != '') {
																										echo $totalpostlike;
																									} else {
																										echo '0';
																									} ?>
																								</span> Like<?php if ($totalpostlike > 1) {
																									echo 's';
																								} ?>
																							</a>
																						</div>

																					</td>
																					<td width="45%">
																						<ul class="likes-mmbr"
																							id="likesmmbrdiv<?php echo $row["postId"]; ?><?php echo $row['postType']; ?>">
																						</ul>

																						<script>
																							$('#likesmmbrdiv<?php echo $row['postId']; ?><?php echo $row['postType']; ?>').load('<?php echo $fullurl; ?>loadlikeusers.php?postId=<?php echo $row['postId']; ?>');
																						</script>

																					</td>
																					<td width="20%" align="right">
																						<div id="commentdisplaybox<?php echo $row['postId']; ?><?php echo $row['postType']; ?>"
																							class="triggerBtn"><i class="fa fa-commenting"
																								aria-hidden="true"></i> <span>
																								<?php if ($totalpostcomment != '') {
																									echo $totalpostcomment;
																								} else {
																									echo '0';
																								} ?>
																							</span> Comment </div>
																					</td>
																					<td width="20%" align="right">
																						<div><a
																								onClick="sharefuncommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo encodeStr($row['postId']); ?>&type=share&sharePostType=<?php echo $row['postType']; ?>','Share','<?php echo $rowResults['id']; ?>');"><i
																									class="fa fa-share" aria-hidden="true"></i> <span
																									id="shareposts<?php echo $row["postId"]; ?><?php echo $row["postType"]; ?>"><span><?php if ($totalpostshared != '') {
																											  echo $totalpostshared;
																										  } else {
																											  echo '0';
																										  } ?></span>
																									Share</span> </a></div>
																					</td>
																				</tr>
																			</table>


																			<ul class="tmln_fttr" style="display: none;">
																				<li id="post<?php echo $row["postId"]; ?><?php echo $row["postType"]; ?>"
																					onClick="postlike(<?php echo $row["postId"]; ?>,<?php echo $row["postType"]; ?>,<?php if ($totalpostlike != '') {
																							  echo $totalpostlike;
																						  } else {
																							  echo '0';
																						  } ?>);">
																					<a><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like <span>
																							<?php if ($totalpostlike != '') {
																								echo $totalpostlike;
																							} else {
																								echo '0';
																							} ?>
																						</span></a>
																				</li>

																				<!--<li><a onclick="opensharebox('<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($row['postId']); ?>','<?php echo stripslashes(trim($rowResults["postTitle"])); ?>');"><i class="fa fa-share" aria-hidden="true"></i> Share <span>0</span></a></li>-->


																				<li class="views">
																					<?php if ($rowResults['viewStatus'] != 0) {
																						echo $rowResults['viewStatus'];
																						if ($rowResults['viewStatus'] > 1) {
																							echo ' views';
																						} else {
																							echo ' view';
																						}
																					} ?>
																				</li>
																			</ul>
																			<div class="commnts-cont">
																				<div class="comnt-write">
																					<div class="write-cmnt-pic"> <img
																							src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($myprofilePhoto)); ?>">
																					</div>
																					<div class="cmnt-inpt">

																						<input type="text" class="commentrowboxclass"
																							id="commentbox<?php echo $row['postId']; ?><?php echo $row['postType']; ?>"
																							name="commentbox<?php echo $row['postId']; ?><?php echo $row['postType']; ?>"
																							placeholder="Type your comment" maxlength="250">

																						<button type="button" onClick="postcmnt('<?php echo $row['postId']; ?>','<?php echo $row['postType']; ?>','<?php echo encodeStr($userres['userId']); ?>','','0','','<?php if ($_REQUEST['siglepost'] == 1) {
																									 echo '10000';
																								 } else {
																									 echo '5';
																								 } ?>');"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>


																						<script>
																							$("#commentbox<?php echo $row['postId']; ?><?php echo $row['postType']; ?>").keypress(function (event) {
																								if (event.which == 13) {
																									postcmnt('<?php echo $row['postId']; ?>', '<?php echo $row['postType']; ?>', '<?php echo encodeStr($userres['userId']); ?>', '', '0', '', '<?php if ($_REQUEST['siglepost'] == 1) {
																												 echo '10000';
																											 } else {
																												 echo '5';
																											 } ?>');
																								}
																							});
																						</script>

																					</div>
																				</div>
																				<ul class="cmmnt-list"
																					id="postcomment<?php echo $row['postId']; ?><?php echo $row['postType']; ?>">
																					Loading...
																				</ul>
																				<script>$(".timlist .timlist #postcomment<?php echo $row['postId']; ?><?php echo $row['postType']; ?>").remove();</script>


																			</div>
																		</div>
																	</div>

																	<script>
																		$('#postcomment<?php echo $row['postId']; ?><?php echo $row['postType']; ?>').load('post-comment.php?postId=<?php echo $row['postId']; ?>&postType=<?php echo $row['postType']; ?>&parentId=0&limit=<?php if ($_REQUEST['siglepost'] == 1) {
																						echo '10000';
																					} else {
																						echo '5';
																					} ?>');
																	</script>
																	<?php
																}

															}



														}

													}
													$n++;




												}

											}
											?>
											<?php
											if ($n == 0) { ?>
												<!--<div class="timlist" style="min-height:218px;">
		<div class="not-found">
		<p>Not found.</p>
		 </div>

		</div>-->
											<?php } ?>
											<!--<div id="loadtimeline<?php echo $endpage; ?>">
  <?php if ($n > 19) {
				  if ($_SESSION['useractivity'] != '') { ?>
  <a onClick="loadtimelineActivitfun('<?php echo $endpage; ?>','<?php echo $endpage + 1; ?>','<?php echo $endpage + 20; ?>');" class="load-more">Load More Posts</a>
  <?php } else { ?>
  <a onClick="loadtimeline('<?php echo $endpage; ?>','<?php echo $endpage + 1; ?>','<?php echo $endpage + 20; ?>');" class="load-more">Load More Posts</a>
  <?php }
			  } ?>
</div>-->
										</div>

										<!--<script>
if(<?php echo $n; ?>>0)
{
//alert(<?php echo $n; ?>);
 $("#totalRow6").text('<?php echo $n; ?>');
}
else
{
 $("#totalRow6").text('0');
}

</script>-->
										<?php

										if ($srch == 0) {
											?>
											<div style="padding-top:78px; text-align:center;">No result found.</div>
											<?php
										}
									}
									?>

									<?php if ($_REQUEST['type'] == 7) {
										?>
										<div style="overflow:hidden;" class="photogrps" id="photogrps">
											<div class="uploadimg" id="imagebx"
												style="width:100%; background-color:inherit; border:0px;"></div>
											<script>
												$("#imagebx").load('<?php echo $fullurl; ?>searchphotogallery.php?keywordsearch=<?php echo $keyword; ?>');
											</script>

										</div>



									<?php } ?>

									<style>
										.gall {
											width: 163px;
											height: 150px;
											overflow: hidden;
											margin: 2px;
											float: left;
											position: relative;
										}

										.gall .iname {
											padding: 5px;
											color: #fff;
											background-color: rgba(0, 0, 0, 0.7);
											position: absolute;
											left: 5px;
											bottom: 5px;
										}

										@media (max-width: 767px) {

											#TGnextbtn,
											#TGprevbtn {
												top: 3%;
											}
										}
									</style>


								<?php } ?>
								<?php

								if ($srch == 0) {
									?>
									<div style="padding:20px; text-align:center;">No result found.</div>
									<?php
								}
								?>
							</div>

						</div>
					</div>
				</div>
			</div>

		</div>
		<?php include('footer.php'); ?>
		<script>
			function countpostview(id) {
				$('#commonaction').load('<?php echo $fullurl; ?>common_action.php?action=allpostview&postId=' + id);
			}

			function reloadPage() {
				location.reload(true);
			}



			$(document).on("click", ".triggerBtn", function () {
				var inputField = $(this).closest('div').find('.commentrowboxclass').focus();

			});
		</script>

</body>

</html>