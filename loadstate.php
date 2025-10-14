<?php
include_once('inc.php');

$countryId = intval($_REQUEST['countryId']);
$statename = $_REQUEST['statename'] ?? '';

echo '<option value="">Select State</option>';

if ($countryId > 0) {
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlOptions1 = "SELECT * FROM " . _STATE_MASTER_TABLE_ . " WHERE country_id='$countryId' ORDER BY name";
	$resOptions1 = getRecords(_STATE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);

	if ($resOptions1) {
		while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
			$strSelected = ($statename == $rowOptions1['name']) ? 'selected="selected"' : "";
			echo '<option value="' . trim($rowOptions1['name']) . '" ' . $strSelected . '>' . trim($rowOptions1['name']) . '</option>';
		}
	}
}
?>