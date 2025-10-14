<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

if (isset($_POST['articleTitle']) && trim($_POST['articleTitle']) != '') {

	if (_SME_CONNECT_EMAIL_ID_ == $_SESSION['sessEmail']) {
		$articleBlogStatus = 1;
	} else {
		$articleBlogStatus = 0;
	}

	unset($insertFields);
	unset($insertVals);


	$time = time();
	$pid = $_POST['articleId2'];
	$noImageName = time() . "_noarticleimg.jpg";
	$pid = (int) $pid; // ensure it's a safe integer

	$resultsArticle = mysqli_query(
		$conn,
		"SELECT * FROM " . _IMAGE_MASTER_TABLE_ . " WHERE postId = $pid"
	) or die(mysqli_error($conn));

	$totalRec = mysqli_num_rows($resultsArticle);
	if ($totalRec == 0) {

		copy("uploads/noarticleimg.jpg", "uploads/" . $noImageName);

		$sql_insAr = "insert into " . _IMAGE_MASTER_TABLE_ . " set imageName='$noImageName',postId='$pid',dateAdded='$time',imageType= '3'";
		mysqli_query($conn, $sql_insAr) or die(mysqli_error($conn));
	}

	$insertFields[0] = "userId";
	$insertFields[1] = "postTitle";
	$insertFields[2] = "postText";
	$insertFields[3] = "postType";
	$insertFields[4] = "shareType";
	$insertFields[5] = "dateAdded";
	$insertFields[6] = "articleBlogStatus";

	$insertVals[0] = $_SESSION["sessUserId"];
	$insertVals[1] = normalclean($_POST['articleTitle']);
	$insertVals[2] = normalclean($_POST['articleDetails']);
	$insertVals[3] = '3';
	$insertVals[4] = 1;
	$insertVals[5] = time();
	$insertVals[6] = $articleBlogStatus;

	$whereFields[0] = "id";
	$whereFields[1] = "userId";

	$whereVals[0] = clean($_POST['articleId2']);
	$whereVals[1] = $_SESSION['sessUserId'];

	$resUpdate = updateDB(_SHAREANDUPDATES_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	if ($resUpdate) {

		//$postId=$resUpdate;
		unset($insertFields);
		unset($insertVals);

		$insertFields[0] = "userId";
		$insertFields[1] = "postId";
		$insertFields[2] = "postType";
		$insertFields[3] = "shareType";
		$insertFields[4] = "dateAdded";

		$insertVals[0] = $_SESSION["sessUserId"];
		$insertVals[1] = clean($_POST['articleId2']);
		$insertVals[2] = '3';
		$insertVals[3] = '1';
		$insertVals[4] = time();

		$resUpdate = insertDB(_TIMELINE_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');


		header("Location:" . $fullurl . "timeline.html");
		exit();

	}




}



/*$sql_ins="DELETE FROM "._SHAREANDUPDATES_TABLE_." WHERE userId= ".$_SESSION["sessUserId"]." AND postType=0 ";
mysql_query($sql_ins) or die(mysql_error()); */

$sql_inss = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND postType=0 order by id desc";
$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
$rowResultsNumRows = mysqli_num_rows($resresults);
if ($rowResultsNumRows == 0) {
	$sql_ins = "INSERT INTO " . _SHAREANDUPDATES_TABLE_ . " SET userId= " . $_SESSION["sessUserId"] . "";
	$resresult2 = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
}

$sql_inss = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND postType=0 order by id desc";
$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
$rowResults = mysqli_fetch_array($resresults);
$postId = $rowResults["id"];
$articlepostId = $rowResults["id"];


$editorcr = 'cols="114" rows="16"';
?>
<!DOCTYPE html>
<html>

<head>
	<title>Post Article</title>
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

			selector: "#articleDetails",

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
							<h2>Add a Story</h2>

							<form name="frmposthomeimg" id="frmposthomeimg" method="post" enctype="multipart/form-data"
								style=" position:relative;" target="actionfrm"
								action="<?php echo $fullurl; ?>common_action.php">
								<div class="upload-sec">
									<div class="artcle-txt">
										<div id="loadimagdiv"> <input name="imagefilehome" id="imagefilehome"
												type="file"
												onChange="$('#commonloader').show();$('#frmposthomeimg').submit();"
												style="    position: absolute;
	left: 0%;
	top: 0;
	width: 100%;
	height: 100%;
	z-index:9;
	opacity:0;
	filter: alpha(opacity=0);
	margin: auto; cursor:pointer;" accept="image/x-png,image/gif,image/jpeg">
											<img src="<?php echo $fullurl; ?>images/upload.png">

											<h3>Add a story image</h3>
											<span>Image that are at least 600x350 pixels look best</span>
										</div>
									</div>
								</div>
								<input type="hidden" id="uploadarticleimg" name="uploadarticleimg" value="1">
								<input type="hidden" id="articleId" name="articleId"
									value="<?php echo encodeStr($postId); ?>">
								<input type="hidden" id="addeditpost" name="addeditpost" value="add">
							</form>
							<form name="articlefrm" id="articlefrm" class="txt-form" method="post"
								enctype="multipart/form-data">

								<input name="imagefilehome" id="imagefilehome" type="file"
									onChange="$('#articlefrm').submit();"
									style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); display:none; ">

								<input type="text" name="articleTitle" id="articleTitle"
									placeholder="Write your headline" class="validate" maxlength="250">

								<textarea name="articleDetails" id="articleDetails" placeholder="Start writing" <?php echo $editorcr ?: ''; ?>></textarea>


								<input type="hidden" id="articleId2" name="articleId2"
									value="<?php echo $articlepostId; ?>">

								<?php
								if (!isset($projectStatus)) {
									$projectStatus = "0"; // or "1" depending on default behavior
								}
								?>
								<label class="trms">
									<input type="checkbox" name="projectStatus" id="projectStatus" value="1"
										onClick="return false;" checked="checked" <?php if ($projectStatus == "1") {
											echo "checked";
										} ?>>
									I confirm that I am authorized to Post this article on
									<?php echo $companNameTitle; ?> and if any image is used, I have the rights to use
									the image.
								</label>


								<div class="pst-evnt-btns">
									<button type="button" name="btnsubmit"
										onClick="formValidation('articlefrm');">Publish</button>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>
</body>

</html>