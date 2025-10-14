<?php
include_once('inc.php');
$pageIndex = 13;

if ($_REQUEST['id'] != '') {
	$sqlCompany = "SELECT * from " . _TALENT_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['id']) . " ";
	$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
	$rowCompany = mysqli_fetch_array($resCompany);

	if ($rowCompany['talentName'] == '') {
		header('Location:talent-konectt.html');
		exit();
	}

	if ($rowCompany['userId'] != $_SESSION["sessUserId"]) {
		unset($insertFields);
		unset($insertVals);
		unset($whereFields);
		unset($whereVals);

		$insertFields[0] = "viewStatus";

		$insertVals[0] = $rowCompany['viewStatus'] + 1;

		$whereFields[0] = "id";

		$whereVals[0] = decodeStr($_REQUEST['id']);

		$resUpdate = updateDB(_TALENT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	}



	$tId = trim($rowCompany['id']);
	$createdby = $rowCompany["userId"];
	$talentProfileName = stripslashes($rowCompany['talentName']);

	$shortDescription = stripslashes($rowCompany['shortDescription']);
	$longDescription = stripslashes($rowCompany['longDescription']);
	$talentProfilePhoto11 = trim($rowCompany['talentProfilePhoto']);

	$categoryId = stripslashes($rowCompany['catIds']);
	//$categoryIdArr=explode(",",$categoryId);


	if ($talentProfilePhoto11 != '') {
		$talentProfilePhoto = $talentProfilePhoto11;
	} else {
		$talentProfilePhoto = 'talentimgthumb.png';
	}


}
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $talentProfileName; ?> - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<meta property="og:title" content="<?php echo stripslashes(strip_tags($talentProfileName)); ?>" />

	<meta property="og:image" content="<?php echo $fullurl; ?>uploads/<?php echo $talentProfilePhoto; ?>" />
	<meta property="og:site_name" content="<?php echo $fullurl; ?>" />
	<meta property="og:description"
		content="<?php echo substr(stripslashes(strip_tags($longDescription)), 0, 250); ?>" />
	<meta property="og:type" content="Talent Connect" />
	<meta property="og:url" content="https://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />

	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>


</head>

