<?php
include_once('../inc.php');
//include_once('config/session-check.inc.php'); // check user login session
include('../mail.php');

$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION["sessUserId"] . "' ";
$res52 = mysqli_query($conn, $aa2);
$getuser2 = mysqli_fetch_array($res52);

$firstName2 = $getuser2['firstName'];
$lastName2 = $getuser2['lastName'];
$userurl2 = $getuser2["userurl"];
$companyName = $getuser2["companyName"];
$profilePhoto2 = $getuser2["profilePhoto"];


require_once('globals.php');
require_once('oauth_helper.php');
// Fill in the next 3 variables. 
$request_token = $_SESSION['request_token'];
$request_token_secret = $_SESSION['request_token_secret'];
$oauth_verifier = $_GET['oauth_verifier'];
// Get the access token using HTTP GET and HMAC-SHA1 signature 
$retarr = get_access_token_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $request_token, $request_token_secret, $oauth_verifier, false, true, true);
if (!empty($retarr)) {
	list($info, $headers, $body, $body_parsed) = $retarr;
	if ($info['http_code'] == 200 && !empty($body)) {
		//   print "Use oauth_token as the token for all of your API calls:\n" . 
		//      rfc3986_decode($body_parsed['oauth_token']) . "\n"; 
		// Fill in the next 3 variables. 
		$guid = $body_parsed['xoauth_yahoo_guid'];
		$access_token = rfc3986_decode($body_parsed['oauth_token']);
		$access_token_secret = $body_parsed['oauth_token_secret'];
		// Call Contact API 
		$retarrs = callcontact_yahoo(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $guid, $access_token, $access_token_secret, false, true);

		// echo "<pre/>";

		$contactArr = explode(',', $retarrs);
		$totalContact = count($contactArr);
		if ($totalContact > 0) {
			for ($i = 0; $i < $totalContact; $i++) {
				$email = strtolower($contactArr[$i]);
				if (trim($email) != "") {

					if (preg_match('/@/', $email)) {
						//echo $email;
						//echo "<br />";
						$toEmail = '';
						$toEmail = trim($email);
						$mailBodyContent = '';
						$mailBodyContent = '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
    <tbody>
    <tr>
        <td align="center" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px">
                <tbody>
                <tr>
                    <td align="center" valign="top" style="width:100%;padding:20px 0">
                        <a href="' . $fullurl . '" target="_blank" >
                            <img src="' . $fullurl . 'images/logo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
                </tr>
                <tr>
                  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">
                        <h4 align="center" style="padding:0;margin:0 0 10px;color:#484848">Hey,</h4>
                      <p align="center" style="margin:0 0 30px;padding:0;color:#484848;line-height:22px;padding-bottom: 12px;"><strong><a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $firstName2 . '</a></strong> has invited you to join <a href="' . $fullurl . '" target="_blank" style="color:#1a94c3; text-decoration:none;">' . $companNameTitle . '</a>- a networking platform for exploring business and job opportunities.</p>
                        <a href="' . $fullurl . '" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#0abe51;border-radius:5px" target="_blank">Join ' . $companNameTitle . ' </a> 
                        <div style="text-align:center; margin-top:10px;">Sign up for free and discover a world full of possibilities </div></td>
                </tr>
                <tr>
                    <td align="center" style="padding:0px;margin:0">
                     <div style="font-size:12px;color:#666666;text-align:center;color:#838383;line-height:24px;padding:20px 0px;background-color: #e9e9e9;">ConnecWrk - a one stop platform for SMEs, freelancers and job seekers. <br>Copyright: OMSR Media Pvt. Ltd.<br>
 <a href="' . $fullurl . 'privacy.html" style="color:#838383; text-decoration:none;">Privacy Policy</a> | <a href="info@connecwrk.com" style="color:#838383; text-decoration:none;">Contact</a> | <a href="' . $fullurl . 'terms.html" style="color:#838383; text-decoration:none;">Terms</a></div></td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</div>';


						//$subject="Invitation from ".$domainname."";  
						$subject = "Invitation to Join ConnecWrk";
						/*
						$headers = 'From: Konectt<do_not_reply@scgindia.in>' . "\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";	*/

						//echo $mailBodyContent;
						//echo '<br /> *******************************';
						//$toEmail='r.pahat786@gmail.com';
						//$mailSent=@mail($email,$subject,$mailBodyContent,$headers);
						//if(trim($toEmail)=='r.pahat@gmail.com')
						//{
						//send_template_mail(_FROM_EMAIL_TEMPLATE_ID_,$toEmail,$subject,$mailBodyContent);
						$sendername = ucfirst($firstName2) . ' ' . ucfirst($lastName2);
						send_invitation_template_mail($sendername, $toEmail, $subject, $mailBodyContent);
						//}



					}
				}
			}

		}

		header("Location:" . $fullurl . "invitation-sent.html");

		//echo $retarrs;

		// print_r($retarrs);


	}
}

?>