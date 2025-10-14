<?php
include_once('inc.php'); 
$pageIndex=18;

 
?>
<!DOCTYPE html>
<html>
<head>
<title>Tedx - <?php echo $companNameTitle;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/style.css">

<link rel="icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<script src="<?php echo $fullurl;?>js/jquery.min.js"></script>
<script src="<?php echo $fullurl;?>js/main.js"></script>

</head>
<body>
<div id="wrapper">
  <?php include('header.php');?>
  <div class="container main">
    <div class="home_container">
      <?php include('left-sidebar.php');?>
<div class="center_content <?php if($_SESSION["sessUserId"]!='' && $_SESSION["sessUserId"]!=0){ }else { echo 'nologin'; }?>">
	<div class="bx-shadow">
    
  <div class="smb-cont">

	<div class="evnt-bnnr" style="background-image:url(<?php echo $fullurl;?>/images/tedx.jpg);">
	<!--<div class="bnnr-cap" style="width:436px; text-align:left; font-size:13px !important;">-->

	<!--	<?php if($_SESSION["sessUserId"]!='' && $_SESSION["sessUserId"]!=0){ ?><a style="background-color:#FFFFFF; color:#00a0af;" href="<?php echo $fullurl;?>cbp.html" class="getstart">Create Business Page</a><?php } ?>-->
	<!--</div>-->
	</div>
	<div class="smb-wrapper">
		<h1><span>   Tedx <?php echo $companNameTitle;?> </span></h1><br>
		<div class="how-benefit">
			<h2>TEDxJMI 2025: A Legacy of Ideas and Impact
			<p>TEDxJMI returns this September after a year-long hiatus, bringing together inspiring voices from diverse backgrounds—artists, changemakers, entrepreneurs, and thought leaders—who share stories of resilience, innovation, and transformation.
</p>

<p>Since its inception in 2011, TEDxJMI has grown into a powerful platform celebrating ideas that matter. With each edition—from intimate beginnings to impactful gatherings featuring renowned speakers like RJ Naved, Sanjay Hegde, and the Nizami Brothers—we’ve fostered a space for bold conversations and meaningful cultural exchange.
</p>
<p>This year, we continue that legacy—igniting reflection, connection, and a renewed belief that every pause is the beginning of something greater.
</p>
			</h2>
			

			 
		</div>
	</div>
</div>
</div>
</div> <!-- [End center content] -->
</div>
</div>
</div>


      </div>
    </div>
  </div>
  <?php include('footer.php');?>
</div>
<script>
<?php

if($_SESSION["d"]==1)
{
?>
showerrormsg('SUCCESS','SME page deleted successfully','');
<?php
$_SESSION["d"]='';
}

?>
</script>
<style type="text/css">
	.evnt-crt-btn.smbcls{display: none !important;}

.popular-artcle1 .artcle-boxp {
    width: 31%;
    float: none;
    margin-right: 18px;
    display: inline-block;
	    margin-bottom: 30px;
}
</style>
</body>
</html>
