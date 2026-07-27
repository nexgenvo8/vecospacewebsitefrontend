<?php
include_once('inc.php');
$_SESSION['loginredirectpageurl'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 26;
if ($_SESSION["sessUserId"] != '') {
	/*
	 $c="SELECT id,status from "._CONTACT_MASTER_TABLE_." WHERE userId= ".$_SESSION["sessUserId"]." and contactId=".decodeStr($_GET['id'])."";
	 $d=mysql_query($c) or die(mysql_error());
	 $aabb=mysql_fetch_array($d);

	*/
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>Find Mentor - <?php echo $companyname; ?></title>
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
					<div class="pnding-contct">

						<div class="contct-list-cont">
							<?php $searchkeywords = isset($_GET['searchkeywords']) ? trim($_GET['searchkeywords']) : '';

							if ($searchkeywords != '') {

								$strWhereContacts = "";
								$strWhereContacts .= " AND (firstName LIKE '%" . $searchkeywords_safe . "%' 
                            OR lastName LIKE '%" . $searchkeywords_safe . "%' 
                            OR email LIKE '%" . $searchkeywords_safe . "%')";
								?>

								<?php
							} else {
								$strWhereContacts = "";
								?>
								<div class="findmetnordivnew">
									<h3 class="findmentr">FIND YOUR MENTOR</h3>
									<form name="topsearchfrm" id="topsearchfrm" class="mainsearch mentorsearch" method="get"
										action="<?php echo $fullurl; ?>mentorsearch.html">

										<?php
										$keywordsearch = isset($_REQUEST["keywordsearch"]) ? trim($_REQUEST["keywordsearch"]) : '';
										?>

										<input type="text" name="keywordsearch" id="keywordsearch"
											value="<?php echo htmlspecialchars($keywordsearch); ?>" maxlength="50"
											class="text" autocomplete="off" placeholder="Search by Name"
											onKeyUp="topsearch();">

										<button type="button" class="search_btn" onClick="subsrchfrm();">
											<i class="fa fa-search" aria-hidden="true"></i>
										</button>
										<!-- <div id="showsearchbox"></div>-->
									</form>

									<div>
									<?php } ?>

									<ul class="cntct-list">
										<?php

										$search = isset($_REQUEST['searchkeywords']) ? trim($_REQUEST['searchkeywords']) : '';
										$r = isset($_REQUEST['r']) ? intval($_REQUEST['r']) : 0;
										$strWhere = '';

										// MySQLi connection assumed in $conn
										
										$acceptQuery = "SELECT * FROM " . _STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_ . " WHERE studentId='" . $_SESSION["sessUserId"] . "' AND status='1' ORDER BY dateAdded";
										$cData = mysqli_query($conn, $acceptQuery) or die(mysqli_error($conn));
										$mentorData2 = mysqli_fetch_array($cData);

										$acceptQuery111 = "SELECT * FROM " . _STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_ . " WHERE studentId='" . $_SESSION["sessUserId"] . "' AND status='0' ORDER BY dateAdded";
										$cData111 = mysqli_query($conn, $acceptQuery111) or die(mysqli_error($conn));
										$mentorData2111 = mysqli_fetch_array($cData111);

										$where2 = '';
										if ($mentorData2 && isset($mentorData2['id'])) {
											$where2 = $mentorData2['mentorId'];
										}

										if ($r == 1) {
											$strWhere .= " AND dateAdded BETWEEN " . strtotime(date('Y-m-d', strtotime("-30 days"))) . " AND " . strtotime(date('Y-m-d')) . " ";
										}

										if ($search != '') {
											$strWhere .= " AND contactId IN (SELECT userId FROM " . _USERS_MASTER_TABLE_ . " WHERE activeYN='Y' AND userId!=106 AND (firstName LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR lastName LIKE '%" . mysqli_real_escape_string($conn, $search) . "%' OR email LIKE '%" . mysqli_real_escape_string($conn, $search) . "%')) ";
										}

										$n = 0;
										unset($selectFields);
										unset($whereFields);
										unset($whereVals);

										$sqlLogin = "";

										if (is_array($mentorData2) && !empty($mentorData2['studentId']) && $mentorData2['status'] == 1) {
											$sqlLogin = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " 
											WHERE activeYN='Y' 
											AND userId!='" . intval($_SESSION['sessUserId']) . "' 
											" . $strWhereContacts . " 
											AND userstype='3' 
											AND userId='" . intval($where2) . "'";
										} else {
											$sqlLogin = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " 
											WHERE activeYN='Y' 
											AND userId!='" . intval($_SESSION['sessUserId']) . "' 
											" . $strWhereContacts . " 
											ORDER BY userId DESC";
										}


										$resLogin = mysqli_query($conn, $sqlLogin);
										if ($resLogin) {
											while ($rowLogin = mysqli_fetch_array($resLogin)) {

												$a = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " 
												  WHERE userId = " . $rowLogin["userId"] . " 
												  AND type != 'admin'";
if (empty($userres['userId'])) {
        continue;
    }
												$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
												$userres = mysqli_fetch_array($b);

												$menterQuery = "SELECT * FROM " . _STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_ . " WHERE mentorId=" . $rowLogin["userId"] . " AND studentId='" . $_SESSION["sessUserId"] . "'";
												$bData = mysqli_query($conn, $menterQuery) or die(mysqli_error($conn));
												$mentorData1 = mysqli_fetch_array($bData);

												$profilePhoto = trim($userres["profilePhoto"]);
												$uploadPath = __DIR__ . "/uploads/" . $profilePhoto;

												// If profile photo missing OR file not found → show placeholder
												if ($profilePhoto == "" || !file_exists($uploadPath)) {
													$userphoto = "user-placeholder.jpg"; // dummy image
												} else {
													$userphoto = $profilePhoto;
												}

												$mycountryName = $userres["countryName"];
												$mystateName = $userres["cityName"];
												$mylocationName = $userres["locationName"];

												if ($rowLogin['userstype'] == '3' || $rowLogin['userstype'] == '2' || $rowLogin['userstype'] == '4') {

													// assigned mentor? always allow
													if ($rowLogin['userId'] == $where2 || $rowLogin['numberofMentees'] != '0') {


														$menterQueryCount = "SELECT * FROM " . _STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_ . " WHERE mentorId=" . $rowLogin["userId"];
														$bDataC = mysqli_query($conn, $menterQueryCount) or die(mysqli_error($conn));
														//$mentorData1=mysql_num_rows($bDataC);
														//if($mentorData1!=$rowLogin['numberofMentees']){
														?>
														<li class="listwidthnew">
														 <div class="full-mentor-row">
															<div class="request-contct rerestmentcontact">
																<div class="rimg"> <a
																		href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html">
																		<img
																			src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>">
																	</a>
																</div>
																<div class="reqst-rdtail rewqnewdte">
																	<div class="middl-nm">
																		<div class="left"><a
																				href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																				class="nm"><?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["firstName"]); ?>
																				<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["lastName"]);//stripslashes(trim($userres["lastName"])); ?></a>
																			<span class="comp"><?php echo $userres['coursename']; ?>-
																				<?php echo $userres['departmentname']; ?></span>
																			<span class="comp"><?php echo $userres['jobTitle']; ?> at
																				<?php echo $userres['companyName']; ?> 				<?php ; ?></span>
																		</div>
																	</div>
																</div>
															</div>

															<div class="rerestselectaction">
																<div class="btnslecectionaction">
																	<?php
																	// Check if $mentorData1 and $mentorData2111 are arrays and have 'status' key
																	$mentorStatus1 = (is_array($mentorData1) && isset($mentorData1['status'])) ? $mentorData1['status'] : null;
																	$mentorStatus2111 = (is_array($mentorData2111) && isset($mentorData2111['status'])) ? $mentorData2111['status'] : null;

																	if ($mentorStatus1 === '' || $mentorStatus1 === null) {
																		if ($mentorStatus2111 === '0') {
																			// Do nothing
																		} else {
																			?>
																			<a id="sendrequesttomentor"
																				href="common_action.php?studentid=<?php echo encodeStr($userres['userId']); ?>&action=addmentor"
																				target="actionfrm" onClick="$('#commonloader').show();">
																				<div class="selectmentordiv">Select</div>
																			</a>
																			<img src="images/Find-you-mentor.png">
																			<?php
																		}
																	} elseif ($mentorStatus1 === '0') {
																		?>
																		<div class="selectedmentordiv">Pending</div>
																		<img src="images/Find-you-mentor.png">
																		<?php
																	} else {
																		?>
																		<div class="selectedmentordiv">Assigned</div>
																		<img src="images/checkednew.png">
																		<?php
																	}
																	?>
																</div>
															</div>
														</div>
														</li>

														<?php
													}
												}
											}
										}
										?>
									</ul>

									<?php if ($n == 0) { ?>
										<div style="padding:30px; text-align:center;">
											<div style="text-align:center; margin-bottom:20px;">No Contacts.</div>
										<?php } ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<style>
			.full-mentor-row {
		width: 100%;
		display: flex;
		align-items: flex-start;
		justify-content: space-between;
		border: 1px solid #ddd;
		border-radius: 8px;
		padding: 15px;
		background: #fff;
	}


	/* right side button container */
	.rerestselectaction {
		display: flex;
		align-items: flex-start;   /* aligns button to top */
	}

	/* button div alignment */
	.btnslecectionaction {
		display: flex;
		flex-direction: column;
		align-items: center;
	}

	.selectmentordiv, .selectedmentordiv {
		padding: 6px 14px;
		border-radius: 4px;
		background: #d9534f;
		color: #fff;
		cursor: pointer;
		text-align: center;
		white-space: nowrap;
	}

.selectedmentordiv {
    background: #5cb85c;
}

</style>
			<?php include('footer.php'); ?>
			<script>
				function reloadPage() {
					location.reload(true);
				}
			</script>
</body>

</html>