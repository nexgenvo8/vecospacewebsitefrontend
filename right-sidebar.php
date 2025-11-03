<?php
$jcarousellite = $_GET['jcarousellite'] ?? 0;
if ($jcarousellite != 1) { ?>
	<script src="<?php echo $fullurl; ?>js/jcarousellite_1.0.1.js"></script>
<?php } ?>
<div class="hm_right_sec">
	<div class="showcurrentright">
		<?php echo date('l, j F Y'); ?>
	</div>
	<?php unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	$mb = 0;
	$sqlQuery = "";
	$sqlQuery = "select dob,userId,firstName,lastName,profilePhoto,userurl,jobTitle,companyName from " . _USERS_MASTER_TABLE_ . " where userId IN(select contactId from " . _CONTACT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and status=1 and birthdayStatus=0) and dob!='0000-00-00'";
	$resQuery = $conn->query($sqlQuery);

	if ($resQuery && $resQuery->num_rows > 0) {
		?>
		<div class="birth-notice" id="userbirthdaysdiv" style="display:none;">
			<div class="birth-namecont">
				<?php
				while ($rowcontacts = $resQuery->fetch_assoc()) {
					$userdob = $rowcontacts["dob"];

					$userdobArr = explode("-", $userdob);
					$dobyear = $userdobArr[0];
					$dobmonth = $userdobArr[1];
					$dobday = $userdobArr[2];

					$userdob = $dobmonth . '-' . $dobday;

					if ($userdob == date("m-d")) {

						$frienddobnameurl = $rowcontacts['userurl'];
						if ($rowcontacts["profilePhoto"] != '') {
							$userdobphoto = $rowcontacts["profilePhoto"];
						} else {
							$userdobphoto = 'user-placeholder.jpg';
						}

						$usercontactid = encodeStr($rowcontacts['userId']);
						$userfirstName = stripslashes(trim($rowcontacts["firstName"]));
						$userlastName = stripslashes(trim($rowcontacts["lastName"]));
						?>

						<div class="birthcont">
							<div class="img">
								<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowcontacts['userId']); ?>/<?php echo $frienddobnameurl; ?>.html"
									target="_blank" class="rqst-img"><img
										src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userdobphoto)); ?>"></a>
							</div>
							<div class="birth-nm">
								<h2>It's <?php echo stripslashes(trim($rowcontacts["firstName"])) . "&rsquo;s"; ?> Birthday Today!
								</h2>
								<span><?php echo stripslashes($rowcontacts["jobTitle"]); ?>
									<?php if (stripslashes($rowcontacts["companyName"]) != '') {
										echo 'at ' . stripslashes($rowcontacts["companyName"]);
									} ?></span>

							</div>
						</div>
						<?php
						$mb++;

					}

				}
				?>

				<p>Leave a message with your best wishes!</p>
				<a <?php if ($mb > 1) { ?>onclick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=sayhappybirthday','Say Happy Birthday');"
					<?php } else { ?>
						onclick="openuserchatbox('<?php echo $usercontactid; ?>','<?php echo $userfirstName; ?> <?php echo $userlastName; ?>','<?php echo $fullurl; ?>profile/<?php echo $usercontactid; ?>/<?php echo $frienddobnameurl; ?>.html');$('#chatfieldfooter').val('Happy Birthday');$('#shb').val('1');"
					<?php } ?> class="send-wish">Send Message</a>
			</div>
		</div>

		<?php
	}
	if ($mb > 0) {
		?>
		<script>
			$('#userbirthdaysdiv').show();
		</script>
	<?php } ?>

	<?php

	if (!isset($ps)) {
		$ps = 0;
	}
	if (!isset($msg)) {
		$msg = 0;
	}

	if ($ps != 1) {
		if ($msg != 1) { ?>
			<?php


			?>
			<div class="right-box-cont" style="display:none;">
				<div class="suggest-box">
					<h2><strong>Notice Board</strong></h2>
					<ul class="trending-list">
						<?php
						unset($selectFields);
						unset($whereFields);
						unset($whereVals);

						$sqlViewArticle2 = "";
						$sqlViewArticle2 = "SELECT userId,id,postTitle,postText from " . _SHAREANDUPDATES_TABLE_ . "  WHERE postType=3 and postTitle!='' and articleBlogStatus=0 ORDER BY dateAdded desc LIMIT 0,3 ";
						$resViewArticle2 = $conn->query($sqlViewArticle2);

						if ($resViewArticle2 && $resViewArticle2->num_rows > 0) {
							while ($rowViewArticle2 = $resViewArticle2->fetch_assoc()) {

								$a2 = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId=" . intval($rowViewArticle2["userId"]);
								$b2 = $conn->query($a2);

								if ($b2 && $b2->num_rows > 0) {
									$userres2 = $b2->fetch_assoc();
									if ($userres2["profilePhoto"] != '') {
										$profilePhoto = $userres2["profilePhoto"];
									} else {
										$profilePhoto = 'user-placeholder.jpg';
									}
									?>
									<li style="cursor:pointer;"
										onclick="window.location.href = '<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowViewArticle2['id']); ?>';">
										<div class="artcl-img"><img src="<?php echo $fullurl; ?>uploads/<?php echo $profilePhoto; ?>"></div>
										<a
											class="ttle"><?php echo substr((stripslashes(trim($rowViewArticle2["postTitle"]))), 0, 5000); ?></a>
										<span
											class="desc"><?php echo substr(strip_tags(stripslashes(trim($rowViewArticle2["postText"]))), 0, 6000); ?></span>
										<span class="nm">By <?php echo stripslashes(trim($userres2["firstName"])); ?>
											<?php echo stripslashes(trim($userres2["lastName"])); ?></span>
									</li>
									<?php
								}
							}

							?>


						</ul>
						<div style="text-align:right;"><a href="<?php echo $fullurl; ?>articles-and-trivia.html">View More</a></div>
					</div>
				</div>
				<div class="right-box-cont">
					<div class="suggest-box">
						<h2>Notice Board</h2>
						<ul class="trending-list">
							<?php
							unset($selectFields, $whereFields, $whereVals);

							$sqlViewArticle2 = "SELECT * FROM noticeBoard ORDER BY id DESC LIMIT 0,5";
							$resViewArticle2 = $conn->query($sqlViewArticle2);

							if ($resViewArticle2 && $resViewArticle2->num_rows > 0) {
								while ($rowViewArticle2 = $resViewArticle2->fetch_assoc()) {
									?>
									<li style="cursor:pointer; padding-left: 0 !important;"
										onclick="window.location.href = '<?php echo $fullurl; ?>view-notice.html?postId=<?php echo encodeStr($rowViewArticle2['id']); ?>';">
										<!--<div class="artcl-img"><img src="<?php echo $fullurl; ?>uploads/<?php echo $profilePhoto; ?>"></div>-->
										<a class="ttle">
											<?php echo substr(stripslashes(trim($rowViewArticle2["title"])), 0, 5000); ?>
										</a>
										<span class="desc">
											<?php echo substr(strip_tags(stripslashes(trim($rowViewArticle2["details"]))), 0, 6000); ?>
										</span>
										<span class="nm">Notice Date
											<?php echo date('d M, Y', strtotime($rowViewArticle2["addeddate"])); ?>
										</span>
									</li>
									<?php
								}
								$resViewArticle2->free(); // Memory cleanup
							}
							?>
						</ul>
						<div style="text-align:right;">
							<a href="<?php echo $fullurl; ?>all-notice.html">View More</a>
						</div>
					</div>

				</div>
			<?php }
		} else {

			if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
				$userwhereid = $_SESSION["sessUserId"];
			} else {
				$userwhereid = 0;
			}


			?>
			<div class="right-box-cont" id="similarProfilesDiv">
				<div class="suggest-box">
					<h2>Similar Profiles</h2>
					<ul class="trending-list">
						<?php
						$fl = 0;
						$s = 1;

						$selectFields = [];
						$whereFields = [];
						$whereVals = [];
						$strWhereContacts = '';

						$sqlViewArticle2 = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " 
    WHERE activeYN='Y' 
    AND jobTitle='" . $conn->real_escape_string($jobTitle) . "' 
    AND userId!=" . intval(decodeStr(!isset($_POST['id']) || $_GET['id'])) . " 
    AND userId NOT IN (
        SELECT contactId FROM " . _CONTACT_MASTER_TABLE_ . " 
        WHERE userId=" . intval($userwhereid) . " AND status=1
    ) 
    AND companyName!='' 
    AND userId!='" . intval($userwhereid) . "' " . $strWhereContacts . " 
    ORDER BY RAND() LIMIT 0,5";

						$resViewArticle2 = $conn->query($sqlViewArticle2);

						if ($resViewArticle2 && $resViewArticle2->num_rows > 0) {
							while ($rowViewArticle2 = $resViewArticle2->fetch_assoc()) {
								$fl = 1;

								$a2 = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId=" . intval($rowViewArticle2["userId"]);
								$b2 = $conn->query($a2);

								if ($b2 && $b2->num_rows > 0) {
									$userres2 = $b2->fetch_assoc();
									$friendnameurl = $userres2['userurl'];
									$profilePhoto = !empty($userres2["profilePhoto"]) ? $userres2["profilePhoto"] : 'user-placeholder.jpg';
									?>
									<li style="cursor:pointer;"
										onclick="window.location.href = '<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2['userId']); ?>/<?php echo $friendnameurl; ?>.html';">
										<div class="artcl-img"><img src="<?php echo $fullurl; ?>uploads/<?php echo $profilePhoto; ?>"></div>
										<a class="ttle"><?php echo stripslashes(trim($userres2["firstName"])); ?>
											<?php echo stripslashes(trim($userres2["lastName"])); ?></a>
										<span class="nm"><?php echo $userres2['jobTitle']; ?> at
											<?php echo $userres2['companyName']; ?></span>
									</li>
									<?php
									$b2->free();
								}
								$s++;
							}
							$resViewArticle2->free();
						}

						if ($s == 1) {
							unset($selectFields, $whereFields, $whereVals);
							$l2 = 0;
							$sqlViewArticle2 = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " 
        WHERE activeYN='Y' 
        AND cityName='" . $conn->real_escape_string($mystateName) . "' 
        AND userId!=" . intval(decodeStr(!isset($_GET['id']))) . " 
        AND userId NOT IN (
            SELECT contactId FROM " . _CONTACT_MASTER_TABLE_ . " 
            WHERE userId=" . intval($userwhereid) . " AND status=1
        ) 
        AND companyName!='' 
        AND userId!='" . intval($userwhereid) . "' " . $strWhereContacts . " 
        ORDER BY RAND() LIMIT 0,5";

							$resViewArticle2 = $conn->query($sqlViewArticle2);

							if ($resViewArticle2 && $resViewArticle2->num_rows > 0) {
								while ($rowViewArticle2 = $resViewArticle2->fetch_assoc()) {
									$l2 = 1;

									$a2 = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId=" . intval($rowViewArticle2["userId"]);
									$b2 = $conn->query($a2);

									if ($b2 && $b2->num_rows > 0) {
										$userres2 = $b2->fetch_assoc();
										$friendnameurl = $userres2['userurl'];
										$profilePhoto = !empty($userres2["profilePhoto"]) ? $userres2["profilePhoto"] : 'user-placeholder.jpg';
										?>
										<li style="cursor:pointer;"
											onclick="window.location.href = '<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2['userId']); ?>/<?php echo $friendnameurl; ?>.html';">
											<div class="artcl-img"><img src="<?php echo $fullurl; ?>uploads/<?php echo $profilePhoto; ?>"></div>
											<a class="ttle"><?php echo stripslashes(trim($userres2["firstName"])); ?>
												<?php echo stripslashes(trim($userres2["lastName"])); ?></a>
											<span class="nm"><?php echo $userres2['jobTitle']; ?> at
												<?php echo $userres2['companyName']; ?></span>
										</li>
										<?php
										$b2->free();
									}
								}
								$resViewArticle2->free();
							}
						}
						?>
					</ul>

				</div>
			</div>
			<?php
		}
		?>

	<?php } // <-- Add this closing brace to properly close the initial if ($ps != 1) block ?>

	<div class="showcurrentright" style="font-size:17px !important;">
		University Placement Cell
	</div>

	<div id="trend">


		<?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
			<div class="right-fttr">
				<ul class="fttr-list">
					<li><a href="<?php echo $fullurl; ?>sdg-pvcypage.html" target="_blank">Privacy</a></li>
					<li><a href="<?php echo $fullurl; ?>terms.html" target="_blank">Terms</a></li>
					<li><a href="<?php echo $fullurl; ?>about.html" target="_blank">About</a></li>
					<li><a href="<?php echo $fullurl; ?>faq.html" target="_blank">FAQ's</a></li>
				</ul>
				<p> &copy; <?php echo date("Y"); ?>&nbsp;SDG COMNET VECOSPACE</p>
				<div class="pwrddebox">
					<div style="float:left"><span style="color: #9f9f9f;">Powered by &nbsp;&nbsp;&nbsp;</span></div>
					<div style="float:left"> <a href="http://deboxglobal.com/"><img
								src="<?php echo $fullurl; ?>images/Logo De Boxpng.png" style="width:50px;"></a></div>
				</div>
			</div>
		<?php } ?>
	</div>

</div>

<script type="text/javascript">
	$(window).scroll(function () {
		if ($(this).scrollTop() > 515) {
			$("#trend").addClass("fixed");
		}
		else {
			$("#trend").removeClass("fixed");
		}
	});

</script>