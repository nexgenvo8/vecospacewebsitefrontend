<?php
include("inc.php");

$re="select * from wfs_pageimages  where id='".$_REQUEST['pid']."'";
$re2=mysql_query($re) or die(mysql_error());
$post_result=mysql_fetch_array($re2);
?>

  <img src="../upload/thumb/small<?php echo $post_result['image']; ?>" width="150" /><input name="feature_img" type="hidden" id="feature_img" value="<?php echo $post_result['image']; ?>" /> 
 
    