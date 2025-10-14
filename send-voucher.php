<?php 
ob_start();
include "inc.php";   

 

if($_GET['id']!='' && is_numeric(decode($_GET['id']))){ 

$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean(decode($_GET['id'])); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_VOUCHER_MASTER_,$where); 
$resultInvoice=mysql_fetch_array($rs); 

$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=1; 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_VOUCHER_SETTING_MASTER_,$where); 
$resultvouchersetting=mysql_fetch_array($rs); 



$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=clean($resultInvoice['queryId']); 
$where='id='.$id.''; 
$rs=GetPageRecord($select,_QUERY_MASTER_,$where); 
$resultQuery=mysql_fetch_array($rs);  


$select=''; 
$where=''; 
$rs='';   
$select='*';  
$where='id=1'; 
$rs=GetPageRecord($select,_VOUCHER_LIST_MASTER_,$where); 
$resultInvoiceSetting=mysql_fetch_array($rs);  



$select=''; 
$where=''; 
$rs='';   
$select='*';  
$where='id=1'; 
$rs=GetPageRecord($select,_INVOICE_SETTING_MASTER_,$where); 
$resultInvoiceSettingLogo=mysql_fetch_array($rs); 

}

if($resultQuery['clientType']==1){
$select4='*';  
$where4='id='.$resultQuery['companyId'].''; 
$rs4=GetPageRecord($select4,_CORPORATE_MASTER_,$where4); 
$resultCompany=mysql_fetch_array($rs4); 
$mobilemailtype='corporate';
}

if($resultQuery['clientType']==2){
$select4='*';  
$where4='id='.$resultQuery['companyId'].''; 
$rs4=GetPageRecord($select4,_CONTACT_MASTER_,$where4); 
$resultCompany=mysql_fetch_array($rs4); 
$mobilemailtype='contacts';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Invoice - INV-<?php echo str_pad($resultInvoice['id'], 6, '0', STR_PAD_LEFT); ?></title> 
 <style>
 #invoicearea .table {
    border: solid #ccc !important;
    border-width:1px !important;
}
#invoicearea .td {
    border: solid #ccc !important;
    border-width:1px !important;
}
 </style>
</head>

<body style="background-color:#FFFFFF;">
<div style="font-family: Arial,Helvetica,sans-serif; margin: 0; padding: 0">
        <table width="100%" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                  <td align="center" valign="top" style="padding-bottom:10px;">
				   <table width="850" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td colspan="3"><table width="100%" border="0" cellpadding="5" cellspacing="0">
      <tr>
        <td colspan="3" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0">
          <tr>
            <td colspan="2" style="padding:10px;"><img src="<?php echo $fullurl; ?>download/<?php echo $resultInvoiceSettingLogo['logo']; ?>" height="45" /></td>
            <td width="50%" align="right" style="color:#000; font-size:30px; padding:10px;"><strong>Voucher</strong></td>
          </tr>
          
        </table></td>
        </tr>
      <tr>
        <td colspan="3" align="left" valign="top" style=" border-top:2px #ccc solid; height:10px;"></td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="top">
		  <?php
