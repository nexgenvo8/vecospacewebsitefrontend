<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session


$aam = "SELECT * from " . _MEETING_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and notiStatus=0 and meetingDateTime<'" . time() . "' GROUP BY meetingDateTime order by id desc";
$res5m = mysqli_query(getDbConnection(), $aam);
while ($row2m = mysqli_fetch_array($res5m)) {

	$sql_ins = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $row2m["createdBy"] . "',userId='" . $_SESSION["sessUserId"] . "',postId='" . $row2m["id"] . "',postType=120,notificationText='meeting',dateAdded='" . time() . "'";
	mysqli_query(getDbConnection(), $sql_ins) or die(mysqli_error(getDbConnection()));


	$sql_ins = "update " . _MEETING_MASTER_TABLE_ . " set notiStatus=1 where userId='" . $_SESSION["sessUserId"] . "' and  id='" . $row2m["id"] . "' ";
	mysqli_query(getDbConnection(), $sql_ins) or die(mysqli_error(getDbConnection()));


}






$aa = "SELECT lastPost from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . "";
$res5 = mysqli_query(getDbConnection(), $aa);
$totalpost = mysqli_fetch_array($res5);
?>
<script>
	<?php
	if ($totalpost['lastPost'] != 0) {
		?>

		$("#newposton").show();

	<?php } ?>


	<?php if ($contactrequests > 0) { ?>

		$("#requestnotificationnumber").show();
		$("#requestnotificationnumber").text('<?php echo $contactrequests; ?>');

	<?php } else { ?>
		$("#requestnotificationnumber").hide();
	<?php } ?>

	<?php if ($notifications > 0) { ?>

		$("#notificationnumber").show();
		$("#notificationnumber").text('<?php echo $notifications; ?>');

	<?php } else { ?>
		$("#notificationnumber").hide();
	<?php } ?>

	<?php
	$sqlMessage = "";
	$sqlMessage = mysqli_query(
		getDbConnection(),
		"SELECT id, userId, contactId FROM " . _CHAT_MASTER_TABLE_ . " WHERE userId='" . intval($_SESSION['sessUserId']) . "' AND status=0 ORDER BY id DESC"
	);

	if (!$sqlMessage) {
		die("Query failed: " . mysqli_error(getDbConnection()));
	}

	$getlasttotal = mysqli_num_rows($sqlMessage);

	?>

	//$('#chatcontactload div').removeClass('active');
	<?php if ($getlasttotal > 0) {
		while ($getactivemsg = mysqli_fetch_array($sqlMessage)) {
			?>
			$('#chatlist<?php echo $getactivemsg["userId"]; ?>').addClass('active');
			<?php
			$sqlLastmsg = "SELECT userId,firstName,lastName,userurl from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $getactivemsg["contactId"] . "";
			$ressqlLastmsg = mysqli_query(getDbConnection(), $sqlLastmsg);
			$getLsatUser = mysqli_fetch_array($ressqlLastmsg);

		}
		?>

		$("#msgnotificationnumber").show();
		$("#msgnotificationnumber").text('<?php echo $getlasttotal; ?>');


		//openuserchatbox('<?php echo encodeStr($getLsatUser['userId']); ?>','<?php echo stripslashes(trim($getLsatUser["firstName"])); ?>										 	<?php echo stripslashes(trim($getLsatUser["lastName"])); ?>','<?php echo $fullurl; ?>profile/<?php echo encodeStr($getLsatUser['userId']); ?>/<?php echo $getLsatUser["userurl"]; ?>.html');


	<?php } else { ?>
		$('title').text('<?php echo $companNameTitle; ?>');
		$("#msgnotificationnumber").hide();
		$("#msgnotificationnumber").text('0');
	<?php } ?>





	<?php

	$aa2 = "SELECT * from " . _VIDEO_CALL_REQUEST_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "'";
	$res52 = mysqli_query(getDbConnection(), $aa2);
	$getuser2 = mysqli_fetch_array($res52);
	if (!empty($getuser2) && isset($getuser2['id']) && $getuser2['id'] != '') {

		?>




		<?php if ($getuser2['callStatus'] == 1) { ?>
			stopring();
			$('.chat-btns').hide();
		<?php } else { ?>
			$('.chat-btns').show();
			playring();
		<?php } ?>
		$('.vdocall-msg').show();
		$('.vdo-icon').addClass('active');




		<?php

		$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $getuser2["callerId"] . "";
		$b = mysqli_query(getDbConnection(), $a) or die(mysqli_error(getDbConnection()));
		$userrescaller = mysqli_fetch_array($b);

		$friendnameurl = $userrescaller['userurl'];

		if ($getuser2['callStatus'] != 1) {
			?>

			openvideocallwindowbtn('<?php echo encodeStr($userrescaller['userId']); ?>', '<?php echo $userrescaller['firstName']; ?>																				 		<?php echo $userrescaller['lastName']; ?>', '<?php echo $fullurl; ?>profile/<?php echo encodeStr($userrescaller['userId']); ?>/<?php echo $friendnameurl; ?>.html', '1');

		<?php }
	} else {
		?>


		$('.chat-btns').hide();
		$('.vdocall-msg').hide();
		$('.vdo-icon').removeClass('active');

		stopring();

		<?php
	}

	$a = "SELECT id from " . _VIDEO_CALL_REQUEST_MASTER_TABLE_ . " WHERE callerId= " . $_SESSION['sessUserId'] . " and callerStatus=1";
	$b = mysqli_query(getDbConnection(), $a) or die(mysqli_error(getDbConnection()));
	$aa = mysqli_fetch_array($b);


	if (!empty($aa) && isset($aa['id']) && $aa['id'] > 0) { ?>


	<?php } else { ?>

	<?php }







	$a = "SELECT onlineTime from " . _VIDEO_CALL_REQUEST_MASTER_TABLE_ . " WHERE callerId= " . $_SESSION['sessUserId'] . "";
	$b = mysqli_query(getDbConnection(), $a) or die(mysqli_error(getDbConnection()));
	$userData = mysqli_fetch_array($b);

	if (!empty($userData['onlineTime'])) {
		$newtimestamp = strtotime($userData['onlineTime'] . ' +25 seconds');
	} else {
		$newtimestamp = time() + 25; // fallback to current time + 25 seconds
	}


	if (date('Y-m-d H:i:s', $newtimestamp) < date('Y-m-d H:i:s')) {

		$sql_ins = "DELETE FROM " . _VIDEO_CALL_REQUEST_MASTER_TABLE_ . " where userId= " . $_SESSION["sessUserId"] . "   ";
		mysqli_query(getDbConnection(), $sql_ins) or die(mysqli_error(getDbConnection()));

		$sql_ins = "DELETE FROM " . _VIDEO_CALL_REQUEST_MASTER_TABLE_ . " where callerId= " . $_SESSION["sessUserId"] . "";
		mysqli_query(getDbConnection(), $sql_ins) or die(mysqli_error(getDbConnection()));

		?>

		stopring();

		<?php

	}
	?>
</script>
<?php
closeConn();
?>