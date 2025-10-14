<?php
include_once('inc.php');
$fpage = 1;
$re = "select title,description,meta_title,meta_description,meta_keyword from post_list where type='menu' and id='2'";
$re2 = mysqli_query($conn, $re) or die(mysqli_error($conn));
$post_result = mysqli_fetch_array($re2);

$privacypage = 1;
?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
  <title><?php echo stripslashes($post_result['meta_title']); ?></title>
  <meta name="description" content="<?php echo stripslashes($post_result['meta_description']); ?>" />
  <meta name="keywords" content="<?php echo stripslashes($post_result['meta_keyword']); ?>" />

  <link href="css/style.css" rel="stylesheet" type="text/css" />
  <script src="js/jquery.min.js"></script>


</head>

<body style="background-image:none;">
  <div class="aboutheader">
    <div class="container">
      <div class="logo">
        <a style="margin-top:0px; margin-bottom:0px;" href="<?php echo $fullurl; ?>"><img src="images/logo.png"
            style="width: 275px;" /></a>
      </div>
      <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
        <div class="toggle hiden-xs" onclick="$('.setting_menu').toggle();">
          <a href="javascript:void(0);">
            <span class="usr_img"><img src="<?php echo $fullurl; ?>uploads/<?php echo $myprofilePhoto; ?>"></span>
          </a>
          <ul class="setting_menu" style="display: none;">
            <li><a href="<?php echo $fullurl; ?>"><i class="fa fa-cog" aria-hidden="true"></i> Go to timeline</a></li>
          </ul>
        </div>
      <?php } ?>
    </div>
  </div>

  <div class="help-banner">
    <p><?php echo stripslashes($post_result['title']); ?></p>
  </div>
  <span class="clear"></span>
  <div class="container">
    <div class="helpwrap-cont">
      <?php include('left_links.php'); ?>
      <div class="right-panel">
        <?php echo stripslashes($post_result['description']); ?>
      </div>
    </div>
  </div>
  </div>
  <?php include('backtotop.php'); ?>
</body>

</html>