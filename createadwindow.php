<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php');
$postcat=$_REQUEST["id"];
?>
<div class="promotion-cont">
    <h3>Create Ad</h3>
  
    <a class="grp-close"  onclick="createadwindow('','0','0');"><i class="fa fa-times" aria-hidden="true"></i></a>
  <form class="edit-layer" enctype="multipart/form-data" name="frmpostad" id="frmpostad" method="post" target="actionfrm" action="<?php echo $fullurl;?>common_action.php"> 
    <div class="promote-left">
      <h3>Ad information</h3>
      <div class="form-group" id="adcategorydiv">
        <label>Category</label>
        <select name="adcategory" id="adcategory" onChange="selectadcategory(this.value);choosemyad();">
          <option value="0" <?php if($postcat==0){ echo "selected";}?>>Select</option>
          <!--<option value="6" <?php if($postcat==6 || $postcat=='p'){ echo "selected";}?>>I want to promote my Post</option>-->
          <option value="7" <?php if($postcat==7 || $postcat=='a'){ echo "selected";}?>>I want to promote my Article</option>
          <option value="1" <?php if($postcat==1){ echo "selected";}?>>I want to promote my Event</option>
          <option value="2" <?php if($postcat==2){ echo "selected";}?>>I want to promote my PROjects</option>
          <option value="3" <?php if($postcat==3){ echo "selected";}?>>I want to promote my SMB</option>
          <option value="4" <?php if($postcat==4){ echo "selected";}?>>I want to promote my Talent</option>
          <option value="5" <?php if($postcat==5){ echo "selected";}?>>I want to promote my Jobs</option>
        </select>
      </div>
	  
	  <!--<div id="adsection">-->
	  <div class="form-group" id="myaddiv" style="display:none;">
        <label id="addcategoryname">Category</label>
        <select name="myad" id="myad" onChange="choosemyad();">
        </select>
      </div>
	  
	  <div class="form-group" id="myaddbuttondiv" style="display:none;">
        <label>Ad a button to your post</label>
        <select name="addbutton2" id="addbutton2" onChange="btnyesno();choosemyad();">
          <option value="1">No Button</option>
          <option value="2">Learn More</option>
        </select>
		
      </div>
	  
	  <div class="form-group" id="adbtnlinkdiv" style="display:none;">
        <label>Choose a link for this button</label>
       <input type="text" name="addlinkurl" id="addlinkurl" onKeyUp="choosemyad();" maxlength="250" autocomplete="off" placeholder="Enter the URL you want to promote">
      </div>
	  <script>
		function btnyesno(addbutton)
		{
			 var addbutton= $('#addbutton2').val();
			
			 if(addbutton==2)
			 {
			 	 $('#adbtnlinkdiv').show();
				//alert();
			 }
			 else
			 {
			 	$('#adbtnlinkdiv').hide();
				$('#addlinkurl').val('');
				// alert('fff');
			 }
			
		}
		</script>
      
      <div class="form-group budget" id="mybudgetdiv" style="display:none;">
	  <h3>Total budget</h3>
	  <div style="margin-bottom:10px;">Please select your budget</div>
	  <?php
	  	unset($selectFields);
		unset($whereFields);
		unset($whereVals);
		$g=1;
		$sqlEvents="";
		$sqlEvents="select * from "._AD_BUDGET_TABLE_."  order by id asc  ";
		$resEvents=getRecords(_AD_BUDGET_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlEvents); 	
		if($resEvents)
		{
			while($rowEvents=mysql_fetch_array($resEvents))
			{
			
	  ?>
        <label><input type="radio" name="budgetId" id="budgetId" value="<?php echo stripslashes($rowEvents["id"]);?>" <?php if($g==1){ echo 'checked';}?>><?php echo stripslashes($rowEvents["duration"]);?> - INR <?php echo stripslashes($rowEvents["amount"]);?></label>
		<?php
		      $g++;
			}
		}
