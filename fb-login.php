<?php
include_once('inc.php');
include_once('mail.php');
$email = addslashes(trim($_REQUEST['email']));
$name = addslashes(trim($_REQUEST['name']));

if ($email == '' || $email == 'undefined') {
	header("Location: " . $fullurl . "");
	exit();
}

if ($name == '' || $name == 'undefined') {
	header("Location: " . $fullurl . "");
	exit();
}

if ($email != '' && $name != '') {
	$result = mysqli_query(
		$conn,
		"SELECT email FROM " . _USERS_MASTER_TABLE_ . " WHERE email = '" . mysqli_real_escape_string($conn, $email) . "'"
	) or die(mysqli_error($conn));

	$number = mysqli_num_rows($result);

	if ($number > 0) {

		$selectFields = [];
		$whereFields = [];
		$whereVals = [];
		$sqlQuery = "";
		$sqlQuery = "Select firstName,lastName,email,userId,activeYN,userurl,timeZone from " . _USERS_MASTER_TABLE_ . " where email='" . $email . "'  ";
		$res = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlQuery);
		if ($res) {
			while ($row = mysqli_fetch_array($res)) {


				$sql_ins = "update " . _USERS_MASTER_TABLE_ . " set activeYN='Y' where userId= " . $row['userId'] . "";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


				$firstlastName = $row["firstName"] . ' ' . $row["lastName"];
				$_SESSION["sessFname"] = $row["firstName"];
				$_SESSION["sessFullName"] = $firstlastName;
				$_SESSION['sessEmail'] = $row['email'];
				$_SESSION['sessUserId'] = $row['userId'];
				$_SESSION['activeYN'] = $row['activeYN'];

				if (trim($_SESSION["activeYN"]) == 'Y') {/*header("location:loginredirect.php");
exit();*/
					?>
					<script>
						window.location = "loginredirect.php";
					</script>

					<?php
				} else {
					header("location:" . $fullurl . "");
					exit();
				}

			}
		}



	} else {


		$password = mt_rand(10000000, 99999999);

		$lastNameUrl = makeContentUrl($name);

		$userurl = $lastNameUrl;

		unset($insertFields);
		unset($insertVals);

		$insertFields[0] = "firstName";
		$insertFields[1] = "lastName";
		$insertFields[2] = "email";
		$insertFields[3] = "password";
		$insertFields[4] = "regDate";
		$insertFields[5] = "modifyDate";
		$insertFields[6] = "ppAndTcStatus";
		$insertFields[7] = "userurl";
		$insertFields[8] = "activeYN";

		$insertVals[0] = $name;
		$insertVals[1] = '&nbsp;';
		$insertVals[2] = $email;
		$insertVals[3] = md5($password);
		$insertVals[4] = time();
		$insertVals[5] = time();
		$insertVals[6] = 1;
		$insertVals[7] = $userurl;
		$insertVals[8] = 'Y';

		$resUpdate = insertDB(_USERS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		$userId = $resUpdate;

		if ($userId != 0 && is_numeric($userId)) {
			unset($insertFields);
			unset($insertVals);

			$insertFields[0] = "userId";

			$insertVals[0] = $userId;

			$resUpdate = insertDB(_USER_SETTINGS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');


			$selectFields = [];
			$whereFields = [];
			$whereVals = [];
			$sqlQuery = "";
			$sqlQuery = "Select firstName,lastName,email,userId,activeYN,userurl,timeZone from " . _USERS_MASTER_TABLE_ . " where email='" . $email . "'  ";
			$res = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlQuery);
			if ($res) {
				while ($row = mysqli_fetch_array($res)) {

					$firstlastName = $row["firstName"] . ' ' . $row["lastName"];
					$_SESSION["sessFname"] = $row["firstName"];
					$_SESSION["sessFullName"] = $firstlastName;
					$_SESSION['sessEmail'] = $row['email'];
					$_SESSION['sessUserId'] = $row['userId'];
					$_SESSION['activeYN'] = $row['activeYN'];
					$firstName = $row['firstName'];
					if (trim($_SESSION["activeYN"]) == 'Y') {





						$mailBodyContent = '';

						$mailBodyContent = '<div style="background-color: #dff6ff;width: 100%;overflow: hidden;">
	<div style="width:600px;margin: auto; border-top: 4px solid #1a94c3; border-bottom: 4px solid #1a94c3;background-color: #fff;overflow: hidden;padding: 30px;padding-top: 0px; box-sizing: border-box;font-family: arial;color: #4c4c4c;font-size: 14px;">
		<a href="' . $fullurl . '" target="_blank" style="display: block;padding: 10px;padding-left: 0;">
		<img src="' . $fullurl . 'images/sgtlogo.png" width="150px;">
		</a>
		
		<div style="width: 100%;height: 100%;left:0;top: 0;padding: 1px;box-sizing: border-box;">
<h1 style="
   margin: 0;
   background-color: white;
   max-width: 300px;
   font-size: 22px;
   font-weight: 500;
   FLOAT: LEFT;
   padding: 0px;
   margin-top: 10px;
   margin-bottom: 20px;
   ">Hi ' . $firstName . ', <br> Welcome to ' . $companNameTitle . '!</h1>
   <a href="' . $fullurl . 'timeline.html" style="display: inline-block;padding: 8px 12px;background-color: #1a94c3;color: #fff;text-decoration: none;border-radius: 4px;margin-top: 15px;float: right;font-weight: 600;float: RIGHT;">Explore ' . $companNameTitle . ' in detail.</a>
</div>
		<div style="width: 100%;height: 250px;position: relative; float: left;overflow: hidden;">
<img src="' . $fullurl . 'uploads/1498818923beach--v3441095-1280.jpg" style="position: absolute;left: 0;top: 0;width: 100%;">

</div>
		 <h2 style="clear: both;float: left;color:#1a94c3;font-size: 18px;font-weight: normal;">A few of the many benefits that you gain by being a member of ' . $companNameTitle . ':
</h2>
<ul style="list-style: none;margin: 0;padding-left: 0; line-height: 20px;">
	<li style="margin-bottom: 15px; width: 100%;float: left;">

		<div><strong>Premium Articles , Trivia and News:</strong> Stay inspired, informed and updated with relevant articles, written by leading management gurus, thought leaders and subject matter experts. Get a snapshot of top news and views-all on a single platform!</div>
	</li>
	<li style="margin-bottom: 15px; width: 100%;float: left;">

		<div><strong>Projects: </strong>Post your projects and outsource your work to hire a freelancer* or expert, to complete it for you. </div>
	</li>
	<li style="margin-bottom: 15px; width: 100%;float: left;">
	
		<div><strong>The Knowledge Vault: </strong>Get access* to reports, case studies and relevant statistics across industry verticals.
 </div>
	</li>
	<li style="margin-bottom: 15px; width: 100%;float: left;">
	
		<div><strong>Groups and chat: </strong>Get invited to a Group or Create your own Private Groups and share information with like minded people on relevant topics. <br> <strong style="color: #1a94c3;">You can create as many groups and chat simultaneously with each group.</strong>
		</div>
	</li>
</ul>
<div style="padding:20px;background-color: #e7e7e7;margin-bottom: 15px; clear: both;">
	Subscribe For A Premium Membership For Other Exclusive Benefits.<a href="' . $fullurl . 'premimum-membership.html" style="color: #1a94c3;"> Click here</a> to know more. 

</div>
<div style="margin-bottom: 15px;font-size: 11px;"> * As a neutral platform, ' . $companNameTitle . ' will enable the Project owners and freelancers to establish contact with each other and negotiate their projects independently among themselves. ' . $companNameTitle . ' will provide the users solely with the necessary infrastructure, but shall not act as representative or agent of a user, and shall not become a party to a service contract concluded between the both.
</div>
<div style="margin-bottom: 15px;font-size: 11px;">* Basic membership provides access to only selected case studies and reports. Premium membership provides access to all reports and case studies etc in the Knowledge Vault.
</div>
	</div>
</div>';
						$subject = 'Hi ' . $firstName . ', Welcome to ' . $companNameTitle . '!';

						$headers = 'From: ' . $companNameTitle . '<do_not_reply@scgindia.in>' . "\r\n";
						$headers .= "MIME-Version: 1.0\r\n";
						$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

						//$mailSent=@mail($email,$subject,$mailBodyContent,$headers);
						send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);




						/*header("location:loginredirect.php");
						exit();*/
						?>
						<script>
							window.location = "loginredirect.php";
						</script>
						<?php
					} else {
						header("location:" . $fullurl . "");
						exit();
					}

				}
			}


		}




	}



}




?>