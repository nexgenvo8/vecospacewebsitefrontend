<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session

$action='add';
$isSubmitted='n';
if(isPost()) // handling the post variables
{
	$errMsg='';
	$className='';
	$classFldName='';
	
	//print_r($_POST);
	$action=clean($_POST['submit']);
	
	if(trim($action)=='editprofile')
	{

		$firstName=clean($_POST["firstName"]);
		$lastName=clean($_POST["lastName"]);
		$employmentId=clean($_POST["employmentId"]);
		$membershipId=clean($_POST["membershipId"]);
		$jobTitle=clean($_POST["jobTitle"]);
		$companyName=clean($_POST["companyName"]);
		$countryName=clean($_POST["countryName"]);
		$cityName=clean($_POST["cityName"]);
		$locationName=clean($_POST["locationName"]);
		//$dob=trim($_POST["dob"]);
		$day=trim($_POST["day"]);
		$month=trim($_POST["month"]);
		$year=trim($_POST["year"]);
		
		$dob=$year.'-'.$month.'-'.$day;
		
		$firstNameUrl=makeContentUrl($firstName);	
		$lastNameUrl=makeContentUrl($lastName);	
		
		$userurl=$firstNameUrl.'-'.$lastNameUrl;
			
			if(trim($errMsg)=='')
			{
				unset($insertFields);
				unset($insertVals);	
				unset($whereFields);	
				unset($whereVals);				
				
				$insertFields[0]="firstName";
				$insertFields[1]="lastName"; 
				$insertFields[2]="employmentId";
				$insertFields[3]="membershipId";
				$insertFields[4]="locationName";
				$insertFields[5]="modifyDate";
				$insertFields[6]="dob";
				$insertFields[7]="countryName";
				$insertFields[8]="userurl";
				$insertFields[9]="cityName";
		
				$insertVals[0]=$firstName;
				$insertVals[1]=$lastName; 
				$insertVals[2]=$employmentId;
				$insertVals[3]=$membershipId;
				$insertVals[4]=$locationName;
				$insertVals[5]=time();
				$insertVals[6]=$dob;
				$insertVals[7]=$countryName;
				$insertVals[8]=$userurl;
				$insertVals[9]=$cityName;
				
				$whereFields[0]="userId";
		
				$whereVals[0]=$_SESSION['sessUserId'];
				
				$resUpdate=updateDB(_USERS_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,''); // verified the user email address
				if($resUpdate)
				{
					$isSubmitted='n';
					$errMsg='Profile updated successfully.';	
					$className='success';
				}
				header("Location:".$fullurl."myprofile/".encodeStr($_SESSION['sessUserId'])."/".$userurl.".html");
				

			}
			
			
	}
	
}

?>
<!DOCTYPE html>
<html>
<head>
<title><?php echo $myname;?> - Update Profile - <?php echo $companyname;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/style.css">
<link rel="icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">

<link href="<?php echo $fullurl;?>css/jquery-ui-1.9.1.custom.css" rel="stylesheet" type="text/css" />
<script src="<?php echo $fullurl;?>js/jquery.min.js"></script>
<script src="<?php echo $fullurl;?>js/jquery-ui-1.9.1.custom.js"></script>

<script src="<?php echo $fullurl;?>js/main.js"></script>
<script type="text/javascript" language="javascript">
		$(function() {
			//$('#dob').datepicker({dateFormat: 'yy-mm-dd'});
			$( "#dob" ).datepicker({changeMonth: true,  changeYear: true,
            yearRange: "-77:+0"});

		});
