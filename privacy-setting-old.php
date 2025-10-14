<?php
include_once('inc.php'); 
?>
<!DOCTYPE html>
<html>
<head>
	<title>About - Konectt</title>
	<link rel="stylesheet" type="text/css" href="css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
<link rel="icon" href="favicon.ico" type="image/x-icon">
 <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
 <script src="js/jquery.min.js"></script>

</head>
<body style="background-color: #fff;background-image: inherit;">
<div id="wrapper">
<header id="header">
  <div class="hdr_cont container">
    <div class="logo">
    <a href="http://scgindia.in/konectt/php/timeline.html" class="hiden-xs"><img src="http://scgindia.in/konectt/php/images/logo.jpg"></a>
    <div class="nav-btn"><i class="fa fa-bars" aria-hidden="true"></i></div>
<a href="http://scgindia.in/konectt/php/timeline.html" class="hiden-d"><img src="http://scgindia.in/konectt/php/images/k-small.png"></a>
    </div>
  <div class="header_right">
    <div class="hdr_search">
    <form class="mainsearch" method="get" action="http://scgindia.in/konectt/php/search.html">
    <input type="text" name="keywordsearch" id="keywordsearch" value="" maxlength="50" class="text" autocomplete="off" placeholder="What are you looking for?" onkeyup="topsearch();">
    <button type="button" class="search_btn"><i class="fa fa-search" aria-hidden="true"></i></button>
   <div id="showsearchbox"></div> 
  
  </form>
    <div class="find_btn" id="requestandnotiload">
<div class="frnd-request hiden-xs">
    <a class="frndr" href="http://scgindia.in/konectt/php/timeline.html"><i class="fa fa-home" aria-hidden="true"></i>
     <span class="ttl">Home</span></a>
    </div>
<div class="frnd-request hiden-xs">
    <a class="frndr" href="http://scgindia.in/konectt/php/contacts.html"><i class="fa fa-user" aria-hidden="true">
  <span class="frnd-tltp" id="requestnotificationnumber" style="display:none;"></span>
  </i>
     <span class="ttl">Contacts</span></a>
    </div>
<div class="frnd-request">
    <a class="frndr" href="http://scgindia.in/konectt/php/messaging.html"><i class="fa fa-comments" aria-hidden="true">
   <span class="frnd-tltp" id="msgnotificationnumber" style="display:none;"></span>
  </i>
     <span class="ttl hiden-xs">Messages</span></a>
    </div>



    <div class="frnd-request">
    <a class="frndr" href="http://scgindia.in/konectt/php/notifications.html"><i class="fa fa-bell">
  
        <span class="frnd-tltp" id="notificationnumber" style="display:none;"></span>
    
    </i>
    <span class="ttl hiden-xs">Notifications</span></a>
    
    <ul class="requst-list">

    </ul>
    </div>





<script>
////////India toogle start ///////////

$('.toggle').click(function(event){
    event.stopPropagation();
});

$('html').click(function() {
  $('.setting_menu').hide(); 
 
});

 
// script for notification
$('#frnd-toggle').click(function(event){
    event.stopPropagation();
});

$('html').click(function() {
  $('#frnd-list').hide(); 
});
$('#frnd-toggle').click(function(event){
  $('#notice-list').hide();  
    $('#frnd-list').show();
});


// script for notification
$('#notice-toggle').click(function(event){
    event.stopPropagation();
});

$('html').click(function() {
  //$('#notice-list').hide();   
    //$('#frnd-list').hide();
 
});

$('#notice-toggle').click(function(event){
$('#notice-list').load('http://scgindia.in/konectt/php/notification.php');
    $('#notice-list').show();
    $('#frnd-list').hide();
    
});


