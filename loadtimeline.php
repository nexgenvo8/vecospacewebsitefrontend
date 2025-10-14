<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$startpage = $_REQUEST['startpage'] ?? '';
$endpage = $_REQUEST['endpage'] ?? '';
$pageid = $_REQUEST['pageid'] ?? '';
$getPostId = $_REQUEST['postId'] ?? '';
$getPostType = $_REQUEST['postType'] ?? '';

$activitPostType = $_REQUEST['activitPostType'] ?? '';
$postWhere = "";

$postWhere = "select * from " . _TIMELINE_MASTER_TABLE_ . " where " . $postWhere . " (userId IN(SELECT contactId FROM " . _CONTACT_MASTER_TABLE_
	. " WHERE  userId='" . $_SESSION['sessUserId'] . "' and status=1 and shareType=2) OR  shareType=1) and status=1 and userId!=106  and adType=0 and postId!=0 order by dateAdded desc limit " . $startpage . "," . $endpage . " ";

if ($getPostId != '' && $getPostType != '') {
	$postWhere = "select * from " . _TIMELINE_MASTER_TABLE_ . " where postId=" . decodeStr($getPostId) . " and postType=" . $getPostType . " and userId!=106 and adType=0  order by dateAdded desc limit " . $startpage . "," . $endpage . " ";
}

if ($activitPostType != '') {
	$wherepostActivityType = '';
	if ($activitPostType == 0) {
		$wherepostActivityType = '';
	}

	if ($activitPostType == 1) {
		$wherepostActivityType = ' and postType=2';
	}

	if ($activitPostType == 2) {
		$wherepostActivityType = ' and postType=3';
	}

	$postWhere = "select * from " . _TIMELINE_MASTER_TABLE_ . " where userId=" . $_SESSION['useractivity'] . " " . $wherepostActivityType . " and userId!=106 and adType=0   order by dateAdded desc limit " . $startpage . "," . $endpage . " ";


}

?>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
$dob = $month . '-' . $day;
if ($dob == date("m-d")) {
	?>
	<div class="birthday-cont">

		<div class="birth-contnr">
			<div class="bday-wish"><?php echo $companNameTitle; ?> is celebrating your birthday</div>
			<h1>Happy Birthday</h1>
			<div class="birth-nm"><?php echo $myname; ?></div>
		</div>
		<canvas id="birthday"></canvas>
	</div>




	<script type="text/javascript" src="<?php echo $fullurl; ?>js/index.js"></script>
	<?php
}

//unset($selectFields);
//unset($whereFields);
//unset($whereVals);
//
//$sqlQuery="";
//$sqlQuery="select dob,userId,firstName,lastName,profilePhoto,userurl from "._USERS_MASTER_TABLE_." where userId IN(select contactId from "._CONTACT_MASTER_TABLE_." where userId='".$_SESSION['sessUserId']."' and status=1 and birthdayStatus=0) and dob!='0000-00-00' ";
//$resQuery=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlQuery); 	
//if($resQuery)
//{
//	while($rowcontacts=mysql_fetch_array($resQuery))
//	{
//			$userdob=$rowcontacts["dob"];
//			  
//			$userdobArr=explode("-", $userdob);
//			$dobyear=$userdobArr[0];
//			$dobmonth=$userdobArr[1];
//			$dobday=$userdobArr[2];
//			
//			$userdob=$dobmonth.'-'.$dobday;
//						
//			if($userdob==date("m-d"))
//			{
//				
//				$frienddobnameurl=$rowcontacts['userurl'];
//				if($rowcontacts["profilePhoto"]!='')
//				{
//				$userdobphoto=$rowcontacts["profilePhoto"];
//				} else {
//				$userdobphoto='user-placeholder.jpg';
//				}	
?>
<!--<div class="wish-list" id="saybirthday<?php echo $rowcontacts['userId']; ?>">
				<div class="wish-box">
		<div class="img">
			<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowcontacts['userId']); ?>/<?php echo $frienddobnameurl; ?>.html" target="_blank" class="rqst-img"><img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userdobphoto)); ?>"></a>
		</div>
		<div class="wish-nam">
			<label>Wish <?php echo stripslashes(trim($rowcontacts["firstName"])); ?> <?php echo stripslashes(trim($rowcontacts["lastName"])); ?> a <strong>Happy Birthday</strong></label>
			
	
		<a onclick="openuserchatbox('<?php echo encodeStr($rowcontacts['userId']); ?>','<?php echo stripslashes(trim($rowcontacts["firstName"])); ?> <?php echo stripslashes(trim($rowcontacts["lastName"])); ?>','<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowcontacts['userId']); ?>/<?php echo $frienddobnameurl; ?>.html');$('#chatfieldfooter').val('Happy Birthday');$('#shb').val('1');" class="say-bday">Say Happy Birthday</a>
		</div>
		<div class="errow-drop"> <span class="errow"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
	  <ul class="erow-list">        
		<li> <a href="<?php echo $fullurl; ?>common_action.php?contactId=<?php echo encodeStr($rowcontacts['userId']); ?>&action=removeshb" target="actionfrm"><i class="fa fa-window-close-o" aria-hidden="true"></i> Remove</a></li>
		
		
	  </ul>
	</div>
	</div>
	
