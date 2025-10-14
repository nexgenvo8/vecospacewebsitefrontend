<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$image = $_POST['image'];

list($type, $image) = explode(';',$image);
list(, $image) = explode(',',$image);

$image = base64_decode($image);
$image_name = time().'.png';

file_put_contents('uploads/'.$image_name, $image);
file_put_contents('uploads/'.'x_'.$image_name, $image);

if($_POST['oldprofilePhoto']!='')
{
    unlink("uploads/".$_POST["oldprofilePhoto"]);
    unlink("uploads/".'x_'.$_POST["oldprofilePhoto"]);
}

$sql_ins="update "._USERS_MASTER_TABLE_." set profilePhoto='$image_name' where userId= ".$_SESSION["sessUserId"]."";
mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

echo 'successfullyUpload ';

?>