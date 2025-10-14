<?php
include_once('inc.php'); 
$fpage=1;
?>
<!DOCTYPE html>
<html>
<head>
<title>Conduct Guidelines - <?php echo $companNameTitle;?></title>
<meta name="description" content="<?php  echo stripslashes($post_result['meta_description']); ?>" />
<meta name="keywords" content="<?php  echo stripslashes($post_result['meta_keyword']); ?>"/>
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
    
    <div class="home_container">
       <div class="center_content nologin">
	    <div class="terms">
      <h2>Conduct Guidelines</h2>
        coming soon
    </div>
        
      </div>
    </div>
  </div>
  <?php include('footer.php');?>
</div>
</body>
</html>
