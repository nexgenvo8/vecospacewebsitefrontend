<?php
include_once('inc.php');
include_once('config/session-check.inc.php');
if (isset($_GET['id']) && !is_numeric($_GET['id'])) {
	die("Invalid user ID");
}
$id = decodeStr($_GET['id']);

$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $id . "";
$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
$chatuser = mysqli_fetch_array($b);

if ($chatuser["profilePhoto"] != '') {
	$chatuserPhoto = $chatuser["profilePhoto"];
} else {
	$chatuserPhoto = 'user-placeholder.jpg';
}
?>
<style type="text/css">
	.center_content {
		margin-bottom: 0;
	}
</style>



<div class="heddr">
	<?php if ($mobile == 'y') { ?>
		<a href="#" class="bck-btn"
			onclick="$('#msgchat').hide();$('.chat_list').show();$('#header').show();$('.container.main').css('padding-top','52px');">
			<i class="fa fa-arrow-left" aria-hidden="true"></i>
		</a>
	<?php } ?>

	<a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($chatuser['userId']); ?>/<?php echo $chatuser['userurl']; ?>.html"
		class="im">
		<img src="<?php echo $fullurl; ?>uploads/<?php echo $chatuserPhoto; ?>">
	</a>

	<div class="right-cht-had">
		<div class="grp-ttl">
			<a
				href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($chatuser['userId']); ?>/<?php echo $chatuser['userurl']; ?>.html">
				<?php echo $chatuser['firstName'] . ' ' . $chatuser['lastName']; ?>
			</a>
		</div>

		<span>
			<?php
			if ($chatuser['userstype'] == 1) {
				echo $chatuser['coursename'];
			} elseif ($chatuser['userstype'] == 2) {
				echo $chatuser['departmentname'];
			} elseif (in_array($chatuser['userstype'], [3, 4, 5])) {
				echo $chatuser['jobTitle'];
			}
			?>
			at <?php echo $chatuser['companyName']; ?>
		</span>
	</div>
</div>

<div class="chats" id="loadchatusermsg" style="height:410px; padding-bottom:10px; border-bottom:2px solid #00a652;">
</div>

<div class="chat_fttr">
	<div class="chat-inpt">
		<span id="setchatarea">
			<textarea name="chatfieldfooter" id="chatfieldfooter" maxlength="800" onclick="$('#selectbuttons').hide();"
				placeholder="Write a message here..."></textarea>
		</span>

		<!-- Attachment Form -->
		<form class="edit-layer" enctype="multipart/form-data" name="frmposthome2" id="frmposthome2" method="post"
			target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">

			<span id="hpotohomeid">
				<input name="chatattachedfile" id="chatattachedfile" type="file" onchange="uploaduserfilesfun();"
					style="display:none;">
			</span>

			<input type="hidden" name="action" id="action" value="chatattachedmsg">
			<input type="hidden" name="contactchatuserid" id="contactchatuserid" value="">
			<input type="hidden" name="loadmsgp" id="loadmsgp" value="0">
		</form>

		<script>
			function uploaduserfilesfun() {
				$('#frmposthome2').submit();
				$('#commonloader').show();

				let hpotohomeid = $('#hpotohomeid').html();
				$('#chatattachedfile').remove();
				$('#hpotohomeid').html(hpotohomeid);
			}
		</script>

		<ul class="emozi">
			<li class="emogi" style="margin-left:10px !important;">
				<a href="javascript:void(0)" class="emoji-toggle" onclick="$('.emoji-list').show()">
					<i class="fa fa-smile-o" aria-hidden="true" id="emogilist"></i>
				</a>
				<ul class="emoji-list">
					<?php include('smily.php'); ?>
				</ul>
			</li>

			<li class="atach">
				<a id="chatattachedbutton"><i class="fa fa-paperclip" aria-hidden="true"></i></a>
			</li>

			<li style="float:right;">
				<div class="send-sec">
					<span id="sendpressenter">Press Enter to Send</span>
					<button class="send" id="sendbuttonchat" onclick="clicktosendchat();"
						style="display:none; background-color:#00a652;">
						Send
					</button>

					<div class="click-btn">
						<a id="sendclick">
							<i style="color:#00a652;" class="fa fa-ellipsis-h" aria-hidden="true"
								onclick="$('#selectbuttons').toggle();" id="openpressenter"></i>
						</a>

						<form class="edit-layer" enctype="multipart/form-data" name="frmposthome3" id="frmposthome3"
							method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">

							<ul class="send-list" id="selectbuttons">
								<li>
									<label>
										<input type="radio" name="setpressenter" id="pressenter" value="1"
											onclick="$('#frmposthome3').submit();$('#sendpressenter').show();$('#sendbuttonchat').hide();$('#selectbuttons').hide(); fetchChat();">
										<div class="presenter">Press Enter to Send</div>
									</label>
								</li>

								<li>
									<label>
										<input type="radio" name="setpressenter" id="presssendbutton" value="2"
											onclick="$('#frmposthome3').submit();$('#sendpressenter').hide();$('#sendbuttonchat').show();$('#selectbuttons').hide(); fetchChat();">
										<div class="presenter">Click Send</div>
									</label>
								</li>

							</ul>
						</form>
					</div>
				</div>
			</li>

		</ul>
	</div>

	<input type="hidden" name="chatuserid" id="chatuserid" value="<?php echo encodeStr($id); ?>">
