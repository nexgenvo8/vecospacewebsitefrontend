<ul class="cntr_tab">
	<?php
	if (!isset($page)) {
		$page = 0;
	}

	$sqlCompany = "";
	$talentHave = [];

	if (!empty($_SESSION["sessUserId"])) {
		$sqlCompany = "SELECT id FROM " . _TALENT_MASTER_TABLE_ . " WHERE userId = " . intval($_SESSION["sessUserId"]) . " ORDER BY id DESC";
		$resCompany = mysqli_query($conn, $sqlCompany);

		if ($resCompany && mysqli_num_rows($resCompany) > 0) {
			$talentHave = mysqli_fetch_assoc($resCompany);
		}
	}
	?>

	<li>
		<a href="<?php echo $fullurl; ?>more-talent-profiles.html" <?php if ($page == 1) { ?>class="active" <?php } ?>>
			All Talent Profiles
		</a>
	</li>

	<?php if (!empty($_SESSION["sessUserId"]) && !empty($talentHave['id'])) { ?>
		<li>
			<a href="<?php echo $fullurl; ?>my-talent-profiles.html" <?php if ($page == 2) { ?>class="active" <?php } ?>>
				My Talent Profile
			</a>
		</li>
	<?php } ?>

</ul>