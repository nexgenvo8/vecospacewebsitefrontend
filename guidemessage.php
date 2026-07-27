<?php
include_once('inc.php'); 
$_SESSION['loginredirectpageurl']= (isset($_SERVER['HTTPS']) ? "https" : "http") . "://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
include_once('config/session-check.inc.php'); // check user login session
$pageIndex=27;
$bss=$_REQUEST['msgchatId'];
$userId= decodeStr($bss);

?>
<!DOCTYPE html>
<html>
<head>
<title>My Contacts - <?php echo $companyname;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/responsive.css">
<link rel="stylesheet" type="text/css" href="<?php echo $fullurl;?>css/style.css">
<link rel="icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta content="en" name="language">
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
<script src="<?php echo $fullurl;?>js/jquery.min.js"></script>
<script src="<?php echo $fullurl;?>js/main.js"></script>

</head>
<body>
  <div id="wrapper" class="">
    <?php include ('header.php');?>
	  <div class="container main">
	    <div class="home_container">
		  <?php include ('left-sidebar.php');?>
		   <div class="center_content"> 
			<div class="pnding-contct" id="msgchatguide">
              <div>
			 <?php
			  unset($selectFields);
		      unset($whereFields);
		      unset($whereVals);
				
			    $a="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= ".$userId."";
				$b=mysqli_query($conn,$a) or die(mysqli_error($conn)); 
				$userres=mysqli_fetch_array($b); 
				
				$friendnameurl=$userres['userurl'];
				if($userres["profilePhoto"]!='')
				{
				$userphoto=$userres["profilePhoto"];
				} else {
				$userphoto='user-placeholder.jpg';
				}
		?>     
			<script>
			window.userType = <?php echo (int)$userres['userstype']; ?>;
			// 3 = mentor
			// 1 = student
			</script>

		
		       <?php
			   if($userres['userstype']==1){
			   ?>
			   <div><p class="chatmessagetagline">GUIDE YOUR MENTEES</p></div><?php }else{?>
			   <div><p class="chatmessagetagline">TAKE GUIDANCE FROM YOUR MENTOR</p></div><?php }?>
			    <div class="userchatdiv">
			     <div class="userprofilediv1"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($userphoto));?>"></div> 
				  <div class="userdetailnewwise">
				  <p class="userfntsize"> 
				    <span>
					  <a href="<?php echo $fullurl;?>profile/<?php echo encodeStr($userres['userId']);?>/<?php echo $userres['userurl'];?>.html">
					  <?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["firstName"]);?> <?php echo preg_replace('/[^a-zA-Z0-9_ %\[\]\.\(\)%&-]/s', '', $userres["lastName"]);?>
					   </a>
					</span>
				  </p>
				  <p><?php echo $userres['coursename'];?> <?php echo $userres['departmentname'];?>,Student</p>
				  <p><?php echo $userres['companyName'];?></p>
				  </div>
				  <div class="rightrighticonmsg">
				   <img src="images/checkednew.png">
				  </div>
			    </div>
				<div class="userchatmessage" id="userchatmessage">
				 <div class="chawithmnteediv">
			      <span>Chat With Mentees</span>
				 
				 </div>
				  <div class="userallchattext">
				  <div class="chatmessageboxscrl" id="loadstmtchat">
				  
				  </div>

				  <div id="loadstmtchat1" style="display:none"></div>
					 <div class="useractiondivnew">
						 <div class="inputmaessasetext">
						 <input type="text" placeholder="Type Here" id="sendchat1" onclick="$('#selectbuttons').hide();" >
						 <ul class="ulemojistyle">
						  <li class="emogi" style="margin-left:10px !important;">
						   <a href="javascript:void(0)" class="emoji-toggle" onClick="$('.emoji-list').show()"><i style="font-size:19px;"class="fa fa-smile-o" aria-hidden="true" id="emogilist"></i></a>
						    <div>
							   <ul class="emoji-list">
								<?php include('smily.php');?>
							   </ul>
                            </div>	
                           <div>							
							   <form class="edit-layer" enctype="multipart/form-data" name="frmpoststmt" id="frmpoststmt" method="post" target="actionfrm" action="<?php echo $fullurl;?>common_action.php"> 
							   <span id="hpotostmtid">
								 <input name="stmtattachedfile" id="stmtattachedfile" type="file"  onChange="uploadstmtfilesfun();" style="display:none;" accept="image/x-png,image/gif,image/jpeg,application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf">
							   </span>
								<input type="hidden" name="action" id="action" value="stmtattachedmsg" />
								<input type="hidden" name="stmtchatuserid" id="stmtchatuserid" value="" />
								<input type="hidden" name="loadmsgp" id="loadmsgp" value="0" />
							   </form> 
							   <script>
								function uploadstmtfilesfun(){

									let file = $('#stmtattachedfile')[0].files[0];
									if(!file) return;

									// show preview instantly
									let reader = new FileReader();

									reader.onload = function(e){

										$('#loadstmtchat').append(`
											<div class="userchatboxmain">
												<div class="userchatboxmain_me">
													<div class="userchatboxmain_text_me">
														<div class="imgbox">
															<img src="${e.target.result}" style="width:200px;opacity:0.6;">
														</div>
														<div style="font-size:11px;color:#999;">Uploading...</div>
													</div>
												</div>
											</div>
										`);

										$("#loadstmtchat").scrollTop($("#loadstmtchat")[0].scrollHeight);
									};

									reader.readAsDataURL(file);

									// upload in background
									let formData = new FormData($('#frmpoststmt')[0]);

									$.ajax({
										url: $('#frmpoststmt').attr('action'),
										type: 'POST',
										data: formData,
										contentType: false,
										processData: false,
										success: function(){
											fetchNewChat(); // refresh with real image
										}
									});
								}

								</script>
							</div>
						   </li>
						 </ul>
						 </div>
						
						 <div class="uploadsendmassaction">

							<!-- Upload Photo -->
							<div class="buttonuploadphodd">
								<a id="stmtattachedbutton">
									<div class="buttondivuplodphoto">
										<i class="fa fa-file-image-o"></i>
										<span>Upload Photo</span>
									</div>
								</a>
							</div>

							<!-- Schedule Event -->
							<div class="buttonuploadphodd">
								<a onclick="sharefuncommonpopupwin('450px','auto',
									'common_popup_inner.php?type=scheduleevent',
									'Schedule Event','');">

									<div class="buttondivuplodphoto">
										<i class="fa fa-calendar"></i>
										<span>Schedule Event</span>
									</div>

									</a>

							</div>
							<!-- Upload Recording -->
							<div class="buttonuploadphodd">
								<a id="stmtrecordbutton">
									<div class="buttondivuplodphoto">
										<i class="fa fa-microphone"></i>
										<span>Upload Recording</span>
									</div>
								</a>
							</div>
							<input name="stmtrecordfile"
       id="stmtrecordfile"
       type="file"
       style="display:none;"
       accept="audio/*,video/*"
       onChange="uploadRecordingFun();">



							<!-- Send Button -->
							<div class="sendmessaagepost">
								<button id="postbuttonchat" onClick="postsmchat();">Post</button>
							</div>

							<input type="hidden" name="smpostid" id="smpostid" value="<?php echo $bss;?>">

						</div>

				     </div>
				  </div>
				</div>
			  </div>
		     </div>
		   </div>	
	    </div>  
      </div>
  </div>
  
  <script>

