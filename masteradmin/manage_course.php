<?php 
require("inc.php");
require("common.php");
require("website_security.php");
 
//----Page Settings-----
		
$pagetitle = "Course"; 				
$backpage = "manage_course.php"; 			
$targetpage = "manage_course.php"; 			
$tableName = "courseMaster";			
$addeditpage = "add_course.php"; 				
$limit =100;
  
//----change status-----  
/*********login token start**********/
$session_token = rand(100000000000,999999999999); 
$_SESSION["cust_session_token"]=$session_token;
$actionId='_console';
/*********login token end**********/
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Manage <?php echo $pagetitle; ?> - <?php echo $profile['company']; ?></title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery-1.6.js"></script>

<script type="text/javascript" src="js/ddaccordion.js"></script>
<script type="text/javascript" src="js/js.js"></script>
</head>

<style>
.srch-field input, select {
    width: 100%;
    border: solid 1px #e7e7e7 !important;
    font-size: 12px !important;
    padding: 9px !important;
    border-radius: 2px;
    box-sizing: border-box;
    height: 35px;
}
.srch-field button {
    position: relative;
    padding: 11px 20px;
    border: 0;
    height: 35px;
    background-color: #1db055;
    color: #fff;
    border-radius: 0px 3px 3px 0;
    box-sizing: border-box;
    cursor: pointer;
}
.srch-field {
    width: 20%;
    float: left;
    overflow: hidden;
    position: relative;
    margin-right: 10px;
	margin-bottom:15px;
}
</style>

<body id="leftbgblack">
 <?php include "header.php"; ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="9%" align="left" valign="top" style="width:176px;"> <?php include "left.php"; ?>    </td>

 
	
	<td width="91%" align="left" valign="top">
	
	<div class="innerouter">
	<div class="innertitlebox">
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td width="616">
	<h3>Manage <?php echo $pagetitle; ?></h3>	</td>
    <td width="355" align="right">&nbsp; </td>
    <td width="150" align="right" style="width:150px;"><em><strong>
	<?php 			
 
if($_GET['searchkeywords']!=''){ 
$searchname = "and course_name='".$_GET['searchkeywords']."'"; 
} 
  
	$classlist=1;	 
	$query = "SELECT COUNT(*) as num FROM courseMaster where  1 ".$searchname." order by id desc ";			
  
	$total_pages = mysql_fetch_array(mysql_query($query));			
			
	echo $total_pages = $total_pages[num];			
	 		
	$stages = 3;			
			
	$page = mysql_escape_string($_GET['page']);			
			
	if($page){			
			
		$start = ($page - 1) * $limit; 			
			
	}else{			
			
		$start = 0;				
			
		}				
			
			
    // Get page data			
			
	 $query1 = "SELECT * FROM courseMaster where  1 ".$searchname." order by id desc LIMIT $start, $limit";			
			
	$result = mysql_query($query1);			
			 
	// Initial page num setup			
			
	if ($page == 0){$page = 1;}			
			
	$prev = $page - 1;				
			
	$next = $page + 1;										
			
	$lastpage = ceil($total_pages/$limit);					
			
	$LastPagem1 = $lastpage - 1;								
			 
	$paginate = '';			
			
	if($lastpage > 1)			
			
	{				
			 
		$paginate .= "<div class='paginate'>";			
			
		// Previous			
			
		if ($page > 1){			
			
			$paginate.= "<a href='$targetpage?page=$prev'>previous</a>";			
			
		}else{			
			
			$paginate.= "<span class='disabled'>previous</span>";	}			
			
			
		// Pages				
			
		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up			
			
		{				
			

			for ($counter = 1; $counter <= $lastpage; $counter++)			
			
			{			
			
				if ($counter == $page){			
			
					$paginate.= "<span class='current'>$counter</span>";			
			
				}else{			
					$searchkeywordsdata=$_GET['searchkeywords'];
					$userTypedata=$_GET['userType'];
					$paginate.= "<a href='$targetpage?page=$counter&searchkeywords=$searchkeywordsdata&userType=$userTypedata'>$counter</a>";
					 
					}								
			
			}			
			
		}			
			
		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?			
			
		{			
			
			// Beginning only hide later pages			
			
			if($page < 1 + ($stages * 2))					
			
			{			
			
				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)			
			
				{			
			
					if ($counter == $page){			
			
						$paginate.= "<span class='current'>$counter</span>";			
			
					}else{			
			
						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}								
			
				}			
			
				$paginate.= "...";			
			
				$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";			
			
				$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";					
			
			}			
			
			// Middle hide some front and some back			
			
			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))			
			
			{			
			
				$paginate.= "<a href='$targetpage?page=1'>1</a>";			
			
				$paginate.= "<a href='$targetpage?page=2'>2</a>";			
			
				$paginate.= "...";			
			
				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)			
			
				{			
			
					if ($counter == $page){			
			
						$paginate.= "<span class='current'>$counter</span>";			
			
					}else{			
			
						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}								
			
				}			
			
				$paginate.= "...";			
			
				$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";			
			
				$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";					
			
			}			
			
			// End only hide early pages			
			
			else			
			
			{			
			
				$paginate.= "<a href='$targetpage?page=1'>1</a>";			
			
				$paginate.= "<a href='$targetpage?page=2'>2</a>";			
			
				$paginate.= "...";			
			
				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)			
			
				{			
			
					if ($counter == $page){			
			
						$paginate.= "<span class='current'>$counter</span>";			
			
					}else{			
			
						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}								
			
				}			
			
			}			
			
		}			
			
				 
				// Next			
			
		if ($page < $counter - 1){ 			
			
			$paginate.= "<a href='$targetpage?page=$next'>next</a>";			
			
		}else{			
			
			$paginate.= "<span class='disabled'>next</span>";			
			
			}			
			
				 
		$paginate.= "</div>";	 
 			
}			
 			
