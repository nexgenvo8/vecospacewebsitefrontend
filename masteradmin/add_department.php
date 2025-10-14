<?php 
require("inc.php");
require("common.php");
require("website_security.php");

$resultkk =mysql_query ("select id from wfs_admin where username='".$_SESSION['username']."'");
$resultAdmin =mysql_fetch_array($resultkk);

$dateAdded=time();
$modifyDate=time();

$addedBy=$resultAdmin['id'];
$modifyBy=$resultAdmin['id'];
  
/*-----------------Add Commond---------------*/

if(isset($_REQUEST['add']))
{ 
$backpage=$_POST['backpage'];
 
$department_name=trim($_POST["department_name"]); 
$status = $_POST['status'];
$sql_ins="insert into departmentMaster set department_name='$department_name',status='$status',dateAdded='$dateAdded',modifyDate='$modifyDate',addedBy='$addedBy',modifyBy='$modifyBy'";

mysql_query($sql_ins) or die(mysql_error()); 
header("location:$backpage?action=add");	
 
}

/*-----------------Edit Commond---------------*/

if($_REQUEST['edit']=="edit"){
$backpage=$_POST['backpage'];
$department_name=trim($_POST["department_name"]); 		 
$status = $_POST['status'];
$id=$_POST['id']; 
  
$backpage=$_POST['backpage'];
$sql_ins="update departmentMaster set department_name='$department_name',status='$status',modifyDate='$modifyDate',modifyBy='$modifyBy' where id = ".$id."";

mysql_query($sql_ins) or die(mysql_error());
 
 header("location:$backpage?action=edit");		
}
 
$re="select * from departmentMaster  where id='".$_REQUEST['id']."'";

$re2=mysql_query($re) or die(mysql_error());
$post_result=mysql_fetch_array($re2);
  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php if($_REQUEST['id']!=""){ echo "Edit"; } else {  echo "Add"; } ?> - <?php echo $_REQUEST['pagetitle']; ?> - <?php echo $profile['company']; ?></title>
<link href="css/main.css" rel="stylesheet" type="text/css" />

<script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script> 
<script language="JavaScript" type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="ckeditor/ckfinder/ckfinder.js"></script> 
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/ddaccordion.js"></script>
<script type="text/javascript" src="js/js.js"></script>
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
    <td width="36"><img src="images/addpage.png" width="32" height="32" /></td>
    <td>
	<h3><?php if($_REQUEST['id']!=""){ echo "Edit"; } else {  echo "Add"; } ?>
	    <?php echo $_REQUEST['pagetitle']; ?></h3>	 </td>
    <td width="151" align="right" style="width:150px;"><a href="<?php echo $_REQUEST['backpage']; ?>" onClick="globalloading();" ><input type="button" name="Submit2" value="Back To List" class="gradiantbtn" /></a></td>
  </tr>
</table>
	</div>
	<div class="loading" id="globalpageloding" style="display:none;">Please Wait Working...</div>
	<form action="" method="post" enctype="multipart/form-data">
	 
	<div class="listingbox addeditpage">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="77%" align="left" valign="top"><table width="100%" border="0" cellpadding="8" cellspacing="0">
              <tr>
                <td width="19%" align="left" valign="top">Department</td>
                <td width="81%" align="left" valign="top">  
				<input name="department_name" type="text" id="department_name" value="<?php  echo stripslashes($post_result['department_name']); ?>" style="width:98%;" required>
				 </td>
              </tr>
              <tr>
                <td width="19%" align="left" valign="top">Status</td>
                <td width="81%" align="left" valign="top">  
				 <select name="status" id="status" style="width:100%">
				     <option value="1" <?php echo ($post_result['status']=="1") ? "selected" : ""; ?>>Active</option>
				     <option value="0" <?php echo ($post_result['status']=="0") ? "selected" : ""; ?>>Inactive</option>
				 </select>
				 </td>
              </tr>
			  
			  
			 
			   
          </table></td>
          <td width="23%" align="left" valign="top" style="width:250px;"><div style="margin-left:10px;" class="featureimagebox">
              <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                 <tr>
                  <td align="center"><input name="Submit" type="submit" class="bluebutton" id="Submit" value="   Save and Publish   "  onclick="globalloading();"  />
                      <?php if($_REQUEST['id']!=""){ ?>
                    <input name="edit" type="hidden" id="edit" value="edit" />
                    <input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
                      <?php } else { ?>
                    <input name="add" type="hidden" id="add" value="add" />
                    <?php } ?>
                      <input name="backpage" type="hidden" id="backpage" value="<?php echo $_REQUEST['backpage']; ?>" /></td>
                </tr>
              </table>
          </div>
              <br />
              <?php if($_REQUEST['id']!=""){ ?>
              <div class="gradiantbtn" style="padding-top:20px; font-size:12px; margin-left:10px;">
                <div align="center" style="padding-bottom:10px;">Added on: <em>
                  <?php
	echo date("g:ia jS F Y", $post_result['dateAdded']);?>
                </em></div>
                <?php if($post_result['modifyDate']!=0){ ?>
                <div align="center" style="padding-bottom:10px;">Last update: <em>
                  <?php
	echo date("g:ia jS F Y", $post_result['modifyDate']);?>
                </em></div>
              </div>
            <?php } } ?>          </td>
        </tr>
      </table>
	</div>
		</form>
	</div>	</td>
  </tr>
</table>
  
 <?php include "footer.php"; ?>

</body>
</html>
