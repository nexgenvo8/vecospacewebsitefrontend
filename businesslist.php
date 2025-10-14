<?php
include_once('inc.php');
$pageIndex = 12;

$c = $_GET["_c"] ?? null;

if (!empty($c)) {
	$_c = decodeStr($c);
	$strWhere = " and companyTypeId=" . intval($_c) . " ";
} else {
	$strWhere = "";
}

$page = 1;
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
							<div class="filter-cat">
								<h3>Categories</h3>
								<ul class="cat-list">
									<?php
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];

									$sqlCompany = "";
									$sqlCompany = "select * from " . _BUSINESS_MASTER_TABLE_ . " where status=1  GROUP BY companyTypeId ASC ";
									$resCompany = getRecords(_BUSINESS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
									if ($resCompany) {
										while ($rowCompany = mysqli_fetch_array($resCompany)) {

											$sqlOptions1 = "SELECT id, optionName FROM " . _OPTION_MASTER_TABLE_ . " 
                        WHERE optionType='industry' AND id=" . intval($rowCompany["companyTypeId"]);

											$resOptions1 = mysqli_query($conn, $sqlOptions1);

											if ($resOptions1) {
												while ($rowOptions = mysqli_fetch_array($resOptions1)) {
													?>
													<li <?php if (isset($_GET["_c"]) && $_GET["_c"] == $rowOptions['id']) { ?>class="active" <?php } ?>>
														<a
															href="<?php echo $fullurl; ?>smb-categories.html?_c=<?php echo encodeStr(trim($rowOptions['id'])); ?>">
															<?php echo trim($rowOptions['optionName']); ?>
														</a>
													</li>
													<?php
												}
												mysqli_free_result($resOptions1);
											}
										}
										mysqli_free_result($resCompany);
									}


									?>
								</ul>
							</div>

							<div class="retd-list-cont">
								<?php
								$_c = isset($_GET["_c"]) ? intval($_GET["_c"]) : 0;
								$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;

								if ($_c != 0) {
									?>
									<div style="padding:20px; font-size:20px; padding-bottom:0px; float:left;">
										<?php
										$a = "SELECT optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE id = " . intval($_c);
										$b = mysqli_query($conn, $a) or die(mysqli_error($conn));

										if ($b && mysqli_num_rows($b) > 0) {
											$rowindustryTypeName = mysqli_fetch_array($b);
											echo htmlspecialchars($rowindustryTypeName["optionName"]);
										} else {
											echo "No option found";
										}

										mysqli_free_result($b);
										?>
									</div>
								<?php } ?>


								<ul class="busssiness-list">
									<?php
									$no = 1;
									$limit = 20;
									$select = '*';
									$where = ' WHERE status=1 ' . $strWhere . ' ORDER BY id DESC';
									$targetpage = $fullurl . 'smb-categories.html?records=' . $limit . '&_c=' . $_c . '&';

									// Pagination calculations
									$page = isset($_GET["page"]) ? intval($_GET["page"]) : 1;
									$limit = intval($limit); // ensure limit is integer
									$start = ($page - 1) * $limit;

									// Main query
									$sql = "SELECT $select FROM " . _BUSINESS_MASTER_TABLE_ . " $where LIMIT $start, $limit";
									$resCompany = mysqli_query($conn, $sql) or die("Error: " . mysqli_error($conn));

									// Total entries
									$sqlCount = "SELECT COUNT(*) FROM " . _BUSINESS_MASTER_TABLE_ . " $where";
									$resCount = mysqli_query($conn, $sqlCount) or die("Error: " . mysqli_error($conn));
									$totalentry = mysqli_fetch_array($resCount)[0];

									// Generate paging manually
									$totalPages = ceil($totalentry / $limit);
									$paging = '';
									for ($i = 1; $i <= $totalPages; $i++) {
										$paging .= '<a href="' . $targetpage . 'page=' . $i . '"';
										if ($i == $page)
											$paging .= ' class="active"';
										$paging .= ">$i</a> ";
									}

									// Mimic GetRecordList return structure
									$rs = [$resCompany, $totalentry, $paging];


									if ($totalentry > 0) {
										while ($rowCompany = mysqli_fetch_array($rs[0])) {
											$companyPhoto = $rowCompany["fileUploaded"] ?: 'businessimg.jpg';
											?>
											<li onclick="location.href='<?php echo $fullurl; ?><?php echo _SMBURL_TEXT_; ?>/<?php echo encodeStr($rowCompany['id']); ?>/<?php echo makeContentUrl($rowCompany['companyBusinessName']); ?>.html';"
												style="cursor:pointer;">
												<div class="bussns-box">
													<div class="bsns-img"><img
															src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>">
													</div>
													<div class="bsns-list-right">
														<h4><?php echo htmlspecialchars($rowCompany['companyBusinessName']); ?>
														</h4>
														<span class="vw"><i class="fa fa-eye" aria-hidden="true"></i>
															<?php echo intval($rowCompany['viewStatus']); ?></span>
														<p class="loctn-info"><i class="fa fa-map-marker"
																aria-hidden="true"></i>
															<?php echo htmlspecialchars($rowCompany['completeAddress']); ?></p>
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
										?>
										<div style="margin-top:20px; text-align:left;">
											<div class="pagingnumbers"><?php echo $paging; ?></div>
										</div>
										<?php
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