$thisid='1';
$tpaybill='0'; 
$select2='*';
$where2='voucherId='.clean($resultInvoice['id']).' order by id desc'; 
$rs2=GetPageRecord($select2,_VOUCHER_LIST_MASTER_,$where2); 
while($listofsuppliers=mysql_fetch_array($rs2)){




if($listofsuppliers['supplierId']!=''){
$id=$listofsuppliers['supplierId'];

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
$editresult=mysql_fetch_array($rs1);

$editassignTo=clean($editresult['assignTo']); 
$editname=clean($editresult['name']); 
$editcontactPerson=clean($editresult['contactPerson']);
$editcompanyTypeId=clean($editresult['companyTypeId']);
$editcountryId=clean($editresult['countryId']);
$editstateId=clean($editresult['stateId']); 
$editcityId=clean($editresult['cityId']); 
$edittitle=clean($editresult['title']); 
$addedBy=clean($editresult['addedBy']);
$dateAdded=clean($editresult['dateAdded']);
$modifyBy=clean($editresult['modifyBy']);
$modifyDate=clean($editresult['modifyDate']); 
$editaddress1=clean($editresult['address1']);  
$editaddress2=clean($editresult['address2']);  
$editaddress3=clean($editresult['address3']);  
$editpinCode=clean($editresult['pinCode']);
$editgstn=clean($editresult['gstn']);
$editagreement=clean($editresult['agreement']);
$editid=clean($editresult['id']);
$editidroomType=clean($listofsuppliers['roomType']);
}




?>   
		<table width="100%" border="0" cellpadding="0" cellspacing="0" >
          <tr>
            <td colspan="2" align="left" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px; padding:10px;">
              <tr>
                <td colspan="2" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Booking ID: </td>
                <td width="68%" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo makeQueryId($resultInvoice['queryId']); ?></strong></td>
              </tr>
              <tr>
                <td colspan="2" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Guest Name:</td>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo $resultQuery['guest1']; ?></strong></td>
              </tr>
              <tr>
                <td colspan="2" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Hotel:</td>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo ($editname); ?></strong></td>
              </tr>
              <tr>
                <td colspan="2" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Adddress: </td>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong>
                  <?php  
	if($listofsuppliers['supplierstateId']!=0){
	$select1='*';  
 $where1='stateId='.$listofsuppliers['supplierstateId'].' and addressParent='.$editid.' and addressType="supplier"'; 
$rs1=GetPageRecord($select1,_ADDRESS_MASTER_,$where1); 
$addressSup=mysql_fetch_array($rs1);  ?>

                  <?php echo $addressSup['address']; ?>, <?php echo getCityName($addressSup['cityId']); ?>, <?php echo getStateName($addressSup['stateId']); ?>, <?php echo $addressSup['pinCode']; ?> <?php echo getCountryName($addressSup['countryId']); 
 
 } else { ?>
	              <?php echo $editaddress1; ?>
	              <?php } ?>
                </strong></td>
              </tr>
            <?php if($editresult['locationMap']!=''){ ?>  <tr>
                <td colspan="2" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Location (MAP):</td>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><a href="<?php echo $editresult['locationMap']; ?>" target="_blank"><strong>View Location </strong></a></td>
              </tr><?php } ?>
              
            </table></td>
            <td width="50%" align="left" valign="top" bgcolor="#F8F8F8"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-size:13px; padding:10px;">
              <tr>
                <td colspan="2" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Booking ID: </td>
                <td width="68%" style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo makeQueryId($resultInvoice['queryId']); ?></strong></td>
              </tr>
              <tr>
                <td colspan="2" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Guest Name:</td>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo $resultQuery['guest1']; ?></strong></td>
              </tr>
              <tr>
                <td colspan="2" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Hotel:</td>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong><?php echo ($editname); ?></strong></td>
              </tr>
              <tr>
                <td colspan="2" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Adddress: </td>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><strong>
                  <?php  
	if($listofsuppliers['supplierstateId']!=0){
	$select1='*';  
 $where1='stateId='.$listofsuppliers['supplierstateId'].' and addressParent='.$editid.' and addressType="supplier"'; 
$rs1=GetPageRecord($select1,_ADDRESS_MASTER_,$where1); 
$addressSup=mysql_fetch_array($rs1);  ?>

                  <?php echo $addressSup['address']; ?>, <?php echo getCityName($addressSup['cityId']); ?>, <?php echo getStateName($addressSup['stateId']); ?>, <?php echo $addressSup['pinCode']; ?> <?php echo getCountryName($addressSup['countryId']); 
 
 } else { ?>
	              <?php echo $editaddress1; ?>
	              <?php } ?>
                </strong></td>
              </tr>
            <?php if($editresult['locationMap']!=''){ ?>  <tr>
                <td colspan="2" style="padding-bottom:5px; padding-top:5px; padding-right:5px;">Location (MAP):</td>
                <td style="padding-bottom:5px; padding-top:5px; padding-right:5px;"><a href="<?php echo $editresult['locationMap']; ?>" target="_blank"><strong>View Location </strong></a></td>
              </tr><?php } ?>
              
            </table></td>
          </tr>
        </table>
		<?php } ?>		</td>
      </tr>
      <tr>
        <td colspan="3" align="left" valign="top">&nbsp;</td>
      </tr>
      
    </table></td>
    </tr>
