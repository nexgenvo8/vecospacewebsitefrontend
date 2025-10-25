<?php
include_once('../inc.php');
if (trim($_REQUEST["myId"]) != '' && trim($_REQUEST["myId"]) != 0) {

	$sql_inss4 = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId=" . $_REQUEST["myId"] . "";
	$res = mysql_query($sql_inss4) or die(mysql_error());
	$getuserdetails = mysql_fetch_array($res);

	$userids = encodeStr($_REQUEST["myId"]);
	$userurlshare = $getuserdetails["userurl"];
	$userprofilePhoto = $getuserdetails["profilePhoto"];
	$userfullname = $getuserdetails["firstName"] . ' ' . $getuserdetails["lastName"];
	$userjobTitle = $getuserdetails["jobTitle"];
	$usercompanyName = $getuserdetails["companyName"];


	$url = $_GET['u'];


	$sql_inss4 = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_REQUEST["myId"] . " AND postType=0";
	$resresults4 = mysql_query($sql_inss4) or die(mysql_error());
	$gettotalrows = mysql_num_rows($resresults4);

	if ($gettotalrows > 0) {

	} else {

		$sql_ins = "INSERT INTO " . _SHAREANDUPDATES_TABLE_ . " SET userId= " . $_REQUEST["myId"] . "";
		$resresult2 = mysql_query($sql_ins) or die(mysql_error());

	}

	$sql_inss = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_REQUEST["myId"] . " AND postType=0";
	$resresults = mysql_query($sql_inss) or die(mysql_error());
	$rowResults = mysql_fetch_array($resresults);
	$postId = $rowResults["id"];

} else {
	if (!isset($_SESSION["sessUserId"]) || $_SESSION["sessUserId"] == '' || $_SESSION["sessUserId"] == 0 || !is_numeric($_SESSION["sessUserId"])) {

		$_SESSION['shareredirecturl'] = 'https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];


		header("location:" . $fullurl . "");
		exit();
	} else {
		$_SESSION['shareredirecturl'] = '';
	}



	$userids = encodeStr($_SESSION['sessUserId']);
	$userurlshare = $userurl;
	$userprofilePhoto = $myprofilePhoto;
	$userfullname = $myname;
	$userjobTitle = $jobTitle;
	$usercompanyName = $companyName;




	$url = $_GET['u'];


	$sql_inss4 = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND postType=0";
	$resresults4 = mysql_query($sql_inss4) or die(mysql_error());
	$gettotalrows = mysql_num_rows($resresults4);

	if ($gettotalrows > 0) {

	} else {

		$sql_ins = "INSERT INTO " . _SHAREANDUPDATES_TABLE_ . " SET userId= " . $_SESSION["sessUserId"] . "";
		$resresult2 = mysql_query($sql_ins) or die(mysql_error());

	}





	$sql_inss = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND postType=0";
	$resresults = mysql_query($sql_inss) or die(mysql_error());
	$rowResults = mysql_fetch_array($resresults);
	$postId = $rowResults["id"];

}


?>
<!DOCTYPE html>
<html>

<head>
	<title>Share news on ConnecWRK</title>
	<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
	<link rel="stylesheet" type="text/css"
		href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
	<script src="<?php echo $fullurl; ?>js/main.js"></script>
	<script src="<?php echo $fullurl; ?>js/URI.js"></script>
</head>

