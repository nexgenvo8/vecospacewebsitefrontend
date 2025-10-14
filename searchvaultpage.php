<?php
include_once('inc.php');
include_once('config/session-check.inc.php');

$strWhere = '';
$strSearchVar = ''; // <-- ensure variable exists

$txtKeywords = $_REQUEST['txtKeywords'] ?? '';
$catIds = $_REQUEST['catIds'] ?? '';

if ($txtKeywords != '') {
	$strWhere .= " AND name LIKE '%" . addslashes($txtKeywords) . "%' ";
	$strSearchVar = $txtKeywords;
}

if ($catIds != '') {
	$strWhere .= " AND catIds='" . addslashes($catIds) . "' ";
}
?>

<!DOCTYPE html>
<html>

<head>
	<title>Vault - Welcome to <?php echo $companNameTitle; ?></title>
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

							<div class="vault-bnnr serch" style="background-image:url(images/vaultbanner.png);">
								<div class="vault-caps">


								</div>
							</div>
							<div class="vault-search">
								<form name="searchvaultfrm" id="searchvaultfrm" class=""
									action="<?php echo $fullurl; ?>search-vault.html" method="get">
									<input type="text" name="txtKeywords" id="txtKeywords"
										value="<?php echo htmlspecialchars($strSearchVar); ?>"
										placeholder="Enter Keywords">

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
							<!--<?php include('vaultinc.php'); ?> -->
							<div class="smb-wrapper">
								<?php
								$n = 0;
								$no = 1;
								$select = '';
								$where = '';
								$rs = '';

								// ✅ Prevent undefined index warning for $_GET['page']
								$page = isset($_GET['page']) ? $_GET['page'] : 1;

								// ✅ Set default limit
								$limit = '30';
								$select = '*';

								// ✅ Define $strWhere safely (in case it's not set elsewhere)
								$strWhere = isset($strWhere) ? $strWhere : '';

								// ✅ Define $fullurl safely (optional if already defined above)
								$fullurl = isset($fullurl) ? $fullurl : '';

								// ✅ Prevent undefined index warning for $_REQUEST keys
								$txtKeywords = isset($_REQUEST['txtKeywords']) ? $_REQUEST['txtKeywords'] : '';
								$catIds = isset($_REQUEST['catIds']) ? $_REQUEST['catIds'] : '';

								$where = ' where name!="" and privacy=1 ' . $strWhere . ' order by id desc';
								$targetpage = $fullurl . 'search-vault.html?records=' . $limit . '&txtKeywords=' . $txtKeywords . '&catIds=' . $catIds . '&';

								$rs = GetRecordList($select, _VAULT_MASTER_TABLE_, $where, $limit, $page, $targetpage);
								$totalentry = $rs[1];
								$paging = $rs[2];

								?>
								<div class="trnding-bsns search vault">
									<?php if ($totalentry > 0) { ?>
										<h2
											style="    padding-left: 15px; border-bottom: dotted 1px #e7e7e7; margin-bottom: 0; padding-bottom: 15px;">
											All Documents</h2>
										<ul class="vault-box-4">

											<?php
											while ($rowpendingfile = mysqli_fetch_array($rs[0])) {

												?>
												<li>
													<div class="vault-box">
														<div class="docimg">
															<a
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
																	   } ?>" width="100%" height="100%"></a>
														</div>
														<div class="doc-wrap">
															<a href="<?php echo $fullurl; ?>view-document.html?id=<?php echo encodeStr($rowpendingfile["id"]); ?>"
																class="docttl"><?php echo stripslashes(cleanquestionmark($rowpendingfile["name"])); ?></a>
															<div class="doc-desc">
																<?php echo getStrLength(strip_tags(stripslashes(cleanquestionmark($rowpendingfile["longDescription"]))), 100); ?>
															</div>
															<div class="doc-fttr">
																<div class="doc-vw">
																	<?php echo stripslashes($rowpendingfile["views"]); ?> Views
																</div>
																<ul class="tmln_fttr">

																	<!--<li>-->
																	<!--	<a href="<?php echo $fullurl; ?>downloads/<?php echo encodeStr($rowpendingfile["id"]); ?>/<?php echo makeContentUrl(stripslashes(cleanquestionmark($rowpendingfile["name"]))); ?>.html"><i class="fa fa-download" aria-hidden="true"></i> </a>-->
																	<!--</li>-->
																	<li>
																		<a
																			onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=sharevaultdoc&postId=<?php echo encodeStr($rowpendingfile["id"]); ?>','Share Documents');"><i
																				class="fa fa-share" aria-hidden="true"></i> </a>
																	</li>
																</ul>
															</div>
														</div>
													</div>
												</li>
												<?php
												$n++;
											}
											?>

										</ul>



										<div style="margin-top:20px; text-align:left;">
											<div class="pagingnumbers"><?php echo $paging; ?></div>
										</div>
									<?php }

									if ($n == 0) { ?>
										<div class="not-found">
											<img src="<?php echo $fullurl; ?>images/documentnotfound.png">
											<div>Oops! no document found.</div>
										</div>
									<?php } ?>

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