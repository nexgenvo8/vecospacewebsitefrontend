var fullurl = 'http://localhost/ndimvecospace/vecospacewebsitefrontend/';

function loadpages(id, page) {
    $('#' + id).load(page);
}

function savestepone() {
    var employmentId = $('#employmentId').val();
    var membershipId = $('#membershipId').val();

    if (employmentId != 0 && membershipId != 0) {
        $('#stape1').removeClass('active');
        $('#stape2').addClass('active');
        $('#stepbox').load('stepbox.php?step=2&employmentId=' + employmentId + '&membershipId=' + membershipId);
    }
}



function savesteptwo() {
    var jobTitle = $('#jobTitle').val();
    var companyName = $('#companyName').val();
    var industry = $('#industry').val();

    jobTitle = encodeURIComponent(jobTitle);
    companyName = encodeURIComponent(companyName);
    industry = encodeURIComponent(industry);



    if (jobTitle != '' && companyName != '') {
        $('#stape2').removeClass('active');
        $('#stape3').addClass('active');
        $('#stepbox').load('stepbox.php?step=3&jobTitle=' + jobTitle + '&companyName=' + companyName + '&industry=' + industry);
    }
}



function showindustry() {
    var companyName = $('#companyName').val();

    if (companyName != '') {
        $('#industrybox').show();
    } else {
        $('#industrybox').hide();
    }
}

function taglinefun() {
    var taglineText = $('#taglineText').val();

    if (taglineText != '') {
        $('#taglinediv').show();
    } else {
        $('#taglinediv').hide();
    }
}



function savetagline() {
    var taglineText = $('#taglineText').val();
    taglineText = encodeURIComponent(taglineText);
    $('#commonaction').load(fullurl + 'common_action.php?taglineText=' + taglineText + '&action=tagline');
    $('#taglinediv').hide();
}



function loadskills() {
    $('#loadskillpage').load(fullurl + 'loadskillpage.php');
}




function loadexploring() {
    $('#loadexploringpage').load(fullurl + 'loadexploringpage.php');
}



function loadprofessionalexp() {
    $('#loadprofessionalexppage').load(fullurl + 'loadprofessionalexppage.php');
}



function loadlanguages() {
    $('#loadlanguagespage').load(fullurl + 'loadlanguagespage.php');
}


function loadinterest() {
    $('#loadinterestspage').load(fullurl + 'loadeinterestspage.php');
}

/*function loadpostarticle()
{
 $('#loadpostarticlepagesssssssss').load(fullurl+'loadpostarticle.php');	
}*/

function loadtimeline(pageid, startpage, endpage) {
    if (!pageid) {
        console.error("Missing pageid for loadtimeline");
        return;
    }

    const url = fullurl + 'loadtimeline.php' +
        '?startpage=' + encodeURIComponent(startpage || 0) +
        '&endpage=' + encodeURIComponent(endpage || 0) +
        '&pageid=' + encodeURIComponent(pageid);

    console.log("Loading timeline URL:", url);

    $('#loadtimeline' + pageid).load(url, function(response, status, xhr) {
        if (status === "error") {
            console.error("Error loading timeline:", xhr.status, xhr.statusText);
            $('#loadtimeline' + pageid).html('<div class="error">Error loading timeline. Please try again.</div>');
        } else {
            console.log("Timeline loaded successfully");
        }
    });
}







function loadtimelinesinglepost(pageid, startpage, endpage, postId, postType) {
    //alert(pageid+'=rr='+startpage+'=ttttt='+endpage+'=yyyyyy='+postId+'=uuuu='+postType);
    $('#loadtimeline' + pageid).load(fullurl + 'loadtimeline.php?startpage=' + startpage + '&endpage=' + endpage + '&pageid=' + pageid + '&postId=' + postId + '&postType=' + postType);
}

function loadtimelinesinglepost2(pageid, startpage, endpage, postId, postType) {
    //alert(pageid+'=rr='+startpage+'=ttttt='+endpage+'=yyyyyy='+postId+'=uuuu='+postType);
    $('#loadtimeline' + pageid).load(fullurl + 'loadtimeline.php?siglepost=1&startpage=' + startpage + '&endpage=' + endpage + '&pageid=' + pageid + '&postId=' + postId + '&postType=' + postType);
}

function loadtimelineActivitfun(pageid, startpage, endpage, activitPostType) {
    $('#loadtimeline' + pageid).load(fullurl + 'loadtimeline.php?startpage=' + startpage + '&endpage=' + endpage + '&pageid=' + pageid + '&activitPostType=' + activitPostType);
}

function loadtimelineactivity(pageid, startpage, endpage, view) {
    $('#loadtimeline' + pageid).load(fullurl + 'loadtimelineactivity.php?startpage=' + startpage + '&endpage=' + endpage + '&pageid=' + pageid + '&view=' + view);
}

function loadgrouptimeline(pageid, startpage, endpage, groupId) {
    $('#loadtimeline' + pageid).load(fullurl + 'loadgrouptimeline.php?siglepost=1&startpage=' + startpage + '&endpage=' + endpage + '&pageid=' + pageid + '&groupId=' + groupId);
}


