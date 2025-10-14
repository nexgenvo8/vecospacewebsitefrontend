<h4>Latest Articles</h4>
<?php if ($pag == 1) {
	$lastlimit = 12;
} else {
	$lastlimit = 6;
} ?>

<div class="popular-artcle3">
	<?php $nn = 1;
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];
	$strar = '';
	if ($_REQUEST["postId"] != '') {
		$strar = " and a.id!='" . decodeStr($_REQUEST["postId"]) . "'";
	}
	$sqlViewArticle = "";
	$sqlViewArticle = "SELECT a.*,b.imageName from " . _SHAREANDUPDATES_TABLE_ . " a INNER JOIN " . _IMAGE_MASTER_TABLE_ . " b ON a.id=b.postId WHERE b.imageName!='' and a.postType=3 and a.articleBlogStatus=0 and b.imageType=3 " . $strar . "  ORDER BY a.id DESC LIMIT 0," . $lastlimit . " ";
	$resViewArticle = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlViewArticle);
	if ($resViewArticle) {
		while ($rowViewArticle = mysqli_fetch_array($resViewArticle)) {

			$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowViewArticle["userId"] . "";
			$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
			$userres = mysqli_fetch_array($b);


			?>
			<a href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowViewArticle['id']); ?>">
				<div class="artcle-boxp3" <?php if ($nn == 3) { ?>style="margin-right: 0;" <?php } ?>>
					<div class="img-box"
						style="background-image: url(<?php echo $fullurl; ?>uploads/<?php echo str_replace(" ", "%20", $rowViewArticle['imageName']); ?>);">
					</div>
					<div class="artcle-boxp-tt3">
						<?php echo (strip_tags(stripslashes($rowViewArticle["postTitle"]))); ?>
						<div class="art-name3">
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