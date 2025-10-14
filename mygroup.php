<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 6;
$pagetab = 1;
?>

<?php
$n = 0;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlGroup = "";
$sqlGroup = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and status=1 order by dateAdded desc ";
$resGroup = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroup);


$aa = "SELECT id from " . _GROUP_MASTER_TABLE_ . " WHERE id IN(select groupId from " . _GROUP_MEMBER_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and status=1  ) and groupType=1";
$bb = mysqli_query($conn, $aa) or die(mysqli_error($conn));

$mytotalgroups = mysqli_num_rows($bb);
?>
<!DOCTYPE html>
<html>

<head>
	<title>My Groups - <?php echo $companNameTitle; ?></title>
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
	<div id="wrapper" class="active">
		<?php include('header.php'); ?>
		<div class="container main">
			<div class="premium_tag"><a href="#">Go Premium</a>
				<p id="typewriter"></p>
			</div>
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content">
					<div class="groups bx-shadow">
						<?php include('searchgroup.inc.php'); ?>
						<div class="trnding-group hiden-xs">
							<h2 style="text-align:left;">Your private groups (<?php echo $mytotalgroups; ?>)</h2>
							<?php if (isset($_REQUEST['q']) && $_REQUEST['q'] == 1) { ?>

								<div style="font-size:12px;" class="grp-reqsteccpt">Group joining request has been accepted
									successfully</div>
							<?php } ?>
							<ul class="prvate-grp-list">

								<?php
								while ($rowgroup = mysqli_fetch_array($resGroup)) {

									$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $rowgroup["groupId"] . " and status=0";
									$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
									$row = mysqli_fetch_array($resgroup);

									if ($row) { // ✅ Check if $row is not null
										$groupThumb = ($row["groupThumb"] != '') ? $row["groupThumb"] : 'group.png';
										$groupType = ($row["groupType"] == 0) ? 'Public' : 'Private';

										if ($row["id"] != '') {
											$sql_postgroup = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE groupId= " . $row["id"] . " order by id desc";
											$respostgroup = mysqli_query($conn, $sql_postgroup) or die(mysqli_error($conn));
											$rowGroupPost = mysqli_fetch_array($respostgroup);
											$groupPostTitle = $rowGroupPost["postTitle"] ?? '';
										}

										$totalgroupmembers = 0;
										if ($row["id"] != '') {
											$sqlGroupTotal = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " where groupId='" . $row["id"] . "' and status=1 ";
											// define missing variables
											$selectFields = "*";
											$whereFields = [];
											$whereVals = [];
											$resGroupTotal = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupTotal);
											if ($resGroupTotal) {
												$totalgroupmembers = mysqli_num_rows($resGroupTotal);
											}
										}

										if ($row["userId"] != 0) {
											$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $row["userId"];
											$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
											$userres = mysqli_fetch_array($b);

											$friendnameurl = $userres['userurl'] ?? '';
											$userphoto = ($userres["profilePhoto"] != '') ? $userres["profilePhoto"] : 'user-placeholder.jpg';
										}

										if ($row["groupType"] == 1) {
											?>
											<li>
												<div class="grp-box">
													<span class="img"><a
															href="<?php echo $fullurl;
															if ($row["groupType"] == 0) { ?>groups-detail<?php } else { ?>private-group<?php } ?>.html?groupId=<?php echo encodeStr($rowgroup['groupId']); ?>"><img
																src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>"></a></span>
													<div class="grpbx-right">
														<h3><a
																href="<?php echo $fullurl;
																if ($row["groupType"] == 0) { ?>groups-detail<?php } else { ?>private-group<?php } ?>.html?groupId=<?php echo encodeStr($rowgroup['groupId']); ?>"><?php echo stripslashes(trim($row["groupName"])); ?></a>
														</h3>
														<p>By <strong><?php if (($userres['userId'] ?? '') == $_SESSION["sessUserId"]) {
															echo 'Me';
														} else {
															echo ($userres['firstName'] ?? '') . " " . ($userres['lastName'] ?? '');
														} ?></strong></p>
													</div>
													<div class="grpbx-fttr">
														<label>members (<?php echo $totalgroupmembers; ?>)</label><a
															href="<?php echo $fullurl;
															if ($row["groupType"] == 0) { ?>groups-detail<?php } else { ?>private-group<?php } ?>.html?groupId=<?php echo encodeStr($rowgroup['groupId']); ?>"
															class="join-btn">Enter</a>
													</div>
												</div>
											</li>
											<?php
										}
									}
									$n++;
								}

								?>

								<?php if ($mytotalgroups < 1) { ?>
									<div style="padding:20px; text-align:center; color:#999999; overflow:hidden;">You have
										no groups.</div>
								<?php } ?>
							</ul>
						</div>
						<div class="trnding-group">
							<?php

							$aa = "SELECT id from " . _GROUP_MASTER_TABLE_ . " WHERE status=0 and id IN(select groupId from " . _GROUP_MEMBER_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and status=1  ) and groupType=0";
							$bb = mysqli_query($conn, $aa) or die(mysqli_error($conn));

							$mytotalpublicgroups = mysqli_num_rows($bb);

							$n = 0;
							$selectFields = [];
							$whereFields = [];
							$whereVals = [];

							$sqlGroup = "";
							$sqlGroup = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and status=1 order by dateAdded desc ";
							$resGroup = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroup);
							if ($resGroup) {
								$mytotalgroups = mysqli_num_rows($resGroup);
								?>
								<h2 style="text-align:left;">Your public groups (<?php echo $mytotalpublicgroups; ?>)</h2>

								<!--<ul class="curently-trendng-list">
				<li>
				<div class="currntly-trendingbox">
				  <span class="im"><a href="#">
					<img src="https://www.konectt.com/demo/uploads/group.png"></a>
				  </span>
				<h3 class="grpnm">
					<a href="#">LOC</a></h3>
				<label class="mmbr-count">2 Members in this group</label>
				<ul class="grupmmbrlist">
				<li>
					<a href="#"><img src="https://www.konectt.com/demo/uploads/1503661808TG-pic.jpg"></a>
				</li>
					<li><a href="#"><img src="https://www.konectt.com/demo/uploads/1508746823CYMERA_20170717_164608.jpg"></a></li>
				</ul>
				<div class="grupbuttons">
					<a href="" class="joingrp-btn"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="#" class="view-btn"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
				</div> 
				</li>
				<li>
				<div class="currntly-trendingbox">
				  <span class="im"><a href="#">
					<img src="https://www.konectt.com/demo/uploads/group.png"></a>
				  </span>
				<h3 class="grpnm">
					<a href="#">LOC</a></h3>
				<label class="mmbr-count">2 Members in this group</label>
				<ul class="grupmmbrlist">
				<li>
					<a href="#"><img src="https://www.konectt.com/demo/uploads/1503661808TG-pic.jpg"></a>
				</li>
					<li><a href="#"><img src="https://www.konectt.com/demo/uploads/1508746823CYMERA_20170717_164608.jpg"></a></li>
				</ul>
				<div class="grupbuttons">
					<a href="" class="joingrp-btn"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="#" class="view-btn"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
				</div>
				</li>
				<li>
				<div class="currntly-trendingbox">
				  <span class="im"><a href="#">
					<img src="https://www.konectt.com/demo/uploads/group.png"></a>
				  </span>
				<h3 class="grpnm">
					<a href="#">LOC</a></h3>
				<label class="mmbr-count">2 Members in this group</label>
				<ul class="grupmmbrlist">
				<li>
					<a href="#"><img src="https://www.konectt.com/demo/uploads/1503661808TG-pic.jpg"></a>
				</li>
					<li><a href="#"><img src="https://www.konectt.com/demo/uploads/1508746823CYMERA_20170717_164608.jpg"></a></li>
				</ul>
				<div class="grupbuttons">
					<a href="" class="joingrp-btn"><i class="fa fa-plus" aria-hidden="true"></i></a>
				<a href="#" class="view-btn"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
				</div> 
				</li>
				</ul>-->




								<ul class="curently-trendng-list">
									<?php
									while ($rowgroup = mysqli_fetch_array($resGroup)) {

										$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $rowgroup["groupId"] . "";
										$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
										$row = mysqli_fetch_array($resgroup);

										if ($row["groupThumb"] != '') {
											$groupThumb = $row["groupThumb"];
										} else {
											$groupThumb = 'group.png';
										}

										if ($row["groupType"] == 0) {
											$groupType = 'Public';
										} else {
											$groupType = 'Private';
										}

										if (!empty($row["id"])) {
											$sql_postgroup = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE postTitle!='' and groupId= " . intval($row["id"]) . " order by id desc";
											$respostgroup = mysqli_query($conn, $sql_postgroup) or die(mysqli_error($conn));
											$rowGroupPost = mysqli_fetch_array($respostgroup);

											$groupPostTitle = isset($rowGroupPost["postTitle"]) ? $rowGroupPost["postTitle"] : '';
										}


										if ($row["id"] != '') {
											$totalgroupmembers = 0;
											$sqlGroupTotal = "";
											$sqlGroupTotal = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " where groupId='" . $row["id"] . "' and status=1 ";
											$resGroupTotal = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupTotal);
											if ($resGroupTotal) {
												$totalgroupmembers = mysqli_num_rows($resGroupTotal);
											}


											$ag = "SELECT id from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $row["id"] . " and userId=" . $_SESSION['sessUserId'] . " and status=1 and userStatus=0";
											$bg = mysqli_query($conn, $ag) or die(mysqli_error($conn));
											$mygroupblockuser = mysqli_num_rows($bg);
										}

										if ($row["userId"] != '') {
											$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $row["userId"] . "";
											$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
											$userres = mysqli_fetch_array($b);

											$friendnameurl = $userres['userurl'];

											if ($userres["profilePhoto"] != '') {
												$userphoto = $userres["profilePhoto"];
											} else {
												$userphoto = 'user-placeholder.jpg';
											}
										}

										if ($row["groupName"] != '') {
											if ($row["groupType"] == 0) {

												?>

												<!-- <li>
				<div class="list_column mygrp">
				  <div class="group-sec"> 
				  <a href="<?php echo $fullurl;
				  if ($row["groupType"] == 0) { ?>groups-detail<?php } else { ?>private-group<?php } ?>.html?groupId=<?php echo encodeStr($rowgroup['groupId']); ?>"><img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>"></a> 
				  <span> <a href="<?php echo $fullurl;
				  if ($row["groupType"] == 0) { ?>groups-detail<?php } else { ?>private-group<?php } ?>.html?groupId=<?php echo encodeStr($rowgroup['groupId']); ?>" class="nm"><?php echo stripslashes(trim($row["groupName"])); ?></a>

				  <div style="margin-top:2px;"> <label class="grp-desc-info">By <strong><?php if ($userres['userId'] == $_SESSION["sessUserId"]) {
					  echo 'Me';
				  } else { ?><?php echo $userres['firstName']; ?> <?php echo $userres['lastName'];
				  } ?></strong></label></div>
				  <div class="grp-dscrp"><?php echo stripslashes(trim($row["groupDetails"])); ?></div>

				  <div style="margin-top:2px;"> <label class="grp-desc-info"><?php if ($row["groupType"] == 0) { ?>
				  <?php
					  $mytotalgroupposts = '';
					  $totalc = "";
					  $totalc = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE groupId= " . $rowgroup["groupId"] . "  and shareType!=0";
					  $retotalc = mysqli_query($conn, $totalc) or die(mysqli_error($conn));
					  $mytotalgroupposts = mysqli_num_rows($retotalc);
					  if ($mytotalgroupposts > 0) {
						  echo $mytotalgroupposts;
						  ?> post<?php if ($mytotalgroupposts > 1) { ?>s<?php } ?> |  <?php }
				  }
				  echo $totalgroupmembers; ?> user<?php if ($totalgroupmembers > 1) { ?>s<?php } ?></label></div></span>
				  
				   </div>
				</div>
				
				<?php if ($groupPostTitle != '') { ?>
				<div class="list_column">
				  <div class="post-sec"> <a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
					<div class="right-post"> <a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html" class="nam"><?php echo stripslashes(trim($userres["firstName"])); ?> <?php echo stripslashes(trim($userres["lastName"])); ?></a> wrote a post <span class="tim"><?php echo makedatetime($rowGroupPost["dateAdded"]); ?></span> <strong>
					<a href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($rowgroup['groupId']); ?>"><?php echo stripslashes($groupPostTitle); ?></a></strong> <span><?php echo getStrLength(strip_tags(stripslashes($rowGroupPost["postText"])), 210); ?></span> </div>
				  </div>
				</div>
						<?php
				}

				?>
			  </li>-->

												<li>
													<div class="currntly-trendingbox">
														<span class="im"><a
																href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($row['id']); ?>"><img
																	src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>"></a></span><?php if ($row['userId'] == $_SESSION["sessUserId"]) { ?>
															<div class="editselfgrp"><a
																	href="<?php echo $fullurl; ?>about-group.html?groupId=<?php echo encodeStr($row['id']); ?>"><i
																		class="fa fa-pencil" aria-hidden="true"></i></a></div><?php } ?>
														<h3 class="grpnm"><a
																href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($row['id']); ?>"><?php echo stripslashes(trim($row["groupName"])); ?></a>
														</h3>

														<label class="mmbr-count"><?php echo $totalgroupmembers; ?> Members in this
															group</label>
														<ul class="grupmmbrlist">
															<?php

															$selectFields = [];
															$whereFields = [];
															$whereVals = [];

															$sqlGroupMembers = "";
															$sqlGroupMembers = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $row["id"] . " and status=1 order by rand() desc LIMIT 0,6 ";
															$resGroupMembers = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
															if ($resGroupMembers) {
																while ($rowgroup = mysqli_fetch_array($resGroupMembers)) {


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
																				src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
																	</li>
																	<?php
																}
															}
															?>
														</ul>
														<div class="grupbuttons">
															<?php if ($mygroupblockuser == 0) { ?>
																<a href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($row['id']); ?>"
																	class="joingrp-btn" data-hover="Join this group"><i class="fa fa-plus"
																		aria-hidden="true"></i></a><?php } ?>
															<a href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($row['id']); ?>"
																class="view-btn" data-hover="View Details"><i class="fa fa-eye"
																	aria-hidden="true"></i></a>
														</div>
													</div>
												</li>


												<?php
												$n++;
											}

										}
									}
									?> 	<?php if ($mytotalpublicgroups < 1) { ?>
										<div style="padding:20px; text-align:center; color:#999999;">You have no groups.</div>
									<?php } ?>
								</ul>
								<?php

							}
							?>

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

	<script>
		<?php
		if ($_SESSION["s"] == 1) {
			?>
			showsusmsg('SUCCESS', 'Your Group has been successfully created on <?php echo $companNameTitle; ?>', '');
			<?php
			$_SESSION["s"] = '';
		}

		if ($_SESSION["d"] == 1) {
			?>
			showerrormsg('SUCCESS', 'Group deleted successfully', '');
			<?php
			$_SESSION["d"] = '';
		}

		if ($_SESSION["d"] == 2) {
			?>
			showsusmsg('SUCCESS', 'You have successfully left this group', '');
			<?php
			$_SESSION["d"] = '';
		}
		?>
	</script>
</body>

</html>