<?php
require("inc.php");
require("common.php");
require("website_security.php");
//----Page Settings-----			
//$type="partner";			
$pagetitle = "Groups";
$targetpage = "group_list.php";
$limit = 100;

//----change status-----			

if ($_GET['status'] != "" && $_GET['unino'] == $_SESSION["cust_session_token"] . "_console") {
	$id = base64_decode($_GET['id']);
	$status = $_GET['status'];

	$sql_ins = "update " . _GROUP_MASTER_TABLE_ . " set status='$status',emailSent=1 where id = " . $id . "";
	mysql_query($sql_ins) or die(mysql_error());

	if ($_REQUEST['emailSent'] == 0) {

		include('../mail.php');
		$mailBodyContent = '';

		$mailBodyContent .= '<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;">
	 <a href="' . $websiteurl . '" target="_blank" style="display: inline-block;padding: 10px;">
    <img src="' . $websiteurl . 'images/ndimlogo.png" width="150px;">
    </a>
</div>
<div style="background-color:#f4f4f4;user-select: none;-moz-user-select: none; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; padding:30px 0px;text-align:center;">
  <div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
    <div style="padding:30px;">
 
      <div style="padding:10px; background-color:#F9F9F9; border:dashed 1px #ccc; border-radius: 2px;">
        <div style="color: #696969; margin-bottom: 22px; font-size: 14px; line-height: 20px;">      
          <div style=" margin-bottom:10px; font-size: 14px;">
        <span style="color:#1a94c3;font-size:22px;">Hello ' . $_REQUEST['username'] . ',</span>
        <div style="display: block;width: 100%;margin-top: 15px;">Congratulations! Your Group "' . $_REQUEST['pagetitle'] . '" is now visible on ' . $companNameTitle . '. Start inviting your friends, colleagues and other like-minded people to join your Group.<br>
          <br>
         You can access it at any time by going to ' . $_REQUEST['pageurl'] . ' or by going to the menu option "Groups" and then clicking on "My Groups".
</div>
          </div>
        </div>
        
        <br>
	<div style="font-size: 14px;line-height: 23px;">Best wishes, <br>
	The Team at ' . $companNameTitle . '
	</div>
    </div>
  </div>
</div>';


		$subject = 'Your Group on ' . $companNameTitle . '';

		send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $_REQUEST['email'], $subject, $mailBodyContent);
		header('Location:group_list.php');
		exit();

	}

}

/*********login token start**********/
$session_token = rand(100000000000, 999999999999);
$_SESSION["cust_session_token"] = $session_token;
$actionId = '_console';
/*********login token end**********/
?>
<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<title>Manage <?php echo $pagetitle; ?> - <?php echo $profile['company']; ?></title>
	<link href="css/main.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="js/jquery-1.6.js"></script>
	<script type="text/javascript" src="js/ddaccordion.js"></script>
	<script type="text/javascript" src="js/js.js"></script>
</head>


</head>

