<?php
include_once('inc.php');
$pageIndex = 13;

if ($_REQUEST['id'] != '') {
	$sqlCompany = "SELECT * from " . _TALENT_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['id']) . " ";
	$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
	$rowCompany = mysqli_fetch_array($resCompany);

	if ($rowCompany['talentName'] == '') {
		header('Location:talent-konectt.html');
		exit();
	}

	if ($rowCompany['userId'] != $_SESSION["sessUserId"]) {
		unset($insertFields);
		unset($insertVals);
		unset($whereFields);
		unset($whereVals);

		$insertFields[0] = "viewStatus";

		$insertVals[0] = $rowCompany['viewStatus'] + 1;

		$whereFields[0] = "id";

		$whereVals[0] = decodeStr($_REQUEST['id']);

		$resUpdate = updateDB(_TALENT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	}



	$tId = trim($rowCompany['id']);
	$createdby = $rowCompany["userId"];
	$talentProfileName = stripslashes($rowCompany['talentName']);

	$shortDescription = stripslashes($rowCompany['shortDescription']);
	$longDescription = stripslashes(str_replace("&#65533;", "", ($rowCompany['longDescription'])));
	$talentProfilePhoto11 = trim($rowCompany['talentProfilePhoto']);

	$categoryId = stripslashes($rowCompany['catIds']);
	//$categoryIdArr=explode(",",$categoryId);


	if ($talentProfilePhoto11 != '') {
		$talentProfilePhoto = $talentProfilePhoto11;
	} else {
		$talentProfilePhoto = 'talentimgthumb.png';
	}


}

?>

