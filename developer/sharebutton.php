<?php
include_once('inc.php'); 
 
$url=$_REQUEST['url'];
$btnsize=$_REQUEST['btnsize'];
$showshare=$_REQUEST['showshare'];
?>
<html>
<link href="css/sharebtn.css" rel="stylesheet" type="text/css" />
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center">
	<a href="https://www.connecwrk.com/platform/share.html?u=<?php echo $url; ?>" target="_blank" style="display:inline-block">
	
	
	<?php if($btnsize==1 && $showshare==1){ ?>
	<div class="smallwithshare"><div class="icon"></div><div class="text">Share</div></div>
	 <?php } ?>
	 <?php if($btnsize==1 && $showshare=='0'){ ?>
	<div class="smallnoshare"></div>
	 <?php } ?>
	 
	 <?php if($btnsize==2 && $showshare==1){ ?>
	<div class="mediumwithshare"><div class="icon"></div><div class="text">Share</div></div>
	 <?php } ?>
	 <?php if($btnsize==2 && $showshare=='0'){ ?>
	<div class="mediumnoshare"></div>
	 <?php } ?>
	 
	  <?php if($btnsize==3 && $showshare==1){ ?>
	<div class="largewithshare"><div class="icon"></div><div class="text">Share</div></div>
	 <?php } ?>
	 <?php if($btnsize==3 && $showshare=='0'){ ?>
	<div class="largenoshare"></div>
	 <?php } ?>
	 
	 
	 </a>
	
	</td>
  </tr>
</table>

</body>

</html>