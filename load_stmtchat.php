<?php
header('Content-Type: text/html; charset=utf-8');


include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$userId2 = $_REQUEST['stmtId'];
$msgdate = '';

$selectFields =[];
$whereFields = [];
$whereVals =[];


$sqlTotal = 0; // default

$query = "SELECT id 
          FROM " . _STUDENT_MENTOR_CHAT_MASTER_TABLE_ . " 
          WHERE userId = '" . mysqli_real_escape_string($conn, $_SESSION['sessUserId']) . "' 
          AND contactId = '" . mysqli_real_escape_string($conn, decodeStr($userId2)) . "'";

$result = mysqli_query($conn, $query);

if ($result) {
	$sqlTotal = mysqli_num_rows($result);
}

if (($sqlTotal - 20) > 0) {
	?>
	<div id="pageid2"><a class="loadmoremessagesclass"
			onclick="loadmorestmtchat('<?php echo ($sqlTotal - 20); ?>','<?php echo $userId2; ?>');">Load more messages</a>
	</div>
	<?php
}

$sql_ins = "UPDATE " . _STUDENT_MENTOR_CHAT_MASTER_TABLE_ . " SET status=1 WHERE contactId= '" . decodeStr($userId2) . "' AND userId='" . $_SESSION["sessUserId"] . "' ";
mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

$n = 0;
if ($sqlTotal == '') {
	$sqlTotal = 0;
}

if ($sqlTotal < 30) {
	$lsatsqlTotal = 0;
} else {
	$lsatsqlTotal = $sqlTotal - 20;
}


$sqlLogin = "";
$sqlLogin = "select * from " . _STUDENT_MENTOR_CHAT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and contactId='" . decodeStr($userId2) . "' ORDER BY dateAdded ASC LIMIT " . $lsatsqlTotal . "," . $sqlTotal . "";
$resLogin = mysqli_query($conn, $sqlLogin);
$totalMsqlRow = mysqli_num_rows($resLogin);
// ================= RECORDING CARD =================


