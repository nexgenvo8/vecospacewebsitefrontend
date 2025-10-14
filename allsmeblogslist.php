<?php
include_once('inc.php'); 
$pageIndex=12;

?>
<!DOCTYPE html>
<html>
<head>
<title>SME Post - <?php echo $companNameTitle;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/style.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/smallnav.css">

<link rel="icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<script src="<?php echo $fullurl;?>js/jquery.min.js"></script>
<script src="<?php echo $fullurl;?>js/main.js"></script>

<script type="text/javascript">
	$(window).scroll(function() {
    if ($(this).scrollTop() > 150){
        $(".write-cont").addClass("fixed");
    }
    else{
        $(".write-cont").removeClass("fixed");
    }
});
</script>
<style>

.newarticlebox { 
    height: 360px !important; 
}
</style>
</head>
<body>
<div id="wrapper" class="active">
  <?php include('header.php');?>
  <div class="container main">
    <div class="premium_tag"><a href="#">Go Premium</a>
      <p id="typewriter"></p>
    </div>
    <div class="home_container">
      <?php include('left-sidebar.php');?>
      <div class="center_content <?php if($_SESSION["sessUserId"]!='' && $_SESSION["sessUserId"]!=0){ }else { echo 'nologin'; }?>">
      <div class="write-cont">
      	<h2>SME Post </h2>
      	
      </div>

<div class="trivia-shdow">

<div class="artcle">
<div class="cntr_cntnt popular" style="width:100%<?php if($_SESSION["sessUserId"]!='' && $_SESSION["sessUserId"]!=0){ }else { echo '!important'; }?>;">
<h2>Short and relevant News and Insights for SMEs</h2>

<div class="popular-artcle1">
<?php $nn=1;
   	$selectFields =[];
	$whereFields =[];
	$whereVals =[];
	$articlephotoltst1="";
	$sqlViewArticle="";
	$sqlViewArticle="SELECT * from "._SHAREANDUPDATES_TABLE_." WHERE  postTitle!='' and status=1 and articleBlogStatus=1 order by id desc LIMIT 0,20";
	$resViewArticle=getRecords(_SHAREANDUPDATES_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlViewArticle); 	
	if($resViewArticle)
	{
		while($rowViewArticle=mysqli_fetch_array($resViewArticle))
		{
		
			$a="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= ".$rowViewArticle["userId"]."";
			$b=mysqli_query($conn, $a) or die(mysqli_error($conn)); 
			$userres=mysqli_fetch_array($b); 
			
			$aimg="select * from "._IMAGE_MASTER_TABLE_." where postId=".$rowViewArticle['id']." and imageType=3";
			$bimg=mysqli_query($conn, $aimg) or die(mysqli_error($conn)); 
			$rowimg=mysqli_fetch_array($bimg); 
			
			if($rowimg['imageName']!='')
			{
				$articlephoto=$rowimg['imageName'];
			} else {
				$articlephoto='articleicon.png';
			}
		
   ?>
	<a href="<?php echo $fullurl; ?>view-sme-blog.html?postId=<?php echo encodeStr($rowViewArticle['id']); ?>">
	<div class="artcle-boxp">
		<div class="img-box" style="background-image: url(<?php echo $fullurl;?>uploads/<?php echo str_replace(' ','%20',$articlephoto); ?>);"></div>
		<div class="artcle-boxp-ttl">
			<strong><?php echo (strip_tags(stripslashes($rowViewArticle["postTitle"]))); ?></strong>
			<div class="art-name">
				by <?php echo stripslashes(trim($userres["firstName"]));?> <?php echo stripslashes(trim($userres["lastName"]));?> -  <?php echo makedatetime($rowViewArticle["dateAdded"]); ?>
			</div>
		</div>
	</div>
	</a>
	 <?php $nn++;}   } ?>
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
  </div>
  <?php include('footer.php');?>
</div>
<style>
.popular-artcle1 .artcle-boxp {
    width: 23%;
    float: none;
    margin-right: 19px;
    display: inline-block;
	    margin-bottom: 30px;
}
</style>
</body>
</html>
