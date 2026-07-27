<?php
include_once('inc.php');
include_once('config/session-check.inc.php');

if ($_GET['id'] != '') {
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlLogin = "";

	$sqlLogin = "select * from " . _USERS_MASTER_TABLE_ . " where userId='" . decodeStr($_GET['id']) . "'";
	$resLogin = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
	if ($resLogin) {
		while ($rowLogin = mysqli_fetch_array($resLogin)) {
			if (decodeStr($_GET['id']) != $_SESSION["sessUserId"]) {
				header("Location: " . $fullurl . "404error.html");
				exit();
			}
			if ($rowLogin['firstName'] == '') {
				header("Location: " . $fullurl . "404error.html");
				exit();
			}

		}
	}
}

?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $myname; ?> <?php echo $companyname; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>

	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<script src="<?php echo $fullurl; ?>js/jcarousellite_1.0.1.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
	<script src="<?php echo $fullurl; ?>js/croppie.js"></script>
	<style>
		.cr-slider-wrap {
			display: none;
		}
	</style>
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
					<div class="cntr_cntnt">
						<div class="cntr_cntnt_tab">


							<div class="share_post">
								<form name="updateprofilephoto" id="updateprofilephoto" enctype="multipart/form-data"
									method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
									<div class="media user-photo" style="position:relative;">
										<?php if ($myprofilePhoto != 'user-placeholder.jpg') { ?><a
												onClick="$('#commonpopupwinouter').hide();alertpopupmain('1','deleteProfilePhoto');"
												class="deletePhotoLink">Delete Photo</a><?php } ?>

										<span class="edit"><i class="fa fa-camera" aria-hidden="true"></i></span><input
											type="hidden" name="oldprofilePhoto" id="oldprofilePhoto"
											value="<?php echo $oldprofilePhoto; ?>" />

										<img src="<?php echo $fullurl; ?>uploads/<?php echo $myprofilePhoto; ?>"
											onerror="userimgError(this);"><span id="hpotohomeid">
											<input name="imagefile" id="imagefile" type="file"
												onChange="homeuploadfun();"
												style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); "
												accept="image/x-png,image/gif,image/jpeg"></span>
									</div>


									<script>
										function homeuploadfun() {
											//$('#updateprofilephoto').submit();
											//$('#commonloader').show();

											// var hpotohomeid = $('#hpotohomeid').html();

											// $('#imagefile').remove();
											// $('#hpotohomeid').html(hpotohomeid);
										}
									</script>
								</form>
								<div class="media_object">
									<div class="media_left">
										<h3><?php echo $myname; ?>&nbsp;&nbsp;&nbsp; <a
												href="<?php echo $fullurl; ?>personal-data.html" class="updt_prfl">Edit
												Profile</a></h3>
										<!-- <a href="javascript:void(0);" class="whts_new">What's new?</a> -->
										<span class="prfl"><?php echo $jobTitle; ?></span>
										<span class="addrs"><?php echo $companyName; ?> <br>
											<?php if ($mylocationName) {
												echo $mylocationName . ',';
											} ?>
											<?php echo $mystateName; ?> <?php echo $mycountryName; ?></span>
									</div>
									<div class="prfl-stats">


										<h1><?php echo ceil($profilerank); ?>%</h1>
										<div class="proces"><span
												style="width: <?php echo ceil($profilerank); ?>%"></span></div>

										<label>Completed Profile</label>
									</div>
								</div>
							</div>

							<div class="share_post">
								<div id="upload-demo" style="display: none;"></div>
								<button id="uploadprofilephoto"
									style="margin-top:2%;padding: 5px; background: green; color: white; border: 1px solid #ccc;float: right;display: none;">Upload</button>
							</div>

							<script>
								var resize = $('#upload-demo').croppie({
									enableExif: true,
									enableOrientation: true,
									viewport: { // Default { width: 100, height: 100, type: 'square' }
										width: 200,
										height: 200,
										type: 'circle' //square
									},
									boundary: {
										width: 400,
										height: 400
									}
								});

								$('#imagefile').on('change', function () {
									var reader = new FileReader();
									reader.onload = function (e) {
										resize.croppie('bind', {
											url: e.target.result
										}).then(function () {
											console.log('jQuery bind complete');
										});
									}
									reader.readAsDataURL(this.files[0]);
									$('#upload-demo').css('display', 'block');
									$('#uploadprofilephoto').css('display', 'block');
								});

								$('#uploadprofilephoto').on('click', function (ev) {
									resize.croppie('result', {
										type: 'canvas',
										size: 'viewport'
									}).then(function (img) {
										$('#commonloader').show();
										$.ajax({
											url: "<?php echo $fullurl; ?>croppie.php",
											type: "POST",
											data: { "image": img, "oldprofilePhoto": '".<?php echo $oldprofilePhoto; ?>."' },
											success: function (data) {
												console.log(data);
												window.location.reload();
												if (data == "successfullyUpload") {

												}
											}
										});
									});
								});
							</script>
							<div class="descrptn my">
								Tagline: <span style="font-size:11px;">Let people know what describes you best (in max
									50 words) <a class="updt_prfl"
										onClick="$('#taglinecontant').show();$('#taglinecontantText').hide();"
										style="margin-left: 10px;">Edit</a></span>



								<div id="taglinecontant" style="display:none;">
									<textarea name="taglineText" rows="3" id="taglineText"
										placeholder="Briefly describe yourself to profile visitors."><?php echo sanitizedboutput($taglineText); ?></textarea>
									<div id="taglinediv">
										<button type="button" onClick="savetagline();">Save</button>
										<button type="button" class="cancel"
											onClick="$('#taglinecontant').hide();$('#taglinecontantText').show();">Cancel</button>
									</div>
								</div>
								<?php if ($taglineText != '') { ?>
									<div id="taglinecontantText" style="font-size:13px; ">
										<?php echo nl2br(stripslashes(strip_tags($taglineText))); ?>
									</div>
								<?php } ?>

								<?php if ($taglineText == '') { ?>
									<script>
										$("#taglinecontant").show();
										$("#taglinecontantText").hide();
									</script>
								<?php } ?>


							</div>
						</div>
						<ul class="edit_list my">
							<li id="loadprofessionalexppage">
								<h3>Professional experience</h3>
								<a class="add_btn"
									onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=professionalexp','Professional experience');"><i
										class="fa fa-plus-circle" aria-hidden="true"></i> Add</a>
								<?php
								$selectFields = [];
								$whereFields = [];
								$whereVals = [];

								$sqlOptions = "";
								$sqlOptions = "SELECT * FROM " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " WHERE userId=" . $_SESSION["sessUserId"] . " order by fromyear desc ";
								$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
								if ($resOptions) {
									while ($rowOptions = mysqli_fetch_array($resOptions)) {
										$s = 1;
										if ($employmentId == $rowOptions['id']) {
											$strSelected = 'selected="selected"';
										} else {
											$strSelected = "";
										}
										?>
										<div class="companyouter my">
											<div class="roundbox">
												<div style="text-align:center; color:#fff; padding-top:20px; font-size:14px;">
													<?php
													$startdate = '1-' . $rowOptions["frommonth"] . '-' . $rowOptions["fromyear"];
													if ($rowOptions["toyear"] != 0) {
														$enddate = '1-' . $rowOptions["tomonth"] . '-' . $rowOptions["toyear"];
													} else {
														$enddate = date("d-m-Y");
													}

													$datetime1 = new DateTime('' . $startdate . '');
													$datetime2 = new DateTime('' . $enddate . '');
													$interval = $datetime1->diff($datetime2);
													echo $interval->format('%y years<br>
 %m ');
													if ($interval->format('%m') > 1) {
														echo 'months';
													} else {
														echo 'month';
													} ?>
												</div>
											</div>
											<div class="rightpnl">

												<div
													style=" font-size: 17px; color: rgba(0,0,0,.65); line-height: 24px; font-weight: 600;">
													<?php echo $rowOptions["jobTitle"]; ?>
												</div>
												<div style="margin-bottom:5px;color: #00a0af; font-size:14px;">
													<?php echo $rowOptions["companyName"]; ?>
												</div>
												<div>
													<?php echo $rowOptions["frommonth"]; ?>/<?php echo $rowOptions["fromyear"]; ?>
													-
													<?php if ($rowOptions["currentPosition"] != 1) {
														echo $rowOptions["tomonth"] . '/' . $rowOptions["toyear"];
													} else {
														echo 'Present';
													} ?>
												</div>
												<div style="margin-bottom:5px; font-size:14px;"><strong>Industry</strong>: <?php
												$selectFields = [];
												$whereFields = [];
												$whereVals = [];

												$sqlIndustry = "";
												$sqlIndustry = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE id='" . $rowOptions["industry"] . "' ";
												$resIndustry = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlIndustry);
												if ($resIndustry) {
													while ($rowIndustry = mysqli_fetch_array($resIndustry)) {

														?>
															<?php echo trim($rowIndustry['optionName']); ?>
															<?php
													}
												}
												?>
												</div>

												<?php if ($rowOptions["jobLocation"] != '') {
													$p = 1; ?>
													<div style="margin-bottom:5px; font-size:14px;"><strong>Location</strong>:
														<?php echo trim($rowOptions['jobLocation']); ?>
													</div><?php } ?>

												<div style="overflow:hidden; position:relative; display:block;"
													id="maindive<?php echo $rowOptions["id"]; ?>">

													<?php if ($rowOptions["positiondetail"] != '') {
														$p = 1; ?>
														<div style="margin-bottom:5px; font-size:14px;">
															<strong>Description</strong>:
															<?php echo nl2br(trim($rowOptions['positiondetail'])); ?>
														</div><?php } ?>

												</div>


											</div>

											<ul class="hover-btn">
												<li><a class="edit educationbg"
														onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=professionalexp&id=<?php echo encodeStr($rowOptions["id"]); ?>','Professional experience');"><i
															class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a>
												</li>
												<li><a onclick="closefuncommonpopupwin();alertpopupmain('<?php echo encodeStr($rowOptions["id"]); ?>','deleteprofexp');"
														class="dlt"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;</a>
												</li>
											</ul>

										</div>

										<?php


									}
								}

								?>
								<script>
									function showhidepe(id, maindiv) {
										var text = $("#showmoreid" + id).text();

										if (text == 'Show More') {
											$("#showmoreid" + id).text('Less');
											$("#" + maindiv).show();

										}
										else {
											$("#showmoreid" + id).text('Show More');
											$("#" + maindiv).hide();
										}
									}

								</script>

								<?php if (!isset($s) || $s != 1) { ?>
									<div class="add_more" id="experience"
										onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=professionalexp','Professional experience');">
										<h4>Your knowledge, skills and experience</h4>
										<span>Here you can enter your haves, such as software skills, social skills or
											expertise in a certain field.</span>
										<span class="addmore_icon"> <i class="fa fa-plus-circle"
												aria-hidden="true"></i></span>
									</div>
								<?php } ?>

							</li>

							<li id="educationalbackground">
								<h3>Educational background</h3>
								<a class="add_btn"
									onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=educationalbg','Educational background');"><i
										class="fa fa-plus-circle" aria-hidden="true"></i> Add</a>
								<?php
								$selectFields = [];
								$whereFields = [];
								$whereVals = [];

								$sqlOptions = "";
								$sqlOptions = "SELECT * FROM " . _EDUCATIONAL_BACKGROUND_TABLE_ . " WHERE userId=" . $_SESSION["sessUserId"] . " order by toyear desc ";
								$resOptions = getRecords(_EDUCATIONAL_BACKGROUND_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
								if ($resOptions) {
									while ($rowOptions = mysqli_fetch_array($resOptions)) {
										$es = 1;
										?>
										<div class="companyouter education my">
											<div class="roundbox"><i class="fa fa-graduation-cap" aria-hidden="true" style="    position: absolute;
									right: 8px;
									top: 12px;
									font-size: 26px;"></i></div>
											<div class="rightpnl">
												<div>
													<?php echo $rowOptions["frommonth"]; ?>/<?php echo $rowOptions["fromyear"]; ?>
													-
													<?php if (!isset($_POST['currentPosition']) || $rowOptions["currentPosition"] != 1) {
														echo $rowOptions["tomonth"] . '/' . $rowOptions["toyear"];
													} else {
														echo 'Present';
													} ?>
												</div>
												<div
													style="margin-bottom: 5px; font-size: 17px; color: rgba(0,0,0,.65); line-height: 24px; font-weight: 600;">
													<?php echo $rowOptions["university"]; ?>
												</div>
												<div style="margin-bottom:5px; font-size:14px;">
													<?php echo $rowOptions["fieldofstudy"]; ?>
												</div>
												<div style="margin-bottom:5px; font-size:14px;">
													<?php echo $rowOptions["degree"]; ?>
												</div>
												<?php if ($rowOptions["specialisedsubjects"] != '') { ?>
													<div style="margin-bottom:5px; font-size:14px;"><strong>Specialisation</strong>:
														<?php echo $rowOptions["specialisedsubjects"]; ?>
													</div><?php } ?>
												<div style="overflow:hidden; position:relative; display:block;"
													id="maindive<?php echo $rowOptions["id"]; ?>">
													<?php $e = '';
													if ($rowOptions["description"] != '') {
														$e = 1; ?>
														<div style="margin-bottom:5px; font-size:14px;">
															<strong>Description</strong>: <?php echo $rowOptions["description"]; ?>
														</div><?php } ?>

												</div>

											</div>

											<ul class="hover-btn">
												<li><a class="edit educationbg"
														onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=educationalbg&id=<?php echo encodeStr($rowOptions["id"]); ?>','Educational background');"><i
															class="fa fa-pencil" aria-hidden="true"></i>&nbsp;</a>
												</li>
												<li><a onclick="closefuncommonpopupwin();alertpopupmain('<?php echo encodeStr($rowOptions['id']); ?>','deleducational');"
														class="dlt"><i class="fa fa-trash-o" aria-hidden="true"></i>&nbsp;</a>
												</li>
											</ul>

										</div>

										<?php


									}
								}

								?>
								<script>
									function showhidepe(id, maindiv) {
										var text = $("#showmoreid" + id).text();

										if (text == 'Show More') {
											$("#showmoreid" + id).text('Less');
											$("#" + maindiv).show();

										}
										else {
											$("#showmoreid" + id).text('Show More');
											$("#" + maindiv).hide();
										}
									}

								</script>

								<?php if (!isset($es) || $es != 1) { ?>
									<div class="add_more" id="experience"
										onClick="funcommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=educationalbg','Educational background');">
										<h4>Education</h4>
										<span>Where did you train? Enter the name of your university, college, etc. here
											along with the content of the course.</span>
										<span class="addmore_icon"> <i class="fa fa-plus-circle"
												aria-hidden="true"></i></span>
									</div>
								<?php } ?>

							</li>



							<li id="loadskillpage">




							</li>
							<script>
								loadskills();
							</script>




							<li id="loadexploringpage">

							</li>

							<script>
								loadexploring();
							</script>




							<li id="loadlanguagespage">

							</li>



							<script>
								loadlanguages();
							</script>


							<li id="loadinterestspage">

							</li>


							<script>
								loadinterest();
							</script>


							<?php
							$selectFields = [];
							$whereFields = [];
							$whereVals = [];

							$sqlUserRec = "";
							$sqlUserRec = "SELECT * FROM " . _USER_RECOMMENDATIONS_TABLE_ . " WHERE contactId=" . $_SESSION["sessUserId"] . " order by dateAdded desc ";
							$resUserRec = getRecords(_USER_RECOMMENDATIONS_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlUserRec);
							if ($resUserRec) {
								?>
								<li id="userrecommed">
									<h3>Recommendations(<?php echo mysqli_num_rows($resUserRec); ?>)</h3>
									<?php
									while ($rowUserRec = mysqli_fetch_array($resUserRec)) {

										$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowUserRec["userId"] . "";
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
										?>
										<div class="recbox my">
											<div class="rlft">
												<div
													style="width:56px; height:56px; overflow:hidden; margin-right:10px; float:left; border-radius: 50%;">
													<a
														href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
															src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"
															style="width:100%;"></a>
												</div>
												<div style="float:left; width:140px;">
													<div style="margin-bottom:5px;"><a
															href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo $userres["firstName"]; ?>
															<?php echo $userres["lastName"]; ?></a></div>
													<div style="margin-bottom:5px; font-size:12px; color:#9a9a9a;">
														<?php echo $userres["jobTitle"]; ?> at
														<?php echo $userres["companyName"]; ?>
													</div>
													<div style="margin-bottom:5px; font-size:12px; color:#9a9a9a;">
														<?php echo makedatetime($rowUserRec["dateAdded"]); ?>
													</div>
												</div>
											</div>
											<div class="rrit"><?php echo nl2br($rowUserRec["recommendationText"]); ?>
												<div style="margin-top:10px;">
													<?php if ($rowUserRec["status"] != 1) { ?>
														<a class="updt_prfl" style="margin-right:5px;"
															href="<?php echo $fullurl; ?>common_action.php?id=<?php echo encodeStr($rowUserRec["id"]); ?>&action=recaprov"
															target="actionfrm">Make public</a><?php } else { ?>
														<a class="updt_prfl"
															style="margin-right:5px; background-color:#2bbd10; cursor:default;">Public</a>
													<?php } ?>
													<a class="updt_prfl" style="background-color:#ef4b4b;"
														onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo encodeStr($rowUserRec["id"]); ?>','delrec');">Delete</a>


												</div>
											</div>
										</div>
										<?php
									}

									?>
								</li>
								<?php

							}
							?>

						</ul>



					</div>
					<?php include('right-sidebar.php'); ?>
				</div>
			</div>
		</div>
		<?php include('footer.php'); ?>
	</div>


	<script>
		function reloadPage() {
			location.reload(true);
		}
	</script>
</body>

</html>