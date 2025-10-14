<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$keyword = clean($_REQUEST['keyword']);
$tageduserid = trim($_REQUEST['tageduserid']);


$tageduserid = rtrim($tageduserid, ',');
if ($keyword != '' && $keyword != 'undefined') {
	if ($tageduserid != '') {
		$where = "userId NOT IN(" . $tageduserid . ") and";
	} else {
		$where = "";
	}

	?>
	<ul class="requst-list" id="notice-list" style="display: block;">

		<?php
		$n = 0;
		$selectFields =[];
		$whereFields =[];
		$whereVals =[];
		$sqlSearch = "";

		$sqlSearch = "select * from " . _USERS_MASTER_TABLE_ . " where " . $where . " (firstName like '%" . $keyword . "%' OR lastName like '%" . $keyword . "%') and userId!=" . $_SESSION['sessUserId'] . " and activeYN='Y' ";
		$resSearch = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlSearch);
		if ($resSearch) {
			while ($rowSearch = mysqli_fetch_array($resSearch)) {

				$friendnameurl = $rowSearch['userurl'];
				if ($rowSearch["profilePhoto"] != '') {
					$userphoto = $rowSearch["profilePhoto"];
				} else {
					$userphoto = 'user-placeholder.jpg';
				}

				?>

				<li style="cursor:pointer;"
					onClick="tagthisuser('<?php echo $rowSearch['firstName']; ?> <?php echo $rowSearch['lastName']; ?>','<?php echo $rowSearch['userId']; ?>','<?php echo $keyword; ?>');">
					<div class="rquest-box">
						<a class="rqst-img"><img
								src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
						<div class="rqst-right">
							<div class="rquest-middle">
								<a><?php echo $rowSearch['firstName']; ?> 			<?php echo $rowSearch['lastName']; ?></a>

								<label><?php echo $rowSearch["jobTitle"]; ?> 			<?php echo $rowSearch["companyName"]; ?></label>
							</div>
						</div>
					</div>
				</li>
				<?php
				$n++;
			}
		}
		?>
		<script>
			$("#searchtagcontact").show();
		</script>

		<?php if ($n == 0) { ?>
			<script>
				$("#searchtagcontact").hide();
			</script>
		<?php } ?>

	<?php } else { ?>
		<script>
			$("#searchtagcontact").hide();
		</script>
	<?php } ?>
	<?php
	/*Search companies*/
	$tagedcompanyid = trim($_REQUEST['tagedcompanyid']);
	$tagedcompanyid = rtrim($tagedcompanyid, ',');
	if ($keyword != '' && $keyword != 'undefined') {
		if ($tagedcompanyid != '') {
			$where = " id NOT IN(" . $tagedcompanyid . ") and tagId!='' OR ";
		} else {
			$where = "  ";
		}


		$n1 = 0;
		$selectFields = [];
		$whereFields = [];
		$whereVals = [];
		$sqlCompany = "";

		$sqlCompany = "select * from " . _COMPANY_MASTER_TABLE_ . " where  " . $where . "  (tagId LIKE '%" . $keyword . "%')  ";
		$resCompany = getRecords(_COMPANY_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
		if ($resCompany) {
			while ($rowCompany = mysqli_fetch_array($resCompany)) {

				$companyPhoto = '';
				$companyTypeName = '';
				if ($rowCompany["companyTypeId"] != 0 && $rowCompany["companyTypeId"] != '') {
					$a = "";
					$a = "SELECT * from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $rowCompany["companyTypeId"] . "";
					$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
					$rowCompanyTypeName = mysqli_fetch_array($b);
					$companyTypeName = $rowCompanyTypeName["optionName"];
				}

				if ($rowCompany['id'] != 0 && $rowCompany['id'] != '') {
					$ap = "";
					$ap = "select imageName from " . _IMAGE_MASTER_TABLE_ . " where  postId= " . $rowCompany['id'] . " and imageType=8 ";
					$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
					$rowLogoImg = mysqli_fetch_array($bp);

					if ($rowLogoImg["imageName"] != '') {
						$companyPhoto = $rowLogoImg["imageName"];
					} else {
						$companyPhoto = 'company.png';
					}
				}



				?>

				<li style="cursor:pointer;"
					onClick="tagthiscompnay('<?php echo $rowCompany['tagId']; ?>','<?php echo $rowCompany['id']; ?>','<?php echo $keyword; ?>');">
					<div class="rquest-box">
						<a class="rqst-img"><img
								src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>"></a>
						<div class="rqst-right">
							<div class="rquest-middle">
								<a><?php echo $rowCompany['companyName']; ?></a>

								<label><?php echo $companyTypeName; ?></label>
							</div>
						</div>
					</div>
				</li>
				<?php
				$n1++;
			}
		}
		?>


	</ul>
	<script>
		$("#searchtagcontact").show();
	</script>

	<?php if ($n1 == 0 && $n == 0) { ?>
		<script>
			$("#searchtagcontact").hide();
		</script>
	<?php } ?>

<?php } else { ?>
	<script>
		$("#searchtagcontact").hide();
	</script>
<?php } ?>