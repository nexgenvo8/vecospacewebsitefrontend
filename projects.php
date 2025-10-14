<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 11;
$ptab = 6;

?>
<!DOCTYPE html>
<html>

<head>
	<title>Internships - <?php echo $companNameTitle; ?></title>
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

			</div>
			<div class="center_content">

				<div class="groups">
					<?php include('project_top.inc.php'); ?>
					<div class="grp_banner prjct">
						<!--<h1 class="headline" style="    font-size: 28px; line-height: 38px;">Connecting <span style="font-size: 28px;font-weight: 700;"> project owners</span> and <br><span style="font-size: 28px;font-weight: 700;">freelancers</span>, across the globe
</h1>-->

						<form name="searchprojectfrm" id="searchprojectfrm" class="grp-search single proje_intership"
							action="<?php echo $fullurl; ?>search-projects.html" method="get">
							<input type="text" name="searchproject" id="searchproject"
								placeholder="e.g. SAP, marketing, sales, etc.">
							<button type="button" class="srch" onClick="subsrchfrm();">Search</button>
						</form>

						<script>
							function subsrchfrm() {

								if ($("#searchproject").val() != '') {
									$("#searchprojectfrm").submit();
								}
							}

							$("input").keypress(function (event) {

								if (event.which == 13) {
									event.preventDefault();

									if ($("#searchproject").val() != '') {
										$("#searchprojectfrm").submit();
									}
								}
							});

						</script>
					</div>
					<!--<div class="how-prjct-work">-->
					<!--  <h2>How Internship work on <?php echo $companNameTitle; ?> </h2>-->
					<!--  <h2 style="font-size: 16px;"><strong>Internship Owners</strong></h2>-->
					<!--  <ol class="work-prjct-list">-->
					<!--    <li><i class="fa fa-sticky-note" aria-hidden="true"></i> Describe your internship <strong>for free</strong></li>-->
					<!--    <li><i class="fa fa-comments" aria-hidden="true"></i> <strong>Receive offers</strong> from internship Seekers  </li>-->
					<!--    <li><i class="fa fa-check-square" aria-hidden="true"></i> <strong>Choose</strong> a internship Seeker for your project </li>-->
					<!--  </ol>-->

					<!--   <h2 style="font-size: 16px; margin-top:50px;"><strong>Internship Seekers </strong></h2>-->
					<!--  <ol class="work-prjct-list">-->
					<!--    <li><i class="fa fa-search" aria-hidden="true"></i> Find <strong>relevant internship</strong> that match your expertise</li>-->
					<!--    <li><i class="fa fa-user" aria-hidden="true"></i> <strong>Connect directly </strong> with clients/internship owners </li>-->
					<!--    <li><i class="fa fa-briefcase" aria-hidden="true"></i> <strong>Get notifications</strong> on -->
					<!--recommended assignments<br>-->
					<!--basis your skill sets </li>-->
					<!--  </ol>-->
					<!--  <style>-->
					<!--  ol.work-prjct-list li {-->
					<!--display: inline-grid;-->
					<!--}-->
					<!--  </style>-->
					<!--</div>-->
					<div class="mmbrof_group_list">
						<h2>Featured Internships</h2>
						<ul class="project-list">
							<?php
							// Remove undefined variables
							$selectFields = [];
							$whereFields = [];
							$whereVals = [];

							$sqlProject = "SELECT * FROM " . _PROJECT_MASTER_TABLE_ . " 
                       WHERE userId != " . intval($_SESSION["sessUserId"]) . " 
                       AND status = 1 
                       AND finalPost = 1 
                       AND projectStatus = 1 
                       ORDER BY id DESC LIMIT 0,5";

							$resProject = mysqli_query($conn, $sqlProject) or die(mysqli_error($conn));
							if ($resProject) {
								while ($rowProject = mysqli_fetch_array($resProject)) {

									$friendnameurl = '';
									$userphoto = '';

									$a = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = " . intval($rowProject["userId"]);
									$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
									$userres = mysqli_fetch_array($b);

									$friendnameurl = $userres['userurl'] ?? '';

									$userphoto = (!empty($userres["profilePhoto"])) ? $userres["profilePhoto"] : 'user-placeholder.jpg';
									?>
									<li onClick="location.href='<?php echo $fullurl; ?>preview-project.html?projId=<?php echo encodeStr($rowProject['id']); ?>';"
										style="cursor:pointer;">
										<div class="prjct-post">
											<div class="prjct-tm">
												<?php
												$first = $last = '';
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
												<span>
													<?php
													$sqlOptionspost = "SELECT optionName FROM " . _OPTION_MASTER_TABLE_ . " 
                                    WHERE optionType='projectindustries' 
                                    AND id='" . intval($rowProject["protIndusCategory"]) . "'";
													$resOptionspost = mysqli_query($conn, $sqlOptionspost) or die(mysqli_error($conn));
													if ($resOptionspost && mysqli_num_rows($resOptionspost) > 0) {
														while ($rowOptionspost = mysqli_fetch_array($resOptionspost)) {
															echo trim($rowOptionspost['optionName']);
														}
													}
													?>
												</span>
												<a
													href="<?php echo $fullurl; ?>preview-project.html?projId=<?php echo encodeStr($rowProject['id']); ?>">
													<?php echo stripslashes($rowProject["projectTitle"]); ?>
												</a>
												<div class="posted">
													Posted: <span><?php echo date("d/m/Y", $rowProject["dateAdded"]); ?></span>
													Start:
													<span><?php echo date("d/m/Y", strtotime($rowProject["proStartDate"])); ?></span>
												</div>
											</div>
											<div class="prjct-location">
												<i class="fa fa-map-marker" aria-hidden="true"></i>
												<span><?php echo $rowProject["proCity"]; ?></span>
											</div>
											<div class="prjct-ownr">
												<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
													class="ownr">
													<img
														src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>">
												</a>
												<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
													class="ownr-nm">
													<?php echo $userres['firstName']; ?> 		<?php echo $userres['lastName']; ?>
												</a>
												<span><?php echo $userres['jobTitle']; ?> at
													<?php echo $userres['companyName']; ?></span>
											</div>
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