<?php
require 'vendor/autoload.php';
use OpenTok\OpenTok;

$apiKey = '45964872';
$apiSecret = '90f7de5d12a1d2e9dd7b74ffef0721b04fc22c1d';
$opentok = new OpenTok($apiKey, $apiSecret);

use OpenTok\MediaMode;
use OpenTok\ArchiveMode;


// An automatically archived session:
$sessionOptions = array(
  'archiveMode' => ArchiveMode::ALWAYS,
  'mediaMode' => MediaMode::ROUTED
);
$session = $opentok->createSession($sessionOptions);


// Store this sessionId in the database for later use
$sessionId = $session->getSessionId();
$TokenRequest = $opentok->generateToken($sessionId);
?>

<script>
  $("input").keypress(function (event) {
    if (event.which == 13) {
      event.preventDefault();
      if ($("#txtUsername").val() != '' && $("#txtPassword").val() != '') {
        $("#kUserLogin").submit();
      }
    }
  });

</script>

<style>
  .chat-cont {
    width: 68px;
    position: fixed;
    right: 0px;
    top: 0px;
    height: 100%;
  }

  #chatcontactload {
    display: block !important;
    height: 100% !important;
    padding-top: 59px;
  }

  .chat-cont .chat-cont-header {
    display: none;
  }

  #usermainboxchat {
    right: 82px !important;
  }
</style>
<div class="copyright" style="margin-top:20px; display: none;"><a>Privacy</a> - <a>Terms</a> - <a>About</a> - <a
    href="<?php echo $fullurl; ?>faq.html">FAQ's</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &copy; <?php echo date("Y"); ?> The
  copyright is OMSR Media Pvt. Ltd | All rights reserved</div>


<link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/custom.css">
<div id="successmessage-outer" style="display: none;">
  <div id="successmessage">
    <div class="msgimg">
      <i class="fa fa-check" aria-hidden="true"></i>
    </div>
    <div class="successmsg-heading">

    </div>
    <div class="mtxt">

    </div>
    <div class="donebtn" onclick="closeshowsusmsg();">
      DONE
    </div>
  </div>
</div>



<div id="successmessage-outer" style="display: none;" class="warningmessage">
  <div id="successmessage">
    <div class="msgimg">
      <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
    </div>
    <div class="successmsg-heading">

    </div>
    <div class="mtxt">

    </div>
    <div class="donebtn" onclick="closeserrormsg();">
      OK
    </div>
  </div>
</div>


<div id="susmsgblk" style="display: none;">

</div>

<div class="foottr">
  <ul>
    <li><a href="<?php echo $fullurl; ?>timeline.html"><i class="fa fa-home" aria-hidden="true"></i></a></li>
    <li><a href="<?php echo $fullurl; ?>contacts.html"><i class="fa fa-user" aria-hidden="true"></i></a></li>
    <li><a href="<?php echo $fullurl; ?>groups.html"><i class="fa fa-users" aria-hidden="true"></i></a></li>
    <li><a
        href="<?php echo $fullurl; ?>myprofile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $myurl; ?>.html"><img
          src="<?php echo $fullurl; ?>uploads/<?php echo $myprofilePhoto; ?>"></a></li>
  </ul>
</div>
<script src="<?php echo $fullurl; ?>js/jquery.typewriter.js"></script>




