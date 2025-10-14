<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$search = isset($_GET['searchmsgcontacts']) ? trim($_GET['searchmsgcontacts']) : "";
if ($search != '') {
	$strWhere = "and (firstName like '%" . $search . "%' OR lastName like '%" . $search . "%') ";
} else {
	$strWhere = "";
}
?>


<?php
$s = "";
if (!empty($searchmsgcontacts)) {
	$s = mysqli_real_escape_string($conn, $searchmsgcontacts);
}
$n = 0;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlMessage = "";
//$sqlMessage="select * from "._CHAT_MASTER_TABLE_." where userId='".$_SESSION['sessUserId']."' GROUP BY contactId ORDER BY id DESC  ";

$sqlMessage = "select * from " . _USERS_MASTER_TABLE_ . " where userId IN (select contactId from " . _CHAT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "') GROUP BY userId ORDER BY onlineLastUpdate DESC  ";

$resMessage = getRecords(_CHAT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlMessage);
if ($resMessage) {
	while ($rowMessage = mysqli_fetch_array($resMessage)) {

		$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowMessage["userId"] . " " . $strWhere . " ";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$userres = mysqli_fetch_array($b);

		$ac = "SELECT * from " . _CHAT_MASTER_TABLE_ . " WHERE userId= " . $rowMessage["userId"] . " order by id desc ";
		$bcc = mysqli_query($conn, $ac) or die(mysqli_error($conn));
		$chat = mysqli_fetch_array($bcc);

		$friendnameurl = '';
		$userphoto = 'user-placeholder.jpg';
		$mycountryName = '';
		$mystateName = '';
		$mylocationName = '';

		if (!empty($userres) && is_array($userres)) {
			$friendnameurl = $userres['userurl'] ?? '';

			if (!empty($userres["profilePhoto"])) {
				$userphoto = $userres["profilePhoto"];
			}

			$mycountryName = $userres["countryName"] ?? '';
			$mystateName = $userres["cityName"] ?? '';
			$mylocationName = $userres["locationName"] ?? '';
		}

		if (isset($userres["firstName"]) && $userres["firstName"] != '') {

			?>
			<li>
				<div class="chat-cont-user-list <?php if (isset($rowMessage['chatStatus']) && $rowMessage['chatStatus'] == 1) {
					$s = 1; ?>active1<?php } ?>" id="chatlist<?php echo isset($userres['userId']) ? $userres['userId'] : ''; ?>"
					onclick="openuserchatbox('<?php echo isset($userres['userId']) ? encodeStr($userres['userId']) : ''; ?>');
					$('#msgchat').show(); $('.chat_list').show(); $('#header').show(); $('.container.main').css('padding-top','52px');">

					<?php if ($userres['onlineStatus'] == 1) { ?>
						<div
							class="online <?php if ($userres['onlineLastUpdate'] < strtotime('-5 minutes', time())) { ?>standby<?php } ?>">
						</div>
					<?php } else { ?>
						<div class="offline"></div>
					<?php } ?>

					<div class="chat-cont-user-list-img">
						<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>">
					</div>

					<div class="chat-cont-user-list-right">
						<div class="chat-cont-user-list-name">
							<?php echo stripslashes(trim($userres["firstName"])); ?>
							<?php echo stripslashes(trim($userres["lastName"])); ?>
						</div>
						<div class="chat-cont-user-list-company">
							<?php echo strip_tags(showsmily($chat["chatText"])); ?>
						</div>
					</div>
				</div>
			</li>

			<?php
		}
		$n++;
	}

}
?>



<?php if ($s == 1) { ?>
	<script>
		$('#mainfriedboxlist').addClass('active1');
		$('.chat_list').show(); $('#header').show(); $('.container.main').css('padding-top', '52px');

	</script>

<?php } else { ?>
	<script>
		//$('#mainfriedboxlist').removeClass('active1'); 
	</script>
<?php } ?>