<?php
include_once('inc.php');
$pageIndex = 14;

?>
<!DOCTYPE html>
<html>

<head>
	<title>Talent - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<style type="text/css">
		li.evnt-crt-btn.smbcls {
			display: none;
		}
	</style>

	<link href="css/style.css" rel="stylesheet" type="text/css">
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
					<div class="bx-shadow">
						<div class="jobs-cont" style="background-color: #fff;">
							<div class="jobs-bnnr">
								<div class="jobbnnr-cap">
									<!--<h1>Jobs Oportunities on <?php echo $companNameTitle; ?></h1>
	<h2 style="font-size: 18px;">Jobs on <?php echo $companNameTitle; ?> aims to help job seekers in finding the right career opportunity and the recruiters get in direct contact with the prospective candidates.</h2>-->
								</div>
							</div>
							<div class="job-search" style="display: none;">
								<form class="job-search-form" name="frmjobsearch" id="frmjobsearch" method="get"
									action="<?php echo $fullurl; ?>search-job.html">
									<div class="keyword">
										<label>Keywords</label>
										<input type="text" name="txtKeywords" id="txtKeywords"
											placeholder="Type keywords" value="<?php echo $txtKeywords; ?>">
									</div>

									<div class="location" style="width:204px;">
										<label>Location</label>
										<input type="text" name="jobLocation" id="jobLocation"
											placeholder="Type location" value="<?php echo $fulljoblocation; ?>">
									</div>
									<div class="career-level" style="width: 160px;">
										<label>Career Level</label>
										<select name="levelId" id="levelId">
											<option value="">Select career level</option>
											<?php
											unset($selectFields);
											unset($whereFields);
											unset($whereVals);

											// MySQLi query
											$sqlOptions1 = "SELECT id, optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='careerlevel'";
											$resOptions1 = mysqli_query($conn, $sqlOptions1);

											if ($resOptions1) {
												while ($rowOptions1 = mysqli_fetch_assoc($resOptions1)) {
													$strSelected = (isset($levelId) && $levelId == $rowOptions1['id']) ? 'selected="selected"' : "";
													?>
													<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>>
														<?php echo trim($rowOptions1['optionName']); ?>
													</option>
													<?php
												}
											} else {
												echo "<option value=''>Error loading career levels</option>";
												// For debugging:
												// echo mysqli_error($conn);
											}
											?>
										</select>
									</div>

									<div class="industry" style="width:106px;">
										<label>Select Industry</label>
										<select name="industry" id="industry">
											<option value="">Select</option>
											<?php
											unset($selectFields);
											unset($whereFields);
											unset($whereVals);

											// MySQLi query
											$sqlOptions1 = "SELECT id, optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry'";
											$resOptions1 = mysqli_query($conn, $sqlOptions1);

											if ($resOptions1) {
												while ($rowOptions1 = mysqli_fetch_assoc($resOptions1)) {
													$strSelected = (isset($companyTypeId) && $companyTypeId == $rowOptions1['id']) ? 'selected="selected"' : "";
													?>
													<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>>
														<?php echo trim($rowOptions1['optionName']); ?>
													</option>
													<?php
												}
											} else {
												echo "<option value=''>Error loading industries</option>";
												// For debugging:
												// echo mysqli_error($conn);
											}
											?>
										</select>
									</div>

									<div class="industry" style="width:106px;">
										<label>Job Post By</label>
										<select name="jobConsultant" id="jobConsultant">
											<option value="101">Select</option>
											<option value="0">Company</option>
											<option value="1">Consultant</option>

										</select>
									</div>
									<input type="submit" value="Search" name="btnjobsearch" id="btnjobsearch"
										class="jobsrch-btn">
								</form>
							</div>
							<h2 style="text-align:left;">How It Works</h2>
							<ul class="howwork-list" style="text-align:left;">
								<li style="text-align:left;">
									<p style="text-align:left;">Searching for Job opportunities through
										<?php echo $companNameTitle; ?> is a first in its own setup to redesign the way
										job market shall be looked upon and catch hold of the best for oneself.
									</p>
								</li>
								<li>
									<p style="text-align:left;">Using this feature of NDIM VECOSPACE students will have
										ample opportunities for themselves to look for a job position and offer
										available on the portal.</p>
								</li>
								<li>
									<p style="text-align:left;">A well laid out page for Job description along with a
										Company profile and Contact Details such as -: Contact Person Name, Address,
										Contact No. and Email Address will be available regarding a given job position
										and offer.</p>

									<?php

									if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {

										$sqlCompany1 = "";
										$sqlCompany1 = "SELECT * FROM " . _COMPANY_MASTER_TABLE_ . " 
										WHERE companyName != '' 
										AND userId = " . intval($_SESSION["sessUserId"]);

										$resCompany1 = mysqli_query($conn, $sqlCompany1);

										if (!$resCompany1) {
											die("MySQLi Error: " . mysqli_error($conn));
										}

										$companyrows = mysqli_num_rows($resCompany1);
										$rowCompany1 = mysqli_fetch_assoc($resCompany1);

										?>
										<div style="margin-top:30px;margin-bottom: 10px; text-align:center; ">
											<?php if ($companyrows > 1) { ?><a class="postjobbtn2"
													onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=jobcompanies&id=0','Companies');">
													<i class="fa fa-upload" aria-hidden="true"></i> Recruiters - Post a Job
												</a><?php }
											if ($companyrows == 1) { ?><a class="postjobbtn2"
													href="<?php echo $fullurl; ?>add-job.html?companyId=<?php echo encodeStr($rowCompany1["id"]); ?>">
													<i class="fa fa-upload" aria-hidden="true"></i> Recruiters - Post a Job
												</a><?php } ?><?php if ($companyrows < 1) { ?><a class="postjobbtn2"
													href="<?php echo $fullurl; ?>create-new-company.html"><i
														class="fa fa-upload" aria-hidden="true"></i> Recruiters - Post a
													Job</a><?php } ?>
													
													<a href="<?php echo $fullurl; ?>add-job.html?type=market" 
													class="postjobbtn2"
													style="background-color:#28a745;">
													<i class="fa fa-briefcase"></i> Post Market Jobs
													</a>
													
											<a href="<?php echo $fullurl; ?>search-job.html" class="postjobbtn2"
												style="background-color: #00a0af;"> <i class="fa fa-search"
													aria-hidden="true" style="color: #00a0af;"></i> Search Jobs</a>
										</div>

									<?php } ?>
								</li>
							</ul>
							<h2 style="text-align: center;border-top:solid 1px #e7e7e7;margin-bottom: 0;">Jobs By Career
								Levels</h2>
							<ul class="career-level-list">
								<?php
								unset($selectFields);
								unset($whereFields);
								unset($whereVals);

								// MySQLi query
								$sqlOptions1 = "SELECT id, optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='careerlevel'";
								$resOptions1 = mysqli_query($conn, $sqlOptions1);

								if ($resOptions1) {
									while ($rowOptions1 = mysqli_fetch_assoc($resOptions1)) {
										?>
										<li>
											<div class="career-box">
												<a
													href="<?php echo $fullurl; ?>search-job.html?levelId=<?php echo trim($rowOptions1['id']); ?>">
													<div class="level-img" style="background-image:url(images/<?php
													$id = $rowOptions1['id'];
													if ($id == 98)
														echo 'students.jpg';
													elseif ($id == 99)
														echo 'entry-level.jpg';
													elseif ($id == 100)
														echo 'profational.jpg';
													elseif ($id == 101)
														echo 'manager.jpg';
													elseif ($id == 102)
														echo 'executive.jpg';
													elseif ($id == 103)
														echo 'senior-Executive.jpg';
													?>);">
														<h4><?php echo trim($rowOptions1['optionName']); ?></h4>
													</div>
												</a>
												<div class="view-all">
													<a
														href="<?php echo $fullurl; ?>search-job.html?levelId=<?php echo trim($rowOptions1['id']); ?>">
														View all <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
													</a>
												</div>
											</div>
										</li>
										<?php
									}
								} else {
									echo "<li>Error loading career levels</li>";
									// For debugging:
									// echo mysqli_error($conn);
								}
								?>
							</ul>

							<h2 style="text-align: center;border-top:solid 1px #e7e7e7;">Most Popular Categories </h2>
							<ul class="popular-joblist">
								<?php
								unset($selectFields);
								unset($whereFields);
								unset($whereVals);

								// MySQLi query
								$sqlOptions1 = "SELECT id, optionName FROM " . _OPTION_MASTER_TABLE_ . " 
                    WHERE optionType='industry' ORDER BY RAND() ASC LIMIT 0,18";
								$resOptions1 = mysqli_query($conn, $sqlOptions1);

								if ($resOptions1) {
									while ($rowOptions1 = mysqli_fetch_assoc($resOptions1)) {
										?>
										<li>
											<a
												href="<?php echo $fullurl; ?>search-job.html?industry=<?php echo trim($rowOptions1['id']); ?>">
												<?php echo trim($rowOptions1['optionName']); ?>
											</a>
										</li>
										<?php
									}
								} else {
									echo "<li>Error loading industries</li>";
									// For debugging:
									// echo mysqli_error($conn);
								}
								?>
							</ul>

							<h2 style="text-align: center;border-top:solid 1px #e7e7e7;margin-bottom: 0;">Featured Jobs
							</h2>
							<ul class="compny-joblist" style="border-top: 0;">

								<?php
								unset($selectFields);
								unset($whereFields);
								unset($whereVals);
								$n = 0;

								// Main jobs query
								$sqlCompany = "SELECT * FROM " . _JOBS_MASTER_TABLE_ . " 
                   WHERE status=1 AND jobStatus=1 
                   ORDER BY RAND() DESC LIMIT 0,5";
								$resCompany = mysqli_query($conn, $sqlCompany);

								if ($resCompany) {
									while ($rowCompany = mysqli_fetch_assoc($resCompany)) {
										?>
										<li>
											<div class="cmpny-jobbox">
												<a href="<?php echo $fullurl; ?>view-job.html?id=<?php echo encodeStr($rowCompany['id']); ?>"
													class="prfl-nam"><?php echo stripslashes($rowCompany["jobTitle"]); ?></a>

												<div class="cmpny-nm">
													<?php
													unset($selectFields);
													unset($whereFields);
													unset($whereVals);

													// Career level query for each job
													$sqlOptions1 = "SELECT id, optionName FROM " . _OPTION_MASTER_TABLE_ . " 
                                        WHERE id=" . intval($rowCompany["levelId"]);
													$resOptions1 = mysqli_query($conn, $sqlOptions1);

													if ($resOptions1) {
														while ($rowOptions1 = mysqli_fetch_assoc($resOptions1)) {
															echo trim($rowOptions1['optionName']);
														}
													}
													?> -
													<span class="locat">
														<i class="fa fa-map-marker" aria-hidden="true"></i>
														<?php echo stripslashes($rowCompany["jobLocation"]); ?>
													</span>
													<span class="ago">
														<?php echo makedatetime(strtotime($rowCompany["dateAdded"])); ?>
													</span>
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
								} else {
									echo "<li>No jobs found.</li>";
									// For debugging:
									// echo mysqli_error($conn);
								}
								?>
							</ul>

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
	<script>
		<?php
		if ($_SESSION["d"] == 1) {
			?>
			showerrormsg('SUCCESS', 'Job deleted successfully', '');
			<?php
			$_SESSION["d"] = '';
		}
		?>
	</script>
</body>

</html>