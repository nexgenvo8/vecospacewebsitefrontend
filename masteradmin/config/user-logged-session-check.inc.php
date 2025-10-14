<?php
if(isset($_SESSION["sessUserId"]) || $_SESSION["sessUserId"]!='' || $_SESSION["sessUserId"]!=0 || is_numeric($_SESSION["sessUserId"]))
{
	header("location:".$fullurl."timeline.html");
	exit();
}
?>