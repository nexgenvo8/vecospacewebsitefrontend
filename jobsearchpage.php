<?php
include_once('inc.php');
$pageIndex = 14;

$strWhere = '';

// Safe checks for request variables
$txtKeywords = isset($_REQUEST['txtKeywords']) ? $_REQUEST['txtKeywords'] : '';
$jobLocation = isset($_REQUEST['jobLocation']) ? $_REQUEST['jobLocation'] : '';
$levelId = isset($_REQUEST['levelId']) ? $_REQUEST['levelId'] : '';
$industry = isset($_REQUEST['industry']) ? $_REQUEST['industry'] : '';
$jobConsultant = isset($_REQUEST['jobConsultant']) ? $_REQUEST['jobConsultant'] : '';
$page = isset($_GET['page']) ? $_GET['page'] : 1;


$jobtitlefld = '';
$fulljoblocation = '';
if ($txtKeywords != '') {
	$strWhere .= " and jobTitle like '%" . $txtKeywords . "%' ";
	$jobtitlefld = $txtKeywords;
}

if ($jobLocation != '') {
	$strWhere .= " and jobLocation like '%" . $jobLocation . "%' ";
	$fulljoblocation = $jobLocation;
}

if ($levelId != '') {
	$strWhere .= " and levelId=" . $levelId . " ";
}

if ($industry != '') {
	$strWhere .= " and jobCatId=" . $industry . " ";
}

if ($jobConsultant != '' && $jobConsultant != '101') {
	$strWhere .= " and jobConsultant=" . $jobConsultant . " ";
} else {
	$jobConsultant = 101;
}

$no = 1;
$select = '';
$where = '';
$rs = '';
$limit = '20';
$select = '*';
$where = ' where status=1 and jobStatus=1 ' . $strWhere . ' order by id desc';
$targetpage = $fullurl . 'search-job.html?records=' . $limit . '&txtKeywords=' . $txtKeywords . '&jobLocation=' . $jobLocation . '&levelId=' . $levelId . '&industry=' . $industry . '&';

$rs = GetRecordList($select, _JOBS_MASTER_TABLE_, $where, $limit, $page, $targetpage);
$totalentry = $rs[1];
$paging = $rs[2];
?>

<!DOCTYPE html>
<html>

<head>
	<title>Search Job - Welcome to <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">


	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>

	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">
</head>

