<?php
include_once('inc.php');
$pageIndex = 7;

?>
<!DOCTYPE html>
<html>

<head>
	<title>Article and trivia - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>

	<script type="text/javascript">
		$(window).scroll(function () {
			if ($(this).scrollTop() > 150) {
				$(".write-cont").addClass("fixed");
			}
			else {
				$(".write-cont").removeClass("fixed");
			}
		});
	</script>
	<style>
		.newarticlebox {
			height: 360px !important;
		}
	</style>
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
					echo 'nologin';
				} ?>">
					<div class="write-cont">
						<h2>Articles and Trivia</h2>
						<a href="<?php echo $fullurl; ?>post-article.html" class="writ-btn">Write an article</a>
					</div>

					<div class="trivia-shdow">

						<ul class="newarticle-list">
							<?php
							// Make sure $conn is your mysqli connection object
// $conn = mysqli_connect("localhost","username","password","database");
							
							$sqlViewArticle = "SELECT a.*, b.imageName 
							FROM " . _SHAREANDUPDATES_TABLE_ . " a 
							INNER JOIN " . _IMAGE_MASTER_TABLE_ . " b ON a.id = b.postId 
							WHERE b.imageName != '' 
							AND a.postType = 3 
							AND b.imageType = 3 
							AND a.articleBlogStatus = 0 
							ORDER BY a.id DESC";

							$resViewArticle = mysqli_query($conn, $sqlViewArticle);

							if ($resViewArticle && mysqli_num_rows($resViewArticle) > 0) {
								while ($rowViewArticle = mysqli_fetch_assoc($resViewArticle)) {

									// Get user info
									$a = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = " . intval($rowViewArticle["userId"]);
									$b = mysqli_query($conn, $a);

									if ($b && mysqli_num_rows($b) > 0) {
										$userres = mysqli_fetch_assoc($b);
										$friendnameurl = $userres['userurl'];
									} else {
										// agar record nahi mila toh default value de do
										$friendnameurl = "#";
										$userres = [
											"firstName" => "",
											"lastName" => "",
											"userurl" => ""
										];
									}

									?>
									<li
										onClick="location.href='<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowViewArticle['id']); ?>';">
										<div class="newarticlebox"
											style="background-image: url(<?php echo $fullurl; ?>uploads/<?php echo str_replace(' ', '%20', $rowViewArticle['imageName']); ?>);">
											<div class="heading-box">
												<h2><?php echo strip_tags(stripslashes($rowViewArticle["postTitle"])); ?></h2>
												<div class="articleby">
													<?php if (!empty($userres) && !empty($userres['userId'])) { ?>
														by <a
															href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html">
															<?php echo stripslashes(trim($userres["firstName"])); ?>
															<?php echo stripslashes(trim($userres["lastName"])); ?>
														</a>
													<?php } else { ?>
														by <span>Unknown Author</span>
													<?php } ?>
													- <?php echo makedatetime($rowViewArticle["dateAdded"]); ?>
												</div>
											</div>
										</div>
									</li>

									<?php
								}
							}
							?>
						</ul>

						<!--<div class="trivia-slider">
<div  class="artcl-box">

 <?php
 // $conn should already be your mysqli connection
// $conn = mysqli_connect("localhost","username","password","database");
 
 $sqlViewArticle = "SELECT a.*, b.imageName 
    FROM " . _SHAREANDUPDATES_TABLE_ . " a 
    INNER JOIN " . _IMAGE_MASTER_TABLE_ . " b 
        ON a.id = b.postId 
    WHERE b.imageName != '' 
      AND a.postType = 3 
      AND b.imageType = 3 
      AND a.articleBlogStatus = 0 
    ORDER BY a.id DESC 
    LIMIT 0,1";

 $resViewArticle = mysqli_query($conn, $sqlViewArticle);

 if ($resViewArticle && mysqli_num_rows($resViewArticle) > 0) {
	 while ($rowViewArticle = mysqli_fetch_assoc($resViewArticle)) {

		 // Fetch user data
 		$sqlUser = "SELECT * 
            FROM " . _USERS_MASTER_TABLE_ . " 
            WHERE userId = " . intval($rowViewArticle["userId"]);

		 $resUser = mysqli_query($conn, $sqlUser);
		 $userres = mysqli_fetch_assoc($resUser);
		 ?>
		
		<a href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowViewArticle['id']); ?>">
			<div class="big-artcle-box" style="background-image: url(<?php echo $fullurl; ?>uploads/<?php echo $rowViewArticle['imageName']; ?>);">
				<div class="artcle-name">
					<?php echo strip_tags(stripslashes($rowViewArticle["postTitle"])); ?>
					<div class="by">
						by <?php echo stripslashes(trim($userres["firstName"])); ?> 
						<?php echo stripslashes(trim($userres["lastName"])); ?>  
						- <?php echo makedatetime($rowViewArticle["dateAdded"]); ?>
					</div>
				</div>
			</div>
		</a>
		
		<?php
	 }
 }
 ?>

	<div  class="grid-artcle-box">

			<?php
			// $conn should be your mysqli connection
