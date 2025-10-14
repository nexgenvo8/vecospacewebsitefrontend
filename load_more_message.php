<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$msgdate = '';
$userId2 = $_REQUEST['userId2'];
$startfrom = $_REQUEST['startfrom'];
$pageid = $_REQUEST['pageid'];
if ($startfrom > 0) {
	?>
	<div id="pageid<?php echo $pageid + 1; ?>"><a class="loadmoremessagesclass"
			onclick="loadmorechatboxmessage('<?php echo ($startfrom - 20); ?>','<?php echo $userId2; ?>');">Load more
			messages</a></div>

	<?php
}

$n = 0;
unset($selectFields);
unset($whereFields);
unset($whereVals);


$sqlTotal = 0;
$sqlTotal = mysqli_num_rows(
	mysqli_query(
		$conn,
		"SELECT id FROM " . _CHAT_MASTER_TABLE_ . " 
         WHERE userId = '" . mysqli_real_escape_string($conn, $_SESSION['sessUserId']) . "' 
         AND contactId = '" . mysqli_real_escape_string($conn, decodeStr($userId2)) . "'"
	)
);


if ($sqlTotal == '') {
	$sqlTotal = 0;
}

if ($sqlTotal < 30) {
	$lsatsqlTotal = 0;
} else {
	$lsatsqlTotal = $sqlTotal - 20;
}


$sqlLogin = "";
$sqlLogin = "select * from " . _CHAT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and contactId='" . decodeStr($userId2) . "' ORDER BY dateAdded ASC LIMIT " . ($startfrom - 20) . "," . $startfrom . "";
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
			<div class="chat-date"><?php echo date("j F Y", $row['dateAdded']); ?></div>
		<?php } ?>
		<?php if ($row["chatBy"] != $_SESSION['sessUserId']) { ?>
			<?php if ($row["meeting"] == 0) { ?>
				<div class="userchatboxmain">
					<div class="userchatboxmain_user">
						<div class="userchatboxmain_name">&nbsp;</div>
						<div class="userchatboxmain_text" <?php if ($img == 1) { ?>style=" padding:0px !important;" <?php } ?>>

							<?php if ($img == 0) { ?>
								<div class="chatmsg<?php if (strpos($row["chatText"], 'maps/place') !== false) { ?> iframehave<?php } ?>">
									<?php echo nl2br(showsmily($row["chatText"])); ?></div><?php } else { ?>
								<div class="imgbox"><img src="<?php echo $fullurl; ?>uploads/<?php echo $row["chatFileName"]; ?>"
										style="width:200px;" onClick="imagepopupmain('<?php echo 'x_' . $row["chatFileName"]; ?>');" /></div>
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
								} else { ?>					<?php echo date("h:i A"); ?>				<?php } ?>
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
						<div class="userchatboxmain_text_me" <?php if ($img == 1) { ?>style=" padding:0px !important;" <?php } ?>>

							<?php if ($img == 0) { ?>
								<div class="chatmsg<?php if (strpos($row["chatText"], 'maps/place') !== false) { ?> iframehave<?php } ?>">
									<?php echo nl2br(showsmily($row["chatText"])); ?></div><?php } else { ?>
								<div class="imgbox"><img src="<?php echo $fullurl; ?>uploads/<?php echo $row["chatFileName"]; ?>"
										style="width:200px;" onClick="imagepopupmain('<?php echo 'x_' . $row["chatFileName"]; ?>');" /></div>
							<?php } ?>

							<div class="userchatboxmain_time_me" id="usermsgid<?php echo $row['id']; ?>">
								<?php if ($row['readDate'] != 0) {
									echo date("h:i A", $row['readDate']);
								} else { ?>					<?php echo date("h:i A"); ?>				<?php } ?>
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
								} else { ?>					<?php echo date("h:i A"); ?>				<?php } ?>
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