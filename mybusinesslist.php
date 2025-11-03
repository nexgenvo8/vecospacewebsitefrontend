<?php
include_once('inc.php');
include_once('config/session-check.inc.php');
$pageIndex = 12;

$page = 2;
?>
<!DOCTYPE html>
<html>

<head>
	<title>Business - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
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
					<div class="bx-shadow"><?php include('businesstopinc.php'); ?>
						<div class="busssiness-list-cont">


							<div class="trnding-bsns" style="margin-top:20px;">
								<ul class="trnding-bsns-list">


									<?php
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];

									$sqlCompany = "";
									$sqlCompany = "select * from " . _BUSINESS_MASTER_TABLE_ . " where userId=" . $_SESSION["sessUserId"] . " ORDER BY id DESC  ";
									$resCompany = getRecords(_BUSINESS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
									if ($resCompany) {
										while ($rowCompany = mysqli_fetch_array($resCompany)) {
											$companyPhoto = '';
											$industryTypeName = '';

											if ($rowCompany["companyTypeId"] != 0 && $rowCompany["companyTypeId"] != '') {
												$a = "SELECT * FROM " . _OPTION_MASTER_TABLE_ . " WHERE id = " . intval($rowCompany["companyTypeId"]);
												$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
												$rowindustryTypeName = mysqli_fetch_array($b);
												$industryTypeName = $rowindustryTypeName["optionName"];
											}

											if ($rowCompany["fileUploaded"] != '') {
												$companyPhoto = $rowCompany["fileUploaded"];
											} else {
												$companyPhoto = 'businessimg.jpg';
											}
											?>
											<li onclick="location.href='<?php echo $fullurl; ?><?php echo _SMBURL_TEXT_; ?>/<?php echo encodeStr($rowCompany['id']); ?>/<?php echo makeContentUrl($rowCompany['companyBusinessName']); ?>.html';"
												style="cursor:pointer;">
												<div class="trending-business">
													<div class="img">
														<img
															src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>">
													</div>
													<?php if ($rowCompany['status'] == 1) { ?>
														<div class="smbstatus" style="background-color: #FF0000;">Active</div>
													<?php } else { ?>
														<div class="smbstatus">Inactive</div>
													<?php } ?>
													<a class="bttl"><?php echo $rowCompany['companyBusinessName']; ?></a>
													<span class="blocat"><?php echo $industryTypeName; ?></span>
													<a href="<?php echo $fullurl; ?><?php echo _SMBURL_TEXT_; ?>/<?php echo encodeStr($rowCompany['id']); ?>/<?php echo makeContentUrl($rowCompany['companyBusinessName']); ?>.html"
														class="fl-dtail-btn">View detail</a>
												</div>
											</li>
											<?php
										}
									} else {
										?>
										<div style="padding:20px; text-align:center;">There is no business page currently to
											display.</div>
										<?php
									}
									?>
								</ul>
							</div>

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

</body>

</html>