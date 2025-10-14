<?php
include_once('inc.php');
$pageIndex = 13;

$_c = ''; // initialize variable

if (isset($_GET["_c"]) && $_GET["_c"] != '') {
	$_c = decodeStr($_GET["_c"]);
	$strWhere = " and FIND_IN_SET('" . $_c . "', catIds) > 0 ";
} else {
	$strWhere = "";
}

$page = 1;
?>


<!DOCTYPE html>
<html>

<head>
	<title>Talent - <?php echo $companNameTitle; ?></title>
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
					<div class="bx-shadow">
						<?php include('talentprofile.inc.php'); ?>
						<div class="busssiness-list-cont">
							<div class="filter-cat">
								<h3>Topics</h3>
								<ul class="cat-list">
									<?php
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];

									$sqlOptions1 = "";
									$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='talent' ";
									$resOptions1 = getRecords(_OPTION_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
									if ($resOptions1) {
										while ($rowOptions = mysqli_fetch_array($resOptions1)) {
											?>
											<li <?php if ($_c == $rowOptions['id']) { ?>class="active" <?php } ?>><a
													href="<?php echo $fullurl; ?>more-talent-profiles.html?_c=<?php echo encodeStr(trim($rowOptions['id'])); ?>"><?php echo trim($rowOptions['optionName']); ?></a>
											</li>
											<?php
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
">
										<?php
										$a = "";
										$a = "SELECT optionName from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $_c . "";
										$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
										$rowindustryTypeName = mysqli_fetch_array($b);
										echo $rowindustryTypeName["optionName"];
										?>
									</div>
								<?php } ?>

								<ul class="also-viewed-list">
									<?php
									$no = 1;
									$select = '';
									$where = '';
									$rs = '';
									$page = isset($_GET['page']) ? $_GET['page'] : 1; // default to page 1
									


									$limit = '20';
									$select = '*';
									$where = ' where status=1 ' . $strWhere . ' order by id desc';
									$_c_param = isset($_GET["_c"]) ? $_GET["_c"] : '';
									$targetpage = $fullurl . 'more-talent-profiles.html?records=' . $limit . '&_c=' . $_c_param . '&';

									$rs = GetRecordList($select, _TALENT_MASTER_TABLE_, $where, $limit, $page, $targetpage);
									$totalentry = $rs[1];
									$paging = $rs[2];
									if ($totalentry > 0) {
										while ($rowCompany = mysqli_fetch_array($rs[0])) {

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
													<div class="img"><img
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