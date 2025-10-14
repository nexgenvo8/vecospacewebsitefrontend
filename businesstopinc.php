<?php
$page = $page ?? 0; // default value set
?>
<ul class="cntr_tab horizontal">
    <li><a href="<?php echo $fullurl; ?>smb-categories.html" <?php if ($page == 1) { ?>class="active" <?php } ?>>All
            Business
            Pages</a></li>

    <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
        <li><a href="<?php echo $fullurl; ?>my-business.html" <?php if ($page == 2) { ?>class="active" <?php } ?>>My Business
                Page</a></li>
        <!--<li><a href="<?php echo $fullurl; ?>my-blogs.html" <?php if ($page == 3) { ?>class="active"<?php } ?>>SME Connect</a></li>-->
        <li style="float:right;" class="evnt-crt-btn smbcls"><a href="<?php echo $fullurl; ?>cbp.html">Create Business
                Page</a></li>
    <?php } ?>
</ul>