<?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
		<div class="selct_popup" style="display:none;" id="friedrequestbox">
			<div class="popup_cont" style="text-align:left; width:500px;">
				<h4 class="usrname" style="font-size:20px; margin-bottom:20px;">Contact requests you received ( pending)</h4>

				<div id="contactrequest" style="max-height:300px; overflow:auto;">Loading...</div>

				<script>
					$('#contactrequest').load('<?php echo $fullurl; ?>contact_request.php');
				</script>
				<script type="text/javascript">
					/*$(window).scroll(function() {
						if ($(this).scrollTop() > 160){
							$(".left_menu_sec").addClass("fix-head");
						}
						else{
							$(".left_menu_sec").removeClass("fix-head");
						}
					});
					$(window).scroll(function() {
						if ($(this).scrollTop() > 10){
							$(".left_menu_sec").addClass("smallfix");
						}
						else{
							$(".left_menu_sec").removeClass("smallfix");
						}
					});
					*/
				</script>
			</div>
		</div>


		<div class="left_menu_sec">
			<div class="menu">
				<ul class="nav_list">
					<?php

					$selectFields;
					$whereFields;
					$whereVals;

					if (isset($_SESSION["sessUserId"]) && !empty($_SESSION["sessUserId"])) {
						$sessUserId = intval($_SESSION["sessUserId"]);

						// Get total contacts
						$sqlLogin1 = "SELECT id FROM " . _CONTACT_MASTER_TABLE_ . " WHERE userId = $sessUserId AND status = 1";
						$resLogin1 = mysqli_query($conn, $sqlLogin1);

						if ($resLogin1) {
							$lefttotalcontacts = mysqli_num_rows($resLogin1);
						} else {
							$lefttotalcontacts = 0;
						}

						unset($selectFields, $whereFields, $whereVals);

						// Get user details
						$sqlLogin = "SELECT userurl, firstName, lastName, userstype, jobTitle, coursename, departmentname, companyName 
                 FROM " . _USERS_MASTER_TABLE_ . " 
                 WHERE userId = $sessUserId";
						$resLogin = mysqli_query($conn, $sqlLogin);

						if ($resLogin && mysqli_num_rows($resLogin) > 0) {
							while ($rowLogin = mysqli_fetch_assoc($resLogin)) {
								$sessuserurl = $rowLogin["userurl"];
								$sessfirstName = $rowLogin["firstName"];
								$sesslastName = $rowLogin["lastName"];
								$sessname = ucfirst($sessfirstName) . ' ' . ucfirst($sesslastName);
								$sessjobTitle = $rowLogin["jobTitle"];
								$sesscoursename = $rowLogin["coursename"];
								$sessdepartmentname = $rowLogin["departmentname"];
								$sesscompanyName = $rowLogin["companyName"];
								$sessuserstype = $rowLogin["userstype"];
							}
						}
						?>

							<?php
							$pageIndex = isset($pageIndex) ? intval($pageIndex) : 0;

							// Ensure $lefttotalcontacts is defined too (avoid warnings)
							$lefttotalcontacts = isset($lefttotalcontacts) ? intval($lefttotalcontacts) : 0;
							if ($pageIndex == 22 && $lefttotalcontacts != 0) { ?>
									<li class="connections" style="display:block;">
										<span>Your connections</span>
										<h1><a href="<?php echo $fullurl; ?>my-contacts.html"><?php echo $lefttotalcontacts; ?></a></h1>
										<ul class="konections">
											<?php
											unset($selectFields, $whereFields, $whereVals);

											// Get random connections
											$sqlLogin2 = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " 
                              WHERE userId IN (
                                  SELECT contactId 
                                  FROM " . _CONTACT_MASTER_TABLE_ . " 
                                  WHERE userId = $sessUserId AND status = 1
                              ) AND profilePhoto != '' 
                              ORDER BY RAND() 
                              LIMIT 0,4";
											$resLogin2 = mysqli_query($conn, $sqlLogin2);

											if ($resLogin2 && mysqli_num_rows($resLogin2) > 0) {
												while ($rowLogin2 = mysqli_fetch_assoc($resLogin2)) {
													$userId2 = intval($rowLogin2["userId"]);

													// Get user details again
													$a2 = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = $userId2";
													$b2 = mysqli_query($conn, $a2);

													if (!$b2) {
														die("MySQLi Error (Connections): " . mysqli_error($conn));
													}

													$userres2 = mysqli_fetch_assoc($b2);

													$friendnameurl2 = $userres2['userurl'];
													$userphoto2 = (!empty($userres2["profilePhoto"])) ? $userres2["profilePhoto"] : 'user-placeholder.jpg';
													?>
															<li>
																<a href="<?php echo $fullurl; ?>my-contacts.html">
																	<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto2)); ?>"
																		alt="<?php echo htmlspecialchars($userres2["firstName"] . ' ' . $userres2["lastName"]); ?>"
																		title="<?php echo htmlspecialchars($userres2["firstName"] . ' ' . $userres2["lastName"]); ?>">
																</a>
															</li>
															<?php
												}
											}
											?>
										</ul>
										<a class="seealllinks" href="<?php echo $fullurl; ?>my-contacts.html">All</a>
									</li>
							<?php } else { ?>
									<style>
										ul.nav_list li.user11 .img11 {
											position: absolute;
											width: 76px;
											height: 76px;

											display: block;
											margin: auto;
											bottom: 8px;
											left: 17%;
											background-color: #fff;
											transform: translateX(-50%);
											border-radius: 50%;
											overflow: hidden;
										}

										ul.nav_list li.user11 .img11 img {
											max-width: 100%;
											display: block;
											border-radius: 50%;
											border: 3px solid #f9eb3f;
										}

										.circle-text {
											position: absolute;
											top: 4px;
											/* Adjust position */
											left: -17px;
											width: 112px;
											height: 67px;
											font-size: 10px;
											/* Adjust font size */
											font-weight: bold;
											text-transform: uppercase;
											fill: white;
											/* Text color */
											z-index: 1;
										}
									</style>
									<li class=" user" style="border-bottom: solid 12px #f0f0f0;">
										<div class="usr-bg">
											<div class="user-bg-cover">&nbsp;</div>

											<span class=" img">
												<?php if ($optional != '' && $pageIndex != 7) { ?>
														<svg viewBox="0 0 100 100" class="circle-text">
															<defs>
																<path id="textPath" d="M 50, 50
													m -40, 0
													a 40,40 0 1,1 80,0
													a 40,40 0 1,1 -80,0" />
															</defs>
															<text>
																<textPath xlink:href="#textPath" startOffset="2%">
																	<?php echo $optional; ?>
																</textPath>
															</text>
														</svg>
												<?php } ?>
												<!---href="<?php echo $fullurl; ?>myprofile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $sessuserurl; ?>.html"--->
						<a style="padding: 0 !important;background: none !important;">
							<img src="<?php echo $fullurl; ?>uploads/<?php echo $myprofilePhoto; ?>"
								style="border:<?php echo profileborder($usersType); ?>"
								onClick="imgpopupprofiles('<?php echo 'x_' . $myprofilePhoto; ?>','1');">
						</a>
					</span>

				</div>

				<div class="usr-right">
					<a
						href="<?php echo $fullurl; ?>myprofile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $sessuserurl; ?>.html"><span
							class="usrnme">
							<?php echo $sessname; ?>
						</span></a>
					<span class="usrdesc">
						<?php
						if ($sessuserstype == '1') {
							echo $sesscoursename;
						}
						if ($sessuserstype == '2') {
							echo $sessdepartmentname;
						} else {
							echo $sessjobTitle;
						}
						//echo $sesscoursename;
						?>
					</span>
					<span class="usrstatic">
						<?php echo $sesscompanyName; ?>
					</span>
				</div>
				<div class="usr-info">

					<div class="connctn" onclick="location.href='<?php echo $fullurl; ?>my-contacts.html';">
						<span class="connct"><a>Contacts</a></span>
						<span class="count">
							<?php echo $lefttotalcontacts; ?>
						</span>
					</div>

					<div class="connctn" onclick="location.href='<?php echo $fullurl; ?>profile-views.html';">
						<span class="connct"><a>Views</a></span>
						<span class="count">
							<?php
							$totalprofileview = 0;

							if (isset($_SESSION["sessUserId"]) && !empty($_SESSION["sessUserId"])) {
								$sessUserId = intval($_SESSION["sessUserId"]);
								$lasdate = date('Y-m-d', strtotime('-90 days'));

								$sql_inssa = "SELECT COUNT(*) AS totalprofile 
                          FROM " . _USER_PROFILE_VIEW_TABLE_ . " 
                          WHERE userId = $sessUserId 
                            AND dateAdded >= '$lasdate'";

								$resresultsa = mysqli_query($conn, $sql_inssa);

								if (!$resresultsa) {
									die("MySQLi Error (Profile Views): " . mysqli_error($conn));
								}

								$rowresultsa = mysqli_fetch_assoc($resresultsa);

								if (!empty($rowresultsa['totalprofile']) && $rowresultsa['totalprofile'] > 0) {
									echo $totalprofileview = intval($rowresultsa['totalprofile']);
								} else {
									echo $totalprofileview = 0;
								}
							} else {
								echo $totalprofileview = 0;
							}
							?>
						</span>
					</div>


					<div class="connctn" style="cursor:pointer;"
						onclick="location.href='<?php echo $fullurl; ?>activity.html?view=<?php echo isset($rowpostview['postType']) && $rowpostview['postType'] == 3 ? '2' : '1'; ?>';">
						<span class="connct">
							<a>
								<?php echo 'Actions'; ?>
							</a>
						</span>
						<span class="count">
							<?php
							$userTotalActivity = 0;
							$selectFields = [];
							$whereFields = [];
							$whereVals = [];
							$olddateAdded = strtotime(date('Y-m-d H:i:s', strtotime("-2 days")));
							$sqlpost2 = "SELECT id FROM " . _SHAREANDUPDATES_TABLE_ . "
                     WHERE userId='" . intval($_SESSION["sessUserId"]) . "'
                     AND adType=0
                     AND dateAdded > " . $olddateAdded . "
                     AND (postType=2 OR postType=3)
                     AND articleBlogStatus=0";
							$resSqlpost2 = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlpost2);

							if ($resSqlpost2) {
								$userTotalActivity = mysqli_num_rows($resSqlpost2);
							}

							echo $userTotalActivity;
							?>
						</span>
					</div>

				</div>



			</li>
			<?php } ?>

			<li style="display: none;">
				<a href="#" class="ripple"><i class="micon"><i class="fa fa-newspaper-o" aria-hidden="true"></i></i>
					<span class="tltp">News</span></a>
			</li>
			<?php
			if ($sessuserstype == '1') {
				?>
			<li style="">
				<a href="<?php echo $fullurl; ?>find-mentor.html"
					class="<?php if ($pageIndex == 26) { ?>active<?php } ?> ripple">
					<i class="micon" style="background-color: #ff7800;"><i class="fa fa-handshake-o"
							aria-hidden="true"></i></i>
					<span class="tltp">Find Your Mentor</span></a>
			</li>
			<?php
			}
			if ($sessuserstype == '3' || $sessuserstype == '2' || $sessuserstype == '4' || $sessuserstype == '5') {
				?>
			<li style="">
				<a href="<?php echo $fullurl; ?>become-a-mentor.html"
					class="<?php if ($pageIndex == 27) { ?>active<?php } ?> ripple">
					<i class="micon" style="background-color: #ff7800;"><i class="fa fa-handshake-o"
							aria-hidden="true"></i></i>
					<span class="tltp">Become a Mentor</span></a>
			</li>
			<?php
			}
			?>
			<li style="">
				<a href="<?php echo $fullurl; ?>articles-and-trivia.html"
					class="<?php if ($pageIndex == 7) { ?>active<?php } ?> ripple">
					<i class="micon" style="background-color: #ff7800;"><i class="fa fa-file-text-o"
							aria-hidden="true"></i></i>
					<span class="tltp">Articles</span></a>
			</li>

			<li>
				<a href="<?php echo $fullurl; ?>events.html"
					class="<?php if ($pageIndex == 10) { ?>active<?php } ?> ripple">
					<i class="micon"><i class="fa fa-calendar" aria-hidden="true"></i></i>
					<span class="tltp">Event Calendar</span></a>
			</li>

			<li>
				<a href="<?php echo $fullurl; ?>projects.html"
					class="<?php if ($pageIndex == 11) { ?>active<?php } ?> ripple">
					<i class="micon" style="background-color: #C02621;"><i class="fa fa-globe"
							aria-hidden="true"></i></i>
					<span class="tltp">Internships & Projects</span></a>
			</li>

			<li>
				<a href="<?php echo $fullurl; ?>jobs.html"
					class="<?php if ($pageIndex == 14) { ?>active<?php } ?> ripple">
					<i class="micon" style="background-color: #C02621;"><i class="fa fa-briefcase"
							aria-hidden="true"></i></i>
					<span class="tltp">Job Opportunities</span></a>
			</li>

			<li>
				<a href="<?php echo $fullurl; ?>talent-konectt.html"
					class="<?php if ($pageIndex == 13) { ?>active<?php } ?> ripple">
					<i class="micon"><i class="fa fa-star" aria-hidden="true"></i></i>
					<span class="tltp">Guest Speakers & Trainers</span></a>
			</li>

			<li>
				<a href="<?php echo $fullurl; ?>companies.html"
					class="<?php if ($pageIndex == 8) { ?>active<?php } ?> ripple">
					<i class="micon"><i class="fa fa-building-o" aria-hidden="true"></i></i>
					<span class="tltp">Company Profiles</span></a>
			</li>

			<li style="">
				<a href="<?php echo $fullurl; ?>smb.html"
					class="<?php if ($pageIndex == 12) { ?>active<?php } ?> ripple">
					<i class="micon" style="background-color: #ff7800;"><i class="fa fa-industry"
							aria-hidden="true"></i></i>
					<!--<img src="images/bl_739_talent_lamp_businessman_lamp_energy_creativity_idea-512.png">-->
									<span class="tltp">Career Enhancers</span></a>
							</li>

							<li style="">
								<a href="<?php echo $fullurl; ?>all-notice.html"
									class="<?php if ($pageIndex == 75) { ?>active<?php } ?> ripple">
									<i class="micon" style="background-color: #ff7800;"><i class="fa fa-file-text"
											aria-hidden="true"></i></i>
									<!--<img src="images/bl_739_talent_lamp_businessman_lamp_energy_creativity_idea-512.png">-->
									<span class="tltp">Notice Board</span></a>
							</li>
							<?php
							if ($sessuserstype == '1') {
								?>

									<li>
										<a href="<?php echo $fullurl; ?>job-fair.html"
											class="<?php if ($pageIndex == 50) { ?>active<?php } ?> ripple">
											<i class="micon"><i class="fa fa-address-card" aria-hidden="true"></i></i>
											<span class="tltp">Placement Registration</span></a>
									</li>
									<?php
							}
							?>
							<li class="hiden-d">
								<a href="<?php echo $fullurl; ?>settings.html" class="ripple">
									<i class="micon" style="background-color: #ff7800;"><i class="fa fa-cog" aria-hidden="true"></i></i>
									<span class="tltp">Setting</span></a>
							</li>
							<li class="hiden-d">
								<a href="<?php echo $fullurl; ?>logout.html" class="ripple">
									<i class="micon"><i class="fa fa-sign-out" aria-hidden="true"></i></i>
									<span class="tltp">Logout</span></a>
							</li>
							<li class="hiden-d" style="padding:0px 15px;">
								<div style="float:left;padding: 4px 0px;"><span class="tltp" style="color: #969696;">Powered by </span>
								</div>
								<div style="float:left"> <a href="http://deboxglobal.com/" style="padding: 0px 12px;"><img
											src="<?php echo $fullurl; ?>images/Logo De Boxpng.png" style="width:50px;"></a></div>
							</li>
						</ul>
					</div>
					<script>
						function opendiffchatbox(id) {
							$('#msgchatguide').html('');
							$('#msgchatguide').load('<?php echo $fullurl; ?>guide-messaging.html?msgchatId=' + id);
						}
					</script>
					<?php
					if (isset($sessuserstype) && $sessuserstype == '3') {
						?>
							<div>
								<ul class="studenmentlist111" style="text-align:right;">
									<li class="mentetex1t111">MENTEES</li>
									<?php
									unset($selectFields);
									unset($whereFields);
									unset($whereVals);

									if (isset($_SESSION['sessUserId']) && !empty($_SESSION['sessUserId'])) {
										$sessUserId = intval($_SESSION['sessUserId']);

										$sqlLogin = "SELECT * FROM " . _STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_ . " 
                             WHERE mentorId = $sessUserId AND status = 1";
										$resLogin = mysqli_query($conn, $sqlLogin);

										if (!$resLogin) {
											die("MySQLi Error (Mentor Requests): " . mysqli_error($conn));
										}

										while ($rowLogin = mysqli_fetch_assoc($resLogin)) {
											$studentId = intval($rowLogin["studentId"]);

											// Fetch student details
											$a = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = $studentId";
											$b = mysqli_query($conn, $a);

											if (!$b) {
												die("MySQLi Error (Fetch Student): " . mysqli_error($conn));
											}

											$userres = mysqli_fetch_assoc($b);

											// Count unread messages
											$unrmsg = "SELECT COUNT(*) AS total 
                               FROM " . _STUDENT_MENTOR_CHAT_MASTER_TABLE_ . " 
                               WHERE userId = $sessUserId 
                               AND contactId = $studentId 
                               AND status = '0'";
											$unrmsgQry = mysqli_query($conn, $unrmsg);

											if (!$unrmsgQry) {
												die("MySQLi Error (Unread Messages): " . mysqli_error($conn));
											}

											$unredmsg = mysqli_fetch_assoc($unrmsgQry);
											$non = $unredmsg['total'];

											$friendnameurl = $userres['userurl'];
											$userphoto = (!empty($userres["profilePhoto"])) ? $userres["profilePhoto"] : 'user-placeholder.jpg';
											?>
													<li>
														<div class="reltposindiv">
															<div class="usrprofileinewimg">
																<?php if (!empty($userres['onlineStatus']) && $userres['onlineStatus'] == 1) { ?>
																		<div id="vbonlineoffline"
																			class="online <?php if ($userres['onlineLastUpdate'] < strtotime("-5 minutes", time())) { ?>standby<?php } ?>">
																		</div>
																<?php } else { ?>
																		<div id="vbonlineoffline" class="offline"></div>
																<?php } ?>

																<span class="frnd-tltp" id="messagenotificationnumber"
																	style=""><?php echo intval($unredmsg['total']); ?></span>

																<a
																	href="<?php echo $fullurl; ?>guide-messaging.html?msgchatId=<?php echo encodeStr($userres['userId']); ?>">
																	<div class="userprofilechatimgdiv">
																		<img id="chatusernum<?php echo $userres['userId']; ?>"
																			onclick="opendiffchatbox('<?php echo encodeStr($userres['userId']); ?>')"
																			src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"
																			style="cursor:pointer;">
																	</div>
																</a>
															</div>
															<div>
																<span>
																	<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["firstName"]); ?>
																	<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["lastName"]); ?>
																</span>
															</div>
														</div>
													</li>
													<?php
										} // end while
									} // end if sessUserId
									?>
								</ul>
							</div>
							<?php
					}

					if (isset($sessuserstype) && $sessuserstype == '1') {
						?>
							<div>
								<ul class="studenmentlist111">
									<li class="mentetex1t111">MENTOR</li>
									<?php
									unset($selectFields);
									unset($whereFields);
									unset($whereVals);

									if (isset($_SESSION['sessUserId']) && !empty($_SESSION['sessUserId'])) {
										$sessUserId = intval($_SESSION['sessUserId']);

										$sqlLogin = "SELECT * FROM " . _STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_ . " 
                             WHERE studentId = $sessUserId AND status = 1";
										$resLogin = mysqli_query($conn, $sqlLogin);

										if (!$resLogin) {
											die("MySQLi Error (Mentor Requests): " . mysqli_error($conn));
										}

										while ($rowLogin = mysqli_fetch_assoc($resLogin)) {
											$mentorId = intval($rowLogin["mentorId"]);

											// Fetch mentor details
											$a = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = $mentorId LIMIT 1";
											$b = mysqli_query($conn, $a);

											if (!$b) {
												die("MySQLi Error (Fetch Mentor): " . mysqli_error($conn));
											}

											$userres = mysqli_fetch_assoc($b);

											// Count unread messages
											$unrmsg = "SELECT COUNT(*) AS totalm 
                               FROM " . _STUDENT_MENTOR_CHAT_MASTER_TABLE_ . " 
                               WHERE userId = $sessUserId 
                               AND contactId = $mentorId 
                               AND status = '0'";
											$unrmsgQry = mysqli_query($conn, $unrmsg);

											if (!$unrmsgQry) {
												die("MySQLi Error (Unread Messages): " . mysqli_error($conn));
											}

											$unredmsg = mysqli_fetch_assoc($unrmsgQry);

											$friendnameurl = $userres['userurl'];
											$userphoto = (!empty($userres["profilePhoto"])) ? $userres["profilePhoto"] : 'user-placeholder.jpg';
											?>
													<li>
														<div class="reltposindiv">
															<div class="clearfix usrprofileinewimg">
																<div id="vbonlineoffline"
																	class="online <?php if ($userres['onlineLastUpdate'] < strtotime("-5 minutes", time())) { ?>standby<?php } ?>">
																</div>
																<span class="frnd-tltp" id="messagenotificationnumber"
																	style=""><?php echo intval($unredmsg['totalm']); ?></span>
																<a
																	href="<?php echo $fullurl; ?>guide-messaging.html?msgchatId=<?php echo encodeStr($userres['userId']); ?>">
																	<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>">
																</a>
															</div>
															<div>
																<span id="chatusernum<?php echo $userres['userId']; ?>"
																	onclick="opendiffchatbox('<?php echo encodeStr($userres['userId']); ?>')"
																	style="cursor:pointer;">
																	<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["firstName"]); ?>
																	<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["lastName"]); ?>
																</span>
															</div>
														</div>
													</li>
													<?php
										}
									}
									?>
								</ul>
							</div>
							<?php
					}

					?>
				</div>


				<?php
					}
}
?>