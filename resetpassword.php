<?php
include_once('inc.php');
include_once('mail.php');
$r = isset($_GET["r"]) ? $_GET["r"] : '';
$restpassword = isset($_POST["restpassword"]) ? $_POST["restpassword"] : '';
$_j = isset($_GET["_j"]) ? $_GET["_j"] : '';

if ($r != 2) {
	if ($r != 1) {

		if ($restpassword != 1) {

			if ($_j == '') {
				header('Location:' . (isset($fullurl) ? $fullurl : '/') . 'page-not-found.html');
				exit();
			}

			$strEmail = $_j;
			$strEmail = base64_decode(base64_decode(base64_decode(base64_decode($strEmail))));

			$selectFields = [];
			$whereFields = [];
			$whereVals = [];

			$sqlLogin = "select email from " . _USERS_MASTER_TABLE_ . " where email='" . $strEmail . "' ";
			$resLogin = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);

			if ($resLogin) {
			} else {
				header('Location:' . $fullurl . 'page-not-found.html');
				exit();
			}


		}


		if (trim(isset($_POST["restpassword"]) ? $_POST["restpassword"] : '') == 1) {

			$errMsg = '';
			$className = '';

			$newpass = md5(addslashes(trim($_POST["newpassword"])));
			$confirmpass = md5(addslashes(trim($_POST["confirmpassword"])));
			$email = trim($_POST["textemail"]);


			if (strlen(trim($_POST["newpassword"])) > 16) {
				$errMsg = 'Please enter new password maximum 16 charachters';
				$className = 'errormsg';
			}


			if (strlen(trim($_POST["confirmpassword"])) > 16) {
				$errMsg = 'Please enter confirm password maximum 16 charachters';
				$className = 'errormsg';
			}
			if (strlen(trim($_POST["newpassword"])) > 5 && strlen(trim($_POST["confirmpassword"])) > 5) {
				if ($newpass != $confirmpass) {

					$errMsg = "New password dose not matched with confirm password.";
					$className = 'errormsg';
				}
			}
			if (strlen(trim($_POST["confirmpassword"])) <= 5) {
				$errMsg = 'Please enter confirm password minimum 6 charachters';
				$className = 'errormsg';
			}

			if (strlen(trim($_POST["newpassword"])) <= 5) {
				$errMsg = 'Please enter new password minimum 6 charachters';
				$className = 'errormsg';
			}


			if (trim($_POST["confirmpassword"]) == '') {
				$errMsg = 'Please enter confirm password';
				$className = 'errormsg';
			}
			if (trim($_POST["newpassword"]) == '') {
				$errMsg = 'Please enter new password';
				$className = 'errormsg';
			}

			if (trim($errMsg) == '') {


				$aa = "SELECT resetPasswordTime from " . _USERS_MASTER_TABLE_ . " where email='" . $email . "' ";
				$res5 = mysqli_query($conn, $aa);
				$rowRows = mysqli_fetch_array($res5);
				$resetPasswordTime = $rowRows['resetPasswordTime'];

				$datetime1 = $resetPasswordTime;
				$datetime2 = time();

				$finalTime = date('i', $datetime2 - $datetime1);
				if ($finalTime > 30) {
					header('Location:' . $fullurl . 'reset-password.html?r=2');
					exit();
				} else {

					$sql_ins = "update " . _USERS_MASTER_TABLE_ . " SET password='" . $confirmpass . "',passStatus=0 WHERE email='" . $email . "' ";
					mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
					//send email

					$mailBodyContent = '';
					$mailBodyContent = '
				<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;">
	<a href="' . $fullurl . 'timeline.html"><img src="' . $fullurl . 'images/alumni-alumni-logo.png" width="150"></a>
</div>
<div style="background-color:#f4f4f4;user-select: none;-moz-user-select: none; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; padding:30px 0px;text-align:center;">
  <div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
    <div style="padding:30px;">
 
      <div style="padding:10px; background-color:#F9F9F9; border:dashed 1px #ccc; border-radius: 2px;">
        <div style="color: #696969; margin-bottom: 22px; font-size: 14px; line-height: 20px;">      
          <div style=" margin-bottom:10px; font-size: 16px;">
        <div style="display: block;width: 100%;margin-top: 10px;"> Your password for signing in to ' . $companNameTitle . ' was recently changed.  </div>
           </div>
        </div>
        <div style="color: #696969; margin-bottom: 22px; font-size: 15px; line-height: 20px;text-align: left; border-bottom: solid 1px #e7e7e7; padding-bottom: 10px; border-top: solid 1px #e7e7e7; padding-top: 10px;"><p>If you did not make this change, kindly <a href="' . $fullurl . 'forgot-password.html">reset your password</a> to secure your account.</p>
<p>Kindly email us on <a href="mailto:support@konectt.com">support@konectt.com</a> for any concerns or queries you may have.
        We are here to help.</p>
        
        </div>
<div style="color: #696969;font-size: 14px;">Wishing you a great life.<br />
        <br />
         Best,
        
        
         <br />
         Team ' . $companNameTitle . '
       </div>

      <div style="    margin-top: 20px; text-align: right; line-height: 30px;padding-top: 5px; border-top: solid 1px #e7e7e7; color: #afafaf;">Powered by ' . $companNameTitle . '</div>
    </div>
  </div>
</div>';


					$subject = "You have a new password";

					$headers = 'From: ' . $companNameTitle . '<do_not_reply@scgindia.in>' . "\r\n";
					$headers .= "MIME-Version: 1.0\r\n";
					$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

					//$mailSent=@mail($email,$subject,$mailBodyContent,$headers);
					send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

					header('Location:' . $fullurl . 'reset-password.html?r=1');
					exit();

				}

			}

		}

	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Reset Password - <?php echo $companNameTitle; ?></title>
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
						src="<?php echo $fullurl; ?>images/alumni-logo.png"></a></div>
		</header>
		<div class="banner">
			<div class="container">
				<div class="second-step" <?php if (isset($_GET['send']) && $_GET['send'] == 1) { ?>style="width:500px;"
					<?php } ?>>

					<h2 style="text-align:center; color:#1a94c3;">Reset Password</h2>
					<form name="frmkonectt" id="frmkonectt" class="personal-data" method="post">
						<?php
						// Fix undefined variable
						$errMsg = isset($errMsg) ? $errMsg : '';

						// Fix undefined $_GET keys
						$r = isset($_GET['r']) ? $_GET['r'] : '';
						$send = isset($_GET['send']) ? $_GET['send'] : '';

						$newpassword = isset($_POST["newpassword"]) ? trim($_POST["newpassword"]) : '';
						$confirmpassword = isset($_POST["confirmpassword"]) ? trim($_POST["confirmpassword"]) : '';
						?>

						<?php if ($r != 2) {
							if ($r != 1) { ?>

								<div id="stepsdetail1">

									<div class="half-input">
										<?php if (trim($errMsg) != '') { ?>
											<div id="emsgdiv" class="<?php echo isset($className) ? $className : ''; ?>"
												style="display:block; margin-top:10px; margin-bottom:10px;">
												<?php echo $errMsg; ?>
											</div>
										<?php } ?>

										<input type="password" class="input validate" name="newpassword" id="newpassword"
											maxlength="16" placeholder="Enter new Password"
											value="<?php echo htmlspecialchars($newpassword); ?>"
											onKeyUp="hideerrordiv(this.id);">
										<input type="password" class="input validate" name="confirmpassword"
											id="confirmpassword" maxlength="16" placeholder="Enter confirm Password"
											value="<?php echo htmlspecialchars($confirmpassword); ?>"
											onKeyUp="hideerrordiv(this.id);">
									</div>

									<input type="hidden" name="restpassword" id="restpassword" value="1">
									<input type="hidden" name="textemail" id="textemail"
										value="<?php echo isset($strEmail) ? $strEmail : ''; ?>">
									<button type="button" onClick="formValidation('frmkonectt');subsrchfrm();"
										class="continue-process-btn">Reset</button>

								</div>

							<?php }
						} ?>

						<?php if ($r == 1) { ?>
							<div style="text-align:center;">
								<strong>Your Password updated successfully.</strong><br><br><br>
								<a href="<?php echo isset($fullurl) ? $fullurl : '#'; ?>">
									<button style="background-color:#e0e0e0; float:none; color:#333; margin:0px;"
										type="button" class="continue-process-btn">Login</button>
								</a>
							</div>
						<?php } ?>

						<?php if ($r == 2) { ?>
							<div style="text-align:center;">
								<strong>That link isn't working.</strong><br><br>
								Password reset links expire after 30 minutes if unused.<br><br>
								If your link isn't working for any reason,<br>
								you can <a
									href="<?php echo isset($fullurl) ? $fullurl . 'forgot-password.html' : '#'; ?>">request
									a new one.</a>
								<br>
							</div>
						<?php } ?>

					</form>


					<script>
						function subsrchfrm() {

							if ($("#newpassword").val() != '' && $("#confirmpassword").val() != '') {
								$("#frmkonectt").submit();
							}
						}

						$("input").keypress(function (event) {

							if (event.which == 13) {
								event.preventDefault();

								if ($("#newpassword").val() != '' && $("#confirmpassword").val() != '') {
									$("#frmkonectt").submit();
								}
							}
						});

					</script>
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