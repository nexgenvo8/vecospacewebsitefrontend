<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

?>


<?php
$n = 0;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlLogin = "";
/*$sqlLogin="select contactId,chatStatus from "._CONTACT_MASTER_TABLE_." where userId='".$_SESSION['sessUserId']."' and status=1 and contactId IN (SELECT userId FROM "._USERS_MASTER_TABLE_." WHERE firstName LIKE '%".$_REQUEST['chatsearch']."%'  OR lastName LIKE '%".$_REQUEST['chatsearch']."%' ) ORDER BY onlineStatus desc LIMIT 0,10  ";
$resLogin=getRecords(_CONTACT_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlLogin); */

$sqlLogin = "select * from " . _USERS_MASTER_TABLE_ . " where userId IN (select contactId from " . _CONTACT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and status=1) ORDER BY onlineLastUpdate desc LIMIT 0,10  ";
$resLogin = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);

if ($resLogin) {
	while ($rowLogin = mysqli_fetch_array($resLogin)) {

		$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin["userId"] . "";
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
		?>
		<?php if (isset($rowLogin["chatStatus"]) && $rowLogin["chatStatus"] == 1) {
			$usernamefortitle = $userres['firstName'] . ' ' . $userres['lastName'];
		} ?>

		<?php $s = 0; // Initialize ?>
		<div class="chat-cont-user-list <?php if (isset($rowLogin["chatStatus"]) && $rowLogin["chatStatus"] == 1) {
			$s = 1;
			echo 'active';
		} ?>" id="chatlist<?php echo isset($userres['userId']) ? $userres['userId'] : ''; ?>">


			<div class="cover-toltip">
				<div class="user-toltip">
					<div class="img">
						<a
							href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
								src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
					</div>
					<div class="toltip-right">
						<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
							class="nm"><?php echo stripslashes(trim($userres["firstName"])); ?>
							<?php echo stripslashes(trim($userres["lastName"])); ?></a>
						<span class="desig"><?php echo stripslashes(trim($userres["jobTitle"])); ?> at
							<?php echo stripslashes(trim($userres["companyName"])); ?></span>
					</div>
				</div>
			</div>
			<?php if ($userres['onlineStatus'] == 1) { ?>
				<div class="online <?php if ($userres['onlineLastUpdate'] < strtotime("-5 minutes", time())) { ?>standby<?php } ?>">
				</div>
			<?php } else { ?>
				<div class="offline"></div>
			<?php } ?>
			<div class="chat-cont-user-list-img"
				onclick="openuserchatbox('<?php echo encodeStr($userres['userId']); ?>','<?php echo $userres['firstName']; ?> <?php echo $userres['lastName']; ?>','<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html');$('#shb').val('0');">
				<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"
					alt="<?php echo stripslashes(trim($userres["firstName"])); ?> <?php echo stripslashes(trim($userres["lastName"])); ?>"
					title="<?php echo stripslashes(trim($userres["firstName"])); ?> <?php echo stripslashes(trim($userres["lastName"])); ?>">
				<!--<div class="usrnmaeprint" style="width:50px;"><?php echo stripslashes(trim($userres["firstName"])); ?> <?php echo stripslashes(trim($userres["lastName"])); ?></div>-->
			</div>

			<div class="chat-cont-user-list-right">
				<div class="chat-cont-user-list-name"><?php echo stripslashes(trim($userres["firstName"])); ?>
					<?php echo stripslashes(trim($userres["lastName"])); ?>
				</div>
				<!--<div class="chat-cont-user-list-company"><?php echo $userres['companyName']; ?></div>-->

			</div>

		</div>

		<?php

		$n++;
	}

}
?>
<a class="message-fixed" href="<?php echo $fullurl; ?>groups.html"><i class="fa fa-plus"
		aria-hidden="true"></i><br>Group</a>



<?php if (isset($s) && $s == 1) { ?>

	<script>
		$('#mainfriedboxlist').addClass('active'); 
	</script>



<?php } else { ?>
	<script>
		$('#mainfriedboxlist').removeClass('active'); 
	</script>
<?php } ?>

<?php if (isset($usernamefortitle) && $usernamefortitle != '') { ?>

	<script language="javascript">
		var rev = "fwd";
		function titlebar(val) {
			var msg = "<?php echo $usernamefortitle; ?> New Message - <?php echo $companNameTitle; ?>";
			var res = " ";
			var speed = 100;
			var pos = val;
			msg = "   " + msg + "";
			var le = msg.length;
			if (rev == "fwd") {
				if (pos < le) {
					//pos = pos+1;
					// scroll = msg.substr(0,pos);
					//document.title = scroll;
					<?php if ($usernamefortitle != '') { ?>
						timer = window.setTimeout("titlebar(" + pos + ")", speed);
					<?php } ?>
				}
				else {
					rev = "bwd";
					timer = window.setTimeout("titlebar(" + pos + ")", speed);
				}
			}
			else {
				if (pos > 0) {
					pos = pos - 1;
					var ale = le - pos;
					scrol = msg.substr(ale, le);
					document.title = scrol;
					timer = window.setTimeout("titlebar(" + pos + ")", speed);
				}
				else {
					rev = "fwd";
					timer = window.setTimeout("titlebar(" + pos + ")", speed);
				}
			}
		}
		titlebar(0);
	</script>

<?php } else { ?>


<?php }





closeConn($conn);

?>