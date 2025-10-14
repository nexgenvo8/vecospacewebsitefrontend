<?php 
//error_reporting(0);
include "citycode.php";
if($lcode!=''){ 
$citycode= $lcode;
} else {
$citycode= 'INXX0038:1:IN';
}
$cityname= 'New Delhi';
include "function.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title>Weather</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<link href="css/style.css" rel="stylesheet" type="text/css" />
 
</head>

<body  style="background-image:url(<?php  echo $foldername.$videoimage=getvideo($homewetherstatus[0]); ?>);  background-size: auto 100%;">
<div id="wrap">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" style="position:absolute; left:0px; height:0px; width:100%; height:100%;">
  <tr>
    <td height="75%"  style="-moz-user-select: none; -webkit-user-select: none; -ms-user-select:none; user-select:none;-o-user-select:none;" 
 unselectable="on"
 onselectstart="return false;" 
 onmousedown="return false;" ><div id="vdocontainer" style="height:100%;">
 <div id="statusboxhome"><table width="100%" border="0" cellpadding="2" cellspacing="0">
  <tr>
    <td align="center"><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="middle"  id="sname"><?php  echo $homewetherstatus[0]; ?></td>
    <td valign="middle">&nbsp;&nbsp;&nbsp;</td>
 
    </tr>
</table></td>
  </tr>
</table>



</div>
       
		
		<!--<div id="homeareabox">
		<h1><?php echo $cityname; ?></h1>
		<div id="dateandtimehome">Just Now, <?php echo $new_date = date('j F Y', strtotime(date('Y-m-d'))); ?></div>
		</div>-->
 		<div id="hometempraturemain">
		<div id="round"></div>
		</div>
		<div id="wetherhomeiconimg">
		
		</div>
		<div id="dirdigit"><?php  echo $homewetherstatus[0]; ?> </div>
  </div></td>
 
  </tr>
  <tr>
    <td height="25%"  >

  
  <div id="tabscontainer" style="height:101%;">
    <div class="threetabs">
    	<div class="tday"><?php  echo $todaybox[0]; ?></div>
        <div class="tico"><img src="images/cloud.png" width="140" height="121" /></div>
        <div class="ttemp"><?php  echo $todaybox[0]; ?></div>
    </div></div></div>
    <div class="threetabs" style="background-color:#3e71a1;">
    	<div class="tday"><?php  echo $nextdaybox[0]; ?></div>
        <div class="tico"><img src="images/cloud.png" width="140" height="121" /></div>
        <div class="ttemp"><?php  echo $nextdaybox[0]; ?></div>
    </div> </div> </div>
    <div class="threetabs" style="background-color:#447db2;">
    	<div class="tday"><?php  echo $thirddaybox[0]; ?></div>
        <div class="tico"><img src="images/cloud.png" width="140" height="121" /></div>
        <div class="ttemp"><?php  echo $thirddaybox[0]; ?></div>
    </div>
</div> 
    	</td>
 
  </tr>
</table>
 
 


<div id="movingcludeouter" style="top:73px;">
<div id="divcenter">
		<img src="<?php  echo  $showimage=$foldername.getbigicon($homewetherstatus[0]); ?>"/>
		 
  </div>
</div>



 
</div>
</body>
</html>
