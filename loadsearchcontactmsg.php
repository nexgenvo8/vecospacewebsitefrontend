<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$search = clean($_REQUEST['searchtypecontact']);

$msguserid = trim(isset($_REQUEST['msguserid']) && $_REQUEST['msguserid']);


$msguserid = rtrim($msguserid, ',');
if ($msguserid != '') {
	$where = "userId NOT IN(" . $msguserid . ") and";
} else {
	$where = "";
}
?>


<div id="searchcontactmsg" class="searchtagcontact" style="height:226px; top:41px;">
	<ul class="requst-list" id="notice-list" style="display: block;">

		<?php
		$strWhere = '';
		$strWhere .= '';

		if ($search != '') {
			$strWhere .= " and contactId IN(select userId from " . _USERS_MASTER_TABLE_ . " where " . $where . " (firstName like '%" . $search . "%' OR lastName like '%" . $search . "%') ) ";
		}

		$n = 0;
		$selectFields = [];
		$whereFields = [];
		$whereVals = [];

		$sqlLogin = "";
		$sqlLogin = "select * from " . _CONTACT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' " . $strWhere . " and status=1 ";
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
				?>
				<li style="cursor:pointer;"
					onclick="msgthisuser('<?php echo stripslashes(trim($userres["firstName"])); ?> <?php echo stripslashes(trim($userres["lastName"])); ?>','<?php echo $userres['userId']; ?>','<?php echo $search; ?>');">
					<div class="rquest-box">
						<a class="rqst-img"><img
								src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
						<div class="rqst-right">
							<div class="rquest-middle">
								<a><?php echo stripslashes(trim($userres["firstName"])); ?>
									<?php echo stripslashes(trim($userres["lastName"])); ?></a>

								<label><?php echo $userres['jobTitle']; ?> at <?php echo $userres['companyName']; ?></label>
							</div>
						</div>
					</div>
				</li>

				<?php

				$n++;
			}
		}
		?>


	</ul>
	<?php if ($n > 0) { ?>
		<script>
			$("#searchcontactmsgouter").show();
		</script>
	<?php } else { ?>
		<script>
			$("#searchcontactmsgouter").hide();
		</script>
	<?php } ?>
</div>