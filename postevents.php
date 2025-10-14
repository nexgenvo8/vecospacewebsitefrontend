<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
include('mail.php');
$pageIndex = 10;

//echo $_SERVER['HTTP_REFERER'];

if (
	isset($_POST['eventName']) && trim($_POST['eventName']) != '' &&
	isset($_POST['action']) && $_POST['action'] == 'postevent' &&
	isset($_POST['eventVerifiedStatus']) && $_POST['eventVerifiedStatus'] == 1
) {

	$eventId = clean($_POST['postId']);
	$eventType = trim($_POST['eventType']);
	$eventName = clean($_POST['eventName']);
	$eventDate = trim($_POST['eventDate']);
	$eventTillDate = trim($_POST['eventTillDate']);
	$eventVenue = trim($_POST['eventVenue']);
	$countryName = normalclean($_POST['countryName']);
	$eventBrief = clean($_POST['eventBrief']);
	$eventDuration = normalclean($_POST['eventDuration']);
	$eventDetails = clean($_POST['eventDetails']);
	$eventAgenda = normalclean($_POST['eventAgenda']);
	$starttime = trim($_POST['starttime']);
	$endtime = trim($_POST['endtime']);
	$websiteurl = trim($_POST['websiteurl']);
	$otherDetails = normalclean($_POST['otherDetails']);
	$eventVerifiedStatus = normalclean($_POST['eventVerifiedStatus']);

	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);

	$insertFields[0] = "userId";
	$insertFields[1] = "eventName";
	$insertFields[2] = "eventDate";
	$insertFields[3] = "eventTillDate";
	$insertFields[4] = "dateAdded";
	$insertFields[5] = "eventVenue";
	$insertFields[6] = "eventCountryAddress";
	$insertFields[7] = "eventBrief";
	$insertFields[8] = "eventDuration";
	$insertFields[9] = "eventDetails";
	$insertFields[10] = "eventAgenda";
	$insertFields[11] = "starttime";
	$insertFields[12] = "endtime";
	$insertFields[13] = "websiteurl";
	$insertFields[14] = "otherDetails";
	$insertFields[15] = "eventType";
	$insertFields[16] = "eventVerifiedStatus";
	$insertFields[17] = "eventStatus";

	$insertVals[0] = $_SESSION["sessUserId"];
	$insertVals[1] = $eventName;
	$insertVals[2] = $eventDate;
	$insertVals[3] = $eventTillDate;
	$insertVals[4] = time();
	$insertVals[5] = $eventVenue;
	$insertVals[6] = $countryName;
	$insertVals[7] = $eventBrief;
	$insertVals[8] = $eventDuration;
	$insertVals[9] = $eventDetails;
	$insertVals[10] = $eventAgenda;
	$insertVals[11] = $starttime;
	$insertVals[12] = $endtime;
	$insertVals[13] = $websiteurl;
	$insertVals[14] = $otherDetails;
	$insertVals[15] = $eventType;
	$insertVals[16] = $eventVerifiedStatus;
	$insertVals[17] = 0;

	$whereFields[0] = "id";
	$whereFields[1] = "userId";

	$whereVals[0] = $eventId;
	$whereVals[1] = $_SESSION['sessUserId'];

	$resUpdate = updateDB(_EVENT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$aa = "SELECT id FROM " . _TIMELINE_MASTER_TABLE_ . " WHERE postId= " . intval($eventId) . " AND postType=5 AND userId=" . intval($_SESSION["sessUserId"]);
	$res5 = mysqli_query($conn, $aa) or die(mysqli_error($conn));
	$getTotal = mysqli_num_rows($res5);

	if ($getTotal > 0) {
		// do something if records found
	} else {
		unset($insertFields);
		unset($insertVals);

		$insertFields[0] = "userId";
		$insertFields[1] = "postId";
		$insertFields[2] = "postType";
		$insertFields[3] = "shareType";
		$insertFields[4] = "dateAdded";

		$insertVals[0] = intval($_SESSION["sessUserId"]);
		$insertVals[1] = intval($eventId);
		$insertVals[2] = 5; // postType
		$insertVals[3] = 1; // shareType
		$insertVals[4] = time();

		$resUpdate = insertDB(_TIMELINE_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		$mailBodyContent = $myname . ' created an Event <strong>' . $eventName . '</strong> - ' . date("H:i:s - d/m/Y");

		$subject = $myname . ' (' . $myemail . ') created an Event';

		adminnotification($subject, $mailBodyContent);
	}


	$poe = 1;
	$_SESSION["poe"] = 1;
	$_SESSION["s"] = 1;


	header('Location:my-events.html');
	exit();

}

if (isset($_REQUEST['eventId']) && $_REQUEST['eventId'] != '') {
	$sqlEvents = "SELECT * FROM " . _EVENT_MASTER_TABLE_ . " WHERE id= " . intval(decodeStr($_REQUEST['eventId']));
	$resEvents = mysqli_query($conn, $sqlEvents) or die(mysqli_error($conn));
	$rowEvents = mysqli_fetch_array($resEvents);

	$createdby = $rowEvents['userId'];
	if ($createdby != $_SESSION["sessUserId"]) {
		header('Location:events.html');
		exit();
	}
	if ($rowEvents['eventName'] == '') {
		header('Location:events.html');
		exit();
	}

	$postId = trim($rowEvents['id']);
	$eventType = $rowEvents['eventType'];
	$eventName = stripslashes($rowEvents['eventName']);
	$eventDate = trim($rowEvents['eventDate']);
	$eventTillDate = trim($rowEvents['eventTillDate']);
	$eventVenue = trim($rowEvents['eventVenue']);
	$countryName = stripslashes($rowEvents['eventCountryAddress']);
	$eventBrief = stripslashes($rowEvents['eventBrief']);
	$eventDuration = stripslashes($rowEvents['eventDuration']);
	$eventDetails = stripslashes($rowEvents['eventDetails']);
	$eventAgenda = stripslashes($rowEvents['eventAgenda']);
	$starttime = stripslashes($rowEvents['starttime']);
	$endtime = stripslashes($rowEvents['endtime']);
	$websiteurl = trim($rowEvents['websiteurl']);
	$otherDetails = stripslashes($rowEvents['otherDetails']);
	$eventVerifiedStatus = trim($rowEvents['eventVerifiedStatus']);
	$eventStatus = trim($rowEvents['eventStatus']);
	$btnname = 'Save Your Event';
} else {
	$sql_ins = "DELETE FROM " . _EVENT_MASTER_TABLE_ . " WHERE userId= " . intval($_SESSION["sessUserId"]) . " AND eventName=''";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "INSERT INTO " . _EVENT_MASTER_TABLE_ . " SET userId= " . intval($_SESSION["sessUserId"]);
	$resresult2 = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_inss = "SELECT id FROM " . _EVENT_MASTER_TABLE_ . " WHERE userId= " . intval($_SESSION["sessUserId"]) . " AND eventName=''";
	$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
	$rowResults = mysqli_fetch_array($resresults);

	$postId = $rowResults["id"];
	$btnname = 'Post Your Event';
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Events - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/default.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/zebra_datepicker.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<script>
		$(document).ready(function () {

			$('#eventDate').Zebra_DatePicker({

				format: 'Y-m-d',

				// direction: [1, 400]

			});



			$('#eventTillDate').Zebra_DatePicker({

				format: 'Y-m-d',

				// direction: [1, 400]

			});
		});

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
				<div class="center_content">
					<div class="evnts post">
						<div class="post-evnt">
							<?php if (isset($_REQUEST['eventId']) && $_REQUEST['eventId'] != '') { ?>
								<h2>Edit Event</h2>
							<?php } else { ?>
								<h2>Post New Event</h2>
							<?php } ?>



							<form name="frmpostevnt" id="frmpostevnt" method="post" enctype="multipart/form-data">
								<label>Event name<span class="reqstar">*</span></label>
								<input type="text" name="eventName" id="eventName"
									value="<?php echo isset($eventName) ? $eventName : ''; ?>" maxlength="150"
									class="validate">

								<div class="evnt-left-fld">
									<label>Event start date/time<span class="reqstar">*</span></label>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td style="padding-right:5px;">
												<input type="text" name="eventDate" id="eventDate"
													value="<?php echo isset($eventDate) ? $eventDate : ''; ?>"
													class="validate cal-icon" onClick="hideerrordiv(this.id);">
											</td>
											<td>
												<select id="starttime" name="starttime" class="validate"
													onChange="hideerrordiv(this.id);">
													<option value="">Select time</option>
													<?php
													$start = strtotime('00:00');
													$end = strtotime('23:30');
													for ($i = $start; $i <= $end; $i += 15 * 60) {
														$strtTimeSelected = (isset($starttime) && $starttime == date('g:i A', $i)) ? 'selected="selected"' : "";
														?>
														<option value="<?php echo date('g:i A', $i); ?>" <?php echo $strtTimeSelected; ?>>
															<?php echo date('g:i A', $i); ?>
														</option>
													<?php } ?>
												</select>
											</td>
										</tr>
									</table>
								</div>

								<div class="evnt-right-fld">
									<label>Event end date/time<span class="reqstar">*</span></label>
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>
											<td style="padding-right:5px;">
												<input type="text" name="eventTillDate" id="eventTillDate"
													value="<?php echo isset($eventTillDate) ? $eventTillDate : ''; ?>"
													class="validate cal-icon" onClick="hideerrordiv(this.id);">
											</td>
											<td>
												<select id="endtime" name="endtime" class="validate"
													onChange="hideerrordiv(this.id);">
													<option value="">Select time</option>
													<?php
													for ($i = $start; $i <= $end; $i += 15 * 60) {
														$endTimeSelected = (isset($endtime) && $endtime == date('g:i A', $i)) ? 'selected="selected"' : "";
														?>
														<option value="<?php echo date('g:i A', $i); ?>" <?php echo $endTimeSelected; ?>>
															<?php echo date('g:i A', $i); ?>
														</option>
													<?php } ?>
												</select>
											</td>
										</tr>
									</table>
								</div>

								<label>Event Type<span class="reqstar">*</span></label>
								<select name="eventType" id="eventType" onChange="hideerrordiv(this.id);">
									<option value="Ticketed" <?php echo (isset($eventType) && $eventType == 'Ticketed') ? 'selected' : ''; ?>>Ticketed</option>
									<option value="From" <?php echo (isset($eventType) && $eventType == 'From') ? 'selected' : ''; ?>>From</option>
									<option value="By invite" <?php echo (isset($eventType) && $eventType == 'By invite') ? 'selected' : ''; ?>>By invite</option>
								</select>

								<label>Event venue</label>
								<textarea rows="3" name="eventVenue"
									id="eventVenue"><?php echo isset($eventVenue) ? $eventVenue : ''; ?></textarea>

								<div class="evnt-left-fld">
									<label>Country<span class="reqstar">*</span></label>
									<select name="countryName" id="countryName" class="validate"
										onChange="hideerrordiv(this.id);">
										<option value="">Select</option>
										<?php
										unset($selectFields);
										unset($whereFields);
										unset($whereVals);

										$sqlOptions1 = "SELECT country_name FROM " . _COUNTRIES_TABLE_ . " ORDER BY country_name";
										$resOptions1 = mysqli_query($conn, $sqlOptions1) or die(mysqli_error($conn));

										if ($resOptions1) {
											while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
												$strSelected = (isset($countryName) && $countryName == $rowOptions1['country_name']) ? 'selected="selected"' : "";
												?>
												<option value="<?php echo trim($rowOptions1['country_name']); ?>" <?php echo $strSelected; ?>>
													<?php echo trim($rowOptions1['country_name']); ?>
												</option>
												<?php
											}
										}
										?>
									</select>
								</div>

								<div class="evnt-right-fld">
									<label>Duration of the event<span class="reqstar">*</span></label>
									<select name="eventDuration" id="eventDuration"
										onChange="changedurationfun();hideerrordiv(this.id);">
										<option value="full" <?php echo (isset($eventDuration) && $eventDuration == 'full') ? 'selected' : ''; ?>>Full day event</option>
										<option value="half" <?php echo (isset($eventDuration) && $eventDuration == 'half') ? 'selected' : ''; ?>>Half Day Event</option>
										<option value="other" <?php echo (isset($eventDuration) && $eventDuration == 'other') ? 'selected' : ''; ?>>Other</option>
									</select>
								</div>

								<div id="otherdetailsdiv"
									style="display:<?php echo (isset($eventDuration) && $eventDuration == 'other') ? 'block' : 'none'; ?>;">
									<label>Other</label>
									<input type="text" name="otherDetails" id="otherDetails"
										value="<?php echo isset($otherDetails) ? $otherDetails : ''; ?>"
										maxlength="150">
								</div>

								<label>Brief profile of the event</label>
								<textarea rows="4" name="eventBrief"
									id="eventBrief"><?php echo isset($eventBrief) ? $eventBrief : ''; ?></textarea>

								<label>Details about the event<span class="reqstar">*</span></label>
								<textarea rows="4" name="eventDetails"
									id="eventDetails"><?php echo isset($eventDetails) ? $eventDetails : ''; ?></textarea>

								<label>Agenda of the event</label>
								<textarea rows="5" name="eventAgenda"
									id="eventAgenda"><?php echo isset($eventAgenda) ? $eventAgenda : ''; ?></textarea>

								<label>Event website url</label>
								<input type="text" name="websiteurl" id="websiteurl"
									value="<?php echo isset($websiteurl) ? $websiteurl : ''; ?>" maxlength="150">

								<label>Photographs from the past events</label>

								<input type="hidden" id="action" name="action" value="postevent">
								<input type="hidden" id="postId" name="postId"
									value="<?php echo isset($postId) ? $postId : ''; ?>">

								<div class="uploadimg" id="imagebx" style="width:100%;"></div>

								<script>
									$("#imagebx").load('<?php echo $fullurl; ?>upload_photo_event.php?eventId=<?php echo isset($postId) ? $postId : ''; ?>');
								</script>

								<label style="margin-top:10px;" class="trms">
									<input type="checkbox" name="eventVerifiedStatus" id="eventVerifiedStatus"
										class="validate" value="1" checked="checked" onClick="return false;">
									I confirm that I am authorized to Post this event on <?php echo $companNameTitle; ?>
									and if any image is used, I have the rights to use the image.
								</label>
							</form>

							<div class="pst-evnt-btns">
								<button type="button" name="btnsubmit" class="bck"
									onClick="javascript: window.location.href='<?php echo $_SERVER['HTTP_REFERER']; ?>';"
									style=" background-color: #eee; color: #000; margin-right:10px;">Cancel</button>

								<button type="button" name="btnsubmit"
									onClick="formValidation('frmpostevnt');"><?php echo $btnname; ?></button>

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

		function changedurationfun() {
			var eventDuration = $("#eventDuration").val();
			if (eventDuration == 'other') {
				$("#otherdetailsdiv").show();
			}
			else {
				$("#otherdetailsdiv").hide();
			}

		}
	</script>
</body>

</html>