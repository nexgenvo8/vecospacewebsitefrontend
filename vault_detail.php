<?php
include_once('inc.php');
$postType = 20;
if ($_REQUEST['id'] != '') {

	$sqlVault = "SELECT * from " . _VAULT_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['id']) . " ";
	$resVault = mysqli_query($conn, $sqlVault) or die(mysqli_error($conn));
	$rowVault = mysqli_fetch_array($resVault);

	if ($rowVault['name'] == '') {
		header('Location:vault.html');
		exit();
	}

	if ($rowVault['userId'] != $_SESSION["sessUserId"]) {

		unset($insertFields);
		unset($insertVals);
		unset($whereFields);
		unset($whereVals);

		$insertFields[0] = "views";

		$insertVals[0] = $rowVault['views'] + 1;

		$whereFields[0] = "id";

		$whereVals[0] = decodeStr($_REQUEST["id"]);

		$resUpdate = updateDB(_VAULT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, ''); //Count project views
	}

	$friendnameurl = '';
	$userphoto = '';
	$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowVault["userId"] . "";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$userres = mysqli_fetch_array($b);

	$jobTitle = $userres["jobTitle"];
	$companyName = $userres["companyName"];

	$friendnameurl = $userres['userurl'];

	if ($userres["profilePhoto"] != '') {
		$userphoto = $userres["profilePhoto"];
	} else {
		$userphoto = 'user-placeholder.jpg';
	}

	$aa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= " . $rowVault["id"] . " and postType= " . $postType . "";
	$res5 = mysqli_query($conn, $aa);
	$totalpostlike = mysqli_num_rows($res5);

	$aa1 = "select id from " . _VAULT_SHARE_MASTER_ . " where  postId=" . $rowVault["id"] . "";
	$res51 = mysqli_query($conn, $aa1);
	$totalShare = mysqli_num_rows($res51);



}

