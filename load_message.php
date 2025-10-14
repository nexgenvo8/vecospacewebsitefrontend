<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$userId2 = $_REQUEST['userId2'];
$msgdate = '';

unset($selectFields);
unset($whereFields);
unset($whereVals);


$sqlTotal = "0";
$sqlTotal = mysqli_num_rows(
	mysqli_query(
		$conn,
		"SELECT id FROM " . _CHAT_MASTER_TABLE_ . " WHERE userId='" . mysqli_real_escape_string($conn, $_SESSION['sessUserId']) . "' AND contactId='" . mysqli_real_escape_string($conn, decodeStr($userId2)) . "'"
	)
);

if ($sqlTotal - 20 > 0) {
	?>
	<div id="pageid2"><a class="loadmoremessagesclass"
			onclick="loadmorechatboxmessage('<?php echo ($sqlTotal - 20); ?>','<?php echo $userId2; ?>');">Load more
			messages</a>
	</div>
	<?php
}

$sql_ins = "UPDATE " . _CHAT_MASTER_TABLE_ . " SET status=1 WHERE contactId= '" . decodeStr($userId2) . "' AND userId='" . $_SESSION["sessUserId"] . "' ";
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
$sqlLogin = "select * from " . _CHAT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and contactId='" . decodeStr($userId2) . "' ORDER BY dateAdded ASC LIMIT " . $lsatsqlTotal . "," . $sqlTotal . "";
$resLogin = mysqli_query($conn, $sqlLogin);
$totalMsqlRow = mysqli_num_rows($resLogin);
if ($totalMsqlRow > 0) {
	while ($row = mysqli_fetch_array($resLogin)) {

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
			<div class="chat-date stimedate"><?php echo date("j F Y", $row['dateAdded']); ?></div>
		<?php } ?>
		<?php if ($row["chatBy"] != $_SESSION['sessUserId']) { ?>
			<?php if ($row["meeting"] == 0) { ?>
				<div class="userchatboxmain">
					<div class="userchatboxmain_user">
						<div class="userchatboxmain_name">&nbsp;</div>
						<?php
						if ($row["chatFileName"] != '') {
							$fileExt = findExtension($row["chatFileName"]);
							$img = in_array(strtolower($fileExt), ['jpeg', 'jpg', 'png']) ? 1 : 0;
						} else {
							$img = 0;
						}

						?>

						<div class="userchatboxmain_text chatmsg<?php if (strpos($row["chatText"], 'iframe') !== false) {
							echo " iframehave";
						} ?>" <?php if ($img == 1) {
							 echo 'style="padding:0px !important;"';
						 } ?>>

							<?php if ($img == 0) {
								echo nl2br(showsmily($row["chatText"]));
							} else { ?>
								<div class="imgbox">
									<img src="uploads/x_<?php echo $row["chatFileName"]; ?>" style="max-width:200px;"
										onClick="imagepopupmain('x_<?php echo $row["chatFileName"]; ?>');" />

								</div>

							<?php } ?>

							<div class="userchatboxmain_time"><?php echo date("h:i A", $row['dateAdded']); ?></div>
						</div>

					</div>
				</div>
			<?php } else { ?>
				<div class="userchatboxmain">
					<div class="userchatboxmain_user">
						<div class="userchatboxmain_name">&nbsp;</div>
						<div class="userchatboxmain_text">

							<div class="chatmsg" id="meeting<?php echo $row['id']; ?>"><?php echo nl2br(showsmily($row["chatText"])); ?>
							</div>
							<script>
								$('#meeting<?php echo $row['id']; ?>').load('<?php echo $fullurl; ?>meeting_inner.php?id=<?php echo $row['id']; ?>&myId=<?php echo $_SESSION['sessUserId']; ?>&user=1');
							</script>
							<div class="userchatboxmain_time" id="usermsgid<?php echo $row['id']; ?>">
								<?php if ($row['readDate'] != 0) {
									echo date("h:i A", $row['readDate']);
								} else { ?> 					<?php echo date("h:i A"); ?> 				<?php } ?>
							</div>
						</div>
					</div>
				</div>
			<?php }
		} else { ?>

			<?php if ($row["meeting"] == 0) { ?>
				<div class="userchatboxmain">
					<div class="userchatboxmain_me">
						<div class="userchatboxmain_name_me">&nbsp;</div>
						<div class="userchatboxmain_text_me chatmsg<?php if (strpos($row["chatText"], 'iframe') !== false) { ?> iframehave<?php } ?>"
							<?php if ($img == 1) { ?>style=" padding:0px !important;" <?php } ?>>

							<?php if ($img == 0) {
								echo nl2br(showsmily($row["chatText"]));
							} else { ?>
								<div class="imgbox">
									<img src="uploads/<?php echo $row["chatFileName"]; ?>" style="width:200px;"
										onClick="imagepopupmain('<?php echo 'x_' . $row["chatFileName"]; ?>');" />
								</div><?php } ?>

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
						<div class="userchatboxmain_name_me">&nbsp;</div>
						<div class="userchatboxmain_text_me">
							<div class="chatmsg" id="meeting<?php echo $row['id']; ?>"><?php echo nl2br(showsmily($row["chatText"])); ?>
							</div>
							<script>
								$('#meeting<?php echo $row['id']; ?>').load('<?php echo $fullurl; ?>meeting_inner.php?id=<?php echo $row['id']; ?>&myId=<?php echo $_SESSION['sessUserId']; ?>');
							</script>
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
<?php } ?>

<script>
	$("#loadchatusermsg").scrollTop($("#loadchatusermsg")[0].scrollHeight);
	setTimeout(function () {
		$("#loadchatusermsg").scrollTop($("#loadchatusermsg")[0].scrollHeight);
	}, 500);


	window.setTimeout(function () {
		$('#loadchatusermsg').animate({
			scrollTop: $('#loadchatusermsg')[0].scrollHeight
		}, 2000);
	}, 1000);//unsued
</script>

<input type="hidden" name="livechattotalpage" id="livechattotalpage" value="1" />