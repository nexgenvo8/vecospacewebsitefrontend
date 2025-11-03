	<?php
	include_once('inc.php');
	include_once('config/session-check.inc.php'); // check user login session
	$pageIndex = 6;

	if ($_REQUEST['g'] != '') {
		$sql_checkmember = "SELECT * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . decodeStr($_REQUEST['g']) . " and userId='" . $_SESSION["sessUserId"] . "' and status=1";
		$rescheckmember = mysqli_query($conn, $sql_checkmember) or die(mysqli_error($conn));
		$mytotalgroups = mysqli_num_rows($rescheckmember);
		if ($mytotalgroups > 0) {
			header('Location:groups.html');
			exit();
		}
	}

	if ($_REQUEST['g'] != '') {
		$sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['g']) . " ";
		$resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
		$rowGroup = mysqli_fetch_array($resgroup);
		$notigroupid = encodeStr($rowGroup['id']);

		if ($rowGroup["groupThumb"] != '') {
			$groupThumb = $rowGroup["groupThumb"];
		} else {
			$groupThumb = 'group.png';
		}
		$mytotalgroups = 0;
		$totalm = "SELECT * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $rowGroup["id"] . " and status=1";
		$retotalm = mysqli_query($conn, $totalm) or die(mysqli_error($conn));
		$mytotalgroups = mysqli_num_rows($retotalm);

		$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowGroup["userId"] . "";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$userres = mysqli_fetch_array($b);
		if ($rowGroup["groupType"] == 1) {
			$notiuserid = encodeStr($userres['userId']);
		} else {
			$notiuserid = encodeStr($_SESSION['sessUserId']);
		}

		$notigroupcontactId = encodeStr($_SESSION['sessUserId']);



	}
	?>
<!DOCTYPE html>
<html>
<head>
<title>Group request - <?php echo $companNameTitle; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
<script src="<?php echo $fullurl; ?>js/ajax-form-post.js"></script>
<script src="<?php echo $fullurl; ?>js/main.js"></script>
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
		<div class="acceptgroup">
			<h2><?php if ($rowGroup["groupType"] == 1) { ?>Private<?php } else { ?>Public<?php } ?> Group</h2>
			<div class="grp-accept-head">
				<div class="img"><img src="<?php echo $fullurl; ?>uploads/<?php echo $groupThumb; ?>"></div>
				<div class="achead-right"><strong><?php echo stripslashes(trim($rowGroup["groupName"])); ?></strong>
				<span><?php echo $mytotalgroups; ?> Members</span>
				</div>
			</div>    		
			<div class="accept-btn-cont">
			<?php if ($_REQUEST['q'] == 1) { ?>
			<div style="font-size:12px; color:#C02621;">Group joining request has been declined</div>
		<?php } ?>
		<?php if ($_REQUEST['q'] != 1) { ?>
					<?php echo $userres['firstName']; ?> 	<?php echo $userres['lastName']; ?> invites you to join this group
					<?php if ($rowGroup["groupType"] == 1) { ?>
						<div class="acbuttons">
							<a href="<?php echo $fullurl; ?>common_action.php?userId=<?php echo $notigroupcontactId; ?>&joinedGroupId=<?php echo $notigroupid; ?>&contactId=<?php echo $notiuserid; ?>&action=actprivategrouprequest&a=1" target="actionfrm" onClick="$('#commonloader').show();" class="active">Accept</a>
							<a href="<?php echo $fullurl; ?>common_action.php?dltGroupId=<?php echo $notigroupid; ?>&action=dltgrouprequest&a=1" target="actionfrm" class="dlt" onClick="$('#commonloader').show();">Decline</a>
						</div>
						<?php
					} else {
						?>
						 <div class="acbuttons">
							<a href="<?php echo $fullurl; ?>common_action.php?userId=<?php echo $notiuserid; ?>&joinedGroupId=<?php echo $notigroupid; ?>&action=actgrouprequest&a=1" target="actionfrm"   onClick="$('#commonloader').show();" class="active">Accept</a>
							<a href="<?php echo $fullurl; ?>common_action.php?userId=<?php echo $notiuserid; ?>&dltGroupId=<?php echo $notigroupid; ?>&action=dltgrouprequest&a=1" target="actionfrm" class="dlt" onClick="$('#commonloader').show();">Decline</a>
						</div>
				 		<?php
					}
					?>
				 <?php } ?>
			</div>
			<?php
			if ($_REQUEST['q'] != 1) {
				if ($rowGroup["groupType"] == 0) { ?>
					<h2>Group Detail</h2>
					<p><?php echo substr(strip_tags(stripslashes(trim($rowGroup["groupDetails"]))), 0, 550); ?></p>
				<?php }
			} ?>
		</div>

	  </div>
	</div>
  </div>
  <?php include('footer.php'); ?>
</div>
<script>
function reloadPage(){
location.reload(true);
}

</script>
</body>
</html>
