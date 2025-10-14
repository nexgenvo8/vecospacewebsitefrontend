<?php
require("inc.php");
require("common.php");
require("website_security.php");


//----Page Settings-----
//$type="partner";
$pagetitle = "Job Fair Registration";
//$backpage = "manage_country.php";
$targetpage = "manage_jobfair.php";
$tableName = "userMaster";
//$addeditpage = "add_country.php";
$limit =100;

//----change status-----

if($_REQUEST['status']!="" && $_GET['unino']==$_SESSION["cust_session_token"]."_console"){
$id=base64_decode($_REQUEST['id']);
$status=$_REQUEST['status'];

$sql_ins="update ".$tableName." set activeYN='$status' where userId = ".$id."";
mysql_query($sql_ins) or die(mysql_error());

}


if($_REQUEST['makeAdmin']!="" && $_GET['unino']==$_SESSION["cust_session_token"]."_console"){
$id=base64_decode($_REQUEST['id']);
$makeAdmin=$_REQUEST['makeAdmin'];

$sql_ins="update ".$tableName." set makeAdmin='$makeAdmin' where userId = ".$id."";
mysql_query($sql_ins) or die(mysql_error());

$queryadmin = "SELECT * FROM "._USERS_MASTER_TABLE_." where  1 and userAccountCloseStatus=0 and userId='".$id."' order by userId desc ";
$queryResult = mysql_fetch_array(mysql_query($queryadmin));


if($makeAdmin==1){
$sql_ins="insert into wfs_admin set name='".$queryResult['firstName'].' '.$queryResult['lastName']."',company='".$queryResult['firstName'].' '.$queryResult['lastName']."',email='".$queryResult['email']."',username='".$queryResult['email']."',password='".$queryResult['password']."'";
mysql_query($sql_ins) or die(mysql_error());
} else{

$sql_del="delete from wfs_admin where username='".$queryResult['email']."'";
mysql_query($sql_del) or die(mysql_error());

}


}


/*********login token start**********/
$session_token = rand(100000000000,999999999999);
$_SESSION["cust_session_token"]=$session_token;
$actionId='_console';
/*********login token end**********/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
    <td width="9%" align="left" valign="top" style="width:176px;"> <?php include "left.php"; ?>    </td>
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

if($_GET['searchkeywords']!=''){

$a=explode(' ',$_GET['searchkeywords']);
$firstName=trim($a[0]);
if($a[1]!=""){
$lastName=trim($a[1]);
$lstnamequery='or lastName like  '%". $lastName ."%'';
}


$searchname = "and (firstName like  '%". $firstName ."%' '".$lstnamequery."' or email like  '%". trim($_REQUEST['searchkeywords']) ."%')";

}

if($_GET['userType']!=''){
$userQuery = "and userstype='".$_GET['userType']."'";
}

	$classlist=1;

	$query = "SELECT COUNT(*) as num FROM "._USERS_MASTER_TABLE_." where  1 and userAccountCloseStatus=0 ".$userQuery." ".$searchname." and userstype=1 and mobile!='' and universityIdAttchment!='' and studentphotoId!='' order by userId desc ";

	$total_pages = mysql_fetch_array(mysql_query($query));

	echo $total_pages = $total_pages[num];


	$stages = 3;

	$page = mysql_escape_string($_GET['page']);

	if($page){

		$start = ($page - 1) * $limit;

	}else{

		$start = 0;

		}


    // Get page data

	 $query1 = "SELECT * FROM "._USERS_MASTER_TABLE_." where  1 and userAccountCloseStatus=0 ".$userQuery." ".$searchname." and userstype=1 and mobile!='' and universityIdAttchment!='' and studentphotoId!='' order by userId desc LIMIT $start, $limit";

	$result = mysql_query($query1);


	// Initial page num setup

	if ($page == 0){$page = 1;}

	$prev = $page - 1;

	$next = $page + 1;

	$lastpage = ceil($total_pages/$limit);

	$LastPagem1 = $lastpage - 1;



	$paginate = '';

	if($lastpage > 1)

	{






		$paginate .= "<div class='paginate'>";

		// Previous

		if ($page > 1){

			$paginate.= "<a href='$targetpage?page=$prev'>previous</a>";

		}else{

			$paginate.= "<span class='disabled'>previous</span>";	}


		// Pages

		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up

		{

			for ($counter = 1; $counter <= $lastpage; $counter++)

			{

				if ($counter == $page){

					$paginate.= "<span class='current'>$counter</span>";

				}else{
					$searchkeywordsdata=$_GET['searchkeywords'];
					$userTypedata=$_GET['userType'];
					$paginate.= "<a href='$targetpage?page=$counter&searchkeywords=$searchkeywordsdata&userType=$userTypedata'>$counter</a>";

					}

			}

		}

		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?

		{

			// Beginning only hide later pages

			if($page < 1 + ($stages * 2))

			{

				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)

				{

					if ($counter == $page){

						$paginate.= "<span class='current'>$counter</span>";

					}else{

						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}

				}

				$paginate.= "...";

				$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";

				$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";

			}

			// Middle hide some front and some back

			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))

			{

				$paginate.= "<a href='$targetpage?page=1'>1</a>";

				$paginate.= "<a href='$targetpage?page=2'>2</a>";

				$paginate.= "...";

				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)

				{

					if ($counter == $page){

						$paginate.= "<span class='current'>$counter</span>";

					}else{

						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}

				}

				$paginate.= "...";

				$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";

				$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";

			}

			// End only hide early pages

			else

			{

				$paginate.= "<a href='$targetpage?page=1'>1</a>";

				$paginate.= "<a href='$targetpage?page=2'>2</a>";

				$paginate.= "...";

				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)

				{

					if ($counter == $page){

						$paginate.= "<span class='current'>$counter</span>";

					}else{

						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}

				}

			}

		}



				// Next

		if ($page < $counter - 1){

			$paginate.= "<a href='$targetpage?page=$next'>next</a>";

		}else{

			$paginate.= "<span class='disabled'>next</span>";

			}



		$paginate.= "</div>";


}

