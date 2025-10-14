<?php
include_once('inc.php');
include_once('config/session-check.inc.php');
$pageIndex = 3;
$msg = 1;
if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'lvg' && $_REQUEST['groupId'] != '') {
	$myvar = '' . $myname . ' has left this group';
	$sql_ins = "DELETE FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " where  userId=" . $_SESSION["sessUserId"] . " and groupId=" . decodeStr($_REQUEST['groupId']) . " ";
	mysqli_query($conn, $sql_ins) or die(error_found(mysqli_error($conn)));

	$dateAdded = time();
	$sql_ins = "insert into " . _GROUP_CHAT_MASTER_TABLE_ . " set status=1,bulbType=2,userId='" . $_SESSION["sessUserId"] . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . $myvar . "',groupId='" . decodeStr($_REQUEST["groupId"]) . "',msgType='text'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


}

if (isset($_FILES['privategroupphotofile']['name']) && $_FILES['privategroupphotofile']['name'] != '') {


	$strFileExtention = findExtension($_FILES['privategroupphotofile']['name']);
	if ($strFileExtention == 'jpg' || $strFileExtention == 'jpeg' || $strFileExtention == 'png' || $strFileExtention == 'gif') {




		$oldphoto = trim($_POST['privategroupOldfile']);
		if ($oldphoto != '' && $oldphoto != 'group.png') {
			unlink("uploads/" . $oldphoto);
		}

		$timename = time();
		$file_name = $_FILES['privategroupphotofile']['name'];

		$file_name = $timename . $file_name;
		copy($_FILES['privategroupphotofile']['tmp_name'], "uploads/" . $file_name);


		$upimg = 'uploads/' . $file_name;

		image_fix_orientation($upimg);
		generate_image_thumbnail($upimg, $upimg, '120', '120');



		$sql_ins = "update " . _GROUP_MASTER_TABLE_ . " set groupThumb='$file_name' where id=" . decodeStr($_REQUEST['groupId']) . " and userId= " . $_SESSION["sessUserId"] . "";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	}

	header("location:private-group.html?groupId=" . $_REQUEST['groupId'] . "");

}



if (isset($_SESSION['sesgroupId']) && $_SESSION['sesgroupId'] != '') {

	$sqlCheck = mysqli_query($conn, "SELECT * FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE userId=" . intval($_SESSION["sessUserId"]) . " AND groupId=" . intval(decodeStr($_REQUEST['groupId'])));

	if (mysqli_num_rows($sqlCheck) > 0) {
	} else {
		$insertFields = [];
		$insertVals = [];
		$whereFields = [];
		$whereVals = [];

		$insertFields[0] = "status";
		$insertFields[1] = "userId";
		$insertFields[2] = "groupId";
		$insertFields[3] = "dateAdded";

		$insertVals[0] = 1;
		$insertVals[1] = $_SESSION['sessUserId'];
		$insertVals[2] = decodeStr($_REQUEST['groupId']);
		$insertVals[3] = time();

		$resInsert = insertDB(_GROUP_MEMBER_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		$acceptnotification = 1;
		$msgacceptnotification = "You have successfully joined this group.";
	}
	$_SESSION['sesgroupId'] = '';

}

if (isset($_SESSION['status']) && $_REQUEST['groupId'] != '' && $_REQUEST['status'] != '') {

	$sql_ins = "update " . _GROUP_MASTER_TABLE_ . " set groupStatus=" . $_REQUEST['status'] . " where id=" . decodeStr($_REQUEST['groupId']) . " and userId='" . $_SESSION["sessUserId"] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
}


if ($_REQUEST['groupId'] != '') {
	$sql_checkmember = "SELECT * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . decodeStr($_REQUEST['groupId']) . " and userId='" . $_SESSION["sessUserId"] . "'";
	$rescheckmember = mysqli_query($conn, $sql_checkmember) or die(error_found(mysqli_error($conn)));
	$rowcheckGroup = mysqli_fetch_array($rescheckmember);
	if ($rowcheckGroup['userId'] != $_SESSION["sessUserId"]) {
		header('Location:my-groups.html');
		exit();
	}
	$yesmember = $rowcheckGroup['userStatus'];

}

$sql_ins = "DELETE FROM " . _GROUP_GOT_MSG_TABLE_ . " WHERE  groupId=" . decodeStr($_REQUEST['groupId']) . " and userId='" . $_SESSION["sessUserId"] . "'  ";
mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

if ($_REQUEST['groupId'] != '') {
	$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['groupId']) . " ";
	$resgroup = mysqli_query($conn, $sql_group) or die(error_found(mysqli_error($conn)));
	$rowGroup = mysqli_fetch_array($resgroup);

	if ($rowGroup["groupThumb"] != '') {
		$groupThumb = $rowGroup["groupThumb"];
	} else {
		$groupThumb = 'group.png';
	}
	$mytotalgroups = 0;

	$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowGroup["userId"] . "";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$userres = mysqli_fetch_array($b);

	$friendnameurl = $userres['userurl'];

	if ($userres["profilePhoto"] != '') {
		$userphoto = $userres["profilePhoto"];
	} else {
		$userphoto = 'user-placeholder.jpg';
	}




	$totalm = "SELECT * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " and status=1 and groupId IN(select id from " . _GROUP_MASTER_TABLE_ . " where groupType=1)";
	$retotalm = mysqli_query($conn, $totalm) or die(mysqli_error($conn));
	$mytotalgroups = mysqli_num_rows($retotalm);



}

