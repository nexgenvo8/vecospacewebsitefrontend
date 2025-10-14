<?php
$page = isset($page) ? $page : 0;
?>
<ul class="cntr_tab">
    <li><a href="<?php echo $fullurl; ?>vault.html" <?php if ($page == 1) { ?>class="active" <?php } ?>>All Documents</a></li>
    <?php if (!empty($_SESSION["sessUserId"])) { ?>
        <li><a href="<?php echo $fullurl; ?>my-vault.html" <?php if ($page == 2) { ?>class="active" <?php } ?>>My Documents</a>
        </li>
        <?php if ($page != 3) { ?>
            <li style="float:right;" class="evnt-crt-btn smbcls">
                <a href="<?php echo $fullurl; ?>upload-documents.html">Upload</a>
            </li>
        <?php } ?>
    <?php } ?>
</ul>