?></strong> items </em></td>
  </tr>
</table>

	</div>
	 <div class="loading" id="globalpageloding" style="display:none;">Please Wait Working...</div>
	  <?php if($_REQUEST['action']=="add"){ ?><div class="successmsg" id="wrongloginclick" style="display:block;">Data Imported Successfully </div><?php } ?>
	  <?php if($_REQUEST['action']=="edit"){ ?><div class="successmsg" id="wrongloginclick" style="display:block;">Update Successfully </div><?php } ?>
	  	  <?php if($_REQUEST['action']=="dlt"){ ?><div class="successmsg" id="wrongloginclick" style="display:block;">Deleted Successfully </div><?php } ?>


	<form action="manage_jobfair.php" method="get">

		  <div class="srchfcontct">

		<div class="srch-field">
			<input type="text" name="searchkeywords" id="searchkeywords" maxlength="60" placeholder="Enter name or email address" autocomplete="off" value="<?php echo $_REQUEST['searchkeywords']; ?>">

		</div>

		<div class="srch-field" style="display:none;">
			<select name="userType" id="userType">
			<option value="" <?php if($_GET['userType']==""){ ?> selected="selected" <?php } ?>>All Users</option>
			<option value="1" <?php if($_GET['userType']==1){ ?> selected="selected" <?php } ?>>Student</option>
			<option value="2" <?php if($_GET['userType']==2){ ?> selected="selected" <?php } ?>>Faculty</option>
			<option value="3" <?php if($_GET['userType']==3){ ?> selected="selected" <?php } ?>>Alumni</option>
			<option value="4" <?php if($_GET['userType']==4){ ?> selected="selected" <?php } ?>>Industry Professional</option>
			<option value="5" <?php if($_GET['userType']==5){ ?> selected="selected" <?php } ?>>Career Enhancer / Service Provider</option>
			<option value="0" <?php if($_GET['userType']==0 && $_GET['userType']!=""){ ?> selected="selected" <?php } ?>>Not Yet Selected</option>
			</select>
		</div>
        <div class="srch-field">
			<div>&nbsp;</div>
		</div>
		<div class="srch-field">
			<button type="submit" >Search</button>
		</div>
		 
	</div>

		  </form>

	 

	  <form action="" method="post">
	<div class="optionsec">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          