function topsharetabs(id) {

    $('#toptabsshare1').removeClass('active');
    $('#toptabsshare2').removeClass('active');
    $('#toptabsshare3').removeClass('active');
    $('#postType').val(id);
    $('#uploadboximage').hide();

    $('#toptabsshare' + id).addClass('active');
    $('#sharetab' + id).show();
    if (id == 2) {
        $('#uploadboximage').show();
    }
}


function removepost(id) {
    $('#loadtimeline1').load(fullurl + 'loadtimeline.php?startpage=0&endpage=20&pageid=1&dltid=' + id);

}


function postlike(postId, postType, like) {
    $('#actionpostdivs').load(fullurl + 'common_action.php?action=postlike&postId=' + postId + '&postType=' + postType + '&like=' + like);
}



function alertpopupmain(id, type) {
    $('#alertpopup').show();
    $('#alertpopup').load(fullurl + 'alertpopup.php?postId=' + id + '&postType=' + type);
}



function imagepopupmain(id) {
    $('#imagepopup').html('<div class="postimageloading">Loading</div>');
    $('#imagepopup').show();
    var id = encodeURI(id);
    $('#imagepopup').load(fullurl + 'imagepopup.php?imgId=' + id);
}

function imgpopupprofiles(id, status) {
    $('#imagepopup').html('<div class="postimageloading">Loading</div>');
    $('#imagepopup').show();
    var id = encodeURI(id);
    $('#imagepopup').load(fullurl + 'imagepopupprofiles.php?imgId=' + id + '&status=' + status);
}

function funcommonpopupwin(width, height, file, title) {
    $('#commonpopupwin').css('width', width);
    $('#commonpopupwin').css('max-width', width);
    $('#commonpopupwin').css('height', height);
    $('#commonpopupwin #commonpopupwinfile').load(file);
    $('#commonpopupwin #popuptitle').html(title);
    $('#commonpopupwinouter').show();
    $('body').css('overflow', 'hidden');

}


function closefuncommonpopupwin() {
    $('#commonpopupwinouter').hide();
    $('body').css('overflow', 'auto');
}

function sharefuncommonpopupwin(width, height, file, title, id) {
    $('#commonpopupwin').css('width', width);
    $('#commonpopupwin').css('max-width', width);
    $('#commonpopupwin').css('height', height);
    $('#commonpopupwin #commonpopupwinfile').load(file);
    $('#commonpopupwin #popuptitle').html(title);

    $('#commonpopupwinouter').show();
    $('body').css('overflow', 'hidden');

}

function showsusmsg(title, dec, img) {
    $('#commonpopupwinouter').hide();
    $('#susmsgblk').show();
    $('#successmessage-outer').show();
    $('#successmessage-outer .successmsg-heading').text(title);
    $('#successmessage-outer .mtxt').html(dec);
}

function showerrormsg(title, dec, img) {
    $('#commonpopupwinouter').hide();
    $('#susmsgblk').show();
    $('.warningmessage').show();
    $('#successmessage-outer .successmsg-heading').text(title);
    $('#successmessage-outer .mtxt').text(dec);
}

function closeshowsusmsg() {
    $('#susmsgblk').hide();
    $('#commonpopupwinouter').hide();
    $('#successmessage-outer').hide();
}

function closeserrormsg() {
    $('#susmsgblk').hide();
    $('#commonpopupwinouter').hide();
    $('.warningmessage').hide();
}

function searchabledropdowns(id, height) {
    var fldoption = $('#' + id).html();

    $('#' + id).before('<div class="udropdown" id="unew' + id + '"><div class="divunewmain" id="' + id + 'divunewmain">' + fldoption + '</div></div>');
    $('#' + id + 'divunewmain').css('height', '' + height + '');
}

/*function updateUserSession(){
 FB.api('/me', { locale: 'en_US', fields: 'name, email' },
function(response) { 
var facebookEmail=response.email;
var facebookName=response.name;

if (typeof facebookEmail === "undefined")
{
alert("Your are not login in facebook. Please login in facebook first.");
}


window.location=""+fullurl+"fblogin.html?email="+facebookEmail+'&name='+facebookName; 
}
);
 
}*/

function submitform(fname, keyword) {
    if ($('#' + keyword + '').val() != '') {
        $('#' + fname + '').submit();
    }
    $("input").keypress(function(event) {

        if (event.which == 13) {
            event.preventDefault();

            if ($('#' + keyword + '').val() != '') {
                $('#' + fname + '').submit();
            }
        }
    });

}


function accordion(sld1) {

    var ckeckid = $('#' + sld1).attr('id');

    //$('.erow-list').hide();

    /*var $when = $("#"+sld1);
    $when.slideToggle();
    $("#"+sld1).not($when).slideUp(); */
    if (ckeckid == sld1) {
        var $when = $("#" + sld1);
        $when.slideToggle();

        $("#" + sld1).not($when).slideUp();
    } else {
        $('.erow-list').hide();
    }


}