<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$postWhere = "select * from " . _TIMELINE_MASTER_TABLE_ . " where status=1 and groupId!=0 and postType=4 order by rand(), groupId desc limit 0,1 ";



$selectFields = [];
$whereFields = [];
$whereVals = [];
$sqlLogin = "";
$sqlLogin = $postWhere;
$resLogin = getRecords(_TIMELINE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
if ($resLogin) {
	while ($row = mysqli_fetch_array($resLogin)) {

		$ha = "SELECT id from " . _HIDDEN_POSTS_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " and timeLineId=" . $row["postId"] . " ";
		$hb = mysqli_query($conn, $ha) or die(mysqli_error($conn));
		$hidpost = mysqli_num_rows($hb);
		if ($hidpost == 0) {


			$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $row["userId"] . "";
			$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
			$userres = mysqli_fetch_array($b);



			if (is_array($userres)) {
				$jobTitle = $userres['jobTitle'] ?? '';
				$companyName = $userres['companyName'] ?? '';
				$friendnameurl = $userres['userurl'] ?? '';
				$userphoto = !empty($userres['profilePhoto']) ? $userres['profilePhoto'] : 'user-placeholder.jpg';
			} else {
				$jobTitle = $companyName = $friendnameurl = '';
				$userphoto = 'user-placeholder.jpg';
			}









			if ($row["postType"] == 4) {


				$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $row["groupId"] . "";
				$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
				$rowGroupName = mysqli_fetch_array($resgroup);

				if ($rowGroupName['id'] != '' && $rowGroupName["groupType"] == 0) {

					if ($rowGroupName["groupThumb"] != '') {
						$groupThumb = $rowGroupName["groupThumb"];
					} else {
						$groupThumb = 'group.png';
					}
					if ($rowGroupName["status"] == 0 && $rowGroupName["userGroupStatus"] == 1) {
						?>
						<div class="timlist" id="387" style="margin-bottom:8px;">
							<div class="hedr">
								<div class="prfl_img"> <a
										href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
											src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a> </div>
								<div class="hdr_right"><a
										href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes(trim($userres["firstName"])); ?>
										<?php echo stripslashes(trim($userres["lastName"])); ?></a><span class="timelinecontantsubline"></span>
									<label class="time"><?php echo $jobTitle; ?>
										<?php if ($companyName != '') {
											echo 'at ' . $companyName;
										} ?>
									</label>
									<label class="time">Created a group <?php echo makedatetime($row["dateAdded"]); ?></label>
								</div>
							</div>
							<div class="txtarea">
								<div style=" margin-bottom:10px;">
									<div style="font-size:15px; font-weight:bold; margin-bottom:5px;">
										<ul class="cht_mmbr_list" style="height:auto;    border-radius: 4px;">
											<li style="border-bottom: 1px #ccc solid;  padding: 16px;  border: 0px; padding-bottom:10px; background-color: #f2f2f2; margin-bottom:15px;"
												class="active">
												<div class="frfl-img" style="float:none; border-bottom:px #CCCCCC solid;"> <a
														href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($rowGroupName['id']); ?>"><img
															src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>"></a>
													<strong style="width:88%; font-size:16px;"><a
															href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($rowGroupName['id']); ?>"
															style="margin-top:-1px; font-size:16px;"><?php echo stripslashes(trim($rowGroupName["groupName"])); ?></a></strong>
													<span
														style="color:#666666; margin-top: 2px; font-weight:normal;"><?php echo getStrLength(strip_tags(stripslashes($rowGroupName["groupDetails"])), 100); ?></span>

													<?php

													$mytotalgroups = 0;
													$totalm = "SELECT * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $rowGroupName['id'] . " and status=1";
													$retotalm = mysqli_query($conn, $totalm) or die(mysqli_error($conn));
													$mytotalgroups = mysqli_num_rows($retotalm);

													if ($mytotalgroups > 0) {
														?>

														<div class="share_with" style=" margin-top:10px; position:relative;">
															<ul class="grp-mmbr_list groupontimeline">
																<?php

																$selectFields = [];
																$whereFields = [];
																$whereVals = [];

																$sqlGroupMembers = "";
																$sqlGroupMembers = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $rowGroupName['id'] . " and status=1 order by rand() desc LIMIT 0,4 ";
																$resGroupMembers = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
																if ($resGroupMembers) {
																	while ($rowgroupmembers = mysqli_fetch_array($resGroupMembers)) {

																		$groupmembernameurl = '';
																		$usergroupmemberphoto = '';
																		$aa = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowgroupmembers["userId"] . "";
																		$bb = mysqli_query($conn, $aa) or die(mysqli_error($conn));
																		$usergroupmembers = mysqli_fetch_array($bb);

																		$groupmembernameurl = $usergroupmembers['userurl'];

																		if ($usergroupmembers["profilePhoto"] != '') {
																			$usergroupmemberphoto = $usergroupmembers["profilePhoto"];
																		} else {
																			$usergroupmemberphoto = 'user-placeholder.jpg';
																		}

																		?>
																		<li><a
																				href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($usergroupmembers['userId']); ?>/<?php echo $groupmembernameurl; ?>.html"><img
																					title="<?php echo stripslashes(trim($usergroupmembers["firstName"])); ?> <?php echo stripslashes(trim($usergroupmembers["lastName"])); ?>"
																					alt="<?php echo stripslashes(trim($usergroupmembers["firstName"])); ?> <?php echo stripslashes(trim($usergroupmembers["lastName"])); ?>"
																					src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($usergroupmemberphoto)); ?>"></a>
																		</li>
																		<?php
																	}
																}
																?>
															</ul>
															<div style=" right:0px; top:10px; font-size:12px; color:#999999;">
																<?php echo $mytotalgroups;
																if ($mytotalgroups > 1) {
																	echo ' members joined this group';
																} else {
																	echo ' member joined this group';
																} ?>
															</div>
														</div>
													<?php } ?>

													<div class="share_with"
														style="position:absolute; right:0px;    top: 6px;width: initial; margin:0px; padding:0px; border:0px;">


														<div>
															<?php

															$selectFields = [];
															$whereFields = [];
															$whereVals = [];

															$sqlCheck = "";
															$sqlCheck = mysqli_query(
																$conn,
																"SELECT * FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " 
																WHERE userId = " . (int) $_SESSION["sessUserId"] . " 
																AND groupId = " . (int) $rowGroupName['id']
															) or die(mysqli_error($conn));

															if (mysqli_num_rows($sqlCheck) == 0) {
																?>
																<a
																	href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($rowGroupName['id']); ?>">
																	<button type="submit">Join Now</button>
																</a>
																<?php
															}
															?>
														</div>

													</div>

												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>

						</div>
						<?php
					}
				}
			}




		}
	}


}


?>