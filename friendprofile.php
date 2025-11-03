<?php


include_once('inc.php');
$ps = 1;
if (isset($REQUEST['r']) && $_REQUEST['r'] != '') {
	$_SESSION['loginredirectpageurl'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
}
if ($_SESSION["sessUserId"] != '') {

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$lasdate = $day_before = date('Y-m-d', strtotime(date('Y-m-d') . ' -90 day'));
	$sql = "";
	$sql = "select id from " . _USER_PROFILE_VIEW_TABLE_ . " where userId='" . decodeStr($_GET['id']) . "' and contactId=" . $_SESSION["sessUserId"] . " and dateAdded between '" . $lasdate . "' and '" . date('Y-m-d') . "' ";
	$resSql = getRecords(_USER_PROFILE_VIEW_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sql);
	if ($resSql) {
	} else {
		if (decodeStr($_GET['id']) != $_SESSION["sessUserId"]) {
			$sql_insa = "INSERT INTO " . _USER_PROFILE_VIEW_TABLE_ . " SET userId= " . decodeStr($_GET['id']) . ",contactId=" . $_SESSION["sessUserId"] . ",dateAdded='" . date('Y-m-d') . "' ";
			$resresult2a = mysqli_query($conn, $sql_insa) or die(mysqli_error($conn));
		}
	}
}

if ($_GET['id'] != '') {
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlLogin1 = "";
	$sqlLogin1 = "select * from " . _CONTACT_MASTER_TABLE_ . " where userId='" . decodeStr($_GET['id']) . "' and status=1 ";
	$resLogin1 = getRecords(_CONTACT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin1);
	if ($resLogin1) {
		$totalcontacts = mysqli_num_rows($resLogin1);
	} else {
		$totalcontacts = 0;
	}


	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlLogin = "";

	//$sqlLogin="select * from "._USERS_MASTER_TABLE_." where userId='".decodeStr($_GET['id'])."' and activeYN='Y'";
	$sqlLogin = "select * from " . _USERS_MASTER_TABLE_ . " where userId='" . decodeStr($_GET['id']) . "'";

	$resLogin = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
	if ($resLogin) {
		while ($rowLogin = mysqli_fetch_array($resLogin)) {

			$userAccountCloseStatus = $rowLogin["userAccountCloseStatus"];
			if ($userAccountCloseStatus == 1) {
				header("Location:" . $fullurl . "404error.html");
				exit();
			}
			$employmentId = $rowLogin["employmentId"];
			$membershipId = $rowLogin["membershipId"];
			$jobTitle = $rowLogin["jobTitle"];
			$companyName = $rowLogin["companyName"];
			$industryId = $rowLogin["industryId"];
			$userurl = $rowLogin["userurl"];
			$myfirstName = $rowLogin["firstName"];
			$mylastName = $rowLogin["lastName"];
			$myname = ucfirst($rowLogin["firstName"]) . ' ' . ucfirst($rowLogin["lastName"]);

			$mycountryName = $rowLogin["countryName"];
			$mystateName = $rowLogin["cityName"];
			$mylocationName = $rowLogin["locationName"];
			$profilePhoto = $rowLogin["profilePhoto"];
			$taglineText = $rowLogin["taglineText"];
			$dob = $rowLogin["dob"];
			$useruserId = $rowLogin["userId"];
			$useruserurl = $rowLogin["userurl"];
			$regDate = $rowLogin["regDate"];
			$onlineDateTime = $rowLogin["onlineLastUpdate"];
			$onlineStatus = $rowLogin["onlineStatus"];


			if ($profilePhoto != '') {
				$profilePhoto = $profilePhoto;
				$oldprofilePhoto = $profilePhoto;
			} else {
				$profilePhoto = 'user-placeholder.jpg';
			}

		}


		/*User Profile Completed Code Start*/

		$totalkeyskillscount = 0;
		$a = "select id from " . _SKILL_EXPERIENCE_TABLE_ . " where userId='" . $useruserId . "' ";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$totalkeyskillscount = mysqli_num_rows($b);

		$totalexploringcount = 0;
		$ae = "select id from " . _EXPLORING_TABLE_ . " where userId='" . $useruserId . "' ";
		$be = mysqli_query($conn, $ae) or die(mysqli_error($conn));
		$totalexploringcount = mysqli_num_rows($be);

		$totalprofessionalcount = 0;
		$ap = "select id from " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " where userId='" . $useruserId . "' ";
		$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
		$totalprofessionalcount = mysqli_num_rows($bp);

		$totaleducationalcount = 0;
		$aeb = "select id from " . _EDUCATIONAL_BACKGROUND_TABLE_ . " where userId='" . $useruserId . "' ";
		$beb = mysqli_query($conn, $aeb) or die(mysqli_error($conn));
		$totaleducationalcount = mysqli_num_rows($beb);

		$totallanguagescount = 0;
		$al = "select id from " . _LANGUAGES_KONECTT_TABLE_ . " where userId='" . $useruserId . "' ";
		$bl = mysqli_query($conn, $al) or die(mysqli_error($conn));
		$totallanguagescount = mysqli_num_rows($bl);

		$totalinterestcount = 0;
		$ai = "select id from " . _INTERESTS_TABLE_ . " where userId='" . $useruserId . "' ";
		$bi = mysqli_query($conn, $ai) or die(mysqli_error($conn));
		$totalinterestcount = mysqli_num_rows($bi);

		$profilerank = 20;

		if ($totalkeyskillscount > 0) {
			$profilerank = $profilerank + 10;
		}
		if ($totalexploringcount > 0) {
			$profilerank = $profilerank + 10;
		}
		if ($totalprofessionalcount > 0) {
			$profilerank = $profilerank + 25;
		}
		if ($totaleducationalcount > 0) {
			$profilerank = $profilerank + 25;
		}
		if ($totallanguagescount > 0) {
			$profilerank = $profilerank + 2.50;
		}
		if ($totalinterestcount > 0) {
			$profilerank = $profilerank + 2.50;
		}
		if ($taglineText != '') {
			$profilerank = $profilerank + 5;
		}
		/*User Profile Completed Code End*/


	}

	if ($_SESSION["sessUserId"] != '') {
		$sql = "SELECT * from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId= " . decodeStr($_GET['id']) . " ";
		$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
		$getUserSettings = mysqli_fetch_array($getSql);
	}


	if (decodeStr($_GET['id']) == $_SESSION["sessUserId"]) {
		header('Location:' . $fullurl . 'myprofile/' . encodeStr($_SESSION['sessUserId']) . '/' . $useruserurl . '.html');
		exit();
	}

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];
	$olddateAdded = strtotime(date('Y-m-d H:i:s', strtotime("-2 days")));
	$myTotalActivity = 0;
	$sqlpost2 = "";

	$sqlpost2 = "select id from " . _SHAREANDUPDATES_TABLE_ . " where userId='" . decodeStr($_GET['id']) . "' and adType=0 and dateAdded>" . $olddateAdded . " and (postType=2 OR postType=3)";
	$resSqlpost2 = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlpost2);

	// ✅ Fix: check if query ran successfully and returned a valid mysqli_result
	if ($resSqlpost2 && $resSqlpost2 instanceof mysqli_result) {
		$myTotalActivity += mysqli_num_rows($resSqlpost2);
	} else {
		// Optional: log or debug
		// echo "<!-- SQL Error: " . mysqli_error($conn) . " -->";
		$myTotalActivity += 0;
	}



}