// ==========================
// GLOBAL EDIT HOLDER
// ==========================
window.editingEvent = null;


// ==========================
// EDIT EVENT CLICK
// ==========================
$(document).on('click', '.edit-event', function(){

    let box = $(this).closest('.chat-event');

   


    if(box.hasClass('expired-meeting')) return;

    window.editingEvent = {
        element: box,
        stmtId: box.attr('data-msg-id'),
        link: box.attr('data-link'),
        date: box.attr('data-date'),
        time: box.attr('data-time')
    };

    sharefuncommonpopupwin(
        '450px',
        'auto',
        'common_popup_inner.php?type=scheduleevent',
        'Edit Meeting',
        ''
    );
});




// ==========================
// MEETING TIMER / STATUS
// ==========================
// ==========================
// MEETING TIMER / STATUS
// ==========================
function updateMeetings(){

    $('.chat-event').each(function(){

        let box  = $(this);

        let date = box.attr('data-date');
        let time = box.attr('data-time');

        if(!date || !time) return;

        let meetTime = new Date(date + 'T' + time);
        let now = new Date();

        let status = box.find('.meeting-status');
        let link   = box.find('.event-link');
        let editBtn = box.find('.edit-event');

        // ================= EXPIRED =================
        if(now > meetTime){

            editBtn.css({
                'pointer-events':'none',
                'opacity':0.4,
                'cursor':'not-allowed'
            });

            status.html('❌ Meeting Finished');

            link.removeAttr('href')
                .css({
                    'pointer-events':'none',
                    'color':'#999',
                    'text-decoration':'line-through'
                })
                .text('Meeting Expired');

            box.addClass('expired-meeting');

            // ✅ ADD ATTENDANCE ONLY ONCE (REAL DOM CHECK)
           // ✅ ADD ATTENDANCE ONLY ONCE
let saved = box.attr('data-attendance');

if(!saved && box.find('.attendance-select').length === 0){

    box.find('.attendance-row').html(`
        <div style="display:flex;align-items:center;gap:10px;margin-top:5px;">
            <strong>Attended:</strong>
            <select class="attendance-select">
                <option value="">Select</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
            <button class="attendance-save">✔</button>
        </div>
    `);
}


        } 
        // ================= ACTIVE =================
        else {

            editBtn.css({
                'pointer-events':'auto',
                'opacity':1,
                'cursor':'pointer'
            });

            let diff = meetTime - now;
            let mins = Math.floor(diff / 60000);
            let secs = Math.floor((diff % 60000) / 1000);

            status.html(`⏳ Starts in ${mins}m ${secs}s`);

            box.removeClass('expired-meeting');
        }
    });
}

