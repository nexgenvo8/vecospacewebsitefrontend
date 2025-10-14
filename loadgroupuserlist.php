<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$n = 0;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlGroupMembers = "";
$sqlGroupMembers = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . decodeStr($_REQUEST["id"]) . " and status=1 and userStatus=0 order by id desc ";
$resGroupMembers = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
if ($resGroupMembers) {
	while ($rowgroup = mysqli_fetch_array($resGroupMembers)) {

		$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $rowgroup["id"] . "";
		$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
		$row = mysqli_fetch_array($resgroup);

		if (isset($row["groupThumb"]) && $row["groupThumb"] != '') {
			$groupThumb = $row["groupThumb"];
		} else {
			$groupThumb = 'group.png';
		}


		$friendnameurl = '';
		$userphoto = '';
		$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowgroup["userId"] . "";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$userres = mysqli_fetch_array($b);

		$friendnameurl = $userres['userurl'];

		if ($userres["profilePhoto"] != '') {
			$userphoto = $userres["profilePhoto"];
		} else {
			$userphoto = 'user-placeholder.jpg';
		}

		?>
		<li style="border-bottom:1px solid #ccc;">
			<div class="frfl-img" style="float:none;">
				<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
					target="_blank"><img
						src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a><a
					href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
					target="_blank"><?php echo $userres['firstName']; ?> 		<?php echo $userres['lastName']; ?></a>
				<span><?php echo $userres["companyName"]; ?></span>
			</div>
		</li>
		<?php
		$n++;
	}
}
?>
<script>
	$('#memberc').text('<?php echo $n; ?>');
</script>