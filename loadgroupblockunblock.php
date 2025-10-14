<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session
$groupUserId=$_REQUEST['groupUserId'];
if($groupUserId!='' && $_REQUEST['id']!='' && $_REQUEST['status']!='')
{
//echo decodeStr($groupUserId).'==='.decodeStr($_REQUEST['id']);

$sql_="UPDATE "._GROUP_MEMBER_MASTER_TABLE_." SET userStatus=".$_REQUEST['status']." WHERE userId=".decodeStr($groupUserId)." and groupId=".decodeStr($_REQUEST['id'])." ";
$resresult2=mysqli_query($conn, $sql_) or die(mysqli_error($conn)); 

}


?>
	<ul class="requst-list block">
<?php
		$n=0;
		$selectFields =[];
		$whereFields =[];
		$whereVals =[];
		
		$sqlGroupMembers="";
		$sqlGroupMembers="select * from "._GROUP_MEMBER_MASTER_TABLE_." WHERE groupId= ".decodeStr($_REQUEST["id"])." and userId!=".$_SESSION["sessUserId"]." and status=1 order by id desc ";
		$resGroupMembers=getRecords(_GROUP_MEMBER_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlGroupMembers); 	
		if($resGroupMembers)
		{
			while($rowgroup=mysqli_fetch_array($resGroupMembers))
			{
			
				$sql_group="SELECT * from "._GROUP_MASTER_TABLE_." WHERE id= ".$rowgroup["groupId"]."";
				$resgroup=mysqli_query($conn, $sql_group) or die(mysqli_error($conn)); 
				$row=mysqli_fetch_array($resgroup);				
				
				
				
				$friendnameurl='';	
				$userphoto='';
				$a="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= ".$rowgroup["userId"]."";
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
              <li>
        <div class="rquest-box">
          <a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($userres['userId']);?>/<?php echo $friendnameurl;?>.html" target="_blank" class="rqst-img"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($userphoto));?>"></a>
         <div class="rqst-right">
     <div class="rquest-middle">
    <a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($userres['userId']);?>/<?php echo $friendnameurl;?>.html" target="_blank"><?php echo $userres['firstName'];?> <?php echo $userres['lastName'];?></a>
<span><?php echo $userres["companyName"];?></span>
<?php if($_SESSION["sessUserId"]==$row["userId"]){?>
<div class="add-frnd">
<?php if($rowgroup["userStatus"]==0){?>
           <a onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl;?>loadgroupblockunblock.php?id=<?php echo $_REQUEST["id"];?>&groupUserId=<?php echo encodeStr($userres['userId']);?>&status=1','Block/Unblock Users');">Block</a>
		   <?php }else{?>
		    <a onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl;?>loadgroupblockunblock.php?id=<?php echo $_REQUEST["id"];?>&groupUserId=<?php echo encodeStr($userres['userId']);?>&status=0','Block/Unblock Users');" style="background-color:#47bd38;">Unblock</a>
         <?php }?>
         </div>
	<?php }?>	 
      </div>
        </div>
        </div>
      </li>
              
<?php
	$n++;	}
}
else
{
?>
<div style="padding:20px; text-align:center;">No any Blocked/Unblocked User.</div>
<?php
 
}
?>

			     </ul>
				      

 