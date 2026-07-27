<?php
include_once('inc.php');

$_SESSION['loginredirectpageurl'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 27;


if ($_REQUEST['numberofMentees'] != 0 && $_REQUEST['numberofMentees'] != '') {


	$insertFields = [];
	$insertVals = [];
	$whereFields = [];
	$whereVals = [];

	$insertFields[0] = "numberofMentees";
	$insertVals[0] = clean($_REQUEST['numberofMentees']);

	$whereFields[0] = "userId";
	$whereVals[0] = $_SESSION['sessUserId'];

	$resUpdate = updateDB(_USERS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

}

if ($_REQUEST['studentIdcontact'] != '' && $_REQUEST['action'] == 'actrequest') {

	$dateAdded = time();
	$studentIdcontact = decodeStr($_REQUEST['studentIdcontact']);

	$sql_ins = "UPDATE " . _STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_ . " SET status=1 WHERE studentId= " . $studentIdcontact . " AND mentorId='" . $_SESSION["sessUserId"] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "DELETE from  " . _STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_ . " where studentId= " . $studentIdcontact . " AND mentorId!='" . $_SESSION["sessUserId"] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	header('Location: become-a-mentor.html');
}

if (trim($_REQUEST['removeresion']) != '') {

	$studentId = $_REQUEST['id'];
	$status = $_REQUEST['status'];
	$mentorId = $_SESSION["sessUserId"];
	$reason = $_REQUEST['removeresion'];

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];
	$insertFields = [];
	$insertVals = [];


	$sql_ins = "DELETE FROM " . _STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_ . " WHERE mentorId= " . $_SESSION["sessUserId"] . " AND studentId='" . $studentId . "' ";

	$insertFields[0] = "studentId";
	$insertFields[1] = "mentorId";
	$insertFields[2] = "status";
	$insertFields[3] = "reason";
	$insertFields[4] = "datedeleted";

	$insertVals[0] = $studentId;
	$insertVals[1] = $mentorId;
	$insertVals[2] = $status;
	$insertVals[3] = $reason;
	$insertVals[4] = time();

	$resUpdate = insertDB(_STUDENT_REMOVE_REASON_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	$_SESSION["d"] = 1;
	header('Location: become-a-mentor.html');
	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>My Contacts - <?php echo $companyname; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta content="en" name="language">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
</head>

<body>
	<div id="wrapper" class="">
		<?php include('header.php'); ?>
		<div class="container main">
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content">
					<div class="pnding-contct becomementordiv">
						
						<div class="mentrbelwborder">
							<script>
								function funcEditMentor() {
									$("#numberofMentees").removeAttr("disabled")
								}
								function mentorSearch() {
									var mentorSearch = $("#mentorSearch").val();
									mentorSearch = encodeURIComponent($.trim(mentorSearch));

									$('#mentorSearchBox').load('<?php echo $fullurl; ?>mentorSearchBox.php?mentorSearch=' + mentorSearch);
								}
							</script>
							<script>
								function subsrchmentorfrm() {

									if ($("#mentorSearch").val() != '') {
										$("#mentorsrchFrm").submit();
									}
								}

								$("input").keypress(function (event) {

									if (event.which == 13) {
										event.preventDefault();

										if ($("#mentorSearch").val() != '') {
											$("#mentorsrchFrm").submit();
										}
									}
								});

							</script>
							<style>
								#mentorSearchBox {
									width: 100%;
									max-height: 350px;
									overflow: auto;
									position: absolute;
									left: 0px;
									top: 33px;
									border: 1px solid #f3f3f3;
									border-radius: 2px;
									box-shadow: 0px 4px 4px #b7b5b5;
									display: none;
									background-color: #fff;
								}
							</style>
							<div class="menteesearchdiv">
								<form name="mentorsrchFrm" id="mentorsrchFrm">
									<input type="text" name="mentorSearch" id="mentorSearch"
										value="<?php echo $_GET['mentorSearch']; ?>" maxlength="60"
										placeholder="Enter name or email address" autocomplete="off"
										onkeyup="mentorSearch()">
									<button type="button" class="serachwithmenteebtn"
										onClick="subsrchmentorfrm();">Search</button>
								</form>
							</div>
							<div class="menttwobuttons">
								<?php
								$selectFields = [];
								$whereFields = [];
								$whereVals = [];

								$sqlLogin1 = "";
								$sqlLogin1 = "select id from " . _STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_ . " where mentorId='" . $_SESSION["sessUserId"] . "' and status=1 ";
								$resLogin1 = getRecords(_STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin1);
								if ($resLogin1) {
									$maccepted = mysqli_num_rows($resLogin1);
								} else {
									$maccepted = 0;
								}



								$remaining = '0';
								$accepted = $maccepted;

								$remaining = $usersnumberofMentees - $maccepted;
								if ($remaining < 0) {
									$remaining = 0;
								} else {
									$remaining = $remaining;
								}
								?>


								<button type="submit" class="hirestudentbtn"> Accepted <?php echo $accepted; ?>
									Students</button>
								<!-- <button type="submit" class="hirestudentbtn remainingstudens">Remaining
									<?php echo $remaining; ?> Students</button> -->
							</div>
						</div>
						<div class="contct-list-cont mentormargtop">
							<ul class="cntct-list studencaseul">

								<?php
								$n = 0;
								$selectFields = [];
								$whereFields = [];
								$whereVals = [];

								$sqlLogin = "";
								$sqlLogin = "select * from " . _STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_ . " where mentorId='" . $_SESSION['sessUserId'] . "'";
								$resLogin = getRecords(_STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
								if ($resLogin) {
									while ($rowLogin = mysqli_fetch_array($resLogin)) {

										$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin["studentId"] . "";
										$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
										$userres = mysqli_fetch_array($b);

										$friendnameurl = $userres['userurl'];
										if ($userres["profilePhoto"] != '') {
											$userphoto = $userres["profilePhoto"];
										} else {
											$userphoto = 'user-placeholder.jpg';
										}

										$mycountryName = $userres["countryName"];
										$mystateName = $userres["cityName"];
										$mylocationName = $userres["locationName"];
										$mycompanyName = $userres["companyName"];
										$myjobTitle = $userres["jobTitle"];
										$mycoursename = $userres["coursename"];
										$mydepartmentname = $userres["departmentname"];


										?>
										<li class="listwidthnew newliwidthmenti">
											<div class="request-contct rerestmentcontact becomementdiv">
												<div class="rimg"> <a
														href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html">
														<img
															src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>">
													</a>
												</div>
												<style>
												</style>
												<div class="reqst-rdtail rewqnewdte newdivimagecc" style="height:auto;">
													<div class="middl-nm">
														<div class="left"> <a
																href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																class="nm"><?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["firstName"]); ?>
																<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["lastName"]);//stripslashes(trim($userres["lastName"])); ?></a>
															<span class="comp"><?php echo $userres['coursename']; ?> ,
																Student</span>
															<span class="comp"> <?php echo $userres['companyName']; ?></span>
														</div>
													</div>
												</div>
											</div>
											
										</li>
										<?php

										$n++;
									}
								}
								?>
								<?php if ($n == 0) { ?>
									<div style="padding:0px; text-align:center;">
										<div style="text-align:center;">No pending requests</div>
									</div>

									<script>
										$('#pagetitlemain2').hide();
									</script>
								<?php } ?>
							</ul>
							<?php if ($n == 0) { ?>
								<div style="padding:30px; text-align:center;">
									<div style="text-align:center; margin-bottom:20px;"></div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<?php include('footer.php'); ?>

	<script>
		function reloadPage() {
			location.reload(true);
		}
	</script>
</body>

</html>