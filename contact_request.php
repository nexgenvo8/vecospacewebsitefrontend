<?php
include_once('inc.php');
include_once('config/session-check.inc.php');

?>

<span class="list-heding">Request Pending</span>





<?php
$n = 0;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlLogin = "";
$sqlLogin = "select * from " . _CONTACT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and status=0 ";
$resLogin = getRecords(_CONTACT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
if ($resLogin) {
	while ($rowLogin = mysqli_fetch_array($resLogin)) {

		$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin["contactId"] . "";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$userres = mysqli_fetch_array($b);

		$friendnameurl = $userres['userurl'];
		if ($userres["profilePhoto"] != '') {
			$userphoto = $userres["profilePhoto"];
		} else {
			$userphoto = 'user-placeholder.jpg';
		}

		$mycountryName = $userres["countryName"];
		$mystateName = $userres["cityName"];
		$mylocationName = $userres["locationName"];
		$mycompanyName = $userres["companyName"];
		$myjobTitle = $userres["jobTitle"];


		?>


		<li>
			<div class="rquest-box">
				<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
					target="_blank" class="rqst-img"><img
						src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
				<div class="rqst-right"><a
						href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
						target="_blank"><?php echo stripslashes(trim($userres["firstName"])); ?>
						<?php echo stripslashes(trim($userres["lastName"])); ?></a>
					<label><?php //if($mylocationName){ echo $mylocationName.',';} ?> 		<?php //echo $mystateName; ?>
						<?php echo $myjobTitle; ?> 		<?php if ($mycompanyName != '') {
										echo '- ' . $mycompanyName;
									} ?></label>
				</div>
				<div class="add-frnd">
					<a href="common_action.php?userId=<?php echo encodeStr($userres['userId']); ?>&action=act"
						target="actionfrm">Connect </a>
					<a href="common_action.php?userId=<?php echo encodeStr($userres['userId']); ?>&action=dec"
						target="actionfrm" class="dlt">Decline</a>
				</div>
			</div>
		</li>




		<?php

		$n++;
	}

}
?>




<?php
if ($n == 0) {
	?>
	<div style="padding:20px; text-align:center; overflow:hidden;">No Request Pending</div>
	<?php
} else {
	?>

<?php } ?>