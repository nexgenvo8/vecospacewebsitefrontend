<?php
error_reporting(E_ALL);
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$action='add';
$isSubmitted='n';
if(isPost())
{
	$errMsg='';
	$className='';

	$action=clean($_POST['txtAction']);

	if(trim($action)=='add' && $_SESSION['sessUserId']!='' && is_numeric($_SESSION['sessUserId']))
	{

		$jobTitle=clean($_POST["jobTitle"]);
		$companyName=clean($_POST["companyName"]);
		$industryId=trim($_POST["industryId"]);
		$userstype=trim($_POST["userstype"]);
		$departmentname=trim($_POST["departmentname"]);
		$coursename=trim($_POST["coursename"]);
		if($_REQUEST['userstype']==1){
		$passingyear=trim($_POST["passingyear"]);
		}
		else
		{
		$passingyear=trim($_POST["passingyear2"]);
		}
		//echo $passingyear=trim($_POST["passingyear"]).'xxxxxxxxxxxxx';exit();
		$countryName=clean($_POST["countryName"]);
		$cityName=clean($_POST["cityName"]);
		$locationName=clean($_POST["locationName"]);
		$timeZone=trim($_POST["timeZone"]);


			if(trim($errMsg)=='')
			{

				unset($insertFields);
				unset($insertVals);
				unset($whereFields);
				unset($whereVals);

				$insertFields[0]="jobTitle";
				$insertFields[1]="industryId";
				$insertFields[2]="countryName";
				$insertFields[3]="cityName";
				$insertFields[4]="companyName";
				$insertFields[5]="timeZone";
				$insertFields[6]="userstype";
				$insertFields[7]="passingyear";
				$insertFields[8]="departmentname";
				$insertFields[9]="coursename";

				$insertVals[0]=$jobTitle;
				$insertVals[1]=$industryId;
				$insertVals[2]=$countryName;
				$insertVals[3]=$cityName;
				$insertVals[4]=$companyName;
				$insertVals[5]=$timeZone;
				$insertVals[6]=$userstype;
				$insertVals[7]=$passingyear;
				$insertVals[8]=$departmentname;
				$insertVals[9]=$coursename;

				$whereFields[0]="userId";

				$whereVals[0]=$_SESSION['sessUserId'];

				$resUpdate=updateDB(_USERS_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');

				header("location:".$fullurl."timeline.html");
				exit();

			}


	}
}


?>
<!DOCTYPE html>
<html>
<head>
	<title><?php echo $companNameTitle;?></title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
 <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="js/jquery.min.js"></script>
<script src="js/main.js"></script>
</head>
<body style="background-color: #fff;background-image: inherit;">
<div id="wrapper">
	<header>
		<div class="logo login-pros"><a href="<?php echo $fullurl;?>"><img src="<?php echo $fullurl;?>images/logo.png"></a></div>
	</header>
<div class="banner">
  <div class="container">
   <div class="second-step">
    <h2 style="text-align:center; color:#1a94c3;">Complete your registration</h2>
   <ul class="prgress">
   	<li id="st" class="active">&nbsp;</li>
   	<li id="st1" class="">&nbsp;</li>
   </ul>

	   <form name="personaldatafrm" id="personaldatafrm" class="personal-data" method="post">
	   <div id="stepsdetail">
	    <h2 style="font-size: 16px;">Personal Data</h2>

             <div class="half-input">
		        <select name="countryName" id="countryName" class="validate">
				   <option value="India">India</option>
				</select>
			</div>
			<div class="half-input" style="" id="showcityname">
			    <select name="cityName" id="cityName" class="validate">
				   <option value="Delhi">Delhi</option>
				</select>
			</div>

        <div class="half-input">
            <select name="timeZone" id="timeZone" class="validate">
			    <option value="Asia/Kolkata" selected="selected">Asia/Kolkata</option>
			</select>
			  <style>
			  .udropdown{ position:relative; }
			  .udropdown .divunewmain{ background-color:#FFFFFF; position:absolute; left:0px; top:0px; max-height:300px; overflow:auto; border:1px solid #ccc; width:100%; }
			  .udropdown .divunewmain option{ padding:8px 10px; font-size:13px;}
			   .udropdown .divunewmain option:hover{ background-color:#F7F7F7;}
		header {
			margin: auto;
			width: 100%;
			overflow: hidden;
			z-index: 9999999999999;
			position: absolute;
			width: 100%;
			background-color: #fff;
		}
		.overlay {
			width: 100%;
			height: 100%;
			position: fixed;
			left: 0;
			top: 0;
			background: #1a94c3;
			background: -moz-linear-gradient(top, #1a94c3 0%, #6dc8e7 100%);
			background: -webkit-linear-gradient(top, #1a94c3 0%,#6dc8e7 100%);
			background: linear-gradient(to bottom, #1a94c3 0%,#6dc8e7 100%);
			filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1a94c3', endColorstr='#6dc8e7',GradientType=0 );
		}
			  </style>
        </div>
		 <button type="button" class="continue-process-btn" onClick="savedatafun(1);">Continue</button>
		</div>

		<div id="stepsdetail1" style="display:none;">
			<h2>Professional experience</h2>
			<div class="half-input">
			  <select name="userstype" id="userstype" onChange="selectusertypemain();">
			     <option value="1">Student</option>
			     <option value="2">Faculty</option>
			     <option value="3">Alumni</option>
			     <option value="4">Industry Professional</option>
			     <option value="5">Career Enhancer / Service Provider </option>
			  </select>
			  </div>
		<script>
		function selectusertypemain(){
			var userstype = $('#userstype').val();

			$('#jobtitlediv').hide();
			$('#coursenamediv').hide();
			$('#departmentnamediv').hide();
			$('#industrydiv').hide();
			$('#alpassingyeardiv').hide();
			$('#stpassingyeardiv').hide();

			if(userstype==1){
			$('#coursenamediv').show();
			$('#departmentnamediv').show();
			$('#stpassingyeardiv').show();
			$('#companyName').attr('placeholder','University');
			$('#companyName').val('Jamia Millia Islamia');
			}
			if(userstype==2){
			$('#departmentnamediv').show();
			$('#companyName').attr('placeholder','University');
			$('#companyName').val('Jamia Millia Islamia');
			}
			if(userstype==3){
			$('#coursenamediv').show();
			$('#departmentnamediv').show();
			$('#alpassingyeardiv').show();
			$('#industrydiv').show();
			$('#jobtitlediv').show();
			$('#companyName').attr('placeholder','Company Name');
			$('#companyName').val('');
			}
			if(userstype==4){
			$('#industrydiv').show();
			$('#jobtitlediv').show();
			$('#companyName').attr('placeholder','Company Name');
			$('#companyName').val('');
			}
			if(userstype==5){
			$('#industrydiv').show();
			$('#jobtitlediv').show();
			$('#companyName').attr('placeholder','Company Name');
			$('#companyName').val('');
			}
		}
		</script>

		    <div class="half-input" id="jobtitlediv" style=" display:none;">
			<input type="hidden" name="txtHiddenFld" id="txtHiddenFld" value="" >
			<input type="text" name="jobTitle" id="jobTitle" placeholder="Enter Job Title" onKeyUp="hideerrordiv(this.id);"  maxlength="100">
			</div>


			<div class="half-input" id="coursenamediv" >
			<select name="coursename" id="coursename">
			<option value="">Select Course</option>
			<?php
					unset($selectFields);
					unset($whereFields);
					unset($whereVals);

					$sqlOptions="";
					$sqlOptions="SELECT * FROM "._COURSE_MASTER_TABLE_."  order by course_name";
					$resOptions=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlOptions);
					if($resOptions)
					{
						while($rowOptions=mysql_fetch_array($resOptions))
						{

				  ?>
			     <option value="<?php echo trim($rowOptions['course_name']); ?>"  ><?php echo trim($rowOptions['course_name']); ?></option>
			       <?php
						}
					}
				  ?>
	        </select>
			</div>



			<div class="half-input" id="departmentnamediv"  style=" display:none;">
			<select name="departmentname" id="departmentname"  >
			<option value="">Select Department</option>
			<?php
					unset($selectFields);
					unset($whereFields);
					unset($whereVals);

					$sqlOptions="";
					$sqlOptions="SELECT * FROM "._DEPARTMENT_MASTER_TABLE_."  order by department_name";
					$resOptions=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlOptions);
					if($resOptions)
					{
						while($rowOptions=mysql_fetch_array($resOptions))
						{

				  ?>
			<option value="<?php echo trim($rowOptions['department_name']); ?>"  ><?php echo trim($rowOptions['department_name']); ?></option>
			<?php
						}
					}
				  ?>
	        </select>
			</div>

			<div class="half-input" id="stpassingyeardiv"  style=" display:none;">

				<select name="passingyear" id="passingyear" >
				<option value="">Select Passing Year</option>
				<option value="20233">2023</option>
				<option value="2024">2024</option>
				 <?php
                 $currentdate=date("Y", strtotime('+1 years'));
				 $end = date('Y-m-d', strtotime('+5 years'));
                 while($currentdate <= $end) {
				 ?>
				    <option value="<?php echo $currentdate;?>" <?php if($currentdate=='2025'){ echo 'selected'; } ?>> <?php echo $currentdate; $currentdate++;?></option>
				  <?php
				 }
				 ?>
				</select>

			</div>
			<div class="half-input" id="alpassingyeardiv"  style=" display:none;">

				<select name="passingyear2" id="passingyear2" >
				<option value="">Select Passing Year</option>
				 <?php
				 $staringdate = 1950;
                 $currentdate=date("Y");
                 while($staringdate <= $currentdate) {
				 ?>
				    <option value="<?php echo $staringdate;?>"><?php echo $staringdate; $staringdate++;?></option>
				  <?php
				 }
				 ?>
				</select>

			</div>
			<div class="half-input">
			  <input type="text" name="companyName" id="companyName" placeholder="University" onKeyUp="hideerrordiv(this.id);" class="validate" maxlength="100" value="Jamia Millia Islamia">
			</div>
			<div class="half-input" style=" display:none;" id="industrydiv">
			<select name="industryId" id="industryId" onChange="hideerrordiv(this.id);">
			<option value="0">Select Industry</option>
			<?php
					unset($selectFields);
					unset($whereFields);
					unset($whereVals);

					$sqlOptions="";
					$sqlOptions="SELECT id,optionName FROM "._OPTION_MASTER_TABLE_." WHERE optionType='industry' ";
					$resOptions=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlOptions);
					if($resOptions)
					{
						while($rowOptions=mysql_fetch_array($resOptions))
						{
							if($industryId==$rowOptions['id']){ $strSelected='selected="selected"';}else{ $strSelected="";}
				  ?>
			<option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected;?> ><?php echo trim($rowOptions['optionName']); ?></option>
			<?php
						}
					}
				  ?>
	        </select>
			</div>

		<input type="hidden" name="txtAction" id="txtAction" value="<?php echo $action;?>">
		     <button type="button" class="back-btn" onClick="backdatabtn(2);">Back</button>
                  <button  type="button" onClick="formValidation('personaldatafrm');$('#txtHiddenFld').val('1');savelastdatafun(1);" class="continue-process-btn">Continue</button>
		</div>



      </form>
    </div>
  </div>
</div>

<?php include('sitefooter.php');?>
</div>
<?php include('sitecopyright.php');?>
<script>

function backdatabtn(s)
{
  	if(s==2)
	{
		$("#stepsdetail").show();
		$("#stepsdetail1").hide();
		$("#st1").removeClass('active');
	}

}

/*function savelastdatafun(s)
{
	var jobTitle = $("#jobTitle").val();
	var companyName = $("#companyName").val();
	var industry = $("#industry").val();
	//var passingyeaerdiv = $("#passingyeaerdiv").val();
	//var departmentname = $("#departmentname").val();
	$("#txtHiddenFld").val('1');
	if(jobTitle=='')
	{
		$("#jobTitle").addClass('redborderfield');
		$("#companyName").removeClass('redborderfield');
		$("#industry").removeClass('redborderfield');
	}
	else
	{
		if(companyName=='')
		{
			$("#companyName").addClass('redborderfield');
			$("#industry").removeClass('redborderfield');
		}
		else
		{
		  if(industry=='')
		  {
			$("#industry").addClass('redborderfield');
		  }
		}

	}

	if(jobTitle!='' && companyName!='' && industry!=0)
	{
		//$("#personaldatafrm").submit();
	}

}*/

function savedatafun(s)
{
	var firstName = $("#firstName").val();
	var lastName = $("#lastName").val();

	var locationName = $("#locationName").val();
	var timeZone = $("#timeZone").val();
	var countryName = $("#countryName").val();
	var cityName = $("#cityName").val();

	var jobTitle = $("#jobTitle").val();
	var companyName = $("#companyName").val();
	var industry = $("#industry").val();





	if(timeZone!='' && countryName!='' && cityName!='')
	{
		$("#stepsdetail").hide();
		$("#stepsdetail1").show();
		$("#st1").addClass('active');

	}

	if(jobTitle!='' && companyName!='' && s==2)
	{
		$("#stepsdetail").hide();
		$("#stepsdetail1").hide();
	}



}




function selectstate(statename)
{
 var countryName = encodeURIComponent($("#countryName").val());
 var statename = encodeURIComponent(statename);
 if(countryName!='')
 {
 	$("#showcityname").show();
 }
 else
 {
	 $("#showcityname").hide();
 }

 //$("#cityName").load('loadstate.php?countryId='+countryName+'&statename='+statename);

}

selectstate('<?php if($mystateName!='') {echo sanitizedboutput($mystateName); }else{ echo '0';}?>');
selectusertypemain();
</script>
<div class="overlay">&nbsp;</div>

</body>
</html>