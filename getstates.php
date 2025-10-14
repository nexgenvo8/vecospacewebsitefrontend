<?php
include_once('inc.php');
$countryId = $_REQUEST['countryId'];
$statename = $_REQUEST['statename'];
if ($countryId == '') {
	$countryId = 0;
}

?>
<option value="">Select</option>
<?php
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlOptions1 = "";
$sqlOptions1 = "SELECT * FROM " . _STATE_MASTER_TABLE_ . " WHERE country_id='" . $countryId . "' ORDER BY name ";
$resOptions1 = getRecords(_STATE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
if ($resOptions1) {
	while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
		if ($statename == $rowOptions1['id']) {
			$strSelected = 'selected="selected"';
		} else {
			$strSelected = "";
		}
		?>
		<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>>
			<?php echo trim($rowOptions1['name']); ?>
		</option>
		<?php
	}
}
?>