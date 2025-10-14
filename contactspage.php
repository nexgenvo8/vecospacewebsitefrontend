<?php
include_once('inc.php');
$_SESSION['loginredirectpageurl'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 22;
$search = '';
if (isset($_REQUEST['searchcontacts']) && $_REQUEST['searchcontacts'] != '') {
	$search = clean($_REQUEST['searchcontacts']);
}
if ($search == '') {
	$active = 1;
	if (isset($_REQUEST['r']) && $_REQUEST['r'] == 1) {
		$active = 2;
	}
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
							<?php if (isset($_POST['searchkeywords']) && $_GET['searchkeywords'] != '') {

								$strWhereContacts .= "";
								$strWhereContacts .= " and  (firstName like '%" . $_GET['searchkeywords'] . "%' OR lastName like '%" . $_GET['searchkeywords'] . "%' OR email like '%" . $_GET['searchkeywords'] . "%' ) ";
								?>

								<?php
							} else {
								$strWhereContacts = "";
								?>
								<h2>People you may know</h2>
							<?php } ?>

							<ul class="cntct-list">
								<?php
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

								$sqlLogin = "";
								$sqlLogin = "select * from " . _USERS_MASTER_TABLE_ . " where activeYN='Y' and userId!=106 and userId not  in (select contactId from " . _CONTACT_MASTER_TABLE_ . " where userId=" . $_SESSION["sessUserId"] . ") and userId not in (select userId from " . _CONTACT_MASTER_TABLE_ . " where contactId=" . $_SESSION["sessUserId"] . ")  and companyName!='' and userId!='" . $_SESSION['sessUserId'] . "' " . $strWhereContacts . "  order by userId desc";
								$resLogin = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
								if ($resLogin) {
									while ($rowLogin = mysqli_fetch_array($resLogin)) {

										$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin["userId"] . "";
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
										?>
										<li>
											<div class="request-contct">
												<div class="rimg"> <a
														href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html">
														<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"
															style="border:<?php echo profileborder($userres['userstype']); ?>">
													</a></div>
												<div class="reqst-rdtail">
													<div class="middl-nm">
														<div class="left"> <a
																href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																class="nm"><?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["firstName"]); ?>
																<?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["lastName"]);//stripslashes(trim($userres["lastName"])); ?></a>
															<span class="comp"><?php echo $userres['jobTitle']; ?> at
																<?php echo $userres['companyName']; ?></span>
														</div>
														<div class="btns">
															<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																class="msg-btn"><i class="fa fa-plus" aria-hidden="true"></i>
																Add as contact</a>
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