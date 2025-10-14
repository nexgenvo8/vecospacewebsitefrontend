<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session
$id=$_REQUEST["adcategory"];
$myad=$_REQUEST["myad"];
?>
<?php
if($id==0 || $myad==0)
{
?>
 <div class="preview-ad2">No Preview Available</div>
<?php
}
?>

<?php
if($id!=0 && $myad!=0)
{
$postTitle='';
$postType=$id;
?>
<?php 
if($id==1)
{
		$selectFields=[];
		$whereFields =[];
		$whereVals =[];
		
		$sqlEvents="";
		$sqlEvents="select * from "._EVENT_MASTER_TABLE_." WHERE eventStatus=1 and userId=".$_SESSION["sessUserId"]."  and id='".$myad."'  ";
		$resEvents=getRecords(_EVENT_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysqli_fetch_array($resEvents))
			{
			$n=1;
			
			$eventphoto=$rowEvents["eventBanner"];
			if($eventphoto!=''){
			$eventphoto=$rowEvents["eventBanner"];
			} else {
			$eventphoto=$rowEvents["eventThumb"];
			}
			
			 if($_REQUEST["addlinkurl"]!='' && $_REQUEST["addbutton"]==2)
			 {
			  $learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=1&url=http://www.'.str_replace("http://","",str_replace("https://","",str_replace("www.","",$_REQUEST["addlinkurl"])));
			 }
			 else
			 {
				$learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=1&url='.$fullurl.'events-detail.html?eventId='.encodeStr($rowEvents['id']);
			 }

$postTitle=stripslashes($rowEvents["eventName"]);
?>
<div class="preview-ad" id="previewadbox">
<?php if($eventphoto!=''){?>
<div id="preview-ad-bnnr">
  <a href="<?php echo $learnurl;?>" target="_blank"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($eventphoto));?>"></a>

</div>
<?php }?>
<div style="margin-bottom:0px; margin-top:10px; font-size:18px; font-weight:bold;"><a href="<?php echo $learnurl;?>" target="_blank"><?php echo stripslashes($rowEvents["eventName"]);?></a></div>
<div class="add-content">
<div class="fetrd-left">
          <div class="evnt-timing">
            <i class="fa fa-clock-o" aria-hidden="true"></i>
            <div class="tim"><label>Starts: </label><?php $strstrtdate=strtotime($rowEvents["eventDate"]); echo date("D, j M Y",$strstrtdate); ?>, <?php echo $rowEvents["starttime"];?></div>
            <div class="tim"><label>Ends: </label><?php $strenddate=strtotime($rowEvents["eventTillDate"]); echo date("D, j M Y",$strenddate); ?>, <?php echo $rowEvents["endtime"];?></div>
			<?php if($rowEvents["eventType"]!=''){?><div class="tim"><label>Event Type: </label><?php echo $rowEvents["eventType"];?></div><?php }?>
          </div>
          
          </div>
		  
<div class="fetrd-right going">
<div class="evnt-timing">
<i class="fa fa-map-marker" aria-hidden="true"></i>
<div class="tim"><?php echo stripslashes($rowEvents["eventVenue"]);?><br>
<?php echo stripslashes($rowEvents["eventCountryAddress"]);?></div>
</div>

</div>

<?php if($_REQUEST["addbutton"]==2){?>
<div id="addbutton"><a href="<?php echo $learnurl;?>" target="_blank"><input type="button" value="Learn More" class="btn" /></a></div>
<?php }?>		  
</div>
</div>
<?php
			}
		}

}
?> 

