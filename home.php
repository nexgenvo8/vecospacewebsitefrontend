<?php
include_once(__DIR__ . '/inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 1;
$_SESSION['useractivity'] = '';

if (
	(empty($coursename) && empty($jobTitle) && empty($departmentname))
	|| empty($companyName)
	|| empty($myfirstName)
	|| empty($mycountryName)
	|| empty($mystateName)
	|| empty($TimeZone)
) {
	header("Location: " . $fullurl . "complete-registration.html");
	exit();
}

$jobTitle = $coursename;

if (isset($_SESSION["sessUserId"]) && !empty($_SESSION["sessUserId"])) {
	$userId = intval($_SESSION["sessUserId"]);

	// Update lastPost
	$sql_ins = "UPDATE " . _USERS_MASTER_TABLE_ . " SET lastPost=0 WHERE userId = $userId";
	if (!mysqli_query($conn, $sql_ins)) {
		die("Error updating lastPost: " . mysqli_error($conn));
	}

	// Check if records exist
	$sql_inss4 = "SELECT id FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE userId = $userId AND postType=0";
	// print_r($sql_inss4);die;
	$resresults4 = mysqli_query($conn, $sql_inss4);
		// print_r($resresults4);die;
	if (!$resresults4) {
		die("Error fetching share updates: " . mysqli_error($conn));
	}
// 
	$gettotalrows = mysqli_num_rows($resresults4);
// print_r($gettotalrows);die;
	if ($gettotalrows == 0) {
		// Delete existing entries
		$sql_del = "DELETE FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE userId = $userId AND postType=0";
		if (!mysqli_query($conn, $sql_del)) {
			die("Error deleting share updates: " . mysqli_error($conn));
		}

		// Insert new entry
		$sql_ins = "INSERT INTO " . _SHAREANDUPDATES_TABLE_ . " SET userId = $userId";
		if (!mysqli_query($conn, $sql_ins)) {
			die("Error inserting share update: " . mysqli_error($conn));
		}
	}

	// Get latest postId
	$sql_inss = "SELECT id FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE userId = $userId AND postType=0 ORDER BY id DESC LIMIT 1";
	$resresults = mysqli_query($conn, $sql_inss);
	if (!$resresults) {
		die("Error fetching latest postId: " . mysqli_error($conn));
	}

	$rowResults = mysqli_fetch_assoc($resresults);

	$postId = $rowResults["id"];
	$jcarousellite = 1;

	// Birthday check query
	$sqlQuery1 = "SELECT dob, userId, firstName, lastName, profilePhoto, userurl 
                  FROM " . _USERS_MASTER_TABLE_ . " 
                  WHERE userId IN (
                      SELECT contactId 
                      FROM " . _CONTACT_MASTER_TABLE_ . " 
                      WHERE userId = $userId AND status=1 AND birthdayStatus=1
                  ) 
                ";
// print_r($sqlQuery1);die;   AND dob != '0000-00-00'

	$resQuery1 = mysqli_query($conn, $sqlQuery1);

	if (!$resQuery1) {
		die("Error fetching birthdays: " . mysqli_error($conn));
	}
// print_r('test');die;
	while ($rowcontacts1 = mysqli_fetch_assoc($resQuery1)) {
		$userdob1 = $rowcontacts1["dob"];
		$userdobArr1 = explode("-", $userdob1);
		$dobyear1 = $userdobArr1[0];
		$dobmonth1 = $userdobArr1[1];
		$dobday1 = $userdobArr1[2];

		$userdob1 = $dobmonth1 . '-' . $dobday1;

		if ($userdob1 != date("m-d")) {
			$sql_ins1 = "UPDATE " . _CONTACT_MASTER_TABLE_ . " 
                         SET birthdayStatus = 0 
                         WHERE contactId = " . intval($rowcontacts1['userId']) . " 
                         AND userId = $userId";

			if (!mysqli_query($conn, $sql_ins1)) {
				die("Error updating birthday status: " . mysqli_error($conn));
			}
		}
	}
} else {
	// sessUserId not set
	header("Location: " . $fullurl . "login.html");
	exit();
}

$industryId = 19999999;
?>
<!DOCTYPE html>
<html>


<head>
	<title><?php echo $companNameTitle; ?></title>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css?id=<?php time(); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
	<link rel="stylesheet" type="text/css"
		href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<script src="<?php echo $fullurl; ?>js/URI.js"></script>
	<script src="<?php echo $fullurl; ?>js/jcarousellite_1.0.1.js"></script>

	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<link href="https://fonts.googleapis.com/css?family=Lovers+Quarrel" rel="stylesheet">

</head>
<!-- Timeline Loading Script -->


<body>
	<div id="wrapper" class="active">
		<?php
		if ($industryId == '' || $industryId == '0') {


			?>
			<div class="selct_popup">
				<div class="popup_cont">
					<h4 class="usrname">Welcome
						<?php echo $_SESSION["sessFname"]; ?>
					</h4>
					<p>Please provide the following detail to get off to a great start on <?php echo $companNameTitle; ?>:
					</p>
					<ul class="steps">
						<li id="stape1" class="active">1</li>
						<li id="stape2">2</li>
						<li id="stape3">3</li>
					</ul>
					<div id="errorMsgBox" class="error-messages" style="display:none;"></div>
					<div class="cntnt_box" id="stepbox"></div>
					<script>
						loadpages('stepbox', 'stepbox.php?step=1');
					</script>
				</div>
			</div>
			<?php
		} else {


			if (isset($_SESSION['sesgroupId']) && $_SESSION['sesgroupId'] != '') {
				$groupId = intval($_SESSION['sesgroupId']);

				$a = "SELECT groupType FROM " . _GROUP_MASTER_TABLE_ . " WHERE id = $groupId LIMIT 1";
				$b = mysqli_query($conn, $a);

				if (!$b) {
					die("MySQLi Error: " . mysqli_error($conn));
				}

				$rowgrouptype = mysqli_fetch_assoc($b);

				if ($rowgrouptype && isset($rowgrouptype["groupType"])) {
					if ($rowgrouptype["groupType"] == 0) {
						header('Location: groups-detail.html?groupId=' . encodeStr($groupId));
						exit();
					} else {
						header('Location: private-group.html?groupId=' . encodeStr($groupId));
						exit();
					}
				} else {
					header('Location: groups.html');
					exit();
				}
			}


			?>



			<?php include('header.php'); ?>
			<div class="container main">
				<div class="home_container">
					<?php include('left-sidebar.php'); ?>
					<div class="center_content">
						<div class="cntr_cntnt">

							<div id="newposton">

								<a href="<?php echo $fullurl; ?>timeline.html">
									<div class="newpostbtn" style="    position: fixed;">New Posts</div>
								</a>
							</div>
							<div class="cntr_cntnt_tab">
								<div class="shareupdate-inner">
									<ul class="cntr_tab" style="display:none;">
										<li><a id="toptabsshare2"
												onClick="topsharetabs(2);$('#uploadphotobtn').show();$('#websitecontentblock').html('');$('#websitecontentblock').hide();$('#linkpasted').val('0');$('#postText').val('');"><i
													class="fa fa-align-left" aria-hidden="true"></i> Highlight of the
												Day</a></li>
										<li><a id="toptabsshare3" href="<?php echo $fullurl; ?>post-article.html"><i
													class="fa fa-file-text-o" aria-hidden="true"></i> Add a Story</a></li>
									</ul>

									<form class="edit-layer" enctype="multipart/form-data" name="frmposthome"
										id="frmposthome" method="post" target="actionfrm"
										action="<?php echo $fullurl; ?>common_action.php">
										<div class="tab_contnt_cont" style="border-radius:7px 7px 0px 0px">
											<div class="tab_contnt" style="position:relative;">

												<div class="hedr" id="myheaderid" style="">
													<div class="prfl_img"> <a
															href="<?php echo $fullurl; ?>myprofile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $userurl; ?>.html"><img
																src="<?php echo $fullurl; ?>uploads/<?php echo $myprofilePhoto; ?>"
																style="border:<?php echo profileborder($usersType); ?>"></a>
													</div>
													<div class="hdr_right"><a
															href="<?php echo $fullurl; ?>myprofile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $userurl; ?>.html"><?php echo $myname; ?></a>
														<label class="time"><?php echo $jobTitle; ?> -
															<?php echo $companyName; ?> </label>
													</div>
												</div>
												<div id="tagcontactdiv" style="display:none;"></div>
												<textarea name="postText" id="postText" placeholder="What's in your mind"
													onKeyUp="showmyheader();" onBlur="showmyheader();"
													onClick="$('#myheaderid').show();"></textarea><input type="hidden"
													name="tageduserid" id="tageduserid" value="">
												<input type="hidden" name="tagedcompanyid" id="tagedcompanyid" value="">
												<div style="display:none;" id="websitecontentblock"></div>
												<input name="linkpasted" id="linkpasted" type="hidden" value="0">
												<div class="upload-img-cont" id="uploadboximage" style="display:none;">
												</div>

											</div>



											<div id="searchtagcontact" style="display:none;">

											</div>
										</div>
										<div class="share_with">
											<div class="upload-img" style="position:relative; display:none;"
												id="uploadphotobtn">
												<div><i class="fa fa-picture-o" aria-hidden="true"></i>Post Picture</div>
												<span id="hpotohomeid">
													<input name="imagefilehome" id="imagefilehome" type="file"
														onChange="homeuploadfun();"
														style="position:absolute; left:0px; top:0px; width:100%; height:100%;cursor: pointer; opacity: 0; filter: alpha(opacity=0); "
														accept="image/x-png,image/gif,image/jpeg"></span>
											</div>
											<script>
												function homeuploadfun() {
													$('#frmposthome').submit();
													$('#commonloader').show();

													var hpotohomeid = $('#hpotohomeid').html();

													$('#imagefilehome').remove();
													$('#hpotohomeid').html(hpotohomeid);
													$('#imgyes').val('1');
												}
											</script>
											<button type="submit" onClick="$('#postpost').val(1);">Post</button>
											<select name="shareType" id="shareType">
												<option value="1">Public</option>
												<option value="2">My Contacts</option>
											</select>



											<input type="hidden" name="postType" id="postType" value="1">
											<input type="hidden" name="imgyes" id="imgyes" value="0">
											<input type="hidden" name="postId" id="postId" value="<?php echo $postId; ?>">

											<input type="hidden" name="postpost" id="postpost" value="0">

										</div>
									</form>
								</div>


								<div class="timeline_cont">
									<script>
										topsharetabs(2); $('#uploadphotobtn').show(); $('#websitecontentblock').html(''); $('#websitecontentblock').hide(); $('#linkpasted').val('0'); $('#postText').val('');
									</script>
									<div id="loadtimeline1">
										Loading...
									</div>

								</div>
							</div>
						</div>
						<?php  include('right-sidebar.php'); ?>
					</div>
				</div>
			</div>
			<?php include('footer.php'); ?>
		</div>

		<?php
		}
		?>


	<script>

		function tagthisuser(name, id, keyword) {
			$("#tagcontactdiv").show();
			$("#tagcontactdiv").append('<div id="t' + id + '" class="tag">' + name + ' <i class="fa fa-times" aria-hidden="true" onClick="removetag(' + id + ');"></i></div>');
			$("#searchtagcontact").hide();

			var postText = $("#postText").val();
			postText = postText.replace("@" + keyword, "");

			$("#postText").val(postText);

			var tageduserid = $("#tageduserid").val();
			tageduserid = tageduserid + "'" + id + "',";
			$("#tageduserid").val(tageduserid);

		}

		function tagthiscompnay(name, id, keyword) {
			$("#tagcontactdiv").show();
			$("#tagcontactdiv").append('<div id="t' + id + '" class="tag">' + name + ' <i class="fa fa-times" aria-hidden="true" onClick="removetag(' + id + ');"></i></div>');
			$("#searchtagcontact").hide();

			var postText = $("#postText").val();
			postText = postText.replace("@" + keyword, "");

			$("#postText").val(postText);

			var tageduserid = $("#tagedcompanyid").val();
			tageduserid = tageduserid + "'" + id + "',";
			$("#tagedcompanyid").val(tageduserid);

		}


		function removetag(id) {
			var tageduserid = $("#tageduserid").val();
			tageduserid = tageduserid.replace("'" + id + "',", "");
			$("#tageduserid").val(tageduserid);
			$("#t" + id).remove();
		}

		/*
		function showmyheader()
		{
		
		 var postText = $("#postText").val();
		 if(postText!='')
		 {
			  $("#myheaderid").show();
		 }
		 else
		 {
			  $("#myheaderid").hide();
		 }
		
		}
		*/

		function addhttp(url) {
			if (!/^(f|ht)tps?:/i.test(url)) {
				url = "http://" + url;
			}
			return url;
		}

		function gettag(content) {

			var tageduserid = $("#tageduserid").val();
			var tagedcompanyid = $("#tagedcompanyid").val();

			var data = content; var arr = data.split('@');
			if (arr[1] != '') {
				$("#searchtagcontact").load('searchtagcontact.php?keyword=' + arr[1] + '&tageduserid=' + tageduserid + '&tagedcompanyid=' + tagedcompanyid);
			}

		}


			/* function getsitecontent() {
		var sitecontent = $('#postText').val();
		gettag(sitecontent);

		var linkpasted = $('#linkpasted').val();
		var detectedUrl = '';

		URI.withinString(sitecontent, function (url) {
			detectedUrl = url;
		});

		if (detectedUrl == '') return;
		if (linkpasted == 1) return;

		$('#linkpasted').val(1);

		$('#websitecontentblock').show();
		$('#websitecontentblock').html('<div style="text-align:center;margin-bottom: 10px;"><img src="images/mainloading.gif"></div>');

		$('#websitecontentblock').load('getwebsitecontent.php?viewpostid=<?php echo encodeStr($postId); ?>&url=' + encodeURIComponent(detectedUrl));
	}
 */
		/* $('#frmposthome').on('submit', function () {
		var txt = $('#postText').val();

		// remove all URLs from text
		txt = txt.replace(/https?:\/\/[^\s]+/gi, '');
		txt = txt.replace(/www\.[^\s]+/gi, '');

		$('#postText').val(txt.trim());
	}); */
		$(document).ready(function () {
			loadtimeline(1, 0, 20);
		});


		function countpostview(id) {
			$('#commonaction').load('common_action.php?action=allpostview&postId=' + id);
		}

		document.getElementById("postText").onpaste = function () { setTimeout(function () { getsitecontent(); showmyheader(); }, 500); }


		function reloadPage() {
			location.reload(true);
		}

		loadtimeline(1, 0, 20);

		function postlikeunlike(id) {
			var color1 = 'rgb(255, 120, 0)';
			var color2 = 'rgb(128, 128, 128)';
			var crname = $('#thumbid' + id).css('color');
			if (crname == color1) {
				$('#thumbid' + id).css('color', color2);
			}
			else {
				$('#thumbid' + id).css('color', color1);
			}
		}
	</script>
</body>

</html>