<?php
$slideText = '';
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlOptions = "";
$sqlOptions = "SELECT membershipText FROM " . _MEMBERSHIP_FEATURES_TABLE_ . " ORDER BY membershipText ASC ";
$resOptions = getRecords(_MEMBERSHIP_FEATURES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
if ($resOptions) {
  while ($rowOptions = mysqli_fetch_array($resOptions)) {
    $slideText .= '"' . $rowOptions["membershipText"] . '",';
  }
}
?>
<script>
  $('#typewriter').typewriter({
    prefix: "",
    text: [<?php echo $slideText; ?>],
    typeDelay: 50,
    waitingTime: 3000,
    blinkSpeed: 200
  });



  $(document).ready(function () {
    $(".setting").click(function () {
      $(this).find(".setting_menu").slideToggle("fast");
    });
  });


  $(document).ready(function () { $(document).click(function (e) { if ($(e.target).is('#emogilist')) { } else { $('.emoji-list').hide(); } }); });

  $(document).ready(function () { $(document).click(function (e) { if ($(e.target).is('#openpressenter')) { } else { $('#selectbuttons').hide(); } }); });
</script>

<div id="commonaction" style="direction:none;"></div>
<iframe name="actionfrm" id="actionfrm" style="display:none;"></iframe>




<?php

if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0 && $fpage != 1) {
  unset($_SESSION['loginredirecturl']);
  if ($pageIndex != 3) {
    $sql_contact = "SELECT * from " . _CONTACT_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND status=1";
    $res_contact = mysqli_query($conn, $sql_contact) or die(mysqli_error($conn));
    $contactrequests = mysqli_num_rows($res_contact);
    ?>
    <div onclick="$('#selectbuttons').hide();" class="chat-cont" <?php if ($contactrequests < 1) { ?>style="display:none;" <?php } ?>>
      <div class="chat-cont-header" id="mainfriedboxlist" onclick="hideshowfooterchatbox();"><span
          id="msgheaderfooter">+</span>Messaging <span class="minimiz"> <a class="bulkmsg"
            onclick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=sendbulkemails','New message');"><i
              class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
          <!--<i class="fa fa-plus" aria-hidden="true" id="plusicon"  onclick="$('#chatcontactload').toggle();$('#minusicon').show();$('#plusicon').hide();"></i>
   <i style="display:none;" class="fa fa-minus" aria-hidden="true" id="minusicon"  onclick="$('#chatcontactload').toggle();$('#minusicon').hide();$('#plusicon').show();"></i>-->
        </span></div>
      <div class="chatsearchmsg" style="display:none;"><i class="fa fa-search" aria-hidden="true"></i><input type="text"
          name="chatsearch" id="chatsearch" onkeyup="searchcontactfun();" placeholder="Search" /></div>
      <div id="chatcontactload" style="display:none; height:320px;"> </div>




      <script>
        $('#chatcontactload').load('<?php echo $fullurl; ?>load_chat_online_contacts.php');

        function hideshowfooterchatbox() {
          var msgheaderfooter = $("#msgheaderfooter").text();
          if (msgheaderfooter == '+') {
            $("#msgheaderfooter").text('-');
            $("#chatcontactload").show();
            $(".chatsearchmsg").show();
          }
          else {
            $("#msgheaderfooter").text('+');
            $("#chatcontactload").hide();
            $(".chatsearchmsg").hide();
          }
        }




        var win;
        var winClosed;
        clearInterval(winClosed);

        function openvideocall() {

          var vidchatuserid = $('#chatuserid').val();
          $('.vdocall-msg').show();
          $('.vdo-icon').addClass('active');
          var uniqueNumber = new Date().getTime();

          win = window.open('<?php $fullurl; ?>konectt-live.html?sendcall=1&s=<?php echo $sessionId; ?>&t=<?php echo $TokenRequest; ?>&u=' + vidchatuserid + '', 'Konectt Video Call', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=960,height=600');

          var winClosed = setInterval(function () {
            if (win.closed) {
              clearInterval(winClosed);
              endcallmain();
            }

          }, 250);
        }







        function closeit() {
          win.close();

        }

        function endcallmain() {
          $('.vdocall-msg').hide();
          $('.vdo-icon').removeClass('active');
          $('#getnotifications').load('common_action.php?videocallcut=1');
        }



      </script>
    </div>
    <div
      style="width:336px; display:none; position:fixed; right:380px; bottom:0px; z-index:999; background-color:#FFFFFF; box-shadow: 0px 0px 5px #a0a0a0;"
      id="usermainboxchat">
      <div class="chat-cont-header">
        <span id="userchatname" onclick="$('#loaduserchatbox').toggle();"></span>
        <a href="#" id="videocallinguserIcon" onclick="$('#videocallinguserIcon').hide();" target="_blank"><span
            class="vdo-icon">&nbsp;</span></a>
        <span class="minimiz" onclick="$('#loaduserchatbox').toggle();"><i class="fa fa-minus"
            aria-hidden="true"></i></span>
        <span class="close-cht" style="position:absolute;font-size:inherit; right:14px; top:8px;"
          onclick="$('#usermainboxchat').hide();clearint();$('#shb').val('0');"><i class="fa fa-times"
            aria-hidden="true"></i></span>
        <div class="vdocall-msg" style="display:none;">You are in this video call<div class="chat-btns">
            <button
              onclick="Declinecall();$('.chat-btns').hide();$('.chat-btns').hide();$('.vdocall-msg').hide();$('.vdo-icon').removeClass('active');">Decline</button>
            <a href="<?php echo $fullurl; ?>konectt-live.html?ac=1" target="_blank"
              onclick="$('.chat-btns').hide();stopring();"><button>Answer</button></a>
          </div>
        </div>
      </div>
      <div id="loaduserchatbox">
        <div style="height:256px; overflow:auto;" id="loadchatusermsg"></div>
        <div style="border-top:2px #1a94c3 solid;">
          <div><span id="chatfieldbox"><textarea name="chatfieldfooter" id="chatfieldfooter" type="text"
                style="border:0px; max-width:100%;width: 100%;max-height: 100px; padding:10px; border:0px;"
                placeholder="Write a message here..." maxlength="800" /></textarea></span>

            <form class="edit-layer" enctype="multipart/form-data" name="frmposthome2" id="frmposthome2" method="post"
              target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
              <span id="hpotohomeid"><input name="chatattachedfile" id="chatattachedfile" type="file"
                  onChange="uploaduserfilesfun();" style="display:none;"
                  accept="image/x-png,image/gif,image/jpeg,application/msword, application/vnd.ms-excel, application/vnd.ms-powerpoint,text/plain, application/pdf"></span>
              <input type="hidden" name="action" id="action" value="chatattachedmsg" />
              <input type="hidden" name="contactchatuserid" id="contactchatuserid" value="" />
              <input type="hidden" name="loadmsgp" id="loadmsgp" value="1" />
              <input type="hidden" name="shb" id="shb" value="0" />
            </form>
            <script>
              function uploaduserfilesfun() {
                $('#frmposthome2').submit();
                $('#commonloader').show();

                var hpotohomeid = $('#hpotohomeid').html();

                $('#chatattachedfile').remove();
                $('#hpotohomeid').html(hpotohomeid);

              }
            </script>
            <ul class="emozi">

              <li class="emogi">
                <a href="javascript:void(0)" class="emoji-toggle" onclick="$('.emoji-list').show();"><i
                    class="fa fa-smile-o" aria-hidden="true" id="emogilist"></i></a>
                <ul class="emoji-list">
                  <?php include('smily.php'); ?>
                </ul>
              </li>
              <li class="atach"><a id="chatattachedbutton"><i class="fa fa-paperclip" aria-hidden="true"></i></a></li>
              <li class="send-sec"><span id="sendpressenter">Press Enter to Send</span> <button class="send"
                  id="sendbuttonchat" onclick="clicktosendchat();">Send</button>
                <div class="click-btn"><a id="sendclick"><i class="fa fa-ellipsis-h" aria-hidden="true"
                      onclick="$('#selectbuttons').toggle();" id="openpressenter"></i></a>
                  <form class="edit-layer" enctype="multipart/form-data" name="frmposthome3" id="frmposthome3" method="post"
                    target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
                    <ul class="send-list" id="selectbuttons" style="display:none;">
                      <li><label><input type="radio" name="setpressenter" id="pressenter" value="1" <?php if ($_SESSION['sesssetpressenter'] == 1 || $_SESSION['sesssetpressenter'] == '') { ?> checked="checked"
                            <?php } ?>
                            onclick="$('#frmposthome3').submit();$('#sendpressenter').show();$('#sendbuttonchat').hide();$('#selectbuttons').hide();">
                          <div class="presenter">Press Enter to Send</div>
                        </label></li>
                      <li><label><input type="radio" name="setpressenter" id="presssendbutton" value="2"
                            onclick="$('#frmposthome3').submit();$('#sendpressenter').hide();$('#sendbuttonchat').show();$('#selectbuttons').hide();"
                            <?php if ($_SESSION['sesssetpressenter'] == 2) { ?> checked="checked" <?php } ?>>
                          <div class="presenter">Click Send</div>
                        </label></li>
                    </ul>
                  </form>
                </div>
              </li>
            </ul>


            <script>
              <?php if ($_SESSION['sesssetpressenter'] == 2) { ?>
                $('#sendpressenter').hide(); $('#sendbuttonchat').show(); $('#selectbuttons').hide();
              <?php } else { ?>
                $('#sendpressenter').show(); $('#sendbuttonchat').hide(); $('#selectbuttons').hide();
              <?php } ?>
            </script>



          </div>
          <div id="textchatactiondiv" style="display:none;"></div>

        </div>
      </div>
    </div>
    <input type="hidden" name="chatuserid" id="chatuserid" />

    <script>
      function openuserchatbox(id, name, url) {
        $('#chatuserid').val(id);
        $('#usermainboxchat').show();
        $('#loaduserchatbox').show();
        $('#userchatname').html('<a href="' + url + '">' + name + '</a>');
        $('#loadchatusermsg').html('');
        $('#loadchatusermsg').load('<?php echo $fullurl; ?>load_chat_user_msg.php?userId=' + id);
        $("#loadchatusermsg").scrollTop($("#loadchatusermsg")[0].scrollHeight);
        $("#chatfieldfooter").focus();
      }

      function typeandsendchat(id) {
        //var chatfieldfooter = $('#chatfieldfooter').val(); 

        var chatfieldfooter = document.getElementById("chatfieldfooter").value.replace(/\n/g, "<br />");

        var shb = $("#shb").val();
        if (chatfieldfooter != "<br />") {
          //alert(chatfieldfooter);	
          chatfieldfooter = encodeURIComponent($.trim(chatfieldfooter));

          if (chatfieldfooter != '' && id != '') {
            $('#textchatactiondiv').load('<?php echo $fullurl; ?>common_action.php?action=chat&contactId=' + id + '&text=' + chatfieldfooter + '&shb=' + shb);

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
          }
        }
      });

      function clicktosendchat() {
        var id = $('#chatuserid').val();
        typeandsendchat(id);
      }

      function searchcontactfun() {
        var chatsearch = '';
        chatsearch = $('#chatsearch').val();
        if (chatsearch != '') {
          var chatsearch = encodeURIComponent(chatsearch);
          $('#chatcontactload').load('<?php echo $fullurl; ?>load_chat_online_contacts.php?chatsearch=' + chatsearch);
        }

      }
      var blurvalue = 2;
      clearInterval(handle);


      $(window).blur(function (e) {

        blurvalue = 1;
      });

      $(window).focus(function (e) {

        blurvalue = 2;
      });

      var handle = setInterval(function () {


        if (blurvalue == 2) {

          var id = $('#chatuserid').val();
          $('#textchatactiondiv').load('<?php echo $fullurl; ?>common_action.php?action=getchat&contactId=' + id);
          var chatsearch = '';
          chatsearch = $('#chatsearch').val();
          if (chatsearch != '') {
            var chatsearch = encodeURIComponent(chatsearch);
            $('#chatcontactload').load('<?php echo $fullurl; ?>load_chat_online_contacts.php?chatsearch=' + chatsearch);
          }


        }

        $('#getnotifications').load('<?php echo $fullurl; ?>getallnotifications.php');

        $('#chatcontactload').load('<?php echo $fullurl; ?>load_chat_online_contacts.php');

      }, 5000000);

      function clearint() {
        clearInterval(handle);
      }


      function opensharebox(url, title) {
        var title = encodeURIComponent(title);
        $('#sharebox').show();
        $('#shareinner').load('shareinner.php?url=' + url + '&title=' + title);
      }
    </script>

  <?php } ?>


  <div class="share-popup-cont" style="display: none;" id="sharebox">
    <div class="share-pop">
      <a class="grp-close" onclick="$('.share-popup-cont').hide();"><i class="fa fa-times" aria-hidden="true"></i></a>
      <h2>Share</h2>
      <ul class="share-list" id="shareinner">

      </ul>
    </div>
  </div>

  <div class="popup-alert-cont" style="display:none;" id="alertpopup">
  </div>


  <div class="img-popup" id="imagepopup" style="display:none;">
  </div>


  <div id="actionpostdivs" style=" display:none;"></div>

  <div class="share-popup" id="sharepopup">
    <div class="sare-img-pop">
      <h2>Upload file</h2>
      <form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post"
        target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">

        <div class="share-pop-inner" id="sharepopinner">

        </div>

        <div class="popup-fttr" style="padding: 20px;"> <a
            onclick="$('.share-popup').hide();$('#posturl').val('');removefilefunc();">Cancel</a>
          <button type="submit" class="btn">Post</button>
        </div>
        <div id="hideremovablefilediv" style="display:none;"></div>
        <script>
          function removefilefunc() {
            var hidact = $('#hidact').val();
            var groupFileId = $('#groupFileId').val();
            var hideremovablefile = $('#hideremovablefile').val();
            if (hidact == 1 && groupFileId != '' && hideremovablefile != '') {
              $("#hideremovablefilediv").load('<?php echo $fullurl; ?>common_action.php?action=rmpgrpfile&rmfileId=' + groupFileId + '&rmfilename=' + hideremovablefile);
            }
          }
        </script>
      </form>
    </div>
  </div>
  <div class="crt-grp-popup" style="display: none;" id="groupformdiv">
    <div class="popup-inner">

      <a class="grp-close" onClick="$('.crt-grp-popup').hide();$('body').css('overflow','auto');">
        <i class="fa fa-times" aria-hidden="true"></i></a>
      <form enctype="multipart/form-data" name="creategroup" id="creategroup" method="post" target="actionfrm"
        action="<?php echo $fullurl; ?>common_action.php" onsubmit="formValidation('creategroup');return false" />
      <div class="nw-grup">
        <h3>Create Group</h3>
        <label>Group type<span class="reqstar">*</span></label>
        <select name="groupType" id="groupType" onchange="changegrouptype();">
          <option value="0">Public</option>
          <option value="1">Private</option>
        </select>

        <label>Group name<span class="reqstar">*</span></label>
        <input type="text" name="groupName" id="groupName" class="validate"
          placeholder="e.g. 'Marketing specialists Warsaw'" maxlength="100">
        <script>
          $("#groupName").focus();
        </script>
        <div id="textareadiv">
          <label>Short group description</label>
          <textarea name="groupDetails" id="groupDetails" rows="4" style="height:100px; margin-bottom:5px;"
            placeholder="Describe your group " maxlength="150"></textarea>
          <div style="margin-bottom:10px;">Max 150 Characters</div>
        </div>
        <div style=""><input type="checkbox" checked="checked" disabled="disabled" /> Yes, I agree to and accept the code
          of <a href="<?php echo $fullurl; ?>conduct-guidelines.html" target="_blank">conduct for moderators</a>.</div>
      </div>
      <div class="popup-fttr">
        <button type="submit" class="konecttbtn konecttbtngbtn">Create</button>
      </div>
      <input type="hidden" name="action" id="action" value="addnewgrp" />
      </form>


    </div>
  </div>




  <div class="crt-grp-popup" id="inviteemail">
    <div class="popup-inner" style="width: 400px">
      <div class="invit">
        <a class="grp-close" onclick="$('#inviteemail').hide();"><i class="fa fa-times" aria-hidden="true"></i></a>
        <div id="showinvitediv">
          <form enctype="multipart/form-data" name="inviteemailaddress" id="inviteemailaddress" method="post"
            target="actionfrm" action="<?php echo $fullurl; ?>common_action.php" />
          <div class="nw-grup">
            <h3>Invite by email</h3>
            <label>Email address<span class="reqstar">*</span></label>
            <input type="text" name="txtuseremail" id="txtuseremail" placeholder="Separate e-mail addresses with commas."
              maxlength="250" class="validate">

            <input type="hidden" name="action" id="action" value="sendtouserinvitation">
            <input type="hidden" name="groupinvitationid" id="groupinvitationid"
              value="<?php echo encodeStr($_REQUEST['groupId']); ?>">
            <input type="hidden" name="invitegroupname" id="invitegroupname"
              value="<?php echo stripslashes(trim($rowGroup["groupName"])); ?>">
          </div>
          <div class="popup-fttr">
            <button type="button" onClick="formValidation('inviteemailaddress');" class="konecttbtn">Send
              invitation</button>
          </div>
          </form>
        </div>

        <div id="hideinvitediv" style="display:none;">
          <div class="suces"><i class="fa-suc"><img src="<?php echo $fullurl; ?>images/suc.png"> </i>
            <span>Invitation Sent!</span>
            <div class="popup-fttr"> <a
                onclick="$('#inviteemail').hide();$('#txtuseremail').val('');$('#sentmsgtextdiv').hide();">Close</a>
              <button type="submit" onclick="$('#hideinvitediv').hide();$('#showinvitediv').show();">More
                invitation</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>


  <div class="vault-slide-cont">
    <button class="close-vault"><img src="<?php echo $fullurl; ?>images/Close.svg"></button>
  </div>
  <script type="text/javascript">

    // var vaultClass = true;
    // $("#vault").click(function () {
    //     $(".vault-slide-cont").toggleClass('open');
    //     vaultClass = false;
    // });
    // $("html,.close-vault").click(function () {
    //     if (vaultClass) {
    //         $(".vault-slide-cont").removeClass('open');
    //     }
    //     vaultClass = true;
    // });


  </script>

  <div class="loader" id="commonloader"><span><img src="<?php echo $fullurl; ?>images/loader.gif">
      <span>Please wait...</span> </span></div>

  <script>
    function changegrouptype() {
      var groupType = $("#groupType").val();
      if (groupType == 1) {
        $("#textareadiv").hide();
      }
      else {
        $("#textareadiv").show();
      }

    }

    function userimgError(image) {
      image.onerror = "";
      image.src = "<?php echo $fullurl; ?>uploads/user-placeholder.jpg";
      return true;
    }
  </script>


  <div class="crt-grp-popup" id="commonpopupwinouter" style="display:none;">
    <div class="popup-inner" id="commonpopupwin">
      <div class="invit">
        <a class="grp-close" onClick="closefuncommonpopupwin();"><i class="fa fa-times" aria-hidden="true"></i></a>


        <div class="nw-grup">
          <h3 id="popuptitle">Loading...</h3>
          <div id="commonpopupwinfile">


          </div>


          <!-- <div class="popup-fttr"> <a onclick="$('#groupuserpopup').hide();">Close</a></div> -->

        </div>


      </div>

    </div>
  </div>
  <div id="getnotifications" style="display:none;"></div>

  <script>


    /*24-10-2017*/
    $('#chatattachedbutton').click(function () {
      $('#chatattachedfile').click();
      var contactchatuserid = $('#chatuserid').val();
      $('#contactchatuserid').val(contactchatuserid);
      //alert($('#chatuserid').val());

    });
    /***********/
    $('#grpsearch').submit(function () {
      // Get the Login Name value and trim it
      var name = $.trim($('#searchgroups').val());
      // Check if empty of not
      if (name === '') {
        //alert('Text-field is empty.');
        return false;
      }
    });



    $(document).mouseup(function (e) {
      var container = $(".remove-list");
      if (!container.is(e.target) && container.has(e.target).length === 0) { container.hide(); }
    });
  </script>

  <div class="crt-grp-popup" id="grouppostpopup" style="display: none;">
    <div class="popup-inner">
      <a class="grp-close"
        onClick="$('.crt-grp-popup').hide();$('#groupPostTitle').val('');$('#groupPostText').val('');"><i
          class="fa fa-times" aria-hidden="true"></i></a>

      <form class="nw-grup" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post"
        target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
        <h3>Write a group post</h3>
        <input type="text" name="groupPostTitle" id="groupPostTitle" placeholder="Write a title for group post"
          maxlength="100" class="validate">
        <textarea rows="4" name="groupPostText" id="groupPostText" placeholder="Write group post"
          style="margin-bottom:5px;"></textarea>
        <div class="post-img">

          <div class="upload-img-cont" id="uploadgroupboximage"></div>

          <div class="upload-img" style="position: relative; margin-top:10px;" id="my-button">

            <table width="0">
              <tbody>
                <tr>
                  <td> <i class="fa fa-cloud-upload" aria-hidden="true"></i></td>
                  <td align="left"> Upload Photo</td>
                </tr>
              </tbody>
            </table>
          </div>



        </div>
        <input type="hidden" name="grouppostpost" id="grouppostpost" value="0">
        <input type="hidden" name="groupId" id="groupId" value="<?php echo $_REQUEST['groupId']; ?>">
        <input type="hidden" name="grouppostId" id="grouppostId" value="<?php echo encodeStr($grouppostId); ?>">
        <div class="popup-fttr">
          <a onClick="$('.crt-grp-popup').hide();$('#groupPostTitle').val('');$('#groupPostText').val('');">Cancel</a>
          <button type="submit" onclick="$('#grouppostpost').val('1');">Post</button>
        </div>
      </form>

      <form class="nw-grup" enctype="multipart/form-data" name="imagegroupfrmposthome" id="imagegroupfrmposthome"
        method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php" style="display:none;">
        <input name="groupimagefilehome" id="groupimagefilehome" type="file"
          onChange="$('#commonloader').show();$('#imagegroupfrmposthome').submit();"
          accept="image/x-png,image/gif,image/jpeg" style="display:none;">

        <input type="hidden" name="groupId" id="groupId" value="<?php echo $_REQUEST['groupId']; ?>">
        <input type="hidden" name="grouppostId" id="grouppostId" value="<?php echo encodeStr($grouppostId); ?>">
      </form>

    </div>
  </div>

  <script>


    function smilyfun(val) {
      $('.emoji-list').hide();
      chatfieldfooter = '';
      if ($("#chatfieldfooter").val() != '') {
        var chatfieldfooter = $("#chatfieldfooter").val();
      }

      $("#chatfieldfooter").val(chatfieldfooter + ' ' + val);
      $("#chatfieldfooter").focus();
    }

    function loadmorechatbox(startpage, userId) {
      var pageid = $("#livechattotalpage").val();

      pageid = Number(pageid) + 1;
      $("#livechattotalpage").val(pageid);
      $("#pageid" + pageid).html('<div style="text-align:center;">Wait please...</div>');
      $("#pageid" + pageid).load('load_more_chat_user_msg.php?startfrom=' + startpage + '&pageid=' + pageid + '&userId=' + userId);

    }


    function loadmorechatboxmessage(startpage, userId) {
      var pageid = $("#livechattotalpage").val();

      pageid = Number(pageid) + 1;
      $("#livechattotalpage").val(pageid);
      $("#pageid" + pageid).html('<div style="text-align:center;">Wait please...</div>');
      $("#pageid" + pageid).load('load_more_chat_user_msg.php?startfrom=' + startpage + '&pageid=' + pageid + '&userId=' + userId);

    }

    function copyToClipboard(element) {
      var $temp = $("<input>");
      $("body").append($temp);
      $temp.val($(element).text()).select();
      document.execCommand("copy");
      $temp.remove();
      $("#clpiboardcopy").fadeIn('fast');
      setTimeout(function () {
        $("#clpiboardcopy").fadeOut('fast');

      }, 2500);
    }

    $('input').keyup(function () { $('input').removeClass('redborderfield'); });
    $('textarea').keyup(function () { $('textarea').removeClass('redborderfield'); });
    $('select').keyup(function () { $('select').removeClass('redborderfield'); });
    $('number').keyup(function () { $('number').removeClass('redborderfield'); });

    $("input").attr('autocomplete', 'off');
  </script>

  <div id="clpiboardcopy"><i class="fa fa-check-circle" aria-hidden="true"></i> Link copied to clipboard.</div>

<?php } else { ?>


  <footer class="hide-mob-footer">
    <div class="container">
      <div class="footer-menu">
        <ul class="foooter-list">
          <li>About Konectt</li>
          <li><a href="<?php echo $fullurl; ?>">Home</a></li>
          <li><a href="<?php echo $fullurl; ?>privacy.html">Privacy</a></li>
          <li><a href="<?php echo $fullurl; ?>terms.html">Terms</a></li>
          <li><a href="<?php echo $fullurl; ?>about.html">About</a></li>
          <li><a href="<?php echo $fullurl; ?>faq.html">FAQ's</a></li>
        </ul>
        <ul class="foooter-list">
          <li>Main Sections</li>
          <li><a href="<?php echo $fullurl; ?>companies.html">Corporate Connect</a></li>
          <li><a href="<?php echo $fullurl; ?>articles-and-trivia.html">Article and Trivia</a></li>
          <li><a href="<?php echo $fullurl; ?>events.html">Events</a></li>
        </ul>


      </div>
    </div>
  </footer>
  <div class="copyright"><?php echo $copyright; ?></div>
<?php } ?>
<input type="hidden" name="vcalluserId" id="vcalluserId" />
<input type="hidden" name="vcallroomname" id="vcallroomname" />
<script src="<?php echo $fullurl; ?>js/validateform.js"></script>
<script>
  function opencallreplay() {
    var vcalluserId = $('#vcalluserId').val();
    var vcallroomname = $('#vcallroomname').val();
    window.open('<?php $fullurl; ?>konectt-live.html?r=' + vcallroomname + '&u=' + vcalluserId + '&ac=1&t=<?php echo $TokenRequest; ?>', 'Konectt Video Call', 'directories=no,titlebar=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no,width=960,height=600');
  }

  var n = 1;
  function openvideocallwindowbtn(userId, userName, userUrl, roomname) {
    $('#vcalluserId').val(userId);
    $('#vcallroomname').val(roomname);
    openuserchatbox(userId, userName, userUrl, roomname);


  }

  function cutvideocall() {
    $('.chat-btns').hide();
    $('.vdocall-msg').hide();
    $('.vdo-icon').removeClass('active');
  }

  function Declinecall() {
    $('.chat-btns').hide();
    $('.vdocall-msg').hide();
    $('.vdo-icon').removeClass('active');
    $('#getnotifications').load('common_action.php?videocallcut=1');
  }


  function hideerrordiv(elemId) {
    $('#' + elemId).removeClass('redborderfield');
  }
  //	$("input").attr('autocomplete','off');
