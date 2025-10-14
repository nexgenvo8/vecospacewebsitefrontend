<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session

if($_REQUEST['id']!='' && $_REQUEST['action']!='')
{

if($_REQUEST['action']=='blkuser'){

$dateAdded=time();
$userId = decodeStr($_REQUEST['id']);

 $sql_ins="INSERT INTO "._BLOCKED_CONTACTS_TABLE_." SET contactId= ".$_SESSION["sessUserId"].",userId=".$userId.",dateAdded='".$dateAdded."' ";
mysqli_query($conn,$sql_ins) or die(mysqli_error($conn)); 

}

if($_REQUEST['action']=='unblkuser'){
$userId = decodeStr($_REQUEST['id']);

$sql_ins="DELETE FROM "._BLOCKED_CONTACTS_TABLE_." WHERE contactId= ".$_SESSION["sessUserId"]." and userId=".$userId." ";
mysqli_query($conn,$sql_ins) or die(mysqli_error($conn)); 

}

}

?>
	<ul class="requst-list block">
<?php
		
			$query="SELECT * from "._BLOCKED_CONTACTS_TABLE_." WHERE  contactId=".$_SESSION["sessUserId"]." and userId= ".decodeStr($_GET['id'])." ";
	$sqlQuery=mysqli_query($conn,$query) or die(mysqli_error($conn));	
		$blockStatus=mysqli_num_rows($sqlQuery);
		
		
		$n=0;
		$selectFields =[];
		$whereFields =[];
		$whereVals =[];
		
		$sqlContact="";
		$sqlContact="select * from "._USERS_MASTER_TABLE_." WHERE userId= ".decodeStr($_REQUEST["id"])." ";
		$resContact=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlContact); 	
		if($resContact)
		{
			while($rowContact=mysqli_fetch_array($resContact))
			{

				$friendnameurl=$rowContact['userurl'];
				
				if($rowContact["profilePhoto"]!='')
				{
				$userphoto=$rowContact["profilePhoto"];
				} else {
				$userphoto='user-placeholder.jpg';
				}
				
		  ?> 
              <li>
        <div class="rquest-box">
          <a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($rowContact['userId']);?>/<?php echo $friendnameurl;?>.html" target="_blank" class="rqst-img"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($userphoto));?>"></a>
         <div class="rqst-right">
     <div class="rquest-middle">
    <a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($rowContact['userId']);?>/<?php echo $friendnameurl;?>.html" target="_blank"><?php echo $rowContact['firstName'];?> <?php echo $rowContact['lastName'];?></a>
<span><?php echo $rowContact["companyName"];?></span>
<div class="add-frnd">
<?php if($blockStatus>0){?>
 <a onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl;?>loadcontactblockunblock.php?id=<?php echo encodeStr($rowContact['userId']);?>&action=unblkuser','Report/Block contacts');" style="background-color:#47bd38;">Unblock</a>
           
		   <?php }else{?>
		   <a onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl;?>loadcontactblockunblock.php?id=<?php echo encodeStr($rowContact['userId']);?>&action=blkuser','Report/Block contacts');">Block</a>
         <?php }?>
         </div>
      </div>
        </div>
        </div>
      </li>
              
<?php
	$n++;	}
}
?>

			     </ul>
				 
