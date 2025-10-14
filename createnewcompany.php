<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
include('mail.php');
$pageIndex = 8;
//print_r($_POST);

if (
	trim($_POST['companyProfileName'] ?? '') != '' &&
	trim($_POST['tagId'] ?? '') != '' &&
	trim($_POST['tagIdtrue'] ?? '') == 1 &&
	trim($_POST['companyTypeId'] ?? '') != '' &&
	trim($_POST['establishedYear'] ?? '') != '' &&
	trim($_POST['countryName'] ?? '') != '' &&
	trim($_POST['cityName'] ?? '') != '' &&
	trim($_POST['locationName'] ?? '') != '' &&
	trim($_POST['postalCode'] ?? '') != '' &&
	trim($_POST['empnoId'] ?? '') != '' &&
	trim($_POST['postId'] ?? '') != '' &&
	trim($_POST['action'] ?? '') == 'addcompany'
) {
	//print_r($_POST);

	$companyId = clean($_POST['postId']);
	$companyProfileName = clean($_POST['companyProfileName']);
	$companyAddress = addslashes($_POST['companyAddress']);
	$aboutCompany = clean($_POST['aboutCompany']);
	$companyTypeId = clean($_POST['companyTypeId']);
	$subIndustryId = clean($_POST['subIndustryId']);
	$empnoId = clean($_POST['empnoId']);
	$establishedYear = trim($_POST['establishedYear']);
	$countryId = clean($_POST['countryName']);
	$stateId = trim($_POST['cityName']);
	$cityName = trim($_POST['locationName']);
	$postalCode = clean($_POST['postalCode']);
	$phoneNumber = clean($_POST['phoneNumber']);
	$emailAaddress = clean($_POST['emailAaddress']);
	$companyUrl = addslashes(trim($_POST['companyUrl']));
	$tagId = trim($_POST['tagId']);
	$status = normalclean($_POST['status']);

	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);


	$insertFields[0] = "companyName";
	$insertFields[1] = "companyTypeId";
	$insertFields[2] = "aboutCompany";
	$insertFields[3] = "companyAddress";
	$insertFields[4] = "dateAdded";
	$insertFields[5] = "empnoId";
	$insertFields[6] = "subIndustryId";
	$insertFields[7] = "establishedYear";
	$insertFields[8] = "countryId";
	$insertFields[9] = "stateId";
	$insertFields[10] = "cityName";
	$insertFields[11] = "postalCode";
	$insertFields[12] = "phoneNumber";
	$insertFields[13] = "emailAaddress";
	$insertFields[14] = "companyUrl";
	$insertFields[15] = "tagId";
	$insertFields[16] = "status";

	$insertVals[0] = $companyProfileName;
	$insertVals[1] = $companyTypeId;
	$insertVals[2] = $aboutCompany;
	$insertVals[3] = $companyAddress;
	$insertVals[4] = date("Y-m-d H:i:s");
	$insertVals[5] = $empnoId;
	$insertVals[6] = $subIndustryId;
	$insertVals[7] = $establishedYear;
	$insertVals[8] = $countryId;
	$insertVals[9] = $stateId;
	$insertVals[10] = $cityName;
	$insertVals[11] = $postalCode;
	$insertVals[12] = $phoneNumber;
	$insertVals[13] = $emailAaddress;
	$insertVals[14] = $companyUrl;
	$insertVals[15] = $tagId;
	$insertVals[16] = $status;

	$whereFields[0] = "id";
	$whereFields[1] = "userId";

	$whereVals[0] = $companyId;
	$whereVals[1] = $_SESSION['sessUserId'];

	$resUpdate = updateDB(_COMPANY_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$aa = "SELECT id from " . _COMPANY_FOLLOWERS_TABLE_ . " WHERE companyId= " . $companyId . "  and userId=" . $_SESSION["sessUserId"] . "  ";
	$res5 = mysqli_query($conn, $aa);
	$getTotal = mysqli_num_rows($res5);
	if ($getTotal > 0) {
	} else {

		$a = "insert into " . _COMPANY_FOLLOWERS_TABLE_ . " set userId=" . $_SESSION["sessUserId"] . ",companyId=" . $companyId . ",dateAdded=" . time() . "";
		mysqli_query($conn, $a) or die(mysqli_error($conn));

		$mailBodyContent = '';
		$mailBodyContent = $myname . ' created a Company <strong>' . $companyProfileName . '</strong> - ' . date("H:i:s - d/m/Y") . '';

		$subject = $myname . ' (' . $myemail . ') created a Company';

		adminnotification($subject, $mailBodyContent);

	}

	$_SESSION["s"] = 1;

	header('Location:companies.html');
	exit();

}

