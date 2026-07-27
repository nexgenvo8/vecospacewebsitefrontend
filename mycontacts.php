<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 2;
$search = '';
$active = 1;

// Check if 'searchcontacts' is set in request before using it
if (isset($_REQUEST['searchcontacts']) && $_REQUEST['searchcontacts'] !== '') {
	$search = clean($_REQUEST['searchcontacts']);
}

// Handle 'r' parameter safely
if ($search === '') {
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

		<div class="container main" style="margin-bottom: 60px;">
			<div class="premium_tag"><a href="#">Go Premium</a>
				<p id="typewriter"></p>
			</div>
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content">
					<div class="contact">
						<div class="pnding-contct">
							<h2 id="pagetitlemain2">Pending contact requests</h2>
							<ul class="cntct-list">

								<?php
								$n = 0;
								$selectFields = [];
								$whereFields = [];
								$whereVals = [];

								$sqlLogin = "";
								$sqlLogin = "select * from " . _CONTACT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and status=0 ";
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
											<div class="request-contct" id="mobile-contact">
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
																href="<?php echo $fullurl; ?>common_action.php?userIdcontact=<?php echo encodeStr($userres['userId']); ?>&action=act"
																target="actionfrm" style="margin-left:10px;color:#1a94c3;
border-color: #1a94c3;">Confirm</a>
															<a class="msg-btn reject dlt"
																href="<?php echo $fullurl; ?>common_action.php?userIdcontact=<?php echo encodeStr($userres['userId']); ?>&action=dec"
																target="actionfrm">Decline</a>
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
							<h2>Contact list</h2>
							<ul class="cntr_tab">
								<li><a href="<?php echo $fullurl; ?>my-contacts.html" <?php if ($active == 1) { ?>class="active" <?php } ?>>All Contacts (<?php echo $lefttotalcontacts; ?>)</a>
								</li>
								<li><a href="<?php echo $fullurl; ?>my-contacts.html?r=1" <?php if ($active == 2) { ?>class="active" <?php } ?>>Recently Added</a></li>
								<li class="cntct_serch">
									<form method="post" name="frmsearchcontacts" id="frmsearchcontacts">
										<input type="text" name="searchcontacts" id="searchcontacts"
											placeholder="Search for your contacts" value="<?php echo $search; ?>"
											class="sbtn validate" maxlength="60">
										<button class="srch-fr-btn" type="button"
											onClick="formValidation('frmsearchcontacts');subsrchfrmcontact();"><i
												class="fa fa-search" aria-hidden="true"></i></button>
									</form>

									<script>
										function subsrchfrmcontact() {

											if ($("#searchcontacts").val() != '') {
												$("#frmsearchcontacts").submit();
											}
										}

										$("input").keypress(function (event) {

											if (event.which == 13) {
												event.preventDefault();

												if ($("#searchcontacts").val() != '') {
													$("#frmsearchcontacts").submit();
												}
											}
										});




									</script>
								</li>
							</ul>

							<ul class="cntct-list">
								<?php
								// Initialize variables safely
								$strWhere = '';
								$search = isset($_REQUEST['search']) ? trim($_REQUEST['search']) : '';

								// Check if 'r' is set in request before using it
								if (isset($_REQUEST['r']) && $_REQUEST['r'] == 1) {
									$startDate = strtotime(date('Y-m-d', strtotime("-30 days")));
									$endDate = strtotime(date('Y-m-d'));
									$strWhere .= " AND dateAdded BETWEEN {$startDate} AND {$endDate} ";
								}

								$n = 0;
								$selectFields = [];
								$whereFields = [];
								$whereVals = [];

								$sqlLogin = "";
								$sqlLogin = "SELECT DISTINCT contactId 
								 FROM " . _CONTACT_MASTER_TABLE_ . " 
								 WHERE userId='" . $_SESSION['sessUserId'] . "' 
								 AND status=1";

								$resLogin = getRecords(_CONTACT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
								if ($resLogin) {
									while ($rowLogin = mysqli_fetch_array($resLogin)) {

										// Ensure contactId exists and is not null
										if (!isset($rowLogin["contactId"]) || empty($rowLogin["contactId"])) {
											continue; // skip this iteration
										}

										$a = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId= " . intval($rowLogin["contactId"]);
										$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
										$userres = mysqli_fetch_array($b);

										// Skip if no user data found
										if (!$userres) {
											continue;
										}

										$friendnameurl = isset($userres['userurl']) ? $userres['userurl'] : '';
										$userphoto = (!empty($userres["profilePhoto"])) ? $userres["profilePhoto"] : 'user-placeholder.jpg';

										$mycountryName = isset($userres["countryName"]) ? $userres["countryName"] : '';
										$mystateName = isset($userres["cityName"]) ? $userres["cityName"] : '';
										$mylocationName = isset($userres["locationName"]) ? $userres["locationName"] : '';
										?>
										<li>
											<div class="request-contct" id="mobile-contact">
												<div class="rimg">
													<a
														href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html">
														<img
															src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>">
													</a>
												</div>
												<div class="reqst-rdtail">
													<div class="middl-nm">
														<div class="left">
															<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																class="nm">
																<?php echo stripslashes(trim($userres["firstName"] ?? '')); ?>
																<?php echo stripslashes(trim($userres["lastName"] ?? '')); ?>
															</a>
															<span class="comp">
																<?php echo $userres['jobTitle'] ?? ''; ?> at
																<?php echo $userres['companyName'] ?? ''; ?>
															</span>
														</div>
														<div class="btns">
															<a href="javascript:void(0);" class="msg-btn" <?php if ($mobile == 'y') { ?>onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>/common_popup_inner.php?type=sendmsgtocontact&id=<?php echo encodeStr($userres['userId']); ?>','New message');"
																<?php } else { ?>onClick="openuserchatbox('<?php echo encodeStr($userres['userId']); ?>','<?php echo stripslashes(trim($userres["firstName"] ?? '')); ?> <?php echo stripslashes(trim($userres["lastName"] ?? '')); ?>','<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html');"
																<?php } ?>>
																<i class="fa fa-paper-plane" aria-hidden="true"></i> Message
															</a>
															<div class="dropdwn">
																<a href="javascript:void(0);" class="open"
																	onClick="$('.remove-list').hide();$('#openc<?php echo $userres['userId']; ?>').show();">
																	<i class="fa fa-ellipsis-h" aria-hidden="true"></i>
																</a>
																<ul class="remove-list"
																	id="openc<?php echo $userres['userId']; ?>">
																	<li>
																		<a
																			onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo encodeStr($userres['userId']); ?>&name=<?php echo stripslashes(trim($userres["firstName"] ?? '')); ?>&type=removeconnection','Alert');">
																			<i class="fa fa-trash-o" aria-hidden="true"></i>
																			Remove Contact
																		</a>
																	</li>
																</ul>
															</div>
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

							<script type="text/javascript">
								$(document).ready(function () {
									$(".dropdwn a.open").click(function (e) {
										$("#remove-list").toggle();
										e.stopPropagation();
									});

									$(document).click(function (e) {
										if (!$(e.target).is('#remove-list, #remove-list *')) {
											$("#remove-list").hide();
										}
									});
								});
							</script>

							<?php if ($n == 0) { ?>
								<div style="padding:30px; text-align:center;">
									<div style="text-align:center; margin-bottom:20px;">You have no recent connections</div>
									<a href="contacts.html" class="add_contacts">Add Contacts</a>
								</div>
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

</body>

</html>