<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
?>
<!DOCTYPE html>
<html>

<head>
	<title>Who's viewed your profile - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
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
				<div class="center_content">
					<div class="cntr_cntnt" style="background-color:#fff; border-radius:4px; ">

						<div class="all-activity bx-shadow">
							<?php
							$lasdate = date('Y-m-d', strtotime('-90 days'));
							$sqlTotal = "SELECT COUNT(*) AS total FROM " . _USER_PROFILE_VIEW_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' AND dateAdded BETWEEN '$lasdate' AND '" . date('Y-m-d') . "'";
							$resTotal = mysqli_query($conn, $sqlTotal) or die(mysqli_error($conn));
							$rowTotal = mysqli_fetch_assoc($resTotal);
							$totalprofile = $rowTotal['total'];

							?>
							<h2 style="margin-bottom:10px"><?php echo $totalprofile; ?> profile viewers in the past 90
								day's</h2>
							<?php if ($totalprofile > 0) { ?>

								<div class="graph-cont">
									<div class="graph">
										<div id="chart_div"></div>
									</div>
									<script>
										google.charts.load('current', { packages: ['corechart', 'bar'] });
										google.charts.setOnLoadCallback(drawBasic);

										function drawBasic() {

											var data = google.visualization.arrayToDataTable([
												['Months', 'Users',],
												<?php // for ($i = -2; $i <= 0; $i++){ $usera="";
													$d = date("Y-m-d", strtotime('-90 days'));
													$sql_inssac = "SELECT MONTH(dateAdded) as month, COUNT(*) as total 
														FROM " . _USER_PROFILE_VIEW_TABLE_ . " 
														WHERE userId='" . $_SESSION['sessUserId'] . "' 
														AND dateAdded BETWEEN '$lasdate' AND '" . date('Y-m-d') . "' 
														GROUP BY MONTH(dateAdded)";
													$userbcountc = mysqli_query($conn, $sql_inssac) or die(mysqli_error($conn));
													while ($rographpc = mysqli_fetch_array($userbcountc)) {
														$i = date("m", strtotime($rographpc["dateAdded"]));
														$usera = "select * from " . _USER_PROFILE_VIEW_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "'  and month(dateAdded)= '" . date('m', strtotime("$i month")) . "'  and dateAdded>='" . $d . "'  ";
														$userbcount = mysqli_query($conn, $usera) or die(mysqli_error($conn));
														$usertotalbcount = mysqli_num_rows($userbcount); ?>
													['<?php echo date('F', strtotime("$i month")); ?>', <?php echo $usertotalbcount; ?>],
												<?php } ?>

											]);


											var options = {
												title: '',
												chartArea: { width: '50%' },
												hAxis: {
													title: 'Total Users',
													minValue: 0
												},
												vAxis: {
													title: 'Months'
												}
											};

											var chart = new google.visualization.BarChart(document.getElementById('chart_div'));

											chart.draw(data, options);
										}
									</script>
									<ul class="views-listpercent">
										<?php
										$usera = "";
										$usera = "SELECT * from " . _USERS_MASTER_TABLE_ . " where userId IN (select contactId from " . _USER_PROFILE_VIEW_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "'  and dateAdded between '" . date('Y-m-d', strtotime(date('Y-m-d') . ' -90 day')) . "' and '" . date('Y-m-d') . "' ) group by industryId ";
										$resUserp = mysqli_query($conn, $usera) or die(mysqli_error($conn));
										$totalindustry = 0;
										$rowIndustry = 0;
										while ($rowUserp = mysqli_fetch_array($resUserp)) {
											$a = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE id='" . $rowUserp["industryId"] . "' ";
											$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
											$rowIndustry = mysqli_fetch_array($b);

											$a2 = "SELECT * from " . _USERS_MASTER_TABLE_ . " 
       WHERE industryId='" . $rowUserp["industryId"] . "' 
       AND userId IN (
           SELECT contactId FROM " . _USER_PROFILE_VIEW_TABLE_ . " 
           WHERE userId='" . $_SESSION['sessUserId'] . "'  
           AND dateAdded >= '" . date('Y-m-d', strtotime(date('Y-m-d') . ' -90 day')) . "'
       )";
											$b2 = mysqli_query($conn, $a2) or die(mysqli_error($conn));
											$totalindustry = mysqli_num_rows($b2);
											?>
											<li>
												<strong>
													<?php echo round($totalindustry / $totalprofile * 100); ?>%
												</strong>
												Views in
												<strong>
													<?php echo isset($rowIndustry['optionName']) ? trim($rowIndustry['optionName']) : 'N/A'; ?>
												</strong>
											</li>

											<?php
											?>
										<?php } ?>
									</ul>
								</div>
								<label class="views-label">People who viewed your profile </label>
								<ul class="comp-mmbr-list viewed">

									<?php
									$n = 0;
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];
									$lasdate = $day_before = date('Y-m-d', strtotime(date('Y-m-d') . ' -90 day'));
									$sqlUserp = "";
									$sqlUserp = "select * from " . _USER_PROFILE_VIEW_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "'  and dateAdded between '" . $lasdate . "' and '" . date('Y-m-d') . "' order by id desc ";
									$resUserp = getRecords(_USER_PROFILE_VIEW_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlUserp);
									if ($resUserp) {
										while ($rowUserp = mysqli_fetch_array($resUserp)) {
											$usera = "";
											$usera = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowUserp["contactId"] . "";
											$userb = mysqli_query($conn, $usera) or die(mysqli_error($conn));
											$userProfileView = mysqli_fetch_array($userb);


											$friendnameurl = $userProfileView['userurl'];
											if ($userProfileView["profilePhoto"] != '') {
												$userphoto = $userProfileView["profilePhoto"];
											} else {
												$userphoto = 'user-placeholder.jpg';
											}

											$mycountryName = $userProfileView["countryName"];
											$mycompanyName = $userProfileView["companyName"];
											$myjobTitle = $userProfileView["jobTitle"];

											if ($userProfileView['userId'] != '') {
												$c = "";
												$c = "SELECT id from " . _CONTACT_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " and contactId=" . $userProfileView['userId'] . "";
												$d = mysqli_query($conn, $c) or die(mysqli_error($conn));
												$aabb = mysqli_fetch_array($d);

												$requestSent = "";
												$cc = "";
												$cc = "SELECT id from " . _CONTACT_MASTER_TABLE_ . " WHERE userId= " . $userProfileView['userId'] . " and contactId=" . $_SESSION["sessUserId"] . " and status=0";
												$dd = mysqli_query($conn, $cc) or die(mysqli_error($conn));
												$requestSent = mysqli_num_rows($dd);

												?>

												<li>
													<div class="comp-mmbr viewed">
														<span class="pic" style="margin-left: 0;">
															<a
																href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userProfileView['userId']); ?>/<?php echo $friendnameurl; ?>.html">
																<img src="<?php echo $fullurl; ?>uploads/<?php echo $userphoto; ?>">
															</a>
														</span>

														<div class="mmbr-right">
															<label
																class="vw-tim"><?php echo makedatetime(strtotime($rowUserp["dateAdded"])); ?></label>
															<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userProfileView['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																class="nm">
																<?php echo stripslashes(trim($userProfileView["firstName"])) . " " . stripslashes(trim($userProfileView["lastName"])); ?>
															</a>
															<span class="prfl">
																<?php echo $myjobTitle; ?>
																<?php if ($mycompanyName != '') {
																	echo " at " . $mycompanyName;
																} ?>
															</span>

															<?php if (empty($aabb['id'])) { ?>
																<?php if ($requestSent > 0) { ?>
																	<a class="add-btn" style="cursor: default;">Pending</a>
																<?php } else { ?>
																	<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userProfileView['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																		class="add-btn">
																		<i class="fa fa-plus" aria-hidden="true"></i> Add
																	</a>
																<?php } ?>
															<?php } ?>
														</div>
													</div>
												</li>
												<?php
											}

											$n++;
										}

									} else {
										?>
										<div style="text-align:center; padding:20px;">No user found.</div>
									<?php } ?>
								</ul>
							<?php } else { ?>
								<div style="padding:20px; text-align:center; font-size:12px; color:#CCCCCC;">No Profile
									Views</div>
							<?php } ?>
						</div>
					</div>
					<?php include('right-sidebar.php'); ?>
				</div>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>


</body>

</html>