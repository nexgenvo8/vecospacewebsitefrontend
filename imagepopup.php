<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session
$imgId=$_REQUEST['imgId'];
 
?>

 <div class="img-inner-pop">
    <a class="img-clos" onclick="$('#imagepopup').hide();"><i class="fa fa-times"></i> </a>
	
	<?php
	if(is_numeric($imgId))
	{
 	$selectFields = [];
    $whereFields = [];
    $whereVals = [];
		$a="";
		$a="select imageName from "._IMAGE_MASTER_TABLE_." where id=".$imgId."";
		$b=getRecords(_IMAGE_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$a); 	
		if($b)
		{
			$numrows=mysqli_num_rows($b); 
			$width='100%';
			
			while($rowimg=mysqli_fetch_array($b))
			{
		  ?>
   <img src="<?php echo $fullurl;?>uploads/<?php echo $rowimg['imageName']; ?>">
	<?php
	
	}
	}
	}
	else
	{
	?>
	<img src="<?php echo $fullurl;?>uploads/<?php echo $imgId; ?>">
	<?php
	}
	?>
  </div>