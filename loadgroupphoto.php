<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session


$sql_inss = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND postType=0 order by id desc";
$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
$rowResults = mysqli_fetch_array($resresults);
$postId = $rowResults["id"];
?>

<script>
	$('#commonloader').hide();
</script>


<ul class="upld-img-list upload">
	<?php

	if ($postId != 0 && is_numeric($postId)) {
		$selectFields = [];
		$whereFields = [];
		$whereVals = [];

		$sqlLogin = "";
		$sqlLogin = "select * from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $postId . "";
		$resLogin = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
		if ($resLogin) {
			while ($rowimg = mysqli_fetch_array($resLogin)) {
				?>

				<li style="display:block;"><img src="<?php echo $fullurl; ?>uploads/<?php echo $rowimg['imageName']; ?>"><span
						class="close"><a
							href="<?php echo $fullurl; ?>common_action.php?postId=<?php echo encodeStr($postId); ?>&action=removegrouppostimg"
							target="actionfrm"><i class="fa fa-times" aria-hidden="true"></i></a></span></li>
				<?php
			}
		}

	}
	?>



</ul>