<body>
	<div id="wrapper">
		<?php include('header.php'); ?>
		<div class="container main">
			<div class="home_container">
				<?php include('left-sidebar.php'); ?>
				<div class="center_content <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
				} else {
					echo 'nologin';
				} ?>">
					<div class="bx-shadow">
						<?php include('talentprofile.inc.php'); ?>
						<div class="talent-detail-page">
							<div class="tlnt-banner">
								<div class="tlnt-prflpic">
									<img src="<?php echo $fullurl; ?>uploads/<?php echo $talentProfilePhoto; ?>">
								</div>
								<div class="tlnt-prflname">
									<?php if ($createdby == $_SESSION["sessUserId"]) { ?><a
											href="<?php echo $fullurl; ?>talent-profile.html?id=<?php echo $_REQUEST['id']; ?>"><span
												class="edit"><i class="fa fa-pencil" aria-hidden="true"></i></span></a>
									<?php } ?>
									<h2><?php echo $talentProfileName; ?></h2>
									<div class="catogry">
										<!-- <?php
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$in = 0;
										$sqlOptions = "";
										$sqlOptions = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='talent' and id IN (" . $categoryId . ") ";
										$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
										if ($resOptions) {
											$totrowOptions = mysqli_num_rows($resOptions);
											while ($rowOptions = mysqli_fetch_array($resOptions)) {
												$in++;

												if ($in == $totrowOptions) {
													$coma = '';
												} else {
													$coma = ', ';
												}
												echo $rowOptions['optionName'] . $coma;
											}
										}
										?><br><br> -->

										<?php echo ($shortDescription); ?>
									</div>

									<div class="tlnt-sendinquiry"><?php if ($createdby != $_SESSION["sessUserId"]) {

										$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
										?>
											<a onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=sendtalentenquiry&purl=<?php echo $actual_link; ?>','Send Enquiry');"
												class="send-inquiry-btn">Send Enquiry</a><?php } ?>
									</div>

								</div>
							</div>
							<script>
								function showtabdata(page) {
									$('#tb1').removeClass('active');
									$('#tb2').removeClass('active');
									$('#tb3').removeClass('active');

									$('#tb' + page).addClass('active');
									var id = '<?php echo $_REQUEST['id']; ?>';
									$('#showtabsdata').load('showtabdata.php?id=' + id + '&page=' + page);

								}
							</script>
							<?php
							$sqlCompany = "SELECT id from " . _TALENT_VIDEO_TABLE_ . " WHERE talentId= " . decodeStr($_REQUEST['id']) . " order by id desc ";
							$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
							$rowvideo = mysqli_fetch_array($resCompany);


							$sqlCompany = "SELECT id from " . _TALENT_TESTIMONIALS_TABLE_ . " WHERE talentId= " . decodeStr($_REQUEST['id']) . " order by id desc ";
							$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
							$rowTestimo = mysqli_fetch_array($resCompany);

							?>
							<ul class="cntr_tab talent" id="tabboxmaintop">
								<li>
									<a onClick="showtabdata('1');" id="tb1">Biography & Topics</a>
								</li>
								<?php if ($_SESSION["sessUserId"] == $rowCompany['userId']) { ?>
									<li>
										<a onClick="showtabdata('2');" id="tb2">Videos</a>
									</li>
								<?php } else { ?>
									<?php
									if (isset($_POST['id']) && $rowvideo['id'] > 0) {
										?>
										<li>
											<a onClick="showtabdata('2');" id="tb2">Videos</a>
										</li>
									<?php }
								} ?>



								<?php if ($_SESSION["sessUserId"] == $rowCompany['userId']) { ?>
									<li>
										<a onClick="showtabdata('3');" id="tb3">Testimonials</a>
									</li>
								<?php } else { ?>
									<?php
									if (isset($_POST['id']) && $rowTestimo['id'] > 0) {
										?>
										<li>
											<a onClick="showtabdata('3');" id="tb3">Testimonials</a>
										</li>
									<?php }
								} ?>

							</ul>

							<div id="showtabsdata"></div>

							<script>
								showtabdata('1');
							</script>


							<?php
							$selectFields = [];
							$whereFields = [];
							$whereVals = [];

							$sqlCompany = "";
							$sqlCompany = "select * from " . _TALENT_MASTER_TABLE_ . " WHERE status=1 and id!=" . $tId . " ORDER BY viewStatus DESC LIMIT 0,5 ";
							$resCompany = getRecords(_TALENT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
							if ($resCompany) {
								?>
								<div class="also-viewed">
									<h1>People also viewed</h1>
									<ul class="also-viewed-list featuredtlnt">
										<?php
										while ($rowCompany = mysqli_fetch_array($resCompany)) {
											$talentProfilePhoto = '';
											if ($rowCompany["talentProfilePhoto"] != '') {
												$talentProfilePhoto = $rowCompany["talentProfilePhoto"];
											} else {
												$talentProfilePhoto = 'talentimgthumb.png';
											}

											?>
											<li onClick="location.href='<?php echo $fullurl; ?>talent-profile-detail.html?id=<?php echo encodeStr($rowCompany['id']); ?>';"
												style="cursor:pointer;">
												<div class="viewed-box">
													<div class="img">
														<img
															src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($talentProfilePhoto)); ?>">
													</div>
													<div class="dtail-viewed">
														<a
															href="<?php echo $fullurl; ?>talent-profile-detail.html?id=<?php echo encodeStr($rowCompany['id']); ?>">
															<h2><?php echo $rowCompany['talentName']; ?></h2>
															<span class="catgr">
																<?php
																$selectFields = [];
																$whereFields = [];
																$whereVals = [];
																$in = 0;
																$sqlOptions = "";
																$sqlOptions = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='talent' and id IN (" . $rowCompany['catIds'] . ") ";
																$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
																if ($resOptions) {
																	$totrowOptions = mysqli_num_rows($resOptions);
																	while ($rowOptions = mysqli_fetch_array($resOptions)) {
																		$in++;

																		if ($in == $totrowOptions) {
																			$coma = '';
																		} else {
																			$coma = ', ';
																		}
																		echo $rowOptions['optionName'] . $coma;
																	}
																}
																?>
															</span>
															<div class="descr">
																<?php echo stripslashes($rowCompany['shortDescription']); ?>
															</div>
														</a>
													</div>
												</div>
											</li>
											<?php
										}
										?>
									</ul>
								</div>
								<?php
							}
							?>
						</div>

					</div>
				</div> <!-- [End center content] -->
			</div>
		</div>
	</div>


	</div>
	</div>
	</div>
	<?php include('footer.php'); ?>
	</div>
	<script>
		<?php

		if ($_SESSION["d"] == 1) {
			?>
			showerrormsg('SUCCESS', 'SMB page deleted successfully', '');
			<?php
			$_SESSION["d"] = '';
		}

		?>
	</script>
</body>

</html>