<body style="background-color: #fff;background-image: inherit;">
	<div id="wrapper">

		<div class="shareupdate-inner">
			<div style="padding:10px; border-bottom:2px #CCCCCC solid; text-align:center;"><img
					src="<?php echo $fullurl; ?>images/alumni-alumni-logo.png" width="193"></div>

			<form class="edit-layer sharemobile" enctype="multipart/form-data" name="frmposthome" id="frmposthome"
				method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php"
				style="width:512px; margin:auto;">

				<div id="mainpage">

					<div class="tab_contnt_cont" style="border-radius:0 0 2px 2px">
						<div class="tab_contnt" style="position:relative;">

							<div class="hedr" id="myheaderid" style="display:none;">
								<div class="prfl_img"><img
										src="<?php echo $fullurl; ?>uploads/<?php echo $userprofilePhoto; ?>"> </div>
								<div class="hdr_right"><?php echo $userfullname; ?>

									<label class="time"><?php echo $userjobTitle; ?> - <?php echo $usercompanyName; ?>
									</label>

								</div>
							</div>
							<div id="tagcontactdiv" style="display:none;"></div>
							<textarea name="postText" id="postText" placeholder="Share an update, article or news"
								onKeyUp="getsitecontent(); showmyheader();" onBlur="showmyheader();"
								onClick="$('#myheaderid').show();"><?php echo $url; ?></textarea><input type="hidden"
								name="tageduserid" id="tageduserid" value="">
							<input type="hidden" name="tagedcompanyid" id="tagedcompanyid" value="">
							<div style="display:none;" id="websitecontentblock">asdfasdfasdfasdf</div>
							<input name="linkpasted" id="linkpasted" type="hidden" value="0">
							<input name="action" id="action" type="hidden" value="webshare">
							<div class="upload-img-cont" id="uploadboximage" style="display:none;">
							</div>

						</div>



						<div id="searchtagcontact" style="display:none;">

						</div>
					</div>
					<div class="share_with">
						<div class="upload-img" style="position:relative; display:none;" id="uploadphotobtn">
							<div><i class="fa fa-picture-o" aria-hidden="true"></i> Upload Photo</div>
							<span id="hpotohomeid">
								<input name="imagefilehome" id="imagefilehome" type="file" onChange="homeuploadfun();"
									style=" position:absolute; left:0px; top:0px; width:100%; height:100%;cursor: pointer; opacity: 0; filter: alpha(opacity=0); "
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



						<input type="hidden" name="postType" id="postType" value="2">
						<input type="hidden" name="imgyes" id="imgyes" value="0">
						<input type="hidden" name="postId" id="postId" value="<?php echo $postId; ?>">

						<input type="hidden" name="postpost" id="postpost" value="0">

						<input type="hidden" name="webpageredirect" id="webpageredirect" value="0">

					</div>
				</div>
			</form>
			<div style="padding:10px; background-color:#e6f8dd; color:#333333; display:none;" id="msg">Great! You have
				successfully shared this update.</div>
			<div
				style="text-align:center; font-size:12px; margin-top:20px;  padding:0 10px; line-height:20px; padding-bottom:10px; clear: both;">
				<div
					style="border-bottom: dotted 1px #e7e7e7; padding-bottom: 5px; max-width: 512px; margin: auto; margin-bottom: 10px;">
					<a onClick="closewindow();"><?php if (trim($_REQUEST["myId"]) != '' && trim($_REQUEST["myId"]) != 0) {
					} else { ?><strong style="color: red;">Close this window</strong><?php } ?></a>
				</div>
				&copy; 2018 The copyright is OMSR Media Pvt. Ltd.
			</div>

		</div>


	</div>

	<script>
		function closewindow() {
			window.close();
		}
		function opentimeline(msg) {
			android.opentimeline(msg);
		}



		function showmyheader() {

			var postText = $("#postText").val();
			if (postText != '') {
				$("#myheaderid").show();
			}
			else {
				$("#myheaderid").hide();
			}

		}

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
				$("#searchtagcontact").load('../searchtagcontact.php?keyword=' + arr[1] + '&tageduserid=' + tageduserid + '&tagedcompanyid=' + tagedcompanyid);
			}

		}


		function getsitecontent() {
			var sitecontent = $('#postText').val();
			//gettag(sitecontent);


			var postType = $('#postType').val();
			var linkpasted = $('#linkpasted').val();

			var nurl = '';
			var url = sitecontent;

			var result = URI.withinString(url, function (url) { nurl = url; });


			if (nurl != '') {

				var nurl = nurl.replace("https", "http");

				if (postType == 2 && linkpasted == 0) {

					$('#websitecontentblock').show();
					$('#websitecontentblock').html('<div style="text-align:center;margin-bottom: 10px;"><img src="../images/mainloading.gif"></div>');
					$('#websitecontentblock').load('../getwebsitecontent.php?viewpostid=<?php echo encodeStr($postId); ?>&url=' + nurl);
				}
			}
		}

		getsitecontent();
		showmyheader();

		var redirectpage = setInterval(function () {
			var webpageredirect = $("#webpageredirect").val();
			if (webpageredirect == 1) {
				// Move to a new location or you can do something else
				window.location.href = "<?php echo $fullurl; ?>";
				$("#webpageredirect").val(0);
			}
		}, 6000);
	</script>


	<iframe id="actionfrm" name="actionfrm" style="display:none;"></iframe>
</body>

</html>