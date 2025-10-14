<?php
include_once('inc.php');
$pageIndex = 7;

$aa = "SELECT name from " . _VAULT_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['id']) . " ";
$res5 = mysqli_query($conn, $aa) or die(error_found(mysqli_error($conn)));
$articletext = mysqli_fetch_array($res5);

if ($_GET["cuid"] != '') {
	$strusrid = '?cuid=' . $_GET["cuid"] . '&t=8';
}
$postTitle = substr(cleanInput(strip_tags(trim(strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '-', $articletext['name'])))))), 0, 100);
header("Location:" . $fullurl . 'downloads/' . $_REQUEST["id"] . '/' . $_REQUEST["uid"] . "/" . $postTitle . ".html" . $strusrid . "");

?>