<table>
	<tr>
		<td width="56px"><?php
		include_once('inc.php');
		include_once('config/session-check.inc.php'); // check user login session
		$g = 1;
		$names = '';
		$ppostId = $_REQUEST['postId'];
		$aaa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= '" . $ppostId . "' order by rand() limit 0,2";
		$res55 = mysqli_query($conn, $aaa);
		while ($rowLogin22 = mysqli_fetch_array($res55)) {

			$a2 = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin22["userId"] . "";
			$b2 = mysqli_query($conn, $a2) or die(mysqli_error($conn));
			$userres2 = mysqli_fetch_array($b2);

			if (!empty($userres2) && is_array($userres2)) {
				$friendnameurl2 = !empty($userres2['userurl']) ? $userres2['userurl'] : '';

				if (!empty($userres2["profilePhoto"])) {
					$userphoto2 = $userres2["profilePhoto"];
				} else {
					$userphoto2 = 'user-placeholder.jpg';
				}
			} else {
				$friendnameurl2 = '';
				$userphoto2 = 'user-placeholder.jpg';
			}

			?>
				<li><a style="cursor:pointer;" title="<?php $names = $names . ', ' . $userres2["firstName"];
				echo $userres2["firstName"]; ?> <?php echo $userres2["lastName"]; ?>"
						onclick="funcommonpopupwin('400px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=viewlikes&id=<?php echo encodeStr($ppostId); ?>','Likes');"><img
							src="<?php echo $fullurl; ?>uploads/<?php echo $userphoto2; ?>"></a></li>
				<?php $g++;
		} ?>
		</td>

		<?php
		$n = 1;
		$aaa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= '" . $ppostId . "'";
		$res55 = mysqli_query($conn, $aaa);
		while ($rowLogin22 = mysqli_fetch_array($res55)) {
			$n++;
		} ?>


		<?php if ($n > 3) { ?>
			<td style="font-size: 12px;font-weight: normal;line-height: 13px;"><?php echo ltrim($names, ","); ?> and<br />
				<?php echo $n - 3; ?> more like this</td><?php } ?>


	</tr>
</table>