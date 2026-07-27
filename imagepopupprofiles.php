<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php');

$imgId = $_REQUEST['imgId'];
$placeholderImage = $fullurl . 'uploads/user-placeholder.jpg';
?>

<div class="img-inner-pop">
    <a class="img-clos" onclick="$('#imagepopup').hide();">
        <i class="fa fa-times"></i>
    </a>

<?php
if (is_numeric($imgId)) {

    $sql = "SELECT imageName FROM "._IMAGE_MASTER_TABLE_." WHERE id=".$imgId." LIMIT 1";
    $b = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sql);

    if ($b && mysql_num_rows($b) > 0) {

        $rowimg = mysql_fetch_array($b);
        $imagePath = $fullurl . 'uploads/' . $rowimg['imageName'];

        // ✅ Check file exists
        if (!empty($rowimg['imageName']) && file_exists('uploads/' . $rowimg['imageName'])) {
            echo '<img src="'.$imagePath.'">';
        } else {
            echo '<img src="'.$placeholderImage.'">';
        }

    } else {
        // ❌ DB record not found
        echo '<img src="'.$placeholderImage.'">';
    }

} else {

    // 🔹 Direct image name case
    if (!empty($imgId) && file_exists('uploads/' . $imgId)) {
        echo '<img src="'.$fullurl.'uploads/'.$imgId.'">';
    } else {
        echo '<img src="'.$placeholderImage.'">';
    }
}
?>
</div>
