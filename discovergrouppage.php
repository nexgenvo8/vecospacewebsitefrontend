<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session
$pageIndex=6;
$pagetab=2;
?>

<!DOCTYPE html>
<html>
<head>
<title>My Groups - <?php echo $companNameTitle;?></title>
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
        <div class="groups bx-shadow">
           <?php include('searchgroup.inc.php');?>
          
      
    <div class="trnding-group">
		  <?php
		 
		  $aa="SELECT id from "._GROUP_MASTER_TABLE_." WHERE userId!='".$_SESSION['sessUserId']."' and groupType=0 and status=0 and userGroupStatus=1 ";
				$bb=mysqli_query($conn, $aa) or die(mysqli_error($conn)); 
				
					$mytotalpublicgroups=mysqli_num_rows($bb);
				
		$n=0;
		$selectFields =[];
		$whereFields =[];
		$whereVals =[];
		
		$sqlGroup="";
		$sqlGroup="select * from "._GROUP_MASTER_TABLE_." where userId!='".$_SESSION['sessUserId']."' and groupType=0 and status=0 and userGroupStatus=1 order by dateAdded desc ";
		$resGroup=getRecords(_GROUP_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlGroup); 	
		if($resGroup)
		{
			$mytotalgroups=mysqli_num_rows($resGroup);
		  ?>
		  
		  
		  
		  
            <h2 style="text-align:left;">Public groups (<?php echo $mytotalpublicgroups;?>)</h2>
            <!--<ul class="mmbr-grp-list">-->
			<ul class="curently-trendng-list">
			<?php
		    while($rowgroup=mysqli_fetch_array($resGroup))
			{
			
				$sql_group="SELECT * from "._GROUP_MASTER_TABLE_." WHERE id= ".$rowgroup["id"]."";
				$resgroup=mysqli_query($conn, $sql_group) or die(mysqli_error($conn)); 
				$row=mysqli_fetch_array($resgroup);	
				
				$aby="SELECT userId,firstName,lastName from "._USERS_MASTER_TABLE_." WHERE userId= ".$row["userId"]."";
					$bby=mysqli_query($conn, $aby) or die(mysqli_error($conn)); 
					$madeby=mysqli_fetch_array($bby); 			
				
				if($row["groupThumb"]!='')
				{
				$groupThumb=$row["groupThumb"];
				} else {
				$groupThumb='group.png';
				}
					
			
				if($row["id"]!='')
				{
				$sql_postgroup="SELECT * from "._SHAREANDUPDATES_TABLE_." WHERE shareType!=0  and  groupId= ".$row["id"]." order by id desc";
				$respostgroup=mysqli_query($conn, $sql_postgroup) or die(mysqli_error($conn)); 
				$rowGroupPost=mysqli_fetch_array($respostgroup);
				
				$groupPostTitle=$rowGroupPost["postTitle"];
				}
				$totalgroupmembers=0;
				$sqlGroupTotal="";
				$sqlGroupTotal="select * from "._GROUP_MEMBER_MASTER_TABLE_." where groupId='".$row["id"]."' and status=1 ";
				$resGroupTotal=getRecords(_GROUP_MEMBER_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlGroupTotal); 	
				if($resGroupTotal)
				{
					$totalgroupmembers=mysqli_num_rows($resGroupTotal);
				}
				
				$ag="SELECT id from "._GROUP_MEMBER_MASTER_TABLE_." WHERE groupId= ".$row["id"]." and userId=".$_SESSION['sessUserId']." and status=1 and userStatus=0";
				$bg=mysqli_query($conn, $ag) or die(mysqli_error($conn));
				$mygroupblockuser=mysqli_num_rows($bg);
				
				if($row["userId"]!=''){
					$a="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= ".$row["userId"]."";
					$b=mysqli_query($conn, $a) or die(mysqli_error($conn)); 
					$userres=mysqli_fetch_array($b); 
					
					$friendnameurl=$userres['userurl'];
					
					if($userres["profilePhoto"]!='')
					{
					$userphoto=$userres["profilePhoto"];
					} else {
					$userphoto='user-placeholder.jpg';
					}
				}

	
?>
			
             <!-- <li>
                <div class="list_column">
                  <div class="group-sec"> 
				  <a href="<?php echo $fullurl; if($row["groupType"]==0){?>groups-detail<?php }else{?>private-group<?php }?>.html?groupId=<?php echo encodeStr($rowgroup['id']);?>"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($groupThumb));?>"></a> <span> <a href="<?php echo $fullurl; if($row["groupType"]==0){?>groups-detail<?php }else{?>private-group<?php }?>.html?groupId=<?php echo encodeStr($rowgroup['id']);?>" class="nm"><?php echo stripslashes(trim($row["groupName"]));?></a>
				    <div style="margin-top:2px;"> <label class="grp-desc-info">By <strong><?php if($madeby['userId']==$_SESSION["sessUserId"]){ echo 'Me';}else {?><?php echo $madeby['firstName'];?> <?php echo $madeby['lastName']; }?></strong></label></div>
				  <?php if($row["groupDetails"]!=''){ echo getStrLength(strip_tags(stripslashes($row["groupDetails"])),160); }?><div style="margin-top:2px;"> <label class="grp-desc-info"><?php if($row["groupType"]==0){?>
				  <?php 
	$totalc="";
	$totalc="SELECT * from "._SHAREANDUPDATES_TABLE_." WHERE groupId= ".$rowgroup["id"]." and shareType!=0";
	$retotalc=mysqli_query($conn, $totalc) or die(mysqli_error($conn)); 
	echo $mytotalgroupposts=mysqli_num_rows($retotalc);
	?> posts |  <?php } echo $totalgroupmembers;?> users</label></div></span>
				  
				   </div>
                </div>
				
				<?php if($groupPostTitle!=''){?>
                <div class="list_column">
                  <div class="post-sec"> <a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($userres['userId']);?>/<?php echo $friendnameurl;?>.html"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($userphoto));?>"></a>
                    <div class="right-post"> <a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($userres['userId']);?>/<?php echo $friendnameurl;?>.html" class="nam"><?php echo stripslashes(trim($userres["firstName"]));?> <?php echo stripslashes(trim($userres["lastName"]));?></a> wrote a post <span class="tim"><?php echo makedatetime($rowGroupPost["dateAdded"]); ?></span> <strong>
					<a href="<?php echo $fullurl;?>groups-detail.html?groupId=<?php echo encodeStr($rowgroup['id']);?>"><?php echo stripslashes($groupPostTitle);?></a></strong> <span><?php echo getStrLength(strip_tags(stripslashes($rowGroupPost["postText"])),250); ?></span> </div>
                  </div>
                </div>
						<?php
						}
						
						?>
              </li>-->
			  
			  
			  <li>
            		<div class="currntly-trendingbox">
            			<span class="im"><a href="<?php echo $fullurl; if($row["groupType"]==0){?>groups-detail<?php }else{?>private-group<?php }?>.html?groupId=<?php echo encodeStr($rowgroup['id']);?>"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($groupThumb));?>"></a></span>
            			<h3 class="grpnm"><a href="<?php echo $fullurl; if($row["groupType"]==0){?>groups-detail<?php }else{?>private-group<?php }?>.html?groupId=<?php echo encodeStr($rowgroup['id']);?>"><?php echo stripslashes(trim($row["groupName"]));?></a></h3>
            	
            			<label class="mmbr-count"><?php echo $totalgroupmembers;?> Members in this group</label>
            			<ul class="grupmmbrlist">
						 <?php
		
		$selectFields =[];
		$whereFields =[];
		$whereVals =[];
		
		$sqlGroupMembers="";
		$sqlGroupMembers="select * from "._GROUP_MEMBER_MASTER_TABLE_." WHERE groupId= ".$row["id"]." and status=1 order by rand() desc LIMIT 0,6 ";
		$resGroupMembers=getRecords(_GROUP_MEMBER_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlGroupMembers); 	
		if($resGroupMembers)
		{
			while($rowgroup1=mysqli_fetch_array($resGroupMembers))
			{
			
				
				$friendnameurl='';	
				$userphoto='';
				$a="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= ".$rowgroup1["userId"]."";
				$b=mysqli_query($conn, $a) or die(mysqli_error($conn)); 
				$userres=mysqli_fetch_array($b); 
				
				$friendnameurl=$userres['userurl'];
				
				if($userres["profilePhoto"]!='')
				{
				$userphoto=$userres["profilePhoto"];
				} else {
				$userphoto='user-placeholder.jpg';
				}
				
		  ?>
            				<li><a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($userres['userId']);?>/<?php echo $friendnameurl;?>.html"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($userphoto));?>"></a></li>
							 <?php
		}
}
?>
            			</ul>
            			<div class="grupbuttons">
            			<?php if($mygroupblockuser==0){?><a href="<?php echo $fullurl; if($row["groupType"]==0){?>groups-detail<?php }else{?>private-group<?php }?>.html?groupId=<?php echo encodeStr($rowgroup['id']);?>" class="joingrp-btn" data-hover="Join this group"><i class="fa fa-plus" aria-hidden="true"></i></a><?php }?>
            			<a href="<?php echo $fullurl; if($row["groupType"]==0){?>groups-detail<?php }else{?>private-group<?php }?>.html?groupId=<?php echo encodeStr($rowgroup['id']);?>" class="view-btn"  data-hover="View Details"><i class="fa fa-eye" aria-hidden="true"></i></a></div>
            		</div>
            	</li>
          <?php
	$n++;	
	
	}
?> <?php if($mytotalpublicgroups<1) {?>
<div style="padding:20px; text-align:center; color:#999999;">You have no groups.</div>
<?php }?> 
			</ul>
			<?php
			
			}
?> 
			
          </div>
     
	 


        </div>
      </div>
    </div>
  </div>
  <?php include('footer.php');?>
</div>
<script>
function reloadPage(){
window.location.href = 'my-groups.html';
}

</script>
</body>
</html>
