<?php
include_once('inc.php');
include_once('config/session-check.inc.php');
include('mail.php');

$pageIndex = 12;

// Helper function to safely get POST data
function getPost($key, $default = '')
{
	return isset($_POST[$key]) ? $_POST[$key] : $default;
}

$action = trim(getPost('action'));
$id = clean(getPost('id'));

$companyBusinessName = clean(getPost('companyBusinessName'));
$completeAddress = addslashes(getPost('completeAddress'));
$shortDescription = addslashes(getPost('shortDescription'));
$longDescription = addslashes(getPost('longDescription'));
$companyTypeId = clean(getPost('companyTypeId'));
$subIndustryId = isset($_REQUEST['subIndustryId']) ? clean($_REQUEST['subIndustryId']) : '';
$empnoId = clean(getPost('empnoId'));
$establishedYear = trim(getPost('establishedYear'));
$countryId = clean(getPost('countryName'));
$stateId = trim(getPost('cityName'));
$cityName = isset($_REQUEST['locationName']) ? trim($_REQUEST['locationName']) : '';
$postalCode = clean(getPost('postalCode'));
$phoneNumber = clean(getPost('phoneNumber'));
$emailAaddress = clean(getPost('emailAaddress'));
$businessWebsiteUrl = addslashes(trim(getPost('businessWebsiteUrl')));
$status = normalclean(getPost('status'));
$enquiryStatus = trim(getPost('enquiryStatus'));
$contactPerson = normalclean(getPost('contactPerson'));



if ($companyBusinessName != '' && $companyTypeId != '' && $establishedYear != '' && $countryId != '' && $stateId != '' && $empnoId != '' && $status == 1 && $action == 'add') {


	$insertFields = [];
	$insertVals = [];
	$whereFields = [];
	$whereVals = [];


	$insertFields[0] = "companyBusinessName";
	$insertFields[1] = "companyTypeId";
	$insertFields[2] = "shortDescription";
	$insertFields[3] = "completeAddress";
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
	$insertFields[14] = "businessWebsiteUrl";
	$insertFields[15] = "longDescription";
	$insertFields[16] = "contactPerson";
	$insertFields[17] = "userId";
	$insertFields[18] = "enquiryStatus";

	$insertVals[0] = $companyBusinessName;
	$insertVals[1] = $companyTypeId;
	$insertVals[2] = $shortDescription;
	$insertVals[3] = $completeAddress;
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
	$insertVals[14] = $businessWebsiteUrl;
	$insertVals[15] = $longDescription;
	$insertVals[16] = $contactPerson;
	$insertVals[17] = $_SESSION["sessUserId"];
	$insertVals[18] = $enquiryStatus;


	$resUpdate = insertDB(_BUSINESS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$_SESSION["s"] = 1;
	$_SESSION["post"] = 1;
	$postId = $resUpdate;
	$pageulr = makeContentUrl($companyBusinessName);

	$mailBodyContent = '';
	$mailBodyContent = $myname . ' created a SMB page <strong>' . $companyBusinessName . '</strong> - ' . date("H:i:s - d/m/Y") . '';

	$subject = $myname . ' (' . $myemail . ') created a SMB page';

	adminnotification($subject, $mailBodyContent);

	header('Location:' . $fullurl . _SMBURL_TEXT_ . '/' . encodeStr($postId) . '/' . $pageulr . '.html');
	exit();

}

if ($companyBusinessName != '' && $companyTypeId != '' && $establishedYear != '' && $countryId != '' && $stateId != '' && $empnoId != '' && $action == 'edit') {


	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);


	$insertFields[0] = "companyBusinessName";
	$insertFields[1] = "companyTypeId";
	$insertFields[2] = "shortDescription";
	$insertFields[3] = "completeAddress";
	$insertFields[4] = "modifyDate";
	$insertFields[5] = "empnoId";
	$insertFields[6] = "subIndustryId";
	$insertFields[7] = "establishedYear";
	$insertFields[8] = "countryId";
	$insertFields[9] = "stateId";
	$insertFields[10] = "cityName";
	$insertFields[11] = "postalCode";
	$insertFields[12] = "phoneNumber";
	$insertFields[13] = "emailAaddress";
	$insertFields[14] = "businessWebsiteUrl";
	$insertFields[15] = "longDescription";
	$insertFields[16] = "contactPerson";
	$insertFields[17] = "enquiryStatus";

	$insertVals[0] = $companyBusinessName;
	$insertVals[1] = $companyTypeId;
	$insertVals[2] = $shortDescription;
	$insertVals[3] = $completeAddress;
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
	$insertVals[14] = $businessWebsiteUrl;
	$insertVals[15] = $longDescription;
	$insertVals[16] = $contactPerson;
	$insertVals[17] = $enquiryStatus;

	$whereFields[0] = "id";

	$whereVals[0] = $id;

	$resUpdate = updateDB(_BUSINESS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	$postId = $id;
	$_SESSION["s"] = 2;
	$_SESSION["post"] = 1;
	$pageulr = makeContentUrl($companyBusinessName);
	header('Location:' . $fullurl . _SMBURL_TEXT_ . '/' . encodeStr($postId) . '/' . $pageulr . '.html');
	exit();

}

$action = 'add';
$btnValue = 'Submit';
if (isset($_REQUEST['id']) && $_REQUEST['id'] != '') {
	$sqlCompany = "SELECT * from " . _BUSINESS_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['id']) . " ";
	$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
	$rowCompany = mysqli_fetch_array($resCompany);

	$createdby = $rowCompany["userId"];
	if ($createdby != $_SESSION["sessUserId"]) {
		header('Location:smb.html');
		exit();
	}

	if ($rowCompany['companyBusinessName'] == '') {
		header('Location:smb.html');
		exit();
	}

	$id = trim($rowCompany['id']);
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
	$enquiryStatus = trim($rowCompany['enquiryStatus']);
	$action = 'edit';
	$btnValue = 'Save';

}

