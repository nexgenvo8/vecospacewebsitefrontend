<?php
include_once('inc.php');
$pageIndex = 12;

$actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


$sqlCompany = "select * from " . _BUSINESS_MASTER_TABLE_ . " where id= " . decodeStr($_REQUEST['id']) . "";
$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
$rowCount = mysqli_num_rows($resCompany);

$rowCompany = mysqli_fetch_array($resCompany);


if ($rowCompany['companyBusinessName'] == '') {
	header('Location:' . $fullurl . 'smb.html');
	exit();
}
$companyPhoto = '';
$industryTypeName = '';
$createdby = $rowCompany["userId"];
$companyBusinessName = stripslashes($rowCompany['companyBusinessName']);
$companyTypeId = stripslashes($rowCompany['companyTypeId']);
$subIndustryId = stripslashes($rowCompany['subIndustryId']);
$completeAddress = trim($rowCompany['completeAddress']);
$shortDescription = trim($rowCompany['shortDescription']);
$empnoId = trim($rowCompany['empnoId']);
$establishedYear = trim($rowCompany['establishedYear']);
$countryId = trim($rowCompany['countryId']);
$stateId = trim($rowCompany['stateId']);
$myblocationName = trim($rowCompany['cityName']);
$postalCode = trim($rowCompany['postalCode']);
$phoneNumber = trim($rowCompany['phoneNumber']);
$emailAaddress = trim($rowCompany['emailAaddress']);
$businessWebsiteUrl = trim($rowCompany['businessWebsiteUrl']);

$longDescription = trim($rowCompany['longDescription']);
$contactPerson = trim($rowCompany['contactPerson']);
$viewStatus = trim($rowCompany['viewStatus']);
$enquiryStatus = trim($rowCompany['enquiryStatus']);
$postId = $rowCompany["id"];



$insertFields = [];
$insertVals = [];
$whereFields = [];
$whereVals = [];

$insertFields[0] = "viewStatus";

$insertVals[0] = $rowCompany['viewStatus'] + 1;

$whereFields[0] = "id";

$whereVals[0] = decodeStr($_REQUEST['id']);

