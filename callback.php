<?php
include_once('inc.php');
//include_once('config/session-check.inc.php'); // check user login session
include('mail.php');


//echo $_COOKIE['userId'];



//echo " $$$$$$$$<br>";
//print_r($_COOKIE);

$accesstoken = '';
$client_id = '352319751754-8liarauervqtfrbohd009uuldk3snldv.apps.googleusercontent.com';
$client_secret = 'wV2LxEN0hVe3jwYUIKmOHmFK';
$redirect_uri = $fullurl . 'callback.php';
$simple_api_key = 'AIzaSyD9OomT3HbnPSfT38v-thhCkV82u9TMc4s';
$max_results = 500;
$auth_code = $_GET["code"];
$userid = decodeStr($_GET["state"]);

//print_r($_REQUEST);
//echo "****Request<br>";

$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $userid . "' ";
$res52 = mysqli_query($conn, $aa2);
$getuser2 = mysqli_fetch_array($res52);

$firstName2 = $getuser2['firstName'];
$lastName2 = $getuser2['lastName'];
$userurl2 = $getuser2["userurl"];
$companyName = $getuser2["companyName"];
$profilePhoto2 = $getuser2["profilePhoto"];

if ($profilePhoto2 != '') {
	$profilePhoto2 = $profilePhoto2;
} else {
	$profilePhoto2 = 'user-placeholder.jpg';
}

function curl_file_get_contents($url)
{
	$curl = curl_init();
	$userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';

	curl_setopt($curl, CURLOPT_URL, $url);   //The URL to fetch. This can also be set when initializing a session with curl_init().
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);    //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
	curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 5);   //The number of seconds to wait while trying to connect.    

	curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); //The contents of the "User-Agent: " header to be used in a HTTP request.
	curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);  //To follow any "Location: " header that the server sends as part of the HTTP header.
	curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);   //The maximum number of seconds to allow cURL functions to execute.
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0); //To stop cURL from verifying the peer's certificate.
	curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);

	$contents = curl_exec($curl);
	curl_close($curl);
	return $contents;
}

$fields = array(
	'code' => urlencode($auth_code),
	'client_id' => urlencode($client_id),
	'client_secret' => urlencode($client_secret),
	'redirect_uri' => urlencode($redirect_uri),
	'grant_type' => urlencode('authorization_code')
);
$post = '';
foreach ($fields as $key => $value) {
	$post .= $key . '=' . $value . '&';
}
$post = rtrim($post, '&');

$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, 'https://accounts.google.com/o/oauth2/token');
curl_setopt($curl, CURLOPT_POST, 5);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
$result = curl_exec($curl);

curl_close($curl);

$response = json_decode($result);
/*
echo "<pre>";
print_r($response);
echo "</pre>";
*/
if (isset($response->access_token)) {
	$accesstoken = $response->access_token;
	$_SESSION['access_token'] = $response->access_token;
}


if (isset($_GET['code'])) {


	$accesstoken = $_SESSION['access_token'];
}

if (isset($_REQUEST['logout'])) {
	unset($_SESSION['access_token']);
}



$url = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=' . $max_results . '&oauth_token=' . $accesstoken;
$xmlresponse = curl_file_get_contents($url);

if ((strlen(stristr($xmlresponse, 'Authorization required')) > 0) && (strlen(stristr($xmlresponse, 'Error ')) > 0)) {
	echo "<h2>OOPS !! Something went wrong. Please try reloading the page.</h2>";
	exit();
}

//echo " <a href ='http://127.0.0.1/gmail_contact/callback.php?downloadcsv=1&code=4/eK2ugUwI_qiV1kE3fDa_92geg7s1DusDsN9BHzGrrTE# '><img src='images/excelimg.jpg' alt=''id ='downcsv'/></a>";
// echo "<h3>Email Addresses:</h3>";
$xml = new SimpleXMLElement($xmlresponse);
$xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005/Atom');

$result = $xml->xpath('//gd:email');

/*
$result2 = $xml->xpath('//gd:im');

echo "<br>********IM";
print_r($result2);


echo "<br>********";
echo "<pre>";
print_r($result);
echo "</pre>";
*/
/*
foreach ($result as $title) {
	$arr[] = $title->attributes()->address;
	 $title->attributes()->displayName;
}
*/
//print_r($arr);
foreach ($arr as $key) {
	//echo $key."<br>";
}

//$response_array = json_decode(json_encode($arr), true);

// echo "<pre>";
// print_r($response_array);
//echo "</pre>";
/*
$email_list = '';
foreach ($response_array as $value2) {

	$email_list = ($value2[0] . ",") . $email_list;
}
*/


if (count($result) > 0) {

	$count = 0;

	$allEmail = '';
	foreach ($result as $title) {


		$toEmail = '';
		$toEmail = $title->attributes()->address;
		$allEmail .= $toEmail;
		// echo  $toEmail;
		//echo "<br>";
		$toEmail = trim($toEmail);
		// $toEmail='alimhali01@gmail.com';


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
                            <img src="' . $fullurl . 'images/alumni-logo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
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

		/*$headers = 'From: '.$companNameTitle.'<do_not_reply@scgindia.in>' . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";	*/

		//$mailSent=@mail($email,$subject,$mailBodyContent,$headers);
		//if(trim($toEmail)=='r.pahat@gmail.com')
		//{

		//send_template_mail(_FROM_EMAIL_TEMPLATE_ID_,$toEmail,$subject,$mailBodyContent);
		$sendername = ucfirst($firstName2) . ' ' . ucfirst($lastName2);
		send_invitation_template_mail($sendername, $toEmail, $subject, $mailBodyContent);
		//}



	}





}

header("Location:invitation-sent.html");


?>