// run timer slower (no DOM spam)
setInterval(updateMeetings, 5000);

// ==========================
// RUN TIMER
// ==========================
setInterval(updateMeetings, 1000);


// ==========================
// SAVE ATTENDANCE
// ==========================
$(document).on('click', '.attendance-save', function(){

    let box = $(this).closest('.chat-event');

    // prevent double click spam
    if(box.data('saving')) return;
    box.data('saving', true);

    let id = box.attr('data-msg-id');
    let select = box.find('.attendance-select');
    let val = select.val();

    if(!val){
        alert("Select attendance first");
        box.removeData('saving');
        return;
    }

    if(!id){
        alert("Invalid meeting ID");
        box.removeData('saving');
        return;
    }

    $.ajax({
        url:'load_studentmentorchat.php',
        type:'POST',
        data:{ msgId:id, attendance:val },

        success:function(res){

            if(res.trim() !== "success"){
                alert("Failed to save attendance");
                box.removeData('saving');
                return;
            }

            // lock UI
            select.prop('disabled', true);
            box.find('.attendance-save').remove();

            let html = `
                <span style="color:green;font-weight:600;margin-left:8px;">
                    ✔ Saved
                </span>
            `;

            // student → feedback
            if(window.userType == 1 && val === "yes"){
                html += `
                    <button class="feedback-btn"
                        style="margin-left:10px;background:#28a745;color:white;
                        border:0;padding:4px 8px;border-radius:4px;cursor:pointer;">
                        Give Feedback
                    </button>
                `;
            }

            // mentor → testimonial
            if(window.userType == 3 && val === "yes"){
                html += `
                    <button class="testimonial-btn"
                        style="margin-left:10px;background:#C02621;color:white;
                        border:0;padding:4px 8px;border-radius:4px;cursor:pointer;">
                        Add Testimonial
                    </button>
                `;
            }

            box.find('.attendance-row').append(html);
            box.removeData('saving');
        },

        error:function(){
            alert("Server error");
            box.removeData('saving');
        }
    });

});


// ==========================
// OPEN FEEDBACK POPUP
// ==========================
$(document).on('click', '.feedback-btn', function(){

    let box = $(this).closest('.chat-event');
    window.currentFeedbackId = box.attr('data-msg-id');

    sharefuncommonpopupwin(
        '450px',
        'auto',
        'common_popup_inner.php?type=stmtfeedback',
        'Give Feedback',
        ''
    );
});


// ==========================
// OPEN TESTIMONIAL POPUP
// ==========================
$(document).on('click', '.testimonial-btn', function(){

    let box = $(this).closest('.chat-event');
    let msgId = box.attr('data-msg-id');

    sharefuncommonpopupwin(
        '450px',
        'auto',
        'common_popup_inner.php?type=stmttestimonial&msgId=' + msgId,
        'Add Testimonial',
        ''
    );
});
// Store meeting data
let meetingData = {};