$resUpdate = updateDB(_BUSINESS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');


if ($rowCompany["companyTypeId"] != 0 && $rowCompany["companyTypeId"] != '') {
	$a = "";
	$a = "SELECT * from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $rowCompany["companyTypeId"] . "";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$rowindustryTypeName = mysqli_fetch_array($b);
	$industryTypeId = $rowindustryTypeName["id"];
	$industryTypeName = $rowindustryTypeName["optionName"];


}
if ($rowCompany["subIndustryId"] != 0 && $rowCompany["subIndustryId"] != '') {
	$a = "";
	$a = "SELECT * from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $rowCompany["subIndustryId"] . "";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$rowindustryTypeName = mysqli_fetch_array($b);
	$industrySubTypeName = $rowindustryTypeName["optionName"];
}

$ata = "select firstName,lastName,userurl,userId,jobTitle,companyName,profilePhoto from " . _USERS_MASTER_TABLE_ . " where  userId= " . $createdby . " ";
$pta = mysqli_query($conn, $ata) or die(mysqli_error($conn));
$rowuserdetails = mysqli_fetch_array($pta);
if ($rowuserdetails["profilePhoto"] != '') {
	$viewuserphoto = $rowuserdetails["profilePhoto"];
} else {
	$viewuserphoto = 'user-placeholder.jpg';
}

if ($rowCompany["fileUploaded"] != '') {
	$companyPhoto = $rowCompany["fileUploaded"];
} else {
	$companyPhoto = 'businessimg.png';
}
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo stripslashes($companyBusinessName); ?> - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">


	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">



	<meta property="og:title" content="<?php echo stripslashes(strip_tags($companyBusinessName)); ?>" />

	<meta property="og:image" content="<?php echo $fullurl; ?>uploads/<?php echo $companyPhoto; ?>" />
	<meta property="og:site_name" content="<?php echo $fullurl; ?>" />
	<meta property="og:description"
		content="<?php echo substr(stripslashes(strip_tags($longDescription)), 0, 250); ?>" />
	<meta property="og:type" content="SMB Connect" />
	<meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />




	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min-imgslider.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/TechcareGallery.css">
	<script src="<?php echo $fullurl; ?>js/TechcareGallery.js"></script>

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
					<div class="bsdtail-cont">
						<?php include('businesstopinc.php'); ?>
						<?php if (isset($_POST['post']) && $_SESSION["post"] == 1) { ?>
							<div class="aplied" style="background-color: rgb(255, 101, 80);
	margin-bottom: 20px;
	border: 0;
	border-radius: 2px;
	color: #fff;
	border-radius: 2px;
	color: #fff;
	float: left;
	width: 100%;
	text-align: center;
	padding: 10px;">This page is under reviewing...</div><?php $_SESSION["post"] = '';
						} ?>
						<div class="bsdtail-wrapper">
							<div class="b-logo">
								<?php if ($createdby == $_SESSION["sessUserId"]) { ?><span class="edit"><i
											class="fa fa-pencil" aria-hidden="true"></i>
										<form class="edit-layer" enctype="multipart/form-data" name="frmposthome"
											id="frmposthome" method="post" target="actionfrm"
											action="<?php echo $fullurl; ?>common_action.php">
											<input name="businesspphoto" id="businesspphoto" type="file"
												onChange="$('#frmposthome').submit();$('#commonloader').show();"
												style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); padding-right:0px !important; "
												accept="image/x-png,image/gif,image/jpeg">
											<input type="hidden" id="smbId" name="smbId"
												value="<?php echo $_REQUEST["id"]; ?>">
											<input type="hidden" id="action" name="action" value="uploadbpphoto">
											<input type="hidden" id="businesspOld" name="businesspOld"
												value="<?php echo $companyPhoto; ?>">
										</form>
									</span>


								<?php } ?>
								<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>"
									title="<?php echo stripslashes($companyBusinessName); ?>"
									alt="<?php echo stripslashes($companyBusinessName); ?>">
							</div>
							<div
								style="margin-bottom:10px; font-size:14px; color:#999999;margin-left: 16px; float:right;">
								<span class="vw"> (Views) : <?php echo stripslashes($viewStatus); ?> </span>
								<?php if ($createdby == $_SESSION['sessUserId']) { ?> <a
										href="<?php echo $fullurl; ?>cbp.html?id=<?php echo $_REQUEST['id']; ?>">
										<button class="cmmnt-btn" type="submit" style="position: relative;
	border-radius: 4px;
	margin-top: 15px;
	margin-left: 10px;margin-right: 10px;
	padding: 5px 15px;">Edit</button></a> <?php } ?>
							</div>
							<h2><?php echo stripslashes($companyBusinessName); ?></h2>


							<span class="ftrd"><a
									href="<?php echo $fullurl; ?>smb-categories.html?_c=<?php echo encodeStr($industryTypeId); ?>"><?php echo stripslashes($industryTypeName); ?>
								</a><!-- / <a href="">Programming & Tech </a>-->
							</span>
							<ul class="bsdtail-info-list">
								<?php if ($contactPerson != '') { ?>
									<li>
										<label>Contact Person: </label>
										<span><?php echo $contactPerson; ?></span>
									</li>
								<?php } ?>
								<li>
									<label>Number of Employees: </label>
									<span> <?php
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];

									$sqlOptions1 = "";
									$sqlOptions1 = "SELECT id,numberOfEmployees FROM " . _EMPLOYERS_NUMBERS_TABLE_ . " WHERE id=" . $empnoId . " ORDER BY id  ";
									$resOptions1 = getRecords(_EMPLOYERS_NUMBERS_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
									if ($resOptions1) {
										while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {

											echo trim($rowOptions1['numberOfEmployees']);
										}
									}
									?></span>
								</li>
								<li>
									<label>Year of Establishment: </label>
									<span><?php echo $establishedYear; ?></span>
								</li>
								<li>
									<label>Location: </label>
									<span> <?php if ($myblocationName != '') {
										echo $myblocationName; ?> ,
										<?php }
									echo $stateId; ?>, <?php echo $countryId;
									  if ($postalCode != '') { ?> -
											<?php echo $postalCode;
									  } ?></span>
								</li>
								<?php if ($completeAddress != '') { ?>
									<li>
										<label>Address: </label>
										<span> <?php echo $completeAddress; ?> <a
												href="https://www.google.co.in/maps/place/<?php echo $completeAddress; ?>"
												target="_blank" class="openingooglemap"> <i class="fa fa-map-marker"
													aria-hidden="true"></i> Open in Google Maps</a></span>
									</li>
								<?php } ?>

								<?php if ($businessWebsiteUrl != '') { ?>
									<li>
										<label>Website: </label>
										<span><a href="http://<?php echo str_replace("http://", "", str_replace("https://", "", str_replace("www.", "", $businessWebsiteUrl))); ?>"
												target="_blank">http://www.<?php echo str_replace("http://", "", str_replace("https://", "", str_replace("www.", "", $businessWebsiteUrl))); ?></a></span>
									</li>
								<?php } ?>
								<li class="description">
									<label>Description: </label>
									<p><?php echo stripslashes(nl2br($longDescription)); ?></p>
								</li>

								<li class="photogrps" id="photogrps">
									<label>Photo Gallery: </label> <br>

									<div class="uploadimg" id="imagebx" style="width:100%;"></div>
									<script>
										$("#imagebx").load('<?php echo $fullurl; ?>upload_businesspage_logo.php?bpId=<?php echo $postId; ?>&uid=<?php echo $createdby; ?>');
									</script>
								</li>

							</ul>
							<!-- 	<div class="bsdtail-bnr-img">
		<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>">
	</div> -->
							<div class="bsdtail-about">
								<div class="about-head">About</div>
								<p><?php echo stripslashes($shortDescription); ?></p>
							</div>
							<div class="bsdtail-about">
								<div class="about-head">Description</div>
								<p><?php echo nl2br(stripslashes($longDescription)); ?></p>
							</div>

						</div>
						<div class="bsdtail-right">
							<ul class="ftrd-list">
								<li class="taglinesmb"><?php echo stripslashes($shortDescription); ?></li>
							</ul>
							<ul class="bsdtail-author-info">
								<!--<?php if ($phoneNumber != '') { ?><li><label>Mobile: </label> <span><?php echo stripslashes($phoneNumber); ?></span></li><?php } ?>
			<?php if ($emailAaddress != '') { ?><li><label>Email: </label><span><?php echo stripslashes($emailAaddress); ?></span></li><?php } ?>-->
							</ul>


							<?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
								if ($createdby != $_SESSION["sessUserId"] && $emailAaddress != '') {
									if ($enquiryStatus == 1) { ?>
										<a onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=sendenquiry&receiverEmail=<?php echo $emailAaddress; ?>&purl=<?php echo $actual_link; ?>&ni=1','Send Enquiry');"
											class="ordr-btn"><i class="fa fa-envelope-o" aria-hidden="true"></i> Send Enquiry</a>
									<?php }
								}
							} ?>
							<div class="bsdtail-author">
								<div class="postedby">Posted by</div>
								<div class="grup-admn"> <a
										href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowuserdetails['userId']); ?>/<?php echo $rowuserdetails['userurl']; ?>.html"><img
											src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($viewuserphoto)); ?>"></a>
									<div class="admn-nm">
										<a
											href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowuserdetails['userId']); ?>/<?php echo $rowuserdetails['userurl']; ?>.html"><?php echo $rowuserdetails['firstName']; ?>
											<?php echo $rowuserdetails['lastName']; ?></a>
										<span class="comp"><?php echo $rowuserdetails['jobTitle']; ?> at
											<?php echo $rowuserdetails['companyName']; ?></span>
									</div>
								</div>
								<?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
									if ($createdby != $_SESSION["sessUserId"]) { ?>
										<!--<div class="center-btn">
	   <a href="#" onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=sendmsgtocontact&id=<?php echo encodeStr($rowuserdetails['userId']); ?>','Send a Message');">Send Message</a>
   </div>-->
									<?php }
								} ?>
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
		function reloadPage() {
			location.reload(true);
		}

		function imagepopupmain(id) {
			$('#eventimagepopup').html('<div class="postimageloading">Loading</div>');
			$('#eventimagepopup').show();
			$('#eventimagepopup').load(fullurl + 'smbimagepopup.php?imgId=' + id);
		}
	</script>
	<div class="img-popup" id="eventimagepopup" style="display:none;"></div>
	<script>
		<?php
		if ($_SESSION["s"] == 1) {
			?>
			showsusmsg('SUCCESS', 'Thank you for creating your Business Page on <?php echo $companNameTitle; ?>. We are reviewing the same and will come back to you shortly.', '');
			<?php
			$_SESSION["s"] = '';
		}

		if ($_SESSION["s"] == 2) {
			?>
			showsusmsg('SUCCESS', 'SMB page updated successfully', '');
			<?php
			$_SESSION["s"] = '';
		}

		?>
	</script>
</body>

</html>