<?php
include_once('inc.php');
$fpage = 6;
$action = 'add';
$isSubmitted = 'n';
if (isPost()) {


	$errMsg = '';
	$errMsgl = '';
	$className = '';
	$className1 = '';
	$classFldName = '';

	$action = clean($_POST['txtAction']);

	if (trim($action) == 'add') {
		$contactName = addslashes($_POST["contactName"]);
		$email = clean($_POST["email"]);
		$message = addslashes($_POST["message"]);


		if (isset($_POST['g-recaptcha-response']))

			$captcha = $_POST['g-recaptcha-response'];

		if (!$captcha) {
			$errMsg = 'Please check the "I\'m not a robot" checkbox!.';
			$className = 'errormsg';
		}

		$response = json_decode(file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" . _RECAPTCHA_SECRET_KEY_ . "&response=" . $captcha . "&remoteip=" . $_SERVER['REMOTE_ADDR']), true);

		if ($response['success'] == false) {
			$errMsg = 'You are a spammer!';
			$className = 'errormsg';
		}
		if (trim($message) == '') {
			$errMsg = 'Please enter your query.';
			$className = 'errormsg';
		}

		if (trim($email) == '') {
			$errMsg = 'Please enter Email address.';
			$className = 'errormsg';
		}

		if (trim($email) != '') {
			if (strlen(trim(sanitizedboutput($email))) > 60) {
				$errMsg = 'Email address exceeded character limit! Can have 60 characters.';
				$className = 'errormsg';
			}
		}

		if (trim($email) != '') {
			if (isValidEmailFunc(trim($email)) == 'n') {
				$errMsg = 'Please enter valid Email.';
				$className = 'errormsg';
			}
		}



		if (trim($contactName) == '') {
			$errMsg = 'Please enter first name.';
			$className = 'errormsg';
		}

		if (trim($contactName) != '') {
			if (strlen(trim(sanitizedboutput($contactName))) > 60) {
				$errMsg = 'First name exceeded character limit! Can have 60 characters.';
				$className = 'errormsg';
			}
		}



		if (trim($errMsg) == '') {
			include_once('mail.php');

			unset($insertFields);
			unset($insertVals);

			$insertFields[0] = "contactName";
			$insertFields[1] = "email";
			$insertFields[2] = "message";
			$insertFields[3] = "dateAdded";

			$insertVals[0] = $contactName;
			$insertVals[1] = $email;
			$insertVals[2] = $message;
			$insertVals[3] = time();

			$resUpdate = insertDB(_CONTACT_MESSAGES_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

			$mailBodyContent = '';
			$mailBodyContent = '<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;"><a href="' . $fullurl . '" style="border:0px;"><img src="' . $fullurl . 'images/logo.jpg" width="217" style="border:0px;"></a></div><div style="background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; padding:30px 0px;text-align:center;">
<div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">

<div style="padding:30px;">



<div style="padding:10px;background-color: #F9F9F9;border:dashed 1px #ccc;border-radius: 2px;">



<div style="color: #696969; font-size: 14px; line-height: 20px;">
    
    <h2 style="
    font-weight: 500;
    font-size: 15px;
    line-height: 23px;
    color: #676767;
"><div style="display:block; font-size:18px; margin-bottom:10px;">Dear Admin,</div></h2>
Following details were entered on contact page:</div>
</div>
<table width="100%" height="90" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="background-color: #f7f7f7;">
<tr>    <td width="82">&nbsp;</td>    
      <td width="45">&nbsp;</td>
      <td width="471">&nbsp;</td>  </tr><tr>
  <td style="padding-left:7px;" valign="top">Name</td>
  <td>:</td>
  <td valign="top">' . stripslashes(ucwords($contactName)) . '</td>
</tr><tr>    <td width="82">&nbsp;</td>    
      <td width="45">&nbsp;</td>
      <td width="471">&nbsp;</td>  </tr><tr>
  <td style="padding-left:7px;" valign="top">Email</td>
  <td>:</td>
  <td valign="top">' . trim($email) . '</td>
</tr><tr>    <td width="82">&nbsp;</td>    
      <td width="45">&nbsp;</td>
      <td width="471">&nbsp;</td>  </tr><tr>
  <td style="padding-left:7px;" valign="top">Mesaage</td>
  <td>:</td>
  <td valign="top" style="padding-bottom: 24px;">' . nl2br(stripslashes(trim($message))) . '</td>
</tr>

</table>

<div style="    margin-top: 20px;
    text-align: right;
    line-height: 30px;padding-top: 5px;
    border-top: solid 1px #e7e7e7;
    color: #afafaf;">Powered by ' . $companNameTitle . '
</div>
</div>
</div>
</div>';


			$subject = "Contact form filled on " . $companNameTitle . "";
			//$email=$email;
			$email = 'info@connecwrk.com';
			send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);


			$isSubmitted = 'y';
			$errMsg = 'Thank you for submitting the contact details. ' . $companNameTitle . ' team will get in touch soon to take this forward.';
			$className = 'success';


			$contactName = '';
			$email = '';
			$message = '';


			//header('Location:thankyou.html');
			//exit();


		}


	}

}
?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<title>Contact Us - <?php echo stripslashes($companNameTitle); ?></title>
	<meta name="description" content="<?php echo stripslashes($post_result['meta_description']); ?>" />
	<meta name="keywords" content="<?php echo stripslashes($post_result['meta_keyword']); ?>" />

	<link href="css/style.css" rel="stylesheet" type="text/css" />
	<script src="js/jquery.min.js"></script>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script>
		//
		// 	     if(!grecaptcha.getResponse())
		//		 {
		//		   alert('Please check the "I\'m not a robot" checkbox!');
		//		   return false;
		//		 }
		//		var recaptcha_response_field = $("input[type='checkbox']#recaptcha_response_field:checked").val();
		//
		//		if(recaptcha_response_field=='' || recaptcha_response_field === undefined)
		//		{
		//			alert("Please check the captcha. I am not a robot.");
		//			$("#recaptcha_response_field").focus();
		//			return false;
		//		}

	</script>
	<!--<script>
function recaptchaCallback() {
$('#logintabledata4').hide();
//$('#submitBtn').removeAttr('disabled');
}
</script>-->
</head>

<body style="background-image:none;">
	<div class="aboutheader">
		<div class="container">
			<div class="logo">
				<a style="margin-top:0px; margin-bottom:0px;" href="<?php echo $fullurl; ?>"><img src="images/ndimlogo.png"
						style="width: 275px;" /></a>
			</div>
			<?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
					<div class="toggle hiden-xs" onclick="$('.setting_menu').toggle();">
						<a href="javascript:void(0);">
							<span class="usr_img"><img
									src="<?php echo $fullurl; ?>uploads/<?php echo $myprofilePhoto; ?>"></span>
						</a>
						<ul class="setting_menu" style="display: none;">
							<li><a href="<?php echo $fullurl; ?>"><i class="fa fa-cog" aria-hidden="true"></i> Go to
									timeline</a>
							</li>
						</ul>
					</div>
			<?php } ?>
		</div>
	</div>

	<div class="help-banner">
		<p>Contact Us</p>
	</div>
	<span class="clear"></span>
	<div class="container">
		<div class="helpwrap-cont">
			<?php include('left_links.php'); ?>
			<div class="right-panel">
				<div class="" style="margin-bottom: 100px;
	float: left;
	margin-left: 0;width: 100%;
	margin-top: 0px;">

					<form class="signup" name="contactusfrm" id="contactusfrm" method="post">
						<h2>Contact Us</h2>


						<?php if ($isSubmitted == 'n') { ?>
								<div style="margin-bottom:30px;font-size: 15px;text-align: left;">
									Thank you for reaching out. If you have any queries, please fill the details in the fields
									below and we shall get back with an answer soon.
									You can also write to us on <a href="mailto:info@vecospace.com">info@vecospace.com</a>
								</div>
						<?php } ?>

						<?php
						$errMsg = $errMsg ?? ''; // Ensure $errMsg is defined
						
						if (!empty($errMsg)) { ?>
								<div style="<?php if ($isSubmitted == 'n') { ?>margin-bottom:30px; font-size: 15px;text-align: left;<?php } else { ?>margin-bottom: 30px; font-size: 15px; min-height: 150px; padding-top: 15px; text-align: center; color: #4a4a4a !important;<?php } ?>"
									class="<?php echo $className; ?>">
									<?php echo $errMsg; ?>
								</div>
						<?php } ?>


						<?php
						$contactName = $contactName ?? '';
						$email = $email ?? '';
						$message = $message ?? '';
						?>

						<?php if ($isSubmitted == 'n') { ?>
								<input type="text" name="contactName" id="contactName"
									value="<?php echo stripslashes($contactName); ?>" placeholder="Name" maxlength="60"
									onKeyUp="hideerrordiv(this.id);" class="validate">

								<input type="email" name="email" id="email" value="<?php echo stripslashes($email); ?>"
									placeholder="Email address" maxlength="60" onKeyUp="hideerrordiv(this.id);"
									class="validate">

								<textarea rows="4" name="message" id="message" placeholder="Kindly describe your query"
									style="height: 100px; width: 100%; padding: 10px; margin-bottom: 20px;" maxlength="2000"
									class="validate"
									onKeyUp="hideerrordiv(this.id);"><?php echo stripslashes($message); ?></textarea>

								<div class="txtfld_labl" style="margin-bottom: 20px;">Are you Human?</div>
								<span class="erorfldcls" id="recaptcha_response_field"></span>
								<div class="g-recaptcha" data-callback="recaptchaCallback"
									data-sitekey="<?php echo _RECAPTCHA_SITE_KEY_; ?>" style="margin-bottom: 20px;"></div>

								<button type="button" onClick="formValidation('contactusfrm');">Submit</button>
								<input type="hidden" name="txtAction" id="txtAction" value="<?php echo $action; ?>">
						<?php } ?>

					</form>


				</div>
			</div>
		</div>
	</div>
	</div>
	<script src="<?php echo $fullurl; ?>js/validateform.js"></script>
</body>

</html>