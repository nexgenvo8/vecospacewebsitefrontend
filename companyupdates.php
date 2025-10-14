<?php
include_once('inc.php');
$pageIndex = 8;
$p = 2;
?>

<?php
if (isset($_REQUEST['status']) && isset($_REQUEST['companyId']) && $_REQUEST['companyId'] != '' && $_REQUEST['status'] != '') {
	$companyId = decodeStr($_REQUEST['companyId']);
	$status = trim($_REQUEST['status']);

	if ($status == 2) {
		$sql_ins = "DELETE FROM " . _COMPANY_FOLLOWERS_TABLE_ . " WHERE companyId= " . $companyId . "  and userId=" . $_SESSION["sessUserId"] . "  ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	} else {
		$a = "insert into " . _COMPANY_FOLLOWERS_TABLE_ . " set userId=" . $_SESSION["sessUserId"] . ",companyId=" . $companyId . ",dateAdded=" . time() . "";
		mysqli_query($conn, $a) or die(mysqli_error($conn));
	}

	header('Location:company-profile.html?companyId=' . $_REQUEST['companyId'] . '');
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

	if ($rowCompany['id'] == '') {
		header("Location: " . $fullurl . "404error.html");
		exit();
	}
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
		$at = "select count(*) as total from " . _USERS_MASTER_TABLE_ . " where companyName='" . $empCompanyName . "'  ";
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

						<div class="cntr_cntnt">

							<div class="compny-profile">



								<div class="updates-compny">
									<?php if ($createdby == $_SESSION["sessUserId"]) { ?>
										<div class="add_more"
											onClick="funcommonpopupwin('680px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo $_REQUEST['companyId']; ?>&type=addcmpupdates','Post a new update');">
											<h4>Post a new update</h4>
											<span>Here you can post updates about your Company.</span>
											<span class="addmore_icon"
												onClick="$('#editexploring').show();$('#defaultexploring').hide();addnewexplorings(1,3);$('#exploringcontentboxs').hide();">
												<i class="fa fa-plus-circle" aria-hidden="true"></i></span>
										</div>
										<?php
									}

									$selectFields = [];
									$whereFields = [];
									$whereVals = [];

									$sqlCompany1 = "";
									$sqlCompany1 = "select * from " . _SHAREANDUPDATES_TABLE_ . " where postType=16 and userId=" . decodeStr($_REQUEST['companyId']) . " order by id desc ";
									$resCompany1 = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany1);
									if ($resCompany1) {
										while ($rowCompany1 = mysqli_fetch_array($resCompany1)) {

											?>
											<div class="updt-compny">
												<?php if ($createdby == $_SESSION["sessUserId"]) { ?>
													<a class="deleteupdate"
														onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo encodeStr($rowCompany1['id']); ?>','delcmpupdate');"><i
															class="fa fa-times" aria-hidden="true"></i></a>
												<?php } ?>
												<div class="employers" style="position:relative;">

													<div class="comp-logo">
														<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>"
															title="<?php echo stripslashes($empCompanyName); ?>"
															alt="<?php echo stripslashes($empCompanyName); ?>">
													</div>
													<div class="comp-mddl">
														<a class="nm"
															style="cursor:default;"><?php echo stripslashes(trim($rowCompany1["postTitle"])); ?></a>

														<div class="catgr" id="desc<?php echo $rowCompany1['id']; ?>"
															style="margin-top:15px; overflow:hidden; height:93px;">
															<?php echo nl2br(stripslashes(trim($rowCompany1["postText"]))); ?>
														</div>
														<div class="dt" style="margin-top:20px;">
															<?php echo makedatetime($rowCompany1["dateAdded"]); ?>
														</div>
														<a style=" margin-top:10px; float:right; font-size:12px;"
															id="readtext<?php echo $rowCompany1['id']; ?>"
															onClick="showmoreless('<?php echo $rowCompany1['id']; ?>');">Read
															More</a>
													</div>
												</div>
											</div>

											<?php
										}
									} else {
										?>
										<div style="padding:20px; text-align:center;">There are no updates, currently.</div>
										<?php
									}
									?>
									<script>
										function showmoreless(id) {
											var text = $('#readtext' + id).text();
											if (text == 'Read More') {
												$('#desc' + id).css('height', 'auto');
												$('#readtext' + id).text('Less');
											}
											else {
												$('#desc' + id).css('height', '93px');
												$('#readtext' + id).text('Read More');
											}
										}
									</script>
								</div>




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