if (isset($_REQUEST['companyId']) && $_REQUEST['companyId'] != '') {
	$sqlCompany = "SELECT * from " . _COMPANY_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['companyId']) . " ";
	$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
	$rowCompany = mysqli_fetch_array($resCompany);


	$cmpOwnerId = trim($rowCompany['userId']);
	if ($cmpOwnerId != $_SESSION["sessUserId"]) {
		header('Location:companies.html');
		exit();
	}
	if ($rowCompany['companyName'] == '') {
		header('Location:companies.html');
		exit();
	}

	$postId = trim($rowCompany['id']);
	$companyProfileName = stripslashes($rowCompany['companyName']);
	$companyTypeId = stripslashes($rowCompany['companyTypeId']);
	$subIndustryId = stripslashes($rowCompany['subIndustryId']);
	$companyAddress = trim($rowCompany['companyAddress']);
	$aboutCompany = trim($rowCompany['aboutCompany']);
	$empnoId = trim($rowCompany['empnoId']);
	$establishedYear = trim($rowCompany['establishedYear']);
	$countryId = trim($rowCompany['countryId']);
	$stateId = trim($rowCompany['stateId']);
	$cityName = trim($rowCompany['cityName']);
	$postalCode = trim($rowCompany['postalCode']);
	$phoneNumber = trim($rowCompany['phoneNumber']);
	$emailAaddress = trim($rowCompany['emailAaddress']);
	$companyUrl = trim($rowCompany['companyUrl']);
	$empnoId = trim($rowCompany['empnoId']);
	;
	$tagId = trim($rowCompany['tagId']);

} else {
	$sql_ins = "DELETE FROM " . _COMPANY_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND companyName='' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	$sql_ins = "INSERT INTO " . _COMPANY_MASTER_TABLE_ . " SET userId= " . $_SESSION["sessUserId"] . "";
	$resresult2 = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	$sql_inss = "SELECT id from " . _COMPANY_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . "  AND companyName=''";
	$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
	$rowResults = mysqli_fetch_array($resresults);
	$postId = $rowResults["id"];

}
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php if ($_REQUEST['companyId'] != '') { ?> Edit <?php } else { ?>Create <?php } ?> Company Profile -
		<?php echo $companNameTitle; ?>
	</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/default.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/zebra_datepicker.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<script>
		$(document).ready(function () {

			$('#eventDate').Zebra_DatePicker({

				format: 'Y-m-d',

				// direction: [1, 400]

			});



			$('#eventTillDate').Zebra_DatePicker({

				format: 'Y-m-d',

				// direction: [1, 400]

			});
		});

	</script>
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
				<div class="center_content">
					<div class="evnts post">
						<div class="post-evnt company-edt">
							<h2><?php if (isset($_REQUEST['companyId']) && $_REQUEST['companyId'] != '') { ?> Edit
								<?php } else { ?>Create
								<?php } ?>Company
								Profile
							</h2>
							<form name="frmcreatecompany" id="frmcreatecompany" method="post"
								enctype="multipart/form-data">
								<label>Company Name<span class="reqstar">*</span></label>
								<?php
								if (!isset($companyProfileName)) {
									$companyProfileName = ''; // default empty value
								}
								?>
								<input type="text" name="companyProfileName" id="companyProfileName"
									value="<?php echo $companyProfileName; ?>" maxlength="150" class="validate">


								<label>Tag ID<span class="reqstar">*</span></label>
								<div style="position:relative;">
									<img src="images/true.png"
										style="position:absolute; right:5px; top:43px; display:none;" id="truevalue">
									<img src="images/false.png"
										style="position:absolute; right:5px; top:43px; display:none;" id="falsevalue">
									<div style="position:absolute; top:46px; left:8px; font-size:17px; color:#a7a7a7;">@
									</div>

									<input type="text" name="tagId" id="tagId"
										value="<?php echo isset($tagId) ? $tagId : ''; ?>" maxlength="100"
										style="padding-left:30px;" onKeyUp="checktagid();" autocomplete="off"
										class="validate">

									<input type="hidden" name="tagIdtrue" id="tagIdtrue"
										value="<?php echo (isset($tagId) && $tagId != '') ? '1' : '0'; ?>">
								</div>

								<script>
									function checktagid() {
										var tagId = $("#tagId").val();
										tagId = tagId.replace(/[^a-z0-9\s]/gi, '').replace(/[_\s]/g, '');
										if (tagId == '') {
											$('#truevalue').hide();
											$('#falsevalue').hide();
										}

										$("#tagId").val(tagId);
										$("#checktagiddiv").load('common_action.php?action=checktagid&tagid=' + tagId);

									}
								</script>
								<div id="checktagiddiv" style="display:none;"></div>
								<label>Industry<span class="reqstar">*</span></label>
								<select name="companyTypeId" id="companyTypeId"
									onChange="selectsubindustry('0');hideerrordiv(this.id);" class="validate">
									<option value="">Select</option>
									<?php
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];

									$sqlOptions1 = "";
									$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry' ";
									$resOptions1 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
									if ($resOptions1) {
										while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
											if ($companyTypeId == $rowOptions1['id']) {
												$strSelected = 'selected="selected"';
											} else {
												$strSelected = "";
											}
											?>
											<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>>
												<?php echo trim($rowOptions1['optionName']); ?>
											</option>
											<?php
										}
									}
									?>
								</select>

								<!--<label>Sub Industry<span class="reqstar">*</span></label>
		<select name="subIndustryId" id="subIndustryId" class="validate">
			</select>-->
								<label>Established in the year<span class="reqstar">*</span></label>
								<select name="establishedYear" id="establishedYear" class="validate"
									onChange="hideerrordiv(this.id);">
									<option value="">Select</option>
									<?php
									for ($e = date('Y'); $e >= 1600; $e--) {
										if ($establishedYear == $e) {
											$strSelected = 'selected="selected"';
										} else {
											$strSelected = "";
										}
										?>
										<option value="<?php echo trim($e); ?>" <?php echo $strSelected; ?>>
											<?php echo trim($e); ?>
										</option>
										<?php
									}
									?>
								</select>
								<label>Employee Strength<span class="reqstar">*</span></label>
								<select name="empnoId" id="empnoId" class="validate" onChange="hideerrordiv(this.id);">
									<option value="">Select</option>
									<?php
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];

									$sqlOptions1 = "";
									$sqlOptions1 = "SELECT id,numberOfEmployees FROM " . _EMPLOYERS_NUMBERS_TABLE_ . " ORDER BY id  ";
									$resOptions1 = getRecords(_EMPLOYERS_NUMBERS_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
									if ($resOptions1) {
										while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
											if ($empnoId == $rowOptions1['id']) {
												$strSelected = 'selected="selected"';
											} else {
												$strSelected = "";
											}
											?>
											<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>>
												<?php echo trim($rowOptions1['numberOfEmployees']); ?>
											</option>
											<?php
										}
									}
									?>
								</select>

								<label>Company address</label>
								<textarea rows="3" name="companyAddress" id="companyAddress" maxlength="200">
									<?php echo isset($companyAddress) ? $companyAddress : ''; ?>
									</textarea>


								<label>Country<span class="reqstar">*</span></label>
								<select name="countryName" id="countryName" class="validate"
									onChange="selectstate(this.value); hideerrordiv(this.id);">
									<option value="">Select</option>
									<?php
									$selectFields = [];
									$whereFields = [];
									$whereVals = [];
									$sqlOptions1 = "SELECT id, country_name FROM " . _COUNTRIES_TABLE_ . " ORDER BY country_name";
									$resOptions1 = getRecords(_COUNTRIES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);

									if ($resOptions1) {
										while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
											$strSelected = (isset($countryId) && $countryId == $rowOptions1['id']) ? 'selected="selected"' : "";
											echo '<option value="' . trim($rowOptions1['id']) . '" ' . $strSelected . '>' . trim($rowOptions1['country_name']) . '</option>';
										}
									}
									?>
								</select>

								<label>State<span class="reqstar">*</span></label>
								<select name="cityName" id="cityName" class="validate">
									<option value="">Select</option>
								</select>



								<?php
								// Define all variables to prevent "undefined variable" warnings
								$cityName = isset($cityName) ? $cityName : '';
								$postalCode = isset($postalCode) ? $postalCode : '';
								$phoneNumber = isset($phoneNumber) ? $phoneNumber : '';
								$emailAaddress = isset($emailAaddress) ? $emailAaddress : '';
								$companyUrl = isset($companyUrl) ? $companyUrl : '';
								$aboutCompany = isset($aboutCompany) ? $aboutCompany : '';
								$postId = isset($postId) ? $postId : '0';
								?>

								<label>City<span class="reqstar">*</span></label>
								<input type="text" name="locationName" id="locationName"
									value="<?php echo htmlspecialchars($cityName); ?>" class="validate" maxlength="100">

								<label>Postal code<span class="reqstar">*</span></label>
								<input type="text" name="postalCode" id="postalCode"
									value="<?php echo htmlspecialchars($postalCode); ?>" maxlength="6" class="validate"
									onkeypress="return blockNonNumbers(this, event, true, false);">

								<label>Phone number</label>
								<input type="text" name="phoneNumber" id="phoneNumber"
									value="<?php echo htmlspecialchars($phoneNumber); ?>" maxlength="60">

								<label>Email address<span class="reqstar">*</span></label>
								<input type="email" name="emailAaddress" id="emailAaddress"
									value="<?php echo htmlspecialchars($emailAaddress); ?>" maxlength="60"
									class="validate">

								<label>Company website</label>
								<input type="text" name="companyUrl" id="companyUrl"
									value="<?php echo htmlspecialchars($companyUrl); ?>" maxlength="250">

								<label>About your company</label>
								<textarea rows="3" name="aboutCompany" id="aboutCompany" maxlength="500"
									placeholder="Max 500 Characters"><?php echo htmlspecialchars($aboutCompany); ?></textarea>

								<label>Company logo</label>

								<input type="hidden" id="action" name="action" value="addcompany">
								<input type="hidden" id="postId" name="postId"
									value="<?php echo htmlspecialchars($postId); ?>">

								<div class="uploadimg" id="imagebx" style="width:100%;"></div>

								<script>
									$("#imagebx").load('upload_company_logo.php?postId=<?php echo urlencode($postId); ?>');
								</script>


								<label class="trms">
									<input type="checkbox" name="status" id="status" class="validate" value="1"
										checked="checked" onClick="return false;" style="width: 20px !important;
	float: left;">
									I confirm that I am authorized to create this Company profile and the information
									given is correct.
								</label>
							</form>
							<div class="pst-evnt-btns comp">
								<?php if (isset($_REQUEST['companyId']) && $_REQUEST['companyId'] != '' && $cmpOwnerId == $_SESSION["sessUserId"]) {
									?>
									<script>
										function reloadPage() {
											location.reload(true);
										}
									</script>
									<a onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo $_REQUEST["companyId"]; ?>','delcmp');"
										style="float: left;color: #ea4335;">Delete this Company profile</a>
								<?php } ?>&nbsp;
								<button type="button" onClick="formValidation('frmcreatecompany');">Save</button>
							</div>

						</div>
					</div>
				</div>
			</div>
			<?php include('footer.php'); ?>
		</div>
		<script>
			function selectstate(countryId) {
				if (countryId == '' || countryId == '0') {
					$('#cityName').html('<option value="">Select</option>');
					return;
				}

				// PHP variable check to prevent undefined warnings
				var stateId = '<?php echo isset($stateId) ? sanitizedboutput($stateId) : '0'; ?>';

				$("#cityName").load('getstates.php?countryId=' + encodeURIComponent(countryId) + '&statename=' + encodeURIComponent(stateId));
			}

			// Auto-load state list when editing an existing record
			$(document).ready(function () {
				var countryId = '<?php echo isset($countryId) ? sanitizedboutput($countryId) : '0'; ?>';
				selectstate(countryId);
			});

			function selectsubindustry(id) {
				var industryId = encodeURIComponent($("#companyTypeId").val());
				var selectedid = encodeURIComponent(id);

				$("#subIndustryId").load('action.php?action=subindustry&industryId=' + industryId + '&selectedid=' + selectedid);
			}

			// Auto-load subindustry list when editing
			$(document).ready(function () {
				selectsubindustry('<?php echo isset($subIndustryId) ? sanitizedboutput($subIndustryId) : '0'; ?>');
			});

			function blockNonNumbers(obj, e, allowDecimal, allowNegative) {
				var key;
				var isCtrl = false;
				var keychar;
				var reg;

				if (window.event) {
					key = e.keyCode;
					isCtrl = window.event.ctrlKey;
				} else if (e.which) {
					key = e.which;
					isCtrl = e.ctrlKey;
				}

				if (isNaN(key)) return true;

				keychar = String.fromCharCode(key);

				// Allow backspace, delete, or Ctrl key combinations
				if (key == 8 || isCtrl) {
					return true;
				}

				reg = /\d/;

				var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;
				var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;

				return isFirstN || isFirstD || reg.test(keychar);
			}
		</script>

		<script>
			function selectstate(countryId) {
				if (countryId == '' || countryId == '0') {
					$('#cityName').html('<option value="">Select</option>');
					return;
				}

				var stateId = '<?php echo isset($stateId) ? sanitizedboutput($stateId) : '0'; ?>';

				$("#cityName").load('getstates.php?countryId=' + encodeURIComponent(countryId) + '&statename=' + encodeURIComponent(stateId), function (response, status, xhr) {
					if (status == "error") {
						console.log("Error loading states: " + xhr.status + " " + xhr.statusText);
					}
				});
			}

			// Auto-load states on page load if editing
			$(document).ready(function () {
				var countryId = '<?php echo isset($countryId) ? sanitizedboutput($countryId) : '0'; ?>';
				if (countryId != '0') {
					selectstate(countryId);
				}
			});
		</script>


</body>

</html>