</script></div>
<style>
.topsearchlist{background-color:#fff; border-bottom:1px solid #f3f3f3; cursor:pointer; padding:6px; }
.topsearchlist:hover{background-color:#F7F7F7;}
#showsearchbox{width: 100%;
    max-height: 350px;
    overflow: auto;
    position: absolute;
    left: 0px;
    top: 33px;
    border: 1px solid #f3f3f3;
    border-radius: 2px;    box-shadow: 0px 4px 4px #b7b5b5; display:none; background-color:#fff;}
.topsearchheader{ border-bottom: 1px solid #f3f3f3; padding:6px; font-weight:bold; color:#1a94c3;}
</style>
  <script>
  function topsearch()
  {
    var keywordsearch = $("#keywordsearch").val();
    keywordsearch = encodeURIComponent($.trim(keywordsearch));
    
    $('#showsearchbox').load('http://scgindia.in/konectt/php/showsearchbox.php?keywordsearch='+keywordsearch);
  
  }
  
  $('#requestandnotiload').load('http://scgindia.in/konectt/php/request_and_notification.php');
  </script>


<script type="text/javascript">
  $(".nav-btn").click(function(){
    $(".left_menu_sec").toggleClass("open");
  });
  $(".nav-btn").click(function(){
    $(".nav-btn").toggleClass("open");
  });
</script>


<script type="text/javascript">//<![CDATA[
$(function(){
// Hide Header on on scroll down
var didScroll;
var lastScrollTop = 0;
var delta = 5;
var navbarHeight = $('#header').outerHeight();

$(window).scroll(function(event){
    didScroll = true;
});

setInterval(function() {
    if (didScroll) {
        hasScrolled();
        didScroll = false;
    }
}, 250);

function hasScrolled() {
    var st = $(this).scrollTop();
    
    // Make sure they scroll more than delta
    if(Math.abs(lastScrollTop - st) <= delta)
        return;
    
    // If they scrolled down and are past the navbar, add class .nav-up.
    // This is necessary so you never see what is "behind" the navbar.
    if (st > lastScrollTop && st > navbarHeight){
        // Scroll Down
        $('#header').removeClass('nav-down').addClass('nav-up');
    } else {
        // Scroll Up
        if(st + $(window).height() < $(document).height()) {
            $('#header').removeClass('nav-up').addClass('nav-down');
        }
    }
    
    lastScrollTop = st;
}
});//]]> 

</script>



  <div class="toggle hiden-xs" onclick="$('.setting_menu').show();">
   <a href="javascript:void(0);">
   <span class="usr_img"><img src="http://scgindia.in/konectt/php/uploads/14979557001.jpg"></span>
   <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
   <ul class="setting_menu">
     <li><a href="http://scgindia.in/konectt/php/myprofile/202565519/shahrukh-khan.html">My profile</a></li>
     <li><a href="#3">Settings</a></li>
     <li><a href="#1">Premium membership</a></li>
     <li><a href="http://scgindia.in/konectt/php/logout.html">Logout</a></li>
   </ul>
   </div>
    </div>
  


    </div>
    </div>
  </header>

<div class="container main">
<div class="setting">
<div class="sttng-wraper">
<div class="inyour-hand">
<h2>Your privacy is in your hands!</h2>
  <i class="fa fa-user-secret" aria-hidden="true"></i>
<span>Konectt gives you complete control over your personal data. You decide what information you would like to show to other people and can edit your privacy settings whenever you want.</span>
</div>
  <h2 class="headline">Setting</h2>
  <ul class="sttng_tab">
    <li><a href="">Login data</a></li>
    <li><a href="">Personal data</a></li>
    <li><a href="" class="active">Privacy</a></li>
    <li><a href="">Notifications</a></li>
  </ul>
  <ul class="setting_area_list">
    <li>
      <span class="subtitle">Profile settings<a href="" class="edit_btn">Edit</a></span>
      <ul class="privacy-setting-list">
        <li><i class="fa fa-check" aria-hidden="true"></i>
          First section to be shown to profile visitors:
          <strong> Profile details</strong>
        </li>
        <li><i class="fa fa-times" aria-hidden="true"></i>
         The Portfolio tab in my profile is visible to:
          <strong>All members</strong>
        </li>
        <li><i class="fa fa-check" aria-hidden="true"></i>
          The "Contacts" tab in my profile is visible to:
          <strong>All members</strong>
        </li>
        <li><i class="fa fa-times" aria-hidden="true"></i>
          The "Activity" tab in my profile is visible to: 
          <strong>My direct contacts only</strong>
        </li>
        <li><i class="fa fa-times" aria-hidden="true"></i>
          First section to be shown to profile visitors:
          <strong> Profile details</strong>
        </li>
        <li><i class="fa fa-check" aria-hidden="true"></i>
          First section to be shown to profile visitors:
          <strong> Profile details</strong>
        </li>
        <span class="subtitle">General settings<a href="" class="edit_btn">Edit</a></span>
        <li><i class="fa fa-times" aria-hidden="true"></i>
          The "Activity" tab in my profile is visible to: 
          <strong>My direct contacts only</strong>
        </li>
        <li><i class="fa fa-times" aria-hidden="true"></i>
          First section to be shown to profile visitors:
          <strong> Profile details</strong>
        </li>
        <li><i class="fa fa-check" aria-hidden="true"></i>
          First section to be shown to profile visitors:
          <strong> Profile details</strong>
        </li>
      </ul>
    </li>
  </ul>
</div>
</div>
</div>










<footer>
  <div class="container">
  <div class="footer-menu">
    <ul class="foooter-list">
      <li><a href="">About</a></li>
      <li><a href="">Team</a></li>
      <li><a href="">Career</a></li>
      <li><a href="">Blog</a></li>
      <li><a href="">Affiliates</a></li>
    </ul>
    <ul class="foooter-list">
      <li><a href="">About</a></li>
      <li><a href="">Team</a></li>
      <li><a href="">Career</a></li>
      <li><a href="">Blog</a></li>
      <li><a href="">Affiliates</a></li>
    </ul>
    <ul class="foooter-list">
      <li><a href="">About</a></li>
      <li><a href="">Team</a></li>
      <li><a href="">Career</a></li>
      <li><a href="">Blog</a></li>
      <li><a href="">Affiliates</a></li>
    </ul>
<div class="logo"><a href="index.html"><img src="images/logo.png"></a></div>
  </div>
  </div>
</footer>
</div>

<div class="copyright">© The copyright is OMSR Media Pvt. Ltd | All rights reserved</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
	$("#login").hide();
	$("a.login-button").click(function(){
		$("#login").show();
		$("#signup").hide();
	})
	$("a.sign_up_btn").click(function(){
		$("#login").hide();
		$("#signup").show();
	})
</script>
</body>
</html>