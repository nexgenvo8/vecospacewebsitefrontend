<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$countexploring = 1;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlLogin = "";
$sqlLogin = "select id from " . _EXPLORING_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' ";
$resLogin = getRecords(_EXPLORING_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
if ($resLogin) {
	while ($row = mysqli_fetch_array($resLogin)) {
		$countexploring = $countexploring + 1;
	}
}


?>

<h3>What am I exploring on <?php echo $companNameTitle; ?><span
		style="font-size:11px; margin-left:4px; color:#999999;">You can add 3 fields here.</span></h3><a class="add_btn"
	onClick="$('#editexploring').show();$('#defaultexploring').hide();addnewexplorings(<?php echo $countexploring; ?>,3);$('#exploringcontentboxs').hide();"><i
		class="fa fa-plus-circle" aria-hidden="true"></i>
	<?php if ($countexploring > 1) { ?>Edit<?php } else { ?>Add<?php } ?></a>

<?php if ($countexploring == 1) { ?>
	<div class="add_more" id="defaultexploring">
		<h4>Your knowledge, explorings and experience</h4>
		<span>Here you can enter your haves, such as software explorings, social explorings or expertise in a certain
			field.</span>
		<span class="addmore_icon"
			onClick="$('#editexploring').show();$('#defaultexploring').hide();addnewexplorings(<?php echo $countexploring; ?>,3);$('#exploringcontentboxs').hide();">
			<i class="fa fa-plus-circle" aria-hidden="true"></i></span>
	</div>
<?php } else { ?>

	<div class="intrs-list" id="exploringcontentboxs">
		<ul class="list"
			onClick="$('#editexploring').show();$('#defaultexploring').hide();addnewexplorings(<?php echo $countexploring; ?>,3);$('#exploringcontentboxs').hide();"
			style="cursor:pointer;">
			<?php

			$countexploring = 1;
			$selectFields = [];
			$whereFields = [];
			$whereVals = [];

			$sqlLogin = "";
			$sqlLogin = "select * from " . _EXPLORING_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' order by exploringText asc ";
			$resLogin = getRecords(_EXPLORING_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
			if ($resLogin) {
				while ($row = mysqli_fetch_array($resLogin)) {
					?>
					<li><?php echo sanitizedboutput($row["exploringText"]); ?></li>
					<?php
				}
			}
			?>
		</ul>
	</div>

<?php } ?>


<div class="edit_box" id="editexploring" style="display:none;">
	<form class="edit-layer" method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
		<h2></h2>
		<a onClick="$('#editexploring').hide();$('#defaultexploring').show();$('#exploringcontentboxs').show();"
			class="close"><i class="fa fa-times" aria-hidden="true"></i></a>
		<ul>
			<?php

			$countexploring = 1;
			$selectFields = [];
			$whereFields = [];
			$whereVals = [];

			$sqlLogin = "";
			$sqlLogin = "select * from " . _EXPLORING_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' order by exploringText asc ";
			$resLogin = getRecords(_EXPLORING_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
			if ($resLogin) {
				while ($row = mysqli_fetch_array($resLogin)) {
					?>

					<li id="newexploringli<?php echo $countexploring; ?>"><input type="text"
							id="newexploring<?php echo $countexploring; ?>" name="check_list[]"
							value="<?php echo sanitizedboutput($row["exploringText"]); ?>"
							placeholder="My purpose of being on <?php echo $companNameTitle; ?> is..."
							onKeyUp="addnewexplorings(Number(<?php echo $countexploring; ?>+1),3);">

						<a onClick="removeexplorings(Number(<?php echo $countexploring; ?>));" class="remove">-</a>
					</li>
					<?php
					$countexploring = $countexploring + 1;
				}
			}
			?>

		</ul>
		<input type="hidden" name="addexploringaction" id="addexploringaction" value="add">
		<div class="submit-now">
			<button class="cancel" type="button" onClick="loadexploring();">cancel</button>
			<button type="submit">Save</button>
		</div>
	</form>

</div>

<script>
	function addnewexplorings(id, limt) {
		var id = Number(id);
		var limt = Number(limt);

		if ($('#newexploring' + id).length || limt < id) {


		} else {


			var displayremove = '<a onClick="removeexploring(' + Number(id) + ');" class="remove" >-</a></li>';


			$('#editexploring ul').append('<li id="newexploringli' + id + '"><input type="text" id="newexploring' + id + '" name="check_list[]" placeholder="My purpose of being on <?php echo $companNameTitle; ?> is..." onKeyUp="addnewexplorings(' + Number(id + 1) + ',3);">' + displayremove);
		}
	}



	function removeexplorings(id) {
		$("#newexploringli" + id).remove();
	}


</script>