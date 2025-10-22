<?php
include_once('inc.php');


if ($_REQUEST['postType'] == 'deletearticlepost') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this article?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?dltid=<?php echo $_REQUEST['postId']; ?>&action=dltarticle&removearticle=1"
        target="actionfrm" class="yes"><button type="button">Yes</button></a>
    </div>
  </div>
<?php }
if ($_REQUEST['postType'] == 'deletearticle') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this article?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?dltid=<?php echo $_REQUEST['postId']; ?>&action=dltarticle&removearticle=2"
        target="actionfrm" class="yes"><button type="button">Yes</button></a>
    </div>
  </div>
  <?php
}

if ($_REQUEST['postType'] == 'deleteprofexp') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this professional experience?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?id=<?php echo $_REQUEST['postId']; ?>&action=dltproexp"
        target="actionfrm" class="yes"><button type="button">Yes</button></a>
    </div>
  </div>
<?php } ?>

<?php
if ($_REQUEST['postType'] == 'deleducational') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this educational background?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?id=<?php echo $_REQUEST['postId']; ?>&action=dlteducational"
        target="actionfrm" class="yes"><button type="button">Yes</button></a>
    </div>
  </div>
<?php } ?>

<?php
if ($_REQUEST['postType'] == 'delrec') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this recommendation?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?id=<?php echo $_REQUEST['postId']; ?>&action=delrec"
        target="actionfrm" class="yes"><button type="button">Yes</button></a>
    </div>
  </div>
<?php } ?>

<?php
if ($_REQUEST['postType'] == 'delgrp') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this group?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a
        onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=delgrp&id=<?php echo $_REQUEST['postId']; ?>','Delete this group');$('.popup-alert-cont').hide();"><button
          type="button">Yes</button></a>
    </div>
  </div>
<?php } ?>

<?php
if ($_REQUEST['postType'] == 'delproject') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this project?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?id=<?php echo $_REQUEST['postId']; ?>&action=delproject"
        target="actionfrm" class="yes"><button type="button">Yes</button></a>
    </div>
  </div>
<?php } ?>

<?php
if ($_REQUEST['postType'] == 'delcmpupdate') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this update?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?id=<?php echo $_REQUEST['postId']; ?>&action=delcmpupdate"
        target="actionfrm" class="yes"><button type="button">Yes</button></a>
    </div>
  </div>
<?php } ?>

<?php
if ($_REQUEST['postType'] == 'delcmp') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this company profile?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a
        onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=delcmp&id=<?php echo $_REQUEST['postId']; ?>','Delete this Company profile');$('.popup-alert-cont').hide();"><button
          type="button">Yes</button></a>
    </div>
  </div>
  <?php
}

if (isset($_REQUEST['postType']) && $_REQUEST['postType'] == 'delevnt') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this event?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?evntid=<?php echo $_REQUEST['postId']; ?>&action=delevnt"
        target="actionfrm" class="yes"><button type="button">Yes</button></a>
    </div>
  </div>
<?php }

if ($_REQUEST['postType'] == 'delsmbp') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this SMB page?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a
        onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=delsmbp&id=<?php echo $_REQUEST['postId']; ?>','Delete this SMB page');$('.popup-alert-cont').hide();"><button
          type="button">Yes</button></a>
    </div>
  </div>
  <?php
}

if ($_REQUEST['postType'] == 'deltalentp') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a
        onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=deltalentp&id=<?php echo $_REQUEST['postId']; ?>','Delete this');$('.popup-alert-cont').hide();"><button
          type="button">Yes</button></a>
    </div>
  </div>
  <?php
}

if ($_REQUEST['postType'] == 'dltpost') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this update?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?dltid=<?php echo $_REQUEST['postId']; ?>&action=dlt"
        target="actionfrm" onclick="$('.popup-alert-cont').hide();"><button type="button">Yes</button></a>
    </div>
  </div>
  <?php
}

if ($_REQUEST['postType'] == 'dltcmnt') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this comment?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?cmntid=<?php echo $_REQUEST['postId']; ?>&action=dltcmnt"
        target="actionfrm" onclick="$('.popup-alert-cont').hide();"><button type="button">Yes</button></a>
    </div>
  </div>
  <?php
}

