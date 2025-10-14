<?php
include_once('inc.php'); 


if($_REQUEST['action']=='joingroup' && $_REQUEST['groupId']!='')
{

$_SESSION['sesgroupId']=decodeStr(decodeStr($_REQUEST['groupId']));

header('Location:timeline.html');

}



?>