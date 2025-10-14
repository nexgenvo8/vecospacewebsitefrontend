<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); 
$url=$_REQUEST['url'];
$title=$_REQUEST['title'];
?>

<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $url; ?>" target="_blank" class="fb"><i class="fa fa-facebook" aria-hidden="true"></i><span>Facebook</span></a></li>
                    <li><a href="https://twitter.com/intent/tweet?text=<?php echo $title; ?> via%20@Konestt&url=<?php echo $url; ?>" class="tw"><i class="fa fa-twitter" aria-hidden="true"></i><span>Twitter</span></a></li>
                    <li><a href="https://www.linkedin.com/sharing/share-offsite?mini=true&url=<?php echo $url; ?>" class="ln"><i class="fa fa-linkedin" aria-hidden="true"></i><span>Linkedin</span></a></li>
                    <li><a href="#" class="kn" onclick="$('.konect-share-pop').show();"><i class="fa"><img src="images/k-logo.png"></i><span><?php echo $companNameTitle;?></span></a>
                    <div class="konect-share-pop">
                    <a class="grp-close" onclick="$('.konect-share-pop').hide();"><i class="fa fa-times" aria-hidden="true"></i></a>
                      <div class="konect-share-pop-inner">
                       <div class="share-tab-cont">

  <ul class="tabss">
    <li class="tab-link current" data-tab="tab-1">Share with Konecttions</li>
    <li class="tab-link" data-tab="tab-2">Share by email</li>
  </ul>

  <div id="tab-1" class="tab-content current">
   <input type="text" name="" class="share-inpt" placeholder="Type here your friends name">
  </div>
  <div id="tab-2" class="tab-content">
      <input type="text" name="" class="share-inpt" placeholder="Type here email">
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
  
  $('ul.tabss li').click(function(){
    var tab_id = $(this).attr('data-tab');

    $('ul.tabss li').removeClass('current');
    $('.tab-content').removeClass('current');

    $(this).addClass('current');
    $("#"+tab_id).addClass('current');
  })

})
</script>
                      </div>
                    </div>
                    </li>