<?php


include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
include('mail.php');
?>
<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
<?php
if (isset($_REQUEST['addskillaction']) && $_REQUEST['addskillaction'] == 'add') {
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlDel = "DELETE FROM " . _SKILL_EXPERIENCE_TABLE_ . " WHERE userId='" . intval($_SESSION["sessUserId"]) . "'";
	$resDel = mysqli_query($conn, $sqlDel) or die(mysqli_error($conn));


	$arr = $_POST['check_list'];

	foreach ($arr as $pkey => $pvalue) {
		if (trim($pvalue) != '') {

			unset($insertFields);
			unset($insertVals);

			$insertFields[0] = "userId";
			$insertFields[1] = "skillText";
			$insertFields[2] = "dateAdded";

			$insertVals[0] = $_SESSION["sessUserId"];
			$insertVals[1] = $pvalue;
			$insertVals[2] = date('Y-m-d');

			$resUpdate = insertDB(_SKILL_EXPERIENCE_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		}
	}
	?>
	<script>
		parent.loadskills();
	</script>


	<?php
}



if (isset($_REQUEST['addexploringaction']) && $_REQUEST['addexploringaction'] == 'add') {



	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlDel = "DELETE FROM " . _EXPLORING_TABLE_ . " WHERE userId='" . intval($_SESSION["sessUserId"]) . "'";
	$resDel = mysqli_query($conn, $sqlDel) or die(mysqli_error($conn));


	$arr = $_POST['check_list'];

	foreach ($arr as $pkey => $pvalue) {
		if (trim($pvalue) != '') {

			unset($insertFields);
			unset($insertVals);

			$insertFields[0] = "userId";
			$insertFields[1] = "exploringText";
			$insertFields[2] = "dateAdded";

			$insertVals[0] = $_SESSION["sessUserId"];
			$insertVals[1] = $pvalue;
			$insertVals[2] = date('Y-m-d');

			$resUpdate = insertDB(_EXPLORING_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		}
	}
	?>



	<script>
		parent.loadexploring();
	</script>


	<?php
}




if (isset($_REQUEST['addlanguageaction']) && $_REQUEST['addlanguageaction'] == 'add') {



	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	unset($_POST['addlanguageaction']);



	$sqlDel = "";
	$sqlDel = mysqli_query($conn, "DELETE FROM " . _LANGUAGES_KONECTT_TABLE_ . " WHERE userId='" . $_SESSION["sessUserId"] . "'");



	$i = 0;


	foreach ($_POST as $val) {

		foreach ($_POST['check_list'] as $pkey => $pvalue) {

			$pvalue = $_POST['check_list'][$i];
			$check_listlang = $_POST['check_listlang'][$i];

			if (trim($pvalue) != '') {


				$insertFields = [];
				$insertVals = [];
				$selectFields = [];
				$whereFields = [];
				$whereVals = [];

				$insertFields[0] = "userId";
				$insertFields[1] = "languageText";
				$insertFields[2] = "experties";
				$insertFields[3] = "dateAdded";

				$insertVals[0] = $_SESSION["sessUserId"];
				$insertVals[1] = $pvalue;
				$insertVals[2] = $check_listlang;
				$insertVals[3] = date('Y-m-d');

				$resUpdate = insertDB(_LANGUAGES_KONECTT_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

			}
			$i++;
		}
	}
	?>



	<script>
		parent.loadlanguages();
	</script>


	<?php
}




if (isset($_REQUEST['addinterestaction']) && $_REQUEST['addinterestaction'] == 'add') {



	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlDel = "";
	$sqlDel = mysqli_query($conn, "DELETE FROM " . _INTERESTS_TABLE_ . " WHERE userId='" . $_SESSION["sessUserId"] . "'");


	$arr = $_POST['check_list'];

	foreach ($arr as $pkey => $pvalue) {
		if (trim($pvalue) != '') {

			unset($insertFields);
			unset($insertVals);

			$insertFields[0] = "userId";
			$insertFields[1] = "interestText";
			$insertFields[2] = "dateAdded";

			$insertVals[0] = $_SESSION["sessUserId"];
			$insertVals[1] = $pvalue;
			$insertVals[2] = date('Y-m-d');

			$resUpdate = insertDB(_INTERESTS_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		}
	}
	?>



	<script>
		parent.loadinterest();
	</script>


	<?php
}


if ($_REQUEST['action'] == 'tagline' && trim($_REQUEST['taglineText']) != '') {


	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);

	$insertFields[0] = "taglineText";

	$insertVals[0] = clean($_REQUEST['taglineText']);

	$whereFields[0] = "userId";

	$whereVals[0] = $_SESSION['sessUserId'];

	$resUpdate = updateDB(_USERS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}



if (isset($_FILES['imagefile']) && $_FILES['imagefile']['name'] != '') {



	$timename = time();
	$file_name = $_FILES['imagefile']['name'];

	$fileExt = findExtension($file_name);

	if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {
		$file_name = $timename . $file_name;
		$file_name = preg_replace('!\s+!', '-', $file_name);
		copy($_FILES['imagefile']['tmp_name'], "uploads/" . $file_name);
		copy($_FILES['imagefile']['tmp_name'], "uploads/" . 'x_' . $file_name);
		if ($_POST['oldprofilePhoto'] != '') {
			unlink("uploads/" . $_POST["oldprofilePhoto"]);
			unlink("uploads/" . 'x_' . $_POST["oldprofilePhoto"]);
		}

		$upimg = 'uploads/' . $file_name;

		//image_fix_orientation($upimg);
		//generate_image_thumbnail($upimg, $upimg,'500','500');



		$sql_ins = "update " . _USERS_MASTER_TABLE_ . " set profilePhoto='$file_name' where userId= " . $_SESSION["sessUserId"] . "";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		?>
		<script>
			parent.reloadPage();
		</script>

		<?php
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.showerrormsg('Error', 'Oops! Please upload image file with extension only .jpg, .png, .gif.', '');
		</script>
		<?php
	}

}


if (isset($_REQUEST['shareType']) && $_REQUEST['shareType'] != '' && $_REQUEST['postpost'] != '0' && $_REQUEST['action'] != 'webshare') {

	//========================*******************

	if (trim($_REQUEST['postText']) != '' || $_REQUEST['imgyes'] == 1) {
		?>
		<script>
			parent.$('#commonloader').show();
		</script>
		<?php

		$linkcontentsubmit = '';
		$linkcontentsubmit = preg_replace('/<br \/>/iU', '', $_REQUEST['linkcontentsubmit']);
		if ($linkcontentsubmit != '') {
			$postText = addslashes($_REQUEST['postText'] . '' . $linkcontentsubmit);
		} else {
			$postText = addslashes($_REQUEST['postText']);
		}

		$tageduserid = str_replace("'", "", trim($_REQUEST['tageduserid']));
		$tageduserid = rtrim($tageduserid, ",");

		unset($insertFields);
		unset($insertVals);
		unset($whereFields);
		unset($whereVals);

		$insertFields[0] = "postType";
		$insertFields[1] = "postText";
		$insertFields[2] = "shareType";
		$insertFields[3] = "dateAdded";
		$insertFields[4] = "websiteshare";

		$insertVals[0] = clean($_REQUEST['postType']);
		$insertVals[1] = $postText;
		$insertVals[2] = clean($_REQUEST['shareType']);
		$insertVals[3] = time();
		$insertVals[4] = trim($_REQUEST['websiteshare']);

		$whereFields[0] = "id";
		$whereFields[1] = "userId";

		$whereVals[0] = clean($_REQUEST['postId']);
		$whereVals[1] = $_SESSION['sessUserId'];

		$resUpdate = updateDB(_SHAREANDUPDATES_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		if ($resUpdate) {
			unset($insertFields);
			unset($insertVals);

			$insertFields[0] = "userId";
			$insertFields[1] = "postId";
			$insertFields[2] = "postType";
			$insertFields[3] = "shareType";
			$insertFields[4] = "dateAdded";
			$insertFields[5] = "status";

			$insertVals[0] = $_SESSION["sessUserId"];
			$insertVals[1] = clean($_REQUEST['postId']);
			$insertVals[2] = clean($_REQUEST['postType']);
			$insertVals[3] = clean($_REQUEST['shareType']);
			$insertVals[4] = time();
			if ($insertVals[3] == 1) {
				$insertVals[5] = 0;
			} else {
				$insertVals[5] = 1;
			}
			$resUpdate = insertDB(_TIMELINE_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
		}


		$sql_ins = "update " . _USERS_MASTER_TABLE_ . " set lastPost=" . clean($_REQUEST['postId']) . " ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		if ($tageduserid != '') {

			$expElementVal = explode(",", $tageduserid);
			for ($elementCount = 0; $elementCount <= count($expElementVal) - 1; $elementCount++) {
				$contactId = $expElementVal[$elementCount];

				unset($insertFields);
				unset($insertVals);

				$insertFields[0] = "userId";
				$insertFields[1] = "contactId";
				$insertFields[2] = "postType";
				$insertFields[3] = "postId";
				$insertFields[4] = "notificationText";
				;
				$insertFields[5] = "dateAdded";

				$insertVals[0] = $contactId;
				$insertVals[1] = $_SESSION["sessUserId"];
				$insertVals[2] = 10;
				$insertVals[3] = clean($_REQUEST['postId']);
				$insertVals[4] = 'tag';
				$insertVals[5] = time();

				$resUpdate = insertDB(_NOTIFICATION_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');


			}
		}






		$tagedcompanyid = str_replace("'", "", trim($_REQUEST['tagedcompanyid']));
		$tagedcompanyid = rtrim($tagedcompanyid, ",");

		if ($tagedcompanyid != '') {

			$expElementVal = explode(",", $tagedcompanyid);
			for ($elementCount = 0; $elementCount <= count($expElementVal) - 1; $elementCount++) {
				$companyId = $expElementVal[$elementCount];

				$sqlCompany = "select userId from " . _COMPANY_MASTER_TABLE_ . " where  id=" . $companyId . "  ";
				$resCompany = getRecords(_COMPANY_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCompany);
				$rowCompanyUserId = mysqli_fetch_array($resCompany);

				$sql = "SELECT notiTagingCompany from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId= " . $rowCompanyUserId["userId"] . " ";
				$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
				$getUserSettings = mysqli_fetch_array($getSql);

				if ($getUserSettings["notiTagingCompany"] == 1) {

					unset($insertFields);
					unset($insertVals);

					$insertFields[0] = "userId";
					$insertFields[1] = "contactId";
					$insertFields[2] = "postType";
					$insertFields[3] = "postId";
					$insertFields[4] = "notificationText";
					$insertFields[5] = "dateAdded";
					$insertFields[6] = "companyId";

					$insertVals[0] = $rowCompanyUserId["userId"];
					$insertVals[1] = $_SESSION["sessUserId"];
					$insertVals[2] = 15;
					$insertVals[3] = clean($_REQUEST['postId']);
					$insertVals[4] = 'companytag';
					$insertVals[5] = time();
					$insertVals[6] = $companyId;

					$resUpdate = insertDB(_NOTIFICATION_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
				}

			}
		}



		?>
		<script>
			//parent.loadtimeline(1,0,20);
			//parent.$('#postText').val('');
			parent.reloadPage();


			//parent.$('#uploadboximage').html('<div class="upload-img" style="position:relative;"><input name="imagefilehome" id="imagefilehome" type="file" onChange="$(\'#frmposthome\').submit();" style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); "><table width="40%"><tbody><tr><td> <i class="fa fa-cloud-upload" aria-hidden="true"></i></td><td align="left"> Upload Photo</td></tr></tbody></table></div>');
			parent.$('#postpost').val(0);

		</script>
		<?php
	}

}








if ($_REQUEST['action'] == 'addcontact' && $_REQUEST['userid'] != '') {

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlCheck = "";
	$sqlCheck = "select id from " . _CONTACT_MASTER_TABLE_ . " where contactId='" . $_SESSION['sessUserId'] . "' and userId=" . decodeStr($_REQUEST['userid']) . " ";
	$resCheck = getRecords(_CONTACT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlCheck);
	if ($resCheck) {
	} else {

		unset($insertFields);
		unset($insertVals);

		$insertFields[0] = "contactId";
		$insertFields[1] = "userId";
		$insertFields[2] = "dateAdded";

		$insertVals[0] = $_SESSION["sessUserId"];
		$insertVals[1] = decodeStr($_REQUEST['userid']);
		$insertVals[2] = time();

		$resUpdate = insertDB(_CONTACT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');




		$aa = "SELECT firstName,lastName,profilePhoto,email from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . decodeStr($_REQUEST['userid']) . "' ";
		$res5 = mysqli_query($conn, $aa);
		$getuser = mysqli_fetch_array($res5);

		$firstName = $getuser['firstName'];
		$lastName = $getuser['lastName'];
		$profilePhoto = $getuser['profilePhoto'];
		$email = $getuser['email'];

		if ($profilePhoto != '') {
			$profilePhoto = $profilePhoto;
		} else {
			$profilePhoto = 'user-placeholder.jpg';
		}


		$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,cityName,countryName from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
		$res52 = mysqli_query($conn, $aa2);
		$getuser2 = mysqli_fetch_array($res52);

		$firstName2 = $getuser2['firstName'];
		$lastName2 = $getuser2['lastName'];
		$profilePhoto21 = $getuser2['profilePhoto'];
		$jobTitle = $getuser2["jobTitle"];
		$companyName = $getuser2["companyName"];
		$cityName = $getuser2["cityName"];
		$countryName = $getuser2["countryName"];
		$userurl = $getuser2["userurl"];

		if ($profilePhoto21 != '') {
			$profilePhoto2 = $profilePhoto21;
		} else {
			$profilePhoto21 = 'user-placeholder.jpg';
		}

		$sql = "SELECT newContactRequest from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId= " . decodeStr($_REQUEST['userid']) . " ";
		$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
		$getUserSettings = mysqli_fetch_array($getSql);

		if ($getUserSettings["newContactRequest"] == 1) {

			$mailBodyContent = '';

			$mailBodyContent .= '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
    <tbody>
    <tr>
        <td align="center" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px;margin-top:20px;">
                <tbody>
                <tr>
                  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">
				  <div style="padding: 0px 0px 16px;text-align:center;">
				   <a href="' . $fullurl . '" target="_blank" >
                            <img src="' . $fullurl . 'images/sdglogo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:234px">                        </a>
				  </div>
                        <div style="color:#666666; font-size:12px; margin-bottom:10px;">You have a new notification</div>
                      <p align="center" style="margin:0 0 30px;padding:0;color:#484848; font-size:18px;">New friend request</p>
					  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">
					  <div style="font-size:20px; margin-bottom:6px;">Hi ' . $firstName . ',</div>
					  <div style="font-size:16px; margin-bottom:16px;">I found you on ' . $companNameTitle . '.</div>
					  <div style="font-size:14px; margin-bottom:16px;">It would be great if you can accept my connection request.</div>
					    <div style="text-align:center;"><div style="
    width: 80px;
    height: 80px;
    overflow: hidden;margin:auto;
    margin-bottom:12px;
    border-radius: 100%;
    border: 3px #e9e9e9 solid; margin:auto;
"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2"><img src="' . $fullurl . 'uploads/' . $profilePhoto2 . '" style="
    width: 100%;
"></a></div>
<div style="text-align:center; margin-bottom:5px; margin-top:5px;"><strong>' . $firstName2 . ' ' . $lastName2 . '</strong></div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $jobTitle . ' at ' . $companyName . '</div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $cityName . ', ' . $countryName . '</div>
</div><div style="text-align:center; margin-top:10px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
  <tbody><tr>
    <td colspan="2" align="center"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#1a94c3;border-radius:5px;margin-bottom: 0px;" target="_blank">View Profile</a></td>
    <td align="center"><a href="' . $fullurl . 'contacts.html?cuid=' . $_SESSION['sessUserId'] . '&t=1" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#0abe51;border-radius:5px;margin-bottom: 0px;" target="_blank">Add as Contact</a></td>
  </tr>

</tbody></table>
</div>
					  </div>

                         </td>
                </tr>
                <tr>
                    <td align="center" style="padding:40px;margin:0">
                       <div style="text-align:center; font-size:12px; margin-bottom:20px;">

                       <a href="' . $fullurl . 'privacy.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Privacy</a> -

                          <a href="' . $fullurl . 'terms.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Terms</a> -

                        <a href="' . $fullurl . 'about.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">About</a> -

                          <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div>
<p style="margin:0;padding:0;font-family:"Open Sans",Arial,Helvetica,sans-serif;line-height:24px;color:#616161;font-size:14px;text-align:center">
                             Powered by <a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $domainname . '</a></p>                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</div>';


			$subject = 'Connection request from ' . $firstName2 . ' ' . $lastName2 . '';

			send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

		}



		?>
		<script>
			parent.$('#sendrequestbutton').removeAttr('href');
			parent.$('#sendrequestbutton').removeAttr('target');
			parent.$('#sendrequestbutton').text('Request Sent');
			parent.$('#sendrequestbutton').css('background-color', '#b0d400');
			parent.reloadPage();
		</script>

		<?php
	}

}




if (isset($_FILES['imagefilehome']) && $_FILES['imagefilehome']['name'] != '' && $_REQUEST['postId'] != '' && $_REQUEST['postpost'] == '0') {


	$postId = $_REQUEST['postId'];
	$imageType = $_REQUEST['postType'];
	$dateAdded = time();

	$timename = time();
	$file_name = $_FILES['imagefilehome']['name'];
	$fileExt = findExtension($file_name);

	if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {
		$file_name = $timename . $file_name;
		$file_name = preg_replace('!\s+!', '-', $file_name);
		copy($_FILES['imagefilehome']['tmp_name'], "uploads/" . $file_name);


		$upimg = 'uploads/' . $file_name;

		//image_fix_orientation($upimg);
		//generate_image_thumbnail($upimg, $upimg,'800','800');


		$sql_inss = "SELECT imageName from " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . $postId . " ";
		$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
		$rowResults = mysqli_fetch_array($resresults);
		$imageName = $rowResults["imageName"];



		if ($imageName != '') {
			unlink("uploads/" . $imageName);
			unlink("uploads/x_" . $imageName);
		}

		$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . $postId . "  ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


		$sql_ins = "insert into " . _IMAGE_MASTER_TABLE_ . " set imageName='" . $file_name . "',postId='$postId',dateAdded='$dateAdded',imageType= " . $imageType . "";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		?>
		<script>
			parent.$('#uploadboximage').load('share_photo_home.php?postId=<?php echo $_REQUEST['postId']; ?>');
		</script>

		<?php
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.showerrormsg('Error', 'Oops! Please upload image file with extension only .jpg, .png, .gif.', '');
		</script>
		<?php
	}



}



if (isset($_FILES['imagefilehome']) && $_FILES['imagefilehome']['name'] != '' && $_REQUEST['uploadarticleimg'] == 1 && $_REQUEST['articleId'] != '' && $_REQUEST['addeditpost'] != '') {

	$postId = decodeStr($_REQUEST['articleId']);
	$imageType = 3;
	$dateAdded = time();

	$timename = time();
	$file_name = $_FILES['imagefilehome']['name'];

	$fileExt = findExtension($file_name);

	if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {

		$file_name = $timename . $file_name;
		$file_name = preg_replace('!\s+!', '-', $file_name);//added  5/12/17

		copy($_FILES['imagefilehome']['tmp_name'], "uploads/" . $file_name);


		$upimg = 'uploads/' . $file_name;

		//image_fix_orientation($upimg);
		//generate_image_thumbnail($upimg, $upimg,'800','800');


		$sql_inss = "SELECT imageName from " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . $postId . " ";
		$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
		$rowResults = mysqli_fetch_array($resresults);
		$imageName = $rowResults["imageName"];



		if ($imageName != '') {
			unlink("uploads/" . $imageName);
			unlink("uploads/x_" . $imageName);
		}

		$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . $postId . "  ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


		$sql_ins = "insert into " . _IMAGE_MASTER_TABLE_ . " set imageName='$file_name',postId='$postId',dateAdded='$dateAdded',imageType= " . $imageType . "";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		?>
		<script>
			parent.$('#loadimagdiv').load('<?php echo $fullurl; ?>article_photo_home.php?postId=<?php echo $_REQUEST['articleId']; ?>');
																																											/*parent.$('#loadimagdiv').load('edit_article_photo_home.php?postId=<?php echo $postId; ?>');*/
		</script>

		<?php
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.showerrormsg('Error', 'Oops! Please upload image file with extension only .jpg, .png, .gif.', '');
		</script>
		<?php
	}

}





if ($_REQUEST['action'] == 'removepostimg' && $_REQUEST['postId'] != '') {


	$sql_inss1 = "SELECT id from " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND id= " . decodeStr($_REQUEST['postId']) . "  order by id desc";
	$resresults1 = mysqli_query($conn, $sql_inss1) or die(mysqli_error($conn));

	$rowsTotal = mysqli_num_rows($resresults1);

	if ($rowsTotal > 0) {

		$sql_inss = "SELECT imageName from " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . decodeStr($_REQUEST['postId']) . " and imageType=3 ";

		$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
		$rowResults = mysqli_fetch_array($resresults);
		$imageName = $rowResults["imageName"];



		if ($imageName != '') {
			unlink("uploads/" . $imageName);
			unlink("uploads/x_" . $imageName);
		}

		$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . decodeStr($_REQUEST['postId']) . "  and imageType=3 ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));





		?>
		<script>
			parent.$('#alertpopup').hide();
			parent.$('#loadimagdiv').load('<?php echo $fullurl; ?>article_photo_home.php?postId=<?php echo $_REQUEST['postId']; ?>');
		</script>

		<?php
	}
}




if ($_REQUEST['action'] == 'homeremovepostimg' && $_REQUEST['postId'] != '') {


	$sql_inss = "SELECT imageName from " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . $_REQUEST['postId'] . " and imageType=2 ";
	$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
	$rowResults = mysqli_fetch_array($resresults);
	$imageName = $rowResults["imageName"];



	if ($imageName != '') {
		unlink("uploads/" . $imageName);
		unlink("uploads/x_" . $imageName);
	}

	$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . $_REQUEST['postId'] . "  and imageType=2 ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));



	?>
	<script>
		parent.$('#uploadboximage').load('share_photo_home.php?postId=<?php echo $_REQUEST['postId']; ?>');
	</script>

	<?php

}






if (isset($_REQUEST['dltid']) && $_REQUEST['dltid'] != '' && $_REQUEST['action'] == 'dlt') {


	$dltid = decodeStr($_REQUEST['dltid']);


	$sql_ins = "select id FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND id='" . $dltid . "' ";
	$sql = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	$s = mysqli_num_rows($sql);
	if ($s > 0) {

		$sql_ins = "DELETE FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND id='" . $dltid . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _TIMELINE_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND postId='" . $dltid . "' ";
		$sql = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE  postId='" . $dltid . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _COMMENT_MASTER_TABLE_ . " WHERE  postId='" . $dltid . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _LIKE_MASTER_TABLE_ . " WHERE  postId='" . $dltid . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _SHARE_MASTER_TABLE_ . " WHERE  postId='" . $dltid . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	}
	?>
	<script>
		parent.$('#alertpopup').hide();
		parent.$('#<?php echo $dltid; ?>').slideUp();
	</script>


	<?php



}



if (isset($_REQUEST['userIdcontact']) && $_REQUEST['userIdcontact'] != '' && $_REQUEST['action'] == 'act') {

	$dateAdded = time();
	$contactId = decodeStr($_REQUEST['userIdcontact']);

	$sql_ins = "INSERT INTO " . _CONTACT_MASTER_TABLE_ . " SET status=1,contactId= " . $_SESSION["sessUserId"] . ",userId=" . $contactId . ",dateAdded='" . $dateAdded . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET status=1 WHERE contactId= " . $contactId . " AND userId='" . $_SESSION["sessUserId"] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins2 = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "',userId='" . $contactId . "',postType=11,notificationText='actrequest',dateAdded='$dateAdded'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	$aa = "SELECT firstName,lastName,profilePhoto,email from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $contactId . "' ";
	$res5 = mysqli_query($conn, $aa);
	$getuser = mysqli_fetch_array($res5);

	$firstName = $getuser['firstName'];
	$lastName = $getuser['lastName'];
	$profilePhoto = $getuser['profilePhoto'];
	$email = $getuser['email'];

	if ($profilePhoto != '') {
		$profilePhoto = $profilePhoto;
	} else {
		$profilePhoto = 'user-placeholder.jpg';
	}

	$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,countryName,cityName from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
	$res52 = mysqli_query($conn, $aa2);
	$getuser2 = mysqli_fetch_array($res52);

	$firstName2 = $getuser2['firstName'];
	$lastName2 = $getuser2['lastName'];
	$profilePhoto2 = $getuser2['profilePhoto'];
	$jobTitle = $getuser2["jobTitle"];
	$companyName = $getuser2["companyName"];
	$userurl = $getuser2["userurl"];

	$cityName = $getuser2["cityName"];
	$countryName = $getuser2["countryName"];

	if ($profilePhoto2 != '') {
		$profilePhoto2 = $profilePhoto2;
	} else {
		$profilePhoto2 = 'user-placeholder.jpg';
	}

	$mailBodyContent = '';
	$mailBodyContent = '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
    <tbody>
    <tr>
        <td align="center" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px">
                <tbody>
                <tr>
                    <td align="center" valign="top" style="width:100%;padding:20px 0">
                        <a href="' . $fullurl . '" target="_blank" >
                            <img src="' . $fullurl . 'images/sdglogo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
                </tr>
                <tr>
                  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">

                      <p align="center" style="margin:0 0 30px;padding:0;color:#484848; font-size:18px;">Invitation accepted!</p>
					  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">


					  <div style="font-size:14px; margin-bottom:16px;"><strong>' . $firstName2 . '</strong>, has accepted your invitation to ' . $companNameTitle . ' Wishing you both a great association ahead.</div>
					    <div style="text-align:center;"><div style="
    width: 80px;
    height: 80px;
    overflow: hidden;margin:auto;
    margin-bottom:12px;
    border-radius: 100%;
    border: 3px #e9e9e9 solid; margin:auto;
"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2"><img src="' . $fullurl . 'uploads/' . $profilePhoto2 . '" style="
    width: 100%;
"></a></div>
<div style="text-align:center; margin-bottom:5px; margin-top:5px;"><strong>' . $firstName2 . ' ' . $lastName2 . '</strong></div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $jobTitle . ' at ' . $companyName . '</div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $cityName . ', ' . $countryName . '</div>
</div><div style="text-align:center; margin-top:10px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
  <tbody><tr>
    <td colspan="2" align="center"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#0abe51;border-radius:5px;margin-bottom: 0px;" target="_blank">View Profile</a></td>
    </tr>
</tbody></table>
</div>
					  </div>

                         </td>
                </tr>
                <tr>
                    <td align="center" style="padding:40px;margin:0">
                       <div style="text-align:center; font-size:12px; margin-bottom:20px;">

                       <a href="' . $fullurl . 'privacy.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Privacy</a> -

                          <a href="' . $fullurl . 'terms.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Terms</a> -

                        <a href="' . $fullurl . 'about.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">About</a> -

                          <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div>
<p style="margin:0;padding:0;font-family:"Open Sans",Arial,Helvetica,sans-serif;line-height:24px;color:#616161;font-size:14px;text-align:center">
                             Powered by <a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $domainname . '</a></p>                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</div>';


	$subject = "See " . $firstName2 . "'s connections, activity and experience";

	send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);
	$_SESSION["s"] = 1;
	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}


if (isset($_REQUEST['userIdcontact']) && $_REQUEST['userIdcontact'] != '' && $_REQUEST['action'] == 'dec') {
	$contactId = decodeStr($_REQUEST['userIdcontact']);

	$sql_ins = "DELETE FROM " . _CONTACT_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND contactId='" . $contactId . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	$_SESSION["d"] = 1;
	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}














//-----------Post Like---------------------------




if (isset($_REQUEST['postId']) && $_REQUEST['postId'] != '' && $_REQUEST['action'] == 'postlike' && $_REQUEST['postType'] != '' && $_REQUEST['like'] != '') {
	$dateAdded = time();

	$aa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= " . $_REQUEST["postId"] . " and postType= " . $_REQUEST["postType"] . "  AND userId='" . $_SESSION["sessUserId"] . "'";
	$res5 = mysqli_query($conn, $aa);
	$totalpostlike = mysqli_num_rows($res5);

	if ($totalpostlike > 0) {

		$like = ($totalpostlike - 1);

		$sql_ins = "DELETE FROM " . _LIKE_MASTER_TABLE_ . "  WHERE postId= " . $_REQUEST["postId"] . " and postType= " . $_REQUEST["postType"] . "  AND userId='" . $_SESSION["sessUserId"] . "'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	} else {

		$like = $totalpostlike + 1;
		$sql_ins = "insert into " . _LIKE_MASTER_TABLE_ . " set userId='" . $_SESSION["sessUserId"] . "',postId='" . $_REQUEST['postId'] . "',postType='" . $_REQUEST["postType"] . "',dateAdded='$dateAdded'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));



		if ($_REQUEST["postType"] == 20) {
			$aa1 = "SELECT userId from " . _VAULT_MASTER_TABLE_ . " WHERE id= " . $_REQUEST["postId"] . "  ";
			$res51 = mysqli_query($conn, $aa1);
			$getrow = mysqli_fetch_array($res51);
			$contactId = $getrow['userId'];

		} else {
			$aa1 = "SELECT userId from " . _TIMELINE_MASTER_TABLE_ . " WHERE postId= " . $_REQUEST["postId"] . "  and postType= " . $_REQUEST["postType"] . "";
			$res51 = mysqli_query($conn, $aa1);
			$getrow = mysqli_fetch_array($res51);
			$contactId = $getrow['userId'];
		}

		$aa = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,email,onlineStatus from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $contactId . "' ";
		$res5 = mysqli_query($conn, $aa);
		$getuser = mysqli_fetch_array($res5);
		$email = $getuser["email"];
		$firstName = $getuser['firstName'];
		$lastName = $getuser['lastName'];
		$profilePhoto = $getuser['profilePhoto'];
		$onlineStatus = $getuser['onlineStatus'];
		$userurl = $getuser["userurl"];
		if ($profilePhoto != '') {
			$profilePhoto = $profilePhoto;
		} else {
			$profilePhoto = 'user-placeholder.jpg';
		}

		if ($onlineStatus != 1) {
			$sqlCmnsts = "";
			$sqlCmnsts = "select dateAdded from " . _LIKE_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "'  order by id desc limit 1,1";
			$resCmnsts = mysqli_query($conn, $sqlCmnsts);
			$getCmnsts = mysqli_fetch_array($resCmnsts);
			$getDateAddedCmnts = $getCmnsts["dateAdded"];


			// if($getCmnsts["dateAdded"]<strtotime("-10 minutes", time()))//You can send an email after 10 minutes according last like
			//{

			$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
			$res52 = mysqli_query($conn, $aa2);
			$getuser2 = mysqli_fetch_array($res52);

			$firstName2 = $getuser2['firstName'];
			$lastName2 = $getuser2['lastName'];
			$profilePhoto2 = $getuser2['profilePhoto'];
			$jobTitle = $getuser2["jobTitle"];
			$companyName = $getuser2["companyName"];
			$userurl2 = $getuser2["userurl"];

			if ($profilePhoto2 != '') {
				$profilePhoto2 = $profilePhoto2;
			} else {
				$profilePhoto2 = 'user-placeholder.jpg';
			}

			$sql = "SELECT emailPostLike from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId=" . $contactId . " ";
			//$getSql = mysql_query($sql) or die(error_found(mysql_error()));
			$getSql = mysqli_query($conn, $sql) or die(mysqli_error($conn));
			$getUserSettings = mysqli_fetch_array($getSql);

			if ($getUserSettings["emailPostLike"] == 1) {


				if ($contactId != $_SESSION['sessUserId']) {

					if ($_REQUEST["postType"] != 20) {


						if ($_REQUEST["postType"] == 2) {
							$cmTitle = '<strong>' . $firstName2 . '</strong> liked your post';
							$cmlink = $fullurl . 'single-post.html?postId=' . encodeStr($_REQUEST["postId"]) . '&postType=2&cuid=' . $_SESSION['sessUserId'] . '&t=3';
							$btnname = 'View Post';
						}
						if ($_REQUEST["postType"] == 3) {
							$cmTitle = '<strong>' . $firstName2 . '</strong> liked your article';
							$cmlink = $fullurl . 'view-article.html?postId=' . encodeStr($_REQUEST["postId"]) . '&cuid=' . $_SESSION['sessUserId'] . '&t=4';
							$btnname = 'View Article';
						}


						$mailBodyContent .= '';
						$mailBodyContent .= '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
	<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
		<tbody>
		<tr>
			<td align="center" valign="top">
				<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px">
					<tbody>
					<tr>
						<td align="center" valign="top" style="width:100%;padding:20px 0">
							<a href="' . $fullurl . '" target="_blank" >
								<img src="' . $fullurl . 'images/sdglogo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
					</tr>
					<tr>
					  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">
							<div style="color:#666666; font-size:12px; margin-bottom:10px;">You have a new notification</div>

						  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">

						  <div style="text-align:center; margin-bottom:5px; margin-top:5px;font-size:18px;">' . $cmTitle . '</div>
						  <div style="text-align:center; margin-top:10px; margin-bottom:30px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
	  <tbody><tr>
		<td colspan="2" align="center"><a href="' . $cmlink . '" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#1a94c3;border-radius:5px;margin-bottom: 0px;" target="_blank">' . $btnname . '</a></td>
		</tr>
	</tbody></table>
	</div>
							<div style="text-align:center;"><div style="
		width: 80px;
		height: 80px;
		overflow: hidden;margin:auto;
		margin-bottom:12px;
		border-radius: 100%;
		border: 3px #e9e9e9 solid; margin:auto;
	"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl2 . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2"><img src="' . $fullurl . 'uploads/' . $profilePhoto2 . '" style="
		width: 100%;
	"></a></div>
	<div style="text-align:center; margin-bottom:5px; margin-top:5px;"><strong>' . $firstName2 . ' ' . $lastName2 . '</strong></div>
	<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $jobTitle . ' at ' . $companyName . '</div>
	<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $cityName . ', ' . $countryName . '</div>
	</div>
						  </div>

					  </td>
					</tr>
					<tr>
						<td align="center" style="padding:40px;margin:0">
						   <div style="text-align:center; font-size:12px; margin-bottom:20px;">

						   <a href="' . $fullurl . 'privacy.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Privacy</a> -

							  <a href="' . $fullurl . 'terms.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Terms</a> -

							<a href="' . $fullurl . 'about.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">About</a> -

							  <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div>
	<p style="margin:0;padding:0;font-family:"Open Sans",Arial,Helvetica,sans-serif;line-height:24px;color:#616161;font-size:14px;text-align:center">
								 Powered by <a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $domainname . '</a></p>                    </td>
					</tr>
					</tbody>
				</table>
			</td>
		</tr>
		</tbody>
	</table>


	</div>';


						$subject = strip_tags($cmTitle);


						send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

					}
				}


			}

			//}

		}




		?>
		<!--<script>
parent.$('#likesmmbrdiv<?php echo decodeStr($_POST['postId']); ?><?php echo $_REQUEST["postType"]; ?>').load('<?php echo $fullurl; ?>loadlikeusers.php?postId=<?php echo decodeStr($_POST['postId']); ?>');
</script>-->
		<?php


	}

	if (isset($_REQUEST['postType']) && $_REQUEST["postType"] == 20) {
		$postLikeText = 'postvaultlike';

		$aa1 = "SELECT userId from " . _VAULT_MASTER_TABLE_ . " WHERE id= " . $_REQUEST["postId"] . "  ";
		$res51 = mysqli_query($conn, $aa1);
		$getrow = mysqli_fetch_array($res51);
		$contactId = $getrow['userId'];
	} else {
		$postLikeText = 'postlike';

		$aa1 = "SELECT userId from " . _TIMELINE_MASTER_TABLE_ . " WHERE postId= " . $_REQUEST["postId"] . "  and postType= " . $_REQUEST["postType"] . "";
		$res51 = mysqli_query($conn, $aa1);
		$getrow = mysqli_fetch_array($res51);
		$contactId = $getrow['userId'];
	}


	$aa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= " . $_REQUEST["postId"] . " and postType= " . $_REQUEST["postType"] . "  ";
	$res5 = mysqli_query($conn, $aa);
	$totalpostlike = mysqli_num_rows($res5);

	$aa1 = "SELECT * from " . _NOTIFICATION_MASTER_TABLE_ . " WHERE contactId='" . $_SESSION["sessUserId"] . "' and userId='" . $contactId . "' and postId= " . $_REQUEST["postId"] . " and  postType= " . $_REQUEST["postType"] . "  ";
	$res51 = mysqli_query($conn, $aa1);
	$totallikes = mysqli_num_rows($res51);
	if ($totallikes > 0) {
	} else {
		$sql_ins = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "',userId='" . $contactId . "',postId= " . $_REQUEST["postId"] . ",postType= " . $_REQUEST["postType"] . ",notificationText='$postLikeText',dateAdded='$dateAdded'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	}
	?>
	<script>
		$('#post<?php echo $_REQUEST['postId']; ?><?php echo $_REQUEST['postType']; ?> span').text(<?php echo $totalpostlike; ?>);
	</script>
	<?php
}





if (isset($_REQUEST['dltid']) && $_REQUEST['dltid'] != '' && $_REQUEST['action'] == 'dltarticle' && $_REQUEST['removearticle'] != '') {


	$dltid = decodeStr($_REQUEST['dltid']);



	$sql_ins = "select id FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE id='" . $dltid . "' and userId=" . $_SESSION["sessUserId"] . " ";
	$sql = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	$s = mysqli_num_rows($sql);
	if ($s > 0) {
		$sql_ins = "DELETE FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE id='" . $dltid . "' and userId=" . $_SESSION["sessUserId"] . " ";
		$sql = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _TIMELINE_MASTER_TABLE_ . " WHERE  postId='" . $dltid . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _COMMENT_MASTER_TABLE_ . " WHERE  postId='" . $dltid . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _LIKE_MASTER_TABLE_ . " WHERE  postId='" . $dltid . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


		$sql_inss = "SELECT imageName from " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . $dltid . " and imageType=3 ";
		$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
		$rowResults = mysqli_fetch_array($resresults);
		$imageName = $rowResults["imageName"];


		if ($imageName != '') {
			unlink("uploads/" . $imageName);
			unlink("uploads/x_" . $imageName);
		}

		$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE  postId='" . $dltid . "' and imageType=3  ";
		mysqli_query($sql_ins) or die(mysqli_error($conn));

	}
	if ($_REQUEST['removearticle'] == 1) {
		?>
		<script>
			parent.$('#<?php echo $dltid; ?>').slideUp();
			parent.$('#alertpopup').hide();
		</script>
		</script>
	<?php } else { ?>
		<script>
			parent.reloadPage();
		</script>
		<?php
	}


}


if (trim($_REQUEST['action']) == 'addnewgrp' && trim($_REQUEST['groupName']) != '') {
	unset($insertFields);
	unset($insertVals);

	$insertFields[0] = "userId";
	$insertFields[1] = "groupName";
	$insertFields[2] = "groupDetails";
	$insertFields[3] = "groupType";
	$insertFields[4] = "dateAdded";

	$insertVals[0] = $_SESSION["sessUserId"];
	$insertVals[1] = normalclean($_REQUEST['groupName']);
	$insertVals[2] = normalclean($_REQUEST['groupDetails']);
	$insertVals[3] = normalclean($_REQUEST['groupType']);
	$insertVals[4] = time();

	$resInsert = insertDB(_GROUP_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$groupId = $resInsert;

	unset($insertFields);
	unset($insertVals);

	$insertFields[0] = "userId";
	$insertFields[1] = "groupId";
	$insertFields[2] = "dateAdded";
	$insertFields[3] = "status";

	$insertVals[0] = $_SESSION["sessUserId"];
	$insertVals[1] = $groupId;
	$insertVals[2] = time();
	$insertVals[3] = 1;

	$resInsert = insertDB(_GROUP_MEMBER_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	unset($insertFields);
	unset($insertVals);

	$insertFields[0] = "userId";
	$insertFields[1] = "groupId";
	$insertFields[2] = "postType";
	$insertFields[3] = "shareType";
	$insertFields[4] = "dateAdded";

	$insertVals[0] = $_SESSION["sessUserId"];
	$insertVals[1] = $groupId;
	$insertVals[2] = 4;
	$insertVals[3] = 2;
	$insertVals[4] = time();

	$resUpdate = insertDB(_TIMELINE_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$mailBodyContent = '';
	$mailBodyContent = $myname . ' created a group <strong>' . normalclean($_REQUEST['groupName']) . '</strong> - ' . date("H:i:s - d/m/Y") . '';

	$subject = $myname . ' (' . $myemail . ') created a group';

	adminnotification($subject, $mailBodyContent);

	$_SESSION["s"] = 1;
	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}


if (isset($_REQUEST['grouppostpost']) && $_REQUEST['grouppostpost'] != '0' && $_REQUEST['groupPostTitle'] != '' && $_REQUEST['groupId'] != '') {


	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);

	$insertFields[0] = "postType";
	$insertFields[1] = "postText";
	$insertFields[2] = "postTitle";
	$insertFields[3] = "dateAdded";
	$insertFields[4] = "shareType";
	$insertFields[5] = "userId";
	$insertFields[6] = "groupId";

	$insertVals[0] = '4';
	$insertVals[1] = addslashes($_REQUEST['groupPostText']);
	$insertVals[2] = clean($_REQUEST['groupPostTitle']);
	$insertVals[3] = time();
	$insertVals[4] = '1';
	$insertVals[5] = $_SESSION['sessUserId'];
	$insertVals[6] = decodeStr($_REQUEST['groupId']);



	$whereFields[0] = "userId";
	$whereFields[1] = "id";

	$whereVals[0] = $_SESSION['sessUserId'];
	$whereVals[1] = decodeStr($_REQUEST['grouppostId']);

	$resUpdate = updateDB(_SHAREANDUPDATES_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');


	unset($insertFields);
	unset($insertVals);

	$insertFields[0] = "userId";
	$insertFields[1] = "postId";
	$insertFields[2] = "postType";
	$insertFields[3] = "shareType";
	$insertFields[4] = "dateAdded";

	$insertVals[0] = $_SESSION["sessUserId"];
	$insertVals[1] = decodeStr($_REQUEST['grouppostId']);
	$insertVals[2] = 4;
	$insertVals[3] = 1;
	$insertVals[4] = time();

	$resUpdate = insertDB(_TIMELINE_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$a = "SELECT userId from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['groupId']) . "";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$groupuserres = mysqli_fetch_array($b);

	$sql = "SELECT notiPostGroup from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId= " . $groupuserres['userId'] . " ";
	$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
	$getUserSettings = mysqli_fetch_array($getSql);

	if ($getUserSettings["notiPostGroup"] == 1) {

		$sql_ins = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "', userId='" . $groupuserres['userId'] . "',groupId= " . decodeStr($_REQUEST['groupId']) . ",postType='4' ,notificationText='grouppost',dateAdded='" . time() . "'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	}

	?>
	<script>
		parent.reloadPage();

		parent.$('#postpost').val(0);

	</script>
	<?php
}


if (isset($_REQUEST['groupdltid']) && $_REQUEST['groupdltid'] != '' && $_REQUEST['action'] == 'dltgrouppost') {


	$dltid = decodeStr($_REQUEST['groupdltid']);


	$sql_ins2 = "SELECT id from " . _GROUP_MASTER_TABLE_ . " WHERE id IN (select groupId from " . _SHAREANDUPDATES_TABLE_ . " where userId=" . $_SESSION["sessUserId"] . " and postType=4) ";
	$sql2 = mysqli_query($conn, $sql_ins2) or die(mysqli_error($conn));
	$s = mysqli_num_rows($sql2);

	if ($s > 0) {
		$sql_ins = "DELETE FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE  id='" . $dltid . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _TIMELINE_MASTER_TABLE_ . " WHERE  postId='" . $dltid . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	}


	$sql_ins = "DELETE FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND id='" . $dltid . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "DELETE FROM " . _TIMELINE_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND postId='" . $dltid . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	$sql_inss = "SELECT imageName from " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . $dltid . " and imageType=4   ";
	$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
	$rowResults = mysqli_fetch_array($resresults);
	$imageName = $rowResults["imageName"];

	if ($imageName != '') {
		unlink("uploads/" . $imageName);
		unlink("uploads/x_" . $imageName);
	}

	$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE  postId='" . $dltid . "' and imageType=4  ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "DELETE FROM " . _COMMENT_MASTER_TABLE_ . " WHERE  postId='" . $dltid . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "DELETE FROM " . _LIKE_MASTER_TABLE_ . " WHERE  postId='" . $dltid . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	?>
	<script>
		parent.$('#alertpopup').hide();
		parent.$('#post<?php echo $dltid; ?>').slideUp();
	</script>


	<?php



}


if (isset($_REQUEST['groupId']) && $_REQUEST['groupId'] != '' && $_REQUEST['action'] == 'groupjoinrequest') {


	$groupId = decodeStr($_REQUEST['groupId']);


	$insertFields = [];
	$insertVals = [];
	$whereFields = [];
	$whereVals = [];

	$insertFields[0] = "status";
	$insertFields[1] = "userId";
	$insertFields[2] = "groupId";
	$insertFields[3] = "dateAdded";

	$insertVals[0] = 0;
	$insertVals[1] = $_SESSION['sessUserId'];
	$insertVals[2] = $groupId;
	$insertVals[3] = time();

	$resInsert = insertDB(_GROUP_MEMBER_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$a = "SELECT * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $groupId . "";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$groupuserres = mysqli_fetch_array($b);
	$dateAdded = time();

	$sql_ins = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "', userId='" . $groupuserres['userId'] . "',groupId= " . $groupId . ",postType='4' ,notificationText='grouprequest',dateAdded='" . $dateAdded . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	?>
	<script>
		parent.reloadPage();
	</script>

	<?php



}


if (isset($_REQUEST['groupId']) && $_REQUEST['groupId'] != '' && $_REQUEST['action'] == 'publicgroupjoinrequest') {


	$groupId = decodeStr($_REQUEST['groupId']);


	$insertFields = [];
	$insertVals = [];
	$whereFields = [];
	$whereVals = [];

	$insertFields[0] = "status";
	$insertFields[1] = "userId";
	$insertFields[2] = "groupId";
	$insertFields[3] = "dateAdded";

	$insertVals[0] = 0;
	$insertVals[1] = $_SESSION['sessUserId'];
	$insertVals[2] = $groupId;
	$insertVals[3] = time();

	$resInsert = insertDB(_GROUP_MEMBER_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$a = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $groupId . "";
	$b = mysqli_query($cconn, $a) or die(mysqli_error($conn));
	$groupuserres = mysqli_fetch_array($b);
	$dateAdded = time();


	$sql_ins = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "', userId='" . $groupuserres['userId'] . "',groupId= " . $groupId . ",postType='4' ,notificationText='grouprequest',dateAdded='" . $dateAdded . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));



	$aa = "SELECT email,firstName from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $groupuserres['userId'] . "' ";
	$res5 = mysqli_query($conn, $aa);
	$getuser = mysqli_fetch_array($res5);
	$userfirstName = $getuser['firstName'];
	$useremail = $getuser["email"];



	$sql = "SELECT notiJoiningGroup from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId= " . $groupuserres['userId'] . " ";
	$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
	$getUserSettings = mysqli_fetch_array($getSql);

	if ($getUserSettings["notiJoiningGroup"] == 1) {



		$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,cityName,countryName,email from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
		$res52 = mysqli_query($conn, $aa2);
		$getuser2 = mysqli_fetch_array($res52);

		$firstName2 = $getuser2['firstName'];
		$lastName2 = $getuser2['lastName'];
		$profilePhoto2 = $getuser2['profilePhoto'];
		$jobTitle = $getuser2["jobTitle"];
		$companyName = $getuser2["companyName"];
		$userurl2 = $getuser2["userurl"];
		$cityName = $getuser2["cityName"];
		$countryName = $getuser2["countryName"];
		$email = $getuser2["email"];
		if ($profilePhoto2 != '') {
			$profilePhoto2 = $profilePhoto2;
		} else {
			$profilePhoto2 = 'user-placeholder.jpg';
		}



		$mailBodyContent .= '';
		$mailBodyContent .= '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
    <tbody>
    <tr>
        <td align="center" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px">
                <tbody>
                <tr>
                    <td align="center" valign="top" style="width:100%;padding:20px 0">
                        <a href="' . $fullurl . '" target="_blank" >
                            <img src="' . $fullurl . 'images/sdglogo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
                </tr>
                <tr>
                  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">


					  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">

					  <div style="text-align:center; margin-bottom:5px; margin-top:5px;font-size:18px;">Dear <strong>' . $userfirstName . '</strong></div>
					  <div style="text-align:center; margin-top:5px; margin-bottom:30px;font-size:15px;">' . $myname . ' is interested to join your group  ' . $groupuserres['groupName'] . '</div>

					    <div style="text-align:center;"><div style="
    width: 80px;
    height: 80px;
    overflow: hidden;margin:auto;
    margin-bottom:12px;
    border-radius: 100%;
    border: 3px #e9e9e9 solid; margin:auto;
"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl2 . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2"><img src="' . $fullurl . 'uploads/' . $profilePhoto2 . '" style="
    width: 100%;
"></a></div>
<div style="text-align:center; margin-bottom:5px; margin-top:5px;"><strong>' . $firstName2 . ' ' . $lastName2 . '</strong></div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $jobTitle . ' at ' . $companyName . '</div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $cityName . ', ' . $countryName . '</div>

<div style="text-align:center; margin-top:10px; margin-bottom:30px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
  <tbody><tr>
    <td colspan="2" align="center"><a href="' . $fullurl . 'joining-requests.html?groupId=' . $_REQUEST['groupId'] . '&cuid=' . $_SESSION['sessUserId'] . '&t=7" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#0abe51;border-radius:5px;margin-bottom: 0px;" target="_blank">View Request</a></td>
    </tr>
</tbody></table>
</div>
</div>
					  </div>

                  </td>
                </tr>
                <tr>
                    <td align="center" style="padding:40px;margin:0">
                       <div style="text-align:center; font-size:12px; margin-bottom:20px;">

                       <a href="' . $fullurl . 'privacy.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Privacy</a> -

                          <a href="' . $fullurl . 'terms.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Terms</a> -

                        <a href="' . $fullurl . 'about.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">About</a> -

                          <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div>
<p style="margin:0;padding:0;font-family:"Open Sans",Arial,Helvetica,sans-serif;line-height:24px;color:#616161;font-size:14px;text-align:center">
                             Powered by <a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $domainname . '</a></p>                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</div>';




		$subject = '' . $myname . ' is interested to join your group  ' . $groupuserres['groupName'] . '';


		send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $useremail, $subject, $mailBodyContent);





		$mailBodyContent = '';
		$mailBodyContent .= '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
    <tbody>
    <tr>
        <td align="center" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px">
                <tbody>
                <tr>
                    <td align="center" valign="top" style="width:100%;padding:20px 0">
                        <a href="' . $fullurl . '" target="_blank" >
                            <img src="' . $fullurl . 'images/sdglogo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
                </tr>
                <tr>
                  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">


					  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">

					  <div style="text-align:center; margin-bottom:5px; margin-top:5px;font-size:18px;">Dear<strong> ' . $myname . '</strong></div>
					  <div style="text-align:center; margin-top:5px; margin-bottom:30px;font-size:15px;">We are currently reviewing your application and we shall be glad to include you in the group, should your profile suit the criteria.<br />
<br />
Once again, we appreciate your interest in joining our group.<br />
<br />
Best regards,<br />
' . $groupuserres['groupName'] . ' Team</div>

</div>


                  </td>
                </tr>
                <tr>
                    <td align="center" style="padding:40px;margin:0">
                       <div style="text-align:center; font-size:12px; margin-bottom:20px;">

                       <a href="' . $fullurl . 'privacy.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Privacy</a> -

                          <a href="' . $fullurl . 'terms.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Terms</a> -

                        <a href="' . $fullurl . 'about.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">About</a> -

                          <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div>
<p style="margin:0;padding:0;font-family:"Open Sans",Arial,Helvetica,sans-serif;line-height:24px;color:#616161;font-size:14px;text-align:center">
                             Powered by <a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $domainname . '</a></p>                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</div>';




		$subject = 'Thank you for your interest in joining our group ' . $groupuserres['groupName'] . '';


		send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);


	}
	?>
	<script>
		parent.reloadPage();
	</script>

	<?php



}






if (isset($_REQUEST['joinedGroupId']) && $_REQUEST['joinedGroupId'] != '' && $_REQUEST['action'] == 'actgrouprequest') {

	$dateAdded = time();
	$groupId = decodeStr($_REQUEST['joinedGroupId']);
	$userId = decodeStr($_REQUEST['userId']);


	$sql_ins = "UPDATE " . _GROUP_MEMBER_MASTER_TABLE_ . " SET status=1 WHERE groupId= " . $groupId . " AND userId='" . $userId . "'    ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$dateAdded = time();

	$sql_del = "DELETE FROM " . _NOTIFICATION_MASTER_TABLE_ . " WHERE contactId= " . $userId . " AND notificationText='grouprequest' and groupId= " . $groupId . " ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "', userId='" . $userId . "',groupId= " . $groupId . ",postType='4' ,notificationText='acceptgrouprequest',dateAdded='" . $dateAdded . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	if ($_REQUEST['a'] == 1) { ?>
		<script>
			window.top.location.href = "groups.html?q=1";
		</script>
		<?php
	} else {

		if ($_REQUEST['page'] == 1) { ?>
			<script>
				parent.reloadPage();
			</script>
		<?php } else { ?>
			<script>
				parent.reloadPage();
			</script> <?php }
	}
}

if (isset($_REQUEST['joinedGroupId']) && $_REQUEST['joinedGroupId'] != '' && $_REQUEST['action'] == 'actprivategrouprequest' && $_REQUEST['contactId'] != '') {

	$dateAdded = time();
	$groupId = decodeStr($_REQUEST['joinedGroupId']);
	$userId = decodeStr($_REQUEST['userId']);
	$contactId = decodeStr($_REQUEST['contactId']);


	echo $sql_ins = "UPDATE " . _GROUP_MEMBER_MASTER_TABLE_ . " SET status=1 WHERE groupId= " . $groupId . " AND userId='" . $_SESSION["sessUserId"] . "'    ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$dateAdded = time();

	$sql_del = "DELETE FROM " . _NOTIFICATION_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND notificationText='privategrouprequest' and groupId= " . $groupId . " ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "', userId='" . $contactId . "',groupId= " . $groupId . ",postType='4' ,notificationText='acceptgrouprequest',dateAdded='" . $dateAdded . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	$a = "SELECT firstName,lastName from " . _USERS_MASTER_TABLE_ . " WHERE userId=" . $contactId . "";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$userres = mysqli_fetch_array($b);
	$myname = $userres["firstName"] . ' ' . $userres["lastName"];

	$myvar = '';

	$dateAdded = time();
	$sql_ins = "insert into " . _GROUP_CHAT_MASTER_TABLE_ . " set status=1,bulbType=3,userId='" . $contactId . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . $myvar . "',groupId='" . $groupId . "',msgType='text'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	if ($_REQUEST['a'] == 1) { ?>
		<script>
			window.top.location.href = "my-groups.html?q=1";
		</script>
		<?php
	} else {

		if ($_REQUEST['page'] == 1) { ?>
			<script>
				parent.reloadPage();
			</script>
		<?php } else { ?>
			<script>
				parent.reloadPage();
			</script>
			<?php
		}
	}

}






if ($_REQUEST['action'] == 'groupchat' && trim($_REQUEST['grouptext']) != '' && $_REQUEST['groupId'] != '' && $_REQUEST['msgType'] != '') {


	$sqlGroupMembers = "";
	$sqlGroupMembers = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . decodeStr($_REQUEST["groupId"]) . " and status=1 and userStatus=0 and groupId IN (select id from " . _GROUP_MASTER_TABLE_ . " where groupStatus=0)  and userId=" . $_SESSION["sessUserId"] . " order by id desc ";
	$resGroupMembers = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
	if ($resGroupMembers) {


		$dateAdded = time();
		$sql_ins = "insert into " . _GROUP_CHAT_MASTER_TABLE_ . " set status=1,userId='" . $_SESSION["sessUserId"] . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . normalclean($_REQUEST["grouptext"]) . "',groupId='" . decodeStr($_REQUEST["groupId"]) . "',msgType='" . $_REQUEST["msgType"] . "'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


		$dd = "SELECT * from " . _GROUP_CHAT_MASTER_TABLE_ . " WHERE groupId= " . decodeStr($_REQUEST["groupId"]) . " order by id desc ";
		$ee = mysqli_query($conn, $dd) or die(mysqli_error($conn));
		$rowGroupchat = mysqli_fetch_array($ee);



		$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowGroupchat["userId"] . "";
		$b = mysqli_query($a) or die(mysqli_error($conn));
		$userres = mysqli_fetch_array($b);

		$friendnameurl = $userres['userurl'];

		if ($userres["profilePhoto"] != '') {
			$userphoto = $userres["profilePhoto"];
		} else {
			$userphoto = 'user-placeholder.jpg';
		}


		$n = 0;
		$selectFields = [];
		$whereFields = [];
		$whereVals = [];

		$sqlGroupMembers = "";
		$sqlGroupMembers = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . decodeStr($_REQUEST["groupId"]) . " and status=1 order by id desc ";
		$resGroupMembers = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
		if ($resGroupMembers) {
			while ($rowgroup = mysqli_fetch_array($resGroupMembers)) {
				$sql_ins = "insert into " . _GROUP_GOT_MSG_TABLE_ . " set status=0,userId='" . $rowgroup["userId"] . "',groupId='" . decodeStr($_REQUEST["groupId"]) . "',chatId='" . $rowGroupchat["id"] . "'";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			}

		}
		?>



		<script>
			<?php if ($rowGroupchat['msgType'] == 'text') { ?>
				$('#groupchatlist').append('<li class="me"><div class="grp-chat-cntnt"><span class="usr"> <a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a></span><div class="gchatlist-right"><div class="time"><span class="nm"><a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo $userres['firstName']; ?>																																																												 			<?php echo $userres['lastName']; ?></a> </span><?php echo date("h:i A", $rowGroupchat['dateAdded']); ?></div><div class="chat-txt"><?php echo normalclean(showsmily($rowGroupchat["chatText"])); ?></div></div></div></li>');
				$(".chats").animate({ scrollTop: $("#groupchatlist").outerHeight() }, 600);

				<?php

				$g = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id=" . decodeStr($_REQUEST["groupId"]) . " ";
				$h = mysqli_query($conn, $g) or die(mysqli_error($conn));
				$groupname = mysqli_fetch_array($h);



				$ga = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " where groupId='" . $groupname["id"] . "'  AND userStatus=0 and status=1 and userId!=" . $_SESSION["sessUserId"] . "";
				$hb = mysqli_query($conn, $ga) or die(mysqli_error($conn));
				while ($groupuser = mysqli_fetch_array($hb)) {

					$token = '';
					$sqlMsgToken = "";
					$sqlMsgToken = "select token from " . _MOBILE_NOTIFICATION_TABLE_ . " where userId='" . $groupuser["userId"] . "' ORDER BY id desc ";
					$resMsgToken = mysqli_query($conn, $sqlMsgToken);
					$getLastToken = mysqli_fetch_array($resMsgToken);
					$token = $getLastToken["token"];


					?>
					$("#sendalert").load('app/firebase/Send.php?title=<?php echo str_replace(" ", "%20", $groupname["groupName"]) . ',' . $groupname["id"]; ?>&message=<?php echo $notimessage; ?>&token=<?php echo $token; ?>&groupId=<?php echo $groupname["id"]; ?>');
					<?php
				}
				?>
			</script>

			<?php

			}

	}

}

if (isset($_REQUEST['dltGroupId']) && $_REQUEST['dltGroupId'] != '' && $_REQUEST['action'] == 'dltgrouprequest') {


	$groupId = decodeStr($_REQUEST['dltGroupId']);
	$userId = decodeStr($_REQUEST['userId']);


	$sql_ins = "DELETE FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE userId= " . $userId . " AND groupId='" . $groupId . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "DELETE FROM " . _NOTIFICATION_MASTER_TABLE_ . " WHERE userId= " . $userId . " AND groupId='" . $groupId . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	if ($_REQUEST['a'] == 1) { ?>
		<script>
			window.top.location.href = "group-request.html?g=<?php echo $_REQUEST['dltGroupId']; ?>&q=1";
		</script>
		<?php
	} else {

		if ($_REQUEST['page'] == 1) { ?>
			<script>
				parent.reloadPage();
			</script>
		<?php } else { ?>
			<script>
				parent.reloadPage();
			</script><?php }

	}

}


if (isset($_REQUEST['dltGroupId']) && $_REQUEST['dltGroupId'] != '' && $_REQUEST['action'] == 'publicdltgrouprequest') {


	$groupId = decodeStr($_REQUEST['dltGroupId']);
	$userId = decodeStr($_REQUEST['userId']);



	$sql_ins = "DELETE FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE userId= " . $userId . " AND groupId='" . $groupId . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "DELETE FROM " . _NOTIFICATION_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND groupId='" . $groupId . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	if ($_REQUEST['a'] == 1) { ?>
		<script>
			window.top.location.href = "group-request.html?g=<?php echo $_REQUEST['dltGroupId']; ?>&q=1";
		</script>
		<?php
	} else {

		if ($_REQUEST['page'] == 1) { ?>
			<script>
				parent.reloadPage();
			</script>
		<?php } else { ?>
			<script>
				parent.reloadPage();
			</script>
		<?php }

	}

}



if ($_REQUEST['action'] == 'uploadgroupimage' && $_REQUEST['groupId'] != '' && $_FILES['myphotofile']['name'] != '') {

	$strFileExtention = findExtension($_FILES['myphotofile']['name']);


	if ($strFileExtention == 'jpg' || $strFileExtention == 'jpeg' || $strFileExtention == 'png' || $strFileExtention == 'gif') {
		$fileExtention = 'photo';
	}
	if ($strFileExtention == 'pdf') {
		$fileExtention = 'pdf';
	}
	if ($strFileExtention == 'doc' || $strFileExtention == 'docx') {
		$fileExtention = 'doc';
	}
	if ($strFileExtention == 'ppt' || $strFileExtention == 'pptx') {
		$fileExtention = 'ppt';
	}
	if ($strFileExtention == 'xls' || $strFileExtention == 'xlsx') {
		$fileExtention = 'xls';
	}
	if ($strFileExtention == 'txt' || $strFileExtention == 'text') {
		$fileExtention = 'txt';
	}

	if ($fileExtention == '') {

		?>
		<script>
			parent.$('#commonloader').hide();
			parent.$('#sharepopup').hide();
			parent.showerrormsg('Error', 'Oops! Please upload file with extension only .jpg, .png, .gif, .pdf, .doc, .docx, .ppt, .pptx, .xls, .xlsx, .text.', '');
		</script>
		<?php
		exit();

	}


	?>
	<script>
		parent.showloading('sharepopinner');
		parent.$('#sharepopup').show();
	</script>
	<?php
	$groupId = decodeStr($_REQUEST['groupId']);

	$timename = time();



	$file_name = time() . basename($_FILES["myphotofile"]["name"]);
	$file_name = preg_replace('!\s+!', '-', $file_name);
	copy($_FILES['myphotofile']['tmp_name'], 'groupuploads/' . $file_name);


	$file_name_big = 'x_' . time() . basename($_FILES["myphotofile"]["name"]);
	$file_name_big = preg_replace('!\s+!', '-', $file_name_big);
	copy($_FILES['myphotofile']['tmp_name'], 'groupuploads/' . $file_name_big);


	$upimg = 'groupuploads/' . $file_name;
	//image_fix_orientation($upimg);
//generate_image_thumbnail($upimg, $upimg,'200','200');





	unset($insertFields);
	unset($insertVals);

	$insertFields[0] = "userId";
	$insertFields[1] = "groupId";
	$insertFields[2] = "fileName";
	$insertFields[3] = "fileType";

	$insertVals[0] = $_SESSION["sessUserId"];
	$insertVals[1] = $groupId;
	$insertVals[2] = $file_name;
	$insertVals[3] = 'file';

	$resInsert = insertDB(_GROUP_FILE_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	?>
	<script>
		parent.$('#sharepopup').show();
		parent.$('#sharepopup h2').text('Upload file');
		parent.$('#sharepopinner').load("<?php echo $fullurl; ?>sharepopupinner.php?fileId=<?php echo $resInsert; ?>&filename=<?php echo $showfile_name; ?>");
	</script>
	<?php

}


if ($_REQUEST['action'] == 'uploadgroupfile' && $_REQUEST['groupgroupId'] != '' && trim($_REQUEST['groupFileId']) != '' && $_REQUEST["msgType"] != '') {

	$groupId = decodeStr($_REQUEST['groupgroupId']);
	$groupFileId = decodeStr($_REQUEST['groupFileId']);
	$fileName = normalclean($_REQUEST['fileName']);
	$filegroupchatfield = normalclean($_REQUEST['filegroupchatfield']);



	$sqlGroupMembers = "";
	$sqlGroupMembers = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . decodeStr($_REQUEST["groupgroupId"]) . " and status=1 and userStatus=0 and groupId IN (select id from " . _GROUP_MASTER_TABLE_ . " where groupStatus=0)  and userId=" . $_SESSION["sessUserId"] . " order by id desc ";
	$resGroupMembers = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
	if ($resGroupMembers) {

		$dateAdded = time();
		$sql_ins = "insert into " . _GROUP_CHAT_MASTER_TABLE_ . " set status=1,userId='" . $_SESSION["sessUserId"] . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . $filegroupchatfield . "',groupId='" . $groupId . "',fileId='" . $groupFileId . "',msgType='" . $_REQUEST["msgType"] . "',fileName='" . $fileName . "'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));




		$dd = "SELECT * from " . _GROUP_CHAT_MASTER_TABLE_ . " WHERE groupId= " . $groupId . " order by id desc ";
		$ee = mysqli_query($conn, $dd) or die(mysqli_error($conn));
		$rowGroupchat = mysqli_fetch_array($ee);

		$selectFields = [];
		$whereFields = [];
		$whereVals = [];

		$sqlGroupMembers = "";
		$sqlGroupMembers = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $groupId . " and status=1 and userStatus=0 order by id desc ";
		$resGroupMembers = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
		if ($resGroupMembers) {
			while ($rowgroup = mysqli_fetch_array($resGroupMembers)) {
				$sql_ins = "insert into " . _GROUP_GOT_MSG_TABLE_ . " set status=0,userId='" . $rowgroup["userId"] . "',groupId='" . $groupId . "',chatId='" . $rowGroupchat["id"] . "'";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			}

		}

		?>
		<script>
			parent.$('#sharepopinner').html('');
			parent.$('#sharepopup').hide();
			parent.$('#groupchatlist').load('groupchatlist.php?groupId=<?php echo $_REQUEST["groupgroupId"]; ?>');





			<?php

			$g = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id=" . $groupId . " ";
			$h = mysqli_query($conn, $g) or die(mysqli_error($conn));
			$groupname = mysqli_fetch_array($h);



			$ga = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " where groupId='" . $groupname["id"] . "'  AND userStatus=0 and status=1 and userId!=" . $_SESSION["sessUserId"] . "";
			$hb = mysqli_query($conn, $ga) or die(mysqli_error($conn));
			while ($groupuser = mysqli_fetch_array($hb)) {

				$token = '';
				$sqlMsgToken = "";
				$sqlMsgToken = "select token from " . _MOBILE_NOTIFICATION_TABLE_ . " where userId='" . $groupuser["userId"] . "' ORDER BY id desc ";
				$resMsgToken = mysqli_query($conn, $sqlMsgToken);
				$getLastToken = mysqli_fetch_array($resMsgToken);
				$token = $getLastToken["token"];


				?>
				parent.$("#sendalert").load('app/firebase/Send.php?title=<?php echo str_replace(" ", "%20", $groupname["groupName"]) . ',' . $groupname["id"]; ?>&message=<?php echo $notimessage; ?>&token=<?php echo $token; ?>&groupId=<?php echo $groupname["id"]; ?>');
				<?php
			}
			?>

		</script>
		<?php
	}

}

if ($_REQUEST['action'] == 'urlgroup' && $_REQUEST['urlgroupId'] != '' && trim($_REQUEST['posturl']) != '') {/*

$groupId = decodeStr($_REQUEST['urlgroupId']);
$filegroupchatfield = trim($_REQUEST['posturl']);

function addhttp($url) {
if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
$url = "http://" . $url;
}
return $url;
}

$filegroupchatfield=normalclean(addhttp($filegroupchatfield));

$filegroupchatfield=$filegroupchatfield;

$dateAdded=time();
$sql_ins="insert into "._GROUP_CHAT_MASTER_TABLE_." set status=1,userId='".$_SESSION["sessUserId"]."',chatBy='".$_SESSION["sessUserId"]."',dateAdded='$dateAdded',chatText= '".$filegroupchatfield."',groupId='".$groupId."',msgType='url'";
mysql_query($sql_ins) or die(mysql_error());

$dd="SELECT * from "._GROUP_CHAT_MASTER_TABLE_." WHERE groupId= ".$groupId." order by id desc ";
$ee=mysql_query($dd) or die(mysql_error());
$rowGroupchat=mysql_fetch_array($ee);

unset($selectFields);
unset($whereFields);
unset($whereVals);

$sqlGroupMembers="";
$sqlGroupMembers="select * from "._GROUP_MEMBER_MASTER_TABLE_." WHERE groupId= ".$groupId." and status=1 order by id desc ";
$resGroupMembers=getRecords(_GROUP_MEMBER_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlGroupMembers);
if($resGroupMembers)
{
while($rowgroup=mysql_fetch_array($resGroupMembers))
{
$sql_ins="insert into "._GROUP_GOT_MSG_TABLE_." set status=0,userId='".$rowgroup["userId"]."',groupId='".$groupId."',chatId='".$rowGroupchat["id"]."'";
mysql_query($sql_ins) or die(mysql_error());

}

}
?>
<script>
parent.$('#sharepopinner').html('');
parent.$('#sharepopup').hide();
parent.$('#groupchatlist').load('groupchatlist.php?groupId=<?php echo $_REQUEST["urlgroupId"];?>');




</script>
<?php


*/
}

if ($_REQUEST['action'] == 'sendtouserinvitation' && trim($_REQUEST['txtuseremail']) != '' && $_REQUEST['groupinvitationid'] != '') {

	$useremailaddress = trim($_REQUEST['txtuseremail']);
	$arrsEmails = explode(',', $useremailaddress);
	foreach ($arrsEmails as $email) {

		if ($email != '') {

			if (isValidEmailFunc(trim($email)) == 'n') {
				?>
				<script>
					parent.showerrormsg('Error', 'Invalid "<?php echo $email; ?>" email address.', '');
				</script>
				<?php
				exit();
			} else {

				$userEmailId = trim($email);
				$sqlCheck = "";
				$sqlCheck = mysqli_query(
					$conn,
					"SELECT * FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " 
     WHERE userId IN (
         SELECT userId FROM " . _USERS_MASTER_TABLE_ . " WHERE email='" . $userEmailId . "'
     ) 
     AND groupId=" . decodeStr(decodeStr($_REQUEST['groupinvitationid']))
				);

				if (mysqli_num_rows($sqlCheck) > 0) {
					?>
					<script>
						parent.showerrormsg('Error', 'This email address "<?php echo $userEmailId; ?>" already registered with <?php echo $companNameTitle; ?>.', '');
					</script>
					<?php
					exit();
				} else {

					$invitegroupname = trim($_REQUEST['invitegroupname']);

					$mygroupId = trim($_REQUEST['groupinvitationid']);
					$mycontactid = trim($_REQUEST['mycontactid']);

					$mailBodyContent = '';
					$mailBodyContent = '<div style="margin:0 auto;padding:30px 0 40px;display:block;box-sizing:border-box; max-width: 600px;"><table style="width:100%;color:#434245" cellspacing="0" cellpadding="0" border="0"><tbody><tr><td style="box-sizing:border-box"><table cellspacing="0" cellpadding="0" border="0"><tbody><tr><td><img style="width:190px;height:30px;margin:0 0 15px 0;padding-right:30px;padding-left:30px" alt="" src="' . $fullurl . 'images/sdglogo.png" height="38" width="38"><h1 style="font-size:30px;padding-right:30px;padding-left:30px">Join ' . $invitegroupname . ' on ' . $companNameTitle . '</h1><p style="font-size:17px;padding-right:30px;padding-left:30px">' . $myname . ' (' . $myemail . ') has invited you to join the ' . $companNameTitle . ' team <strong>' . $invitegroupname . '</strong>. Join now to start collaborating!</p><div style="padding-right:30px;padding-left:30px"><a href="' . $fullurl . 'invitation.html?groupId=' . $mygroupId . '&action=joingroup" style="min-width:234px;border:13px solid #1c267a;border-radius:4px;background-color:#1c267a;font-size:20px;color:#ffffff;display:inline-block;text-align:center;vertical-align:top;font-weight:900;text-decoration:none!important">Join Now</a></div><div style="padding-right:30px;padding-left:30px"><div style="padding:30px 0 22px;margin:0;padding-top:20px"></div></div></td></tr></tbody></table></td></tr></tbody></table></div>';


					$subject = $myname . " has invited you to join a " . $companNameTitle . " team";


					/*			$headers = 'From: Konectt<do_not_reply@scgindia.in>' . "\r\n";
								$headers .= "MIME-Version: 1.0\r\n";
								$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";

								$mailSent=@mail($email,$subject,$mailBodyContent,$headers);*/

					send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);


					?>
					<script>
						parent.$('#txtuseremail').val('');
						parent.$('#showinvitediv').hide();
						parent.$('#hideinvitediv').show();
					</script>
					<?php

				}

			}


		}

	}
}


if (isset($_FILES['imagefileevent']) && $_FILES['imagefileevent']['name'] != '' && $_REQUEST['eventId'] != '') {


	$postId = $_REQUEST['eventId'];
	$dateAdded = time();

	$timename = time();
	$file_name = $_FILES['imagefileevent']['name'];
	$fileExt = findExtension($file_name);

	if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {
		$file_name = $timename . $file_name;
		$file_name = preg_replace('!\s+!', '-', $file_name);
		copy($_FILES['imagefileevent']['tmp_name'], "uploads/" . $file_name);


		$upimg = 'uploads/' . $file_name;

		//image_fix_orientation($upimg);
		//generate_image_thumbnail($upimg, $upimg,'800','800');


		$sql_ins = "insert into " . _EVENT_IMAGE_MASTER_TABLE_ . " set imageName='$file_name',eventId='$postId',dateAdded='$dateAdded'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
		?>
		<script>
			parent.$("#imagebx").load('upload_photo_event.php?eventId=<?php echo $_REQUEST['eventId']; ?>');
		</script>
		<?php
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.showerrormsg('Error', 'Oops! Please upload image file with extension only .jpg, .png, .gif.', '');
		</script>
		<?php
	}


}

if ($_REQUEST['action'] == 'deleventimgact' && $_REQUEST['deleventimgId'] != '' && $_REQUEST['eventId'] != '') {

	$id = decodeStr($_REQUEST['deleventimgId']);

	$sql_inss = "SELECT imageName from " . _EVENT_IMAGE_MASTER_TABLE_ . " WHERE id= " . $id . " and eventId=" . decodeStr($_REQUEST['eventId']) . " ";
	$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
	$rowResults = mysqli_fetch_array($resresults);
	$imageName = $rowResults["imageName"];


	if ($imageName != '') {
		unlink("uploads/" . $imageName);
		unlink("uploads/x_" . $imageName);
	}

	$sql_ins = "DELETE FROM " . _EVENT_IMAGE_MASTER_TABLE_ . " WHERE id= " . $id . "  and eventId=" . decodeStr($_REQUEST['eventId']) . "  ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));



	?>
	<script>
		parent.$("#imagebx").load('<?php echo $fullurl; ?>upload_photo_event.php?eventId=<?php echo decodeStr($_REQUEST['eventId']); ?>');
	</script>

	<?php
}


if ($_REQUEST['action'] == 'profilephoto' && $_FILES['eventprofilephoto']['name'] != '' && $_REQUEST['eventId'] != '') {

	$eventId = decodeStr($_REQUEST['eventId']);


	$timename = time();
	$file_name = $_FILES['eventprofilephoto']['name'];
	$fileExt = findExtension($file_name);

	if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {
		$eventThumbOld = $_REQUEST['eventThumbOld'];
		if ($eventThumbOld != '') {
			unlink("uploads/" . $eventThumbOld);
			unlink("uploads/x_" . $eventThumbOld);
		}

		$file_name = $timename . $file_name;
		$file_name = preg_replace('!\s+!', '-', $file_name);
		copy($_FILES['eventprofilephoto']['tmp_name'], "uploads/" . $file_name);


		$sql_ins = "UPDATE " . _EVENT_MASTER_TABLE_ . " set eventThumb='$file_name' WHERE id='$eventId'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		?>
		<script>
			parent.reloadPage();
		</script>
		<?php
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.showerrormsg('Error', 'Oops! Please upload image file with extension only .jpg, .png, .gif.', '');
		</script>
		<?php
	}

}

if ($_REQUEST['action'] == 'profilephoto' && $_FILES['eventbannerphoto']['name'] != '' && $_REQUEST['eventId'] != '') {

	$eventId = decodeStr($_REQUEST['eventId']);


	$timename = time();
	$file_name = $_FILES['eventbannerphoto']['name'];
	$fileExt = findExtension($file_name);

	if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {

		$eventBannerOld = $_REQUEST['eventBannerOld'];
		if ($eventBannerOld != '') {
			unlink("uploads/" . $eventBannerOld);
			unlink("uploads/x_" . $eventBannerOld);
		}

		$file_name = $timename . $file_name;
		$file_name = preg_replace('!\s+!', '-', $file_name);
		copy($_FILES['eventbannerphoto']['tmp_name'], "uploads/" . $file_name);

		$sql_ins = "UPDATE " . _EVENT_MASTER_TABLE_ . " set eventBanner='$file_name' WHERE id='$eventId'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		?>
		<script>
			parent.reloadPage();
		</script>

		<?php
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.showerrormsg('Error', 'Oops! Please upload image file with extension only .jpg, .png, .gif.', '');
		</script>
		<?php
	}
}

if (isset($_REQUEST['msgcontactId']) && $_REQUEST['msgcontactId'] != '' && $_REQUEST['action'] == 'sendmsgtocontact' && trim($_REQUEST['txtmsg']) != '') {


	$aaa = "SELECT userId from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . decodeStr($_REQUEST['msgcontactId']) . "'";
	$res55 = mysqli_query($conn, $aaa);
	$numrows = mysqli_num_rows($res55);
	if ($numrows > 0) {


		$sql = "SELECT sendMeEmail from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId= " . decodeStr($_REQUEST['msgcontactId']) . " ";
		$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
		$getUserSettings = mysqli_fetch_array($getSql);

		if ($getUserSettings["sendMeEmail"] == 1) {

			$a = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,email from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . decodeStr($_REQUEST['msgcontactId']) . "' ";
			$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
			$userres = mysqli_fetch_array($b);
			$email = $userres['email'];



			$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,cityName,countryName from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
			$res52 = mysqli_query($conn, $aa2);
			$getuser2 = mysqli_fetch_array($res52);

			$firstName2 = $getuser2['firstName'];
			$lastName2 = $getuser2['lastName'];
			$profilePhoto2 = $getuser2['profilePhoto'];
			$jobTitle = $getuser2["jobTitle"];
			$companyName = $getuser2["companyName"];
			$userurl2 = $getuser2["userurl"];
			$cityName = $getuser2["cityName"];
			$countryName = $getuser2["countryName"];

			if ($profilePhoto2 != '') {
				$profilePhoto2 = $profilePhoto2;
			} else {
				$profilePhoto2 = 'user-placeholder.jpg';
			}



			$mailBodyContent .= '';
			$mailBodyContent .= '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
    <tbody>
    <tr>
        <td align="center" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px">
                <tbody>
                <tr>
                    <td align="center" valign="top" style="width:100%;padding:20px 0">
                        <a href="' . $fullurl . '" target="_blank" >
                            <img src="' . $fullurl . 'images/sdglogo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
                </tr>
                <tr>
                  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">
                        <div style="color:#666666; font-size:12px; margin-bottom:10px;">You have a new message</div>

					  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">

					  <div style="text-align:center; margin-bottom:5px; margin-top:5px;font-size:18px;"><strong>' . $firstName2 . '</strong> sent you a message</div>
					  <div style="text-align:center; margin-top:10px; margin-bottom:30px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
  <tbody><tr>
    <td colspan="2" align="center"><a href="' . $fullurl . 'messaging.html?cuid=' . $_SESSION['sessUserId'] . '&t=6" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#0abe51;border-radius:5px;margin-bottom: 0px;" target="_blank">View Message</a></td>
    </tr>
</tbody></table>
</div>
					    <div style="text-align:center;"><div style="
    width: 80px;
    height: 80px;
    overflow: hidden;margin:auto;
    margin-bottom:12px;
    border-radius: 100%;
    border: 3px #e9e9e9 solid; margin:auto;
"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl2 . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2"><img src="' . $fullurl . 'uploads/' . $profilePhoto2 . '" style="
    width: 100%;
"></a></div>
<div style="text-align:center; margin-bottom:5px; margin-top:5px;"><strong>' . $firstName2 . ' ' . $lastName2 . '</strong></div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $jobTitle . ' at ' . $companyName . '</div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $cityName . ', ' . $countryName . '</div>
</div>
					  </div>

                  </td>
                </tr>
                <tr>
                    <td align="center" style="padding:40px;margin:0">
                       <div style="text-align:center; font-size:12px; margin-bottom:20px;">

                       <a href="' . $fullurl . 'privacy.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Privacy</a> -

                          <a href="' . $fullurl . 'terms.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Terms</a> -

                        <a href="' . $fullurl . 'about.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">About</a> -

                          <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div>
<p style="margin:0;padding:0;font-family:"Open Sans",Arial,Helvetica,sans-serif;line-height:24px;color:#616161;font-size:14px;text-align:center">
                             Powered by <a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $domainname . '</a></p>                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</div>';


			$subject = 'You have a new message on ' . $companNameTitle . '';

			send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);


		}

	}

	$dateAdded = time();
	$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=1,userId='" . $_SESSION["sessUserId"] . "',contactId='" . decodeStr($_REQUEST["msgcontactId"]) . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . addslashes($_REQUEST["txtmsg"]) . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=0,userId='" . decodeStr($_REQUEST["msgcontactId"]) . "',contactId='" . $_SESSION["sessUserId"] . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . addslashes($_REQUEST["txtmsg"]) . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));



	?>

	<script>

		//parent.$('#sendmsg').html('<div style="text-align:center; font-size:16px; padding-bottom:20px; font-waight:bold;">Message sent successfully.</div>');
		parent.showsusmsg('SUCCESS', 'Your message sent successfully.', '');
	</script>
	<?php
}



if (isset($_FILES['groupimagefilehome']) && $_FILES['groupimagefilehome']['name'] != '' && $_REQUEST['groupId'] != '') {


	$groupId = decodeStr($_REQUEST['groupId']);
	$grouppostId = decodeStr($_REQUEST['grouppostId']);

	$imageType = 4;
	$dateAdded = time();

	$timename = time();
	$file_name = $_FILES['groupimagefilehome']['name'];
	$fileExt = findExtension($file_name);

	if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {
		$file_name = $timename . $file_name;
		$file_name = preg_replace('!\s+!', '-', $file_name);
		copy($_FILES['groupimagefilehome']['tmp_name'], "uploads/" . $file_name);



		$sql_inss = "SELECT imageName from " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . $grouppostId . " ";
		$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
		$rowResults = mysqli_fetch_array($resresults);
		$imageName = $rowResults["imageName"];



		if ($imageName != '') {
			unlink("uploads/" . $imageName);
			unlink("uploads/x_" . $imageName);
		}

		$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . $grouppostId . "  ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


		$sql_ins = "insert into " . _IMAGE_MASTER_TABLE_ . " set imageName='$file_name',postId='$grouppostId',dateAdded='$dateAdded',imageType= " . $imageType . "";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		?>
		<script>
			parent.$('#uploadgroupboximage').load('<?php echo $fullurl; ?>loadgroupphoto.php');
		</script>

		<?php
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.showerrormsg('Error', 'Oops! Please upload image file with extension only .jpg, .png, .gif.', '');
		</script>
		<?php
	}


}

if ($_REQUEST['action'] == 'removegrouppostimg' && trim($_REQUEST['postId']) != '') {


	$sql_inss = "SELECT imageName from " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . decodeStr($_REQUEST['postId']) . " ";
	$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
	$rowResults = mysqli_fetch_array($resresults);
	$imageName = $rowResults["imageName"];



	if ($imageName != '') {
		unlink("uploads/" . $imageName);
		unlink("uploads/x_" . $imageName);
	}

	$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . decodeStr($_REQUEST['postId']) . "  ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));



	?>
	<script>
		parent.$('#uploadgroupboximage').load('<?php echo $fullurl; ?>loadgroupphoto.php');
	</script>

	<?php

}

if (isset($_FILES['companylogoimage']) && $_FILES['companylogoimage']['name'] != '' && $_REQUEST['postId'] != '') {


	$postId = $_REQUEST['postId'];
	$imageType = 8;
	$companylogoimageOld = $_REQUEST['companylogoimageOld'];
	$dateAdded = time();

	$timename = time();
	$file_name = $_FILES['companylogoimage']['name'];
	$fileExt = findExtension($file_name);

	if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {


		$file_name = $timename . $file_name;
		$file_name = preg_replace('!\s+!', '-', $file_name);
		copy($_FILES['companylogoimage']['tmp_name'], "uploads/" . $file_name);


		$upimg = 'uploads/' . $file_name;

		//image_fix_orientation($upimg);
//generate_image_thumbnail($upimg, $upimg,'800','800');


		if ($companylogoimageOld != '') {
			unlink("uploads/" . $companylogoimageOld);
			unlink("uploads/x_" . $companylogoimageOld);
		}

		$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . $postId . " and imageType=8 ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


		$sql_ins = "insert into " . _IMAGE_MASTER_TABLE_ . " set imageName='$file_name',postId='$postId',dateAdded='$dateAdded',imageType= " . $imageType . "";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		?>
		<script>
			parent.$('#imagebx').load('upload_company_logo.php?postId=<?php echo $_REQUEST['postId']; ?>');
		</script>

		<?php
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.showerrormsg('Error', 'Oops! Please upload image file with extension only .jpg, .png, .gif.', '');
		</script>
		<?php
	}



}

if ($_REQUEST['action'] == 'delcmplogo' && $_REQUEST['cmpdelId'] != '' && $_REQUEST['postId'] != '') {

	$id = decodeStr($_REQUEST['cmpdelId']);
	$oldimg = $_REQUEST['oldimg'];
	if ($oldimg != '') {
		unlink("uploads/" . $oldimg);
		unlink("uploads/x_" . $oldimg);
	}

	$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE id= " . $id . "  and postId=" . decodeStr($_REQUEST['postId']) . "  ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	?>
	<script>
		parent.$("#imagebx").load('<?php echo $fullurl; ?>upload_company_logo.php?postId=<?php echo decodeStr($_REQUEST['postId']); ?>');
	</script>
	<?php
}



if (isset($_REQUEST['cmntid']) && $_REQUEST['cmntid'] != '' && $_REQUEST['action'] == 'dltcmnt') {
	$dltid = decodeStr($_REQUEST['cmntid']);

	$sql_ins2 = "select postId,postType FROM " . _COMMENT_MASTER_TABLE_ . " WHERE  id='" . $dltid . "'  ";
	$sql2 = mysqli_query($conn, $sql_ins2) or die(mysqli_error($conn));
	$sql2 = mysqli_fetch_array($sql2);

	$postId = $sql2['postId'];
	$postType = $sql2['postType'];

	$sql_ins = "select id FROM " . _COMMENT_MASTER_TABLE_ . " WHERE  id='" . $dltid . "'  and userId=" . $_SESSION["sessUserId"] . " ";
	$sql = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	$s = mysqli_num_rows($sql);


	$sql_ins1 = "select id FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE  id='" . $sql2["postId"] . "'  and userId=" . $_SESSION["sessUserId"] . "  ";
	$sql1 = mysqli_query($conn, $sql_ins1) or die(mysqli_error($conn));
	$s1 = mysqli_num_rows($sql1);

	if ($s > 0) {
		$sql_ins = "DELETE FROM " . _COMMENT_MASTER_TABLE_ . " WHERE  id='" . $dltid . "'  ";
		$sql = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _COMMENT_MASTER_TABLE_ . " WHERE  parentId='" . $dltid . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	}


	if ($s1 > 0) {
		$sql_ins = "DELETE FROM " . _COMMENT_MASTER_TABLE_ . " WHERE  id='" . $dltid . "'  ";
		$sql = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _COMMENT_MASTER_TABLE_ . " WHERE  parentId='" . $dltid . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	}

	if ($postId != 0 && $postType != '') {
		$aa = "select id from " . _COMMENT_MASTER_TABLE_ . " where postId=" . $postId . " and postType=" . $postType . " and parentId=0 ";
		$res5 = mysqli_query($conn, $aa);
		$totalpostcomment = mysqli_num_rows($res5);
	}
	?>
	<script>
		parent.$('#alertpopup').hide();
		parent.$('#cmntid<?php echo $dltid; ?>').slideUp();
		<?php
		if ($postId != 0 && $postType != '') { ?>
			parent.$('#commentdisplaybox<?php echo $postId; ?><?php echo $postType; ?> span').text('<?php echo $totalpostcomment; ?>');
			<?php
		}
		?>
	</script>
	<?php
}

if (isset($_REQUEST['cmntrplid']) && $_REQUEST['cmntrplid'] != '' && $_REQUEST['action'] == 'dltreply') {
	$dltid = decodeStr($_REQUEST['cmntrplid']);

	$sql_ins = "DELETE FROM " . _COMMENT_MASTER_TABLE_ . " WHERE  id='" . $dltid . "'  ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	?>
	<script>
		parent.$('#alertpopup').hide();
		parent.$('#cmntrplid<?php echo $dltid; ?>').slideUp();
	</script>
	<?php
}

if ($_REQUEST['action'] == 'cmpprofilephoto' && $_FILES['companyprofilephoto']['name'] != '' && $_REQUEST['postId'] != '') {

	$postId = decodeStr($_REQUEST['postId']);
	$imageType = 8;
	$companylogoimageOld = $_REQUEST['companylogoimageOld'];
	$dateAdded = time();

	$timename = time();
	$file_name = $_FILES['companyprofilephoto']['name'];

	$file_name = $timename . $file_name;
	$file_name = preg_replace('!\s+!', '-', $file_name);
	copy($_FILES['companyprofilephoto']['tmp_name'], "uploads/" . $file_name);


	$upimg = 'uploads/' . $file_name;

	//image_fix_orientation($upimg);
//generate_image_thumbnail($upimg, $upimg,'800','800');


	if ($companylogoimageOld != '' && $companylogoimageOld != 'company.png') {
		unlink("uploads/" . $companylogoimageOld);
		unlink("uploads/x_" . $companylogoimageOld);
	}

	$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE postId= " . $postId . " and imageType=8 ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	$sql_ins = "insert into " . _IMAGE_MASTER_TABLE_ . " set imageName='$file_name',postId='$postId',dateAdded='$dateAdded',imageType= " . $imageType . "";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	?>
	<script>
		parent.reloadPage();
	</script>

	<?php
}

if ($_REQUEST['action'] == 'cmpaboutcompany' && trim($_REQUEST['aboutCompany']) != '' && $_REQUEST['companyId'] != '') {

	$aboutCompany = clean($_POST['aboutCompany']);
	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);

	$insertFields[0] = "aboutCompany";

	$insertVals[0] = $aboutCompany;

	$whereFields[0] = "id";

	$whereVals[0] = decodeStr($_REQUEST['companyId']);

	$resUpdate = updateDB(_COMPANY_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	?>
	<script>
		parent.reloadPage();
	</script>

	<?php
}

if ($_REQUEST['action'] == 'allpostview' && $_REQUEST['postId'] != '') {

	$aa = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE id= " . decodeStr($_REQUEST["postId"]) . " ";
	$res5 = mysqli_query($conn, $aa);
	$articletext = mysqli_fetch_array($res5);

	if ($articletext['userId'] != $_SESSION["sessUserId"]) {

		unset($insertFields);
		unset($insertVals);
		unset($whereFields);
		unset($whereVals);

		$insertFields[0] = "viewStatus";

		$insertVals[0] = $articletext['viewStatus'] + 1;

		$whereFields[0] = "id";

		$whereVals[0] = decodeStr($_REQUEST["postId"]);

		$resUpdate = updateDB(_SHAREANDUPDATES_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	}

}


if (isset($_REQUEST['cmntrplid']) && $_REQUEST['msguserid'] != '' && $_REQUEST['action'] == 'sendmsguser' && trim($_REQUEST['txtmsg']) != '') {


	$tageduserid = str_replace("'", "", trim($_REQUEST['msguserid']));
	$tageduserid = rtrim($tageduserid, ",");

	if ($tageduserid != '') {

		$expElementVal = explode(",", $tageduserid);
		for ($elementCount = 0; $elementCount <= count($expElementVal) - 1; $elementCount++) {
			$contactId = $expElementVal[$elementCount];

			$dateAdded = time();
			$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=1,userId='" . $_SESSION["sessUserId"] . "',contactId='" . $contactId . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . normalclean($_REQUEST["txtmsg"]) . "'";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


			$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=0,userId='" . $contactId . "',contactId='" . $_SESSION["sessUserId"] . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . normalclean($_REQUEST["txtmsg"]) . "'";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			/*$sql_ins="UPDATE "._CONTACT_MASTER_TABLE_." SET chatStatus=1 WHERE contactId= ".$_SESSION["sessUserId"]." AND userId='".$contactId."' ";
			mysql_query($sql_ins) or die(mysql_error());

			 $sql_ins="UPDATE "._CHAT_MASTER_TABLE_." SET status=1 WHERE contactId= '".$contactId."' AND userId='".$_SESSION["sessUserId"]."' ";
			mysql_query($sql_ins) or die(mysql_error()); */


		}

		?>

		<script>
			//parent.$('#sendmsg').html('<div style="text-align:center; font-size:16px; padding-bottom:20px; font-waight:bold;">Message sent successfully.</div>');
			parent.showsusmsg('SUCCESS', 'Your message sent successfully.', '');
		</script>

		<?php

	}


}

if (isset($_REQUEST['setpressenter']) && $_REQUEST['setpressenter'] != '') {
	$_SESSION['sesssetpressenter'] = $_REQUEST['setpressenter'];
}


if (isset($_REQUEST['msguserid']) && $_REQUEST['msguserid'] != '' && $_REQUEST['action'] == 'shareprofile' && trim($_REQUEST['txtmsg']) != '') {

	$postId = decodeStr($_REQUEST['shareduserid']);

	$tageduserid = str_replace("'", "", trim($_REQUEST['msguserid']));
	$tageduserid = rtrim($tageduserid, ",");

	if ($tageduserid != '') {

		$expElementVal = explode(",", $tageduserid);
		for ($elementCount = 0; $elementCount <= count($expElementVal) - 1; $elementCount++) {
			$contactId = $expElementVal[$elementCount];

			$dateAdded = time();


			$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=1,userId='" . $_SESSION["sessUserId"] . "',contactId='" . $contactId . "',shareId='" . $postId . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . normalclean($_REQUEST["txtmsg"]) . "'";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


			$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=0,userId='" . $contactId . "',contactId='" . $_SESSION["sessUserId"] . "',shareId='" . $postId . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . normalclean($_REQUEST["txtmsg"]) . "'";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			$sql_ins2 = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "',userId='" . $contactId . "',postId='" . $postId . "', postType=12,notificationText='shareprofile',dateAdded='$dateAdded'";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));



		}

		?>

		<script>
			//parent.$('#sendmsg').html('<div style="text-align:center; font-size:16px; padding-bottom:20px; font-waight:bold;">Profile Shared successfully.</div>');
			parent.showsusmsg('SUCCESS', 'Profile shared successfully.', '');
		</script>

		<?php

	}
}

if (isset($_REQUEST['rmcontactid']) && $_REQUEST['rmcontactid'] != '' && $_REQUEST['action'] == 'removeconection') {
	$dateAdded = time();
	$userId = decodeStr($_REQUEST['rmcontactid']);

	$sql_ins = "DELETE FROM " . _CONTACT_MASTER_TABLE_ . " WHERE  contactId='" . $userId . "' and userId='" . $_SESSION['sessUserId'] . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "DELETE FROM " . _CONTACT_MASTER_TABLE_ . " WHERE contactId='" . $_SESSION['sessUserId'] . "' and userId='" . $userId . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}

if (isset($_REQUEST['rmcontactid']) && $_REQUEST['rmcontactid'] != '' && $_REQUEST['action'] == 'blockcontact') {
	$dateAdded = time();
	$userId = decodeStr($_REQUEST['rmcontactid']);
	$status = trim($_REQUEST['status']);
	if ($status == 1) {

		//$sql_ins="DELETE FROM "._CONTACT_MASTER_TABLE_." WHERE  contactId='".$userId."' and userId='".$_SESSION['sessUserId']."'";
//mysql_query($sql_ins) or die(mysql_error());

		//$sql_ins="DELETE FROM "._CONTACT_MASTER_TABLE_." WHERE contactId='".$_SESSION['sessUserId']."' and userId='".$userId."' ";
//mysql_query($sql_ins) or die(mysql_error());


		$sql_ins = "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET blockUser=1 WHERE contactId='" . $userId . "' AND userId='" . $_SESSION['sessUserId'] . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));   //This and above Queries updated by Imran,Rashid 12-01-2018


		$sql_ins = "INSERT INTO " . _BLOCKED_CONTACTS_TABLE_ . " SET contactId= " . $userId . ",userId=" . $_SESSION["sessUserId"] . ",dateAdded='" . $dateAdded . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	} else {

		//$sql_ins="INSERT INTO "._CONTACT_MASTER_TABLE_." SET status=1,contactId= ".$_SESSION["sessUserId"].",userId=".$userId.",dateAdded='".$dateAdded."'";
//mysql_query($sql_ins) or die(mysql_error());

		//$sql_ins="INSERT INTO "._CONTACT_MASTER_TABLE_." SET status=1,contactId= ".$userId.",userId=".$_SESSION["sessUserId"].",dateAdded='".$dateAdded."'";
//mysql_query($sql_ins) or die(mysql_error());


		$sql_ins = "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET blockUser=0 WHERE contactId='" . $userId . "' AND userId='" . $_SESSION['sessUserId'] . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn)); //This and above Queries updated by Imran,Rashid 12-01-2018

		$sql_ins = "DELETE FROM " . _BLOCKED_CONTACTS_TABLE_ . " WHERE  contactId='" . $userId . "' and userId='" . $_SESSION['sessUserId'] . "'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	}

	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}

if (isset($_REQUEST['rmcontactid']) && $_REQUEST['rmcontactid'] != '' && $_REQUEST['action'] == 'recommendations' && trim($_REQUEST['fullusername']) != '' && $_REQUEST['userurl'] != '') {
	$dateAdded = time();
	$contactId = decodeStr($_REQUEST['rmcontactid']);
	//$fullusername=normalclean($_REQUEST['fullusername']);
	$fullusername = $myname;
	//$userurl=$_REQUEST['userurl'];
	$userurl = '<a href="' . $fullurl . 'profile/' . encodeStr($_SESSION["sessUserId"]) . '/' . $userurl . '/recommend.html" target="_blank">' . $fullurl . 'profile/' . encodeStr($_SESSION["sessUserId"]) . '/' . $userurl . '.html</a>';
	$msgchat = normalclean($_REQUEST["pmessage"]) . '<br><br>Write ' . $fullusername . ' a recommendation:<br>' . $userurl;
	/*
	$sql_ins="insert into "._CHAT_MASTER_TABLE_." set status=1,userId='".$_SESSION["sessUserId"]."',contactId='".$contactId."',chatBy='".$_SESSION["sessUserId"]."',dateAdded='$dateAdded',chatText= '".$msgchat."'";
				mysql_query($sql_ins) or die(mysql_error());*/


	$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=0,userId='" . $contactId . "',contactId='" . $_SESSION["sessUserId"] . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . $msgchat . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	?>
	<script>
		parent.$('#rsuccess').show();
		parent.$('#frmposthomerecommend').hide();
		parent.showsusmsg('SUCCESS', 'Request has been sent successfully.', '');
	</script>
	<?php
}


if (isset($_REQUEST['rmcontactid']) && $_REQUEST['rmcontactid'] != '' && $_REQUEST['action'] == 'recommendeduser' && trim($_REQUEST['fullusername']) != '' && $_REQUEST['userurl'] != '') {
	$dateAdded = time();
	$contactId = decodeStr($_REQUEST['rmcontactid']);
	$fullusername = normalclean($_REQUEST['fullusername']);
	$userurl = $_REQUEST['userurl'];
	$userurl = '<a href="' . $_REQUEST['userurl'] . '" target="_blank">' . $_REQUEST['userurl'] . '</a>';
	$msgchat = $fullusername . ' sent you a recommendation<br /><br />Review Recommendation:<br>' . $userurl;

	/*$sql_ins="insert into "._CHAT_MASTER_TABLE_." set status=1,userId='".$_SESSION["sessUserId"]."',contactId='".$contactId."',chatBy='".$_SESSION["sessUserId"]."',dateAdded='$dateAdded',chatText= '".$msgchat."'";
				mysql_query($sql_ins) or die(mysql_error()); */


	$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=0,userId='" . $contactId . "',contactId='" . $_SESSION["sessUserId"] . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . $msgchat . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	$sql_ins = "insert into " . _USER_RECOMMENDATIONS_TABLE_ . " set userId='" . $_SESSION["sessUserId"] . "',contactId='" . $contactId . "',dateAdded='$dateAdded',recommendationText= '" . addslashes($_REQUEST["pmessage"]) . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	?>
	<script>
		parent.$('#rsuccess').show();
		parent.$('#frmposthomerecommend').hide();
		parent.showsusmsg('SUCCESS', 'Your recommendation has been submitted successfully.', '');
	</script>
	<?php
}

if ($_REQUEST['action'] == 'saveprofessinalexp' && trim($_REQUEST['jobTitle']) != '' && trim($_REQUEST['jobLocation']) != '' && trim($_REQUEST['companyName']) != '' && $_REQUEST['industry'] != 0 && $_REQUEST['frommonth'] != 0 && $_REQUEST['fromyear'] != 0 && (($_REQUEST['tomonth'] != 0 && $_REQUEST['toyear'] != 0) || ($_REQUEST['currentPosition'] == 1))) {
	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	if (trim($_REQUEST['professionalid']) != '') {

		if ($_REQUEST['currentPosition'] == 1) {

			$sql_ins = "update " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " set currentPosition=0 where userId= " . $_SESSION["sessUserId"] . " ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		}

		unset($insertFields);
		unset($insertVals);
		unset($whereFields);
		unset($whereVals);

		$insertFields[0] = "userId";
		$insertFields[1] = "jobTitle";
		$insertFields[2] = "companyName";
		$insertFields[3] = "employment";
		$insertFields[4] = "industry";
		$insertFields[5] = "currentPosition";
		$insertFields[6] = "frommonth";
		$insertFields[7] = "fromyear";
		$insertFields[8] = "tomonth";
		$insertFields[9] = "toyear";
		$insertFields[10] = "discipline";
		$insertFields[11] = "careerlevel";
		$insertFields[12] = "positiondetail";
		$insertFields[13] = "segment";
		$insertFields[14] = "legalform";
		$insertFields[15] = "employees";
		$insertFields[16] = "companywebsite";
		$insertFields[17] = "jobLocation";

		$insertVals[0] = $_SESSION["sessUserId"];
		$insertVals[1] = normalclean($_REQUEST['jobTitle']);
		$insertVals[2] = normalclean($_REQUEST['companyName']);
		$insertVals[3] = trim($_REQUEST['employment']);
		$insertVals[4] = trim($_REQUEST['industry']);
		$insertVals[5] = trim($_REQUEST['currentPosition']);
		$insertVals[6] = trim($_REQUEST['frommonth']);
		$insertVals[7] = trim($_REQUEST['fromyear']);
		$insertVals[8] = trim($_REQUEST['tomonth']);
		$insertVals[9] = trim($_REQUEST['toyear']);
		$insertVals[10] = trim($_REQUEST['discipline']);
		$insertVals[11] = trim($_REQUEST['careerlevel']);
		$insertVals[12] = normalclean($_REQUEST['positiondetail']);
		$insertVals[13] = trim($_REQUEST['segment']);
		$insertVals[14] = trim($_REQUEST['legalform']);
		$insertVals[15] = trim($_REQUEST['employees']);
		$insertVals[16] = trim($_REQUEST['companywebsite']);
		$insertVals[17] = trim($_REQUEST['jobLocation']);


		$whereFields[0] = "id";
		$whereFields[1] = "userId";

		$whereVals[0] = decodeStr(trim($_REQUEST['professionalid']));
		$whereVals[1] = $_SESSION['sessUserId'];

		$resUpdate = updateDB(_PROFESSIONAL_EXPERIENCE_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');


	} else {

		if ($_REQUEST['currentPosition'] == 1) {

			$sql_ins = "update " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " set currentPosition=0 where userId= " . $_SESSION["sessUserId"] . " ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		}

		unset($insertFields);
		unset($insertVals);

		$insertFields[0] = "userId";
		$insertFields[1] = "jobTitle";
		$insertFields[2] = "companyName";
		$insertFields[3] = "employment";
		$insertFields[4] = "industry";
		$insertFields[5] = "dateAdded";
		$insertFields[6] = "frommonth";
		$insertFields[7] = "fromyear";
		$insertFields[8] = "tomonth";
		$insertFields[9] = "toyear";
		$insertFields[10] = "currentPosition";
		$insertFields[11] = "discipline";
		$insertFields[12] = "careerlevel";
		$insertFields[13] = "positiondetail";
		$insertFields[14] = "segment";
		$insertFields[15] = "legalform";
		$insertFields[16] = "employees";
		$insertFields[17] = "companywebsite";
		$insertFields[18] = "jobLocation";

		$insertVals[0] = $_SESSION["sessUserId"];
		$insertVals[1] = normalclean($_REQUEST['jobTitle']);
		$insertVals[2] = normalclean($_REQUEST['companyName']);
		$insertVals[3] = trim($_REQUEST['employment']);
		$insertVals[4] = trim($_REQUEST['industry']);
		$insertVals[5] = time();
		$insertVals[6] = trim($_REQUEST['frommonth']);
		$insertVals[7] = trim($_REQUEST['fromyear']);
		$insertVals[8] = trim($_REQUEST['tomonth']);
		$insertVals[9] = trim($_REQUEST['toyear']);
		$insertVals[10] = trim($_REQUEST['currentPosition']);
		$insertVals[11] = trim($_REQUEST['discipline']);
		$insertVals[12] = trim($_REQUEST['careerlevel']);
		$insertVals[13] = normalclean($_REQUEST['positiondetail']);
		$insertVals[14] = trim($_REQUEST['segment']);
		$insertVals[15] = trim($_REQUEST['legalform']);
		$insertVals[16] = trim($_REQUEST['employees']);
		$insertVals[17] = trim($_REQUEST['companywebsite']);
		$insertVals[18] = trim($_REQUEST['jobLocation']);

		$resUpdate = insertDB(_PROFESSIONAL_EXPERIENCE_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');



	}




	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlOptions = "";
	$sqlOptions = "SELECT jobTitle,companyName FROM " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " WHERE userId=" . $_SESSION["sessUserId"] . " order by fromyear desc LIMIT 0,1 ";
	$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
	if ($resOptions) {
		while ($rowOptions = mysqli_fetch_array($resOptions)) {


			$userjobTitle = $rowOptions['jobTitle'];
			$usercompanyName = $rowOptions['companyName'];

			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);

			$insertFields[0] = "jobTitle";
			$insertFields[1] = "companyName";
			$insertFields[2] = "industryId";

			$insertVals[0] = $userjobTitle;
			$insertVals[1] = $usercompanyName;
			$insertVals[2] = trim($_REQUEST['industry']);

			$whereFields[0] = "userId";

			$whereVals[0] = $_SESSION['sessUserId'];

			$resUpdate = updateDB(_USERS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, ''); // verified the user email address

		}

	}


	if (trim($_REQUEST['currentPosition']) == 1 && $_SESSION['jobupdate'] != 1) {

		$a = "SELECT profilePhoto,firstName,lastName,userurl from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $_SESSION['sessUserId'] . "";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$userres = mysqli_fetch_array($b);

		if ($userres["profilePhoto"] != '') {
			$userphoto = $userres["profilePhoto"];
		} else {
			$userphoto = 'user-placeholder.jpg';
		}
		$firstName = $userres["firstName"];
		$lastName = $userres["lastName"];
		$friendnameurl = $userres['userurl'];

		$aa = "SELECT companyName from " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " WHERE userId= " . $_SESSION['sessUserId'] . " and currentPosition=1";
		$bb = mysqli_query($conn, $aa) or die(mysqli_error($conn));
		$companyuserres = mysqli_fetch_array($bb);



		$selectFields = [];
		$whereFields = [];
		$whereVals = [];


		$sqlUser = "";
		$sqlUser = "select * from " . _USERS_MASTER_TABLE_ . " where  activeYN='Y' and userId IN (select contactId from " . _CONTACT_MASTER_TABLE_ . " where userId=" . $_SESSION['sessUserId'] . "  and status=1)";
		$resUser = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlUser);
		if ($resUser) {
			while ($rowUser = mysqli_fetch_array($resUser)) {

				$email = $rowUser["email"];
				$userId = $rowUser["userId"];
				if ($rowUser["profilePhoto"] != '') {
					$userphoto2 = $rowUser["profilePhoto"];
				} else {
					$userphoto2 = 'user-placeholder.jpg';
				}

				$firstName2 = $rowUser["firstName"];
				$lastName2 = $rowUser["lastName"];

				$sql = "SELECT emailContactNewPosition from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId= " . $userId . " ";
				$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
				$getUserSettings = mysqli_fetch_array($getSql);

				if ($getUserSettings["emailContactNewPosition"] == 1) {


					$mailBodyContent = '';
					$mailBodyContent = '<div style="background-color: #dff6ff; width: 100%; overflow: hidden;">
	<div style="width: 600px; margin: auto; border-top: 4px solid #1a94c3; border-bottom: 4px solid #1a94c3; background-color: #fff; overflow: hidden; padding-top: 0px; box-sizing: border-box; font-family: arial; color: #4c4c4c; font-size: 14px; padding-bottom: 0;">
		<div style="padding:0 20px;box-sizing: border-box;overflow: hidden;">
		<a href="' . $fullurl . '" target="_blank" style="display: inline-block;padding: 10px;padding-left: 0;float: left;margin-bottom: 10px;">
		<img src="' . $fullurl . 'images/sdglogo.png" width="150px;">
		</a>
		<table width="150" style="float: right;" border="0;">
			<tbody><tr>
				<td>' . $firstName2 . ' ' . $lastName2 . '</td>
				<td><a style="float: right;width: 40px;"><img src="' . $fullurl . 'uploads/' . $userphoto2 . '" style="border-radius: 50%;width: 100%;"></a></td>
			</tr>
		</tbody></table>
		</div>
		<div style="background-color: #1a94c3;padding: 20px;overflow: hidden;width: 100%;box-sizing: border-box;padding-bottom: 10px;">
			<div style="color: #fff;font-size: 18px;text-align: center;">Your contacts on ' . $companNameTitle . ' seem to be doing great things in their professional career and we thought you may want to Congratulate them!</div>
			<div style="clear: both;width: 100%;float: left;text-align: center;">
			<a href="' . $fullurl . 'notifications.html" style="font-size: 14px;text-decoration: none;padding: 8px 12px; border: solid 1px #fff; color: #fff;margin-top: 15px;display: inline-block;">See all updates</a></div>
		</div>
		<div style="text-align: center;width: 100%;float: left;">
		<a href="#" style="width: 70px;display: inline-block;margin: 20px 0"><img src="' . $fullurl . 'uploads/' . $userphoto . '" style="border-radius: 50%;width: 100%;"></a>
		<div style="font-size: 16px;margin-bottom: 20px;"><strong>' . $firstName . ' ' . $lastName . '</strong> has a new job at ' . $companyuserres['companyName'] . '</div>
		<div style="display: block;margin-bottom: 30px;overflow: hidden;">
			<a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $friendnameurl . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2" style="border: solid 1px #e7e7e7;display: inline-block; padding: 8px 13px;text-decoration: none;color: #000;">View profile</a>
			<a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $friendnameurl . '/congratulate.html?cuid=' . $_SESSION['sessUserId'] . '&t=9" style="display: inline-block;padding: 8px 13px;background-color: #1a94c3;text-decoration: none;color: #fff;margin-left: 20px;">Congratulate </a>
		</div>
		</div>
	</div>
	</div>';


					$subject = "It seems " . $firstName . " has a new job!";

					send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

				}

				$sql_ins2 = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "',userId='" . $userId . "',postType=13,notificationText='changejob',dateAdded='" . time() . "'";
				mysqli_query($conn, $sql_ins2) or die(mysqli_error($conn));

				$_SESSION['jobupdate'] = 1;

			}

		}



	}


	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}

if (isset($_REQUEST['id']) && $_REQUEST['id'] != '' && $_REQUEST['action'] == 'dltproexp') {


	$dltid = decodeStr($_REQUEST['id']);

	$sql_ins = "DELETE FROM " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " WHERE id= " . $dltid . " and userId=" . $_SESSION['sessUserId'] . " ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlOptions = "";
	$sqlOptions = "SELECT jobTitle,companyName FROM " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " WHERE userId=" . $_SESSION["sessUserId"] . " order by fromyear desc LIMIT 0,1 ";
	$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
	if ($resOptions) {
		while ($rowOptions = mysqli_fetch_array($resOptions)) {


			$userjobTitle = $rowOptions['jobTitle'];
			$usercompanyName = $rowOptions['companyName'];

			unset($insertFields);
			unset($insertVals);
			unset($whereFields);
			unset($whereVals);

			$insertFields[0] = "jobTitle";
			$insertFields[1] = "companyName";

			$insertVals[0] = $userjobTitle;
			$insertVals[1] = $usercompanyName;

			$whereFields[0] = "userId";

			$whereVals[0] = $_SESSION['sessUserId'];

			$resUpdate = updateDB(_USERS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, ''); // verified the user email address

		}

	}

	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}



if ($_REQUEST['action'] == 'saveeducationalbg' && trim($_REQUEST['university']) != '' && trim($_REQUEST['fieldofstudy']) != '' && $_REQUEST['frommonth'] != 0 && $_REQUEST['fromyear'] != 0 && $_REQUEST['tomonth'] != 0 && $_REQUEST['toyear'] != 0) {
	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	if (trim($_REQUEST['educationalid']) != '') {


		unset($insertFields);
		unset($insertVals);
		unset($whereFields);
		unset($whereVals);

		$insertFields[0] = "userId";
		$insertFields[1] = "university";
		$insertFields[2] = "fieldofstudy";
		$insertFields[3] = "degree";
		$insertFields[4] = "toyear";
		$insertFields[5] = "specialisedsubjects";
		$insertFields[6] = "frommonth";
		$insertFields[7] = "fromyear";
		$insertFields[8] = "tomonth";
		$insertFields[9] = "description";

		$insertVals[0] = $_SESSION["sessUserId"];
		$insertVals[1] = normalclean($_REQUEST['university']);
		$insertVals[2] = normalclean($_REQUEST['fieldofstudy']);
		$insertVals[3] = normalclean($_REQUEST['degree']);
		$insertVals[4] = trim($_REQUEST['toyear']);
		$insertVals[5] = normalclean($_REQUEST['specialisedsubjects']);
		$insertVals[6] = trim($_REQUEST['frommonth']);
		$insertVals[7] = trim($_REQUEST['fromyear']);
		$insertVals[8] = trim($_REQUEST['tomonth']);
		$insertVals[9] = normalclean($_REQUEST['description']);


		$whereFields[0] = "id";
		$whereFields[1] = "userId";

		$whereVals[0] = decodeStr(trim($_REQUEST['educationalid']));
		$whereVals[1] = $_SESSION['sessUserId'];

		$resUpdate = updateDB(_EDUCATIONAL_BACKGROUND_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');


	} else {


		unset($insertFields);
		unset($insertVals);

		$insertFields[0] = "userId";
		$insertFields[1] = "university";
		$insertFields[2] = "fieldofstudy";
		$insertFields[3] = "degree";
		$insertFields[4] = "toyear";
		$insertFields[5] = "specialisedsubjects";
		$insertFields[6] = "frommonth";
		$insertFields[7] = "fromyear";
		$insertFields[8] = "tomonth";
		$insertFields[9] = "dateAdded";
		$insertFields[10] = "description";

		$insertVals[0] = $_SESSION["sessUserId"];
		$insertVals[1] = normalclean($_REQUEST['university']);
		$insertVals[2] = normalclean($_REQUEST['fieldofstudy']);
		$insertVals[3] = normalclean($_REQUEST['degree']);
		$insertVals[4] = trim($_REQUEST['toyear']);
		$insertVals[5] = normalclean($_REQUEST['specialisedsubjects']);
		$insertVals[6] = trim($_REQUEST['frommonth']);
		$insertVals[7] = trim($_REQUEST['fromyear']);
		$insertVals[8] = trim($_REQUEST['tomonth']);
		$insertVals[9] = time();
		$insertVals[10] = normalclean($_REQUEST['description']);

		$resUpdate = insertDB(_EDUCATIONAL_BACKGROUND_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	}
	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}

if (trim(isset($_REQUEST['id']) && $_REQUEST['id']) != '' && $_REQUEST['action'] == 'dlteducational') {


	$dltid = decodeStr($_REQUEST['id']);

	$sql_ins = "DELETE FROM " . _EDUCATIONAL_BACKGROUND_TABLE_ . " WHERE id= " . $dltid . " and userId=" . $_SESSION['sessUserId'] . " ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}

if (trim(isset($_REQUEST['id']) && $_REQUEST['id']) != '' && $_REQUEST['action'] == 'recaprov') {


	$upid = decodeStr($_REQUEST['id']);

	$sql_ins = "update " . _USER_RECOMMENDATIONS_TABLE_ . " set status=1 where contactId= " . $_SESSION["sessUserId"] . " and id=" . $upid . " ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}

if (trim(isset($_REQUEST['id']) && $_REQUEST['id']) != '' && $_REQUEST['action'] == 'delrec') {


	$dltid = decodeStr($_REQUEST['id']);

	$sql_ins = "DELETE FROM " . _USER_RECOMMENDATIONS_TABLE_ . " WHERE id= " . $dltid . " and contactId=" . $_SESSION['sessUserId'] . " ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}

if (trim(isset($_REQUEST['gprid']) && $_REQUEST['gprid']) != '' && $_REQUEST['action'] == 'delgrp') {

	$dltid = decodeStr($_REQUEST['gprid']);

	$password = clean($_POST['delgrppassword']);


	if (trim($password) != "") {
		$pass = md5($password);
		$sql = "SELECT userId from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' and password='" . $pass . "' ";
		$resSql = mysqli_query($conn, $sql);
		$getrows = mysqli_num_rows($resSql);
		if ($getrows > 0) {
			?>
			<script>
				parent.$('#errormsg').hide();
			</script>
			<?php

			$sql = "SELECT id,fileName FROM " . _GROUP_FILE_TABLE_ . " WHERE groupId= " . $dltid . "  ";
			$resSql = mysqli_query($conn, $sql);
			while ($rowGroup = mysqli_fetch_array($resSql)) {

				$sql_ins11 = "DELETE FROM " . _GROUP_FILE_TABLE_ . " WHERE id= " . $rowGroup["id"] . "  ";
				mysqli_query($conn, $sql_ins11) or die(mysqli_error($conn));

				if ($rowGroup["fileName"] != '') {
					unlink("groupuploads/" . $rowGroup["fileName"]);
					unlink("groupuploads/x_" . $rowGroup["fileName"]);
				}

			}


			$sqlChat = "SELECT id,fileName FROM " . _GROUP_CHAT_MASTER_TABLE_ . " WHERE groupId= " . $dltid . "  ";
			$resSqlChat = mysqli_query($conn, $sqlChat);
			while ($rowGroupChat = mysqli_fetch_array($resSqlChat)) {
				$sql_ins11 = "DELETE FROM " . _GROUP_CHAT_MASTER_TABLE_ . " WHERE id= " . $rowGroupChat["id"] . "  ";
				mysqli_query($conn, $sql_ins11) or die(mysqli_error($conn));

				if ($rowGroupChat["fileName"] != '') {
					unlink("groupuploads/" . $rowGroupChat["fileName"]);
					unlink("groupuploads/x_" . $rowGroupChat["fileName"]);
				}

			}

			$sql_ins111 = "DELETE FROM " . _NOTIFICATION_MASTER_TABLE_ . " WHERE groupId= " . $dltid . " and postType=4   ";
			mysqli_query($conn, $sql_ins111) or die(mysqli_error($conn));

			$sql = "SELECT groupThumb from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $dltid . " ";
			$resSql = mysqli_query($conn, $sql);
			$getGroupdata = mysqli_fetch_array($resSql);

			if ($getGroupdata["groupThumb"] != '') {
				unlink("uploads/" . $getGroupdata["groupThumb"]);
				unlink("uploads/x_" . $getGroupdata["groupThumb"]);
			}

			$sql_ins = "DELETE FROM " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $dltid . "  ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			$sql_ins = "DELETE FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $dltid . "  ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			$sql_ins = "DELETE FROM " . _TIMELINE_MASTER_TABLE_ . " WHERE groupId= " . $dltid . " and postType=4  ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


			$sql_ins = "DELETE FROM " . _GROUP_POST_MASTER_TABLE_ . " WHERE groupId= " . $dltid . " and postType=4    ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


			$sql_ins = "DELETE FROM " . _COMMENT_MASTER_TABLE_ . " WHERE postId= " . $dltid . " and postType=4  ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			$sql_ins111 = "DELETE FROM " . _GROUP_GOT_MSG_TABLE_ . " WHERE groupId= " . $dltid . " ";
			mysqli_query($conn, $sql_ins111) or die(mysqli_error($conn));

			$_SESSION["d"] = 1;
			?>
			<script>
				parent.reloadPage();
			</script>
			<?php
		} else {
			?>
			<script>
				parent.$('#errormsg').text('That password is incorrect. Try again.');
				parent.$('#errormsg').css('color', '#FF0000');
			</script>
			<?php
		}
	} else {
		?>
		<script>
			parent.$('#errormsg').text('Please enter your password');
			parent.$('#errormsg').css('color', '#FF0000');
		</script>
		<?php
	}


}

if ($_REQUEST['action'] == 'postandshare' && trim($_REQUEST['sharedata']) != '') {
	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	$sharepostText = addslashes($_REQUEST['sharepostText']);
	$sharedata = addslashes($_REQUEST['sharedata']);
	$oldpostId = decodeStr($_REQUEST['oldpostId']);

	$postText = '<div class="post-cnt">' . $sharepostText . '</div>' . $sharedata;

	$insertFields = [];
	$insertVals = [];
	$whereFields = [];
	$whereVals = [];

	$insertFields[0] = "postType";
	$insertFields[1] = "postText";
	$insertFields[2] = "shareType";
	$insertFields[3] = "dateAdded";
	$insertFields[4] = "userId";
	$insertFields[5] = "sharePost";

	$insertVals[0] = clean($_REQUEST['sharePostType']);
	$insertVals[1] = $postText;
	$insertVals[2] = clean($_REQUEST['postshareType']);
	$insertVals[3] = time();
	$insertVals[4] = $_SESSION['sessUserId'];
	$insertVals[5] = 1;

	$resUpdate = insertDB(_SHAREANDUPDATES_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
	$postId = $resUpdate;
	if ($resUpdate) {
		$insertFields = [];
		$insertVals = [];

		$insertFields[0] = "userId";
		$insertFields[1] = "postId";
		$insertFields[2] = "postType";
		$insertFields[3] = "shareType";
		$insertFields[4] = "dateAdded";

		$insertVals[0] = $_SESSION["sessUserId"];
		$insertVals[1] = $postId;
		$insertVals[2] = 2;
		$insertVals[3] = clean($_REQUEST['postshareType']);
		$insertVals[4] = time();

		$resUpdate = insertDB(_TIMELINE_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');


		$sql_ins = "insert into " . _SHARE_MASTER_TABLE_ . " set userId='" . $_SESSION["sessUserId"] . "',postId='" . $oldpostId . "',postType='" . $_REQUEST["sharePostType"] . "',dateAdded='" . time() . "'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	}


	$sql_ins = "update " . _USERS_MASTER_TABLE_ . " set lastPost=" . $postId . " ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	$aa666 = "SELECT * from " . _SHARE_MASTER_TABLE_ . " WHERE postId=" . $oldpostId . " and postType=" . $_REQUEST["sharePostType"] . "   ";
	$res5666 = mysqli_query($conn, $aa666);
	$totalpostsharecount = mysqli_num_rows($res5666);
	$totalpostsharecount222 = $totalpostsharecount;
	?>
	<script>
		parent.$('#shareboxouter').hide();
		parent.$('#sharesuccess').show();
		parent.$('#commonloader').hide();
		parent.showsusmsg('SUCCESS', 'Post successfully shared', '');
		parent.$('body').css('overflow', 'auto');
		parent.$('#shareposts<?php echo $oldpostId; ?><?php echo $_REQUEST['sharePostType']; ?> span').text(<?php echo $totalpostsharecount222; ?>);
	</script>
	<?php
}


if (trim(isset($_REQUEST['id']) && $_REQUEST['id']) != '' && $_REQUEST['action'] == 'delproject') {


	$dltid = decodeStr($_REQUEST['id']);

	$aa = "SELECT id from " . _PROJECT_MASTER_TABLE_ . " WHERE id= " . $dltid . " and userId='" . $_SESSION["sessUserId"] . "' ";
	$res5 = mysqli_query($conn, $aa);
	$checkUser = mysqli_num_rows($res5);

	if ($checkUser > 0) {

		$sql_ins = "DELETE FROM " . _PROJECT_MASTER_TABLE_ . " WHERE id= " . $dltid . " ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _PROJECT_INTRESTED_TABLE_ . " WHERE projectId= " . $dltid . " ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$sql_ins = "DELETE FROM " . _PROJECT_BOOKMARK_TABLE_ . " WHERE projectId= " . $dltid . " ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
		$_SESSION["d"] = 1;
	}
	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}

if (isset($_REQUEST['pid']) && $_REQUEST['pid'] != '' && $_REQUEST['action'] == 'bookmark') {
	$dltid = decodeStr($_REQUEST['pid']);

	$dateAdded = time();

	$aa = "SELECT * from " . _PROJECT_BOOKMARK_TABLE_ . " WHERE projectId= " . $dltid . " and userId='" . $_SESSION["sessUserId"] . "' ";
	$res5 = mysqli_query($conn, $aa);
	$checkBookmark = mysqli_num_rows($res5);

	if ($checkBookmark > 0) {
		$sql_ins = "DELETE FROM " . _PROJECT_BOOKMARK_TABLE_ . " WHERE projectId= " . $dltid . " and userId='" . $_SESSION["sessUserId"] . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		?>
		<script>
			$('#bookmarktextdiv').text('Bookmark project');

			$('#bookmarktextdivouter').removeClass('bookmarked');
			$('#bookmarklisting<?php echo $dltid; ?>').hide();
			reloadPage();
		</script>
		<?php
	} else {
		$sql_ins = "insert into " . _PROJECT_BOOKMARK_TABLE_ . " set userId='" . $_SESSION["sessUserId"] . "',projectId='" . $dltid . "',dateAdded='$dateAdded'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		?>
		<script>
			$('#bookmarktextdiv').text('Remove bookmark');
			$('#bookmarktextdivouter').addClass('bookmarked');
		</script>
		<?php
	}

}

if ($_REQUEST['action'] == 'applyproject' && trim($_REQUEST['projid']) != '') {

	$aap = "SELECT * from " . _PROJECT_INTRESTED_TABLE_ . " WHERE projectId= " . decodeStr($_REQUEST['projid']) . " and userId='" . $_SESSION["sessUserId"] . "' ";
	$res5p = mysqli_query($conn, $aap);
	$checkBookmarkp = mysqli_num_rows($res5p);
	if ($checkBookmarkp > 0) {
		?>
		<script>
			parent.$('#popupcontentproj').hide();
			parent.$('#frmposthomerecommend').html("<div style='text-align:center; font-size:16px; padding-bottom:20px;'>You are already applied for this project.</div>");
		</script>
		<?php
	} else {
		$sql_insp = "insert into " . _PROJECT_INTRESTED_TABLE_ . " set userId='" . $_SESSION["sessUserId"] . "',projectId='" . decodeStr($_REQUEST['projid']) . "',dateAdded='" . time() . "'";
		mysqli_query($conn, $sql_insp) or die(mysqli_error($conn));


		$insertFields = [];
		$insertVals = [];
		$whereFields = [];
		$whereVals = [];

		$insertFields[0] = "userId";
		$insertFields[1] = "contactId";
		$insertFields[2] = "projectdescription";
		$insertFields[3] = "dateAdded";
		$insertFields[4] = "userSubject";
		$insertFields[5] = "projectId";

		$insertVals[0] = $_SESSION["sessUserId"];
		$insertVals[1] = decodeStr($_REQUEST['uid']);
		$insertVals[2] = normalclean($_REQUEST['projectdescription']);
		$insertVals[3] = time();
		$insertVals[4] = addslashes($_REQUEST['userSubject']);
		$insertVals[5] = decodeStr($_REQUEST['projid']);

		$resUpdate = insertDB(_PROJECT_USER_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		$sql_ins2 = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "',userId='" . decodeStr($_REQUEST['uid']) . "',postType=14,notificationText='interestedproject',dateAdded='" . time() . "'";
		mysqli_query($conn, $sql_ins2) or die(mysqli_error($conn));

		$sql = "SELECT emailApplyProject from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId= " . decodeStr($_REQUEST['uid']) . " ";
		$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
		$getUserSettings = mysqli_fetch_array($getSql);

		if ($getUserSettings["emailApplyProject"] == 1) {



			////////////
			$a = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,email from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . decodeStr($_REQUEST['uid']) . "' ";
			$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
			$userres = mysqli_fetch_array($b);
			$email = $userres['email'];



			$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,cityName,countryName from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
			$res52 = mysqli_query($conn, $aa2);
			$getuser2 = mysqli_fetch_array($res52);

			$firstName2 = $getuser2['firstName'];
			$lastName2 = $getuser2['lastName'];
			$profilePhoto2 = $getuser2['profilePhoto'];
			$jobTitle = $getuser2["jobTitle"];
			$companyName = $getuser2["companyName"];
			$userurl2 = $getuser2["userurl"];
			$cityName = $getuser2["cityName"];
			$countryName = $getuser2["countryName"];

			if ($profilePhoto2 != '') {
				$profilePhoto2 = $profilePhoto2;
			} else {
				$profilePhoto2 = 'user-placeholder.jpg';
			}



			$mailBodyContent .= '';
			$mailBodyContent .= '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
    <tbody>
    <tr>
        <td align="center" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px">
                <tbody>
                <tr>
                    <td align="center" valign="top" style="width:100%;padding:20px 0">
                        <a href="' . $fullurl . '" target="_blank" >
                            <img src="' . $fullurl . 'images/sdglogo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
                </tr>
                <tr>
                  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">


					  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">

					  <div style="text-align:center; margin-bottom:5px; margin-top:5px;font-size:18px;"><strong>Project Subject:</strong> <a href="' . $fullurl . 'preview-project.html?projId=' . $_REQUEST['projid'] . '&cuid=' . $_SESSION['sessUserId'] . '&t=10">' . $_REQUEST['projetvname'] . '</a></div>
					  <div style="text-align:center; margin-bottom:5px; margin-top:30px;font-size:15px;">Applied by:</div>

					    <div style="text-align:center;"><div style="
    width: 80px;
    height: 80px;
    overflow: hidden;margin:auto;
    margin-bottom:12px;
    border-radius: 100%;
    border: 3px #e9e9e9 solid; margin:auto;
"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl2 . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2"><img src="' . $fullurl . 'uploads/' . $profilePhoto2 . '" style="
    width: 100%;
"></a></div>
<div style="text-align:center; margin-bottom:5px; margin-top:5px;"><strong>' . $firstName2 . ' ' . $lastName2 . '</strong></div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $jobTitle . ' at ' . $companyName . '</div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $cityName . ', ' . $countryName . '</div>

<div style="text-align:center; margin-top:10px; margin-bottom:30px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
  <tbody><tr>
    <td colspan="2" align="center"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl2 . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#0abe51;border-radius:5px;margin-bottom: 0px;" target="_blank">View Profile</a></td>
    </tr>
</tbody></table>
</div>
</div>
					  </div>

                  </td>
                </tr>
                <tr>
                    <td align="center" style="padding:40px;margin:0">
                       <div style="text-align:center; font-size:12px; margin-bottom:20px;">

                       <a href="' . $fullurl . 'privacy.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Privacy</a> -

                          <a href="' . $fullurl . 'terms.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Terms</a> -

                        <a href="' . $fullurl . 'about.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">About</a> -

                          <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div>
<p style="margin:0;padding:0;font-family:"Open Sans",Arial,Helvetica,sans-serif;line-height:24px;color:#616161;font-size:14px;text-align:center">
                             Powered by <a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $domainname . '</a></p>                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</div>';


			$subject = "" . $firstName2 . " has applied for your project on " . $companNameTitle . "";

			send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

			/////////


		}

		$_SESSION["smg8"] = 1;

		?>
		<script>
			parent.reloadPage();
			//parent.$('#popupcontentproj').hide();
			//parent.$('#frmposthomerecommend').html("<div style='text-align:center; font-size:16px; padding-bottom:20px; color:#0fd020;'>The project owner has been informed that you're interested in their project.</div>");

		</script>
		<?php
	}
}

if (isset($_REQUEST['pid']) && $_REQUEST['pid'] != '' && $_REQUEST['action'] == 'interested') {
	$dltid = decodeStr($_REQUEST['pid']);

	$sql_ins = "DELETE FROM " . _PROJECT_INTRESTED_TABLE_ . " WHERE projectId= " . $dltid . " and userId='" . $_SESSION["sessUserId"] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "DELETE FROM " . _PROJECT_USER_MASTER_TABLE_ . " WHERE projectId= " . $dltid . " and userId='" . $_SESSION["sessUserId"] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	?>
	<script>
		reloadPage();
	</script>
	<?php
}


if (isset($_REQUEST['tagid']) && $_REQUEST['tagid'] != '' && $_REQUEST['action'] == 'checktagid') {
	$tagId = $_REQUEST['tagid'];

	$sql_ins = "SELECT tagId FROM " . _COMPANY_MASTER_TABLE_ . " WHERE tagId= '" . $tagId . "' ";
	$resrusult = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	$tagidcheck = mysqli_num_rows($resrusult);
	if ($tagidcheck > 0) {
		?>
		<script>
			$('#tagIdtrue').val('0');
			$('#truevalue').hide();
			$('#falsevalue').show();
		</script>
		<?php
	} else {
		?>
		<script>
			$('#tagIdtrue').val('1');
			$('#truevalue').show();
			$('#falsevalue').hide();
		</script>
		<?php
	}

}

if ($_REQUEST['action'] == 'addcmpupdates' && trim($_REQUEST['cmpid']) != '' && trim($_REQUEST['companyheadline']) != '' && trim($_REQUEST['companyupdatedescription']) != '') {


	unset($insertFields);
	unset($insertVals);

	$insertFields[0] = "userId";
	$insertFields[1] = "postType";
	$insertFields[2] = "postTitle";
	$insertFields[3] = "dateAdded";
	$insertFields[4] = "postText";

	$insertVals[0] = decodeStr($_REQUEST['cmpid']);//this is used for company
	$insertVals[1] = 16; //add company updates status
	$insertVals[2] = normalclean($_REQUEST['companyheadline']);
	$insertVals[3] = time();
	$insertVals[4] = normalclean($_REQUEST['companyupdatedescription']);

	$resUpdate = insertDB(_SHAREANDUPDATES_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlFollowersMember = "";
	$sqlFollowersMember = "select userId from " . _COMPANY_FOLLOWERS_TABLE_ . " WHERE companyId= " . decodeStr($_REQUEST['cmpid']) . " and userId!=" . $_SESSION["sessUserId"] . "  ";
	$resFollowersMember = getRecords(_COMPANY_FOLLOWERS_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlFollowersMember);
	if ($resFollowersMember) {
		while ($folloMembers = mysqli_fetch_array($resFollowersMember)) {

			$sql_ins2 = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "',userId='" . $folloMembers["userId"] . "',companyId=" . decodeStr($_REQUEST['cmpid']) . ",postType=16,notificationText='companyupdate',dateAdded='" . time() . "'";
			mysqli_query($conn, $sql_ins2) or die(mysqli_error($conn));

		}

	}


	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}

if (trim(isset($_REQUEST['id']) && $_REQUEST['id']) != '' && $_REQUEST['action'] == 'delcmpupdate') {

	$dltid = decodeStr($_REQUEST['id']);

	$sql_ins = "DELETE FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE id= " . $dltid . " ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}


if ($_REQUEST['action'] == 'postandsharewithmsg' && trim($_REQUEST['sharePostType']) != '') {
	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	if (trim(isset($_REQUEST['sharedoc']) && $_REQUEST["sharedoc"]) == 1 && trim($_REQUEST["sharePostType"]) == 'sharedocs') {

		if (!empty($_REQUEST['check_list'])) {

			foreach ($_REQUEST['check_list'] as $ids) {


				$aa = "SELECT firstName,lastName,profilePhoto,userId,email from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . decodeStr($ids) . "' ";
				$res5 = mysqli_query($conn, $aa);
				$getuser = mysqli_fetch_array($res5);

				$firstName = $getuser['firstName'];
				$lastName = $getuser['lastName'];
				$profilePhoto = $getuser['profilePhoto'];
				$shareduserId = $getuser['userId'];
				$email = $getuser["email"];


				if ($profilePhoto != '') {
					$profilePhoto = $profilePhoto;
				} else {
					$profilePhoto = 'user-placeholder.jpg';
				}


				$postId = decodeStr($_REQUEST['postId']);

				/*unset($selectFields);
				unset($whereFields);
				unset($whereVals);

				$sqlCheck1="";
				$sqlCheck1="select id from "._VAULT_SHARE_MASTER_." where userId='".$shareduserId."' and postId=".$postId." ";
				$resCheck1=getRecords(_VAULT_SHARE_MASTER_,$selectFields,$whereFields,$whereVals,_Y_,$sqlCheck1);
				if($resCheck1)
				{
				}
				else
				{}*/



				$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
				$res52 = mysqli_query($conn, $aa2);
				$getuser2 = mysqli_fetch_array($res52);

				$firstName2 = $getuser2['firstName'];
				$lastName2 = $getuser2['lastName'];
				$profilePhoto2 = $getuser2['profilePhoto'];
				$jobTitle = $getuser2["jobTitle"];
				$companyName = $getuser2["companyName"];
				$userurl = $getuser2["userurl"];

				if ($profilePhoto2 != '') {
					$profilePhoto2 = $profilePhoto2;
				} else {
					$profilePhoto2 = 'user-placeholder.jpg';
				}


				$insertFields = [];
				$insertVals = [];
				$whereFields = [];
				$whereVals = [];

				$insertFields[0] = "dateAdded";
				$insertFields[1] = "userId";
				$insertFields[2] = "postId";

				$insertVals[0] = time();
				$insertVals[1] = $shareduserId;
				$insertVals[2] = $postId;

				$resInsert = insertDB(_VAULT_SHARE_MASTER_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

				$dateAdded = time();

				$sql_ins = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "', userId='" . $shareduserId . "',postId= " . $postId . ",postType='20' ,notificationText='postvaultshare',dateAdded='" . $dateAdded . "'";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

				/*For email templates*/
				$sql_vault = "SELECT name,fileSize,documentFile from " . _VAULT_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['postId']) . " ";
				$resvault = mysqli_query($conn, $sql_vault) or die(mysqli_error($conn));
				$rowvault = mysqli_fetch_array($resvault);
				$name = $rowvault['name'];
				$documentFileName = trim($rowvault["documentFile"]);

				$sharefileSize = trim($rowvault["fileSize"]);

				$totalsharefileSize = ceil($sharefileSize / 1024 / 1024);



				$mailBodyContent = '';
				$mailBodyContent = '<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;">
	 <a href="' . $fullurl . '" target="_blank" style="display: inline-block;padding: 10px;">
    <img src="' . $fullurl . 'images/sdglogo.png" width="150px;">
    </a>
</div>
<div style="background-color:#f4f4f4;user-select: none;-moz-user-select: none; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; padding:30px 0px;text-align:center;">
  <div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
    <div style="padding:30px;">
      <div style="width: 60px;height: 60px;margin: auto;">
        <a style="color:#1a94c3; text-decoration: none;" href="' . $fullurl . 'profile/' . encodeStr($_SESSION["sessUserId"]) . '/' . $userurl . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2"><img src="' . $fullurl . 'uploads/' . $profilePhoto2 . '" style="border-radius: 50%;width: 50px;height: 50px;display: block;"></a>
      </div>
    <span style="color:#1a94c3;font-size:22px;text-align: center;display: block;"><a style="color:#1a94c3; text-decoration: none;" href="' . $fullurl . 'profile/' . encodeStr($_SESSION["sessUserId"]) . '/' . $userurl . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2">' . $firstName2 . ' ' . $lastName2 . '</a> </span>
        <div style="display: block;width: 100%;margin-top: 15px;margin-bottom: 35px;font-size: 18px;text-align: center;color:#000;"> Sent you a Document </div>
      <div style="padding:10px; background-color:#F9F9F9; border:dashed 1px #ccc; border-radius: 2px;">


     <div style="width: 100%;text-align: left;overflow: hidden;padding: 10px;">

       <strong style="font-weight: 600;display: block;text-align: center;">File Size (' . $totalsharefileSize . ' MB) </strong>
       <div style="font-size: 14px;  color: #a0a0a0; margin-top: 5px;text-align: center;">' . $documentFileName . ' </div></div>
       <div style="width: 100%;overflow: hidden;text-align: center;">
<a href="' . $fullurl . 'downloads.html?id=' . $_REQUEST['postId'] . '&uid=' . encodeStr($_SESSION["sessUserId"]) . '&cuid=' . $_SESSION['sessUserId'] . '&t=8" style="display: inline-block; padding: 10px 43px; background-color: #1a94c3; text-decoration: none; color: #fff;font-size: 18px; margin-top: 15px;border-radius: 24px;">Get Your Files</a></div>
<div style="width: 100%;overflow:hidden;text-align: left;margin-top: 20px;">

</div>


      <div style="    margin-top: 20px; text-align: right; line-height: 30px;padding-top: 5px; border-top: solid 1px #e7e7e7; color: #afafaf;">Powered by ' . $companNameTitle . '</div>
    </div>
  </div>
</div>';


				$subject = "" . $firstName2 . " Shared a Document on " . $companNameTitle . "";

				send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);






			}
		}


	} else {


		$sharePostType = trim($_REQUEST['sharePostType']);
		$oldpostId = $_REQUEST['oldpostId'];


		$sql_ins = "SELECT firstName,lastName FROM " . _USERS_MASTER_TABLE_ . " WHERE userId IN (select userId from " . _SHAREANDUPDATES_TABLE_ . " where id= " . decodeStr($oldpostId) . ")  ";
		$getqueryName = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
		$getName = mysqli_fetch_array($getqueryName);

		$sql_ins = "SELECT firstName,lastName FROM " . _USERS_MASTER_TABLE_ . " WHERE userId=" . $_SESSION["sessUserId"] . "  ";
		$getqueryName = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
		$mygetName = mysqli_fetch_array($getqueryName);

		if ($sharePostType == 3) {
			$txtmsg = $userurl = '<a href="' . $fullurl . 'view-article.html?postId=' . $oldpostId . '" target="_blank">' . $mygetName["firstName"] . ' ' . $mygetName["lastName"] . ' shared an article</a>';
		} else {
			$txtmsg = $userurl = '<a href="' . $fullurl . 'single-post.html?postId=' . $oldpostId . '&postType=' . $_REQUEST['sharePostType'] . '" target="_blank">' . $mygetName["firstName"] . ' ' . $mygetName["lastName"] . ' shared an update</a>';
		}
		$postShare = 'mobile_singlepost.php?postId=' . $oldpostId . '&postType=' . $_REQUEST['sharePostType'] . '';

		if (!empty($_REQUEST['check_list'])) {

			foreach ($_REQUEST['check_list'] as $check) {


				$dateAdded = time();
				$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=1,userId='" . $_SESSION["sessUserId"] . "',contactId='" . decodeStr($check) . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . $txtmsg . "',postShare= '" . $postShare . "'";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


				$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=0,userId='" . decodeStr($check) . "',contactId='" . $_SESSION["sessUserId"] . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . $txtmsg . "',postShare= '" . $postShare . "'";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


				$sql_ins = "insert into " . _SHARE_MASTER_TABLE_ . "
	 set userId='" . $_SESSION["sessUserId"] . "',postId='" . decodeStr($oldpostId) . "',postType='" . $_REQUEST["sharePostType"] . "',dateAdded='" . time() . "'";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
			}
		}

		$aa666 = "SELECT * from " . _SHARE_MASTER_TABLE_ . " WHERE postId=" . decodeStr($oldpostId) . " and postType=" . $_REQUEST["sharePostType"] . "   ";
		$res5666 = mysqli_query($conn, $aa666);
		$totalpostsharecount = mysqli_num_rows($res5666);
		$totalpostsharecount222 = $totalpostsharecount;
		?>
		<script>
			parent.$('#shareposts<?php echo decodeStr($oldpostId); ?><?php echo $_REQUEST['sharePostType']; ?> span').text(<?php echo $totalpostsharecount222; ?>);
		</script>
		<?php
	}

	?>
	<script>
		parent.$('#shareboxouter').hide();
		parent.$('#sharesuccess').show();
		parent.$('#commonloader').hide();
		parent.showsusmsg('SUCCESS', 'Successfully shared.', '');// with selected contacts
	</script>
	<?php
}


if (trim(isset($_REQUEST['cmpid']) && $_REQUEST['cmpid']) != '' && $_REQUEST['action'] == 'delcmp') {
	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	$dltid = decodeStr($_REQUEST['cmpid']);

	$password = clean($_POST['delgrppassword']);


	if (trim($password) != "") {
		$pass = md5($password);
		$sql = "SELECT userId from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' and password='" . $pass . "' ";
		$resSql = mysqli_query($conn, $sql);
		$getrows = mysqli_num_rows($resSql);
		if ($getrows > 0) {
			?>
			<script>
				parent.$('#commonloader').hide();
				parent.$('#errormsg').hide();
			</script>
			<?php

			$sql_ins = "DELETE FROM " . _SHAREANDUPDATES_TABLE_ . " WHERE userId= " . $dltid . " and postType=16  ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			$sql_ins = "DELETE FROM " . _NOTIFICATION_MASTER_TABLE_ . " WHERE companyId= " . $dltid . " ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			if ($dltid != 0 && $dltid != '') {
				$ap = "select imageName from " . _IMAGE_MASTER_TABLE_ . " WHERE  postId= " . $dltid . " and imageType=8 ";
				$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
				$rowLogoImg = mysqli_fetch_array($bp);

				if ($rowLogoImg["imageName"] != '') {
					unlink("uploads/" . $rowLogoImg["imageName"]);
					unlink("uploads/x_" . $rowLogoImg["imageName"]);
				}
			}

			$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE  postId= " . $dltid . " and imageType=8 ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
			/*Edit by rashid 28/11/17*/
			$aj = "select * from " . _JOBS_MASTER_TABLE_ . " WHERE companyId= " . $dltid . "";
			$bj = mysqli_query($$conn, $aj) or die(mysqli_error($conn));
			while ($rowJob = mysqli_fetch_array($bj)) {
				$sql_ins = "DELETE FROM " . _JOB_INTRESTED_TABLE_ . " WHERE jobId= '" . $rowJob["id"] . "'  ";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

				$sql_ins = "DELETE FROM " . _JOB_USER_TABLE_ . " WHERE jobId= '" . $rowJob["id"] . "'   ";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

				$sql_ins = "DELETE FROM " . _NOTIFICATION_MASTER_TABLE_ . " WHERE postId= '" . $rowJob["id"] . "' and postType=155 ";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
			}

			$sql_ins = "DELETE FROM " . _JOBS_MASTER_TABLE_ . " WHERE companyId= " . $dltid . "  ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
			/*end */

			$sql_ins = "DELETE FROM " . _COMPANY_MASTER_TABLE_ . " WHERE id= " . $dltid . "  ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			$sql_ins = "DELETE FROM " . _COMPANY_FOLLOWERS_TABLE_ . " WHERE companyId= " . $dltid . " ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			$_SESSION["d"] = 1;
			?>
			<script>
				parent.reloadPage();
			</script>
			<?php
		} else {
			?>
			<script>
				parent.$('#commonloader').hide();
				parent.$('#errormsg').text('That password is incorrect. Try again.');
				parent.$('#errormsg').css('color', '#FF0000');
			</script>
			<?php
		}
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.$('#errormsg').text('Please enter your password');
			parent.$('#errormsg').css('color', '#FF0000');
		</script>
		<?php
	}


}

if ($_REQUEST['action'] == 'hidepost' && $_REQUEST['hiddenpid'] != '') {
	$hiddenpid = decodeStr($_REQUEST['hiddenpid']);

	$sql_ins = "INSERT INTO " . _HIDDEN_POSTS_MASTER_TABLE_ . " SET userId= " . $_SESSION["sessUserId"] . ",timeLineId=" . $hiddenpid . ",dateAdded=" . time() . " ";
	$resresult2 = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	?>
	<script>
		parent.$('#alertpopup').hide();
		parent.$('#<?php echo $hiddenpid; ?>').slideUp();
	</script>
	<?php
}


if ($_REQUEST['action'] == 'reportpost' && trim($_REQUEST['hiddenpid']) != '' && trim($_REQUEST['blockTitleId']) != '') {
	$hiddenpid = decodeStr($_REQUEST['hiddenpid']);
	$blockTitleId = decodeStr($_REQUEST['blockTitleId']);

	$sql_ins = "INSERT INTO " . _HIDDEN_POSTS_MASTER_TABLE_ . " SET userId= " . $_SESSION["sessUserId"] . ",timeLineId=" . $hiddenpid . ",blockReasonId=" . $blockTitleId . ",postBlock=1,dateAdded=" . time() . " ";
	$resresult2 = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$ha = "SELECT id from " . _HIDDEN_POSTS_MASTER_TABLE_ . " WHERE postBlock=1 and timeLineId=" . $hiddenpid . " ";
	$hb = mysqli_query($conn, $ha) or die(mysqli_error($conn));
	$hidpost = mysqli_num_rows($hb);
	if ($hidpost > 20) {

		$sql_ins = "update " . _TIMELINE_MASTER_TABLE_ . " set status=0 where postId= " . $hiddenpid . " ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	}

	?>
	<script>
		parent.closeshowsusmsg();
		parent.$('#<?php echo $hiddenpid; ?>').slideUp();
		parent.$('body').css('overflow', 'auto');
	</script>
	<?php
}

if ($_REQUEST['action'] == 'changepass' && $_REQUEST['oldpass'] != '' && trim($_REQUEST['newpass']) != '' && trim($_REQUEST['confirmpass']) != '') {
	?>
	<script>
		parent.$('#errormsgpass').hide();
	</script>

	<?php
	$password = md5(addslashes(trim($_POST['oldpass'])));
	$newpass = md5(addslashes(trim($_POST["newpass"])));
	$confirmpass = md5(addslashes(trim($_POST["confirmpass"])));


	if (strlen(trim($_POST["oldpass"])) > 5 && strlen(trim($_POST["newpass"])) > 5 && strlen(trim($_POST["confirmpass"])) > 5) {
		if ($password != $userpasswordchanged) {
			?>
			<script>
				parent.$('#errormsgpass').show();
				parent.$('#errormsgpass').text('Old password dose not matched.');
			</script>
			<?php
			exit();
		}
	}

	if (strlen(trim($_POST["newpass"])) > 16) {
		?>
		<script>
			parent.$('#errormsgpass').show();
			parent.$('#errormsgpass').text('Please enter new password maximum 16 charachters');
		</script>
		<?php
		exit();
	}

	if (strlen(trim($_POST["confirmpass"])) > 16) {
		?>
		<script>
			parent.$('#errormsgpass').show();
			parent.$('#errormsgpass').text('Please enter confirm password maximum 16 charachters');
		</script>
		<?php
		exit();
	}


	if (strlen(trim($_POST["newpass"])) > 5 && strlen(trim($_POST["confirmpass"])) > 5) {
		if ($newpass != $confirmpass) {
			?>

			<script>
				parent.$('#errormsgpass').show();
				parent.$('#errormsgpass').text('New password dose not matched with confirm password.');
			</script>

			<?php
			exit();
		}
	}

	if (strlen(trim($_POST["newpass"])) <= 5) {
		?>
		<script>
			parent.$('#errormsgpass').show();
			parent.$('#errormsgpass').text('Please enter new password minimum 6 charachters');
		</script>
		<?php
		exit();
	}

	if (strlen(trim($_POST["confirmpass"])) <= 5) {
		?>
		<script>
			parent.$('#errormsgpass').show();
			parent.$('#errormsgpass').text('Please enter confirm password minimum 6 charachters');
		</script>
		<?php
		exit();
	}




	$sql_ins = "update " . _USERS_MASTER_TABLE_ . " SET password='" . $confirmpass . "' WHERE userId='" . $_SESSION['sessUserId'] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	$one = mysqli_affected_rows($sql_ins);


	?>
	<script>
		parent.$('#shareboxouter').hide();
		parent.$('#sharesuccess').show();
		parent.$('#commonloader').hide();
		parent.showsusmsg('SUCCESS', 'Password changed successfully', '');
	</script>
	<?php
	exit();
}

if ($_REQUEST['action'] == 'personaldatasetting' && trim($_REQUEST['firstName']) != '' && trim($_REQUEST['lastName']) != '' && trim($_REQUEST['countryName']) != '' && trim($_REQUEST['cityName']) != '' && trim($_REQUEST['locationName']) != '' && trim($_REQUEST['day']) != '0' && trim($_REQUEST['month']) != '0' && trim($_REQUEST['year']) != '0' && trim($_REQUEST['timeZone']) != '' && trim($_REQUEST['gender']) != '') {
	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	$firstName = clean($_POST["firstName"]);
	$lastName = clean($_POST["lastName"]);
	$countryName = clean($_POST["countryName"]);
	$cityName = clean($_POST["cityName"]);
	$locationName = clean($_POST["locationName"]);
	$day = trim($_POST["day"]);
	$month = trim($_POST["month"]);
	$year = trim($_POST["year"]);

	$gender = trim($_POST["gender"]);

	$dob = $year . '-' . $month . '-' . $day;

	$timeZone = trim($_POST["timeZone"]);

	$firstNameUrl = makeContentUrl($firstName);
	$lastNameUrl = makeContentUrl($lastName);

	$userurl = $firstNameUrl . '-' . $lastNameUrl;


	$sql_ins = "update " . _USERS_MASTER_TABLE_ . " SET firstName='" . $firstName . "',lastName='" . $lastName . "',countryName='" . $countryName . "',cityName='" . $cityName . "',locationName='" . $locationName . "',dob='" . $dob . "',userurl='" . $userurl . "',timeZone='" . $timeZone . "',gender='" . $gender . "' WHERE userId='" . $_SESSION['sessUserId'] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));




	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
	exit();
}


if ($_REQUEST['action'] == 'settings' && $_SESSION['sessUserId'] != 0 && $_SESSION['sessUserId'] != '') {
	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	$contactTabvisible = clean($_POST["contactTabvisible"]);
	$activityTabVisible = clean($_POST["activityTabVisible"]);
	$allowSearchEngines = clean($_POST["allowSearchEngines"]);

	$iWantRecieveMsg = clean($_POST["iWantRecieveMsg"]);
	$postGroupSearchEngine = clean($_POST["postGroupSearchEngine"]);

	$sendMeEmail = clean($_POST["sendMeEmail"]);
	$emailCommentLike = clean($_POST["emailCommentLike"]);
	$emailPostLike = clean($_POST["emailPostLike"]);
	$newContactRequest = clean($_POST["newContactRequest"]);
	$pendingContactRequest = clean($_POST["pendingContactRequest"]);
	$emailFreelancerAccount = clean($_POST["emailFreelancerAccount"]);
	$emailApplyProject = clean($_POST["emailApplyProject"]);
	$emailContactNewPosition = clean($_POST["emailContactNewPosition"]);

	$notiPostGroup = clean($_POST["notiPostGroup"]);
	$notiJoiningGroup = clean($_POST["notiJoiningGroup"]);
	$notiFollowCompany = clean($_POST["notiFollowCompany"]);
	$notiTagingCompany = clean($_POST["notiTagingCompany"]);
	$notiEventGuist = clean($_POST["notiEventGuist"]);
	$contactListVisible = trim($_POST["contactListVisible"]);
	$newOpportunities = trim($_POST["newOpportunities"]);
	$allowFuturePostsComments = trim($_POST["allowFuturePostsComments"]);
	$notiPostCommentsAllow = trim($_POST["notiPostCommentsAllow"]);
	$notiPostLikesAllow = trim($_POST["notiPostLikesAllow"]);
	$notiNewPositionEmployer = trim($_POST["notiNewPositionEmployer"]);
	$notiMeetingRequest = trim($_POST["notiMeetingRequest"]);
	$notiProjectApplied = trim($_POST["notiProjectApplied"]);
	$notiJoinGroupRequestAllow = trim($_POST["notiJoinGroupRequestAllow"]);
	$notiNewArticlesAllow = trim($_POST["notiNewArticlesAllow"]);
	$userBirthdayAllow = trim($_POST["userBirthdayAllow"]);



	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);

	$insertFields[0] = "contactTabvisible";
	$insertFields[1] = "activityTabVisible";
	$insertFields[2] = "allowSearchEngines";
	$insertFields[3] = "iWantRecieveMsg";
	$insertFields[4] = "postGroupSearchEngine";
	$insertFields[5] = "sendMeEmail";
	$insertFields[6] = "emailCommentLike";
	$insertFields[7] = "emailPostLike";
	$insertFields[8] = "newContactRequest";
	$insertFields[9] = "pendingContactRequest";
	$insertFields[10] = "emailFreelancerAccount";
	$insertFields[11] = "emailApplyProject";
	$insertFields[12] = "emailContactNewPosition";
	$insertFields[13] = "notiPostGroup";
	$insertFields[14] = "notiJoiningGroup";
	$insertFields[15] = "notiFollowCompany";
	$insertFields[16] = "notiTagingCompany";
	$insertFields[17] = "notiEventGuist";
	$insertFields[18] = "contactListVisible";
	$insertFields[19] = "newOpportunities";
	$insertFields[20] = "allowFuturePostsComments";
	$insertFields[21] = "notiPostCommentsAllow";
	$insertFields[22] = "notiPostLikesAllow";
	$insertFields[23] = "notiNewPositionEmployer";
	$insertFields[24] = "notiMeetingRequest";
	$insertFields[25] = "notiProjectApplied";
	$insertFields[26] = "notiJoinGroupRequestAllow";
	$insertFields[27] = "notiNewArticlesAllow";
	$insertFields[28] = "userBirthdayAllow";

	$insertVals[0] = $contactTabvisible;
	$insertVals[1] = $activityTabVisible;
	$insertVals[2] = $allowSearchEngines;
	$insertVals[3] = $iWantRecieveMsg;
	$insertVals[4] = $postGroupSearchEngine;
	$insertVals[5] = $sendMeEmail;
	$insertVals[6] = $emailCommentLike;
	$insertVals[7] = $emailPostLike;
	$insertVals[8] = $newContactRequest;
	$insertVals[9] = $pendingContactRequest;
	$insertVals[10] = $emailFreelancerAccount;
	$insertVals[11] = $emailApplyProject;
	$insertVals[12] = $emailContactNewPosition;
	$insertVals[13] = $notiPostGroup;
	$insertVals[14] = $notiJoiningGroup;
	$insertVals[15] = $notiFollowCompany;
	$insertVals[16] = $notiTagingCompany;
	$insertVals[17] = $notiEventGuist;
	$insertVals[18] = $contactListVisible;
	$insertVals[19] = $newOpportunities;
	$insertVals[20] = $allowFuturePostsComments;
	$insertVals[21] = $notiPostCommentsAllow;
	$insertVals[22] = $notiPostLikesAllow;
	$insertVals[23] = $notiNewPositionEmployer;
	$insertVals[24] = $notiMeetingRequest;
	$insertVals[25] = $notiProjectApplied;
	$insertVals[26] = $notiJoinGroupRequestAllow;
	$insertVals[27] = $notiNewArticlesAllow;
	$insertVals[28] = $userBirthdayAllow;

	$whereFields[0] = "userId";

	$whereVals[0] = $_SESSION['sessUserId'];

	$resUpdate = updateDB(_USER_SETTINGS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');




	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
	exit();
}


if (isset($_REQUEST['evntid']) && trim($_REQUEST['evntid']) != '' && $_REQUEST['action'] == 'delevnt') {

	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	$dltid = decodeStr($_REQUEST['evntid']);


	if ($dltid != 0 && $dltid != '') {

		$sql_inss1 = "SELECT id from " . _EVENT_MASTER_TABLE_ . " WHERE id= " . $dltid . " and userId='" . $_SESSION["sessUserId"] . "' ";
		$resresults1 = mysqli_query($conn, $sql_inss1) or die(mysqli_error($conn));

		$rowsTotal = mysqli_num_rows($resresults1);

		if ($rowsTotal > 0) {


			$ap = "select id,imageName from " . _EVENT_IMAGE_MASTER_TABLE_ . " WHERE  eventId= " . $dltid . " ";
			$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
			while ($rowLogoImg = mysqli_fetch_array($bp)) {

				if ($rowLogoImg["imageName"] != '') {
					unlink("uploads/" . $rowLogoImg["imageName"]);
					unlink("uploads/x_" . $rowLogoImg["imageName"]);
				}

				$sql_ins = "DELETE FROM " . _EVENT_IMAGE_MASTER_TABLE_ . " WHERE  id= " . $rowLogoImg["id"] . " ";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
			}

			$sql_ins = "DELETE FROM " . _EVENT_GUEST_MASTER_TABLE_ . " WHERE eventId= " . $dltid . " ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

			$sql_ins = "DELETE FROM " . _TIMELINE_MASTER_TABLE_ . " WHERE postId= " . $dltid . " and postType=5  ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


			$ape = "select eventThumb from " . _EVENT_MASTER_TABLE_ . " WHERE  id= " . $dltid . " ";
			$bpe = mysqli_query($conn, $ape) or die(mysqli_error($conn));
			$rowLogoImge = mysqli_fetch_array($bpe);

			if ($rowLogoImge["eventThumb"] != '') {
				unlink("uploads/" . $rowLogoImge["eventThumb"]);
				unlink("uploads/x_" . $rowLogoImge["eventThumb"]);
			}


			$sql_ins = "DELETE FROM " . _EVENT_MASTER_TABLE_ . " WHERE id= " . $dltid . "  ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
		}

	}
	?>
	<script>
		parent.showerrormsg('SUCCESS', 'Event deleted successfully', '');
		parent.$('#commonloader').hide();
		parent.$('.popup-alert-cont').hide();
		parent.$('#<?php echo $dltid; ?>').slideUp();
	</script>
	<?php

}


if (isset($_REQUEST['dltNotiId']) && $_REQUEST['dltNotiId'] != '' && $_REQUEST['action'] == 'dltnotipost') {


	$dltid = decodeStr($_REQUEST['dltNotiId']);

	$sql_ins = "DELETE FROM " . _NOTIFICATION_MASTER_TABLE_ . " WHERE  id='" . $dltid . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	?>
	<script>
		parent.$('#<?php echo $dltid; ?>').slideUp();
	</script>


	<?php



}

if ($_REQUEST['action'] == 'rmpgrpfile' && $_REQUEST['rmfileId'] != '' && $_REQUEST['rmfilename'] != '') {

	$id = decodeStr($_REQUEST['rmfileId']);
	$oldimg = $_REQUEST['rmfilename'];
	if ($oldimg != '') {
		unlink("groupuploads/" . $oldimg);
		unlink("groupuploads/x_" . $oldimg);
	}

	$sql_ins = "DELETE FROM " . _GROUP_FILE_TABLE_ . " WHERE id= " . $id . "   ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	exit();
}


if (isset($_REQUEST['videocallcut']) && $_REQUEST['videocallcut'] == 1) {
	$sql_ins = "DELETE FROM " . _VIDEO_CALL_REQUEST_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . "   ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "DELETE FROM " . _VIDEO_CALL_REQUEST_MASTER_TABLE_ . " WHERE callerId= " . $_SESSION["sessUserId"] . "   ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$_SESSION['tok'] = 'noses';
	?>
	<script>
		parent.$('#videocallinguserIcon').show();
	</script>
	<?php

}





if (isset($_REQUEST['getvideouserlive']) && $_REQUEST['getvideouserlive'] == '1') {

	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);

	$insertFields[0] = "onlineTime";
	$insertVals[0] = date('Y-m-d H:i:s');

	$whereFields[0] = "userId";
	$whereVals[0] = $_SESSION['sessUserId'];

	$resUpdate = updateDB(_VIDEO_CALL_REQUEST_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');



	$aa2 = "SELECT callStatus,id from " . _VIDEO_CALL_REQUEST_MASTER_TABLE_ . " WHERE callerId='" . $_SESSION['sessUserId'] . "'";
	$res52 = mysqli_query($conn, $aa2);
	$getuser2 = mysqli_fetch_array($res52);
	if ($getuser2['id'] != '') {
		?>

		<?php if ($getuser2['callStatus'] == 1) { ?>
			<script>

				$('#callerphoto').hide();
			</script>
			<?php
		}


	}

}

//echo $_REQUEST['action'].'aaaaaaa'.$_REQUEST['bpId'].'====='.$_FILES['businesslogoimage']['name'];
if ($_REQUEST['action'] == 'uploadsmbpics' && $_FILES['businesslogoimage']['name'] != '' && $_REQUEST['bpId'] != '') {


	$bpId = $_REQUEST['bpId'];
	$imageType = 9;
	$businesslogoimageOld = $_REQUEST['businesslogoimageOld'];
	$dateAdded = time();

	$timename = time();
	$file_name = $_FILES['businesslogoimage']['name'];
	$fileExt = findExtension($file_name);

	if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG') {


		$file_name = $timename . $file_name;
		$file_name = preg_replace('!\s+!', '-', $file_name);
		copy($_FILES['businesslogoimage']['tmp_name'], "uploads/" . $file_name);


		$upimg = 'uploads/' . $file_name;

		//image_fix_orientation($upimg);
//generate_image_thumbnail($upimg, $upimg,'800','800');


		if ($businesslogoimageOld != '') {
			unlink("uploads/" . $businesslogoimageOld);
			unlink("uploads/x_" . $businesslogoimageOld);
		}


		$sql_ins = "insert into " . _IMAGE_MASTER_TABLE_ . " set imageName='$file_name',postId='$bpId',dateAdded='$dateAdded',imageType= " . $imageType . "";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		?>
		<script>
			parent.$('#imagebx').load('<?php echo $fullurl; ?>upload_businesspage_logo.php?bpId=<?php echo $_REQUEST['bpId']; ?>&uid=<?php echo $_REQUEST['smbuid']; ?>');
		</script>

		<?php
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.showerrormsg('Error', 'Oops! Please upload image file with extension only .jpg, .png, .gif.', '');
		</script>
		<?php
	}



}


if ($_REQUEST['action'] == 'uploadbpphoto' && $_FILES['businesspphoto']['name'] != '' && $_REQUEST['smbId'] != '') {

	$smbId = decodeStr($_REQUEST['smbId']);


	$timename = time();
	$file_name = $_FILES['businesspphoto']['name'];
	$fileExt = findExtension($file_name);

	if ($fileExt == 'jpeg' || $fileExt == 'JPEG' || $fileExt == 'jpg' || $fileExt == 'JPG' || $fileExt == 'png' || $fileExt == 'PNG' || strtolower($fileExt) == 'gif') {
		$businesspOld = $_REQUEST['businesspOld'];
		if ($businesspOld != '' && $businesspOld != 'businessimg.png') {
			unlink("uploads/" . $businesspOld);
			unlink("uploads/x_" . $businesspOld);
		}

		$file_name = $timename . $file_name;
		$file_name = preg_replace('!\s+!', '-', $file_name);
		copy($_FILES['businesspphoto']['tmp_name'], "uploads/" . $file_name);


		$sql_ins = "UPDATE " . _BUSINESS_MASTER_TABLE_ . " set fileUploaded='$file_name' WHERE id='$smbId'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		?>
		<script>
			parent.reloadPage();
		</script>
		<?php
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.showerrormsg('Error', 'Oops! Please upload image file with extension only .jpg, .png, .gif.', '');
		</script>
		<?php
	}

}

if ($_REQUEST['action'] == 'delsmbpics' && $_REQUEST['delesmbimgId'] != '' && $_REQUEST['bpId'] != '') {

	$id = decodeStr($_REQUEST['delesmbimgId']);

	$sql_inss = "SELECT imageName from " . _IMAGE_MASTER_TABLE_ . " WHERE id= " . $id . "  ";
	$resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
	$rowResults = mysqli_fetch_array($resresults);
	$imageName = $rowResults["imageName"];

	if ($imageName != '') {
		unlink("uploads/" . $imageName);
		unlink("uploads/x_" . $imageName);
	}

	$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE id= " . $id . "   ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));



	?>
	<script>

		parent.$("#imagebx").load('<?php echo $fullurl; ?>upload_businesspage_logo.php?bpId=<?php echo decodeStr($_REQUEST['bpId']); ?>&uid=<?php echo $_REQUEST['smbuid']; ?>');
	</script>

	<?php
}

if ($_REQUEST['action'] == 'sendenquiry' && trim($_REQUEST['senderName']) != '' && trim($_REQUEST['senderPhoneNumber']) != '' && trim($_REQUEST['senderEmail']) != '' && trim($_REQUEST['receiverEmail']) != '') {

	$senderName = clean($_POST["senderName"]);
	$senderPhoneNumber = trim($_POST["senderPhoneNumber"]);
	$senderEmail = clean($_POST["senderEmail"]);
	$senderMsg = addslashes($_POST["senderMsg"]);
	$email = trim($_POST["receiverEmail"]);
	$purl = trim($_POST["purl"]);

	$mailBodyContent = '';
	$mailBodyContent = '<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;"><a href="' . $fullurl . '" style="border:0px;"><img src="' . $fullurl . 'images/logo.jpg" width="180" style="border:0px;"></a></div>
<div style="background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; padding:30px 0px;text-align:center;">
<div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
<div style="padding:30px;">
<div style="font-size:22px; margin-bottom:10px;">You have new enquiry from ' . $companNameTitle . '</div>
<div style="padding:10px; background-color:#F9F9F9; border:dashed 1px #ccc; border-radius: 2px;">
<div style="color: #696969; margin-bottom: 22px; font-size: 14px; line-height: 20px;">
<font face="helvetica, Arial, sans-serif"><span style="font-size:16px">
 <p style="margin-bottom:5px;">Name: ' . $senderName . '</p>
 <p style="margin-bottom:5px;">Phone: ' . $senderPhoneNumber . '</p>
 <p style="margin-bottom:5px;">Email: ' . $senderEmail . '</p>
 <p style="margin-bottom:5px;">Message: ' . nl2br(stripslashes($senderMsg)) . '</p>
 <p style="margin-bottom:5px;">URL: <a href="' . $purl . '" style="font-family:Helvetica,Arial,sans-serif;font-size:16px;color:#179cd0;word-break:break-all" target="_blank">' . $purl . '</a></p>
 </span></font>
</div>
</div>
<div style="    margin-top: 20px;
   text-align: right;
   line-height: 30px;padding-top: 5px;
   border-top: solid 1px #e7e7e7;
   color: #afafaf;">Powered by ' . $companNameTitle . '
</div>
</div>
</div>
</div>';


	$subject = "Enquiry From " . $companNameTitle . ".";
	send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

	?>
	<script>
		parent.$('#shareboxouter').hide();
		parent.$('#sharesuccess').show();
		parent.$('#commonloader').hide();
		parent.showsusmsg('SUCCESS', 'Enquiry sent successfully', '');
	</script>
	<?php
	exit();
}

if (trim(isset($_REQUEST['smbpid']) && $_REQUEST['smbpid']) != '' && $_REQUEST['action'] == 'delsmbp') {
	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	$dltid = decodeStr($_REQUEST['smbpid']);

	$password = clean($_POST['delgrppassword']);


	if (trim($password) != "") {
		$pass = md5($password);
		if ($pass != $userpasswordchanged) {
			?>
			<script>
				parent.$('#commonloader').hide();
				parent.$('#errormsg').text('That password is incorrect. Try again.');
				parent.$('#errormsg').css('color', '#FF0000');
			</script>
			<?php
		} else {
			?>
			<script>
				parent.$('#commonloader').hide();
				parent.$('#errormsg').hide();
			</script>
			<?php
			$ap = "select id,imageName from " . _IMAGE_MASTER_TABLE_ . " WHERE  postId= " . $dltid . " and imageType=9  ";
			$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
			while ($rowLogoImg = mysqli_fetch_array($bp)) {

				if ($rowLogoImg["imageName"] != '') {
					unlink("uploads/" . $rowLogoImg["imageName"]);
					unlink("uploads/x_" . $rowLogoImg["imageName"]);
				}

				$sql_ins = "DELETE FROM " . _IMAGE_MASTER_TABLE_ . " WHERE  id= " . $rowLogoImg["id"] . " ";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
			}


			$ap = "select fileUploaded from " . _BUSINESS_MASTER_TABLE_ . " WHERE  id= " . $dltid . " ";
			$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
			$rowLogoImg = mysqli_fetch_array($bp);

			if ($rowLogoImg["fileUploaded"] != '' && $rowLogoImg["fileUploaded"] != 'businessimg.png') {
				unlink("uploads/" . $rowLogoImg["fileUploaded"]);
				unlink("uploads/x_" . $rowLogoImg["fileUploaded"]);
			}

			$sql_ins = "DELETE FROM " . _BUSINESS_MASTER_TABLE_ . " WHERE id= " . $dltid . "  ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
			$_SESSION["d"] = 1;
			?>
			<script>
				parent.reloadPage();
			</script>
			<?php

		}
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.$('#errormsg').text('Please enter your password');
			parent.$('#errormsg').css('color', '#FF0000');
		</script>
		<?php
	}

}

if (trim(isset($_REQUEST['contactId']) && $_REQUEST['contactId']) != '' && $_REQUEST['action'] == 'removeshb') {


	$sql_ins = "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET birthdayStatus=1 WHERE contactId= '" . decodeStr($_REQUEST['contactId']) . "' AND userId='" . $_SESSION["sessUserId"] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	?>
	<script>
		parent.$('#saybirthday<?php echo decodeStr($_REQUEST['contactId']); ?>').slideUp();
	</script>
	<?php


}

if (trim(isset($_REQUEST['tlntpid']) && $_REQUEST['tlntpid']) != '' && $_REQUEST['action'] == 'deltalentp') {
	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	$dltid = decodeStr($_REQUEST['tlntpid']);

	$password = clean($_POST['delgrppassword']);


	if (trim($password) != "") {
		$pass = md5($password);
		if ($pass != $userpasswordchanged) {
			?>
			<script>
				parent.$('#commonloader').hide();
				parent.$('#errormsg').text('That password is incorrect. Try again.');
				parent.$('#errormsg').css('color', '#FF0000');
			</script>
			<?php
		} else {
			?>
			<script>
				parent.$('#commonloader').hide();
				parent.$('#errormsg').hide();
			</script>
			<?php
			$sql_ins = "select id FROM " . _TALENT_MASTER_TABLE_ . " WHERE id= " . $dltid . " and userId=" . $_SESSION["sessUserId"] . " ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
			$s = mysqli_num_rows($sql);
			if ($s > 0) {
				$ap = "select talentProfilePhoto from " . _TALENT_MASTER_TABLE_ . " WHERE  id= " . $dltid . " ";
				$bp = mysqli_query($conn, $ap) or die(mysqli_error($conn));
				$rowLogoImg = mysqli_fetch_array($bp);

				if ($rowLogoImg["talentProfilePhoto"] != '' && $rowLogoImg["talentProfilePhoto"] != 'businessimg.png') {
					unlink("uploads/" . $rowLogoImg["talentProfilePhoto"]);
					unlink("uploads/x_" . $rowLogoImg["talentProfilePhoto"]);
				}

				$sql_ins = "DELETE FROM " . _TALENT_MASTER_TABLE_ . " WHERE id= " . $dltid . "  ";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
				$_SESSION["d"] = 1;
			}
			?>
			<script>
				parent.reloadPage();
			</script>
			<?php

		}
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.$('#errormsg').text('Please enter your password');
			parent.$('#errormsg').css('color', '#FF0000');
		</script>
		<?php
	}

}


if ($_REQUEST['action'] == 'sendtalentenquiry' && trim($_REQUEST['senderName']) != '' && trim($_REQUEST['senderPhoneNumber']) != '' && trim($_REQUEST['senderEmail']) != '') {

	$senderName = clean($_POST["senderName"]);
	$senderPhoneNumber = trim($_POST["senderPhoneNumber"]);
	$senderEmail = clean($_POST["senderEmail"]);
	$senderMsg = addslashes($_POST["senderMsg"]);

	$purl = trim($_POST["purl"]);
	$email = "info@connecwrk.com";

	$mailBodyContent = '';
	$mailBodyContent = '<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;"><a href="' . $fullurl . '" style="border:0px;"><img src="' . $fullurl . 'images/logo.jpg" width="180" style="border:0px;"></a></div>
<div style="background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; padding:30px 0px;text-align:center;">
<div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
<div style="padding:30px;">
<div style="font-size:22px; margin-bottom:10px;">You have new enquiry from Talent Profile on ' . $companNameTitle . '</div>
<div style="padding:10px; background-color:#F9F9F9; border:dashed 1px #ccc; border-radius: 2px;">
<div style="color: #696969; margin-bottom: 22px; font-size: 14px; line-height: 20px;">
<font face="helvetica, Arial, sans-serif"><span style="font-size:16px">
 <p style="margin-bottom:5px;">Name: ' . $senderName . '</p>
 <p style="margin-bottom:5px;">Phone: ' . $senderPhoneNumber . '</p>
 <p style="margin-bottom:5px;">Email: ' . $senderEmail . '</p>
 <p style="margin-bottom:5px;">Message: ' . nl2br(stripslashes($senderMsg)) . '</p>
 <p style="margin-bottom:5px;">URL: <a href="' . $purl . '&cuid=' . $_SESSION['sessUserId'] . '&t=11" style="font-family:Helvetica,Arial,sans-serif;font-size:16px;color:#179cd0;word-break:break-all" target="_blank">' . $purl . '</a></p>
 </span></font>
</div>
</div>
<div style="    margin-top: 20px;
   text-align: right;
   line-height: 30px;padding-top: 5px;
   border-top: solid 1px #e7e7e7;
   color: #afafaf;">Powered by ' . $companNameTitle . '
</div>
</div>
</div>
</div>';


	$subject = "Enquiry on Talent Profile " . $companNameTitle . ".";

	send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

	?>
	<script>
		parent.$('#shareboxouter').hide();
		parent.$('#sharesuccess').show();
		parent.$('#commonloader').hide();
		parent.showsusmsg('SUCCESS', 'Enquiry sent successfully', '');
	</script>
	<?php
	exit();
}






if (isset($_REQUEST['talentVideoTitle']) && $_REQUEST['talentVideoTitle'] != '' && $_REQUEST['talentVideoURL'] != '' && $_REQUEST['action'] == 'addtalentVideo') {

	$talentVideoTitle = clean($_REQUEST['talentVideoTitle']);
	$talentVideoURL = ($_REQUEST['talentVideoURL']);
	$talentId = decodeStr($_REQUEST['talentId']);
	$dateAdded = time();

	if ($_REQUEST['talentVidId'] != '') {
		$sql_ins = "UPDATE " . _TALENT_VIDEO_TABLE_ . " SET talentVideoTitle='" . $talentVideoTitle . "',talentVideoURL='" . $talentVideoURL . "' WHERE userId=" . $_SESSION["sessUserId"] . " AND id='" . decodeStr($_REQUEST['talentVidId']) . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
		?>
		<script>
			parent.showsusmsg('SUCCESS', 'Successfully Updated.', '');
		</script>
		<?php
	} else {

		$sql_ins = "insert into " . _TALENT_VIDEO_TABLE_ . " SET talentVideoTitle='" . $talentVideoTitle . "',talentVideoURL='" . $talentVideoURL . "',talentId='" . $talentId . "',userId='" . $_SESSION["sessUserId"] . "',dateAdded='" . $dateAdded . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	}

	?>
	<script>
		parent.showtabdata('2');
		parent.closefuncommonpopupwin();
	</script>
	<?php


}




if (isset($_REQUEST['talentVideopostId']) && $_REQUEST['talentVideopostId'] != '' && $_REQUEST['action'] == 'removeTalentVideo') {

	$sql_ins = "DELETE FROM " . _TALENT_VIDEO_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['talentVideopostId']) . " and userId='" . $_SESSION["sessUserId"] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	?>
	<script>
		parent.showtabdata('2');
	</script>

	<?php

}





if (isset($_REQUEST['testimonialsDetails']) && $_REQUEST['testimonialsDetails'] != '' && $_REQUEST['testimonialsName'] != '' && $_REQUEST['action'] == 'addtalentTestimonial') {

	$testimonialsName = clean($_REQUEST['testimonialsName']);
	$testimonialsDetails = ($_REQUEST['testimonialsDetails']);
	$talentId = decodeStr($_REQUEST['talentId']);
	$dateAdded = time();


	$sql_ins = "insert into " . _TALENT_TESTIMONIALS_TABLE_ . " SET testimonialsName='" . $testimonialsName . "',testimonialsDetails='" . $testimonialsDetails . "',talentId='" . $talentId . "',userId='" . $_SESSION["sessUserId"] . "',dateAdded='" . $dateAdded . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	?>
	<script>
		parent.showtabdata('3');
		parent.closefuncommonpopupwin();
	</script>
	<?php


}





if (isset($_REQUEST['talentTestimonialspostId']) && $_REQUEST['talentTestimonialspostId'] != '' && $_REQUEST['action'] == 'remoTestiposti') {

	$sql_ins = "DELETE FROM " . _TALENT_TESTIMONIALS_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['talentTestimonialspostId']) . " and userId='" . $_SESSION["sessUserId"] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	?>
	<script>
		parent.showtabdata('3');
	</script>

	<?php

}



if (isset($_REQUEST['profileph']) && $_REQUEST['profileph'] != '' && $_REQUEST['action'] == 'removeProfilePhoto') {

	$a = "SELECT profilePhoto from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
	$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
	$userres = mysqli_fetch_array($b);
	if ($userres['profilePhoto'] != '') {
		unlink("uploads/" . $userres['profilePhoto']);
		unlink("uploads/" . 'x_' . $userres['profilePhoto']);
	}

	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);

	$insertFields[0] = "profilePhoto";

	$insertVals[0] = '';

	$whereFields[0] = "userId";

	$whereVals[0] = $_SESSION['sessUserId'];

	$resUpdate = updateDB(_USERS_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');





	?>
	<script>
		parent.reloadPage();
	</script>

	<?php

}


if ($_REQUEST['action'] == 'applyjob' && trim($_REQUEST['jobid']) != '') {

	$aap = "SELECT * from " . _JOB_INTRESTED_TABLE_ . " WHERE jobId= " . decodeStr($_REQUEST['jobid']) . " and userId='" . $_SESSION["sessUserId"] . "' ";
	$res5p = mysqli_query($conn, $aap);
	$checkBookmarkp = mysqli_num_rows($res5p);
	if ($checkBookmarkp > 0) {
		?>
		<script>
			parent.$('#popupcontentproj').hide();
			parent.$('#frmposthomerecommend').html("<div style='text-align:center; font-size:16px; padding-bottom:20px;'>You are already applied for this job.</div>");
		</script>
		<?php
	} else {
		$sql_insp = "insert into " . _JOB_INTRESTED_TABLE_ . " set userId='" . $_SESSION["sessUserId"] . "',jobId='" . decodeStr($_REQUEST['jobid']) . "',dateAdded='" . time() . "'";
		mysqli_query($conn, $sql_insp) or die(mysqli_error($conn));


		unset($insertFields);
		unset($insertVals);

		$insertFields[0] = "userId";
		$insertFields[1] = "contactId";
		$insertFields[2] = "jobDescription";
		$insertFields[3] = "dateAdded";
		$insertFields[4] = "userSubject";
		$insertFields[5] = "jobId";

		$insertVals[0] = $_SESSION["sessUserId"];
		$insertVals[1] = $_REQUEST['uid'];
		$insertVals[2] = normalclean($_REQUEST['projectdescription']);
		$insertVals[3] = time();
		$insertVals[4] = addslashes($_REQUEST['userSubject']);
		$insertVals[5] = decodeStr($_REQUEST['jobid']);

		$resUpdate = insertDB(_JOB_USER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		$sql_ins2 = "insert into " . _NOTIFICATION_MASTER_TABLE_ . " set contactId='" . $_SESSION["sessUserId"] . "',userId='" . $_REQUEST['uid'] . "',postId='" . decodeStr($_REQUEST['jobid']) . "',postType=155,notificationText='interestedjob',dateAdded='" . time() . "'";
		mysqli_query($conn, $sql_ins2) or die(mysqli_error($conn));

		$sql = "SELECT emailApplyProject from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId= " . $_REQUEST['uid'] . " ";
		$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));
		$getUserSettings = mysqli_fetch_array($getSql);

		if ($getUserSettings["emailApplyProject"] == 1) {


			////////////
			$a = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,email from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_REQUEST['uid'] . "' ";
			$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
			$userres = mysqli_fetch_array($b);
			$email = $userres['email'];



			$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl,cityName,countryName from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . $_SESSION['sessUserId'] . "' ";
			$res52 = mysqli_query($conn, $aa2);
			$getuser2 = mysqli_fetch_array($res52);

			$firstName2 = $getuser2['firstName'];
			$lastName2 = $getuser2['lastName'];
			$profilePhoto2 = $getuser2['profilePhoto'];
			$jobTitle = $getuser2["jobTitle"];
			$companyName = $getuser2["companyName"];
			$userurl2 = $getuser2["userurl"];
			$cityName = $getuser2["cityName"];
			$countryName = $getuser2["countryName"];

			if ($profilePhoto2 != '') {
				$profilePhoto2 = $profilePhoto2;
			} else {
				$profilePhoto2 = 'user-placeholder.jpg';
			}



			$mailBodyContent .= '';
			$mailBodyContent .= '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
    <tbody>
    <tr>
        <td align="center" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px">
                <tbody>
                <tr>
                    <td align="center" valign="top" style="width:100%;padding:20px 0">
                        <a href="' . $fullurl . '" target="_blank" >
                            <img src="' . $fullurl . 'images/sdglogo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
                </tr>
                <tr>
                  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">


					  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">

					  <div style="text-align:center; margin-bottom:5px; margin-top:5px;font-size:18px;"><strong>Job Title:</strong> <a href="' . $fullurl . 'view-job.html?id=' . $_REQUEST['jobid'] . '&cuid=' . $_SESSION['sessUserId'] . '&t=12">' . $_REQUEST['projetvname'] . '</a></div>
					  <div style="text-align:center; margin-bottom:5px; margin-top:30px;font-size:15px;">Applied by:</div>

					    <div style="text-align:center;"><div style="
    width: 80px;
    height: 80px;
    overflow: hidden;margin:auto;
    margin-bottom:12px;
    border-radius: 100%;
    border: 3px #e9e9e9 solid; margin:auto;
"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl2 . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2"><img src="' . $fullurl . 'uploads/' . $profilePhoto2 . '" style="
    width: 100%;
"></a></div>
<div style="text-align:center; margin-bottom:5px; margin-top:5px;"><strong>' . $firstName2 . ' ' . $lastName2 . '</strong></div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $jobTitle . ' at ' . $companyName . '</div>
<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $cityName . ', ' . $countryName . '</div>

<div style="text-align:center; margin-top:10px; margin-bottom:30px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
  <tbody><tr>
    <td colspan="2" align="center"><a href="' . $fullurl . 'profile/' . encodeStr($_SESSION['sessUserId']) . '/' . $userurl2 . '.html?cuid=' . $_SESSION['sessUserId'] . '&t=2" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#0abe51;border-radius:5px;margin-bottom: 0px;" target="_blank">View Profile</a></td>
    </tr>
</tbody></table>
</div>
</div>
					  </div>

                  </td>
                </tr>
                <tr>
                    <td align="center" style="padding:40px;margin:0">
                       <div style="text-align:center; font-size:12px; margin-bottom:20px;">

                       <a href="' . $fullurl . 'privacy.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Privacy</a> -

                          <a href="' . $fullurl . 'terms.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Terms</a> -

                        <a href="' . $fullurl . 'about.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">About</a> -

                          <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div>
<p style="margin:0;padding:0;font-family:"Open Sans",Arial,Helvetica,sans-serif;line-height:24px;color:#616161;font-size:14px;text-align:center">
                             Powered by <a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $domainname . '</a></p>                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</div>';


			$subject = "" . $firstName2 . " has applied for your job on " . $companNameTitle . "";

			send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);



		}

		$_SESSION["smg8"] = 1;

		?>
		<script>
			parent.reloadPage();

		</script>
		<?php
	}
}


if (trim(isset($_REQUEST['jobid']) && $_REQUEST['jobid']) != '' && $_REQUEST['action'] == 'deljob') {
	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	$dltid = decodeStr($_REQUEST['jobid']);

	$password = clean($_POST['delgrppassword']);


	if (trim($password) != "") {
		$pass = md5($password);
		if ($pass != $userpasswordchanged) {
			?>
			<script>
				parent.$('#commonloader').hide();
				parent.$('#errormsg').text('That password is incorrect. Try again.');
				parent.$('#errormsg').css('color', '#FF0000');
			</script>
			<?php
		} else {
			?>
			<script>
				parent.$('#commonloader').hide();
				parent.$('#errormsg').hide();
			</script>
			<?php
			$sql_ins = "select id FROM " . _JOBS_MASTER_TABLE_ . " WHERE id=" . $dltid . " and userId=" . $_SESSION["sessUserId"] . " ";
			$sql = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
			$s = mysqli_num_rows($sql);
			if ($s > 0) {

				$sql_ins = "DELETE FROM " . _JOB_INTRESTED_TABLE_ . " WHERE jobId=" . $dltid . "  ";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

				$sql_ins = "DELETE FROM " . _JOB_USER_TABLE_ . " WHERE jobId=" . $dltid . "  ";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

				$sql_ins = "DELETE FROM " . _NOTIFICATION_MASTER_TABLE_ . " WHERE postId=" . $dltid . " and postType=155 ";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

				$sql_ins = "DELETE FROM " . _JOBS_MASTER_TABLE_ . " WHERE id=" . $dltid . "  ";
				mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

				$_SESSION["d"] = 1;
			}
			?>
			<script>
				parent.reloadPage();
			</script>
			<?php

		}
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.$('#errormsg').text('Please enter your password');
			parent.$('#errormsg').css('color', '#FF0000');
		</script>
		<?php
	}

}


if (
	isset($_REQUEST['contactchatuserid']) &&
	$_REQUEST['contactchatuserid'] != '' &&
	isset($_REQUEST['action']) &&
	$_REQUEST['action'] == 'chatattachedmsg' &&
	isset($_FILES['chatattachedfile']) &&
	!empty($_FILES['chatattachedfile']['name'])
) {

	$strFileExtention = findExtension($_FILES['chatattachedfile']['name']);
	$fileExtention = '';

	if (in_array($strFileExtention, ['jpg', 'jpeg', 'png', 'gif'])) {
		$fileExtention = 'photo';
	} elseif ($strFileExtention == 'pdf') {
		$fileExtention = 'pdf';
	} elseif (in_array($strFileExtention, ['doc', 'docx'])) {
		$fileExtention = 'doc';
	} elseif (in_array($strFileExtention, ['ppt', 'pptx'])) {
		$fileExtention = 'ppt';
	} elseif (in_array($strFileExtention, ['xls', 'xlsx'])) {
		$fileExtention = 'xls';
	} elseif (in_array($strFileExtention, ['txt', 'text'])) {
		$fileExtention = 'txt';
	}

	if ($fileExtention == '') {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.$('#sharepopup').hide();
			parent.showerrormsg('Error', 'Oops! Please upload file with extension only .jpg, .png, .gif, .pdf, .doc, .docx, .ppt, .pptx, .xls, .xlsx, .text.', '');
		</script>
		<?php
		exit();
	}

	// Ensure uploads directory exists
	if (!is_dir(__DIR__ . "/uploads")) {
		mkdir(__DIR__ . "/uploads", 0755, true);
	}

	$timename = time();
	$file_name = preg_replace('!\s+!', '-', $timename . $_FILES['chatattachedfile']['name']);
	$showfile_name = preg_replace('!\s+!', '-', $_FILES['chatattachedfile']['name']);

	$uploadPath = __DIR__ . "/uploads/" . $file_name;
	$thumbPath = __DIR__ . "/uploads/x_" . $file_name;

	if (move_uploaded_file($_FILES['chatattachedfile']['tmp_name'], $uploadPath)) {
		copy($uploadPath, $thumbPath); // thumbnail copy
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.showerrormsg('Error', 'File upload failed.', '');
		</script>
		<?php
		exit();
	}

	$upimg = 'uploads/' . $file_name;
	$dateAdded = time();

	$text = '<div class="chatfiledownload"><b>' . $myname . ' </b> shared a file <a class="dwnload" href="' . $fullurl . 'uploads/x_' . $file_name . '" target="_blank">View</a></div>';

	mysqli_query($conn, "INSERT INTO " . _CHAT_MASTER_TABLE_ . " SET status=1, userId='" . $_SESSION["sessUserId"] . "', contactId='" . decodeStr($_REQUEST["contactchatuserid"]) . "', chatBy='" . $_SESSION["sessUserId"] . "', dateAdded='$dateAdded', chatText='" . $text . "', chatFileName='" . $file_name . "'") or die(mysqli_error($conn));
	$lastchatid = mysqli_insert_id($conn);

	mysqli_query($conn, "INSERT INTO " . _CHAT_MASTER_TABLE_ . " SET status=0, userId='" . decodeStr($_REQUEST["contactchatuserid"]) . "', contactId='" . $_SESSION["sessUserId"] . "', chatBy='" . $_SESSION["sessUserId"] . "', dateAdded='$dateAdded', chatText='" . $text . "', chatFileName='" . $file_name . "'") or die(mysqli_error($conn));

	chattimelineentry($_SESSION["sessUserId"], decodeStr($_REQUEST["contactchatuserid"]), 1);

	mysqli_query($conn, "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET chatStatus=1 WHERE contactId=" . $_SESSION["sessUserId"] . " AND userId='" . decodeStr($_REQUEST["contactchatuserid"]) . "'") or die(mysqli_error($conn));
	mysqli_query($conn, "UPDATE " . _USERS_MASTER_TABLE_ . " SET onlineLastUpdate=" . time() . " WHERE userId=" . $_SESSION["sessUserId"]) or die(mysqli_error($conn));
	mysqli_query($conn, "UPDATE " . _CHAT_MASTER_TABLE_ . " SET status=1 WHERE contactId='" . decodeStr($_REQUEST['contactchatuserid']) . "' AND userId='" . $_SESSION["sessUserId"] . "'") or die(mysqli_error($conn));

	if (!empty($_REQUEST['shb']) && trim($_REQUEST['shb']) == 1) {
		mysqli_query($conn, "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET birthdayStatus=1 WHERE contactId='" . decodeStr($_REQUEST['contactchatuserid']) . "' AND userId='" . $_SESSION["sessUserId"] . "'") or die(mysqli_error($conn));
		?>
		<script>
			parent.$('#saybirthday<?php echo decodeStr($_REQUEST['contactchatuserid']); ?>').slideUp();
		</script>
		<?php
	}

	$token = '';
	$sqlMsgToken = "SELECT token FROM " . _MOBILE_NOTIFICATION_TABLE_ . " WHERE userId='" . decodeStr($_REQUEST["contactchatuserid"]) . "' ORDER BY id DESC LIMIT 1";
	$resMsgToken = mysqli_query($conn, $sqlMsgToken);
	if ($resMsgToken && mysqli_num_rows($resMsgToken) > 0) {
		$getLastToken = mysqli_fetch_assoc($resMsgToken);
		$token = $getLastToken["token"];
	}

	?>
	<div id="sendalert" style="display:none;"></div>
	<div id="sendalert" style="display:none;"></div>

	<script>
		header('Content-Type: application/json');
					echo json_encode([
			'status' => 'success',
			'type' => $fileExtention,
			'file_url' => $fullurl. 'uploads/'.$file_name,
			'thumb_url' => $fullurl. 'uploads/x_'.$file_name,
			'filename' => $file_name
		]);
		exit;

		$token = isset($token) ? urlencode($token) : '';

		parent.$('#commonloader').hide();
		<?php if ($_REQUEST["loadmsgp"] == 1) { ?>
			parent.$('#loadchatusermsg').load('<?php echo $fullurl; ?>load_chat_user_msg.php?userId2=<?php echo urlencode($_REQUEST["contactchatuserid"]); ?>');
		<?php } else { ?>
			parent.$('#loadchatusermsg').load('<?php echo $fullurl; ?>load_message.php?userId2=<?php echo urlencode($_REQUEST["contactchatuserid"]); ?>');
		<?php } ?>

		$("#sendalert").load('app/firebase/Send.php?title=<?php echo urlencode($notititle . ',' . $_SESSION["sessUserId"]); ?>&message=<?php echo urlencode($notimessage); ?>&token=<?php echo urlencode($token); ?>');
	</script>

	<?php
}



if ($_REQUEST['action'] == 'uploaddocuments' && $_FILES['uploaddocumentsfile']['name'] != '') {

	$strFileExtention = findExtension($_FILES['uploaddocumentsfile']['name']);

	if ($strFileExtention == 'pdf') {
		$fileExtention = 'pdf';
	}
	if ($strFileExtention == 'doc' || $strFileExtention == 'docx') {
		$fileExtention = 'doc';
	}
	if ($strFileExtention == 'ppt' || $strFileExtention == 'pptx') {
		$fileExtention = 'ppt';
	}
	if ($strFileExtention == 'xls' || $strFileExtention == 'xlsx') {
		$fileExtention = 'xls';
	}


	if ($fileExtention != '') {


		$timename = time();
		$file_name = str_replace(" ", "-", $_FILES['uploaddocumentsfile']['name']);
		$file_name = str_replace(".xlsx", ".xls", str_replace(".docx", ".doc", str_replace(".pptx", ".ppt", $file_name)));

		$file_name = $timename . $file_name;
		$file_name = preg_replace('!\s+!', '-', $file_name);
		$fileSize = filesize($_FILES['uploaddocumentsfile']['tmp_name']);

		copy($_FILES['uploaddocumentsfile']['tmp_name'], "uploads/" . $file_name);


		if ($fileExtention == 'pdf') {
			$savefile = 'uploads/' . $file_name . '.jpg';
			$inputfile = 'uploads/' . $file_name . '';
			exec("convert -density 100 -colorspace rgb " . $inputfile . "[0] -scale 283x350 " . $savefile . "");
		}

		unset($insertFields);
		unset($insertVals);

		$insertFields[0] = "userId";
		$insertFields[1] = "documentFile";
		$insertFields[2] = "dateAdded";
		$insertFields[3] = "fileSize";

		$insertVals[0] = $_SESSION["sessUserId"];
		$insertVals[1] = $file_name;
		$insertVals[2] = time();
		$insertVals[3] = $fileSize;

		$resUpdate = insertDB(_VAULT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		?>
		<script>
			parent.loadpendingfile();
			parent.$('#commonloader').hide();
			parent.$('#sharepopup').hide();
		</script>
		<?php
	} else {

		?>
		<script>
			parent.$('#commonloader').hide();
			parent.$('#sharepopup').hide();
			parent.showerrormsg('Error', 'Oops! Please upload file with extension only .pdf, .doc, .docx, .ppt, .pptx, .xls, .xlsx', '');
		</script>
		<?php

	}

}

if (isset($_POST['action']) && $_POST['action'] == 'updatedocuments' && trim($_POST["name"]) != '' && trim($_POST["longDescription"]) != '' && trim($_POST["catIds"]) != '' && trim($_POST["fileId"]) != '') {

	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	unset($insertFields);
	unset($insertVals);
	unset($whereFields);
	unset($whereVals);


	$insertFields[0] = "name";
	$insertFields[1] = "longDescription";
	$insertFields[2] = "documentKeyword";
	$insertFields[3] = "catIds";
	$insertFields[4] = "privacy";

	$insertVals[0] = clean($_POST["name"]);
	$insertVals[1] = clean($_POST["longDescription"]);
	$insertVals[2] = addslashes($_POST["documentKeyword"]);
	$insertVals[3] = clean($_POST["catIds"]);
	$insertVals[4] = clean($_POST["privacy"]);

	$whereFields[0] = "userId";
	$whereFields[1] = "id";

	$whereVals[0] = $_SESSION['sessUserId'];
	$whereVals[1] = trim($_POST["fileId"]);

	$resUpdate = updateDB(_VAULT_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	?>
	<script>
		<?php
		if (trim($_POST["p"]) == 1) {

			?>
			//parent.showsusmsg('SUCCESS','Document details updated successfully','');
			parent.window.location.href = '<?php echo $fullurl; ?>my-vault.html';
			<?php
		}
		?>

		parent.loadpendingfile();
		parent.$('#commonloader').hide();
		parent.$('#sharepopup').hide();
	</script>
	<?php

}


if ($_REQUEST['action'] == 'deldocument' && $_REQUEST['documentId'] != '') {

	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	$dltid = decodeStr($_REQUEST['documentId']);


	if ($dltid != 0 && $dltid != '') {



		$ape = "select documentFile from " . _VAULT_MASTER_TABLE_ . " WHERE  id= " . $dltid . " and userId='" . $_SESSION["sessUserId"] . "' ";
		$bpe = mysqli_query($conn, $ape) or die(mysqli_error($conn));
		$rowLogoImge = mysqli_fetch_array($bpe);

		if ($rowLogoImge["documentFile"] != '') {
			unlink("uploads/" . $rowLogoImge["documentFile"]);
			unlink("uploads/" . $rowLogoImge["documentFile"] . '.jpg');

			$sql_ins = "DELETE FROM " . _VAULT_MASTER_TABLE_ . " WHERE id= " . $dltid . "  and userId='" . $_SESSION["sessUserId"] . "' ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		}

	}
	?>
	<script>
		parent.loadpendingfile();
		parent.showerrormsg('SUCCESS', 'Document deleted successfully', '');
		parent.$('#commonloader').hide();
		parent.$('.popup-alert-cont').hide();
		parent.$('#<?php echo $dltid; ?>').slideUp();
	</script>
	<?php




}

if (trim($_REQUEST['action']) == 'saveadcontent' && trim($_REQUEST['adcategory']) != '' && trim($_REQUEST['myad']) != '' && trim($_REQUEST['addbutton2']) != '' && trim($_REQUEST['budgetId']) != '') {

	if ($_REQUEST["addlinkurl"] != '') {
		$learnurl = 'http://www.' . str_replace("http://", "", str_replace("https://", "", str_replace("www.", "", $_REQUEST["addlinkurl"])));
	} else {
		$learnurl = '';
	}

	$budgetId = trim($_REQUEST['budgetId']);
	//$budgetAdDate=time();
	/*$budgetFldArr=explode("@@",trim($_REQUEST['budgetId']));
	$budgetId=$budgetFldArr[0];
	$budgetAdDate=$budgetFldArr[1];*/
	//echo 	$budgetId.'==='.$budgetAdDate;

	unset($insertFields);
	unset($insertVals);

	$insertFields[0] = "userId";
	$insertFields[1] = "adType";
	$insertFields[2] = "adId";
	$insertFields[3] = "budgetId";
	$insertFields[4] = "buttonType";
	$insertFields[5] = "adURL";
	$insertFields[6] = "dateAdded";
	$insertFields[7] = "adContent";
	$insertFields[8] = "postTitle";
	$insertFields[9] = "viewStatus";
	$insertFields[10] = "status";

	$insertVals[0] = $_SESSION["sessUserId"];
	$insertVals[1] = trim($_REQUEST['adcategory']);
	$insertVals[2] = trim($_REQUEST['myad']);
	$insertVals[3] = $budgetId;
	$insertVals[4] = trim($_REQUEST['addbutton2']);
	$insertVals[5] = $learnurl;
	$insertVals[6] = time();
	$insertVals[7] = trim($_REQUEST['adContent']);
	$insertVals[8] = addslashes($_REQUEST['postTitle']);
	$insertVals[9] = 1;
	$insertVals[10] = 1;

	$resUpdate = insertDB(_AD_POST_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$postLastId = $resUpdate;

	$insertFields = [];
	$insertVals = [];
	$whereFields = [];
	$whereVals = [];

	$insertFields[0] = "postType";
	$insertFields[1] = "postText";
	$insertFields[2] = "shareType";
	$insertFields[3] = "dateAdded";
	$insertFields[4] = "userId";
	$insertFields[5] = "adId";
	$insertFields[6] = "adType";

	$insertVals[0] = 2;
	$insertVals[1] = trim($_REQUEST['adContent']);
	$insertVals[2] = 1;
	$insertVals[3] = time();
	$insertVals[4] = $_SESSION['sessUserId'];
	$insertVals[5] = $postLastId;
	$insertVals[6] = trim($_REQUEST['adcategory']);


	$postUpdate = insertDB(_SHAREANDUPDATES_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	$postTimeLastId = $postUpdate;

	unset($insertFields);
	unset($insertVals);

	$insertFields[0] = "userId";
	$insertFields[1] = "postId";
	$insertFields[2] = "postType";
	$insertFields[3] = "shareType";
	$insertFields[4] = "dateAdded";
	$insertFields[5] = "adType";

	$insertVals[0] = $_SESSION["sessUserId"];
	$insertVals[1] = $postTimeLastId;
	$insertVals[2] = 2;
	$insertVals[3] = 1;
	$insertVals[4] = time();
	$insertVals[5] = 1;

	$resUpdate = insertDB(_TIMELINE_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');




	?>
	<script>
		parent.window.location.href = '<?php echo $fullurl; ?>myads.html';
	</script>
	<?php

}


if (isset($_REQUEST['groupId']) && $_REQUEST['groupId'] != '' && $_REQUEST['action'] == 'leavepublicgrp') {
	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php


	$sql_ins = "DELETE FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " where  userId=" . $_SESSION["sessUserId"] . " and groupId=" . decodeStr($_REQUEST['groupId']) . " ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	/*$myvar='<div style="color:#b5b5b5;">'.$myname.' has left this group</div>';
	$dateAdded=time();
	$sql_ins="insert into "._GROUP_CHAT_MASTER_TABLE_." set status=1,userId='".$_SESSION["sessUserId"]."',chatBy='".$_SESSION["sessUserId"]."',dateAdded='$dateAdded',chatText= '".$myvar."',groupId='".decodeStr($_REQUEST["groupId"])."',msgType='text'";
	mysql_query($sql_ins) or die(mysql_error());*/
	$_SESSION["d"] = 2;
	?>
	<script>
		parent.$('#alertpopup').hide();
		parent.$('#commonloader').hide();
		parent.window.location.href = '<?php echo $fullurl; ?>my-groups.html';
	</script>
	<?php
}

if (trim(isset($_REQUEST['chatId']) && $_REQUEST['chatId']) != '' && $_REQUEST['action'] == 'meetingstatus' && $_REQUEST['userid'] != '' && $_REQUEST['status'] != '') {

	$sql_ins = "UPDATE " . _MEETING_MASTER_TABLE_ . " SET status='" . $_REQUEST['status'] . "' WHERE chatId= '" . ($_REQUEST['chatId']) . "' AND userId='" . $_REQUEST['userid'] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

}


if (isset($_REQUEST['contactId']) && $_REQUEST['contactId'] != '' && $_SESSION['sessUserId'] != '' && $_REQUEST['action'] == 'meeting' && $_REQUEST['meetingdate'] != '' && $_REQUEST['checkInTime'] != '' && $_REQUEST['meetinghour'] != '' && $_REQUEST['meetingminutes'] != '' && $_REQUEST['title'] != '') {


	$_REQUEST['myId'] = $_SESSION['sessUserId'];


	$meetingdate = $_REQUEST["meetingdate"];
	$checkInTime = $_REQUEST["checkInTime"];
	$_REQUEST['meetingDateTime'] = $meetingdate . ' ' . $checkInTime;


	$_REQUEST['duration'] = $_REQUEST['meetinghour'] . ' ' . $_REQUEST['meetingminutes'];

	$dateAdded = time();

	$string = $_REQUEST['contactId'];
	$string = preg_replace('/\.$/', '', $string);
	$array = explode(', ', $string);
	foreach ($array as $value) {


		$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=1,userId='" . $_REQUEST['myId'] . "',contactId='" . ($value) . "',chatBy='" . $_REQUEST['myId'] . "',dateAdded='$dateAdded',meeting=1";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
		$lastchatid = mysqli_insert_id();


		$sql_ins = "insert into " . _CHAT_MASTER_TABLE_ . " set status=0,userId='" . ($value) . "',contactId='" . $_REQUEST['myId'] . "',chatBy='" . $_REQUEST['myId'] . "',dateAdded='$dateAdded',meeting=1";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		$chatId = mysqli_insert_id();


		chattimelineentry($_SESSION["sessUserId"], $value, 1);

		$sql_ins = "insert into " . _MEETING_MASTER_TABLE_ . " set status=0,userId='" . ($value) . "',createdBy='" . $_REQUEST['myId'] . "',chatId='" . $chatId . "',meetingDateTime='" . strtotime(str_replace('%20', ' ', $_REQUEST['meetingDateTime'])) . "',duration='" . $_REQUEST['duration'] . "',agenda='" . addslashes($_REQUEST['agenda']) . "',title='" . addslashes($_REQUEST['title']) . "'";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	}


	$sql_ins = "insert into " . _MEETING_MASTER_TABLE_ . " set status=0,userId='" . ($_REQUEST['myId']) . "',createdBy='" . $_REQUEST['myId'] . "',chatId='" . $lastchatid . "',meetingDateTime='" . strtotime(str_replace('%20', ' ', $_REQUEST['meetingDateTime'])) . "',duration='" . $_REQUEST['duration'] . "',agenda='" . addslashes($_REQUEST['agenda']) . "',title='" . addslashes($_REQUEST['title']) . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$token = '';
	$sqlMsgToken = "";
	$sqlMsgToken = "select token from " . _MOBILE_NOTIFICATION_TABLE_ . " where userId='" . ($_REQUEST["contactId"]) . "' ORDER BY id desc ";
	$resMsgToken = mysqli_query($conn, $sqlMsgToken);
	$getLastToken = mysqli_fetch_array($resMsgToken);
	$token = $getLastToken["token"];
	?>
	<div id="sendalert" style="display:none;"></div>
	<script>
		$text = trim((string)($_REQUEST['something'] ?? ''));

		parent.closefuncommonpopupwin();
		parent.$('#loadchatusermsg').load("<?php echo $fullurl; ?>load_chat_user_msg.php?userId2=<?php echo encodeStr($_REQUEST['contactId']); ?>");
		$("#sendalert").load('app/firebase/Send.php?title=<?php echo $notititle . ',' . $_SESSION["sessUserId"]; ?>&message=<?php echo $notimessage; ?>&token=<?php echo $token; ?>');
	</script>

	<?php
}

if (trim(isset($_REQUEST['userId']) && $_REQUEST['userId']) != '' && $_REQUEST['action'] == 'closeuseraccount') {
	?>
	<script>
		parent.$('#commonloader').show();
	</script>
	<?php
	$userId = $_REQUEST['userId'];
	$password = clean($_POST['delgrppassword']);

	if (trim($password) != "") {
		$pass = md5($password);
		if ($pass != $userpasswordchanged) {
			?>
			<script>
				parent.$('#commonloader').hide();
				parent.$('#errormsg').text('That password is incorrect. Try again.');
				parent.$('#errormsg').css('color', '#FF0000');
			</script>
			<?php
		} else {
			?>
			<script>
				parent.$('#commonloader').hide();
				parent.$('#errormsg').hide();
			</script>
			<?php

			$sql_ins = "update " . _USERS_MASTER_TABLE_ . " SET userAccountCloseStatus=1 WHERE userId='" . $_SESSION["sessUserId"] . "' ";
			mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
			?>
			<script>
				window.top.location.href = "<?php echo $fullurl; ?>logout.html?_c=1";
			</script>
			<?php

		}
	} else {
		?>
		<script>
			parent.$('#commonloader').hide();
			parent.$('#errormsg').text('Please enter your password');
			parent.$('#errormsg').css('color', '#FF0000');
		</script>
		<?php
	}

}













if (isset($_REQUEST['shareType']) && $_REQUEST['shareType'] != '' && $_REQUEST['postpost'] != '0' && $_REQUEST['action'] == 'webshare') {

	if (trim($_REQUEST['postText']) != '' || $_REQUEST['imgyes'] == 1) {
		?>
		<script>
			parent.$('#commonloader').show();
		</script>
		<?php

		$linkcontentsubmit = '';
		$linkcontentsubmit = preg_replace('/<br \/>/iU', '', $_REQUEST['linkcontentsubmit']);
		if ($linkcontentsubmit != '') {
			$postText = addslashes($_REQUEST['postText'] . '' . $linkcontentsubmit);
		} else {
			$postText = addslashes($_REQUEST['postText']);
		}

		$tageduserid = str_replace("'", "", trim($_REQUEST['tageduserid']));
		$tageduserid = rtrim($tageduserid, ",");



		unset($insertFields);
		unset($insertVals);
		unset($whereFields);
		unset($whereVals);

		$insertFields[0] = "postType";
		$insertFields[1] = "postText";
		$insertFields[2] = "shareType";
		$insertFields[3] = "dateAdded";
		$insertFields[4] = "websiteshare";
		$insertFields[5] = "webshare";
		$insertFields[6] = "webshareurl";

		$insertVals[0] = clean($_REQUEST['postType']);
		$insertVals[1] = $postText;
		$insertVals[2] = clean($_REQUEST['shareType']);
		$insertVals[3] = time();
		$insertVals[4] = trim($_REQUEST['websiteshare']);
		$insertVals[5] = 1;
		$insertVals[6] = addslashes($_REQUEST['postText']);

		$whereFields[0] = "id";
		$whereFields[1] = "userId";

		$whereVals[0] = clean($_REQUEST['postId']);
		$whereVals[1] = $_SESSION['sessUserId'];

		$resUpdate = updateDB(_SHAREANDUPDATES_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		if ($resUpdate) {
			unset($insertFields);
			unset($insertVals);

			$insertFields[0] = "userId";
			$insertFields[1] = "postId";
			$insertFields[2] = "postType";
			$insertFields[3] = "shareType";
			$insertFields[4] = "dateAdded";

			$insertVals[0] = $_SESSION["sessUserId"];
			$insertVals[1] = clean($_REQUEST['postId']);
			$insertVals[2] = clean($_REQUEST['postType']);
			$insertVals[3] = clean($_REQUEST['shareType']);
			$insertVals[4] = time();

			$resUpdate = insertDB(_TIMELINE_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

		}


		$sql_ins = "update " . _USERS_MASTER_TABLE_ . " set lastPost=" . clean($_REQUEST['postId']) . " ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

		if ($tageduserid != '') {

			$expElementVal = explode(",", $tageduserid);
			for ($elementCount = 0; $elementCount <= count($expElementVal) - 1; $elementCount++) {
				$contactId = $expElementVal[$elementCount];

				unset($insertFields);
				unset($insertVals);

				$insertFields[0] = "userId";
				$insertFields[1] = "contactId";
				$insertFields[2] = "postType";
				$insertFields[3] = "postId";
				$insertFields[4] = "notificationText";
				;
				$insertFields[5] = "dateAdded";

				$insertVals[0] = $contactId;
				$insertVals[1] = $_SESSION["sessUserId"];
				$insertVals[2] = 119;
				$insertVals[3] = clean($_REQUEST['postId']);
				$insertVals[4] = 'webps';//Web post share
				$insertVals[5] = time();

				//$resUpdate=insertDB(_NOTIFICATION_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');


			}
		}


		?>
		<script>

			parent.$('#postpost').val(0);
			parent.$('#mainpage').hide();
			parent.$('#msg').show();
			parent.$('#webpageredirect').val(1);
			parent.opentimeline('Great! You have successfully shared the update.');
		</script>
		<?php
	}

}



// student send request to mentor
if ($_REQUEST['action'] == 'addmentor' && $_REQUEST['studentid'] != '') {

	$studentId = $_SESSION["sessUserId"];
	$mentorId = decodeStr($_REQUEST['studentid']);
	$status = 0;

	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$insertFields = [];
	$insertVals = [];

	$insertFields[0] = "studentId";
	$insertFields[1] = "mentorId";
	$insertFields[2] = "status";
	$insertFields[3] = "dateAdded";

	$insertVals[0] = $studentId;
	$insertVals[1] = $mentorId;
	$insertVals[2] = $status;
	$insertVals[3] = time();

	$resUpdate = insertDB(_STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');

	?>
	<script>
		parent.$('#sendrequesttomentor').removeAttr('href');
		parent.$('#sendrequesttomentor').removeAttr('target');
		parent.$('#sendrequesttomentor').text('Request Sent');
		parent.$('#sendrequesttomentor').css('background-color', '#b0d400');
		parent.reloadPage();
	</script>
	<?php
}
if (isset($_REQUEST['studentIdcontact']) && $_REQUEST['studentIdcontact'] != '' && $_REQUEST['action'] == 'declinest') {
	$studentId = decodeStr($_REQUEST['studentIdcontact']);
	/*$status = $_REQUEST['status'];
	$mentorId =  $_SESSION["sessUserId"];
	$reason= $_REQUEST['removeresion'];

	unset($selectFields);
	unset($whereFields);
	unset($whereVals);

	unset($insertFields);
	unset($insertVals);

		$insertFields[0]="studentId";
		$insertFields[1]="mentorId";
		$insertFields[2]="status";
		$insertFields[3]="reason";
		$insertFields[4]="dateAdded";

		$insertVals[0]=$studentId;
		$insertVals[1]=$mentorId;
		$insertVals[2]=$status;
		$insertVals[3]=$reason;
		$insertVals[4]=time();
	*/
	$sql_ins = "DELETE FROM " . _STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_ . " WHERE mentorId= " . $_SESSION["sessUserId"] . " AND studentId='" . $studentId . "' ";
	/*$resUpdate=insertDB(_STUDENT_REMOVE_REASON_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');*/
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	$_SESSION["d"] = 1;
	?>
	<script>
		parent.reloadPage();
	</script>
	<?php
}


if (isset($_REQUEST['stmtchatuserid']) && $_REQUEST['stmtchatuserid'] != '' && $_REQUEST['action'] == 'stmtattachedmsg' && $_FILES['stmtattachedfile']['name'] != '') {

	$strFileExtention = findExtension($_FILES['stmtattachedfile']['name']);

	if ($strFileExtention == 'jpg' || $strFileExtention == 'jpeg' || $strFileExtention == 'png' || $strFileExtention == 'gif') {
		$fileExtention = 'photo';
	}
	if ($strFileExtention == 'pdf') {
		$fileExtention = 'pdf';
	}
	if ($strFileExtention == 'doc' || $strFileExtention == 'docx') {
		$fileExtention = 'doc';
	}
	if ($strFileExtention == 'ppt' || $strFileExtention == 'pptx') {
		$fileExtention = 'ppt';
	}
	if ($strFileExtention == 'xls' || $strFileExtention == 'xlsx') {
		$fileExtention = 'xls';
	}
	if ($strFileExtention == 'txt' || $strFileExtention == 'text') {
		$fileExtention = 'txt';
	}

	if ($fileExtention == '') {

		?>
		<script>
			parent.$('#commonloader').hide();
			parent.$('#sharepopup').hide();
			parent.showerrormsg('Error', 'Oops! Please upload file with extension only .jpg, .png, .gif, .pdf, .doc, .docx, .ppt, .pptx, .xls, .xlsx, .text.', '');
		</script>
		<?php
		exit();

	}

	$timename = time();
	$file_name = $_FILES['stmtattachedfile']['name'];
	$showfile_name = $_FILES['stmtattachedfile']['name'];
	$showfile_name = preg_replace('!\s+!', '-', $showfile_name);

	$file_name = $timename . $file_name;
	$file_name = preg_replace('!\s+!', '-', $file_name);
	copy($_FILES['stmtattachedfile']['tmp_name'], "uploads/" . $file_name);
	copy($_FILES['stmtattachedfile']['tmp_name'], "uploads/x_" . $file_name);

	$upimg = 'uploads/' . $file_name;
	//image_fix_orientation($upimg);
//generate_image_thumbnail($upimg, $upimg,'200','200');

	$dateAdded = time();
	//$text="<div class='chatfiledownload'><a href=".$fullurl.'uploads/'.$file_name.">".$myname." shared a file</a></div>";

	$text = '<div class="chatfiledownload"><b>' . $myname . ' </b> shared a file <a class="dwnload" href="' . $fullurl . 'uploads/x_' . $file_name . '" target="_blank">View</a></div>';


	$sql_ins = "insert into " . _STUDENT_MENTOR_CHAT_MASTER_TABLE_ . " set status=1,userId='" . $_SESSION["sessUserId"] . "',contactId='" . decodeStr($_REQUEST["stmtchatuserid"]) . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . $text . "',chatFileName= '" . $file_name . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
	$lastchatid = mysqli_insert_id();

	$sql_ins = "insert into " . _STUDENT_MENTOR_CHAT_MASTER_TABLE_ . " set status=0,userId='" . decodeStr($_REQUEST["stmtchatuserid"]) . "',contactId='" . $_SESSION["sessUserId"] . "',chatBy='" . $_SESSION["sessUserId"] . "',dateAdded='$dateAdded',chatText= '" . $text . "',chatFileName= '" . $file_name . "'";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


	chattimelineentry($_SESSION["sessUserId"], decodeStr($_REQUEST["stmtchatuserid"]), 1);

	$sql_ins = "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET chatStatus=1 WHERE contactId= " . $_SESSION["sessUserId"] . " AND userId='" . decodeStr($_REQUEST["stmtchatuserid"]) . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "UPDATE " . _USERS_MASTER_TABLE_ . " SET onlineLastUpdate=" . time() . " WHERE userId=" . $_SESSION["sessUserId"] . "  ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	$sql_ins = "UPDATE " . _STUDENT_MENTOR_CHAT_MASTER_TABLE_ . " SET status=1 WHERE contactId= '" . decodeStr($_REQUEST['stmtchatuserid']) . "' AND userId='" . $_SESSION["sessUserId"] . "' ";
	mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));

	if (trim($_REQUEST['shb']) == 1) {
		$sql_ins = "UPDATE " . _CONTACT_MASTER_TABLE_ . " SET birthdayStatus=1 WHERE contactId= '" . decodeStr($_REQUEST['stmtchatuserid']) . "' AND userId='" . $_SESSION["sessUserId"] . "' ";
		mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
		?>
		<script>
			parent.$('#saybirthday<?php echo decodeStr($_REQUEST['stmtchatuserid']); ?>').slideUp();
		</script>
		<?php
	}

	$token = '';
	$sqlMsgToken = "";
	$sqlMsgToken = "select token from " . _MOBILE_NOTIFICATION_TABLE_ . " where userId='" . decodeStr($_REQUEST["stmtchatuserid"]) . "' ORDER BY id desc ";
	$resMsgToken = mysqli_query($conn, $sqlMsgToken);
	$getLastToken = mysqli_fetch_array($resMsgToken);
	$token = $getLastToken["token"];

	?>
	<div id="sendalert" style="display:none;"></div>
	<script>

		parent.$('#commonloader').hide();
		<?php
		if ($_REQUEST["loadmsgp"] == 1) { ?>
			parent.$('#loadstmtchat').load('<?php echo $fullurl; ?>load_chat_user_msg.php?stmtId=<?php echo ($_REQUEST["stmtchatuserid"]); ?>');
		<?php } else { ?>
			parent.$('#loadstmtchat').load('<?php echo $fullurl; ?>load_stmtchat.php?stmtId=<?php echo ($_REQUEST["stmtchatuserid"]); ?>');
		<?php } ?>

		$("#sendalert").load('app/firebase/Send.php?title=<?php echo $notititle . ',' . $_SESSION["sessUserId"]; ?>&message=<?php echo $notimessage; ?>&token=<?php echo $token; ?>');
	</script>

	<?php


}

closeConn();
?>