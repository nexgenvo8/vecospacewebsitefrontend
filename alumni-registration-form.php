<?php
include_once('inc.php');
include_once('config/user-logged-session-check.inc.php'); // check user login session
$fpage = 1;
$action = 'add';
$isSubmitted = 'n';





if (isPost()) {


    $errMsg = '';
    $errMsgl = '';
    $className = '';
    $className1 = '';
    $classFldName = '';

    $action = clean($_POST['txtAction']);

    if (trim($action) == 'add') {

        include_once('mail.php');
        $firstName = clean($_POST["firstName"]);
        $lastName = clean($_POST["lastName"]);
        //$password = addslashes(trim($_POST["password"]));
        $password = mt_rand(1000, 200000000);
        $ppAndTcStatus = clean($_POST["ppAndTcStatus"]);
        $email = clean($_POST["email"]);
        $gender = trim($_POST["gender"]);
        $mobile = clean($_POST["mobile"]);
        $day = trim($_POST["day"]);
        $month = trim($_POST["month"]);
        $year = trim($_POST["year"]);

        $userstype = trim($_POST["userstype"]);
        $jobTitle = trim($_POST["jobTitle"]);
        $coursename = trim($_POST["coursename"]);
        $departmentname = trim($_POST["departmentname"]);
        $companyName = trim($_POST["companyName"]);
        $industryId = trim($_POST["industryId"]);

        if ($_POST['userstype'] == 1) {
            $passingyear = trim($_POST["passingyear"]);
        } else {
            $passingyear = trim($_POST["passingyear2"]);
        }

        $dob = $year . '-' . $month . '-' . $day;


        $firstNameUrl = makeContentUrl($firstName);
        $lastNameUrl = makeContentUrl($lastName);

        $userurl = $firstNameUrl . '-' . $lastNameUrl;

        if ($ppAndTcStatus != 1) // validating if privacy policy and terms or conditions is not  checked.
        {
            $errMsg = 'Please confirm that you accept the terms & conditions and the privacy policy.';
            $className = 'errormsg';
        }

        if ($password == '' || strlen($password) < 6) // validating if password is blank
        {
            $errMsg = 'Please enter password min. 6 characters.';
            $className = 'errormsg';
        }

        if ($password != '') // validating if password charactor length > 60
        {
            if (strlen($password) > 60) {
                $errMsg = 'Please enter password max. 60 characters.';
                $className = 'errormsg';
            }
        }

        if ($gender == '') {
            $errMsg = 'Please select gender.';
            $className = 'errormsg';
        }

        if ($year == '' || $year == 0) {
            $errMsg = 'Please select year.';
            $className = 'errormsg';
        }

        if ($month == '' || $month == 0) {
            $errMsg = 'Please select month.';
            $className = 'errormsg';
        }

        if ($day == '' || $day == 0) {
            $errMsg = 'Please select day.';
            $className = 'errormsg';
        }

        if (trim($email) == '') {
            $errMsg = 'Please enter Email address.';
            $className = 'errormsg';
        }

        if (trim($email) != '') {
            if (strlen(trim(sanitizedboutput($email))) > 60) {
                $errMsg = 'Email address exceeded character limit! Can have 60 characters.';
                $className = 'errormsg';
            }
        }

        if (trim($email) != '') {
            if (isValidEmailFunc(trim($email)) == 'n') {
                $errMsg = 'Please enter valid Email.';
                $className = 'errormsg';
            }
        }

        if (trim($lastName) == '') {
            $errMsg = 'Please enter last name.';
            $className = 'errormsg';
        }

        if (trim($lastName) != '') {
            if (strlen(trim(sanitizedboutput($lastName))) > 60) {
                $errMsg = 'Last name exceeded character limit! Can have 60 characters.';
                $className = 'errormsg';
            }
        }

        if (trim($firstName) == '') {
            $errMsg = 'Please enter first name.';
            $className = 'errormsg';
        }

        if (trim($firstName) != '') {
            if (strlen(trim(sanitizedboutput($firstName))) > 60) {
                $errMsg = 'First name exceeded character limit! Can have 60 characters.';
                $className = 'errormsg';
            }
        }


        $selectFields = [];
        $whereFields = [];
        $whereVals = [];

        $sqlBrokerageDetails = "";
        $sqlBrokerageDetails = "select email from " . _USERS_MASTER_TABLE_ . " where email='" . $email . "' ";
        $resBrokerageDetails = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlBrokerageDetails);
        if ($resBrokerageDetails) {
            $errMsg = 'Email address <strong>"' . $email . '"</strong> already exits. Please try another .';
            $className = 'errormsg';
        }
        if (trim($errMsg) == '') {
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
            $insertFields[8] = "gender";
            $insertFields[9] = "dob";
            $insertFields[10] = "countryName";
            $insertFields[11] = "cityName";
            $insertFields[12] = "timeZone";
            $insertFields[13] = "jobTitle";
            $insertFields[14] = "industryId";
            $insertFields[15] = "companyName";
            $insertFields[16] = "userstype";
            $insertFields[17] = "passingyear";
            $insertFields[18] = "departmentname";
            $insertFields[19] = "coursename";
            $insertFields[20] = "mobile";

            $insertVals[0] = $firstName;
            $insertVals[1] = $lastName;
            $insertVals[2] = $email;
            $insertVals[3] = md5($password);
            $insertVals[4] = time();
            $insertVals[5] = time();
            $insertVals[6] = $ppAndTcStatus;
            $insertVals[7] = $userurl;
            $insertVals[8] = $gender;
            $insertVals[9] = $dob;
            $insertVals[10] = trim($_POST["countryName"]);
            $insertVals[11] = trim($_POST["cityName"]);
            $insertVals[12] = trim($_POST["timeZone"]);
            $insertVals[13] = $jobTitle;
            $insertVals[14] = $industryId;
            $insertVals[15] = $companyName;
            $insertVals[16] = $userstype;
            $insertVals[17] = $passingyear;
            $insertVals[18] = $departmentname;
            $insertVals[19] = $coursename;
            $insertVals[20] = $mobile;

            $resUpdate = insertDB(_USERS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _Y_, '');
            if ($resUpdate) {
                $userId = $resUpdate;

                $isSubmitted = 'n';
                $errMsg = 'Profile created successfully.';
                $className = 'success';
            }

            $strEmail = '';
            $strEmail = base64_encode(base64_encode(base64_encode(base64_encode($email))));
            $mailBodyContent = '';

            $mailBodyContent = '<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;"><a href="' . $fullurl . 'timeline.html" style="border:0px;">
		<img src="' . $fullurl . 'images/logo.png" width="217" style="border:0px;"></a></div><div style="background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:scroll; padding:30px 0px;text-align:center;">
<div style="margin:auto; width:100%; background-color:#FFFFFF; text-align:left;">
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
  ">
    <div style="display:block; font-size:18px; margin-bottom:10px;">Hello ' . $FirstName . '</div>
    Thank you for registering with us. We are thrilled to have you on ' . $companNameTitle . '. 
    To get you fully on board, we request you to verify your email address, by clicking on the button below.
  </h2>
</div>

<!-- Button -->
<div style="text-align:left; margin-top:20px; margin-bottom:30px;">
  <a href="' . $fullurl . 'confirm-registration.html?_j=' . $strEmail . '" style="text-decoration:none;">
    <input name="" type="button" style="background-color:#C02621; cursor:pointer; padding:12px 30px; outline:0px; border:0px; border-radius:3px; color:#FFFFFF; font-size:16px;" value="Confirm e-mail address">
  </a>
</div>

<!-- Scrollable credentials -->
<div style="background:#f9f9f9; padding:10px; border:1px dashed #ccc; border-radius:3px; font-size:14px; line-height:20px; color:#696969;">
  After Confirmation please login your account using:<br><br>

  <div style="margin-bottom:8px;">
    Email ID: 
    <div style="overflow-x:auto; -webkit-overflow-scrolling:touch; white-space:nowrap;">
      <span style="font-weight:700;">' . $email . '</span>
    </div>
  </div>

  <div>
    Password: 
    <div style="overflow-x:auto; -webkit-overflow-scrolling:touch; white-space:nowrap;">
      <span style="font-weight:700;">' . $password . '</span>
    </div>
  </div>

  <br>
  Please change your password from Account Setting -> My Account.
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
</div>';


            $subject = "Please confirm your " . $companNameTitle . " registration now.";

            $headers = 'From: ' . $companNameTitle . '<do_not_reply@scgindia.in>' . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

            //$mailSent=@mail($email,$subject,$mailBodyContent,$headers);
            send_template_mail_reg(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);
            //send_template_mail_new(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

            if ($userId != 0 && is_numeric($userId)) {
                unset($insertFields);
                unset($insertVals);

                $insertFields[0] = "userId";

                $insertVals[0] = $userId;

                $resUpdate = insertDB(_USER_SETTINGS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
            }

            $_SESSION["registerEmail"] = $email;
            header('Location:thankyou.html');
            exit();
        } else {
            // Show error popup
            echo "<script>alert('" . addslashes($errMsg) . "');</script>";
        }
    }

    // if (trim($action) == 'login') {

    //     $username = clean($_POST['txtUsername']);
    //     $passwordl = clean($_POST['txtPassword']);
    //     $pass = md5($passwordl);

    //     if (trim($pass) == "") {
    //         $errMsgl = "Please enter password";
    //         $className = 'errormsg';
    //     }
    //     if (trim($username) == "") {
    //         $errMsgl = "Please enter registered email address";
    //         $className = 'errormsg';
    //     }

    //     if (trim($errMsgl) == "") {

    //         unset($selectFields);
    //         unset($whereFields);
    //         unset($whereVals);
    //         $sqlQuery = "";
    //         $sqlQuery = "Select firstName,lastName,email,userId,activeYN,userurl,timeZone,userAccountCloseStatus from " . _USERS_MASTER_TABLE_ . " where email='" . $username . "' and password='" . $pass . "' and activeYN='Y' ";

    //         $res = mysql_query($sqlQuery);
    //         if (mysql_num_rows($res) > 0) {
    //             while ($row = mysql_fetch_array($res)) {

    //                 $firstlastName = $row["firstName"] . ' ' . $row["lastName"];
    //                 $_SESSION["sessFname"] = $row["firstName"];
    //                 $_SESSION["sessFullName"] = $firstlastName;
    //                 $_SESSION['sessEmail'] = $row['email'];
    //                 $_SESSION['sessUserId'] = $row['userId'];
    //                 $_SESSION['userstype'] = $row['userstype'];
    //                 $userAccountCloseStatus = $row['userAccountCloseStatus'];

    //                 setcookie('userId', encodeStr($row['userId']), time() + (86400 * 30), "/");
    //                 if ($userAccountCloseStatus == 1) {
    //                     header("location:disabled-account.html");
    //                     exit();
    //                 } else {
    //                     header("location:loginredirect.php");
    //                     exit();
    //                 }
    //             }
    //         } else {
    //             $className1 = 'redborderfield';
    //         }
    //     }
    // }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include jQuery first -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include Select2 CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <style>
        /* Background image styling */
        body {
            background: url('background.jpg') no-repeat center center/cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Footer Styling */
        footer {
            margin-top: auto;
            /* Pushes footer to the bottom */
        }

        .mt-3 {
            margin-top: 0.5rem !important;
        }

        /* Centered form container */
        .form-container {
            background: rgba(255, 255, 255, 0.9);
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.2);
            max-width: 600px;
            width: 100%;
            margin: auto;
        }

        /* Customizing form inputs */
        .form-control,
        .form-select {
            font-size: 12px;
            height: 30px;
            padding: 5px;
        }

        /* Adjusting labels */
        label {
            font-size: 12px;
            font-weight: 600;
        }

        /* Button Styling */
        .btn-success {
            font-size: 13px;
            padding: 6px;
        }

        .terms-checkbox {
            font-size: 11px;
        }

        @media only screen and (max-width: 800px) {
            .container {

                padding: 15px !important;
            }
        }
    </style>
</head>

<body style="background-color: #fff;background-image: inherit;">
    <div id="wrapper">
        <header class="container">
            <div class="logo logo_marg"><a href="<?php echo $fullurl; ?>"><img
                        src="<?php echo $fullurl; ?>images/logo.png"></a></div>
            <div class="header_right" style="display:none;">
                <form class="login-form" name="kUserLogin" id="kUserLogin" method="post" style="display:none1;">
                    <div class="login-inputs">
                        <input type="text" name="txtUsername" id="txtUsername" maxlength="60" placeholder="Email"
                            value="<?php echo sanitizedboutput($username); ?>"
                            class="validate <?php echo $className1; ?>" onKeyUp="hideerrordiv(this.id);">
                    </div>
                    <div class="login-inputs">
                        <input type="password" name="txtPassword" id="txtPassword" maxlength="60" placeholder="Password"
                            class="validate <?php echo $className1; ?>">
                        <a href="<?php echo $fullurl; ?>forgot-password.html">Forgot Password?</a>
                    </div>
                    <button type="button" onClick="formValidation('kUserLogin');" style="margin-top:12px;">Log
                        in</button>
                    <input type="hidden" name="txtAction" id="txtAction" value="login">

                </form>
                <script>
                    $("input").keypress(function (event) {
                        if (event.which == 13) {
                            //event.preventDefault();
                            if ($("#txtUsername").val() != '' && $("#txtPassword").val() != '') {
                                $("#kUserLogin").submit();
                            }
                        }
                    });
                </script>
            </div>
        </header>
        <div class="banner">
            <!--<div class="bannerblkbg"></div>-->
            <div class="container mt-5" style="background:white;width: 77%;padding: 15px;">
                <h3 class="text-success">Register Now !!!</h3>
                <form name="registrationtstep1" id="registrationtstep1" method="post">
                    <div class="row g-3">
                        <?php
                        // Default values if variables are not set
                        $firstName = isset($firstName) ? $firstName : '';
                        $lastName = isset($lastName) ? $lastName : '';
                        $email = isset($email) ? $email : '';
                        ?>

                        <div class="col-6 col-md-6">
                            <input name="firstName" pattern=".*\S.*" type="text" id="firstName"
                                onKeyUp="hideerrordiv(this.id);" value="<?php echo sanitizedboutput($firstName); ?>"
                                class="form-control validate" placeholder="First name" required>
                        </div>
                        <div class="col-6 col-md-6">
                            <input name="lastName" pattern=".*\S.*" type="text" id="lastName"
                                onKeyUp="hideerrordiv(this.id);" value="<?php echo sanitizedboutput($lastName); ?>"
                                class="form-control validate" placeholder="Last name" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <input name="email" type="email" id="email" onKeyUp="hideerrordiv(this.id);"
                                value="<?php echo sanitizedboutput($email); ?>" class="form-control validate"
                                placeholder="Email" required>
                        </div>
                        <div class="col-12 col-md-6">
                            <input name="mobile" type="number" id="mobile" onKeyUp="hideerrordiv(this.id);"
                                value="<?php echo sanitizedboutput($mobile); ?>" class="form-control validate"
                                placeholder="Phone" required>
                        </div>
                        <!--<div class="col-md-6">-->
                        <!--    <input name="password" type="password" id="password" onKeyUp="hideerrordiv(this.id);" value="<?php echo sanitizedboutput($password); ?>" class="form-control validate" placeholder="Password (6 or more characters)" required>-->
                        <!--</div>-->
                    </div>

                    <label class="mt-3">Birthday</label>
                    <div class="row g-3">
                        <div class="col-4 col-md-3" style="margin-bottom: 10px;">
                            <select class="form-select" id="day" name="day" required>
                                <option value="0">Day</option>
                                <?php
                                for ($d = 1; $d <= 31; $d++) {
                                    if ($day == $d) {
                                        $strSelected = 'selected="selected"';
                                    } else {
                                        $strSelected = "";
                                    }
                                    ?>
                                        <option value="<?php echo $d; ?>" <?php echo $strSelected; ?>><?php echo $d; ?></option>
                                        <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-4 col-md-3" style="margin-bottom: 10px;">
                            <select class="form-select" name="month" id="month" required>
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
                                            <?php //echo $m; 
                                                ?>         <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                                        </option>
                                        <?php
                                }
                                ?>

                            </select>
                        </div>
                        <div class="col-4 col-md-3" style="margin-bottom: 10px;">
                            <select class="form-select" name="year" id="year" required>
                                <option value="0">Year</option>
                                <?php
                                for ($y = date('Y', strtotime('-10 years')); $y >= 1920; $y--) {
                                    if ($year == $y) {
                                        $strSelected = 'selected="selected"';
                                    } else {
                                        $strSelected = "";
                                    }
                                    ?>
                                        <option value="<?php echo $y; ?>" <?php echo $strSelected; ?>><?php echo $y; ?></option>
                                        <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3" style="margin-bottom: 10px;">
                            <!--<label class="mt-3">Gender</label>-->
                            <div class="d-flex gap-3">
                                <div>
                                    <input type="radio" name="gender" id="male" value="Male" checked> Male
                                </div>
                                <div>
                                    <input type="radio" name="gender" id="female" value="Female"> Female
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-6 col-md-4" style="margin-bottom: 10px;">
                                <select class="form-select" name="userstype" id="userstype"
                                    onChange="selectusertypemain(this.value);" disabled>
                                    <option value="3" selected>Alumni</option>
                                </select>

                                <script>
                                    $(document).ready(function () {
                                        // Trigger change so logic runs automatically
                                        $("#userstype").trigger("change");
                                    });

                                    function selectusertypemain(id) {
                                        var userstype = $('#userstype').val();

                                        $('#jobtitlediv').hide();
                                        $('#coursenamediv').hide();
                                        $('#departmentnamediv').hide();
                                        $('#industrydiv').hide();
                                        $('#alpassingyeardiv').hide();
                                        $('#stpassingyeardiv').hide();

                                        if (userstype == 3) { // Alumni
                                            $('#coursenamediv').show();
                                            $('#departmentnamediv').show();
                                            $('#alpassingyeardiv').show();
                                            $('#industrydiv').show();
                                            $('#jobtitlediv').show();
                                            $('#companyName').attr('placeholder', 'Company Name');
                                            $('#companyName').val('');
                                        }
                                    }

                                    selectusertypemain();
                                </script>
                            </div>

                            <div class="col-6 col-md-4" id="jobtitlediv" style="margin-bottom: 10px;">
                                <input type="text" name="jobTitle" id="jobTitle" class="form-control"
                                    placeholder="Enter Job Title">
                            </div>
                            <div class="col-6 col-md-4" id="coursenamediv" style="margin-bottom: 10px;">
                                <select class="form-select" name="coursename" id="coursename">
                                    <option selected>Course</option>
                                    <?php
                                    $selectFields = [];
                                    $whereFields = [];
                                    $whereVals = [];

                                    $sqlOptions = "";
                                    $sqlOptions = "SELECT * FROM " . _COURSE_MASTER_TABLE_ . "  WHERE status=1 order by course_name";
                                    $resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
                                    if ($resOptions) {
                                        while ($rowOptions = mysqli_fetch_array($resOptions)) {

                                            ?>
                                                    <option value="<?php echo trim($rowOptions['course_name']); ?>">
                                                        <?php echo trim($rowOptions['course_name']); ?>
                                                    </option>
                                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>



                            <div class="col-6 col-md-4" id="departmentnamediv" style="margin-bottom: 10px;">
                                <select class="form-select" name="departmentname" id="departmentname">
                                    <option selected>Department</option>
                                    <?php
                                    $selectFields = [];
                                    $whereFields = [];
                                    $whereVals = [];

                                    $sqlOptions = "";
                                    $sqlOptions = "SELECT * FROM " . _DEPARTMENT_MASTER_TABLE_ . " WHERE status=1  order by department_name";
                                    $resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
                                    if ($resOptions) {
                                        while ($rowOptions = mysqli_fetch_array($resOptions)) {

                                            ?>
                                                    <option value="<?php echo trim($rowOptions['department_name']); ?>">
                                                        <?php echo trim($rowOptions['department_name']); ?>
                                                    </option>
                                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 col-md-4" id="stpassingyeardiv" style="margin-bottom: 10px;">
                                <select class="form-select" name="passingyear" id="passingyear">
                                    <option selected>Passing Year</option>
                                    <option value="2023">2023</option>
                                    <option value="2024">2024</option>
                                    <option value="2024">2025</option>
                                    <?php
                                    $currentdate = date("Y", strtotime('+1 years'));
                                    $end = date('Y-m-d', strtotime('+5 years'));
                                    while ($currentdate <= $end) {
                                        ?>
                                            <option value="<?php echo $currentdate; ?>" <?php if ($currentdate == '2025') {
                                                   echo 'selected';
                                               } ?>> <?php echo $currentdate;
                                                $currentdate++; ?></option>
                                            <?php
                                    }
                                    ?>
                                </select>
                            </div>



                            <div class="col-6 col-md-4" id="alpassingyeardiv" style="margin-bottom: 10px;">
                                <select class="form-select" name="passingyear2" id="passingyear2">
                                    <option selected>Passing Year</option>
                                    <?php
                                    $staringdate = 1950;
                                    $currentdate = date("Y");
                                    while ($staringdate <= $currentdate) {
                                        ?>
                                            <option value="<?php echo $staringdate; ?>"><?php echo $staringdate;
                                               $staringdate++; ?></option>
                                            <?php
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 col-md-4" style="margin-bottom: 10px;">
                                <input type="text" name="companyName" id="companyName" placeholder="University"
                                    class="form-control">
                            </div>


                            <div class="col-6 col-md-4" id="industrydiv" style="margin-bottom: 10px;">
                                <select class="form-select" name="industryId" id="industryId">
                                    <option value="0">Industry</option>
                                    <?php
                                    $selectFields = [];
                                    $whereFields = [];
                                    $whereVals = [];

                                    $sqlOptions = "";
                                    $sqlOptions = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry' ";
                                    $resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
                                    if ($resOptions) {
                                        while ($rowOptions = mysqli_fetch_array($resOptions)) {
                                            if ($industryId == $rowOptions['id']) {
                                                $strSelected = 'selected="selected"';
                                            } else {
                                                $strSelected = "";
                                            }
                                            ?>
                                                    <option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected; ?>>
                                                        <?php echo trim($rowOptions['optionName']); ?>
                                                    </option>
                                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- Terms & Conditions Checkbox -->
                    <div class="form-check mt-3 terms-checkbox">
                        <input class="form-check-input" type="checkbox" name="ppAndTcStatus" id="ppAndTcStatus"
                            onClick="return false;" value="1" checked id="terms">
                        <label class="form-check-label" for="terms">
                            I accept <?php echo $companNameTitle; ?>'s <a href="<?php echo $fullurl; ?>terms.html"
                                target="_blank">Terms & Conditions</a></label>
                        </label>
                    </div>

                    <div class="form-check mt-3 terms-checkbox" style="">
                        <label class="form-check-label" for="terms">
                            <a href="<?php echo $fullurl; ?>" target="_blank">If already registered login here</a>
                        </label>
                    </div>
                    <input type="hidden" name="txtAction" id="txtAction" value="<?php echo $action; ?>">
                    <input type="hidden" name="countryName" value="India">
                    <input type="hidden" name="cityName" value="Delhi">
                    <input type="hidden" name="timeZone" value="Asia/Kolkata">
                    <button type="submit" class="btn btn-success w-100 mt-4"
                        onClick="formValidation('registrationtstep1');">Register Now</button>
                </form>
            </div>
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


    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <?php include('footer.php'); ?>
    <script>
        $(document).ready(function () {
            $('#departmentname').select2({
                placeholder: 'Select a Department',
                allowClear: true
            });

            $('#coursename').select2({
                placeholder: 'Select a Course',
                allowClear: true
            });
        });
    </script>
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