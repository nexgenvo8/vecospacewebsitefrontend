<?php
require("inc.php");
require("common.php");
//require("website_security.php");
include_once('../mail.php');

$id = $_REQUEST['id'];
////////////////fetch email id//////////////
$re = "select email from userMaster  where userId='" . $id . "'";
$re2 = mysql_query($re) or die(mysql_error());
$industry_email = mysql_fetch_array($re2);
///////////////////////////////////////////
$email = $industry_email['email'];
//echo '<span>'.$email.'</span>'; die;
//$email = preg_replace('/\s+/', '', $email);
//$maileremail = $email;
$passtosent = mt_rand(1000, 200000000);
$Password = md5($passtosent);

$sql_ins = "update userMaster set password='$Password' where userId = " . $id . "";
mysql_query($sql_ins) or die(mysql_error());


$strEmail = base64_encode(base64_encode(base64_encode(base64_encode($email))));
if (isset($email)) {
    $mailBodyContent = '<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;"><a href="' . $websiteurl . 'timeline.html" style="border:0px;">
		<img src="' . $websiteurl . 'images/logoo.jpg" width="217" style="border:0px;"></a></div><div style="background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:scroll; padding:30px 0px;text-align:center;">
<div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
<table style="width:100%;background-color: #e8e8e8;">
<tbody><tr>
<td colspan="3" height="20" style="height:20px;font-size:0px;text-align:center">

<a style="text-decoration:underline;font-family:arial,sans-serif;font-size:11px;color:#666666">If this e-mail isn&prime;t displayed correctly, please click here.</a></td></tr>

</tbody></table>
<div style="padding:30px;">



<div style="padding:10px;background-color: #F9F9F9;border:dashed 1px #ccc;border-radius: 2px;width: 100%;
    overflow-y: scroll;">



<div style="color: #696969; font-size: 14px; line-height: 20px;">

<h2 style="
font-weight: 500;
font-size: 15px;
line-height: 23px;
color: #676767;
"><div style="display:block; font-size:18px; margin-bottom:10px;">Hello ' . $FirstName . '</div>

Thank you for registering with us. We are thrilled to have you on ' . $companNameTitle . '. To get you fully on board, we request you to verify your email address, by clicking on the button below.	</h2></div><div style="text-align:left; margin-top:20px; margin-bottom:30px;"><a href="' . $websiteurl . 'confirm-registration.html?_j=' . $strEmail . '" style="text-decoration:none;"><input name="" type="button" style="background-color:#860E66;cursor: pointer; padding:12px 30px; outline:0px; border:0px; border-radius: 3px; color:#FFFFFF; font-size:16px; cursor:pointer;" value="Confirm e-mail address"></a></div> After Confirmation Please login your account using your email id: <span style="font-weight:700;">' . $email . '</span> and password: <span style="font-weight:700;">' . $passtosent . '</span> and change your password from account Setting -> My Account.

</div>


<table width="100%" height="90" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="
background-color: #f7f7f7;
"><tbody><tr><td colspan="3" width="100%" height="10" style="width:100%;height:10px;line-height:0px;font-size:0px">&nbsp;</td></tr><tr><td width="25" style="width:4%">&nbsp;</td><td width="480" height="80" style="width:80%;height:80px;font-family:Arial;font-size:13px;color:#808080;line-height:18px;text-align:left">Is the button not working? Please copy this link to your browser:<br><br><a href="' . $websiteurl . 'confirm-registration.html?_j=' . $strEmail . '" style="font-family:Helvetica,Arial,sans-serif;font-size:12px;color:#179cd0;word-break:break-all" target="_blank">' . $websiteurl . 'confirm-registration.html?_j=' . $strEmail . '</a></td><td width="25" style="width:4%">&nbsp;</td></tr><tr><td colspan="3" height="10" style="height:10px;line-height:0px;font-size:0px">&nbsp;</td></tr></tbody></table>

<div style="    margin-top: 20px;
text-align: right;
line-height: 30px;padding-top: 5px;
border-top: solid 1px #e7e7e7;
color: #afafaf;">Powered by ' . $companNameTitle . '
</div>
</div>
</div>
</div>';

    $subject = "Please confirm your " . $companNameTitle . " registration now.";

    send_template_mail_new(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);


    // $posturl = "https://rhcrm.in/emailservice/postemail_api.php";
// $jsondata = '{
//     "subject" : "'.$subject.'",
//     "toEmail" : "'.$email.'",
//     "ccEmail" : "",
//     "emailContent" : '.json_encode($mailBodyContent).',
//     "attachment" : "",
//     "serverName" : "jmi vecospace"
// }';

    // $ch = curl_init();
// curl_setopt($ch, CURLOPT_URL,$posturl);
// curl_setopt($ch, CURLOPT_POST,1);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $jsondata);
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// $response = curl_exec($ch);
// curl_close($ch);

    ?>
    <script>
        parent.$('#sendbutton<?php echo $_REQUEST['id']; ?>').val('Mail Sent');
    </script>
    <?php
}

?>