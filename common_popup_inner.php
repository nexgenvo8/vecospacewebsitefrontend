<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$type = clean($_REQUEST['type']);
?>

<?php if ($type == 'leavegroup' && $_REQUEST['groupId'] != '') { ?>
		<!--<link href="css/style.css" rel="stylesheet" type="text/css" />-->

		<div style="text-align:center; font-size:20px;">Do you want to leave this group?</div>
		<div style="text-align:center;">
			<div class="popup-fttr" style="float:none; background-color:#fff; margin-top:0px; text-align:center;">
				<a href="<?php echo $fullurl; ?>private-group.html?groupId=<?php echo $_REQUEST["groupId"]; ?>&action=lvg"><button
						type="button" style="float:none; margin:5px;">Yes</button></a>
				<!-- <button type="button" style="float:none; margin:5px;" onclick="$('.crt-grp-popup').hide();$('#groupName').val('');$('#groupDetails').val('');">No</button>-->
				<a type="button" style="float:none; margin:5px;margin-left: 15px;"
					onclick="$('.crt-grp-popup').hide();$('#groupName').val('');$('#groupDetails').val('');">No</a>
			</div>
		</div>
<?php } ?>

<?php if ($type == 'sendmsgtocontact') { ?>

		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">
			<label>Message<span class="reqstar">*</span></label>
			<textarea rows="4" name="txtmsg" id="txtmsg" placeholder="Type your message here" style="height:170px;"
				maxlength="500" class="validate" onKeyUp="hideerrordiv(this.id);"><?php
				if (isset($_REQUEST['m']) && $_REQUEST['m'] == 1) {
					echo 'Congrats on the new job!';
				}
				?></textarea>

			<div class="popup-fttr">
				<a onClick="$('#sendmsgtocontactdiv').hide();$('#txtmsg').val('');closefuncommonpopupwin();">Cancel</a>
				<button type="button" onClick="formValidation('sendmsg');">Send</button>
				<input type="hidden" name="action" id="action" value="sendmsgtocontact">
				<input type="hidden" name="msgcontactId" id="msgcontactId" value="<?php echo trim($_GET['id']); ?>">
			</div>
		</form>

		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>


<?php if ($type == 'sendbulkemails') { ?>

		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div class="tagbox" id="msgcontactdiv" style=""></div>


			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>


			<input type="text" name="searchtypecontact" id="searchtypecontact" onkeyup="searchcontactmsg();" autocomplete="off"
				placeholder="Type a name or multiple names" />
			<label>Message<span class="reqstar">*</span></label>
			<textarea rows="4" name="txtmsg" id="txtmsg" style="height:170px;" placeholder="Type your message here"
				class="validate" onKeyUp="hideerrordiv(this.id);"></textarea>
			<div class="popup-fttr">

				<button type="button" class="konecttbtn" onClick="formValidation('sendmsg');">Send</button>
				<input type="hidden" name="action" id="action" value="sendmsguser">
				<input type="hidden" name="msguserid" id="msguserid" value="">
			</div>
		</form>
		<script>
			function searchcontactmsg() {
				var searchtypecontact = $("#searchtypecontact").val();
				searchtypecontact = encodeURIComponent(searchtypecontact);
				var msguserid = $("#msguserid").val();
				if (searchtypecontact != '') {
					$("#searchcontactmsgouter").load('<?php echo $fullurl; ?>loadsearchcontactmsg.php?searchtypecontact=' + searchtypecontact + '&msguserid=' + msguserid);
				}
				else {
					$("#searchcontactmsgouter").hide();
				}

			}


			function msgthisuser(name, id, keyword) {
				$("#msgcontactdiv").show();
				$("#msgcontactdiv").append('<div id="t' + id + '" class="tag">' + name + ' <i class="fa fa-times" aria-hidden="true" onClick="removemsg(' + id + ');"></i></div>');
				$("#searchcontactmsg").hide();
				$("#searchtypecontact").val('');


				var msguserid = $("#msguserid").val();
				msguserid = msguserid + "'" + id + "',";
				$("#msguserid").val(msguserid);

			}


			function removemsg(id) {
				var msguserid = $("#msguserid").val();
				msguserid = msguserid.replace("'" + id + "',", "");

				$("#msguserid").val(msguserid);
				$("#t" + id).remove();
			}


		</script>
		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}

			ul#notice-list li {
				float: left;
				width: 100%;
				min-height: 55px;
				border-bottom: solid 1px #f0f0f0;
				/* padding: 10px; */
			}
		</style>
<?php } ?>

<?php if ($type == 'shareprofile') { ?>

		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div class="tagbox" id="msgcontactdiv" style=""></div>


			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>


			<input type="text" name="searchtypecontact" id="searchtypecontact"
				onkeyup="searchcontactmsg();hideerrordiv(this.id);" placeholder="Type a name or multiple names" />
			<label>Message<span class="reqstar">*</span></label>
			<textarea rows="4" name="txtmsg" id="txtmsg" style="height:170px;" placeholder="Type your message here"
				class="validate" onKeyUp="hideerrordiv(this.id);"><?php echo $_REQUEST['url']; ?></textarea>
			<div class="popup-fttr">
				<a onClick="$('#sendmsgtocontactdiv').hide();$('#txtmsg').val('');closefuncommonpopupwin();">Cancel</a>
				<button type="button" onClick="formValidation('sendmsg');">Send</button>
				<input type="hidden" name="action" id="action" value="shareprofile"><input type="hidden" name="shareduserid"
					id="shareduserid" value="<?php echo $_REQUEST['id']; ?>">
				<input type="hidden" name="msguserid" id="msguserid" value="">
			</div>
			<style>
				#commonpopupwinfile #searchcontactmsg {
					top: 39px !important;
					border-radius: 0px !important;
				}
			</style>
		</form>
		<script>
			function searchcontactmsg() {
				var searchtypecontact = $("#searchtypecontact").val();
				searchtypecontact = encodeURIComponent(searchtypecontact);
				if (searchtypecontact != '') {
					$("#searchcontactmsgouter").load('<?php echo $fullurl; ?>loadsearchcontactmsg.php?searchtypecontact=' + searchtypecontact);
				}
				else {
					$("#searchcontactmsgouter").hide();
				}

			}


			function msgthisuser(name, id, keyword) {
				$("#msgcontactdiv").show();
				$("#msgcontactdiv").append('<div id="t' + id + '" class="tag">' + name + ' <i class="fa fa-times" aria-hidden="true" onClick="removemsg(' + id + ');"></i></div>');
				$("#searchcontactmsg").hide();
				$("#searchtypecontact").val('');


				var msguserid = $("#msguserid").val();
				msguserid = msguserid + "'" + id + "',";
				$("#msguserid").val(msguserid);

			}


			function removemsg(id) {
				var msguserid = $("#msguserid").val();
				msguserid = msguserid.replace("'" + id + "',", "");

				$("#msguserid").val(msguserid);
				$("#t" + id).remove();
			}


		</script>
		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'removeconnection' && $_REQUEST['id'] != '') { ?>

		<div style="margin-top:10px; margin-bottom:10px; text-align:center; font-size:20px;">Are you sure want to remove
			<?php echo $_REQUEST["name"]; ?>?
		</div>
		<div style="text-align:center;">
			<div id="removeonnectiondiv"></div>
			<div class="popup-fttr" style="float:none; background-color:#fff; margin-top:0px; text-align:center;">
				<a href="<?php echo $fullurl; ?>common_action.php?action=removeconection&rmcontactid=<?php echo $_REQUEST["id"]; ?>"
					target="actionfrm" style="padding: 0;"><button type="button"
						style="float:none; margin:5px;">Yes</button></a>
				<a type="button" style="float:none; margin:5px;margin-left: 15px;"
					onclick="$('.crt-grp-popup').hide();$('#groupName').val('');$('#groupDetails').val('');">No</a>
			</div>
		</div>
		<!--onclick="removeconnectionfun('<?php echo $_REQUEST["id"]; ?>');"-->

		<!--<script>
function removeconnectionfun(id)
{
	  if(id!='')
	  {
		  $("#removeonnectiondiv").load('<?php echo $fullurl; ?>common_action.php?action=removeconection&rmcontactid='+id);
	  }
}
</script>-->

<?php } ?>

<?php if ($type == 'blockcontact' && $_REQUEST['id'] != '') { ?>
		<?php if ($_REQUEST["status"] == 1) {
			$bstatus = 'block';
		} else {
			$bstatus = 'unblock';
		} ?>
		<div style="margin-top:10px; margin-bottom:10px; text-align:center; font-size:20px;">Are you sure want to
			<?php echo $bstatus; ?>	 	<?php echo $_REQUEST["name"]; ?>?
		</div>
		<div style="text-align:center;">
			<div class="popup-fttr" style="float:none; background-color:#fff; padding:10px; margin-top:0px; text-align:center;">
				<a href="<?php echo $fullurl; ?>common_action.php?action=blockcontact&rmcontactid=<?php echo $_REQUEST["id"]; ?>&status=<?php echo $_REQUEST["status"]; ?>"
					target="actionfrm"><button type="button" style="float:none; margin:5px;">Yes</button></a>
				<a type="button" style="float:none; margin:5px;"
					onclick="$('.crt-grp-popup').hide();$('#groupName').val('');$('#groupDetails').val('');">No</a>
			</div>
		</div>

<?php } ?>

<?php if ($type == 'recommendations' && $_REQUEST['id'] != '') {
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlLogin = "";
	$sqlLogin = "select jobTitle,companyName,firstName,lastName,userurl from " . _USERS_MASTER_TABLE_ . " where userId='" . decodeStr($_GET['id']) . "' ";
	$resLogin = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
	if ($resLogin) {
		while ($rowLogin = mysqli_fetch_array($resLogin)) {
			$jobTitle = $rowLogin["jobTitle"];
			$companyName = $rowLogin["companyName"];
			$myfirstName = $rowLogin["firstName"];
			$mylastName = $rowLogin["lastName"];
			$myname = ucfirst($rowLogin["firstName"]) . ' ' . ucfirst($rowLogin["lastName"]);
			$userurl = $rowLogin["userurl"];

			$userurl = $fullurl . 'profile/' . $_GET['id'] . '/' . $userurl . '.html';
		}
	}
	?>
		<style>
			.popuptitle {
				display: none;
			}

			.nw-grup {
				padding: 0px
			}

			.crt-grp-popup .popup-inner {
				border: 0px;
				border-radius: 0px;
				box-shadow: 0px 0px 5px #5f5f5f;
				width: 600px;
				max-width: 600px;
			}
		</style>
		<!--<div style="margin-top:10px; margin-bottom:10px; text-align:left; font-size:20px; background-color:#1a94c3; color:#fff; padding:20px; margin-top:-21px;">Ask <?php echo $_REQUEST["name"]; ?> to recommend you</div>-->
		<form enctype="multipart/form-data" name="frmposthomerecommend" id="frmposthomerecommend" method="post"
			target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">

			<div id="selectposition">
				<div style="font-size:14px; text-align:left; margin-bottom:10px;"> How do you know
					<?php echo $_REQUEST["name"]; ?>?
				</div>
				<div style="font-size:14px; text-align:left; margin-bottom:10px;">
					<select name="requesterRelationship" id="requesterRelationship"
						style="padding:8px; border:1px solid #ccc; width:100%; box-sizing:border-box;" onchange="sonextbtn();">
						<option value="">Select relationship</option>

						<option value="RECOMMENDER_MANAGED_RECOMMENDEE"><?php echo $_REQUEST["name"]; ?> managed you directly
						</option>
						<option value="RECOMMENDER_REPORTED_TO_RECOMMENDEE"><?php echo $_REQUEST["name"]; ?> reported directly
							to
							you</option>
						<option value="RECOMMENDER_SENIOR_THAN_RECOMMENDEE"><?php echo $_REQUEST["name"]; ?> was senior to you
							but didn't manage directly</option>
						<option value="RECOMMENDEE_SENIOR_THAN_RECOMMENDER">You were senior to <?php echo $_REQUEST["name"]; ?>
							but didn't manage directly</option>
						<option value="WORKED_IN_SAME_GROUP">You worked with <?php echo $_REQUEST["name"]; ?> in the same group
						</option>
						<option value="WORKED_IN_DIFFERENT_GROUPS"><?php echo $_REQUEST["name"]; ?> worked with you in different
							groups</option>
						<option value="WORKED_IN_DIFFERENT_COMPANIES"><?php echo $_REQUEST["name"]; ?> worked with you but at
							different companies</option>
						<option value="RECOMMENDEE_IS_CLIENT_OF_RECOMMENDER">You were a client of
							<?php echo $_REQUEST["name"]; ?>'s
						</option>
						<option value="RECOMMENDER_IS_CLIENT_OF_RECOMMENDEE"><?php echo $_REQUEST["name"]; ?> was a client of
							yours</option>
						<option value="RECOMMENDER_TAUGHT_RECOMMENDEE"><?php echo $_REQUEST["name"]; ?> taught or mentored you
						</option>
						<option value="RECOMMENDER_ADVISED_RECOMMENDEE"><?php echo $_REQUEST["name"]; ?> advised you</option>
						<option value="RECOMMENDER_STUDIED_WITH_RECOMMENDEE">You were students together</option>
					</select>
				</div>
				<div style="font-size:14px; text-align:left; margin-bottom:10px;">

					<select name="position" id="position"
						style="padding:8px; border:1px solid #ccc; width:100%; box-sizing:border-box;" onchange="sonextbtn();">
						<?php
						$selectFields = [];
						$whereFields = [];
						$whereVals = [];

						$sqlOptions = "";
						$sqlOptions = "SELECT * FROM " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " WHERE userId=" . $_SESSION["sessUserId"] . " order by fromyear desc ";
						$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
						if ($resOptions) {
							?>
								<option value="">Select your position at the time</option>
								<?php
								while ($rowOptions = mysqli_fetch_array($resOptions)) {
									$s = 1;
									if ($_REQUEST["position"] == $rowOptions["jobTitle"]) {
										$strSelected = 'selected="selected"';
									} else {
										$strSelected = "";
									}
									?>
										<option value="<?php echo $rowOptions["jobTitle"]; ?>"><?php echo $rowOptions["jobTitle"]; ?></option>
										<?php
								}
						} else {
							?>
								<option value="">Please add at least one professional experience to request a recommendation</option>
								<?php
						}
						?>
					</select>
				</div>
			</div>
			<div id="pmsg" style="display:none;">
				<div style="font-size:14px; text-align:left; margin-bottom:10px;">Include a personalized message with your
					request</div>
				<div style="padding:10px 0px; border-bottom:1px solid #ccc;">
					<textarea name="pmessage" id="pmessage"
						style="width:100%; padding:8px; border:1px solid #ccc; box-sizing:border-box; height:150px;"
						class="validate"
						onKeyUp="hideerrordiv(this.id);">Hi <?php echo $myname; ?>, can you write me a recommendation?</textarea>
					<input type="hidden" id="action" name="action" value="recommendations" />
					<input type="hidden" id="rmcontactid" name="rmcontactid" value="<?php echo $_REQUEST["id"]; ?>" />
					<input type="hidden" id="fullusername" name="fullusername" value="<?php echo $myname; ?>" />
					<input type="hidden" id="userurl" name="userurl" value="<?php echo $userurl; ?>" />

				</div>
			</div>
			<div style="text-align:center;">
				<div class="popup-fttr"
					style="float:none; background-color:#fff; padding:10px; margin-top:0px; text-align:center;">
					<button id="nextbtn" type="button" style="float:none; display:none; margin:5px;"
						onclick="$('#selectposition').hide();$('#pmsg').show();$('#nextbtn').hide();$('#sendbtn').show();">Next</button>

					<button id="sendbtn" type="button" style="float:none; display:none; margin:5px;"
						onClick="formValidation('frmposthomerecommend');">Send</button>

				</div>
			</div>
		</form>
		<div id="rsuccess" style="display:none;">
			<div style="text-align:center; font-size:14px; color:#009900; margin-bottom:10px;">Request has been sent
				successfully</div>
			<div class="popup-fttr" style="float:none; background-color:#fff; padding:10px; margin-top:0px; text-align:center;">

				<button id="sendbtn" type="button" style="float:none; display:none; margin:5px;"
					onclick="closefuncommonpopupwin();">Close</button>

			</div>
		</div>
		<script>
			function sonextbtn() {
				var requesterRelationship = $("#requesterRelationship").val();
				var position = $("#position").val();

				if (requesterRelationship != '' && position != '') {
					$("#nextbtn").show();
				}
			}

		</script>
<?php } ?>

