<?php
include_once('inc.php');
$pageIndex = 7;
$_SESSION['loginredirectpageurl'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
$aa = "SELECT postTitle,articleBlogStatus,userId from " . _SHAREANDUPDATES_TABLE_ . " WHERE id= " . decodeStr($_REQUEST["postId"]) . " ";
$res5 = mysqli_query($conn, $aa) or die(error_found(mysqli_error($conn)));
$articletext = mysqli_fetch_array($res5);
if ($articletext['articleBlogStatus'] == 1) {
	$pageredir = "sme-blogs/";
	if ($_GET["cuid"] != '') {
		$strusrid = '?cuid=' . $_GET["cuid"] . '&t=5';
	}
} else {
	$pageredir = "articles-and-trivia/";

	if ($_GET["cuid"] != '') {
		$strusrid = '?cuid=' . $_GET["cuid"] . '&t=4';
	}
}


$postTitle = substr(cleanInput(strip_tags(trim(strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '-', $articletext['postTitle'])))))), 0, 100);
header("Location:" . $fullurl . $pageredir . $_REQUEST["postId"] . "/" . $postTitle . ".html" . $strusrid . "");

?>