if ($totalMsqlRow > 0) {
	while ($row = mysqli_fetch_array($resLogin)) {


$attendance = $row['attendance']; // column name confirm karo

$text = trim($row["chatText"]);

if(strpos($text,'[recording]') === 0){

    $file = str_replace('[recording]','',$text);

    echo '
    <div class="userchatboxmain">
        <div class="recording-card">
            🎤 Voice Message<br>
            <audio controls src="'.$fullurl.$file.'" style="width:100%"></audio>
        </div>
    </div>';

    continue;
}






		if ($row["chatFileName"] != '') {
		


			$fileExt = findExtension($row["chatFileName"]);

			if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {
				$img = 1;
			} else {
				$img = 0;
			}
		} else {
			$img = 0;
		}
		?>
		
		<?php if ($msgdate != date("Y-m-d", $row['dateAdded'])) { ?>
			<div class="chat-date"><?php echo date("j F Y", $row['dateAdded']); ?></div>
		<?php } ?>


		<?php if ($row["chatBy"] != $_SESSION['sessUserId']) {
			$selst = 'select * from ' . _USERS_MASTER_TABLE_ . '  WHERE userId=' . decodeStr($_REQUEST["stmtId"]) . ' ';
			$usersmt = mysqli_query($conn, $selst);
			$resultsmt = mysqli_fetch_array($usersmt);
			if ($resultsmt["profilePhoto"] != '') {
				$userphotot = $resultsmt["profilePhoto"];
			} else {
				$userphotot = 'user-placeholder.jpg';
			}



			if ($row["meeting"] == 0) { ?>
				<div class="userchatboxmain">
					<div class="userchatboxmain_user">
						<div class="userrigtimagediv" style="width: 50px; float:left;">
							<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphotot)); ?>">
						</div>
						<div class="userchatboxmain_name"
							style="font-size: 16px; font-weight: 600;color: #C02621;    text-align: left;margin-left: 70px ">
							<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $resultsmt["firstName"]); ?>
							<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $resultsmt["lastName"]); ?>
						</div>
						<div style="margin-left: 70px;"
							class="userchatboxmain_text chatmsg12 bg123none chatmsg<?php if (strpos($row["chatText"], 'iframe') !== false) { ?> iframehave<?php } ?>"
							<?php if ($img == 1) { ?>style=" padding:0px !important;" <?php } ?>>
							<?php if ($img == 0) {
								$html = $row["chatText"];

								$attendanceAttr = ' data-attendance="'.$attendance.'"';

								$html = str_replace(
									'<div class="chat-event"',
									'<div class="chat-event" data-msg-id="'.$row['id'].'" '.$attendanceAttr,
									$html
								);


								echo nl2br(showsmily($html));
							} else { ?>
								<div class="imgbox" style="max-height:100px;">
									<img src="<?php echo $fullurl; ?>uploads/<?php echo $row["chatFileName"]; ?>" style="max-height:100px;;"
										onClick="imagepopupmain('<?php echo 'x_' . $row["chatFileName"]; ?>');" />
								</div>
							<?php } ?>
							<div class="userchatboxmain_time">
								<?php echo date("h:i A", $row['dateAdded']); ?>
							</div>
						</div>
					</div>
				</div>

			<?php } else { ?>
				<div class="userchatboxmain">
					<div class="userchatboxmain_user">
						<div class="userrigtimagediv1" style="width: 50px;  float: left !important;">
							<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphotot)); ?>">
						</div>
						<div class="userchatboxmain_name"
							style="font-size: 16px; font-weight: 600;color: #C02621;    text-align: left;margin-left: 70px;">
							<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $resultsmt["firstName"]); ?>
							<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $resultsmt["lastName"]); ?>
						</div>
						<div class="userchatboxmain_text" style="margin-left: 70px;">
							<div class="chatmsg" id="meeting<?php echo $row['id']; ?>"><?php $html = $row["chatText"];

							$attendanceAttr = ' data-attendance="'.$attendance.'"';

							$html = str_replace(
								'<div class="chat-event"',
								'<div class="chat-event" data-msg-id="'.$row['id'].'" '.$attendanceAttr,
								$html
							);


							echo nl2br(showsmily($html)); ?>
							</div>

							<div class="userchatboxmain_time" id="usermsgid<?php echo $row['id']; ?>">
								<?php if ($row['readDate'] != 0) {
									echo date("h:i A", $row['readDate']);
								} else { ?> 					<?php echo date("h:i A"); ?> 				<?php } ?>
							</div>
						</div>
					</div>
				</div>

			<?php }
		} else {

			$sel = 'select * from ' . _USERS_MASTER_TABLE_ . '  WHERE userId=' . $_SESSION["sessUserId"] . ' ';
			$usersm = mysqli_query($conn, $sel);
			$resultsm = mysqli_fetch_array($usersm);
			if ($resultsm["profilePhoto"] != '') {
				$userphoto = $resultsm["profilePhoto"];
			} else {
				$userphoto = 'user-placeholder.jpg';
			}

			if ($row["meeting"] == 0) { ?>
				<div class="userchatboxmain">
					<div class="userchatboxmain_me">
						<div class="userrigtimagediv" style="width: 50px;">
							<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>">
						</div>
						<div class="userchatboxmain_name_me"
							style="font-size: 16px; font-weight: 600;color: #C02621;     text-align: right;    margin-right: 70px;">
							<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $resultsm["firstName"]); ?>
							<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $resultsm["lastName"]); ?>
						</div>
						<div style="margin-right: 70px;"
							class="userchatboxmain_text_me bg123none chatmsg12 chatmsg<?php if (strpos($row["chatText"], 'iframe') !== false) { ?> iframehave<?php } ?>"
							<?php if ($img == 1) { ?>style=" padding:0px !important;" <?php } ?>>
							<?php if ($img == 0) {
								$html = $row["chatText"];

								$attendanceAttr = ' data-attendance="'.$attendance.'"';

								$html = str_replace(
									'<div class="chat-event"',
									'<div class="chat-event" data-msg-id="'.$row['id'].'" '.$attendanceAttr,
									$html
								);


								echo nl2br(showsmily($html));
							} else { ?>
								<div class="imgbox" style="max-height:100px;">
									<img src="<?php echo $fullurl; ?>uploads/<?php echo $row["chatFileName"]; ?>" style="max-height:100px;"
										onClick="imagepopupmain('<?php echo 'x_' . $row["chatFileName"]; ?>');" />
								</div>
							<?php } ?>
							<div class="userchatboxmain_time_me" id="usermsgid<?php echo $row['id']; ?>">
								<?php if ($row['readDate'] != 0) {
									echo date("h:i A", $row['readDate']);
								} else { ?> 					<?php echo date("h:i A"); ?> 				<?php } ?>
							</div>
						</div>
					</div>
				</div>

			<?php } else { ?>
				<div class="userchatboxmain">
					<div class="userchatboxmain_me">
						<style>
							.userrigtimagediv1 {
								float: left;
								width: 8%;
								max-width: 50px;
							}
						</style>
						<div class="userlestimagediv" style="width: 50px;     float: left !important;">
							<img src="<?php echo $fullurl; ?>uploads/<?php $html = $row["chatText"];

						$attendanceAttr = ' data-attendance="'.$attendance.'"';

						$html = str_replace(
							'<div class="chat-event"',
							'<div class="chat-event" data-msg-id="'.$row['id'].'" '.$attendanceAttr,
							$html
						);


						echo nl2br(showsmily($html)); ?>">
						</div>
						<div class="userchatboxmain_name_me"
							style="font-size: 16px; font-weight: 600;color: #C02621;    text-align: left;margin-left: 70px;">
							<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $resultsm["firstName"]); ?>
							<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $resultsm["lastName"]); ?>
						</div>
						<div class="userchatboxmain_text_me" style="margin-left: 70px;">
							<div class="chatmsg" id="meeting<?php echo $row['id']; ?>"><?php echo nl2br(showsmily($row["chatText"])); ?>
							</div>
							<div class="userchatboxmain_time_me" id="usermsgid<?php echo $row['id']; ?>">
								<?php if ($row['readDate'] != 0) {
									echo date("h:i A", $row['readDate']);
								} else { ?> 					<?php echo date("h:i A"); ?> 				<?php } ?>
							</div>
						</div>
					</div>
				</div>

			<?php }
		} ?>

		<?php
		if ($msgdate != date("Y-m-d", $row['dateAdded'])) {
			$msgdate = date("Y-m-d", $row['dateAdded']);
		}
	}
}