// $conn = mysqli_connect("localhost","username","password","database");
			
			// ----------------- FIRST BLOCK (LIMIT 1,2) -----------------
			$articlephotoltst3 = '';

			$sqlViewArticle = "SELECT a.*, b.imageName 
    FROM " . _SHAREANDUPDATES_TABLE_ . " a 
    INNER JOIN " . _IMAGE_MASTER_TABLE_ . " b ON a.id = b.postId 
    WHERE b.imageName != '' 
      AND a.postType = 3 
      AND b.imageType = 3 
      AND a.articleBlogStatus = 0 
    ORDER BY a.id DESC 
    LIMIT 1,2";

			$resViewArticle = mysqli_query($conn, $sqlViewArticle);

			if ($resViewArticle && mysqli_num_rows($resViewArticle) > 0) {
				while ($rowViewArticle = mysqli_fetch_assoc($resViewArticle)) {

					// Fetch user info
					$sqlUser = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = " . intval($rowViewArticle["userId"]);
					$resUser = mysqli_query($conn, $sqlUser);
					$userres = mysqli_fetch_assoc($resUser);

					$articlephotoltst3 = ($rowViewArticle['imageName'] != '')
						? $rowViewArticle['imageName']
						: 'articleicon.png';
					?>
		
		<a href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowViewArticle['id']); ?>">
			<div class="grid-box" style="background-image: url(<?php echo $fullurl; ?>uploads/<?php echo $articlephotoltst3; ?>);">
				<div class="artcle-name">
					<?php echo strip_tags(stripslashes($rowViewArticle["postTitle"])); ?>
					<div class="by">
						by <?php echo stripslashes(trim($userres["firstName"])); ?> 
						<?php echo stripslashes(trim($userres["lastName"])); ?> -  
						<?php echo makedatetime($rowViewArticle["dateAdded"]); ?>
					</div>
				</div>
			</div>
		</a>
		
		<?php
				}
			}
			?>

<?php
// ----------------- SECOND BLOCK (LIMIT 3,2) -----------------
$articlephotoltst2 = '';

$sqlViewArticle = "SELECT a.*, b.imageName 
    FROM " . _SHAREANDUPDATES_TABLE_ . " a 
    INNER JOIN " . _IMAGE_MASTER_TABLE_ . " b ON a.id = b.postId 
    WHERE b.imageName != '' 
      AND a.postType = 3 
      AND b.imageType = 3 
      AND a.articleBlogStatus = 0 
    ORDER BY a.id DESC 
    LIMIT 3,2";

$resViewArticle = mysqli_query($conn, $sqlViewArticle);

if ($resViewArticle && mysqli_num_rows($resViewArticle) > 0) {
	while ($rowViewArticle = mysqli_fetch_assoc($resViewArticle)) {

		// Fetch user info
		$sqlUser = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = " . intval($rowViewArticle["userId"]);
		$resUser = mysqli_query($conn, $sqlUser);
		$userres = mysqli_fetch_assoc($resUser);

		$articlephotoltst2 = ($rowViewArticle['imageName'] != '')
			? $rowViewArticle['imageName']
			: 'articleicon.png';
		?>
		
		<a href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowViewArticle['id']); ?>">
			<div class="grid-box2" style="background-image: url(<?php echo $fullurl; ?>uploads/<?php echo $articlephotoltst2; ?>);">
				<div class="artcle-name">
					<?php echo strip_tags(stripslashes($rowViewArticle["postTitle"])); ?>
					<div class="by">
						by <?php echo stripslashes(trim($userres["firstName"])); ?> 
						<?php echo stripslashes(trim($userres["lastName"])); ?> -  
						<?php echo makedatetime($rowViewArticle["dateAdded"]); ?>
					</div>
				</div>
			</div>
		</a>
		
		<?php
	}
}
?>


	</div>
</div>



