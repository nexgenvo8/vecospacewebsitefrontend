/*
 * Techcare Image Gallery
 * http://techcareonline.in
 *
 * Copyright (c) 2016 Techcare Online
 *
 * Date: 2016-09-22 10:58:48 +0530 (Thu, 22 Sep 2016)
 */
 
$(document).ready(function(){
$( "body" ).append('<div id="TGgallerybg"></div><div id="TGpopouter"><div id="popbox"><div id="TGclosegallerybutton">X</div><div id="TGnextbtn"></div><div id="TGprevbtn"></div></div></div>');
var clickimgid  = '';
var imgdisplay = '';
$('#TGimageboxouter img').live('click', function() {
$("#TGnextbtn").show();
$("#TGprevbtn").show();
$(".TGimgdisplayclass").remove();
var clickimg = $(this).attr('src');
$("#TGgallerybg").fadeIn();
$("#TGpopouter").fadeIn(400);
var imgno = 1;
$("#TGimageboxouter").find('img').each(function() {  
	if($(this).attr('src')==clickimg){
		imgdisplay = 'style="display:block;"';
	clickimgid = imgno;  
	} else {
		imgdisplay = 'style=""';
	}
$("#popbox").append("<div id='"+imgno+"' class='TGimgdisplayclass' "+imgdisplay+"><div class='imgtitle'>"+$(this).attr('title')+"</div><img src='"+$(this).attr('src')+"'/></div>");
var imgdisplay = '';
imgno++;
});
 
	if(Number(imgno-1) == clickimgid){
		$("#TGnextbtn").hide();
	}
	if(1 == clickimgid){
		$("#TGprevbtn").hide();
	}
});

$('#TGclosegallerybutton').live('click', function() {
$("#TGgallerybg").fadeOut();
$("#TGpopouter").fadeOut(400);
});

$('#TGnextbtn').live('click', function() { 
var totalimg = 1;
var selectedimg = '';
var newselectedimg = '';
$(".TGimgdisplayclass").each(function(){
    
	if($(this).css("display")=="block"){
		selectedimg = $(this).attr('id');
	}
totalimg++;
}); 
totalimg = totalimg-1;
newselectedimg = Number(selectedimg)+1;   
$("#"+selectedimg).fadeOut(300);
$("#"+newselectedimg).fadeIn(300); 

showhideleftandprevbtn(totalimg,newselectedimg,'next') 

});

$('#TGprevbtn').live('click', function() { 
var totalimg = 1;
var selectedimg = '';
var newselectedimg = '';
$(".TGimgdisplayclass").each(function(){
    
if($(this).css("display")=="block"){
	selectedimg = $(this).attr('id');
}
totalimg++;
}); 
totalimg = totalimg-1;
newselectedimg = Number(selectedimg)-1;   
$("#"+selectedimg).fadeOut(300);
$("#"+newselectedimg).fadeIn(300);

newselectedimg = newselectedimg-1;
showhideleftandprevbtn('0',newselectedimg,'prev');

});

function showhideleftandprevbtn(totalimg,currimg,actions){
	$("#TGnextbtn").show();
	$("#TGprevbtn").show();
	
	if(actions=='next'){
		if(totalimg==currimg){
			$("#TGnextbtn").hide();
		}
	}

	if(actions=='prev'){
		if(Number(currimg)==0){
			$("#TGprevbtn").hide();
		}
	}
}
});