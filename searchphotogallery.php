<?php
include_once('inc.php'); 
$keyword=$_REQUEST['keywordsearch'];
		 
		$selectFields =[];
		$whereFields =[];
		$whereVals=[];	
		$sqlSearch="";	
		
	    $sqlSearch="select id,imageName,postId from "._IMAGE_MASTER_TABLE_." where  postId IN(select id from "._SHAREANDUPDATES_TABLE_." where userId IN(select userId from "._USERS_MASTER_TABLE_."  where (firstName like '%".$keyword."%' OR lastName like '%".$keyword."%') and userId!=".$_SESSION['sessUserId']." ) ) order by id desc ";			
		$resSearch=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlSearch); 
$totalimages=mysqli_num_rows($resSearch);




?>

<?php
if($totalimages==0)
{
?>
<script>
$('#photogrps').hide();
</script>
<?php 
}?>
<script>
$('#commonloader').hide();
</script>

<?php if($totalimages>0){?>

<ul class="upld-img-list searchphoto" style="display:block;" id="TGimageboxouter">
<?php 
	
		while($rowName=mysqli_fetch_array($resSearch))
			{
			  
			  $a="SELECT * from "._SHAREANDUPDATES_TABLE_." WHERE id= '".$rowName["postId"]."'";
				$b=mysqli_query($conn, $a) or die(mysqli_error($conn)); 
				$userrespost=mysqli_fetch_array($b); 
							  
				  $a="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= '".$userrespost["userId"]."'";
					$b=mysqli_query($conn, $a) or die(mysqli_error($conn)); 
					$userres=mysqli_fetch_array($b); 
?>     
        <li class="gall">
			<img title="by <?php echo $userres['firstName']; ?> <?php echo $userres['lastName']; ?>" src="<?php echo $fullurl;?>uploads/<?php echo $rowName['imageName'];?>" style="min-width:100%; cursor:pointer; max-height:100%; min-height:100%;">
					
					<div class="iname">by <?php echo $userres['firstName']; ?> <?php echo $userres['lastName']; ?></div>
				</li>
				   <?php
				}
			
			?>   
      
         
</ul>
<?php }?>
