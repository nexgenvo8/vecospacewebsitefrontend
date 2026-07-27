<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 6;



if (isset($_FILES['imagefile']) && $_FILES['imagefile']['name'] != '') {

	$timename = time();
	$file_name = $_FILES['imagefile']['name'];
	$fileExt = findExtension($file_name);

	if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {
		$file_name = $timename . $file_name;
		copy($_FILES['imagefile']['tmp_name'], "uploads/" . $file_name);
		if (isset($_POST['oldprofilePhoto']) && $_POST['oldprofilePhoto'] != '') {
			unlink("uploads/" . $_POST["oldprofilePhoto"]);
		}

		$upimg = 'uploads/' . $file_name;

		image_fix_orientation($upimg);
		generate_image_thumbnail($upimg, $upimg, '120', '120');



		$sql_ins = "update " . _GROUP_MASTER_TABLE_ . " set groupThumb='$file_name' where id=" . decodeStr($_REQUEST['groupId']) . " and userId= " . $_SESSION["sessUserId"] . "";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		header("location:group-setting.html?groupId=" . $_REQUEST['groupId'] . "");
	} else {

		header("location:group-setting.html?groupId=" . $_REQUEST['groupId'] . "&e=1");
	}
}






if (isset($_POST['btnsubmit']) && $_POST['btnsubmit'] == 1) {
	$userGroupStatus = normalclean($_POST["userGroupStatus"]);

	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);

	$insertFields[0] = "userGroupStatus";

	$insertVals[0] = $userGroupStatus;

	$whereFields[0] = "id";
	$whereFields[1] = "userId";

	$whereVals[0] = clean($_POST['txtId']);
	$whereVals[1] = $_SESSION['sessUserId'];

	$resUpdate = updateDB(_GROUP_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	//27/11/17 By Rashid
	$sql_ins = "update " . _GROUP_MEMBER_MASTER_TABLE_ . " set userStatus=" . $userGroupStatus . " where groupId=" . clean($_POST['txtId']) . " and userId='" . $_SESSION["sessUserId"] . "' ";
	mysqli_query($conn, $sql_ins) or die(error_found(mysqli_error($conn)));
	//27/11/17 By Rashid
	$errMsg = "Group details updated successfully.";

}


if ($_REQUEST['groupId'] != '') {
	$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= '" . decodeStr($_REQUEST['groupId']) . "' ";
	$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
	$rowGroup = mysqli_fetch_array($resgroup);

	if ($rowGroup['id'] == '') {
		header("Location: " . $fullurl . "my-groups.html");
		exit();
	}

	$oldphoto = $rowGroup["groupThumb"];


	if ($rowGroup["groupThumb"] != '') {
		$groupThumb = $rowGroup["groupThumb"];
	} else {
		$groupThumb = 'group.png';
	}
	$mytotalgroups = 0;
	$totalm = "SELECT * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $rowGroup["id"] . "";
	$retotalm = mysqli_query($conn, $totalm) or die(mysqli_error($conn));
	$mytotalgroups = mysqli_num_rows($retotalm);

	$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowGroup["userId"] . "";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$userres = mysqli_fetch_array($b);

	$friendnameurl = $userres['userurl'];

	if ($userres["profilePhoto"] != '') {
		$userphoto = $userres["profilePhoto"];
	} else {
		$userphoto = 'user-placeholder.jpg';
	}

	$groupsql = "SELECT id from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE userId= " . $_SESSION['sessUserId'] . " and groupId='" . decodeStr($_REQUEST['groupId']) . "' ";
	$resultgroup = mysqli_query($conn, $groupsql) or die(mysqli_error($conn));
	$mygroupid = mysqli_num_rows($resultgroup);

	$groupsql1 = "SELECT id from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE userId= " . $_SESSION['sessUserId'] . " and groupId='" . decodeStr($_REQUEST['groupId']) . "' and status=1 ";
	$resultgroup1 = mysqli_query($conn, $groupsql1) or die(mysqli_error($conn));
	$mygroupid1 = mysqli_num_rows($resultgroup1);
}







?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo stripslashes(trim($rowGroup["groupName"])); ?> Group - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
</head>

