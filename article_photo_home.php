<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$sql_inss = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND id= " . decodeStr($_REQUEST['postId']) . "  order by id desc";
$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
$rowResults = mysqli_fetch_array($resresults);
$postId = $rowResults["id"];
?>

<script>
	$('#commonloader').hide();
</script>

<?php
$n = 1;
/*if($postId!=0 && is_numeric($postId))
{*/
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlLogin = "";
$sqlLogin = "select * from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $postId . "";
$resLogin = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
if ($resLogin) {
	while ($rowimg = mysqli_fetch_array($resLogin)) {
		?>

		<img src="<?php echo $fullurl; ?>uploads/<?php echo $rowimg['imageName']; ?>"><span class="close"><a
				onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo encodeStr($postId); ?>','removepostimg');"><i
					class="fa fa-times" aria-hidden="true"></i></a></span>
		<?php
		$n++;
	}
}
//}
?>
<?php if ($n == 1) { ?>
	<input name="imagefilehome" id="imagefilehome" type="file"
		onchange="$('#commonloader').show();$('#frmposthomeimg').submit();" style="    position: absolute;
   left: 0%;
   top: 0;
   width: 100%;
   height: 100%;
z-index:9;
opacity:0;
   filter: alpha(opacity=0);
   margin: auto; cursor:pointer;" accept="image/x-png,image/gif,image/jpeg" autocomplete="off">
	<img src="<?php echo $fullurl; ?>images/upload.png">

	<h3>Add a article image</h3>
	<span>Image that are at least 600x350 pixels look best</span>

<?php } ?>