<?php
include_once('inc.php');
$pageIndex = 12;
if ($_GET["_c"] != '') {
	$_c = decodeStr($_GET["_c"]);
	$strWhere = " and companyTypeId=" . $_c . " ";
} else {
	$strWhere = "";
}
$page = 1;
?>
<!DOCTYPE html>
<html>

<head>
	<title>Business - Welcome to Konectt</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>

	<style type="text/css">
		@media only screen and (min-width: 800px) {
			.left_menu_sec {
				width: 60px;
				float: left;
				overflow: inherit;
			}

			.menu {
				width: 100%;
			}

			ul.nav_list li a span.tltp {
				display: none;
			}

			ul.nav_list li a i.micon {
				float: none !important;
				margin: auto;
			}

			ul.nav_list li a {
				overflow: inherit;
			}

			ul.nav_list li a:hover .tltp {
				display: inline-table;
				position: absolute;
				left: 100%;
				z-index: 9999;
				background-color: #000;
				line-height: 20px;
				top: 10px !important;
				padding: 0px 10px;
				white-space: nowrap;
				font-size: 13px;
				border-radius: 0 2px 2px 0;
			}

			ul.nav_list li a .coming {
				display: none;
			}

			ul.nav_list li.user .connctn {
				display: none;
			}

			ul.nav_list li.user .img {
				width: 40px;
			}

			ul.nav_list li.user .usr-right {
				display: none;
			}

			ul.nav_list li {
				padding-bottom: 5px;
			}

			ul.nav_list li:last-child {
				padding-bottom: 0;
			}
		}

		.my-message {
			padding: 0 !important
		}

		.center_content {
			float: right;
			width: 100%;
			padding-left: 83px;
		}

		.chat_list {
			width: 200px;
		}

		.chat_box {
			width: 62%;
		}

		.chat_list.mmbr {
			float: right;
		}

		.chat_list.mmbr {
			width: 207px;
			border-left: 0;
		}

		.chats {
			overflow: auto;
		}

		.bussns-box .bsns-img img {
			max-width: 100%;
		}
	</style>

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
							<div class="filter-cat">
								<h3>Categories</h3>
								<ul class="cat-list">
									<?php
									$selectFieldsv = [];
									$whereFields = [];
									$whereVals = [];

									$sqlCompany = "";
									$sqlCompany = "select * from " . _BUSINESS_MASTER_TABLE_ . " where status=1  GROUP BY companyTypeId ASC ";
									$resCompany = getRecords(_BUSINESS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
									if ($resCompany) {
										while ($rowCompany = mysqli_fetch_array($resCompany)) {

											$sqlOptions1 = "";
											$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry' and id=" . $rowCompany["companyTypeId"] . " ";
											$resOptions1 = getRecords(_EMPLOYERS_NUMBERS_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
											if ($resOptions1) {
												while ($rowOptions = mysqli_fetch_array($resOptions1)) {
													?>
													<li <?php if ($_c == $rowOptions['id']) { ?>class="active" <?php } ?>><a
															href="<?php echo $fullurl; ?>smb-categories.html?_c=<?php echo encodeStr(trim($rowOptions['id'])); ?>"><?php echo trim($rowOptions['optionName']); ?></a>
													</li>
													<?php
												}
											}

										}

									}

									?>
								</ul>
							</div>

							<div class="retd-list-cont">
								<?php
								if ($_c != 0 && $_c != '') {
									?>
									<div style="
   padding: 20px;
   font-size: 20px;
   padding-bottom: 0px;float: left;
"> 	<?php
	$a = "";
	$a = "SELECT optionName from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $_c . "";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$rowindustryTypeName = mysqli_fetch_array($b);
	echo $rowindustryTypeName["optionName"];
	?></div> <?php } ?>

								<ul class="busssiness-list">
									<?php

									$selectFields = [];
									$whereFields = [];
									$whereVals = [];

									$sqlCompany = "";
									$sqlCompany = "select * from " . _BUSINESS_MASTER_TABLE_ . " where status=1 " . $strWhere . " ORDER BY id DESC LIMIT 0,10 ";
									$resCompany = getRecords(_BUSINESS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
									if ($resCompany) {
										while ($rowCompany = mysqli_fetch_array($resCompany)) {
											$companyPhoto = '';


											if ($rowCompany["fileUploaded"] != '') {
												$companyPhoto = $rowCompany["fileUploaded"];
											} else {
												$companyPhoto = 'businessimg.png';
											}

											?>

											<li onClick="location.href='<?php echo $fullurl; ?><?php echo _SMBURL_TEXT_; ?>/<?php echo encodeStr($rowCompany['id']); ?>/<?php echo makeContentUrl($rowCompany['companyBusinessName']); ?>.html';"
												style="cursor:pointer;">
												<div class="bussns-box">
													<div class="bsns-img"><img
															src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>">
													</div>
													<div class="bsns-list-right">
														<h4><?php echo $rowCompany['companyBusinessName']; ?></h4>
														<span class="vw"><i class="fa fa-eye" aria-hidden="true"></i>
															<?php echo $rowCompany['viewStatus']; ?></span>
														<p class="loctn-info"><i class="fa fa-map-marker"
																aria-hidden="true"></i>
															<?php echo $rowCompany['completeAddress']; ?></p>
														<p class="loctn-info">
															<?php echo stripslashes($rowCompany['shortDescription']); ?>
														</p>
														<a href="<?php echo $fullurl; ?><?php echo _SMBURL_TEXT_; ?>/<?php echo encodeStr($rowCompany['id']); ?>/<?php echo makeContentUrl($rowCompany['companyBusinessName']); ?>.html"
															class="btn">View Detail</a>
													</div>
												</div>
											</li>

											<?php
										}
									} else {
										?>
										<div style="padding:20px; text-align:center;">Not found</div>
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