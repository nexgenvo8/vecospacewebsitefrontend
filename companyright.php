<div class="hm_right_sec" style="width:317px;">
	<div class="crt-employr">
		<?php if ($createdby == $_SESSION["sessUserId"]) { ?>
			<a class="btn"
				href="<?php echo $fullurl; ?>create-new-company.html?companyId=<?php echo trim($_REQUEST['companyId']); ?>"><i
					class="fa fa-pencil" aria-hidden="true"></i> Edit Company profile</a>
		<?php } ?>

	</div>

	<?php
	$n = 0;
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlFollowersMember = "";
	$sqlFollowersMember = "select * from " . _COMPANY_FOLLOWERS_TABLE_ . " WHERE companyId= " . decodeStr($_REQUEST['companyId']) . "  order by id desc  ";
	$resFollowersMember = getRecords(_COMPANY_FOLLOWERS_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlFollowersMember);
	if ($resFollowersMember) {

		?>
		<div class="crt-employr">
			<h4 style="font-size:18px;">Other followers of this company</h4>
			<ul class="grp-mmbr_list">
				<?php
				while ($folloMembers = mysqli_fetch_array($resFollowersMember)) {

					$friendnameurl = '';
					$userphoto = '';

					$a = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = " . intval($folloMembers["userId"]);
					$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
					$userres = mysqli_fetch_array($b);

					// ✅ Handle null or missing array values safely
					$userres = isset($userres) && is_array($userres) ? $userres : [];

					$friendnameurl = $userres['userurl'] ?? '';
					$userphoto = $userres['profilePhoto'] ?? 'user-placeholder.jpg';
					$userId = $userres['userId'] ?? 0;
					$firstName = isset($userres['firstName']) ? trim((string) $userres['firstName']) : '';
					$lastName = isset($userres['lastName']) ? trim((string) $userres['lastName']) : '';

					?>
					<li>
						<a
							href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userId); ?>/<?php echo $friendnameurl; ?>.html">
							<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes($userphoto); ?>"
								title="<?php echo stripslashes($firstName . ' ' . $lastName); ?>"
								alt="<?php echo stripslashes($firstName . ' ' . $lastName); ?>">
						</a>
					</li>
					<?php
					$n++;
				}
				?>
				<script>
					$("#companyfollowers").text('<?php echo $n; ?> Followers');
				</script>
			</ul>

		</div>
	<?php } ?>
	<div class="box">
		<h2>Company summary</h2>
		<div class="yremployr">
			<?php if ($numberOfEmployees != '') { ?>
				<div class="indstre">
					<label>Employee Strength</label>
					<span><a style="cursor:default;"><?php echo $numberOfEmployees; ?></a></span>
					<br />
				</div>
			<?php }
			if ($establishedYear != 0) { ?>
				<div class="indstre">
					<label>Established in the year</label>
					<span><a style="cursor:default;"><?php echo $establishedYear; ?></a></span><br />
				</div>
			<?php }
			if ($industryTypeName != '') { ?>
				<div class="indstre">
					<label>Industry</label>
					<span><a style="cursor:default;"><?php echo stripslashes($industryTypeName); ?><?php if (trim($industrySubTypeName) != '') {
						   echo $industrySubTypeName;
					   } ?></a></span>
				</div>
			<?php } ?>
		</div>

		<a href="#" class="all-employrs"><!-- Your employers --></a>
	</div>
	<div class="box">
		<h2>Contact</h2>
		<div class="yremployr">
			<?php if ($empCompanyAddress != '') { ?>
				<div class="indstre">
					<label>Company Address</label>
					<span><a href="https://www.google.co.in/maps/place/<?php echo $empCompanyAddress; ?>"
							target="_blank"><?php echo $empCompanyAddress; ?></a></span>
					<br />
				</div>
			<?php }
			if ($phoneNumber != '') { ?>
				<div class="indstre">
					<label>Phone number</label>
					<span><a style="cursor:default;"><?php echo $phoneNumber; ?></a></span><br />
				</div>
			<?php }
			if ($emailAaddress != '') { ?>
				<div class="indstre">
					<label>Email address</label>
					<span><a style="cursor:default;"><?php echo $emailAaddress; ?></a></span><br />
				</div>

			<?php }
			if ($companyUrl != '') { ?>
				<div class="indstre">
					<label>Company website</label>
					<span><a href="<?php echo $companyUrl; ?>" target="_blank"><?php echo $companyUrl; ?></a></span><br />
				</div>
			<?php } ?>
		</div>
		<h2>Location</h2>
		<div class="indstre">

			<span><?php echo stripslashes($empstate_name); ?>, <?php echo stripslashes($empcountry_name); ?></span>
			<a href="https://www.google.co.in/maps/place/<?php echo stripslashes($empstate_name); ?> <?php echo stripslashes($empcountry_name); ?>"
				target="_blank" class="openingooglemap"> <i class="fa fa-map-marker" aria-hidden="true"></i> Open in
				Google Maps</a>
		</div>
	</div>
	<div class="managedby">This Profile is managed
		by<a><?php if ($createdby == $_SESSION["sessUserId"]) {
			echo 'Me';
		} else { ?><?php echo $rowuserdetails['firstName']; ?>
				<?php echo $rowuserdetails['lastName'];
		} ?></a> </div>
</div>