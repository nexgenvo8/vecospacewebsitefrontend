<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$pageIndex = 11;
$ptab = 5;

// Fix: check if sort exists
$sort = isset($_GET["sort"]) ? $_GET["sort"] : "";

if ($sort == '') {
	$sortStr = " and userId IN(select userId from " . _PROJECT_MASTER_TABLE_ . " order by id desc) ";
	$sortTaxt = 'Latest projects';
}

if ($sort == 'startdate') {
	$sortStr = " and userId IN(select userId from " . _PROJECT_MASTER_TABLE_ . " order by proStartDate desc) ";
	$sortTaxt = 'Project start date';
}

// Fix: define variables instead of unsetting
$selectFields = [];
$whereFields = [];
$whereVals = [];

// My Projects
$sqlMyProject = "select id from " . _PROJECT_MASTER_TABLE_ . " where userId=" . intval($_SESSION["sessUserId"]) . " " . $sortStr;
$resMyProject = getRecords(_PROJECT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlMyProject);
$totalMyproject = is_object($resMyProject) ? mysqli_num_rows($resMyProject) : 0;

// Bookmarked Projects
$sqlBookmProject = "select * from " . _PROJECT_BOOKMARK_TABLE_ . " where userId=" . intval($_SESSION["sessUserId"]);
$resBookmProject = getRecords(_PROJECT_BOOKMARK_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlBookmProject);
$totalBookmproject = is_object($resBookmProject) ? mysqli_num_rows($resBookmProject) : 0;

// Interested Projects
$sqlInterestedProject = "select id from " . _PROJECT_INTRESTED_TABLE_ . " where userId=" . intval($_SESSION["sessUserId"]);
$resInterestedProject = getRecords(_PROJECT_INTRESTED_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlInterestedProject);
$totalInterestedproject = is_object($resInterestedProject) ? mysqli_num_rows($resInterestedProject) : 0;
?>

<!DOCTYPE html>
<html>

