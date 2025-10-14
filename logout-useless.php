<?php 
include_once('inc.php'); // contains all the functions used in the application

$sql_ins="UPDATE "._USERS_MASTER_TABLE_." SET onlineStatus=0 where userId='".$_SESSION['sessUserId']."'";
mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

$sql_ins="UPDATE "._CONTACT_MASTER_TABLE_." SET onlineStatus=0 where userId='".$_SESSION['sessUserId']."'";
mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


$sql_ins="UPDATE "._CONTACT_MASTER_TABLE_." SET onlineStatus=0 where contactId='".$_SESSION['sessUserId']."'";
mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


unset($_SESSION["sessFname"]);

unset($_SESSION["sessFullName"]);

unset($_SESSION["sessEmail"]);

unset($_SESSION["sessUserId"]);

unset($_SESSION['loginredirecturl']);

unset($_SESSION['groupjoiningurl']);

session_destroy();

header("location:".$fullurl.""); 
?>