</table>

				  
				  </td>
                </tr>
                <tr>
                  <td align="center" valign="top" style="padding-bottom:10px;"><img src="<?php echo $fullurl; ?>download/<?php echo $resultInvoiceSettingLogo['logo']; ?>" /></td>
                </tr>
                <tr>
                    <td width="100%" valign="top">
                        <table width="850" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#000000">
                            <tbody>
                                <tr>
                                    <td width="100%" style="border-bottom: 0; background: #af1086; padding: 10px; border-top-left-radius: 35px; border-top-right-radius: 35px" valign="middle">                                    </td>
                                </tr>
                               
                                <tr>
                                  <td style="background: #fff; border: 1px solid #e7e7e7; color: #666">&nbsp;</td>
                                </tr>
                                <tr>
                                    <td width="100%" style="background: #fff; border: 1px solid #e7e7e7; color: #666">
                                        <table width="100%">
                                            <tbody>
                                                <tr>
                                                    <td style="font-weight: bold" align="center" width="100%">
                                                        <h4 style="margin: 0; font-size: 18px">Booking ID: <?php echo makeQueryId($resultInvoice['queryId']); ?></h4>
                                                        <hr style="border-color: #e4e1e1; width:630px;">                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>                                    </td>
                                </tr>
                                <tr>
                                    <td style="padding: 0 10px; background-color: #d3dbe5; border-bottom-left-radius: 35px; border-bottom-right-radius: 35px; padding-bottom: 10px">
                                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td style="font-size: 12px; color: #2f2f2f; font-weight: normal; text-align: left; font-family: Arial,Helvetica,sans-serif; vertical-align: top">
                                                        <table width="100%" align="left" cellpadding="0" cellspacing="0" border="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td valign="top" style="padding: 20px 0 10px 0">
                                                                    
																	  
																	    <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                                            <tbody>
                                                                                
                                                                      <?php
