<?php 
include "inc.php";
include "config/logincheck.php";
$activeleftmenuID=89;  
$detailbackpage='company_detail.php';
$ticketid=decode($_GET['id']);

$select='';
$where='';
$rs='';  
$select='*'; 
$where='id='.decode($_GET['id']).'';
$rs=GetPageRecord($select,_company_master_,$where);
$resultcustomer=mysql_fetch_array($rs);  

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo strip($resultcustomer['company_name']); ?> - Company Details  - <?php echo $systeminfo['systemname']; ?></title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script src="js/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="js/ddaccordion.js"></script> 
<script type="text/javascript" src="js/system_function.js"></script> 
<script type="text/javascript" src="js/tablesortingjquery.js"></script>
<script src="js/jquery.searchableSelect.js"></script>
<script src="js/validation.js"></script> 
<script type="text/javascript" src="js/zebra_datepicker.js"></script>
 <link rel="stylesheet" href="css/default.css" type="text/css">
</head>

<body>


 <?php include("header_top.php"); ?>

<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="4%" align="left" valign="top" id="leftouter">
    
    
    <?php include("left.php"); ?>
    
    
    
    </td>
    <td width="96%" align="left" valign="top">
	<div class="innertop">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="47%" align="left" valign="top"><h1>Company Details </h1>
            <div class="brdc"><span><a href="<?php echo $fullurl; ?>">Dashboard</a></span><span>-</span><span><a href="<?php echo decode($_GET['page']); ?>">Company</a></span></div></td>
<td width="53%" align="right" valign="bottom"><br />

<a href="add_ticket.php?page=<?php echo encode($actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>&cid=<?php echo encode($resultcustomer['id']); ?>&ctype=2"><input type="button" name="Submit2" value="Add Ticket" class="darkorbutton " /></a>
<a href="#"><input type="button" name="Submit2" value="Add Booking" class="darkorbutton " /></a>
<a href="#"><input type="button" name="Submit2" value="Add Enquiry" class="darkorbutton " /></a>
<?php if($_GET['page']!=''){ ?><a href="<?php echo decode($_GET['page']); ?>"><input type="button" name="Submit2" value="Back" class="darkbluebutton" /></a><?php } ?>
               
			  
			  
			  
		    </td>
        </tr>
      </table>
	</div>
	
	<div class="row1"><div class="whitebox"> <div class="grayheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>Company Information  </td>
    <td align="right"><a href="edit_company.php?page=<?php echo encode($actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>&id=<?php echo $_GET['id']; ?>"><input type="button" name="Submit2" value="Edit" class="darkbluebutton" />
          </a></td>
  </tr>
  
</table>
</div>
		 <div class="sectioninner">
		   <table width="100%" border="0" cellpadding="0" cellspacing="0" >
             <tr>
               <td width="49%" align="left" valign="top" style="    border: #E8E8E8 1px solid; background-color:#FDFDFD;"><div class="ticketdetailsleft" style="border:0px;"> 
			        
                  <div class="ticketfollowupouter"><table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <td class="borderbottom"><span class="heading">Company Type :</span></td>
    <td class="borderbottom"><?php
$select4='name'; 
$where4='id='.$resultcustomer['customer_type'].'';
$rs4=GetPageRecord($select4,_customer_type_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['name']); 

?></td>
  </tr>
  <tr>
    <td class="borderbottom"><span class="heading">ID:</span></td>
    <td class="borderbottom"><strong><?php echo strip($resultcustomer['company_id']); ?></strong></td>
  </tr>
  <tr>
    <td class="borderbottom"><span class="heading">Address Type:</span> </td>
    <td class="borderbottom"><?php
$select4='name'; 
$where4='id='.$resultcustomer['address_type'].'';
$rs4=GetPageRecord($select4,_address_type_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['name']); 

