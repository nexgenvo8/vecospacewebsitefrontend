<?php

include_once('inc.php');
$_SESSION['loginredirectpageurl'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 22;
$search = '';
$startpage = $_REQUEST['startpage'] ?? '';
$endpage = $_REQUEST['endpage'] ?? '';
$pageid = $_REQUEST['pageid'] ?? '';
if (isset($_REQUEST['searchcontacts']) && $_REQUEST['searchcontacts'] != '') {
	$search = clean($_REQUEST['searchcontacts']);
}
if ($search == '') {
	$active = 1;
	if (isset($_REQUEST['r']) && $_REQUEST['r'] == 1) {
		$active = 2;
	}
}


$strWhereCourse = "";
$strWhereDepartment = "";
$strWhereUserType = "";
$strWherePassingYear = "";

// Clean the inputs to prevent injection
$strSearchCourse = isset($_GET["courseName"]) ? clean($_GET["courseName"]) : '';
$strSearchDepartment = isset($_GET["departmentName"]) ? clean($_GET["departmentName"]) : '';
$strSearchUserType = isset($_GET["userType"]) ? clean($_GET["userType"]) : '';
$strSearchPassingYear = isset($_GET["passingYear"]) ? clean($_GET["passingYear"]) : '';


// Course filter
if ($strSearchCourse != '' && $strSearchCourse != 'Course') {
	$strWhereCourse = " AND coursename LIKE '%" . $strSearchCourse . "%' ";
}

// Department filter
if ($strSearchDepartment != '' && $strSearchDepartment != 'Department') {
	$strWhereDepartment = " AND departmentName LIKE '%" . $strSearchDepartment . "%' ";
}

// User Type filter
if ($strSearchUserType != '' && $strSearchUserType != '0' && $strSearchUserType != 'User Type') {
	$strWhereUserType = " AND userstype = '" . $strSearchUserType . "' ";
}

// Passing Year filter
if ($strSearchPassingYear != '' && $strSearchPassingYear != 'Passing Year') {
	$strWherePassingYear = " AND passingyear = '" . $strSearchPassingYear . "' ";
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
			<div class="premium_tag"><a href="#">Go Premium</a>
				<p id="typewriter"></p>
			</div>
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content">
					<div class="contact">
						<div class="contct-srch">
							<?php if (isset($_POST['s']) && $_SESSION["s"] == 1) {
								if ($_REQUEST['q'] == 1) { ?>
									<div style="padding: 10px;
								background-color: #d7f5bb;
								margin-bottom: 9px;
								border-radius: 5px;
								text-align: center;
								font-weight: bold;
								border: 1px solid #ccecad;">Invitation has been sent.</div>
								<?php }
								$_SESSION["s"] = '';
							} ?>

							<?php if (isset($_POST['q']) && $_REQUEST['q'] == 2) { ?>
								<div style="padding: 10px;
							background-color: #fff3f3;
							margin-bottom: 9px;
							border-radius: 5px;
							text-align: center;
							font-weight: bold;
							border: 1px solid #ffdfdf;
							color: #de5454;">This email already registered with <?php echo $companNameTitle; ?>.</div>
							<?php } ?>
							<form method="get" name="frmsearchcontacts" id="frmsearchcontacts">
								<div class="srchfcontct">
									<span>Search for contacts</span>
									<div class="srch-field">
										<input type="text" name="searchkeywords" id="searchkeywords"
											value="<?php echo isset($_GET['searchkeywords']) ? htmlspecialchars($_GET['searchkeywords']) : ''; ?>"
											maxlength="60" placeholder="Enter name or email address" class="validate">

										<button type="button"
											onClick="formValidation('frmsearchcontacts');subsrchfrm();">Search</button>
									</div>
								</div>
							</form>
							<script>
								function subsrchfrm() {

									if ($("#searchkeywords").val() != '') {
										$("#frmsearchcontacts").submit();
									}
								}

								$("input").keypress(function (event) {

									if (event.which == 13) {
										event.preventDefault();

										if ($("#searchkeywords").val() != '') {
											$("#frmsearchcontacts").submit();
										}
									}
								});




							</script>
							<form enctype="multipart/form-data" name="frmposthome4" id="frmposthome4" method="post"
								target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
								<div class="srchfcontct" style="margin-left:17px;">
									<span>Invite people to <?php echo $companNameTitle; ?></span>
									<div class="srch-field">
										<input type="hidden" name="action" value="sendinvitation">
										<input type="email" name="txtuseremail1" id="txtuseremail1" maxlength="250"
											placeholder="Separate e-mail addresses with commas." class="validate">
										<button type="button" onClick="formValidation('frmposthome4');subsrchfrm1();"
											style="cursor: default;">Invite</button>
									</div>
								</div>
							</form>

							<script>


								function subsrchfrm1() {

									if ($("#txtuseremail1").val() != '') {
										$("#frmposthome4").submit();
									}
								}

								$("input").keypress(function (event) {

									if (event.which == 13) {
										event.preventDefault();

										if ($("#txtuseremail1").val() != '') {
											$("#frmposthome4").submit();
										}
									}
								});

							</script>
						</div>
						<div class="pnding-contct">
							<h2 id="pagetitlemain2">Pending contact requests</h2>
							<ul class="cntct-list">

								<?php
								$n = 0;
								$selectFields = [];
								$whereFields = [];
								$whereVals = [];

								$sqlLogin = "";
								$sqlLogin = "select * from " . _CONTACT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and status=0  and userId!=106 ";
								$resLogin = getRecords(_CONTACT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
								if ($resLogin) {
									while ($rowLogin = mysqli_fetch_array($resLogin)) {

										$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin["contactId"] . "";
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


										?>
										<?php


										?>

										<li>
											<div class="request-contct">
												<div class="rimg"><a
														href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
														target="_blank" class="rqst-img"><img
															src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
												</div>
												<div class="reqst-rdtail">
													<div class="middl-nm">
														<div class="left"><a
																href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																target="_blank"><?php echo stripslashes(trim($userres["firstName"])); ?>
																<?php echo stripslashes(trim($userres["lastName"])); ?></a>
															<span class="comp"><?php echo $userres['jobTitle']; ?> at
																<?php echo $userres['companyName']; ?></span>
														</div>
														<div class="btns">
															<a class="msg-btn"
																href="common_action.php?userIdcontact=<?php echo encodeStr($userres['userId']); ?>&action=act"
																target="actionfrm" onClick="$('#commonloader').show();"
																style="margin-left: 10px; color: #1a94c3; border-color: #1a94c3;">Confirm</a>
															<a class="msg-btn reject dlt"
																href="common_action.php?userIdcontact=<?php echo encodeStr($userres['userId']); ?>&action=dec"
																target="actionfrm"
																onClick="$('#commonloader').show();">Decline</a>
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
										<div style="text-align:center;">No pending contact requests</div>
									</div>

									<script>
										$('#pagetitlemain2').hide();
									</script>
								<?php } ?>
							</ul>
						</div>

						<div class="contct-list-cont">
							<form method="GET" action="contacts.html" name="frmsearchcontacts" id="frmsearchcontacts">
								<div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">

									<!-- Course Name -->
									<div class="srchfcontct" style="flex: 0 0 45%; box-sizing: border-box;">
										<span>Course Name</span>
										<div class="srch-field" style="display: flex; align-items: center; gap: 10px;">
											<select name="courseName" id="courseName" class="validate" style="
												width: 100%;
												padding: 8px 10px;
												font-size: 14px;
												border: 1px solid #ccc;
												border-radius: 4px;
												outline: none;
												background-color: #fff;
												box-sizing: border-box;
											">
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
											<button type="submit" style="
												padding: 8px 16px;
												border: none;
												border-radius: 4px;
												background-color: #20741f;
												color: #fff;
												cursor: pointer;
											">Search</button>
										</div>
									</div>

									<!-- Department Name -->
									<div class="srchfcontct" style="flex: 0 0 45%; box-sizing: border-box;">
										<span>Department Name</span>
										<div class="srch-field" style="display: flex; align-items: center; gap: 10px;">
											<select name="departmentName" id="departmentName" class="validate" style="
											width: 100%;
											padding: 8px 10px;
											font-size: 14px;
											border: 1px solid #ccc;
											border-radius: 4px;
											outline: none;
											background-color: #fff;
											box-sizing: border-box;
										">
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
											<button type="submit" style="
											padding: 8px 16px;
											border: none;
											border-radius: 4px;
											background-color: #20741f;
											color: #fff;
											cursor: pointer;
										">Search</button>
										</div>
									</div>

									<!-- Passing Year -->
									<div class="srchfcontct" style="flex: 0 0 45%; box-sizing: border-box;">
										<span>Passing Year</span>
										<div class="srch-field" style="display: flex; align-items: center; gap: 10px;">
											<select name="passingYear" id="passingYear" class="validate" style="
												width: 100%;
												padding: 8px 10px;
												font-size: 14px;
												border: 1px solid #ccc;
												border-radius: 4px;
												outline: none;
												background-color: #fff;
												box-sizing: border-box;
											">
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
											<button type="submit" style="
											padding: 8px 16px;
											border: none;
											border-radius: 4px;
											background-color: #20741f;
											color: #fff;
											cursor: pointer;
										">Search</button>
										</div>
									</div>

									<!-- User Type -->
									<div class="srchfcontct" style="flex: 0 0 45%; box-sizing: border-box;">
										<span>User Type</span>
										<div class="srch-field" style="display: flex; align-items: center; gap: 10px;">
											<select name="userType" id="userType" class="validate" style="
											width: 100%;
											padding: 8px 10px;
											font-size: 14px;
											border: 1px solid #ccc;
											border-radius: 4px;
											outline: none;
											background-color: #fff;
											box-sizing: border-box;
										">
												<option value="1">Student</option>
												<option value="2">Faculty</option>
												<option value="3">Alumni</option>
												<option value="4">Industry Professional</option>
											</select>
											<button type="submit" style="
												padding: 8px 16px;
												border: none;
												border-radius: 4px;
												background-color: #20741f;
												color: #fff;
												cursor: pointer;
											">Search</button>
										</div>
									</div>
									<!-- Industry Name -->
									<!-- Industry Name (Left-aligned) -->
									<!-- <div class="srchfcontct"
										style="flex: 0 0 45%; box-sizing: border-box; margin-bottom: 10px;">
										<span>Industry Name</span>
										<div class="srch-field" style="display: flex; align-items: center; gap: 10px;">
											<select name="industryId" id="industryId" class="validate" style="
											width: 100%;
											padding: 8px 10px;
											font-size: 14px;
											border: 1px solid #ccc;
											border-radius: 4px;
											outline: none;
											background-color: #fff;
											box-sizing: border-box;
										">
												<option value="0">Industry</option>
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
											<button type="submit" style="
												padding: 8px 16px;
												border: none;
												border-radius: 4px;
												background-color: #20741f;
												color: #fff;
												cursor: pointer;
											">
												Search
											</button>
										</div>
									</div> -->



								</div>
							</form>



							<?php if (isset($_Get['searchkeywords']) && $_GET['searchkeywords'] != '') {

								$strWhereContacts .= "";
								$strWhereContacts .= " and  (firstName like '%" . $_GET['searchkeywords'] . "%' OR lastName like '%" . $_GET['searchkeywords'] . "%' OR email like '%" . $_GET['searchkeywords'] . "%' ) ";
								?>

								<?php
							} else {
								$strWhereContacts = "";
								?>
								<h2>People you may know</h2>
							<?php } ?>

							<?php
							$startpage = $_REQUEST['startpage'] ?? 0; // Default start at 0
							$limit = $_REQUEST['endpage'] ?? 10; // Default 10 records per page
							
							$strWhere = '';

							if (isset($_POST['r']) && $_REQUEST['r'] == 1) {
								$strWhere .= " and dateAdded between " . strtotime(date('Y-m-d', strtotime("-30 days"))) . " and " . strtotime(date('Y-m-d')) . " ";
							}

							if ($search != '') {
								$strWhere .= " and contactId IN(select userId from " . _USERS_MASTER_TABLE_ . " where activeYN='Y' and userId!=106 and (firstName like '%" . $search . "%' OR lastName like '%" . $search . "%' OR email like '%" . $search . "%' ) ) ";
							}

							$n = 0;
							$selectFields = [];
							$whereFields = [];
							$whereVals = [];

							// Count total records for pagination
							$sqlCount = "SELECT COUNT(*) as total FROM " . _USERS_MASTER_TABLE_ . " 
							WHERE activeYN='Y' 
							AND userId!=106 
							AND userId NOT IN (SELECT contactId FROM " . _CONTACT_MASTER_TABLE_ . " WHERE userId=" . $_SESSION["sessUserId"] . ")
							AND userId NOT IN (SELECT userId FROM " . _CONTACT_MASTER_TABLE_ . " WHERE contactId=" . $_SESSION["sessUserId"] . ")
							AND companyName!='' 
							AND userId!='" . $_SESSION['sessUserId'] . "' " . $strWhere;
							$resCount = mysqli_query($conn, $sqlCount) or die(mysqli_error($conn));
							$rowCount = mysqli_fetch_assoc($resCount);
							$totalRecords = $rowCount['total'];

							// Main query with LIMIT for pagination
							$sqlLogin = "
								SELECT * FROM " . _USERS_MASTER_TABLE_ . "
								WHERE activeYN='Y' 
								AND userId!=106 
								AND userId NOT IN (
									SELECT contactId FROM " . _CONTACT_MASTER_TABLE_ . " 
									WHERE userId=" . intval($_SESSION["sessUserId"]) . "
								)
								AND userId NOT IN (
									SELECT userId FROM " . _CONTACT_MASTER_TABLE_ . " 
									WHERE contactId=" . intval($_SESSION["sessUserId"]) . "
								)
								AND companyName!=''
								AND userId!='" . intval($_SESSION['sessUserId']) . "'
								" . $strWhereCourse . "
								" . $strWhereDepartment . "
								" . $strWhereUserType . "
								" . $strWherePassingYear . "
								ORDER BY userId DESC
								LIMIT " . intval($startpage) . ", " . intval($limit) . "
							";


							$resLogin = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
							?>

							<ul class="cntct-list">
								<?php
								if ($resLogin) {
									while ($rowLogin = mysqli_fetch_array($resLogin)) {
										$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin["userId"];
										$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
										$userres = mysqli_fetch_array($b);

										$friendnameurl = $userres['userurl'];
										$userphoto = ($userres["profilePhoto"] != '') ? $userres["profilePhoto"] : 'user-placeholder.jpg';
										?>
										<li>
											<div class="request-contct">
												<div class="rimg">
													<a
														href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html">
														<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"
															style="border:<?php echo profileborder($userres['userstype']); ?>">
													</a>
												</div>
												<div class="reqst-rdtail">
													<div class="middl-nm">
														<div class="left">
															<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																class="nm">
																<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["firstName"]); ?>
																<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["lastName"]); ?>
															</a>
															<span class="comp"><?php echo $userres['jobTitle']; ?> at
																<?php echo $userres['companyName']; ?></span>
														</div>
														<div class="btns">
															<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																class="msg-btn">
																<i class="fa fa-plus" aria-hidden="true"></i> Add as contact
															</a>
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
							</ul>



							<?php
							$limit = 10; // records per page
							$startpage = isset($_GET['startpage']) ? intval($_GET['startpage']) : 0;

							// Preserve filters in pagination URLs
							$courseName = isset($_GET['courseName']) ? urlencode($_GET['courseName']) : '';
							$departmentName = isset($_GET['departmentName']) ? urlencode($_GET['departmentName']) : '';
							$userType = isset($_GET['userType']) ? urlencode($_GET['userType']) : '';
							$passingYear = isset($_GET['passingYear']) ? urlencode($_GET['passingYear']) : '';

							// Build query string for filters (excluding startpage)
							$queryString = "courseName={$courseName}&departmentName={$departmentName}&userType={$userType}&passingYear={$passingYear}";

							$totalRecordsQuery = "
	SELECT COUNT(*) as total
	FROM " . _USERS_MASTER_TABLE_ . "
	WHERE activeYN = 'Y'
	AND userId != 106
	AND userId NOT IN (
		SELECT contactId
		FROM " . _CONTACT_MASTER_TABLE_ . "
		WHERE userId = " . intval($_SESSION['sessUserId']) . "
	)
	AND userId NOT IN (
		SELECT userId
		FROM " . _CONTACT_MASTER_TABLE_ . "
		WHERE contactId = " . intval($_SESSION['sessUserId']) . "
	)
	AND companyName != ''
	AND userId != " . intval($_SESSION['sessUserId']) . "
	" . $strWhereCourse . "
	" . $strWhereDepartment . "
	" . $strWhereUserType . "
	" . $strWherePassingYear . "
";


							$totalResult = mysqli_query($conn, $totalRecordsQuery);
							$totalRow = mysqli_fetch_assoc($totalResult);
							$totalRecords = $totalRow['total'];

							// Calculate pages
							$currentPage = floor($startpage / $limit) + 1;
							$totalPages = ceil($totalRecords / $limit);

							// Pagination UI
							echo '<div class="pagination-wrapper">';
							echo '<div class="pagination-buttons">';

							// Previous
							if ($currentPage > 1) {
								$prevStart = ($currentPage - 2) * $limit;
								echo '<a href="?' . $queryString . '&startpage=' . $prevStart . '" class="prev-btn">&laquo; Previous</a>';
							} else {
								echo '<button class="prev-btn" disabled>&laquo; Previous</button>';
							}

							// Page numbers
							echo '<div class="page-numbers">';
							$visiblePages = 3;
							$start = max(1, $currentPage - 1);
							$end = min($totalPages, $start + $visiblePages - 1);

							if ($end - $start + 1 < $visiblePages) {
								$start = max(1, $end - $visiblePages + 1);
							}

							if ($start > 1) {
								echo '<a href="?' . $queryString . '&startpage=0" class="page-number">1</a>';
								if ($start > 2)
									echo '<span class="dots">...</span>';
							}

							for ($i = $start; $i <= $end; $i++) {
								$pageStart = ($i - 1) * $limit;
								if ($i == $currentPage) {
									echo '<span class="page-number active">' . $i . '</span>';
								} else {
									echo '<a href="?' . $queryString . '&startpage=' . $pageStart . '" class="page-number">' . $i . '</a>';
								}
							}

							if ($end < $totalPages) {
								if ($end < $totalPages - 1)
									echo '<span class="dots">...</span>';
								$lastStart = ($totalPages - 1) * $limit;
								echo '<a href="?' . $queryString . '&startpage=' . $lastStart . '" class="page-number">' . $totalPages . '</a>';
							}

							echo '</div>';

							// Next
							if ($currentPage < $totalPages) {
								$nextStart = $currentPage * $limit;
								echo '<a href="?' . $queryString . '&startpage=' . $nextStart . '" class="next-btn">Next &raquo;</a>';
							} else {
								echo '<button class="next-btn" disabled>Next &raquo;</button>';
							}

							echo '</div>';
							echo '</div>';
							?>









							<?php if ($n == 0) { ?>
								<div style="padding:30px; text-align:center;">
									<div style="text-align:center; margin-bottom:20px;">No Contacts.</div>
									<!--<a href="add-contacts.html" class="add_contacts">Add Contacts</a></div>-->
								<?php } ?>
							</div>
						</div>





					</div>
				</div>
			</div>
		</div>


		<style>
			.pagination-wrapper {
				text-align: center;
				margin-top: 20px;
			}

			.pagination-buttons {
				display: inline-flex;
				align-items: center;
				gap: 8px;
			}

			.pagination-buttons a,
			.pagination-buttons button,
			.page-number {
				padding: 6px 12px;
				border: 1px solid #ccc;
				background: #20741f;
				color: #e2d5d5ff;
				text-decoration: none;
				border-radius: 5px;
				transition: all 0.2s ease;
			}

			.pagination-buttons a:hover {
				background: #20741f;
				color: #fff;
			}

			.page-number.active {
				background: #20741f;
				color: #fff;
				border-color: #20741f;
				font-weight: bold;
			}

			.page-numbers {
				display: inline-flex;
				align-items: center;
				gap: 5px;
			}

			.dots {
				padding: 6px 10px;
				color: #888;
			}
		</style>


		<?php include('footer.php'); ?>

		<script>
			function reloadPage() {
				location.reload(true);
			}

		</script>

		<script>
			<?php
			if ($_SESSION["s"] == 1) {
				?>
				showsusmsg('SUCCESS', 'Request accepted', '');
				<?php
				$_SESSION["s"] = '';
			}
			if ($_SESSION["d"] == 1) {
				?>
				showerrormsg('SUCCESS', 'Request declined', '');
				<?php
				$_SESSION["d"] = '';
			}

			?>
		</script>

</body>

</html>