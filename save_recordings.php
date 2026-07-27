<?php
include_once('inc.php');
include_once('config/session-check.inc.php');

$dir = "uploads/recordings/";

if(!is_dir($dir)){
    mkdir($dir,0777,true);
}

$name = time().'_'.$_FILES['recording']['name'];
$path = $dir.$name;

move_uploaded_file($_FILES['recording']['tmp_name'], $path);

$url = $fullurl.$path; // important: full public link

echo json_encode([
    "status"=>"success",
    "link"=>$url
]);
exit;
?>
