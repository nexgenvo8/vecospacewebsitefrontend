<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session
$imgId=$_REQUEST['imgId'];
 
?>

 <div class="img-inner-pop">
    <a class="img-clos" onclick="$('#groupimagepopup').hide();"><i class="fa fa-times"></i> </a>
	
	<?php
 	
		$a="";
		$a="select fileName from "._GROUP_FILE_TABLE_." where id=".$imgId."";
		$b=getRecords(_GROUP_FILE_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$a); 	
		if($b)
		{
			$numrows=mysql_num_rows($b); 
			$width='100%';
			
			while($rowimg=mysql_fetch_array($b))
			{
		  ?>
   <img src="<?php echo $fullurl;?>groupuploads/x_<?php echo $rowimg['fileName']; ?>">
	<?php
	
	}
	}
	?>
  </div>