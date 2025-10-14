<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session
$ps=1;
?>
<!DOCTYPE html>
<html>
<head>
<title>My Ads - <?php echo $companNameTitle;?></title>
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
      <?php include('left-sidebar.php');?>
<div class="center_content">
<div class="setting" id="settingpage">
  <div class="myads-cont">
   <div class="adshead"> <h2>Published Ads</h2> <a onClick="createadwindow('','1');" class="btn">+ &nbsp; Create</a></div>

<ul class="adlist">
  <li>
    <div class="head">
      <ul class="adsrowlist">
        <li class="posts">Posts</li>
        <li class="type">Type</li>
        <li class="reach">Reach</li>
        <li class="click">Clicks</li>
        <li class="published">Published</li>
        <li class="status">Status</li>
      </ul>
    </div>
  </li>
  <?php 
		$selectFields =[];
		$whereFields =[];
		$whereVals =[];
		$n=1;
		$sqlEvents="";
		$sqlEvents="select * from "._AD_POST_MASTER_TABLE_." where userId=".$_SESSION["sessUserId"]." order by id desc   ";
		$resEvents=getRecords(_AD_POST_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysqli_fetch_array($resEvents))
			{
				$sql_inss="SELECT views from "._SHAREANDUPDATES_TABLE_." WHERE adId= ".$rowEvents["id"]." and adType=".$rowEvents["adType"]." ";
				$resresults=mysqli_query($conn, $sql_inss) or die(mysqli_error($conn)); 
				$rowResults=mysqli_fetch_array($resresults); 
			?>
  <li>
      <ul class="adsrowlist">
        <li class="posts">
            <a href="#" class="ttl"><?php echo stripslashes($rowEvents["postTitle"]);?></a>
        </li>
        <li class="type"><?php  if($rowEvents["adType"]==1){ echo "Events";} if($rowEvents["adType"]==2){ echo "PROjects";} if($rowEvents["adType"]==3){ echo "SMB Connect";} if($rowEvents["adType"]==4){ echo "Talent Connect";} if($rowEvents["adType"]==5){ echo "Jobs";}?></li>
        <li class="reach"><?php echo stripslashes($rowResults["views"]);?></li>
        <li class="click">10</li>
        <li class="published"><?php echo date("m-d-Y h:i A",$rowEvents["dateAdded"]);?></li>
        <li class="status"><?php if($rowEvents["status"]==1 && $rowEvents["viewStatus"]==1){ echo "Active";}else{ echo "In-Active";}?></li>
		
      </ul>
  </li>
  <?php $n++;
   		}
  }
  ?>
  
</ul>
<?php if($n==1){?>
   <div class="no-post">No Ad Available</div>
   <?php }?>
  </div>
</div>
</div>
    </div>
  </div>
  <?php include('footer.php');?>
</div>




</body>
</html>
