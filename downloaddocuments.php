<?php
include_once('inc.php');
$postType = 20;
if ($_REQUEST['id'] != '') {

	$sqlVault = "SELECT * from " . _VAULT_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['id']) . " ";
	$resVault = mysqli_query($conn, $sqlVault) or die(mysqli_error($conn));
	$rowVault = mysqli_fetch_array($resVault);

	if ($rowVault['name'] == '') {
		header('Location:vault.html');
		exit();
	}

	$name = $rowVault['name'];
	$documentFileName = trim($rowVault["documentFile"]);

	$sharefileSize = trim($rowVault["fileSize"]);

	$totalsharefileSize = ceil($sharefileSize / 1024 / 1024);



	$aa2 = "SELECT firstName,lastName,profilePhoto,jobTitle,companyName,userId,userurl from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . decodeStr($_REQUEST['userId']) . "' ";
	$res52 = mysqli_query($conn, $aa2);
	$getuser2 = mysqli_fetch_array($res52);

	$firstName2 = $getuser2['firstName'];
	$lastName2 = $getuser2['lastName'];
	$profilePhoto2 = $getuser2['profilePhoto'];
	$jobTitle = $getuser2["jobTitle"];
	$companyName = $getuser2["companyName"];
	$userurl = $getuser2["userurl"];

	if ($profilePhoto2 != '') {
		$profilePhoto2 = $profilePhoto2;
	} else {
		$profilePhoto2 = 'user-placeholder.jpg';
	}





}

?>
<title><?php echo $companNameTitle; ?></title>
<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;">
	<a href="<?php echo $fullurl; ?>" target="_blank" style="display: inline-block;padding: 10px;">
		<img src="<?php echo $fullurl; ?>images/sdglogo.png" width="150px;">
	</a>
</div>
<div
	style="background-color:#f4f4f4;user-select: none;-moz-user-select: none; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; padding:30px 0px;text-align:center;">
	<div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
		<div style="padding:30px;">
			<div style="width: 100px;height: 100px;margin: auto;">
				<img src="<?php echo $fullurl; ?>images/download.png" style="width: 100px;height: 100px;display: block;">
			</div>
			<span
				style="color:#000;font-size:22px;text-align: center;display: block;margin-top:20px; margin-bottom:20px;">Ready
				to download </span>

			<div style="padding:10px; background-color:#F9F9F9; border:dashed 1px #ccc; border-radius: 2px;">


				<div style="width: 100%;text-align: left;overflow: hidden;padding: 10px;">

					<strong style="font-weight: 600;display: block;text-align: center;">File Size
						(<?php echo $totalsharefileSize; ?> MB) </strong>
					<div style="font-size: 14px;  color: #a0a0a0; margin-top: 5px;text-align: center;">
						<?php echo $documentFileName; ?> </div>
				</div>
				<div style="width: 100%;overflow: hidden;text-align: center;">
					<a href="<?php echo $fullurl; ?>download.php?id=<?php echo $_REQUEST['id']; ?>"
						style="display: inline-block; padding: 10px 43px; background-color: #1a94c3; text-decoration: none; color: #fff;font-size: 18px; margin-top: 15px;border-radius: 24px;">Download
						Your File</a>
				</div>
				<div style="width: 100%;overflow:hidden;text-align: left;margin-top: 20px;">
					<div style="
	text-align: center;
	margin-bottom: 15px;
	padding-bottom: 10px;
	border-bottom: solid 1px #e7e7e7;
	font-size: 16px;
	margin-top: 20px;
">
						Sent by </div>
					<div style="width: 60px;height: 60px;margin: auto;">
						<a style="color:#1a94c3; text-decoration: none;" target="_blank"
							href="<?php echo $fullurl; ?>profile/<?php echo $_REQUEST['userId']; ?>/<?php echo $userurl; ?>.html"><img
								src="<?php echo $fullurl; ?>uploads/<?php echo $profilePhoto2; ?>"
								style="border-radius: 50%;width: 50px;height: 50px;display: block;"></a>
					</div> <span style="color:#1a94c3;font-size:22px;text-align: center;display: block;"><a
							style="color:#1a94c3; text-decoration: none;" target="_blank"
							href="<?php echo $fullurl; ?>profile/<?php echo $_REQUEST['userId']; ?>/<?php echo $userurl; ?>.html"><?php echo $firstName2; ?>
							<?php echo $lastName2; ?></a> </span>
				</div>


				<div
					style="    margin-top: 20px; text-align: right; line-height: 30px;padding-top: 5px; border-top: solid 1px #e7e7e7; color: #afafaf;">
					Powered by <?php echo $companNameTitle; ?></div>
			</div>
		</div>
	</div>