</div>-->
<?php
//	}
//		
//	}
//}
?>
<?php
$n = 0;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlLogin = "";
$sqlLogin = $postWhere;
$resLogin = getRecords(_TIMELINE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
if ($resLogin) {
	while ($row = mysqli_fetch_array($resLogin)) {

		if ($row["status"] == 1 || $row["status"] == 0) {

			$ha = "SELECT id from " . _HIDDEN_POSTS_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " and timeLineId=" . $row["postId"] . " ";
			$hb = mysqli_query($conn, $ha) or die(mysqli_error($conn));
			$hidpost = mysqli_num_rows($hb);
			if ($hidpost == 0) {


				$aa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= " . $row["postId"] . " and postType= " . $row["postType"] . "";
				$res5 = mysqli_query($conn, $aa);
				$totalpostlike = mysqli_num_rows($res5);

				$aa2 = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= " . $row["postId"] . " and postType= " . $row["postType"] . " and userId=" . $_SESSION["sessUserId"] . "";
				$res52 = mysqli_query($conn, $aa2);
				$getpostlike = mysqli_num_rows($res52);


				$totalpostcomment = '0';
				$totalpostshared = '0';

				$aa = "SELECT * from " . _COMMENT_MASTER_TABLE_ . " WHERE postId= " . $row["postId"] . " and postType= " . $row["postType"] . " and parentId=0";
				$res5 = mysqli_query($conn, $aa);
				$totalpostcomment = mysqli_num_rows($res5);

				$aas = "SELECT * from " . _SHARE_MASTER_TABLE_ . " WHERE postId= " . $row["postId"] . " and postType= " . $row["postType"] . "";
				$res5s = mysqli_query($conn, $aas);
				$totalpostshared = mysqli_num_rows($res5s);

				$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $row["userId"] . "";
				$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
				$userres = mysqli_fetch_array($b);



				$jobTitle = $userres["jobTitle"];
				$companyName = $userres["companyName"];

				$friendnameurl = $userres['userurl'];

				if ($userres["profilePhoto"] != '') {
					$userphoto = $userres["profilePhoto"];
				} else {
					$userphoto = 'user-placeholder.jpg';
				}








				if ($row["postType"] == 1 || $row["postType"] == 2 || $row["postType"] == 3) {

					$sql_inss = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE id= " . $row["postId"] . " and articleBlogStatus=0 ";
					$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
					$rowResults = mysqli_fetch_array($resresults);

					if ($row["postId"] == $rowResults["id"]) {
						?>


						<div class="timlist" id="<?php echo $rowResults['id']; ?>">
							<div class="hedr">
								<div class="prfl_img"> <a
										href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
											src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"
											style="border:<?php echo profileborder($userres['userstype']); ?>"></a> </div>
								<div class="hdr_right"><a
										href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes(trim($userres["firstName"])); ?>
										<?php echo stripslashes(trim($userres["lastName"])); ?><span> -
											<?php if ($row["postType"] == 3 && $rowResults["sharePost"] != 1) {
												echo 'Posted an article';
											} else {
												if ($rowResults["sharePost"] == 1) {
													if ($row["postType"] == 3) {
														echo 'Shared an article';
													} else {
														echo 'Shared a post';
													}
												}
											} ?>
											<?php echo makedatetime($row["dateAdded"]); ?></span></a>
									<?php if ($row["postType"] == 3 && $rowResults["sharePost"] != 1) { ?>
										<span class="timelinecontantsubline"></span>
									<?php } ?>
									<label class="time"><?php echo $jobTitle; ?>
										<?php if ($companyName != '') {
											echo 'at ' . $companyName;
										} ?>
									</label>

								</div>

								<?php if ($row["postType"] == 1 || $row["postType"] == 2) { ?>
									<div class="errow-drop"> <span class="errow" onclick="accordion('<?php echo $row['id']; ?>');"><i
												class="fa fa-angle-down" aria-hidden="true"></i></span>
										<ul class="erow-list" id="<?php echo $row['id']; ?>">
											<li>
												<div style="display:none;" id="clipboard<?php echo ($rowResults['id']); ?>">
													<?php echo $fullurl . "single-post.html?postId=" . encodeStr($rowResults['id']) . "&postType=" . $row["postType"]; ?>
												</div>
												<a style="cursor:pointer;"
													onclick="copyToClipboard('#clipboard<?php echo ($rowResults['id']); ?>');"><i class="fa fa-link"
														aria-hidden="true"></i> Copy link to post</a>
											</li>
											<?php if ($userres['userId'] == $_SESSION['sessUserId']) { ?>
												<li> <!--<a href="common_action.php?dltid=<?php echo encodeStr($rowResults['id']); ?>&action=dlt" target="actionfrm"><i class="fa fa-window-close-o" aria-hidden="true"></i> Remove</a>-->
													<a
														onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo encodeStr($rowResults['id']); ?>','dltpost');"><i
															class="fa fa-window-close-o" aria-hidden="true"></i> Remove</a>
												</li>
											<?php } else { ?>
												<li><a onclick="alertpopupmain('<?php echo encodeStr($row["postId"]); ?>','hidepost22');"><i
															class="fa fa-eye-slash" aria-hidden="true"></i> Hide this post</a></li>
												<li><a
														onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo encodeStr($rowResults['id']); ?>&type=reportpost','Why are you reporting this?');"><i
															class="fa fa-flag" aria-hidden="true"></i> Report this post</a></li>
											<?php } ?>
										</ul>
									</div>
								<?php } ?>

								<?php if ($row["postType"] == 3) { ?>
									<div class="errow-drop"> <span class="errow" onclick="accordion('<?php echo $row['id']; ?>');"><i
												class="fa fa-angle-down" aria-hidden="true"></i></span>
										<ul class="erow-list" id="<?php echo $row['id']; ?>">
											<?php if ($userres['userId'] == $_SESSION['sessUserId']) { ?>
												<?php if ($rowResults["sharePost"] != 1) { ?>
													<li><a
															href="<?php echo $fullurl; ?>edit-article.html?editid=<?php echo encodeStr($rowResults['id']); ?>&action=edit"><i
																class="fa fa-pencil" aria-hidden="true"></i> Edit</a></li><?php } ?>
												<li><a onclick="alertpopupmain('<?php echo encodeStr($rowResults['id']); ?>','deletearticlepost');"><i
															class="fa fa-window-close-o" aria-hidden="true"></i> Remove</a></li>
											<?php } ?>
											<div style="display:none;" id="clipboard<?php echo ($rowResults['id']); ?>">
												<?php echo $fullurl . "view-article.html?postId=" . encodeStr($rowResults['id']) . "&postType=" . $row["postType"]; ?>
											</div>
											<li>
												<a style="cursor:pointer;"
													onclick="copyToClipboard('#clipboard<?php echo ($rowResults['id']); ?>');"><i class="fa fa-link"
														aria-hidden="true"></i> Copy link to post</a>
											</li>
											<li><a onclick="alertpopupmain('<?php echo encodeStr($row["postId"]); ?>','hidepost');"><i
														class="fa fa-eye-slash" aria-hidden="true"></i> Hide this article</a></li>
										</ul>
									</div>
								<?php } ?>

							</div>
							<div class="txtarea" id="txtarea<?php echo $rowResults['id']; ?>">
								<div style=" margin-bottom:10px;">
									<?php if ($row["postType"] == 1 || $row["postType"] == 2 || $rowResults["sharePost"] == 1) { ?>

										<div id="shortdesc<?php echo $rowResults['id']; ?>" style="position:relative; height:<?php if ($rowResults["websiteshare"] == 0 && $rowResults["sharePost"] == 0 && $rowResults["postText"] != '' && strlen((stripslashes($rowResults["postText"]))) > 200) {
											   echo '140px';
										   } else {
											   echo 'auto';
										   } ?>; overflow:hidden;">
											<?php echo stripslashes(nl2br(str_replace('&#63;', '', $rowResults["postText"]))); ?>
										</div>
										<?php
										if (strlen((stripslashes($rowResults["postText"]))) > 200 && $rowResults["websiteshare"] == 0 && $rowResults["sharePost"] == 0 && $rowResults["postText"] != '') {
											?>
											<div style="margin-top:10px; padding-left:0px; text-align:right;"
												id="hideafterreadmore<?php echo $rowResults['id']; ?>"><a style="cursor:pointer"
													id="readtext<?php echo $rowResults['id']; ?>"
													onClick="showmoreless('<?php echo $rowResults['id']; ?>');">read more</a></div>
											<?php
										}

										?>

									<?php } ?>
									<?php if ($row["postType"] == 3) { ?>
										<div style="font-size:15px; font-weight:bold; margin-bottom:5px;"><a
												href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($row['postId']); ?>"><?php echo stripslashes(strip_tags($rowResults["postTitle"])); ?></a>
										</div>
										<div class="timelinelistingcontant">
											<?php echo getStrLength(strip_tags(stripslashes($rowResults["postText"])), 210); ?>

											<div style="margin-top:10px; float:right; padding:10px;"><a
													href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($row['postId']); ?>">read
													more</a></div>
										</div>
									<?php } ?>
								</div>
								<?php

								$a = "";
								$a = "select * from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $row['postId'] . "";
								$b = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $a);
								if ($b) {
									$numrows = mysqli_num_rows($b);
									$width = '100%';

									while ($rowimg = mysqli_fetch_array($b)) {
										?>
										<img src="<?php echo $fullurl; ?>uploads/<?php echo $rowimg['imageName']; ?>"
											style="position:inline-block; cursor:pointer;"
											onclick="countpostview('<?php echo encodeStr($row['postId']); ?>');imagepopupmain('<?php echo $rowimg['id']; ?>');">
									<?php }
								}


								?>

								<?php if ($userres['userId'] == $_SESSION['sessUserId']) {

									if (($row["postType"] == 1 || $row["postType"] == 2) && $rowResults["sharePost"] != 1) { ?>
										<!-- <div class="promote-btn">
			   <a onclick="createadwindow('p','1','<?php echo ($row['postId']); ?>');">Promote</a>
		</div>-->
									<?php }
									if ($row["postType"] == 3) { ?>
										<!-- <div class="promote-btn">
			   <a onclick="createadwindow('a','1','<?php echo ($row['postId']); ?>');">Promote</a>
		</div>-->
									<?php }
								} ?>
								<div class="timeline-img"> </div>
							</div>

							<div
								style="padding:10px; position:relative; float:left; padding-left:20px; width:100%; color:rgba(0,0,0,.6); font-size:13px; ">
								<div style="position:absolute; left:15px;"><span
										id="post<?php echo $row["postId"]; ?><?php echo $row["postType"]; ?>"><span><?php if ($totalpostlike != '') {
												  echo $totalpostlike;
											  } else {
												  echo '0';
											  } ?></span></span>
									Like<?php if ($totalpostlike > 1) {
										echo 's';
									} ?> &nbsp;-&nbsp; <span
										id="commentdisplaybox<?php echo $row["postId"]; ?><?php echo $row["postType"]; ?>"><span>
											<?php if ($totalpostcomment != '') {
												echo $totalpostcomment;
											} else {
												echo $c = '0';
											} ?></span></span>
									<span>Comment<?php if ($totalpostcomment > 1) {
										echo 's';
									} ?></span>
								</div>




								<div style="position:absolute; right:15px;">
									<span id="shareposts<?php echo $row["postId"]; ?><?php echo $row["postType"]; ?>"><span><?php if ($totalpostshared != '') {
											  echo $totalpostshared;
										  } else {
											  echo '0';
										  } ?></span>
										Share</span>
								</div>
							</div>

							<div class="timlist-fttr">
								<table width="100%" cellpadding="0" cellspacing="0" border="0">
									<tr>
										<td width="15%">
											<div onclick="postlike(<?php echo $row['postId']; ?>,<?php echo $row['postType']; ?>,<?php if ($totalpostlike != '') {
													  echo $totalpostlike;
												  } else {
													  echo '0';
												  } ?>);postlikeunlike('<?php echo $row['id']; ?>');">
												<a><i class="fa fa-thumbs-up" aria-hidden="true" id="thumbid<?php echo $row["id"]; ?>" style="color: <?php if ($getpostlike > 0) {
													   echo 'rgb(255, 120, 0)';
												   } else {
													   echo 'rgb(128, 128, 128)';
												   } ?>;"></i><span>

													</span> Like </a>
											</div>

										</td>
										<td width="45%">
											<ul class="likes-mmbr loadlikeusers"
												id="likesmmbrdiv<?php echo $row["postId"]; ?>_<?php echo $row['postType']; ?>_<?php echo $row['id']; ?>"
												data-postid="<?php echo $row["postId"]; ?>" data-posttype="<?php echo $row["postType"]; ?>">
											</ul>
										</td>
										<script>
											$(document).ready(function () {
												$('.loadlikeusers').each(function () {
													var postId = $(this).data('postid');
													var postType = $(this).data('posttype');
													var $this = $(this);

													// Load the like users for each post uniquely
													$this.load('<?php echo rtrim($fullurl, "/"); ?>/loadlikeusers.php?postId=' + postId + '&postType=' + postType,
														function (response, status, xhr) {
															if (status === "error") {
																console.error("Error loading likes for postId " + postId + ": " + xhr.status + " " + xhr.statusText);
															}
														}
													);
												});
											});
										</script>


										<td width="20%" align="right">
											<div id="commentdisplaybox<?php echo $row['postId'] . $row['postType']; ?>"
												onclick="showComments('<?php echo $row['postId']; ?>', '<?php echo $row['postType']; ?>');"
												style="cursor:pointer;" class="triggerBtn">
												<i class="fa fa-commenting" aria-hidden="true"></i> Comment
											</div>
										</td>
										<td width="20%" align="right">
											<div><a
													onClick="sharefuncommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo encodeStr($row['postId']); ?>&type=share&sharePostType=<?php echo $row['postType']; ?>','Share','<?php echo $rowResults['id']; ?>');"><i
														class="fa fa-share" aria-hidden="true"></i> Share </a></div>
										</td>
									</tr>
								</table>


								<ul class="tmln_fttr" style="display: none;">
									<li id="post<?php echo $row["postId"]; ?><?php echo $row["postType"]; ?>" onclick="postlike(<?php echo $row['postId']; ?>,<?php echo $row['postType']; ?>,<?php if ($totalpostlike != '') {
													echo $totalpostlike;
												} else {
													echo '0';
												} ?>;">
										<a><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like <span>
												<?php if ($totalpostlike != '') {
													echo $totalpostlike;
												} else {
													echo '0';
												} ?>
											</span></a>
									</li>





									<li class="views">
										<?php if ($rowResults['viewStatus'] != 0) {
											echo $rowResults['viewStatus'];
											if ($rowResults['viewStatus'] > 1) {
												echo ' views';
											} else {
												echo ' view';
											}
										} ?>
									</li>
								</ul>
								<div class="commnts-cont" style="display:none;"
									id="commnts-cont<?php echo $row['postId'] . $row['postType']; ?>">
									<div class="comnt-write">
										<div class="write-cmnt-pic">
											<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($myprofilePhoto)); ?>">
										</div>
										<div class="cmnt-inpt">
											<input type="text" class="commentrowboxclass"
												id="commentbox<?php echo $row['postId'] . $row['postType']; ?>" placeholder="Type your comment"
												maxlength="250">

											<button type="button" onclick="postcmnt('<?php echo $row['postId']; ?>',
									   '<?php echo $row['postType']; ?>',
									   '<?php echo encodeStr($userres['userId']); ?>',
									   '', '0', '',
									   '<?php echo (isset($_REQUEST['siglepost']) && $_REQUEST['siglepost'] == 1) ? '10000' : '5'; ?>');">
												<i class="fa fa-paper-plane" aria-hidden="true"></i>
											</button>
										</div>
									</div>

									<ul class="cmmnt-list" style="display:none;"
										id="postcomment<?php echo $row['postId'] . $row['postType']; ?>">
										Loading...
									</ul>
								</div>

								<!-- <script>
									function showComments(postId, postType) {
										const commentContainer = document.getElementById("commnts-cont" + postId + postType);
										const commentList = document.getElementById("postcomment" + postId + postType);
										const commentBox = document.getElementById("commentbox" + postId + postType);

										// Toggle visibility
										commentContainer.style.display = "block";
										commentList.style.display = "block";
										commentBox.focus();

										// Load comments only once
										if (!commentList.getAttribute("data-loaded")) {
											$(commentList).load(
												"post-comment.php?postId=" + postId + "&postType=" + postType + "&parentId=0&limit=" +
												(<?php echo (isset($_REQUEST['siglepost']) && $_REQUEST['siglepost'] == 1) ? '10000' : '5'; ?>),
												function () {
													commentList.setAttribute("data-loaded", "true");
												}
											);
										}
									}

									// Enter key handler
									$(document).on("keypress", ".commentrowboxclass", function (event) {
										if (event.which === 13) {
											const idParts = $(this).attr("id").replace("commentbox", "").match(/(\d+)(.*)/);
											if (idParts) {
												showComments(idParts[1], idParts[2]);
												postcmnt(idParts[1], idParts[2], "<?php echo encodeStr($userres['userId']); ?>", "", "0", "", "<?php echo (isset($_REQUEST['siglepost']) && $_REQUEST['siglepost'] == 1) ? '10000' : '5'; ?>");
											}
										}
									});

								</script> -->
								<script>
									function showComments(postId, postType) {
										const commentContainer = document.getElementById("commnts-cont" + postId + postType);
										const commentList = document.getElementById("postcomment" + postId + postType);
										const commentBox = document.getElementById("commentbox" + postId + postType);

										// Show comment container
										commentContainer.style.display = "block";
										commentList.style.display = "block";
										commentBox.focus();

										// Always reload comments when opening
										$(commentList).load(
											"post-comment.php?postId=" + postId +
											"&postType=" + postType +
											"&parentId=0&limit=" +
											(<?php echo (isset($_REQUEST['siglepost']) && $_REQUEST['siglepost'] == 1) ? '10000' : '5'; ?>)
										);
									}

									// Enter key handler for comment box
									$(document).on("keypress", ".commentrowboxclass", function (event) {
										if (event.which === 13) { // Enter key
											const idParts = $(this).attr("id").replace("commentbox", "").match(/(\d+)(.*)/);
											if (idParts) {
												const postId = idParts[1];
												const postType = idParts[2];

												// Post comment
												postcmnt(
													postId,
													postType,
													"<?php echo encodeStr($userres['userId']); ?>",
													"",
													"0",
													"",
													"<?php echo (isset($_REQUEST['siglepost']) && $_REQUEST['siglepost'] == 1) ? '10000' : '5'; ?>"
												);

												// Refresh comments after posting
												showComments(postId, postType);
											}
										}
									});
								</script>

							</div>
						</div>

						<script>
							$('#postcomment<?php echo $row['postId']; ?><?php echo $row['postType']; ?>').load('post-comment.php?postId=<?php echo $row['postId']; ?>&postType=<?php echo $row['postType']; ?>&parentId=0&limit=<?php if ($_REQUEST['siglepost'] == 1) {
											echo '10000';
										} else {
											echo '5';
										} ?>');
						</script>


						<?php
					}

				}



			}

			if ($n == 1 || $n == 8 || $n == 14) {
				$newloadtime1 = mt_rand(100000000, 999999999);

				?>
				<div id="loadrandom<?php echo $newloadtime1; ?>"></div>
				<!--<script>
	$('#loadrandom<?php echo $newloadtime1; ?>').load('randomtimeline_ads.php');
	</script>-->
				<?php
			}


			if ($n == 8 || $n == 12 || $n == 15) {
				$newloadtime = mt_rand(100000000, 999999999);

				?>
				<div id="loadrandom<?php echo $newloadtime; ?>"></div>
				<script>
					$('#loadrandom<?php echo $newloadtime; ?>').load('randomtimeline_event.php');
				</script>
				<?php
			}


			if ($n == 8 || $n == 13 || $n == 18) {
				$newloadtime1 = mt_rand(100000000, 999999999);

				?>
				<div id="loadrandom<?php echo $newloadtime1; ?>"></div>
				<script>
					$('#loadrandom<?php echo $newloadtime1; ?>').load('randomtimeline_group.php');
				</script>
				<?php
			}
		}
		$n++;




	}
}