</div>
<script>
	window.fetchChat = function () {
		var chatDiv = $("#loadchatusermsg");
		var userId2 = $('#chatuserid').val();

		$.get('<?php echo $fullurl; ?>getchat.php', { action: 'getchat', contactId: userId2 }, function (data) {
			if (data.trim() !== '') {
				chatDiv.append(data);
				chatDiv.scrollTop(chatDiv[0].scrollHeight);
			}
		});
	}


</script>
<script>
	<?php if ($_SESSION['sesssetpressenter'] == 2) { ?>
		$('#sendpressenter').hide(); $('#sendbuttonchat').show(); $('#selectbuttons').hide();
	<?php } else { ?>
		$('#sendpressenter').show(); $('#sendbuttonchat').hide(); $('#selectbuttons').hide();
	<?php } ?>

	<?php if ($mobile == 'y') { ?>
		$('#sendpressenter').hide(); $('#sendbuttonchat').show(); $('#selectbuttons').hide();
	<?php } ?>
</script>
<style>
	.send-list {
		position: absolute;
		background: #fff;
		border: 1px solid #ccc;
		list-style: none;
		padding: 5px;
		margin: 5px 0;
		right: 0;
		z-index: 9999;
		display: none;
		border-radius: 8px;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
	}

	.send-list li {
		padding: 6px 10px;
		cursor: pointer;
	}

	.send-list li:hover {
		background: #f5f5f5;
	}
</style>
<!-- <script>
	function refreshChat() {
		var id = $('#chatuserid').val();

		var chatDiv = $("#loadchatusermsg");
		var isAtBottom = (chatDiv.scrollTop() + chatDiv.innerHeight() >= chatDiv[0].scrollHeight);

		chatDiv.load('load_message.php?userId2=' + id, function () {
			if (isAtBottom) {
				chatDiv.scrollTop(chatDiv[0].scrollHeight);
			}
		});
	}

	$(document).ready(function () {
		refreshChat(); // first load
		setInterval(refreshChat, 1000); // refresh every 1 sec
	});
</script> -->


<script>
	$(".chat-cont-user-list").removeClass('active1');
	$("#chatlist<?php echo $id; ?>").addClass('active1');

	$("#chatfieldfooter").focus();
	$("#loadchatusermsg").load('load_message.php?userId2=<?php echo encodeStr($id); ?>');

	/* ================================
	   Send Text Chat
	================================ */
	function typeandsendchat(id) {
		var chatfieldfooter = $('#chatfieldfooter').val().replace(/\n/g, "<br />");
		if (chatfieldfooter != "<br />") {
			chatfieldfooter = encodeURIComponent($.trim(chatfieldfooter));

			if (chatfieldfooter != '' && id != '') {
				$('#textchatactiondiv').load('<?php echo $fullurl; ?>getchat.php?action=chat&contactId=' + id + '&text=' + chatfieldfooter);
				$("#chatfieldfooter").focus();
			}
		}
		$("#chatfieldfooter").val('');
	}

	$("#chatfieldfooter").keypress(function (e) {
		if (e.which == 13) {
			var setpressenter = $('input[name=setpressenter]:checked').val();
			if (setpressenter == 1) {
				var id = $('#chatuserid').val();
				typeandsendchat(id);
				e.preventDefault();
			}
		}
	});

	function clicktosendchat() {
		var id = $('#chatuserid').val();
		typeandsendchat(id);
	}

	/* ================================
	   Upload Attachment with Preview
	================================ */
	$('#chatattachedbutton').click(function () {
		$('#chatattachedfile').click();
		var contactchatuserid = $('#chatuserid').val();
		$('#contactchatuserid').val(contactchatuserid);
	});

	/* Main upload function */



	function uploaduserfilesfun() {
		const fileInput = document.getElementById('chatattachedfile');
		const file = fileInput.files[0];
		if (!file) return;

		const contactchatuserid = $('#chatuserid').val();
		$('#contactchatuserid').val(contactchatuserid);

		var form = $('#frmposthome2')[0];
		var formData = new FormData(form);

		$('#commonloader').show();
		$.ajax({
			url: $('#frmposthome2').attr('action'),
			type: 'POST',
			data: formData,
			contentType: false,
			processData: false,
			success: function (response) {
				$('#commonloader').hide();
				$("#loadchatusermsg").load('load_message.php?userId2=' + contactchatuserid);
			},
			error: function (xhr, status, error) {
				console.error(error);
				$('#commonloader').hide();
			}
		});
	}



</script>