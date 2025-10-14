<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$keyword = clean($_REQUEST['keywordsearch']);

if ($keyword != '') {

	?>
	<script>
		$("#showsearchbox").show();
	</script>
	<?php

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];
	$sqlSearch = "";

	$sqlSearch = "select * from " . _USERS_MASTER_TABLE_ . " where userId IN (SELECT userId from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE allowSearchEngines=1) and (firstName like '%" . $keyword . "%' OR lastName like '%" . $keyword . "%') and userId!=" . $_SESSION['sessUserId'] . " and activeYN='Y' and userId!=106 and companyName!='' LIMIT 0,5";

	$resSearch = mysqli_query($conn, $sqlSearch) or die(mysqli_error($conn));
	$records1 = mysqli_num_rows($resSearch);
	if ($records1 > 0) {
		$s = 1;
		?>
		<div class="topsearchheader">Contacts</div>
		<?php
		while ($rowSearch = mysqli_fetch_array($resSearch)) {

			$friendnameurl = $rowSearch['userurl'];
			if ($rowSearch["profilePhoto"] != '') {
				$userphoto = $rowSearch["profilePhoto"];
			} else {
				$userphoto = 'user-placeholder.jpg';
			}

			?>
			<div class="topsearchlist"
				onclick="location.href='<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowSearch['userId']); ?>/<?php echo $friendnameurl; ?>.html';">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="1%">
							<div
								style="width:35px;    border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
								<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"
									width="100%">
							</div>
						</td>
						<td width="99%">
							<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
								<?php echo $rowSearch['firstName']; ?>
								<?php echo $rowSearch['lastName']; ?>
							</div>
							<div style="font-size:12px; color:#9a9a9a;"><?php echo $rowSearch["jobTitle"]; ?> at
								<?php echo $rowSearch["companyName"]; ?>
							</div>
						</td>
					</tr>
				</table>

			</div>
			<?php
		}
	}
	?>



	<?php

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlGroup = "";
	$sqlGroup = "select * from " . _GROUP_MASTER_TABLE_ . " WHERE userId IN (SELECT userId from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE postGroupSearchEngine=1) and (groupName like '%" . $keyword . "%') and  groupType=0 and status=0 and userGroupStatus=1  LIMIT 0,5";
	$resGroup = mysqli_query($conn, $sqlGroup) or die(mysqli_error($conn));
	$mytotalgroups = mysqli_num_rows($resGroup);
	if ($mytotalgroups > 0) {
		$s = 1;
		?>
		<div class="topsearchheader">Groups</div>
		<?php

		while ($rowgroup = mysqli_fetch_array($resGroup)) {

			$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $rowgroup["id"] . "";
			$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
			$row = mysqli_fetch_array($resgroup);

			if ($row["groupThumb"] != '') {
				$groupThumb = $row["groupThumb"];
			} else {
				$groupThumb = 'group.png';
			}

			$totalgroupmembers = 0;
			$sqlGroupTotal = "";
			$sqlGroupTotal = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " where groupId='" . $row["id"] . "' and status=1 ";
			$resGroupTotal = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupTotal);
			if ($resGroupTotal) {
				$totalgroupmembers = mysqli_num_rows($resGroupTotal);
			}

			?>
			<div class="topsearchlist"
				onclick="location.href='<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($rowgroup['id']); ?>';">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="1%">
							<div
								style="width:35px;    border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
								<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>"
									width="100%">
							</div>
						</td>
						<td width="99%">
							<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
								<?php echo stripslashes(trim($row["groupName"])); ?>
							</div>
							<div style="font-size:12px; color:#9a9a9a;">Members (<?php echo $totalgroupmembers; ?>)</div>
						</td>
					</tr>
				</table>

			</div>
			<?php

		}
	}
	?>



	<?php
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlCompany = "";
	$sqlCompany = "select * from " . _COMPANY_MASTER_TABLE_ . " where (companyName like '%" . $keyword . "%' OR companyTypeId IN(SELECT id from " . _OPTION_MASTER_TABLE_ . " WHERE optionName like '%" . $keyword . "%' ))  and status=0 order by id desc LIMIT 0,5 ";
	$resCompany = mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn));
	$mytotalCompany = mysqli_num_rows($resCompany);
	if ($mytotalCompany > 0) {
		$s = 1;
		?>
		<div class="topsearchheader">Companies</div>
		<?php
		while ($rowCompany = mysqli_fetch_array($resCompany)) {
			$companyPhoto = '';
			$companyTypeName = '';
			if ($rowCompany["companyTypeId"] != 0 && $rowCompany["companyTypeId"] != '') {
				$a = "SELECT * from " . _OPTION_MASTER_TABLE_ . " WHERE id= " . $rowCompany["companyTypeId"] . "";
				$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
				$rowCompanyTypeName = mysqli_fetch_array($b);
				$companyTypeName = $rowCompanyTypeName["optionName"];
			}

			if ($rowCompany['id'] != 0 && $rowCompany['id'] != '') {
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
			<div class="topsearchlist"
				onclick="location.href='<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo encodeStr($rowCompany['id']); ?>';">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="1%">
							<div
								style="width:35px;    border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
								<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>"
									title="<?php echo stripslashes($rowCompany["companyName"]); ?>" width="100%">
							</div>
						</td>
						<td width="99%">
							<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
								<?php echo getStrLength(strip_tags(stripslashes($rowCompany["companyName"])), 42); ?>
							</div>
							<div style="font-size:12px; color:#9a9a9a;"><?php echo stripslashes($companyTypeName); ?></div>
						</td>
					</tr>
				</table>

			</div>
			<?php

		}
	}
	?>


	<?php
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$articlephoto = '';
	$sqlLatestArticle = "";
	$sqlLatestArticle = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId IN (SELECT userId from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE postGroupSearchEngine=1) and (postTitle like '%" . $keyword . "%')  and postType=3 and articleBlogStatus=0 ORDER BY postTitle LIMIT 0,5 ";
	$resLatestArticle = mysqli_query($conn, $sqlLatestArticle) or die(mysqli_error($conn));
	$mytotalArticle = mysqli_num_rows($resLatestArticle);
	if ($mytotalArticle > 0) {
		$s = 1;
		?>
		<div class="topsearchheader">Artcles and Trivia</div>
		<?php
		while ($rowLatestArticle = mysqli_fetch_array($resLatestArticle)) {

			$a = "";
			$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLatestArticle["userId"] . "";
			$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
			$userres = mysqli_fetch_array($b);

			$aimg = "select * from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $rowLatestArticle['id'] . " and imageType=3";
			$bimg = mysqli_query($conn, $aimg) or die(mysqli_error($conn));
			$rowimg = mysqli_fetch_array($bimg);

			if ($rowimg['imageName'] != '') {
				$articlephoto = $rowimg['imageName'];
			} else {
				$articlephoto = 'articleicon.png';
			}




			?>
			<div class="topsearchlist"
				onclick="location.href='<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowLatestArticle['id']); ?>';">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="1%">
							<div
								style="width:35px;    border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
								<img src="<?php echo $fullurl; ?>uploads/<?php echo $articlephoto; ?>"
									title="<?php echo stripslashes($rowLatestArticle["postTitle"]); ?>" width="100%"
									style="min-height:100%;">
							</div>
						</td>
						<td width="99%">
							<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
								<?php echo getStrLength(strip_tags(stripslashes($rowLatestArticle["postTitle"])), 42); ?>
							</div>
							<div style="font-size:12px; color:#9a9a9a;">By <?php echo stripslashes(trim($userres["firstName"])); ?>
								<?php echo stripslashes(trim($userres["lastName"])); ?>
							</div>
						</td>
					</tr>
				</table>

			</div>
			<?php

		}
	}
	?>

	<?php
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlFeaturedEvents = "";
	$sqlFeaturedEvents = "select * from " . _EVENT_MASTER_TABLE_ . " where eventStatus=1 and (eventName like '%" . $keyword . "%') order by id desc LIMIT 0,5 ";
	$resFeaturedEvents = mysqli_query($conn, $sqlFeaturedEvents) or die(mysqli_error($conn));
	$mytotalEvents = mysqli_num_rows($resFeaturedEvents);
	if ($mytotalEvents > 0) {
		$s = 1;
		?>
		<div class="topsearchheader">Events</div>
		<?php
		while ($rowFeaturedEvents = mysqli_fetch_array($resFeaturedEvents)) {
			$eventphoto = '';
			if ($rowFeaturedEvents["eventThumb"] != '') {
				$eventphoto = $rowFeaturedEvents["eventThumb"];
			} else {
				$eventphoto = 'events-placeholder.jpg';
			}
			?>
			<div class="topsearchlist"
				onclick="location.href='<?php echo $fullurl; ?>events-detail.html?eventId=<?php echo encodeStr($rowFeaturedEvents['id']); ?>';">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="1%">
							<div
								style="width:35px;    border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
								<img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($eventphoto)); ?>"
									title="<?php echo stripslashes($rowFeaturedEvents["eventName"]); ?>" width="100%"
									style="min-height:100%;">
							</div>
						</td>
						<td width="99%">
							<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
								<?php echo getStrLength(stripslashes($rowFeaturedEvents["eventName"]), 36); ?>
							</div>
							<div style="font-size:12px; color:#9a9a9a;">
								<?php $strstrtdate = strtotime($rowFeaturedEvents["eventDate"]);
								echo date("j M", $strstrtdate); ?> -
								<?php $strenddate = strtotime($rowFeaturedEvents["eventTillDate"]);
								echo date("j M Y", $strenddate); ?>
								<?php echo stripslashes(strip_tags($rowFeaturedEvents["eventVenue"])); ?>
								<?php echo stripslashes($rowFeaturedEvents["eventCountryAddress"]); ?>
							</div>
						</td>
					</tr>
				</table>

			</div>
			<?php

		}
	}
	?>
	<?php
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlProjects = "";
	$sqlProjects = "SELECT * from " . _PROJECT_MASTER_TABLE_ . " WHERE (projectTitle like '%" . $keyword . "%' OR proCity like '%" . $keyword . "%' OR proCountry like '%" . $keyword . "%' OR proNature like '%" . $keyword . "%' OR proSkills like '%" . $keyword . "%') and  status=1  and finalPost=1 and projectStatus=1 ORDER BY projectTitle LIMIT 0,5 ";
	$resProjects = mysqli_query($conn, $sqlProjects) or die(mysqli_error($conn));
	$mytotalProjects = mysqli_num_rows($resProjects);
	if ($mytotalProjects > 0) {
		$s = 1;
		?>
		<div class="topsearchheader">Projects</div>
		<?php
		while ($rowProjects = mysqli_fetch_array($resProjects)) {

			$a = "";
			$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowProjects["userId"] . "";
			$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
			$userres = mysqli_fetch_array($b);

			?>
			<div class="topsearchlist"
				onclick="location.href='<?php echo $fullurl; ?>preview-project.html?projId=<?php echo encodeStr($rowProjects['id']); ?>';">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="100%">
							<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
								<?php echo getStrLength(strip_tags(stripslashes($rowProjects["projectTitle"])), 42); ?>
							</div>
							<div style="font-size:12px; color:#9a9a9a;">By <?php echo stripslashes(trim($userres["firstName"])); ?>
								<?php echo stripslashes(trim($userres["lastName"])); ?>
							</div>
						</td>
					</tr>
				</table>

			</div>
			<?php

		}
	}
	?>

	<?php
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];


	$sqlSmb = "";
	$sqlSmb = "SELECT id,companyBusinessName,completeAddress,shortDescription,fileUploaded,userId from " . _BUSINESS_MASTER_TABLE_ . " WHERE (companyBusinessName like '%" . $keyword . "%' OR cityName like '%" . $keyword . "%' OR completeAddress like '%" . $keyword . "%' OR contactPerson like '%" . $keyword . "%' OR postalCode like '%" . $keyword . "%') ORDER BY companyBusinessName LIMIT 0,5 ";
	$resSmb = mysqli_query($conn, $sqlSmb) or die(mysqli_error($conn));
	$mytotalSmb = mysqli_num_rows($resSmb);
	if ($mytotalSmb > 0) {
		$s = 1;
		?>
		<div class="topsearchheader">SME Connect</div>
		<?php
		while ($rowSmb = mysqli_fetch_array($resSmb)) {

			$a = "";
			$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowSmb["userId"] . "";
			$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
			$userres = mysqli_fetch_array($b);

			$companyPhoto = '';
			if ($rowSmb["fileUploaded"] != '') {
				$companyPhoto = $rowSmb["fileUploaded"];
			} else {
				$companyPhoto = 'businessimg.png';
			}
			?>
			<div class="topsearchlist"
				onclick="location.href='<?php echo $fullurl; ?><?php echo _SMBURL_TEXT_; ?>/<?php echo encodeStr($rowSmb['id']); ?>/<?php echo makeContentUrl($rowSmb['companyBusinessName']); ?>.html';">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="1%">
							<div
								style="width:35px;    border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
								<img src="<?php echo $fullurl; ?>uploads/<?php echo $companyPhoto; ?>"
									title="<?php echo stripslashes($rowSmb["companyBusinessName"]); ?>" width="100%"
									style="min-height:100%;">
							</div>
						</td>
						<td width="99%">
							<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
								<?php echo getStrLength(strip_tags(stripslashes($rowSmb["companyBusinessName"])), 42); ?>
							</div>
							<div style="font-size:12px; color:#9a9a9a;">By <?php echo stripslashes(trim($userres["firstName"])); ?>
								<?php echo stripslashes(trim($userres["lastName"])); ?>
							</div>
						</td>
					</tr>
				</table>

			</div>
			<?php

		}
	}
	?>

	<?php
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];


	$sqlTalent = "";
	$sqlTalent = "SELECT * from " . _TALENT_MASTER_TABLE_ . " WHERE (talentName like '%" . $keyword . "%' OR shortDescription like '%" . $keyword . "%' OR longDescription like '%" . $keyword . "%') ORDER BY talentName LIMIT 0,5 ";
	$resTalent = mysqli_query($conn, $sqlTalent) or die(mysqli_error($conn));
	$mytotalTalent = mysqli_num_rows($resTalent);
	if ($mytotalTalent > 0) {
		$s = 1;
		?>
		<div class="topsearchheader">Talent Connect</div>
		<?php
		while ($rowTalent = mysqli_fetch_array($resTalent)) {

			$talentProfilePhoto = '';
			if ($rowTalent["talentProfilePhoto"] != '') {
				$talentProfilePhoto = $rowTalent["talentProfilePhoto"];
			} else {
				$talentProfilePhoto = 'talentimgthumb.png';
			}
			?>
			<div class="topsearchlist"
				onclick="location.href='<?php echo $fullurl; ?>talent-profile-detail.html?id=<?php echo encodeStr($rowTalent['id']); ?>';">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="1%">
							<div
								style="width:35px;    border-radius: 50%; height:35px; overflow:hidden; border:1px solid #ccc; margin-right:10px;">
								<img src="<?php echo $fullurl; ?>uploads/<?php echo $talentProfilePhoto; ?>"
									title="<?php echo stripslashes($rowTalent["talentName"]); ?>" width="100%"
									style="min-height:100%;">
							</div>
						</td>
						<td width="99%">
							<div style=" font-size:14px; font-weight:bold; margin-bottom:5px;">
								<?php echo getStrLength(strip_tags(stripslashes($rowTalent["talentName"])), 42); ?>
							</div>
							<div style="font-size:12px; color:#9a9a9a;">
								<?php echo getStrLength(strip_tags(stripslashes($rowTalent["shortDescription"])), 85); ?>
							</div>
						</td>
					</tr>
				</table>

			</div>
			<?php

		}
	}
	?>



	<?php
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];


	$sqlJobs = "";
	$sqlJobs = "SELECT * from " . _JOBS_MASTER_TABLE_ . " WHERE status=1 and jobStatus=1 and (jobTitle like '%" . $keyword . "%' OR jobDetails like '%" . $keyword . "%' OR jobLocation like '%" . $keyword . "%') ORDER BY jobTitle LIMIT 0,5 ";
	$resJobs = mysqli_query($conn, $sqlJobs) or die(mysqli_error($conn));
	$mytotalJobs = mysqli_num_rows($resJobs);
	if ($mytotalJobs > 0) {
		$s = 1;
		?>
		<div class="topsearchheader">Jobs</div>
		<?php
		while ($rowJobs = mysqli_fetch_array($resJobs)) {

			?>
			<div class="topsearchlist"
				onclick="location.href='<?php echo $fullurl; ?>view-job.html?id=<?php echo encodeStr($rowJobs['id']); ?>';">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td width="99%">
							<div style="font-size:12px; font-weight:bold; margin-bottom:5px;">
								<?php echo stripslashes(trim($rowJobs["jobTitle"])); ?>
							</div>
							<div style="font-size:12px;margin-bottom:5px;"><i class="fa fa-map-marker" aria-hidden="true"
									style="color: #3294c3; font-size: 14px; margin-right: 5px;"></i>
								<?php echo stripslashes(trim($rowJobs["jobLocation"])); ?></div>
							<div style="font-size:12px; color:#9a9a9a;">
								<?php echo getStrLength(strip_tags(stripslashes($rowJobs["jobDetails"])), 85); ?>
							</div>
						</td>
					</tr>
				</table>

			</div>
			<?php

		}
	}
	?>
	<?php
	if (isset($s) && $s == 1) {
		?>
		<div style="padding:6px; color:#1a94c3; text-align:center; cursor:pointer;"
			onclick="location.href='<?php echo $fullurl; ?>search.html?keywordsearch=<?php echo $keyword; ?>';">See all results
			for <?php echo $keyword; ?></div>
		<?php
	} else {
		?>
		<div style="padding:6px; background-color:#fff; color:#111; text-align:center;">No result found for
			<?php echo $keyword; ?>
		</div>
	<?php } ?>


	<?php
} else {
	?>
	<script>
		$("#showsearchbox").hide();
	</script>
	<?php
}
?>

<style type="text/css">
	#showsearchbox {
		box-shadow: 0 0 0 1px rgba(0, 0, 0, .1), 0 6px 9px rgba(0, 0, 0, .2) !important;
	}
</style>