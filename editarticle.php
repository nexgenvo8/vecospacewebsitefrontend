<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

if (trim($_POST['postTitle']) != '') {

	unset($insertFields);
	unset($insertVals);

	$insertFields[0] = "userId";
	$insertFields[1] = "postTitle";
	$insertFields[2] = "postText";
	$insertFields[3] = "postType";

	$insertVals[0] = $_SESSION["sessUserId"];
	$insertVals[1] = normalclean($_POST['postTitle']);
	$insertVals[2] = normalclean($_POST['postText']);
	$insertVals[3] = '3';

	$whereFields[0] = "id";
	$whereFields[1] = "userId";

	$whereVals[0] = clean($_REQUEST['articleId2']);
	$whereVals[1] = $_SESSION['sessUserId'];

	$time = time();
	$pid = $_REQUEST['articleId2'];
	$noImageName = time() . "_noarticleimg.jpg";
	$resultsArticle = mysqli_query(
		$conn,
		"SELECT * FROM " . _IMAGE_MASTER_TABLE_ . " WHERE postId = " . (int) $pid
	) or die(mysqli_error($conn));

	$totalRec = mysqli_num_rows($resultsArticle);

	if ($totalRec == 0) {

		copy("uploads/noarticleimg.jpg", "uploads/" . $noImageName);

		$sql_insAr = "insert into " . _IMAGE_MASTER_TABLE_ . " set imageName='$noImageName',postId='$pid',dateAdded='$time',imageType= '3'";
		mysqli_query($conn, $sql_insAr) or die(mysqli_error($conn));
	}

	$resUpdate = updateDB(_SHAREANDUPDATES_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	header("Location:" . $fullurl . "view-article.html?postId=" . encodeStr($_REQUEST['articleId2']) . "");
	exit();


}




$sql_inss = "SELECT id,postTitle,postText,userId from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND id=" . decodeStr($_REQUEST['editid']) . "";
$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
$rowResults = mysqli_fetch_array($resresults);
$postId = $rowResults["id"];
$createdby = $rowResults['userId'];
if ($createdby != $_SESSION["sessUserId"]) {
	header('Location:articles-and-trivia.html');
	exit();
}
if ($rowResults['id'] == '') {
	header('Location:articles-and-trivia.html');
	exit();
}

$sql_inss = "SELECT imageName from " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . decodeStr($_REQUEST['editid']) . " and imageType=3";
$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
$rowResultsImage = mysqli_fetch_array($resresults);
$imageName = $rowResultsImage["imageName"];

$editorcr = 'cols="114" rows="16"';
?>
<!DOCTYPE html>
<html>

<head>
	<title>Edit Article</title>
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/main.js"></script>

	<script src="<?php echo $fullurl; ?>tinymce/tinymce.min.js"></script>

	<script type="text/javascript">

		tinymce.init({

			selector: "#postText",

			themes: "modern",

			plugins: [

				"advlist autolink lists link image charmap print preview anchor",

				"searchreplace visualblocks code fullscreen"

			],

			toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image"

		});

	</script>
	<style>
		.nicEdit-main {
			height: 240px;
			overflow: auto !important;
		}
	</style>
	<!--Ends editor script-->
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
				<div class="center_content">
					<div class="evnts post" id="postarticle">
						<div class="post-evnt">
							<h2>Edit Article</h2>

							<form name="frmposthomeimg" id="frmposthomeimg" method="post" enctype="multipart/form-data"
								style=" position:relative;" target="actionfrm"
								action="<?php echo $fullurl; ?>common_action.php">
								<div class="upload-sec">
									<div class="artcle-txt">
										<div id="loadimagdiv"><input name="imagefilehome" id="imagefilehome" type="file"
												onChange="$('#frmposthomeimg').submit();" style="    position: absolute;
	left: 28%;
	top: 60px;
	width: 43%;
	height: 268px;
	opacity:0;
	filter: alpha(opacity=0);
	margin: auto; cursor:pointer;" accept="image/x-png,image/gif,image/jpeg">
											<img src="<?php echo $fullurl; ?>images/upload.png">

											<h3>Add a article image</h3>
											<span>Image that are at least 600x350 pixels look best</span>
										</div>
									</div>
								</div>
								<input type="hidden" id="uploadarticleimg" name="uploadarticleimg" value="1">
								<input type="hidden" id="articleId" name="articleId"
									value="<?php echo $_REQUEST['editid']; ?>">
								<input type="hidden" id="addeditpost" name="addeditpost" value="edit">
							</form>

							<script>
								$('#loadimagdiv').load('<?php echo $fullurl; ?>article_photo_home.php?postId=<?php echo $_REQUEST['editid']; ?>');
							</script>

							<form name="articlefrm" id="articlefrm" class="txt-form" method="post"
								enctype="multipart/form-data">

								<input name="imagefilehome" id="imagefilehome" type="file"
									onChange="$('#articlefrm').submit();"
									style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); display:none;  ">

								<input type="text" name="postTitle" id="postTitle" placeholder="Write your headline"
									value="<?php echo sanitizedboutput($rowResults['postTitle']); ?>" class="validate"
									maxlength="250">

								<textarea name="postText" id="postText" placeholder="Start writing" <?php echo $editorcr; ?>><?php echo sanitizedboutput($rowResults['postText']); ?></textarea>

								<input type="hidden" id="articleId2" name="articleId2" value="<?php echo $postId; ?>">
								<input type="hidden" id="addeditpost" name="addeditpost" value="edit">

							</form>

							<div class="pst-evnt-btns">
								<?php if ($_REQUEST['editid'] != '' && $rowResults["userId"] == $_SESSION["sessUserId"]) {
									?>
									<script>
										function reloadPage() {
											location.reload(true);
										}
									</script>
									<a onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo $_REQUEST['editid']; ?>','deletearticle');"
										style="float: left;color: #ea4335;margin-left: -18px;">Delete this Article</a>
								<?php } ?>&nbsp;
								<button type="button" name="btnsubmit"
									onClick="formValidation('articlefrm');">Update</button>
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