<?php
include_once('inc.php');
//include_once('config/session-check.inc.php');
include_once('mail.php');
$errMsg = '';
$className = '';
$textVar = 'Thank You!';
if (isset($_GET['_j']) && $_GET['_j'] != '') {
	$strEmail = $_GET['_j'];

// Agar raw email hai
if (filter_var($strEmail, FILTER_VALIDATE_EMAIL)) {
    // do nothing, already email
} else {
    // encoded email hai → decode
    $decoded = $strEmail;
    for ($i = 0; $i < 4; $i++) {
        $decoded = base64_decode($decoded, true);
    }

    if (filter_var($decoded, FILTER_VALIDATE_EMAIL)) {
        $strEmail = $decoded;
    } else {
        $strEmail = '';
    }
}
	/*	echo '<br>=====<br>';
		echo $strEmail=clean($strEmail);*/

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];
	$oops = 0;
	$sqlLogin = "";
	$sqlLogin = "select email,activeYN,firstName from " . _USERS_MASTER_TABLE_ . " where email='" . $strEmail . "' ";
	$resLogin = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
	if ($resLogin) {
		while ($rowLogin = mysqli_fetch_array($resLogin)) {
			$email = $rowLogin['email'];
			$activeYN = $rowLogin['activeYN'];
			$firstName = ucfirst($rowLogin["firstName"]);
		}

		if ($activeYN == 'Y') {
			$errMsg = "Your email address already verified. Please login.";
			$className = 'errormsg  thanku-err';
			$textVar = 'Oops!';
			$oops = 1;
		} else {
			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);

			$insertFields[0] = "activeYN";
			$insertVals[0] = 'Y';

			$whereFields[0] = "email";
			$whereVals[0] = $email;

			$resUserLoginTime = updateDB(_USERS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, ''); // verified the user email address	
			if ($resUserLoginTime) {
				$errMsg = "Your email address has been verified successfully.";
				$className = 'confirmemail thanku-txt';
				$textVar = 'Thank You!';

				$strEmail = '';
				$strEmail = base64_encode(base64_encode(base64_encode(base64_encode($email))));
				$mailBodyContent = '';

				$mailBodyContent = '<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;"><a href="' . $fullurl . '" style="border:0px;"><img src="' . $fullurl . 'images/sgtlogo.jpg" width="217" style="border:0px;"></a></div>
<div style="background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; padding:30px 0px;text-align:center;">
<div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
<div style="padding:30px;">
<div style="font-size:22px; margin-bottom:10px;"><span style="color:#1a94c3;">Hi ' . $firstName . ',</span> It &prime;s time to get &prime;' . $companNameTitle . '&prime;</div>
<div style="text-align:left; margin-top:20px; margin-bottom:40px;"><a href="' . $fullurl . 'timeline.html" style="text-decoration:none;"><input name="" type="button" style="background-color:#C02621; padding:12px 30px; outline:0px; border:0px; border-radius: 3px; color:#FFFFFF; font-size:16px;" value="Explore ' . $companNameTitle . '"></a></div>
<div style="margin-bottom:20px; font-size:15px; color:#1a94c3;"><strong>A few of the many benefits that you gain by being a member of ' . $companNameTitle . ':</strong></div>
<div style="padding:10px; background-color:#F9F9F9; border:dashed 1px #ccc; border-radius: 2px;">
<div style="color: #696969; margin-bottom: 22px; font-size: 14px; line-height: 20px;"><strong>Articles , Trivia and News:</strong> Stay inspired, informed and updated with relevant articles, written by leading management gurus, thought leaders and subject matter experts. Get a snapshot of top news and views-all on a single platform!</div>
<div style="color: #696969; margin-bottom: 22px; font-size: 14px; line-height: 20px;"><strong>Projects:&nbsp;</strong>Post your projects and outsource your work to hire a freelancer* or expert, to complete it for you.</div>
<div style="color: #696969; margin-bottom: 22px; font-size: 14px; line-height: 20px;"><strong>Events :&nbsp;</strong>Post your next event and reach out to your target group on ' . $companNameTitle . ' or get updated on great events happening around you.</div>
<div style="color: #696969; font-size: 14px; line-height: 20px;"><strong>Groups and chat:&nbsp;</strong>Get invited to a Group or Create your own Private Groups and share information with like minded people on relevant topics.
<br>
You can create as many groups and chat simultaneously with each group.</div>
</div>
<div style="margin-top: 25px; font-size: 12px; color: #666666; padding-top: 20px; border-top: 1px #e4e4e4 solid;">* As a neutral platform, ' . $companNameTitle . ' will enable the Project owners and freelancers to establish contact with each other and negotiate their projects independently among themselves. ' . $companNameTitle . ' will provide the users solely with the necessary infrastructure, but shall not act as representative or agent of a user, and shall not become a party to a service contract concluded between the both.<br>
<br>
* Basic membership provides access to only selected case studies and reports. Premium membership provides access to all reports and case studies etc in the Knowledge Vault.</div>
<div style="    margin-top: 20px;
   text-align: right;
   line-height: 30px;padding-top: 5px;
   border-top: solid 1px #e7e7e7;
   color: #afafaf;">Powered by ' . $companNameTitle . '
</div>
</div>
</div>
</div>';
				$subject = 'Hi ' . $firstName . ', Welcome to ' . $companNameTitle . '!';

				$headers = 'From: ' . $companNameTitle . '<do_not_reply@scgindia.in>' . "\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

				//$mailSent=@mail($email,$subject,$mailBodyContent,$headers);
				send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

			}
		}

	} else {
		$errMsg = "Invalid Access.";
		$className = 'errormsg ';
		$textVar = 'Oops!';
		$oops = 1;
		$in = 1;
	}
} else {
	header("Location:" . $fullurl . "");
	exit();
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Confirm - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link rel="icon" href="favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css"
		href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/main.js"></script>
</head>

<body style="background-color: #fff;background-image: inherit;overflow: hidden;">
	<div id="wrapper">
		<header>
			<div class="logo login-pros"><a href="<?php echo $fullurl; ?>"><img
						src="<?php echo $fullurl; ?>images/ndimlogo.png"></a></div>
		</header>
		<div class="banner">
			<div class="container">
				<div class="second-step thankyou-confirm" style="width:500px;">
					<?php if ($oops == 1) { ?><i class="fa fa-times-circle-o" aria-hidden="true"
							style="color: #fd6363;"></i><?php } else { ?><i class="fa fa-check-circle-o"
							aria-hidden="true"></i><?php } ?>
					<h2 style="text-align:center; color:#1a94c3;"><?php echo $textVar; ?></h2>
					<form name="frmkonectt" id="frmkonectt" class="personal-data" method="post">
						<div style="text-align:center; "> <?php if (trim($errMsg) != '') { ?>
								<div id="emsgdiv" class="<?php echo $className; ?>"
									style="display:block; margin-top:10px; margin-bottom:10px;"><?php echo $errMsg; ?><br>
									<br>
								</div>
							<?php } ?><a href="<?php echo $fullurl; ?>"><button
									style="background-color:#3ca3ce; float:none; color:#fff; margin-right:10px;"
									type="button" class="continue-process-btn">Back to login page</button></a>
						</div>
						<br>

					</form>
				</div>
			</div>
		</div>

		<?php include('sitefooter.php'); ?>
	</div>
	<?php include('sitecopyright.php'); ?>

	<div class="overlay">&nbsp;</div>
	<style type="text/css">
		header {
			margin: auto;
			width: 100%;
			overflow: hidden;
			z-index: 9999999999999;
			position: absolute;
			width: 100%;
			background-color: #fff;
		}

		.overlay {
			width: 100%;
			height: 100%;
			position: fixed;
			left: 0;
			top: 0;
			background: #1a94c3;
			background: -moz-linear-gradient(top, #1a94c3 0%, #6dc8e7 100%);
			background: -webkit-linear-gradient(top, #1a94c3 0%, #6dc8e7 100%);
			background: linear-gradient(to bottom, #1a94c3 0%, #6dc8e7 100%);
			filter: progid:DXImageTransform.Microsoft.gradient(startColorstr='#1a94c3', endColorstr='#6dc8e7', GradientType=0);
		}
	</style>
</body>

</html>