<?php 
if($id==2)
{
		$selectFields=[];
		$whereFields =[];
		$whereVals =[];
		
		$sqlEvents="";
		$sqlEvents="select * from "._PROJECT_MASTER_TABLE_." where userId=".$_SESSION["sessUserId"]."  and id='".$myad."'  ";
		$resEvents=getRecords(_PROJECT_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysqli_fetch_array($resEvents))
			{
			$n=1;
			 if($_REQUEST["addlinkurl"]!='' && $_REQUEST["addbutton"]==2)
			 {
			  $learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=2&url=http://www.'.str_replace("http://","",str_replace("https://","",str_replace("www.","",$_REQUEST["addlinkurl"])));
			 }
			 else
			 {
				$learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=2&url='.$fullurl.'preview-project.html?projId='.encodeStr($rowEvents['id']);
			 }
			 $postTitle=stripslashes($rowEvents["projectTitle"]);
?>
<div class="preview-ad" id="previewadbox">

<div style="margin-bottom:0px; margin-top:10px; font-size:18px; font-weight:bold;"><a href="<?php echo $learnurl;?>" target="_blank"><?php echo stripslashes($rowEvents["projectTitle"]);?></a></div>

<div style="margin-bottom:0px; margin-top:5px; font-size:14px;"><?php
		
			$sqlOptionspost="";
			$sqlOptionspost="SELECT optionName FROM "._OPTION_MASTER_TABLE_." WHERE optionType='projectindustries' and id='".$rowEvents["protIndusCategory"]."' ";
			$resOptionspost=getRecords(_OPTION_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlOptionspost); 	
			 $totalpost=mysqli_num_rows($resOptionspost);
			if($totalpost)
			{
				while($rowOptionspost=mysqli_fetch_array($resOptionspost))
				{
					  echo trim($rowOptionspost['optionName']); 
				}
			}
		  ?></div><?php if($rowEvents["proEstimatedBudget"]!=''){?>		  
<div style="margin-bottom:0px; margin-top:5px; font-size:14px;"><strong>Estimated Budget</strong>: <?php echo $rowEvents["proCurrency"].' '.$rowEvents["proEstimatedBudget"];?></div>
<?php }?>
		  
	<div style="margin-bottom:0px; margin-top:15px; font-size:22px;"><table width="100%" border="0" cellspacing="0" cellpadding="5" style="font-size:22px;">
  <tr>
    <td width="33%" align="center" bgcolor="#F9F9F9"><?php 
		 $proDuration=stripslashes($rowEvents['proDuration']);
		 if($proDuration=='1 day'){  $first='1'; $last='day'; }
		 if($proDuration=='2 days'){  $first='2'; $last='days'; }
		 if($proDuration=='3 days'){  $first='3'; $last='days'; }
		 if($proDuration=='7 days(1 week)'){  $first='1'; $last='week'; }
		 if($proDuration=='14 days(2 weeks)'){  $first='2'; $last='weeks'; }
		 if($proDuration=='21 days(3 weeks)'){  $first='3'; $last='weeks'; }
		 if($proDuration=='28 days(1 month)'){  $first='1'; $last='month'; }
		 if($proDuration=='60 days(2 months)'){  $first='2'; $last='months'; }
		 if($proDuration=='90 days(3 months)'){  $first='3'; $last='months'; }
?>
<div style="margin-bottom:0px; margin-top:5px; font-size:14px; padding:30px;"><strong>Duration</strong>: <?php echo $first;?> <?php echo $last; ?></div></td>
    <td width="33%" align="center" bgcolor="#F9F9F9">
<div style="margin-bottom:0px; margin-top:5px; font-size:14px;"><strong>Start</strong>: <?php echo date("d/m/Y",strtotime(trim($rowEvents['proStartDate']))); ?></div>
</td>
    <td width="33%" align="center" bgcolor="#F9F9F9"><div style="margin-bottom:0px; margin-top:5px; font-size:14px;"><strong>Hours</strong>: <?php echo stripslashes($rowEvents['proNature']); ?></div></td>
  </tr>
</table>
</div>	  
		  
 	  <div style="margin-bottom:0px; margin-top:15px; font-size:14px;"><?php echo getStrLength(strip_tags(stripslashes($rowEvents["projectDetails"])),210); ?></div>
<?php if($_REQUEST["addbutton"]==2){?>
<div id="addbutton"><a href="<?php echo $learnurl;?>" target="_blank"><input type="button" value="Learn More" class="btn" /></a></div>
<?php }?>

</div>
<?php
			
			}
		}

}
?> 

