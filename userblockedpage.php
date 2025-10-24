<?php
include_once('inc.php');

?>
<!DOCTYPE html>
<html>

<head>
  <title>User Deactivated - <?php echo $companNameTitle; ?></title>
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
        <div class="second-step" <?php if ($_GET['send'] == 1) { ?>style="width:500px;" <?php } ?>>
          <h2 style="text-align:center; color:#1a94c3;">User deactivated</h2>

          <div style="text-align:center; ">
            <strong>Please read your messages.</strong><br>
            Your account has been deactivated. Please contact Administrator if you have any question.
            <br>
            <br>

            <a href="<?php echo $fullurl; ?>"><button
                style="background-color:#e0e0e0; float:none; color:#333; margin-right:10px;" type="button"
                class="continue-process-btn">Back to login page</button></a>
          </div>

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