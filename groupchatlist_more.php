<?php
include_once('inc.php');
include_once('config/session-check.inc.php');
$startfrom = $_REQUEST['startfrom'];
$pageid = $_REQUEST['pageid'];
if ($startfrom > 0) {
	?>


	<?php
}
$sqlTotal = "0";
$sqlTotal = mysqli_num_rows(
	mysqli_query(
		$conn,
		"SELECT id FROM " . _GROUP_CHAT_MASTER_TABLE_ . " 
         WHERE groupId = " . (int) decodeStr($_REQUEST['groupId'])
	)
);


if ($sqlTotal == '') {
	$sqlTotal = 0;
}

if ($sqlTotal < 30) {
	$lsatsqlTotal = 0;
} else {
	$lsatsqlTotal = $sqlTotal - 10;
}



function Size($path)
{
	$bytes = sprintf('%u', filesize($path));

	if ($bytes > 0) {
		$unit = intval(log($bytes, 1024));
		$units = array('B', 'KB', 'MB', 'GB');

		if (array_key_exists($unit, $units) === true) {
			return sprintf('%d %s', $bytes / pow(1024, $unit), $units[$unit]);
		}
	}

	return $bytes;
}

$startfrom2 = $startfrom - 20;
if ($startfrom2 < 0) {
	$startfrom2 = 0;
}
?>

<?php if ($startfrom2 > 1) { ?>
	<div id="pageid<?php echo $pageid + 1; ?>"><a class="loadmoremessagesclass"
			onclick="loadmorechatbox('<?php echo ($startfrom - 20); ?>','<?php echo $_REQUEST['groupId']; ?>');">Load more
			messages</a></div>
<?php } ?>


