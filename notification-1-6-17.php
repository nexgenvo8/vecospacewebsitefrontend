<?php
include_once('inc.php');
include_once('config/session-check.inc.php');

?>
<span class="list-heding">Notifications</span>
<div style="overflow:auto; max-height:250px;">

	<?php
	$n = 0;
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlLogin = "";
	$sqlLogin = "select * from " . _NOTIFICATION_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and contactId!='" . $_SESSION['sessUserId'] . "' order by dateAdded desc LIMIT 0,30 ";
	$resLogin = getRecords(_NOTIFICATION_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
	if ($resLogin) {
		while ($rowNotification = mysqli_fetch_array($resLogin)) {

			$friendnameurl = '';
			$userphoto = '';
			$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowNotification["contactId"] . "";
			$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
			$notiuser = mysqli_fetch_array($b);

			$friendnameurl = $notiuser['userurl'];

			if ($notiuser["profilePhoto"] != '') {
				$userphoto = $notiuser["profilePhoto"];
			} else {
				$userphoto = 'user-placeholder.jpg';
			}
			$notiuserid = encodeStr($notiuser['userId']);
			$notiName = $notiuser["firstName"] . ' ' . $notiuser["lastName"];
			$mycountryName = $notiuser["countryName"];
			$mystateName = $notiuser["cityName"];
			$mylocationName = $notiuser["locationName"];

			$c = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE id= " . $rowNotification["postId"] . "";
			$d = mysqli_query($conn, $c) or die(mysqli_error($conn));
			$notipost = mysqli_fetch_array($d);
			$notipostid = encodeStr($notipost['id']);
			$notiposttype = $notipost['postType'];
			$notiposttitle = substr(strip_tags(stripslashes(trim($notipost['postTitle']))), 0, 20);
			$notiposttext = substr(strip_tags(stripslashes(trim($notipost['postText']))), 0, 20);




			if ($rowNotification["groupId"] != '') {

				$sql_groupName = "SELECT id,groupName,groupType from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $rowNotification["groupId"] . " ";
				$resgroupName = mysqli_query($conn, $sql_groupName) or die(mysqli_error($conn));
				$rowGroupName = mysqli_fetch_array($resgroupName);
				$notigroupname = $rowGroupName['groupName'];
				$notigroupid = encodeStr($rowGroupName['id']);

			}
			?>

			<li>
				<div class="rquest-box">
					<a href="<?php echo $fullurl; ?>profile/<?php echo $notiuserid; ?>/<?php echo $friendnameurl; ?>.html"
						target="_blank" class="rqst-img"><img
							src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
					<div class="rqst-right">
						<div class="rquest-middle">
							<a href="<?php echo $fullurl; ?>profile/<?php echo $notiuserid; ?>/<?php echo $friendnameurl; ?>.html"
								target="_blank"><?php echo $notiName; ?></a>


							<?php if ($rowNotification['postType'] == 1 || $rowNotification['postType'] == 2) { ?>


								<?php if ($rowNotification['notificationText'] == 'postlike') { ?>
									<span class="timelinecontantsubline">liked your post <a
											href="<?php echo $fullurl; ?>single-post.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php echo $notiposttext; ?></a></span>
								<?php } ?>

								<?php if ($rowNotification['notificationText'] == 'postcomment') {
									if ($notiposttext == '') {
										$notiposttext = 'Photo';
									} ?>
									<span class="timelinecontantsubline">posted a comment on your post <a
											href="<?php echo $fullurl; ?>single-post.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php echo $notiposttext; ?></a></span>
								<?php } ?>


							<?php } ?>


							<?php if ($rowNotification['postType'] == 3) { ?>


								<?php if ($rowNotification['notificationText'] == 'postlike') { ?>
									<span class="timelinecontantsubline">liked your article post <a
											href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php echo $notiposttitle; ?></a></span>
								<?php } ?>

								<?php if ($rowNotification['notificationText'] == 'articlecomment') { ?>
									<span class="timelinecontantsubline">posted a comment on your article <a
											href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php echo $notiposttitle; ?></a></span>
								<?php } ?>
							<?php } ?>



							<?php if ($rowNotification['postType'] == 4) { ?>
								<?php if ($rowNotification['notificationText'] == 'postlike') { ?>
									<span class="timelinecontantsubline">liked your group post <a
											href="<?php echo $fullurl; ?>single-group-post.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php echo $notiposttitle; ?></a></span>
								<?php } ?>

								<?php if ($rowNotification['notificationText'] == 'groupcomment') { ?>
									<span class="timelinecontantsubline">posted a comment on your group post <a
											href="<?php echo $fullurl; ?>single-group-post.html?postId=<?php echo $notipostid; ?>&postType=<?php echo $notiposttype; ?>"><?php echo $notiposttitle; ?></a></span>
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
											target="actionfrm">Confirm </a>
										<a href="<?php echo $fullurl; ?>common_action.php?userId=<?php echo $notiuserid; ?>&dltGroupId=<?php echo $notigroupid; ?>&action=dltgrouprequest"
											target="actionfrm" class="dlt">Decline</a>
									</div>
								<?php } ?>

								<?php if ($rowNotification['notificationText'] == 'privategrouprequest') { ?>
									<span class="timelinecontantsubline">wants to join his group <a
											href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo $notigroupid; ?>"><?php echo $notigroupname; ?></a></span>
									<div class="add-frnd">
										<a href="<?php echo $fullurl; ?>common_action.php?userId=<?php echo encodeStr($rowNotification["userId"]); ?>&joinedGroupId=<?php echo $notigroupid; ?>&contactId=<?php echo $notiuserid; ?>&action=actprivategrouprequest"
											target="actionfrm">Confirm </a>
										<a href="<?php echo $fullurl; ?>common_action.php?dltGroupId=<?php echo $notigroupid; ?>&action=dltgrouprequest"
											target="actionfrm" class="dlt">Decline</a>
									</div>
								<?php } ?>

								<?php if ($rowNotification['notificationText'] == 'acceptgrouprequest') { ?>
									<span class="timelinecontantsubline">Accepted your group joining request <a
											href="<?php echo $fullurl;
											if ($rowGroupName["groupType"] == 0) { ?>groups-detail<?php } else { ?>private-group<?php } ?>.html?groupId=<?php echo $notigroupid; ?>"><?php echo $notigroupname; ?></a></span>
								<?php } ?>

							<?php } ?>


							<label><?php echo makedatetime($rowNotification["dateAdded"]); ?></label>
						</div>
					</div>
				</div>
			</li>
			<?php $n++;
		}
	} ?>


</div>
<?php
if ($n == 0) {
	?>
	<div style="padding:20px; text-align:center; overflow:hidden;">No Notifications</div>
<?php
}
$sql_ins = "UPDATE " . _NOTIFICATION_MASTER_TABLE_ . " SET status=1 where userId='" . $_SESSION['sessUserId'] . "' ";
mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
?>
<script>
	$('#notificationnumber').text('0');

</script>