<?php 
if($id==3)
{
		$selectFields=[];
		$whereFields =[];
		$whereVals =[];
		
		$sqlEvents="";
		$sqlEvents="select * from "._BUSINESS_MASTER_TABLE_." where userId=".$_SESSION["sessUserId"]." and id='".$myad."'  ";
		$resEvents=getRecords(_BUSINESS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysqli_fetch_array($resEvents))
			{
			$n=1;
			
			if($rowEvents["fileUploaded"]!='')
			{
				$companyPhoto=$rowEvents["fileUploaded"];
			} else {
				$companyPhoto='businessimg.png';
			}
			
			 if($_REQUEST["addlinkurl"]!='' && $_REQUEST["addbutton"]==2)
			 {
			 $learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=3&url=http://www.'.str_replace("http://","",str_replace("https://","",str_replace("www.","",$_REQUEST["addlinkurl"])));
			 }
			 else
			 {
				$learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=3&url='.$fullurl._SMBURL_TEXT_.'/'.encodeStr($rowEvents['id']).'/'.makeContentUrl($rowEvents['companyBusinessName']);
			 }
			 $postTitle=stripslashes($rowEvents["companyBusinessName"]);
?>
<div class="preview-ad" id="previewadbox">
<?php if($companyPhoto!=''){?>
<div id="preview-ad-bnnr">
  <a href="<?php echo $learnurl;?>" target="_blank"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($companyPhoto));?>"></a>

</div>
<?php }?>
<div style="margin-bottom:0px; margin-top:10px; font-size:18px; font-weight:bold;"><a href="<?php echo $learnurl;?>" target="_blank"><?php echo stripslashes($rowEvents["companyBusinessName"]);?></a></div>

<div style="margin-bottom:0px; margin-top:10px; font-size:14px;"><?php echo stripslashes($rowEvents["shortDescription"]);?></div>

<div style="margin-bottom:0px; margin-top:5px; font-size:14px;"><strong>Contact Person:</strong> <?php echo stripslashes($rowEvents["contactPerson"]);?></div>
<?php if(stripslashes($rowEvents["phoneNumber"])!=''){?>
<div style="margin-bottom:0px; margin-top:5px; font-size:14px;"><strong>Mobile:</strong> <?php echo stripslashes($rowEvents["phoneNumber"]);?></div>
<?php }?>
<?php if(stripslashes($rowEvents["emailAaddress"])!=''){?>
<div style="margin-bottom:0px; margin-top:5px; font-size:14px;"><strong>Email:</strong> <?php echo stripslashes($rowEvents["emailAaddress"]);?></div>
<?php }?>
<?php if(stripslashes($rowEvents["completeAddress"])!=''){?>
<div style="margin-bottom:0px; margin-top:5px; font-size:14px;"><strong>Address:</strong> <?php echo $rowEvents["completeAddress"];?></div>
<?php }?>
<?php if(stripslashes($rowEvents["businessWebsiteUrl"])!=''){?>
<div style="margin-bottom:0px; margin-top:5px; font-size:14px;"><strong>Website:</strong> <a href="http://<?php echo str_replace("http://","",str_replace("https://","",str_replace("www.","",$rowEvents["businessWebsiteUrl"])));?>" target="_blank">http://www.<?php echo str_replace("http://","",str_replace("https://","",str_replace("www.","",$rowEvents["businessWebsiteUrl"])));?></a></div>
<?php }?>

<div style="margin-bottom:0px; margin-top:10px; font-size:14px;"><?php echo getStrLength(strip_tags(stripslashes($rowEvents["longDescription"])),210); ?></div>
<?php if($_REQUEST["addbutton"]==2){?>
<div id="addbutton"><a href="<?php echo $learnurl;?>" target="_blank"><input type="button" value="Learn More" class="btn" /></a></div>
<?php }?>

</div>
<?php
			}
		}

}
?> 

<?php 
if($id==4)
{
		$selectFields=[];
		$whereFields =[];
		$whereVals =[];
		
		$sqlEvents="";
		$sqlEvents="select * from "._TALENT_MASTER_TABLE_." where status=1 and userId=".$_SESSION["sessUserId"]." and id='".$myad."'  ";
		$resEvents=getRecords(_TALENT_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysqli_fetch_array($resEvents))
			{
			$n=1;
			
				$talentProfilePhoto='';							
				if($rowEvents["talentProfilePhoto"]!='')
				{
					$talentProfilePhoto=$rowEvents["talentProfilePhoto"];
				} else {
					$talentProfilePhoto='talentimgthumb.png';
				}
				
			 if($_REQUEST["addlinkurl"]!='' && $_REQUEST["addbutton"]==2)
			 {
			  $learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=4&url=http://www.'.str_replace("http://","",str_replace("https://","",str_replace("www.","",$_REQUEST["addlinkurl"])));
			 }
			 else
			 {
				$learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=4&url='.$fullurl.'talent-profile-detail.html?id='.encodeStr($rowEvents['id']);
			 }
			 $postTitle=stripslashes($rowEvents["talentName"]);
?>
 <div class="preview-ad" id="previewadbox">
<?php if($talentProfilePhoto!=''){?>
<div id="preview-ad-bnnr">
  <a href="<?php echo $learnurl;?>" target="_blank"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($talentProfilePhoto));?>"></a>

</div>
<?php }?>
<div style="margin-bottom:0px; margin-top:10px; font-size:18px; font-weight:bold;"><a href="<?php echo $learnurl;?>" target="_blank"><?php echo stripslashes($rowEvents["talentName"]);?></a></div>

<div style="margin-bottom:0px; margin-top:5px; font-size:14px;">
								<?php $selectFields =[];
								$whereFields =[];
								$whereVals =[];
								$in=0;
								$sqlOptions="";
								$sqlOptions="SELECT id,optionName FROM "._OPTION_MASTER_TABLE_." WHERE optionType='talent' and id IN (".$rowEvents['catIds'].") ";
								$resOptions=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlOptions); 	
								if($resOptions)
								{
									$totrowOptions=mysqli_num_rows($resOptions);
									while($rowOptions=mysqli_fetch_array($resOptions))
									{
									 $in++;
									
									 if($in==$totrowOptions){$coma='';}else{ $coma=', ';}
									 echo $rowOptions['optionName'].$coma;
									}
								}?></div>

