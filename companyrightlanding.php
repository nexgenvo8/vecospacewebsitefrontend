<div class="hm_right_sec">
<div class="crt-employr">
  <a href="<?php echo $fullurl;?>create-new-company.html" class="btn" style="margin-top:48px;"><i class="fa fa-plus" aria-hidden="true"></i> Create Company Profile</a>
</div>
<?php if($companyName!='' || $userIndustryName!='')
{?>
<div class="box">
  <h2>Your Employers</h2>
  
  <div class="yremployr">
    <a href="#" class="img"><img src="<?php echo $fullurl;?>uploads/<?php echo $userindustryPhoto;?>"></a>
    <div class="yremployr-dtail">
      <a href="#"><?php echo $companyName;?></a>
      <span><?php echo $userIndustryName;?></span>
    </div>
  </div>
  <a href="#" class="all-employrs"><!-- Your employers --></a>
  
</div>

<?php
}

	if($_SESSION["sessUserId"]!='' && $_SESSION["sessUserId"]!=0)
	{
		$selectFields =[];
		$whereFields = [];
		$whereVals = [];
		
		$sqlCompany1="";
		$sqlCompany1="select * from "._COMPANY_MASTER_TABLE_." where  companyName!='' and userId=".$_SESSION["sessUserId"]." order by id desc LIMIT 0,50 ";
		$resCompany1=getRecords(_COMPANY_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlCompany1); 	
		if($resCompany1)
		{
?>
<div class="box">
  <h2>Your Company Pages </h2>
  <div class="yremployr">
  <?php
			while($rowCompany=mysqli_fetch_array($resCompany1))
			{
				$companyPhoto='';
				$companyTypeName='';
				if($rowCompany["companyTypeId"]!=0 && $rowCompany["companyTypeId"]!='')
				{
					$a="";
					$a="SELECT * from "._OPTION_MASTER_TABLE_." WHERE id= ".$rowCompany["companyTypeId"]."";
					$b=mysqli_query($conn, $a) or die(mysqli_error($conn)); 
					$rowCompanyTypeName=mysqli_fetch_array($b); 
					$companyTypeName=$rowCompanyTypeName["optionName"];
				}
				
				if($rowCompany['id']!=0 && $rowCompany['id']!='')
				{
					$ap="";
					$ap="select imageName from "._IMAGE_MASTER_TABLE_." where  postId= ".$rowCompany['id']." and imageType=8 ";
					$bp=mysqli_query($conn, $ap) or die(mysqli_error($conn)); 
					$rowLogoImg=mysqli_fetch_array($bp); 
					
					if($rowLogoImg["imageName"]!='')
					{
						$companyPhoto=$rowLogoImg["imageName"];
					} else {
						$companyPhoto='company.png';
					}
				}				
		  ?>		  
  	<div style="overflow: hidden;
width: 100%;
margin-bottom: 24px;
">
    <a href="<?php echo $fullurl;?>company-profile.html?companyId=<?php echo encodeStr($rowCompany['id']);?>" class="img"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($companyPhoto));?>"  title="<?php echo stripslashes($rowCompany["companyName"]);?>" alt="<?php echo stripslashes(trim($rowCompany["companyName"]));?>"></a>
    
    <div class="yremployr-dtail">
      <a href="<?php echo $fullurl;?>company-profile.html?companyId=<?php echo encodeStr($rowCompany['id']);?>"><?php echo getStrLength(stripslashes($rowCompany["companyName"]),100); ?></a>
      <span><?php echo stripslashes($companyTypeName);?></span>
    </div>
	</div>
	<?php
		}

?>
  </div>
</div>
<?php
 }
 	}

?>


