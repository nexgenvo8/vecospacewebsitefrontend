<?php
include_once('inc.php');
include_once('config/session-check.inc.php');

?>

<div class="frnd-request hiden-xs">
    <a class="frndr active" href="<?php echo $fullurl; ?>timeline.html"><i class="fa fa-home" aria-hidden="true"></i>
        <span class="ttl">Home</span></a>
</div>

<div class="frnd-request">
    <a class="frndr" href="<?php echo $fullurl; ?>messaging.html"><i class="fa fa-comments" aria-hidden="true">
            <span class="frnd-tltp" id="msgnotificationnumber" style="display:none;"></span>
        </i>
        <span class="ttl hiden-xs">Messages</span></a>
</div>

<div class="frnd-request">
    <a class="frndr" href="<?php echo $fullurl; ?>notifications.html"><i class="fa fa-bell">

            <span class="frnd-tltp" id="notificationnumber" style="display:none;"></span>

        </i>
        <span class="ttl hiden-xs">Notifications</span></a>

    <ul class="requst-list">

    </ul>
</div>
<div class="frnd-request hiden-xs">
    <a class="frndr" href="<?php echo $fullurl; ?>contacts.html"><i class="fa fa-user" aria-hidden="true">
            <span class="frnd-tltp" id="requestnotificationnumber" style="display:none;"></span>
        </i>
        <span class="ttl">Contacts</span></a>
</div>

<div class="frnd-request">
    <a id="vault" class="frndr" href="<?php echo $fullurl; ?>vault.html">
        <i class="fa fa-book" aria-hidden="true"></i>
        <span class="ttl hiden-xs">Knowledge Hub</span>
    </a>
</div>

<script>
    $('#frnd-list').load('<?php echo $fullurl; ?>contact_request.php');

</script>



<script>
    ////////India toogle start //////////

    $('.toggle').click(function (event) {
        event.stopPropagation();
    });

    $('html').click(function () {
        $('.setting_menu').hide();

    });


    // script for notification
    $('#frnd-toggle').click(function (event) {
        event.stopPropagation();
    });

    $('html').click(function () {
        $('#frnd-list').hide();
    });
    $('#frnd-toggle').click(function (event) {
        $('#notice-list').hide();
        $('#frnd-list').show();
    });


    // script for notification
    $('#notice-toggle').click(function (event) {
        event.stopPropagation();
    });

    $('html').click(function () {
        //$('#notice-list').hide();   
        //$('#frnd-list').hide();

    });

    $('#notice-toggle').click(function (event) {
        $('#notice-list').load('<?php echo $fullurl; ?>notification.php');
        $('#notice-list').show();
        $('#frnd-list').hide();

    });

    $(document).ready(function () {
        // Function to set the active state and color in sessionStorage
        function setActiveState(link) {
            sessionStorage.setItem('activePage', link.href);
            $('.frndr').removeClass('active');
            $('.frndr i').css('color', '');
            link.classList.add('active');
            $(link).find('i').css('color', '#C02621');
        }

        // Click event handler for icons
        $('.frndr').click(function () {
            setActiveState(this);
        });

        // Load contact requests when the page loads
        $('#frnd-list').load('<?php echo $fullurl; ?>contact_request.php');

        // Check the current page and set the active state
        const activePage = window.location.pathname;
        const navLinks = document.querySelectorAll('.frnd-request a');

        navLinks.forEach(link => {
            if (activePage.startsWith(link.pathname)) {
                setActiveState(link);
            }
        });
    });




</script>