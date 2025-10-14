<?php
include_once('inc.php');
$pageIndex = 13;

$page = isset($_GET['page']) ? intval($_GET['page']) : 1; // Fix undefined variable

if (!empty($_SESSION["sessUserId"]) && $_SESSION["sessUserId"] != 0) {
	$userwhereid = $_SESSION["sessUserId"];
} else {
	$userwhereid = 0;
}

$sqlCompany = "SELECT id FROM " . _TALENT_MASTER_TABLE_ . " WHERE userId=" . intval($userwhereid) . " ORDER BY id DESC";
$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
$talentHave = mysqli_fetch_array($resCompany);
?>

<!DOCTYPE html>
<html>

<head>
	<title>Talent - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<style type="text/css">
		li.evnt-crt-btn.smbcls {
			display: none;
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
					<div class="bx-shadow">
						<?php include('talentprofile.inc.php'); ?>
						<div class="smb-bnnr tlnt">
							<div class="bnnr-cap"
								style="width: 436px; text-align: left; font-size: 13px !important; top: 65%; left: 78.5%;">
								<?php
								// ✅ Show only if user is logged in and has NO talent profile yet
								if (!empty($_SESSION["sessUserId"]) && empty($talentHave['id'])) {
									?>
									<a style="background-color:#FFFFFF; color:#00a0af;"
										href="<?php echo $fullurl; ?>talent-profile.html" class="getstart">Create Talent
										Profile</a>
									<?php
								}
								?>
							</div>
						</div>

						<div class="smb-wrapper">

							<div class="how-benefit">
								<h2>Various Industry professionals and representatives will be given an invitation
									for Guest lectures at <?php echo $companNameTitle; ?></h2>
								<ul class="bnfit-list">
									<li>
										<i class="fa fa-check" aria-hidden="true"></i>
										<p>Students can attend these lectures for additional insight about a
											specific career field.</p>
									</li>
									<li>
										<i class="fa fa-check" aria-hidden="true"></i>
										<p>It will help students establish a professional contact with industry
											representatives.</p>
									</li>
									<li>
										<i class="fa fa-check" aria-hidden="true"></i>
										<p>Attending these lectures will help students develop a global approach to
											understand the changes taking place every day globally.</p>
									</li>
									<li>
										<strong><?php echo $companNameTitle; ?> for Business Speakers, Artists and
											Trainers</strong><br><br>
										If you are a Speaker, Trainer, Master of Ceremonies, Entertainment
										artist/group etc, register yourself on <?php echo $companNameTitle; ?>. The
										benefits to you will be: <span><a style=" cursor:pointer;" id="readmorebtn"
												onClick="$('#displayothertext').show();$('#readmorebtn').hide();">read
												more</a></span> <br>
										<span id="displayothertext" style="display:none;">
											<p> Please read these <strong><a href="terms.html" target="_blank">Terms</a>
												</strong> for details.<br><br>
												<strong>Contact Us</strong> on <a
													href="mailto:info@deboxglobal.in">info@deboxglobal.in</a> to
												learn how you can bring a top business speaker or entertainment
												artist to your next company event or offsite.
											</p>
										</span>
									</li>
								</ul>


								<?php
								$selectFields = [];
								$whereFields = [];
								$whereVals = [];

								$sqlCompany = "";
								$sqlCompany = "select * from " . _TALENT_MASTER_TABLE_ . " WHERE talentProfilePhoto!='' and status=1 ORDER BY rand() LIMIT 0,3 ";
								$resCompany = getRecords(_TALENT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
								if ($resCompany) {
									?>
									<div class="trnding-bsns">
										<h1 class="finest-spkr">Find the finest speakers or entertainment artists, for
											your next event.</h1>
										<h2>Featured Talent Profiles <div class="bs-fot"><a
													href="<?php echo $fullurl; ?>more-talent-profiles.html">View all</a>
											</div>
										</h2>
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