?>
<!DOCTYPE html>
<html>

<head>
	<title>Business - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
					<div class="smb-cont">
						<div class="cbp-wrap">
							<h1>Create Business Page</h1>
							<form name="frmkonectt" id="frmkonectt" method="post" enctype="multipart/form-data">
								<!--<form enctype="multipart/form-data" name="creategroup" id="creategroup" method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php" onsubmit="formValidation('frmkonectt');return false">-->
								<div class="cbp-row">
									<label>Name of your Company/Business<span class="reqstar">*</span> </label>
									<input type="text" name="companyBusinessName" id="companyBusinessName"
										maxlength="150" class="validate" onKeyUp="hideerrordiv(this.id);"
										value="<?php echo $companyBusinessName; ?>">
								</div>
								<div class="cbp-row-half pd-right">
									<?php
									$companyTypeId = isset($companyTypeId) ? $companyTypeId : 0;
									$subIndustryId = isset($subIndustryId) ? $subIndustryId : 0;
									?>

									<label>Industry Category<span class="reqstar">*</span></label>
									<select name="companyTypeId" id="companyTypeId" class="validate"
										onChange="hideerrordiv(this.id); selectindustries(this.value);">

										<option value="0">Select</option>
										<?php
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$sqlOptions = "SELECT id, optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry' ORDER BY optionName";
										$resOptions = getRecords(_OPTION_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);

										if ($resOptions) {
											while ($rowOptions = mysqli_fetch_array($resOptions)) {
												$strSelected = ($companyTypeId == $rowOptions['id']) ? 'selected="selected"' : "";
												?>
												<option value="<?php echo intval($rowOptions['id']); ?>" <?php echo $strSelected; ?>>
													<?php echo htmlspecialchars(trim($rowOptions['optionName']), ENT_QUOTES); ?>
												</option>
												<?php
											}
										}
										?>
									</select>
								</div>

								<div class="cbp-row-half pd-left" id="showsubindustries" style="display:none;">
									<label>Sub Category</label>
									<select name="subIndustryId" id="subIndustryId"></select>
								</div>

								<div class="cbp-row-half pd-left" id="showsubindustries" style="display:none;">
									<label>Sub Category</label>
									<select name="subIndustryId" id="subIndustryId"></select>
								</div>
								<div class="cbp-row">
									<label>Short description about your business (maximum 100 words)<span
											class="reqstar">*</span></label>
									<input type="text" name="shortDescription" id="shortDescription" maxlength="100"
										class="validate" onKeyUp="hideerrordiv(this.id);"
										value="<?php echo $shortDescription; ?>"
										placeholder="Example &ldquo;We are the leading providers of spare parts to majority of automobile companies&rdquo;">
								</div>
								<div class="cbp-row">
									<label>Detailed Description (maximum 500 words)</label>
									<textarea name="longDescription" rows="3" id="longDescription" maxlength="500"
										onKeyUp="hideerrordiv(this.id);">
