<div class="copyright_cont home">
  <div class="ftr_container">
    <dl class="dl_list">

      <dd>
        <a href="#">
          About this site
        </a>
      </dd>
      <dd>
        <a href="#">
          Terms & Conditions
        </a>
      </dd>
      <dd>
        <a href="<?php echo $fullurl; ?>faq.html">
          Faq
        </a>
      </dd>
      <dd>
        <a href="#">
          Privacy Policy
        </a>
      </dd>
      <dd>
        <a href="#">
          Security
        </a>
      </dd>
      <dd>
        <a href="#">
          Language: English
        </a>
      </dd>

    </dl>
    <p class="all_right">&copy; Konectt | All rights reserved</p>
  </div>
</div>
<div class="foottr">
  <ul>
    <li><a class="active" href="#"><i class="fa fa-home" aria-hidden="true"></i></a></li>
    <li><a href="#"><i class="fa fa-user" aria-hidden="true"></i></a></li>
    <li><a href="#"><i class="fa fa-users" aria-hidden="true"></i></a></li>
    <li><a href="#"><img src="images/user-placeholder.jpg"></a></li>
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

</script>

<div id="commonaction" style="direction:none;"></div>
<iframe name="actionfrm" id="actionfrm" style="display:none;"></iframe>




<?php
if ($pageIndex != 3) {
  $sql_contact = "SELECT * from " . _CONTACT_MASTER_TABLE_ . " WHERE userId= " . $_SESSION["sessUserId"] . " AND status=1";
  $res_contact = mysqli_query($conn, $sql_contact) or die(mysqli_error($conn));
  $contactrequests = mysqli_num_rows($res_contact);
  ?>
  <div class="chat-cont" <?php if ($contactrequests < 1) { ?>style="display:none;" <?php } ?>>
    <div class="chat-cont-header" id="mainfriedboxlist">Messaging <span class="minimiz"> <a href="#" class="bulkmsg"
          onclick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=sendbulkemails','New message');"><i
            class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
        <i class="fa fa-plus" aria-hidden="true" id="plusicon"
          onclick="$('#chatcontactload').toggle();$('#minusicon').show();$('#plusicon').hide();"></i>
        <i style="display:none;" class="fa fa-minus" aria-hidden="true" id="minusicon"
          onclick="$('#chatcontactload').toggle();$('#minusicon').hide();$('#plusicon').show();"></i>
      </span></div>
    <div id="chatcontactload" style="display:none; height:308px;"> </div>
    <script>
      $('#chatcontactload').load('<?php echo $fullurl; ?>load_chat_online_contacts.php');
    </script>
  </div>
  <div
    style="width:336px; display:none; position:fixed; right:380px; bottom:0px; z-index:999; background-color:#FFFFFF; box-shadow: 0px 0px 5px #a0a0a0;"
    id="usermainboxchat">
    <div class="chat-cont-header" onclick="$('#loaduserchatbox').toggle();"
      style="background-color:#1a94c3; color:#FFFFFF; position:relative;">
      <span id="userchatname"></span>
      <span class="minimiz"><i class="fa fa-minus" aria-hidden="true"></i></span>
      <span class="close-cht" style="position:absolute;font-size:inherit; right:14px; top:8px;"
        onclick="$('#usermainboxchat').hide();clearint();"><i class="fa fa-times" aria-hidden="true"></i></span>
    </div>
    <div id="loaduserchatbox">
      <div style="height:223px; overflow:auto;" id="loadchatusermsg"></div>
      <div style="border-top:2px #1a94c3 solid;">
        <div><textarea name="chatfieldfooter" id="chatfieldfooter" type="text"
            style="border:0px; max-width:100%;width: 100%;max-height: 100px; padding:10px; border:0px;"
            placeholder="Write a message here..." /></textarea>


          <ul class="emozi">
            <li><a id="sendphoto"><i class="fa fa-paperclip" aria-hidden="true"></i></a></li>
            <li><a onclick="posrturl();showloading('sharepopinner');"></a></li>
            <li class="send-sec">Press Enter to Send <button class="send">Send</button>
              <div class="click-btn"><a href="#" id="sendclick"><i class="fa fa-ellipsis-h" aria-hidden="true"
                    onclick="$('#selectbuttons').show();"></i></a>
                <ul class="send-list" id="selectbuttons" style="display:none;">
                  <li><label><input type="radio" name="Enter" value="">
                      <div class="presenter">Press Enter to Send</div>
                    </label></li>
                  <li><label><input type="radio" name="Enter" checked="checked">
                      <div class="presenter">Click Send</div>
                    </label></li>
                </ul>
              </div>
            </li>
          </ul>






        </div>
        <div id="textchatactiondiv" style="display:none;"></div>

      </div>
    </div>
  </div>
  <input type="hidden" name="chatuserid" id="chatuserid" />

  <script>
    function openuserchatbox(id, name) {
      $('#chatuserid').val(id);
      $('#usermainboxchat').show();
      $('#loaduserchatbox').show();
      $('#userchatname').text(name);
      $('#loadchatusermsg').html('');
      $('#loadchatusermsg').load('<?php echo $fullurl; ?>load_chat_user_msg.php?userId=' + id);
      $("#loadchatusermsg").scrollTop($("#loadchatusermsg")[0].scrollHeight);
      $("#chatfieldfooter").focus();
    }

    function typeandsendchat(id) {
      var chatfieldfooter = $('#chatfieldfooter').val();
      chatfieldfooter = encodeURIComponent($.trim(chatfieldfooter));

      if (chatfieldfooter != '' && id != '') {
        $('#textchatactiondiv').load('<?php echo $fullurl; ?>common_action.php?action=chat&contactId=' + id + '&text=' + chatfieldfooter);

      }
      $("#chatfieldfooter").val('');

    }

    $("#chatfieldfooter").keypress(function (e) {
      if (e.which == 13) {
        var id = $('#chatuserid').val();
        typeandsendchat(id);
      }
    });


    clearInterval(handle);

    var handle = setInterval(function () {
      var id = $('#chatuserid').val();
      $('#textchatactiondiv').load('<?php echo $fullurl; ?>common_action.php?action=getchat&contactId=' + id);
      $('#chatcontactload').load('<?php echo $fullurl; ?>load_chat_online_contacts.php');
    }, 3000);

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

      <div class="popup-fttr"> <a onclick="$('.share-popup').hide();">Cancel</a>
        <button type="submit" class="btn">Post</button>
      </div>
    </form>
  </div>
</div>
<div class="crt-grp-popup" style="display: none;" id="groupformdiv">
  <div class="popup-inner">

    <a class="grp-close" onClick="$('.crt-grp-popup').hide();"><i class="fa fa-times" aria-hidden="true"></i></a>
    <form enctype="multipart/form-data" name="creategroup" id="creategroup" method="post" target="actionfrm"
      action="<?php echo $fullurl; ?>common_action.php" />
    <div class="nw-grup">
      <h3>Enter a name for your group</h3>
      <label>Group type</label>
      <div class="grouptype" style="margin-bottom:20px;">
        <select name="groupType" id="groupType" onchange="changegrouptype();"
          style="border:1px #e7e7e7 solid; padding:8px;">
          <option value="0">Public</option>
          <option value="1">Private</option>
        </select>
      </div>

      <label>Group name</label>
      <input type="text" name="groupName" id="groupName" placeholder="e.g. 'Marketing specialists Warsaw'">
      <div id="textareadiv">
        <label>Short group description</label>
        <textarea name="groupDetails" id="groupDetails" rows="4" placeholder="Describe your group "></textarea>
      </div>

    </div>
    <div class="popup-fttr"> <a
        onClick="$('.crt-grp-popup').hide();$('#groupName').val('');$('#groupDetails').val('');">Cancel</a>
      <button type="submit">Create new group</button>
    </div>
    </form>


  </div>
</div>




<div class="crt-grp-popup" id="inviteemail">
  <div class="popup-inner">
    <div class="invit">
      <a class="grp-close" onclick="$('#inviteemail').hide();"><i class="fa fa-times" aria-hidden="true"></i></a>
      <div id="showinvitediv">
        <form enctype="multipart/form-data" name="inviteemailaddress" id="inviteemailaddress" method="post"
          target="actionfrm" action="<?php echo $fullurl; ?>common_action.php" />
        <div class="nw-grup">
          <h3>Invite by email</h3>
          <label>Email address </label>
          <input type="text" name="txtuseremail" id="txtuseremail"
            placeholder="Enter email address with comma separated">

          <input type="hidden" name="action" id="action" value="sendtouserinvitation">
          <input type="hidden" name="groupinvitationid" id="groupinvitationid"
            value="<?php echo encodeStr($_REQUEST['groupId']); ?>">
          <input type="hidden" name="invitegroupname" id="invitegroupname"
            value="<?php echo stripslashes(trim($rowGroup["groupName"])); ?>">
        </div>
        <div class="popup-fttr"> <a
            onclick="$('#inviteemail').hide();$('#txtuseremail').val('');$('#sentmsgtextdiv').hide();">Cancel</a>
          <button type="submit">Send invitation</button>
        </div>
        </form>
      </div>

      <div id="hideinvitediv" style="display:none;">
        <div class="suces"><i class="fa-suc"><img src="images/suc.png"> </i>
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





<div class="loader" id="commonloader"><span><img src="images/loader.gif">
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
      <a class="grp-close" onClick="$('#commonpopupwinouter').hide();"><i class="fa fa-times"
          aria-hidden="true"></i></a>


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

  var handle = setInterval(function () {
    $('#getnotifications').load('<?php echo $fullurl; ?>getallnotifications.php');
  }, 3000);

</script>