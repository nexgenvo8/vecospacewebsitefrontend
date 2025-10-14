<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 6;


$sql = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['groupId']) . " ";
$res = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
$row = mysqli_fetch_array($res);
$title = substr(cleanInput(strip_tags(trim(strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '-', $row['groupName'])))))), 0, 100);
header("Location:" . $fullurl . 'groups/' . $_REQUEST["groupId"] . "/" . $title . ".html");
?>