<div style="margin-bottom:0px; margin-top:10px; font-size:14px;"><?php echo stripslashes($rowEvents["shortDescription"]);?></div>


<?php if($_REQUEST["addbutton"]==2){?>
<div id="addbutton"><a href="<?php echo $learnurl;?>" target="_blank"><input type="button" value="Learn More" class="btn" /></a></div>
<?php }?>

</div>
<?php
			}
		}

}
?> 


<?php 
if($id==5)
{
		$selectFields =[];
		$whereFields =[];
		$whereVals =[];
		
		$sqlEvents="";
		$sqlEvents="select * from "._JOBS_MASTER_TABLE_." where userId=".$_SESSION["sessUserId"]." and id='".$myad."'    ";
		$resEvents=getRecords(_JOBS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysqli_fetch_array($resEvents))
			{
			$n=1;
				$selectFields=[];
		$whereFields =[];
		$whereVals =[];
			
				$sqlOptions1="";
				$sqlOptions1="SELECT id,optionName FROM "._OPTION_MASTER_TABLE_." WHERE  id=".$rowEvents["levelId"]." ";
				$resOptions1=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlOptions1); 	
				if($resOptions1)
				{
					while($rowOptions1=mysqli_fetch_array($resOptions1))
					{
						
			     $jobLevelname=trim($rowOptions1['optionName']); 
			  		}
			    }
				
				$selectFields=[];
		$whereFields =[];
		$whereVals =[];
			
				$sqlOptions1="";
				$sqlOptions1="SELECT id,optionName FROM "._OPTION_MASTER_TABLE_." WHERE  id=".$rowEvents["jobCatId"]." ";
				$resOptions1=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlOptions1); 	
				if($resOptions1)
				{
					while($rowOptions1=mysqli_fetch_array($resOptions1))
					{
						
			    $jobCategoryname=trim($rowOptions1['optionName']); 
			  		}
			    }
				
			  if($_REQUEST["addlinkurl"]!='' && $_REQUEST["addbutton"]==2)
			 {
			  $learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=5&url=http://www.'.str_replace("http://","",str_replace("https://","",str_replace("www.","",$_REQUEST["addlinkurl"])));
			 }
			 else
			 {
				$learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=5&url='.$fullurl.'view-job.html?id='.encodeStr($rowEvents['id']);
			 }
			 $postTitle=stripslashes($rowEvents["jobTitle"]);
?>
<div class="preview-ad" id="previewadbox">

<div style="margin-bottom:0px; margin-top:10px; font-size:18px; font-weight:bold;"><a href="<?php echo $learnurl;?>" target="_blank"><?php echo stripslashes($rowEvents["jobTitle"]);?></a></div>

<div style="margin-bottom:0px; margin-top:5px; font-size:14px;"><strong>Category:</strong> <?php echo $jobCategoryname;?></div>
<div style="margin-bottom:0px; margin-top:5px; font-size:14px;"><strong>Career Level:</strong> <?php echo $jobLevelname;?></div>
<div style="margin-bottom:0px; margin-top:5px; font-size:14px;"><strong>Salary:</strong> <?php echo number_format($rowEvents["minAnnualSalary"], 2);?> - <?php echo number_format($rowEvents["maxAnnualSalary"], 2);?></div>

 	  <div style="margin-bottom:0px; margin-top:15px; font-size:14px;"><?php echo getStrLength(strip_tags(stripslashes($rowEvents["jobDetails"])),210); ?></div>
<?php if($_REQUEST["addbutton"]==2){?>
<div id="addbutton"><a href="<?php echo $learnurl;?>" target="_blank"><input type="button" value="Learn More" class="btn" /></a></div>
<?php }?>

</div>
<?php
			}
		}

}
?> 

