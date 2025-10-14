<?php
 $sql3="select * from wfs_admin  where username='".$_SESSION['username']."'";
$rs3=mysql_query($sql3) or die(mysql_error());
$profile=mysql_fetch_array($rs3);

$websiteurl='http://jmi.vecospace.com/';


?>