</script>
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
          
          <div class="updt_frfl">
          <h3>Update your Profile</h3>
           <form name="updateprofile" id="updateprofile" method="post">
             <div class="half"> <label>First Name <div class="erorfldcls" id="fld_firstName"></div> <div class="erorfldcls" id="fld_lastName"></div></label>
              <input type="text" name="firstName" id="firstName" value="<?php echo sanitizedboutput($myfirstName);?>" onKeyUp="hideerrordiv(this.id);">
              </div>

             <div class="half">
             <label>Last Name</label> 
             <input type="text" name="lastName" id="lastName" value="<?php echo sanitizedboutput($mylastName);?>" onKeyUp="hideerrordiv(this.id);">
             </div>
			  <label>Date of birth</label> 
             <!--<input type="text" name="dob" id="dob" value="<?php echo sanitizedboutput($dob);?>" onKeyUp="hideerrordiv(this.id);" readonly="true">-->
             <div class="birth">
			  <select name="day" id="day" onChange="hideerrordiv(this.id);" style="width:110px;">
			 	 <option value="0">Day</option>
				<?php
				for($d=1; $d<=31; $d++)
				{
				if($day==$d){ $strSelected='selected="selected"';}else{ $strSelected="";}
			  ?>
			   <option value="<?php echo $d; ?>" <?php echo $strSelected;?> ><?php echo $d; ?></option>
			  <?php
			    }
			  ?>
			  </select>
			  &nbsp;&nbsp;
			   <select name="month" id="month" onChange="hideerrordiv(this.id);" style="width:110px;">
			 	 <option value="0">Month</option>
				<?php
				for($m=1; $m<=12; $m++)
				{
				if($month==$m){ $strSelected='selected="selected"';}else{ $strSelected="";}
			  ?>
			   <option value="<?php echo $m; ?>" <?php echo $strSelected;?> ><?php echo $m; ?></option>
			  <?php
			    }
			  ?>
			  </select>
			  &nbsp;&nbsp;
			   <select name="year" id="year" onChange="hideerrordiv(this.id);" style="width:110px;">
			 	 <option value="0">Year</option>
				<?php
				for($y=1920; $y<=date('Y', strtotime('-10 years'));$y++)
				{
				if($year==$y){ $strSelected='selected="selected"';}else{ $strSelected="";}
			  ?>
			   <option value="<?php echo $y; ?>" <?php echo $strSelected;?> ><?php echo $y; ?></option>
			  <?php
			    }
			  ?>
			  </select>
			</div>
              <label>What's your current employment status? <div class="erorfldcls" id="fld_employmentId"></div></label>
              <select name="employmentId" id="employmentId" onChange="hideerrordiv(this.id);">
			  <option value="0">Select</option>
			  <?php
			  	unset($selectFields);
				unset($whereFields);
				unset($whereVals);
			
				$sqlOptions="";
				$sqlOptions="SELECT id,optionName FROM "._OPTION_MASTER_TABLE_." WHERE optionType='currentemployments' ";
				$resOptions=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlOptions); 	
				if($resOptions)
				{
					while($rowOptions=mysql_fetch_array($resOptions))
					{
						if($employmentId==$rowOptions['id']){ $strSelected='selected="selected"';}else{ $strSelected="";}
			  ?>
			   <option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected;?> ><?php echo trim($rowOptions['optionName']); ?></option>
			  <?php
			  		}
			    }
			  ?>
			</select>
              <label>What do you expect from your <?php echo $companNameTitle;?> membership? <div class="erorfldcls" id="fld_membershipId"></div></label>
              <select name="membershipId" id="membershipId" onChange="hideerrordiv(this.id);">
			  <option value="0">Select</option>
			  <?php
			  	unset($selectFields);
				unset($whereFields);
				unset($whereVals);
			
				$sqlOptions1="";
				$sqlOptions1="SELECT id,optionName FROM "._OPTION_MASTER_TABLE_." WHERE optionType='konecttmembership' ";
				$resOptions1=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlOptions1); 	
				if($resOptions1)
				{
					while($rowOptions1=mysql_fetch_array($resOptions1))
					{
						if($membershipId==$rowOptions1['id']){ $strSelected='selected="selected"';}else{ $strSelected="";}
			  ?>
			   <option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected;?> ><?php echo trim($rowOptions1['optionName']); ?></option>
			  <?php
			  		}
			    }
			  ?>
			</select>
			  <label>Country</label>
              <select name="countryName" id="countryName" onChange="selectstate('<?php if($mystateName!='') {echo sanitizedboutput($mystateName); }else{ echo '0';}?>');">
			  <option value="">Select</option>
			  <?php
			  	unset($selectFields);
				unset($whereFields);
				unset($whereVals);
			
				$sqlOptions1="";
				$sqlOptions1="SELECT country_name FROM "._COUNTRIES_TABLE_." ORDER BY country_name ";
				$resOptions1=getRecords(_COUNTRIES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlOptions1); 	
				if($resOptions1)
				{
					while($rowOptions1=mysql_fetch_array($resOptions1))
					{
						if($mycountryName==$rowOptions1['country_name']){ $strSelected='selected="selected"';}else{ $strSelected="";}
			  ?>
			   <option value="<?php echo trim($rowOptions1['country_name']); ?>" <?php echo $strSelected;?> ><?php echo trim($rowOptions1['country_name']); ?></option>
			  <?php
			  		}
			    }
			  ?>
			</select>
			<label>State</label>
              <select name="cityName" id="cityName">
			  
			</select>
			  <!--<input type="text" name="cityName" id="cityName" value="<?php echo sanitizedboutput($mystateName);?>">-->
			  
			<label>City</label>
              <input type="text" name="locationName" id="locationName" value="<?php echo sanitizedboutput($mylocationName);?>">
              <button type="submit" name="submit" value="editprofile" class="svbtn">Save</button>
            </form>
          </div>
        </div>
        <?php include('right-sidebar.php');?>
      </div>
    </div>
  </div>
  <?php include('footer.php');?>
