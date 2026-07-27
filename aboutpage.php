<?php
include_once('inc.php');
$fpage = 3;
$re = "select title,description,meta_title,meta_description,meta_keyword from post_list  where id='6'";
$re2 = mysqli_query($conn, $re) or die(mysqli_error($conn));
$post_result = mysqli_fetch_array($re2);
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
        <a style="margin-top:0px; margin-bottom:0px;" href="<?php echo $fullurl; ?>"><img src="images/ndimlogo.png"
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
      <?php include('ndim_left_links.php'); ?>
      <div class="right-panel">
        <p>NDIM VECOSPACE is an education&nbsp;eco-space&nbsp;of NDIM, it started with the sole purpose as an opportunity to learn from your classmates and your professors. So that a person who&#39;s always been shy in the real-time class feels free to ask questions and can have a discussion with his/her fellow classmates.<br />
We want NDIM VECOSPACEto be the remedy for students&nbsp;not given the intellectual space, freedom, or support to fulfill their educational potential and desire for learning. And we&nbsp;want NDIM VECOSPACEto empower instructors to have a positive, personal impact on more students.<br />
NDIM VECOSPACEis designed to connect students, TAs, and professors so every student can get help when she needs it &mdash; even at 2 AM.<br />
And given the unprecedented times, we are in, we hope NDIM VECOSPACE&nbsp;enhances your experience as a student, as a TA, and as a Professor.</p>

      </div>
    </div>
  </div>
  </div>
  <?php include('backtotop.php'); ?>
</body>

</html>