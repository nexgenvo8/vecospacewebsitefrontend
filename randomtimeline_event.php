<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$postWhere = "select * from " . _TIMELINE_MASTER_TABLE_ . " where status=1 and postType=5 order by rand(), postId desc limit 0,1 ";



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



			if ($row["postType"] == 5) {



				$sql_group = "SELECT * from " . _EVENT_MASTER_TABLE_ . " WHERE id= " . $row["postId"] . "";
				$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
				$rowEvents = mysqli_fetch_array($resgroup);


				//echo $rowEvents["eventTillDate"].' '.$rowEvents["endtime"]."===".date("Y-m-d h:i A");	
				if (strtotime($rowEvents["eventTillDate"] . ' ' . $rowEvents["endtime"]) >= strtotime(date("Y-m-d h:i A"))) {

					if ($rowEvents["eventThumb"] != '') {
						$eventphoto = $rowEvents["eventThumb"];
					} else {
						$eventphoto = 'events-placeholder.jpg';
					}
					if ($rowEvents["eventBanner"] != '') {
						$eventBgphoto = $rowEvents["eventBanner"];
					} else {
						$eventBgphoto = 'events-bg-placeholder.jpg';
					}

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
								<label class="time">Posted an event <?php echo makedatetime($row["dateAdded"]); ?></label>
							</div>

							<div class="errow-drop"> <span class="errow"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
								<ul class="erow-list">
									<div style="display:none;" id="clipboard<?php echo trim($rowEvents['id']); ?>">
										<?php echo $fullurl . "events-detail.html?eventId=" . encodeStr($rowEvents['id']); ?>
									</div>
									<li>
										<a style="cursor:pointer;"
											onclick="copyToClipboard('#clipboard<?php echo trim($rowEvents['id']); ?>');"><i
												class="fa fa-link" aria-hidden="true"></i> Copy link to post</a>
									</li>
								</ul>
							</div>

						</div>
						<div class="txtarea">
							<div style=" margin-bottom:10px;">
								<div class="evnt-show-info">
									<div class="img"><a
											href="<?php echo $fullurl; ?>events-detail.html?eventId=<?php echo encodeStr($rowEvents['id']); ?>"
											style="display:block; margin-top:-1px; font-size:16px;"><img
												src="<?php echo $fullurl; ?>uploads/<?php echo $eventBgphoto; ?>"> <span
												class="evnt-prfl-img"><img
													src="<?php echo $fullurl; ?>uploads/<?php echo $eventphoto; ?>"></span></a></div>


								</div>
								<div style="font-size:15px; font-weight:bold; margin-bottom:5px;">
									<ul class="cht_mmbr_list" style="height:auto;    border-radius: 4px; margin-bottom:7px;">
										<li style="border-bottom: 1px #ccc solid;  padding: 16px;  border: 0px; padding-bottom:0px;    background-color: #f2f2f2; margin-bottom:7px;"
											class="going">

											<div class="frfl-img" style="float:none; border-bottom:px #CCCCCC solid;">

												<strong style="width:100%; font-size:16px;"><a
														href="<?php echo $fullurl; ?>events-detail.html?eventId=<?php echo encodeStr($rowEvents['id']); ?>"
														style="display:block; margin-top:-1px; font-size:16px;"><?php echo stripslashes(str_replace('�', '&ndash;', $rowEvents["eventName"])); ?></a></strong>
												<span style="color:#666666; margin-top: 2px; font-weight:normal;"><?php $strstrtdate = strtotime($rowEvents["eventDate"]);
												echo date("j M", $strstrtdate); ?>
													-
													<?php $strenddate = strtotime($rowEvents["eventTillDate"]);
													echo date("j M Y", $strenddate); ?>
													<?php echo stripslashes(strip_tags($rowEvents["eventVenue"])); ?>
													<?php echo stripslashes($rowEvents["eventCountryAddress"]); ?></span>

												<?php
												$mytotalgroups = 0;
												$totalm = "select id from " . _EVENT_GUEST_MASTER_TABLE_ . " where  eventId= " . $rowEvents["id"] . " and status=1";
												$retotalm = mysqli_query($conn, $totalm) or die(mysqli_error($conn));
												$mytotalgroups = mysqli_num_rows($retotalm);
												?>

												<div class="share_with" style=" margin-top:10px;    min-height: 35px; position:relative;">
													<ul class="grp-mmbr_list groupontimeline">
														<?php

														$selectFields = [];
														$whereFields = [];
														$whereVals = [];

														$sqlGroupMembers = "";
														$sqlGroupMembers = "select * from " . _EVENT_GUEST_MASTER_TABLE_ . " WHERE  eventId= " . $rowEvents["id"] . " and status=1 order by id desc LIMIT 0,6";
														$resGroupMembers = getRecords(_EVENT_GUEST_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
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
													<div style="position:absolute; right:0px; top:10px; font-size:12px; color:#999999;">
														<?php echo $mytotalgroups;
														if ($mytotalgroups > 1) {
															echo ' ' . $companNameTitle . ' members are going to be there.';
														} else {
															echo ' ' . $companNameTitle . ' member is going to be there.';
														} ?>
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


?>