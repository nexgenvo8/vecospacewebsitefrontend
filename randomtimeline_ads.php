<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session

$postWhere="select * from "._TIMELINE_MASTER_TABLE_." where status=1 and adType=1 and postId IN (select id from "._SHAREANDUPDATES_TABLE_." where adId IN (select id from "._AD_POST_MASTER_TABLE_." where status=1 and viewStatus=1)) order by rand() LIMIT 0,1";


 	
	$sqlLogin="";
	$sqlLogin=$postWhere;
	$resLogin=getRecords(_TIMELINE_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlLogin); 	
	if($resLogin)
	{
		while($row=mysqli_fetch_array($resLogin))
			{
			
				 $aa="SELECT * from "._LIKE_MASTER_TABLE_." WHERE postId= ".$row["postId"]." and postType= ".$row["postType"]."";
				$res5 = mysqli_query($conn,$aa);
				$totalpostlike=mysqli_num_rows($res5); 
				
				$aa="SELECT * from "._COMMENT_MASTER_TABLE_." WHERE postId= ".$row["postId"]." and postType= ".$row["postType"]."";
				$res5 = mysqli_query($conn,$aa);
				$totalpostcomment=mysqli_num_rows($res5);
				 
				$aas="SELECT * from "._SHARE_MASTER_TABLE_." WHERE postId= ".$row["postId"]." and postType= ".$row["postType"]."";
				$res5s = mysqli_query($conn,$aas);
				$totalpostshared=mysqli_num_rows($res5s);
							
			$sql_inss="SELECT * from "._SHAREANDUPDATES_TABLE_." WHERE id= ".$row["postId"]."";
			$resresults=mysqli_query($conn,$sql_inss) or die(mysqli_error($conn)); 
			$rowResults=mysqli_fetch_array($resresults); 
							
	?>
<div class="timlist" id="<?php $views=$rowResults['views']+1; $postid=$rowResults['id']; echo $rowResults['id'];?>" style="margin-bottom:8px;">
  <div class="txtarea">
     <?php echo $rowResults['postText'];?>
  </div>
  
  <div class="timlist-fttr">
  	<table width="100%" cellpadding="0" cellspacing="0" border="0">
  		<tr>
  			<td width="15%">
  				 <div id="post<?php echo $row["postId"]; ?><?php echo $row["postType"]; ?>" onclick="postlike(<?php echo $row["postId"]; ?>,<?php echo $row["postType"]; ?>,<?php  if($totalpostlike!=''){ echo $totalpostlike; } else { echo '0'; } ?>);"><a><i class="fa fa-thumbs-up" aria-hidden="true" style="color: #ff7800;"></i><span>
      <?php  if($totalpostlike!=''){ echo $totalpostlike; } else { echo '0'; } ?>
      </span> Like </a></div>

  			</td>
  			<td width="45%">
  	<ul class="likes-mmbr" id="likesmmbrdiv<?php echo $row["postId"]; ?><?php echo $row['postType']; ?>"></ul>
  		
	<script>
	 $('#likesmmbrdiv<?php echo $row['postId']; ?><?php echo $row['postType']; ?>').load('<?php echo $fullurl;?>loadlikeusers.php?postId=<?php echo $row['postId']; ?>');
	</script>
	
  			</td>
  			<td width="20%" align="right"> <div id="commentdisplaybox<?php echo $row['postId']; ?><?php echo $row['postType']; ?>" class="triggerBtn"><i class="fa fa-commenting" aria-hidden="true" ></i> <span>
      <?php  if($totalpostcomment!=''){ echo $totalpostcomment; } else { echo '0'; } ?>
      </span> Comment </div></td>
  			<td width="20%" align="right">	
  				<div><a onClick="sharefuncommonpopupwin('550px','auto','<?php echo $fullurl;?>common_popup_inner.php?id=<?php echo encodeStr($row['postId']); ?>&type=share&sharePostType=<?php echo $row['postType']; ?>','Share','<?php echo $rowResults['id'];?>');"><i class="fa fa-share" aria-hidden="true"></i> <span><?php  if($totalpostshared!=''){ echo $totalpostshared; } else { echo '0'; } ?></span> Share </a></div></td>
  		</tr>
  	</table>
 

  <ul class="tmln_fttr" style="display: none;">
    <li id="post<?php echo $row["postId"]; ?><?php echo $row["postType"]; ?>" onclick="postlike(<?php echo $row["postId"]; ?>,<?php echo $row["postType"]; ?>,<?php  if($totalpostlike!=''){ echo $totalpostlike; } else { echo '0'; } ?>);"><a><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like <span>
      <?php  if($totalpostlike!=''){ echo $totalpostlike; } else { echo '0'; } ?>
      </span></a></li>
   
    <!--<li><a onclick="opensharebox('<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($row['postId']); ?>','<?php echo stripslashes(trim($rowResults["postTitle"]));?>');"><i class="fa fa-share" aria-hidden="true"></i> Share <span>0</span></a></li>-->

	
	<li class="views"><?php if($rowResults['viewStatus']!=0) {echo $rowResults['viewStatus']; if($rowResults['viewStatus']>1){ echo ' views';}else{ echo ' view';}}?></li>
  </ul>
  <div class="commnts-cont">
  <div class="comnt-write">
      <div class="write-cmnt-pic"> <img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($myprofilePhoto));?>"> </div>
      <div class="cmnt-inpt">
        <form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post" target="actionfrm" action="<?php echo $fullurl;?>common_action.php">
          <input type="text" class="commentrowboxclass" id="commentbox" name="commentbox" placeholder="Type your comment" maxlength="250">
          <input name="postId" id="postId"  type="hidden" value="<?php echo encodeStr($row['postId']); ?>">
          <input name="limit" id="limit"  type="hidden" value="5">
          <input name="action" id="action"  type="hidden" value="postcomment">
          <input name="parentId" id="parentId"  type="hidden" value="0">
          <input name="postType" id="postType"  type="hidden" value="<?php echo $row['postType']; ?>">
          <input name="pageType" id="pageType"  type="hidden" value="timeline">
          <input name="userId" id="userId"  type="hidden" value="<?php echo encodeStr($userres['userId']);?>">
          <button type="submit"><i class="fa fa-paper-plane" aria-hidden="true"></i></button>
        </form>
      </div>
    </div>
    <ul class="cmmnt-list"  id="postcomment<?php echo $row['postId']; ?><?php echo $row['postType']; ?>">
      Loading...
    </ul>
	<script>$(".timlist .timlist #postcomment<?php echo $row['postId']; ?><?php echo $row['postType']; ?>").remove();</script>
    
    
  </div>
  </div>
  
  <script>
		  $('#postcomment<?php echo $row['postId']; ?><?php echo $row['postType']; ?>').load('post-comment.php?postId=<?php echo $row['postId']; ?>&postType=<?php echo $row['postType']; ?>&parentId=0&limit=5');
		  </script>
</div>
<?php
		
	}


}

 $sql_ins="update "._SHAREANDUPDATES_TABLE_." set views=".$views." WHERE id= ".$postid." ";
	mysqli_query($conn,$sql_ins) or die(mysqli_error($conn));

?>




