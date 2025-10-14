<?php
include_once('inc.php');
$pageIndex = 8;

if ($_REQUEST['companyId'] != '' && $_REQUEST['status'] != '') {
	$companyId = decodeStr($_REQUEST['companyId']);
	$status = trim($_REQUEST['status']);

	if ($status == 2) {
		$sql_ins = "DELETE FROM " . _COMPANY_FOLLOWERS_TABLE_ . " WHERE companyId= " . $companyId . "  and userId=" . $_SESSION["sessUserId"] . "  ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	} else {
		$a = "insert into " . _COMPANY_FOLLOWERS_TABLE_ . " set userId=" . $_SESSION["sessUserId"] . ",companyId=" . $companyId . ",dateAdded=" . time() . "";
		mysqli_query($conn, $a) or die(mysqli_error($conn));


	}

}

$sqlCompany = "select id,companyName from " . _COMPANY_MASTER_TABLE_ . " where id= " . decodeStr($_REQUEST['companyId']) . " and companyName!=''  ";
$resSqlCompany = mysqli_query($conn, $sqlCompany) or die(error_found(mysqli_error($conn)));
$rowSqlCompany = mysqli_fetch_array($resSqlCompany);

$companyName = substr(cleanInput(strip_tags(trim(strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '-', $rowSqlCompany['companyName'])))))), 0, 100);
header("Location:" . $fullurl . 'corporate-connect/' . $_REQUEST["companyId"] . "/" . $companyName . ".html");

?>