<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session
$pageIndex=10;
?>
<!DOCTYPE html>
<html>
<head>
<title>Events - <?php echo $companNameTitle;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/style.css">
<link rel="icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<script src="<?php echo $fullurl;?>js/jquery.min.js"></script>
<script src="<?php echo $fullurl;?>js/main.js"></script>
</head>
<body>
<div id="wrapper" class="active">
  <?php include('header.php');?>
  <div class="container main">
    <div class="premium_tag"><a href="#">Go Premium</a>
      <p id="typewriter"></p>
    </div>
    <div class="home_container">
      <?php include('left-sidebar.php');?>
      <div class="center_content">
      	<div class="feed">
      		<div class="ttl-hd">Follow people to see their posts in your feed</div>
      		<ul>
      			<li>
      				<div class="feed_box">
      					<div class="fd-img"><img src="http://scgindia.in/konectt/php/uploads/14979557001.jpg"></div>
      					<div class="fd-nm">ShahRukh Khan</div>
      					<span class="fd-position">Front End Web developer at scg india</span>
      					<span class="fllwrs">995 Followers</span>
      					<a href="" class="flw-btn"><i class="fa fa-plus" aria-hidden="true"></i>Follow</a>
      				</div>
      			</li>
      		</ul>
      	</div>
      </div>
    </div>
  </div>
  <?php include('footer.php');?>
</div>
<script>
function reloadPage(){
location.reload(true);
}

</script>
</body>
</html>