<?php if ($type == 'recommendeduser' && $_REQUEST['id'] != '') {
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlLogin = "";
	$sqlLogin = "select jobTitle,companyName,firstName,lastName,userurl from " . _USERS_MASTER_TABLE_ . " where userId='" . decodeStr($_GET['id']) . "' ";
	$resLogin = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
	if ($resLogin) {
		while ($rowLogin = mysqli_fetch_array($resLogin)) {
			$jobTitle = $rowLogin["jobTitle"];

			$companyName = $rowLogin["companyName"];
			$myfirstName = $rowLogin["firstName"];
			$mylastName = $rowLogin["lastName"];

			$userurl = $rowLogin["userurl"];

			$userurl = $fullurl . 'myprofile/' . $_GET['id'] . '/' . $userurl . '.html';
		}
	}
	?>
		<style>
			.popuptitle {
				display: none;
			}

			.nw-grup {
				padding: 0px
			}

			.crt-grp-popup .popup-inner {
				border: 0px;
				border-radius: 4px;
				box-shadow: 0px 0px 5px #5f5f5f;
				width: 600px;
				max-width: 600px;
			}
		</style>
		<!--<div style="margin-top:10px; margin-bottom:10px; text-align:left; font-size:20px; background-color:#1a94c3; color:#fff; padding:20px; margin-top:-21px;">Write <?php echo $_REQUEST["name"]; ?> a recommendation</div>-->
		<form enctype="multipart/form-data" name="frmposthomerecommend" id="frmposthomerecommend" method="post"
			target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">


			<div id="selectposition">
				<div style="font-size:14px; text-align:left; margin-bottom:10px;"> How do you know
					<?php echo $_REQUEST["name"]; ?>?
				</div>
				<div style="font-size:14px; text-align:left; margin-bottom:10px;"><select name="requesterRelationship"
						id="requesterRelationship"
						style="padding:8px; border:1px solid #ccc; width:100%; box-sizing:border-box;" onchange="sonextbtn();">
						<option value="">Select relationship</option>

						<option value="RECOMMENDER_MANAGED_RECOMMENDEE">You managed <?php echo $_REQUEST["name"]; ?> directly
						</option>
						<option value="RECOMMENDER_REPORTED_TO_RECOMMENDEE">You reported directly to
							<?php echo $_REQUEST["name"]; ?>
						</option>
						<option value="RECOMMENDER_SENIOR_THAN_RECOMMENDEE">You were senior to <?php echo $_REQUEST["name"]; ?>
						</option>
						<option value="RECOMMENDEE_SENIOR_THAN_RECOMMENDER"><?php echo $_REQUEST["name"]; ?> was senior to you
						</option>
						<option value="WORKED_IN_SAME_GROUP">You worked with <?php echo $_REQUEST["name"]; ?> in the same group
						</option>
						<option value="WORKED_IN_DIFFERENT_GROUPS">You worked with <?php echo $_REQUEST["name"]; ?> but in
							different groups</option>
						<option value="WORKED_IN_DIFFERENT_COMPANIES">You worked with <?php echo $_REQUEST["name"]; ?> but at
							different companies</option>
						<option value="RECOMMENDEE_IS_CLIENT_OF_RECOMMENDER"><?php echo $_REQUEST["name"]; ?> was a client of
							yours</option>
						<option value="RECOMMENDER_IS_CLIENT_OF_RECOMMENDEE">You were a client of
							<?php echo $_REQUEST["name"]; ?>'s
						</option>
						<option value="RECOMMENDER_TAUGHT_RECOMMENDEE">You taught <?php echo $_REQUEST["name"]; ?></option>
						<option value="RECOMMENDER_ADVISED_RECOMMENDEE">You mentored <?php echo $_REQUEST["name"]; ?></option>
						<option value="RECOMMENDER_STUDIED_WITH_RECOMMENDEE">You and <?php echo $_REQUEST["name"]; ?> studied
							together</option>
					</select></div>
				<div style="font-size:14px; text-align:left; margin-bottom:10px;"><select name="position" id="position"
						style="padding:8px; border:1px solid #ccc; width:100%; box-sizing:border-box;" onchange="sonextbtn();">
						<option value="">Select <?php echo $_REQUEST["name"]; ?>'s position at the time</option>

						<option value="<?php echo $jobTitle; ?> at <?php echo $companyName; ?>"><?php echo $jobTitle; ?> at
							<?php echo $companyName; ?>
						</option>

					</select></div>
			</div>



			<div id="pmsg" style="display:none;">
				<div style="font-size:14px; text-align:left; margin-bottom:10px;">The recommendation will appear on
					<?php echo $_REQUEST["name"]; ?>'s profile.
				</div>
				<div style="padding:10px 0px; border-bottom:1px solid #ccc;">
					<textarea name="pmessage" id="pmessage"
						style="width:100%; padding:8px; border:1px solid #ccc; box-sizing:border-box; height:150px;"
						placeholder="Write your recommendation here..." class="validate"
						onKeyUp="hideerrordiv(this.id);"></textarea>
					<input type="hidden" id="action" name="action" value="recommendeduser" />
					<input type="hidden" id="rmcontactid" name="rmcontactid" value="<?php echo $_REQUEST["id"]; ?>" />
					<input type="hidden" id="fullusername" name="fullusername" value="<?php echo $myname; ?>" />
					<input type="hidden" id="userurl" name="userurl" value="<?php echo $userurl; ?>" />

				</div>
			</div>
			<div style="text-align:center;">
				<div class="popup-fttr"
					style="float:none; background-color:#fff; padding:10px; margin-top:0px; text-align:center;">
					<button id="nextbtn" type="button" style="float:none; display:none; margin:5px;"
						onclick="$('#selectposition').hide();$('#pmsg').show();$('#nextbtn').hide();$('#sendbtn').show();">Next</button>

					<button id="sendbtn" type="button" style="float:none; display:none; margin:5px;"
						onClick="formValidation('frmposthomerecommend');">Send</button>

				</div>
			</div>
		</form>
		<div id="rsuccess" style="display:none;">
			<div style="text-align:center; font-size:14px; color:#009900; margin-bottom:10px;">Your recommendation has been
				submitted successfully</div>
			<div class="popup-fttr" style="float:none; background-color:#fff; padding:10px; margin-top:0px; text-align:center;">

				<button id="sendbtn" type="button" style="float:none; display:none; margin:5px;"
					onclick="closefuncommonpopupwin();">Close</button>

			</div>
		</div>
		<script>
			function sonextbtn() {
				var requesterRelationship = $("#requesterRelationship").val();
				var position = $("#position").val();

				if (requesterRelationship != '' && position != '') {
					$("#nextbtn").show();
				}
			}

		</script>
<?php } ?>



<?php if ($type == 'viewlikes') {
	?>
		<div style="height:300px; overflow:auto;">
			<ul class="requst-list" id="notice-list">
				<?php
				$aaa = "SELECT * FROM " . _LIKE_MASTER_TABLE_ . " 
        WHERE postId = '" . mysqli_real_escape_string($conn, decodeStr($_REQUEST["id"])) . "' 
        ORDER BY id DESC";

				$res55 = mysqli_query($conn, $aaa) or die(mysqli_error($conn));

				while ($rowLogin22 = mysqli_fetch_assoc($res55)) {
					$a2 = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " 
           WHERE userId = '" . mysqli_real_escape_string($conn, $rowLogin22["userId"]) . "'";

					$b2 = mysqli_query($conn, $a2) or die(mysqli_error($conn));
					$userres2 = mysqli_fetch_assoc($b2);

					// Use $userres2 here...
					mysqli_free_result($b2);

					$friendnameurl2 = $userres2['userurl'];
					if ($userres2["profilePhoto"] != '') {
						$userphoto2 = $userres2["profilePhoto"];
					} else {
						$userphoto2 = 'user-placeholder.jpg';
					}
					?>
						<li>
							<div class="rquest-box">
								<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2["userId"]); ?>/<?php echo $friendnameurl2; ?>.html"
									target="_blank" class="rqst-img"><img
										src="<?php echo $fullurl; ?>uploads/<?php echo $userphoto2; ?>"></a>

								<div class="rqst-right">
									<div class="rquest-middle">
										<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2["userId"]); ?>/<?php echo $friendnameurl2; ?>.html"
											target="_blank" style="color: #676767;"><?php echo $userres2["firstName"]; ?>
											<?php echo $userres2["lastName"]; ?></a>
										<div style="font-size:12px; color:#9a9a9a;"><?php echo $userres2["jobTitle"]; ?> at
											<?php echo $userres2["companyName"]; ?>
										</div>
									</div>
								</div>
							</div>
						</li>
				<?php } ?>
			</ul>
		</div>

<?php } ?>