?></strong> items </em></td>
  </tr>
</table>
	</div>
	 <div class="loading" id="globalpageloding" style="display:none;">Please Wait Working...</div>
	  <?php if($_REQUEST['action']=="add"){ ?><div class="successmsg" id="wrongloginclick" style="display:block;">Added Successfully </div> <?php } ?>
	  <?php if($_REQUEST['action']=="edit"){ ?> <div class="successmsg" id="wrongloginclick" style="display:block;">Update Successfully </div> <?php } ?>  
	  	  <?php if($_REQUEST['action']=="dlt"){ ?><div class="successmsg" id="wrongloginclick" style="display:block;">Deleted Successfully </div><?php } ?>
	  
	  <form action="manage_course.php" method="get">
		   
		  <div class="srchfcontct">
		 
		<div class="srch-field"> 
			<input type="text" name="searchkeywords" id="searchkeywords" maxlength="60" placeholder="Enter Course" autocomplete="off" value="<?php echo $_REQUEST['searchkeywords']; ?>">
		</div>
		 
		<div class="srch-field"> 
			<button type="submit" >Search</button>
		</div>
	</div>
	    </form>
	  
		 
	  <form action="" method="post">
	   <div class="optionsec">	 
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="62%" align="left" valign="middle"><a href="<?php echo $addeditpage; ?>?backpage=<?php echo $backpage; ?>&pagetitle=<?php echo $pagetitle; ?>"  onclick="globalloading();" ><input type="button" name="Submit" value="Add New" class="greenbtn" style="position: relative; padding: 3px 15px; border: 0; height: auto; background-color: #1db055; color: #fff; border-radius: 0px 3px 3px 0; box-sizing: border-box; cursor: pointer;"/></a> </td>
          <td width="38%" align="right" valign="middle"><div style=" overflow:hidden; text-align:right;">
   <?php  echo $paginate; ?>
 </div></td>
        </tr>
      </table>			
	</div>
	<div class="listingbox" style="position:relative;">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="3%" align="left" valign="top" class="listingheaddr">S.N.</td>			
           <td width="19%" align="left" valign="top" class="listingheaddr">Name</td>
           <td width="54%" align="left" valign="top" class="listingheaddr">Department </td>
           <td width="20%" align="left" valign="top" class="listingheaddr">Status </td>
           <td width="12%" align="center" valign="top" class="listingheaddr"> Date Added </td>
           <td width="12%" align="center" valign="top" class="listingheaddr">Last Modified </td>
           </tr>
        <?php  while($res_post = mysql_fetch_array($result)) { ?>
		<tr <?php if($classlist==1){ ?>style="background-color:#f7f7f7;" <?php }  else { ?>style="background-color:#FFFFFF;" <?php } ?>>
          <td align="left" valign="top" class="graylist"><?php echo $start=$start+1; ?></td>			
          			
          <td align="left" valign="middle" class="graylist"><a href="<?php echo $addeditpage; ?>?id=<?php echo $res_post['id']; ?>&backpage=<?php echo $backpage; ?>&pagetitle=<?php echo $pagetitle; ?>"  onclick="globalloading();"><?php  echo stripslashes($res_post['course_name']); ?></a></td>
          <td align="left" valign="middle" class="graylist">

		  <?php   
if($res_post['dep_name']!=""){ 
$myArraynew = explode(',', $res_post['dep_name']);  
foreach($myArraynew as $my_Array){  
$query1kkk = mysql_query("SELECT department_name FROM departmentMaster where  1 and id='$my_Array'");	 
$resultkkk = mysql_fetch_array($query1kkk); 
?> 
<span style="width: 100%; display: inline-block; margin-bottom: 2px;"><?php echo $resultkkk['department_name']; ?></span> 
<?php 
} }
?>
</td>
<td align="left" valign="left" class="graylist"><?php  echo ($res_post['status']==1) ? "Active" : "Inactive" ?></td>
          <td align="center" valign="middle" class="graylist"><?php  echo date('d/m/Y H:i:s',$res_post['dateAdded']); ?></td>
          <td align="center" valign="middle" class="graylist"><?php  echo date('d/m/Y H:i:s',$res_post['modifyDate']); ?></td>
          </tr>
		<?php $classlist=$classlist+1; if($classlist==3){ $classlist=1; } } ?>
      </table>
	  <div id="confdlt" style="display:none;">			
	  <div align="left" style="font-size:18px; line-height:25px; margin-bottom:10px;"><img src="images/-trash.png" width="50" height="50"  style="float:left; padding-right:10px;"/>Do you want to permanently 			
	    delete the selected  items?</div>			
		<div style="text-align:center;">			
		  <input name="Submit2" type="submit" class="redbutton" value="  Yes  "  onclick="globalloading();"/>			
		  <input name="Submit22" type="button" class="gradiantbtn" value="  No  " onclick="closeconfirmdlt();" />			
		</div>			
	</div>
	  <?php if($total_pages==0){ ?>
	  <div style="padding:10px; background-color:#FFFFFF; text-align:center; color:#CCCCCC;"><em>No Item</em></div>
	  <?php } ?>
	</div>
	 
	<div class="optionsec">
	  <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="62%" align="left" valign="middle"><a href="<?php echo $addeditpage; ?>?backpage=<?php echo $backpage; ?>&pagetitle=<?php echo $pagetitle; ?>"  onclick="globalloading();" ><input type="button" name="Submit" value="Add New" class="greenbtn" style="position: relative; padding: 3px 15px; border: 0; height: auto; background-color: #1db055; color: #fff; border-radius: 0px 3px 3px 0; box-sizing: border-box; cursor: pointer;"/></a> </td>
          <td width="38%" align="right" valign="middle"><div style="  overflow:hidden; text-align:right;">
            <?php  echo $paginate; ?>
          </div></td>
        </tr>
      </table>
	</div>
		</form>
	</div>	</td>
  </tr>
</table>

 
 
 <?php include "footer.php"; ?>
</body>
</html>
