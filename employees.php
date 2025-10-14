<?php
include_once('inc.php');
$pageIndex = 8;
$p = 3;
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
$sqlFollowersMember = "";
$sqlFollowersMember = "select userId from " . _COMPANY_FOLLOWERS_TABLE_ . " WHERE companyId= " . decodeStr($_REQUEST['companyId']) . " and userId=" . $createdby . " order by id asc LIMIT 0,1 ";
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
						<div class="cntr_cntnt">

							<div class="compny-profile">


								<h2>The following employees are <?php echo $companNameTitle; ?> members</h2>
								<ul class="comp-mmbr-list" style="margin-top:0px;">
									<?php
									if ($totalEmployees > 0) {

										while ($rowEmployee = mysqli_fetch_array($resFollowersMember)) {

											$friendnameurl = '';
											$userphoto = '';
											$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowEmployee["userId"] . "";
											$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
											$userres2 = mysqli_fetch_array($b);

											$friendnameurl = $userres2['userurl'];

											if ($userres2["profilePhoto"] != '') {
												$userphoto = $userres2["profilePhoto"];
											} else {
												$userphoto = 'user-placeholder.jpg';
											}

											?>

											<!--  <li>
	<div class="comp-mmbr employee" style="cursor:pointer;"  onClick="javascript:location.href='<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2['userId']); ?>/<?php echo $friendnameurl; ?>.html'">
	  <span class="pic"><a  href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2['userId']); ?>/<?php echo $friendnameurl; ?>.html"> <img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"> </a></span>
	  <div class="mmbr-right">
	  <a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2['userId']); ?>/<?php echo $friendnameurl; ?>.html"  class="nm"><?php echo stripslashes(trim($userres2["firstName"])); ?> <?php echo stripslashes(trim($userres2["lastName"])); ?></a>
		
		<span class="prfl"><?php echo stripslashes(trim($userres2["jobTitle"])); ?> at <?php echo stripslashes(trim($userres2["companyName"])); ?></span>
	   
	   
	  </div>
	</div>
  </li>-->

											<?php
										}
									}
									if ($userres2['userId'] != '' && $userres2['userId'] != 0) {
										$n = 0;
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$sqlEmployee = "";
										$sqlEmployee = "select * from " . _USERS_MASTER_TABLE_ . "  where userId!=" . $userres2['userId'] . " and companyName='" . $empCompanyName . "'  ";
										$resEmployee = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlEmployee);
										if ($resEmployee) {
											?>
											<?php
											while ($rowEmployee = mysqli_fetch_array($resEmployee)) {

												$friendnameurl = $rowEmployee['userurl'];
												if ($rowEmployee["profilePhoto"] != '') {
													$userphoto = $rowEmployee["profilePhoto"];
												} else {
													$userphoto = 'user-placeholder.jpg';
												}

												if ($rowEmployee["industryId"] != 0 && $rowEmployee["industryId"] != '') {
													$a = "SELECT optionName from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $rowEmployee["industryId"] . "";
													$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
													$rowCompanyTypeName1 = mysqli_fetch_array($b);
													$empCompanyTypeName = $rowCompanyTypeName1["optionName"];
												}
												if ($_SESSION["sessUserId"] != '') {
													$c = "";
													$c = "SELECT id from " . _CONTACT_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " and contactId=" . $rowEmployee['userId'] . "";
													$d = mysqli_query($conn, $c) or die(mysqli_error($conn));
													$aabb = mysqli_fetch_array($d);

													$requestSent = "";
													$cc = "";
													$cc = "SELECT id from " . _CONTACT_MASTER_TABLE_ . " WHERE userId= " . $rowEmployee['userId'] . " and contactId=" . $_SESSION["sessUserId"] . " and status=0";
													$dd = mysqli_query($conn, $cc) or die(mysqli_error($conn));
													$requestSent = mysqli_num_rows($dd);
												}
												?>

												<li>
													<div class="comp-mmbr employee" style="cursor:pointer;"
														onClick="javascript:location.href='<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowEmployee['userId']); ?>/<?php echo $friendnameurl; ?>.html'">
														<span class="pic"><a
																href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowEmployee['userId']); ?>/<?php echo $friendnameurl; ?>.html">
																<img
																	src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>">
															</a></span>
														<div class="mmbr-right">
															<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowEmployee['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																class="nm"><?php echo stripslashes(trim($rowEmployee["firstName"])); ?>
																<?php echo stripslashes(trim($rowEmployee["lastName"])); ?></a>

															<a href="#" class="comp"
																style="margin-top:0px;"><?php echo stripslashes(trim($rowEmployee["jobTitle"])); ?>
																at
																<?php echo stripslashes(trim($rowEmployee["companyName"])); ?></a>


															<?php if (isset($aabb['id']) && $aabb['id'] == '') { ?>


																<?php if ($requestSent > 0) { ?>

																	<?php if ($rowEmployee['userId'] != $_SESSION["sessUserId"]) { ?>
																		<a class="add-btn"
																			style="cursor: default; background-color: #f1912f;color: #fff;">Pending</a>
																	<?php } else { ?>
																		<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowEmployee['userId']); ?>/<?php echo $friendnameurl; ?>.html"
																			class="add-btn">+Add</a>
																	<?php }
																}
															} ?>

														</div>
													</div>
												</li>
												<?php

												$n++;
											}
											?> 		<?php
										}
									}
									?>
								</ul>

								<?php if ($n == 0) {
								} ?>
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