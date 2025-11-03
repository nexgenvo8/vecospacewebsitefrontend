<?php
include_once('inc.php');
include_once('config/session-check.inc.php');
$action = 'add';
$isSubmitted = 'n';
if (isPost()) {
	$errMsg = '';
	$className = '';
	$action = clean($_POST['txtAction']);

	if (trim($action) == 'reopen') {
		$reopenuseraccount = trim($_POST["reopenuseraccount"]);

		if ($reopenuseraccount == 1) {
			$sql_ins = "update " . _USERS_MASTER_TABLE_ . " SET userAccountCloseStatus=0 WHERE userId='" . $_SESSION["sessUserId"] . "' ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
			$_SESSION["_ac"] = 1;
			header('Location:' . $fullurl . 'timeline.html');
			exit();
		} else {
			header('Location:' . $fullurl);
			exit();
		}
	}
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Re-activate account - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css"
		href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/main.js"></script>
</head>

<body style="background-color: #fff;background-image: inherit;overflow: hidden;">
	<div id="wrapper">
		<header>
			<div class="logo login-pros"><a href="<?php echo $fullurl; ?>"><img
						src="<?php echo $fullurl; ?>images/sgtlogo.png"></a></div>
		</header>
		<div class="banner">
			<div class="container">
				<div class="second-step" <?php if ($_GET['send'] == 1) { ?>style="width:500px;" <?php } ?>>
					<h2 style="text-align:center; color:#1a94c3;">Re-activate account</h2>
					<form name="frmkonectt" id="frmkonectt" class="personal-data" method="post">

						<div id="stepsdetail1" style="text-align:center;">
							<div class="half-input">
								<?php if ($errMsg != '') { ?>
									<div style="margin-bottom:10px; color:#FF0000;"><?php echo $errMsg; ?></div><?php } ?>
							</div>

							<input type="hidden" name="txtAction" id="txtAction" value="reopen">
							<input type="hidden" name="reopenuseraccount" id="reopenuseraccount" value="1">
							<button type="submit" style=" float:none;" class="continue-process-btn">Yes</button>
							<a href="<?php echo $fullurl; ?>logout.html"><button
									style="background-color:#e0e0e0; color:#333; margin-left:10px; float:none;"
									type="button" class="continue-process-btn">No</button></a>

						</div>
					</form>
				</div>
			</div>
		</div>

		<?php include('sitefooter.php'); ?>
	</div>
	<?php include('sitecopyright.php'); ?>

	<div class="overlay">&nbsp;</div>
	<style type="text/css">
		header {
			margin: auto;
			width: 100%;
			overflow: hidden;
			z-index: 9999999999999;
			position: absolute;
			width: 100%;
			background-color: #fff;
		}

		.overlay {
			width: 100%;
			height: 100%;
			position: fixed;
			left: 0;
			top: 0;
			background: #1a94c3;
			background: -moz-linear-gradient(top, #1b8cb8 0%, #6dc8e7 100%);
			background: -webkit-linear-gradient(top, #1b8cb8 0%, #6dc8e7 100%);
			background: linear-gradient(to bottom, #1b8cb8 0%, #6dc8e7 100%);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#1a94c3', endColorstr='#6dc8e7', GradientType=0);
		}
	</style>
</body>

</html>