<?php
$sqlQuery = "";
$sqlQuery = "select * from " . _GROUP_CHAT_MASTER_TABLE_ . " where groupId=" . decodeStr($_REQUEST['groupId']) . " ORDER BY dateAdded ASC  LIMIT " . $startfrom2 . "," . $startfrom . "";
$resQuery = getRecords(_TIMELINE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlQuery);
if ($resQuery) {
	while ($row = mysqli_fetch_array($resQuery)) {

		if ($row["userId"] == $_SESSION['sessUserId']) {
			$mecalss = ' me';
		} else {
			$mecalss = '';
		}


		$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $row["userId"] . "";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$userres = mysqli_fetch_array($b);

		$friendnameurl = $userres['userurl'];

		if ($userres["profilePhoto"] != '') {
			$userphoto = $userres["profilePhoto"];
		} else {
			$userphoto = 'user-placeholder.jpg';
		}

		if ($row['msgType'] == 'pdf') {
			$fileex = 'pdf-icon.png';
		}
		if ($row['msgType'] == 'ppt') {
			$fileex = 'ppt-icon.png';
		}
		if ($row['msgType'] == 'doc') {
			$fileex = 'doc-icon.png';
		}
		if ($row['msgType'] == 'xls') {
			$fileex = 'xls-icon.png';
		}
		if ($row['msgType'] == 'txt') {
			$fileex = 'txt-icon.png';
		}

		$dd = "SELECT * from " . _GROUP_FILE_TABLE_ . " WHERE id= " . $row["fileId"] . "  ";
		$ee = mysqli_query($conn, $dd) or die(mysqli_error($conn));
		$rowfilename = mysqli_fetch_array($ee);


		$textmsg = $row['chatText'];

		if ($row["chatBy"] == $_SESSION['sessUserId']) {
			$username = 'You';

			if ($row['bulbType'] == 2) {
				$textmsg = $username . ' left this group';
			}

			if ($row['bulbType'] == 3) {

				$aa = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $row["userId"] . "";
				$bb = mysqli_query($conn, $aa) or die(mysqli_error($conn));
				$groupadmin = mysqli_fetch_array($bb);

				$textmsg = 'You added ' . $groupadmin['firstName'] . '';
			}

		} else {

			$username = $userres['firstName'];

			if ($row['bulbType'] == 2) {
				$textmsg = $username . ' left this group';
			}

			if ($row['bulbType'] == 3) {

				$aa = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $row["chatBy"] . "";
				$bb = mysqli_query($conn, $aa) or die(mysqli_error($conn));
				$groupadmin = mysqli_fetch_array($bb);


				$aaa = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $row["userId"] . "";
				$bbb = mysqli_query($conn, $aaa) or die(mysqli_error($conn));
				$thirdadmin = mysqli_fetch_array($bbb);

				if ($row["userId"] != $_SESSION['sessUserId']) {

					$textmsg = '' . $groupadmin['firstName'] . ' added ' . $thirdadmin['firstName'] . '';

				} else {

					$textmsg = '' . $groupadmin['firstName'] . ' added you';
				}

			}



		}
		?>
		<?php if ($row['msgType'] == 'text') { ?>

			<li class="type<?php echo $row['bulbType']; ?><?php echo $mecalss; ?>">
				<div class="grp-chat-cntnt">
					<span class="usr"><img
							src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></span>
					<div class="gchatlist-right">
						<div class="time"><span class="nm"><?php echo $userres['firstName']; ?> -</span>
							<?php echo date("h:i A", $row['dateAdded']); ?></div>
						<div class="chat-txt <?php if ($row['maplocation'] == 1) { ?>no-paddinggroup<?php } ?>">
							<?php echo (showsmily($row["chatText"])); ?>
						</div>
					</div>
				</div>
			</li>
		<?php } ?>




		<?php if ($row['msgType'] == 'photo' && $row["fileId"] != 0) {

			?>
			<li class="type<?php echo $row['bulbType']; ?><?php echo $mecalss; ?>">
				<div class="grp-chat-cntnt">
					<span class="usr"> <img
							src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></span>
					<div class="gchatlist-right">
						<div class="time"><span class="nm"><?php echo $userres['firstName']; ?> -</span>
							<?php echo date("h:i A", $row['dateAdded']); ?></div>
						<div class="chat-txt no-paddinggroup">
							<span class="shared-file">

								<div class="file-box photo">
									<span class="photo-file"><img
											src="<?php echo $fullurl; ?>groupuploads/<?php echo $rowfilename["fileName"]; ?>"
											onClick="groupimagepopupmain(<?php echo $rowfilename["id"]; ?>);"></span>
								</div>

							</span>
						</div>
						<?php if ($row["fileName"] != '') { ?>
							<div class="filename"><?php echo (showsmily($row["fileName"])); ?></div><?php } ?>
					</div>
				</div>
			</li>
		<?php }
		if ($row['msgType'] != 'photo' && $row['msgType'] != 'text' && $row['msgType'] != 'url' && $row["fileId"] != 0) { ?>

			<li <?php echo $mecalss; ?>
				onClick="openfile('<?php echo $fullurl; ?>groupuploads/<?php echo $rowfilename["fileName"]; ?>','document');">
				<div class="grp-chat-cntnt">
					<span class="usr"> <img
							src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></span>
					<div class="gchatlist-right">
						<div class="time"><span class="nm"><?php echo $userres['firstName']; ?> - </span>
							<?php echo date("h:i A", $row['dateAdded']); ?></div>

						<div class="chat-txt"><?php echo (showsmily($row["chatText"])); ?>
							<span class="shared-file">

								<a href="<?php echo $fullurl; ?>groupuploads/<?php echo $rowfilename["fileName"]; ?>"
									target="_blank">
									<div class="file-box">
										<span class="icon-file"><img src="../images/<?php echo $fileex; ?>"></span>
										<span class="fl-box-right">
											<h4><?php if ($row["fileName"] != '') {
												echo ($row["fileName"]);
											} else {
												echo $rowfilename["fileName"];
											} ?>
											</h4>
											<label><?php echo Size('groupuploads/' . $rowfilename["fileName"]); ?></label>
										</span>
									</div>
								</a>
							</span>
						</div>
					</div>
				</div>
			</li>




		<?php }


		if ($msgdate != date("Y-m-d", $row['dateAdded'])) {
			$msgdate = date("Y-m-d", $row['dateAdded']);
		}
	}
} ?>

<script>
	$('#groupnewmsgcount<?php echo decodeStr($_REQUEST['groupId']); ?>').text('0');
	$('#groupnewmsgcount<?php echo decodeStr($_REQUEST['groupId']); ?>').hide();

</script>