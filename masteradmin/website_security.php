<?php ob_start();
$sesId=session_id();

$ors_cus_sess_login_status=isset($_SESSION['ors_cus_sess_login_status'])?$_SESSION['ors_cus_sess_login_status']:'';
$ors_cus_sess_customer_id=isset($_SESSION["ors_cus_sess_customer_id"])?$_SESSION["ors_cus_sess_customer_id"]:'';

if($ors_cus_sess_login_status!=session_id()."_".$ors_cus_sess_customer_id."_login"){
$_SESSION['ors_cus_sess_ackmsg']="Please login first";
header("location:logout.php");
exit();
}

$PageViewRestrict='1';
?>