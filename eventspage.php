<?php
include_once('inc.php');
$pageIndex = 10;
?>
<!DOCTYPE html>
<html>

<head>
	<title>Events - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<style>
		button.srch {
			background-color: #f4bc2d;
			border: 0;
			padding: 11px;
			color: #fff;
			float: left;
			border-radius: 0 4px 4px 0;
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
				<div class="center_content <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
				} else {
					echo 'nologin';
				} ?>">
					<div class="evnts">
						<ul class="cntr_tab">
							<li><a class="active">All Events</a></li>
							<?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
								<li><a href="<?php echo $fullurl; ?>my-events.html">My Events</a></li><?php } ?>
							<li class="evnt-crt-btn"><a href="<?php echo $fullurl; ?>post-events.html">+ Post an
									event</a></li>
						</ul>
						<div class="evnt-bnnr">

							<label>&nbsp;</label>
							<div class="serch-evnt">
								<?php include('searcheventsfrm.inc.php'); ?>
							</div>



						</div>
						<div class="featurd-evnt-cont" style="padding-bottom:0px;">
							<div class="featurd-evnt" style="padding:0px;">
								<h3 style="padding:12px; margin-bottom:0px;">Featured Events</h3>
								<ul class="evnts-list">
									<?php
									$n = 0;

									// Define missing variables to avoid warnings
									$strWhereEvent = isset($strWhereEvent) ? $strWhereEvent : "";
									$selectFields = isset($selectFields) ? $selectFields : [];
									$whereFields = isset($whereFields) ? $whereFields : [];
									$whereVals = isset($whereVals) ? $whereVals : [];

									$sqlEvents = "SELECT * FROM " . _EVENT_MASTER_TABLE_ . " 
	              WHERE eventName != '' AND eventStatus = 1 " . $strWhereEvent . " 
	              ORDER BY RAND() DESC 
	              LIMIT 0,2";

									// Replace getRecords() with mysqli_query
									$resEvents = mysqli_query($conn, $sqlEvents);

									if ($resEvents && mysqli_num_rows($resEvents) > 0) {
										while ($rowEvents = mysqli_fetch_assoc($resEvents)) {

											$a = "SELECT id, imageName FROM " . _EVENT_IMAGE_MASTER_TABLE_ . " WHERE eventId = " . intval($rowEvents["id"]);
											$imgrows = mysqli_query($conn, $a);
											$rowName = ($imgrows && mysqli_num_rows($imgrows) > 0) ? mysqli_fetch_assoc($imgrows) : null;

											if (!empty($rowName['imageName'])) {
												$eventphoto = $rowName['imageName'];
											} else {
												$eventphoto = 'events-placeholder.jpg';
											}
											?>
											<li style="margin-bottom:10px;">
												<a href="<?php echo $fullurl; ?>events-detail.html?eventId=<?php echo encodeStr($rowEvents['id']); ?>"
													class="block">
													<div class="evnt_box" style="border-bottom:10px; margin-top:10px;">
														<div class="evnt-img">
															<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($eventphoto)); ?>"
																title="<?php echo stripslashes($rowEvents["eventName"]); ?>"
																alt="<?php echo stripslashes(trim($rowEvents["eventName"])); ?>">
														</div>
														<div class="evnt-dtail">
															<span
																class="ttl"><?php echo stripslashes($rowEvents["eventName"]); ?></span>
															<span class="evnt-dration">
																<?php
																$strstrtdate = strtotime($rowEvents["eventDate"]);
																echo date("D, j M Y", $strstrtdate);
																?> -
																<?php
																$strenddate = strtotime($rowEvents["eventTillDate"]);
																echo date("D, j M Y", $strenddate);
																?>
															</span>
															<span
																class="locat"><?php echo stripslashes($rowEvents["eventCountryAddress"]); ?></span>
														</div>
													</div>
												</a>
											</li>
											<?php
											$n++;
										}
									}
									?>
								</ul>

							</div>
						</div>
						<div class="evnt-list-cont">
							<ul class="cntr_tab">
								<li><a class="active" href="events.html">Recommendations</a></li>
								<?php if (isset($_SESSION["sessUserId"]) && $_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
									<li><a href="contact-events.html">Your contacts' events</a></li>
								<?php } ?>
							</ul>

							<ul class="evnts-list">
								<?php
								$n = 0;

								// Fix: Define variables if not set
								$strWhereEvent = isset($strWhereEvent) ? $strWhereEvent : "";
								$selectFields = isset($selectFields) ? $selectFields : [];
								$whereFields = isset($whereFields) ? $whereFields : [];
								$whereVals = isset($whereVals) ? $whereVals : [];

								$sqlEvents = "SELECT * FROM " . _EVENT_MASTER_TABLE_ . " 
                      WHERE eventName != '' AND eventStatus = 1 " . $strWhereEvent . " 
                      ORDER BY id DESC 
                      LIMIT 0,16";

								$resEvents = mysqli_query($conn, $sqlEvents);

								if ($resEvents && mysqli_num_rows($resEvents) > 0) {
									while ($rowEvents = mysqli_fetch_assoc($resEvents)) {

										$eventphoto = (!empty($rowEvents["eventThumb"]))
											? $rowEvents["eventThumb"]
											: 'events-placeholder.jpg';
										?>
										<li>
											<a href="<?php echo $fullurl; ?>events-detail.html?eventId=<?php echo encodeStr($rowEvents['id']); ?>"
												class="block">
												<div class="evnt_box">
													<div class="evnt-img">
														<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($eventphoto)); ?>"
															title="<?php echo stripslashes($rowEvents["eventName"]); ?>"
															alt="<?php echo stripslashes(trim($rowEvents["eventName"])); ?>">
													</div>
													<div class="evnt-dtail">
														<span
															class="ttl"><?php echo stripslashes($rowEvents["eventName"]); ?></span>
														<span class="evnt-dration">
															<?php
															$strstrtdate = strtotime($rowEvents["eventDate"]);
															echo date("D, j M Y", $strstrtdate);
															?> -
															<?php
															$strenddate = strtotime($rowEvents["eventTillDate"]);
															echo date("D, j M Y", $strenddate);
															?>
														</span>
														<span
															class="locat"><?php echo stripslashes($rowEvents["eventCountryAddress"]); ?></span>
													</div>
												</div>
											</a>
										</li>
										<?php
										$n++;
									}
								}
								?>
							</ul>

							<?php if ($n == 0) { ?>
								<div style="padding:20px; text-align:center;overflow: hidden;">
									There is no event currently to display.
								</div>
							<?php } ?>
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