?></td>
  </tr>
  <tr>
    <td class="borderbottom"><span class="heading">Name:</span></td>
    <td class="borderbottom"><?php echo strip($resultcustomer['company_name']); ?></td>
  </tr>
  <tr>
    <td width="18%" valign="top" class="borderbottom"><span class="heading">Contact No.:</span></td>
    <td width="82%" class="borderbottom">
	<?php
$select='';
$where='';
$rs=''; 
$select='*';  
$where='parentid='.$resultcustomer['id'].' and section = "company" order by primaryid desc';
$rs=GetPageRecord($select,_crm_contact_phone_master_,$where);
while($list=mysql_fetch_array($rs)){ 
?>
 <?php echo strip($list['phone']); ?> &nbsp;&nbsp;(<?php
$select4='name'; 
$where4='id='.$list['type'].' and status = 1';
$rs4=GetPageRecord($select4,_crm_contact_type_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['name']); 

?>) <?php if($list['primaryid']=='1'){ ?><span style="color:#6990C3;"> - Primary</span><?php } ?><br />

<?php } ?>	</td>
  </tr>
  <tr>
    <td valign="top" class="borderbottom"><span class="heading">Email Id:</span> </td>
    <td class="borderbottom"><?php
$select='';
$where='';
$rs=''; 
$select='*';  
$where='parentid='.$resultcustomer['id'].' and section = "company" order by primaryid desc';
$rs=GetPageRecord($select,_crm_contact_email_master_,$where);
while($list=mysql_fetch_array($rs)){ 
?>
 <?php echo strip($list['email']); ?> &nbsp;&nbsp;(<?php
$select4='name'; 
$where4='id='.$list['type'].' and status = 1';
$rs4=GetPageRecord($select4,_crm_contact_type_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['name']); 

?>)  <?php if($list['primaryid']=='1'){ ?><span style="color:#6990C3;"> - Primary</span><?php } ?><br />

<?php } ?>	</td>
  </tr>
 <tr>
    <td width="29%" class="borderbottom"><span class="heading">Country</span>:</td>
    <td width="71%" class="borderbottom"><?php
$select4='countryname'; 
$where4='id='.$resultcustomer['country'].'';
$rs4=GetPageRecord($select4,_country_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['countryname']); 

?> </td>
  </tr> 
 
  <tr>
    <td class="borderbottom"><span class="heading">State</span>:</td>
    <td class="borderbottom"><?php
$select4='statename'; 
$where4='id='.$resultcustomer['state'].'';
$rs4=GetPageRecord($select4,_state_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['statename']); 

?></td>
  </tr> 
 
  <tr>
    <td class="borderbottom"> <span class="heading">City:</span></td>
    <td class="borderbottom"><?php
$select4='cityname'; 
$where4='id='.$resultcustomer['city'].'';
$rs4=GetPageRecord($select4,_city_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['cityname']); 

?></td>
  </tr>
  <tr>
    <td class="borderbottom"><span class="heading">Pincode:</span></td>
    <td class="borderbottom"><?php echo strip($resultcustomer['pincode']); ?></td>
  </tr>
  <tr>
    <td class="borderbottom"><span class="heading">Landmark:</span></td>
    <td class="borderbottom"><?php echo strip($resultcustomer['landmark']); ?></td>
  </tr>
  <tr>
    <td class="borderbottom"><span class="heading">Address:</span></td>
    <td  class="borderbottom"><?php echo strip($resultcustomer['address']); ?></td>
  </tr>
  <tr>
    <td  class="borderbottom"><span class="heading">Long & Latitude:</span></td>
    <td  class="borderbottom"><?php echo strip($resultcustomer['long_latitude']); ?></td>
  </tr>
  <tr>
    <td  class="borderbottom"><span class="heading">Ownership:</span></td>
    <td  class="borderbottom"><?php
$select4='name'; 
$where4='id='.$resultcustomer['ownership'].'';
$rs4=GetPageRecord($select4,_crm_ownership_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['name']); 

?></td>
  </tr>
  <tr>
    <td  class="borderbottom"><span class="heading">Rating:</span></td>
    <td  class="borderbottom"><?php echo strip($resultcustomer['rating']); ?></td>
  </tr>

 
 
