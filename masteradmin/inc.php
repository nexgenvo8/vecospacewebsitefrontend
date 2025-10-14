<?php
session_start();

include("lib/conn.php");
include("config/database.php");

$companNameTitle='JMI VECOSPACE';

function cleanInput($input) {
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );
    $output = preg_replace($search, '', $input);
    return $output;
}

function encodeStr($str)
{
$finalenc=$str+202565517;

//$str=base64_encode(base64_encode($str));
  return $finalenc;
}

function decodeStr($str)
{
$finalenc=$str-202565517;
//$str=base64_decode(base64_decode($str));
  return $finalenc;
}
function makeContentUrl($contentText)
{
	$url='-';
	
	if(trim($contentText)!='')
		$url=strtolower(trim(preg_replace("/[\s-]+/", "-", preg_replace( "/[^a-zA-Z0-9\-]/", '-', $contentText)),"-"));
	
	return $url;
}
if($_SESSION['username']=="")
{
header("location:login.php");
}
//error_reporting(0);

 
/*-------------------------------Profile Update-----------------------*/




if($_REQUEST['profile']=="profile")
{
$name=($_REQUEST['name']);
$company=($_REQUEST['company']);	
$email=($_REQUEST['email']);	

$sql_ins="update wfs_admin set name='$name',company='$company',email='$email' where id='1'";
mysql_query($sql_ins) or die(mysql_error());

$url=$_SERVER['REQUEST_URI'];


}




/*-------------------------------Password Update-----------------------*/

define(_CKFINDER_PATH_, CONST_SURL . 'ckeditor/ckfinder/');
?>