// Function to mark attendance
function markAttendance(meetingId, status, buttonElement) {
    let meetingDiv = $(buttonElement).closest('.meeting-event');
    let attendanceRow = meetingDiv.find('.attendance-row');
    let testimonialRow = meetingDiv.find('.testimonial-row');
    
    if(status === 'yes') {
        attendanceRow.html('<strong>Attendance:</strong> ✓ Yes (Present)');
        testimonialRow.show(); // Show testimonial button
        testimonialRow.html('<button class="testimonial-btn" onclick="openTestimonialModal(\'' + meetingId + '\')" style="background:#C02621; color:white; padding:5px 15px; border:0; border-radius:3px;">📝 Write Testimonial</button>');
        
        // Store meeting info for testimonial
        meetingData[meetingId] = {
            date: meetingDiv.data('date'),
            time: meetingDiv.data('time'),
            link: meetingDiv.data('link'),
            status: 'yes'
        };
        
        // Open testimonial modal immediately
        openTestimonialModal(meetingId);
    } else {
        attendanceRow.html('<strong>Attendance:</strong> ✗ No (Absent)');
        testimonialRow.hide();
        
        meetingData[meetingId] = {
            date: meetingDiv.data('date'),
            time: meetingDiv.data('time'),
            link: meetingDiv.data('link'),
            status: 'no'
        };
    }
    
    // Get the chat message ID
    let msgElement = meetingDiv.closest('.userchatboxmain, .chat-message');
    let msgId = msgElement.data('msgid') || msgElement.attr('id');
    
    // Save attendance to database
    $.ajax({
        url: 'save_attendance.php',
        type: 'POST',
        data: {
            attendance: status,
            meetingId: meetingId,
            msgId: msgId,
            meetingDate: meetingDiv.data('date'),
            meetingTime: meetingDiv.data('time'),
            meetingLink: meetingDiv.data('link')
        },
        success: function(response) {
            console.log("Attendance saved:", response);
        },
        error: function() {
            console.error("Error saving attendance");
        }
    });
}

// Testimonial Modal HTML (add to your page)
let testimonialModalHtml = `
<div id="testimonialModal" style="display:none; position:fixed; z-index:9999; left:0; top:0; width:100%; height:100%; background-color:rgba(0,0,0,0.5);">
    <div style="background-color:#fff; margin:10% auto; padding:20px; width:80%; max-width:500px; border-radius:8px;">
        <div style="display:flex; justify-content:space-between; border-bottom:1px solid #ddd; padding-bottom:10px; margin-bottom:15px;">
            <h3 style="margin:0; color:#C02621;">Write Testimonial</h3>
            <span onclick="closeTestimonialModal()" style="font-size:28px; cursor:pointer;">&times;</span>
        </div>
        <div style="margin-bottom:15px; padding:10px; background:#f5f5f5; border-radius:5px;" id="testimonialStudentInfo">
            <!-- Student info will be loaded here -->
        </div>
        <textarea id="testimonialTextArea" style="width:100%; height:150px; border:1px solid #ccc; padding:8px;" placeholder="Write your testimonial about the meeting..."></textarea>
        <div style="margin-top:15px; text-align:right;">
            <button onclick="closeTestimonialModal()" style="padding:8px 15px; margin-right:10px;">Cancel</button>
            <button onclick="saveTestimonial()" style="background:#C02621; color:white; padding:8px 15px; border:0; border-radius:3px;">Save Testimonial</button>
        </div>
    </div>
</div>`;

// Add modal to page if not exists
if(!document.getElementById('testimonialModal')) {
    $('body').append(testimonialModalHtml);
}

let currentMeetingId = null;

function openTestimonialModal(meetingId) {
    currentMeetingId = meetingId;
    
    // Get student info from the page
    let studentName = $('.student-name, .contact-name').text() || 'Student';
    let studentRegNo = $('.registration-no, .student-reg').text() || 'N/A';
    let meetingInfo = meetingData[meetingId] || {};
    
    let infoHtml = `
        <strong>Student Name:</strong> ${studentName}<br>
        <strong>Registration No:</strong> ${studentRegNo}<br>
        <strong>Meeting Date:</strong> ${meetingInfo.date || 'N/A'}<br>
        <strong>Meeting Time:</strong> ${meetingInfo.time || 'N/A'}
    `;
    
    $('#testimonialStudentInfo').html(infoHtml);
    $('#testimonialTextArea').val('');
    $('#testimonialModal').fadeIn();
}

function closeTestimonialModal() {
    $('#testimonialModal').fadeOut();
    currentMeetingId = null;
}

