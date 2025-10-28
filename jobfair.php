<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
include('mail.php');
ini_set('upload_max_filesize', '20M');
ini_set('post_max_size', '25M');
$pageIndex = 50;
//print_r($_POST);

if (
    !empty($_POST['EnrollmentNo']) &&
    !empty($_POST['mobile']) &&
    (!empty($_POST['action']) && trim($_POST['action']) == 'addcompany')
) {

    $userId = $_SESSION['sessUserId'];

    if (!$userId) {
        echo "<script>
            alert('Session expired. Please log in again.');
            window.location.href = 'https://jmi.vecospace.com/';
        </script>";
        exit;
    }

    //////////////check already registered////////////////
    $checkIfRegistered = "SELECT registrationNo FROM userMaster WHERE userId = '$userId' LIMIT 1";
    $checkResult = mysqli_query($conn, $checkIfRegistered);
    $checkRow = mysqli_fetch_assoc($checkResult);

    if ($checkRow && !empty($checkRow['registrationNo'])) {
        echo "<script>
            alert('You are already registered. Your registration number is: {$checkRow['registrationNo']}');
            window.location.href = 'job-fair.html';
        </script>";
        exit;
    }

    // ---------- POST FIELDS ----------
    $EnrollmentNo   = trim($_POST['EnrollmentNo']);
    $mobile         = trim($_POST['mobile']);
    $photoIdType    = trim($_POST['photoIdType']);
    $jobTerms       = trim($_POST['jobTerms']);
    $profession     = trim($_POST['profession']);
    $jobTitle       = trim($_POST['jobTitle']);
    $companyName    = trim($_POST['companyName']);
    $industryId     = trim($_POST['industryId']);
    $linkedIn       = trim($_POST['linkedIn']);
    $CompanyWebsite = trim($_POST['CompanyWebsite']);
    $prefix         = 'UPC' . date('y') . date('m'); // e.g. UPC2509
    $timename       = time();

    // ---------- File Upload Helper ----------
    function uploadFile($field, $timename, $maxSize = 5242880) {
        if (isset($_FILES[$field]) && $_FILES[$field]['error'] !== 4) {
            $errorCode = $_FILES[$field]['error'];

            if ($errorCode !== 0) {
                return "Upload failed (error code $errorCode). Please try again.";
            }

            $fileTmp  = $_FILES[$field]['tmp_name'];
            $fileName = $_FILES[$field]['name'];
            $fileSize = $_FILES[$field]['size'];

            if ($fileSize > $maxSize) {
                return "File too large! Max size is 5MB.";
            }

            $check = @getimagesize($fileTmp);
            if ($check === false) {
                return "Invalid file source! Please upload only images from Gallery or Camera, not Google Drive.";
            }

            $ext = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            $allowedExt = ['jpg', 'jpeg', 'png'];
            if (!in_array($ext, $allowedExt)) {
                return "Invalid file type! Only JPG and PNG are allowed.";
            }

            $filename    = $timename . "_" . preg_replace('!\s+!', '-', $fileName);
            $destination = "uploads/" . $filename;

            if (move_uploaded_file($fileTmp, $destination)) {
                return $filename;
            } else {
                return "Failed to save uploaded file. Please try again.";
            }
        }
        return '';
    }

    // ---------- Upload Files ----------
    $errorMsg = "";

    $university_file_name = uploadFile('universityIdAttchment', $timename);
    if ($university_file_name && !file_exists("uploads/" . $university_file_name)) {
        $errorMsg = $university_file_name;
    }

    $photo_id_name = uploadFile('studentphotoId', $timename);
    if ($photo_id_name && !file_exists("uploads/" . $photo_id_name)) {
        $errorMsg = $photo_id_name;
    }

    $profile_photo = uploadFile('profileimg', $timename);
    if ($profile_photo && !file_exists("uploads/" . $profile_photo)) {
        $errorMsg = $profile_photo;
    }

    // ✅ NEW FIELD: Membership Image Upload
    $membership_image = uploadFile('membershipImage', $timename);
    if ($membership_image && !file_exists("uploads/" . $membership_image)) {
        $errorMsg = $membership_image;
    }

    if ($errorMsg !== "") {
        echo "<script>alert('❌ $errorMsg'); window.history.back();</script>";
        exit;
    }

    // ---------- Generate new registration number ----------
    $query  = "SELECT registrationNo FROM userMaster WHERE registrationNo LIKE '$prefix%' 
               ORDER BY registrationNo DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    $row    = mysqli_fetch_assoc($result);

    if ($row) {
        $lastRegNo   = $row['registrationNo'];
        $lastNumber  = (int)substr($lastRegNo, -4);
        $newNumber   = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $newNumber = '0001';
    }
    $registrationNo = $prefix . $newNumber;

    // ---------- Build Update Query ----------
    $setParts = array(
        "EnrollmentNo = '" . mysqli_real_escape_string($conn, $EnrollmentNo) . "'",
        "mobile = '" . mysqli_real_escape_string($conn, $mobile) . "'",
        "photoIdType = '" . mysqli_real_escape_string($conn, $photoIdType) . "'",
        "registrationNo = '" . mysqli_real_escape_string($conn, $registrationNo) . "'",
        "jobTerms = '" . mysqli_real_escape_string($conn, $jobTerms) . "'",
        "profession = '" . mysqli_real_escape_string($conn, $profession) . "'",
        "jobTitle = '" . mysqli_real_escape_string($conn, $jobTitle) . "'",
        "companyName = '" . mysqli_real_escape_string($conn, $companyName) . "'",
        "industryId = '" . mysqli_real_escape_string($conn, $industryId) . "'",
        "linkedIn = '" . mysqli_real_escape_string($conn, $linkedIn) . "'",
        "CompanyWebsite = '" . mysqli_real_escape_string($conn, $CompanyWebsite) . "'"
    );

    if (!empty($university_file_name)) {
        $setParts[] = "universityIdAttchment = '" . mysqli_real_escape_string($conn, $university_file_name) . "'";
    }
    if (!empty($photo_id_name)) {
        $setParts[] = "studentphotoId = '" . mysqli_real_escape_string($conn, $photo_id_name) . "'";
    }
    if (!empty($profile_photo)) {
        $setParts[] = "profilePhoto = '" . mysqli_real_escape_string($conn, $profile_photo) . "'";
    }
    if (!empty($membership_image)) {
        $setParts[] = "MembershipImage = '" . mysqli_real_escape_string($conn, $membership_image) . "'";
    }

    $sql_ins = "UPDATE userMaster SET " . implode(", ", $setParts) . " WHERE userId = '$userId'";
    
    mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

    $_SESSION["s"] = 1;

    echo "<script>
        alert('✅ Saved Successfully! Your UPC Registration No: $registrationNo');
        window.location.href = 'timeline.html';
    </script>";
    exit;
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Job Fair Registration</title>
    <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
    <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/default.css">
    <link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
    <script src="<?php echo $fullurl; ?>js/zebra_datepicker.js"></script>
    <script src="<?php echo $fullurl; ?>js/main.js"></script>
    
    <!-- Include jQuery first -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Select2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<style>
    .select2-container--default .select2-selection--single {
  width: 100%;
  float: left;
  padding: 4px;
  border: solid 1px #e7e7e7 !important;
  max-width: 100%;
  outline: none;
  border-radius: 2px !important;
  height: 38px !important;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
  top: 48% !important;
  transform: translateY(-50%);
  right: 10px;
}

.select2-container--default .select2-dropdown {
  border: 1px solid #e7e7e7 !important;
  border-radius: 2px;
  box-shadow: none;
}


.select2-container--default .select2-results__option {
  border-bottom: 1px solid #e7e7e7;
  padding: 10px;
}


.select2-container--default .select2-results__option:last-child {
  border-bottom: none;
}

.customFlex-wrap {
    display: flex
;
    align-items: center;
    flex-wrap: wrap;
}

.select2-container--default .select2-selection--single .select2-selection__clear {
    margin-right: 30px;
    color: #888888;
}
</style>
    <script>
        $(document).ready(function() {

            $('#eventDate').Zebra_DatePicker({

                format: 'Y-m-d',

                // direction: [1, 400]

            });



            $('#eventTillDate').Zebra_DatePicker({

                format: 'Y-m-d',

                // direction: [1, 400]

            });
        });
    </script>
</head>

<body>
    <div id="wrapper" class="active">
        <?php include('header.php'); ?>
        <div class="container main">
            <div class="premium_tag"><a href="#">Go Premium</a>
                <p id="typewriter"></p>
            </div>
            <div class="home_container">
                <?php include('left-sidebar.php'); ?>
                <div class="center_content">
                    <div class="evnts post">
                        <div class="post-evnt company-edt">
                            <h2>Placement Registration Form for JMI Students</h2>
                            <p>Placement Registration form for students of Jamia Millia Islamia (University Placement
                                Cell, Jamia Millia Islamia)</p>
                             <p style="color:red;">⚠ Please upload document from Camera or Gallery only, not from Google Drive.</p>
                            <?php if(!empty($registrationNo)){ ?>   
                            <p style="color:green;"><b>You are registered with UPC No#: <?php echo $registrationNo; ?></b></p>
                            <?php } ?>
                            
                            <form name="frmcreatecompany" id="frmcreatecompany"  method="post" enctype="multipart/form-data" action="">
                                
                                <div style="display: flex;">
                                  <div style="padding:5px;">
                                    <img style="width:80px;" src="<?php echo $fullurl;?>uploads/<?php if($profilePhoto!=''){ echo $profilePhoto; }else{ echo "user-placeholder.jpg"; } ?>" width="18%" alt="profileimg" />

                                  </div>
                                  <?php if(empty($profilePhoto)){ ?>
                                  <div style="width: 30%;">
                                  <label>Upload Your Photo</label>
                                        <input type="file" accept="image/*"  name="profileimg"  class="validate" style="style="width:80px;" height: 36px;" >
                                  </div>
                                  <?php } ?>
                                </div>
                                
                                
                                <div class="customFlex-wrap">
                                <div class="form-grp fifty pd-right">
                                    <label>Name<span class="reqstar">*</span></label>
                                    <input type="text" name="name" value="<?php echo $myfirstName; ?> <?php echo $mylastName; ?>" readonly maxlength="150" class="validate">

                                </div>
                                <div class="form-grp fifty pd-right">
                                    <label>Department/Faculty<span class="reqstar">*</span></label>
                                    <select class="form-select" name="departmentname" id="departmentname" required>
                                        <option selected>Department</option>
                                        <?php
                                        $selectFields= [];
                                        $whereFields =[];
                                        $whereVals =[];

                                        $sqlOptions = "";
                                        $sqlOptions = "SELECT * FROM " . _DEPARTMENT_MASTER_TABLE_ . " WHERE status=1  order by department_name";
                                        $resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
                                        if ($resOptions) {
                                            while ($rowOptions = mysqli_fetch_array($resOptions)) {

                                        ?>
                                                <option value="<?php echo trim($rowOptions['department_name']); ?>" <?php if($departmentname==$rowOptions['department_name']){ echo "selected"; } ?>><?php echo trim($rowOptions['department_name']); ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-grp fifty pd-right">
                                    <label>Name of Course<span class="reqstar">*</span></label>
                                    <select class="form-select" name="coursename" id="coursename" required>
                                        <option selected>Select Course</option>
                                        <?php
                                        $selectFields =[];
                                        $whereFields =[];
                                        $whereVals= [];

                                        $sqlOptions = "";
                                        $sqlOptions = "SELECT * FROM " . _COURSE_MASTER_TABLE_ . " WHERE status=1 order by course_name";
                                        $resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
                                        if ($resOptions) {
                                            while ($rowOptions = mysqli_fetch_array($resOptions)) {

                                        ?>
                                                <option value="<?php echo trim($rowOptions['course_name']); ?>" <?php if($coursename==$rowOptions['course_name']){ echo "selected"; } ?>><?php echo trim($rowOptions['course_name']); ?></option>
                                        <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <!-- <div class="form-grp fifty pd-right">
                                    <label>Semester<span class="reqstar">*</span></label>
                                    <select class="form-select" name="semester" id="semester" required >
                                        <option option="">Select Semester</option>
                                        <option option="1">1</option>
                                        <option option="2">2</option>
                                        <option option="3">3</option>
                                        <option option="4">4</option>
                                        <option option="5">5</option>
                                        <option option="6">6</option>
                                        <option option="7">7</option>
                                        <option option="8">8</option>
                                    </select>
                                </div> -->
                                <div class="form-grp fifty pd-right">
                                    <label>Year of Passing<span class="reqstar">*</span></label>
                                    <select class="form-select" name="passingyear" id="passingyear" required>
                                        <option option="">Select Year</option>
                                        <option value="2023" <?php if($passingyear=='2023'){ echo "selected"; } ?>>2023</option>
                                        <option value="2024" <?php if($passingyear=='2024'){ echo "selected"; } ?>>2024</option>
                                        <option value="2025" <?php if($passingyear=='2025'){ echo "selected"; } ?>>2025</option>
                                        <?php
                                        $currentdate = date("Y", strtotime('+1 years'));
                                        $end = date('Y-m-d', strtotime('+5 years'));
                                        while ($currentdate <= $end) {
                                        ?>
                                            <option value="<?php echo $currentdate; ?>"
                                                <?php if ($currentdate == $passingyear) {
                                                    echo 'selected';
                                                } ?>> <?php echo $currentdate;
                                            $currentdate++; ?>
                                            </option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-grp fifty pd-right">
                                    <label>Email<span class="reqstar">*</span></label>
                                    <input type="text" name="email" value="<?php echo $myemail; ?>" readonly maxlength="150" class="validate" required>
                                </div>
                                <div class="form-grp fifty pd-right">
                                    <label>Mobile No<span class="reqstar">*</span></label>
                                    <input type="text" name="mobile" id="mobile" value="<?php echo $mymobile; ?>" class="validate" maxlength="10" required>
                                </div>
                                <div class="form-grp fifty pd-right">
                                    <label>Gender<span class="reqstar">*</span></label>
                                    <select class="form-select" name="gender" id="gender" required>
                                        <option option="Male" <?php if($mygender=="Male"){ echo "selected"; } ?>>Male</option>
                                        <option option="Female" <?php if($mygender=="Female"){ echo "selected"; } ?>>Female</option>
                                        <option option="Other" <?php if($mygender=="Other"){ echo "selected"; } ?>>Other</option>
                                    </select>
                                </div>
                                
                                <!-- Industry ID -->
                               <div class="form-grp fifty pd-right">
                                    <label>Industry<span class="reqstar">*</span></label>
                                    <select class="form-select" name="industryId" id="industryId" required>
                                        <option value="">Select Industry</option>
                                        <?php
                                        $selectFields = [];
                                        $whereFields = [];
                                        $whereVals = [];

                                        $sqlOptions = "SELECT id, optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry'";
                                        $resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);

                                        if ($resOptions) {
                                            while ($rowOptions = mysqli_fetch_array($resOptions)) {
                                                $strSelected = ($industryId == $rowOptions['id']) ? 'selected="selected"' : '';
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
                                <div class="form-grp hundred pd-right">
                                    <label>Upload Your University ID<span class="reqstar">*</span></label>
                                    <span>(Image file should be less than 5MB)</span>
                                    <input type="file" accept="image/*" name="universityIdAttchment" id="universityIdAttach" value="" class="validate mt-2" style="height: 36px;" required>
                                </div>
                                <div class="form-grp fifty pd-right">
                                    <label>Enrolment/Roll No.<span class="reqstar">*</span></label>
                                    <input type="text" name="EnrollmentNo" id="EnrollmentNo" value="" class="validate" maxlength="100" placeholder="Enrolment Number" required />
                                </div>
                                
                                <div class="form-grp fifty pd-right">
                                    <label>Photo ID Type<span class="reqstar">*</span></label>
                                    <select class="form-select" name="photoIdType" id="photoIdType" required>
                                        <?php
                        			  	$selectFields= [];
                        				$whereFields =[];
                        				$whereVals =[];
                        			
                        				$sqlOptions1="";
                        				$sqlOptions1="SELECT * FROM documentType ORDER BY name ";
                        				$resOptions1=getRecords("documentType",$selectFields,$whereFields,$whereVals,_Y_,$sqlOptions1); 	
                        				if($resOptions1)
                        				{
                        					while($rowOptions1=mysqli_fetch_array($resOptions1))
                        					{
                        			  ?>
                        			   <option value="<?php echo trim($rowOptions1['id']); ?>" ><?php echo trim($rowOptions1['name']); ?></option>
                        			  <?php
                        			  		}
                        			    }
                        			  ?>
                                    </select>
                                </div>
                                <div class="form-grp hundred pd-right">
                                    <label>Upload Your Photo ID Card<span class="reqstar">*</span></label><br>
                                    <span class="mb-2">(Image file should be less than 5MB)</span>
                                    <input type="file" accept="image/*"  name="studentphotoId" id="studentphotoId" value="" class="validate" style="height: 36px;" required>
                                </div>
                                

                                

                                <!-- Profession (Select Field) -->
                                <div class="form-grp fifty pd-right">
                                    <label>Profession<span class="reqstar">*</span></label>
                                    <select name="profession" id="profession" class="validate" required>
                                        <option value="">-- Select Profession --</option>
                                        <option value="1">Business</option>
                                        <option value="2">Job</option>
                                        <option value="3">Homemaker</option>
                                        <option value="4">Not Working</option>
                                    </select>
                                </div>

                                <!-- Job Title -->
                                <div class="form-grp fifty pd-right">
                                    <label>Job Title<span class="reqstar">*</span></label>
                                    <input type="text" name="jobTitle" id="jobTitle" value="<?php echo $myjobTitle ?? ''; ?>" class="validate" maxlength="100" placeholder="Job Title" required />
                                </div>

                                <div class="form-grp hundred pd-right">
                                    <label>Upload Membership Fee Reciept<span class="reqstar">*</span></label><br>
                                    <h3 style="font-size: 18px;">Bank Details: </h3>
                                    <span class="mb-2" style="font-size: 18px;">AC Name: Jamia Alumni And Donor Endowment Found</span><br>
                                    <span class="mb-2" style="font-size: 18px;">Bank Name : State Bank Of India</span><br>
                                    <span class="mb-2" style="font-size: 18px;">AC No: 41324220286</span><br>
                                    <span class="" style="font-size: 18px;">IFSC CODE: SBIN0006069</span>
                                    <h3>Note: Membership Fee -Rs 1000 for 3 Years & Rs 5000 For Lifetime Membership</h3>
                                    <input type="file" accept="image/*" name="membershipImage" id="membershipImage" value="" class="validate" style="height: 36px;margin-top: 8px;" required>
                                </div>

                                <!-- Company Name -->
                                <div class="form-grp fifty pd-right">
                                    <label>Company Name<span class="reqstar">*</span></label>
                                    <input type="text" name="companyName" id="companyName" value="<?php echo $mycompanyName ?? ''; ?>" class="validate" maxlength="100" placeholder="Company Name" required />
                                </div>


                                <!-- LinkedIn Profile -->
                                <div class="form-grp fifty pd-right">
                                    <label>LinkedIn Profile</label>
                                    <input type="url" name="linkedIn" id="linkedIn" value="<?php echo $mylinkedIn ?? ''; ?>" class="validate" maxlength="255" placeholder="LinkedIn Profile URL" />
                                </div>

                                <!-- Company Website -->
                                <div class="form-grp fifty pd-right">
                                    <label>Company Website</label>
                                    <input type="url" name="CompanyWebsite" id="CompanyWebsite" value="<?php echo $myCompanyWebsite ?? ''; ?>" class="validate" maxlength="255" placeholder="Company Website URL" />
                                </div>


                                <!-- Terms & Conditions Checkbox -->
                                <label style="margin-top:10px;" class="trms">
                                <input required type="checkbox" name="jobTerms" id="jobTerms" class="validate" value="1" autocomplete="off">
                                I wish to abide by all the rules & guidelines given by University Placement Cell from time to time
                            	</label>

                                <!--<div class="form-grp thirty pd-left" style="width: 33% !important;">-->
                                <!--    <label>Preference 1<span class="reqstar">*</span></label>-->
                                <!--    <select name="company1" id="company1" required class="validate">-->
                                <!--        <option value="">Select</option>-->
                                <!--        <option value="Axis Bank">Axis Bank</option>-->
                                <!--        <option value="Brandsun Promotion">Brandsun Promotion</option>-->
                                <!--        <option value="Topline Print & Advertising">Topline Print & Advertising</option>-->
                                <!--        <option value="Kapston Services Pvt Ltd">Kapston Services Pvt Ltd</option>-->
                                <!--        <option value="SIS-V Protect">SIS-V Protect</option>-->
                                <!--        <option value="PVR Cinemas">PVR Cinemas</option>-->
                                <!--        <option value="SBI Cards">SBI Cards</option>-->
                                <!--        <option value="DHL">DHL</option>-->
                                <!--        <option value="Airtel Bharti">Airtel Bharti</option>-->
                                <!--        <option value="Vodafone">Vodafone</option>-->
                                <!--        <option value="Airtel">Airtel</option>-->
                                <!--        <option value="Max Life Insurance">Max Life Insurance</option>-->
                                <!--        <option value="TATA NRI">TATA NRI</option>-->
                                <!--        <option value="American Express">American Express</option>-->
                                <!--        <option value="HSBC">HSBC</option>-->
                                <!--        <option value="Just Dial">Just Dial</option>-->
                                <!--        <option value="Bikaner">Bikaner</option>-->
                                <!--        <option value="SBI (Sboss)">SBI (Sboss)</option>-->
                                <!--        <option value="Formica Laminate">Formica Laminate</option>-->
                                <!--        <option value="Dwija Food">Dwija Food</option>-->
                                <!--        <option value="Dixon Electro Appliances Pvt Ltd">Dixon Electro Appliances Pvt Ltd</option>-->
                                <!--        <option value="Redient Pvt Ltd">Redient Pvt Ltd</option>-->
                                <!--    </select>-->
                                <!--</div>-->
                                <!--<div class="form-grp thirty pd-left" style="width: 33% !important;">-->
                                <!--    <label>Preference 2<span class="reqstar">*</span></label>-->
                                <!--    <select name="company2" id="company2" required class="validate">-->
                                <!--        <option value="">Select</option>-->
                                <!--        <option value="Axis Bank">Axis Bank</option>-->
                                <!--        <option value="Brandsun Promotion">Brandsun Promotion</option>-->
                                <!--        <option value="Topline Print & Advertising">Topline Print & Advertising</option>-->
                                <!--        <option value="Kapston Services Pvt Ltd">Kapston Services Pvt Ltd</option>-->
                                <!--        <option value="SIS-V Protect">SIS-V Protect</option>-->
                                <!--        <option value="PVR Cinemas">PVR Cinemas</option>-->
                                <!--        <option value="SBI Cards">SBI Cards</option>-->
                                <!--        <option value="DHL">DHL</option>-->
                                <!--        <option value="Airtel Bharti">Airtel Bharti</option>-->
                                <!--        <option value="Vodafone">Vodafone</option>-->
                                <!--        <option value="Airtel">Airtel</option>-->
                                <!--        <option value="Max Life Insurance">Max Life Insurance</option>-->
                                <!--        <option value="TATA NRI">TATA NRI</option>-->
                                <!--        <option value="American Express">American Express</option>-->
                                <!--        <option value="HSBC">HSBC</option>-->
                                <!--        <option value="Just Dial">Just Dial</option>-->
                                <!--        <option value="Bikaner">Bikaner</option>-->
                                <!--        <option value="SBI (Sboss)">SBI (Sboss)</option>-->
                                <!--        <option value="Formica Laminate">Formica Laminate</option>-->
                                <!--        <option value="Dwija Food">Dwija Food</option>-->
                                <!--        <option value="Dixon Electro Appliances Pvt Ltd">Dixon Electro Appliances Pvt Ltd</option>-->
                                <!--        <option value="Redient Pvt Ltd">Redient Pvt Ltd</option>-->
                                <!--    </select>-->
                                <!--</div>-->

                                <!--<div class="form-grp thirty pd-left" style="width: 33% !important;">-->
                                <!--    <label>Preference 3<span class="reqstar">*</span></label>-->
                                <!--    <select name="company3" id="company3" required class="validate">-->
                                <!--        <option value="">Select</option>-->
                                <!--        <option value="Axis Bank">Axis Bank</option>-->
                                <!--        <option value="Brandsun Promotion">Brandsun Promotion</option>-->
                                <!--        <option value="Topline Print & Advertising">Topline Print & Advertising</option>-->
                                <!--        <option value="Kapston Services Pvt Ltd">Kapston Services Pvt Ltd</option>-->
                                <!--        <option value="SIS-V Protect">SIS-V Protect</option>-->
                                <!--        <option value="PVR Cinemas">PVR Cinemas</option>-->
                                <!--        <option value="SBI Cards">SBI Cards</option>-->
                                <!--        <option value="DHL">DHL</option>-->
                                <!--        <option value="Airtel Bharti">Airtel Bharti</option>-->
                                <!--        <option value="Vodafone">Vodafone</option>-->
                                <!--        <option value="Airtel">Airtel</option>-->
                                <!--        <option value="Max Life Insurance">Max Life Insurance</option>-->
                                <!--        <option value="TATA NRI">TATA NRI</option>-->
                                <!--        <option value="American Express">American Express</option>-->
                                <!--        <option value="HSBC">HSBC</option>-->
                                <!--        <option value="Just Dial">Just Dial</option>-->
                                <!--        <option value="Bikaner">Bikaner</option>-->
                                <!--        <option value="SBI (Sboss)">SBI (Sboss)</option>-->
                                <!--        <option value="Formica Laminate">Formica Laminate</option>-->
                                <!--        <option value="Dwija Food">Dwija Food</option>-->
                                <!--        <option value="Dixon Electro Appliances Pvt Ltd">Dixon Electro Appliances Pvt Ltd</option>-->
                                <!--        <option value="Redient Pvt Ltd">Redient Pvt Ltd</option>-->
                                <!--    </select>-->
                                <!--</div>-->

                                <input type="hidden" id="action" name="action" value="addcompany">
                                <input type="hidden" id="postId" name="postId" value="<?php echo $_SESSION['sessUserId']; ?>">

                                



                        </div>
                        <div class="pst-evnt-btns comp">
                            <button type="submit">Submit</button>
                        </div>
                        </form>


                    </div>
                </div>
            </div>
        </div>
        <?php include('footer.php'); ?>
    </div>

<script>
$(document).ready(function() {
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

</body>

</html>