<body>
	<div id="wrapper" class="">
		<?php include('header.php'); ?>

		<div class="container main">
			<div class="premium_tag"><a href="#">Go Premium</a>
				<p id="typewriter"></p>
			</div>
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content">
					<div class="groups detail">
						<div class="mmbrof_group_list">
							<div class="grp-dtail-had">
								<div class="group-sec"><img
										src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>"><input
										name="oldprofilePhoto" id="oldprofilePhoto" type="hidden" value=""> <span> <a
											style="cursor:default; text-decoration:none;"
											class="nm"><?php echo stripslashes(trim($rowGroup["groupName"])); ?></a>
										<label><?php echo substr(strip_tags(stripslashes(trim($rowGroup["groupDetails"]))), 0, 250); ?></label>
									</span>

									<div class="join-btn">
										<!--<a href="<?php echo $fullurl; ?>about-group.html?groupId=<?php echo encodeStr($rowGroup['id']); ?>">About this group</a>-->
										<?php if ($mygroupid == 0) { ?><a
												href="common_action.php?groupId=<?php echo encodeStr($rowGroup['id']); ?>&action=groupjoinrequest"
												target="actionfrm" class="konectt-btn">Join group</a> <?php } ?>

										<?php if ($mygroupid1 == 0 && $mygroupid == 1) { ?><a class="konectt-btn"
												style="background-color:#18ad06;">Join request sent</a> <?php } ?>
									</div>

								</div>
							</div>
						</div>
						<div class="posts_cont">
							<ul class="cntr_tab">
								<li><a
										href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($rowGroup['id']); ?>">Posts</a>
								</li>
								<?php if ($rowGroup['userId'] == $_SESSION['sessUserId']) { ?>
									<li><a
											href="<?php echo $fullurl; ?>joining-requests.html?groupId=<?php echo encodeStr($rowGroup['id']); ?>">Joining
											requests</a></li>
								<?php } ?>
								<li><a
										href="<?php echo $fullurl; ?>about-group.html?groupId=<?php echo encodeStr($rowGroup['id']); ?>">About
										this group</a></li>
								<?php if ($rowGroup['userId'] == $_SESSION['sessUserId']) { ?>
									<li><a href="<?php echo $fullurl; ?>group-setting.html?groupId=<?php echo encodeStr($rowGroup['id']); ?>"
											class="active">Group setting</a></li>
									<li><a
											onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=invitegrpcontacts&groupId=<?php echo encodeStr($rowGroup['id']); ?>','Invite Contacts');">Invite
											contacts</a></li>
								<?php } ?>
							</ul>
							<div class="post-list" style="width:100%;">
								<form enctype="multipart/form-data" name="frmgroup" id="frmgroup" method="post">
									<div class="grp-setting">
										<h2>Group setting</h2>
										<div class="grp-setin-frm">
											<div class="status">
												<span> Change photo &nbsp;&nbsp;</span>
												<input name="imagefile" id="imagefile" type="file"
													onChange="$('#frmgroup').submit();$('#commonloader').show();">
												<?php if (isset($_GET['e']) && $_GET['e'] == 1) { ?>
													<div style="margin-bottom:10px; color:#FF0000;" class="">Oops! Please
														upload image file with extension only .jpg, .png, .gif.</div>
												<?php } ?>
											</div>

											<div class="status">
												Group status: <select name="userGroupStatus" id="userGroupStatus">
													<option value="1" <?php if (trim($rowGroup["userGroupStatus"]) == 1) {
														echo 'selected';
													} ?>>Active</option>
													<option value="0" <?php if (trim($rowGroup["userGroupStatus"]) == 0) {
														echo 'selected';
													} ?>>Deactive</option>
												</select><input type="hidden" name="txtId" id="txtId"
													value="<?php echo decodeStr($_REQUEST['groupId']); ?>">
												<button class="grp_dtail-btn" type="submit" name="btnsubmit"
													value="1">Update</button>
											</div>
											<div class="dlt-grup">
												<div style="text-align:center; margin-left:320px;"><a
														style="width:120px; "
														onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo $_REQUEST["groupId"]; ?>','delgrp');">Delete
														This Group</a></div>
												<span><strong>Note: </strong>if you delete this group all the data will
													be lost (members, posts, likes, comments, images etc) which was
													associated with this group.</span>
											</div>
										</div>
									</div>
								</form>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>
	<?php if ($_REQUEST['groupId'] != '') { ?>
		<script>
			function reloadPage() {
				location.reload(true);
			}
		</script>
	<?php } ?>
</body>

</html>