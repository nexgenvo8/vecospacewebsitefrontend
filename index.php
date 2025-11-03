<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once(__DIR__ . '/inc.php');
// check user login session

$fpage = 1;
$action = 'add';
$isSubmitted = 'n';
$errMsgl = "";



if (isPost()) {
	$errMsg = '';
	$className = '';

	$action = isset($_POST['txtAction']) ? clean($_POST['txtAction'], $conn) : "";


	if (trim($action) == 'add') {
		include_once('mail.php');
		$firstName = clean($_POST["firstName"]);
		$lastName = clean($_POST["lastName"]);
		$password = trim($_POST["password"]);
		$ppAndTcStatus = clean($_POST["ppAndTcStatus"]);
		$email = clean($_POST["email"]);
		$gender = trim($_POST["gender"]);

		$day = trim($_POST["day"]);
		$month = trim($_POST["month"]);
		$year = trim($_POST["year"]);
		$dob = $year . '-' . $month . '-' . $day;

		$firstNameUrl = makeContentUrl($firstName);
		$lastNameUrl = makeContentUrl($lastName);
		$userurl = $firstNameUrl . '-' . $lastNameUrl;

		// ---- Validations ----
		if ($ppAndTcStatus != 1) {
			$errMsg = 'Please confirm that you accept the terms & conditions and the privacy policy.';
			$className = 'errormsg';
		} elseif ($password == '' || strlen($password) < 6) {
			$errMsg = 'Please enter password min. 6 characters.';
			$className = 'errormsg';
		} elseif (strlen($password) > 60) {
			$errMsg = 'Please enter password max. 60 characters.';
			$className = 'errormsg';
		} elseif ($gender == '') {
			$errMsg = 'Please select gender.';
			$className = 'errormsg';
		} elseif ($year == '' || $year == 0) {
			$errMsg = 'Please select year.';
			$className = 'errormsg';
		} elseif ($month == '' || $month == 0) {
			$errMsg = 'Please select month.';
			$className = 'errormsg';
		} elseif ($day == '' || $day == 0) {
			$errMsg = 'Please select day.';
			$className = 'errormsg';
		} elseif (trim($email) == '') {
			$errMsg = 'Please enter Email address.';
			$className = 'errormsg';
		} elseif (strlen($email) > 60) {
			$errMsg = 'Email address exceeded character limit! Can have 60 characters.';
			$className = 'errormsg';
		} elseif (isValidEmailFunc($email) == 'n') {
			$errMsg = 'Please enter valid Email.';
			$className = 'errormsg';
		} elseif (trim($lastName) == '') {
			$errMsg = 'Please enter last name.';
			$className = 'errormsg';
		} elseif (strlen($lastName) > 60) {
			$errMsg = 'Last name exceeded character limit! Can have 60 characters.';
			$className = 'errormsg';
		} elseif (trim($firstName) == '') {
			$errMsg = 'Please enter first name.';
			$className = 'errormsg';
		} elseif (strlen($firstName) > 60) {
			$errMsg = 'First name exceeded character limit! Can have 60 characters.';
			$className = 'errormsg';
		}

		// ---- Database Check ----
		if (trim($errMsg) == '') {


			// Check if email exists
			$stmt = $conn->prepare("SELECT email FROM " . _USERS_MASTER_TABLE_ . " WHERE email = ?");
			$stmt->bind_param("s", $email);
			$stmt->execute();
			$stmt->store_result();
			if ($stmt->num_rows > 0) {
				$errMsg = 'Email address <strong>"' . $email . '"</strong> already exists. Please try another.';
				$className = 'errormsg';
			}
			$stmt->close();

			// ---- Insert User ----
			if ($errMsg == '') {
				$stmt = $conn->prepare("INSERT INTO " . _USERS_MASTER_TABLE_ . " 
                    (firstName, lastName, email, password, regDate, modifyDate, ppAndTcStatus, userurl, gender, dob) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

				$hashedPassword = md5($password); // ❌ better use password_hash() instead of md5
				$regDate = time();
				$modifyDate = time();

				$stmt->bind_param(
					"ssssiiisss",
					$firstName,
					$lastName,
					$email,
					$hashedPassword,
					$regDate,
					$modifyDate,
					$ppAndTcStatus,
					$userurl,
					$gender,
					$dob
				);

				if ($stmt->execute()) {
					$userId = $stmt->insert_id;

					$isSubmitted = 'n';
					$errMsg = 'Profile created successfully.';
					$className = 'success';

					// ---- Send Email ----
					$strEmail = base64_encode(base64_encode(base64_encode(base64_encode($email))));

					$mailBodyContent = '<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;"><a href="' . $fullurl . 'timeline.html" style="border:0px;"><img src="' . $fullurl . 'images/logo.jpg" width="217" style="border:0px;"></a></div><div style="background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; padding:30px 0px;text-align:center;">
<div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
<table style="width:100%;background-color: #e8e8e8;">
<tbody><tr>
<td colspan="3" height="20" style="height:20px;font-size:0px;text-align:center">

    <a style="text-decoration:underline;font-family:arial,sans-serif;font-size:11px;color:#666666">If this e-mail isn&prime;t displayed correctly, please click here.</a></td></tr>

    </tbody></table>
<div style="padding:30px;">



<div style="padding:10px;background-color: #F9F9F9;border:dashed 1px #ccc;border-radius: 2px;">



<div style="color: #696969; font-size: 14px; line-height: 20px;">

    <h2 style="
    font-weight: 500;
    font-size: 15px;
    line-height: 23px;
    color: #676767;
"><div style="display:block; font-size:18px; margin-bottom:10px;">Hello ' . $firstName . '</div>

Thank you for registering with us. We are thrilled to have you on ' . $companNameTitle . '. To get you fully on board, we request you to verify your email address, by clicking on the button below.	</h2></div><div style="text-align:left; margin-top:20px; margin-bottom:30px;"><a href="' . $fullurl . 'confirm-registration.html?_j=' . $strEmail . '" style="text-decoration:none;"><input name="" type="button" style="background-color:#FF0000;cursor: pointer; padding:12px 30px; outline:0px; border:0px; border-radius: 3px; color:#FFFFFF; font-size:16px; cursor:pointer;" value="Confirm e-mail address"></a></div>
</div>
<table width="100%" height="90" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="
    background-color: #f7f7f7;
"><tbody><tr><td colspan="3" width="100%" height="10" style="width:100%;height:10px;line-height:0px;font-size:0px">&nbsp;</td></tr><tr><td width="25" style="width:4%">&nbsp;</td><td width="480" height="80" style="width:80%;height:80px;font-family:Arial;font-size:13px;color:#808080;line-height:18px;text-align:left">Is the button not working? Please copy this link to your browser:<br><br><a href="' . $fullurl . 'confirm-registration.html?_j=' . $strEmail . '" style="font-family:Helvetica,Arial,sans-serif;font-size:12px;color:#179cd0;word-break:break-all" target="_blank">' . $fullurl . 'confirm-registration.html?_j=' . $strEmail . '</a></td><td width="25" style="width:4%">&nbsp;</td></tr><tr><td colspan="3" height="10" style="height:10px;line-height:0px;font-size:0px">&nbsp;</td></tr></tbody></table>

<div style="    margin-top: 20px;
    text-align: right;
    line-height: 30px;padding-top: 5px;
    border-top: solid 1px #e7e7e7;
    color: #afafaf;">Powered by ' . $companNameTitle . '
</div>
</div>
</div>
</div>'; // keep your existing template
					$subject = "Please confirm your " . $companNameTitle . " registration now.";
					send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

					// ---- Insert into user_settings ----
					$stmt2 = $conn->prepare("INSERT INTO " . _USER_SETTINGS_MASTER_TABLE_ . " (userId) VALUES (?)");
					$stmt2->bind_param("i", $userId);
					$stmt2->execute();
					$stmt2->close();

					$_SESSION["registerEmail"] = $email;
					header('Location:thankyou.html');
					exit;
				} else {
					$errMsg = "Database error: " . $stmt->error;
					$className = 'errormsg';
				}

				$stmt->close();
			}
			$conn->close();
		}
	}



	if (trim($action) == 'login') {
		$username = isset($_POST['txtUsername']) ? clean($_POST['txtUsername'], $conn) : "";
		$passwordl = isset($_POST['txtPassword']) ? clean($_POST['txtPassword'], $conn) : "";

		if (trim($passwordl) == "") {
			$errMsgl = "Please enter password";
			$className = 'errormsg';
		}
		if (trim($username) == "") {
			$errMsgl = "Please enter registered email address";
			$className = 'errormsg';
		}

		if (trim($errMsgl) == "") {
			// Step 1 — Get user data including stored password hash
			$sqlQuery = "SELECT firstName, lastName, email, userId, activeYN, userurl, timeZone, userAccountCloseStatus, userstype, password 
                     FROM " . _USERS_MASTER_TABLE_ . " 
                     WHERE email='" . mysqli_real_escape_string($conn, $username) . "' 
                       AND activeYN='Y'";

			$res = mysqli_query($conn, $sqlQuery);


			if ($res && mysqli_num_rows($res) > 0) {
				$row = mysqli_fetch_assoc($res);



				// Step 2 — Verify password
				// Step 2 — Verify password
				if (md5($passwordl) === $row['password']) {
					$firstlastName = $row["firstName"] . ' ' . $row["lastName"];
					$_SESSION["sessFname"] = $row["firstName"];
					$_SESSION["sessFullName"] = $firstlastName;
					$_SESSION['sessEmail'] = $row['email'];
					$_SESSION['sessUserId'] = $row['userId'];
					$_SESSION['userstype'] = $row['userstype'];
					$userAccountCloseStatus = $row['userAccountCloseStatus'];

					setcookie('userId', encodeStr($row['userId']), time() + (60 * 60 * 24 * 60), "/");

					if ($userAccountCloseStatus == 1) {
						header("location:disabled-account.html");
						exit();
					} else {
						header("location:timeline.html");
						exit();
					}
				} else {

					$className1 = 'redborderfield';
				}

			} else {
				echo "<pre>No user found with that email</pre>";
				$className1 = 'redborderfield';
			}
		}
	}



}

?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $companNameTitle; ?> - log in or sign up</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="favion.ico" type="image/x-icon">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="icon" href="<?php echo $fullurl; ?>favion.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css"
		href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="js/jquery.min.js"></script>
	<script src="js/main.js"></script>
	<style>
		/* .login-inputs{
	display: none;
} */
	</style>
	<style>
		/*.password-container {*/
		/*    position: relative;*/
		/*    width: 250px;*/
		/*}*/
		/*.password-container input {*/
		/*    width: 100%;*/
		/*    padding: 5px;*/
		padding-right: 40px;
		/* Space for the icon */
		/*    font-size: 16px;*/
		/*}*/
		/*.password-container .eye-icon {*/
		/*    position: absolute;*/
		/*    right: 10px;*/
		/*    top: 27%;*/
		/*    transform: translateY(-50%);*/
		/*    cursor: pointer;*/
		/*    font-size: 12px;*/
		/*}*/

		.banner {
			position: relative;
			/* Ensure positioning works */
		}

		.mobile-overlay-container {
			display: none;
			/* Hidden by default */
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 60%;
			display: flex;
			justify-content: center;
			align-items: center;
			z-index: 2;
			pointer-events: none;
			/* so it doesn’t block clicks below if needed */
		}

		.mobile-message {
			display: none;
			/* Hidden by default */
			color: #20741f;
			background-color: #ffff;
			padding: 10px 20px;
			font-size: 14px;
			z-index: 10;
			padding: 20px;
			box-shadow: 2px 2px 2px 2px #bfbdbd;
		}

		/* Only show on screens smaller than 768px */
		@media (max-width: 768px) {
			.mobile-message {
				display: block;
			}
		}
	</style>
</head>

<body style="background-color: #fff;background-image: inherit;">
	<div id="wrapper">
		<header class="container">
			<div class="logo logo_marg"><a href="<?php echo $fullurl; ?>"><img
						src="<?php echo $fullurl; ?>images/ndimlogo.png" style="margin-top: 10px;"></a></div>
			<div class="header_right">

				<form class="login-form loginForm1" name="kUserLogin" id="kUserLogin2" method="post">
					<div class="login-inputs ">
						<input type="text" name="txtUsername" id="txtUsername2" maxlength="60" placeholder="Email"
							tabindex="1" value="" class="validate <?php echo $className1; ?>"
							onKeyUp="hideerrordiv(this.id);">
					</div>
					<div class="login-inputs password-container">
						<input type="password" name="txtPassword" id="txtPassword2" maxlength="60"
							placeholder="Password" tabindex="1" class="validate <?php echo $className1; ?>">
						<!--<span class="eye-icon" onclick="togglePassword()">👁️</span-->
						<a href="<?php echo $fullurl; ?>forgot-password.html">Forgot Password?</a>
					</div>
					<button type="button" onClick="formValidation('kUserLogin2');" tabindex="1"
						style="margin-top:12px;">Log in</button>
					<input type="hidden" name="txtAction" id="txtAction" value="login">

				</form>
				<script>
					$("input").keypress(function (event) {

						if (event.which == 13) {
							event.preventDefault();
							if ($("#txtUsername2").val() != '' && $("#txtPassword2").val() != '') {
								$("#kUserLogin2").submit();
							}
						}
					});

				</script>
			</div>
		</header>
		<div class="banner2">
			<div class="banner">
				<!-- <div class="mobile-overlay-container">
					<div class="mobile-message">
						<div style="font-size:16px; font-weight:500;">An Initiative By</div>
						<div style="font-size:18px; font-weight:700;">UNIVERSITY PLACEMENT CELL</div>
						<div style="font-size:20px; font-weight:500;">Jamia Millia Islamia</div>
					</div>
				</div> -->

				<div class="bannerblkbg"></div>
				<div class="container">
					<div class="banner-left-info" style="text-align:left;">

						<div class="new">

							<form class="login-form" name="kUserLogin" id="kUserLogin" method="post">
								<div class="login-inputs">
									<input type="text" name="txtUsername" id="txtUsername" maxlength="60"
										placeholder="Email" tabindex="1"
										value="<?php echo sanitizedboutput($username); ?>"
										class="validate <?php echo $className1; ?>" onKeyUp="hideerrordiv(this.id);">
								</div>
								<div class="login-inputs ">
									<input type="password" name="txtPassword" id="txtPassword" maxlength="60"
										placeholder="Password" tabindex="1" class="validate <?php echo $className1; ?>">
									>
									<a href="<?php echo $fullurl; ?>forgot-password.html">Forgot Password?</a>
								</div>
								<button type="button" onClick="formValidation('kUserLogin');" tabindex="1"
									style="margin-top:12px;">Log in</button>
								<button type="button" name="txtAction" id="txtAction" value="login">

							</form>
							<script>
								$("input").keypress(function (event) {
									if (event.which == 13) {
										event.preventDefault();
										if ($("#txtUsername").val() != '' && $("#txtPassword2").val() != '') {
											$("#kUserLogin").submit();
										}
									}
								});

								function togglePassword() {
									const passwordField = document.getElementById("txtPassword2");
									if (passwordField.type === "password") {
										passwordField.type = "text";
									} else {
										passwordField.type = "password";
									}
								}

							</script>
						</div>
						<form class="signup" name="registrationtstep1" id="registrationtstep1" method="post"
							style="display:none;">
							<h2 style="color: #0e7037;font-weight:600;">Register Now !!!</h2>
							<?php if ($errMsg != '') { ?>
								<div style="margin-bottom:10px; color:#FF0000;" class="<?php echo $className; ?>">
									<?php echo $errMsg; ?>
								</div><?php } ?>
							<div class="regstr-inputs pd-right">
								<input name="firstName" type="text" id="firstName" onKeyUp="hideerrordiv(this.id);"
									value="<?php echo sanitizedboutput($firstName); ?>" maxlength="30"
									placeholder="First name" class="validate">
							</div>
							<div class="regstr-inputs pd-left">
								<input name="lastName" type="text" id="lastName" onKeyUp="hideerrordiv(this.id);"
									value="<?php echo sanitizedboutput($lastName); ?>" maxlength="30"
									placeholder="Last name" class="validate">
							</div>
							<input type="email" name="email" id="email" value="<?php echo sanitizedboutput($email); ?>"
								placeholder="Email" maxlength="60" onKeyUp="hideerrordiv(this.id);" class="validate">

							<input name="password" type="password" id="password" onKeyUp="hideerrordiv(this.id);"
								value="<?php echo sanitizedboutput($password); ?>" maxlength="16"
								placeholder="Password (6 or more characters)" class="validate">
							<label>Birthday</label>
							<div class="rgstr-birthday">
								<select id="day" name="day" class="validate" onChange="hideerrordiv(this.id);">
									<option value="0">Day</option>
									<?php
									for ($d = 1; $d <= 31; $d++) {
										if ($day == $d) {
											$strSelected = 'selected="selected"';
										} else {
											$strSelected = "";
										}
										?>
										<option value="<?php echo $d; ?>" <?php echo $strSelected; ?>><?php echo $d; ?>
										</option>
										<?php
									}
									?>
								</select>
								<select name="month" id="month" style="width:110px;" class="validate"
									onChange="hideerrordiv(this.id);">
									<option value="0">Month</option>
									<?php
									for ($m = 1; $m <= 12; $m++) {
										if ($month == $m) {
											$strSelected = 'selected="selected"';
										} else {
											$strSelected = "";
										}
										?>
										<option value="<?php echo $m; ?>" <?php echo $strSelected; ?>>
											<?php //echo $m; ?> 	<?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
										</option>
										<?php
									}
									?>
								</select>

								<select name="year" id="year" style="width:110px;" class="validate"
									onChange="hideerrordiv(this.id);">
									<option value="0">Year</option>

									<?php
									for ($y = date('Y', strtotime('-10 years')); $y >= 1920; $y--) {
										if ($year == $y) {
											$strSelected = 'selected="selected"';
										} else {
											$strSelected = "";
										}
										?>
										<option value="<?php echo $y; ?>" <?php echo $strSelected; ?>><?php echo $y; ?>
										</option>
										<?php
									}
									?>
								</select>
							</div>
							<div class="rgstr-gender">
								<input type="radio" name="gender" id="male" value="Male" <?php if ($gender == 'Male' || $gender == '') {
									echo 'checked';
								} ?>>
								<label for="male"> Male </label>
								<input type="radio" name="gender" id="female" value="Female" <?php if ($gender == 'Female') {
									echo 'checked';
								} ?>>
								<label for="female">Female </label>
							</div>
							<div class="check">
								<input type="checkbox" name="ppAndTcStatus" id="ppAndTcStatus" value="1"
									checked="checked" onClick="return false;" style="display: none;">
								<label for="ppAndTcStatus">
									I accept <?php echo $companNameTitle; ?>'s <a
										href="<?php echo $fullurl; ?>terms.html" target="_blank">Terms &
										Conditions</a></label>
							</div>
							<div class="sign_updiv">
								<button type="button" onClick="formValidation('registrationtstep1');">Register
									Now</button>
								<input type="hidden" name="txtAction" id="txtAction" value="<?php echo $action; ?>">
							</div>
						</form>


					</div>
				</div>
				<div class="footer-left2"><strong>
						<div>
							<div style="font-weight:normal;">
								<div style="float:left;">© 2023&nbsp;NDIM VECOSPACE &nbsp;|
									&nbsp;Powered by &nbsp;&nbsp;&nbsp;</div>
								<div><a href="http://deboxglobal.com/"><img src="images/Logo De Boxpng.png"
											style="width:50px;"></a></div>
							</div>
						</div>

						<p>

						</p>
					</strong></div>
				<div class="footer-menu2" style="/* margin-top:9px; */"><strong>
						<ul class="foooter-list">
							<li><a href="http://jmi.vecospace.com/privacy.html">Privacy</a></li>
							<li><a href="http://jmi.vecospace.com/terms.html">Terms</a></li>
							<li><a href="http://jmi.vecospace.com/about.html">About</a></li>
							<li><a href="http://jmi.vecospace.com/contact-us.html">Contact Us</a></li>
							<li><a href="http://jmi.vecospace.com/faq.html">FAQ's</a></li>


					</strong></div>
			</div>
			<style>
				@-webkit-keyframes slide {
					from {
						background-position: 0 bottom;
					}

					to {
						background-position: -1000% bottom;
					}
				}
			</style>
			<!--<div class="index-featured" style=" -webkit-animation: slide 250s linear infinite;">
<div class="container">
  <div class="premium-cont">
	<h2>How It Works? </h2>

 <div style="text-align: center;
	max-width: 1000px;
	margin: auto;
	line-height: 28px;
	font-weight: normal;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has industry's.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has industry's.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has industry's.Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has industry's.Lorem Ipsum is simply dummy text of.</div>









  </div>
</div>
 </div>

</div> -->

			<?php include('footer.php'); ?>

			<style type="text/css">
				.foottr {
					display: none;
				}

				.grup-box {
					height: 390px;
				}

				@media (max-width:767px) {
					footer.hide-mob-footer {
						display: block;
						padding: 10px 0;
						border-bottom: solid 1px #e7e7e7;
					}

					ul.foooter-list li:first-child {
						font-weight: normal;
						display: inline-block;
					}

					footer.hide-mob-footer .footer-left {
						display: none;
					}

					ul.foooter-list li a {
						padding: 0 5px;
						padding-right: 7px;
						font-size: 12px;
						font-weight: normal;
					}

					ul.foooter-list li {
						margin-right: 0;
						margin-bottom: 0;
					}

					ul.foooter-list li a:after {
						height: 10px;
					}


				}

				.fb_iframe_widget iframe * {
					width: 100%;
					display: block;
				}
			</style>

</body>

</html>