<?php
		$selectFields =[];
		$whereFields = [];
		$whereVals = [];
		
		$sqlCompany="";
		$sqlCompany="select * from "._COMPANY_MASTER_TABLE_." where status=0 and id IN(select companyId from "._COMPANY_FOLLOWERS_TABLE_." where userId=".$_SESSION["sessUserId"].") order by viewStatus desc LIMIT 0,50 ";
		$resCompany=getRecords(_COMPANY_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlCompany); 	
		if($resCompany)
		{
?>
<div class="box">
  <h2>Companies You Are Following</h2>
  <div class="yremployr">
  <?php
			while($rowCompany=mysqli_fetch_array($resCompany))
			{
				$companyPhoto='';
				$companyTypeName='';
				if($rowCompany["companyTypeId"]!=0 && $rowCompany["companyTypeId"]!='')
				{
					$a="";
					$a="SELECT * from "._OPTION_MASTER_TABLE_." WHERE id= ".$rowCompany["companyTypeId"]."";
					$b=mysqli_query($conn, $a) or die(mysqli_error($conn)); 
					$rowCompanyTypeName=mysqli_fetch_array($b); 
					$companyTypeName=$rowCompanyTypeName["optionName"];
				}
				
				if($rowCompany['id']!=0 && $rowCompany['id']!='')
				{
					$ap="";
					$ap="select imageName from "._IMAGE_MASTER_TABLE_." where  postId= ".$rowCompany['id']." and imageType=8 ";
					$bp=mysqli_query($conn, $ap) or die(mysqli_error($conn)); 
					$rowLogoImg=mysqli_fetch_array($bp); 
					
					if($rowLogoImg["imageName"]!='')
					{
						$companyPhoto=$rowLogoImg["imageName"];
					} else {
						$companyPhoto='company.png';
					}

				}
				
		  ?>
		  
		  
  	<div style="overflow: hidden;
width: 100%;
margin-bottom: 24px;
">
    <a href="<?php echo $fullurl;?>company-profile.html?companyId=<?php echo encodeStr($rowCompany['id']);?>" class="img"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($companyPhoto));?>"  title="<?php echo stripslashes($rowCompany["companyName"]);?>" alt="<?php echo stripslashes(trim($rowCompany["companyName"]));?>"></a>
    
    <div class="yremployr-dtail">
      <a href="<?php echo $fullurl;?>company-profile.html?companyId=<?php echo encodeStr($rowCompany['id']);?>"><?php echo getStrLength(stripslashes($rowCompany["companyName"]),100); ?></a>
      <span><?php echo stripslashes($companyTypeName);?></span>
    </div>
	</div>
	<?php
		}

?>
  </div>
  <a href="#" class="all-employrs"><!-- Your employers --></a>
</div>
<?php
 }
$selectFields=[];
$whereFields=[];
$whereVals=[];

$sqlFeatured="";
$sqlFeatured="select * from "._COMPANY_MASTER_TABLE_." where companyName!='' and status=0 and id IN(select postId from "._IMAGE_MASTER_TABLE_." where imageType=8) order by viewStatus desc, id desc LIMIT 0,10 ";
$resFeatured=getRecords(_COMPANY_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlFeatured); 	
if($resFeatured)
{
?>
<div class="box" style="border-bottom:0px;">
  <h2>Featured Companies</h2>
  <ul class="feturd-employrs-list">
	 <?php
			while($rowFeatured=mysqli_fetch_array($resFeatured))
			{
				$companyPhoto='';
				$companyTypeName='';
				if($rowFeatured["companyTypeId"]!=0 && $rowFeatured["companyTypeId"]!='')
				{
					$a="SELECT * from "._OPTION_MASTER_TABLE_." WHERE id= ".$rowFeatured["companyTypeId"]."";
					$b=mysqli_query($conn, $a) or die(mysqli_error($conn)); 
					$rowFeaturedTypeName=mysqli_fetch_array($b); 
					$companyTypeName=$rowFeaturedTypeName["optionName"];
				}
				
				if($rowFeatured['id']!=0 && $rowFeatured['id']!='')
				{
					$ap="select imageName from "._IMAGE_MASTER_TABLE_." where  postId= ".$rowFeatured['id']." and imageType=8 ";
					$bp=mysqli_query($conn, $ap) or die(mysqli_error($conn)); 
					$rowLogoImg=mysqli_fetch_array($bp); 
					
					if($rowLogoImg["imageName"]!='')
					{
						$companyPhoto=$rowLogoImg["imageName"];
					} else {
						$companyPhoto='company.png';
					}

				}
				
		  ?>
	<li>
      <a href="<?php echo $fullurl;?>company-profile.html?companyId=<?php echo encodeStr($rowFeatured['id']);?>"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($companyPhoto));?>"  title="<?php echo stripslashes($rowFeatured["companyName"]);?>" alt="<?php echo stripslashes(trim($rowFeatured["companyName"]));?>"></a>
    </li>
    <?php
		}

?>
  </ul>
</div>
<?php
}
?>

</div>