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
 
$course_name=trim($_POST["course_name"]); 
$status = $_POST['status'];
$dep=implode(",", $_POST["dep_name"]);
 
$dep_name=rtrim($dep,',');
  
$sql_ins="insert into courseMaster set course_name='$course_name',dep_name='$dep_name',status='$status',dateAdded='$dateAdded',modifyDate='$modifyDate',addedBy='$addedBy',modifyBy='$modifyBy'";

mysql_query($sql_ins) or die(mysql_error()); 
header("location:$backpage?action=add");	
 
}

/*-----------------Edit Commond---------------*/

if($_REQUEST['edit']=="edit"){
$backpage=$_POST['backpage'];
$course_name=trim($_POST["course_name"]); 
$status = $_POST['status'];
$dep=implode(",",$_POST["dep_name"]);
$dep_name=rtrim($dep,',');

		  
$id=$_POST['id']; 
  
$backpage=$_POST['backpage'];
$sql_ins="update courseMaster set course_name='$course_name',dep_name='$dep_name',status='$status',modifyDate='$modifyDate',modifyBy='$modifyBy' where id = ".$id."";

mysql_query($sql_ins) or die(mysql_error());
 
 header("location:$backpage?action=edit");		
}
 
$re="select * from courseMaster  where id='".$_REQUEST['id']."'";

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


<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<script>
$(document).ready(function() { 
$("#dep_name").select2();
});
</script>
 
<style>
.select2-container--default .select2-selection--multiple {
    background-color: white;
    border: 1px solid #d8d8d8 !important;
    border-radius: 0px;
    cursor: text;
    margin-top: 5px !important;
    min-height: 35px !important;
}
.select2-container--default .select2-selection--multiple{
margin-top: -1px !important;
border-radius: .1875rem;
}

</style>
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
				 <select name="dep_name[]" id="dep_name" style="width:100%" multiple="multiple">
				<?php 
				
				$myArraynew = explode(',', $post_result['dep_name']); 
				
				$query1kkk = "SELECT * FROM departmentMaster where  1 order by department_name asc";			
				$resultkkk = mysql_query($query1kkk);	
				while($depName=mysql_fetch_array($resultkkk)){ 
				?>
				<option value="<?php echo $depName['id']; ?>" <?php foreach($myArraynew as $key => $value) { if($value == $depName['id']){ echo 'selected="selected"'; } }?>><?php echo $depName['department_name']; ?></option>
				     
					 <?php } ?>
					 
				</select>
				</td>
				 
              </tr>
			
			
			  <tr>
                <td width="19%" align="left" valign="top">Course</td>
                <td width="81%" align="left" valign="top">  
				<input name="course_name" type="text" id="course_name" value="<?php  echo stripslashes($post_result['course_name']); ?>" style="width:98%;" required>
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
