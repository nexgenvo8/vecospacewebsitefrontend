<?php 
require("inc.php");
require("common.php");
require("website_security.php");
 
/*-----------------Add Commond---------------*/

if(isset($_REQUEST['add']) && $_POST['title']!='')
{
include 'uploadimage.php';

$title=trim(addslashes($_POST['title'])); 
$description=addslashes($_POST['txtDescription']);

$meta_title=addslashes($_POST['meta_title']);

$meta_description=addslashes($_POST['meta_description']);

$meta_keyword=addslashes($_POST['meta_keyword']);

$type="menu";
$status=$_POST['status'];
$add_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$backpage=$_POST['backpage'];
$adduser=$_SESSION['username'];
$edit_date=date("Y-m-d H:i:s");
$featured=$_POST['featured'];
$cat_show=$_POST['cat_show'];
/*****************************check duplicte url***********************************************/
					$title_rewriting=strtolower(trim(preg_replace("/[\s-]+/", "-", preg_replace( "/[^a-zA-Z0-9\-]/", '-', addslashes($_POST['title']))),"-"));
					$result1="SELECT COUNT(*) as num FROM post_list WHERE url_rewriting='".$title_rewriting."' ";
					$count=mysql_fetch_array(mysql_query($result1));
					$count1 = $count['num'];
					if($count1=="0"){
					$url_rewriting=strtolower(trim(preg_replace("/[\s-]+/", "-", preg_replace( "/[^a-zA-Z0-9\-]/", '-', addslashes($_POST['title']))),"-")); }
					else { 
					$next_id = mysql_result(mysql_query("SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'post_list'"), 0);
					$url_rewriting=strtolower(trim(preg_replace("/[\s-]+/", "-", preg_replace( "/[^a-zA-Z0-9\-]/", '-', addslashes($_POST['title']."-".$next_id))),"-"));
					}

		
$sql_ins="insert into post_list set title='$title',description='$description',type='$type',status='$status',add_date='$add_date',edit_date='$edit_date',lastip='$lastip',adduser='$adduser',url_rewriting='$url_rewriting',meta_title='$meta_title',meta_description='$meta_description',meta_keyword='$meta_keyword'";
mysql_query($sql_ins) or die(mysql_error());


 header("location:$backpage?action=add");		


}

/*-----------------Edit Commond---------------*/

if($_REQUEST['edit']=="edit" && $_POST['title']!=''){

$title=trim(addslashes($_POST['title']));
$description=addslashes($_POST['txtDescription']);

$meta_title=addslashes($_POST['meta_title']);

$meta_description=addslashes($_POST['meta_description']);

$meta_keyword=addslashes($_POST['meta_keyword']);

$type="menu";
$status=$_POST['status'];
$edit_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$backpage=$_POST['backpage'];
$edituser=$_SESSION['username'];
$featured=$_POST['featured'];
$cat_show=$_POST['cat_show'];
$id=$_POST['id']; 
//$url_rewriting=strtolower(trim(preg_replace("/[\s-]+/", "-", preg_replace( "/[^a-zA-Z0-9\-]/", '-', addslashes($title))),"-"));
				$title_rewriting=strtolower(trim(preg_replace("/[\s-]+/", "-", preg_replace( "/[^a-zA-Z0-9\-]/", '-', addslashes($_POST['title']))),"-"));
				$result1="SELECT COUNT(*) as num FROM post_list WHERE id!= ".$id." and  url_rewriting='".$title_rewriting."' ";
				$count=mysql_fetch_array(mysql_query($result1));
				$count1 = $count['num'];
				if($count1=="0"){
				$url_rewriting=strtolower(trim(preg_replace("/[\s-]+/", "-", preg_replace( "/[^a-zA-Z0-9\-]/", '-', addslashes($_POST['title']))),"-")); }
				else { 
				//$next_id = mysql_result(mysql_query("SELECT MAX(id) FROM post_list"), 0);
				$url_rewriting=strtolower(trim(preg_replace("/[\s-]+/", "-", preg_replace( "/[^a-zA-Z0-9\-]/", '-', addslashes($_POST['title']."-".$id))),"-"));
				}

$sql_ins="update post_list set title='$title',description='$description',feature_img='$image',status='$status',edit_date='$edit_date',lastip='$lastip',edituser='$edituser',url_rewriting='$url_rewriting',meta_title='$meta_title',meta_description='$meta_description',meta_keyword='$meta_keyword' where id = ".$id."";
mysql_query($sql_ins) or die(mysql_error());


 header("location:$backpage?action=edit");		
}



