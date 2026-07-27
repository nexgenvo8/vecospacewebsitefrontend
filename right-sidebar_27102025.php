<?php if ($jcarousellite != 1) { ?>
	<script src="<?php echo $fullurl; ?>js/jcarousellite_1.0.1.js"></script>
<?php } ?>
<div class="hm_right_sec">
	<div class="showcurrentright">
		<?php echo date('l, j F Y'); ?>
	</div>
	 

	<?php
	if ($ps != 1) {
		if ($msg != 1) { ?>
			<?php


			?>
			 
			<div class="right-box-cont">
				<div class="suggest-box">
					<h2>Notice Board</h2>
					<ul class="trending-list">
						<?php
						unset($selectFields);
						unset($whereFields);
						unset($whereVals);

						$sqlViewArticle2 = "";
						$sqlViewArticle2 = "SELECT * from noticeboard ORDER BY id desc LIMIT 0,5 ";
						$resViewArticle2 = getRecords('noticeboard', $selectFields, $whereFields, $whereVals, _Y_, $sqlViewArticle2);
						if ($resViewArticle2) {
							while ($rowViewArticle2 = mysqli_fetch_array($resViewArticle2)) {
						?>
								<li style="cursor:pointer; padding-left: 0 !important;" onclick="window.location.href = '<?php echo $fullurl; ?>view-notice.html?postId=<?php echo encodeStr($rowViewArticle2['id']); ?>';">
									<!--<div class="artcl-img"><img src="<?php echo $fullurl; ?>uploads/<?php echo $profilePhoto; ?>"></div>-->
									<a class="ttle"><?php echo substr((stripslashes(trim($rowViewArticle2["title"]))), 0, 5000); ?></a>
									<span class="desc"><?php echo substr(strip_tags(stripslashes(trim($rowViewArticle2["detail"]))), 0, 6000); ?></span>
									<span class="nm">Notice Date <?php echo date('d M, Y', $rowViewArticle2["dateAdded"]); ?></span>
								</li>
						<?php
							}
						}

						?>


					</ul>
					<div style="text-align:right;"><a href="<?php echo $fullurl; ?>all-notice.html">View More</a></div>
				</div>
			</div>
		<?php  }
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
					unset($selectFields);
					unset($whereFields);
					unset($whereVals);

					$sqlViewArticle2 = "";
					$sqlViewArticle2 = "select * from " . _USERS_MASTER_TABLE_ . " where activeYN='Y' and jobTitle='" . $jobTitle . "' and userId!=" . decodeStr($_GET['id']) . " and userId not  in (select contactId from " . _CONTACT_MASTER_TABLE_ . " where userId=" . $userwhereid . " and status=1) and companyName!='' and userId!='" . $userwhereid . "' " . $strWhereContacts . " ORDER BY RAND()  LIMIT 0,5";
					$resViewArticle2 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlViewArticle2);
					if ($resViewArticle2) {
						while ($rowViewArticle2 = mysqli_fetch_array($resViewArticle2)) {

							$fl = 1;
							$a2 = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowViewArticle2["userId"] . "";
							$b2 = mysqli_query($a2) or die(mysqli_error($conn));
							$userres2 = mysqli_fetch_array($b2);
							$friendnameurl = $userres2['userurl'];
							if ($userres2["profilePhoto"] != '') {
								$profilePhoto = $userres2["profilePhoto"];
							} else {
								$profilePhoto = 'user-placeholder.jpg';
							}
					?>
							<li style="cursor:pointer;" onclick="window.location.href = '<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2['userId']); ?>/<?php echo $friendnameurl; ?>.html';">
								<div class="artcl-img"><img src="<?php echo $fullurl; ?>uploads/<?php echo $profilePhoto; ?>"></div>
								<a class="ttle"><?php echo stripslashes(trim($userres2["firstName"])); ?> <?php echo stripslashes(trim($userres2["lastName"])); ?></a>
								<span class="nm"><?php echo $userres2['jobTitle']; ?> at <?php echo $userres2['companyName']; ?></span>
							</li>
							<?php
							$s++;
						}
					}






					if ($s == 1) {
						unset($selectFields);
						unset($whereFields);
						unset($whereVals);
						$l2 = 0;
						$sqlViewArticle2 = "";
						$sqlViewArticle2 = "select * from " . _USERS_MASTER_TABLE_ . " where activeYN='Y' and cityName='" . $mystateName . "' and userId!=" . decodeStr($_GET['id']) . " and userId not  in (select contactId from " . _CONTACT_MASTER_TABLE_ . " where userId=" . $userwhereid . " and status=1) and companyName!='' and userId!='" . $userwhereid . "' " . $strWhereContacts . " ORDER BY RAND() LIMIT 0,5";
						$resViewArticle2 = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlViewArticle2);
						if ($resViewArticle2) {
							while ($rowViewArticle2 = mysqli_fetch_array($resViewArticle2)) {
								$l2 = 1;
								$a2 = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowViewArticle2["userId"] . "";
								$b2 = mysqli_query($a2) or die(mysqli_error($conn));
								$userres2 = mysqli_fetch_array($b2);
								$friendnameurl = $userres2['userurl'];
								if ($userres2["profilePhoto"] != '') {
									$profilePhoto = $userres2["profilePhoto"];
								} else {
									$profilePhoto = 'user-placeholder.jpg';
								}
							?>
								<li style="cursor:pointer;" onclick="window.location.href = '<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2['userId']); ?>/<?php echo $friendnameurl; ?>.html';">
									<div class="artcl-img"><img src="<?php echo $fullurl; ?>uploads/<?php echo $profilePhoto; ?>"></div>
									<a class="ttle"><?php echo stripslashes(trim($userres2["firstName"])); ?> <?php echo stripslashes(trim($userres2["lastName"])); ?></a>
									<span class="nm"><?php echo $userres2['jobTitle']; ?> at <?php echo $userres2['companyName']; ?></span>
								</li>
					<?php

							}
						}
					}
					?>


				</ul>
			</div>
		</div>
	<?php
	}
	?>

	<div class="showcurrentright" style="font-size:17px !important;">
		University Placement Cell
	</div>

	<div id="trend">


		<?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
			<div class="right-fttr">
				<ul class="fttr-list">
					<li><a href="<?php echo $fullurl; ?>privacy.html" target="_blank">Privacy</a></li>
					<li><a href="<?php echo $fullurl; ?>terms.html" target="_blank">Terms</a></li>
					<li><a href="<?php echo $fullurl; ?>about.html" target="_blank">About</a></li>
					<li><a href="<?php echo $fullurl; ?>faq.html" target="_blank">FAQ's</a></li>
				</ul>
				<p> &copy; <?php echo date("Y"); ?>&nbsp;Jamia Millia Islamia VECOSPACE</p>
				<div class="pwrddebox">
					<div style="float:left"><span style="color: #9f9f9f;">Powered by &nbsp;&nbsp;&nbsp;</span></div>
					<div style="float:left"> <a href="http://deboxglobal.com/"><img src="<?php echo $fullurl; ?>images/Logo De Boxpng.png" style="width:50px;"></a></div>
				</div>
			</div>
		<?php } ?>
	</div>

</div>

<script type="text/javascript">
	$(window).scroll(function() {
		if ($(this).scrollTop() > 515) {
			$("#trend").addClass("fixed");
		} else {
			$("#trend").removeClass("fixed");
		}
	});
</script>