<?php
include_once('inc.php');
include_once('mail.php');
if (isset($_SESSION['registerEmail']) && isset($_SESSION['resendemail']) && $_SESSION["registerEmail"] != '' && $_REQUEST["resendemail"] == 1) {

  $email = $_SESSION["registerEmail"];
  $strEmail = '';
  $strEmail = base64_encode(base64_encode(base64_encode(base64_encode($email))));
  $mailBodyContent = '';

  $mailBodyContent = '<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;"><a href="' . $fullurl . 'timeline.html" style="border:0px;"><img src="' . $fullurl . 'images/logo.jpg" width="217" style="border:0px;"></a></div><div style="background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; padding:30px 0px;text-align:center;">
<div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
<table style="width:100%;background-color: #e8e8e8;">
<tbody><tr>
<td colspan="3" height="20" style="height:20px;font-size:0px;text-align:center">

    <a style="text-decoration:underline;font-family:arial,sans-serif;font-size:11px;color:#666666">If this e-mail isn&prime;t displayed correctly, please click here.</a></td></tr>

    </tbody></table>
<div style="padding:30px;">



<div style="padding:10px;background-color: #F9F9F9;border:dashed 1px #ccc;border-radius: 2px;">



<div style="color: #696969; font-size: 14px; line-height: 20px;">
    
    <h2 style="
    font-weight: 500;
    font-size: 15px;
    line-height: 23px;
    color: #676767;
"><div style="display:block; font-size:18px; margin-bottom:10px;">Hello,</div>

Thank you for registering with us. We are thrilled to have you on ' . $companNameTitle . '. To get you fully on board, we request you to verify your email address, by clicking on the button below.	</h2></div><div style="text-align:left; margin-top:20px; margin-bottom:30px;"><a href="' . $fullurl . 'confirm-registration.html?_j=' . $strEmail . '" style="text-decoration:none;"><input name="" type="button" style="background-color:#C02621;cursor: pointer; padding:12px 30px; outline:0px; border:0px; border-radius: 3px; color:#FFFFFF; font-size:16px; cursor:pointer;" value="Confirm e-mail address"></a></div>
</div>
<table width="100%" height="90" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="
    background-color: #f7f7f7;
"><tbody><tr><td colspan="3" width="100%" height="10" style="width:100%;height:10px;line-height:0px;font-size:0px">&nbsp;</td></tr><tr><td width="25" style="width:4%">&nbsp;</td><td width="480" height="80" style="width:80%;height:80px;font-family:Arial;font-size:13px;color:#808080;line-height:18px;text-align:left">Is the button not working? Please copy this link to your browser:<br><br><a href="' . $fullurl . 'confirm-registration.html?_j=' . $strEmail . '" style="font-family:Helvetica,Arial,sans-serif;font-size:12px;color:#179cd0;word-break:break-all" target="_blank">' . $fullurl . 'confirm-registration.html?_j=' . $strEmail . '</a></td><td width="25" style="width:4%">&nbsp;</td></tr><tr><td colspan="3" height="10" style="height:10px;line-height:0px;font-size:0px">&nbsp;</td></tr></tbody></table>

<div style="    margin-top: 20px;
    text-align: right;
    line-height: 30px;padding-top: 5px;
    border-top: solid 1px #e7e7e7;
    color: #afafaf;">Powered by ' . $companNameTitle . '
</div>
</div>
</div>
</div>';


  $subject = "Please confirm your " . $companNameTitle . " registration now.";

  $headers = 'From: ' . $companNameTitle . '<do_not_reply@scgindia.in>' . "\r\n";
  $headers .= "MIME-Version: 1.0\r\n";
  $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

  //$mailSent=@mail($email,$subject,$mailBodyContent,$headers);
  send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

  header('Location:thankyou.html?s=1');
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Confirm your registration - <?php echo $companNameTitle; ?></title>
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
            src="<?php echo $fullurl; ?>images/ndimlogo.png"></a></div>
    </header>
    <div class="banner">
      <div class="container">
        <div class="second-step" style="width:412px;">
          <h2 style="text-align:center; color:#C02621;">Check your inbox</h2>
          <form name="frmkonectt" id="frmkonectt" class="personal-data" method="post">


            <div style="text-align:center; ">Kindly check your email and follow
              the steps to confirm your
              registration on <?php echo $companNameTitle; ?>.<br><br>
              Can&rsquo;t find the email? Try checking your
              Spam or other folders.<br>

              <br>
              <?php if (isset($_GET['s']) && $_GET['s'] == 1) { ?>
                <div style="color:green;">Mail sent successfully</div>
                <br>
              <?php } ?>
              <a href="<?php echo $fullurl; ?>thankyou.html?resendemail=1"><button
                  style="background-color:#e0e0e0; float:none; color:#333; margin-right:0px;" type="button"
                  class="continue-process-btn">Resend Email</button></a><br>
              <br>

              <a href="<?php echo $fullurl; ?>">Back to login page</a>



            </div>
            <br>

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
	background: #C02621;
	background: -moz-linear-gradient(top, #8f1b17 0%, #e04a45 100%);
	background: -webkit-linear-gradient(top, #8f1b17 0%, #e04a45 100%);
	background: linear-gradient(to bottom, #8f1b17 0%, #e04a45 100%);
	filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#8f1b17', endColorstr='#e04a45', GradientType=0);

    }
  </style>
</body>

</html>