</table>
                  </div>
  
               </div></td>
               <td width="1%" align="left" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
               <td width="50%" align="left" valign="top" style="    border: #E8E8E8 1px solid; background-color:#FDFDFD;"><div class="ticketdetailsleft" style="border:0px;">
                 
			     <div class="ticketfollowupouter">
			 <table width="100%" border="0" cellpadding="5" cellspacing="0">
     <tr>
    <td width="31%" class="borderbottom"><span class="heading">TIN/Registration:</span></td>
    <td width="69%" class="borderbottom"><?php echo strip($resultcustomer['tin']); ?></td>
  </tr>
  <tr>
    <td class="borderbottom"><span class="heading">PAN No.:</span></td>
    <td class="borderbottom"><?php echo strip($resultcustomer['pan']); ?></td>
  </tr>
  <tr>
    <td class="borderbottom"><span class="heading">Service Tax No.:</span></td>
    <td class="borderbottom"><?php echo strip($resultcustomer['servicetax']); ?></td>
  </tr> <tr>
    <td class="borderbottom"><span class="heading">CIN No.:</span></td>
    <td class="borderbottom"><?php echo strip($resultcustomer['cin']); ?></td>
  </tr>
  <tr>
    <td class="borderbottom"><span class="heading">Industry.:</span></td>
    <td class="borderbottom"><?php
$select4='name'; 
$where4='id='.$resultcustomer['industry'].'';
$rs4=GetPageRecord($select4,_crm_industry_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['name']); 

?></td>
  </tr>
  <tr>
    <td class="borderbottom"><span class="heading">Annual Revenue:</span></td>
    <td class="borderbottom"><?php echo strip($resultcustomer['annual_revenue']); ?></td>
  </tr>
  <tr>
    <td class="borderbottom"><span class="heading">Website:</span></td>
    <td class="borderbottom"><?php echo strip($resultcustomer['website']); ?></td>
  </tr> <tr>
    <td class="borderbottom"><span class="heading">Number of Employee:</span></td>
    <td class="borderbottom"><?php echo strip($resultcustomer['employee']); ?></td>
  </tr>
    <tr>
    <td  class="borderbottom"><span class="heading">IATA No.:</span></td>
    <td  class="borderbottom"><?php echo strip($resultcustomer['iatano']); ?></td>
  </tr>
  <tr>
    <td  class="borderbottom"><span class="heading">Bonton Relationship:</span></td>
    <td  class="borderbottom"><?php
$select4='name'; 
$where4='id='.$resultcustomer['bonton_relationship'].'';
$rs4=GetPageRecord($select4,_crm_relationship_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['name']); 

?></td>
  </tr>
  <tr>
    <td  class="borderbottom"><span class="heading">Supplier Service List:</span></td>
    <td  class="borderbottom"><?php
$select4='name'; 
$where4='id='.$resultcustomer['supplier_service_list'].'';
$rs4=GetPageRecord($select4,_crm_supplier_service_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['name']); 

?></td>
  </tr>
  <tr>
    <td  class="borderbottom"><span class="heading">B2B Service List:</span></td>
    <td  class="borderbottom"><?php
$select4='name'; 
$where4='id='.$resultcustomer['b2b_service_list'].'';
$rs4=GetPageRecord($select4,_crm_b2b_service_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['name']); 

?></td>
  </tr>
   <tr>
    <td class="borderbottom"><span class="heading">Created By:</span></td>
    <td class="borderbottom"><?php
$select4='first_name,last_name'; 
$where4='id='.$resultcustomer['addby'].'';
$rs4=GetPageRecord($select4,_user_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['first_name']).' '.strip($result['last_name']); 

