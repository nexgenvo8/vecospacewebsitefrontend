<?php
include_once('inc.php');
include_once('mail.php');
$action = 'add';
$isSubmitted = 'n';
if (isPost()) {
	$errMsg = '';
	$className = '';

	$action = clean($_POST['txtAction']);

	if (trim($action) == 'add') {


		$email = clean($_POST["email"]);


		if (trim($email) == '') // validating if email address is blank
		{
			$errMsg = 'Please enter email address.';
			$className = 'errormsg';
		}

		if (trim($email) != '') // validating if email address charactor length > 60
		{
			if (strlen(trim(sanitizedboutput($email))) > 60) {
				$errMsg = 'Email address exceeded character limit! Can have 60 characters.';
				$className = 'errormsg';
			}
		}

		if (trim($email) != '') {
			if (isValidEmailFunc(trim($email)) == 'n') // validating if E-mail address of user is valid
			{
				$errMsg = 'Please enter valid email.';
				$className = 'errormsg';
			}
		}

		if (trim($errMsg) == '') {

			$selectFields = [];
			$whereFields = [];
			$whereVals = [];

			$sqlEmailDetails = "";
			$sqlEmailDetails = "select email from " . _USERS_MASTER_TABLE_ . " where email='" . $email . "' ";
			$resEmailDetails = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlEmailDetails);
			if ($resEmailDetails) {

				$strEmail = '';
				$strEmail = base64_encode(base64_encode(base64_encode(base64_encode($email))));
				$mailBodyContent = '';

				$mailBodyContent = '<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;">
	<a href="' . $fullurl . 'timeline.html"><img src="' . $fullurl . 'images/logo.jpg" width="150"></a>
</div>
<div style="background-color:#f4f4f4;user-select: none;-moz-user-select: none; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; padding:30px 0px;text-align:center;">
  <div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
    <div style="padding:30px;">
 
      <div style="padding:10px; background-color:#F9F9F9; border:dashed 1px #ccc; border-radius: 2px;">
        <div style="color: #696969; margin-bottom: 22px; font-size: 14px; line-height: 20px;">      
          <div style=" margin-bottom:10px; font-size: 16px;">
        <div style="display: block;width: 100%;margin-top: 10px;"> It seems you have forgotten your ' . $companNameTitle . ' login password.  </div>
           </div>
        </div>
        <div style="color: #696969; margin-bottom: 22px; font-size: 15px; line-height: 20px;text-align: center; border-bottom: solid 1px #e7e7e7; padding-bottom: 10px; border-top: solid 1px #e7e7e7; padding-top: 10px;"><p>If you really have, please click on the below link to create a new one</p>
          <div style="width: 100%;text-align: center;overflow: hidden;">
          <a href="' . $fullurl . 'reset-password.html?_j=' . $strEmail . '" target="_blank"  style="float: none; display: inline-block; padding: 8px 13px; background-color: #20741f; text-decoration: none; color: #fff; margin-left: 0; margin-top: 10px;">Create a new password</a>
        </div>
        
        </div>
<div style="    color: #696969; font-size: 13px; line-height: 20px; padding-left: 10px;"><p>You can also copy and paste the below link in your browser window</p>
<a href="' . $fullurl . 'reset-password.html?_j=' . $strEmail . '" target="_blank">' . $fullurl . 'reset-password.html?_j=' . $strEmail . '</a>
<p>If you did?nt mean to change your password, you can simply ignore this email</p>
   
    Thank You<br />
    Team ' . $companNameTitle . '</p>
</div>

      <div style="    margin-top: 20px; text-align: right; line-height: 30px;padding-top: 5px; border-top: solid 1px #e7e7e7; color: #afafaf;">Powered by ' . $companNameTitle . '</div>
    </div>
  </div>
</div>';


				$subject = "Reset your password";

				/*				$headers = 'From: '.$companNameTitle.'<do_not_reply@scgindia.in>' . "\r\n";
								$headers .= "MIME-Version: 1.0\r\n";
								$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";*/

				//$mailSent=@mail($email,$subject,$mailBodyContent,$headers);
				send_template_mail_reg(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

				$sql_ins = "update " . _USERS_MASTER_TABLE_ . " set passStatus='1',resetPasswordTime=" . time() . " where email='" . $email . "' ";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

				header('Location:forgot-password.html?send=1');

			} else {
				$errMsg = 'This Email address does not exists.';
				$className = 'errormsg';
			}

		}


	}
}


?>
<!DOCTYPE html>
<html>

<head>
	<title>Forgot Password - <?php echo $companNameTitle; ?></title>
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
					<h2 style="text-align:center; color:#20741f;">Forgot Password</h2>
					<form name="frmkonectt" id="frmkonectt" class="personal-data" method="post">

						<?php if (!isset($_GET['send']) || $_GET['send'] != 1) { ?>
							<div id="stepsdetail1" style="text-align: center;">
								<div class="half-input">
									<?php if (!empty($errMsg)) { ?>
										<div style="margin-bottom:10px; color:#FF0000;"><?php echo htmlspecialchars($errMsg); ?>
										</div>
									<?php } ?>
									<input type="email" class="input validate" name="email" id="email"
										value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>"
										placeholder="Enter email address" maxlength="60" onKeyUp="hideerrordiv(this.id);">
								</div>

								<input type="hidden" name="txtAction" id="txtAction"
									value="<?php echo isset($action) ? htmlspecialchars($action) : ''; ?>">
								<button type="button" onClick="formValidation('frmkonectt');"
									class="continue-process-btn">Send
								</button>
								<a href="<?php echo $fullurl; ?>">
									<button style="background-color:#e0e0e0; color:#333; margin-right:10px;" type="button"
										class="continue-process-btn">Cancel
									</button>
								</a>
							</div>

						<?php } else { ?>
							<div style="text-align:center;">
								<strong>Please check your messages.</strong><br>
								Please check your inbox as we've sent an e-mail to the e-mail address you linked to your
								<?php echo isset($companNameTitle) ? htmlspecialchars($companNameTitle) : ''; ?> profile.
								When you click on the link in the e-mail, you'll be
								automatically forwarded to a page explaining how to create your new password.&nbsp;<br>
								<br>
								<strong>Haven't received an e-mail yet?</strong>&nbsp;<br>
								Please check your spam folder and make sure our e-mail hasn't ended up there. If don't
								receive our e-mail within 2 hours.<br>
								<br>

								<a href="<?php echo $fullurl; ?>">
									<button style="background-color:#e0e0e0; float:none; color:#333; margin-right:10px;"
										type="button" class="continue-process-btn">Back to login page
									</button>
								</a>
							</div>
						<?php } ?>

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
			background: #016402;
			background: -moz-linear-gradient(top, #1b8cb8 0%, #6dc8e7 100%);
			background: -webkit-linear-gradient(top, #036503 0%, #529152 100%);
			background: linear-gradient(to bottom, #0a680a 0%, #629b62 100%);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#20741f', endColorstr='#6dc8e7', GradientType=0);
		}
	</style>
</body>

</html>