<?php
include_once('inc.php');
$pageIndex = 13;
if ($_GET["_c"] != '') {
	$_c = decodeStr($_GET["_c"]);
	$strWhere = " and FIND_IN_SET('" . $_c . "', catIds) > 0 ";
} else {
	$strWhere = "";
}
$page = 2;


$sqlCompany = "SELECT id from " . _TALENT_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " order by id desc";
$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
$talentHave = mysqli_fetch_array($resCompany);

if ($talentHave['id'] != '') {
	header("Location: " . $fullurl . "talent-profile-detail.html?id=" . encodeStr($talentHave['id']) . "");
}
?>
<!DOCTYPE html>
<html>

<head>
	<title>My Talent Profiles - <?php echo $companNameTitle; ?></title>
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

								<ul class="also-viewed-list" style="margin-top:15px;">
									<?php
									$no = 1;
									$select = '';
									$where = '';
									$rs = '';
									$page = ($_GET['page']);


									$limit = '20';
									$select = '*';
									$where = ' where userId=' . $_SESSION["sessUserId"] . ' ' . $strWhere . ' order by id desc';
									$targetpage = $fullurl . 'my-talent-profiles.html?records=' . $limit . '&_c=' . $_GET["_c"] . '&';
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
													</div><?php if ($rowCompany['status'] == 1) { ?>
														<div class="smbstatus" style="background-color: #1db055;">Active</div>
													<?php } else { ?>
														<div class="smbstatus">Inactive</div><?php } ?>
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
	<script>
		<?php

		$cmsg = 'Talent profile page created successfully. <br><br>Your talent profile page is under reviewing. You will get a confirmation email after approval.';
		if ($_SESSION["s"] == 1) {
			?>
			showsusmsg('SUCCESS', '<?php echo $cmsg; ?>', '');
			<?php
			$_SESSION["s"] = '';
		}

		if ($_SESSION["s"] == 2) {
			?>
			showsusmsg('SUCCESS', 'Thank you for creating your profile on Talent Connect. We are reviewing the same and will come back to you shortly.', '');
			<?php
			$_SESSION["s"] = '';
		}

		if ($_SESSION["d"] == 1) {
			?>
			showerrormsg('SUCCESS', 'Talent profile page deleted successfully', '');
			<?php
			$_SESSION["d"] = '';
		}

		?>
	</script>
</body>

</html>