/*if($rowLogin["firstName"]!=''){
header("Location: ".$fullurl."404error.html"); 
exit();
}*/

if ($_SESSION["sessUserId"] != '') {

	$c = "SELECT id,status from " . _CONTACT_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " and contactId=" . decodeStr($_GET['id']) . "";
	$d = mysqli_query($conn, $c) or die(mysqli_error($conn));
	$aabb = mysqli_fetch_array($d);

	$cc = "SELECT id from " . _CONTACT_MASTER_TABLE_ . " WHERE userId= " . decodeStr($_GET['id']) . " and contactId=" . $_SESSION["sessUserId"] . " and status=0";
	$dd = mysqli_query($conn, $cc) or die(mysqli_error($conn));
	$requestSent = mysqli_num_rows($dd);

	$ccb = "SELECT id from " . _BLOCKED_CONTACTS_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " and contactId=" . decodeStr($_GET['id']) . " ";
	$ddb = mysqli_query($conn, $ccb) or die(mysqli_error($conn));
	$blockeduser = mysqli_num_rows($ddb);

	$ccba = "SELECT id from " . _BLOCKED_CONTACTS_TABLE_ . " WHERE userId= " . decodeStr($_GET['id']) . " and contactId=" . $_SESSION["sessUserId"] . " ";
	$ddba = mysqli_query($conn, $ccba) or die(mysqli_error($conn));
	$blockedusera404 = mysqli_num_rows($ddba);

	if ($blockedusera404 > 0) {
		header("Location: " . $fullurl . "404error.html");
		exit();
	}

}

$strprofilephoto = $profilePhoto;
$userfilename = 'uploads/x_' . trim($profilePhoto);
if (file_exists($userfilename)) {
	$strprofilephoto = 'x_' . $profilePhoto;
} else {
	$strprofilephoto = $profilePhoto;
}
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $myname; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
</head>

