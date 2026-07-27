<?php

include_once('inc.php');

if (trim($_REQUEST['commentbox']) != '' && $_REQUEST['parentId'] != '' && $_REQUEST['postId'] != '' && $_REQUEST['action'] == 'postcomment') {
	//include('mail.php'); 

	$insertFields = [];
	$insertVals = [];
	$whereFields = [];
	$whereVals = [];

	$insertFields[0] = "userId";
	$insertFields[1] = "postId";
	$insertFields[2] = "parentId";
	$insertFields[3] = "postType";
	$insertFields[4] = "commentText";
	$insertFields[5] = "dateAdded";


	$insertVals[0] = $_SESSION['sessUserId'];
	$insertVals[1] = ($_REQUEST['postId']);
	$insertVals[2] = clean($_REQUEST['parentId']);
	$insertVals[3] = clean($_REQUEST['postType']);
	$insertVals[4] = clean($_REQUEST['commentbox']);
	$insertVals[5] = time();

	$resInsert = insertDB(_COMMENT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$dateAdded = time();
	//$userId=decodeStr($_REQUEST['userId']);
	$userId = decodeStr($_REQUEST['contactuserId']);


	if ($_REQUEST["postType"] == 1 || $_REQUEST["postType"] == 2) {
		$notificationText = 'postcomment';
	}
	if ($_REQUEST["postType"] == 3) {
		$notificationText = 'articlecomment';
	}
	if ($_REQUEST["postType"] == 4) {
		$notificationText = 'groupcomment';
	}

	$sql_ins = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "',userId='" . $userId . "',postId= " . ($_REQUEST["postId"]) . ",postType=" . $_REQUEST["postType"] . ",notificationText='$notificationText',dateAdded='$dateAdded'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	if ($_REQUEST["postuserId"] != '') {

		$sql_ins = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "',userId='" . decodeStr($_REQUEST["postuserId"]) . "',parentId='" . decodeStr($_REQUEST["postuserId"]) . "',postId= " . ($_REQUEST["postId"]) . ",postType=" . $_REQUEST["postType"] . ",notificationText='$notificationText',dateAdded='$dateAdded'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	}

	$aa = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,email,onlineStatus from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $userId . "' ";
	$res5 = mysqli_query($conn, $aa);
	$getuser = mysqli_fetch_array($res5);
	$email = $getuser["email"];
	$firstName = $getuser['firstName'];
	$lastName = $getuser['lastName'];
	$profilePhoto = $getuser['profilePhoto'];
	$onlineStatus = $getuser['onlineStatus'];
	$userurl = $getuser["userurl"];
	if ($profilePhoto != '') {
		$profilePhoto = $profilePhoto;
	} else {
		$profilePhoto = 'user-placeholder.jpg';
	}


	if ($onlineStatus != 1) {

		$sqlCmnsts = "";
		$sqlCmnsts = "select dateAdded from " . _COMMENT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "'  order by id desc limit 1,1";
		$resCmnsts = mysqli_query($conn, $sqlCmnsts);
		$getCmnsts = mysqli_fetch_array($resCmnsts);
		$getDateAddedCmnts = $getCmnsts["dateAdded"];


		if ($getCmnsts["dateAdded"] < strtotime("-10 minutes", time()))//You can send an email after 10 minutes according last message
		{

			$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,cityName,countryName from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
			$res52 = mysqli_query($conn, $aa2);
			$getuser2 = mysqli_fetch_array($res52);

			$firstName2 = $getuser2['firstName'];
			$lastName2 = $getuser2['lastName'];
			$profilePhoto2 = $getuser2['profilePhoto'];
			$jobTitle = $getuser2["jobTitle"];
			$companyName = $getuser2["companyName"];
			$userurl2 = $getuser2["userurl"];
			$cityName = $getuser2["cityName"];
			$countryName = $getuser2["countryName"];

			if ($profilePhoto2 != '') {
				$profilePhoto2 = $profilePhoto2;
			} else {
				$profilePhoto2 = 'user-placeholder.jpg';
			}


			$sql = "SELECT emailCommentLike from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId= " . $userId . " ";
			$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
			$getUserSettings = mysqli_fetch_array($getSql);

			if ($_REQUEST['parentId'] == 0) {

				if ($getUserSettings["emailCommentLike"] == 1) {


					if ($userId != $_SESSION['sessUserId']) {
						if ($_REQUEST["postType"] == 2) {
							$cmTitle = '<strong>' . $firstName2 . '</strong> commented on your post';
							$cmlink = $fullurl . 'single-post.html?postId=' . encodeStr($_REQUEST["postId"]) . '&postType=2&cuid=' . $_SESSION['sessUserId'] . '&t=3';
						}
						if ($_REQUEST["postType"] == 3) {
							$cmTitle = '<strong>' . $firstName2 . '</strong> commented on your article';
							$cmlink = $fullurl . 'view-article.html?postId=' . encodeStr($_REQUEST["postId"]) . '&cuid=' . $_SESSION['sessUserId'] . '&t=4';
						}


						$mailBodyContent .= '';
						$mailBodyContent .= '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
		<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
			<tbody>
			<tr>
				<td align="center" valign="top">
					<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px">
						<tbody>
						<tr>
							<td align="center" valign="top" style="width:100%;padding:20px 0">
								<a href="' . $fullurl . '" target="_blank" >
									<img src="' . $fullurl . 'images/ndimlogo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
						</tr>
						<tr>
						  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">
								<div style="color:#666666; font-size:12px; margin-bottom:10px;">You have a new notification</div>
						
							  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">
							  
							  <div style="text-align:center; margin-bottom:5px; margin-top:5px;font-size:18px;">' . $cmTitle . '</div>
							  <div style="text-align:center; margin-top:10px; margin-bottom:30px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
		  <tbody><tr>
			<td colspan="2" align="center"><a href="' . $cmlink . '" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#1a94c3;border-radius:5px;margin-bottom: 0px;" target="_blank">View Comment </a></td>
			</tr>
		</tbody></table>
		</div>
								<div style="text-align:center;"><div style="
			width: 80px;
			height: 80px;
			overflow: hidden;margin:auto;
			margin-bottom:12px;
			border-radius: 100%;
			border: 3px #e9e9e9 solid; margin:auto;
		"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2"><img src="' . $fullurl . 'uploads/' . $profilePhoto2 . '" style="
			width: 100%;
		"></a></div>
		<div style="text-align:center; margin-bottom:5px; margin-top:5px;"><strong>' . $firstName2 . ' ' . $lastName2 . '</strong></div>
		<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $jobTitle . ' at ' . $companyName . '</div>
		<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $cityName . ', ' . $countryName . '</div> 
		</div>
							  </div>
								 
						  </td>
						</tr>
						<tr>
							<td align="center" style="padding:40px;margin:0">
							   <div style="text-align:center; font-size:12px; margin-bottom:20px;">
							  
							   <a href="' . $fullurl . 'privacy.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Privacy</a> - 
									
								  <a href="' . $fullurl . 'terms.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Terms</a> - 
									
								<a href="' . $fullurl . 'about.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">About</a> - 
									
								  <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div> 
		<p style="margin:0;padding:0;font-family:"Open Sans",Arial,Helvetica,sans-serif;line-height:24px;color:#616161;font-size:14px;text-align:center">
									 Powered by <a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $domainname . '</a></p>                    </td>
						</tr>
						</tbody>
					</table>
				</td>
			</tr>
			</tbody>
		</table>
		
		
		</div>';


						$subject = strip_tags($cmTitle);

						//send_template_mail(_FROM_EMAIL_TEMPLATE_ID_,$email,$subject,$mailBodyContent);
						$_SESSION['checkmsgtimetable'] = '';

					}
				}


			}

		}


	}


	?>

	<?php if ($_REQUEST['pageType'] == 'article') { ?>
		<script>
			//parent.reloadPage();
		</script>

	<?php } ?>


	<?php if ($_REQUEST['pageType'] == 'timeline') { ?>
		<script>


			parent.$('.commentrowboxclass').val('');
			parent.$('#postcomment<?php echo decodeStr($_REQUEST['postId']); ?><?php echo $_REQUEST["postType"]; ?>').load('<?php echo $fullurl; ?>post-comment.php?postId=<?php echo decodeStr($_REQUEST['postId']); ?>&postType=<?php echo $_REQUEST["postType"]; ?>&parentId=<?php echo $_REQUEST["parentId"]; ?>&limit=<?php echo $_REQUEST["limit"]; ?>');
		</script>

	<?php } ?>

	<?php if ($_REQUEST['pageType'] == 'grouptimeline') { ?>
		<script>


			parent.$('.commentrowboxclass').val('');
			parent.$('#postcomment<?php echo decodeStr($_REQUEST['postId']); ?><?php echo $_REQUEST["postType"]; ?>').load('<?php echo $fullurl; ?>post-comment.php?postId=<?php echo decodeStr($_REQUEST['postId']); ?>&postType=<?php echo $_REQUEST["postType"]; ?>&parentId=<?php echo $_REQUEST["parentId"]; ?>&limit=<?php echo $_REQUEST["limit"]; ?>');
		</script>

	<?php } ?>

	<?php

}


if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
	$aa = "select * from " . _COMMENT_MASTER_TABLE_ . " where postId=" . $_REQUEST['postId'] . " and postType=" . $_REQUEST['postType'] . " and parentId=0 ";
	$res5 = mysqli_query($conn, $aa);
	$totalpostcomment = mysqli_num_rows($res5);

	?>
	<?php if (isset($_REQUEST['limit']) && $totalpostcomment > 5 && $_REQUEST['limit'] == 5) { ?>

		<div style="padding:0px; font-size:13px;">

			<?php if ($_REQUEST['postType'] == 3) { ?>
				<a style="text-align:center; font-size:14px; color:#32a8d7; border-bottom:1px solid #ececed;"
					href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($_REQUEST['postId']); ?>">more
					comments</a>
			<?php } ?>

			<?php if ($_REQUEST['postType'] == 2 || $_REQUEST['postType'] == 1) { ?>
				<a style="text-align:center; font-size:14px; color:#32a8d7; border-bottom:1px solid #ececed;"
					href="<?php echo $fullurl; ?>single-post.html?postId=<?php echo encodeStr($_REQUEST['postId']); ?>&postType=<?php echo $_REQUEST['postType']; ?>">more
					comment</a>
			<?php } ?>

			<?php if ($_REQUEST['postType'] == 4) { ?>
				<a style="text-align:center; font-size:14px; color:#32a8d7; border-bottom:1px solid #ececed;"
					href="<?php echo $fullurl; ?>single-group-post.html?postId=<?php echo encodeStr($_REQUEST['postId']); ?>">view
					<?php echo $totalpostcomment - 5; ?> more comment</a>
			<?php } ?>

		</div>

	<?php } ?>

	<?php

	if (isset($_REQUEST['limit']) && $_REQUEST['limit'] == 5) {
		$limit = '5';

		if ($totalpostcomment > 5) {
			$startlmit = $totalpostcomment - 5;
		} else {
			$startlmit = 0;
		}


	} else {
		$startlmit = 0;
		$limit = '5000';
	}

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$postId = isset($_REQUEST['postId']) ? (int) $_REQUEST['postId'] : 0;
	$postType = isset($_REQUEST['postType']) ? (int) $_REQUEST['postType'] : 0;
	$parentId = isset($comment['id']) ? (int) $comment['id'] : 0;

	$a = "";
	$a = "select * from " . _COMMENT_MASTER_TABLE_ . " where postId=" . $postId . "  and commentText!='' and postType=" . $postType . " and parentId=0 order by id desc limit " . $startlmit . "," . $limit . "";
	//$a="select * from "._COMMENT_MASTER_TABLE_." where postId=".$postId."  and commentText!='' and postType=".$postType." and parentId=0 order by id desc";
	$b = getRecords(_COMMENT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $a);

	while ($comment = mysqli_fetch_array($b)) {

		$a2 = "SELECT * from usermaster WHERE userId = " . $comment["userId"] . "";
		$b2 = mysqli_query($conn, $a2) or die(mysqli_error($conn));


		$userres2 = mysqli_fetch_array($b2);

		if (isset($userres2['profilePhoto']) && trim($userres2['profilePhoto']) != '') {
			$userphoto = $userres2['profilePhoto'];
		} else {
			$userphoto = 'user-placeholder.jpg';
		}

		$parentuserid = '';

		$a235 = "SELECT userId from " . _SHAREANDUPDATES_TABLE_ . " WHERE id = " . $_REQUEST['postId'] . "";
		$b235 = mysqli_query($conn, $a235) or die(mysqli_error($conn));

		$postuserres2 = mysqli_fetch_array($b235);

		?>
		<li id="cmntid<?php echo $comment['id']; ?>">
			<div class="comment">
				<div class="comment-head">
					<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2['userId']); ?>/<?php echo $userres2['userurl']; ?>.html"
						class="cmnt-img"><img src="<?php echo $fullurl; ?>uploads/<?php echo $userphoto; ?>"></a>

					<div class="comment-nm-sec">
						<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2['userId']); ?>/<?php echo $userres2['userurl']; ?>.html"
							class="cmnt-nm"><?php echo stripslashes($userres2['firstName'] . ' ' . $userres2['lastName']); ?></a>

						<div class="timeand-rply">
							<?php echo makedatetime($comment["dateAdded"]); ?> - <a
								onclick="$('#replycomment<?php echo $comment['id']; ?>').show();$('#commentboxreply<?php echo $_REQUEST['postId']; ?><?php echo $comment['id']; ?>').focus();">Reply</a>
						</div>
					</div>
				</div>

				<div class="cmmnt-text">
					<?php echo strip_tags(stripslashes(trim($comment["commentText"]))); ?>
				</div><?php //echo $userres2['userId'].'==='.$postuserres2['userId']; ?>
				<?php if ($userres2['userId'] == $_SESSION["sessUserId"] || $postuserres2['userId'] == $_SESSION["sessUserId"]) { ?>
					<a class="close"
						onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo encodeStr($comment['id']); ?>','dltcmnt');"><i
							title="Remove" class="fa fa-times" aria-hidden="true"></i></a>
				<?php } ?>
			</div>


			<div style="margin-top:10px; display:none;" id="replycomment<?php echo $comment['id']; ?>" class="replycmntclass">
				<div class="write-cmnt-pic"> <img
						src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($myprofilePhoto)); ?>"> </div>
				<div class="cmnt-inpt" style="width:100%;">

					<input type="text" class="commentrowboxclass"
						id="commentboxreply<?php echo $_REQUEST['postId']; ?><?php echo $comment['id']; ?>" name="commentbox"
						placeholder="Type your reply" maxlength="250" autocomplete="off">

					<button type="button"
						onclick="postcmnt('<?php echo $_REQUEST['postId']; ?>','<?php echo $_REQUEST['postType']; ?>','<?php echo encodeStr($postuserres2['userId']); ?>','<?php echo encodeStr($comment["userId"]); ?>','<?php echo $comment['id']; ?>','<?php echo $comment['id']; ?>');"><i
							class="fa fa-paper-plane" aria-hidden="true"></i></button>


				</div>
			</div>

			<script>
				$("#commentboxreply<?php echo $_REQUEST['postId']; ?><?php echo $comment['id']; ?>").keypress(function (event) {
					if (event.which == 13) {
						postcmnt('<?php echo $_REQUEST['postId']; ?>', '<?php echo $_REQUEST['postType']; ?>', '<?php echo encodeStr($postuserres2['userId']); ?>', '<?php echo encodeStr($comment["userId"]); ?>', '<?php echo $comment['id']; ?>', '<?php echo $comment['id']; ?>');
					}
				});
			</script>
			<?php

			$postId = isset($_REQUEST['postId']) ? (int) $_REQUEST['postId'] : 0;
			$postType = isset($_REQUEST['postType']) ? (int) $_REQUEST['postType'] : 0;
			$parentId = isset($comment['id']) ? (int) $comment['id'] : 0;


			$ab = "";
			$ab = "SELECT * FROM " . _COMMENT_MASTER_TABLE_ . " 
       WHERE postId = $postId 
       AND commentText != '' 
       AND postType = $postType 
       AND parentId = $parentId";

			$bb = getRecords(_COMMENT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $ab);

			while ($comment2 = mysqli_fetch_array($bb)) {
				$a2 = "SELECT * from usermaster WHERE userId = " . $comment2["userId"] . "";
				$b2 = mysqli_query($conn, $a2) or die(mysqli_error($conn));
				$userres23 = mysqli_fetch_array($b2);


				if (isset($userres2['profilePhoto']) && trim($userres2['profilePhoto']) != '') {
					$userphoto = $userres2['profilePhoto'];
				} else {
					$userphoto = 'user-placeholder.jpg';
				}

				?>



				<div class="comment replycommentclass" id="cmntrplid<?php echo $comment2['id']; ?>">
					<div class="comment-head">
						<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres23['userId']); ?>/<?php echo $userres23['userurl']; ?>.html"
							class="cmnt-img"><img src="<?php echo $fullurl; ?>uploads/<?php echo $userphoto3; ?>"></a>

						<div class="comment-nm-sec">
							<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres23['userId']); ?>/<?php echo $userres23['userurl']; ?>.html"
								class="cmnt-nm"><?php echo stripslashes($userres23['firstName'] . ' ' . $userres23['lastName']); ?></a>



							<div class="timeand-rply">
								<?php echo makedatetime($comment2["dateAdded"]); ?>
							</div>



						</div>
					</div>
					<div class="cmmnt-text">
						<?php echo strip_tags(stripslashes(trim($comment2["commentText"]))); ?>
					</div>


					<?php if ($userres23['userId'] == $_SESSION["sessUserId"] || $postuserres2['userId'] == $_SESSION["sessUserId"]) { ?>
						<a class="close"
							onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo encodeStr($comment2['id']); ?>','dltreply');"><i
								title="Remove" class="fa fa-times" aria-hidden="true"></i></a>
					<?php } ?>
				</div>

			<?php } ?>





		</li>

	<?php } ?>


	<script>$('#commentdisplaybox<?php echo $_REQUEST['postId']; ?><?php echo $_REQUEST["postType"]; ?> span').text('<?php echo $totalpostcomment; ?>');</script>

<?php } ?>