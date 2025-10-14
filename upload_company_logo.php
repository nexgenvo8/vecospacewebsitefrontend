<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$a = "select * from " . _IMAGE_MASTER_TABLE_ . " where  postId= " . $_REQUEST["postId"] . " and imageType=8 ";
$imgrows = mysqli_query($conn, $a) or die(mysqli_error($conn));
$totalimages = mysqli_num_rows($imgrows);


?>
<script>
	$('#commonloader').hide();
</script>
<form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post"
	target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
	<?php if ($totalimages > 0) { ?>

		<ul class="upld-img-list logo" style="display:block;">
			<?php
			while ($rowName = mysqli_fetch_array($imgrows)) {
				?>
				<li><img src="uploads/<?php echo $rowName['imageName']; ?>"><span class="close"><a
							href="<?php echo $fullurl; ?>common_action.php?cmpdelId=<?php echo encodeStr($rowName['id']); ?>&postId=<?php echo encodeStr($_REQUEST["postId"]); ?>&oldimg=<?php echo trim($rowName['imageName']); ?>&action=delcmplogo"
							target="actionfrm"><i class="fa fa-times" aria-hidden="true"></i></a></span></li>

				<?php

			}
			?>

			<li style="position:relative; display:none;"><i class="fa fa-plus" aria-hidden="true"></i> <input
					name="companylogoimage" id="companylogoimage" type="file"
					onChange="$('#commonloader').show();$('#frmposthome').submit();"
					style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); "
					accept="image/x-png,image/gif,image/jpeg"></li>

		</ul>
	<?php } else { ?>
		<span class="up-btn" style="position:relative;"><i class="fa fa-cloud-upload" aria-hidden="true"><span>Upload
					Logo</span></i><input name="companylogoimage" id="companylogoimage" type="file"
				onChange="$('#commonloader').show();$('#frmposthome').submit();"
				style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); "
				accept="image/x-png,image/gif,image/jpeg"></span>
	<?php } ?>
	<input type="hidden" id="postId" name="postId" value="<?php echo $_REQUEST["postId"]; ?>">
</form>