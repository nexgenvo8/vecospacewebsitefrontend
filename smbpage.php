<?php
include_once('inc.php');
$pageIndex = 12;


?>
<!DOCTYPE html>
<html>

<head>
	<title>Business - <?php echo $companNameTitle; ?></title>
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
						<?php include('businesstopinc.php'); ?>
						<div class="smb-cont">

							<div class="smb-bnnr">
								<div class="bnnr-cap" style="width:436px; text-align:left; font-size:13px !important;">

									<?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?><a
											style="background-color:#FFFFFF; color:#00a0af;"
											href="<?php echo $fullurl; ?>cbp.html" class="getstart">Create Business
											Page</a><?php } ?>
								</div>
							</div>
							<div class="smb-wrapper">
								<h1>
									<span> Establish your business presence on <?php echo $companNameTitle; ?>,
										today.</span>
								</h1><br>
								<div class="how-benefit">
									<h2>The benefits for creating a Business Page on <?php echo $companNameTitle; ?>
									</h2>
									<ul class="bnfit-list">
										<li>
											<i class="fa fa-check" aria-hidden="true"></i>
											<p>NDIM VECOSPACE will provide interactive sessions with Career Enhancing
												experts</p>
										</li>
										<li>
											<i class="fa fa-check" aria-hidden="true"></i>
											<label>Skills Enhancement Courses will help -:</label>
											<p style="margin-bottom: 0px;">Change or grow your position and need to
												refresh your skills.</p>
											<p>Learn new skills to increase or modify your field of specialization.</p>
										</li>
										<li>
											<i class="fa fa-check" aria-hidden="true"></i>
											<label>Professional Development Courses will help-:</label>
											<p>Plan for and get the career you want.</p>
										</li>
									</ul>
									<div class="trnding-bsns">
										<h2>Featured Industry pages <div class="bs-fot"
												style="background-color:#C02621;"><a
													href="<?php echo $fullurl; ?>smb-categories.html">View all</a></div>
										</h2>
										<ul class="trnding-bsns-list">


											<?php
											$selectFields = [];
											$whereFields = [];
											$whereVals = [];

											$sqlCompany = "";
											$sqlCompany = "select * from " . _BUSINESS_MASTER_TABLE_ . " where fileUploaded!='' and status=1 ORDER BY rand() LIMIT 0,3 ";
											$resCompany = getRecords(_BUSINESS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
											if ($resCompany) {
												while ($rowCompany = mysqli_fetch_array($resCompany)) {
													$companyPhoto = '';
													$industryTypeName = '';
													if ($rowCompany["companyTypeId"] != 0 && $rowCompany["companyTypeId"] != '') {
														$a = "";
														$a = "SELECT * from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $rowCompany["companyTypeId"] . "";
														$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
														$rowindustryTypeName = mysqli_fetch_array($b);
														$industryTypeName = $rowindustryTypeName["optionName"];
													}

													if ($rowCompany["fileUploaded"] != '') {
														$companyPhoto = $rowCompany["fileUploaded"];
													} else {
														$companyPhoto = 'businessimg.png';
													}

													?>
													<li onClick="location.href='<?php echo $fullurl; ?><?php echo _SMBURL_TEXT_; ?>/<?php echo encodeStr($rowCompany['id']); ?>/<?php echo makeContentUrl($rowCompany['companyBusinessName']); ?>.html';"
														style="cursor:pointer;">
														<div class="trending-business">
															<div class="img"><img
																	src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>">
															</div>
															<a
																class="bttl"><?php echo $rowCompany['companyBusinessName']; ?></a>
															<span class="blocat"><?php echo $industryTypeName; ?></span>
															<a href="<?php echo $fullurl; ?><?php echo _SMBURL_TEXT_; ?>/<?php echo encodeStr($rowCompany['id']); ?>/<?php echo makeContentUrl($rowCompany['companyBusinessName']); ?>.html"
																class="fl-dtail-btn">View detail</a>
														</div>
													</li>


													<?php
												}
											}
											?>
										</ul>
									</div>


								</div>
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
	<script>
		<?php

		if ($_SESSION["d"] == 1) {
			?>
			showerrormsg('SUCCESS', 'SME page deleted successfully', '');
			<?php
			$_SESSION["d"] = '';
		}

		?>
	</script>
	<style type="text/css">
		.evnt-crt-btn.smbcls {
			display: none !important;
		}

		.popular-artcle1 .artcle-boxp {
			width: 31%;
			float: none;
			margin-right: 18px;
			display: inline-block;
			margin-bottom: 30px;
		}
	</style>
</body>

</html>