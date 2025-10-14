<?php
include_once('inc.php');

if ($_GET['action'] == 'subindustry') {
	header("Content-Type: text/html; charset=utf-8");
	error_reporting(0);

	$industryId = intval($_GET['industryId'] ?? 0);
	$selectedid = intval($_GET['selectedid'] ?? 0);

	echo '<option value="">Select Sub Category</option>';

	if ($industryId > 0) {
		$sql = "SELECT id, optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='subindustry' AND subindustryId='" . $industryId . "' ORDER BY optionName";
		$res = mysqli_query($conn, $sql);

		if ($res) {
			while ($row = mysqli_fetch_assoc($res)) {
				$selected = ($selectedid == $row['id']) ? 'selected="selected"' : '';
				echo "<option value='{$row['id']}' {$selected}>{$row['optionName']}</option>";
			}
		}
	}
	exit; // VERY IMPORTANT: prevents extra HTML output
}
?>