$thisid='1';
$tpaybill='0'; 
$select2='*';
$where2='voucherId='.clean($resultInvoice['id']).' order by id desc'; 
$rs2=GetPageRecord($select2,_VOUCHER_LIST_MASTER_,$where2); 
while($listofsuppliers=mysql_fetch_array($rs2)){




if($listofsuppliers['supplierId']!=''){
$id=$listofsuppliers['supplierId'];

$select1='*';  
$where1='id='.$id.''; 
$rs1=GetPageRecord($select1,_SUPPLIERS_MASTER_,$where1); 
$editresult=mysql_fetch_array($rs1);

$editassignTo=clean($editresult['assignTo']); 
$editname=clean($editresult['name']); 
$editcontactPerson=clean($editresult['contactPerson']);
$editcompanyTypeId=clean($editresult['companyTypeId']);
$editcountryId=clean($editresult['countryId']);
$editstateId=clean($editresult['stateId']); 
$editcityId=clean($editresult['cityId']); 
$edittitle=clean($editresult['title']); 
$addedBy=clean($editresult['addedBy']);
$dateAdded=clean($editresult['dateAdded']);
$modifyBy=clean($editresult['modifyBy']);
$modifyDate=clean($editresult['modifyDate']); 
$editaddress1=clean($editresult['address1']);  
$editaddress2=clean($editresult['address2']);  
$editaddress3=clean($editresult['address3']);  
$editpinCode=clean($editresult['pinCode']);
$editgstn=clean($editresult['gstn']);
$editagreement=clean($editresult['agreement']);
$editid=clean($editresult['id']);
$editidroomType=clean($listofsuppliers['roomType']);
}




?>   

<?php if($thisid==1){ ?>

<tr>
                                                                                    <td style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px">YOUR HOTEL DETAILS</td>
                                                                                   <?php if($listofsuppliers['showCost']==1){ ?> <td style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px">&nbsp;&nbsp;</td>
                                                                                    <td style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px">RATE DETAILS (in INR)</td> <?php } ?>
                                                                              </tr>
<?php } ?>



   <tr>
                                                                                    <td align="center" valign="top" bgcolor="#FFFFFF">
                                                                                        <table border="0" align="left" cellspacing="0" cellpadding="0" style="border-style: none; border-color: inherit; border-width: 0; border-collapse: collapse; width: 286px;">
                                                                                            <tbody>
                                                                                                <tr>
                                                                                                    <td style="background: #ffffff" valign="top">
                                                                                                        <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                                                                                                            <tbody>
                                                                                                                <tr>
                                                                                                                    <td width="275" align="left" valign="top" style="padding: 7px 10px; color: #fff"><table width="100%" border="0" cellpadding="4" cellspacing="0" style="background: #ffffff; color: #fff">
                                                                                                                      <tbody>
                                                                                                                        <tr>
                                                                                                                          <td style="font: normal 14px Arial,Helvetica,sans-serif; color: #2f2f2f; padding-bottom: 5px"><strong style="color: #777777"><?php echo ($editname); ?></strong></td>
                                                                                                                        </tr>
                                                                                                                         
                                                                                                                        <tr>
                                                                                                                          <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666"><?php  
	if($listofsuppliers['supplierstateId']!=0){
	$select1='*';  
 $where1='stateId='.$listofsuppliers['supplierstateId'].' and addressParent='.$editid.' and addressType="supplier"'; 
$rs1=GetPageRecord($select1,_ADDRESS_MASTER_,$where1); 
$addressSup=mysql_fetch_array($rs1);  ?>

 <?php echo $addressSup['address']; ?>, <?php echo getCityName($addressSup['cityId']); ?>, <?php echo getStateName($addressSup['stateId']); ?>, <?php echo $addressSup['pinCode']; ?> <?php echo getCountryName($addressSup['countryId']); 
 
 } else { ?>
	<?php echo $editaddress1; ?>
	<?php } ?></td>
                                                                                                                        </tr>
                                                                                                                      
                                                                                                                       <!-- <tr>
                                                                                                                          <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666">Phone: <?php echo getPrimaryPhone($editid,'suppliers'); ?></td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                          <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666">Email: <?php echo getPrimaryEmail($editid,'suppliers'); ?></td>
                                                                                                                        </tr>-->
                                                                                                                        <tr>
                                                                                                                          <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666">Room Type: <strong><?php echo getRoomType($editidroomType); ?></strong></td>
                                                                                                                        </tr>
                                                                                                                        <tr>
                                                                                                                          <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666">Check In: <strong><?php echo date('d-m-Y',strtotime($listofsuppliers['fromDate'])); ?></strong></td>
                                                                                                                        </tr>
																														<tr>
                                                                                                                          <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666">Check Out: <strong><?php echo date('d-m-Y',strtotime($listofsuppliers['toDate'])); ?></strong></td>
                                                                                                                        </tr>
                                                                                                                        <?php if($editresult['locationMap']!=''){ ?><tr>
                                                                                                                          <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666">Location (MAP): <a href="<?php echo $editresult['locationMap']; ?>" target="_blank"><strong style="color:#006699;">View Location </strong></a></td>
                                                                                                                        </tr><?php } ?>
                                                                                                                        <tr>
                                                                                                                          <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666">&nbsp;</td>
                                                                                                                        </tr>
                                                                                                                      </tbody>
                                                                                                                    </table></td>
                                                                                                                </tr>
                                                                                                            </tbody>
                                                                                                    </table>                                                                                                    </td>
                                                                                                </tr>
                                                                                            </tbody>
                                        </table>                                                                              </td>
                                                                                 <?php if($listofsuppliers['showCost']==1){  $showcostdiv=1;?>   <td valign="top" align="center">&nbsp;</td>
                                                                           <td align="center" valign="top" bgcolor="#FFFFFF">
                                                                                        <table width="284" cellpadding="4" cellspacing="0" style=" margin:10px;">
                        <tbody>
                            <tr>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">Rooms</td>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="right"><?php echo $listofsuppliers['suppliernorooms']; ?></td>
                            </tr>
                            <tr>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">No. of Nights</td>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="right"><?php echo $listofsuppliers['suppliernonight']; ?></td>
                            </tr>
                            <tr>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">Per Night Cost</td>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="right"><?php echo $listofsuppliers['supplierpernight']; ?></td>
                            </tr>
                            <tr>
                                <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">Cost</td>
                                <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="right"><?php echo $listofsuppliers['suppliertotalcost']; ?></td>
                            </tr>
                            <tr>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">Tax CGST </td>
                              <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; color: #666666; padding: 5px 0 5px 0; border-bottom: 1px solid #ebebf0" align="right"><?php echo $listofsuppliers['suppliercgst']; ?>%</td>
                            </tr>
                            <tr>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">SGST </td>
                              <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; color: #666666; padding: 5px 0 5px 0; border-bottom: 1px solid #ebebf0" align="right"><?php echo $listofsuppliers['suppliersgst']; ?>%</td>
                            </tr>
                            <tr>
                              <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" valign="top" class="auto-style1">IGST </td>
                              <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; color: #666666; padding: 5px 0 5px 0; border-bottom: 1px solid #ebebf0" align="right"><?php echo $listofsuppliers['supplierigst']; ?>%</td>
                            </tr>
                            <tr>
                                <td style="font: normal 12px Arial,Helvetica,sans-serif; font-weight: bold; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 0px #ebebf0; border-top: solid 2px #c7c7c7" valign="top" class="auto-style1">Amount Payable</td>
                                <td style="font-family: Arial,Helvetica,sans-serif; font-size: 12px; font-weight: normal; color: #666666; padding: 5px 0 5px 0; border-bottom: 0px solid #ebebf0; border-top: solid 2px #c7c7c7" align="right"><strong><?php echo $listofsuppliers['suppliertoalcost']; $tpaybill = $tpaybill+$listofsuppliers['suppliertoalcost']; ?></strong></td>
                            </tr>
                        </tbody>
                    </table>                                                                                    </td> <?php } ?>
                                                                              </tr>
                     <tr>
                                                                                    <td height="20" bgcolor="#D3DBE5">&nbsp;&nbsp;</td>
                                                                                      <td bgcolor="#D3DBE5">&nbsp;&nbsp;</td>
                                                                                      <td height="20" bgcolor="#D3DBE5"> </td>
                                                                              </tr>  <?php $thisid++; } ?>                                                         
                                                                            </tbody>
                                                                      </table>                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                     <td style="font: bold 16px Arial,Helvetica,sans-serif; padding-bottom: 20px">                                                                   </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 20px">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                  <td style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px"><table width="100%" border="0" align="left" cellspacing="0" cellpadding="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                  <td style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px">YOUR BOOKING DETAILS</td>
                                                                                  <td style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px">&nbsp;</td>
                                                                                  <td width="49%" style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px">INCLUSION</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td width="49%" align="left" valign="top" bgcolor="#FFFFFF" style="padding-right: 5px"><table width="100%" cellspacing="0" cellpadding="4" style="margin:5px;">
                                                                                                            <tbody>
                                                                                                                <tr>
                                                                                                                    <td width="140" align="left" valign="top" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Guest Name</td>
                                                                                                                    <td width="170" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="left"><span style="text-transform: capitalize"><?php echo $resultQuery['guest1']; ?></span></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td width="140" align="left" valign="top" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Email</td>
                                                                                                                    <td width="170" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0" align="left"><?php echo getPrimaryEmail($resultCompany['id'],''.$mobilemailtype.''); ?></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                  <td  style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Contact Number</td>
                                                                                                                  <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0"><?php echo getPrimaryPhone($resultCompany['id'],''.$mobilemailtype.''); ?></td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                  <td  style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0">Booking Date</td>
                                                                                                                  <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0"><?php echo date('m-d-Y',$resultInvoice['dateAdded']);?></td>
                                                                                                                </tr>
                                                                                                              <?php if($showcostdiv==1){ ?>  <tr>
                                                                                                                  <td  style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0"><strong>Total Payable </strong></td>
                                                                                                                  <td style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0"><strong><?php echo $tpaybill; ?> INR</strong></td>
                                                                                                                </tr><?php } ?>
                                                                                                            </tbody>
                                                                                                        </table>                                                                                  </td>
                                                                                    <td width="1%" align="left" valign="top" style="padding-right: 5px">&nbsp;</td>
                                                                                    <td width="49%" align="left" valign="top" bgcolor="#FFFFFF" style="padding-right: 5px"><table width="100%" cellspacing="0" cellpadding="4" style="margin:5px;">
                                                                                                            <tbody>
                                                                                                           
<?php
$string = $resultInvoice['amenitiesList'];
$string = preg_replace('/\.$/', '', $string); //Remove dot at end if exists
$array = explode(',', $string); //split string into array seperated by ', '
foreach($array as $value) //loop over values
{
if($value!=''){ 

$select=''; 
$where=''; 
$rs='';   
$select='*'; 
$id=1; 
$where='id='.$value.''; 
$rs=GetPageRecord($select,_AMENITIES_MASTER_,$where); 
$emvalname=mysql_fetch_array($rs); 
?>
 <tr>
<td align="left" valign="top" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 0 5px 0; border-bottom: solid 1px #ebebf0"><?php echo $emvalname['name']; ?><span style="text-transform: capitalize"> </span></td>
         <?php } } if($resultInvoice['specialrequest']!=''){ ?>	                                                                                                       </tr>
 <tr>
   <td align="left" valign="top" style="font: normal 12px Arial,Helvetica,sans-serif; color: #666666; padding: 5px 5 5px 5;  ">
   <?php echo $resultInvoice['specialrequest']; ?>   </td>
 </tr>
 <?php }  ?>
                                                                                                            </tbody>
                                                                                                        </table></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td height="20" colspan="3"></td>
                                                                                </tr>
                                                                            </tbody>
                                                                       </table></td>
                                                                </tr>
                                                                <tr>
                                                                  <td style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px"><?php echo strip($resultvouchersetting['policies']); ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 20px">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tbody>
															 <?php if($resultQuery['paymentMode']==2){ ?>
                                <tr>
                                  <td align="center" style="background: #fff;   color: #666;padding:10px; text-align:center; color:#F70F20; font-size:15px;" ><strong>Note</strong>: Payment need to be made directly at property</td>
                                </tr>
								<?php } ?>
                                                                <tr>
                                                                  <td style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px">&nbsp;</td>
                                                                </tr>
                                                                <tr>
                                                                    <td style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px">POINTS TO REMEMBER</td>
                                                                </tr>
                                                                <tr>
                                                                    <td valign="top" style="font: normal 14px Arial,Helvetica,sans-serif; color: #2f2f2f; padding: 15px; background: #fff">
                                                                        <?php echo $resultvouchersetting['pointsRememberText']; ?>                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td style="padding-bottom: 20px">
                                                        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="font: normal 15px Arial,Helvetica,sans-serif; padding-bottom: 8px">24/7 One Clikk Hotels Helpdesk</td>
                                                                </tr>
                                                                <tr>
                                                                    <td width="250" valign="top" style="font: normal 14px Arial,Helvetica,sans-serif; color: #2f2f2f; padding: 15px; background: #fff; width: 570px">
                                                                        <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td valign="top" width="35" style="padding: 12px 0; line-height: 1">
                                                                                        <img src="https://ci5.googleusercontent.com/proxy/cInV6aw8AmXq90Yv5yDQIc0yI5RTU-0C-TlaoFn2eib7SzE3hJyBzr6rgRITMlDrBUJ7SM_xuC8f4s63D-t8YowMhcSIC5i0VMPW3fWTq5gI31_Wmw=s0-d-e1-ft#https://rtnlandpages.blob.core.windows.net/vouchimage/phone.jpg" alt="" style="border: 0; padding-top: 5px; display: block" class="CToWUd"></td>
                                                                                    <td valign="middle" width="95%" style="padding-left: 10px; border-bottom: solid 1px #e3e3e3">
                                                                                        <?php echo $resultvouchersetting['phone']; ?>                                                                                    </td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td valign="top" width="35" style="padding: 12px 0; line-height: 1">
                                                                                        <img src="https://ci6.googleusercontent.com/proxy/nVQKc1aq6ptMfHZaKvfL_YBbcACNMPbWnOyXf2Ntc2SHsbBoBzU_-vRUk4J_HuEskO-PS3-cQEjtX9V6bnQuv0Tq555VA6DI3KYuPOMVXqhETEQuFQ=s0-d-e1-ft#https://rtnlandpages.blob.core.windows.net/vouchimage/email.jpg" alt="" style="border: 0; padding-top: 5px; display: block" class="CToWUd"></td>
                                                                                    <td valign="middle" width="95%" style="padding: 16px 10px; border-bottom: solid 1px #e3e3e3"><?php echo $resultvouchersetting['email']; ?></td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td valign="top" width="35" style="padding: 8px 0 0px 2px; line-height: 1">
                                                                                        <img src="https://ci3.googleusercontent.com/proxy/tzO88b9qVYHE0mt6nhRHZwMlMSYJvDVPQ7ZGXAvmoe_z4zShNiV3D74nMO9i3Uc013VcpHCRRTLo1MbZWjHrOn6SCMnYRMeWBN6UmpIj99bVUF8S8w=s0-d-e1-ft#https://rtnlandpages.blob.core.windows.net/vouchimage/globe.jpg" alt="" style="border: 0; padding-top: 5px; display: block" class="CToWUd"></td>
                                                                                    <td valign="middle" width="95%" style="padding: 16px 10px; border-bottom: solid 1px #e3e3e3"><?php echo $resultvouchersetting['website']; ?></td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>                                                    </td>
                                                </tr>
                                                <tr style="background-color: #af1086">
                                                    <td width="100%" style="border-bottom: 0; padding: 10px">
                                                        <table border="0" cellpadding="0" cellspacing="0" align="left" width="100%" style="background-color: #af1086;">
                                                        </table>                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>                                    </td>
                                </tr>
                            </tbody>
                      </table>                    </td>
                </tr>
                <tr>
                  <td align="center" valign="top" style="padding-top:10px; font-size:12px; color:#666666;">Generated from travCRM</td>
                </tr>
            </tbody>
        </table>
</div>






<style>

@media print 
{
  @page { margin: 0; }
  body  { margin:0cm; }
}
</style>
<?php if($_GET['print']==1){ ?>

<script>
window.print();
</script>
<?php }
if($_REQUEST['save']==1){ 
$fileName=''.makeQueryId($resultInvoice['queryId']).'-voucher.doc';
header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
header('Content-Disposition: attachment;filename="' . $fileName . '"');
}
 ?>
</body>
</html>