<?php if ($type == 'professionalexp') {
	if (!empty($_REQUEST['id'])) {
		$id = mysqli_real_escape_string($conn, decodeStr(trim($_REQUEST['id'])));
		$userId = mysqli_real_escape_string($conn, $_SESSION['sessUserId']);

		$aa = "SELECT * FROM " . _PROFESSIONAL_EXPERIENCE_TABLE_ . " 
           WHERE id = '$id' 
           AND userId = '$userId'";

		$res5 = mysqli_query($conn, $aa) or die(mysqli_error($conn));
		$getdetails = mysqli_fetch_assoc($res5);

		mysqli_free_result($res5);
	}

	?>

		<form class="nw-grup" name="frmprofessinalexp" id="frmprofessinalexp" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div class="tagbox" id="msgcontactdiv" style=""></div>


			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>

			<label>Job title<span class="reqstar">*</span>:</label>
			<input type="text" name="jobTitle" id="jobTitle"
				value="<?php echo htmlspecialchars($getdetails['jobTitle'] ?? ''); ?>" class="validate" maxlength="250"
				onKeyUp="hideerrordiv(this.id);" />


			<div style="display:none;">
				<label>Employment<span class="reqstar">*</span>:</label>
				<span class="nw-grup" style="padding:0px;">
					<select name="employment" id="employment">
						<option value="0">Select</option>
						<?php
						$selectFields = [];
						$whereFields = [];
						$whereVals = [];

						$sqlOptions = "";
						$sqlOptions = "SELECT id, optionName 
               FROM " . _OPTION_MASTER_TABLE_ . " 
               WHERE optionType = 'currentemployments'";

						$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);

						if ($resOptions) {
							while ($rowOptions = mysqli_fetch_assoc($resOptions)) {
								if ($getdetails["employment"] == $rowOptions['id']) {
									$strSelected = 'selected="selected"';
								} else {
									$strSelected = "";
								}
								?>
										<option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected; ?>>
											<?php echo trim($rowOptions['optionName']); ?>
										</option>
										<?php
							}
						}
						?>
					</select>
				</span>
			</div>
			<div style="display:none;">
				<label>Discipline:</label>
				<span class="nw-grup" style="padding:0px;">
					<select name="discipline" id="discipline">
						<option value="0">Select</option>
						<?php
						$selectFields = [];
						$whereFields = [];
						$whereVals = [];

						$sqlOptions = "SELECT id, optionName 
               FROM " . _OPTION_MASTER_TABLE_ . " 
               WHERE optionType = 'currentemployments'";

						$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);

						if ($resOptions) {
							while ($rowOptions = mysqli_fetch_assoc($resOptions)) {
								if ($getdetails["discipline"] == $rowOptions['id']) {
									$strSelected = 'selected="selected"';
								} else {
									$strSelected = "";
								}
								?>
										<option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected; ?>>
											<?php echo trim($rowOptions['optionName']); ?>
										</option>
										<?php
							}
						}
						?>
					</select>
				</span>
			</div>
			<div style="display:none;">
				<label>Career level:</label>
				<span class="nw-grup" style="padding:0px;">
					<select name="careerlevel" id="careerlevel">
						<option value="0">Select</option>
						<?php
						$selectFields = [];
						$whereFields = [];
						$whereVals = [];

						$sqlOptions = "";
						$sqlOptions = "SELECT id, optionName 
               FROM " . _OPTION_MASTER_TABLE_ . " 
               WHERE optionType = 'currentemployments'";

						$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);

						if ($resOptions) {
							while ($rowOptions = mysqli_fetch_assoc($resOptions)) {
								if ($getdetails["careerlevel"] == $rowOptions['id']) {
									$strSelected = 'selected="selected"';
								} else {
									$strSelected = "";
								}
								?>
										<option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected; ?>>
											<?php echo trim($rowOptions['optionName']); ?>
										</option>
										<?php
							}
						}
						?>
					</select>
				</span>
			</div>




			<label>Company name<span class="reqstar">*</span>:</label>
			<input type="text" name="companyName" id="companyName"
				value="<?php echo htmlspecialchars($getdetails['companyName'] ?? ''); ?>" class="validate" maxlength="250"
				onKeyUp="hideerrordiv(this.id);" />

			<label>Industry<span class="reqstar">*</span>:</label>
			<select name="industry" id="industry" class="validate" onchange="hideerrordiv(this.id);">
				<option value="0">Select</option>
				<?php
				$selectFields = [];
				$whereFields = [];
				$whereVals = [];

				$sqlOptions = "";
				$sqlOptions = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry' ";
				$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
				if ($resOptions) {
					while ($rowOptions = mysqli_fetch_array($resOptions)) {
						if ($getdetails["industry"] == $rowOptions['id']) {
							$strSelected = 'selected="selected"';
						} else {
							$strSelected = "";
						}
						?>
								<option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected; ?>>
									<?php echo trim($rowOptions['optionName']); ?>
								</option>
								<?php
					}
				}
				?>
			</select>

			<div style="display:none;">
				<label>Segment:</label>
				<span class="nw-grup" style="padding:0px;">
					<select name="segment" id="segment">
						<option value="0">Select</option>
						<?php
						$selectFields = [];
						$whereFields = [];
						$whereVals = [];


						$sqlOptions = "";
						$sqlOptions = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='currentemployments' ";
						$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
						if ($resOptions) {
							while ($rowOptions = mysqli_fetch_array($resOptions)) {
								if ($getdetails["segment"] == $rowOptions['id']) {
									$strSelected = 'selected="selected"';
								} else {
									$strSelected = "";
								}
								?>
										<option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected; ?>>
											<?php echo trim($rowOptions['optionName']); ?>
										</option>
										<?php
							}
						}
						?>
					</select>
				</span>

				<label>Legal form:</label>
				<span class="nw-grup" style="padding:0px;">
					<select name="legalform" id="legalform">
						<option value="0">Select</option>
						<?php
						$selectFields = [];
						$whereFields = [];
						$whereVals = [];

						$sqlOptions = "";
						$sqlOptions = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='currentemployments' ";
						$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
						if ($resOptions) {
							while ($rowOptions = mysqli_fetch_array($resOptions)) {
								if ($getdetails["legalform"] == $rowOptions['id']) {
									$strSelected = 'selected="selected"';
								} else {
									$strSelected = "";
								}
								?>
										<option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected; ?>>
											<?php echo trim($rowOptions['optionName']); ?>
										</option>
										<?php
							}
						}
						?>
					</select>
				</span>

				<label>Employees:</label>
				<span class="nw-grup" style="padding:0px;">
					<select name="employees" id="employees">
						<option value="0">Select</option>
						<?php
						$selectFields = [];
						$whereFields = [];
						$whereVals = [];

						$sqlOptions = "";
						$sqlOptions = "SELECT id,optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='currentemployments' ";
						$resOptions = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
						if ($resOptions) {
							while ($rowOptions = mysqli_fetch_array($resOptions)) {
								if ($getdetails["employees"] == $rowOptions['id']) {
									$strSelected = 'selected="selected"';
								} else {
									$strSelected = "";
								}
								?>
										<option value="<?php echo trim($rowOptions['id']); ?>" <?php echo $strSelected; ?>>
											<?php echo trim($rowOptions['optionName']); ?>
										</option>
										<?php
							}
						}
						?>
					</select>
				</span>

				<label>Company website:</label>
				<input type="text" name="companywebsite" id="companywebsite"
					value="<?php echo $getdetails["companywebsite"]; ?>" />
			</div>
			<label>Location<span class="reqstar">*</span>:</label>
			<input type="text" name="jobLocation" id="jobLocation"
				value="<?php echo htmlspecialchars($getdetails['jobLocation'] ?? ''); ?>" class="validate" maxlength="250"
				onKeyUp="hideerrordiv(this.id);" />

			<label><strong>Period</strong></label>

			<div class="exprnc-date">
				<div style="float:left;">
					<span style="padding:10px 10px 10px 0px;">From<span class="reqstar">*</span></span>
					<select name="frommonth" id="frommonth" class="validate" onchange="hideerrordiv(this.id);">
						<option value="0">Month</option>
						<?php
						for ($m = 1; $m <= 12; $m++) {
							if ($getdetails["frommonth"] == $m) {
								$strSelected = 'selected="selected"';
							} else {
								$strSelected = "";
							}
							?>
								<option value="<?php echo $m; ?>" <?php echo $strSelected; ?>><?php echo $m; ?></option>
								<?php
						}
						?>
					</select>

					<select name="fromyear" id="fromyear" class="validate" onchange="hideerrordiv(this.id);">
						<option value="0">Year</option>
						<?php
						for ($y = date('Y'); $y >= 1900; $y--) {
							if ($getdetails["fromyear"] == $y) {
								$strSelected = 'selected="selected"';
							} else {
								$strSelected = "";
							}
							?>
								<option value="<?php echo $y; ?>" <?php echo $strSelected; ?>><?php echo $y; ?></option>
								<?php
						}
						?>
					</select>
				</div>

				<div id="fromyearmonthdiv"
					style=" float:left; margin-right:10px;  display:<?php if ($getdetails["currentPosition"] == 1) { ?>none<?php } else { ?>block<?php } ?>;">
					<span style="padding:10px 10px 10px 10px;">To<span class="reqstar">*</span></span>
					<select name="tomonth" id="tomonth" class="validate" onchange="hideerrordiv(this.id);">
						<option value="0">Month</option>
						<?php
						for ($m = 1; $m <= 12; $m++) {
							if ($getdetails["tomonth"] == $m) {
								$strSelected = 'selected="selected"';
							} else {
								$strSelected = "";
							}
							?>
								<option value="<?php echo $m; ?>" <?php echo $strSelected; ?>><?php echo $m; ?></option>
								<?php
						}
						?>
					</select>
					<select name="toyear" id="toyear" class="validate" onchange="hideerrordiv(this.id);">
						<option value="0">Year</option>
						<?php
						for ($y = date('Y'); $y >= 1900; $y--) {
							if ($getdetails["toyear"] == $y) {
								$strSelected = 'selected="selected"';
							} else {
								$strSelected = "";
							}
							if ($getdetails["fromyear"] > $y) {
								$strdisabled = 'disabled="disabled"';
							} else {
								$strdisabled = "";
							}
							?>
								<option value="<?php echo $y; ?>" <?php echo $strSelected; ?>		 		<?php echo $strdisabled; ?>>
									<?php echo $y; ?>
								</option>
								<?php
						}
						?>
					</select>
				</div>

				<div style="float:left;">
					<span style="padding: 10px;display: block;"><input type="checkbox" name="currentPosition"
							id="currentPosition" value="1" <?php if (($getdetails["currentPosition"] ?? 0) == 1) {
								echo "checked";
							} ?> />
						Current position

						Current position</span>
				</div>

			</div>






			<label>Description:</label>
			<textarea name="positiondetail" rows="3" maxlength="2000"
				id="positiondetail"><?php echo htmlspecialchars($getdetails["positiondetail"] ?? ""); ?></textarea>

			<div class="popup-fttr">
				<?php if (isset($_POST['id']) && $_REQUEST['id'] != '') { ?>
						<!--<button style="background-color:#ef4b4b;margin: auto;margin-bottom: 15px;" type="button" onclick="closefuncommonpopupwin();alertpopupmain('<?php echo $_REQUEST['id']; ?>','deleteprofexp');">Delete</button>-->
				<?php } ?>

				<button type="button" onClick="formValidation('frmprofessinalexp');" class="konecttbtn">Save</button>
				<input type="hidden" name="action" id="action" value="saveprofessinalexp">
				<input type="hidden" name="professionalid" id="professionalid"
					value="<?php echo htmlspecialchars($_REQUEST['id'] ?? ''); ?>">

			</div>
		</form>
		<script>
			$("#jobTitle").focus();

			$("#currentPosition").click(function () {
				if ($(this).is(":checked")) {

					// $("option:selected").prop("selected", false);

					$("#fromyearmonthdiv").hide();
					$("#tomonth").removeClass('validate');
					$("#toyear").removeClass('validate');
				}
				else {
					$("#fromyearmonthdiv").show();
					$("#tomonth").addClass('validate');
					$("#toyear").addClass('validate');
				}
			});

			$('document').ready(function () {
				$('#fromyear').on('change', function () {
					var value = $(this).val();
					$('select option').prop("disabled", false);
					$("#toyear option").each(function () {

						if ($(this).val() < value) {
							$(this).prop("disabled", true);
						}
						if ($(this).val() == 0) {
							$('select option').prop("disabled", false);
						}

					});
				});
			});
		</script>
		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'educationalbg') {
	if (isset($_POST['id']) && $_REQUEST['id'] != '') {

		$aa = "SELECT * from " . _EDUCATIONAL_BACKGROUND_TABLE_ . " WHERE id= " . decodeStr(trim($_REQUEST['id'])) . " and userId=" . $_SESSION['sessUserId'] . " ";
		$res5 = mysqli_query($conn, $aa);
		$getdetails = mysqli_fetch_array($res5);

	}

	?>

		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div class="tagbox" id="msgcontactdiv" style=""></div>


			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>

			<label>School or University<span class="reqstar">*</span>:</label>
			<input type="text" name="university" id="university"
				value="<?php echo htmlspecialchars($getdetails['university'] ?? ''); ?>" class="validate" maxlength="250"
				onKeyUp="hideerrordiv(this.id);" />

			<script>
				$("#university").focus();
			</script>
			<label>Field of study<span class="reqstar">*</span>:</label>
			<span class="nw-grup" style="padding:0px;">
				<input type="text" name="fieldofstudy" id="fieldofstudy"
					value="<?php echo htmlspecialchars($getdetails["fieldofstudy"] ?? ''); ?>" class="validate" maxlength="250"
					onKeyUp="hideerrordiv(this.id);" />
			</span>
			<label>(Future) degree:</label>
			<input type="text" name="degree" id="degree" value="<?php echo htmlspecialchars($getdetails["degree"] ?? ''); ?>" />
			<label><strong>Period</strong></label>

			<div class="exprnc-date edu-bg">
				<div style="float:left;">
					<span style="display: block; padding:10px 10px 10px 0px;">From<span class="reqstar">*</span></span>
					<select name="frommonth" id="frommonth" class="validate" onchange="hideerrordiv(this.id);">
						<option value="0">Month</option>
						<?php
						for ($m = 1; $m <= 12; $m++) {
							if ($getdetails["frommonth"] == $m) {
								$strSelected = 'selected="selected"';
							} else {
								$strSelected = "";
							}
							?>
								<option value="<?php echo $m; ?>" <?php echo $strSelected; ?>><?php echo $m; ?></option>
								<?php
						}
						?>
					</select>

					<select name="fromyear" id="fromyear" class="validate" onchange="hideerrordiv(this.id); showcontent();">
						<option value="0">Year</option>
						<?php
						for ($y = date('Y'); $y >= 1900; $y--) {
							if ($getdetails["fromyear"] == $y) {
								$strSelected = 'selected="selected"';
							} else {
								$strSelected = "";
							}
							?>
								<option value="<?php echo $y; ?>" <?php echo $strSelected; ?>><?php echo $y; ?></option>
								<?php
						}
						?>
					</select>
				</div>
				<script>
					function showcontent() {
						var fromyear = $("#fromyear").val();
						if (fromyear != 0) {
							$(".fromyearedu").show();
						}
						else {
							$(".fromyearedu").hide();
						}

					}
				</script>
				<div id="fromyearmonthdiv" class="fromyearedu"
					style=" float:left; margin-right:10px; display:<?php if ($getdetails["tomonth"] != 0) { ?>block<?php } else { ?>none<?php } ?>;">
					<span style="display: block; padding:10px 10px 10px 10px;">To<span class="reqstar">*</span></span>
					<select name="tomonth" id="tomonth" class="validate" onchange="hideerrordiv(this.id);">
						<option value="0">Month</option>
						<?php
						for ($m = 1; $m <= 12; $m++) {
							if ($getdetails["tomonth"] == $m) {
								$strSelected = 'selected="selected"';
							} else {
								$strSelected = "";
							}
							?>
								<option value="<?php echo $m; ?>" <?php echo $strSelected; ?>><?php echo $m; ?></option>
								<?php
						}
						?>
					</select>
					<select name="toyear" id="toyear" class="validate" onchange="hideerrordiv(this.id);">
						<option value="0">Year</option>
						<?php
						for ($y = date('Y'); $y >= 1900; $y--) {
							if ($getdetails["toyear"] == $y) {
								$strSelected = 'selected="selected"';
							} else {
								$strSelected = "";
							}

							if ($getdetails["fromyear"] > $y) {
								$strdisabled = 'disabled="disabled"';
							} else {
								$strdisabled = "";
							}
							?>
								<option value="<?php echo $y; ?>" <?php echo $strSelected; ?>		 		<?php echo $strdisabled; ?>>
									<?php echo $y; ?>
								</option>
								<?php
						}
						?>
					</select>
				</div>


			</div>


			<label>Specialisation:</label>
			<textarea name="specialisedsubjects" rows="3" maxlength="2000"
				id="specialisedsubjects"><?php echo htmlspecialchars($getdetails["specialisedsubjects"] ?? ''); ?></textarea>
			<label>Description:</label>
			<textarea name="description" rows="3" maxlength="2000"
				id="description"><?php echo htmlspecialchars($getdetails["description"] ?? ''); ?></textarea>
			<div class="popup-fttr">
				<?php if (isset($_POST['id']) && $_REQUEST['id'] != '') { ?>
						<!--<button style="background-color:#ef4b4b; float:left; margin-left:0px;" type="button" onclick="closefuncommonpopupwin();alertpopupmain('<?php echo $_REQUEST['id']; ?>','deleducational');">Delete</button>-->
				<?php } ?>
				<button type="button" onClick="formValidation('sendmsg');" class="konecttbtn">Save</button>
				<input type="hidden" name="action" id="action" value="saveeducationalbg">
				<input type="hidden" name="educationalid" id="educationalid"
					value="<?php echo htmlspecialchars($_REQUEST['id'] ?? ''); ?>">
			</div>
		</form>

		<script>
			$('document').ready(function () {
				$('#fromyear').on('change', function () {
					var value = $(this).val();
					$('select option').prop("disabled", false);
					$("#toyear option").each(function () {

						if ($(this).val() < value) {
							$(this).prop("disabled", true);
						}
						if ($(this).val() == 0) {
							$('select option').prop("disabled", false);
						}

					});
				});
			});


		</script>
		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'delgrp') { ?>

		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div class="tagbox" id="msgcontactdiv" style=""></div>
			<div id="errormsg" style="margin-bottom:10px;"></div>
			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>
			<label>Enter your account password<span class="reqstar">*</span></label>
			<input type="password" name="delgrppassword" id="delgrppassword" class="validate" onKeyUp="hideerrordiv(this.id);"
				maxlength="50" style="margin-bottom: 10px;" />
			<div style="font-size:12px; color:#999999; margin-bottom:10px;"><strong>Note</strong>: if you delete this group all
				the data will be lost (members, posts, likes, comments, images etc) which was associated with this group.</div>
			<div class="popup-fttr">

				<button style="background-color:#ef4b4b;" type="button" onClick="formValidation('sendmsg');">Delete</button>


				<input type="hidden" name="action" id="action" value="delgrp">
				<input type="hidden" name="gprid" id="gprid" value="<?php echo $_REQUEST['id']; ?>">
			</div>
		</form>

		<style type="text/css">
			form#sendmsg input {
				width: 100%;
				border: solid 1px #d0d0d0;
				padding: 10px;
				border-radius: 0;
			}

			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'share') { ?>

		<div id="shareboxouter">
			<form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post"
				target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
				<div style="margin-bottom:20px;overflow: hidden;">
					<div class="timlist"
						style="padding:0px;display: none; border:0px; box-shadow:0px 0px 0px #fff; border-bottom:1px solid #efefef; border-radius:0px;">
						<div class="hedr">
							<div class="prfl_img"> <a
									href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $userurl; ?>.html"><img
										src="<?php echo $fullurl; ?>uploads/<?php echo $myprofilePhoto; ?>"></a> </div>
							<div class="hdr_right"><a
									href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $userurl; ?>.html"><?php echo $myname; ?></a>
								<label class="time"><?php echo $jobTitle; ?> - <?php echo $companyName; ?></label>
							</div>
						</div>
					</div>
					<textarea name="sharepostText" id="sharepostText" placeholder="Say something about this..."
						style="height:80px; border:0px;"></textarea><input type="hidden" name="tageduserid" id="tageduserid"
						value="">
				</div>
				<div class="timlist" id="loadshareddata2"></div>

				<div style="margin-top:20px;width: 100%;float: left;">
					<select name="postshareType" id="postshareType" onchange="changesharefunval();" style="">
						<option value="1">Share with Public</option>
						<option value="2">Share with My Contacts</option>
						<option value="3">Send as Message</option>
						<option value="4">Share To External Social Media</option>
					</select>
				</div>
				<div class="popup-fttr" style="margin-top: 0;">

					<button type="submit" class="konecttbtn ">Share</button>
					<input type="hidden" name="action" id="action" value="postandshare">
					<input type="hidden" name="sharePostType" id="sharePostType"
						value="<?php echo $_REQUEST['sharePostType']; ?>">

					<input type="hidden" name="oldpostId" id="oldpostId" value="<?php echo $_REQUEST['id']; ?>">

					<textarea name="sharedata" id="sharedata" style="display:none;"></textarea>
				</div>


				<script>
					var secdiv = $('#txtarea<?php echo decodeStr(trim($_REQUEST['id'])); ?>').html();


					$('#loadshareddata2').html(secdiv);
					$('#sharedata').val('<div class="timlist sharedt" id="loadshareddatabox">' + secdiv + '</div>');

					function changesharefunval() {
						var postshareType = $('#postshareType').val();

						if (postshareType == 3) {
							sharefuncommonpopupwin('450px', 'auto', '<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo $_REQUEST['id']; ?>&type=sharewithmessage&sharePostType=<?php echo $_REQUEST['sharePostType']; ?>', '<span style="text-transform:none;">Share as a Messages</span>', '');
						}

						if (postshareType == 4) {
							sharefuncommonpopupwin('450px', 'auto', '<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo $_REQUEST['id']; ?>&type=sharewithexternalsocial&sharePostType=<?php echo $_REQUEST['sharePostType']; ?>', '<span style="text-transform:none;">Share</span>', '');
						}

					}
				</script>

			</form>
		</div>
		<div id="sharesuccess" style="display:none; text-align:center; font-size:15px;">
			Successfully shared
		</div>
		<style>
			.timlist.sharedt {
				pointer-events: none;
			}
		</style>
		<?php
}
?>
<?php if ($type == 'skillbox') { ?>
		<div style="text-align:center;">
			<form name="frmskills" id="frmskills" method="post" enctype="multipart/form-data">
				<label>Enter Skill<span class="reqstar">*</span></label>
				<input type="text" name="skills" id="skills" value="" maxlength="60" placeholder="Enter skill name"
					autocomplete="off" onKeyUp="hideerrordiv(this.id);">


				<div class="popup-fttr" style="margin-top:0; padding-bottom:0;">
					<a onclick="$('#sendmsgtocontactdiv').hide();$('#skills').val('');closefuncommonpopupwin();">Cancel</a>
					<button type="button" onclick="addskills();">Add</button>
				</div>
			</form>
		</div>
		<script>



			function randomNumberFromRange(min, max) {
				return Math.floor(Math.random() * (max - min + 1) + min);
			}

			function addskills() {
				var minNumber = 100;
				var maxNumber = 999;

				var number = randomNumberFromRange(minNumber, maxNumber);

				if ($.trim($("#skills").val()) != '') {
					var skill = $("#skills").val();
					var proSkills = $("#proSkills").val();

					$("#proSkills").val(proSkills + ',' + skill);

					$("#skilllist").append('<div class="skillb" id="sk' + number + '"><div id="dk' + number + '">' + skill + '</div><span onClick="dltskill(' + number + ');"><i class="fa fa-times"></i></span></div>');
					$('#sendmsgtocontactdiv').hide(); $('#skills').val(''); closefuncommonpopupwin();
				}
				else {
					$("#skills").addClass('redborderfield');
				}

				var proSkills = $("#proSkills").val();
				if (proSkills == '') {
					$("#skillsbox").addClass('redborderfield');
					$("#proSkills").addClass('validate');
				}
				else {
					$("#skillsbox").removeClass('redborderfield');
					$("#proSkills").removeClass('validate');
				}

			}





			$("#skills").focus();
		</script>
		<style>
			.nw-grup {
				padding: 0;
			}
		</style>

<?php } ?>

