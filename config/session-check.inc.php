<?php
if(!isset($_SESSION["sessUserId"]) || $_SESSION["sessUserId"]=='' || $_SESSION["sessUserId"]==0 || !is_numeric($_SESSION["sessUserId"]))
{
	
	$_SESSION['loginredirecturl']=$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];


	header("location:".$fullurl."");
	exit();
}
?>