<?php if ($_REQUEST['page'] == 2) {


	$sqlCompany = "SELECT * from " . _TALENT_VIDEO_TABLE_ . " WHERE talentId= " . decodeStr($_REQUEST['id']) . " order by id desc ";
	$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
	$rowvideo = mysqli_fetch_array($resCompany);



	?>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<div class="vdo-contnr" style="position:relative;">
		<?php if ($_SESSION["sessUserId"] == $rowCompany['userId']) { ?>
			<div style="position:absolute; right:10px; top:10px;">
				<a style="cursor:pointer;"><input name="" type="button" value="Add Video" class="green-btn"
						onclick="funcommonpopupwin('680px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo $_REQUEST['id']; ?>&type=addtalentvideo','Add Video');"></a>
			</div>
		<?php } ?>
		<h2>Videos</h2>
		<?php
		if ($rowvideo['id'] != '') {
			$url = $rowvideo['talentVideoURL'];
			$vimg = ''; // Default empty value
	
			if (!empty($url)) {
				// Try to parse query parameter ?v= (for URLs like https://www.youtube.com/watch?v=abcd1234)
				parse_str(parse_url($url, PHP_URL_QUERY) ?? '', $my_array_of_vars);

				if (!empty($my_array_of_vars['v'])) {
					// Normal YouTube URL
					$vimg = $my_array_of_vars['v'];
				} else {
					// Handle short YouTube URL format (https://youtu.be/abcd1234)
					$path = parse_url($url, PHP_URL_PATH);
					if (!empty($path)) {
						$vimg = ltrim($path, '/');
					}
				}
			} ?>
			<div class="vdo-player">
				<iframe width="100%" id="youtubeframe" name="youtubeframe" height="auto"
					src="//www.youtube.com/embed/<?php echo $vimg; ?>" frameborder="0" allowfullscreen></iframe>
			</div>
			<script>
				function playvideofunc(url) {
					$('#youtubeframe').attr('src', url);
				}

				function goToAnchor(anchor) {
					var loc = document.location.toString().split('#')[0];
					document.location = loc + '#' + anchor;
					return false;
				}
			</script>
			<ul class="speker-vdo-list">

				<?php
				$insertFields = [];
				$selectFields = [];
				$whereFields = [];
				$whereVals = [];

				$sqlOptions1 = "";
				$sqlOptions1 = "SELECT * FROM " . _TALENT_VIDEO_TABLE_ . " WHERE talentId= " . decodeStr($_REQUEST['id']) . " order by id desc ";
				$resOptions1 = getRecords(_OPTION_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
				if ($resOptions1) {
					while ($rowvideoList = mysqli_fetch_array($resOptions1)) {

						$url = $rowvideoList['talentVideoURL'] ?? '';
						$videothumb = ''; // default empty
		
						if (!empty($url)) {
							// Parse query string (handles ?v=)
							parse_str(parse_url($url, PHP_URL_QUERY) ?? '', $my_array_of_vars);

							if (!empty($my_array_of_vars['v'])) {
								// Standard YouTube URL format
								$videothumb = $my_array_of_vars['v'];
							} else {
								// Handle short YouTube link format (https://youtu.be/abcd1234)
								$path = parse_url($url, PHP_URL_PATH);
								if (!empty($path)) {
									$videothumb = ltrim($path, '/');
								}
							}
						}
						?>
						<li>
							<div class="vdo-list-box">
								<div class="vdo-player">
									<img onclick="playvideofunc('//www.youtube.com/embed/<?php echo $videothumb; ?>');goToAnchor('tabboxmaintop');"
										src="http://i1.ytimg.com/vi/<?php echo $videothumb ?>/mqdefault.jpg"
										title="<?php echo stripslashes($rowvideoList['talentVideoTitle']); ?>"
										alt="<?php echo stripslashes($rowvideoList['talentVideoTitle']); ?>">

									<?php if ($_SESSION["sessUserId"] == $rowvideoList['userId']) { ?>
										<div style="width:200px;">
											<div style="right: 10px;" class="delete"
												onclick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo encodeStr($rowvideoList['id']); ?>','deltalentvideo');">
												<i class="fa fa-trash-o" aria-hidden="true"></i>
											</div>

											<div style="right: 50px;" class="delete"
												onclick="funcommonpopupwin('680px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo $_REQUEST['id']; ?>&vid=<?php echo encodeStr($rowvideoList['id']); ?>&type=addtalentvideo','Add Video');">
												<a class="edit educationbg"><i class="fa fa-pencil" aria-hidden="true"></i></a>
											</div>
										</div>
									<?php } ?>
								</div>
								<div class="vdo-ttl"
									onclick="playvideofunc('//www.youtube.com/embed/<?php echo $videothumb; ?>');goToAnchor('tabboxmaintop');"
									title="<?php echo stripslashes($rowvideoList['talentVideoTitle']); ?>">
									<?php echo stripslashes($rowvideoList['talentVideoTitle']); ?>
								</div>
							</div>
						</li>

					<?php }
				} ?>


			</ul>
		<?php } else { ?>
			<div style="text-align:center; padding:20px;">No Video</div>
		<?php } ?>
	</div>


<?php } ?>
<?php if ($_REQUEST['page'] == 3) {

	$sqlCompany = "SELECT * from " . _TALENT_TESTIMONIALS_TABLE_ . " WHERE talentId= " . decodeStr($_REQUEST['id']) . " order by id desc ";
	$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
	$rowvideo = mysqli_fetch_array($resCompany);
	?>
	<!-- Testimonial section -->
	<div class="tstmonial-cont" style="position:relative;">
		<?php if ($_SESSION["sessUserId"] == $rowCompany['userId']) { ?>
			<div style="position:absolute; right:15px; top:10px;">
				<a style="cursor:pointer;"><input name="" type="button" value="Add Testimonial" class="green-btn"
						onclick="funcommonpopupwin('680px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo $_REQUEST['id']; ?>&type=addtalentTestimonials','Add Testimonial');"></a>
			</div>
		<?php } ?>
		<h2>Testimonials</h2>
		<?php
		if ($rowvideo['id'] != '') {
			?> 		<?php echo nl2br($longDescription); ?>
			<ul class="tstmonial_list">
				<?php

				$selectFields = [];
				$whereFields = [];
				$whereVals = [];
				$sqlOptions1 = "";
				$sqlOptions1 = "SELECT * FROM " . _TALENT_TESTIMONIALS_TABLE_ . " WHERE talentId= " . decodeStr($_REQUEST['id']) . " order by id desc ";
				$resOptions1 = getRecords(_OPTION_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
				if ($resOptions1) {
					while ($rowTestmonialsList = mysqli_fetch_array($resOptions1)) {


						?>
						<li>
							<div class="tstmonial_box">
								<?php if ($_SESSION["sessUserId"] == $rowTestmonialsList['userId']) { ?>
									<div class="delete"
										onclick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo encodeStr($rowTestmonialsList['id']); ?>','deltalenttestimonials');">
										<i class="fa fa-trash-o" aria-hidden="true"></i>
									</div>
								<?php } ?>
								<i class="fa fa-quote-left" aria-hidden="true"></i>
								<div class="tstmnl-txt">
									<?php echo nl2br(stripslashes(str_replace("&#65533;", "", ($rowTestmonialsList['testimonialsDetails'])))); ?>
									<div class="tst-name">-
										<?php echo (stripslashes(str_replace("&#65533;", "", ($rowTestmonialsList['testimonialsName'])))); ?>
									</div>
								</div>
								<i class="fa fa-quote-right" aria-hidden="true"></i>
							</div>
						</li>
					<?php }
				} ?>

			</ul>

		<?php } else { ?>
			<div style="text-align:center; padding:20px;">No Testimonial</div>
		<?php } ?>
	</div>
	<!-- Testimonial section End -->
<?php } ?>

<?php if ($_REQUEST['page'] == 1) { ?>
	<div class="tlnt-wrapper">
		<div class="tlnt-bio">
			<h1>Biography</h1>
			<p><?php echo nl2br($longDescription); ?></p>
		</div>
		<div class="tlnt-topic">
			<h1>Topics</h1>
			<ul class="topic-list">
				<?php
				$selectFields = [];
				$whereFields = [];
				$whereVals = [];
				$sqlOptions = "";
				$sqlOptions = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='talent' and id IN (" . $categoryId . ") ";
				$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
				if ($resOptions) {
					while ($rowOptions = mysqli_fetch_array($resOptions)) {
						?>
						<li>
							<a
								href="<?php echo $fullurl; ?>more-talent-profiles.html?_c=<?php echo encodeStr(trim($rowOptions['id'])); ?>"><?php echo $rowOptions['optionName']; ?></a>
						</li>
						<?php

					}
				}
				?>
			</ul>
		</div>
	</div>
<?php } ?>