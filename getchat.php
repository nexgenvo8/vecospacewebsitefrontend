<?php
include_once('inc.php');
include_once('config/session-check.inc.php');

if ($_REQUEST['contactId'] != '' && $_REQUEST['action'] == 'chat' && trim($_REQUEST['text']) != '') {
	include('mail.php');


	$dateAdded = time();
	$text = normalclean($_REQUEST["text"]);
	//$text=ltrim($text,"<br />");
	$text = preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $text);
	if (trim($_REQUEST['text']) != '') {

		$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=1,userId='" . $_SESSION["sessUserId"] . "',contactId='" . decodeStr($_REQUEST["contactId"]) . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . $text . "'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
		$lastchatid = mysqli_insert_id($conn);

		chattimelineentry($_SESSION["sessUserId"], decodeStr($_REQUEST["contactId"]), 1);

		$a = "";
		$a = "select blockUser from " . _CONTACT_MASTER_TABLE_ . " where contactId='" . $_SESSION["sessUserId"] . "' AND userId='" . decodeStr($_REQUEST["contactId"]) . "' ";
		$b = mysqli_query($conn, $a);
		$c = mysqli_fetch_array($b);
		if ($c["blockUser"] != 1) {

			$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=0,userId='" . decodeStr($_REQUEST["contactId"]) . "',contactId='" . $_SESSION["sessUserId"] . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . $text . "'";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


		}




		$sql_ins = "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET chatStatus=1 WHERE contactId= " . $_SESSION["sessUserId"] . " AND userId='" . decodeStr($_REQUEST["contactId"]) . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "UPDATE " . _USERS_MASTER_TABLE_ . " SET onlineLastUpdate=" . time() . " WHERE userId=" . $_SESSION["sessUserId"] . "  ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


		/*$sql_ins="UPDATE "._CHAT_MASTER_TABLE_." SET status=1 WHERE contactId= '".decodeStr($_REQUEST['contactId'])."' AND userId='".$_SESSION["sessUserId"]."' ";
	   mysql_query($sql_ins) or die(mysql_error());*/

		if (trim($_REQUEST['shb']) == 1) {
			$sql_ins = "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET birthdayStatus=1 WHERE contactId= '" . decodeStr($_REQUEST['contactId']) . "' AND userId='" . $_SESSION["sessUserId"] . "' ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
			?>
			<script>
				parent.$('#saybirthday<?php echo decodeStr($_REQUEST['contactId']); ?>').slideUp();
			</script>
			<?php
		}
		$token = '';
		$sqlMsgToken = "";
		$sqlMsgToken = "select token from " . _MOBILE_NOTIFICATION_TABLE_ . " where userId='" . decodeStr($_REQUEST["contactId"]) . "' ORDER BY id desc ";
		$resMsgToken = mysqli_query($conn, $sqlMsgToken);
		$getLastToken = mysqli_fetch_array($resMsgToken);
		$token = $getLastToken["token"];
		?>
		<div id="sendalert" style="display:none;"></div>
		<script>
			$('#loadchatusermsg').append('<div class="userchatboxmain"><div class="userchatboxmain_me"><div  class="userchatboxmain_name_me" >&nbsp;</div><div class="userchatboxmain_text_me"><div class="chatmsg"><?php echo showsmily($text); ?></div><div  class="userchatboxmain_time_me" id="usermsgid<?php echo $lastchatid; ?>"><?php echo date("h:i A"); ?></div></div></div></div>');
			$("#loadchatusermsg").scrollTop($("#loadchatusermsg")[0].scrollHeight);

			<?php
			$a = "";
			$a = "select blockUser from " . _CONTACT_MASTER_TABLE_ . " where contactId='" . $_SESSION["sessUserId"] . "' AND userId='" . decodeStr($_REQUEST["contactId"]) . "' ";
			$b = mysqli_query($conn, $a);
			$c = mysqli_fetch_array($b);
			if ($c["blockUser"] != 1) {
				?>
				$("#sendalert").load('app/firebase/Send.php?title=<?php echo $notititle . ',' . $_SESSION["sessUserId"]; ?>&message=<?php echo $notimessage; ?>&token=<?php echo $token; ?>');
			<?php } ?>


		</script>

		<?php
		$contactId = decodeStr($_REQUEST['contactId']);
		//////////////////////
		$a = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,email,onlineStatus from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $contactId . " ";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$userres = mysqli_fetch_array($b);
		$email = $userres['email'];
		if ($userres['onlineStatus'] == 0 && $_SESSION['msgsent'] != $contactId) {

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



			$mailBodyContent .= '';
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
                        <div style="color:#666666; font-size:12px; margin-bottom:10px;">You have a new message</div>
                
					  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">
					  
					  <div style="text-align:center; margin-bottom:5px; margin-top:5px;font-size:18px;"><strong>' . $firstName2 . '</strong> sent you a message</div>
					  <div style="text-align:center; margin-top:10px; margin-bottom:30px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
  <tbody><tr>
    <td colspan="2" align="center"><a href="' . $fullurl . 'messaging.html?cuid=' . $_SESSION['sessUserId'] . '&t=6" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#0abe51;border-radius:5px;margin-bottom: 0px;" target="_blank">View Message</a></td>
    </tr>
</tbody></table>
</div>
					    <div style="text-align:center;"><div style="
    width: 80px;
    height: 80px;
    overflow: hidden;margin:auto;
    margin-bottom:12px;
    border-radius: 100%;
    border: 3px #e9e9e9 solid; margin:auto;
"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl2 . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2"><img src="' . $fullurl . 'uploads/' . $profilePhoto2 . '" style="
    width: 100%;
"></a></div>
<div style="text-align:center; margin-bottom:5px; margin-top:5px;"><strong>' . $firstName2 . ' ' . $lastName2 . '</strong></div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $jobTitle . ' at ' . $companyName . '</div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $cityName . ', ' . $countryName . '</div> 
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
                            
                          <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div> 
<p style="margin:0;padding:0;font-family:"Open Sans",Arial,Helvetica,sans-serif;line-height:24px;color:#616161;font-size:14px;text-align:center">
                             Powered by <a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $domainname . '</a></p>                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</div>';


			$subject = 'You have a new message on ' . $companNameTitle . '';

			send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);
			$_SESSION['msgsent'] = $contactId;

		}

		//////////////////////


	}

}

