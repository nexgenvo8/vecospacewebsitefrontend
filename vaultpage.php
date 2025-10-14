<?php
include_once('inc.php');
include_once('config/session-check.inc.php');



?>
<!DOCTYPE html>
<html>

<head>
	<title>Knowledge Hub - <?php echo $companNameTitle; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">

	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
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
					<div class="bx-shadow">

						<div class="smb-cont">

							<div class="vault-bnnr" style="background-image:url(images/vaultbanner.png);">
								<div class="vault-caps">
									<!--<h1 style="margin-bottom:40px;">"Knowledge is Power. Knowledge shared is power multiplied"<span style="font-size:15px; font-weight:normal; padding-left:30px; text-align:left; margin-top:16px; margin-bottom:30px;">-Robert Noyce</span></h1>-->

								</div>
							</div>
							<div class="vault-search">
								<span class="srchanything">Knowledge Hub</span>
								<?php
								$strSearchVar = isset($strSearchVar) ? $strSearchVar : '';
								?>

								<form name="searchvaultfrm" id="searchvaultfrm" class="mrgin_40"
									action="<?php echo $fullurl; ?>search-vault.html" method="get">
									<input type="text" name="txtKeywords" id="txtKeywords"
										value="<?php echo $strSearchVar; ?>" placeholder="Enter Keywords">
									<select name="catIds" id="catIds">
										<option value="">All</option>
										<?php
										$selectFields = [];
										$whereFields = [];
										$whereVals = [];

										$sqlOptions1 = "";
										$sqlOptions1 = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry' ";
										$resOptions1 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
										if ($resOptions1) {
											while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
												if ($_REQUEST["catIds"] == $rowOptions1['id']) {
													$strSelected = 'selected="selected"';
												} else {
													$strSelected = "";
												}
												?>
												<option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected; ?>><?php echo trim($rowOptions1['optionName']); ?></option>
												<?php
											}
										}
										?>
									</select>
									<button type="submit" class="srch" onClick="subsrchfrm();">Search</button>
								</form>
								<script>
									$("input").keypress(function (event) {

										if (event.which == 13) {
											event.preventDefault();

											if ($("#txtKeywords").val() != '') {
												$("#searchvaultfrm").submit();
											}
										}
									});

								</script>

							</div>
							<?php include('vaultinc.php'); ?>
							<div style="    text-align: center;
							padding: 30px 0px;
							float: left;
							font-size: 16px;
							text-align: left;
							padding: 30px;">Welcome to Vault, on <?php echo $companNameTitle; ?>. Here members can upload and share
								presentations, case studies, reports etc, with other members on
								<?php echo $companNameTitle; ?>. Apart from sharing the uploaded content with members,
								you can also share the files with your friends, colleagues etc, via email.<br>
								<br>


								Upload files privately or publicly in PowerPoint, PDF, word and excel formats. The users
								can like, share and download a publicly uploaded document.
							</div>
							<div class="smb-wrapper">


								<div class="how-benefit vault">
									<h2>Recently Uploaded</h2>
									<ul class="vault-box-3">

										<?php
										$n = 1;
										$query_recent = "SELECT * FROM " . _VAULT_MASTER_TABLE_ . " WHERE name != '' ORDER BY id DESC LIMIT 0, 6";
										$a = mysqli_query($conn, $query_recent);

										if ($a && mysqli_num_rows($a) > 0) {
											while ($rowpendingfile = mysqli_fetch_assoc($a)) {
												?>
						<li>
							<div class="vault-box">
								<div class="docimg">
									<a href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>">
										<img src="<?php echo $fullurl; ?>
								<?php
								if (file_exists('uploads/' . $rowpendingfile["documentFile"] . '.jpg')) {
									echo "uploads/" . $rowpendingfile["documentFile"] . '.jpg';
								} else {
									$strFileExtention = findExtension($rowpendingfile["documentFile"]);
									echo "images/";
									if ($strFileExtention == 'doc')
										echo 'doc.png';
									if ($strFileExtention == 'xls')
										echo 'xls.png';
									if ($strFileExtention == 'ppt')
										echo 'ppt.png';
									if ($strFileExtention == 'pdf')
										echo 'pdf.png';
								}
								?>" width="100%" height="100%">
									</a>
								</div>
								<div class="doc-wrap">
									<a href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>" class="docttl">
										<?php echo stripslashes(cleanquestionmark($rowpendingfile["name"])); ?>
									</a>
									<div class="doc-desc">
										<?php echo getStrLength(strip_tags(stripslashes(cleanquestionmark($rowpendingfile["longDescription"]))), 100); ?>
									</div>
									<div class="doc-fttr">
										<div class="doc-vw"><?php echo stripslashes($rowpendingfile["views"]); ?> Views</div>
										<ul class="tmln_fttr">
											<li>
												<a onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=sharevaultdoc&postId=<?php echo encodeStr($rowpendingfile["id"]); ?>','Share Documents');">
													<i class="fa fa-share" aria-hidden="true"></i>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</li>
						<?php
						$n++;
											}
										} else {
											echo "<li>No documents found.</li>";
										}
										?>
	</ul>

	<div class="trnding-bsns">
		<ul class="vault-box-4">
			<?php
			$n = 1;
			$query_trending = "SELECT * FROM " . _VAULT_MASTER_TABLE_ . " WHERE name != '' ORDER BY views DESC LIMIT 0, 6";
			$a = mysqli_query($conn, $query_trending);

			if ($a && mysqli_num_rows($a) > 0) {
				while ($rowpendingfile = mysqli_fetch_assoc($a)) {
					?>
							<li>
								<div class="vault-box">
									<div class="docimg">
										<a href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>">
											<img src="<?php echo $fullurl; ?>
									<?php
									if (file_exists('uploads/' . $rowpendingfile["documentFile"] . '.jpg')) {
										echo "uploads/" . $rowpendingfile["documentFile"] . '.jpg';
									} else {
										$strFileExtention = findExtension($rowpendingfile["documentFile"]);
										echo "images/";
										if ($strFileExtention == 'doc')
											echo 'doc.png';
										if ($strFileExtention == 'xls')
											echo 'xls.png';
										if ($strFileExtention == 'ppt')
											echo 'ppt.png';
										if ($strFileExtention == 'pdf')
											echo 'pdf.png';
									}
									?>" width="100%" height="100%">
										</a>
									</div>
									<div class="doc-wrap">
										<a href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>" class="docttl">
											<?php echo stripslashes(cleanquestionmark($rowpendingfile["name"])); ?>
										</a>
										<div class="doc-desc">
											<?php echo getStrLength(strip_tags(stripslashes(cleanquestionmark($rowpendingfile["longDescription"]))), 100); ?>
										</div>
										<div class="doc-fttr">
											<div class="doc-vw"><?php echo stripslashes($rowpendingfile["views"]); ?> Views</div>
											<ul class="tmln_fttr">
												<li>
													<a onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=sharevaultdoc&postId=<?php echo encodeStr($rowpendingfile["id"]); ?>','Share Documents');">
														<i class="fa fa-share" aria-hidden="true"></i>
													</a>
												</li>
											</ul>
										</div>
									</div>
								</div>
							</li>
							<?php
							$n++;
				}
			} else {
				echo "<li>No trending documents found.</li>";
			}
			?>
		</ul>
		<div class="morerecords" style="margin-bottom:16px;">
			<a href="<?php echo $fullurl; ?>search-vault.html" class="load-more">View More Documents</a>
		</div>
	</div>
</div>

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

</body>

</html>