<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session
$ps=2;
?>
<!DOCTYPE html>
<html>
<head>
<title>Settings - <?php echo $companNameTitle;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/style.css">
<link rel="icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<script src="<?php echo $fullurl;?>js/jquery.min.js"></script>
<script src="<?php echo $fullurl;?>js/main.js"></script>

</head>
<body>
<div id="wrapper" class="active">
  <?php include('header.php');?>
  <div class="container main">

    <div class="home_container">
      <?php include('left-sidebar.php');?>
      <div class="center_content">
	  <div class="setting" id="settingpage">
<div class="sttng-wraper">

<?php include('settingtop.inc.php');?>
  <ul class="setting_area_list">
    <li>
      <dl>
	  <div>
        <dt>First name</dt>
        <dd><?php echo $myfirstName;?> <a onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl;?>common_popup_inner.php?type=personaldatasetting','Edit Personal Data');"  class="edit_btn">Edit</a></dd>
		</div>
		<div>
        <dt>Last name</dt>
        <dd><?php echo $mylastName;?></dd></div>
		
		<div>
        <dt>Gender</dt>
        <dd><?php echo $mygender;?></dd></div>
		
        <?php if($dob!='0000-00-00'){?>
		<div>
		<dt>Date of birth</dt>
        <dd><?php echo date('j F Y',strtotime($dob));?></dd></div>
		<?php }?>
		
        <div>
		<dt>Location</dt>
        <dd><?php if($mylocationName!='') { echo $mylocationName;?>, <?php } echo $mystateName;?>  <?php echo $mycountryName;?></dd></div>
		<div>
		<dt>Time Zone</dt>
        <dd><?php echo $TimeZone;?></dd></div>
		
		
      </dl>
    </li>
  </ul>
</div>
</div>
	  </div>
    </div>
  </div>
  <?php include('footer.php');?>
</div>
<script>

function reloadPage(){
location.reload(true);
}
</script>
</body>
</html>
