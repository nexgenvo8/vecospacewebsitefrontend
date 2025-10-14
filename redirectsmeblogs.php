<?php
include_once('inc.php'); 
$pageIndex=7;

$aa="SELECT postTitle from "._SHAREANDUPDATES_TABLE_." WHERE id= ".decodeStr($_REQUEST["postId"])." ";
$res5 = mysqli_query($conn, $aa) or die(error_found(mysqli_error($conn))); 
$articletext=mysqli_fetch_array($res5);
$postTitle=substr(cleanInput(strip_tags(trim(strtolower(str_replace(' ','-',preg_replace('/[^A-Za-z0-9\-]/', '-', $articletext['postTitle'])))))),0,100);
header("Location:".$fullurl.'sme-blogs/'.$_REQUEST["postId"]."/".$postTitle.".html");

?>