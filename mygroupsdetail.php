<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 6;


if (isset($_SESSION['sesgroupId']) && $_SESSION['sesgroupId'] != '') {
	$groupId = decodeStr($_REQUEST['groupId']);
	$userId = $_SESSION["sessUserId"];

	$sqlCheck = mysqli_query($conn, "SELECT * FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE userId=" . intval($userId) . " AND groupId=" . intval($groupId));

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



if ($_REQUEST['groupId'] != '') {
	$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['groupId']) . " ";
	$resgroup = mysqli_query($conn, $sql_group) or die(error_found(mysqli_error($conn)));
	$rowGroup = mysqli_fetch_array($resgroup);

	if ($rowGroup['id'] == '') {
		header("Location: " . $fullurl . "404error.html");
		exit();
	}
	if ($rowGroup["groupThumb"] != '') {
		$groupThumb = $rowGroup["groupThumb"];
	} else {
		$groupThumb = 'group.png';
	}
	$mytotalgroups = 0;
	$totalm = "SELECT * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $rowGroup["id"] . " and status=1";
	$retotalm = mysqli_query($conn, $totalm) or die(mysqli_error($conn));
	$mytotalgroups = mysqli_num_rows($retotalm);

	$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowGroup["userId"] . "";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$userGroupres = mysqli_fetch_array($b);

	$groupOwnerurl = $userGroupres['userurl'];

	if ($userGroupres["profilePhoto"] != '') {
		$groupOwnerPhoto = $userGroupres["profilePhoto"];
	} else {
		$groupOwnerPhoto = 'user-placeholder.jpg';
	}



}

$groupsql = "SELECT id from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE userId= " . $_SESSION['sessUserId'] . " and groupId=" . decodeStr($_REQUEST['groupId']) . " ";
$resultgroup = mysqli_query($conn, $groupsql) or die(mysqli_error($conn));
$mygroupid = mysqli_num_rows($resultgroup);

$groupsql1 = "SELECT id from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE userId= " . $_SESSION['sessUserId'] . " and groupId=" . decodeStr($_REQUEST['groupId']) . " and status=1 ";
$resultgroup1 = mysqli_query($conn, $groupsql1) or die(mysqli_error($conn));
$mygroupid1 = mysqli_num_rows($resultgroup1);


$sql_ins = "DELETE FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND postType=0  and groupId=" . decodeStr($_REQUEST['groupId']) . "";
mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


$sql_ins = "INSERT INTO " . _SHAREANDUPDATES_TABLE_ . " SET userId= " . $_SESSION["sessUserId"] . ",groupId=" . decodeStr($_REQUEST['groupId']) . "";
$resresult2 = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


$sql_inss = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND postType=0  and groupId=" . decodeStr($_REQUEST['groupId']) . "";
$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
$rowResults = mysqli_fetch_array($resresults);
$grouppostId = $rowResults["id"];

