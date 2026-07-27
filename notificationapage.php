<?php
include_once('inc.php');
$_SESSION['loginredirectpageurl'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
include_once('config/session-check.inc.php'); // check user login session
?>
<!DOCTYPE html>
<html>

<head>
	<title>Notifications - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<style type="text/css">
		ul#notice-list li .rquest-box .timelinecontantsubline a.blue-white-btn {
			display: block;
			width: 150px;
			text-align: center;
			margin-left: 0;
		}
	</style>

</head>

<body>
<iframe name="actionfrm" style="display:none;"></iframe>

	<div id="wrapper" class="active">

		<?php include('header.php'); ?>
		<div class="container main">
			<div class="premium_tag"><a href="#">Go Premium</a>
				<p id="typewriter"></p>
			</div>
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content">
					<div class="cntr_cntnt" style="background-color:#fff; border-radius:2px;padding: 0 !important;">

						<div class="all-activity bx-shadow">
							<h2>Notifications</h2>
							<?php
							$n = 0;
							$selectFields = [];
							$whereFields = [];
							$whereVals = [];

							$sqlLogin = "";
							$sqlLogin = "SELECT * FROM " . _NOTIFICATION_MASTER_TABLE_ . " 
							WHERE userId='" . mysqli_real_escape_string($conn, $_SESSION['sessUserId']) . "' 
							OR contactId!='" . mysqli_real_escape_string($conn, $_SESSION['sessUserId']) . "' 
							ORDER BY dateAdded DESC 
							LIMIT 0,50";



							// Run query directly for clarity
							$resLogin = mysqli_query($conn, $sqlLogin);

							if (!$resLogin) {
								die("Query failed: " . mysqli_error($conn)); // This will show what went wrong
							}

							$totalniti = mysqli_num_rows($resLogin);

							if ($totalniti > 0) { ?>
								<ul class="requst-list" id="notice-list">
									<!--Start user requests-->
									<?php
									/*  $n=0;
									unset($selectFields);
									unset($whereFields);
									unset($whereVals);

									$sqlLogin="";
									$sqlLogin="select * from "._CONTACT_MASTER_TABLE_." where userId='".$_SESSION['sessUserId']."' and status=0 ";
									$resLogin=getRecords(_CONTACT_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlLogin); 	
									if($resLogin)
									{
										while($rowLogin=mysql_fetch_array($resLogin))
										{

										$a="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= ".$rowLogin["contactId"]."";
										$b=mysql_query($a) or die(mysql_error()); 
										$userres=mysql_fetch_array($b); 

										$friendnameurl=$userres['userurl'];
										if($userres["profilePhoto"]!='')
										{
										$userphoto=$userres["profilePhoto"];
										} else {
										$userphoto='user-placeholder.jpg';
										}		

										$mycountryName=$userres["countryName"];			  
										$mystateName=$userres["cityName"];
										$mylocationName=$userres["locationName"];	
										$mycompanyName=$userres["companyName"];	  
										$myjobTitle=$userres["jobTitle"];*/


									?>


									<!--<li>
		<div class="rquest-box">
		 <a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html" target="_blank" class="rqst-img"><img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
		 <div class="rqst-right"><a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html" target="_blank"><?php echo stripslashes(trim($userres["firstName"])); ?> <?php echo stripslashes(trim($userres["lastName"])); ?></a>
		 <label><?php //if($mylocationName){ echo $mylocationName.',';} ?> <?php //echo $mystateName; ?> <?php echo $myjobTitle; ?><?php if ($mycompanyName != '') {
					echo '- ' . $mycompanyName;
				} ?></label>
		 </div>
		<div class="add-frnd">
		   <a href="common_action.php?userId=<?php echo encodeStr($userres['userId']); ?>&action=act" target="actionfrm" onClick="$('#commonloader').show();">Connect </a>
		   <a href="common_action.php?userId=<?php echo encodeStr($userres['userId']); ?>&action=dec" target="actionfrm" class="dlt" onClick="$('#commonloader').show();">Decline</a>
		 </div>
		</div>
	  </li>-->




									<?php

									//$n++;  }
								
									// }
									?>
									<!--End user requests-->

									<!--Start user notifications-->
									<?php

									while ($rowNotification = mysqli_fetch_array($resLogin)) {


										$friendnameurl = '';
										$userphoto = '';
										$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowNotification["contactId"] . "";
										$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
										$notiuser = mysqli_fetch_array($b);

										$friendnameurl = $notiuser['userurl'] ?? '';

										if (!empty($notiuser["profilePhoto"])) {
											$userphoto = $notiuser["profilePhoto"];
										} else {
											$userphoto = 'user-placeholder.jpg';
										}
										if (true) {

											$notiuserid = encodeStr($notiuser['userId']);
											$notiName = trim(($notiuser["firstName"] ?? '') . ' ' . ($notiuser["lastName"] ?? ''));
											$mycountryName = $notiuser["countryName"] ?? '';
											$mystateName = $notiuser["cityName"] ?? '';
											$mylocationName = $notiuser["locationName"] ?? '';
										} else {
											$notiuserid = '';
											$notiName = 'Unknown User';
											$mycountryName = '';
											$mystateName = '';
											$mylocationName = '';
										}


										$c = "SELECT * FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE id = " . intval($rowNotification["postId"]);
										$d = mysqli_query($conn, $c) or die(mysqli_error($conn));

										if (mysqli_num_rows($d) > 0) {
											$notipost = mysqli_fetch_array($d);

											$notipostid = encodeStr($notipost['id']);
											$notiposttype = $notipost['postType'] ?? '';
											$dot = '';
											if (strlen($notipost['postTitle']) > 20) {
												$dot = '...';
											}
											$notiposttitle = substr(strip_tags(stripslashes(trim($notipost['postTitle']))), 0, 200000000) . $dot;
											$notiposttext = substr(strip_tags(stripslashes(trim($notipost['postText']))), 0, 200000000000);
										} else {
											// Post not found
											$notipostid = '';
											$notiposttype = '';
											$notiposttitle = '';
											$notiposttext = '';
										}


										if ($rowNotification["groupId"] != '') {

											$sql_groupName = "SELECT id, groupName, groupType 
                      FROM " . _GROUP_MASTER_TABLE_ . " 
                      WHERE id = " . intval($rowNotification["groupId"]);

											$resgroupName = mysqli_query($conn, $sql_groupName) or die(mysqli_error($conn));
											$rowGroupName = mysqli_fetch_array($resgroupName);

											if ($rowGroupName) { // <-- check if data exists
												$notigroupname = $rowGroupName['groupName'];
												$notigroupid = encodeStr($rowGroupName['id']);
											} else {
												$notigroupname = ''; // fallback values
												$notigroupid = '';
											}
										}


										if ($rowNotification['postType'] == 16) {

											$ap = "SELECT * from " . _COMPANY_MASTER_TABLE_ . " WHERE id= " . $rowNotification["companyId"] . "";
											$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
											$getCompanyResult = mysqli_fetch_array($bp);

											$ap = "select imageName from " . _IMAGE_MASTER_TABLE_ . " where  postId= " . $rowNotification["companyId"] . " and imageType=8 ";
											$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
											$rowLogoImg = mysqli_fetch_array($bp);

											if ($rowLogoImg["imageName"] != '') {
												$companyPhoto = $rowLogoImg["imageName"];
											} else {
												$companyPhoto = 'company.png';
											}
										}

										if (!empty($notiuser) && is_array($notiuser) && $notiuser["firstName"] != '') {
?>

											<li id="<?php echo $rowNotification['id']; ?>">
												<div class="rquest-box">

													<?php if ($rowNotification['postType'] == 16) { ?>
														<a href="<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo encodeStr($rowNotification["companyId"]); ?>"
															target="_blank" class="rqst-img"><img
																src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>"></a>
													<?php } else { ?>
														<a href="<?php echo $fullurl; ?>profile/<?php echo $notiuserid; ?>/<?php echo $friendnameurl; ?>.html"
															target="_blank" class="rqst-img"><img
																src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
													<?php } ?>
													<div class="rqst-right">
														<div class="rquest-middle">


															<?php if ($rowNotification['postType'] == 16) { ?>
																<a href="<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo encodeStr($rowNotification["companyId"]); ?>"
																	target="_blank"><?php echo stripslashes($getCompanyResult["companyName"]); ?></a>
															<?php } else { ?>
																<a href="<?php echo $fullurl; ?>profile/<?php echo $notiuserid; ?>/<?php echo $friendnameurl; ?>.html"
																	target="_blank"><?php echo $notiName; ?></a>
															<?php } ?>

															<?php if ($rowNotification['postType'] == 1 || $rowNotification['postType'] == 2) { ?>


																<?php if ($rowNotification['notificationText'] == 'postlike') { ?>
																	<span class="timelinecontantsubline">
																		liked your post
																		<a <?php if (!empty($notiposttext)) { ?>class="notificationlink"
																			<?php } ?>
																			href="<?php echo $fullurl; ?>single-post.html?postId=<?php echo $notipostid ?? ''; ?>&postType=<?php echo $notiposttype ?? ''; ?>">
																			<?php
																			if (!empty($notiposttext)) {
																				echo getStrLength(strip_tags(stripslashes($notiposttext)), 200);
																			} else {
																				echo 'view post';
																			}
																			?>
																		</a>
																	</span>

																	<div class="dropdwn">
																		<a href="javascript:void(0);" class="open"
																			onclick="$('.remove-list').hide();$('#openc<?php echo $rowNotification['id']; ?>').show();">
																			<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
																		</a>

																		<ul class="remove-list"
																			id="openc<?php echo $rowNotification['id']; ?>"
																			style="display: none;">
																			<li>
																				<a href="<?php echo $fullurl; ?>common_action.php?dltNotiId=<?php echo encodeStr($rowNotification['id']); ?>&action=dltnotipost"
																					target="actionfrm">
																					<i class="fa fa-trash-o" aria-hidden="true"></i> Remove
																				</a>
																			</li>
																		</ul>
																	</div>
																<?php } ?>


																<?php if ($rowNotification['notificationText'] == 'postcomment') {
																	if ($notiposttext == '') {
																		$notiposttext = 'view post';
																	} ?>
																	<span class="timelinecontantsubline">
																		<?php


																		if ($rowNotification['parentId'] == $_SESSION["sessUserId"]) { ?>
																			replied on your comment. <a <?php if ($notiposttext != '') { ?>class="notificationlink" <?php } ?>
																				href="<?php echo $fullurl; ?>single-post.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php if ($notiposttext != '') {
																							 echo getStrLength(strip_tags(stripslashes($notiposttext)), 200);
																						 } else {
																							 echo 'view comment';
																						 } ?></a>
																		<?php } else { ?>

																			posted a comment on your post. <a <?php if ($notiposttext != '') { ?>class="notificationlink" <?php } ?>
																				href="<?php echo $fullurl; ?>single-post.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php if ($notiposttext != '') {
																							 echo getStrLength(strip_tags(stripslashes($notiposttext)), 200);
																						 } else {
																							 echo 'view post';
																						 }//echo $notiposttext; ?></a>
																		<?php } ?>
																	</span>
																<?php } ?>


															<?php } ?>


															<?php if ($rowNotification['postType'] == 3) { ?>


																<?php if ($rowNotification['notificationText'] == 'postlike') { ?>
																	<span class="timelinecontantsubline">liked your article post <a <?php if ($notiposttitle != '') { ?>class="notificationlink" <?php } ?>
																			href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php echo getStrLength(strip_tags(stripslashes($notiposttitle)), 200); ?></a></span>
																<?php } ?>

																<?php if ($rowNotification['notificationText'] == 'articlecomment') { ?>
																	<span class="timelinecontantsubline">posted a comment on your article <a
																			<?php if ($notiposttitle != '') { ?>class="notificationlink"
																			<?php } ?>
																			href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php echo getStrLength(strip_tags(stripslashes($notiposttitle)), 200); ?></a></span>
																<?php } ?>
															<?php } ?>



															<?php if ($rowNotification['postType'] == 4) { ?>
																<?php if ($rowNotification['notificationText'] == 'postlike') { ?>
																	<span class="timelinecontantsubline">liked your group post <a
																			class="blue-white-btn"
																			href="<?php echo $fullurl; ?>single-group-post.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php if ($notiposttitle != '') {
																						 echo $notiposttitle;
																					 } else {
																						 echo 'view post';
																					 } ?></a></span>
																<?php } ?>

																<?php if ($rowNotification['notificationText'] == 'groupcomment') { ?>
																	<span class="timelinecontantsubline">posted a comment on your group post
																		<a
																			href="<?php echo $fullurl; ?>single-group-post.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php if ($notiposttitle != '') {
																						 echo $notiposttitle;
																					 } else {
																						 echo 'view post';
																					 } ?></a></span>
																<?php } ?>

																<?php if ($rowNotification['notificationText'] == 'grouppost') { ?>
																	<span class="timelinecontantsubline">shared a post in your group <a
																			href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo $notigroupid; ?>"><?php echo $notigroupname; ?></a></span>
																<?php } ?>

																<?php if ($rowNotification['notificationText'] == 'grouprequest') { ?>
																	<span class="timelinecontantsubline">wants to join your group <a
																			href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo $notigroupid; ?>"><?php echo $notigroupname; ?></a></span>
																	<div class="add-frnd">
																		<a href="<?php echo $fullurl; ?>common_action.php?userId=<?php echo $notiuserid; ?>&joinedGroupId=<?php echo $notigroupid; ?>&action=actgrouprequest"
																			target="actionfrm" onClick="$('#commonloader').show();">Confirm
																		</a>
																		<a href="<?php echo $fullurl; ?>common_action.php?userId=<?php echo encodeStr($rowNotification["contactId"]); ?>&dltGroupId=<?php echo $notigroupid; ?>&action=publicdltgrouprequest"
																			target="actionfrm" class="dlt"
																			onClick="$('#commonloader').show();">Decline</a>
																	</div>
																<?php } ?>


																<?php if ($rowNotification['notificationText'] == 'grouprequestmobile') { ?>
																	<span class="timelinecontantsubline">Added you to in his group <a
																			href="<?php echo $fullurl; ?>private-group.html?groupId=<?php echo $notigroupid; ?>"><?php echo $notigroupname; ?></a></span>
																<?php } ?>


																<?php 
																


																if ($rowNotification['notificationText'] == 'privategrouprequest') { ?>
																	<span class="timelinecontantsubline">wants to join his group <a
																			href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo $notigroupid; ?>"><?php echo $notigroupname; ?></a></span>
																	<div class="add-frnd">
																		<a href="<?php echo $fullurl; ?>common_action.php?userId=<?php echo encodeStr($rowNotification["userId"]); ?>&joinedGroupId=<?php echo $notigroupid; ?>&contactId=<?php echo $notiuserid; ?>&action=actprivategrouprequest"
																			target="actionfrm" onClick="$('#commonloader').show();">Confirm
																		</a>
																		<a href="<?php echo $fullurl; ?>common_action.php?dltGroupId=<?php echo $notigroupid; ?>&action=dltgrouprequest&userId=<?php echo encodeStr($_SESSION["sessUserId"]); ?>"
																			target="actionfrm" class="dlt"
																			onClick="$('#commonloader').show();">Decline</a>
																	</div>
																<?php } ?>

																<?php if ($rowNotification['notificationText'] == 'acceptgrouprequest') { ?>
																	<span class="timelinecontantsubline">has accepted your group joining
																		request <a
																			href="<?php echo $fullurl;
																			if ($rowGroupName["groupType"] == 0) { ?>groups-detail<?php } else { ?>private-group<?php } ?>.html?groupId=<?php echo $notigroupid; ?>"><?php echo $notigroupname; ?></a>
																	</span>
																<?php } ?>

															<?php } ?>


															<?php if ($rowNotification['postType'] == 10) { ?>


																<?php if ($rowNotification['notificationText'] == 'tag') { ?>
																	<span class="timelinecontantsubline">tagged you in a post. <a
																			class="blue-white-btn"
																			href="<?php echo $fullurl; ?>single-post.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php if ($notiposttext != '') {
																						 echo $notiposttext;
																					 } else {
																						 echo 'view post';
																					 } ?></a></span>
																<?php } ?>

															<?php } ?>

															<?php if ($rowNotification['postType'] == 11) { ?>


																<?php if ($rowNotification['notificationText'] == 'actrequest') { ?>
																	<span class="timelinecontantsubline">accepted your contact
																		request</span>
																<?php } ?>

															<?php } ?>

															<?php if ($rowNotification['postType'] == 12) { ?>


																<?php if ($rowNotification['notificationText'] == 'shareprofile') {

																	$aa = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowNotification["postId"] . "";
																	$bb = mysqli_query($conn, $aa) or die(mysqli_error($conn));
																	$notiuser2 = mysqli_fetch_array($bb);

																	/*$cc="SELECT * from "._CHAT_MASTER_TABLE_." WHERE contactId= ".$rowNotification["contactId"]." and userId= ".$rowNotification["userId"]." ";
																	$dd=mysql_query($cc) or die(mysql_error()); 
																	$notipost2=mysql_fetch_array($dd);*/

																	?>
																	<span class="timelinecontantsubline">shared <a
																			href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($notiuser2['userId']); ?>/<?php echo $notiuser2['userurl']; ?>.html"
																			target="_blank"><?php if ($notiuser2['userId'] == $rowNotification["userId"]) { ?>your<?php } else { ?><?php echo $notiuser2["firstName"] . ' ' . $notiuser2["lastName"];
																			} ?></a>
																		profile</span>
																<?php } ?>

															<?php } ?>

															<?php if ($rowNotification['postType'] == 13) { ?>


																<?php if ($rowNotification['notificationText'] == 'changejob') {

																	$aa = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowNotification["contactId"] . "";
																	$bb = mysqli_query($conn, $aa) or die(mysqli_error($conn));
																	$notiuser2 = mysqli_fetch_array($bb);

																	$aa = "SELECT companyName from " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " WHERE userId= " . $notiuser2['userId'] . " and currentPosition=1";
																	$bb = mysqli_query($conn, $aa) or die(mysqli_error($conn));
																	$companyuserres = mysqli_fetch_array($bb);
																	?>
																	<span class="timelinecontantsubline">has a new job at
																		<?php echo $companyuserres["companyName"]; ?> <a
																			href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($notiuser2['userId']); ?>/<?php echo $notiuser2['userurl']; ?>/congratulate.html"
																			target="_blank" class="blue-white-btn">Say congrats</a> </span>
																<?php } ?>

															<?php } ?>

															<?php if ($rowNotification['postType'] == 14) { ?>


																<?php if ($rowNotification['notificationText'] == 'interestedproject') {

																	$ap = "SELECT * from " . _PROJECT_MASTER_TABLE_ . " WHERE id= " . $rowNotification["postId"] . "";
																	$bp = mysqli_query($cconn, $ap) or die(mysqli_error($conn));
																	$rowProject = mysqli_fetch_array($bp);
																	?>
																	<span class="timelinecontantsubline">has applied for your project <a
																			href="<?php echo $fullurl; ?>preview-project.html?projId=<?php echo encodeStr($rowProject['id']); ?>"><?php echo $rowProject["projectTitle"]; ?></a>
																	</span>
																<?php } ?>

															<?php } ?>
															
															
															<?php if ($rowNotification['postType'] == 500 && 
																	  $rowNotification['notificationText'] == 'mentor_assigned') { ?>

															<?php
															// Fetch Mentor Info Correctly
															$mentorId = intval($rowNotification["contactId"]); // ✅ mentor id

															$mentorQuery = "SELECT firstName,lastName,userurl,profilePhoto 
																			FROM " . _USERS_MASTER_TABLE_ . " 
																			WHERE userId = $mentorId";

															$mentorRes = mysqli_query($conn, $mentorQuery);
															$mentor = mysqli_fetch_array($mentorRes);

															$mentorName = trim(($mentor['firstName'] ?? '') . ' ' . ($mentor['lastName'] ?? ''));
															?>

															<span class="timelinecontantsubline">
																👨‍🏫 <strong><?php echo $mentorName; ?></strong> Mohd Shadab is now your mentor
															</span>

															<?php } ?>





															<?php if ($rowNotification['postType'] == 155) { ?>


																<?php if ($rowNotification['notificationText'] == 'interestedjob') {

																	$ap = "SELECT * from " . _JOBS_MASTER_TABLE_ . " WHERE id= " . $rowNotification["postId"] . "";
																	$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
																	$rowProject = mysqli_fetch_array($bp);
																	?>
																	<span class="timelinecontantsubline">has applied for your job <a
																			href="<?php echo $fullurl; ?>view-job.html?id=<?php echo encodeStr($rowProject['id']); ?>"><?php echo $rowProject["jobTitle"]; ?></a>
																	</span>
																<?php } ?>

															<?php } ?>

															<?php if ($rowNotification['postType'] == 15) { ?>


																<?php if ($rowNotification['notificationText'] == 'companytag') {

																	$ap = "SELECT id,companyName from " . _COMPANY_MASTER_TABLE_ . " WHERE id= " . $rowNotification["companyId"] . "";
																	$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
																	$getResult = mysqli_fetch_array($bp);
																	?>
																	<span class="timelinecontantsubline">tagged your company <a
																			href="<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo encodeStr($getResult["id"]); ?>"><strong><?php echo $getResult["companyName"]; ?></strong></a>
																		in his post <a class="blue-white-btn"
																			href="<?php echo $fullurl; ?>single-post.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php if ($notiposttitle != '') {
																						 echo $notiposttitle;
																					 } else {
																						 echo 'view post';
																					 } ?></a>
																	</span>
																<?php } ?>

															<?php } ?>


															<?php if ($rowNotification['postType'] == 16) { ?>


																<?php if ($rowNotification['notificationText'] == 'companyupdate') {


																	?>
																	<span class="timelinecontantsubline">post a new update <a
																			href="<?php echo $fullurl; ?>company-updates.html?companyId=<?php echo encodeStr($rowNotification["companyId"]); ?>">View
																			Update</a> </span>
																<?php } ?>

															<?php } ?>


															<?php if ($rowNotification['postType'] == 20) { ?>

																<?php
																$ap = "SELECT * from " . _VAULT_MASTER_TABLE_ . " WHERE id= " . $rowNotification["postId"] . " ";
																$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
																$rowDetail = mysqli_fetch_array($bp);

																if ($rowNotification['notificationText'] == 'postvaultlike') { ?>
																	<span class="timelinecontantsubline">liked your document <a
																			href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowDetail["id"]); ?>"><?php echo getStrLength(strip_tags(stripslashes($rowDetail["name"])), 50); ?></a></span>
																<?php }

																if ($rowNotification['notificationText'] == 'postvaultshare') { ?>
																	<span class="timelinecontantsubline">shared a document <a
																			href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowDetail["id"]); ?>"><?php echo getStrLength(strip_tags(stripslashes($rowDetail["name"])), 50); ?></a></span>
																<?php } ?>

															<?php } ?>

															<?php if ($rowNotification['postType'] == 120) { ?>

																<?php
																$ap = "SELECT * from " . _MEETING_MASTER_TABLE_ . " WHERE id= " . $rowNotification["postId"] . " ";
																$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
																$rowDetail = mysqli_fetch_array($bp);
																if ($rowDetail["userId"] == $rowDetail["createdBy"]) {
																	$mymeeting = 1;
																} else {
																	$mymeeting = 2;
																}
																if ($rowNotification['notificationText'] == 'meeting') { ?>
																	<span class="timelinecontantsubline"
																		style="overflow: visible;max-height: inherit; height: auto;">Meeting
																		Request:
																		<strong><?php echo getStrLength(strip_tags(stripslashes($rowDetail["title"])), 50); ?></strong>
																		- <?php echo date("D j M, g:i a", $rowDetail['meetingDateTime']); ?>
																		- <?php echo stripslashes($rowDetail["duration"]); ?> <a
																			onClick="sharefuncommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?chatuserid=<?php echo encodeStr($rowDetail["userId"]); ?>&time=<?php echo $rowDetail['meetingDateTime']; ?>&type=meetingdetail&mymeeting=<?php echo $mymeeting; ?>','Meeting Request','202565610');"
																			class="blue-white-btn">View Detail</a></span>
																<?php }
															} ?>

															<label><?php echo makedatetime($rowNotification["dateAdded"]); ?></label>
														</div>
													</div>
												</div>
											</li>
											<?php $n++;
										}
									} ?>

								</ul>
								<?php
							}
							?>
							<!--End user notifications-->
							<?php
							if ($n == 0) {
								?>
								<div style="padding:20px; text-align:center; overflow:hidden;">No Notifications</div>
								<?php
							} ?>
						</div>

						<div>


							<?php
							$sql_ins = "UPDATE " . _NOTIFICATION_MASTER_TABLE_ . " SET status=1 where userId='" . $_SESSION['sessUserId'] . "' ";
							mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
							?>
							<script>
								$('#notificationnumber').text('0');

							</script>
						</div>
					</div>
					<?php include('right-sidebar.php'); ?>
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