<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$groupUserId = $_REQUEST['groupUserId'];
if ($groupUserId != '' && $_REQUEST['groupId'] != '') {
	?>
	<script>
		$('#commonloader').hide();
	</script>
	<?php
	$groupId = decodeStr($_REQUEST['groupId']);

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlCheck1 = "";
	$sqlCheck1 = "select id from " . _GROUP_MEMBER_MASTER_TABLE_ . " where userId='" . decodeStr($groupUserId) . "' and groupId=" . $groupId . " ";
	$resCheck1 = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCheck1);
	if ($resCheck1) {
	} else {
		include_once('mail.php');
		unset($insertFields);
		unset($insertVals);
		$whereFields = [];
		$whereVals = [];

		$insertFields[0] = "status";
		$insertFields[1] = "userId";
		$insertFields[2] = "groupId";
		$insertFields[3] = "dateAdded";

		$insertVals[0] = 0;
		$insertVals[1] = decodeStr($groupUserId);
		$insertVals[2] = $groupId;
		$insertVals[3] = time();

		$resInsert = insertDB(_GROUP_MEMBER_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');


		$dateAdded = time();

		$sql_ins = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "', userId='" . decodeStr($groupUserId) . "',groupId= " . $groupId . ",postType='4' ,notificationText='privategrouprequest',dateAdded='" . $dateAdded . "'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		/*For email templates*/
		$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['groupId']) . " ";
		$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
		$rowGroup = mysqli_fetch_array($resgroup);
		$groupName = $rowGroup['groupName'];

		$aa = "SELECT email from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . decodeStr($groupUserId) . "' ";
		$res5 = mysqli_query($conn, $aa);
		$getuser = mysqli_fetch_array($res5);
		$email = $getuser["email"];

		$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
		$res52 = mysqli_query($conn, $aa2);
		$getuser2 = mysqli_fetch_array($res52);

		$firstName2 = $getuser2['firstName'];
		$lastName2 = $getuser2['lastName'];
		$profilePhoto2 = $getuser2['profilePhoto'];
		$jobTitle = $getuser2["jobTitle"];
		$companyName = $getuser2["companyName"];
		$userurl = $getuser2["userurl"];

		if ($profilePhoto2 != '') {
			$profilePhoto2 = $profilePhoto2;
		} else {
			$profilePhoto2 = 'user-placeholder.jpg';
		}

		$mailBodyContent = '';
		$mailBodyContent = '<div style="background-color: #dff6ff; width: 100%; overflow: hidden;">
		<div style="width: 600px; margin: auto; border-top: 4px solid #1a94c3;
		border-bottom: 4px solid #1a94c3; background-color: #fff; overflow: hidden;
		padding: 30px; padding-top: 0px; box-sizing: border-box; font-family: arial;
		color: #4c4c4c; font-size: 14px; padding-bottom: 0;">
			<a href="' . $fullurl . '" target="_blank" style="display: inline-block;padding: 10px;padding-left: 0;float: left;margin-bottom: 30px;">
			<img src="' . $fullurl . 'images/sdglogo.png" width="150px;">
			</a>
			<table width="100%" border="0" style="border-bottom: solid 2px #e7e7e7;">
		<tbody><tr>
			<td valign="top"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl . '.html" style="float: right;width: 50px;"><img src="' . $fullurl . 'uploads/' . $profilePhoto2 . '" style="width: 100%;margin-bottom: 20px;"></a></td>
			<td valign="top"><strong>' . $firstName2 . ' ' . $lastName2 . ' </strong>
			<div style="margin: 15px 0;margin-top: 10px;">' . $jobTitle . ' at ' . $companyName . '</div>	
	
			</td>
		</tr>
	</tbody></table>
	<div style="padding: 25px 0;">' . $firstName2 . ' has invited you to Join the group <strong>"' . $groupName . '" </strong>� that he has created on ' . $companNameTitle . '</div>
	<div style="padding-bottom: 35px;">-' . $firstName2 . ' ' . $lastName2 . '</div>
	<a href="' . $fullurl . 'group-request.html?g=' . $_REQUEST['groupId'] . '" style="    display: inline-block; padding: 8px 13px; background-color: #1a94c3; text-decoration: none; color: #fff; margin-bottom: 20px;">View Group</a>
		</div>
	</div>';


		$subject = "" . $firstName2 . " invites you to join " . $groupName . " on " . $companNameTitle . "";

		$headers = 'From: ' . $companNameTitle . '<do_not_reply@scgindia.in>' . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

		//$mailSent=@mail($email,$subject,$mailBodyContent,$headers);
		send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

	}

}
?>

<ul class="requst-list invitecontact" id="notice-list" style="max-height:350px;">
	<?php
	$aaa = "select * from " . _USERS_MASTER_TABLE_ . " where (firstName like '%" . $keyword . "%' OR lastName like '%" . $keyword . "%') and userId IN (select userId from " . _CONTACT_MASTER_TABLE_ . " where contactId='" . $_SESSION['sessUserId'] . "' and status=1)  ";
	$res55 = mysqli_query($conn, $aaa);
	while ($rowLogin22 = mysqli_fetch_array($res55)) {

		$a2 = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin22["userId"] . "";
		$b2 = mysqli_query($conn, $a2) or die(mysqli_error($conn));
		$userres2 = mysqli_fetch_array($b2);

		$friendnameurl2 = $userres2['userurl'];
		if ($userres2["profilePhoto"] != '') {
			$userphoto2 = $userres2["profilePhoto"];
		} else {
			$userphoto2 = 'user-placeholder.jpg';
		}
		?>
		<li>
			<div class="rquest-box">
				<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2["userId"]); ?>/<?php echo $friendnameurl2; ?>.html"
					target="_blank" class="rqst-img"><img
						src="<?php echo $fullurl; ?>uploads/<?php echo $userphoto2; ?>"></a>

				<div class="rqst-right">
					<div class="rquest-middle">
						<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2["userId"]); ?>/<?php echo $friendnameurl2; ?>.html"
							target="_blank"><?php echo $userres2["firstName"]; ?> 	<?php echo $userres2["lastName"]; ?></a>
						<div style="font-size:12px; color:#9a9a9a;"><?php echo $userres2["jobTitle"]; ?> at
							<?php echo $userres2["companyName"]; ?>
						</div>

						<?php
						$n = 0;
						$selectFields = [];
						$whereFields = [];
						$whereVals = [];

						$sqlCheck = "";
						$sqlCheck = mysqli_query(
							$conn,
							"SELECT * FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " 
     WHERE userId = " . (int) $userres2['userId'] . " 
     AND groupId = " . (int) decodeStr($_REQUEST['groupId'])
						) or die(mysqli_error($conn));

						if (mysqli_num_rows($sqlCheck) > 0) {
							?>
							<i class="fa fa-check greentick" aria-hidden="true"></i>
							<?php
						} else {
							?>
							<div class="add-frnd">
								<a onclick="groupsendrequest('<?php echo encodeStr($userres2['userId']); ?>');">Send Request</a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</li>
	<?php } ?>
</ul>

<input type="hidden" name="requestgroupId" id="requestgroupId" value="<?php echo $_REQUEST["groupId"]; ?>" />
<script>
	function groupsendrequest(id) {
		$('#commonloader').show();
		var requestgroupId = $("#requestgroupId").val();
		$("#groupcontactinner").load('<?php echo $fullurl; ?>getinvitecontacts.php?groupId=<?php echo $_REQUEST['groupId']; ?>&keyword=<?php echo $keyword ?>&groupUserId=' + id);


	}
</script>