<body>
	<div id="wrapper" class="active">
		<?php include('header.php'); ?>
		<div class="container main">
			<div class="premium_tag"><a href="#">Go Premium</a>
				<p id="typewriter"></p>
			</div>
			<div class="home_container">


				<div class="frndtprfile-cont <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
				} else {
					echo 'nologin';
				} ?>">
					<div class="frndtprfile-left">
						<div class="view-prfl">
							<div class="usr-dtail">
								<div class="cover-img"> <span class="active-ago">
										<?php if (makedatetime($onlineDateTime) != '0 seconds') {
											echo 'Active: ' . makedatetime($onlineDateTime);
										} ?>
									</span>
									<div class="user-bg-cover">
										<div class="roundcircle" style="">

										</div>
									</div>
									<div class="frnduser-img"> <img
											src="<?php echo $fullurl; ?>uploads/<?php echo $profilePhoto; ?>"
											onClick="imagepopupmain('<?php echo $strprofilephoto; ?>');"> </div>

								</div>
								<div class="usr-info">
									<h2><?php echo $myname; ?></h2>
									<strong><?php echo $jobTitle; ?> - <a
											style="cursor:default;color: #fff;font-weight: 600;"><?php echo $companyName; ?></a></strong>
									<div class="locat">
										<?php if ($mylocationName) {
											echo $mylocationName . ',';
										} ?>
										<?php echo $mystateName; ?> <?php echo $mycountryName; ?>

									</div>
								</div>
								<?php
								// Ensure $aabb is always an array
								if (!isset($aabb) || !is_array($aabb)) {
									$aabb = [];
								}

								// Set default values to avoid undefined offsets
								$aabb['id'] = $aabb['id'] ?? '';
								$aabb['status'] = $aabb['status'] ?? 0;
								?>

								<div class="frnd-user-buttons" style="padding-top:0px; margin-top:0px; ">
									<?php
									if ($aabb['id'] == '') { ?>

										<?php
										if (isset($_SESSION['sessUserId']) && $_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
											if ($blockeduser > 0) {
												?>
												<a class="btn grey addas-contct"
													onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo trim($_GET['id']); ?>&status=0&name=<?php echo $myfirstName; ?>&type=blockcontact','Unblock');">Unblock</a>
												<?php
											} else {
												if (decodeStr($_GET['id']) == $_SESSION['sessUserId']) {
												} else {
													if ($aabb['id'] == '') { ?>

														<?php if ($requestSent > 0) { ?>
															<!--<a class="pndng-btn"><i class="fa fa-check-circle" aria-hidden="true"></i> Pending</a>-->
														<?php } else { ?>
															<a id="sendrequestbutton"
																href="<?php echo $fullurl; ?>common_action.php?userid=<?php echo trim($_GET['id']); ?>&action=addcontact"
																target="actionfrm" class="btn grey addas-contct senmsg"
																onClick="$('#commonloader').show();"> Add Contact</a>
														<?php }
													}
												}
											}
										} ?>

									<?php } else {
										if ($aabb['status'] == 1) { ?>
											<?php if (decodeStr($_GET['id']) != $_SESSION['sessUserId']) {

												if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
													<?php if ($blockeduser > 0) { ?>
													<?php } else { ?>
														<?php if ($aabb['id'] != '') { ?>
															<a class="senmsg" <?php if ($mobile == 'y') { ?>onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>/common_popup_inner.php?type=sendmsgtocontact&id=<?php echo $_GET['id']; ?>','New message');"
																<?php } else { ?>
																	onClick="openuserchatbox('<?php echo $_GET['id']; ?>','<?php echo $myname; ?>','<?php echo $fullurl; ?>profile/<?php echo $_GET['id']; ?>/<?php echo $useruserurl; ?>.html');$('#shb').val('0');"
																<?php } ?>>Send Message</a>
														<?php }
													}
												}
											}
										} ?>

										<!--<div class="more"> <a href="" class="click-more">More</a> </div>-->

										<?php if ($aabb['id'] == '') { ?> 	<?php } else {
											if ($aabb['status'] == 1) { ?>
												<?php if (decodeStr($_GET['id']) != $_SESSION['sessUserId']) { ?>

													<div class="more">
														<a class="click-more">More</a>
														<?php if ($blockeduser > 0) { ?>
															<ul class="go-btn-list" style="display:none;">
																<li><a class="btn"
																		onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo trim($_GET['id']); ?>&status=0&name=<?php echo $myfirstName; ?>&type=blockcontact','Unblock');">Unblock</a>
																</li>
															</ul>
														<?php } else { ?>

															<?php if (decodeStr($_GET['id']) == $_SESSION['sessUserId']) {
															} else {
																if ($aabb['id'] == '') { ?> 						<?php } else {
																	if ($aabb['status'] == 1) { ?>
																		<?php if (decodeStr($_GET['id']) != $_SESSION['sessUserId']) {

																			$query = "SELECT * from " . _BLOCKED_CONTACTS_TABLE_ . " WHERE  contactId=" . $_SESSION["sessUserId"] . " and userId= " . decodeStr($_GET['id']) . " ";
																			$sqlQuery = mysqli_query($conn, $query) or die(mysqli_error($conn));
																			$blockStatus = mysqli_num_rows($sqlQuery);
																			?>

																			<?php
																			$jsName = isset($myfirstName) ? addslashes($myfirstName) : '';
																			$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
																			$id = $id ?? 0;
																			$jsName = $jsName ?? '';
																			$myfirstName = $myfirstName ?? '';
																			$myname = $myname ?? '';
																			$id = isset($_REQUEST['id']) ? $_REQUEST['id'] : '';


																			?>


																			<ul class="go-btn-list" style="display:none;">
																				<li><a
																						onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=shareprofile&id=<?php echo trim($_GET['id']); ?>&url=<?php echo $actual_link = $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>','Share Profile');">Share
																						Profile </a></li>
																				<li><a
																						onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo trim($_GET['id']); ?>&name=<?php echo $myfirstName; ?>&type=removeconnection','Alert');">Remove
																						Connection</a></li>
																				<?php if ($blockStatus > 0) { ?>
																					<li><a
																							onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo trim($_GET['id']); ?>&status=0&name=<?php echo $myfirstName; ?>&type=blockcontact','Report/Unblock contacts');">Report/Unblock</a>
																					</li>
																				<?php } else { ?>
																					<li><a
																							onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo trim($_GET['id']); ?>&status=1&name=<?php echo $myfirstName; ?>&type=blockcontact','Report/Block contacts');">Report/Block</a>
																					</li>
																				<?php } ?>
																				<?php
																				$type = $_GET['type'] ?? '';

																				if ($type == 'recommendations' && !empty($_REQUEST['id'])) {
																					// your code for recommendations
																				}

																				if ($type == 'recommendeduser' && !empty($_REQUEST['id'])) {
																					// your code for recommendeduser
																				}
																				?>


																				<li><a
																						onClick="funcommonpopupwin('550px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo trim($_GET['id']); ?>&name=<?php echo $myfirstName; ?>&type=recommendations','Ask <?php echo $myfirstName; ?> to recommend you');">Request
																						a Recommendation</a></li>
																				<li><a
																						onClick="funcommonpopupwin('550px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo trim($_GET['id']); ?>&name=<?php echo $myfirstName; ?>&type=recommendeduser','Write <?php echo $myfirstName; ?> a recommendation');">Recommend
																						<?php echo $myname; ?></a></li>


																			</ul>

																		<?php }
																	}
																}
															}
														}
												} ?>
													<div id="contactblocked"></div>


												<?php }
										}
									} ?>
									</div>




									<ul class="frnd-usractivity-button">
										<?php if (!empty($getUserSettings) && isset($getUserSettings["activityTabVisible"]) && $getUserSettings["activityTabVisible"] == "All members") { ?>
											<li class="activty"> <a <?php if ($requestSent > 0) {
											} else {
												if ($aabb['id'] != '') { ?>href="<?php echo $fullurl; ?>user-activity.html?userId=<?php echo $_GET['id']; ?>&view=1"
														<?php }
											} ?>><strong><?php echo $myTotalActivity; ?></strong>
													<span>Activity</span> </a>
												</a></li>
										<?php }
										if (!empty($getUserSettings) && isset($getUserSettings["activityTabVisible"]) && $getUserSettings["activityTabVisible"] == "My contacts only") {
											$activityTab = $getUserSettings['activityTabVisible'] ?? ''; // safe access
											$requestSent = $requestSent ?? 0; // default to 0 if not set
										

											$sql = "SELECT userId from " . _CONTACT_MASTER_TABLE_ . " WHERE userId= " . decodeStr($_GET['id']) . " and contactId=" . $_SESSION['sessUserId'] . " and status=1 ";
											$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
											$getUserSettingsContactVisible = mysqli_fetch_array($getSql);
											//if($getUserSettingsContactVisible["userId"]!=''){
											?>
											<li class="activty"> <a <?php if ($requestSent > 0) {
											} else {
												if ($aabb['id'] != '') { ?>href="<?php echo $fullurl; ?>user-activity.html?userId=<?php echo $_GET['id']; ?>&view=1"
														<?php }
											} ?>><strong><?php echo $myTotalActivity; ?></strong>
													<span>Activity</span> </a>
												</a></li>
											<?php
											//}
										} ?>
										<?php
										$contactListVisible = $getUserSettings['contactListVisible'] ?? 0;  // default 0 if not set
										$contactTabVisible = $getUserSettings['contactTabvisible'] ?? '';    // default empty string if not set
										
										if ($contactListVisible == 1) {
											if ($contactTabVisible == "All members") { ?>
												<li class="contcts"> <a <?php if ($totalcontacts > 0) { ?>
															onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=viewcontacts&id=<?php echo $_GET['id']; ?>','<?php echo $myfirstName; ?>&prime;s Contacts');"
														<?php } ?>><strong><?php echo $totalcontacts; ?></strong>
														<span>Contacts</span> </a>
													</a></li>
											<?php }
											if ($getUserSettings["contactTabvisible"] == "My contacts only") {


												$sql = "SELECT userId from " . _CONTACT_MASTER_TABLE_ . " WHERE userId= " . decodeStr($_GET['id']) . " and contactId=" . $_SESSION['sessUserId'] . " and status=1 ";
												$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
												$getUserSettingsContactVisible = mysqli_fetch_array($getSql);

												if (isset($getUserSettingsContactVisible["userId"]) && !empty($getUserSettingsContactVisible["userId"])) {
													?>
													<li class="contcts">
														<a <?php if (!empty($totalcontacts) && $totalcontacts > 0) { ?> onClick="funcommonpopupwin(
					'400px',
					'auto',
					'<?php echo $fullurl; ?>common_popup_inner.php?type=viewcontacts&id=<?php echo $_GET['id']; ?>',
					'<?php echo $myfirstName; ?>\'s Contacts'
				);" <?php } ?>>
															<strong><?php echo $totalcontacts ?? 0; ?></strong>
															<span>Contacts</span>
														</a>
													</li>
													<?php
												}
											}
										}
										?>

										<li class="prfl-complete"> <a
												style="cursor:inherit"><strong><?php echo ceil($profilerank); ?>%</strong>
												<span>Completed Profile</span></a> </li>



									</ul>

									<?php if ($taglineText != '') { ?>
										<div class="descrptn"> <?php echo sanitizedboutput($taglineText); ?>
											<div id="taglinediv" style="display:none;">
												<button type="button" onClick="savetagline();">Save</button>
												<button type="button" class="cancel"
													onClick="$('#taglinediv').hide();$('#taglineText').val('');" <?php if ($taglineText != '') { ?>style="display:none;" <?php } ?>>Cancel</button>
											</div>
										</div>
									<?php } ?>

									<?php if (decodeStr($_GET['id']) == $_SESSION['sessUserId']) {
									} else {
										if ($aabb['id'] == '') { ?>
											<?php if ($requestSent > 0) { ?>
												<div class="invttion-sent" style="text-align:center;">
													<table width="100%" border="0">
														<tr>
															<td width="50px" align="center"><i class="fa fa-check-circle"
																	aria-hidden="true"></i> </td>
															<td align="left">Your invitation to add <strong
																	style="font-size: 18px; font-weight:500; color: #C02621;"><?php echo $myname; ?></strong>
																as a contact has been sent. </td>
														</tr>
													</table>
												</div>
											<?php }
										}
									} ?>

								</div>





							</div>
							<div class="cntr_cntnt" style="width:100% <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
							} else {
								echo '!important';
							} ?>;">
								<ul class="edit_list">
									<?php
									$totalUserArticles = 0;
									$sqlTotalUserArticle = "";
									$sqlTotalUserArticle = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE postTitle!=''  and postType=3 and userId=" . decodeStr($_GET['id']) . "  ";
									$resTotalUserArticle = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlTotalUserArticle);
									if ($resTotalUserArticle) {
										$totalUserArticles = mysqli_num_rows($resTotalUserArticle);
									}
									if ($totalUserArticles > 0) {

										$sqlTotalUserArticle = "";
										$sqlTotalUserArticle = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE postTitle!=''  and postType=3 and userId=" . decodeStr($_REQUEST["id"]) . " ORDER BY id DESC  LIMIT 0,1";
										$resTotalUserArticle = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlTotalUserArticle);
										if ($resTotalUserArticle && mysqli_num_rows($resTotalUserArticle) > 0) {

											while ($rowTotalUserArticle = mysqli_fetch_array($resTotalUserArticle)) {
												?>
												<li>
													<h3>Article<?php if ($totalUserArticles > 1) {
														echo 's';
													} ?>
														(<?php echo $totalUserArticles; ?>)</h3>
													<div class="usr-artcl"> <a
															href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowTotalUserArticle["id"]); ?>">
															<div class="img">
																<?php
																$a = "";
																$a = "select * from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $rowTotalUserArticle['id'] . " and imageType=3";
																$b = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $a);
																if ($b) {
																	$numrows = mysqli_num_rows($b);
																	$width = '100%';

																	while ($rowimg = mysqli_fetch_array($b)) {
																		?>
																		<img
																			src="<?php echo $fullurl; ?>uploads/<?php echo $rowimg['imageName']; ?>">
																	<?php }
																}


																?>
															</div>
														</a>
														<div class="about-artcl">
															<h2><a
																	href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowTotalUserArticle["id"]); ?>"><?php echo stripslashes(trim($rowTotalUserArticle["postTitle"])); ?></a>
															</h2>
															<p class="desc">
																<?php echo substr(stripslashes(strip_tags($rowTotalUserArticle['postText'])), 0, 200); ?>
															</p>
															<span
																class="dt"><?php echo makedatetime($rowTotalUserArticle["dateAdded"]); ?></span>
														</div>
														<div class="seeall-artcl"> <a
																href="<?php echo $fullurl; ?>user-articles.html?id=<?php echo $_REQUEST["id"]; ?>">See
																all articles</a> </div>
													</div>
												</li>
												<?php

											}

										}

									} ?>
									<li id="loadprofessionalexppage">
										<h3>Professional experience</h3>
										<?php
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$sqlOptions = "";
										$sqlOptions = "SELECT * FROM " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " WHERE userId=" . $useruserId . " order by fromyear desc ";
										$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
										if ($resOptions) {
											while ($rowOptions = mysqli_fetch_array($resOptions)) {
												$s = 1;
												if ($employmentId == $rowOptions['id']) {
													$strSelected = 'selected="selected"';
												} else {
													$strSelected = "";
												}
												?>
												<div class="companyouter">
													<div class="roundbox">
														<div
															style="text-align:center; color:#fff; padding-top:20px; font-size:14px;">
															<?php
															$startdate = '1-' . $rowOptions["frommonth"] . '-' . $rowOptions["fromyear"];
															if ($rowOptions["toyear"] != 0) {
																$enddate = '1-' . $rowOptions["tomonth"] . '-' . $rowOptions["toyear"];
															} else {
																$enddate = date("d-m-Y");
															}

															$datetime1 = new DateTime('' . $startdate . '');
															$datetime2 = new DateTime('' . $enddate . '');
															$interval = $datetime1->diff($datetime2);
															echo $interval->format('%y years<br>
 %m months'); ?>
														</div>
													</div>
													<div class="rightpnl">
														<div
															style="margin-bottom:5px; font-size:17px; color: rgba(0,0,0,.65);line-height: 24px; font-weight:600;">
															<?php echo $rowOptions["jobTitle"]; ?>
														</div>
														<div style="margin-bottom:5px; font-size:14px;">
															<?php echo $rowOptions["companyName"]; ?>
														</div>
														<div style="margin-bottom:5px;">
															<?php echo $rowOptions["frommonth"]; ?>/<?php echo $rowOptions["fromyear"]; ?>
															-
															<?php if ($rowOptions["currentPosition"] != 1) {
																echo $rowOptions["tomonth"] . '/' . $rowOptions["toyear"];
															} else {
																echo 'Present';
															} ?>
														</div>
														<div style="margin-bottom:5px; font-size:14px;">
															<strong>Industry</strong>:
															<?php
															$selectFields = [];
															$whereFields = [];
															$whereVals = [];

															$sqlIndustry = "";
															$sqlIndustry = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE id='" . $rowOptions["industry"] . "' ";
															$resIndustry = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlIndustry);
															if ($resIndustry) {
																while ($rowIndustry = mysqli_fetch_array($resIndustry)) {

																	?>
																	<?php echo trim($rowIndustry['optionName']); ?>
																	<?php
																}
															}
															?>
														</div>
														<?php if ($rowOptions["jobLocation"] != '') {
															$p = 1; ?>
															<div style="margin-bottom:5px; font-size:14px;">
																<strong>Location</strong>:
																<?php echo trim($rowOptions['jobLocation']); ?>
															</div>
														<?php } ?>
														<div style="overflow:hidden; position:relative; display:block;"
															id="maindive<?php echo $rowOptions["id"]; ?>">
															<?php if ($rowOptions["positiondetail"] != '') {
																$p = 1; ?>
																<div style="margin-bottom:5px; font-size:15px;">
																	<?php echo nl2br(trim(substr($rowOptions['positiondetail'], 0, 2000))); ?>
																</div>
															<?php } ?>
														</div>
													</div>
												</div>
												<?php


											}
										}

										?>
										<script>
											function showhidepe(id, maindiv) {
												var text = $("#showmoreid" + id).text();

												if (text == 'Show More') {
													$("#showmoreid" + id).text('Less');
													$("#" + maindiv).show();

												}
												else {
													$("#showmoreid" + id).text('Show More');
													$("#" + maindiv).hide();
												}
											}

										</script>
									</li>
									<?php
									if (!isset($s)) {
										$s = 0;
									}
									?>
									<?php if ($s != 1) { ?>
										<script>
											$('#loadprofessionalexppage').hide();
										</script>
									<?php } ?>
									<li id="educationalbackground">
										<h3>Educational background</h3>
										<?php
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$sqlEducational = "";
										$sqlEducational = "SELECT * FROM " . _EDUCATIONAL_BACKGROUND_TABLE_ . " WHERE userId=" . $useruserId . " order by toyear desc ";
										$resEducational = getRecords(_EDUCATIONAL_BACKGROUND_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlEducational);
										if ($resEducational) {
											while ($rowEducational = mysqli_fetch_array($resEducational)) {
												$es = 1;
												?>
												<div class="companyouter education">
													<div class="roundbox"><i class="fa fa-graduation-cap" aria-hidden="true"
															style="    position: absolute;
													right: 8px;
													top: 12px;
													font-size: 26px;"></i></div>
													<div class="rightpnl">

														<div>
															<?php echo $rowEducational["frommonth"] ?? ''; ?>/<?php echo $rowEducational["fromyear"] ?? ''; ?>
															-
															<?php if (($rowEducational["currentPosition"] ?? 0) != 1) {
																echo ($rowEducational["tomonth"] ?? '') . '/' . ($rowEducational["toyear"] ?? '');
															} else {
																echo 'Present';
															} ?>
														</div>

														<div
															style="font-size:17px; font-weight:600;color: rgba(0,0,0,.65);line-height: 24px;">
															<?php echo $rowEducational["university"]; ?>
														</div>
														<div style="margin-bottom:5px; font-size:15px;">
															<?php echo $rowEducational["fieldofstudy"]; ?>
														</div>
														<div style="margin-bottom:5px; font-size:14px;">
															<?php echo $rowEducational["degree"]; ?>
														</div>
														<?php if ($rowEducational["specialisedsubjects"] != '') { ?>
															<div style="margin-bottom:5px; font-size:14px;"><strong>Specialised
																	subjects</strong>:
																<?php echo $rowEducational["specialisedsubjects"]; ?>
															</div>
														<?php } ?>
														<div style="overflow:hidden; position:relative; display:block;"
															id="maindive<?php echo $rowEducational["id"]; ?>">
															<?php $e = '';
															if ($rowEducational["description"] != '') {
																$e = 1; ?>
																<div style="margin-bottom:5px; font-size:14px;">
																	<strong>Description</strong>:
																	<?php echo $rowEducational["description"]; ?>
																</div>
															<?php } ?>
														</div>
													</div>
												</div>
												<?php


											}
										}

										?>
										<script>
											function showhidepe(id, maindiv) {
												var text = $("#showmoreid" + id).text();

												if (text == 'Show More') {
													$("#showmoreid" + id).text('Less');
													$("#" + maindiv).show();

												}
												else {
													$("#showmoreid" + id).text('Show More');
													$("#" + maindiv).hide();
												}
											}

										</script>
									</li>
									<?php
									if (!isset($es)) {
										$es = 0;
									}
									?>
									<?php if ($es != 1) { ?>
										<script>
											$('#educationalbackground').hide();
										</script>
									<?php } ?>
									<?php
									if (!isset($sets)) {
										$sets = 0;
									}
									?>
									<li id="loadskillpage">
										<h3>Skills and Experience</h3>
										<div class="intrs-list" id="skillcontentboxs">
											<ul class="list">
												<?php

												$countskill = 1;
												$selectFields = [];
												$whereFields = [];
												$whereVals = [];

												$sqlLogin = "";
												$sqlLogin = "select * from " . _SKILL_EXPERIENCE_TABLE_ . " where userId='" . $useruserId . "' and skillText!='' order by skillText asc ";
												$resLogin = getRecords(_SKILL_EXPERIENCE_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
												if ($resLogin) {
													while ($row = mysqli_fetch_array($resLogin)) {
														$sets = 1;
														?>
														<li><?php echo sanitizedboutput($row["skillText"]); ?></li>
														<?php
													}
												}
												?>
											</ul>
										</div>
									</li>
									<?php
									if (!isset($sets)) {
										$sets = 0;
									}
									?>
									<?php if ($sets != 1) { ?>
										<script>
											$('#loadskillpage').hide();
										</script>
									<?php } ?>
									<li id="loadexploringpage">
										<h3>What am I exploring on <?php echo $companNameTitle; ?></h3>
										<div class="intrs-list" id="exploringcontentboxs">
											<ul class="list">
												<?php

												$countexploring = 1;
												$selectFields = [];
												$whereFields = [];
												$whereVals = [];

												$sqlLogin = "";
												$sqlLogin = "select * from " . _EXPLORING_TABLE_ . " where userId='" . $useruserId . "' and exploringText!='' order by exploringText asc ";
												$resLogin = getRecords(_EXPLORING_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
												if ($resLogin) {
													while ($row = mysqli_fetch_array($resLogin)) {
														$wie = 1;
														?>
														<li><?php echo sanitizedboutput($row["exploringText"]); ?></li>
														<?php
													}
												}
												?>
											</ul>
										</div>
									</li>
									<?php
									if (!isset($wie)) {
										$wie = 0;
									}
									?>
									<?php if ($wie != 1) { ?>
										<script>
											$('#loadexploringpage').hide();
										</script>
									<?php } ?>
									<?php
									if (!isset($langs)) {
										$langs = 0;
									}
									?>
									<li id="loadlanguagespage">
										<h3>Languages</h3>
										<div class="intrs-list" id="languagecontentboxs">
											<ul class="list language">
												<?php

												$countlanguage = 1;
												$selectFields = [];
												$whereFields = [];
												$whereVals = [];

												$sqlLogin = "";
												$sqlLogin = "select * from " . _LANGUAGES_KONECTT_TABLE_ . " where userId='" . $useruserId . "' and languageText!='' order by languageText asc ";
												$resLogin = getRecords(_LANGUAGES_KONECTT_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
												if ($resLogin) {
													while ($row = mysqli_fetch_array($resLogin)) {
														$langs = 1; ?>
														<li class="color<?php echo $row["experties"]; ?>">
															<span><?php echo sanitizedboutput($row["languageText"]); ?>
																<?php if ($row["experties"] != 0) { ?>
																	<label style="font-size: 12px;">(
																		<?php if ($row["experties"] == 25) {
																			echo "Basic knowledge";
																		} else if ($row["experties"] == 50) {
																			echo "Good knowledge";
																		} else if ($row["experties"] == 75) {
																			echo "Fluent";
																		} else if ($row["experties"] == 100) {
																			echo "First language";
																		} ?>
																		)</label>
																<?php } ?>
															</span>
														</li>
														<?php
													}
												}
												?>
											</ul>
										</div>
									</li>
									<?php
									if (!isset($langs)) {
										$langs = 0;
									}
									?>
									<?php if ($langs != 1) { ?>
										<script>
											$('#loadlanguagespage').hide();
										</script>
									<?php } ?>
									<li id="loadinterestspage">
										<h3>Interests</h3>
										<div class="intrs-list" id="interestcontentboxs">
											<ul class="list">
												<?php

												$countinterest = 1;
												$selectFields = [];
												$whereFields = [];
												$whereVals = [];

												$sqlLogin = "";
												$sqlLogin = "select * from " . _INTERESTS_TABLE_ . " where userId='" . $useruserId . "' and interestText!='' order by interestText asc ";
												$resLogin = getRecords(_INTERESTS_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
												if ($resLogin) {
													while ($row = mysqli_fetch_array($resLogin)) {
														$inter = 1; ?>
														<li><?php echo sanitizedboutput($row["interestText"]); ?></li>
														<?php
													}
												}
												?>
											</ul>
										</div>
									</li>
									<?php
									if (!isset($inter)) {
										$inter = 0;
									}
									?>
									<?php if ($inter != 1) { ?>
										<script>
											$('#loadinterestspage').hide();
										</script>
									<?php } ?>
									<?php
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];
									$sqlUserRec = "";
									$sqlUserRec = "SELECT * FROM " . _USER_RECOMMENDATIONS_TABLE_ . " WHERE contactId=" . $useruserId . " and status=1 order by dateAdded desc ";
									$resUserRec = getRecords(_USER_RECOMMENDATIONS_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlUserRec);
									if ($resUserRec) {
										?>
										<li id="userrecommed">
											<h3>Recommendations(<?php echo mysqli_num_rows($resUserRec); ?>)</h3>
											<?php
											while ($rowUserRec = mysqli_fetch_array($resUserRec)) {

												$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowUserRec["userId"] . "";
												$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
												$userres = mysqli_fetch_array($b);

												$jobTitle = $userres["jobTitle"];
												$companyName = $userres["companyName"];

												$friendnameurl = $userres['userurl'];

												if ($userres["profilePhoto"] != '') {
													$userphoto = $userres["profilePhoto"];
												} else {
													$userphoto = 'user-placeholder.jpg';
												}
												?>
												<div class="recbox">
													<div class="rlft">
														<div
															style="width:56px; height:56px; overflow:hidden; margin-right:10px; float:left; border-radius: 50%;">
															<a
																href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
																	src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"
																	style="width:100%;"></a>
														</div>
														<div style="float:left; width:140px;">
															<div style="margin-bottom:5px;"> <a
																	href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																	style="font-size: 17px;"><?php echo $userres["firstName"]; ?>
																	<?php echo $userres["lastName"]; ?></a></div>
															<div style="margin-bottom:5px; font-size:12px; color:#9a9a9a;">
																<?php echo $userres["jobTitle"]; ?> at
																<?php echo $userres["companyName"]; ?>
															</div>
															<div style="margin-bottom:5px; font-size:12px; color:#9a9a9a;">
																<?php echo makedatetime($rowUserRec["dateAdded"]); ?>
															</div>
														</div>
													</div>
													<div class="rrit responsivedivmain">
														<?php echo nl2br($rowUserRec["recommendationText"]); ?>
													</div>
												</div>
												<?php
											}
											?>
										</li>
										<?php
									}
									?>
								</ul>
							</div>
						</div>

						<?php include('right-sidebar.php'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('footer.php'); ?>
	</div>

	<div id="showsentmsgdiv" style="display:none;">
		<div class="suces"><i class="fa-suc"><img src="<?php echo $fullurl; ?>images/suc.png"> </i> <span>Message
				Sent!</span>
			<div class="popup-fttr"> <a
					onClick="$('#sendmsgtocontactdiv').hide();$('#txtmsg').val('');$('#showsentmsgdiv').hide();">Close</a>
			</div>
		</div>
	</div>
	<style>
		.container.main {
			min-height: 1000px;
		}
	</style>
	<script>
		function reloadPage() {
			location.reload(true);
		}
		<?php if (isset($_REQUEST['r']) && $_REQUEST['r'] == 'recommend') { ?>
			funcommonpopupwin('550px', 'auto', '<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo trim($_GET['id']); ?>&name=<?php echo $myfirstName; ?>&type=recommendeduser', '');
		<?php } ?>
		<?php if (isset($_REQUEST['r']) && $_REQUEST['r'] == 'congratulate') { ?>
			funcommonpopupwin('520px', 'auto', '<?php echo $fullurl; ?>common_popup_inner.php?type=sendmsgtocontact&id=<?php echo $_GET['id']; ?>&m=1', 'Send a Message');
		<?php } ?>
	</script>
</body>
</html>