?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo stripslashes(trim($rowGroup["groupName"])); ?> - Group - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<script type="text/javascript">
		$(document).ready(function () { $(document).click(function (e) { if ($(e.target).is('.btn-going,.rugo,.fa-chevron-down')) { $('.go-btn-list').show(); } else { $('.go-btn-list').hide(); } }); });
	</script>
	<style>
		ul.nav_list li.createad {
			display: none;
		}

		.searchfldbox {
			position: absolute;
			right: 10px;
			top: 45px;
			background-color: #fff;
			padding: 10px;
			z-index: 99;
			width: 290px;
			border: 1px #f1f1f1 solid;
			box-shadow: 4px 4px 5px #bdbdbd;
			background-color: white;
			max-height: 300px;
			padding-bottom: 10px;
		}

		ul.nav_list li.user .usr-right {
			display: none;
		}

		.no-paddinggroup {
			padding: 0 !important;
		}

		ul.nav_list li {
			padding-bottom: 5px;
		}

		.greentick {
			color: #2cc31a;
			font-size: 18px;
			position: absolute;
			right: 3px;
			top: 9px;
		}


		.gchatlist-right span.nm {
			display: inline-block;
		}

		.gchatlist-right span.nm label {
			font-weight: normal !important;
			margin-left: -6px;
		}

		.grp-chat-cntnt .usr img {
			max-width: 30px;
			margin-left: 4px;
			margin-top: 5px;
			border-radius: 50%;
		}

		ul.grp-chat-list li.me span.nm {
			display: none;
		}

		.grp-chat-cntnt .gchatlist-right {
			min-height: 35px;
			padding-left: 40px;
		}

		ul.grp-chat-list li {
			float: left;
			margin-top: 22px !important;

			border-radius: 8px;
			margin-bottom: 20px;
			max-width: 55%;
			width: auto;
			clear: both;
			margin-top: 0;
			margin-left: 0;
		}

		ul.grp-chat-list li.me .chat-txt {
			background-color: transparent;
			box-shadow: none;
			padding: 8px;
		}

		.gchatlist-right .time {
			position: absolute;
			bottom: -18px;
			left: 40px;
			color: #999;
			white-space: nowrap;
		}

		ul.grp-chat-list li.me {
			float: right;
			background-color: #00a0af;
			color: #fff;
			margin-right: 10px;
			margin-top: 15px;
			position: relative;
			box-shadow: 0 0 0 1px rgba(0, 0, 0, .1), 0 1px 1px rgba(0, 0, 0, .1);
		}

		ul.grp-chat-list li span.shared-file {
			margin-top: 0;
		}

		ul.grp-chat-list li.me .gchatlist-right .time {
			position: absolute;
			bottom: -18px;
			padding-right: 8px;
			color: #999;
			text-align: right;
			left: inherit;
			right: 0;
			white-space: nowrap;
		}

		ul.grp-chat-list li.me .grp-chat-cntnt {
			position: static;
		}

		ul.grp-chat-list li.me .chat-txt a {
			color: #fff;
		}

		ul.grp-chat-list li.me span.usr {
			display: none;
		}

		ul.grp-chat-list li.me .gchatlist-right {
			padding-left: 0;
			min-height: inherit;
		}

		ul.grp-chat-list li .file-box span.fl-box-right {
			width: 118px;
			margin-top: 0;
		}

		.file-box span.photo-file img {
			max-width: inherit;
			width: 100%;
			border-radius: 8px;
			display: block;
		}

		.file-box.photo {
			padding: 0px !important;
			background-color: transparent !important;
			width: 100%;
			overflow: hidden;
			margin-top: 0;
		}

		.gchatlist-right .chat-txt {
			padding-right: 0;
			font-size: 15px;
			padding: 8px;
			background-color: #e6e9ec;
			border-radius: 8px;
			overflow: hidden;
			line-height: inherit;
			box-shadow: 0 0 0 1px rgba(0, 0, 0, .1), 0 1px 1px rgba(0, 0, 0, .1);
		}

		.file-box {
			border: 0px !important;
		}

		.filename {
			margin-top: 6px;
			padding: 0px 5px 5px 5px;
			float: left;
			font-size: 12px;
		}

		ul.grp-chat-list li.me span.shared-file label {
			color: #abe1fb;
			font-size: 11px;
		}

		ul.grp-chat-list li span.shared-file label {
			color: #8c8c8c;
			font-size: 11px;
		}

		ul.grp-chat-list li span.shared-file .file-box {
			padding: 0;
			margin: 0;
		}

		ul.grp-chat-list li span.shared-file .file-box:hover {
			background-color: inherit;
		}

		span.fl-box-right h4 {
			font-weight: 100;
			text-overflow: ellipsis;
			overflow: hidden;
			white-space: nowrap;
		}

		.me .contct-namnumber label.nm {
			color: #fff !important;
		}

		.me .contct-namnumber label {
			font-size: 14px;
			color: #fff !important;
			line-height: 15px;
		}
	</style>