if ($rowGroup["userId"] != $_SESSION["sessUserId"]) {
	if ($mygroupid > 0 && $mygroupid1 > 0) {

	} else {
		header('Location:' . $fullurl . 'ask-join-group.html?groupId=' . $_REQUEST['groupId']);
	}
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

	<meta property="og:title" content="<?php echo stripslashes(trim($rowGroup["groupName"])); ?>" />

	<meta property="og:image" content="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>" />
	<meta property="og:site_name" content="<?php echo $fullurl; ?>" />
	<meta property="og:description"
		content="<?php echo substr(stripslashes(strip_tags($rowGroup["groupDetails"])), 0, 250); ?>" />
	<meta property="og:type" content="Groups" />
	<meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />


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
			<?php
			$acceptnotification = isset($row['acceptnotification']) ? $row['acceptnotification'] : 0; // default to 0
			
			?>
			<?php if ($acceptnotification == 1) { ?>
				<div class="accept-notification"><?php echo $msgacceptnotification; ?></div>
			<?php } ?>
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content" style="min-height:500px;box-shadow: inherit !important;overflow: visible;">
					<div class="groups detail bx-shadow" style="">
						<div class="mmbrof_group_list">
							<div class="grp-dtail-had">
								<div class="group-sec">
									<?php if ($rowGroup['userId'] == $_SESSION['sessUserId']) { ?>
										<a href="<?php echo $fullurl; ?>group-setting.html?groupId=<?php echo $_REQUEST['groupId']; ?>"
											class="grp-logo"> <img
												src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>">
											<span class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></span>
										</a>
									<?php } else { ?>
										<img
											src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>"><?php } ?>
									<div style="position:relative;" class="edit-grp">

										<?php if ($rowGroup['userId'] == $_SESSION['sessUserId']) { ?>
											<a href="<?php echo $fullurl; ?>about-group.html?groupId=<?php echo $_REQUEST['groupId']; ?>"
												class="btn"><i class="fa fa-pencil" aria-hidden="true"></i> Edit
												Group</a><?php } ?>

										<a style="cursor:default; text-decoration:none;"
											class="nm"><?php echo stripslashes(trim($rowGroup["groupName"])); ?></a>
										<label><?php echo getStrLength(strip_tags(stripslashes($rowGroup["groupDetails"])), 500); ?></label>
										<?php if ($rowGroup['status'] != 0) { ?>
											<div style="color:#FF0000; margin-top:10px;" class="deactivategrp">Deactivated
												group</div><?php } ?>
									</div>
									<div class="join-btn"><?php if ($mygroupid == 0) { ?><a
												href="<?php echo $fullurl; ?>common_action.php?groupId=<?php echo encodeStr($rowGroup['id']); ?>&action=groupjoinrequest"
												target="actionfrm" class="konectt-btn"
												onClick="$('#commonloader').show();">Join group</a> <?php } ?>

										<?php if ($mygroupid1 == 0 && $mygroupid == 1) { ?><a class="konectt-btn"
												style="background-color:#18ad06;">Request sent</a> <?php } ?>

										<?php //if($mygroupid1>0) { ?><!--<a  onclick="alertpopupmain('<?php echo $_REQUEST["groupId"]; ?>','leavepublicgrp');" class="konectt-btn">Leave this group</a>-->
										<?php //} ?>

									</div>
								</div>
							</div>
						</div>
						<?php if ($rowGroup['status'] == 0 || $rowGroup['userId'] == $_SESSION['sessUserId']) { ?>

							<?php
							$a = "SELECT id from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . decodeStr($_REQUEST['groupId']) . " and userId=" . $_SESSION['sessUserId'] . " and status=1 and userStatus=0";
							$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
							$groupblockuser = mysqli_num_rows($b);

							if ($groupblockuser == 1) { ?>
								<div class="posts_cont">
									<ul class="cntr_tab">
										<li><a href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($rowGroup['id']); ?>"
												class="active">Posts</a></li>
										<?php if ($rowGroup['userId'] == $_SESSION['sessUserId']) { ?>
											<li><a
													href="<?php echo $fullurl; ?>joining-requests.html?groupId=<?php echo encodeStr($rowGroup['id']); ?>">Joining
													requests</a></li>
										<?php } ?>
										<li><a
												href="<?php echo $fullurl; ?>about-group.html?groupId=<?php echo encodeStr($rowGroup['id']); ?>">About
												this group</a></li>
										<?php if ($rowGroup['userId'] == $_SESSION['sessUserId']) { ?>
											<li><a
													href="<?php echo $fullurl; ?>group-setting.html?groupId=<?php echo encodeStr($rowGroup['id']); ?>">Group
													setting</a></li>
											<li><a
													onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=invitegrpcontacts&groupId=<?php echo encodeStr($rowGroup['id']); ?>','Invite Contacts');">Invite
													contacts</a></li>
										<?php } ?>

									</ul>
									<?php if ($rowGroup['status'] == 0) { ?>
										<div class="post-list">
											<ul>
												<li>
													<div class="post"> <?php if ($mygroupid > 0 && $mygroupid1 > 0) { ?><span
																class="postimg"><img
																	src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($profilePhoto)); ?>"></span>

															<div class="post-had-right">
																<a><?php echo stripslashes(trim($myfirstName . ' ' . $mylastName)); ?></a>
																<?php if ($rowGroup['status'] == 0) { ?>
																	<a class="post-type" onClick="$('#grouppostpopup').show();">Type your
																		post</a>
																<?php } ?>
															</div>
														<?php } ?>






														<div class="grp-post-sec">
															<div class="timeline_cont" style="padding:0px;">
																<div id="loadtimeline1">
																	Loading...
																</div>

															</div>
														</div>
													</div>
												</li>
											</ul>
										</div>
										<div class="about-group">
											<div class="modator" style="padding-bottom: 0px;">
												<h4>Moderators</h4>
												<div class="grup-admn"> <a
														href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userGroupres['userId']); ?>/<?php echo $groupOwnerurl; ?>.html"><img
															src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupOwnerPhoto)); ?>"></a>
													<div class="admn-nm"><a
															href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userGroupres['userId']); ?>/<?php echo $groupOwnerurl; ?>.html"><?php echo stripslashes(trim($userGroupres["firstName"])); ?>
															<?php echo stripslashes(trim($userGroupres["lastName"])); ?></a> <span
															class="comp"><a> <?php echo $userGroupres["companyName"]; ?></a></span>
													</div>
												</div>
												<!-- <a class="dtl" href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userGroupres['userId']); ?>/<?php echo $groupOwnerurl; ?>.html">Moderator details</a>-->
											</div>
											<h4>Members (<?php echo $mytotalgroups; ?>)</h4>
											<ul class="grp-mmbr_list">
												<?php
												$n = 0;
												$selectFields = [];
												$whereFields = [];
												$whereVals = [];

												$sqlGroupMembers = "";
												$sqlGroupMembers = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $rowGroup["id"] . " and status=1 order by id desc LIMIT 0,16 ";
												$resGroupMembers = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
												if ($resGroupMembers) {
													while ($rowgroup = mysqli_fetch_array($resGroupMembers)) {

														$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $rowgroup["groupId"] . "";
														$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
														$row = mysqli_fetch_array($resgroup);

														if ($row["groupThumb"] != '') {
															$groupThumb = $row["groupThumb"];
														} else {
															$groupThumb = 'group.png';
														}

														$friendnameurl = '';
														$userphoto = '';
														$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowgroup["userId"] . "";
														$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
														$userres = mysqli_fetch_array($b);

														$friendnameurl = $userres['userurl'];

														if ($userres["profilePhoto"] != '') {
															$userphoto = $userres["profilePhoto"];
														} else {
															$userphoto = 'user-placeholder.jpg';
														}
														if ($_SESSION["sessUserId"] == $row["userId"]) {
															$poptitle = 'Block/Unblock Users';
														} else {
															$poptitle = 'Group Members';

														} ?>
														<li><a
																onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>loadgroupblockunblock.php?id=<?php echo $_REQUEST["groupId"]; ?>','<?php echo $poptitle; ?>');"><img
																	src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"
																	title="<?php echo stripslashes(trim($userres["firstName"])); ?> <?php echo stripslashes(trim($userres["lastName"])); ?>"
																	alt="<?php echo stripslashes(trim($userres["firstName"])); ?> <?php echo stripslashes(trim($userres["lastName"])); ?>"></a>
														</li>
														<?php
														$n++;
													}
												}
												?>
											</ul>
											<div class="grp-info">
												<h4>About this group</h4>
												<ul>
													<li>Founded: <span><?php echo date("d/m/Y", $rowGroup["dateAdded"]); ?></span>
													</li>
													<li>Members: <span><?php echo $mytotalgroups; ?></span></li>
													<li>Posts: <span>
															<?php

															$totalc = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE groupId= " . $rowGroup["id"] . " and shareType!=0";
															$retotalc = mysqli_query($conn, $totalc) or die(mysqli_error($conn));
															echo mysqli_num_rows($retotalc);
															?></span></li>
													<li>Comments: <span><?php

													$totalc1 = "SELECT id from " . _COMMENT_MASTER_TABLE_ . " WHERE postId IN(select id from " . _SHAREANDUPDATES_TABLE_ . " where groupId= " . $rowGroup["id"] . " )";
													$retotalc1 = mysqli_query($conn, $totalc1) or die(mysqli_error($conn));
													echo mysqli_num_rows($retotalc1);
													?></span></li>
												</ul>
											</div>
										</div>
									<?php } ?>
								</div>
							<?php } else {
								?>
								<div
									style="background:#FFFFFF; padding:30px; text-align:center; font-size:14px; float:left; width:100%;">
									You are blocked by group admin</div>
								<?php
							}


						} ?>
					</div>
				</div>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>


	<script>
		loadgrouptimeline(1, 0, 20, <?php echo decodeStr($_REQUEST['groupId']); ?>);

		function reloadPage() {
			location.reload(true);
		}


		$('#my-button').click(function () {
			$('#groupimagefilehome').click();
		});
	</script>

	<style>
		.edit {
			position: absolute;
			right: 0;
			text-align: center;
			width: 20px !important;
			height: 20px;
			background-color: #a29f9f;
			line-height: 20px;
			border-radius: 50%;
			bottom: 0;
			color: white;
			font-size: 11px !important;
		}
	</style>
</body>

</html>