<?php if ($type == 'applyproject' && $_REQUEST['uid'] != '') {
	$selectFields = [];
	$whereFields = [];
	$whereVals = [];

	$sqlLogin = "";
	$sqlLogin = "select jobTitle,companyName,firstName,lastName,userurl from " . _USERS_MASTER_TABLE_ . " where userId='" . decodeStr($_REQUEST['uid']) . "' ";
	$resLogin = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
	if ($resLogin) {
		while ($rowLogin = mysqli_fetch_array($resLogin)) {
			$jobTitle1 = $rowLogin["jobTitle"];
			$companyName1 = $rowLogin["companyName"];
			$myfirstName1 = $rowLogin["firstName"];
			$mylastName1 = $rowLogin["lastName"];
			$myname1 = ucfirst($rowLogin["firstName"]) . ' ' . ucfirst($rowLogin["lastName"]);
			$userurl1 = $rowLogin["userurl"];

			$userurl1 = $fullurl . 'profile/' . $_REQUEST['uid'] . '/' . $userurl1 . '.html';
		}
	}

	$sqlProjects = "SELECT * from " . _PROJECT_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['id']) . " ";
	$resProjects = mysqli_query($conn, $sqlProjects) or die(mysqli_error($conn));
	$rowProjects = mysqli_fetch_array($resProjects);
	?>
		<style>
			.popuptitle {
				display: none;
			}

			.nw-grup {
				padding: 0px
			}

			.crt-grp-popup .popup-inner {
				border: 0px;
				border-radius: 0px;
				box-shadow: 0px 0px 5px #5f5f5f;
				width: 600px;
				max-width: 600px;
			}
		</style>
		<div id="sendtxtpromsg" style="display:none;"></div>
		<form style=" padding:15px;" enctype="multipart/form-data" name="frmposthomerecommend" id="frmposthomerecommend"
			method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">

			<div class="tagbox" id="msgcontactdiv" style=""></div>


			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>
			<div id="popupcontentproj">
				<div>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="3%" align="left" valign="top"><img
									src="<?php echo $fullurl . 'uploads/' . $myprofilePhoto; ?>"
									style="width:80px;border-radius: 50%;" /></td>
							<td width="97%" align="left" valign="top" style=" padding-left:20px;">

								<div style="margin-bottom:10px; overflow:hidden;">
									<div style="float:left; padding:3px 6px; background-color:#F8F8F8; border:1px #ccc solid;">
										<?php echo $myname1; ?>
									</div>
								</div>
								<input type="text" name="userSubject" id="userSubject"
									value="I'm interested in your <?php echo stripslashes($rowProjects['projectTitle']); ?> project."
									style="background:white; cursor:text;" maxlength="200" class="validate"
									onKeyUp="hideerrordiv(this.id);" />


								<textarea name="projectdescription" rows="3" id="projectdescription" maxlength="1000"
									style="height:250px;" class="validate" onKeyUp="hideerrordiv(this.id);">Hello <?php echo $myfirstName1; ?>

																																				I'm interested in your "<?php echo stripslashes($rowProjects['projectTitle']); ?>" (<?php echo $fullurl; ?>preview-project.html?projId=<?php echo $_REQUEST['id']; ?>) project. 

																																				Please feel free to check out my <?php echo $companNameTitle; ?> profile to see whether you think we could work together:
																																				<?php echo $fullurl; ?>profile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $userurl; ?>.html

																																				If you'd like to contact me, just reply to this message.

																																				Kind regards,
																																				<?php echo $myname; ?></textarea>
							</td>
						</tr>
					</table>


				</div>

				<div class="popup-fttr">

					<a
						onClick="$('#sendmsgtocontactdiv').hide();$('#projectdescription').val('');closefuncommonpopupwin();">Cancel</a>
					<button type="button" onClick="formValidation('frmposthomerecommend');">Send</button>
					<input type="hidden" name="action" id="action" value="applyproject">
					<input type="hidden" name="projetvname" id="projetvname"
						value="<?php echo stripslashes($rowProjects['projectTitle']); ?>">
					<input type="hidden" name="projid" id="projid" value="<?php echo $_REQUEST['id']; ?>">
					<input type="hidden" name="uid" id="uid" value="<?php echo $_REQUEST['uid']; ?>">
				</div>
			</div>
		</form>
		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>

<?php } ?>

<?php if ($type == 'viewcontacts') {
	?>
		<div style="height:300px; overflow:auto;">
			<ul class="requst-list" id="notice-list">
				<?php
				$n = 0;
				$selectFields = [];
				$whereFields = [];
				$whereVals = [];

				$sqlLogin = "";
				$sqlLogin = "select distinct(userId) from " . _CONTACT_MASTER_TABLE_ . " where contactId='" . decodeStr($_REQUEST["id"]) . "' and status=1 ";
				$resLogin = getRecords(_CONTACT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
				if ($resLogin) {
					while ($rowLogin = mysqli_fetch_array($resLogin)) {
						$z = 1;
						$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin["userId"] . "";
						$b = mysqli_query($conn, $a);
						$userres = mysqli_fetch_array($b);

						$friendnameurl = $userres['userurl'];
						if ($userres["profilePhoto"] != '') {
							$userphoto = $userres["profilePhoto"];
						} else {
							$userphoto = 'user-placeholder.jpg';
						}

						$mycountryName = $userres["countryName"];
						$mystateName = $userres["cityName"];
						$mylocationName = $userres["locationName"];
						$mycompanyName = $userres["companyName"];
						$myjobTitle = $userres["jobTitle"];


						?>
								<li>
									<div class="rquest-box">
										<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
											target="_blank" class="rqst-img"><img
												src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>

										<div class="rqst-right">
											<div class="rquest-middle">
												<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
													target="_blank"><?php echo $userres["firstName"]; ?>			 			<?php echo $userres["lastName"]; ?></a>
												<div style="font-size:12px; color:#9a9a9a;"><?php echo $userres["jobTitle"]; ?> at
													<?php echo $userres["companyName"]; ?>
												</div>
											</div>
										</div>
									</div>
								</li>
								<?php

								$n++;
					}

				}
				?>
				<?php if ($z != 1) { ?>
						<div style="padding:0px; text-align:center; margin-top:100px;">No any contacts</div><?php } ?>
			</ul>

		</div>

<?php } ?>

<?php if ($type == 'addcmpupdates' && $_REQUEST['id'] != '') {
	?>
		<style>
			.popuptitle {
				display: none;
			}

			.nw-grup {
				padding: 0px
			}

			.crt-grp-popup .popup-inner {
				border: 0px;
				border-radius: 0px;
				box-shadow: 0px 0px 5px #5f5f5f;
				width: 600px;
				max-width: 600px;
			}
		</style>
		<div id="sendtxtpromsg" style="display:none;"></div>
		<form style=" padding:15px;" enctype="multipart/form-data" name="frmposthomerecommend" id="frmposthomerecommend"
			method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">

			<div class="tagbox" id="msgcontactdiv" style=""></div>


			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>
			<div id="popupcontentproj">
				<div>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="100%" align="left" valign="top">

								<label>Headline<span class="reqstar">*</span></label>
								<input type="text" name="companyheadline" id="companyheadline"
									style="background:white; cursor:text;" maxlength="200" placeholder="Enter headline here" />

								<label>Text<span class="reqstar">*</span></label>
								<textarea name="companyupdatedescription" id="companyupdatedescription" rows="3"
									maxlength="1200" style="height:250px;"
									placeholder="Update text(max. 1200 characters)"></textarea>
							</td>
						</tr>
					</table>


				</div>

				<div class="popup-fttr">

					<a
						onClick="$('#sendmsgtocontactdiv').hide();$('#companyupdatedescription').val('');$('#companyheadline').val('');closefuncommonpopupwin();">Cancel</a>
					<button type="submit">Save</button>
					<input type="hidden" name="action" id="action" value="addcmpupdates">
					<input type="hidden" name="cmpid" id="cmpid" value="<?php echo $_REQUEST['id']; ?>">
				</div>
			</div>
		</form>
		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
		<script>
			function reloadPage() {
				location.reload(true);
			}
		</script>
<?php } ?>

<?php if ($type == 'sharewithmessage') { ?>
		<div id="shareboxouter">
			<form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post"
				target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
				<div style="overflow:hidden;">
					<div class="timlist"
						style="padding:0px;display: none; border:0px; box-shadow:0px 0px 0px #fff; border-bottom:1px solid #efefef; border-radius:0px;">
						<div class="hedr">
							<div class="prfl_img"> <a
									href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $userurl; ?>.html"><img
										src="<?php echo $fullurl; ?>uploads/<?php echo $myprofilePhoto; ?>"></a> </div>
							<div class="hdr_right"><a
									href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $userurl; ?>.html"><?php echo $myname; ?></a>
								<label class="time"><?php echo $jobTitle; ?> - <?php echo $companyName; ?></label>
							</div>
						</div>
					</div>
					<a onClick="sharefuncommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo $_REQUEST['id']; ?>&type=share&sharePostType=<?php echo $_REQUEST['sharePostType']; ?>','Share','<?php echo $rowResults['id']; ?>');"
						class="back-erow" style=" padding-top: 15px;display: inline-block;"><i class="fa fa-arrow-left"
							aria-hidden="true"></i> Back</a>
				</div>
				<div class="timlist" id="loadshareddata2" style="padding:0px;">
					<div class="">
						<ul class="requst-list" id="notice-list" style="max-height:350px; overflow:auto;">
							<?php

							$n = 0;
							$selectFields = [];
							$whereFields = [];
							$whereVals = [];

							$sqlLogin = "";
							$sqlLogin = "select * from " . _CONTACT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and status=1 ";
							$resLogin = getRecords(_CONTACT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
							if ($resLogin) {
								while ($rowLogin = mysqli_fetch_array($resLogin)) {

									$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin["contactId"] . "";
									$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
									$userres2 = mysqli_fetch_array($b);


									// Default values in case data is missing
									$friendnameurl2 = '';
									$userphoto2 = 'user-placeholder.jpg';
									$mycountryName = '';
									$mystateName = '';
									$mylocationName = '';

									// Check if $userres2 is a valid array
									if (is_array($userres2) && !empty($userres2)) {

										$friendnameurl2 = isset($userres2['userurl']) ? trim($userres2['userurl']) : '';

										if (!empty($userres2["profilePhoto"])) {
											$userphoto2 = trim($userres2["profilePhoto"]);
										}

										$mycountryName = isset($userres2["countryName"]) ? trim($userres2["countryName"]) : '';
										$mystateName = isset($userres2["cityName"]) ? trim($userres2["cityName"]) : '';
										$mylocationName = isset($userres2["locationName"]) ? trim($userres2["locationName"]) : '';
									}
									?>


											<li class="msguserscheckbox">
												<div class="msgcheckbox"><input type="checkbox" name="check_list[]" id="check_list"
														value="<?php echo encodeStr($userres2["userId"]); ?>" /></div>
												<div class="rquest-box">
													<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2["userId"]); ?>/<?php echo $friendnameurl2; ?>.html"
														target="_blank" class="rqst-img"><img
															src="<?php echo $fullurl; ?>uploads/<?php echo $userphoto2; ?>"></a>

													<div class="rqst-right">
														<div class="rquest-middle">
															<?php
															if (is_array($userres2) && !empty($userres2)) {
																$profileUrl = $fullurl . "profile/" . encodeStr($userres2["userId"]) . "/" . $friendnameurl2 . ".html";
																$fullName = trim($userres2["firstName"] ?? '') . " " . trim($userres2["lastName"] ?? '');
																$jobTitle = trim($userres2["jobTitle"] ?? '');
																$company = trim($userres2["companyName"] ?? '');
																?>
																	<a href="<?php echo $profileUrl; ?>" target="_blank">
																		<?php echo htmlspecialchars($fullName); ?>
																	</a>
																	<div style="font-size:12px; color:#9a9a9a;">
																		<?php echo htmlspecialchars($jobTitle); ?> at
																		<?php echo htmlspecialchars($company); ?>
																	</div>
																	<?php
															} else {
																echo "<span style='color:red;'>User details not found.</span>";
															}
															?>
														</div>
													</div>

												</div>
											</li>
											<?php

											$n++;
								}

							}
							?>
						</ul>
					</div>
				</div>

				<div style="">
					<div class="popup-fttr">


						<a onclick="$('#sharepostText').val('');closefuncommonpopupwin();">Cancel</a>
						<button type="submit">Share</button>
						<input type="hidden" name="action" id="action" value="postandsharewithmsg">
						<input type="hidden" name="sharePostType" id="sharePostType"
							value="<?php echo $_REQUEST['sharePostType']; ?>">

						<input type="hidden" name="oldpostId" id="oldpostId" value="<?php echo $_REQUEST['id']; ?>">

					</div>

				</div>

			</form>
		</div>


		<div id="sharesuccess" style="display:none; text-align:center; font-size:15px;">
			Successfully shared
		</div>




		<?php
}
?>

<?php if ($type == 'delcmp') { ?>
		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div class="tagbox" id="msgcontactdiv" style=""></div>
			<div id="errormsg" style="margin-bottom:10px;"></div>
			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>
			<label>Enter your account password<span class="reqstar">*</span></label>
			<input type="password" name="delgrppassword" id="delgrppassword" maxlength="50" class="validate"
				onKeyUp="hideerrordiv(this.id);" />
			<div style="font-size:12px; color:#999999; margin-bottom:10px;"><strong>Note</strong>: if you remove this company
				all the data will be lost (followers, updates, images etc) which was associated with this company.</div>
			<div class="popup-fttr">

				<button style="background-color:#ef4b4b;" onclick="formValidation('sendmsg');" type="button">Delete</button>


				<input type="hidden" name="action" id="action" value="delcmp">
				<input type="hidden" name="cmpid" id="cmpid" value="<?php echo $_REQUEST['id']; ?>">
			</div>
		</form>
		<style type="text/css">
			form#sendmsg input {
				width: 100%;
				border: solid 1px #d0d0d0;
				padding: 10px;
				border-radius: 0;
			}

			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'reportpost' && $_REQUEST['id'] != '') { ?>
		<form enctype="multipart/form-data" name="frmposthomerecommend" id="frmposthomerecommend" method="post"
			target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">

			<div id="selectposition">
				<ul class="report-list">
					<?php
					$selectFields = [];
					$whereFields = [];
					$whereVals = [];

					$sqlBlkReason = "";
					$sqlBlkReason = "SELECT * FROM " . _BLOCK_REASON_MASTER_TABLE_ . " order by srNo desc ";
					$resBlkReason = getRecords(_BLOCK_REASON_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlBlkReason);
					if ($resBlkReason) {
						while ($rowBlkReason = mysqli_fetch_array($resBlkReason)) {
							?>
									<li>
										<label>
											<input type="radio" name="blockTitleId" id="blockTitleId"
												value="<?php echo encodeStr($rowBlkReason["id"]); ?>">
											<span></span>

											<?php echo stripslashes($rowBlkReason["blockTitle"]); ?> </label>
									</li>


									<?php

						}
					}
					?>
				</ul>
			</div>


			<input type="hidden" id="action" name="action" value="reportpost" />
			<input type="hidden" id="hiddenpid" name="hiddenpid" value="<?php echo $_REQUEST["id"]; ?>" />


			<div style="text-align:center;">
				<div class="popup-fttr" style="float:left; background-color:#fff;  margin-top:0px; text-align:center;">

					<button id="submitbtn" type="submit" style="float:none;margin:5px;" class="konecttbtn">Submit</button>

				</div>
			</div>
		</form>


<?php } ?>

