<?php
include_once('inc.php');

/*$url = 'https://www.connecwrk.com/view-sme-blog.html?postId=202581501';
$query = parse_url($url, PHP_URL_QUERY);
parse_str($query);
parse_str($query, $arr);
echo $query;  // postId=202581501&myId=13*/

$pageIndex = 7;
$pag = 1;
$aa = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE id= " . decodeStr($_REQUEST["postId"]) . " ";
$res5 = mysqli_query($conn, $aa) or die(error_found(mysqli_error($conn)));
$articletext = mysqli_fetch_array($res5);
if ($articletext['userId'] != $_SESSION["sessUserId"]) {

	$insertFields = [];
	$insertVals = [];
	$whereFields = [];
	$whereVals = [];

	$insertFields[0] = "viewStatus";

	$insertVals[0] = $articletext['viewStatus'] + 1;

	$whereFields[0] = "id";

	$whereVals[0] = decodeStr($_REQUEST["postId"]);

	$resUpdate = updateDB(_SHAREANDUPDATES_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, ''); //Count article views
}

if ($articletext['id'] == '') {
	header("Location: " . $fullurl . "404error.html");
	exit();
}



$aa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= " . $articletext["id"] . " and postType= 3";
$res5 = mysqli_query($conn, $aa);
$totalpostlike = mysqli_num_rows($res5);



$aa = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $articletext["userId"] . " and postType=3 and postTitle!='' and articleBlogStatus=0 ";
$res5 = mysqli_query($conn, $aa);
$totalarticles = mysqli_num_rows($res5);

$aas = "SELECT * from " . _SHARE_MASTER_TABLE_ . " WHERE postId= " . $articletext["id"] . " and postType= " . $articletext["postType"] . "";
$res5s = mysqli_query($conn, $aas);
$totalpostshared = mysqli_num_rows($res5s);

$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $articletext["userId"] . "";
$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
$userresarticles = mysqli_fetch_array($b);

$aa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= " . decodeStr($_REQUEST["postId"]) . " and postType= " . $articletext["postType"] . "";
$res5 = mysqli_query($conn, $aa);
$totalpostlike = mysqli_num_rows($res5);

$aa = "SELECT * from " . _COMMENT_MASTER_TABLE_ . " WHERE postId= " . decodeStr($_REQUEST["postId"]) . " and postType= " . $articletext["postType"] . "";
$res5 = mysqli_query($conn, $aa);
$totalpostcomment = mysqli_num_rows($res5);

$userphoto = '';
$friendnameurl = '';
$user_jobTitle = stripslashes(strip_tags($userresarticles['jobTitle']));
$user_companyName = stripslashes(strip_tags($userresarticles['companyName']));
$friendnameurl = $userresarticles['userurl'];

if ($userresarticles["profilePhoto"] != '') {
	$userphoto = $userresarticles["profilePhoto"];
} else {
	$userphoto = 'user-placeholder.jpg';
}

