<?php
include_once('inc.php'); 
$_SESSION['loginredirectpageurl']= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
include_once('config/session-check.inc.php'); // check user login session
$pageIndex=27;
$bss=$_REQUEST['msgchatId'];
$userId= decodeStr($bss);

?>
<!DOCTYPE html>
<html>
<head>
<title>My Contacts - <?php echo $companyname;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/style.css">
<link rel="icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta content="en" name="language">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<script src="<?php echo $fullurl;?>js/jquery.min.js"></script>
<script src="<?php echo $fullurl;?>js/main.js"></script>

</head>
<body>
  <div id="wrapper" class="">
    <?php include ('header.php');?>
	  <div class="container main">
	    <div class="home_container">
		  <?php include ('left-sidebar.php');?>
		   <div class="center_content"> 
			<div class="pnding-contct" id="msgchatguide">
              <div>
			 <?php
			  unset($selectFields);
		      unset($whereFields);
		      unset($whereVals);
				
			    $a="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= ".$userId."";
				$b=mysqli_query($conn,$a) or die(mysqli_error($conn)); 
				$userres=mysqli_fetch_array($b); 
				
				$friendnameurl=$userres['userurl'];
				if($userres["profilePhoto"]!='')
				{
				$userphoto=$userres["profilePhoto"];
				} else {
				$userphoto='user-placeholder.jpg';
				}
		?>      
		       <?php
			   if($userres['userstype']==1){
			   ?>
			   <div><p class="chatmessagetagline">GUIDE YOUR MENTEES</p></div><?php }else{?>
			   <div><p class="chatmessagetagline">TAKE GUIDANCE FROM YOUR MENTOR</p></div><?php }?>
			    <div class="userchatdiv">
			     <div class="userprofilediv1"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($userphoto));?>"></div> 
				  <div class="userdetailnewwise">
				  <p class="userfntsize"> 
				    <span>
					  <a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($userres['userId']);?>/<?php echo $userres['userurl'];?>.html">
					  <?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["firstName"]);?> <?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["lastName"]);?>
					   </a>
					</span>
				  </p>
				  <p><?php echo $userres['coursename'];?> <?php echo $userres['departmentname'];?>,Student</p>
				  <p><?php echo $userres['companyName'];?></p>
				  </div>
				  <div class="rightrighticonmsg">
				   <img src="images/checkednew.png">
				  </div>
			    </div>
				<div class="userchatmessage" id="userchatmessage">
				 <div class="chawithmnteediv">
			      <span>Chat With Mentees</span>
				 
				 </div>
				  <div class="userallchattext">
				  <div class="chatmessageboxscrl" id="loadstmtchat">
				  
				  </div>

				  <div id="loadstmtchat1" style="display:none"></div>
					 <div class="useractiondivnew">
						 <div class="inputmaessasetext">
						 <input type="text" placeholder="Type Here" id="sendchat1" onclick="$('#selectbuttons').hide();" >
						 <ul class="ulemojistyle">
						  <li class="emogi" style="margin-left:10px !important;">
						   <a href="javascript:void(0)" class="emoji-toggle" onClick="$('.emoji-list').show()"><i style="font-size:19px;"class="fa fa-smile-o" aria-hidden="true" id="emogilist"></i></a>
						    <div>
							   <ul class="emoji-list">
								<?php include('smily.php');?>
							   </ul>
                            </div>	
                           <div>							
							   <form class="edit-layer" enctype="multipart/form-data" name="frmpoststmt" id="frmpoststmt" method="post" target="actionfrm" action="<?php echo $fullurl;?>common_action.php"> 
							   <span id="hpotostmtid">
								 <input name="stmtattachedfile" id="stmtattachedfile" type="file"  onChange="uploadstmtfilesfun();" style="display:none;" accept="image/x-png,image/gif,image/jpeg,application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf">
							   </span>
								<input type="hidden" name="action" id="action" value="stmtattachedmsg" />
								<input type="hidden" name="stmtchatuserid" id="stmtchatuserid" value="" />
								<input type="hidden" name="loadmsgp" id="loadmsgp" value="0" />
							   </form> 
							   <script>
								function uploadstmtfilesfun()
								{
								  $('#frmpoststmt').submit();
								  $('#commonloader').show();
								  
								 var hpotostmtid = $('#hpotostmtid').html();
								 
								  $('#stmtattachedfile').remove();
								  $('#hpotostmtid').html(hpotostmtid);
								  
								}
								</script>
							</div>
						   </li>
						 </ul>
						 </div>
						
						 <div class="uploadsendmassaction">
						   <div class="buttonuploadphodd">
							<a id="stmtattachedbutton"><div class="buttondivuplodphoto" ><i class="fa fa-file-image-o"></i><span>Upload Photo </span></div></a> 
						   </div>
						   <div class="sendmessaagepost">
							<button id="postbuttonchat" onClick="postsmchat();">Post</button>
						   </div>
						   <input type="hidden" name="smpostid" id="smpostid" value="<?php echo $bss;?>">
						 </div>
				     </div>
				  </div>
				</div>
			  </div>
		     </div>
		   </div>	
	    </div>  
      </div>
  </div>
   <script>
	    $("#loadstmtchat").load('load_stmtchat.php?stmtId=<?php echo $bss;?>');
   </script>
    <script>
		<?php if($_SESSION['sesssetpressenter']==2){?>
		$('#sendpressenter').hide();$('#sendbuttonchat').show();$('#selectbuttons').hide();
		<?php }else{?>
		$('#sendpressenter').show();$('#sendbuttonchat').hide();$('#selectbuttons').hide();
		<?php }?>

		<?php  if($mobile=='y'){?>
		$('#sendpressenter').hide();$('#sendbuttonchat').show();$('#selectbuttons').hide();
		<?php }?>
	  </script>
  <script>
  /*$("#chatfieldfooter").keypress(function(e) {
		if(e.which == 13) {
		var setpressenter = $('input[name=setpressenter]:checked').val();
		if(setpressenter==1)
		{	
			var id = $('#chatuserid').val();
			typeandsendchat(id);
			e.preventDefault();
		}
		}
	});*/
		$("#sendchat1").keypress(function(e) {
			if(e.which == 13) {
			
			var setpressenter = $('input[name=setpressenter]:checked').val();
			
			if(setpressenter==1)
			{
				var id = $('#smpostid').val();
				typesmchat(id);
				e.preventDefault();
			 }
			}
		});
		
		function postsmchat()
		{
			var id = $('#smpostid').val();
			typesmchat(id);
		}
		
		function typesmchat(id){
			var sendchat1 = $('#sendchat1').val();
			
			sendchat1 = encodeURIComponent($.trim(sendchat1));
			
			if(sendchat1!='' && id!=''){
				
				$('#loadstmtchat').load('<?php echo $fullurl; ?>load_studentmentorchat.php?action=chat&stmtId='+id+'&text='+sendchat1);
				$("#sendchat1").focus();
			}						
			$("#sendchat1").val('');

		}
		$('#stmtattachedbutton').click(function(){
			$('#stmtattachedfile').click();	
			var stmtchatuserid=$('#smpostid').val(); 
			$('#stmtchatuserid').val(stmtchatuserid); 
		});	
  </script>
<?php include ('footer.php');?>
</body>
</html>
