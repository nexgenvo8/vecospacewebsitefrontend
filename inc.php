<?php
ini_set('session.gc_maxlifetime', 2592000); // 30 days
ini_set('session.cookie_lifetime', 2592000); // 30 days
session_set_cookie_params(2592000); // 30 days

session_start();

error_reporting(0);
// error_reporting(E_ALL);
// ini_set('display_errors', 1);


include_once('config/config.php'); // contains all the defined common variables used in application
include_once('config/database.php'); // contains all the tailored datbase functions to avoid direct query execution
include_once('config/functions.php'); // contains all the functions used in the application
ini_set('upload_max_filesize', '40M');
ini_set('post_max_size', '40M');

function openConn()
{
	$conn = new mysqli(_DATABASE_HOST_, _DATABASE_USERNAME_, _DATABASE_PASSWORD_, _DATABASE_NAME_);
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}
	return $conn;
}
mysqli_set_charset($conn, "utf8mb4");

// $fullurl = 'https://jmi.vecospace.com/';
// $withoutwwwurl = 'https://jmi.vecospace.com/';
// $withouthttpsurl = 'https://jmi.vecospace.com/';
// $domainname = 'vecospace.com';

$fullurl = 'https://ndim.vecospace.com/';
$withoutwwwurl = 'https://ndim.vecospace.com/';
$withouthttpsurl = 'https://ndim.vecospace.com/';
$domainname = 'vecospace.com';

$actual_sitelink1 = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'];

$copyright = "&copy; The copyright is Debox Global | All rights reserved";

function error_found($id)
{
	global $fullurl;
	header("Location: " . $fullurl . "404error.html");
	exit();
}

$companyname = 'Welcome to NDIM VECOSPACE';
$companNameTitle = 'NDIM VECOSPACE';
$ndimvecospace = 'Corrintech Technology Pvt. Ltd';