<body>
	<div id="wrapper">
		<?php include('header.php'); ?>
		<div class="container main">
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
				} else {
					echo 'nologin';
				} ?>">

					<div class="jobs-cont result">

						<div class="jobsearch-result-list">
							<ul class="broadcumb">
								<li><a href="<?php echo $fullurl; ?>jobs.html">Jobs - </a></li>
								<li>search </li>
							</ul>
							<h2 style="margin-bottom: 0;padding-top: 10px;"><?php echo $totalentry; ?> Results found
							</h2>
							<?php
							if ($totalentry > 0) {
								?>
								<ul class="compny-joblist" style="border-top: 0;">
									<?php

									while ($rowCompany = mysqli_fetch_array($rs[0])) {

										?>

										<li>
											<div class="cmpny-jobbox">
												<a href="<?php echo $fullurl; ?>view-job.html?id=<?php echo encodeStr($rowCompany['id']); ?>"
													class="prfl-nam"><?php echo stripslashes($rowCompany["jobTitle"]); ?></a>
												<div class="cmpny-nm">
													<?php
													$selectFields = [];
													$whereFields = [];
													$whereVals = [];

													$sqlOptions1 = "";
													$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE  id=" . $rowCompany["levelId"] . " ";
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
													?> -
													<span class="locat"><i class="fa fa-map-marker"
															aria-hidden="true"></i><?php echo stripslashes($rowCompany["jobLocation"]); ?></span>
													<span
														class="ago"><?php echo makedatetime(strtotime($rowCompany["dateAdded"])); ?></span>
												</div>


												<p class="job-descrpt">

													<?php echo getStrLength(strip_tags(stripslashes($rowCompany["jobDetails"])), 220); ?>


												</p>
												<a href="<?php echo $fullurl; ?>view-job.html?id=<?php echo encodeStr($rowCompany['id']); ?>"
													class="applyjob-btn">View Details</a>
											</div>

										</li>
										<?php
									}

									?>

								</ul>
								<div style="margin-top:20px; text-align:left;">
									<div class="pagingnumbers"><?php echo $paging; ?></div>
								</div>
							<?php } else { ?>
								<div style="padding:20px; text-align:center;overflow: hidden;">No Jobs Found.</div>
							<?php } ?>
						</div>
						<div class="refine-search">

							<div class="job-search result">
								<h2>Refine Search</h2>
								<form class="job-search-form" name="frmjobsearch" id="frmjobsearch" method="get"
									action="<?php echo $fullurl; ?>search-job.html">
									<div class="keyword">
										<input type="text" name="txtKeywords" id="txtKeywords" placeholder=" Keywords"
											value="<?php echo htmlspecialchars($jobtitlefld, ENT_QUOTES, 'UTF-8'); ?>">
									</div>
									<div class="location">
										<input type="text" name="jobLocation" id="jobLocation" placeholder="Location"
											value="<?php echo htmlspecialchars($fulljoblocation, ENT_QUOTES, 'UTF-8'); ?>">
									</div>



									<div class="career-level">
										<select name="levelId" id="levelId">
											<option value=""> Career level</option>
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
													<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>><?php echo trim($rowOptions1['optionName']); ?>
													</option>
													<?php
												}
											}
											?>
										</select>
									</div>
									<div class="industry">

										<select name="industry" id="industry">
											<option value="">Industry</option>
											<?php
											$selectFields = [];
											$whereFields = [];
											$whereVals = [];

											$sqlOptions1 = "";
											$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry' ";
											$resOptions1 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
											if ($resOptions1) {
												while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
													if ($industry == $rowOptions1['id']) {
														$strSelected = 'selected="selected"';
													} else {
														$strSelected = "";
													}
													?>
													<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>><?php echo trim($rowOptions1['optionName']); ?>
													</option>
													<?php
												}
											}
											?>
										</select>
									</div>
									<div class="industry">
										<select name="jobConsultant" id="jobConsultant">
											<option>Job Post By</option>
											<option value="101" <?php if ($jobConsultant == 101) {
												echo "selected";
											} ?>>
												Select</option>
											<option value="0" <?php if ($jobConsultant == 0) {
												echo "selected";
											} ?>>Company
											</option>
											<option value="1" <?php if ($jobConsultant == 1) {
												echo "selected";
											} ?>>
												Consultant</option>
										</select>
									</div>
									<input type="submit" value="Search" name="btnjobsearch" id="btnjobsearch"
										class="jobsrch-btn">
									<a class="postjobbtn2" href="<?php echo $fullurl; ?>create-new-company.html"><i
											class="fa fa-upload" aria-hidden="true"></i> Recruiters - Post a Job</a>
								</form>
							</div>
							<div class="add">
								<style>
									#ads1 {
										position: absolute;
										left: 30px;
										z-index: 9;
										font-size: 22px;
										top: -100px;
										text-align: center;
										width: 80%;
									}

									#ads2 {
										position: absolute;
										left: 129px;
										height: 287px;
										bottom: -290px;
										width: 78px;
										z-index: 92;
									}

									#ads3 {
										background-color: #ffeccc;
										width: 100%;
										height: 100%;
										left: 0px;
										top: -281px;
										text-align: center;
										font-size: 22px;
										z-index: 9;
										font-size: 20px;
										position: absolute;
										border-bottom: 5px #FF9900 solid;
									}

									#ads4 {
										background-color: #fff;
										width: 100%;
										height: 100%;
										left: 0px;
										bottom: -281px;
										text-align: center;
										font-size: 22px;
										z-index: 9;
										font-size: 20px;
										position: absolute;
									}
								</style>
								<div class="advrtise">
									<div class="add">
										<div style="width:337px; height:281px; overflow:hidden; position:relative;">
											<div id="ads1"><strong>A small step</strong> can help you save money for an
												<strong>International holiday</strong>.
											</div>
											<img src="images/adhand.png" id="ads2" />
											<div id="ads3">
												<div style="padding-top:100px;"><strong>Home Loans</strong> and balance
													transfer<br />of <strong>home loans @ 8.25%*</strong> ROI <br />and
													nil processing fee.</div>
												<div style="padding-top:30px; font-size:11px;">*Offer available for
													salaried customers and <br />property to be registered</div>
											</div>

											<div id="ads4">
												<div style="padding-top:100px;">For further details</div>
												<div style="padding-top:30px; text-align:center; "><a
														class="invifrnd">Click Here</a></div>
												<div style="text-align:center; font-size:11px; margin-top:30px;"><a
														onClick="adanimation();">Replay</a></div>
											</div>

										</div>



										<script>
											function adanimation() {
												$("#ads1").animate({
													top: "100px",
												}, 800);
												$("#ads4").animate({
													bottom: "-281px",
												}, 800);

												setTimeout(function () {
													$("#ads2").animate({
														bottom: "-2px",
													}, 800);

													$("#ads1").animate({
														top: "-100px",
													}, 800);
												}, 3000);

												setTimeout(function () {
													$("#ads2").animate({
														bottom: "-290px",
													}, 1050);
												}, 3000);

												setTimeout(function () {
													$("#ads3").animate({
														top: "0px",
													}, 800);
												}, 3900);

												setTimeout(function () {
													$("#ads4").animate({
														bottom: "0px",
													}, 800);

												}, 7900);


												setTimeout(function () {
													$("#ads3").animate({
														top: "-281px",
													}, 800);
												}, 7900);



											}


											adanimation();
										</script>

										<!--<img src="<?php echo $fullurl; ?>images/rightad.PNG">-->

									</div>
								</div>
							</div>
							<div class="invite-frnd-cont">
								<img src="<?php echo $fullurl; ?>images/invite-icon.png">
								<h1>
									Invite People To Join <font color="#1a94c3"><?php echo $companNameTitle; ?></font>
								</h1>
								<div class="invite-yourfrnd">
									<a onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=invitepeople','Invite people');"
										class="invifrnd">Invite Now</a>
								</div>
							</div>



						</div>
					</div>

				</div> <!-- [End center content] -->
			</div>
		</div>
	</div>


	</div>
	</div>
	</div>
	<?php include('footer.php'); ?>
	</div>

</body>

</html>