</div>-->

						<div class="artcle">
							<div class="cntr_cntnt popular">
								<h2>Popular Articles</h2>

								<div class="popular-artcle1">
									<?php
									$nn = 1;
									$articlephotoltst1 = "";

									$sqlViewArticle = "SELECT a.*, b.imageName 
									FROM " . _SHAREANDUPDATES_TABLE_ . " a 
									INNER JOIN " . _IMAGE_MASTER_TABLE_ . " b ON a.id = b.postId 
									WHERE b.imageName != '' 
									AND a.postType = 3 
									AND b.imageType = 3 
									AND a.articleBlogStatus = 0 
									ORDER BY a.id DESC 
									LIMIT 3,3";

									$resViewArticle = mysqli_query($conn, $sqlViewArticle);

									if ($resViewArticle && mysqli_num_rows($resViewArticle) > 0) {
										while ($rowViewArticle = mysqli_fetch_assoc($resViewArticle)) {

											$a = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = " . intval($rowViewArticle["userId"]);
											$b = mysqli_query($conn, $a);
											$userres = mysqli_fetch_assoc($b);

											$articlephotoltst1 = ($rowViewArticle['imageName'] != '')
												? $rowViewArticle['imageName']
												: 'articleicon.png';
											?>
											<a
												href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowViewArticle['id']); ?>">
												<div class="artcle-boxp" <?php if ($nn == 3) { ?>style="margin-right: 0;" <?php } ?>>
													<div class="img-box"
														style="background-image: url(<?php echo $fullurl; ?>uploads/<?php echo str_replace(' ', '%20', $articlephotoltst1); ?>);">
													</div>
													<div class="artcle-boxp-ttl">
														<?php echo strip_tags(stripslashes($rowViewArticle["postTitle"])); ?>
														<div class="art-name">
															by <?php echo stripslashes(trim($userres["firstName"])); ?>
															<?php echo stripslashes(trim($userres["lastName"])); ?> -
															<?php echo makedatetime($rowViewArticle["dateAdded"]); ?>
														</div>
													</div>
												</div>
											</a>
											<?php $nn++;
										}
									} ?>
								</div>

								<div class="populr-artcl2">
									<?php
									$n = 0;
									$articlephotoltst = "";

									$sqlViewArticle = "SELECT a.*, b.imageName 
									FROM " . _SHAREANDUPDATES_TABLE_ . " a 
									INNER JOIN " . _IMAGE_MASTER_TABLE_ . " b ON a.id = b.postId 
									WHERE b.imageName != '' 
									AND a.postType = 3 
									AND b.imageType = 3 
									AND a.articleBlogStatus = 0 
									ORDER BY a.id DESC 
									LIMIT 8,20";

									$resViewArticle = mysqli_query($conn, $sqlViewArticle);

									if ($resViewArticle && mysqli_num_rows($resViewArticle) > 0) {
										while ($rowViewArticle = mysqli_fetch_assoc($resViewArticle)) {

											$a = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = " . intval($rowViewArticle["userId"]);
											$b = mysqli_query($conn, $a);
											$userres = mysqli_fetch_assoc($b);

											$articlephotoltst = ($rowViewArticle['imageName'] != '')
												? $rowViewArticle['imageName']
												: 'articleicon.png';
											?>
											<a
												href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowViewArticle['id']); ?>">
												<div class="artcle-box-long">
													<div class="image-box"
														style="background-image: url(<?php echo $fullurl; ?>uploads/<?php echo $articlephotoltst; ?>);">
													</div>
													<div class="long-contnt">
														<?php echo strip_tags(stripslashes($rowViewArticle["postTitle"])); ?>
														<div class="long-cont">
															<?php echo strip_tags(stripslashes($rowViewArticle["postText"])); ?>
														</div>
														<div class="long-name">
															<?php if (!empty($userres) && !empty($userres['firstName'])) { ?>
																by <?php echo stripslashes(trim($userres["firstName"])); ?>
																<?php echo stripslashes(trim($userres["lastName"])); ?>
															<?php } else { ?>
																by <span>Unknown Author</span>
															<?php } ?>
															- <?php echo makedatetime($rowViewArticle["dateAdded"]); ?>
														</div>
													</div>
												</div>
											</a>

											<?php $n++;
										}
									} ?>

									<?php if ($n > 9) { ?>
										<div class="morerecords">
											<a href="<?php echo $fullurl; ?>all-articles-and-trivia.html">More Article and
												Trivia</a>
										</div>
									<?php } ?>
								</div>
							</div>
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

</body>

</html>