<?php
include_once('inc.php'); 
$fpage=5;

$privacypage=1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<title>ConnecWRK Developer</title>
<meta name="description" content="<?php  echo stripslashes($post_result['meta_description']); ?>" />
<meta name="keywords" content="<?php  echo stripslashes($post_result['meta_keyword']); ?>"/>

<link href="css/style.css" rel="stylesheet" type="text/css" />
<script src="js/jquery.min.js"></script>
</head>

<body style="background-image:none;">
<div class="aboutheader">
<div class="container">
<div class="logo">
<a style="margin-top:0px; margin-bottom:0px;" href="<?php echo $fullurl;?>"><img src="images/logo.jpg" /></a>
</div>
<?php if($_SESSION["sessUserId"]!='' && $_SESSION["sessUserId"]!=0){ ?> 
<div class="toggle hiden-xs" onclick="$('.setting_menu').toggle();">
   <a href="javascript:void(0);">
   <span class="usr_img"><img src="<?php echo $fullurl;?>uploads/<?php echo $myprofilePhoto; ?>"></span>
  </a>
   <ul class="setting_menu" style="display: none;">
     <li><a href="<?php echo $fullurl;?>"><i class="fa fa-cog" aria-hidden="true"></i> Go to timeline</a></li>
   </ul>
   </div>
  <?php }?>  
</div>
</div>

<div class="help-banner">
<p>ConnecWRK Developer - Share Plugin</p>
</div>
<span class="clear"></span>
<div class="container">
  <div class="helpwrap-cont">
   
      <?php include('left_links.php'); ?>
	  
   
    <div class="right-panel">
	<div id="developrcontform" style="overflow:hidden; margin-bottom:20px; margin:0px 0px 30px;">
	  <h2><strong>Share Button Configurator</strong></h2>
	<div style="overflow:hidden; width:100%; float:left;">   <div style="float:left;">URL<br />
		<input type="text" name="url" id="url" value="" placeholder="URL to be shared (Optional)" style="width:400px; border:1px #e3eaee solid; padding:8px;" onkeyup="previewbtn();">
		</div><div style="float:left; margin-left:10px;">Button Size<br />
		<select name="btnsize" id="btnsize" style="width:100px; border:1px #e3eaee solid; padding:8px;" onchange="previewbtn();">
		<option value="1">Small</option>
		<option value="2">Medium</option>
		<option value="3">Large</option>
		
		</select>
		
		</div>
		
		<div style="float:left; margin-left:10px; padding-top:8px;">  
	 <table border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3">&nbsp;</td>
    </tr>
  <tr>
    <td colspan="2"><input name="showshare" type="checkbox" id="showshare" onclick="previewbtn();" class="checkbox_check" value="1" checked="checked" /></td>
    <td style="padding-left:2px;">Show <strong>Share</strong> Text </td>
  </tr>
</table>

		
		</div>
		<div style="width:100%; float:left;">
		<h4 style="margin-bottom: 5px;">Preview</h4>
		</div>
		
		<div style="margin-top:0px; padding:10px; border:1px  #e3eaee solid; float:left; width:100%;">
		<iframe  frameborder="0" scrolling="no" id="preview" name="preview" src="https://www.connecwrk.com/developer/sharebtn.html" style="height:70px; width:100%; border:0px;"></iframe>
		</div>
		 
	  </div>
	  <div id="copypastecode" style="width:100%; float:left; display:none;"><h4 style="margin-bottom: 5px;">Copy and paste the code below into your website</h4><textarea name="copycode" id="copycode" cols="" rows="" style="width:100%; height:80px; box-sizing:border-box; border:1px  #e3eaee solid; padding:10px;">
	  </textarea></div>
	  <div style="float:left; width:100%; text-align:left; margin-top:10px;"><a  class="invifrnd" onclick="getcodeclick();">Get Code</a></div>
	  </div>
	  <h2 id="step-by-step">Step-by-Step</h2>
	  <h4>1. Choose URL or Page</h4>
	  <p>Pick the URL of a Website, ConnecWRK SME Page or Profile Page you want to share.</p>
	  <h4>2. Code Configurator</h4>
	  <p>Paste the URL to the&nbsp;Code Configurator&nbsp;and adjust the&nbsp;layout&nbsp;of your share button. Click the&nbsp;<strong>Get Code</strong>&nbsp;button to generate your share button code.</p>
	  <h4>3. Copy &amp; Paste HTML snippet</h4>
	  <p>Copy and past the snippet into the HTML of the destination website.</p><br />
<br />
<br />

      
    </div>
  </div>
  </div>
</div>


<script>
function getcodeclick(){
var url = encodeURI($('#url').val());
var btnsize = $('#btnsize').val();
if ($('input.checkbox_check').is(':checked')) {
var showshare = '1'; 
} else {
var showshare = '0'; 
}
$('#copycode').val('');
$('#copypastecode').show();
var weburl = $('#weburl').val();
$('#copycode').val(""+weburl+"\n<div id='connecwrk-share-button' data-href='"+url+"' data-size='"+btnsize+"' show-text='"+showshare+"' target='_blank'></div>");




}

function previewbtn(){
var url = encodeURI($('#url').val());
var btnsize = $('#btnsize').val();
$('#copypastecode').hide();
if ($('input.checkbox_check').is(':checked')) {
var showshare = '1'; 
} else {
var showshare = '0'; 
}

$('#preview').attr('src','<?php echo $fullurl; ?>developer/sharebtn.html?url='+url+'&btnsize='+btnsize+'&showshare='+showshare);
}
previewbtn();
</script>
<input name="weburl" type="hidden" id="weburl" value="<script src='<?php echo $fullurl; ?>platform/connecwrk.js' type='text/javascript'></script>" />
</body>
</html>