?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo stripslashes(cleanquestionmark($rowVault["name"])); ?> - Vault - <?php echo $companNameTitle; ?>
	</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<meta property="og:title"
		content="<?php echo stripslashes(cleanquestionmark($rowVault["name"])); ?> - Vault - <?php echo $companNameTitle; ?>" />
	<meta property="og:image" content="<?php echo $fullurl; ?><?php if (file_exists('uploads/' . $rowVault["documentFile"] . '.jpg')) { ?>uploads/<?php echo $rowVault["documentFile"] . '.jpg';
	   } else {
		   $strFileExtention = findExtension($rowVault["documentFile"]); ?>images/<?php if ($strFileExtention == 'doc') {
				  echo 'doc.png';
			  }
			  if ($strFileExtention == 'xls') {
				  echo 'xls.png';
			  }
			  if ($strFileExtention == 'ppt') {
				  echo 'ppt.png';
			  }
			  if ($strFileExtention == 'pdf') {
				  echo 'pdf.png';
			  }
	   } ?>" />
	<meta property="og:description"
		content="<?php echo strip_tags(stripslashes(cleanquestionmark($rowVault["longDescription"]))); ?>" />
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
						<?php include('vaultinc.php'); ?>
						<div class="your-vault">
							<div class="my-doclist dtail">
								<?php
								// Ensure documentFile exists
								$documentFile = isset($rowVault["documentFile"]) ? trim($rowVault["documentFile"]) : '';

								if (!empty($documentFile)) {

									// Full file URL
									$fileUrl = $fullurl . "uploads/" . urlencode($documentFile);

									// Get file extension
									$fileExt = strtolower(pathinfo($documentFile, PATHINFO_EXTENSION));

									// Decide how to display
									if ($fileExt === 'pdf') {
										// PDF embed directly
										echo '<iframe src="' . $fileUrl . '" width="100%" height="100%" style="border:none;"></iframe>';
									} else {
										// Use Google Docs Viewer for other formats
										echo '<iframe src="https://docs.google.com/gview?url=' . urlencode($fileUrl) . '&embedded=true" width="100%" height="100%" style="border:none;"></iframe>';
									}

								} else {
									echo "<p style='color:red;'>No document found.</p>";
								}
								?>

								<!-- <iframe
									src="https://docs.google.com/gview?url=<?php echo $fullurl; ?>uploads/<?php echo $rowVault["documentFile"]; ?>&amp;embedded=true"
									width="100%" height="100%" /></iframe> -->
								<div class="doc-ttl"><?php echo stripslashes(cleanquestionmark($rowVault["name"])); ?>
									<span><?php echo stripslashes($rowVault["views"]); ?> Views</span>
								</div>
								<?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
									<ul class="tmln_fttr docdtail">
										<li id="post<?php echo $rowVault["id"]; ?><?php echo $postType; ?>" onClick="postlike(<?php echo $rowVault["id"]; ?>,<?php echo $postType; ?>,<?php if ($totalpostlike != '') {
														echo $totalpostlike;
													} else {
														echo '0';
													} ?>);">
											<a><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like <span>
													<?php if ($totalpostlike != '') {
														echo $totalpostlike;
													} else {
														echo '0';
													} ?>
												</span></a>
										</li>
										<li>
											<a
												href="<?php echo $fullurl; ?>downloads/<?php echo encodeStr($rowVault["id"]); ?>/<?php echo makeContentUrl(stripslashes(cleanquestionmark($rowVault["name"]))); ?>.html"><i
													class="fa fa-download" aria-hidden="true"></i> <span>Download</span>
											</a>
										</li>
										<li>
											<a
												onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=sharevaultdoc&postId=<?php echo $_REQUEST['id']; ?>','Share Documents');"><i
													class="fa fa-share" aria-hidden="true"></i> Share <span>
													<?php if ($totalShare != '') {
														echo $totalShare;
													} else {
														echo '0';
													} ?></span>
											</a>
										</li>
									</ul>
									<?php
								}

								if ($rowVault["privacy"] == '1') {
									?>
									<div class="sharewith">
										<div>
											<script type="text/javascript"
												src="//s7.addthis.com/js/300/addthis_widget.js#pubid=imran190"></script>
											<div class="addthis_inline_share_toolbox_tnos"></div>
										</div>
									</div>
								<?php } ?>
								<div class="docdtail-wrap">
									<div class="doc-authr">
										<div class="img">
											<a
												href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
													src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
										</div>
										<div class="doc-authr-dtail">
											<a class="nm"
												href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes(trim($userres["firstName"])); ?>
												<?php echo stripslashes(trim($userres["lastName"])); ?></a>
											<span class="dt"><?php echo $jobTitle; ?>
												<?php if ($companyName != '') {
													echo '- ' . $companyName;
												} ?></span>
										</div>
									</div>
									<div class="postdon">

										Published on <?php echo makedatetime($rowVault["dateAdded"]); ?>
									</div>
									<div class="postdon" style="text-align:right; border-right:0px;">

										Category : <span style=" color:#000000;"><a
												href="<?php echo $fullurl; ?>search-vault.html?catIds=<?php echo $rowVault["catIds"]; ?>"><?php
													  $ape = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry' and id='" . $rowVault["catIds"] . "' ";
													  $bpe = mysqli_query($conn, $ape) or die(mysqli_error($conn));
													  $rowOptions1 = mysqli_fetch_array($bpe);

													  echo trim($rowOptions1['optionName']);
													  ?></a></span>
									</div>
									<div class="descr">
										<?php echo nl2br(stripslashes(cleanquestionmark($rowVault["longDescription"]))); ?>
									</div>
								</div>

							</div>
							<div class="storage-graph dtail">
								<h2 style="padding: 10px;padding-left: 15px;">Recommended</h2>
								<ul class="docrecomnd-list">
									<?php
									$a1 = "";
									$a1 = mysqli_query($conn, "SELECT * FROM " . _VAULT_MASTER_TABLE_ . " WHERE name != '' ORDER BY RAND() LIMIT 0,7");
									while ($rowpendingfile = mysqli_fetch_array($a1)) {


										?>
										<li>
											<div class="rcmnd">
												<div class="img"><a
														href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>"><img
															src="<?php echo $fullurl; ?><?php if (file_exists('uploads/' . $rowpendingfile["documentFile"] . '.jpg')) { ?>uploads/<?php echo $rowpendingfile["documentFile"] . '.jpg';
															   } else {
																   $strFileExtention = findExtension($rowpendingfile["documentFile"]); ?>images/<?php if ($strFileExtention == 'doc') {
																		  echo 'doc.png';
																	  }
																	  if ($strFileExtention == 'xls') {
																		  echo 'xls.png';
																	  }
																	  if ($strFileExtention == 'ppt') {
																		  echo 'ppt.png';
																	  }
																	  if ($strFileExtention == 'pdf') {
																		  echo 'pdf.png';
																	  }
															   } ?>" width="100%" height="100%"></a></div>
												<div class="rcmnd-dtail">
													<div class="ttl"><a
															href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>"><?php echo stripslashes(cleanquestionmark($rowpendingfile["name"])); ?></a>
													</div>
													<span class="authr"><?php $ape = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry' and id='" . $rowpendingfile["catIds"] . "' ";
													$bpe = mysqli_query($conn, $ape) or die(mysqli_error($conn));
													$rowOptions1 = mysqli_fetch_array($bpe);

													echo trim($rowOptions1['optionName']); ?></span>
												</div>
											</div>
										</li>

										<?php

									}
									?>
								</ul>
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