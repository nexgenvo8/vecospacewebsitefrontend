<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session


$sqlGroupMembers = "";
$sqlGroupMembers = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . decodeStr($_REQUEST["groupId"]) . " and status=1 and userStatus=0 and groupId IN (select id from " . _GROUP_MASTER_TABLE_ . " where groupStatus=0) and userId=" . $_SESSION["sessUserId"] . " order by id desc ";
$resGroupMembers = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
if ($resGroupMembers) {

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


	$sqlLogin = "select * from " . _GROUP_GOT_MSG_TABLE_ . " where groupId=" . decodeStr($_REQUEST['groupId']) . " and userId='" . $_SESSION["sessUserId"] . "' and status=0 ORDER BY id ASC ";
	$resLogin = getRecords(_GROUP_GOT_MSG_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
	if ($resLogin) {
		while ($row = mysqli_fetch_array($resLogin)) {

			$sql_group = "SELECT * from " . _GROUP_CHAT_MASTER_TABLE_ . " WHERE groupId= " . $row['groupId'] . " and id= " . $row['chatId'] . " order by id desc ";
			$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
			$rowGroup = mysqli_fetch_array($resgroup);


			$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowGroup["userId"] . "";
			$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
			$userres = mysqli_fetch_array($b);

			$friendnameurl = $userres['userurl'];

			if ($userres["profilePhoto"] != '') {
				$userphoto = $userres["profilePhoto"];
			} else {
				$userphoto = 'user-placeholder.jpg';
			}




			$dd = "SELECT * from " . _GROUP_FILE_TABLE_ . " WHERE id= " . $rowGroup["fileId"] . "  ";
			$ee = mysqli_query($conn, $dd) or die(mysqli_error($conn));
			$rowfilename = mysqli_fetch_array($ee);


			if ($rowGroup['msgType'] == 'pdf') {
				$fileex = 'pdf-icon.png';
			}
			if ($rowGroup['msgType'] == 'ppt') {
				$fileex = 'ppt-icon.png';
			}
			if ($rowGroup['msgType'] == 'doc') {
				$fileex = 'doc-icon.png';
			}
			if ($rowGroup['msgType'] == 'xls') {
				$fileex = 'xls-icon.png';
			}
			if ($rowGroup['msgType'] == 'txt') {
				$fileex = 'txt-icon.png';
			}



			if ($rowGroup['userId'] != $_SESSION["sessUserId"]) {


				?>
				<script>
					<?php if ($rowGroup['msgType'] == 'text') { ?>
						$('#groupchatlist').append('<li><div class="grp-chat-cntnt"><span class="usr"> <img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></span><div class="gchatlist-right"><div class="time"><span class="nm"><?php echo $userres['firstName']; ?> - </span><?php echo date("h:i A", $rowGroup['dateAdded']); ?></div><div class="chat-txt <?php if ($rowGroup['maplocation'] == 1) { ?>no-paddinggroup<?php } ?>"><?php echo normalclean($rowGroup["chatText"]); ?></div></div></div></li>');
					<?php
					}
			}
			if ($rowGroup['msgType'] == 'photo') {
				?>
					$('#groupchatlist').append('<li><div class="grp-chat-cntnt"><span class="usr"> <img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></span><div class="gchatlist-right"><div class="time"><span class="nm"><?php echo $userres['firstName']; ?> - </span><?php echo date("h:i A", $rowGroup['dateAdded']); ?></div><div class="chat-txt no-paddinggroup"><span class="shared-file"><div class="file-box photo"><span class="photo-file"><img src="<?php echo $fullurl; ?>groupuploads/<?php echo $rowfilename["fileName"]; ?>" filename="<?php echo $fullurl; ?>groupuploads/<?php echo $rowfilename["fileName"]; ?>" filetype="image" onClick="groupimagepopupmain(<?php echo $rowfilename["id"]; ?>);"></span></div><?php if ($rowGroup["fileName"] != '') { ?><div class="filename"><?php echo (showsmily($rowGroup["fileName"])); ?></div><?php } ?></span></div></div></div></li>');
				<?php }


			if ($rowGroup['msgType'] != 'photo' && $rowGroup['msgType'] != 'url' && $rowGroup['msgType'] != 'text') {
				?>
					$('#groupchatlist').append('<li filename="<?php echo $fullurl; ?>groupuploads/<?php echo $rowfilename["fileName"]; ?>" filetype="document" ><div class="grp-chat-cntnt"><span class="usr"> <img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></span><div class="gchatlist-right"><div class="time"><span class="nm"><?php echo $userres['firstName']; ?> - </span><?php echo date("h:i A", $rowGroup['dateAdded']); ?></div><div class="chat-txt"><?php echo normalclean($rowGroup["chatText"]); ?><span class="shared-file"><a href="<?php echo $fullurl; ?>groupuploads/<?php echo $rowfilename["fileName"]; ?>" target="_blank"><div class="file-box"><span class="icon-file"><img src="../images/<?php echo $fileex; ?>"></span><span class="fl-box-right"><h4><?php if ($rowGroup["fileName"] != '') {
												 echo ($rowGroup["fileName"]);
											 } else {
												 echo $rowfilename["fileName"];
											 } ?></h4><label><?php echo Size('groupuploads/' . $rowfilename["fileName"]); ?></label></span></div></a></span></div></div></div></li>');
				<?php } ?>




			</script>

			<?php
			$sql_ins = "DELETE FROM " . _GROUP_GOT_MSG_TABLE_ . " WHERE  groupId=" . decodeStr($_REQUEST['groupId']) . " and userId='" . $_SESSION["sessUserId"] . "'  ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			?>
			<script>
				$(".chats").animate({ scrollTop: $("#groupchatlist").outerHeight() }, 600);
			</script>
		<?php }
	}
} ?>