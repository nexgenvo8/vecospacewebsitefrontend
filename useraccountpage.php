<?php
include_once('inc.php');
?>
<!DOCTYPE html>
<html>

<head>
  <title>User account - <?php echo $companNameTitle; ?></title>
  <link rel="stylesheet" type="text/css" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <link rel="icon" href="favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css"
    href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body style="background-color: #fff;background-image: inherit;overflow: hidden;">
  <div id="wrapper">
    <header>
      <div class="logo login-pros"><a href="https://www.konectt.com"><img
            src="https://www.konectt.com/images/ndimlogo.png"></a></div>
    </header>
    <div class="banner">
      <div class="container">
        <div class="second-step" style="width:500px;">

          <form name="frmkonectt" id="frmkonectt" class="personal-data" method="post">
            <div style="text-align:center; ">
              <strong>Your account has been temporarily suspended</strong><br><br>

              Suspicious activity has been detected on your <?php echo $companNameTitle; ?> account and it has been
              temporarily suspended as a security precaution. Ii is likely that your account was compromised as a result
              of entering your password on a website design to look like <?php echo $companNameTitle; ?>. This type of
              attack is known as phising. If you have any question please write to support team <a
                href="mailto:help@konectt.com">help@konectt.com</a><br>
              <br>

              <a href="https://www.konectt.com"><button
                  style="background-color:#e0e0e0; float:none; color:#333; margin-right:10px;" type="button"
                  class="continue-process-btn">Back to home page</button></a>
            </div>

        </div>
      </div>
    </div>


  </div>


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