<?php if ($type == 'changeusremail') { ?>

		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div style="position:relative;" id="searchcontactmsgouter">This is the e-mail address you use to log in and to which
				we send you notifications: <strong><?php echo $_SESSION['sessEmail']; ?></strong></div><br />


			<label>E-mail address<span class="reqstar">*</span></label>
			<input type="text" name="usremail" id="usremail" value="<?php echo $_SESSION['sessEmail']; ?>" maxlength="60" />
			<script>
				$("#usremail").focus();
			</script>

			<div class="popup-fttr">
				<a onClick="$('#sendmsgtocontactdiv').hide();$('#txtmsg').val('');closefuncommonpopupwin();">Cancel</a>
				<button type="submit">Save</button>
				<input type="hidden" name="action" id="action" value="changeusremail">
			</div>
		</form>
		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'changepass') { ?>

		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div id="errormsgpass" style="color:#C02621; font-size:12px; margin-bottom: 10px; margin-top: -10px;"></div>
			<label>Old password<span class="reqstar">*</span></label>
			<input type="password" name="oldpass" id="oldpass" value="" maxlength="16" class="validate"
				onKeyUp="hideerrordiv(this.id);" />
			<label>New password <span class="reqstar">*</span></label>
			<input type="password" name="newpass" id="newpass" value="" maxlength="16" class="validate"
				onKeyUp="hideerrordiv(this.id);" />
			<label>New password confirmation<span class="reqstar">*</span></label>
			<input type="password" name="confirmpass" id="confirmpass" value="" maxlength="16" class="validate"
				onKeyUp="hideerrordiv(this.id);" />
			<script>
				$("#oldpass").focus();
			</script>

			<div class="popup-fttr">
				<a
					onClick="$('#sendmsgtocontactdiv').hide();$('#oldpass').val('');$('#newpass').val('');$('#confirmpass').val('');closefuncommonpopupwin();">Cancel</a>
				<button type="button" onClick="formValidation('sendmsg');">Save</button>
				<input type="hidden" name="action" id="action" value="changepass">
			</div>
		</form>
		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'personaldatasetting') { ?>

		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">



			<div id="errormsgpass" style="color:#C02621; font-size:12px;"></div>
			<label>First Name<span class="reqstar">*</span></label>
			<input type="text" name="firstName" id="firstName" value="<?php echo sanitizedboutput($myfirstName); ?>"
				class="validate" onKeyUp="hideerrordiv(this.id);">
			<label>Last Name<span class="reqstar">*</span></label>
			<input type="text" name="lastName" id="lastName" value="<?php echo sanitizedboutput($mylastName); ?>"
				class="validate" onKeyUp="hideerrordiv(this.id);">
			<div class="rgstr-gender">
				<div class="genderlavel">Gender<span class="reqstar">*</span></div>
				<input type="radio" name="gender" id="male" value="Male" <?php if ($mygender == 'Male' || $mygender == '') {
					echo 'checked';
				} ?>>
				<label for="male"> Male </label>
				<input type="radio" name="gender" id="female" value="Female" <?php if ($mygender == 'Female') {
					echo 'checked';
				} ?>>
				<label for="female">Female </label>
			</div>
			<label>Date of birth<span class="reqstar">*</span></label>
			<div class="birth"> <select name="day" id="day" style="width:110px;" class="validate"
					onChange="hideerrordiv(this.id);">
					<option value="0">Day</option>
					<?php
					for ($d = 1; $d <= 31; $d++) {
						if ($day == $d) {
							$strSelected = 'selected="selected"';
						} else {
							$strSelected = "";
						}
						?>
							<option value="<?php echo $d; ?>" <?php echo $strSelected; ?>><?php echo $d; ?></option>
							<?php
					}
					?>
				</select>
				&nbsp;&nbsp;
				<select name="month" id="month" style="width:110px;" class="validate" onChange="hideerrordiv(this.id);">
					<option value="0">Month</option>
					<?php
					for ($m = 1; $m <= 12; $m++) {
						if ($month == $m) {
							$strSelected = 'selected="selected"';
						} else {
							$strSelected = "";
						}
						?>
							<option value="<?php echo $m; ?>" <?php echo $strSelected; ?>>
								<?php //echo $m; ?>		 		<?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
							</option>
							<?php
					}
					?>
				</select>
				&nbsp;&nbsp;
				<select name="year" id="year" style="width:110px;" class="validate" onChange="hideerrordiv(this.id);">
					<option value="0">Year</option>

					<?php
					for ($y = date('Y', strtotime('-10 years')); $y >= 1920; $y--) {
						if ($year == $y) {
							$strSelected = 'selected="selected"';
						} else {
							$strSelected = "";
						}
						?>
							<option value="<?php echo $y; ?>" <?php echo $strSelected; ?>><?php echo $y; ?></option>
							<?php
					}
					?>

					<?php /*?><?php
for($y=1920; $y<=date('Y', strtotime('-10 years'));$y++)
{
if($year==$y){ $strSelected='selected="selected"';}else{ $strSelected="";}
?>
<option value="<?php echo $y; ?>" <?php echo $strSelected;?> ><?php echo $y; ?></option>
<?php
}
?><?php */ ?>
				</select>
			</div>

			<label>Country<span class="reqstar">*</span></label>
			<select name="countryName" id="countryName" onChange="selectstate('<?php if ($mystateName != '') {
				echo sanitizedboutput($mystateName);
			} else {
				echo '0';
			} ?>');hideerrordiv(this.id);" class="validate">
				<option value="">Select</option>
				<?php
				$selectFields;
				$whereFields;
				$whereVals;

				$sqlOptions1 = "";
				$sqlOptions1 = "SELECT country_name FROM " . _COUNTRIES_TABLE_ . " ORDER BY country_name ";
				$resOptions1 = getRecords(_COUNTRIES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
				if ($resOptions1) {
					while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
						if ($mycountryName == $rowOptions1['country_name']) {
							$strSelected = 'selected="selected"';
						} else {
							$strSelected = "";
						}
						?>
								<option value="<?php echo trim($rowOptions1['country_name']); ?>" <?php echo $strSelected; ?>>
									<?php echo trim($rowOptions1['country_name']); ?>
								</option>
								<?php
					}
				}
				?>
			</select>

			<label>State<span class="reqstar">*</span></label>
			<select name="cityName" id="cityName" class="validate" onChange="hideerrordiv(this.id);">

			</select>

			<label>City<span class="reqstar">*</span></label>
			<input type="text" name="locationName" id="locationName" value="<?php echo sanitizedboutput($mylocationName); ?>"
				class="validate" onKeyUp="hideerrordiv(this.id);">

			<label>Time Zone<span class="reqstar">*</span></label>
			<select name="timeZone" id="timeZone" class="validate" onChange="hideerrordiv(this.id);">
				<option value="">Select</option>
				<?php
				$selectFields = [];
				$whereFields = [];
				$whereVals = [];

				$sqlOptions1 = "";
				$sqlOptions1 = "SELECT TimeZone FROM " . _TIME_ZONE_MASTER_TABLE_ . " order by TimeZone ";
				$resOptions1 = getRecords(_TIME_ZONE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);
				if ($resOptions1) {
					while ($rowOptions1 = mysqli_fetch_array($resOptions1)) {
						if ($TimeZone == $rowOptions1['TimeZone']) {
							$strSelected = 'selected="selected"';
						} else {
							$strSelected = "";
						}
						?>
								<option value="<?php echo trim($rowOptions1['TimeZone']); ?>" <?php echo $strSelected; ?>>
									<?php echo trim($rowOptions1['TimeZone']); ?>
								</option>
								<?php
					}
				}
				?>
			</select>
			<script>
				$("#firstName").focus();
				function selectstate(statename) {
					var countryName = encodeURIComponent($("#countryName").val());
					var statename = encodeURIComponent(statename);

					$("#cityName").load('loadstate.php?countryId=' + countryName + '&statename=' + statename);
					//alert(countryName);

				}

				selectstate('<?php if ($mystateName != '') {
					echo sanitizedboutput($mystateName);
				} else {
					echo '0';
				} ?>');



			</script>

			<div class="popup-fttr">
				<a
					onClick="$('#sendmsgtocontactdiv').hide();$('#oldpass').val('');$('#newpass').val('');$('#confirmpass').val('');closefuncommonpopupwin();">Cancel</a>
				<button type="button" onClick="formValidation('sendmsg');">Save</button>
				<input type="hidden" name="action" id="action" value="personaldatasetting">
			</div>
		</form>

		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>



