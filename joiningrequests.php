<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 6;
$errMsg = '';

if ($_REQUEST['groupId'] != '') {
	$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['groupId']) . " ";
	$resgroup = mysqli_query($conn, $sql_group) or die(error_found($conn));
	$rowGroup = mysqli_fetch_array($resgroup);

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

	$groupsql = "SELECT id from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE userId= " . $_SESSION['sessUserId'] . " and groupId=" . decodeStr($_REQUEST['groupId']) . " ";
	$resultgroup = mysqli_query($conn, $groupsql) or die(mysqli_error($conn));
	$mygroupid = mysqli_num_rows($resultgroup);

	$groupsql1 = "SELECT id from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE userId= " . $_SESSION['sessUserId'] . " and groupId=" . decodeStr($_REQUEST['groupId']) . " and status=1 ";
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
										src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>">
									<span> <a style="cursor:default; text-decoration:none;"
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
									<li><a href="<?php echo $fullurl; ?>joining-requests.html?groupId=<?php echo encodeStr($rowGroup['id']); ?>"
											class="active">Joining requests</a></li>
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
							<div class="post-list" style="width:100%;">
								<div class="grp-setting">
									<h2>Joining requests&nbsp;<?php if ($errMsg != '') { ?>
											<div><?php //echo $errMsg; ?></div> <?php } ?>
									</h2>


									<?php
									$n = 0;
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];

									$sqlRequests = "";
									$sqlRequests = "select * from " . _NOTIFICATION_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and contactId!='" . $_SESSION['sessUserId'] . "' and notificationText='grouprequest' order by dateAdded desc";
									$resRequests = getRecords(_NOTIFICATION_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlRequests);
									if ($resRequests) {
										?>

										<ul class="joining-requests-list">
											<?php
											while ($rowRequests = mysqli_fetch_array($resRequests)) {

												$friendnameurl = '';
												$userphoto = '';
												$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowRequests["contactId"] . "";
												$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
												$requestuser = mysqli_fetch_array($b);

												$friendnameurl = $requestuser['userurl'];

												if ($requestuser["profilePhoto"] != '') {
													$userphoto = $requestuser["profilePhoto"];
												} else {
													$userphoto = 'user-placeholder.jpg';
												}
												$requestuserid = encodeStr($requestuser['userId']);
												$requestName = $requestuser["firstName"] . ' ' . $requestuser["lastName"];
												$mycountryName = $requestuser["countryName"];
												$mystateName = $requestuser["cityName"];
												$mylocationName = $requestuser["locationName"];




												if ($rowRequests["groupId"] != '') {

													$sql_groupName = "SELECT id,groupName from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $rowRequests["groupId"] . " ";
													$resgroupName = mysqli_query($conn, $sql_groupName) or die(mysqli_error($conn));
													$rowGroupName = mysqli_fetch_array($resgroupName);
													$requestgroupname = $rowGroupName['groupName'];
													$requestgroupid = encodeStr($rowGroupName['id']);

												}
												?>

												<?php if ($rowRequests['postType'] == 4) { ?>

													<li>
														<div class="rquest-box">
															<a href="<?php echo $fullurl; ?>profile/<?php echo $requestuserid; ?>/<?php echo $friendnameurl; ?>.html"
																target="_blank" class="rqst-img"><img
																	src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>

															<div class="rqst-right">
																<div class="rquest-middle">
																	<a href="<?php echo $fullurl; ?>profile/<?php echo $requestuserid; ?>/<?php echo $friendnameurl; ?>.html"
																		target="_blank" class="nm"
																		style="font-size:14px;"><?php echo $requestName; ?></a>
																	<!--<a href="#" target="_blank" class="nm">mohd imran</a>-->
																	<span class="timelinecontantsubline"
																		style="font-size:14px;">wants to join your <a
																			href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo $requestgroupid; ?>"
																			target="_blank" class="nm"
																			style="font-size:13px;"><?php echo $requestgroupname; ?></a>
																		group </span>
																	<div class="add-frnd">
																		<a href="<?php echo $fullurl; ?>common_action.php?userId=<?php echo $requestuserid; ?>&joinedGroupId=<?php echo $requestgroupid; ?>&action=actgrouprequest&page=1"
																			target="actionfrm" style="color: white;">Confirm </a>
																		<a href="<?php echo $fullurl; ?>common_action.php?userId=<?php echo $requestuserid; ?>&dltGroupId=<?php echo $requestgroupid; ?>&action=publicdltgrouprequest&page=1"
																			target="actionfrm" class="dlt">Decline</a>
																	</div>
																	<label><?php echo makedatetime($rowRequests["dateAdded"]); ?></label>
																</div>
															</div>
														</div>
													</li>

													<?php if ($rowRequests['notificationText'] == 'grouprequest') { ?>


													<?php } ?>

												<?php } ?>

												<?php $n++;
											}
											?>
										</ul>
									<?php } ?>
									<?php
									if ($n == 0) {
										?>
										<div style="padding:20px; text-align:center; overflow:hidden;">No pending requests
										</div>
										<?php
									}
									?>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>
	<script>
		function reloadPage() {
			location.reload(true);
		}

	</script>
</body>

</html>