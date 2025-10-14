<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session
$pageIndex=1;

?>
<!DOCTYPE html>
<html>
<head>
<title>Post -  <?php echo $companNameTitle;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/style.css">
<link rel="icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<script src="<?php echo $fullurl;?>js/jquery.min.js"></script>
<script src="<?php echo $fullurl;?>js/main.js"></script>
</head>
<body>
<div id="wrapper" class="active">
  <?php include('header.php');?>
  <div class="container main">
    <div class="premium_tag"><a href="#">Go Premium</a>
      <p id="typewriter"></p>
    </div>
    <div class="home_container">
      <?php include('left-sidebar.php');?>
      <div class="center_content">
        <div class="cntr_cntnt">
          <div class="cntr_cntnt_tab">			
            <div class="timeline_cont">
             <?php  $n=0;
	$selectFields =[];
	$whereFields =[];
	$whereVals =[];
	
	$sqlLogin="";
	$sqlLogin="select * from "._SHAREANDUPDATES_TABLE_." where id='".decodeStr($_REQUEST['postId'])."' ";
	$resLogin=getRecords(_SHAREANDUPDATES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlLogin); 	
	if($resLogin)
	{
		while($row=mysqli_fetch_array($resLogin))
			{



 $aa="SELECT * from "._LIKE_MASTER_TABLE_." WHERE postId= ".$row["id"]." and postType= ".$row["postType"]."";
$res5 = mysqli_query($conn, $aa);
$totalpostlike=mysqli_num_rows($res5); 

 $aa1="SELECT * from "._COMMENT_MASTER_TABLE_." WHERE postId= ".$row["id"]." and postType= ".$row["postType"]."";
$res51 = mysqli_query($conn,$aa1);
$totalpostcomment=mysqli_num_rows($res51);


$a="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= ".$row["userId"]."";
$b=mysqli_query($conn,$a) or die(mysqli_error($conn)); 
$userres=mysqli_fetch_array($b); 


$jobTitle=$userres["jobTitle"];
$companyName=$userres["companyName"];

$friendnameurl=$userres['userurl'];

if($userres["profilePhoto"]!='')
{
$userphoto=$userres["profilePhoto"];
} else {
$userphoto='user-placeholder.jpg';
}		




	
?>




<div class="timlist" id="post<?php echo $row['id'];?>">
                <div class="hedr">
                  <div class="prfl_img"> <a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($userres['userId']);?>/<?php echo $friendnameurl;?>.html"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($userphoto));?>"></a> </div>
                  <div class="hdr_right"><a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($userres['userId']);?>/<?php echo $friendnameurl;?>.html"><?php echo stripslashes(trim($userres["firstName"]));?> <?php echo stripslashes(trim($userres["lastName"]));?></a>
				  
				  <label class="time"><?php echo $jobTitle;?> <?php if($companyName!=''){echo '- '.$companyName;}?></label>
                    <label class="time"><?php echo makedatetime($row["dateAdded"]); ?></label>
                  </div>
				  
                </div>
                <div class="txtarea" style="max-height: 100%;"> 
				<div style=" margin-bottom:10px;">
				
				
				<div style="font-size:15px; font-weight:bold; margin-bottom:5px;"><a style="cursor:default; text-decoration:none;"><?php echo stripslashes(trim($row["postTitle"]));?></a></div>
				<div class="timelinelistingcontant"><?php echo stripslashes(nl2br($row["postText"])); ?></div>
		
				</div>
				
				
		<?php
 	
		$a="";
		$a="select * from "._IMAGE_MASTER_TABLE_." where postId=".$row['id']." and imageType=4";
		$b=getRecords(_IMAGE_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$a); 	
		if($b)
		{
			$numrows=mysqli_num_rows($b); 
			$width='100%';
			
			while($rowimg=mysqli_fetch_array($b))
			{
		  ?>
		  
		  <img src="<?php echo $fullurl;?>uploads/<?php echo $rowimg['imageName']; ?>" style="position:inline-block; cursor:pointer;" onClick="imagepopupmain('<?php echo $rowimg['id']; ?>');">
		  
		  
		  
		  <?php } }
	
		  
		   ?>
				
				
                  <div class="timeline-img">  </div>
                </div>
                <ul class="tmln_fttr">
                  <li id="post<?php echo $row["id"]; ?><?php echo $row["postType"]; ?>" onClick="postlike(<?php echo $row["id"]; ?>,<?php echo $row["postType"]; ?>,<?php  if($totalpostlike!=''){ echo $totalpostlike; } else { echo '0'; } ?>);"><a><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like <span><?php  if($totalpostlike!=''){ echo $totalpostlike; } else { echo '0'; } ?></span></a></li>
                 <li id="commentdisplaybox<?php echo $row['id']; ?><?php echo $row['postType']; ?>"><a><i class="fa fa-commenting" aria-hidden="true" ></i> Comment <span><?php  if($totalpostcomment!=''){ echo $totalpostcomment; } else { echo '0'; } ?></span></a></li>
                 <!-- <li><a><i class="fa fa-share" aria-hidden="true"></i> Share <span>0</span></a></li>-->
                </ul>
				<!---------------Comments----------Start--------------->
				 <div class="commnts-cont">
          <ul class="cmmnt-list grp-dtail-cmmnts"  id="postcomment<?php echo $row['id']; ?><?php echo $row['postType']; ?>">
		  Locading...

          </ul>
		  
		  <script>
		  $('#postcomment<?php echo $row['id']; ?><?php echo $row['postType']; ?>').load('post-comment.php?postId=<?php echo $row['id']; ?>&postType=<?php echo $row['postType']; ?>&parentId=0&limit=5000');
		  </script>
		  
          <div class="comnt-write">
            <div class="write-cmnt-pic">
              <img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($myprofilePhoto));?>">
            </div>
           <div class="cmnt-inpt"> 
		    <form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post" target="actionfrm" action="<?php echo $fullurl;?>common_action.php">   
		   <input type="text" class="commentrowboxclass" style="height:35px;" id="commentbox" name="commentbox" placeholder="Type your comment">
		   
		   
		    <input name="postId" id="postId"  type="hidden" value="<?php echo encodeStr($row['id']); ?>">
		    <input name="limit" id="limit"  type="hidden" value="5000">
		   <input name="action" id="action"  type="hidden" value="postcomment">
		   <input name="parentId" id="parentId"  type="hidden" value="0">
		   <input name="postType" id="postType"  type="hidden" value="<?php echo $row['postType']; ?>">
		   <input name="pageType" id="pageType"  type="hidden" value="grouptimeline">
		   <input name="userId" id="userId"  type="hidden" value="<?php echo encodeStr($userres['userId']);?>">
		   <button type="submit">Post</button>
		   
		   </form>
		   </div>
          </div>
        </div>
		<!---------------Comments----------Ends--------------->
		
		
              </div>
			  
<?php
	$n++;	}
}
?>
              
            </div>
          </div>
        </div>
        <?php include('right-sidebar.php');?>
      </div>
    </div>
  </div>
  <?php include('footer.php');?>
</div>

</body>
</html>