<style>
.srchfcontct {
    float: left;
    width: 100%;
    border-radius: 2px;
    background-color: #fff;
    padding: 0px;
    margin-bottom: 16px;
}
.srch-field {
    
    float: left;
    overflow: hidden;
    position: relative;
    margin-right: 10px;
}
.srch-field input, select {
    width: 100%;
    border: solid 1px #e7e7e7 !important;
    font-size: 12px !important;
    padding: 9px !important;
    border-radius: 2px;
    box-sizing: border-box;
    height: 35px;
}
.srch-field button {
    position: relative;
    padding: 11px 20px;
    border: 0;
    height: 35px;
    background-color: #20741f;
    color: #fff;
    border-radius: 0px 3px 3px 0;
    box-sizing: border-box;
    cursor: pointer;
}
.box-div {
    width: 16.6%;
    float: left;
    margin: 0px;
    margin-bottom: 10px;
}
</style>
        </tr>
      </table>
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="100%" align="right" valign="middle"><div style=" overflow:hidden; text-align:right;">
   <?php  echo $paginate; ?>
 </div></td>
        </tr>
      </table>
	</div>
	<div class="listingbox" style="position:relative; min-height:300px;">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <!--<td width="6%" align="left" valign="top" class="listingheaddr">Select</td>-->
          <td width="6%" align="left" valign="top" class="listingheaddr">S. N.</td>
          <td width="14%" align="left" valign="top" class="listingheaddr">UPC No.</td> 
          <!--<td width="2%" align="center" valign="top" class="listingheaddr"><input type="checkbox" id="chkAll" /></td>-->
          <td width="14%" align="left" valign="top" class="listingheaddr">Name</td> 
          
          <td width="7%" align="left" valign="top" class="listingheaddr">Department</td> 
          <td width="7%" align="left" valign="top" class="listingheaddr">Course</td> 
          <td width="2%" align="left" valign="top" class="listingheaddr">Semester</td>
          <td width="4%" align="left" valign="top" class="listingheaddr">Passing Year</td> 
          <td width="14%" align="left" valign="top" class="listingheaddr">Email</td>
          <td width="14%" align="left" valign="top" class="listingheaddr">Mobile</td> 
          <td width="14%" align="left" valign="top" class="listingheaddr">Gender</td> 
          <td width="7%" align="center" valign="top" class="listingheaddr">University Id</td>
          <td width="7%" align="center" valign="top" class="listingheaddr">Student Id</td>
          <td width="7%" align="center" valign="top" class="listingheaddr">Student Id Proof</td>
          <td width="7%" align="center" valign="top" class="listingheaddr">Student Id Type</td>
          
        </tr>
        <?php  while($res_post = mysql_fetch_array($result)) { ?>
		<tr <?php if($classlist==1){ ?>style="background-color:#f7f7f7;" <?php }  else { ?>style="background-color:#FFFFFF;" <?php } ?>>
		  <!--<td align="left" valign="top" class="graylist">
            <input type="checkbox" name="check_list[]" class="chk" id="check_list[]"  value="<?php echo $res_post['userId']; ?>" />       </td>-->
		  <td align="left" valign="top" class="graylist"><?php echo $start=$start+1; ?></td>
          <td align="left" valign="middle" class="graylist"><?php  echo stripslashes($res_post['registrationNo']); ?></td>
          <td align="left" valign="middle" class="graylist"><?php  echo stripslashes($res_post['firstName']); ?> <?php  echo stripslashes($res_post['lastName']); ?></td>
          <td align="left" valign="middle" class="graylist"><?php  echo stripslashes($res_post['departmentname']); ?></td>
          <td align="left" valign="middle" class="graylist"><?php  echo stripslashes($res_post['coursename']); ?></td>
          <td align="left" valign="middle" class="graylist"><?php  echo stripslashes($res_post['semester']); ?></td>
          <td align="left" valign="middle" class="graylist"><?php  echo stripslashes($res_post['passingyear']); ?></td>
          <td align="left" valign="middle" class="graylist"><?php  echo stripslashes($res_post['email']); ?></td>
          <td align="center" valign="middle" class="graylist"><?php  echo $res_post['mobile']; ?></td>
          <td align="center" valign="middle" class="graylist"><?php  echo $res_post['gender']; ?></td>
          <td align="center" valign="middle" class="graylist"><a href="<?php echo $websiteurl; ?>uploads/<?php  echo $res_post['universityIdAttchment']; ?>" target="BLANK__">View</a></td>
          <td align="center" valign="middle" class="graylist"><?php  echo $res_post['studentId']; ?></td>
          <td align="center" valign="middle" class="graylist"><a href="<?php echo $websiteurl; ?>uploads/<?php  echo $res_post['studentphotoId']; ?>"  target="BLANK__">View</a></td>   
          <td align="center" valign="middle" class="graylist">
              <?php $re="select * from documentType  where id='".$res_post['photoIdType']."'";
$re2=mysql_query($re) or die(mysql_error());  $industry_res=mysql_fetch_array($re2);
echo $industry_res['name'];
?></td>   
        </tr>
		<?php $classlist=$classlist+1; if($classlist==3){ $classlist=1; } } ?>
      </table>
	  <div id="confdlt" style="display:none;">
	  <div align="left" style="font-size:18px; line-height:25px; margin-bottom:10px;"><img src="images/-trash.png" width="50" height="50"  style="float:left; padding-right:10px;"/>Do you want to permanently
	    delete the selected  items?</div>
		<div style="text-align:center;">
		  <input name="Submit2" type="submit" class="redbutton" value="  Yes  "  onclick="globalloading();"/>
		  <input name="Submit22" type="button" class="gradiantbtn" value="  No  " onclick="closeconfirmdlt();" />
		</div>

	</div>
	  <?php if($total_pages==0){ ?>
	  <div style="padding:10px; background-color:#FFFFFF; text-align:center; color:#CCCCCC;"><em>No Item</em></div>
	  <?php } ?>
	</div>


	<div class="optionsec">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="62%" align="left" valign="middle"><!--<a href="<?php echo $addeditpage; ?>?backpage=<?php echo $backpage; ?>&pagetitle=<?php echo $pagetitle; ?>"  onclick="globalloading();" ><input type="button" name="Submit" value="Add New" class="greenbtn"  /></a><input type="button" name="Submit3" value="Delete Selected Items" class="redbutton" onclick="confirmdlt();" />--></td>
          <td width="38%" align="right" valign="middle"><div style="  overflow:hidden; text-align:right;">
            <?php  echo $paginate; ?>
          </div></td>
        </tr>
      </table>
	</div>


		</form>
	</div>

	</td>
  </tr>
</table>
<script>
function funcResendEmail(id){
    $('#sendbutton'+id).val('Sending...');
    $('#sendbutton'+id).load("resendemail.php?id="+id);
}
</script>


 <?php include "footer.php"; ?>
</body>
</html>
