<?php
include_once('inc.php');
$pageIndex = 8;
$p = 1;
?>

<?php

$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlCompany = "";
$sqlCompany = "select * from " . _COMPANY_MASTER_TABLE_ . " where id= " . decodeStr($_REQUEST['companyId']) . " and companyName!=''  ";
$resCompany = getRecords(_COMPANY_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);

while ($rowCompany = mysqli_fetch_array($resCompany)) {
	$companyPhoto = '';
	$industryTypeName = '';
	$createdby = $rowCompany["userId"];
	$empCompanyName = $rowCompany["companyName"];
	$empCompanyAddress = $rowCompany["companyAddress"];
	$empAboutCompany = $rowCompany["aboutCompany"];
	$establishedYear = $rowCompany["establishedYear"];
	$phoneNumber = trim($rowCompany['phoneNumber']);
	$emailAaddress = trim($rowCompany['emailAaddress']);
	$companyUrl = trim($rowCompany['companyUrl']);
	$tagId = $rowCompany["tagId"];
	$companyStatus = trim($rowCompany['status']);

	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);

	$insertFields[0] = "viewStatus";

	$insertVals[0] = $rowCompany['viewStatus'] + 1;

	$whereFields[0] = "id";

	$whereVals[0] = decodeStr($_REQUEST['companyId']);

	$resUpdate = updateDB(_COMPANY_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');


	if ($rowCompany["companyTypeId"] != 0 && $rowCompany["companyTypeId"] != '') {
		$a = "";
		$a = "SELECT * from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $rowCompany["companyTypeId"] . "";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$rowindustryTypeName = mysqli_fetch_array($b);
		$industryTypeName = $rowindustryTypeName["optionName"];

		$at = "";
		$at = "select count(*) as total from " . _USERS_MASTER_TABLE_ . " where companyName='" . $empCompanyName . "' ";
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

	$ata = "select firstName,lastName from " . _USERS_MASTER_TABLE_ . " where  userId= " . $createdby . " ";
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
$sqlFollowersMember = "";
$sqlFollowersMember = "select userId from " . _COMPANY_FOLLOWERS_TABLE_ . " WHERE companyId= " . decodeStr($_REQUEST['companyId']) . " and userId=" . $createdby . " order by id asc LIMIT 0,1 ";
$resFollowersMember = getRecords(_COMPANY_FOLLOWERS_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlFollowersMember);
$getFollowersTotalMember = mysqli_num_rows($resFollowersMember);
$totalEmployees = $totalEmployees + $getFollowersTotalMember;



?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo stripslashes($empCompanyName); ?> - Corporate - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

	<meta property="og:title" content="<?php echo stripslashes(strip_tags($empCompanyName)); ?>" />

	<?php
	$a = "";
	$a = "select imageName from " . _IMAGE_MASTER_TABLE_ . " where postId=" . decodeStr($_REQUEST['companyId']) . " and imageType=8";
	$b = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $a);
	if ($b) {
		while ($rowimg = mysqli_fetch_array($b)) {
			?>
			<meta property="og:image" content="<?php echo $fullurl; ?>uploads/<?php echo $rowimg['imageName']; ?>" />
			<?php
		}
	}
	?>
	<meta property="og:site_name" content="<?php echo $fullurl; ?>" />
	<meta property="og:description"
		content="<?php echo substr(stripslashes(strip_tags($empAboutCompany)), 0, 250); ?>" />
	<meta property="og:type" content="Company" />
	<meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />




	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<style>
		textarea#aboutCompany {
			width: 100%;
			padding: 10px;
			min-height: 140px;
			border-color: #e7e7e7;
		}
	</style>
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

						<div class="cntr_cntnt"
							style="width: 570px; border-right:1px solid #e7e7e7; padding-right:30px;">

							<div class="compny-profile">

								<?php //if($createdby==$_SESSION["sessUserId"]){ ?><!--<form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
<input type="hidden" id="companyId" name="companyId" value="<?php echo $_REQUEST['companyId']; ?>">
	<textarea rows="3" name="aboutCompany" id="aboutCompany" placeholder="About your company"><?php echo $empAboutCompany; ?></textarea>

	  <input type="hidden" id="action" name="action" value="cmpaboutcompany">
	  <div class="pst-evnt-btns">
 <button type="submit">Update</button>
</div>
	  
	  </form>-->
								<?php //}else{ ?>
								<div style="font-size:20px; margin-bottom:20px;">Tag ID: <span
										style="font-size:20px; color:#969393;">@<?php echo $tagId; ?></span></div>
								<?php if ($empAboutCompany != '') { ?>
									<p style="    line-height: 26px;"><?php echo $empAboutCompany; ?></p><?php }//} ?>

								<h2 style="margin-top:80px;">Other Companies On <?php echo $companNameTitle; ?> </h2>
								<ul class="employers-list recomend featured">
									<?php
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];
									$n = 0;
									$sqlRecomndCompany = "";
									$sqlRecomndCompany = "select * from " . _COMPANY_MASTER_TABLE_ . " where  companyName!='' and status=0 and id!='" . decodeStr($_REQUEST['companyId']) . "' order by id desc LIMIT 0,6 ";
									$resRecomndCompany = getRecords(_COMPANY_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlRecomndCompany);
									if ($resRecomndCompany) {
										while ($rowRecomndCompany = mysqli_fetch_array($resRecomndCompany)) {
											$RecomndCompanyPhoto = '';
											$RecomndindustryTypeName = '';
											if ($rowRecomndCompany["companyTypeId"] != 0 && $rowRecomndCompany["companyTypeId"] != '') {
												$a = "SELECT * from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $rowRecomndCompany["companyTypeId"] . "";
												$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
												$rowRecomndindustryTypeName = mysqli_fetch_array($b);
												$RecomndindustryTypeName = $rowRecomndindustryTypeName["optionName"];
											}

											if ($rowRecomndCompany['id'] != 0 && $rowRecomndCompany['id'] != '') {
												$ap = "select imageName from " . _IMAGE_MASTER_TABLE_ . " where  postId= " . $rowRecomndCompany['id'] . " and imageType=8 ";
												$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
												$rowLogoImg = mysqli_fetch_array($bp);

												if ($rowLogoImg["imageName"] != '') {
													$RecomndCompanyPhoto = $rowLogoImg["imageName"];
												} else {
													$RecomndCompanyPhoto = 'company.png';
												}

											}

											?>

											<li>
												<div class="employers secont-type" style="min-height:137px;">
													<div class="comp-logo">
														<a
															href="<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo encodeStr($rowRecomndCompany['id']); ?>"><img
																src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($RecomndCompanyPhoto)); ?>"
																title="<?php echo stripslashes($rowRecomndCompany["companyName"]); ?>"
																alt="<?php echo stripslashes(trim($rowRecomndCompany["companyName"])); ?>"></a>
													</div>
													<div class="comp-mddl">
														<a href="<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo encodeStr($rowRecomndCompany['id']); ?>"
															class="nm"><?php echo getStrLength(strip_tags(stripslashes($rowRecomndCompany["companyName"])), 100); ?></a>

														<span
															class="catgr"><?php echo stripslashes($RecomndindustryTypeName); ?></span>
													</div>
												</div>
											</li>
											<?php
											$n++;
										}
									}
									?>
								</ul>
								<?php if ($n == 0) { ?>
									<div style="padding:20px; text-align:center;">No any companies.</div>
								<?php } ?>
							</div>


						</div>
						<?php include('companyright.php'); ?>
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