?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo stripslashes(strip_tags($articletext['postTitle'])); ?> - Articles -
		<?php echo $companNameTitle; ?>
	</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">
	<meta property="og:title" content="<?php echo stripslashes(strip_tags($articletext['postTitle'])); ?>" />

	<?php
	$selectFields = [];
	$insertVals = [];
	$whereFields = [];
	$whereVals = [];


	$a = "";
	$a = "select imageName from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $articletext['id'] . " and imageType=3";
	$b = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $a);
	if ($b) {
		while ($rowimg = mysqli_fetch_array($b)) {
			?>
			<meta property="og:image" content="<?php echo $fullurl; ?>uploads/<?php echo $rowimg['imageName']; ?>" />
			<?php
		}
	}
	?>
	<meta property="og:site_name" content="<?php echo $fullurl; ?>" />
	<meta property="og:description"
		content="<?php echo substr(stripslashes(strip_tags($articletext['postText'])), 0, 250); ?>" />
	<meta property="og:type" content="Article" />
	<meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />


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
				<div class="center_content <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
				} else {
					if ($mobile == 'y') {
					} else {
						echo 'nologin';
					}
				} ?>">
					<div class="write-cont">
						<h2>Articles and Trivia</h2>
						<a href="<?php echo $fullurl; ?>post-article.html" class="writ-btn">Write an article</a>
					</div>
					<div class="artcle bx-shadow">
						<div class="cntr_cntnt popular-dtail">
							<?php if ($userresarticles['userId'] == $_SESSION['sessUserId']) { ?>
								<div style="margin-bottom:10px; font-size:14px; color:#999999;">Edit this article <a
										href="<?php echo $fullurl; ?>edit-article.html?editid=<?php echo encodeStr($articletext['id']); ?>&action=edit"><button
											class="cmmnt-btn" type="submit" style="position: relative;
	border-radius: 4px;
	margin-top: 0px;
	margin-left: 10px;
	padding: 5px 15px;">Edit</button></a></div>
							<?php } ?>
							<h2><?php echo stripslashes(strip_tags($articletext['postTitle'])); ?></h2>
							<div style="margin-bottom:15px; overflow:hidden; line-height:35px;">
								<div style="float:left; font-size:13px; color:#999999;">Published
									<?php echo makedatetime($articletext["dateAdded"]); ?> &nbsp;|&nbsp; Views:
									<?php echo $articletext["viewStatus"];//$tagArray = explode(",",$articletext['viewStatus']); echo $arrayCount = count($tagArray); ?>
								</div>
								<div style=" float:right;">
									<!-- Go to www.addthis.com/dashboard to customize your tools -->
									<script type="text/javascript"
										src="//s7.addthis.com/js/300/addthis_widget.js#pubid=imran190"></script>
									<!-- Go to www.addthis.com/dashboard to customize your tools -->
									<div class="addthis_inline_share_toolbox_tnos"></div>
								</div>
								<div style="float:right; font-size:13px; color:#999999;">
									<!--Published by  <a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userresarticles['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes($userresarticles['firstName'] . ' ' . $userresarticles['lastName']); ?></a>-->
								</div>
							</div>

							<div class="detail-cntnt">
								<?php
								$selectFields = [];
								$insertVals = [];
								$whereFields = [];
								$whereVals = [];
								$a = "";
								$a = "select * from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $articletext['id'] . " and imageType=3";
								$b = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $a);
								if ($b) {
									$numrows = mysqli_num_rows($b);
									$width = '100%';

									while ($rowimg = mysqli_fetch_array($b)) {
										?>

										<img src="<?php echo $fullurl; ?>uploads/<?php echo $rowimg['imageName']; ?>"
											style="position:inline-block; cursor:pointer;"
											onClick="imagepopupmain('<?php echo $rowimg['id']; ?>');">



									<?php }
								}


								?>
								<p><?php echo stripslashes($articletext['postText']); ?></p>
							</div>
							<label class="postd-on">Published <?php echo makedatetime($articletext["dateAdded"]); ?>
								&nbsp;|&nbsp; Views:
								<?php echo $articletext["viewStatus"];// echo $arrayCount; ?></label>
							<div class="pblsh-artcl-fttr">
								<div class="artcl-other">
									<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userresarticles['userId']); ?>/<?php echo $friendnameurl; ?>.html"
										class="other-img"><img
											src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
									<div class="about-other">
										<a
											href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userresarticles['userId']); ?>/<?php echo $friendnameurl; ?>.html"><strong><?php echo stripslashes($userresarticles['firstName'] . ' ' . $userresarticles['lastName']); ?></strong></a>
										<label><?php echo $user_jobTitle; ?> at <?php echo $user_companyName; ?></label>
										<a href="<?php echo $fullurl; ?>user-articles.html?id=<?php echo encodeStr($userresarticles['userId']); ?>"
											class="mr-article" target="_blank"><?php echo $totalarticles; ?>
											Articles</a>
									</div>
								</div>
								<div class="social-stats">
									<ul class="tmln_fttr">

										<li id="post<?php echo $articletext["id"]; ?>3" <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?> onClick="postlike(<?php echo $articletext["id"]; ?>,3,<?php if ($totalpostlike != '') {
															echo $totalpostlike;
														} else {
															echo '0';
														} ?>);" <?php } ?>><a><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like
												<span><?php if ($totalpostlike != '') {
													echo $totalpostlike;
												} else {
													echo '0';
												} ?></span></a>
										</li>

										<li><a onClick="$('#commentbox').focus();"><i class="fa fa-commenting"
													aria-hidden="true"></i> Comment
												<span><?php if ($totalpostcomment != '') {
													echo $totalpostcomment;
												} else {
													echo '0';
												} ?></span></a>
										</li>

										<li><a <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>onClick="sharefuncommonpopupwin('550px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo encodeStr($articletext["id"]); ?>&type=share&sharePostType=3','Share','<?php echo $articletext['id']; ?>');"
												<?php } ?>><i class="fa fa-share" aria-hidden="true"></i> Share
												<span><?php if ($totalpostshared != '') {
													echo $totalpostshared;
												} else {
													echo '0';
												} ?></span></a>
										</li>
									</ul>
								</div>
							</div>
							<div class="cmmnt-sec">
								<label class="zero-cmnt"><?php if ($totalpostcomment != '') {
									echo $totalpostcomment;
								} else {
									echo '0';
								} ?>
									comments</label>
								<div class="commnts-cont artcle-cmnt">
									<?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>




										<div class="commnts-cont ">
											<div class="comnt-write artcle-cmnt">
												<div class="write-cmnt-pic"> <img
														src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($myprofilePhoto)); ?>">
												</div>
												<div class="cmnt-inpt">

													<input type="text" class="commentrowboxclass"
														id="commentbox<?php echo $articletext['id']; ?><?php echo $articletext['postType']; ?>"
														name="commentbox<?php echo $articletext['id']; ?><?php echo $articletext['postType']; ?>"
														placeholder="Type your comment" maxlength="250">

													<button type="button"
														onClick="postcmnt('<?php echo $articletext['id']; ?>','<?php echo $articletext['postType']; ?>','<?php echo encodeStr($userresarticles['userId']); ?>','','0','','10000');"><i
															class="fa fa-paper-plane" aria-hidden="true"></i></button>


													<script>
														$("#commentbox<?php echo $articletext['id']; ?><?php echo $articletext['postType']; ?>").keypress(function (event) {
															if (event.which == 13) {
																postcmnt('<?php echo $articletext['id']; ?>', '<?php echo $articletext['postType']; ?>', '<?php echo encodeStr($userresarticles['userId']); ?>', '', '0', '', '10000');
															}
														});
													</script>

												</div>
											</div>
											<ul class="cmmnt-list"
												id="postcomment<?php echo $articletext['id']; ?><?php echo $articletext['postType']; ?>">
												Loading...
											</ul>
											<script>$(".timlist .timlist #postcomment<?php echo $articletext['id']; ?><?php echo $articletext['postType']; ?>").remove();</script>


										</div>

										<script>
											$('#postcomment<?php echo $articletext['id']; ?><?php echo $articletext['postType']; ?>').load('<?php echo $fullurl; ?>post-comment.php?postId=<?php echo $articletext['id']; ?>&postType=<?php echo $articletext['postType']; ?>&parentId=0&limit=10000');
										</script>
									<?php } ?>
								</div>
							</div>

							<div class="mor-for-u" id="userarticle">
								<h2>More articles by
									<?php echo stripslashes($userresarticles['firstName'] . ' ' . $userresarticles['lastName']); ?>
								</h2>
								<div class="popular-artcle1">
									<?php $nn = 1;
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];
									$ns = 1;
									$articlephoto = '';
									$sqlOtherArticle = "";
									$sqlOtherArticle = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE postTitle!=''  and postType=3 and articleBlogStatus=0 and userId=" . $userresarticles["userId"] . " and id!=" . $articletext['id'] . " ORDER BY viewStatus DESC LIMIT 0,3 ";
									$resOtherArticle = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOtherArticle);
									if ($resOtherArticle) {
										while ($rowOtherArticle = mysqli_fetch_array($resOtherArticle)) {

											$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowOtherArticle["userId"] . "";
											$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
											$userres = mysqli_fetch_array($b);


											$aimg = "SELECT * 
         FROM " . _IMAGE_MASTER_TABLE_ . " 
         WHERE postId = " . intval($rowOtherArticle['id']) . " 
           AND imageType = 3";

											$bimg = mysqli_query($conn, $aimg);

											if ($bimg && mysqli_num_rows($bimg) > 0) {
												$rowimg = mysqli_fetch_array($bimg);

												$articlephoto = !empty($rowimg['imageName'])
													? $rowimg['imageName']
													: 'articleicon.png';
											} else {
												$articlephoto = 'articleicon.png';
											}


											?>
											<a
												href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowOtherArticle['id']); ?>">
												<div class="artcle-boxp" <?php if ($nn == 3) { ?>style="margin-right: 0;" <?php } ?>>
													<div class="img-box"
														style="background-image: url(<?php echo $fullurl; ?>uploads/<?php echo str_replace(' ', '%20', $articlephoto); ?>);">
													</div>
													<div class="artcle-boxp-ttl">
														<?php echo getStrLength(strip_tags(stripslashes($rowOtherArticle["postTitle"])), 40); ?>
														<div class="art-name">
															by <?php echo stripslashes(trim($userres["firstName"])); ?>
															<?php echo stripslashes(trim($userres["lastName"])); ?> -
															<?php echo makedatetime($rowOtherArticle["dateAdded"]); ?>
														</div>
													</div>
												</div>
											</a>
											<?php $nn++;
										}
									} ?>

									<?php if ($nn < 2) { ?>
										<script>
											$("#userarticle").hide();
										</script>
									<?php } ?>
								</div>
							</div>


							<div class="mor-for-u discovermor">
								<h2>Discover More Articles and Interesting Trivia On <?php echo $companNameTitle; ?>
								</h2>
								<div class="popular-artcle4 discovermor4">
									<?php
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];
									$nn = 1;
									$articlephoto1 = '';
									$sqlOtherArticle = "";
									$sqlOtherArticle = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE postTitle!=''  and postType=3 and articleBlogStatus=0 ORDER BY rand() LIMIT 0,6 ";
									$resOtherArticle = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOtherArticle);
									if ($resOtherArticle) {
										while ($rowOtherArticle = mysqli_fetch_array($resOtherArticle)) {

											$a = "SELECT firstName,lastName from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowOtherArticle["userId"] . "";
											$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
											$userres = mysqli_fetch_array($b);


											$aimg = "select imageName from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $rowOtherArticle['id'] . " and imageType=3";
											$bimg = mysqli_query($conn, $aimg) or die(mysqli_error($connn));
											$rowimg = mysqli_fetch_array($bimg);

											if ($rowimg && isset($rowimg['imageName']) && $rowimg['imageName'] != '') {
												$articlephoto1 = $rowimg['imageName'];
											} else {
												$articlephoto1 = 'articleicon.png';
											}


											/*$filename = $fullurl.'uploads/'.trim($rowimg['imageName']);
											if(file_exists($filename))
											{
												$articlephoto1=$rowimg['imageName'];
											} else {
												$articlephoto1='articleicon.png';
											}*/


											?>
											<a
												href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowOtherArticle['id']); ?>">
												<div class="artcle-boxp" <?php if ($nn == 3 || $nn == 6 || $nn == 9 || $nn == 12) { ?>style="margin-right: 0;" <?php } ?>>
													<div class="img-box"
														style="background-image: url(<?php echo $fullurl; ?>uploads/<?php echo str_replace(' ', '%20', $articlephoto1); ?>);">
													</div>
													<div class="artcle-boxp-ttl">
														<?php echo (strip_tags(stripslashes($rowOtherArticle["postTitle"]))); ?>
														<div class="art-name">
															by <?php echo stripslashes(trim($userres["firstName"])); ?>
															<?php echo stripslashes(trim($userres["lastName"])); ?> -
															<?php echo makedatetime($rowOtherArticle["dateAdded"]); ?>
														</div>
													</div>
												</div>
											</a>
											<?php $nn++;
										}
									} ?>
								</div>
							</div>




						</div>

						<div class="hm_right_sec" style="width: 320px;">

							<ul class="artcl-short-nws latest">
								<li>
									<div class="shrt-news articleauthor" style="background-color: #f5f5f5;">
										<h4>Published by</h4>
										<a class="shrt-img"
											href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userresarticles['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
												src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
										<div class="ttl-head">
											<a
												href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userresarticles['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes($userresarticles['firstName'] . ' ' . $userresarticles['lastName']); ?></a>
											<span><?php echo $user_jobTitle; ?> at
												<?php echo $user_companyName; ?></span>
											<a href="<?php echo $fullurl; ?>user-articles.html?id=<?php echo encodeStr($userresarticles['userId']); ?>"
												class="mr-article" target="_blank"><?php echo $totalarticles; ?>
												Articles</a>
										</div>
									</div>
								</li>
							</ul>

							<?php include('rightarticletrivia.php'); ?>
						</div>

					</div>

				</div>
			</div>
		</div>
	</div>


	</div>
	</div>
	</div>
	<?php include('footer.php'); ?>
	</div>

	<script type="text/javascript">
		function reloadPage() {
			location.reload(true);
		}



		$('.more-btn a.mr').click(function (event) {
			event.stopPropagation();
		});

		$('html').click(function () {
			$('.more-list').hide();
		});
		$('.more-btn a.mr').click(function (event) {
			$('.more-list').toggle();
		});



		$(window).scroll(function () {
			if ($(this).scrollTop() > 150) {
				$(".write-cont").addClass("fixed");
			}
			else {
				$(".write-cont").removeClass("fixed");
			}
		});
	</script>
	<div id="actionpostdivs" style=" display:none;"></div>
	<iframe name="actionfrm" id="actionfrm" style="display:none;"></iframe>


	<div style="display:none;">

		<div class="timlist" id="<?php echo decodeStr($_REQUEST["postId"]); ?>">
			<div class="hedr">
				<div class="prfl_img"> <a
						href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userresarticles['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
							src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
				</div>
				<div class="hdr_right"><a
						href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userresarticles['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes($userresarticles['firstName'] . ' ' . $userresarticles['lastName']); ?></a>
					<span class="timelinecontantsubline"></span>
					<label class="time"><?php echo $user_jobTitle; ?> at <?php echo $user_companyName; ?></label>
					<label class="time">Posted an article <?php echo makedatetime($articletext["dateAdded"]); ?></label>
				</div>
			</div>



			<div id="txtarea<?php echo decodeStr(trim($_REQUEST['postId'])); ?>">
				<div style=" margin-bottom:10px;">
					<div style="font-size:15px; font-weight:bold; margin-bottom:5px;"><a
							href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo $_REQUEST["postId"]; ?>"><?php echo stripslashes(trim($articletext["postTitle"])); ?></a>
					</div>
					<div class="timelinelistingcontant">
						<?php echo substr(strip_tags(stripslashes(trim($articletext["postText"]))), 0, 250); ?>...<a
							href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo $_REQUEST["postId"]; ?>">read
							more</a>
					</div>
				</div>
				<?php

				$a = "";
				$a = "select * from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $articletext['id'] . "";
				$b = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $a);
				if ($b) {
					$numrows = mysqli_num_rows($b);
					$width = '100%';

					while ($rowimg = mysqli_fetch_array($b)) {
						?>
						<img src="<?php echo $fullurl; ?>uploads/<?php echo $rowimg['imageName']; ?>"
							style="position:inline-block; cursor:pointer;"
							onClick="countpostview('<?php echo encodeStr($row['postId']); ?>');imagepopupmain('<?php echo $rowimg['id']; ?>');">
					<?php }
				}


				?>
				<div class="timeline-img"> </div>
			</div>


		</div>

	</div>
</body>

</html>