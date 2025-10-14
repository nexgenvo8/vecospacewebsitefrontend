<?php
include_once('inc.php'); 
$pageIndex=12;

?>
<!DOCTYPE html>
<html>
<head>
<title>Business - <?php echo $companNameTitle;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/style.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<link rel="icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

<script src="<?php echo $fullurl;?>js/jquery.min.js"></script>


</head>
<body style="background-color: #fff;">
<div class="request-sucess">
	<img src="<?php echo $fullurl;?>images/logo.jpg">
	<div class="request-sucess-txt">
		You've invited people to connection.
	</div>
	<div class="youcanadd">You can manage your invitations any time. Try adding contacts from another email address to find more connections.</div>
	<a  onClick="window.close()" class="close-btn">Done for now</a>
</div>
</body>
</html>