?></td>
  </tr>
  <tr>
    <td> <span class="heading">Create Date:</span></td>
    <td><?php if($resultcustomer['adddate']!=''){  echo showdate($resultcustomer['adddate']); } else { echo '-'; } ?></td>
  </tr>
  <tr>
    <td class="borderbottom"><span class="heading">Remark:</span></td>
    <td class="borderbottom"><?php echo strip($resultcustomer['remark']); ?></td>
  </tr>
 <tr>
    <td><span class="heading">Assign To</span>:</td>
    <td><?php
$select4='first_name,last_name'; 
$where4='id='.$resultcustomer['assign_to'].'';
$rs4=GetPageRecord($select4,_user_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['first_name']).' '.strip($result['last_name']); 

?></td>
  </tr> 
</table>
			   
			   </div>
			   
			    
			   </div></td>
             </tr>
           </table>
		 </div>
		
		 
		</div></div>
		
		
		<div class="row1" style="padding-top:0px;"><div class="whitebox"> 
		<div class="grayheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="1%"><div class="plusminusbutton" id="tabcontact" onclick="updowntab('tabcontact','sectioncontact');">-</div></td>
    <td width="48%"  onclick="updowntab('tabcontact','sectioncontact');">Contacts  
			(<?php 
			$select='id';
			$where='where company_id="'.$resultcustomer['id'].'"';
			echo $contact = countlisting($select,_contacts_master_,$where);
			?>) </td>
    <td width="51%" align="right"><a href="add_contacts.php?page=<?php echo encode($actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>&cid=<?php echo $_GET['id']; ?>&openclosetab=contact"><input type="button" name="Submit2" value="Add New" class="darkbluebutton" />
          </a></td>
  </tr>
  
</table>
</div> <div class="sectioninner" style="margin-top:0px; display:show;" id="sectioncontact">
		   <div class="sectioninner">
 <?php if($contact>0){ ?>
		<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
   <thead>
   <tr>
     <th width="10%" align="left" class="header sortingbg">Designation</th>
     <th width="20%" align="left" class="header sortingbg">	Name</th>
    <th width="13%" align="left" class="header sortingbg">Phone</th>
    <th width="16%" align="left" class="header sortingbg">Email Id </th>
    <th width="15%" align="left" class="header sortingbg">City</th>
    <th width="12%" align="left" class="header sortingbg">Assign to </th>
    <th width="14%" align="left" class="header sortingbg">Created Date </th>
    </tr></thead>
 
<?php
$no=1;
$select='';
$where='';
$rs='';  
$limit=2000; 
$select='*';
$where='where company_id="'.$resultcustomer['id'].'" order by id desc';
$targetpage='';
$rs=GetRecordList($select,_contacts_master_,$where,$limit,$page,$targetpage);
$totalentry=$rs[1];
$paging=$rs[2];
while($customer=mysql_fetch_array($rs[0])){
?>
 
  <tr>
    <td align="left" ><?php
$select4='desigName'; 
$where4='id='.$customer['designation'].'';
$rs4=GetPageRecord($select4,_customer_designation_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['desigName']); 

?></td>
    <td align="left" ><a href="contact_detail.php?page=<?php echo encode($actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"); ?>&id=<?php echo encode($customer['id']); ?>"><?php
$select4='title'; 
$where4='id='.$customer['title'].'';
$rs4=GetPageRecord($select4,_title_master_,$where4);
$resultassigned=mysql_fetch_array($rs4); 
echo strip($resultassigned['title']); 

?> <?php echo strip($customer['first_name']); ?> <?php echo strip($customer['last_name']); ?></a></td>
    <td align="left"><?php
$select4='phone'; 
$where4='parentid='.$customer['id'].' and section = "contact" and primaryid=1';
$rs4=GetPageRecord($select4,_crm_contact_phone_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['phone']); 

?></td>
    <td align="left"><?php
$select4='email'; 
$where4='parentid='.$customer['id'].' and section = "contact" and primaryid=1';
$rs4=GetPageRecord($select4,_crm_contact_email_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['email']); 

?></td>
    <td align="left"><?php
$select45='city'; 
$where45='parentid='.$customer['id'].' and section = "contact" and primaryid=1';
$rs4=GetPageRecord($select45,_crm_contact_address_master_,$where45);
$result2=mysql_fetch_array($rs4);  

if($result2['city']!=0){ 
$select4='cityname'; 
$where4='id='.$result2['city'].'';
$rs4=GetPageRecord($select4,_city_master_,$where4);
$result=mysql_fetch_array($rs4); 
echo strip($result['cityname']); 
}
?></td>
    <td align="left"><?php
$select4='first_name,last_name'; 
$where4='id='.$customer['assign_to'].'';
$rs4=GetPageRecord($select4,_user_master_,$where4);
$resultassigned=mysql_fetch_array($rs4); 
echo strip($resultassigned['first_name']).' '.strip($resultassigned['last_name']); 

?></td>
    <td align="left"><?php echo showdate($customer['adddate']) ?></td>
    </tr>
  <?php $no++; } ?>
