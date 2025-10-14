  <div class="inyour-hand">
<h2>Your privacy is in your hands!</h2>
  <i class="fa fa-user-secret" aria-hidden="true"></i>
<span><?php echo $companNameTitle;?> gives you complete control over your personal data. You decide what information you would like to show to other people and can edit your privacy settings whenever you want.</span>
</div>
  <h2 class="headline">Settings</h2>
  <ul class="sttng_tab">
    <li><a href="<?php echo $fullurl;?>settings.html" <?php if($ps==1){?> class="active"<?php }?>>My account</a></li>
    <li><a href="<?php echo $fullurl;?>personal-data.html" <?php if($ps==2){?> class="active"<?php }?>>Personal data</a></li>
    <li><a href="<?php echo $fullurl;?>privacy-setting.html" <?php if($ps==3){?> class="active"<?php }?>>Privacy</a></li>
    <li><a href="<?php echo $fullurl;?>notification-setting.html" <?php if($ps==4){?> class="active"<?php }?>>Notifications</a></li>
  </ul>