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
	$totalm = "SELECT * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $rowGroup["id"] . " and status=1 and userId IN (select contactId from " . _CONTACT_MASTER_TABLE_ . " where userId=" . $_SESSION["sessUserId"] . " ) ";
	$retotalm = mysqli_query($conn, $totalm) or die(mysqli_error($conn));
	$mytotalgroups = mysqli_num_rows($retotalm);


	$mytotalgroups2 = 0;
	$totalm = "SELECT * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $rowGroup["id"] . " and status=1  ";
	$retotalm = mysqli_query($conn, $totalm) or die(mysqli_error($conn));
	$mytotalgroups2 = mysqli_num_rows($retotalm);

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

?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo stripslashes(trim($rowGroup["groupName"])); ?> Group - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
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
			<?php if (isset($acceptnotification) && $acceptnotification == 1) { ?>

				<div class="accept-notification">


					<?php echo $msgacceptnotification; ?>
				</div>
			<?php } ?>
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content">
					<div class="groups detail">
						<div class="mmbrof_group_list">
							<div class="grp-dtail-had">
								<div class="group-sec">
									<?php if ($rowGroup['userId'] == $_SESSION['sessUserId']) { ?>
										<a href="group-setting.html?groupId=<?php echo $_REQUEST['groupId']; ?>"
											class="grp-logo"> <img
												src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>">
										</a>
									<?php } else { ?>
										<img
											src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>"><?php } ?>
									<div style="position:relative;" class="edit-grp">


										<a style="cursor:default; text-decoration:none;"
											class="nm"><?php echo stripslashes(trim($rowGroup["groupName"])); ?></a>
										<label><?php echo substr(strip_tags(stripslashes(trim($rowGroup["groupDetails"]))), 0, 250); ?></label>
									</div>
									<div class="join-btn">
										<!--<a href="<?php echo $fullurl; ?>about-group.html?groupId=<?php echo encodeStr($rowGroup['id']); ?>">About this group</a>  -->
										<?php if ($mygroupid == 0) { ?><a
												href="common_action.php?groupId=<?php echo encodeStr($rowGroup['id']); ?>&action=publicgroupjoinrequest"
												target="actionfrm" class="konectt-btn"
												onClick="$('#commonloader').show();">Join group</a> <?php } ?>

										<?php if ($mygroupid1 == 0 && $mygroupid == 1) { ?><a class="konectt-btn"
												style="background-color:#18ad06;">Request sent</a> <?php } ?>
									</div>
								</div>
							</div>
						</div>



						<div class="posts_cont">

							<div class="post-list">

								<?php if ($rowGroup["groupLongDetails"] != '') { ?> <span class="admn"
										style="font-size:18px;">About this group</span><br>
									<div class="post">
										<div class="mmbrof_group_list">
											<div class="grp-dtail-had" style="padding:0px; line-height:18px;border: 0;">
												<div class="group-sec">

													<div style="position:relative;padding-left: 0 !important;">
														<?php echo getStrLength(strip_tags(stripslashes($rowGroup["groupLongDetails"])), 1000); ?>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>


								<div class="your-connction" style="border-top:0px;">
									<span class="admn">Your Contacts(<?php echo $mytotalgroups; ?>)</span>
									<ul>
										<?php
										$n = 0;
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$sqlGroupMembers = "";
										$sqlGroupMembers = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $rowGroup["id"] . " and status=1 and userId IN (select contactId from " . _CONTACT_MASTER_TABLE_ . " where userId=" . $_SESSION["sessUserId"] . " ) order by id desc LIMIT 0,16 ";
										$resGroupMembers = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
										if ($resGroupMembers) {
											while ($rowgroup = mysqli_fetch_array($resGroupMembers)) {

												$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $rowgroup["id"] . "";
												$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
												$row = mysqli_fetch_array($resgroup);

												if (isset($row["groupThumb"]) && $row["groupThumb"] != '') {
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

												?>
												<li>
													<div class="post">
														<span class="postimg"><a
																href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
																	src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"
																	title="<?php echo stripslashes(trim($userres["firstName"])); ?> <?php echo stripslashes(trim($userres["lastName"])); ?>"
																	alt="<?php echo stripslashes(trim($userres["firstName"])); ?> <?php echo stripslashes(trim($userres["lastName"])); ?>"></a></span>
														<div class="post-had-right">
															<a
																href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes(trim($userres["firstName"])); ?>
																<?php echo stripslashes(trim($userres["lastName"])); ?></a><br>

															<span
																style="color:#828282; font-size:12px;"><?php echo $userres["jobTitle"]; ?>
																at <?php echo $userres["companyName"]; ?></span>
														</div>
													</div>
												</li>
												<?php
												$n++;
											}
										}
										?>
									</ul>

								</div>
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
								<h4>Members (<?php echo $mytotalgroups2; ?>)</h4>
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

											$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $rowgroup["id"] . "";
											$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
											$row = mysqli_fetch_array($resgroup);

											if (isset($row["groupThumb"]) && $row["groupThumb"] != '') {
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

											?>
											<li><a
													href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
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
								<div class="grp-info" style="margin-top: 0px;">
									<h4>About this group</h4>
									<ul>
										<li>Founded: <span><?php echo date("d/m/Y", $rowGroup["dateAdded"]); ?></span>
										</li>
										<li>Members: <span><?php echo $mytotalgroups2; ?></span></li>
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
						</div>
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