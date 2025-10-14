<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session

if($_REQUEST["fileId"]!='')
{
$dd="SELECT * from "._GROUP_FILE_TABLE_." WHERE id= ".$_REQUEST["fileId"]."  ";
$ee=mysqli_query($conn, $dd) or die(mysqli_error($conn)); 
$rowfilename=mysqli_fetch_array($ee);

$filename=$_REQUEST['filename'];

$strFileExtention=findExtension($rowfilename['fileName']);

if($strFileExtention=='jpg' || $strFileExtention=='jpeg' || $strFileExtention=='png' || $strFileExtention=='gif'){ $fileExtention='photo';}
if($strFileExtention=='pdf'){ $fileExtention='pdf';}
if($strFileExtention=='doc' || $strFileExtention=='docx'){ $fileExtention='doc';}
if($strFileExtention=='ppt' || $strFileExtention=='pptx'){ $fileExtention='ppt';}
if($strFileExtention=='xls' || $strFileExtention=='xlsx'){ $fileExtention='xls';}
if($strFileExtention=='txt' || $strFileExtention=='text'){ $fileExtention='txt';}
?>

<?php if($fileExtention=='photo'){?><img src="<?php echo $fullurl;?>groupuploads/<?php echo $rowfilename['fileName'];?>"><?php }?>
	<div class="after-img">
      <label>Title</label>
      <input type="text" name="fileName" id="fileName" value="<?php echo $filename;?>" maxlength="250"> 
      <textarea rows="4" name="filegroupchatfield" id="filegroupchatfield" maxlength="250" style="display:none;"></textarea>
	<input type="hidden" name="msgType" id="msgType" value="<?php echo $fileExtention;?>" />
	<input type="hidden" name="action" id="action" value="uploadgroupfile" />
	<input type="hidden" name="groupgroupId" id="groupgroupId" value="<?php echo encodeStr($rowfilename['groupId']);?>" />
	
	<input type="hidden" name="groupFileId" id="groupFileId" value="<?php echo encodeStr($rowfilename['id']);?>" />
	
	<input type="hidden" name="hidact" id="hidact" value="1" />
	<input type="hidden" name="hideremovablefile" id="hideremovablefile" value="<?php echo $rowfilename['fileName'];?>" />
    </div>
<script>
	$('#commonloader').hide();
</script>
<?php
}
else
{

?>
<div class="after-img url">
      <label>URL</label>
      <input type="text" placeholder="Enter URL" name="posturl" id="posturl" maxlength="250">
	  <input type="hidden" name="action" id="action" value="urlgroup" />
	<input type="hidden" name="urlgroupId" id="urlgroupId" value="<?php echo $_REQUEST['urlgroupId'];?>" />
	  </div>
<?php
}
?>