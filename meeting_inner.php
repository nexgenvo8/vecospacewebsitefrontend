<?php
include_once('inc.php');
include_once('config/session-check.inc.php');
if (isset($_POST['user']) && $_REQUEST['user'] != 1) {
	?>
	<?php
	$aa = "SELECT * from " . _MEETING_MASTER_TABLE_ . " where chatId='" . $_REQUEST['id'] . "' and userId='" . ($_SESSION['sessUserId']) . "'  ";
	$res5 = mysqli_query($conn, $aa);
	$getdata = mysqli_fetch_array($res5);

	?>
	<div style="cursor:pointer;" class="contact-share"
		onClick="sharefuncommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?chatuserid=<?php echo $_GET['chatuserid']; ?>&time=<?php echo $getdata['meetingDateTime']; ?>&type=meetingdetail&mymeeting=1','Meeting Request','<?php echo encodeStr($getdata['id']); ?>');">
		<div class="meet-left">
			<span>Meeting</span>
			<label class="mttitle"><?php echo stripslashes($getdata["title"]); ?></label>
			<time><?php echo date("D j M, g:i a", $getdata['meetingDateTime']); ?></time>


		</div>
		<div class="meet-right">
			<?php if ($getdata['meetingDateTime'] < time()) { ?>
				<label class="tag closed">Closed</label>
			<?php } else { ?>
				<label class="tag">Open</label>
			<?php } ?>
			<div class="calicon"></div>
		</div>


	</div>
	<?php
} else {
	?>
	<?php
	$aa = "SELECT * from " . _MEETING_MASTER_TABLE_ . " where chatId='" . $_REQUEST['id'] . "' and userId='" . ($_SESSION['sessUserId']) . "'  ";
	$res5 = mysqli_query($conn, $aa);
	$getdata = mysqli_fetch_array($res5);

	?>
	<div class="contact-share">
		<div style="cursor:pointer;"
			onClick="sharefuncommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?chatuserid=<?php echo encodeStr($_SESSION['sessUserId']); ?>&time=<?php echo $getdata['meetingDateTime']; ?>&type=meetingdetail&mymeeting=2','Meeting Request','<?php echo encodeStr($getdata['id']); ?>');">
			<div class="meet-left">
				<span>Meeting</span>
				<label class="mttitle"><?php echo stripslashes($getdata["title"]); ?></label>
				<time><?php echo date("D j M, g:i a", $getdata['meetingDateTime']); ?></time>


			</div>
			<div class="meet-right">
				<?php if ($getdata['meetingDateTime'] < time()) { ?>
					<label class="tag closed">Closed</label>
				<?php } else { ?>
					<label class="tag">Open</label>
				<?php } ?>
				<div class="calicon"></div>
			</div>
		</div>
		<?php if ($getdata['meetingDateTime'] > time()) { ?>
			<div class="ruatending" id="<?php echo $_REQUEST['id']; ?>">

				<?php if ($getdata['status'] == 0) { ?>
					<span>Are you attending</span>
					<?php
				}
				?>

				<?php if ($getdata['status'] == 1) { ?>
					<span>Yes i am attending</span>
					<?php
				}
				?>

				<?php if ($getdata['status'] == 2) { ?>
					<span>Maybe i am attending</span>
					<?php
				}
				?>

				<?php if ($getdata['status'] == 3) { ?>
					<span>I am not attending</span>
					<?php
				}
				?>

				<ul>
					<li><a class="yes<?php if ($getdata['status'] == 1) { ?> active<?php } ?>"
							onClick="meetingattend(<?php echo $_REQUEST['id']; ?>,<?php echo $_SESSION['sessUserId']; ?>,1);">Yes</a>
					</li>
					<li><a class="no<?php if ($getdata['status'] == 3) { ?> active<?php } ?>"
							onClick="meetingattend(<?php echo $_REQUEST['id']; ?>,<?php echo $_SESSION['sessUserId']; ?>,3);">No</a>
					</li>
					<li><a class="maybe<?php if ($getdata['status'] == 2) { ?> active<?php } ?>"
							onClick="meetingattend(<?php echo $_REQUEST['id']; ?>,<?php echo $_SESSION['sessUserId']; ?>,2);">Maybe</a>
					</li>
				</ul>
			</div>
		<?php } ?>
	</div>
	<?php
}

?>