$re="select * from post_list  where id='".$_REQUEST['id']."'";
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
    <td width="151" align="right" style="width:150px;"><a href="<?php echo $_REQUEST['backpage']; ?>" onclick="globalloading();" ><input type="button" name="Submit2" value="Back To List" class="gradiantbtn" /></a></td>
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
          <td width="19%" align="left" valign="top">Page Name</td>
          <td width="81%" align="left" valign="top"><input name="title" type="text" id="title" style="width:98%;" value="<?php  echo stripslashes($post_result['title']); ?>" /></td>
        </tr>
<tr>
          <td align="left" valign="top">Description</td>
          <td align="left" valign="top"><textarea name="txtDescription" id="txtDescription" style="width:98%;"><?php  echo stripslashes($post_result['description']); ?></textarea>
            <script type="text/javascript">
	                var editor = CKEDITOR.replace('txtDescription');
					CKFinder.setupCKEditor( editor,'<?php echo $editorurl; ?>' ) ;
                </script></td>
        </tr>
		
        		<tr>

          <td width="17%" align="left" valign="top">Meta Title</td>

          <td width="83%" align="left" valign="top"><input name="meta_title" type="text" id="meta_title" style="width:97%;" value="<?php  echo stripslashes($post_result['meta_title']); ?>" /></td>

        </tr>
		<tr>

          <td width="17%" align="left" valign="top">Meta Description</td>

          <td width="83%" align="left" valign="top"><textarea class="textarea-new" name="meta_description"  id="meta_description" cols="45" rows="5" style="width:97%;"><?php  echo stripslashes($post_result['meta_description']); ?></textarea></td>

        </tr>
		<tr>

          <td width="17%" align="left" valign="top">Meta Keywords</td>

          <td width="83%" align="left" valign="top"><textarea class="textarea-new" name="meta_keyword"  id="meta_keyword" cols="45" rows="5" style="width:97%;"><?php  echo stripslashes($post_result['meta_keyword']); ?></textarea></td></tr>
		  <!--<tr>
          <td align="left" valign="middle">Active  </td>
          <td align="left" valign="top"><select name="status" id="status">
            <option value="1" <?php if($post_result['status']==1){ ?>selected="selected"<?php } ?>>Yes</option>
            <option value="2" <?php if($post_result['status']==2){ ?>selected="selected"<?php } ?>>No</option>
          </select>          </td>
        </tr>-->

      
        
      </table></td>
    <td width="23%" align="left" valign="top" style="width:250px;">
	<div style="margin-left:10px;" class="featureimagebox">
	 <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
 <!-- <tr>
    <td align="center"><h4 style="margin-bottom:10px;">Feature Image</h4></td>
    </tr>
  <tr>
    <td align="center">
	
	<div id="fimagech"><?php if($post_result['feature_img']!=""){ ?><img src="../upload/thumb/small<?php echo $post_result['feature_img']; ?>" width="150" /><input name="feature_img" type="hidden" id="feature_img" value="<?php echo $post_result['feature_img']; ?>" />  <?php } ?> 


    </div> <input name="feature_img_name" type="text" id="feature_img_name" style="padding:2px;width:150px;" value="<?php echo $post_result['feature_img_name']; ?>"   placeholder="Image Name"  />
    </td>
  </tr>
  <tr>
    <td height="34" align="center" class="yallowlink"><a href="pageimg.php" onclick="openpageimg();" target="pageimgid"><strong>Select Feature Image</strong></a></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
  </tr>-->
  <tr>
    <td align="center">
      <input name="Submit" type="submit" class="bluebutton" id="Submit" value="   Save and Publish   "  onclick="globalloading();"  />
      <?php if($_REQUEST['id']!=""){ ?><input name="edit" type="hidden" id="edit" value="edit" /><input name="id" type="hidden" id="id" value="<?php echo $_REQUEST['id']; ?>" />
      <?php } else { ?><input name="add" type="hidden" id="add" value="add" /><?php } ?>
      <input name="backpage" type="hidden" id="backpage" value="<?php echo $_REQUEST['backpage']; ?>" /></td>
    </tr>
</table>

	 </div><br />

	<?php if($_REQUEST['id']!=""){ ?>
	<div class="gradiantbtn" style="padding-top:20px; font-size:12px; margin-left:10px;">
	  <div align="center" style="padding-bottom:10px;">Added on: 
	    <em>
	     <?php
	echo date("g:ia jS F Y", strtotime($post_result['add_date']));?></em></div>
	<?php if($post_result['add_date']!="0000-00-00 00:00:00"){ ?><div align="center" style="padding-bottom:10px;">Last update: 
	    <em>
	     <?php
	echo date("g:ia jS F Y", strtotime($post_result['edit_date']));?></em></div>
	</div> <?php } } ?>
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
