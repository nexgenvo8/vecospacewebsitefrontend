<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
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
				<div class="center_content">
					<div class="evnts">
						<ul class="cntr_tab">
							<li><a class="active">All Events</a></li>
							<li><a href="<?php echo $fullurl; ?>my-events.html">My Events</a></li>
							<li class="evnt-crt-btn"><a href="<?php echo $fullurl; ?>post-events.html">+ Post an
									event</a></li>
						</ul>
						<div class="evnt-bnnr" style="background-image: url(images/eventsbanner.jpg);">
							<h1>Post an event or search for great events around the world</h1>
							<label>&nbsp;</label>
							<div class="serch-evnt" style="margin-top: 20px;">
								<?php include('searcheventsfrm.inc.php'); ?>
							</div>
						</div>

						<div class="evnt-list-cont">
							<ul class="cntr_tab">
								<li><a href="events.html">Recommendations</a></li>
								<li><a href="contact-events.html" class="active">Your contacts' events</a></li>
							</ul>
							<ul class="evnts-list">
								<?php
								$n = 0;

								// mysqli connection assumed as $conn
								
								$sqlEvents = "SELECT * FROM " . _EVENT_MASTER_TABLE_ . " 
								WHERE eventName != '' 
								AND eventStatus = 1 
								AND id IN (
									SELECT id FROM " . _EVENT_MASTER_TABLE_ . " 
									WHERE userId IN (
										SELECT contactId FROM " . _CONTACT_MASTER_TABLE_ . " 
										WHERE userId = " . intval($_SESSION["sessUserId"]) . "
									)
								) 
								ORDER BY RAND() DESC 
								LIMIT 0,16";

								$resEvents = mysqli_query($conn, $sqlEvents);

								if ($resEvents && mysqli_num_rows($resEvents) > 0) {
									while ($rowEvents = mysqli_fetch_assoc($resEvents)) {

										if (!empty($rowEvents["eventThumb"])) {
											$eventphoto = $rowEvents["eventThumb"];
										} else {
											$eventphoto = 'events-placeholder.jpg';
										}
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
								<div style="padding:20px; text-align:center; float:left; width:100%;">There is no event
									currently to display.</div>
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