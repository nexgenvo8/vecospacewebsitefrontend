<?php
include_once('inc.php');
$pageIndex = 8;
$p = 4;
?>

<?php
if (isset($_REQUEST['companyId']) && isset($_REQUEST['status']) && $_REQUEST['companyId'] != '' && $_REQUEST['status'] != '') {
	$companyId = decodeStr($_REQUEST['companyId']);
	$status = trim($_REQUEST['status']);

	if ($status == 2) {
		$sql_ins = "DELETE FROM " . _COMPANY_FOLLOWERS_TABLE_ . " WHERE companyId= " . $companyId . "  and userId=" . $_SESSION["sessUserId"] . "  ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	} else {
		$a = "insert into " . _COMPANY_FOLLOWERS_TABLE_ . " set userId=" . $_SESSION["sessUserId"] . ",companyId=" . $companyId . ",dateAdded=" . time() . "";
		mysqli_query($conn, $a) or die(mysqli_error($conn));
	}

	header('Location:employees.html?companyId=' . $_REQUEST['companyId'] . '');
	exit();

}
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlCompany = "";
$sqlCompany = "select * from " . _COMPANY_MASTER_TABLE_ . " where id= " . decodeStr($_REQUEST['companyId']) . " and companyName!=''  ";
$resCompany = getRecords(_COMPANY_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);

while ($rowCompany = mysqli_fetch_array($resCompany)) {
	$companyPhoto = '';
	$companyTypeName = '';
	$createdby = $rowCompany["userId"];
	$empCompanyName = $rowCompany["companyName"];
	$empCompanyAddress = $rowCompany["companyAddress"];
	$companyIndustryTypeId = $rowCompany["companyTypeId"];
	$establishedYear = $rowCompany["establishedYear"];
	$phoneNumber = trim($rowCompany['phoneNumber']);
	$emailAaddress = trim($rowCompany['emailAaddress']);
	$companyUrl = trim($rowCompany['companyUrl']);
	$companyStatus = trim($rowCompany['status']);


	if ($rowCompany['id'] == '') {
		header("Location: " . $fullurl . "404error.html");
		exit();
	}

	if ($companyIndustryTypeId != 0 && $companyIndustryTypeId != '') {
		$a = "";
		$a = "SELECT * from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $companyIndustryTypeId . "";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$rowCompanyTypeName = mysqli_fetch_array($b);
		$industryTypeName = $rowCompanyTypeName["optionName"];

		$at = "";
		$at = "select count(*) as total from " . _USERS_MASTER_TABLE_ . " where  companyName='" . $empCompanyName . "' ";
		$bt = mysqli_query($conn, $at) or die(mysqli_error($conn));
		$getTotal = mysqli_fetch_array($bt);
		$totalEmployeesTotals = $getTotal['total'];
	}
	if ($rowCompany["subIndustryId"] != 0 && $rowCompany["subIndustryId"] != '') {
		$a = "";
		$a = "SELECT * from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $rowCompany["subIndustryId"] . "";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$rowindustryTypeName = mysqli_fetch_array($b);
		$industrySubTypeName = $rowindustryTypeName["optionName"];
	}

	$ata = "select firstName,lastName,userId from " . _USERS_MASTER_TABLE_ . " where  userId= " . $createdby . " ";
	$pta = mysqli_query($conn, $ata) or die(mysqli_error($conn));
	$rowuserdetails = mysqli_fetch_array($pta);

	if ($rowCompany["countryId"] != 0 && $rowCompany["countryId"] != '') {
		$atac = "";
		$atac = "select * from " . _COUNTRIES_TABLE_ . " where  id= " . $rowCompany["countryId"] . " ";
		$ptac = mysqli_query($conn, $atac) or die(mysqli_error($conn));
		$rowcmpdetails = mysqli_fetch_array($ptac);
		$empcountry_name = $rowcmpdetails['country_name'];
	}

	if ($rowCompany["stateId"] != 0 && $rowCompany["stateId"] != '') {
		$atac = "";
		$atac = "select * from " . _STATE_MASTER_TABLE_ . " where  id= " . $rowCompany["stateId"] . " ";
		$ptac = mysqli_query($conn, $atac) or die(mysqli_error($conn));
		$rowcmpdetails = mysqli_fetch_array($ptac);
		$empstate_name = $rowcmpdetails['name'];
	}

	if ($rowCompany['id'] != 0 && $rowCompany['id'] != '') {
		$ap = "select imageName from " . _IMAGE_MASTER_TABLE_ . " where  postId= " . $rowCompany['id'] . " and imageType=8 ";
		$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
		$rowLogoImg = mysqli_fetch_array($bp);

		if ($rowLogoImg["imageName"] != '') {
			$companyPhoto = $rowLogoImg["imageName"];
		} else {
			$companyPhoto = 'company.png';
		}

	}

	if ($rowCompany['empnoId'] != 0 && $rowCompany['empnoId'] != '') {
		$apen = "select numberOfEmployees from " . _EMPLOYERS_NUMBERS_TABLE_ . " where  id= " . $rowCompany['empnoId'] . "";
		$bpen = mysqli_query($conn, $apen) or die(mysqli_error($conn));
		$getnoEmployees = mysqli_fetch_array($bpen);
		$numberOfEmployees = $getnoEmployees['numberOfEmployees'];

	}
}