<?php if ($type == 'settings' && $_REQUEST['section'] != '') {

	$sql = "SELECT * from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId= " . $_SESSION['sessUserId'] . " ";
	$getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));

	$getResults = mysqli_fetch_array($getSql);

	?>

		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div style="display:<?php if ($_REQUEST['section'] == 1) {
				echo 'block';
			} else {
				echo 'none';
			} ?>;">
				<label>The "Contacts" tab in my profile is visible to</label>
				<div class="birth"> <select name="contactTabvisible" id="contactTabvisible">
						<option value="My contacts only" <?php if ($getResults["contactTabvisible"] == "My contacts only") {
							echo "selected";
						} ?>>My contacts only</option>
						<option value="All members" <?php if ($getResults["contactTabvisible"] == "All members") {
							echo "selected";
						} ?>>All members</option>
					</select>
				</div>

				<label> The "Activity" tab in my profile is visible to</label>
				<div class="birth"> <select name="activityTabVisible" id="activityTabVisible">
						<option value="Nobody" <?php if ($getResults["activityTabVisible"] == "Nobody") {
							echo "selected";
						} ?>>
							Nobody
						</option>
						<option value="My contacts only" <?php if ($getResults["activityTabVisible"] == "My contacts only") {
							echo "selected";
						} ?>>My contacts only</option>
						<option value="All members" <?php if ($getResults["activityTabVisible"] == "All members") {
							echo "selected";
						} ?>>All members</option>
					</select>
				</div>
				<div class="checkboxlevels"><label>
						<input type="checkbox" name="allowSearchEngines" id="allowSearchEngines" value="1" <?php if ($getResults["allowSearchEngines"] == 1) {
							echo "checked";
						} ?> /> Allow search engines to find my
						profile
					</label></div>
				<div class="checkboxlevels"><label>
						<input type="checkbox" name="contactListVisible" id="contactListVisible" value="1" <?php if ($getResults["contactListVisible"] == 1) {
							echo "checked";
						} ?> /> Who can see your Contact list
					</label></div>

			</div>

			<div style="display:<?php if ($_REQUEST['section'] == 2) {
				echo 'block';
			} else {
				echo 'none';
			} ?>;" class="notif-sttng-box">
				<label style="display:none;">I want to receive messages from</label>
				<div style="display:none;" class="birth"> <select name="iWantRecieveMsg" id="iWantRecieveMsg">
						<option value="My contacts only" <?php if ($getResults["iWantRecieveMsg"] == "My contacts only") {
							echo "selected";
						} ?>>My contacts only</option>
						<option value="All members" <?php if ($getResults["iWantRecieveMsg"] == "All members") {
							echo "selected";
						} ?>>All members</option>
					</select>
				</div>
				<div class="checkboxlevels"><label>
						<input type="checkbox" name="postGroupSearchEngine" id="postGroupSearchEngine" value="1" <?php if ($getResults["postGroupSearchEngine"] == 1) {
							echo "checked";
						} ?> /> Make my public groups and
						articles available to search engines
					</label></div>
				<div class="checkboxlevels"><label>
						<input type="checkbox" name="newOpportunities" id="newOpportunities" value="1" <?php if ($getResults["newOpportunities"] == 1) {
							echo "checked";
						} ?> /> Let recruiters know that you are open
						to new opportunities
					</label></div>
				<div class="checkboxlevels"><label>
						<input type="checkbox" name="allowFuturePostsComments" id="allowFuturePostsComments" value="1" <?php if ($getResults["allowFuturePostsComments"] == 1) {
							echo "checked";
						} ?> /> Allow other members to
						mention
						you in future posts or comments
					</label></div>
			</div>

			<div style="display:<?php if ($_REQUEST['section'] == 3) {
				echo 'block';
			} else {
				echo 'none';
			} ?>;" class="notif-sttng-box">

				<div class="checkboxlevels"><label><input type="checkbox" name="sendMeEmail" id="sendMeEmail" value="1" <?php if ($getResults["sendMeEmail"] == 1) {
					echo "checked";
				} ?> /> When someone sends me a message</label>
				</div>
				<div class="checkboxlevels"><label><input type="checkbox" name="emailCommentLike" id="emailCommentLike"
							value="1" <?php if ($getResults["emailCommentLike"] == 1) {
								echo "checked";
							} ?> /> When someone
						comments
						on something I posted or commented on</label></div>
				<div class="checkboxlevels"><label><input type="checkbox" name="emailPostLike" id="emailPostLike" value="1"
							<?php if ($getResults["emailPostLike"] == 1) {
								echo "checked";
							} ?> /> When someone likes something I
						posted</label></div>
				<div class="checkboxlevels"><label><input type="checkbox" name="newContactRequest" id="newContactRequest"
							value="1" <?php if ($getResults["newContactRequest"] == 1) {
								echo "checked";
							} ?> /> When I receive
						new
						contact requests</label></div>
				<div class="checkboxlevels"><label><input type="checkbox" name="pendingContactRequest"
							id="pendingContactRequest" value="1" <?php if ($getResults["pendingContactRequest"] == 1) {
								echo "checked";
							} ?> /> If I have any pending contact requests</label></div>
				<div class="checkboxlevels"><label style="display:none;"><input type="checkbox" name="emailFreelancerAccount"
							id="emailFreelancerAccount" value="1" <?php if ($getResults["emailFreelancerAccount"] == 1) {
								echo "checked";
							} ?> /> When someone send message to my freelancer account</label></div>
				<div class="checkboxlevels"><label><input type="checkbox" name="emailApplyProject" id="emailApplyProject"
							value="1" <?php if ($getResults["emailApplyProject"] == 1) {
								echo "checked";
							} ?> /> When someone
						applies
						to the Project i posted</label></div>
				<div class="checkboxlevels"><label><input type="checkbox" name="emailContactNewPosition"
							id="emailContactNewPosition" value="1" <?php if ($getResults["emailContactNewPosition"] == 1) {
								echo "checked";
							} ?> /> When a contact of mine has a new position or employer</label></div>

				<div class="checkboxlevels"><label><input type="checkbox" name="notiJoiningGroup" id="notiJoiningGroup"
							value="1" <?php if ($getResults["notiJoiningGroup"] == 1) {
								echo "checked";
							} ?> /> When someone sends
						group joining request to My Group</label></div>

			</div>

			<div style="display:<?php if ($_REQUEST['section'] == 4) {
				echo 'block';
			} else {
				echo 'none';
			} ?>;" class="notif-sttng-box">

				<div class="checkboxlevels"><label><input type="checkbox" name="notiPostGroup" id="notiPostGroup" value="1"
							<?php if ($getResults["notiPostGroup"] == 1) {
								echo "checked";
							} ?> /> When someone posts in My
						Group</label></div>

				<div class="checkboxlevels"><label style="display:none;"><input type="checkbox" name="notiFollowCompany"
							id="notiFollowCompany" value="1" <?php if ($getResults["notiFollowCompany"] == 1) {
								echo "checked";
							} ?> /> When someone follow your company</label></div>
				<div class="checkboxlevels"><label><input type="checkbox" name="notiTagingCompany" id="notiTagingCompany"
							value="1" <?php if ($getResults["notiTagingCompany"] == 1) {
								echo "checked";
							} ?> /> When someone tags
						your company in his post</label></div>
				<div class="checkboxlevels"><label style="display:none;"><input type="checkbox" name="notiEventGuist"
							id="notiEventGuist" value="1" <?php if ($getResults["notiEventGuist"] == 1) {
								echo "checked";
							} ?> />
						When
						someone join your event guist list</label></div>

				<div class="checkboxlevels"><label><input type="checkbox" name="notiPostCommentsAllow"
							id="notiPostCommentsAllow" value="1" <?php if ($getResults["notiPostCommentsAllow"] == 1) {
								echo "checked";
							} ?> /> When someone comments on something I posted or commented on</label></div>

				<div class="checkboxlevels"><label><input type="checkbox" name="notiPostLikesAllow" id="notiPostLikesAllow"
							value="1" <?php if ($getResults["notiPostLikesAllow"] == 1) {
								echo "checked";
							} ?> /> When someone
						likes
						something I posted</label></div>

				<div class="checkboxlevels"><label><input type="checkbox" name="notiNewPositionEmployer"
							id="notiNewPositionEmployer" value="1" <?php if ($getResults["notiNewPositionEmployer"] == 1) {
								echo "checked";
							} ?> /> When a contact of mine has a new position or employer</label></div>

				<div class="checkboxlevels"><label><input type="checkbox" name="notiMeetingRequest" id="notiMeetingRequest"
							value="1" <?php if ($getResults["notiMeetingRequest"] == 1) {
								echo "checked";
							} ?> /> When a contact
						of
						mine sends me a meeting request</label></div>

				<div class="checkboxlevels"><label><input type="checkbox" name="notiProjectApplied" id="notiProjectApplied"
							value="1" <?php if ($getResults["notiProjectApplied"] == 1) {
								echo "checked";
							} ?> /> When someone
						applies
						to a Project I posted</label></div>

				<div class="checkboxlevels"><label><input type="checkbox" name="notiJoinGroupRequestAllow"
							id="notiJoinGroupRequestAllow" value="1" <?php if ($getResults["notiJoinGroupRequestAllow"] == 1) {
								echo "checked";
							} ?> /> When someone wants to Join a group that I have created</label></div>

				<div class="checkboxlevels"><label><input type="checkbox" name="notiNewArticlesAllow" id="notiNewArticlesAllow"
							value="1" <?php if ($getResults["notiNewArticlesAllow"] == 1) {
								echo "checked";
							} ?> /> When a contact
						of
						mine publishes a new article</label></div>

				<div class="checkboxlevels"><label><input type="checkbox" name="userBirthdayAllow" id="userBirthdayAllow"
							value="1" <?php if ($getResults["userBirthdayAllow"] == 1) {
								echo "checked";
							} ?> /> On the Birthday
						of a
						contact of mine</label></div>

			</div>


			<div class="popup-fttr">
				<a onClick="$('#sendmsgtocontactdiv').hide(); closefuncommonpopupwin();">Cancel</a>
				<button type="submit">Save</button>
				<input type="hidden" name="action" id="action" value="settings">
			</div>
		</form>

		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'sendenquiry') { ?>
		<form class="nw-grup" name="sendenquirymsg" id="sendenquirymsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div id="errormsgpass" style="color:#C02621; font-size:12px;"></div>
			<label>Name<span class="reqstar">*</span></label>
			<input type="text" name="senderName" id="senderName" class="validate" maxlength="60"
				onKeyUp="hideerrordiv(this.id);">
			<label>Mobile<span class="reqstar">*</span></label>
			<input type="text" name="senderPhoneNumber" id="senderPhoneNumber" class="validate" maxlength="14"
				onKeyUp="hideerrordiv(this.id);">
			<label>Email<span class="reqstar">*</span></label>
			<input type="email" name="senderEmail" id="senderEmail" class="validate" maxlength="60"
				onKeyUp="hideerrordiv(this.id);">
			<label>Message</label>
			<textarea name="senderMsg" id="senderMsg" rows="3" maxlength="1000" style="height:150px;"></textarea>
			<div class="popup-fttr">
				<a onClick="$('#sendmsgtocontactdiv').hide();$('#sendenquirymsg').val('');closefuncommonpopupwin();">Cancel</a>
				<button type="button" onClick="formValidation('sendenquirymsg');">Send</button>
				<input type="hidden" name="action" id="action" value="sendenquiry">
				<input type="hidden" name="receiverEmail" id="receiverEmail" value="<?php echo $_REQUEST["receiverEmail"]; ?>">
				<input type="hidden" name="purl" id="purl" value="<?php echo $_REQUEST["purl"]; ?>">
			</div>
		</form>

		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'delsmbp') { ?>
		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div class="tagbox" id="msgcontactdiv" style=""></div>
			<div id="errormsg" style="margin-bottom:10px;"></div>
			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>
			<label>Enter your account password<span class="reqstar">*</span></label>
			<input type="password" name="delgrppassword" id="delgrppassword" maxlength="50" class="validate"
				onKeyUp="hideerrordiv(this.id);" />
			<div style="font-size:12px; color:#999999; margin-bottom:10px;"><strong>Note</strong>: if you remove this SMB page
				all the data will be lost (photo gallery, images etc) which was associated with this SMB page.</div>
			<div class="popup-fttr">

				<button style="background-color:#ef4b4b;" onclick="formValidation('sendmsg');" type="button">Delete</button>


				<input type="hidden" name="action" id="action" value="delsmbp">
				<input type="hidden" name="smbpid" id="smbpid" value="<?php echo $_REQUEST['id']; ?>">
			</div>
		</form>
		<style type="text/css">
			form#sendmsg input {
				width: 100%;
				border: solid 1px #d0d0d0;
				padding: 10px;
				border-radius: 0;
			}

			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'deltalentp') { ?>
		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div class="tagbox" id="msgcontactdiv" style=""></div>
			<div id="errormsg" style="margin-bottom:10px;"></div>
			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>
			<label>Enter your account password<span class="reqstar">*</span></label>
			<input type="password" name="delgrppassword" id="delgrppassword" maxlength="50" class="validate"
				onKeyUp="hideerrordiv(this.id);" />
			<!--<div style="font-size:12px; color:#999999; margin-top:10px;"><strong>Note</strong>: if you remove this Talent Profile page all the data will be lost (images etc) which was associated with this Talent Profile page.</div>-->
			<div class="popup-fttr" style="margin-top: 0px;">

				<button style="background-color:#ef4b4b;" onclick="formValidation('sendmsg');" type="button">Delete</button>


				<input type="hidden" name="action" id="action" value="deltalentp">
				<input type="hidden" name="tlntpid" id="tlntpid" value="<?php echo $_REQUEST['id']; ?>">
			</div>
		</form>
		<style type="text/css">
			form#sendmsg input {
				width: 100%;
				border: solid 1px #d0d0d0;
				padding: 10px;
				border-radius: 0;
			}

			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'sendtalentenquiry') { ?>
		<form class="nw-grup" name="sendenquirymsg" id="sendenquirymsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div id="errormsgpass" style="color:#C02621; font-size:12px;"></div>
			<label>Name<span class="reqstar">*</span></label>
			<input type="text" name="senderName" id="senderName" class="validate" maxlength="60"
				onKeyUp="hideerrordiv(this.id);">
			<label>Mobile<span class="reqstar">*</span></label>
			<input type="text" name="senderPhoneNumber" id="senderPhoneNumber" class="validate" maxlength="14"
				onKeyUp="hideerrordiv(this.id);">
			<label>Email<span class="reqstar">*</span></label>
			<input type="email" name="senderEmail" id="senderEmail" class="validate" maxlength="60"
				onKeyUp="hideerrordiv(this.id);">
			<label>Message</label>
			<textarea name="senderMsg" id="senderMsg" rows="3" maxlength="1000" style="height:150px;"></textarea>
			<div class="popup-fttr">
				<a onClick="$('#sendmsgtocontactdiv').hide();$('#sendenquirymsg').val('');closefuncommonpopupwin();">Cancel</a>
				<button type="button" onClick="formValidation('sendenquirymsg');">Send</button>
				<input type="hidden" name="action" id="action" value="sendtalentenquiry">
				<input type="hidden" name="purl" id="purl" value="<?php echo $_REQUEST["purl"]; ?>">
			</div>
		</form>

		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>




<?php
if ($type == 'addtalentvideo') {

	// Initialize variables to prevent undefined warnings
	$talentVideoTitle = '';
	$talentVideoURL = '';

	if (isset($_REQUEST['vid']) && $_REQUEST['vid'] != '') {
		$sql = "SELECT * FROM " . _TALENT_VIDEO_TABLE_ . " WHERE id=" . decodeStr($_REQUEST['vid']) . " ";
		$resv = mysqli_query($conn, $sql);

		if ($resv && mysqli_num_rows($resv) > 0) {
			$rowVideo = mysqli_fetch_array($resv);
			$talentVideoTitle = trim($rowVideo['talentVideoTitle']);
			$talentVideoURL = trim($rowVideo['talentVideoURL']);
		}
	}
	?>

		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div id="errormsgpass" style="color:#C02621; font-size:12px;"></div>

			<label>Video Title <span class="reqstar">*</span></label>
			<input name="talentVideoTitle" type="text" class="validate" id="talentVideoTitle"
				value="<?php echo htmlspecialchars($talentVideoTitle); ?>" maxlength="250">

			<label>YouTube URL <span class="reqstar">*</span></label>
			<input name="talentVideoURL" type="text" class="validate" id="talentVideoURL"
				value="<?php echo htmlspecialchars($talentVideoURL); ?>" maxlength="250">

			<div class="popup-fttr">
				<a
					onClick="$('#sendmsgtocontactdiv').hide();$('#oldpass').val('');$('#newpass').val('');$('#confirmpass').val('');closefuncommonpopupwin();">
					Cancel
				</a>
				<button type="button" onClick="formValidation('sendmsg');">Save</button>

				<input type="hidden" name="action" id="action" value="addtalentVideo">
				<input type="hidden" name="talentId" id="talentId" value="<?php echo $_REQUEST['id'] ?? ''; ?>">
				<input type="hidden" name="talentVidId" id="talentVidId" value="<?php echo $_REQUEST['vid'] ?? ''; ?>">
			</div>
		</form>

		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>

<?php } ?>










<?php if ($type == 'addtalentTestimonials') { ?>

		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">



			<div id="errormsgpass" style="color:#C02621; font-size:12px;"></div>
			<label>Testimonial (maximum 500 characters)<span class="reqstar"> *</span> </label>
			<textarea name="testimonialsDetails" cols="6" class="validate" id="testimonialsDetails" maxlength="500"
				style="height: 150px;"></textarea>
			<label>Testimonial By <span class="reqstar">*</span></label>
			<input name="testimonialsName" type="text" class="validate" id="testimonialsName" value="" maxlength="100">



			<div class="popup-fttr">
				<a
					onClick="$('#sendmsgtocontactdiv').hide();$('#oldpass').val('');$('#newpass').val('');$('#confirmpass').val('');closefuncommonpopupwin();">Cancel</a>
				<button type="button" onClick="formValidation('sendmsg');">Save</button>
				<input type="hidden" name="action" id="action" value="addtalentTestimonial">
				<input type="hidden" name="talentId" id="talentId" value="<?php echo $_REQUEST['id']; ?>">
			</div>
		</form>

		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'applyjob' && $_REQUEST['id'] != '') {
	$sqlProjects = "SELECT * from " . _JOBS_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['id']) . " ";
	$resProjects = mysqli_query($conn, $sqlProjects) or die(mysqli_error($conn));
	$rowProjects = mysqli_fetch_array($resProjects);
	?>
		<style>
			.popuptitle {
				display: none;
			}

			.nw-grup {
				padding: 0px
			}

			.crt-grp-popup .popup-inner {
				border: 0px;
				border-radius: 0px;
				box-shadow: 0px 0px 5px #5f5f5f;
				width: 600px;
				max-width: 600px;
			}
		</style>
		<div id="sendtxtpromsg" style="display:none;"></div>
		<form style=" padding:15px;" enctype="multipart/form-data" name="frmposthomerecommend" id="frmposthomerecommend"
			method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">

			<div class="tagbox" id="msgcontactdiv" style=""></div>


			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>
			<div id="popupcontentproj">
				<div>
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="3%" align="left" valign="top"><img
									src="<?php echo $fullurl . 'uploads/' . $myprofilePhoto; ?>"
									style="width:80px;border-radius: 50%;" /></td>
							<td width="97%" align="left" valign="top" style=" padding-left:20px;">


								<input type="text" name="userSubject" id="userSubject"
									value="I'm interested in your <?php echo stripslashes($rowProjects['jobTitle']); ?> Job."
									style="background:white; cursor:text;" maxlength="200" class="validate"
									onKeyUp="hideerrordiv(this.id);" />
								<?php
								if (!isset($myfirstName1)) {
									$myfirstName1 = isset($myfirstName) ? $myfirstName : "";
								}
								?>

								<textarea name="projectdescription" rows="3" id="projectdescription" maxlength="1000"
									style="height:250px;" class="validate" onKeyUp="hideerrordiv(this.id);">
																						Hello <?php echo $myfirstName1; ?>

																						I'm interested in your "<?php echo stripslashes($rowProjects['jobTitle']); ?>" (<?php echo $fullurl; ?>view-job.html?id=<?php echo $_REQUEST['id']; ?>) Job. 

																						Please feel free to check out my <?php echo $companNameTitle; ?> profile to see whether you think we could work together:
																						<?php echo $fullurl; ?>profile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $userurl; ?>.html

																						If you'd like to contact me, just reply to this message.

																						Kind regards,
																						<?php echo $myname; ?>
																						</textarea>

							</td>
						</tr>
					</table>


				</div>

				<div class="popup-fttr">

					<a
						onClick="$('#sendmsgtocontactdiv').hide();$('#projectdescription').val('');closefuncommonpopupwin();">Cancel</a>
					<button type="button"
						onClick="formValidation('frmposthomerecommend');$('#commonloader').show();">Send</button>
					<input type="hidden" name="action" id="action" value="applyjob">
					<input type="hidden" name="projetvname" id="projetvname"
						value="<?php echo stripslashes($rowProjects['jobTitle']); ?>">
					<input type="hidden" name="jobid" id="jobid" value="<?php echo $_REQUEST['id']; ?>">
					<input type="hidden" name="uid" id="uid" value="<?php echo $rowProjects['userId']; ?>">
				</div>
			</div>
		</form>
		<style type="text/css">
			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>

<?php } ?>

<?php if ($type == 'deljob') { ?>
		<form class="nw-grup" name="sendmsgjjj" id="sendmsgjjj" method="post" target="actionfrmjob"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div class="tagbox" id="msgcontactdiv" style=""></div>
			<div id="errormsg" style="margin-bottom:10px;"></div>
			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>
			<label>Enter your account password<span class="reqstar">*</span></label>
			<input type="password" name="delgrppassword" id="delgrppassword" maxlength="50" class="validate"
				onKeyUp="hideerrordiv(this.id);" />
			<div style="font-size:12px; color:#999999; margin-bottom:10px;"><strong>Note</strong>: if you remove this job all
				the data will be lost which was associated with this job.</div>
			<div class="popup-fttr">

				<button style="background-color:#ef4b4b;" onclick="formValidation('sendmsgjjj');" type="button">Delete</button>


				<input type="hidden" name="action" id="action" value="deljob">
				<input type="hidden" name="jobid" id="jobid" value="<?php echo $_REQUEST['id']; ?>">
			</div>
			<iframe name="actionfrmjob" id="actionfrmjob" style="display:none;"></iframe>
		</form>
		<style type="text/css">
			form#sendmsg input {
				width: 100%;
				border: solid 1px #d0d0d0;
				padding: 10px;
				border-radius: 0;
			}

			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>


<?php if ($type == 'jobcompanies') {
	?>
		<div class="all-activity">
			<ul class="requst-list" id="notice-list" style="max-height:350px; overflow:auto;">
				<?php
				$aaa = "select * from " . _COMPANY_MASTER_TABLE_ . " where  companyName!='' and userId=" . $_SESSION["sessUserId"] . " ORDER BY companyName ";
				$res55 = mysqli_query($conn, $aaa);
				while ($rowLogin22 = mysqli_fetch_array($res55)) {

					?>
						<li>
							<div class="rquest-box" style="min-height:auto !important;">

								<div class="rqst-right" style="padding-left:12px;">
									<div class="rquest-middle">
										<a style="font-size:20px;"
											href="<?php echo $fullurl; ?>add-job.html?companyId=<?php echo encodeStr($rowLogin22["id"]); ?>"><?php echo $rowLogin22["companyName"]; ?></a>
									</div>
								</div>
							</div>
						</li>
				<?php } ?>
			</ul>
		</div>

<?php } ?>


