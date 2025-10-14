<?php if($jcarousellite!=1){?>
<script src="<?php echo $fullurl;?>js/jcarousellite_1.0.1.js"></script>
<?php }?>
<div class="hm_right_sec">
	<div class="birth-notice">
		<div class="birth-namecont">
			
			<div class="birthcont"><div class="img">
				<img src="https://www.konectt.com/demo/uploads/1504015941myfbphoto.jpg">
			</div>
			<div class="birth-nm">
				<h2>Rahseed Birthday!</h2>
				<span>Web developer  - at SCG India</span>
				
			</div>
			</div>
			<p>Leave a message  with your best wishes!</p>
			<a href="#" class="send-wish">Send Message</a>
		</div>
	</div>
 <!--<div class="right-box-cont" style="display: none;">
	<h2>Invite people to <strong>Konectt</strong></h2>
	<form enctype="multipart/form-data" name="frmposthome4" id="frmposthome4" method="post" target="actionfrm" action="<?php echo $fullurl;?>common_action.php">
	<div class="invitation">
		<input type="hidden" name="action" value="sendinvitation">
		<input type="email" name="txtuseremail" id="txtuseremail" maxlength="60" placeholder="Enter email address" class="validate" onKeyUp="hideerrordiv(this.id);">
		<button type="button" onClick="formValidation('frmposthome4');subsrchfrm2();"><i class="fa fa-paper-plane" aria-hidden="true"></i> Send Invitation</button>
	</div>
	</form>
	<script>	
 function subsrchfrm2(){
   
   		 if($("#txtuseremail").val()!='')
		 {
			$("#frmposthome4").submit();
		 }
   }
   
   	$("input").keypress(function(event) {
  
    if (event.which == 13) {
        event.preventDefault();
       	   
	    if($("#txtuseremail").val()!='')
		{
			$("#frmposthome4").submit();
		}
    }
});
	  
	  </script>
</div>-->

<div class="invite-frnd-cont">
	<img src="<?php echo $fullurl; ?>images/invite-icon.png">
	<h1>
		Invite People to <font color="#1a94c3">Konectt</font>
	</h1>
	<div class="invite-yourfrnd">
		<p>Invite your friends and your family members</p>
		<a onclick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=invitepeople','Invite people');" class="invifrnd">Invite Now</a>
	</div>
</div>

<div class="right-box-cont">
	<div class="suggest-box">
		<h2>Articles and Trivia</h2>
		<ul class="trending-list">
		 <?php 
   	$selectFields =[];
	$whereFields =[];
	$whereVals =[];
	
	$sqlViewArticle2="";
	$sqlViewArticle2="SELECT userId,id,postTitle,postText from "._SHAREANDUPDATES_TABLE_."  WHERE postType=3 and postTitle!='' ORDER BY id DESC LIMIT 0,3 ";
	$resViewArticle2=getRecords(_SHAREANDUPDATES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlViewArticle2); 	
	if($resViewArticle2)
	{
		while($rowViewArticle2=mysqli_fetch_array($resViewArticle2))
		{
		
			$a2="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= ".$rowViewArticle2["userId"]."";
			$b2=mysqli_query($conn, $a2) or die(mysqli_error($conn)); 
			$userres2=mysqli_fetch_array($b2);
			  if($userres2["profilePhoto"]!=''){
			  $profilePhoto=$userres2["profilePhoto"];
			  } else {
			  $profilePhoto='user-placeholder.jpg';
			  }
   ?>
			<li style="cursor:pointer;" onclick="window.location.href = '<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowViewArticle2['id']); ?>';">
			<div class="artcl-img"><img src="<?php echo $fullurl;?>uploads/<?php echo $profilePhoto; ?>"></div>
				<a class="ttle"><?php echo substr((stripslashes(trim($rowViewArticle2["postTitle"]))),0,50);?></a>
				<span class="desc"><?php echo substr(strip_tags(stripslashes(trim($rowViewArticle2["postText"]))),0,60);?></span>
				<span class="nm">By <?php echo stripslashes(trim($userres2["firstName"]));?> <?php echo stripslashes(trim($userres2["lastName"]));?></span>
			</li>
	<?php
	 	}
	}	

?>		
		</ul>
	</div>
</div>
<div id="trend">
<div class="advrtise">
	<div class="add"><img src="<?php echo $fullurl;?>images/rightad.PNG"></div>
</div>
<div class="right-fttr">
	<ul class="fttr-list">
		 <li><a href="<?php echo $fullurl;?>privacy.html">Privacy</a></li>
		 <li><a href="<?php echo $fullurl;?>terms.html">Terms</a></li>
		 <li><a href="<?php echo $fullurl;?>about.html">About</a></li>
		 <li><a href="<?php echo $fullurl;?>faq.html">FAQ's</a></li> 
	</ul>
	<p> &copy; <?php echo date("Y");?> The copyright is OMSR Media Pvt. Ltd.</p>
</div>
</div>

  </div>

<script type="text/javascript">
	$(window).scroll(function() {
	    if ($(this).scrollTop() > 515){
	        $("#trend").addClass("fixed");
	    }
	    else{
	        $("#trend").removeClass("fixed");
	    }
	});

</script> 