$sql_ins = "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET chatStatus=0 WHERE contactId= '" . decodeStr($userId2) . "' AND userId='" . $_SESSION["sessUserId"] . "' ";
mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));




?>
<?php if ($msgdate != date("Y-m-d")) { ?>
	<div class="chat-date"><?php echo date("j F Y"); ?></div>
<?php }

?>
<script>
	function loadmorestmtchat(startpage, stmtId) {
		var pageid = $("#livechatstmtpage").val();

		pageid = Number(pageid) + 1;
		$("#livechatstmtpage").val(pageid);
		$("#pageid" + pageid).html('<div style="text-align:center;">Wait please...</div>');
		$("#pageid" + pageid).load('load_more_stmtchat.php?startfrom=' + startpage + '&pageid=' + pageid + '&stmtId=' + stmtId);

	}

</script>
<!--<script>
	$("#loadstmtchat").scrollTop($("#loadstmtchat")[0].scrollHeight);
	setTimeout(function () {
		$("#loadstmtchat").scrollTop($("#loadstmtchat")[0].scrollHeight);
	}, 500);


	window.setTimeout(function () {
		$('#loadstmtchat').animate({
			scrollTop: $('#loadstmtchat')[0].scrollHeight
		}, 2000);
	}, 1000);//unsued
</script> -->

<input type="hidden" name="livechatstmtpage" id="livechatstmtpage" value="1" />
<style>

.recording-card {
    background: #fde2e2;
    border-left: 4px solid #dc3545;
    padding: 10px;
    border-radius: 10px;
    font-size: 14px;
    margin-top: 5px;
}

</style>