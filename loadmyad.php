<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session

$id=$_REQUEST["id"];
if($id>0)
{
$n=0;
?>
 <option value="0">Select</option>

<?php 
if($id==1)
{
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);
		
		$sqlEvents="";
		$sqlEvents="select * from "._EVENT_MASTER_TABLE_." WHERE userId=".$_SESSION["sessUserId"]."  and eventName!='' and eventStatus=1 and id NOT IN (select adId from "._AD_POST_MASTER_TABLE_." where adType=1) order by eventName  ";
		$resEvents=getRecords(_EVENT_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysql_fetch_array($resEvents))
			{
			$n=1;
?>
 <option value="<?php echo trim($rowEvents['id']);?>"><?php echo stripslashes($rowEvents["eventName"]);?></option>
<?php
			}
		}

}
?> 

<?php 
if($id==2)
{
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);
		
		$sqlEvents="";
		$sqlEvents="select * from "._PROJECT_MASTER_TABLE_." where userId=".$_SESSION["sessUserId"]." and id NOT IN (select adId from "._AD_POST_MASTER_TABLE_." where adType=2) order by projectTitle  ";
		$resEvents=getRecords(_PROJECT_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysql_fetch_array($resEvents))
			{
			$n=1;
?>
 <option value="<?php echo trim($rowEvents['id']);?>"><?php echo stripslashes($rowEvents["projectTitle"]);?></option>
<?php
			}
		}

}
?> 

<?php 
if($id==3)
{
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);
		
		$sqlEvents="";
		$sqlEvents="select * from "._BUSINESS_MASTER_TABLE_." where userId=".$_SESSION["sessUserId"]." and id NOT IN (select adId from "._AD_POST_MASTER_TABLE_." where adType=3) order by companyBusinessName  ";
		$resEvents=getRecords(_BUSINESS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysql_fetch_array($resEvents))
			{
			$n=1;
?>
 <option value="<?php echo trim($rowEvents['id']);?>"><?php echo stripslashes($rowEvents["companyBusinessName"]);?></option>
<?php
			}
		}

}
?> 

<?php 
if($id==4)
{
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);
		
		$sqlEvents="";
		$sqlEvents="select * from "._TALENT_MASTER_TABLE_." where status=1 and userId=".$_SESSION["sessUserId"]." and id NOT IN (select adId from "._AD_POST_MASTER_TABLE_." where adType=4) order by talentName  ";
		$resEvents=getRecords(_TALENT_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysql_fetch_array($resEvents))
			{
			$n=1;
?>
 <option value="<?php echo trim($rowEvents['id']);?>"><?php echo stripslashes($rowEvents["talentName"]);?></option>
<?php
			}
		}

}
?> 


<?php 
if($id==5)
{
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);
		
		$sqlEvents="";
		$sqlEvents="select * from "._JOBS_MASTER_TABLE_." where status=1 and jobStatus=1 and userId=".$_SESSION["sessUserId"]." and id NOT IN (select adId from "._AD_POST_MASTER_TABLE_." where adType=5) order by jobTitle  ";
		$resEvents=getRecords(_JOBS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysql_fetch_array($resEvents))
			{
			$n=1;
?>
 <option value="<?php echo trim($rowEvents['id']);?>"><?php echo stripslashes($rowEvents["jobTitle"]);?></option>
<?php
			}
		}

}
?> 

<?php 
if($id==6)
{
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);
		
		$sqlEvents="";
		$sqlEvents="select * from "._SHAREANDUPDATES_TABLE_." where userId=".$_SESSION["sessUserId"]."  and (postType=1 OR postType=2) ORDER BY postTitle  ";
		$resEvents=getRecords(_SHAREANDUPDATES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysql_fetch_array($resEvents))
			{
			$n=1;
?>
 <option value="<?php echo trim($rowEvents['id']);?>"><?php echo getStrLength(strip_tags(stripslashes($rowEvents["postText"])),100); ?><?php //echo stripslashes($rowEvents["postTitle"]);?></option>
<?php
			}
		}

}
?>

<?php 
if($id==7)
{
		unset($selectFields);
		unset($whereFields);
		unset($whereVals);
		
		$sqlEvents="";
		$sqlEvents="SELECT * from "._SHAREANDUPDATES_TABLE_." WHERE postTitle!=''  and postType=3 and userId=".$_SESSION["sessUserId"]." ORDER BY postTitle  ";
		$resEvents=getRecords(_SHAREANDUPDATES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysql_fetch_array($resEvents))
			{
			$n=1;
?>
 <option value="<?php echo trim($rowEvents['id']);?>"><?php echo stripslashes($rowEvents["postTitle"]);?></option>
<?php
			}
		}

}
?>


 
 
<?php

}
?>

<?php if($n==0){?>
<script>
$('#myad').hide();
$('#addcategoryname').text('Post Not Available');
</script>
<?php }else{?>
<script>
$('#myad').show();
</script>
<?php }?>