<?php echo $longDescription; ?></textarea>
								</div>
								<div class="cbp-row-half pd-right">
									<label>Number of Employees<span class="reqstar">*</span></label>
									<select name="empnoId" id="empnoId" class="validate"
										onChange="hideerrordiv(this.id);">
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
												<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>><?php echo trim($rowOptions1['numberOfEmployees']); ?>
												</option>
												<?php
											}
										}
										?>
									</select>
								</div>
								<div class="cbp-row-half pd-left">
									<label>Year your business was established<span class="reqstar">*</span></label>
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
								</div>
								<div class="cbp-row-half pd-right">
									<label>Country<span class="reqstar">*</span></label>
									<?php
									$mybstateName = isset($mybstateName) ? $mybstateName : '';

									?>
									<?php
									$mybstateName = isset($stateId) ? $stateId : '';
									?>


									<select name="countryName" id="countryName" class="validate"
										onChange="hideerrordiv(this.id); selectstate('0');">


										<option value="">Select</option>
										<?php
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$sqlOptions1 = "SELECT id, country_name FROM " . _COUNTRIES_TABLE_ . " ORDER BY country_name";
										$resOptions1 = getRecords(_COUNTRIES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);

										if ($resOptions1) {
											while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
												$strSelected = ($countryId == $rowOptions1['id']) ? 'selected="selected"' : '';
												?>
												<option value="<?php echo intval($rowOptions1['id']); ?>" <?php echo $strSelected; ?>>
													<?php echo htmlspecialchars(trim($rowOptions1['country_name']), ENT_QUOTES); ?>
												</option>
												<?php
											}
										}
										?>
									</select>
								</div>

								<div class="cbp-row-half pd-left">
									<label>State<span class="reqstar">*</span></label>
									<select name="cityName" id="cityName" class="validate"
										onChange="hideerrordiv(this.id);">
										<option value="">Select State</option>
									</select>
								</div>

								<?php
								// Ensure this is set before line 390
								$myblocationName = isset($_POST['locationName']) ? trim($_POST['locationName']) : '';
								?>

								<div class="cbp-row-half pd-right">
									<label>City</label>
									<input type="text" name="locationName" id="locationName"
										value="<?php echo $myblocationName; ?>" maxlength="100"
										onKeyUp="hideerrordiv(this.id);">
								</div>

								<div class="cbp-row-half pd-left">
									<label>Postal Code</label>
									<input type="text" name="postalCode" id="postalCode"
										value="<?php echo $postalCode; ?>" maxlength="6"
										onKeyUp="hideerrordiv(this.id);"
										onKeyPress="return blockNonNumbers(this, event, true, false);">
								</div>
								<div class="cbp-row">
									<label>Complete Address</label>
									<textarea name="completeAddress" rows="3" id="completeAddress" maxlength="250"
										onKeyUp="hideerrordiv(this.id);">