if ($n == 0) { ?>
	<div class="timlist" style="min-height:218px;">
		<div class="not-found">
			<!--<i class="fa fa-times-circle-o" aria-hidden="true"></i>
		<h2>This page isn't available</h2>
		<p>The link you followed may be broken, or the page may have been removed.</p>-->
			<p>Not found.</p>
		</div>

	</div>
<?php } ?>

<div id="loadtimeline<?php echo $endpage; ?>">
	<?php if ($n > 19) {
		if ($_SESSION['useractivity'] != '') { ?>
			<a onClick="loadtimelineActivitfun('<?php echo $endpage; ?>','<?php echo $endpage + 1; ?>','<?php echo $endpage + 20; ?>');"
				class="load-more">Load More Posts</a>
		<?php } else { ?>
			<a onClick="loadtimeline('<?php echo $endpage; ?>','<?php echo $endpage + 1; ?>','<?php echo $endpage + 20; ?>');"
				class="load-more">Load More Posts</a>
		<?php }
	} ?>
</div>



<script>

	$(document).on("click", ".triggerBtn", function () {
		var inputField = $(this).closest('div').find('.commentrowboxclass').focus();

	});
</script>
<style>
	.timlist-fttr table td,
	.timlist-fttr table td a {
		color: rgba(0, 0, 0, .6);
		font-size: 15px;
		font-weight: 600;
	}
</style>