<head>
	<title>Projects - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<script>
		function bookmarkfun(id) {
			$('#loadbookmarkdiv').load('<?php echo $fullurl; ?>common_action.php?action=bookmark&pid=' + id);
		}
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

				<div class="groups" style="min-height:500px; background-color:#fff;">
					<?php include('project_top.inc.php'); ?>
					<ul class="manage-tab">

						<li><a href="<?php echo $fullurl; ?>manage-projects.html">My projects
								<?php if ($totalMyproject > 0) {
									echo '(' . $totalMyproject . ')';
								} ?></a></li>
						<li><a href="<?php echo $fullurl; ?>bookmarked-projects.html" class="active">Bookmarked projects
								<?php if ($totalBookmproject > 0) {
									echo '(' . $totalBookmproject . ')';
								} ?></a></li>
						<li><a href="<?php echo $fullurl; ?>interested-projects.html">Projects I am interested
								in<?php if ($totalInterestedproject > 0) {
									echo '(' . $totalInterestedproject . ')';
								} ?></a>
						</li>
						<li class="post-prjct-btn"><a href="<?php echo $fullurl; ?>post-project.html" class="btn">Post a
								Project </a></li>
					</ul>


					<?php
					if ($totalBookmproject == 0) {
						?>
						<div class="crtnw-prjct" style="text-align:center; padding-top:15%;">
							<strong>You have not bookmarked any Project.</strong>
							<p>Explore suitable projects now!</p>
							<div class="findprojectbtn"><a href="<?php echo $fullurl; ?>search-projects.html">Find
									Projects</a></div>
						</div>
					<?php } else { ?>

						<div class="reslt">
							<span class="rslt-count"><?php echo $totalBookmproject; ?> Result</span>

						</div>
						<ul class="project-list">
							<?php

							if ($totalBookmproject > 0) {
								while ($rowProject1 = mysqli_fetch_array($resBookmProject)) {

									$ap = "SELECT * from " . _PROJECT_MASTER_TABLE_ . " WHERE id= " . $rowProject1["projectId"] . "";
									$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
									$rowProject = mysqli_fetch_array($bp);

									$friendnameurl = '';
									$userphoto = '';
									$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowProject["userId"] . "";
									$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
									$userres = mysqli_fetch_array($b);

									$friendnameurl = $userres['userurl'];

									if ($userres["profilePhoto"] != '') {
										$userphoto = $userres["profilePhoto"];
									} else {
										$userphoto = 'user-placeholder.jpg';
									}
									?>
									<li id="bookmarklisting<?php echo $rowProject['id']; ?>">
										<div class="prjct-post">

											<div onClick="location.href='<?php echo $fullurl; ?>preview-project.html?projId=<?php echo encodeStr($rowProject['id']); ?>';"
												style="cursor:pointer;">
												<div class="prjct-tm">
													<?php
													if ($rowProject["proDuration"] == '1 day') {
														$first = '1';
														$last = 'day';
													}
													if ($rowProject["proDuration"] == '2 days') {
														$first = '2';
														$last = 'days';
													}
													if ($rowProject["proDuration"] == '3 days') {
														$first = '3';
														$last = 'days';
													}
													if ($rowProject["proDuration"] == '7 days(1 week)') {
														$first = '1';
														$last = 'week';
													}
													if ($rowProject["proDuration"] == '14 days(2 weeks)') {
														$first = '2';
														$last = 'weeks';
													}
													if ($rowProject["proDuration"] == '21 days(3 weeks)') {
														$first = '3';
														$last = 'weeks';
													}
													if ($rowProject["proDuration"] == '28 days(1 month)') {
														$first = '1';
														$last = 'month';
													}
													if ($rowProject["proDuration"] == '60 days(2 months)') {
														$first = '2';
														$last = 'months';
													}
													if ($rowProject["proDuration"] == '90 days(3 months)') {
														$first = '3';
														$last = 'months';
													}

													?>
													<?php echo $first; ?><span><?php echo $last; ?></span>
												</div>
												<div class="project-nm">
													<span><?php
													$whereFields = [];
													$selectFields = [];     // Empty because we are passing raw SQL
													$whereVals = [];
													$sqlOptionspost = "";
													$sqlOptionspost = "SELECT optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry' and id='" . $rowProject["protIndusCategory"] . "' ";
													$resOptionspost = getRecords(_OPTION_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptionspost);
													$totalpost = mysqli_num_rows($resOptionspost);
													if ($totalpost) {
														while ($rowOptionspost = mysqli_fetch_array($resOptionspost)) {
															echo trim($rowOptionspost['optionName']);
														}
													}
													?></span>
													<a
														href="<?php echo $fullurl; ?>preview-project.html?projId=<?php echo encodeStr($rowProject['id']); ?>"><?php echo stripslashes($rowProject["projectTitle"]); ?></a>
													<div class="posted">Posted:
														<span><?php echo date("d/m/Y", $rowProject["dateAdded"]); ?></span> Start:
														<span><?php echo date("d/m/Y", strtotime($rowProject["proStartDate"])); ?></span>
													</div>

												</div>

												<div class="prjct-location"><i class="fa fa-map-marker"
														aria-hidden="true"></i><span><?php echo $rowProject["proCity"]; ?></span>
												</div>
											</div>
											<div class="prjct-ownr">
												<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
													class="ownr"><img
														src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
												<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
													class="ownr-nm"><?php echo $userres['firstName']; ?>
													<?php echo $userres['lastName']; ?></a>
												<span><?php echo $userres['jobTitle']; ?> at
													<?php echo $userres['companyName']; ?></span>
												<a class="delete-pro" title="Remove"
													onClick="bookmarkfun('<?php echo encodeStr($rowProject['id']); ?>');"><i
														class="fa fa-times" aria-hidden="true"></i></a>
											</div>
										</div>
									</li>
									<?php

								}

							}
							?>
						</ul>

					<?php } ?>


				</div>
				<div id="loadbookmarkdiv" style="display:none;"></div>

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