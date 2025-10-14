<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$sql_ins = "SELECT id FROM " . _EVENT_IMAGE_MASTER_TABLE_ . " WHERE eventId= " . intval($_REQUEST["eventId"]);
$resresult2 = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
$totalimages = mysqli_num_rows($resresult2);



?>
<script>
	$('#commonloader').hide();
</script>
<form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post"
	target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
	<?php if ($totalimages > 0) { ?>

		<ul class="upld-img-list" style="display:block;">
			<?php

			$a = "SELECT id, imageName FROM " . _EVENT_IMAGE_MASTER_TABLE_ . " WHERE eventId= " . intval($_REQUEST["eventId"]);
			$imgrows = mysqli_query($conn, $a) or die(mysqli_error($conn));
			while ($rowName = mysqli_fetch_array($imgrows)) {


				?>
				<li><img src="uploads/<?php echo $rowName['imageName']; ?>"><span class="close"><a
							href="common_action.php?deleventimgId=<?php echo encodeStr($rowName['id']); ?>&eventId=<?php echo encodeStr($_REQUEST["eventId"]); ?>&oldevntimg=<?php echo trim($rowName['imageName']); ?>&action=deleventimgact"
							target="actionfrm"><i class="fa fa-times" aria-hidden="true"></i></a></span></li>
				<?php

			}
			?>

			<li style="position:relative;"><i class="fa fa-plus" aria-hidden="true"></i> <input name="imagefileevent"
					id="imagefileevent" type="file" onChange="$('#commonloader').show();$('#frmposthome').submit();"
					style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); "
					accept="image/x-png,image/gif,image/jpeg"></li>

		</ul>
	<?php } else { ?>
		<span class="up-btn" style="position:relative;"><i class="fa fa-cloud-upload" aria-hidden="true"><span>Upload an
					image</span></i><input name="imagefileevent" id="imagefileevent" type="file"
				onChange="$('#commonloader').show();$('#frmposthome').submit();"
				style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); "
				accept="image/x-png,image/gif,image/jpeg"></span>
	<?php } ?>
	<input type="hidden" id="eventId" name="eventId" value="<?php echo $_REQUEST["eventId"]; ?>">
	<input type="hidden" id="imgThumb" name="imgThumb" value="<?php echo $rowName['imageName']; ?>">
</form>