if (trim($_REQUEST['contactId']) != '' && $_REQUEST['action'] == 'getchat') {


	$dateAdded = time();

	$n = 0;
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlLogin = "";
	$sqlLogin = "select * from " . _CHAT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and contactId='" . decodeStr($_REQUEST['contactId']) . "' and status=0 ORDER BY dateAdded asc LIMIT 0,1";
	$resLogin = getRecords(_CHAT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
	if ($resLogin) {
		while ($row = mysqli_fetch_array($resLogin)) {

			if ($row["chatFileName"] != '') {
				$fileExt = findExtension($row["chatFileName"]);

				if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {

					$img = 1;

				} else {

					$img = 0;

				}

			} else {

				$img = 0;
			}

			$msgid = $row["id"];

			$contentimg = 'x_' . $row["chatFileName"];
			?>

			<script>
				var contentimg = '<?php echo $contentimg; ?>';


				$('#loadchatusermsg').append('<div class="userchatboxmain"><div class="userchatboxmain_user"><div class="userchatboxmain_name">&nbsp;</div><div class="userchatboxmain_text" <?php if ($img == 1) { ?>style=" padding:0px !important;"<?php } ?>><?php if ($img == 0) { ?><div class="chatmsg<?php if (strpos($row["chatText"], 'maps/place') !== false) { ?> iframehave<?php } ?>"><?php echo nl2br(showsmily(str_replace("'", "&#39;", $row["chatText"]))); ?></div><?php } else { ?><div class="imgbox"><img src="<?php echo $fullurl; ?>uploads/<?php echo $row["chatFileName"]; ?>" style="width:200px;" onClick="imagepopupmain(\'' + contentimg + '\');" /></div><?php } ?><div class="userchatboxmain_time"><?php echo date("h:i A", $row['dateAdded']); ?></div></div></div></div>');

				$('#chatlist<?php echo ($_REQUEST['contactId']); ?>').removeClass('active');

				$("#loadchatusermsg").scrollTop($("#loadchatusermsg")[0].scrollHeight);
			</script>

			<?php
			$sql_ins = "UPDATE " . _CHAT_MASTER_TABLE_ . " SET status=1 WHERE contactId= '" . decodeStr($_REQUEST['contactId']) . "' AND userId='" . $_SESSION["sessUserId"] . "' and id='" . $msgid . "' ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			if ($row["meeting"] == 1 && $row["status"] == 0) {
				?>
				<script>
					parent.$('#loadchatusermsg').load("<?php echo $fullurl; ?>load_chat_user_msg.php?userId2=<?php echo $_REQUEST['contactId']; ?>");
				</script>
			<?php } ?>

			<?php

		}
	}

	$a = "";
	$a = "SELECT blockUser FROM " . _CONTACT_MASTER_TABLE_ . " 
      WHERE contactId='" . $_SESSION['sessUserId'] . "' 
      AND userId='" . decodeStr($_REQUEST['contactId']) . "'";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$c = mysqli_fetch_array($b);

	// Safely check blockUser
	if (isset($c["blockUser"]) && $c["blockUser"] != 1) {


		$sqlLogin2 = "";
		$sqlLogin2 = "select id,readDate,dateAdded from " . _CHAT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and contactId='" . decodeStr($_REQUEST['contactId']) . "' and status=1 ORDER BY dateAdded desc LIMIT 0,1";
		$resLogin2 = getRecords(_CHAT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin2);
		if ($resLogin2) {
			while ($row2 = mysqli_fetch_array($resLogin2)) {

				$aa = "SELECT readDate from " . _CHAT_MASTER_TABLE_ . " where contactId='" . $_SESSION['sessUserId'] . "' and userId='" . decodeStr($_REQUEST['contactId']) . "'  ORDER BY dateAdded desc						 LIMIT 0,1";
				$res5 = mysqli_query($conn, $aa);

				$getread = mysqli_fetch_array($res5);
				if ($getread['readDate'] != 0 && $getread['readDate'] != '') {

					?>
					<script>
						$('.fa-check-circle span').remove();
						$('.fa-check-circle').removeClass('fa-check-circle');
						$('#usermsgid<?php echo $row2['id']; ?>').html('<i class="fa fa-check-circle" aria-hidden="true"> <span>Read</span></i><?php echo date("h:i A", $row2['dateAdded']); ?>');
					</script>
					<?php

				}


				$sql_ins = "UPDATE " . _CHAT_MASTER_TABLE_ . " SET readDate=" . time() . " WHERE readDate=0 and  contactId= '" . decodeStr($_REQUEST['contactId']) . "' AND userId='" . $_SESSION["sessUserId"] . "' ";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));



			}

		}


	}


	$sql_ins = "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET chatStatus=0 WHERE contactId= '" . decodeStr($_REQUEST['contactId']) . "' AND userId='" . $_SESSION["sessUserId"] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));



}



closeConn();
?>