function saveTestimonial() {
    let testimonialText = $('#testimonialTextArea').val().trim();
    
    if(!testimonialText) {
        alert("Please write your testimonial");
        return;
    }
    
    // Get the chat message ID containing this meeting
    let meetingDiv = $('.meeting-event[data-meeting-id="' + currentMeetingId + '"]');
    let msgElement = meetingDiv.closest('.userchatboxmain, .chat-message');
    let msgId = msgElement.data('msgid') || msgElement.attr('id');
    
    $.ajax({
        url: 'save_attendance.php',
        type: 'POST',
        data: {
            action: 'testimonial',
            meetingId: currentMeetingId,
            msgId: msgId,
            text: testimonialText
        },
        success: function(response) {
            alert("Testimonial saved successfully!");
            closeTestimonialModal();
            
            // Update the testimonial button
            let testimonialRow = meetingDiv.find('.testimonial-row');
            testimonialRow.html('<span style="color:green;">✓ Testimonial submitted</span>');
        },
        error: function() {
            alert("Error saving testimonial. Please try again.");
        }
    });
}

function fetchNewChat() {
    let id = $('#smpostid').val();

    $('#loadstmtchat').load(
        '<?php echo $fullurl; ?>load_stmtchat.php?stmtId=' + id
    );
}

$('#stmtrecordbutton').click(function(){

    window.currentRecordingId = $('#smpostid').val();

    sharefuncommonpopupwin(
        '450px',
        'auto',
        'common_popup_inner.php?type=recording',
        'Upload Recording',
        ''
    );
});



</script>

   <script>
	    $("#loadstmtchat").load('load_stmtchat.php?stmtId=<?php echo $bss;?>');
		

   </script>
    <script>
		<?php if($_SESSION['sesssetpressenter']==2){?>
		$('#sendpressenter').hide();$('#sendbuttonchat').show();$('#selectbuttons').hide();
		<?php }else{?>
		$('#sendpressenter').show();$('#sendbuttonchat').hide();$('#selectbuttons').hide();
		<?php }?>

		<?php  if($mobile=='y'){?>
		$('#sendpressenter').hide();$('#sendbuttonchat').show();$('#selectbuttons').hide();
		<?php }?>
	  </script>
  <script>
  /*$("#chatfieldfooter").keypress(function(e) {
		if(e.which == 13) {
		var setpressenter = $('input[name=setpressenter]:checked').val();
		if(setpressenter==1)
		{	
			var id = $('#chatuserid').val();
			typeandsendchat(id);
			e.preventDefault();
		}
		}
	});*/
		$("#sendchat1").keypress(function(e) {
			if(e.which == 13) {
			
			var setpressenter = $('input[name=setpressenter]:checked').val();
			
			if(setpressenter==1)
			{
				var id = $('#smpostid').val();
				typesmchat(id);
				e.preventDefault();
			 }
			}
		});
		
		function postsmchat()
		{
			var id = $('#smpostid').val();
			typesmchat(id);
		}
		
		function typesmchat(id){
    var sendchat1 = $('#sendchat1').val();
    sendchat1 = encodeURIComponent($.trim(sendchat1));

    if(sendchat1!='' && id!=''){

        $('#loadstmtchat').load(
            '<?php echo $fullurl; ?>load_studentmentorchat.php?action=chat&stmtId='+id+'&text='+sendchat1,
            function(){
                fetchNewChat(); // 👈 instantly refresh after sending
            }
        );

        $("#sendchat1").focus();
    }

    $("#sendchat1").val('');
}

		$('#stmtattachedbutton').click(function(){
			$('#stmtattachedfile').click();	
			var stmtchatuserid=$('#smpostid').val(); 
			$('#stmtchatuserid').val(stmtchatuserid); 
		});	
  </script>
<?php include ('footer.php');?>


</body>
</html>
<style>
.chat-event.expired-meeting {
    background: inherit;
    border-left: inherit;
}

.chat-event a,
.chat-event a:visited {
    color: #0d6efd !important;
    text-decoration: underline !important;
}

.chat-event.expired-meeting a {
    color: #999 !important;
    text-decoration: line-through !important;
    pointer-events: none;
}

.uploadsendmassaction {
    display: flex;
    align-items: center;
    gap: 10px;
}

.buttonuploadphodd {
    display: inline-flex;
}
.chat-event {
    background: #e7f3ff;
    border-left: 4px solid #0d6efd;
    padding: 10px;
    border-radius: 10px;
    font-size: 14px;
    margin-top: 5px;
}

.chat-event.expired-meeting {
    background: #f8d7da;
    border-left: 4px solid #dc3545;
}

.event-title {
    font-weight: 600;
    color: #0d6efd;
    display: flex;
    justify-content: space-between;
}

.edit-event {
    cursor: pointer;
    font-size: 14px;
}


</style>
