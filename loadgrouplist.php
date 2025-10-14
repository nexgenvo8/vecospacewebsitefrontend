<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session


$n = 0;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlGroupMembers = "";
$sqlGroupMembers = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " and status=1 order by id desc";
$resGroupMembers = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
if ($resGroupMembers) {
	while ($rowgroup = mysqli_fetch_array($resGroupMembers)) {

		$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $rowgroup["groupId"] . "";
		$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
		$row = mysqli_fetch_array($resgroup);

		if ($row["groupThumb"] != '') {
			$groupThumb = $row["groupThumb"];
		} else {
			$groupThumb = 'group.png';
		}
		if ($row["userId"] != '') {
			$a = "SELECT firstName,lastName from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $row["userId"] . "";
			$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
			$groupuser = mysqli_fetch_array($b);

			if ($row['groupType'] == 1) {


				$totalm = "SELECT * from " . _GROUP_GOT_MSG_TABLE_ . " where groupId=" . $rowgroup["groupId"] . " and userId='" . $_SESSION["sessUserId"] . "' and status=0";
				$retotalm = mysqli_query($conn, $totalm) or die(mysqli_error($conn));
				$mytotalgroupsmsg = mysqli_num_rows($retotalm);
				?>
				<a href="<?php echo $fullurl; ?>private-group.html?groupId=<?php echo encodeStr($row['id']); ?>">

					<li style="border-bottom:1px #ccc solid;" <?php if ($row['id'] == decodeStr($_REQUEST['groupId'])) {
						echo 'class="active"';
					} ?>>
						<div class="frfl-img" style="float:none; border-bottom:px #CCCCCC solid;">
							<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>" border="0">

							<strong><?php echo stripslashes($row['groupName']); ?></strong>
							<span style="color:#666666;">By
								<?php if ($row["userId"] == $_SESSION["sessUserId"]) {
									echo 'Me';
								} else {
									echo stripslashes($groupuser["firstName"]); ?>
									<?php echo stripslashes($groupuser["lastName"]);
								} ?></span>
							<?php if ($mytotalgroupsmsg > 0 && $row['id'] != decodeStr($_REQUEST['groupId'])) { ?>
								<span class="tltp"
									id="groupnewmsgcount<?php echo $rowgroup["groupId"]; ?>"><?php echo $mytotalgroupsmsg; ?></span>
							<?php } ?>


						</div>
					</li>
				</a>

				<?php
			}
		}
	}
} ?>