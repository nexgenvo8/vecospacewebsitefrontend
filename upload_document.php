<?php
include_once('inc.php');
include_once('config/session-check.inc.php');
$page = 3;
?>
<!DOCTYPE html>
<html>

<head>
	<title>Vault - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
</head>

<body>
	<div id="wrapper">
		<?php include('header.php'); ?>
		<div class="container main">
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content <?php echo (!empty($_SESSION["sessUserId"])) ? '' : 'nologin'; ?>">
					<div class="bx-shadow">
						<?php include('vaultinc.php'); ?>
						<div class="upload-doccont">

							<?php
							$id = isset($_GET["id"]) ? $_GET["id"] : '';
							if ($id == '') {
								?>
								<h1>Reach more than 70 million people when you upload and share</h1>
								<div class="upload-box">
									<div class="uplod-afile">
										<form class="edit-layer" enctype="multipart/form-data" name="uploaddocuments"
											id="uploaddocuments" method="post" target="actionfrm"
											action="<?php echo $fullurl; ?>common_action.php">
											<input type="file" name="uploaddocumentsfile" id="uploaddocumentsfile"
												onChange="$('#uploaddocuments').submit();$('#commonloader').show();"
												accept="application/msword, application/vnd.ms-powerpoint, text/plain, application/pdf, application/vnd.ms-excel">
											<input type="hidden" name="action" id="action" value="uploaddocuments">
										</form>

										<h3>Upload a file</h3>
										<img src="<?php echo $fullurl; ?>images/upload-background-sprite.png">
										<div class="uplod-filebtn">
											<a href="javascript:void(0);"
												onclick="$('#uploaddocumentsfile').click();">Select files to upload</a>
											<span> or drag and drop (max 20 mb)</span>
										</div>
									</div>
								</div>
								<?php
							}
							?>

							<div id="pendingfiles"></div>

							<!-- Hidden iframe for upload target -->
							<iframe name="actionfrm" id="actionfrm" style="display:none;"></iframe>

							<!-- Loader -->
							<div id="commonloader"
								style="display:none; text-align:center; font-weight:bold; padding:10px;">
								Uploading... Please wait
							</div>

							<script>
								function loadpendingfile() {
									$("#pendingfiles").load('<?php echo $fullurl; ?>pendingfiles.php?eid=<?php echo $id; ?>');
								}
								loadpendingfile();

								// refresh the list after upload completes
								$('#actionfrm').on('load', function () {
									$('#commonloader').hide();
									loadpendingfile();
								});
							</script>

						</div>
					</div>
				</div> <!-- [End center content] -->
			</div>
		</div>
	</div>
	<?php include('footer.php'); ?>
</body>

</html>