if ($_REQUEST['postType'] == 'dltreply') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this comment?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?cmntrplid=<?php echo $_REQUEST['postId']; ?>&action=dltreply"
        target="actionfrm" onclick="$('.popup-alert-cont').hide();"><button type="button">Yes</button></a>
    </div>
  </div>
  <?php
}

if ($_REQUEST['postType'] == 'removepostimg') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this image?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?postId=<?php echo $_REQUEST['postId']; ?>&action=removepostimg"
        target="actionfrm" onclick="$('.popup-alert-cont').hide();"><button type="button">Yes</button></a>
    </div>
  </div>
  <?php
}



if ($_REQUEST['postType'] == 'deltalentvideo') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this video?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?talentVideopostId=<?php echo $_REQUEST['postId']; ?>&action=removeTalentVideo"
        target="actionfrm" onclick="$('.popup-alert-cont').hide();"><button type="button">Yes</button></a>
    </div>
  </div>
  <?php
}



if ($_REQUEST['postType'] == 'deltalenttestimonials') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this testimonial?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?talentTestimonialspostId=<?php echo $_REQUEST['postId']; ?>&action=remoTestiposti"
        target="actionfrm" onclick="$('.popup-alert-cont').hide();"><button type="button">Yes</button></a>
    </div>
  </div>
  <?php
}





if ($_REQUEST['postType'] == 'deleteProfilePhoto') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant" id="prodeleteimage">Are you sure you want to delete profile photo?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?profileph=<?php echo $_REQUEST['postId']; ?>&action=removeProfilePhoto"
        target="actionfrm" onclick="$('#prodeleteimage').html('Please wait...');"><button type="button">Yes</button></a>
    </div>
  </div>
  <?php
}

if ($_REQUEST['postType'] == 'deljob') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this job?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a
        onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=deljob&id=<?php echo $_REQUEST['postId']; ?>','Delete this job');$('.popup-alert-cont').hide();"><button
          type="button">Yes</button></a>
    </div>
  </div>
  <?php
}

if ($_REQUEST['postType'] == 'deldocument') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this document?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?documentId=<?php echo $_GET['postId']; ?>&action=deldocument"
        target="actionfrm" class="yes"><button type="button">Yes</button></a>
    </div>
  </div>
<?php }

if ($_REQUEST['postType'] == 'dltgrouppost') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to delete this group post?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?groupdltid=<?php echo $_REQUEST['postId']; ?>&action=dltgrouppost"
        target="actionfrm" onclick="$('.popup-alert-cont').hide();"><button type="button">Yes</button></a>
    </div>
  </div>
  <?php
}

if ($_REQUEST['postType'] == 'hidepost') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to hide this article?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?hiddenpid=<?php echo $_REQUEST['postId']; ?>&action=hidepost"
        target="actionfrm" class="yes"><button type="button">Yes</button></a>
    </div>
  </div>
<?php }

if ($_REQUEST['postType'] == 'hidepost22') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Are you sure you want to hide this post?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?hiddenpid=<?php echo $_REQUEST['postId']; ?>&action=hidepost"
        target="actionfrm" class="yes"><button type="button">Yes</button></a>
    </div>
  </div>
  <?php
}

if ($_REQUEST['postType'] == 'leavepublicgrp') {
  ?>
  <div class="popup-alert">
    <div class="alrt-had">Alert</div>
    <div class="contant">Do you want to leave this group?</div>
    <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a href="<?php echo $fullurl; ?>common_action.php?groupId=<?php echo $_REQUEST['postId']; ?>&action=leavepublicgrp"
        target="actionfrm" class="yes"><button type="button">Yes</button></a>
    </div>
  </div>
  <?php
}
if ($_REQUEST['postType'] == 'closeuseraccount') {
  ?>
  <!--<div class="popup-alert">
  <div class="alrt-had">Alert</div>
  <div class="contant">Are you sure you want to close this Account?</div>
  <div class="popup-fttr">
      <a onclick="$('#alertpopup').hide();">No</a>
      <a onClick="funcommonpopupwin('400px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=closeuseraccount&userId=<?php echo $_REQUEST['postId']; ?>','Deactivate your account');$('.popup-alert-cont').hide();"><button type="button">Yes</button></a>
    </div>
</div>-->
  <?php
}
?>