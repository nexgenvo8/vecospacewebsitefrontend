<?php
ob_start();
include_once('inc.php');  

$url=$_REQUEST["url"];
$adId=$_REQUEST["id"];
$adType=$_REQUEST["adType"];

$sql_inss="SELECT clicks from "._SHAREANDUPDATES_TABLE_." WHERE adId='".$adId."' and adType='".$adType."' ";
  $resresults=mysqli_query($conn, $sql_inss) or die(mysqli_error($conn)); 
    $rowResults=mysqli_fetch_array($resresults); 

$clicks=$rowResults["clicks"]+1;

 $sql_ins="update "._SHAREANDUPDATES_TABLE_." set clicks=".$clicks." WHERE adId='".$adId."' and adType='".$adType."' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


header('Location:'.$url.'');
exit()
?>