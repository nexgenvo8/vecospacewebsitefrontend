<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session

	$countinterest=1;
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$sqlLogin="";
	$sqlLogin="select id from "._INTERESTS_TABLE_." where userId='".$_SESSION['sessUserId']."' ";
	$resLogin=getRecords(_INTERESTS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlLogin); 	
	if($resLogin)
	{ 
		while($row=mysql_fetch_array($resLogin))
		{
			$countinterest=$countinterest+1;
		}
	}


?>

<h3>Interests</h3><a class="add_btn" onClick="$('#editinterest').show();$('#defaultinterest').hide();addnewinterest(<?php echo $countinterest;?>,100);$('#interestcontentboxs').hide();"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add</a>
               
			   <?php if($countinterest==1){?>
			    <div class="add_more" id="defaultinterest">
                  <h4>What do you like to do outside of work?</h4>
                  <span>What are your hobbies, interests and leisure activities?</span>
                 <span class="addmore_icon" onClick="$('#editinterest').show();$('#defaultinterest').hide();addnewinterest(<?php echo $countinterest;?>,100);$('#interestcontentboxs').hide();"> <i class="fa fa-plus-circle" aria-hidden="true"></i></span>
                </div>
				<?php }else{?>
				
				<div class="intrs-list" id="interestcontentboxs">
            <ul class="list"  onClick="$('#editinterest').show();$('#defaultinterest').hide();addnewinterest(<?php echo $countinterest;?>,100);$('#interestcontentboxs').hide();" style="cursor:pointer;">
			  <?php
					 
	$countinterest=1;
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$sqlLogin="";
	$sqlLogin="select * from "._INTERESTS_TABLE_." where userId='".$_SESSION['sessUserId']."' order by interestText asc ";
	$resLogin=getRecords(_INTERESTS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlLogin); 	
	if($resLogin)
	{
		while($row=mysql_fetch_array($resLogin))
			{
					 ?>
              <li><?php echo sanitizedboutput($row["interestText"]);?></li>
			  <?php
			  }
			 }
			  ?>
            </ul></div>	
           
				<?php }?>
			 
				
                <div class="edit_box" id="editinterest" style="display:none;">
                  <form class="edit-layer" method="post" target="actionfrm" action="<?php echo $fullurl;?>common_action.php"> 
                    <h2>Edit interest on <?php echo $companNameTitle;?></h2>
                    <a onClick="$('#editinterest').hide();$('#defaultinterest').show();$('#interestcontentboxs').show();"class="close"><i class="fa fa-times" aria-hidden="true"></i></a>
                    <ul> 
                     <?php
					 
	$countinterest=1;
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$sqlLogin="";
	$sqlLogin="select * from "._INTERESTS_TABLE_." where userId='".$_SESSION['sessUserId']."' order by interestText asc ";
	$resLogin=getRecords(_INTERESTS_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlLogin); 	
	if($resLogin)
	{
		while($row=mysql_fetch_array($resLogin))
			{
					 ?>
					 
					 <li id="newinterestli<?php echo $countinterest; ?>"><input type="text" id="newinterest<?php echo $countinterest; ?>" name="check_list[]" value="<?php echo sanitizedboutput($row["interestText"]);?>" placeholder="Add new interest and experience" onKeyUp="addnewinterest(Number(<?php echo $countinterest; ?>+1),100);">
				 
					 <a onClick="removeinterest(Number(<?php echo $countinterest; ?>));" class="remove" >-</a>
					 </li>
					 <?php
					$countinterest=$countinterest+1;
					}
					 }
					 ?>
					 
                    </ul>
					<input type="hidden" name="addinterestaction" id="addinterestaction" value="add">
					<div class="submit-now">
                      <button type="button" class="cancel" onClick="loadinterest();">cancel</button>
                      <button type="submit">Save</button>
                    </div>
                  </form>
                    
                </div>
				
 <script>
 function addnewinterest(id,limt)
{
	var id=Number(id);
	var limt=Number(limt);
	
if( $('#newinterest'+id).length || limt<id) 
{
 
	
	} else {


var displayremove = '<a onClick="removeinterest('+Number(id)+');" class="remove" >-</a></li>';			

	
$('#editinterest ul').append('<li id="newinterestli'+id+'"><input type="text" id="newinterest'+id+'" name="check_list[]" placeholder="Add new interest and experience" onKeyUp="addnewinterest('+Number(id+1)+',100);">'+displayremove);		
}
}



function removeinterest(id)
{
$("#newinterestli"+id).remove();	
}

 
 </script>