<?php if ($type == 'invitegrpcontacts') {
	?>
		<div class="">
			<div class="searchfldbox" id="groupcontactinner" style="display:block;">

				<ul class="requst-list invitecontact" id="notice-list" style="max-height:350px;">
					<?php
					// $keyword = isset($keyword) ? $keyword : '';
					$aaa = "select * from " . _USERS_MASTER_TABLE_ . " where (firstName like '%" . $keyword . "%' OR lastName like '%" . $keyword . "%') and userId IN (select userId from " . _CONTACT_MASTER_TABLE_ . " where contactId='" . $_SESSION['sessUserId'] . "' and status=1)  ";
					$res55 = mysqli_query($conn, $aaa);
					while ($rowLogin22 = mysqli_fetch_array($res55)) {

						$a2 = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin22["userId"] . "";
						$b2 = mysqli_query($conn, $a2);
						$userres2 = mysqli_fetch_array($b2);

						$friendnameurl2 = $userres2['userurl'];
						if ($userres2["profilePhoto"] != '') {
							$userphoto2 = $userres2["profilePhoto"];
						} else {
							$userphoto2 = 'user-placeholder.jpg';
						}
						?>
							<li>
								<div class="rquest-box">
									<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2["userId"]); ?>/<?php echo $friendnameurl2; ?>.html"
										target="_blank" class="rqst-img"><img
											src="<?php echo $fullurl; ?>uploads/<?php echo $userphoto2; ?>"></a>

									<div class="rqst-right">
										<div class="rquest-middle">
											<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2["userId"]); ?>/<?php echo $friendnameurl2; ?>.html"
												target="_blank"><?php echo $userres2["firstName"]; ?>
												<?php echo $userres2["lastName"]; ?></a>
											<div style="font-size:12px; color:#9a9a9a;"><?php echo $userres2["jobTitle"]; ?> at
												<?php echo $userres2["companyName"]; ?>
											</div>

											<?php
											$n = 0;
											$selectFields = [];
											$whereFields = [];
											$whereVals = [];

											$sqlCheck = "";
											$sqlCheck = mysqli_query(
												$conn,
												"SELECT * 
										FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " 
										WHERE userId='" . mysqli_real_escape_string($conn, $userres2['userId']) . "' 
										AND groupId='" . mysqli_real_escape_string($conn, decodeStr($_REQUEST['groupId'])) . "'"
											) or die(mysqli_error($conn));

											if (mysqli_num_rows($sqlCheck) > 0) {
												?>
													<i class="fa fa-check greentick" aria-hidden="true"></i>
													<?php
											} else {
												?>
													<div class="add-frnd">
														<a onclick="groupsendrequest('<?php echo encodeStr($userres2['userId']); ?>');"
															style="color: #fff !important; font-weight: 500;">Send Request</a>
													</div>
											<?php } ?>
										</div>
									</div>
								</div>
							</li>
					<?php } ?>
				</ul>
			</div>

		</div>
		<style>
			.greentick {
				color: #2cc31a;
				font-size: 18px;
				position: absolute;
				right: 3px;
				top: 9px;
			}
		</style>
		<input type="hidden" name="requestgroupId" id="requestgroupId" value="<?php echo $_REQUEST["groupId"]; ?>" />
		<script>
			function groupsendrequest(id) {
				$('#commonloader').show();
				var requestgroupId = $("#requestgroupId").val();
				$("#groupcontactinner").load('<?php echo $fullurl; ?>getinvitecontacts.php?groupId=<?php echo $_REQUEST['groupId']; ?>&keyword=<?php echo $keyword ?>&groupUserId=' + id);
			}
		</script>
<?php } ?>

<?php if ($type == 'sharevaultdoc') { ?>


		<ul class="cntr_tab invite">
			<li><a class="active"
					onclick="$('#shareboxouter').show();$('#shareboxouterothers').hide();shareselecttab('sharediv1');"
					id="sharediv1">Share with my contacts</a></li>
			<li><a onclick="$('#shareboxouter').hide();$('#shareboxouterothers').show();shareselecttab('sharediv2');"
					id="sharediv2">Send by email</a></li>
		</ul>
		<script>
			function shareselecttab(id) {
				$('#sharediv1').removeClass('active');
				$('#sharediv2').removeClass('active');
				$('#' + id).addClass('active');
			}
		</script>
		<div>

			<div id="shareboxouter">
				<form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthomes1" method="post"
					target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
					<div class="timlist" id="loadshareddata2" style="padding:0px;">
						<div class="">
							<ul class="requst-list" id="notice-list" style="max-height:350px; overflow:auto;">
								<?php

								$n = 0;
								$selectFields = [];
								$whereFields = [];
								$whereVals = [];
								$keyword = isset($_REQUEST['keyword']) ? trim($_REQUEST['keyword']) : '';

								$sqlLogin = "";
								$sqlLogin = "select * from " . _USERS_MASTER_TABLE_ . " where (firstName like '%" . $keyword . "%' OR lastName like '%" . $keyword . "%') and userId IN (select userId from " . _CONTACT_MASTER_TABLE_ . " where contactId='" . $_SESSION['sessUserId'] . "' and status=1)  ";
								$resLogin = getRecords(_CONTACT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
								if ($resLogin) {
									while ($rowLogin = mysqli_fetch_array($resLogin)) {

										$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin["userId"] . "";
										$b = mysqli_query($conn, $a);
										$userres2 = mysqli_fetch_array($b);

										$friendnameurl2 = $userres2['userurl'];
										if ($userres2["profilePhoto"] != '') {
											$userphoto2 = $userres2["profilePhoto"];
										} else {
											$userphoto2 = 'user-placeholder.jpg';
										}

										$mycountryName = $userres2["countryName"];
										$mystateName = $userres2["cityName"];
										$mylocationName = $userres2["locationName"];
										?>
												<li class="msguserscheckbox">
													<div class="msgcheckbox"><input type="checkbox" name="check_list[]" id="check_list"
															value="<?php echo encodeStr($userres2["userId"]); ?>" class="deleteChk" /></div>
													<div class="rquest-box">
														<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2["userId"]); ?>/<?php echo $friendnameurl2; ?>.html"
															target="_blank" class="rqst-img"><img
																src="<?php echo $fullurl; ?>uploads/<?php echo $userphoto2; ?>"></a>

														<div class="rqst-right">
															<div class="rquest-middle">
																<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres2["userId"]); ?>/<?php echo $friendnameurl2; ?>.html"
																	target="_blank"><?php echo $userres2["firstName"]; ?>
																	<?php echo $userres2["lastName"]; ?></a>
																<div style="font-size:12px; color:#9a9a9a;"><?php echo $userres2["jobTitle"]; ?>
																	at <?php echo $userres2["companyName"]; ?></div>
															</div>
														</div>
													</div>
												</li>
												<?php

												$n++;
									}

								}
								?>
							</ul>
						</div>


					</div>

					<div class="popup-fttr">


						<!--<a onclick="$('#sharepostText').val('');closefuncommonpopupwin();">Cancel</a>-->
						<button type="button" class="konecttbtn" onclick="submitsharefrom();">Share</button>
						<input type="hidden" name="action" id="action" value="postandsharewithmsg">
						<input type="hidden" name="sharePostType" id="sharePostType" value="sharedocs">

						<input type="hidden" name="postId" id="postId" value="<?php echo $_REQUEST['postId']; ?>">
						<input type="hidden" name="sharedoc" value="1">
					</div>

					<script language="javascript" type="text/javascript">
						function submitsharefrom() {
							$('#commonloader').show();
							if (jQuery(".deleteChk:checkbox:checked").length > 0) {
								//alert('ok333');
								$('#commonloader').hide();
								$("#frmposthomes1").submit();
								return true;
							}
							else {
								$('#commonloader').hide();
								showerrormsg('Error', 'Oops! Please select at least one contact to share this document', '');
								return false;
							}



						}


					</script>
				</form>
			</div>

			<div id="shareboxouterothers" style="display:none;">
				<form class="edit-layer" enctype="multipart/form-data" name="frmposthomepeople" id="frmposthomepeople"
					method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
					<div class="tagbox" id="msgcontactdiv" style=""></div>
					<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>
					<div id="popupcontentproj">
						<div>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<td width="100%" align="left" valign="top">

										<label>Email<span class="reqstar">*</span></label>
										<input type="email" name="txtuseremail1" id="txtuseremail1" maxlength="250"
											placeholder="Separate e-mail addresses with commas." class="validate"
											onKeyUp="hideerrordiv(this.id);">
									</td>
								</tr>
							</table>


						</div>

						<div class="popup-fttr">

							<button type="button" onClick="formValidation('frmposthomepeople');subsrchfrmPeople();"
								class="konecttbtn">Send</button>
							<input type="hidden" name="action" value="sendinvitation">
							<input type="hidden" name="postId" id="postId" value="<?php echo $_REQUEST['postId']; ?>">
							<input type="hidden" name="sharedoc" value="1">
						</div>
					</div>
					<script>
						$('#txtuseremail1').focus();
						function subsrchfrmPeople() {

							if ($("#txtuseremail1").val() != '') {
								$("#frmposthomepeople").submit();
							}
							/*else
							{
								   $('#txtuseremail1').addClass('redborderfield');
							   return false;
							}*/

						}

						$("input").keypress(function (event) {

							if (event.which == 13) {
								event.preventDefault();

								if ($("#txtuseremail1").val() != '') {
									$("#frmposthomepeople").submit();
								}
								/*else
								{
									  $('#txtuseremail1').addClass('redborderfield');
									return false;
								}*/
							}
						});

					</script>



					<!--<script>
function vaultsendrequest(id)
{
	$('#commonloader').show();
	$("#vaultcontactinner").load('<?php echo $fullurl; ?>getvaultdocusers.php?postId=<?php echo $_REQUEST['postId']; ?>&userId='+id);
}

</script>-->
				</form>
			</div>

		</div>
		<?php if ($mobile != 'y') { ?>
				<style>
					.crt-grp-popup .popup-inner {
						max-width: 450px !important;
					}
				</style>
		<?php } ?>

		<?php
}
?>

<?php if ($type == 'invitepeople') {
	$yahooUrL = '';
	// for Yahoo
	require_once(__DIR__ . '/yahapi/globals.php');
	require_once(__DIR__ . '/yahapi/oauth_helper.php');
	$callback = $fullurl . "yahapi/yahoo_callback.php";
	// Get the request token using HTTP GET and HMAC-SHA1 signature 
	$retarr = get_request_token(OAUTH_CONSUMER_KEY, OAUTH_CONSUMER_SECRET, $callback, false, true, true);

	if (!empty($retarr)) {
		list($info, $headers, $body, $body_parsed) = $retarr;
		if ($info['http_code'] == 200 && !empty($body)) {
			// print "Have the user go to xoauth_request_auth_url to authorize your app\n" . 
//  rfc3986_decode($body_parsed['xoauth_request_auth_url']) . "\n"; 
//echo "<pre/>"; 
//print_r($retarr); 
			$_SESSION['request_token'] = $body_parsed['oauth_token'];
			$_SESSION['request_token_secret'] = $body_parsed['oauth_token_secret'];
			$_SESSION['oauth_verifier'] = $body_parsed['oauth_token'];
			$yahooUrL = urldecode($body_parsed['xoauth_request_auth_url']);
		}
	} else {
		$yahooUrL = '';
	}

	// end Yahoo


	$urlgmail = "https://accounts.google.com/o/oauth2/auth?client_id=352319751754-8liarauervqtfrbohd009uuldk3snldv.apps.googleusercontent.com&redirect_uri=" . $fullurl . "callback.php&scope=https://www.google.com/m8/feeds/&response_type=code&state=" . encodeStr($_SESSION["sessUserId"]);

	?>
		<form enctype="multipart/form-data" name="frmposthomepeople" id="frmposthomepeople" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php">

			<div class="tagbox" id="msgcontactdiv" style=""></div>
			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>
			<div id="popupcontentproj">
				<ul class="invite-bylist">
					<li><a target="_blank" href="<?php echo $urlgmail; ?>"><img
								src="<?php echo $fullurl; ?>/images/gmail.png"><span>Gmail</span> </a></li>
					<li><a href="<?php echo $yahooUrL; ?>" target="_blank"><img
								src="<?php echo $fullurl; ?>/images/yahoo.png"><span>Yahoo</span> </a></li>
					<li><a onclick="$('#txtuseremail1').focus();"><img
								src="<?php echo $fullurl; ?>/images/email.png"><span>Email</span> </a></li>
				</ul>
				<div style="display:none;" id="invisent">Invitation sent successfully</div>
				<div class="invite-email">
					<table width="100%" border="0" cellspacing="0" cellpadding="0">
						<tr>
							<td width="100%" align="left" valign="top">

								<!-- <label>Email<span class="reqstar">*</span></label> -->
								<input type="email" name="txtuseremail1" id="txtuseremail1" maxlength="250"
									placeholder="Separate e-mail addresses with commas." class="validate"
									onKeyUp="hideerrordiv(this.id);" style="margin-bottom: 10px;">
							</td>
						</tr>
					</table>
					<div class="popup-fttr">

						<button type="button" onClick="formValidation('frmposthomepeople');subsrchfrmPeople();"
							class="konecttbtn">Send Invitation</button>
						<input type="hidden" name="action" value="sendinvitation">
					</div>

				</div>




			</div>
			<script>
				$('#txtuseremail1').focus();

				function subsrchfrmPeople() {

					if ($("#txtuseremail1").val() != '') {
						$("#frmposthomepeople").submit();
					}
				}

				$("input").keypress(function (event) {

					if (event.which == 13) {
						event.preventDefault();

						if ($("#txtuseremail1").val() != '') {
							$("#frmposthomepeople").submit();
						}
					}
				});

			</script>
		</form>



<?php } ?>

<?php if ($type == 'sayhappybirthday') {
	?>
		<div class="all-activity">
			<div class="searchfldbox" id="groupcontactinner" style="display:block;">

				<ul class="requst-list invitecontact" id="notice-list" style="max-height:350px;">
					<?php
					$selectFields = [];
					$whereFields = [];
					$whereVals = [];
					$mb = 0;
					$sqlQuery = "";
					$sqlQuery = "select dob,userId,firstName,lastName,profilePhoto,userurl,jobTitle,companyName from " . _USERS_MASTER_TABLE_ . " where userId IN(select contactId from " . _CONTACT_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and status=1) and dob!='0000-00-00' ";
					$resQuery = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlQuery);
					if ($resQuery) {
						while ($rowcontacts = mysqli_fetch_array($resQuery)) {
							$userdob = $rowcontacts["dob"];

							$userdobArr = explode("-", $userdob);
							$dobyear = $userdobArr[0];
							$dobmonth = $userdobArr[1];
							$dobday = $userdobArr[2];

							$userdob = $dobmonth . '-' . $dobday;

							if ($userdob == date("m-d")) {

								$frienddobnameurl = $rowcontacts['userurl'];
								if ($rowcontacts["profilePhoto"] != '') {
									$userphoto2 = $rowcontacts["profilePhoto"];
								} else {
									$userphoto2 = 'user-placeholder.jpg';
								}

								$usercontactid = encodeStr($rowcontacts['userId']);
								$userfirstName = stripslashes(trim($rowcontacts["firstName"]));
								$userlastName = stripslashes(trim($rowcontacts["lastName"]));

								$a23 = "SELECT birthdayStatus from " . _CONTACT_MASTER_TABLE_ . " WHERE contactId= " . $rowcontacts["userId"] . " and userId=" . $_SESSION['sessUserId'] . " ";
								$b23 = mysqli_query($conn, $a23) or die(mysqli_error($conn));
								$userres23 = mysqli_fetch_array($b23);
								?>
											<li>
												<div class="rquest-box">
													<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowcontacts["userId"]); ?>/<?php echo $frienddobnameurl; ?>.html"
														target="_blank" class="rqst-img"><img
															src="<?php echo $fullurl; ?>uploads/<?php echo $userphoto2; ?>"></a>

													<div class="rqst-right">
														<div class="rquest-middle">
															<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowcontacts["userId"]); ?>/<?php echo $frienddobnameurl; ?>.html"
																target="_blank"><?php echo $rowcontacts["firstName"]; ?>
																<?php echo $rowcontacts["lastName"]; ?></a>
															<div style="font-size:12px; color:#9a9a9a;"><?php echo $rowcontacts["jobTitle"]; ?> at
																<?php echo $rowcontacts["companyName"]; ?>
															</div>

															<?php
															/*$n=0;
															unset($selectFields);
															unset($whereFields);
															unset($whereVals);

															$sqlCheck="";		
															$sqlCheck=mysql_query("select * from "._GROUP_MEMBER_MASTER_TABLE_." where  userId=".$rowcontacts['userId']." and groupId=".decodeStr($_REQUEST['groupId'])." ");		 	
															if(mysql_num_rows($sqlCheck)>0)
															{*/
															?>
															<!--<i class="fa fa-check greentick" aria-hidden="true"></i>-->
															<?php
															/*}
															else
															{*/
															?>
															<div class="add-frnd">
																<?php if ($userres23["birthdayStatus"] == 1) { ?>Sent<?php } else { ?>
																		<a
																			onclick="openuserchatbox('<?php echo encodeStr($rowcontacts['userId']); ?>','<?php echo stripslashes(trim($rowcontacts["firstName"])); ?> <?php echo stripslashes(trim($rowcontacts["lastName"])); ?>','<?php echo $fullurl; ?>profile/<?php echo encodeStr($rowcontacts['userId']); ?>/<?php echo $frienddobnameurl; ?>.html');$('#chatfieldfooter').val('Happy Birthday');$('#shb').val('1');closefuncommonpopupwin();">Send
																			Message</a><?php } ?>
															</div>
															<?php //} ?>
														</div>
													</div>
												</div>
											</li>
											<?php
							}

						}


					} ?>
				</ul>
			</div>

		</div>
		<style>
			.greentick {
				color: #2cc31a;
				font-size: 18px;
				position: absolute;
				right: 3px;
				top: 9px;
			}
		</style>
		<input type="hidden" name="requestgroupIdxxxxxxxxxxx" id="requestgroupIdxxxxxxxxxxx"
			value="<?php echo $_REQUEST["groupId"]; ?>" />
		<!--<script>