</div>
<script>
function selectstate(statename)
{
 var countryName = encodeURIComponent($("#countryName").val());
 var statename = encodeURIComponent(statename);
 
 $("#cityName").load('loadstate.php?countryId='+countryName+'&statename='+statename);
  //alert(countryName);

}

selectstate('<?php if($mystateName!='') {echo sanitizedboutput($mystateName); }else{ echo '0';}?>');


function hideerrordiv(elemId)
{
	$('#fld_'+elemId).css('display','none');
}

$(document).ready(function()
{

	$("#updateprofile").submit(function()
	{

		var errorFldArray=[];
		var allFldArray=["firstName","lastName","employmentId"];

		if($("#firstName").val().trim()=='')
		{
			errorFldArray.push(['firstName@@@Please enter First Name.']);
		}

		if($("#firstName").val().trim()!='')
		{
			if(isValidateLen($('#firstName').val().trim(),60))
			{
				errorFldArray.push(['firstName@@@First Name exceeded character limit! Can have 60 characters.']);
			}
		}


		if($("#lastName").val().trim()=='')
		{
			errorFldArray.push(['lastName@@@Please enter Last Name.']);
		}

		if($("#lastName").val().trim()!='')
		{
			if(isValidateLen($('#lastName').val().trim(),60))
			{
				errorFldArray.push(['lastName@@@Last Name exceeded character limit! Can have 60 characters.']);
			}
		}
		
		if($("#employmentId").val().trim()=='' || $("#employmentId").val().trim()==0)
		{
			errorFldArray.push(['employmentId@@@Please select your employement status.']);
		}
		
		if($("#membershipId").val().trim()=='' || $("#membershipId").val().trim()==0)
		{
			errorFldArray.push(['employmentId@@@Please select your <?php echo $companNameTitle;?> membership.']);
		}
		
		for (var i = 0; i < allFldArray.length; i++)
		{
			$('#fld_'+allFldArray[i]).css('display','none');

			$('#allErrorMsg').css('display','none');
		}


		for (var i = 0; i < errorFldArray.length; i++)
		{

			$('#allErrorMsg').css('display','block');

			$('html, body').animate({scrollTop: '-100px'}, 0);

			var errorfldrow='';
			var errorfldrownew='';
			errorfldrow=$.trim(errorFldArray[i]);
			errorfldrownew=errorfldrow.split('@@@');

			$('#fld_'+errorfldrownew[0]).css('display','inline');

			$('#fld_'+errorfldrownew[0]).text(errorfldrownew[1]);

		}


		if(errorFldArray.length>0)
		{
 			return false;
		}
		else
		{
			return true;
		}


	});



});


$('#firstName').focus();
</script>
</body>
</html>
