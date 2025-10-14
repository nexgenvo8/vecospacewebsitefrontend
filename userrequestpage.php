<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session
?>
<!DOCTYPE html>
<html>
<head>
<title>User requests - <?php echo $companNameTitle;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/style.css">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
  
<link rel="icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
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
        <div class="cntr_cntnt" style="background-color:#fff; border-radius:4px; ">

<div class="all-activity">
<h2>User requests</h2>

</div>
<div>
  <ul class="requst-list" id="notice-list">

 <?php
		  $n=0;
		$selectFields =[];
		$whereFields =[];
		$whereVals =[];
	
		$sqlLogin="";
		$sqlLogin="select * from "._CONTACT_MASTER_TABLE_." where userId='".$_SESSION['sessUserId']."' and status=0 ";
		$resLogin=getRecords(_CONTACT_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlLogin); 	
		if($resLogin)
		{
			while($rowLogin=mysqli_fetch_array($resLogin))
			{
			
			$a="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= ".$rowLogin["contactId"]."";
			$b=mysqli_query($conn, $a) or die(mysqli_error($conn)); 
			$userres=mysqli_fetch_array($b); 
											
			$friendnameurl=$userres['userurl'];
			if($userres["profilePhoto"]!='')
			{
			$userphoto=$userres["profilePhoto"];
			} else {
			$userphoto='user-placeholder.jpg';
			}		
			
			$mycountryName=$userres["countryName"];			  
			$mystateName=$userres["cityName"];
			$mylocationName=$userres["locationName"];	
			$mycompanyName=$userres["companyName"];	  
			$myjobTitle=$userres["jobTitle"];


	  ?>
	  
	  
<li>
        <div class="rquest-box">
         <a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($userres['userId']);?>/<?php echo $friendnameurl; ?>.html" target="_blank" class="rqst-img"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($userphoto));?>"></a>
         <div class="rqst-right"><a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($userres['userId']);?>/<?php echo $friendnameurl; ?>.html" target="_blank"><?php echo stripslashes(trim($userres["firstName"]));?> <?php echo stripslashes(trim($userres["lastName"]));?></a>
         <label><?php //if($mylocationName){ echo $mylocationName.',';}?> <?php //echo $mystateName;?> <?php echo $myjobTitle;?><?php if($mycompanyName!=''){ echo '- '.$mycompanyName;}?></label>
         </div>
        <div class="add-frnd">
           <a href="common_action.php?userId=<?php echo encodeStr($userres['userId']);?>&action=act" target="actionfrm">Connect </a>
           <a href="common_action.php?userId=<?php echo encodeStr($userres['userId']);?>&action=dec" target="actionfrm" class="dlt">Decline</a>
         </div>
        </div>
      </li>
	  
	  
 

 <?php
		   
		 $n++;  }
		   
		   }
		  ?>
 
 </ul>
 <?php
if($n==0)
{
?>
 <div style="padding:20px; text-align:center; overflow:hidden;">No Request Pending</div>
 <?php 
 } 
 ?>
 </div>
</div>
        <?php include('right-sidebar.php');?>
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
