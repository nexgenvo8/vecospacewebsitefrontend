<?php
include_once('inc.php');
?>
<!DOCTYPE html>
<html>

<head>
  <title>404 Page not found - <?php echo $companNameTitle; ?></title>
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
        <div class="second-step" style="width:800px; top: 0px;   background-color: transparent;">
          <div class="container main" style=" padding-top: 0px;   width: 100%;">

            <div class="home_container">
              <div class="center_content" style="padding-left: 0;">
                <div class="error">
                  <h1>404</h1>
                  <div class="not-found">PAGE NOt found</div>
                  <div class="broken">
                    The link you clicked maybe broken or the page may have been removed.
                  </div>
                  <a href="<?php echo $fullurl; ?>">Go to Home</a>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <?php include('sitefooter.php'); ?>
  </div>
  <?php include('sitecopyright.php'); ?>

  <div class="overlay">&nbsp;</div>

</body>

</html>