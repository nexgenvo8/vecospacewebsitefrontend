<?php
include_once('inc.php');
$_SESSION['loginredirectpageurl'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 11;
$ptab = 3;
$aaView = "SELECT projectTitle FROM " . _PROJECT_MASTER_TABLE_ . " WHERE id=" . intval(decodeStr($_REQUEST['projId']));
$res5View = mysqli_query($conn, $aaView) or die(error_found(mysqli_error($conn)));
$projectView = mysqli_fetch_array($res5View);


if ($_GET["cuid"] != '') {
	$strusrid = '?cuid=' . $_GET["cuid"] . '&t=' . $_GET["t"];
}
$projectTitle = substr(cleanInput(strip_tags(trim(strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '-', $projectView['projectTitle'])))))), 0, 100);
header("Location:" . $fullurl . 'project/' . $_REQUEST["projId"] . "/" . $projectTitle . ".html" . $strusrid . "");

?>