</head>

<body>
	<div id="wrapper" class="active">
		<?php include('header.php'); ?>
		<div class="container main">
			<?php if (isset($acceptnotification) && $acceptnotification == 1) { ?>

				<div class="accept-notification"><?php echo $msgacceptnotification; ?></div>
			<?php } ?>
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content">
					<div class="my-message grup-dtail bx-shadow" id="prgroup">
						<div class="chat_list">
							<h3>Groups (<?php echo $mytotalgroups; ?>)</h3>
							<!-- <div class="search-friend"><input type="text" name="" value="" placeholder="Search friends"><img src="images/search_icon.png"></div> -->

							<ul class="cht_mmbr_list" id="loadgrouplist">



							</ul>
							<script>
								//$('#loadgrouplist').load('loadgrouplist.php?groupId=<?php echo $_REQUEST["groupId"]; ?>');
							</script>
						</div>
						<div class="chat_box">
							<div class="heddr private-group">
								<img
									src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>">
								<div class="right-cht-had">
									<div class="grp-ttl"><?php echo stripslashes(trim($rowGroup["groupName"])); ?></div>



									<div class="btn-going">
										<a class="rugo"
											style="font-size: 13px; background-color: #fff; color: #636363;border: 1px solid #ccc;padding: 5px 7px;margin-top: 1px;">Options<i
												class="fa fa-chevron-down" aria-hidden="true"></i></a>
										<ul class="go-btn-list"
											style="width: 172px; font-size: 12px; left: -96px; display:none;">
											<?php if ($_SESSION["sessUserId"] == $rowGroup['userId']) { ?>
												<li><a
														onClick="$('#inviteemail').show();$('#sentmsgtextdiv').hide();$('#showinvitediv').show();$('#hideinvitediv').hide();$('#txtuseremail').focus();">Invite
														By Email </a></li>
												<li><a style="font-size: 14px;" id="changegroupphoto">Change Group Image</a>
												</li>

												<li><a style="font-size: 14px;"
														onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl; ?>loadgroupblockunblock.php?id=<?php echo $_REQUEST["groupId"]; ?>','Block/Unblock Users');">Block/Unblock
														Users</a></li>
												<?php if ($rowGroup['groupStatus'] == 0) { ?>
													<li><a href="<?php echo $fullurl; ?>privategroup.php?groupId=<?php echo $_REQUEST["groupId"]; ?>&status=1"
															style="font-size: 14px;">Block This Group</a></li>
												<?php } else { ?>
													<li><a href="<?php echo $fullurl; ?>privategroup.php?groupId=<?php echo $_REQUEST["groupId"]; ?>&status=0"
															style="font-size: 14px;">Unblock This Group</a></li><?php } ?>

												<li><a style="font-size: 14px;"
														onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo $_REQUEST["groupId"]; ?>','delgrp');">Delete
														This Group</a></li>

												<form enctype="multipart/form-data" name="frmgroup" id="frmgroup"
													method="post">
													<input name="privategroupphotofile" id="privategroupphotofile"
														type="file"
														onChange="$('#frmgroup').submit();$('#commonloader').show();"
														style="display:none;" accept="image/x-png,image/gif,image/jpeg">
													<input type="hidden" name="privategroupOldfile" id="privategroupOldfile"
														value="<?php echo stripslashes(trim($groupThumb)); ?>" />
													<input type="hidden" name="groupId" id="groupId"
														value="<?php echo $_REQUEST["groupId"]; ?>" />
												</form>
											<?php } else { ?>
												<li><a onClick="funcommonpopupwin('410px','auto','<?php echo $fullurl; ?>common_popup_inner.php?groupId=<?php echo $_REQUEST["groupId"]; ?>&type=leavegroup','Alert');"
														style="font-size: 14px;">Leave this group</a></li>
											<?php } ?>
										</ul>
									</div>


								</div>
							</div>
							<div class="chats">
								<div class="loader"></div>
								<?php if ($yesmember == 0) { ?>
									<ul class="grp-chat-list" id="groupchatlist">
										Loading...
									</ul>
								<?php } ?>
								<script>
									<?php if ($yesmember == 0) { ?>
										$('#groupchatlist').load('groupchatlist.php?groupId=<?php echo $_REQUEST["groupId"]; ?>');

										setInterval(function () {
											$('#groupnewchatlist').load('autoload_groupchatlist.php?groupId=<?php echo $_REQUEST["groupId"]; ?>');
										}, 4000);

									<?php } ?>
									setInterval(function () {
										$('#loadgrouplist').load('loadgrouplist.php?groupId=<?php echo $_REQUEST["groupId"]; ?>');
									}, 15000);

									$('#loadgrouplist').load('loadgrouplist.php?groupId=<?php echo $_REQUEST["groupId"]; ?>');
								</script>

							</div>
							<iframe id="actionfrm" name="actionfrm" style="display:none;"></iframe>
							<div class="chat_fttr">
								<?php if ($yesmember == 0) { ?>

									<?php if ($rowGroup["groupStatus"] == 0) { ?>
										<ul class="emozi">
											<li><a id="sendphoto1"><i class="fa fa-paperclip" aria-hidden="true"></i></a></li>
											<!--  <li><a onClick="posrturl();showloading('sharepopinner');"><i class="fa fa-link" aria-hidden="true"></i></a></li> -->
											<!--<li><a><i class="fa fa-picture-o" aria-hidden="true"></i></a></li>-->
										</ul>
										<form class="edit-layer" enctype="multipart/form-data" name="frmposthome2"
											id="frmposthome2" onSubmit="$('#sharepopup').show();showloading('sharepopinner');"
											method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
											<span id="hpotohomeid">
												<input name="myphotofile" id="myphotofile" type="file"
													onChange="homeuploadfun();" style="display:none;"
													accept="image/x-png,image/gif,image/jpeg,application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf">
											</span>
											<input type="hidden" name="action" id="action" value="uploadgroupimage" />
											<input type="hidden" name="groupId" id="groupId"
												value="<?php echo $_REQUEST["groupId"]; ?>" />
										</form>

										<script>
											function homeuploadfun() {
												$('#frmposthome2').submit();
												// $('#commonloader').show();

												var hpotohomeid = $('#hpotohomeid').html();

												$('#myphotofile').remove();
												$('#hpotohomeid').html(hpotohomeid);

											}
										</script>


										<div class="grp-chat-fttr"> <input type="text" name="groupchatfield" id="groupchatfield"
												maxlength="250" placeholder="Write a message here...">
											<input type="hidden" name="groupchatuserid" id="groupchatuserid" />
											<input type="hidden" name="msgType" id="msgType" value="text" />

											<button type="button" onClick="grouptypeandsendchat();"
												class="bgcolororange">send</button>
										</div>
									<?php } else { ?>

										<div style="padding:23.5px; text-align:center;">This group blocked.</div>


									<?php }
								} else { ?>
									<div style="padding:23.5px; text-align:center;">You are blocked by group admin.</div>
								<?php } ?>
							</div>
						</div>
						<div class="chat_list mmbr">
							<h3>Members (<span id="memberc">0</span>) </h3>
							<?php if ($_SESSION["sessUserId"] == $rowGroup['userId']) { ?>
								<div class="search-friend" style="position:relative;"><input type="text"
										name="searchcontacts" id="searchcontacts" value="" placeholder="Invite Contacts"
										onKeyUp="contactsearch();"><img src="images/search_icon.png">
									<div class="searchfldbox" id="groupcontactinner" style="display:none;">


									</div>
								</div>
							<?php } ?>



							<ul class="cht_mmbr_list" id="loadgroupuserlist">



							</ul>





							<script>
								function contactsearch() {
									var keyword = encodeURIComponent($("#searchcontacts").val());
									$("#groupcontactinner").load('groupcontactinner.php?keyword=' + keyword + '&groupId=<?php echo $_REQUEST["groupId"]; ?>');
								}

								$('#loadgroupuserlist').load('loadgroupuserlist.php?id=<?php echo $_REQUEST["groupId"]; ?>');

							</script>


						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include('footer.php'); ?>
		<input type="hidden" name="livechattotalpage" id="livechattotalpage" value="1" />
	</div>
	<script>

		function grouptypeandsendchat() {
			var groupchatfield = $('#groupchatfield').val();
			groupchatfield = encodeURIComponent($.trim(groupchatfield));
			var msgType = $('#msgType').val();


			if (groupchatfield != '') {
				$('#grouptextchatactiondiv').load('<?php echo $fullurl; ?>common_action.php?groupId=<?php echo $_REQUEST['groupId']; ?>&action=groupchat&grouptext=' + groupchatfield + '&msgType=' + msgType);

			}
			$("#groupchatfield").val('');

		}

		$("#groupchatfield").keypress(function (e) {
			if (e.which == 13) {
				grouptypeandsendchat();
			}
		});


		function showloading(id) {
			$('#' + id).html('<div style="text-align:center;margin-bottom: 10px;"><img src="images/mainloading.gif"></div>');
		}




		function reloadPage() {
			location.reload(true);
		}


		$('#sendphoto1').click(function () {
			$('#myphotofile').click();
		});


		$('#changegroupphoto').click(function () {
			$('#privategroupphotofile').click();
		});


		function posrturl() {
			$('#sharepopup').show();
			$('#sharepopup h2').text('Post URL');
			$('#sharepopinner').load("sharepopupinner.php?urlgroupId=<?php echo $_REQUEST['groupId']; ?>");
		}

		function groupimagepopupmain(id) {
			$('#groupimagepopup').html('<div class="postimageloading">Loading</div>');
			$('#groupimagepopup').show();
			$('#groupimagepopup').load(fullurl + 'groupimagepopup.php?imgId=' + id);
		}



		function loadmorechatbox(startpage, groupId) {
			var pageid = $("#livechattotalpage").val();
			pageid = Number(pageid) + 1;
			$("#livechattotalpage").val(pageid);
			$("#pageid" + pageid).html('<div style="text-align:center;">Wait please...</div>');
			$("#pageid" + pageid).load('<?php echo $fullurl; ?>groupchatlist_more.php?startfrom=' + startpage + '&pageid=' + pageid + '&groupId=' + groupId + '&myIdxxxxxxxxx=<?php echo $_SESSION["sessUserId"]; ?>');

		}

	</script>
	<div class="img-popup" id="groupimagepopup" style="display:none;">
	</div>

	<div style="display:none;" id="grouptextchatactiondiv"></div>
	<div style="display:none;" id="groupnewchatlist"></div>
	<script>
		function reloadPage() {
			location.reload(true);
		}
	</script>
	<div id="sendalert" style="display:none;"></div>
</body>

</html>