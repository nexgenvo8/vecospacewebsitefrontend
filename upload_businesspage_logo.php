<?php
include_once('inc.php'); 

$sql_ins="select id from "._IMAGE_MASTER_TABLE_." where  postId= '".$_REQUEST["bpId"]."' and imageType=9";
$resresult2=mysqli_query($conn, $sql_ins) or die(mysqli_error($conn)); 
$totalimages=mysqli_num_rows($resresult2);

	$sqlCompany="select companyBusinessName from "._BUSINESS_MASTER_TABLE_." where id= ".$_REQUEST["bpId"]."";
	$resCompany=mysqli_query($conn, $sqlCompany) or die(mysqli_error($conn)); 	
	$rowCount=mysqli_num_rows($resCompany);			

	$rowCompany=mysqli_fetch_array($resCompany);

	$companyBusinessNamePhoto=stripslashes($rowCompany['companyBusinessName']);

?>

<?php
if($totalimages==0 && $_REQUEST["uid"]!=$_SESSION["sessUserId"])
{
?>
<script>
$('#photogrps').hide();
</script>
<?php
}
?>
<script>
$('#commonloader').hide();
</script>
<form class="edit-layer" enctype="multipart/form-data" name="frmbusinesspage" id="frmbusinesspage" method="post" target="actionfrm" action="<?php echo $fullurl;?>common_action.php">   
<?php if($totalimages>0)
{?>
<ul class="upld-img-list" style="display:block;" id="TGimageboxouter">
       <?php 
		 
$a="select id,imageName from "._IMAGE_MASTER_TABLE_." where  postId= '".$_REQUEST["bpId"]."' and imageType=9 order by id ";
$imgrows=mysqli_query($conn, $a) or die(mysqli_error($conn)); 
 while($rowName=mysqli_fetch_array($imgrows))
 {

	?>     
        <li><img title="<?php echo $companyBusinessNamePhoto;?>" src="<?php echo $fullurl;?>uploads/<?php echo $rowName['imageName'];?>"><?php if($_REQUEST["uid"]==$_SESSION["sessUserId"]){ if($_SESSION["sessUserId"]!='' && $_SESSION["sessUserId"]!=0){?><span class="close"><a title="Remove" href="<?php echo $fullurl;?>common_action.php?delesmbimgId=<?php echo encodeStr($rowName['id']);?>&bpId=<?php echo encodeStr($_REQUEST["bpId"]);?>&oldevntimg=<?php echo trim($rowName['imageName']);?>&action=delsmbpics&smbuid=<?php echo $_REQUEST["uid"];?>" target="actionfrm"><?php }?><i class="fa fa-times" aria-hidden="true"></i></a></span></li>
   <?php
		}	
	  
  }
?>   
      
           <?php if($_REQUEST["uid"]==$_SESSION["sessUserId"]){ ?> <li style="position:relative;"><i class="fa fa-plus" aria-hidden="true"></i> <input name="businesslogoimage" id="businesslogoimage" type="file" onChange="$('#commonloader').show();$('#frmbusinesspage').submit();" style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); " accept="image/x-png,image/gif,image/jpeg"></li><?php }?>
         <input type="hidden" id="action" name="action" value="uploadsmbpics">
      </ul>
<?php
}
else
{
?>
<?php if($_REQUEST["uid"]==$_SESSION["sessUserId"]){ ?>
<span class="up-btn" style="position:relative;"><i class="fa fa-cloud-upload" aria-hidden="true"><span>Upload an image</span></i><input name="businesslogoimage" id="businesslogoimage" type="file" onChange="$('#commonloader').show();$('#frmbusinesspage').submit();" style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); " accept="image/x-png,image/gif,image/jpeg"></span>
<input type="hidden" id="action" name="action" value="uploadsmbpics">
<?php }}?>
	 <input type="hidden" id="bpId" name="bpId" value="<?php echo $_REQUEST["bpId"];?>">
	 <input type="hidden" id="smbuid" name="smbuid" value="<?php echo $_REQUEST["uid"];?>">

</form>