<body id="leftbgblack">
	<?php include "header.php"; ?>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td width="9%" align="left" valign="top" style="width:176px;"> <?php include "left.php"; ?> </td>
			<td width="91%" align="left" valign="top">

				<div class="innerouter">
					<div class="innertitlebox">
						<table width="100%" border="0" cellpadding="0" cellspacing="0">
							<tr>
								<td width="616">
									<h3>Manage <?php echo $pagetitle; ?></h3>
								</td>
								<td width="355" align="right">&nbsp; </td>
								<td width="150" align="right" style="width:150px;"><em><strong>
											<?php



											$classlist = 1;
											$query = "SELECT COUNT(*) as num FROM " . _GROUP_MASTER_TABLE_ . " order by id desc ";

											$total_pages = mysql_fetch_array(mysql_query($query));

											echo $total_pages = $total_pages[num];


											$stages = 3;

											$page = mysql_escape_string($_GET['page']);

											if ($page) {

												$start = ($page - 1) * $limit;

											} else {

												$start = 0;

											}


											// Get page data			
											
											$query1 = "SELECT * FROM " . _GROUP_MASTER_TABLE_ . " order by id desc LIMIT $start, $limit";

											$result = mysql_query($query1);


											// Initial page num setup			
											
											if ($page == 0) {
												$page = 1;
											}

											$prev = $page - 1;

											$next = $page + 1;

											$lastpage = ceil($total_pages / $limit);

											$LastPagem1 = $lastpage - 1;



											$paginate = '';

											if ($lastpage > 1) {






												$paginate .= "<div class='paginate'>";

												// Previous			
											
												if ($page > 1) {

													$paginate .= "<a href='$targetpage?page=$prev'>previous</a>";

												} else {

													$paginate .= "<span class='disabled'>previous</span>";
												}


												// Pages				
											
												if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up			
												{

													for ($counter = 1; $counter <= $lastpage; $counter++) {

														if ($counter == $page) {

															$paginate .= "<span class='current'>$counter</span>";

														} else {

															$paginate .= "<a href='$targetpage?page=$counter'>$counter</a>";
														}

													}

												} elseif ($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?			
												{

													// Beginning only hide later pages			
											
													if ($page < 1 + ($stages * 2)) {

														for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {

															if ($counter == $page) {

																$paginate .= "<span class='current'>$counter</span>";

															} else {

																$paginate .= "<a href='$targetpage?page=$counter'>$counter</a>";
															}

														}

														$paginate .= "...";

														$paginate .= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";

														$paginate .= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";

													}

													// Middle hide some front and some back			
													elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {

														$paginate .= "<a href='$targetpage?page=1'>1</a>";

														$paginate .= "<a href='$targetpage?page=2'>2</a>";

														$paginate .= "...";

														for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {

															if ($counter == $page) {

																$paginate .= "<span class='current'>$counter</span>";

															} else {

																$paginate .= "<a href='$targetpage?page=$counter'>$counter</a>";
															}

														}

														$paginate .= "...";

														$paginate .= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";

														$paginate .= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";

													}

													// End only hide early pages			
													else {

														$paginate .= "<a href='$targetpage?page=1'>1</a>";

														$paginate .= "<a href='$targetpage?page=2'>2</a>";

														$paginate .= "...";

														for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {

															if ($counter == $page) {

																$paginate .= "<span class='current'>$counter</span>";

															} else {

																$paginate .= "<a href='$targetpage?page=$counter'>$counter</a>";
															}

														}

													}

												}



												// Next			
											
												if ($page < $counter - 1) {

													$paginate .= "<a href='$targetpage?page=$next'>next</a>";

												} else {

													$paginate .= "<span class='disabled'>next</span>";

												}



												$paginate .= "</div>";


											}

											?>
										</strong> items </em></td>
							</tr>
						</table>

					</div>
					<div class="loading" id="globalpageloding" style="display:none;">Please Wait Working...</div>
					<?php if ($_REQUEST['action'] == "add") { ?>
							<div class="successmsg" id="wrongloginclick" style="display:block;">Added Successfully </div>
					<?php } ?>
					<?php if ($_REQUEST['action'] == "edit") { ?>
							<div class="successmsg" id="wrongloginclick" style="display:block;">Update Successfully </div>
					<?php } ?>
					<?php if ($_REQUEST['action'] == "dlt") { ?>
							<div class="successmsg" id="wrongloginclick" style="display:block;">Deleted Successfully </div>
					<?php } ?>

					<form action="" method="post">
						<div class="optionsec">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="62%" align="left" valign="middle">
										<!--<a href="<?php echo $addeditpage; ?>?backpage=<?php echo $backpage; ?>&pagetitle=<?php echo $pagetitle; ?>"  onclick="globalloading();" ><input type="button" name="Submit" value="Add New" class="greenbtn"/></a><input type="button" name="Submit3" value="Delete Selected Items" class="redbutton" onclick="confirmdlt();" />-->
									</td>
									<td width="38%" align="right" valign="middle">
										<div style=" overflow:hidden; text-align:right;">
											<?php echo $paginate; ?>
										</div>
									</td>
								</tr>
							</table>
						</div>
						<div class="listingbox" style="position:relative; min-height:300px;">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<!--<td width="6%" align="left" valign="top" class="listingheaddr">Select</td>-->
									<td width="6%" align="left" valign="top" class="listingheaddr">S. N. </td>
									<!--<td width="2%" align="center" valign="top" class="listingheaddr"><input type="checkbox" id="chkAll" /></td>-->
									<td width="33%" align="left" valign="top" class="listingheaddr">Group Name</td>
									<td width="15%" align="left" valign="top" class="listingheaddr">Group Type </td>
									<td width="15%" align="left" valign="top" class="listingheaddr">User Name</td>
									<td width="17%" align="left" valign="top" class="listingheaddr">Email id</td>
									<td width="17%" align="center" valign="top" class="listingheaddr"> Date </td>
									<td width="7%" align="center" valign="top" class="listingheaddr">Status</td>
									<td width="5%" align="center" valign="top" class="listingheaddr">Open</td>
								</tr>
								<?php while ($res_post = mysql_fetch_array($result)) {
									$postTitle = substr(cleanInput(strip_tags(trim(strtolower(str_replace(' ', '-', preg_replace('/[^A-Za-z0-9\-]/', '-', $res_post['postTitle'])))))), 0, 100);
									?>
										<tr <?php if ($classlist == 1) { ?>style="background-color:#f7f7f7;" <?php } else { ?>style="background-color:#FFFFFF;" <?php } ?>>
											<!--<td align="left" valign="top" class="graylist"> 			
			<input type="checkbox" name="check_list[]" class="chk" id="check_list[]"  value="<?php echo $res_post['userId']; ?>" />       </td>-->
											<td align="left" valign="top" class="graylist"><?php echo $start = $start + 1; ?>
											</td>

											<td align="left" valign="middle" class="graylist">
												<?php echo stripslashes($res_post['groupName']); ?>
											</td>
											<td align="left" valign="middle" class="graylist">
												<?php if (trim($res_post['groupType']) == '0') {
													echo 'Public';
												} else {
													echo 'Private';
												} ?>
											</td>
											<td align="left" valign="middle" class="graylist">
												<?php $re = "select * from " . _USERS_MASTER_TABLE_ . "  where userId='" . $res_post['userId'] . "'";
												$re2 = mysql_query($re) or die(mysql_error());
												$user_res = mysql_fetch_array($re2);
												echo $user_res['firstName'] . ' ' . $user_res['lastName'];
												?>
											</td>
											<td align="left" valign="middle" class="graylist">
												<?php echo stripslashes($user_res['email']); ?>
											</td>
											<td align="center" valign="middle" class="graylist">
												<?php echo date('m/d/Y H:i:s', $res_post['dateAdded']); ?>
											</td>
											<td align="center" valign="middle" class="graylist">
												<?php if ($res_post['status'] == '1') { ?>
														<a href="<?php echo $backpage; ?>?status=0&id=<?php echo base64_encode($res_post['id']); ?>&unino=<?php echo $_SESSION["cust_session_token"] . "_console"; ?>"
															onclick="globalloading();"><img src="images/lock.png" /></a>
												<?php } else { ?><a
															href="<?php echo $backpage; ?>?status=1&id=<?php echo base64_encode($res_post['id']); ?>&unino=<?php echo $_SESSION["cust_session_token"] . "_console"; ?>&emailSent=<?php echo $res_post["emailSent"]; ?>&email=<?php echo stripslashes($user_res['email']); ?>&username=<?php echo $user_res['firstName'] . ' ' . $user_res['lastName']; ?>&pageurl=<?php echo $websiteurl; ?>groups-detail.html?groupId=<?php echo encodeStr($res_post['id']); ?>&pagetitle=<?php echo stripslashes($res_post['groupName']); ?>"
															onclick="globalloading();"><img src="images/unlock.png" width="30"
																border="0" /></a><?php } ?>
											</td>
											<td align="center" valign="top" class="graylist"><a
													href="<?php echo $websiteurl; ?>groups-detail.html?groupId=<?php echo encodeStr($res_post['id']); ?>"
													target="_blank"><img src="images/eye_inv.png" alt="View" width="30"
														height="32" border="0" /></a></td>
										</tr>
										<?php $classlist = $classlist + 1;
										if ($classlist == 3) {
											$classlist = 1;
										}
								} ?>
							</table>
							<div id="confdlt" style="display:none;">
								<div align="left" style="font-size:18px; line-height:25px; margin-bottom:10px;"><img
										src="images/-trash.png" width="50" height="50"
										style="float:left; padding-right:10px;" />Do you want to permanently
									delete the selected items?</div>
								<div style="text-align:center;">
									<input name="Submit2" type="submit" class="redbutton" value="  Yes  "
										onclick="globalloading();" />
									<input name="Submit22" type="button" class="gradiantbtn" value="  No  "
										onclick="closeconfirmdlt();" />
								</div>

							</div>
							<?php if ($total_pages == 0) { ?>
									<div style="padding:10px; background-color:#FFFFFF; text-align:center; color:#CCCCCC;">
										<em>No Item</em>
									</div>
							<?php } ?>
						</div>


						<div class="optionsec">
							<table width="100%" border="0" cellpadding="0" cellspacing="0">
								<tr>
									<td width="62%" align="left" valign="middle">
										<!--<a href="<?php echo $addeditpage; ?>?backpage=<?php echo $backpage; ?>&pagetitle=<?php echo $pagetitle; ?>"  onclick="globalloading();" ><input type="button" name="Submit" value="Add New" class="greenbtn"  /></a><input type="button" name="Submit3" value="Delete Selected Items" class="redbutton" onclick="confirmdlt();" />-->
									</td>
									<td width="38%" align="right" valign="middle">
										<div style="  overflow:hidden; text-align:right;">
											<?php echo $paginate; ?>
										</div>
									</td>
								</tr>
							</table>
						</div>


					</form>
				</div>

			</td>
		</tr>
	</table>



	<?php include "footer.php"; ?>
</body>

</html>