<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session

if($_GET['userId']!='')
{
 $_SESSION['useractivity']=decodeStr($_GET['userId']);
}
else
{
 $_SESSION['useractivity']=$_SESSION['sessUserId'];
}

		$selectFields =[];
		$whereFields =[];
		$whereVals =[];
	
		$sqlLogin="";
		$sqlLogin="select firstName,lastName from "._USERS_MASTER_TABLE_." where userId='".decodeStr($_GET['userId'])."' ";
		$resLogin=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlLogin); 	
		if($resLogin)
		{
			while($rowLogin=mysqli_fetch_array($resLogin))
			{
				$myfirstName=$rowLogin["firstName"];
				$mylastName=$rowLogin["lastName"];	
				$myname=ucfirst($rowLogin["firstName"]).' '.ucfirst($rowLogin["lastName"]);	
				
			}
		}
		
		if($_GET['userId']!='')
		{
			$sql="SELECT * from "._USER_SETTINGS_MASTER_TABLE_." WHERE userId= ".decodeStr($_GET['userId'])." "; 
			$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn))); 		
			$getUserSettings=mysqli_fetch_array($getSql);
		
		}
		
		if($getUserSettings["activityTabVisible"]=="Nobody"){
		
		  header('Location:'.$fullurl.'');
		  exit();
		}
		
		if($getUserSettings["activityTabVisible"]=="My contacts only"){
		
		
			$sql="SELECT userId from "._CONTACT_MASTER_TABLE_." WHERE userId= ".decodeStr($_GET['userId'])." and contactId=".$_SESSION['sessUserId']." and status=1 "; 
			$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn))); 		
			$getUserSettingsContactVisible=mysqli_fetch_array($getSql);
			
			if($getUserSettingsContactVisible["userId"]!='')
			{
			  $redirect=1;
			}
		}
		
		if($redirect!=1 && $getUserSettings["activityTabVisible"]!="All members")
		{
		  header('Location:'.$fullurl.'');
		  exit();		  
		}
?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $myname;?>'s Activity - <?php echo $companNameTitle;?></title>
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
     
    <div class="home_container">
      <?php include('left-sidebar.php');?>
      <div class="center_content">
        <div class="cntr_cntnt">

<div class="all-activity">
<h2><?php echo $myname;?>'s College Action</h2>
<ul class="cntr_tab">
  <li><a href="<?php echo $fullurl;?>user-activity.html?userId=<?php echo $_GET['userId'];?>&view=1" class="<?php if($_REQUEST['view']=='1'){ echo 'active';}?>">Highlight</a></li>
  <li><a href="<?php echo $fullurl;?>user-activity.html?userId=<?php echo $_GET['userId'];?>&view=2" class="<?php if($_REQUEST['view']=='2'){ echo 'active';}?>">Stories</a></li>
 </ul>
</div>
<div id="loadtimeline1">
			  Loading...
               </div>
</div>
        <?php include('right-sidebar.php');?>
      </div>
    </div>
  </div>
  <?php include('footer.php');?>
</div>

<script>
loadtimelineActivitfun(1,0,20,<?php if($_REQUEST['view']==''){ echo '0';}else{ echo $_REQUEST['view'];}?>);

function postlikeunlike(id)
{
 var color1='rgb(255, 120, 0)';
 var color2='rgb(128, 128, 128)';
 var crname=$('#thumbid'+id).css('color');
 if(crname==color1)
	{
	$('#thumbid'+id).css('color',color2);
	}
	else
	{
	$('#thumbid'+id).css('color',color1);
	}
}
</script>
</body>
</html>