function groupsendrequest(id)
{
	$('#commonloader').show();
	var requestgroupId = $("#requestgroupId").val();
	$("#groupcontactinner").load('<?php echo $fullurl; ?>getinvitecontacts.php?groupId=<?php echo $_REQUEST['groupId']; ?>&keyword=<?php echo $keyword ?>&userId='+id);

}
</script>-->
<?php } ?>

<?php if ($type == 'meetingdetail') {


	if (isset($_GET["mymeeting"]) && $_GET["mymeeting"] == 1) {

		$createdBy = mysqli_real_escape_string($conn, $_SESSION['sessUserId']);
		$meetingDateTime = mysqli_real_escape_string($conn, $_GET['time']);
		$chatUserId = mysqli_real_escape_string($conn, decodeStr($_GET["chatuserid"]));

		$aa = "
        SELECT * 
        FROM " . _MEETING_MASTER_TABLE_ . " 
        WHERE createdBy='$createdBy' 
          AND meetingDateTime='$meetingDateTime' 
          AND userId='$chatUserId'
    ";
		$res5 = mysqli_query($conn, $aa) or die(mysqli_error($conn));
		$getdata = mysqli_fetch_assoc($res5);
		mysqli_free_result($res5);

		$a = "
        SELECT * 
        FROM " . _USERS_MASTER_TABLE_ . " 
        WHERE userId='$chatUserId'
    ";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$userres = mysqli_fetch_assoc($b);
		mysqli_free_result($b);

	} else {

		$meetingDateTime = mysqli_real_escape_string($conn, $_GET['time']);
		$userId = mysqli_real_escape_string($conn, $_SESSION['sessUserId']);

		$aa = "
        SELECT * 
        FROM " . _MEETING_MASTER_TABLE_ . " 
        WHERE meetingDateTime='$meetingDateTime' 
          AND userId='$userId'
    ";
		$res5 = mysqli_query($conn, $aa) or die(mysqli_error($conn));
		$getdata = mysqli_fetch_assoc($res5);
		mysqli_free_result($res5);

		$createdBy = mysqli_real_escape_string($conn, $getdata["createdBy"]);

		$a = "
        SELECT * 
        FROM " . _USERS_MASTER_TABLE_ . " 
        WHERE userId='$createdBy'
    ";
		$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
		$userres = mysqli_fetch_assoc($b);
		mysqli_free_result($b);
	}


	?>

		<div class="meeting_detail">
			<div class="meetin_content">
				<div class="yousent">
					<?php if ($_GET["mymeeting"] == 1) { ?> <strong>You </strong> Sent to
							<strong><?php echo stripslashes(trim($userres["firstName"])); ?>
								<?php echo stripslashes(trim($userres["lastName"])); ?></strong><?php } ?>
					<?php if ($_GET["mymeeting"] == 2) { ?> <strong><?php echo stripslashes(trim($userres["firstName"])); ?>
								<?php echo stripslashes(trim($userres["lastName"])); ?> </strong> Sent to <strong>You</strong><?php } ?>
				</div>
				<div class="mtngtitle">
					<h3><?php echo stripslashes($getdata["title"]); ?></h3>
					<span class="time"><?php echo date("D j M, g:i a", $getdata['meetingDateTime']); ?>
						(<?php echo $getdata['duration']; ?>)</span>

					<?php if ($getdata["agenda"] != '') { ?>
							<div style="margin-top:12px;"><strong>Agenda:</strong> <?php echo stripslashes($getdata["agenda"]); ?></div>
					<?php } ?>

				</div>
				<?php if ($_GET["mymeeting"] == 1) { ?>
						<div class="allresponse">
							<span class="allresptitle">All responses</span>
							<div class="res-contnt">
								<span class="count">
									<?php
									$meetingDateTime = mysqli_real_escape_string($conn, $getdata["meetingDateTime"]);
									$createdBy = mysqli_real_escape_string($conn, $_SESSION['sessUserId']);

									$aat = "
            SELECT id 
            FROM " . _MEETING_MASTER_TABLE_ . " 
            WHERE meetingDateTime='$meetingDateTime' 
              AND createdBy='$createdBy' 
              AND status=1
        ";
									$bb = mysqli_query($conn, $aat) or die(mysqli_error($conn));
									echo $totalattending = mysqli_num_rows($bb);
									mysqli_free_result($bb);
									?>
								</span> Yes I am attending
							</div>

							<div class="res-contnt">
								<span class="count">
									<?php
									$a = "
            SELECT id 
            FROM " . _MEETING_MASTER_TABLE_ . " 
            WHERE meetingDateTime='$meetingDateTime' 
              AND createdBy='$createdBy' 
              AND status=3
        ";
									$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
									echo $totalmaybeattending = mysqli_num_rows($b);
									mysqli_free_result($b);
									?>
								</span> I am not attending
							</div>

							<div class="res-contnt">
								<span class="count">
									<?php
									$a = "
            SELECT id 
            FROM " . _MEETING_MASTER_TABLE_ . " 
            WHERE meetingDateTime='$meetingDateTime' 
              AND createdBy='$createdBy' 
              AND status=2
        ";
									$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
									echo $totalnotattending = mysqli_num_rows($b);
									mysqli_free_result($b);
									?>
								</span> Maybe I am attending
							</div>

						</div>
				<?php } ?>

				<?php if ($_GET["mymeeting"] == 2) { ?>
						<?php if ($getdata['status'] != 0) { ?>
								<div class="allresponse">
									<span class="allresptitle">Your response</span>
									<div class="res-contnt">

										&nbsp;&nbsp;&nbsp;You responded <strong>
											<?php if ($getdata['status'] == 1) { ?>Yes i am attending<?php } ?>
											<?php if ($getdata['status'] == 2) { ?>Maybe i am attending<?php } ?>
											<?php if ($getdata['status'] == 3) { ?>I am not attending<?php } ?>


										</strong>
									</div>


								</div> <?php } ?>
				<?php } ?>
			</div>
		</div>



<?php } ?>

<?php if ($type == 'setmeeting') { ?>
		<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/default.css">
		<script src="<?php echo $fullurl; ?>js/zebra_datepicker.js"></script>
		<script>
			$(document).ready(function () {

				$('#meetingdate').Zebra_DatePicker({

					format: 'd-m-Y',


				});

			});





			function submitmeeting() {

				$('#meetingrequestftm').attr('target', 'actionfrm');
				$('#meetingrequestftm').attr('action', '<?php echo $fullurl; ?>common_action.php');

			}

		</script>
		<style>
			.Zebra_DatePicker.dp_visible {
				z-index: 9999999 !important;
			}

			.Zebra_DatePicker_Icon_Wrapper {
				width: 50% !important;
			}
		</style>
		<?php
		$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId='" . decodeStr($_GET["meetingcontactchatuserid"]) . "'";
		$b = mysqli_query($conn, $a) or die(mysqli_error($connn));
		$userres = mysqli_fetch_array($b);


		?>
		<form class="edit-layer nw-grup" style="margin-top: 15px;" name="meetingrequestftm" id="meetingrequestftm"
			method="post">
			<label>Send to</label>
			<input type="text" name="sendtoname" id="sendtoname" disabled="disabled"
				value="<?php echo stripslashes(trim($userres["firstName"])); ?>  <?php echo stripslashes(trim($userres["lastName"])); ?>">
			<label>Title</label>
			<input type="text" name="title" id="title" placeholder="What is this meeting about?" class="validate">
			<input type="hidden" name="contactId" id="contactId"
				value="<?php echo decodeStr($_GET["meetingcontactchatuserid"]); ?>">
			<input type="hidden" name="action" id="action" value="meeting">
			<div class="dtetime">
				<label>Date & Time</label>
				<input type="text" name="meetingdate" id="meetingdate" value="<?php echo date("d-m-Y"); ?>"
					displayname="Followup Date" class="validate" style="width:98% !important;">

				<select id="checkInTime" name="checkInTime" class="gridfield validate" autocomplete="off"
					displayname="Followup Time">

					<option value="">Select Time</option>
					<?php

					$start = strtotime('00:00');

					$end = strtotime('23:30');



					for ($i = $start; $i <= $end; $i = $i + 15 * 60) {
						if (date('g:i A') == date('g:i A', $i)) {
							$strtTimeSelected = 'selected="selected"';
						} else {
							$strtTimeSelected = "";
						}
						?>

							<option value="<?php echo date('g:i A', $i); ?>" <?php echo $strtTimeSelected; ?>>
								<?php echo date('g:i A', $i); ?>
							</option>

					<?php } ?>

				</select>
			</div>
			<div class="dtetime">
				<label>Duration</label>
				<select name="meetinghour" id="meetinghour" style="float:left;">
					<option value="0 Hr">0 Hour</option>
					<?php

					for ($j = 1; $j <= 24; $i = $j++) {
						if ($hour == $j) {
							$strtTimeSelected = 'selected="selected"';
						} else {
							$strtTimeSelected = "";
						}
						?>

							<option value="<?php echo $j; ?> Hr" <?php echo $strtTimeSelected; ?>><?php echo $j; ?> Hour</option>

					<?php } ?>

				</select>
				<select name="meetingminutes" id="meetingminutes" style="float:right;">
					<?php

					for ($j = 1; $j <= 60; $i = $j++) {
						if ('30' == $j) {
							$strtTimeSelected = 'selected="selected"';
						} else {
							$strtTimeSelected = "";
						}
						?>

							<option value="<?php echo $j; ?> Mins" <?php echo $strtTimeSelected; ?>><?php echo $j; ?> Minute</option>

					<?php } ?>
				</select>


			</div>



			<label>Agenda(optional)</label>
			<input type="text" name="agenda" id="agenda" placeholder="Add agenda here">
			<div class="popup-fttr">
				<button type="button" class="konecttbtn"
					onClick="submitmeeting();formValidation('meetingrequestftm');">Send</button>
			</div>
		</form>


<?php } ?>

<?php if ($type == 'closeuseraccount') { ?>
		<form class="nw-grup" name="sendmsg" id="sendmsg" method="post" target="actionfrm"
			action="<?php echo $fullurl; ?>common_action.php" style="padding:0px;">

			<div class="tagbox" id="msgcontactdiv" style=""></div>
			<div id="errormsg" style="margin-bottom:10px;margin-top: 10px;"></div>
			<div style="font-size:12px; color:#999999; margin-bottom:10px;"><strong>Note</strong>: Deactivating your account
				will disable your profile. Some information may still be visible to others, such as your name in their friends
				list, messages you sent, posts, comments and likes.</div>
			<div style="position:relative; display:none;" id="searchcontactmsgouter"></div>
			<label>Enter your account password<span class="reqstar">*</span></label>
			<input type="password" name="delgrppassword" id="delgrppassword" maxlength="50" class="validate"
				onKeyUp="hideerrordiv(this.id);" />

			<div class="popup-fttr">
				<a onclick="$('#delgrppassword').val('');closefuncommonpopupwin();">Cancel</a>
				<button style="background-color:#ef4b4b;" onclick="formValidation('sendmsg');" type="button">Deactivate
					Now</button>


				<input type="hidden" name="action" id="action" value="closeuseraccount">
				<input type="hidden" name="userId" id="userId" value="<?php echo $_SESSION["sessUserId"]; ?>">
			</div>
		</form>
		<style type="text/css">
			form#sendmsg input {
				width: 100%;
				border: solid 1px #d0d0d0;
				padding: 10px;
				border-radius: 0;
			}

			#commonpopupwinouter {
				float: left;
				width: 100%;
			}

			#commonpopupwinouter .nw-grup {
				padding-bottom: 0px !important;
			}

			#commonpopupwinouter .popup-fttr {
				margin-left: -20px;
				width: 110%;
			}
		</style>
<?php } ?>

<?php if ($type == 'sharewithexternalsocial') { ?>
		<div id="shareboxouter">
			<form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post"
				target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
				<div style="overflow:hidden;">
					<div class="timlist"
						style="padding:0px;display: none; border:0px; box-shadow:0px 0px 0px #fff; border-bottom:1px solid #efefef; border-radius:0px;">
						<div class="hedr">
							<div class="prfl_img"> <a
									href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $userurl; ?>.html"><img
										src="<?php echo $fullurl; ?>uploads/<?php echo $myprofilePhoto; ?>"></a> </div>
							<div class="hdr_right"><a
									href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $userurl; ?>.html"><?php echo $myname; ?></a>
								<label class="time"><?php echo $jobTitle; ?> - <?php echo $companyName; ?></label>
							</div>
						</div>
					</div>
					<a onClick="sharefuncommonpopupwin('450px','auto','<?php echo $fullurl; ?>common_popup_inner.php?id=<?php echo $_REQUEST['id']; ?>&type=share&sharePostType=<?php echo $_REQUEST['sharePostType']; ?>','Share','<?php echo $rowResults['id']; ?>');"
						class="back-erow" style=" padding-top: 15px;display: inline-block;"><i class="fa fa-arrow-left"
							aria-hidden="true"></i> Back</a>
				</div>
				<div class="timlist" id="loadshareddata2" style="padding:0px;">
					<style>
						.containersocial {
							display: grid;
							grid-template-columns: auto auto auto;
							padding: 10px;
						}

						.containersocial>div {
							background-color: #f1f1f1;
							padding: 10px;
							font-size: 30px;
							text-align: center;
						}
					</style>
					<?php
					$url = urlencode('https://jmi.vecospace.com/single-post.html?postId=' . $_REQUEST['id'] . '&postType=' . $_REQUEST['sharePostType']);
					?>
					<div class="containersocial">
						<div>
							<a target="_blank" href="https://api.whatsapp.com/send?text=<?php echo $url; ?>"
								data-action="share/whatsapp/share">
								<img style="width:45px;" src="images/wtapp.png" />
							</a>
						</div>
						<div>
							<a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>"
								class="fb-xfbml-parse-ignore">
								<img style="width:42px;" src="images/fb.jpg">
							</a>
						</div>
						<div><a target="_blank" href="https://twitter.com/intent/tweet?text=<?php echo $url; ?>"
								class="fb-xfbml-parse-ignore">
								<img style="width:42px;" src="images/tw1.png">
							</a>
						</div>
					</div>
				</div>

				<div style="">
					<div class="popup-fttr">


						<a onclick="$('#sharepostText').val('');closefuncommonpopupwin();">Cancel</a>
						<!--<button type="submit">Share</button>-->
						<input type="hidden" name="action" id="action" value="postandsharewithmsg">
						<input type="hidden" name="sharePostType" id="sharePostType"
							value="<?php echo $_REQUEST['sharePostType']; ?>">

						<input type="hidden" name="oldpostId" id="oldpostId" value="<?php echo $_REQUEST['id']; ?>">

					</div>

				</div>

			</form>
		</div>


		<div id="sharesuccess" style="display:none; text-align:center; font-size:15px;">
			Successfully shared
		</div>




		<?php
}
?>