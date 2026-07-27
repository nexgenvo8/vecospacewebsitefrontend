<?php
include_once('inc.php');
$pageIndex = 10;



if ($_REQUEST['eventId'] != '' && $_REQUEST['status'] != '') {
	$eventId = decodeStr($_REQUEST['eventId']);
	$status = trim($_REQUEST['status']);

	/* $sql_ins = "DELETE FROM " . _EVENT_GUEST_MASTER_TABLE_ . " WHERE eventId= " . intval($eventId) . " AND userId=" . intval($_SESSION["sessUserId"]);
	
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn)); */

	$a = "INSERT INTO " . _EVENT_GUEST_MASTER_TABLE_ . " SET userId=" . intval($_SESSION["sessUserId"]) . ", eventId=" . intval($eventId) . ", status=" . intval($status) . ", dateAdded=" . time();
	
	
	mysqli_query($conn, $a) or die(mysqli_error($conn));

	/*header('Location:events-detail.html?eventId='.$_REQUEST['eventId'].'');
	exit();*/
}

$sqlEvents = "SELECT eventName FROM " . _EVENT_MASTER_TABLE_ . " WHERE id= " . intval(decodeStr($_REQUEST['eventId']));
$resEvents = mysqli_query($conn, $sqlEvents) or die(error_found(mysqli_error($conn)));
$rowEvents = mysqli_fetch_array($resEvents);
$eventName = substr(cleanInput(strip_tags(trim(strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '-', $rowEvents['eventName'])))))), 0, 100);

header("Location:" . $fullurl . 'events/' . $_REQUEST["eventId"] . "/" . $eventName . ".html");
?>