<?php 
if($id==6)
{
		$selectFields=[];
		$whereFields =[];
		$whereVals =[];
		
		$sqlEvents="";
		$sqlEvents="select * from "._SHAREANDUPDATES_TABLE_." where userId=".$_SESSION["sessUserId"]."  and (postType=1 OR postType=2) and id='".$myad."'    ";
		$resEvents=getRecords(_SHAREANDUPDATES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysqli_fetch_array($resEvents))
			{
			$n=1;
				
			  if($_REQUEST["addlinkurl"]!='' && $_REQUEST["addbutton"]==2)
			 {
			  $learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=7&url=http://www.'.str_replace("http://","",str_replace("https://","",str_replace("www.","",$_REQUEST["addlinkurl"])));
			 }
			 else
			 {
				$learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=7&url='.$fullurl.'view-article.html?postId='.encodeStr($rowEvents['id']);
			 }
			 $postTitle=stripslashes($rowEvents["postTitle"]);
?>
<div class="preview-ad" id="previewadbox">

<div style="margin-bottom:0px; margin-top:10px; font-size:18px; font-weight:bold;"><a href="<?php echo $learnurl;?>" target="_blank"><?php echo stripslashes($rowEvents["postTitle"]);?></a></div>

 	  <div style="margin-bottom:0px; margin-top:15px; font-size:14px;"><?php echo stripslashes(nl2br($rowEvents["postText"]));?><?php //echo getStrLength(strip_tags(stripslashes(nl2br($rowEvents["postText"]))),210); ?></div>
<?php if($_REQUEST["addbutton"]==2){?>
<div id="addbutton"><a href="<?php echo $learnurl;?>" target="_blank"><input type="button" value="Learn More" class="btn" /></a></div>
<?php }?>

</div>
<?php
			}
		}

}
?>

<?php 
if($id==7)
{
	$selectFields=[];
		$whereFields =[];
		$whereVals =[];
		
		$sqlEvents="";
		$sqlEvents="select * from "._SHAREANDUPDATES_TABLE_." where postTitle!=''  and postType=3 and userId=".$_SESSION["sessUserId"]." and id='".$myad."'    ";
		$resEvents=getRecords(_SHAREANDUPDATES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysqli_fetch_array($resEvents))
			{
			$n=1;
				
			$aimg="";						
			$aimg="select * from "._IMAGE_MASTER_TABLE_." where postId=".$rowEvents['id']." and imageType=3";
			$bimg=mysqli_query($conn, $aimg) or die(mysqli_error($conn)); 
			$rowimg=mysqli_fetch_array($bimg); 
			
			if($rowimg['imageName']!='')
			{
				$articlephoto=$rowimg['imageName'];
			} else {
				//$articlephoto='articleicon.png';
			}
				
			  if($_REQUEST["addlinkurl"]!='' && $_REQUEST["addbutton"]==2)
			 {
			  $learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=7&url=http://www.'.str_replace("http://","",str_replace("https://","",str_replace("www.","",$_REQUEST["addlinkurl"])));
			 }
			 else
			 {
				$learnurl=$fullurl.'redirecturl.html?id='.$rowEvents["id"].'&type=7&url='.$fullurl.'view-article.html?postId='.encodeStr($rowEvents['id']);
			 }
			 $postTitle=stripslashes($rowEvents["postTitle"]);
?>
<div class="preview-ad" id="previewadbox">
<?php if($articlephoto!=''){?>
<div id="preview-ad-bnnr">
  <a href="<?php echo $learnurl;?>" target="_blank"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($articlephoto));?>"></a>

</div>
<?php }?>
<div style="margin-bottom:0px; margin-top:10px; font-size:18px; font-weight:bold;"><a href="<?php echo $learnurl;?>" target="_blank"><?php echo stripslashes($rowEvents["postTitle"]);?></a></div>

 	  <div style="margin-bottom:0px; margin-top:15px; font-size:14px;"><?php echo getStrLength(strip_tags(stripslashes($rowEvents["postText"])),210); ?><?php //echo stripslashes(nl2br($rowEvents["postText"]));?></div>
<?php if($_REQUEST["addbutton"]==2){?>
<div id="addbutton"><a href="<?php echo $learnurl;?>" target="_blank"><input type="button" value="Learn More" class="btn" /></a></div>
<?php }?>

</div>
<?php
			}
		}

}
?>



<?php
}
?>
<input type="hidden" name="postTitle" id="postTitle" value="<?php echo $postTitle;?>" />
<textarea name="adContent" id="adContent" style="display:none;"></textarea>
<script>
function getadcontent()
{
 var previewadbox = $('#previewadbox').html();
 $('#adContent').val(previewadbox);

}
getadcontent();
</script>