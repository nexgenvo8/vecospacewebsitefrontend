<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$startpage = $_REQUEST['startpage'];
$endpage = $_REQUEST['endpage'];
$pageid = $_REQUEST['pageid'];




$n = 0;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlLogin = "";
$sqlLogin = "select * from " . _SHAREANDUPDATES_TABLE_ . " where groupId='" . $_REQUEST['groupId'] . "' and shareType!=0  order by dateAdded desc limit " . $startpage . "," . $endpage . " ";
$resLogin = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
if ($resLogin) {
	while ($row = mysqli_fetch_array($resLogin)) {



		$aa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= " . $row["id"] . " and postType= " . $row["postType"] . "";
		$res5 = mysqli_query($conn, $aa);
		$totalpostlike = mysqli_num_rows($res5);

		$aa1 = "SELECT * from " . _COMMENT_MASTER_TABLE_ . " WHERE postId= " . $row["id"] . " and postType= " . $row["postType"] . "";
		$res51 = mysqli_query($conn, $aa1);
		$totalpostcomment = mysqli_num_rows($res51);

		$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $row["userId"] . "";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$userres = mysqli_fetch_array($b);

		$aa = "SELECT userId from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $_REQUEST['groupId'] . "";
		$res5 = mysqli_query($conn, $aa);
		$getusergroup = mysqli_fetch_array($res5);


		$jobTitle = $userres["jobTitle"];
		$companyName = $userres["companyName"];

		$friendnameurl = $userres['userurl'];

		if ($userres["profilePhoto"] != '') {
			$userphoto = $userres["profilePhoto"];
		} else {
			$userphoto = 'user-placeholder.jpg';
		}





		?>




		<div class="timlist" id="post<?php echo $row['id']; ?>">
			<div class="hedr">
				<div class="prfl_img"> <a
						href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
							src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a> </div>
				<div class="hdr_right"><a
						href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes(trim($userres["firstName"])); ?>
						<?php echo stripslashes(trim($userres["lastName"])); ?></a>

					<label class="time"><?php echo $jobTitle; ?> 		<?php if ($companyName != '') {
								   echo '- ' . $companyName;
							   } ?></label>
					<label class="time"><?php echo makedatetime($row["dateAdded"]); ?></label>
				</div>
				<?php if ($userres['userId'] == $_SESSION['sessUserId'] || $getusergroup['userId'] == $_SESSION['sessUserId']) { ?>

					<div class="errow-drop"> <span class="errow"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></span>
						<ul class="erow-list">

							<li> <a
									onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo encodeStr($row['id']); ?>','dltgrouppost');"><i
										class="fa fa-window-close-o" aria-hidden="true"></i> Remove</a> </li>

						</ul>
					</div>

				<?php } ?>
			</div>
			<div class="txtarea">
				<div style=" margin-bottom:10px;">


					<div style="font-size:15px; font-weight:bold; margin-bottom:5px;">
						<?php echo stripslashes(trim($row["postTitle"])); ?></div>
					<div class="timelinelistingcontant">
						<?php echo substr(strip_tags(stripslashes(trim($row["postText"]))), 0, 5000);
						if (strlen(strip_tags(stripslashes(trim($row["postText"])))) > 5000) { ?>...<a
								href="<?php echo $fullurl; ?>single-group-post.html?postId=<?php echo encodeStr($row['id']); ?>">read
								more</a><?php } ?></div>

				</div>


				<?php

				$a = "";
				$a = "select * from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $row['id'] . " and imageType=4";
				$b = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $a);
				if ($b) {
					$numrows = mysqli_num_rows($b);
					$width = '100%';

					while ($rowimg = mysqli_fetch_array($b)) {
						?>

						<img src="<?php echo $fullurl; ?>uploads/<?php echo $rowimg['imageName']; ?>"
							style="position:inline-block; cursor:pointer;" onclick="imagepopupmain('<?php echo $rowimg['id']; ?>');">



					<?php }
				}


				?>


				<div class="timeline-img"> </div>
			</div>

			<div class="timlist-fttr">
				<table width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<td width="15%">
							<div id="post<?php echo $row["id"]; ?><?php echo $row["postType"]; ?>"
								onclick="postlike(<?php echo $row["id"]; ?>,<?php echo $row["postType"]; ?>,<?php if ($totalpostlike != '') {
										  echo $totalpostlike;
									  } else {
										  echo '0';
									  } ?>);">
								<a><i class="fa fa-thumbs-up" aria-hidden="true" style="color: #ff7800;"></i><span>
										<?php if ($totalpostlike != '') {
											echo $totalpostlike;
										} else {
											echo '0';
										} ?>
									</span> Like </a></div>

						</td>
						<td width="45%">
							<ul class="likes-mmbr" id="likesmmbrdiv<?php echo $row["id"]; ?><?php echo $row['postType']; ?>">
							</ul>

							<script>
								$('#likesmmbrdiv<?php echo $row['id']; ?><?php echo $row['postType']; ?>').load('<?php echo $fullurl; ?>loadlikeusers.php?postId=<?php echo $row['id']; ?>');
							</script>

						</td>
						<td width="20%" align="right">
							<div id="commentdisplaybox<?php echo $row['id']; ?><?php echo $row['postType']; ?>"
								class="triggerBtn"><i class="fa fa-commenting" aria-hidden="true"></i> <span>
									<?php if ($totalpostcomment != '') {
										echo $totalpostcomment;
									} else {
										echo '0';
									} ?>
								</span> Comment </div>
						</td>

					</tr>
				</table>


				<ul class="tmln_fttr" style="display: none;">
					<li id="post<?php echo $row["id"]; ?><?php echo $row["postType"]; ?>"
						onclick="postlike(<?php echo $row["id"]; ?>,<?php echo $row["postType"]; ?>,<?php if ($totalpostlike != '') {
								  echo $totalpostlike;
							  } else {
								  echo '0';
							  } ?>);">
						<a><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like <span>
								<?php if ($totalpostlike != '') {
									echo $totalpostlike;
								} else {
									echo '0';
								} ?>
							</span></a></li>

					<!--<li><a onclick="opensharebox('<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($row['id']); ?>','<?php echo stripslashes(trim($rowResults["postTitle"])); ?>');"><i class="fa fa-share" aria-hidden="true"></i> Share <span>0</span></a></li>-->


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


				<div class="commnts-cont">
					<?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
						<div class="commnts-cont">
							<div class="comnt-write">
								<div class="write-cmnt-pic"> <img
										src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($myprofilePhoto)); ?>">
								</div>
								<div class="cmnt-inpt">

									<input type="text" class="commentrowboxclass"
										id="commentbox<?php echo $row['id']; ?><?php echo $row['postType']; ?>"
										name="commentbox<?php echo $row['id']; ?><?php echo $row['postType']; ?>"
										placeholder="Type your comment" maxlength="250">

									<button type="button"
										onclick="postcmnt('<?php echo $row['id']; ?>','<?php echo $row['postType']; ?>','<?php echo encodeStr($userres['userId']); ?>','','0','','<?php if ($_REQUEST['siglepost'] == 1) {
													echo '10000';
												} else {
													echo '5';
												} ?>');"><i
											class="fa fa-paper-plane" aria-hidden="true"></i></button>


									<script>
										$("#commentbox<?php echo $row['id']; ?><?php echo $row['postType']; ?>").keypress(function (event) {
											if (event.which == 13) {
												postcmnt('<?php echo $row['id']; ?>', '<?php echo $row['postType']; ?>', '<?php echo encodeStr($userres['userId']); ?>', '', '0', '', '<?php if ($_REQUEST['siglepost'] == 1) {
															echo '10000';
														} else {
															echo '5';
														} ?>');
											}
										});
									</script>

								</div>
							</div>
							<ul class="cmmnt-list" id="postcomment<?php echo $row['id']; ?><?php echo $row['postType']; ?>">
								Loading...
							</ul>
							<script>$(".timlist .timlist #postcomment<?php echo $row['id']; ?><?php echo $row['postType']; ?>").remove();</script>


						</div>

						<script>
							$('#postcomment<?php echo $row['id']; ?><?php echo $row['postType']; ?>').load('<?php echo $fullurl; ?>post-comment.php?postId=<?php echo $row['id']; ?>&postType=<?php echo $row['postType']; ?>&parentId=0&limit=<?php if ($_REQUEST['siglepost'] == 1) {
											  echo '10000';
										  } else {
											  echo '5';
										  } ?>');
						</script>
					<?php } ?>
				</div>
			</div>

		</div>

		<?php
		$n++;
	}
}
?>
<div id="loadtimeline<?php echo $endpage; ?>">
	<?php if ($n > 19) { ?>
		<a onClick="<?php echo $fullurl; ?>loadgrouptimeline('<?php echo $endpage; ?>','<?php echo $endpage + 1; ?>','<?php echo $endpage + 20; ?>','<?php echo $_REQUEST['groupId']; ?>');"
			class="load-more">Load More Posts</a>
	<?php } ?>
</div>

<?php if ($n == 0) { ?>
	<div style="text-align:center; font-size:12px; margin-top:50px; color:#999999;">No Post</div>
<?php } ?>
<script>
	$(document).on("click", ".triggerBtn", function () {
		var inputField = $(this).closest('div').find('.commentrowboxclass').focus();

	});
</script>