<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$countskill = 1;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlLogin = "";
$sqlLogin = "select id from " . _SKILL_EXPERIENCE_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' ";
$resLogin = getRecords(_SKILL_EXPERIENCE_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
if ($resLogin) {
	while ($row = mysqli_fetch_array($resLogin)) {
		$countskill = $countskill + 1;
	}
}


?>

<h3>Key Skills<span style="font-size:11px; margin-left:4px; color:#999999;">You can add 5 skills.</span></h3><a
	class="add_btn"
	onClick="$('#editskill').show();$('#defaultskill').hide();addnewskills(<?php echo $countskill; ?>,5);$('#skillcontentboxs').hide();"><i
		class="fa fa-plus-circle" aria-hidden="true"></i> <?php if ($countskill > 1) { ?>Edit<?php } else { ?>Add<?php } ?></a>

<?php if ($countskill == 1) { ?>
	<div class="add_more" id="defaultskill">
		<h4>Your knowledge, skills and experience</h4>
		<span>Here you can enter your haves, such as software skills, social skills or expertise in a certain field.</span>
		<span class="addmore_icon"
			onClick="$('#editskill').show();$('#defaultskill').hide();addnewskills(<?php echo $countskill; ?>,5);$('#skillcontentboxs').hide();">
			<i class="fa fa-plus-circle" aria-hidden="true"></i></span>
	</div>
<?php } else { ?>

	<div class="intrs-list" id="skillcontentboxs">
		<ul class="list"
			onClick="$('#editskill').show();$('#defaultskill').hide();addnewskills(<?php echo $countskill; ?>,5);$('#skillcontentboxs').hide();"
			style="cursor:pointer;">
			<?php

			$countskill = 1;
			$selectFields = [];
			$whereFields = [];
			$whereVals = [];

			$sqlLogin = "";
			$sqlLogin = "select * from " . _SKILL_EXPERIENCE_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' order by skillText asc ";
			$resLogin = getRecords(_SKILL_EXPERIENCE_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
			if ($resLogin) {
				while ($row = mysqli_fetch_array($resLogin)) {
					?>
					<li><?php echo sanitizedboutput($row["skillText"]); ?></li>
					<?php
				}
			}
			?>
		</ul>
	</div>

<?php } ?>


<div class="edit_box" id="editskill" style="display:none;">
	<form class="edit-layer" method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
		<h2></h2>
		<a onClick="$('#editskill').hide();$('#defaultskill').show();$('#skillcontentboxs').show();" class="close"><i
				class="fa fa-times" aria-hidden="true"></i></a>
		<ul>
			<?php

			$countskill = 1;
			$selectFields = [];
			$whereFields = [];
			$whereVals = [];

			$sqlLogin = "";
			$sqlLogin = "select * from " . _SKILL_EXPERIENCE_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' order by skillText asc ";
			$resLogin = getRecords(_SKILL_EXPERIENCE_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
			if ($resLogin) {
				while ($row = mysqli_fetch_array($resLogin)) {
					?>

					<li id="newskillli<?php echo $countskill; ?>"><input type="text" id="newskill<?php echo $countskill; ?>"
							name="check_list[]" value="<?php echo sanitizedboutput($row["skillText"]); ?>"
							placeholder="Add new skills and experience"
							onKeyUp="addnewskills(Number(<?php echo $countskill; ?>+1),5);">

						<a onClick="removeskills(Number(<?php echo $countskill; ?>));" class="remove">-</a>
					</li>
					<?php
					$countskill = $countskill + 1;
				}
			}
			?>

		</ul>
		<input type="hidden" name="addskillaction" id="addskillaction" value="add">
		<div class="submit-now">
			<button type="button" class="cancel" onClick="loadskills();">cancel</button>
			<button type="submit">Save</button>
		</div>
	</form>

</div>

<script>
	function addnewskills(id, limt) {
		var id = Number(id);
		var limt = Number(limt);

		if ($('#newskill' + id).length || limt < id) {


		} else {


			var displayremove = '<a onClick="removeskills(' + Number(id) + ');" class="remove" >-</a></li>';


			$('#editskill ul').append('<li id="newskillli' + id + '"><input type="text" id="newskill' + id + '" name="check_list[]" placeholder="Add new skills and experience" onKeyUp="addnewskills(' + Number(id + 1) + ',5);">' + displayremove);
		}
	}

	function removeskills(id) {
		$("#newskillli" + id).remove();
	}




</script>