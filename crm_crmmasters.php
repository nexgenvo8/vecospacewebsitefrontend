<link href="css/main.css" rel="stylesheet" type="text/css" />
<div class="rightsectionheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td><div class="headingm"><?php echo $pageName; ?></div></td>
    <td align="right"><table border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td><select name="select" class="topdropdown">
          <option value="Active Users">Active Users</option>
          <option value="Active Users">Inactive Users</option>
          <option value="Active Users">Deleted Users</option>
        </select>
        </td>
        <td><input type="button" name="Submit" value="Import" class="whitembutton" /></td>
        <td style="padding-right:20px;"><input name="deactivatebtn" type="button" class="redmbutton" id="deactivatebtn" value="Deactivate"  style="display:none;" /><input name="addnewuserbtn" type="button" class="bluembutton" id="addnewuserbtn" value="+ Add New User" /></td>
      </tr>
      
    </table></td>
  </tr>
  
</table>
</div>

<div id="pagelisterouter">
<table border="0" cellpadding="0" cellspacing="0" class="tablesorter gridtable">

   <thead>

   <tr>
     <th width="68" align="center" class="header" style="width:20px;">&nbsp;</th>

     <th width="27" align="center" valign="middle" class="header" ><input type="checkbox" id="checkAll"  name="checkedAll"  onclick="checkallbox();" />
    <label for="checkAll"><span></span>&nbsp;</label></th>
     <th width="174" align="center" class="header" >User ID 	</th>

    <th width="189" align="left" class="header sortingbg">Company Name </th>

    <th width="187" align="center" class="header sortingbg">users</th>
    <th width="141" align="center" class="header sortingbg">Status</th>

    <th width="158" align="left" class="header sortingbg">expired on </th>

    <th width="169" align="left" class="header sortingbg">created date </th>

    <th width="73" align="left" class="header" style="width:50px;">&nbsp;</th>
    </tr>
   </thead>

 


 

  <tbody><tr>
    <td align="center"><img src="images/editicon.png" class="editicon" /></td>

    <td align="center" valign="middle"><input type="checkbox" id="c1" name="cc" class="chk" />
    <label for="c1"><span></span>&nbsp;</label></td>
    <td align="center">&nbsp;</td>

    <td align="left">  </td>

    <td align="center">&nbsp;</td>
    <td align="center"> 	 </td>

    <td align="left">Outgoing</td>

    <td align="left">K.. SRINIVASAN</td>

    <td align="left"style="width:50px;">&nbsp;</td>
    </tr> 
 

  <tr>
    <td align="center"><img src="images/editicon.png" class="editicon" /></td>

    <td align="center" valign="middle"><input type="checkbox" id="c2" name="cc"  class="chk" />
    <label for="c2"><span></span>&nbsp;</label></td>
    <td align="center">&nbsp;</td>

    <td align="left">  </td>

    <td align="center">&nbsp;</td>
    <td align="center"> 	 </td>

    <td align="left">Outgoing</td>

    <td align="left">K.. SRINIVASAN</td>

    <td align="left"style="width:50px;">&nbsp;</td>
    </tr> 
</tbody></table><div class="pagingdiv">

		

		<table width="100%" border="0" cellpadding="0" cellspacing="0">

  <tbody><tr>

    <td><table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td style="padding-right:20px;">1588 entries</td>
    <td><select name="currentOption" id="currentOption"  class="lightgrayfield">   <option value="10" selected=""> 10 Records Per Page </option>  <option value="20"> 20 Records Per Page </option>  <option value="30"> 30 Records Per Page </option>  <option value="40"> 40 Records Per Page </option>  <option value="50"> 50 Records Per Page </option>  </select></td>
  </tr>
  
</table>
</td>

    <td align="right"><div class="pagingnumbers"><div class="paginate"><span class="disabled">Previous</span><span class="current">1</span><a href="http://crm.bonton-holidays.com/calls.php?search=&amp;records=&amp;datefrom=&amp;enddate=&amp;followupdate=&amp;region=&amp;assign_to=&amp;status=&amp;directiontype=&amp;leadsource=&amp;campaign=&amp;page=2">2</a><a href="http://crm.bonton-holidays.com/calls.php?search=&amp;records=&amp;datefrom=&amp;enddate=&amp;followupdate=&amp;region=&amp;assign_to=&amp;status=&amp;directiontype=&amp;leadsource=&amp;campaign=&amp;page=3">3</a><a href="http://crm.bonton-holidays.com/calls.php?search=&amp;records=&amp;datefrom=&amp;enddate=&amp;followupdate=&amp;region=&amp;assign_to=&amp;status=&amp;directiontype=&amp;leadsource=&amp;campaign=&amp;page=4">4</a><a href="http://crm.bonton-holidays.com/calls.php?search=&amp;records=&amp;datefrom=&amp;enddate=&amp;followupdate=&amp;region=&amp;assign_to=&amp;status=&amp;directiontype=&amp;leadsource=&amp;campaign=&amp;page=5">5</a><a href="http://crm.bonton-holidays.com/calls.php?search=&amp;records=&amp;datefrom=&amp;enddate=&amp;followupdate=&amp;region=&amp;assign_to=&amp;status=&amp;directiontype=&amp;leadsource=&amp;campaign=&amp;page=6">6</a><a href="http://crm.bonton-holidays.com/calls.php?search=&amp;records=&amp;datefrom=&amp;enddate=&amp;followupdate=&amp;region=&amp;assign_to=&amp;status=&amp;directiontype=&amp;leadsource=&amp;campaign=&amp;page=7">7</a><a href="http://crm.bonton-holidays.com/calls.php?search=&amp;records=&amp;datefrom=&amp;enddate=&amp;followupdate=&amp;region=&amp;assign_to=&amp;status=&amp;directiontype=&amp;leadsource=&amp;campaign=&amp;page=8">8</a><a href="http://crm.bonton-holidays.com/calls.php?search=&amp;records=&amp;datefrom=&amp;enddate=&amp;followupdate=&amp;region=&amp;assign_to=&amp;status=&amp;directiontype=&amp;leadsource=&amp;campaign=&amp;page=9">9</a>...<a href="http://crm.bonton-holidays.com/calls.php?search=&amp;records=&amp;datefrom=&amp;enddate=&amp;followupdate=&amp;region=&amp;assign_to=&amp;status=&amp;directiontype=&amp;leadsource=&amp;campaign=&amp;page=63">63</a><a href="http://crm.bonton-holidays.com/calls.php?search=&amp;records=&amp;datefrom=&amp;enddate=&amp;followupdate=&amp;region=&amp;assign_to=&amp;status=&amp;directiontype=&amp;leadsource=&amp;campaign=&amp;page=64">64</a><a href="http://crm.bonton-holidays.com/calls.php?search=&amp;records=&amp;datefrom=&amp;enddate=&amp;followupdate=&amp;region=&amp;assign_to=&amp;status=&amp;directiontype=&amp;leadsource=&amp;campaign=&amp;page=2">Next</a></div></div></td>

  </tr>

</tbody></table>



		</div>
</div>
<script>
if($('.chk:checkbox:checked').length > 0){
$('#addnewuserbtn').hide();
$('#deactivatebtn').show();
} else {
$('#addnewuserbtn').show();
$('#deactivatebtn').hide();
}


comtabopenclose('linkbox','op4');
</script>