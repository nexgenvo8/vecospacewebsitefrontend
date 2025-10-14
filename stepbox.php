<?php
include_once('inc.php'); 

if($_REQUEST['employmentId']!='0' && $_REQUEST['membershipId']!='0' && $_REQUEST['step']=='2'){

		unset($insertFields);
		unset($insertVals);	
		unset($whereFields);	
		unset($whereVals);

		$insertFields[0]="employmentId";
		$insertFields[1]="membershipId";
			
		$insertVals[0]=$_REQUEST['employmentId'];
		$insertVals[1]=$_REQUEST['membershipId'];		

		$whereFields[0]="userId";	
		$whereVals[0]=$_SESSION['sessUserId'];	
		$resUserDetails=updateDB(_USERS_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,''); // verified the user email address	
		
}

if($_REQUEST['jobTitle']!='' && $_REQUEST['companyName']!='' && $_REQUEST['step']=='3'){

		unset($insertFields);
		unset($insertVals);	
		unset($whereFields);	
		unset($whereVals);

		$insertFields[0]="jobTitle";
		$insertFields[1]="companyName";
		$insertFields[2]="industryId";
			
		$insertVals[0]=clean($_REQUEST['jobTitle']);
		$insertVals[1]=clean($_REQUEST['companyName']);
		$insertVals[2]=$_REQUEST['industry'];
				

		$whereFields[0]="userId";	
		$whereVals[0]=$_SESSION['sessUserId'];	
		$resUserDetails=updateDB(_USERS_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,''); // verified the user email address	

?>
<script>window.location.href = '<?php echo $fullurl;?>home.php';</script>
<?php
	
}

?>
	
	
	
	  <?php if($_REQUEST['step']==1){ ?>
	  
	 
	  <div id="divloginstapes1" class="step-one" style="display:block;">
		  
		  <div class="slct_cont">
		  <label>What's your current employment status?</label>
			<select name="employmentId" id="employmentId" >
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
						if($optionsid==$rowOptions['id']){ $strSelected='selected="selected"';}else{ $strSelected="";}
			  ?>
			   <option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected;?> ><?php echo trim($rowOptions['optionName']); ?></option>
			  <?php
			  		}
			    }
			  ?>
			</select>
		  </div> 
		  <div class="slct_cont">
		  <label>What do you expect from your <?php echo $companNameTitle;?> membership?</label>
			<select name="membershipId" id="membershipId" >
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
						if($optionsid==$rowOptions1['id']){ $strSelected='selected="selected"';}else{ $strSelected="";}
			  ?>
			   <option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected;?> ><?php echo trim($rowOptions1['optionName']); ?></option>
			  <?php
			  		}
			    }
			  ?>
			</select>
		  </div> 
		  <input type="submit" id="frmloginstapesbutton1" class="svbtn" value="Save" onClick="savestepone();" />
	 
		  </div>
	<?php } ?>  
		  
		  
		  
		  
		  
		  
		  <?php if($_REQUEST['step']==2){ ?>
		  
	  <div id="divloginstapes2" class="step-one">
       
      <div class="slct_cont">
      <label>What's your current job title?</label>
       <input name="jobTitle"  id="jobTitle" type="text" >
      </div> 
      <div class="slct_cont">
      <label>What's your current company name?</label>
        <input name="companyName" id="companyName" type="text" onKeyUp="showindustry();">
      </div> 
	    <div class="slct_cont" id="industrybox" style="display:none;" >
      <label style="font-size:12px;">We like lerning: The compay you work for isn't in our database yet, so we can provide you with great contact suggestions.</label>
        <select name="industry" id="industry"> 
			  <?php
			  	unset($selectFields);
				unset($whereFields);
				unset($whereVals);
			
				$sqlOptions1="";
				$sqlOptions1="SELECT id,optionName FROM "._OPTION_MASTER_TABLE_." WHERE optionType='industry' ";
				$resOptions1=getRecords(_USERS_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlOptions1); 	
				if($resOptions1)
				{
					while($rowOptions1=mysql_fetch_array($resOptions1))
					{
						if($optionsid==$rowOptions1['id']){ $strSelected='selected="selected"';}else{ $strSelected="";}
			  ?>
			   <option value="<?php echo trim($rowOptions1['id']); ?>" <?php echo $strSelected;?> ><?php echo trim($rowOptions1['optionName']); ?></option>
			  <?php
			  		}
			    }
			  ?>
			</select>
      </div> 
      <button type="submit" id="frmloginstapesbutton2" class="svbtn" onClick="savesteptwo();">Save</button>
      
      </div>
	  
	   <?php }?>
	  
	  
	  