</table>
 <?php } else {?>
<div style="text-align:center; padding:5px;">No Record</div>
<?php } ?>
		
		</div></div>
		
		 
		</div></div>
		
		
		<div class="row1" style="padding-top:0px;"><div class="whitebox"> <div class="grayheader">
		    <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="1%"><div class="plusminusbutton" id="historytab" onclick="updowntab('historytab','sectionhistory');">+</div></td>
                <td width="99%" onclick="updowntab('historytab','sectionhistory');">History (<?php 
			$select='id';
			$where='where customer_id="'.$resultcustomer['id'].'" and type="company"';
			echo $history = countlisting($select,_crm_history_master_,$where);
			?>)</td>
              </tr>
            </table>
		    </div>
		 <div class="sectioninner" style="margin-top:0px; display:none;" id="sectionhistory">
		   
		  <div class="sectioninner">
<?php if($history>0){ ?><table width="100%" border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">
   <thead>
   <tr>
     <th width="19%" align="left" class="header sortingbg">
Added By </th>
    <th width="25%" align="left" class="header sortingbg">Added On</th>
    <th width="27%" align="left" class="header">Reason Type</th>
    <th width="29%" align="left" class="header">Details</th>
    </tr></thead>
 
<?php
$no=1;
$select='';
$where='';
$rs=''; 
$page='';
$limit='6000';
$search='';
$select='*';
$where='where customer_id="'.$resultcustomer['id'].'" and type="company" order by id desc';
$targetpage='';
$rs=GetRecordList($select,_crm_history_master_,$where,$limit,$page,$targetpage);
$totalentry=$rs[1];
$paging=$rs[2];
while($history=mysql_fetch_array($rs[0])){
?>
 
  <tr>
    <td align="left"><?php
$select4='first_name,last_name'; 
$where4='id='.$history['addedby'].'';
$rs4=GetPageRecord($select4,_user_master_,$where4);
$resultassigned=mysql_fetch_array($rs4); 
echo strip($resultassigned['first_name']).' '.strip($resultassigned['last_name']); 

?></td>
    <td align="left"><?php echo showdatetime($history['adddate']) ?></td>
    <td align="left"><?php echo strip($history['reason_type']); ?></td>
    <td align="left"><?php echo strip($history['details']); ?></td>
    </tr>
  <?php $no++; } ?> 
</table><?php } else {?>
<div style="text-align:center; padding:5px;">No Record</div>
<?php } ?>
		</div></div>
		
		 
		</div></div>
		 
		 
        
         <?php include("footer.php"); ?>
       
	</td>
  </tr>
</table>

<script>

function changeticketstatus(){
var getdropdown = document.getElementById("ticketaction").value;

if(getdropdown=='assigned'){
$("#reassigndiv").show();
} else {
$("#reassigndiv").hide();

}

}



function changetab(id,tb){
$(".contenttab").hide();
$("#t").removeClass("active");
$("#e").removeClass("active");
$("#b").removeClass("active");
$("#h").removeClass("active");
$("#"+tb).addClass("active");
$("#"+id).show();	
}
changetab('ticket','t');
</script>


</body>
</html>