?> 
      </div>
	  
	 <!-- </div>-->
	  <script>
	  function choosemyad()
	  {
		  //var adcategory=$('#adcategory').val();
		  //var myad=$('#myad').val();
		  var addbutton=$('#addbutton2').val();
		  var addlinkurl=$('#addlinkurl').val();
		  addlinkurl = encodeURIComponent($.trim(addlinkurl)); 
		  
		  if($('#myad').val()!=0)
		  {
		  	var myad=$('#myad').val();
		  }
		  else
		  {
		 	 var myad = $('#mypostId').val();
		  }
		  
		  if($('#adcategory').val()!=0)
		  {
		  	var adcategory=$('#adcategory').val();
		  }
		  else
		  {
		 	 var adcategory = $('#mycatpostId').val();
		  }
		  
		
		  
		  $('#showad').load('<?php echo $fullurl;?>showad.php?adcategory='+adcategory+'&myad='+myad+'&addbutton='+addbutton+'&addlinkurl='+addlinkurl);
	  }
	 
	  function selectadcategory(id)
	  {
	  
		   var adcategory=$('#adcategory').val();
		    //$('#adsection').show();
		    $('#myaddiv').show();
		    $('#myaddbuttondiv').show();
		    $('#mybudgetdiv').show();
		 
		  if(id=='p' || id=='a')
		  {
		 	var adcategory=id;
		  }
		  else
		  {
		 	 adcategory=adcategory;
		  }
		  
		  //alert(adcategory+'---'+id);
		   
		     
				if(adcategory=='p' || adcategory=='a')
				{
				  if(adcategory=='p')
				  {
					adcategory=6;
					$('#mycatpostId').val(adcategory);
				  }	
				  if(adcategory=='a')
				  {
					adcategory=7;
				  }	 
					 
					 
					  $('#adcategorydiv').hide();
					   $('#myaddiv').hide();
					  //$('#myaddiv').hide();
					  var myad = $('#mypostId').val();
					  var addbutton=$('#addbutton2').val();
					  var addlinkurl=$('#addlinkurl').val();
					  addlinkurl = encodeURIComponent($.trim(addlinkurl)); 
					//alert(myad+'=wwwwwwww'+adcategory);
					 if(myad!=0)
					 {
					///alert(myad+'gfgfgfgf='+adcategory);
					  $('#showad').load('<?php echo $fullurl;?>showad.php?adcategory='+adcategory+'&myad='+myad+'&addbutton='+addbutton+'&addlinkurl='+addlinkurl);
					 }
					 else
					 {
					  //alert(myad+'==='+adcategory);
					 }
				 
				}
				
		  
		  
		   if(adcategory!=0 && adcategory!='p' && adcategory!='a')
		   {
				//alert('loadmyad.php');
				$('#myad').load('<?php echo $fullurl;?>loadmyad.php?id='+adcategory);
		   }
		   
		   if(adcategory==1)
		   {
				$('#addcategoryname').text('Select your event');
		   }
		   if(adcategory==2)
		   {
				$('#addcategoryname').text('Select your PROject');
		   }
		   
		   if(adcategory==3)
		   {
				$('#addcategoryname').text('Select your SMB Connect');
		   }
		   
		   if(adcategory==4)
		   {
				$('#addcategoryname').text('Select your Talent Connect');
		   }
		   
		   if(adcategory==5)
		   {
				$('#addcategoryname').text('Select your Job');
		   }
		   
		   if(adcategory==6 || adcategory=='p')
		   {
				$('#addcategoryname').text('Select your Post');
		   }
		   
		   if(adcategory==7 || adcategory=='a')
		   {
				$('#addcategoryname').text('Select your Article');
		   }
		   
		   
		   if(adcategory==0 || adcategory=='')
		   {
				//$('#adsection').hide();
				$('#myaddiv').hide();
				 $('#myaddbuttondiv').hide();
		   		 $('#mybudgetdiv').hide();
		   }
	   
	   
	  }
	  
	  function desktopmobileview(id)
	  {
		   if(id==1)
		   {
			 $('#previewadbox').removeClass('mobile');
			 $('#d1').removeClass('active');
			 $('#d2').removeClass('active');
			 $('#d1').addClass('active');
		   }
		   else
		   {
		     $('#previewadbox').addClass('mobile');
			 $('#d1').removeClass('active');
			 $('#d2').removeClass('active');
			 $('#d2').addClass('active');
		   }
	  }
	  <?php if($postcat=='p' || $postcat=='a'){?>
	  selectadcategory('<?php echo $postcat;?>');
	   <?php }?>
	  </script>
	  
    </div>
	
    <div class="promote-right">
      <ul class="cntr_tab">
        <li><a class="active" id="d1" onclick="desktopmobileview('1');">Desktop View</a></li>
        <li><a id="d2" onclick="desktopmobileview('2');">Mobile View</a></li>
      </ul>
	  
      <div class="promotion-ad" id="showad">
	  
	  
	  <div class="preview-ad2">No Preview Available</div>
	  
	  
	  </div>
    </div>
    <div class="ad-fttr">
      <a onclick="createadwindow('','0','0');">Cancel</a>
	 <input type="hidden" name="action" id="action" value="saveadcontent" />
	 <input type="hidden" name="mypostId" id="mypostId" value="<?php echo $_REQUEST["postId"];?>" />
	 <input type="hidden" name="mycatpostId" id="mycatpostId" value="" />
      <button class="green-btn" type="submit">Promote</button>
    </div>
	</form>
	<div id="mypostdiv" style="display:none;"></div>
  </div>