$totalEmployees = 0;

$sqlFollowersMember = "SELECT userId FROM " . _COMPANY_FOLLOWERS_TABLE_ . " 
    WHERE companyId = " . decodeStr($_REQUEST['companyId']) . " 
    AND userId = " . $createdby . " 
    ORDER BY id ASC LIMIT 0,1";

$resFollowersMember = getRecords(_COMPANY_FOLLOWERS_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlFollowersMember);

$getFollowersTotalMember = mysqli_num_rows($resFollowersMember);

$totalEmployees = $totalEmployees + $getFollowersTotalMember;



?>
<!DOCTYPE html>
<html>

<head>
	<title>Companies - <?php echo $companNameTitle; ?></title>
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
				<?php include('left-sidebar.php'); ?>
				<div class="center_content <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
				} else {
					echo 'nologin';
				} ?>">
					<div class="artcle comp-profile">

						<?php include('companyheader.php'); ?>
						<?php if ($createdby == $_SESSION["sessUserId"]) { ?>
							<a class="crtjob-btn"
								href="<?php echo $fullurl; ?>add-job.html?companyId=<?php echo $_REQUEST['companyId']; ?>">Post
								Job</a>
						<?php } ?>

						<ul class="compny-joblist">

							<?php
							$selectFields = [];
							$whereFields = [];
							$whereVals = [];
							$n = 0;
							$j = 0;
							$sqlCompany = "";
							$sqlCompany = "select * from " . _JOBS_MASTER_TABLE_ . " where companyId= " . decodeStr($_REQUEST['companyId']) . " order by id desc LIMIT 0,10 ";
							$resCompany = getRecords(_JOBS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
							if ($resCompany) {

								while ($rowCompany = mysqli_fetch_array($resCompany)) {

									if ($rowCompany["userId"] == $_SESSION["sessUserId"] && $rowCompany["status"] == 0) {
										$j = 1;
										?>
										<li>
											<div class="cmpny-jobbox"><span
													class="ago"><?php echo makedatetime(strtotime($rowCompany["dateAdded"])); ?></span>
												<a href="<?php echo $fullurl; ?>view-job.html?id=<?php echo encodeStr($rowCompany['id']); ?>"
													class="prfl-nam"><?php echo stripslashes($rowCompany["jobTitle"]); ?></a>
												<div class="cmpny-nm" style="color:#d2953b;">
													<?php
													$selectFields = [];
													$whereFields = [];
													$whereVals = [];
													$levelId = '';
													$sqlOptions1 = "";
													$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE  id=" . $rowCompany["levelId"] . " ";
													$resOptions1 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
													if ($resOptions1) {
														while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
															if ($levelId == $rowOptions1['id']) {
																$strSelected = 'selected="selected"';
															} else {
																$strSelected = "";
															}
															echo trim($rowOptions1['optionName']);
														}
													}
													?>
												</div>

												<div class="cmpny-nm" style="font-size: 14px;"><strong>Location:
													</strong><?php echo stripslashes($rowCompany["jobLocation"]); ?></div>
												<p class="job-descrpt">



													<?php echo getStrLength(strip_tags(stripslashes($rowCompany["jobDetails"])), 220);

													?>

												<div style="margin-top:5px; color:#FF0000;">Under Reviewing</div>

												</p>
											</div>

										</li>

										<?php
									} else {

										if ($rowCompany["status"] == 1) {

											if ($rowCompany["jobStatus"] == 1) {
												$j = 1;
												?>

												<li>
													<div class="cmpny-jobbox"><span
															class="ago"><?php echo makedatetime(strtotime($rowCompany["dateAdded"])); ?></span>
														<a href="<?php echo $fullurl; ?>view-job.html?id=<?php echo encodeStr($rowCompany['id']); ?>"
															class="prfl-nam"><?php echo stripslashes($rowCompany["jobTitle"]); ?></a>
														<div class="cmpny-nm" style="color:#d2953b;">
															<?php
															$selectFields = [];
															$whereFields = [];
															$whereVals = [];

															$sqlOptions1 = "";
															$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE  id=" . $rowCompany["levelId"] . " ";
															$resOptions1 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
															if ($resOptions1) {
																while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
																	if ($levelId == $rowOptions1['id']) {
																		$strSelected = 'selected="selected"';
																	} else {
																		$strSelected = "";
																	}
																	echo trim($rowOptions1['optionName']);
																}
															}
															?>
														</div>

														<div class="cmpny-nm" style="font-size: 14px;"><strong>Location:
															</strong><?php echo stripslashes($rowCompany["jobLocation"]); ?></div>
														<p class="job-descrpt">

															<?php echo getStrLength(strip_tags(stripslashes($rowCompany["jobDetails"])), 220); ?>


														</p>
														<a href="<?php echo $fullurl; ?>view-job.html?id=<?php echo encodeStr($rowCompany['id']); ?>"
															class="applyjob-btn">Apply Now</a>
													</div>

												</li>

											<?php } else {
												if ($rowCompany["userId"] == $_SESSION["sessUserId"]) {
													$j = 1; ?>




													<li>
														<div class="cmpny-jobbox"><span
																class="ago"><?php echo makedatetime(strtotime($rowCompany["dateAdded"])); ?></span>
															<a href="<?php echo $fullurl; ?>view-job.html?id=<?php echo encodeStr($rowCompany['id']); ?>"
																class="prfl-nam"><?php echo stripslashes($rowCompany["jobTitle"]); ?></a>
															<div class="cmpny-nm" style="color:#d2953b;">
																<?php
																$selectFields = [];
																$whereFields = [];
																$whereVals = [];

																$sqlOptions1 = "";
																$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE  id=" . $rowCompany["levelId"] . " ";
																$resOptions1 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
																if ($resOptions1) {
																	while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
																		if ($levelId == $rowOptions1['id']) {
																			$strSelected = 'selected="selected"';
																		} else {
																			$strSelected = "";
																		}
																		echo trim($rowOptions1['optionName']);
																	}
																}
																?>
															</div>

															<div class="cmpny-nm" style="font-size: 14px;"><strong>Location:
																</strong><?php echo stripslashes($rowCompany["jobLocation"]); ?></div>
															<p class="job-descrpt">

																<?php echo getStrLength(strip_tags(stripslashes($rowCompany["jobDetails"])), 220); ?>


															<div style="margin-top:5px; color:#FF0000;">Disabled Job</div>

														</div>

													</li>

													<?php


												}


											}






										}
									}



								}
								if ($j == 0) {
									?>
									<div style="padding:20px; text-align:center;">There are no jobs, currently in this company.
									</div>
									<?php
								}
							} else {
								?>
								<div style="padding:20px; text-align:center;">There are no jobs, currently in this company.
								</div>
								<?php
							}
							?>
						</ul>


					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include('footer.php'); ?>
	</div>
	<script>

		<?php
		$cmsg = 'Thank you for posting a Job on ' . $companNameTitle . '. We are reviewing the same and will come back to you shortly.';

		if ($_SESSION["s"] == 1) {
			?>
			showsusmsg('SUCCESS', '<?php echo $cmsg; ?>', '');
			<?php
			$_SESSION["s"] = '';
		}

		if ($_SESSION["s"] == 2) {
			?>
			showsusmsg('SUCCESS', 'Job updated successfully', '');
			<?php
			$_SESSION["s"] = '';
		}


		?>
	</script>
</body>

</html>