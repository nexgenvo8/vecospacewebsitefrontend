<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$keyword = clean($_REQUEST['keyword'] ?? ''); // agar keyword na ho to blank set kare

$groupUserId = isset($_REQUEST['groupUserId']) ? $_REQUEST['groupUserId'] : '';

//echo $_REQUEST['userId'].'====='.$_REQUEST['groupId'].'=-----='.$keyword.'==='.$_REQUEST['userIdgroup'];
if (isset($_REQUEST['groupId']) && $groupUserId != '' && $_REQUEST['groupId'] != '') {
	$groupId = decodeStr($_REQUEST['groupId']);
	?>
	<script>$('#commonloader').hide();</script>
	<?php
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];



	$sqlCheck1 = "";
	$sqlCheck1 = "select id from " . _GROUP_MEMBER_MASTER_TABLE_ . " where userId='" . decodeStr($groupUserId) . "' and groupId=" . $groupId . " ";
	$resCheck1 = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCheck1);
	if ($resCheck1) {
	} else {
		include_once('mail.php');
		$insertFields = [];
		$insertVals = [];
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

		$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,cityName,countryName from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
		$res52 = mysqli_query($conn, $aa2);
		$getuser2 = mysqli_fetch_array($res52);

		$firstName2 = $getuser2['firstName'];
		$lastName2 = $getuser2['lastName'];
		$profilePhoto21 = $getuser2['profilePhoto'];
		$jobTitle = $getuser2["jobTitle"];
		$companyName = $getuser2["companyName"];
		$userurl2 = $getuser2["userurl"];
		$cityName = $getuser2["cityName"];
		$countryName = $getuser2["countryName"];

		if ($profilePhoto21 != '') {
			$profilePhoto2 = $profilePhoto21;
		} else {
			$profilePhoto21 = 'user-placeholder.jpg';
		}


		$mailBodyContent = ''; // Initialize kar diya

		$mailBodyContent .= ''; // Ab warning nahi aayegi

		$mailBodyContent .= '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
    <tbody>
    <tr>
        <td align="center" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px">
                <tbody>
                <tr>
                    <td align="center" valign="top" style="width:100%;padding:20px 0">
                        <a href="' . $fullurl . '" target="_blank" >
                            <img src="' . $fullurl . 'images/sdglogo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
                </tr>
                <tr>
                  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">
                     
                
					  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">
					  
					  <div style="text-align:center; margin-bottom:5px; margin-top:5px;font-size:16px; line-height:26px;">' . $firstName2 . ' has invited you to Join the group<br>
 <b>' . stripslashes($groupName) . '</b><br />
 that he has created on ' . $companNameTitle . '</div>
					 
					    <div style="text-align:center;"><div style="
    width: 80px;
    height: 80px;
    overflow: hidden;margin:auto;
    margin-bottom:12px;
    border-radius: 100%;
    border: 3px #e9e9e9 solid; margin:auto;
"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl2 . '.html"><img src="' . $fullurl . 'uploads/' . $profilePhoto2 . '" style="
    width: 100%;
"></a></div>
<div style="text-align:center; margin-bottom:5px; margin-top:5px;"><strong>' . $firstName2 . ' ' . $lastName2 . '</strong></div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $jobTitle . ' at ' . $companyName . '</div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $cityName . ', ' . $countryName . '</div>

<div style="text-align:center; margin-top:10px; margin-bottom:30px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
  <tbody><tr>
    <td colspan="2" align="center"><a href="' . $fullurl . 'notifications.html" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#0abe51;border-radius:5px;margin-bottom: 0px;" target="_blank">View Request</a></td>
    </tr>
</tbody></table>
</div> 
</div>
					  </div>
                         
                  </td>
                </tr>
                <tr>
                    <td align="center" style="padding:40px;margin:0">
                       <div style="text-align:center; font-size:12px; margin-bottom:20px;">
                      
                       <a href="' . $fullurl . 'privacy.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Privacy</a> - 
                            
                          <a href="' . $fullurl . 'terms.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Terms</a> - 
                            
                        <a href="' . $fullurl . 'about.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">About</a> - 
                            
                          <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div>                     </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</div>';


		$subject = "" . $firstName2 . " invites you to join " . $groupName . " on " . $companNameTitle . "";

		send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, str_replace('?', '', $mailBodyContent));

	}

}
if ($keyword != '') {
	?>
	<ul class="cht_mmbr_list" id="loadgroupuserlist" style="height:200px;">

		<?php
		$n = 0;
		$selectFields = [];
		$whereFields = [];
		$whereVals = [];

		$sqlSearch = "";
		//echo $sqlSearch="select * from "._USERS_MASTER_TABLE_."  a inner join "._GROUP_MEMBER_MASTER_TABLE_." b on a.userId=b.userId  where (a.firstName like '%".$keyword."%' OR a.lastName like '%".$keyword."%') and b.status=1 and b.groupId='".decodeStr($_REQUEST["groupId"])."' ";
	
		$sqlSearch = "select * from " . _USERS_MASTER_TABLE_ . " where (firstName like '%" . $keyword . "%' OR lastName like '%" . $keyword . "%') and userId IN (select userId from " . _CONTACT_MASTER_TABLE_ . " where contactId='" . $_SESSION['sessUserId'] . "' and status=1)  ";
		$resSearch = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlSearch);
		if ($resSearch) {
			while ($rowSearch = mysqli_fetch_array($resSearch)) {




				$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowSearch["userId"] . "";
				$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
				$userres = mysqli_fetch_array($b);

				$friendnameurl = $userres['userurl'];
				if ($userres["profilePhoto"] != '') {
					$userphoto = $userres["profilePhoto"];
				} else {
					$userphoto = 'user-placeholder.jpg';
				}

				?>


				<li>
					<div class="frfl-img">
						<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
							target="_blank"><img
								src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a><a
							href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
							target="_blank"><?php echo $userres['firstName']; ?> 			<?php echo $userres['lastName']; ?></a>
						<span
							style="width:120px; white-space:nowrap; text-overflow:ellipsis; overflow:hidden;"><?php echo $userres["companyName"]; ?></span>

						<?php
						$n = 0;
						unset($selectFields);
						unset($whereFields);
						unset($whereVals);

						$sqlCheck = "";
						$sqlCheck = mysqli_query(
							$conn,
							"SELECT * FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " 
     WHERE userId=" . (int) $userres['userId'] . " 
       AND groupId=" . (int) decodeStr($_REQUEST['groupId'])
						);

						if (mysqli_num_rows($sqlCheck) > 0) {
							?>
							<i class="fa fa-check greentick" aria-hidden="true"></i>
							<?php
						} else {
							?>
							<div class="add-frnd" style=" position:absolute; right:-5px; top:12px;">
								<a
									onclick="groupsendrequest('<?php echo encodeStr($userres['userId']); ?>');$('#commonloader').show();">Send
									Request</a>
							</div>
						<?php } ?>


					</div>
				</li>
				<?php
				$n++;
			}
		}
		?>
		<?php if ($n == 0) { ?>
			<div style="text-align:center; color:#666666; font-size:12px;">No Contact Found.</div><?php } ?>

	</ul>


	<script>
		$("#groupcontactinner").show();
	</script>
	<?php
} else {
	?>
	<script>
		$("#groupcontactinner").hide();
	</script>
	<?php
}
?>
<input type="hidden" name="requestgroupId" id="requestgroupId" value="<?php echo $_REQUEST["groupId"]; ?>" />
<script>
	function groupsendrequest(id) {
		var requestgroupId = $("#requestgroupId").val();
		$("#groupcontactinner").load('<?php echo $fullurl; ?>groupcontactinner.php?groupId=<?php echo $_REQUEST['groupId']; ?>&keyword=<?php echo $keyword ?>&groupUserId=' + id);

	}
</script>