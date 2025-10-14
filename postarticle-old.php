<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session

if($_POST['articleTitle']!='')
{
		
		unset($insertFields);
		unset($insertVals);					
		
		$insertFields[0]="userId";
		$insertFields[1]="postTitle"; 
		$insertFields[2]="postText";
		$insertFields[3]="postType";
		$insertFields[4]="shareType";
		$insertFields[5]="dateAdded";
	
		$insertVals[0]=$_SESSION["sessUserId"];
		$insertVals[1]=normalclean($_POST['articleTitle']);
		$insertVals[2]=normalclean($_POST['articleDetails']);
		$insertVals[3]='3';
		$insertVals[4]=1;;
		$insertVals[5]=time();
		
		$whereFields[0]="id";
		$whereFields[1]="userId";
		
		$whereVals[0]=clean($_REQUEST['articleId2']);
		$whereVals[1]=$_SESSION['sessUserId'];
		
		$resUpdate=updateDB(_SHAREANDUPDATES_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,''); 
		
		if($resUpdate)
		{
			
			//$postId=$resUpdate;
			unset($insertFields);
			unset($insertVals);					
			
			$insertFields[0]="userId";
			$insertFields[1]="postId"; 
			$insertFields[2]="postType";
			$insertFields[3]="shareType";
			$insertFields[4]="dateAdded";
		
			$insertVals[0]=$_SESSION["sessUserId"];
			$insertVals[1]=clean($_REQUEST['articleId2']);
			$insertVals[2]='3';
			$insertVals[3]='1';
			$insertVals[4]=time();
		
			$resUpdate=insertDB(_TIMELINE_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
			

			
			header("Location:".$fullurl."timeline.html");
			exit();

		}
		
		
		

}



$sql_ins="DELETE FROM "._SHAREANDUPDATES_TABLE_." WHERE userId= ".$_SESSION["sessUserId"]." AND postType=0 ";
mysqli_query($conn,$sql_ins) or die(mysqli_error($conn)); 


$sql_ins="INSERT INTO "._SHAREANDUPDATES_TABLE_." SET userId= ".$_SESSION["sessUserId"]."";
$resresult2=mysqli_query($conn,$sql_ins) or die(mysqli_error($conn)); 


$sql_inss="SELECT id from "._SHAREANDUPDATES_TABLE_." WHERE userId= ".$_SESSION["sessUserId"]." AND postType=0";
$resresults=mysqli_query($conn,$sql_inss) or die(mysqli_error($conn)); 
$rowResults=mysqli_fetch_array($resresults);
$postId=$rowResults["id"];




?>

<!DOCTYPE html>
<html>
<head>
<title>Post Article</title>
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/style.css">
<script src="<?php echo $fullurl;?>js/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<script language="JavaScript" type="text/javascript" src="<?php echo $fullurl;?>ckeditor/ckeditor.js"></script>
<script language="JavaScript" type="text/javascript" src="<?php echo $fullurl;?>ckeditor/ckfinder/ckfinder.js"></script>
<script src="<?php echo $fullurl;?>js/main.js"></script>

<!--<script type="text/javascript">
   	CKEDITOR.replace( 'articleDetails', {
	toolbar: [
		{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		[ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
		'/',																					// Line break - next group will be placed in new line.
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] }
	]
});
</script>-->
</head>
<body style="background:none;">
<div class="article">
  <div class="artcl-head">
    <div class="logo"><a href="<?php echo $fullurl;?>timeline.html"><img src="<?php echo $fullurl;?>images/logo.jpg"></a></div>
    <div class="artcle-btn">
      <div class="more-btn"><a class="mr">More <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
        <ul class="more-list">
          <li><a href="#">Start a new article</a></li>
          <li><a href="#">Draft</a></li>
          <li><a href="#">Article</a></li>
          <li class="help"><a href="#">Help center</a></li>
        </ul>
      </div>
      <div class="publish"><a onClick="postarticle();">Publish</a></div>
    </div>
  </div>
  <form name="frmposthomeimg" id="frmposthomeimg"  method="post" enctype="multipart/form-data" style=" position:relative;" target="actionfrm" action="<?php echo $fullurl;?>common_action.php">
 <div class="upload-sec"> <div class="artcle-txt"><div id="loadimagdiv"> <input name="imagefilehome" id="imagefilehome" type="file"  onChange="$('#frmposthomeimg').submit();" style="    position: absolute;
    left: 28%;
    top: 60px;
    width: 43%;
    height: 268px;
	opacity:0;
    filter: alpha(opacity=0);
    margin: auto; cursor:pointer;">
  <img src="<?php echo $fullurl;?>images/upload.png">
 
    <h3>Add a article image</h3>
    <span>Image that are at least 600x350 pixels look best</span> </div></div></div>
	<input type="hidden" id="uploadarticleimg" name="uploadarticleimg" value="1">
	<input type="hidden" id="articleId" name="articleId" value="<?php echo encodeStr($postId); ?>">
	<input type="hidden" id="addeditpost" name="addeditpost" value="add">
	</form>
	
  
    <form name="frmposthome" id="frmposthome" class="txt-form" method="post" enctype="multipart/form-data">
	 
	<input name="imagefilehome" id="imagefilehome" type="file" onChange="$('#frmposthome').submit();" style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); ">
	
      <input type="text" name="articleTitle" id="articleTitle" placeholder="Write your headline">
      <textarea rows="4" name="articleDetails" id="articleDetails" placeholder="Start writing"></textarea>
	  
	<input type="hidden" id="articleId2" name="articleId2" value="<?php echo $postId; ?>">
	  <script type="text/javascript">
	                var editor = CKEDITOR.replace('articleDetails');
					CKFinder.setupCKEditor( editor,'<?php echo $fullurl;?>' ) ;
                </script>
    </form>
  </div>
</div>
<script type="text/javascript">
  $('.more-btn a.mr').click(function(event){
    event.stopPropagation();
});

$('html').click(function() {
  $('.more-list').hide(); 
});
$('.more-btn a.mr').click(function(event){
    $('.more-list').toggle();
});

function postarticle()
{
	//alert();
	document.getElementById("frmposthome").submit();
} 

</script>
<iframe name="actionfrm" id="actionfrm" style="display:none;"></iframe>
</body>
</html>