// ✅ fixed session check (your OR condition was always true)
if (isset($_SESSION["sessUserId"]) && $_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0 && is_numeric($_SESSION["sessUserId"])) {

	$sqlLogin = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
	$resLogin = mysqli_query($conn, $sqlLogin) or die(mysqli_error($conn));

	if ($resLogin && mysqli_num_rows($resLogin) > 0) {
		while ($rowLogin = mysqli_fetch_assoc($resLogin)) {
			$employmentId = $rowLogin["employmentId"];
			$membershipId = $rowLogin["membershipId"];
			$jobTitle = $rowLogin["jobTitle"];
			$companyName = $rowLogin["companyName"];
			$industryId = $rowLogin["industryId"];
			$userurl = $rowLogin["userurl"];
			$myemail = $rowLogin["email"];
			$mymobile = $rowLogin["mobile"];
			$myfirstName = $rowLogin["firstName"];
			$mylastName = $rowLogin["lastName"];
			$myname = ucfirst($rowLogin["firstName"]) . ' ' . ucfirst($rowLogin["lastName"]);
			$myurl = $rowLogin["userurl"];
			$mycountryName = $rowLogin["countryName"];
			$mystateName = $rowLogin["cityName"];
			$mylocationName = $rowLogin["locationName"];
			$mygender = $rowLogin["gender"];
			$coursename = $rowLogin["coursename"];
			$departmentname = $rowLogin["departmentname"];
			$passingyear = $rowLogin["passingyear"];
			$usersType = $rowLogin["userstype"];
			$usersnumberofMentees = $rowLogin["numberofMentees"];
			$profilePhoto = $rowLogin["profilePhoto"];
			$taglineText = $rowLogin["taglineText"];
			$dob = $rowLogin["dob"];
			$onlineDateTime = $rowLogin["onlineDateTime"];
			$userpasswordchanged = $rowLogin["password"];
			$TimeZone = $rowLogin["timeZone"];
			$userAccountCloseStatus = $rowLogin["userAccountCloseStatus"];
			$optional = $rowLogin["optional"];
			$dobArr = explode("-", $dob);
			$year = $dobArr[0] ?? '';
			$month = $dobArr[1] ?? '';
			$day = $dobArr[2] ?? '';

			$universityIdAttchment = $rowLogin["universityIdAttchment"];
			$studentphotoId = $rowLogin["studentphotoId"];
			$jobTerms = $rowLogin["jobTerms"];
			$mystudentId = $rowLogin["studentId"];
			$registrationNo = $rowLogin["registrationNo"];

			$myprofilePhoto = $profilePhoto != '' ? $profilePhoto : 'user-placeholder.jpg';
			$oldprofilePhoto = $profilePhoto;

			$userActiveYN = $rowLogin["activeYN"];
		}

		// Account inactive? force logout
		if ($userActiveYN == 'N') {
			$sql_ins = "UPDATE " . _USERS_MASTER_TABLE_ . " SET onlineStatus=0 WHERE userId='" . $_SESSION['sessUserId'] . "'";
			mysqli_query($conn, $sql_ins);

			$sql_ins = "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET onlineStatus=0 WHERE userId='" . $_SESSION['sessUserId'] . "'";
			mysqli_query($conn, $sql_ins);

			$sql_ins = "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET onlineStatus=0 WHERE contactId='" . $_SESSION['sessUserId'] . "'";
			mysqli_query($conn, $sql_ins);

			unset($_SESSION["sessFname"], $_SESSION["sessFullName"], $_SESSION["sessEmail"], $_SESSION["sessUserId"], $_SESSION["activeYN"], $_SESSION['groupjoiningurl']);
			session_destroy();
			?>
			<script>window.location.href = '<?php echo $fullurl; ?>useraccount.html';</script>
			<?php
			exit();
		}
	}

	// Update online status
	$currentLogintime = date('Y-m-d H:i:s', strtotime('-10 minutes'));
	mysqli_query($conn, "UPDATE " . _USERS_MASTER_TABLE_ . " SET onlineStatus=0 WHERE onlineDateTime<'" . $currentLogintime . "'");

	mysqli_query($conn, "UPDATE " . _USERS_MASTER_TABLE_ . " SET onlineStatus=1,onlineDateTime='" . date("Y-m-d H:i:s") . "' WHERE userId='" . $_SESSION["sessUserId"] . "'");
	mysqli_query($conn, "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET onlineStatus=1 WHERE contactId='" . $_SESSION["sessUserId"] . "'");

	// Contact requests
	$sql_contact = "SELECT * FROM " . _CONTACT_MASTER_TABLE_ . " WHERE userId=" . $_SESSION["sessUserId"] . " AND status=0";
	$res_contact = mysqli_query($conn, $sql_contact);
	$contactrequests = mysqli_num_rows($res_contact);

	// User notification settings
	$getsqls = "SELECT allowFuturePostsComments,notiPostCommentsAllow,notiNewPositionEmployer,notiMeetingRequest,notiProjectApplied,notiJoinGroupRequestAllow,notiPostLikesAllow 
                FROM " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId=" . $_SESSION['sessUserId'];
	$getSqlsRes = mysqli_query($conn, $getsqls);
	$getUSettings = mysqli_fetch_assoc($getSqlsRes);

	$strSettWhere = "";
	if ($getUSettings["allowFuturePostsComments"] == 0)
		$strSettWhere .= " and postType!=10 ";
	if ($getUSettings["notiPostCommentsAllow"] == 0)
		$strSettWhere .= " and notificationText NOT IN ('postcomment','articlecomment','groupcomment') ";
	if ($getUSettings["notiNewPositionEmployer"] == 0)
		$strSettWhere .= " and postType!=13 ";
	if ($getUSettings["notiMeetingRequest"] == 0)
		$strSettWhere .= " and postType!=120 ";
	if ($getUSettings["notiProjectApplied"] == 0)
		$strSettWhere .= " and postType!=14 ";
	if ($getUSettings["notiJoinGroupRequestAllow"] == 0)
		$strSettWhere .= " and notificationText!='acceptgrouprequest' ";
	if ($getUSettings["notiPostLikesAllow"] == 0)
		$strSettWhere .= " and notificationText!='postlike' ";

	// Notifications
	$sql_contact = "SELECT * FROM " . _NOTIFICATION_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' AND status=0 AND contactId!='" . $_SESSION['sessUserId'] . "' $strSettWhere";
	$res_contact = mysqli_query($conn, $sql_contact);
	$notifications = mysqli_num_rows($res_contact);
	// --- Initialize profile count variables to 0 (to avoid undefined warnings)
	$totalkeyskillscount = 0;
	$totalexploringcount = 0;
	$totalprofessionalcount = 0;
	$totaleducationalcount = 0;
	$totallanguagescount = 0;
	$totalinterestcount = 0;

	// --- Run profile count queries (if session is active)
	if (isset($_SESSION['sessUserId']) && !empty($_SESSION['sessUserId'])) {
		$totalkeyskillscount = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM " . _SKILL_EXPERIENCE_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "'"));
		$totalexploringcount = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM " . _EXPLORING_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "'"));
		$totalprofessionalcount = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "'"));
		$totaleducationalcount = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM " . _EDUCATIONAL_BACKGROUND_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "'"));
		$totallanguagescount = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM " . _LANGUAGES_KONECTT_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "'"));
		$totalinterestcount = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM " . _INTERESTS_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "'"));
	}

	// --- Profile rank calculation
	$profilerank = 20;

	if ($totalkeyskillscount > 0)
		$profilerank += 10;
	if ($totalexploringcount > 0)
		$profilerank += 10;
	if ($totalprofessionalcount > 0)
		$profilerank += 25;
	if ($totaleducationalcount > 0)
		$profilerank += 25;
	if ($totallanguagescount > 0)
		$profilerank += 2.5;
	if ($totalinterestcount > 0)
		$profilerank += 2.5;
	if (!empty($taglineText))
		$profilerank += 5;


	// Detect mobile
	$useragent = $_SERVER['HTTP_USER_AGENT'];
	$mobile = 'n';
	if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|.../i', $useragent)) {
		$mobile = 'y';
	}
}



function cleanquestionmark($text)
{
	return str_replace("?", "", $text); // remove question marks
}




?>