<?php echo $completeAddress; ?></textarea>
								</div>
								<div class="cbp-row-half pd-right">
									<label>Contact person's name</label>
									<input name="contactPerson" type="text" id="contactPerson"
										value="<?php echo $contactPerson; ?>" maxlength="60"
										onKeyUp="hideerrordiv(this.id);">
								</div>
								<div class="cbp-row-half pd-left">
									<label>Phone/Number</label>
									<input type="text" name="phoneNumber" id="phoneNumber"
										value="<?php echo $phoneNumber; ?>" maxlength="12"
										onKeyUp="hideerrordiv(this.id);">
								</div>
								<div class="cbp-row">
									<label>Email address</label>
									<input type="email" name="emailAaddress" id="emailAaddress"
										value="<?php echo $emailAaddress; ?>" maxlength="60"
										onKeyUp="hideerrordiv(this.id);">
								</div>
								<div class="cbp-row">
									<label>Website address of your Business</label>
									<input type="text" name="businessWebsiteUrl" id="businessWebsiteUrl" maxlength="250"
										value="<?php echo $businessWebsiteUrl; ?>" onKeyUp="hideerrordiv(this.id);">
								</div>

								<div class="trms">
									<label style="margin-top:0;margin-bottom: 0;">
										<input type="checkbox" name="enquiryStatus" id="enquiryStatus" class="validate"
											value="1" <?php if ($enquiryStatus == 1 || $enquiryStatus == '') {
												echo 'checked="checked"';
											} ?>>
										&nbsp;I agree to receive business enquiry from <?php echo $companNameTitle; ?>.
									</label>

									<?php if (isset($_REQUEST['id']) && $_REQUEST['id'] == '') { ?>
										<label style="margin-top:10px;">
											<input type="checkbox" name="status" id="status" class="validate" value="1"
												checked="checked" onClick="return false;">
											&nbsp;I confirm that I am authorized to create this business page and the
											information given is correct.
										</label>
									</div>
								<?php } ?>



								<input type="hidden" id="action" name="action" value="<?php echo $action; ?>">
								<input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
							</form>

							<div class="cbp-row">
								<?php if (isset($_REQUEST['id']) && $_REQUEST['id'] != '' && $createdby == $_SESSION["sessUserId"]) {
									?>
									<script>
										function reloadPage() {
											location.reload(true);
										}
									</script>
									<a onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo $_REQUEST['id']; ?>','delsmbp');"
										style="float: left;color: #ea4335; margin-top:8px;">Delete this page</a>&nbsp;
								<?php } ?>
								<button class="submit" type="button" onClick="formValidation('frmkonectt');"
									style="margin-top: 0;"><?php echo $btnValue; ?></button>
								<!--<button class="submit" type="submit"><?php echo $btnValue; ?></button>-->
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
	<script>
		var subIndustryURL = "<?php echo $fullurl; ?>action.php?action=subindustry";
	</script>

	<script>
		function selectstate(statename) {
			var countryId = $("#countryName").val();
			var statenameEncoded = encodeURIComponent(statename);

			if (countryId) {
				$("#cityName").load('<?php echo $fullurl; ?>loadstate.php?countryId=' + countryId + '&statename=' + statenameEncoded);
			} else {
				$("#cityName").html('<option value="">Select State</option>');
			}
		}

		// Initial load
		selectstate(<?php echo json_encode($stateId ?: '0'); ?>);

		function selectindustries(selectedSubIndustryId = 0) {
			var companyTypeId = $("#companyTypeId").val();

			if (companyTypeId && companyTypeId != "0") {
				$("#showsubindustries").show();
				$("#subIndustryId").load('<?php echo $fullurl; ?>action.php?action=subindustry&industryId=' + companyTypeId + '&selectedid=' + selectedSubIndustryId);
			} else {
				$("#showsubindustries").hide();
				$("#subIndustryId").html('<option value="">Select Sub Category</option>');
			}
		}
		$(document).ready(function () {
			<?php if (!empty($subIndustryId) && $subIndustryId != 0) { ?>
				selectindustries(<?php echo json_encode($subIndustryId); ?>);
			<?php } ?>
		});


		function blockNonNumbers(obj, e, allowDecimal, allowNegative) {
			var key;
			var isCtrl = false;
			var keychar;
			var reg;
			if (window.event) {
				key = e.keyCode;
				isCtrl = window.event.ctrlKey

			}

			else if (e.which) {
				key = e.which;
				isCtrl = e.ctrlKey;
			}

			if (isNaN(key)) return true;
			keychar = String.fromCharCode(key);
			// check for backspace or delete, or if Ctrl was pressed
			if (key == 8 || isCtrl) {
				return true;
			}
			reg = /\d/;

			var isFirstN = allowNegative ? keychar == '-' && obj.value.indexOf('-') == -1 : false;
			var isFirstD = allowDecimal ? keychar == '.' && obj.value.indexOf('.') == -1 : false;
			return isFirstN || isFirstD || reg.test(keychar);
		}
	</script>
	</div>

</body>

</html>