</script>


<input type="hidden" id="tokenId" name="tokenId" value="<?php echo $TokenRequest; ?>" />
<input type="hidden" id="sessionId" name="sessionId" value="<?php echo $sessionId; ?>" />



<script>
  function playring() {
    document.getElementById('player').play();
  }

  function stopring() {
    document.getElementById('player').pause();
  }

  function playring2() {
    document.getElementById('player2').play();
  }

  function stopring2() {
    document.getElementById('player2').pause();
  }


  function endvideocall() {
    Declinecall();
    $('.chat-btns').hide();
    $('.chat-btns').hide();
    $('.vdocall-msg').hide();
    $('.vdo-icon').removeClass('active');
  }










  var runningtitle = 1;
  var runtitle = setInterval(function () {
    var msgnotificationnumber = Number($('#msgnotificationnumber').text());


    if (msgnotificationnumber > 0) {
      if (runningtitle == 1) {
        if (msgnotificationnumber == 1) {
          $('title').text('(' + msgnotificationnumber + ') New Message');
        }

        if (msgnotificationnumber > 1) {
          $('title').text('(' + msgnotificationnumber + ') New Messages');
        }
        runningtitle = 0;
      }
      else {
        $('title').text('Konectt');
        runningtitle = 1;
      }


    }
    //$('#keywordsearch').val(msgnotificationnumber);
  }, 2000);




</script>
<div style="display:none;">
  <audio id="player" loop="loop" src="<?php $fullurl; ?>ring/phone2.mp3"> </audio>
  <audio id="player2" loop="loop" src="<?php $fullurl; ?>ring/calling.mp3"> </audio>
</div>

<div class="promote-fix" style="display:none;" id="createadwindow">
  <style type="text/css">
    #groupformdiv .popup-inner {
      width: 430px !important;
    }
  </style>
</div>

<script>
  function createadwindow(id, status, adId) {
    if (status == 1) {
      $("#createadwindow").show();

      $("#createadwindow").load('<?php echo $fullurl; ?>createadwindow.php?id=' + id + '&postId=' + adId);
    }
    else {
      $("#createadwindow").hide();
    }
  }


</script>

<?php
if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
  $sql_ins = "UPDATE " . _USERS_MASTER_TABLE_ . " SET onlineLastUpdate=" . time() . " WHERE userId=" . $_SESSION["sessUserId"] . "  ";
  mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
}
?>