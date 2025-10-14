<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session
$pageIndex=11;

?>
<!DOCTYPE html>
<html>
<head>
<title>Thanks Project - <?php echo $companNameTitle;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/default.css">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

<link rel="icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<script src="<?php echo $fullurl;?>js/jquery-1.11.1.min.js"></script>
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
      
    </div>
	<div class="center_content">

<div class="groups">
<?php include('project_top.inc.php');?>
<div class="create-projct prview">
<div class="well_done">
  <h1>Well done!</h1>
  <p>Thanks for creating a new project on <?php echo $companNameTitle;?>.</p>
  <span>Members on <?php echo $companNameTitle;?> will be able to view your Project within the next 24 hours
</span>
<div class="btns-wldon">
  <a href="<?php echo $fullurl;?>post-project.html" class="crt">Create another Project</a>
  <a href="<?php echo $fullurl;?>manage-projects.html">Manage your Project </a>
</div>
</div>
</div>
</div>


  </div>
  </div>
  <?php include('footer.php');?>
</div>

</body>
</html>
