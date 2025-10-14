<?php
include_once('inc.php');
$pageIndex = 8;
$strWhereVar = "";
$strSearchVar = clean($_GET["searchcompanies"]);
if ($strSearchVar != '') {
	$strWhereVar = " and (companyName like '%" . $strSearchVar . "%' OR aboutCompany like '%" . $strSearchVar . "%' OR companyAddress like '%" . $strSearchVar . "%' OR emailAaddress like '%" . $strSearchVar . "%' OR phoneNumber like '%" . $strSearchVar . "%' OR cityName like '%" . $strSearchVar . "%') ";
}
$aa = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE id='" . $industryId . "' ";
$res5 = mysqli_query($conn, $aa);
$rowindustry = mysqli_fetch_array($res5);

if ($rowindustry) {   // check added
	$userIndustryName = trim($rowindustry['optionName']);

	if (!empty($rowindustry["imageName"])) {
		$userindustryPhoto = $rowindustry["imageName"];
	} else {
		$userindustryPhoto = 'company.png';
	}
} else {
	$userIndustryName = '';
	$userindustryPhoto = 'company.png';
}


?>
<!DOCTYPE html>
<html>

<head>
	<title>Corporate - <?php echo $companNameTitle; ?></title>
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
				<div
					class="center_content <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
					} else {
						echo 'nologin';
					} ?>">
					<div class="bx-shadow">
						<?php include('searchcmp.inc.php'); ?>
						<div class="artcle">
							<div class="cntr_cntnt" style="width: 566px;">
								<div class="compny">
									<h2>Search results for (<?php echo $strSearchVar; ?>)</h2>
									<ul class="employers-list">
										<?php
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];
										$n = 0;
										$sqlCompany = "";
										$sqlCompany = "select * from " . _COMPANY_MASTER_TABLE_ . " where companyName!='' and status=0 " . $strWhereVar . " order by id desc LIMIT 0,50 ";
										$resCompany = getRecords(_COMPANY_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
										if ($resCompany) {
											while ($rowCompany = mysqli_fetch_array($resCompany)) {
												$companyPhoto = '';
												$companyTypeName = '';
												if ($rowCompany["companyTypeId"] != 0 && $rowCompany["companyTypeId"] != '') {
													$a = "SELECT * from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $rowCompany["companyTypeId"] . "";
													$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
													$rowCompanyTypeName = mysqli_fetch_array($b);
													$companyTypeName = $rowCompanyTypeName["optionName"];
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

												?>
												<li>
													<div class="employers">
														<div class="comp-logo">
															<a
																href="<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo encodeStr($rowCompany['id']); ?>"><img
																	src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>"
																	title="<?php echo stripslashes($rowCompany["companyName"]); ?>"
																	alt="<?php echo stripslashes(trim($rowCompany["companyName"])); ?>"></a>
														</div>
														<div class="comp-mddl">
															<a href="<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo encodeStr($rowCompany['id']); ?>"
																class="nm"><?php echo getStrLength(stripslashes($rowCompany["companyName"]), 100); ?></a>
															<span
																class="catgr"><?php echo stripslashes($companyTypeName); ?></span>
															<span
																class="clstou"><?php echo getStrLength(stripslashes($rowCompany["aboutCompany"]), 150); ?></span>
														</div>
													</div>
												</li>
												<?php $n++;
											}
										}
										?>
									</ul>
									<?php if ($n == 0) { ?>
										<div style="padding:20px; text-align:center;">You have no found any company.</div>
									<?php } ?>
								</div>


							</div>
							<?php include('companyrightlanding.php'); ?>
						</div>


					</div>


				</div>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>
	<script>
		function reloadPage() {
			location.reload(true);
		}

	</script>
</body>

</html>