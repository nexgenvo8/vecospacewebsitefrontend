<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
include_once('mail.php');
if ($_REQUEST['userId'] != '' && $_REQUEST['postId'] != '') {
	?>
	<script>
		$('#commonloader').hide();
	</script>
	<?php
	$postId = decodeStr($_REQUEST['postId']);

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlCheck1 = "";
	$sqlCheck1 = "select id from " . _VAULT_SHARE_MASTER_ . " where userId='" . decodeStr($_REQUEST['userId']) . "' and postId=" . $postId . " ";
	$resCheck1 = getRecords(_VAULT_SHARE_MASTER_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCheck1);
	if ($resCheck1) {
	} else {

		unset($insertFields);
		unset($insertVals);
		$whereFields = [];
		$whereVals = [];

		$insertFields[0] = "dateAdded";
		$insertFields[1] = "userId";
		$insertFields[2] = "postId";

		$insertVals[0] = time();
		$insertVals[1] = decodeStr($_REQUEST['userId']);
		$insertVals[2] = $postId;

		$resInsert = insertDB(_VAULT_SHARE_MASTER_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');


		$dateAdded = time();

		$sql_ins = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "', userId='" . decodeStr($_REQUEST['userId']) . "',postId= " . $postId . ",postType='20' ,notificationText='postvaultshare',dateAdded='" . $dateAdded . "'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		/*For email templates*/
		$sql_vault = "SELECT name,fileSize,documentFile from " . _VAULT_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['postId']) . " ";
		$resvault = mysqli_query($conn, $sql_vault) or die(mysqli_error($conn));
		$rowvault = mysqli_fetch_array($resvault);
		$name = $rowvault['name'];
		$documentFileName = trim($rowvault["documentFile"]);

		$sharefileSize = trim($rowvault["fileSize"]);

		$totalsharefileSize = ceil($sharefileSize / 1024 / 1024);

		$aa = "SELECT email from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . decodeStr($_REQUEST['userId']) . "' ";
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
		$mailBodyContent = '<div style="padding:20px 0px;text-align:center;background-color:#ffffff">
	 <a href="' . $fullurl . '" style="display:inline-block;padding:10px" target="_blank">
    <img src="' . $fullurl . 'images/ndimlogo.png" width="150px;">
    </a>
</div>
<div style="background-color:#f4f4f4;font-family:Arial,Helvetica,sans-serif;font-size:13px;overflow:hidden;padding:30px 0px;text-align:center">
  <div style="margin:auto;width:600px;background-color:#ffffff;text-align:left">
    <div style="padding:30px">
    <span style="color:#1a94c3;font-size:22px">' . $firstName2 . ' ' . $lastName2 . ' </span>
        <div style="display:block;width:100%;margin-top:15px;margin-bottom:15px;font-size:16px;margin:10px 0"> Shared a document </div>
      <div style="padding:10px;background-color:#f9f9f9;border:dashed 1px #ccc;border-radius:2px">
     
   
     <div style="width:100%;text-align:left;overflow:hidden;padding:10px">

       <strong style="font-weight:600;display:block">File Size (' . $totalsharefileSize . ' MB) </strong>
       <div style="font-size:14px;color:#a0a0a0;margin-top:5px">' . $documentFileName . ' </div></div>
<a href="' . $fullurl . 'view-document.html?id=' . $_REQUEST['postId'] . '" style="display:inline-block;padding:8px 13px;background-color:#1a94c3;text-decoration:none;color:#fff;margin-left:10px;margin-top:15px;border-radius:14px">View Documents</a>
     

      <div style="margin-top:20px;text-align:right;line-height:30px;padding-top:5px;border-top:solid 1px #e7e7e7;color:#afafaf">Powered by ' . $companNameTitle . '</div>
    </div>
  </div>
</div></div>';


		$subject = "" . $firstName2 . " Shared a Document on " . $companNameTitle . "";

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
						unset($selectFields);
						unset($whereFields);
						unset($whereVals);

						$sqlCheck = "";
						$sqlCheck = mysqli_query(
							$conn,
							"SELECT * FROM " . _VAULT_SHARE_MASTER_ . " 
     WHERE userId = " . (int) $userres2['userId'] . " 
     AND postId = " . (int) decodeStr($_REQUEST['postId'])
						) or die(mysqli_error($conn));

						if (mysqli_num_rows($sqlCheck) > 0) {
							?>
							<i class="fa fa-check greentick" aria-hidden="true"></i>
							<?php
						} else {
							?>
							<div class="add-frnd">
								<a onclick="vaultsendrequest('<?php echo encodeStr($userres2['userId']); ?>');">Share</a>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</li>
	<?php } ?>
</ul>
<script>
	function vaultsendrequest(id) {
		$('#commonloader').show();
		$("#vaultcontactinner").load('<?php echo $fullurl; ?>getvaultdocusers.php?postId=<?php echo $_REQUEST['postId']; ?>&userId=' + id);


	}
</script>