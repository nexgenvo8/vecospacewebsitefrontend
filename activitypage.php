<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

if (isset($_POST['userId']) && $_GET['userId'] != '') {
  $_SESSION['useractivity'] = decoeStr($_GET['userId']);
} else {
  $_SESSION['useractivity'] = $_SESSION['sessUserId'];
}

?>
<!DOCTYPE html>
<html>

<head>
  <title>My Activity - <?php echo $companNameTitle; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

  <link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
  <script src="<?php echo $fullurl; ?>js/main.js"></script>
</head>

<body>
  <div id="wrapper" class="active">

    <?php include('header.php'); ?>
    <div class="container main">
      <div class="premium_tag"><a href="#">Go Premium</a>
        <p id="typewriter"></p>
      </div>
      <div class="home_container">
        <?php include('left-sidebar.php'); ?>
        <div class="center_content">
          <div class="cntr_cntnt">

            <div class="all-activity">
              <h2>My College Action</h2>
              <ul class="cntr_tab">
                <li><a href="<?php echo $fullurl; ?>activity.html?view=1" class="<?php if ($_REQUEST['view'] == '1') {
                     echo 'active';
                   } ?>">Highlight</a></li>
                <li><a href="<?php echo $fullurl; ?>activity.html?view=2" class="<?php if ($_REQUEST['view'] == '2') {
                     echo 'active';
                   } ?>">Stories</a></li>
              </ul>
            </div>
            <div id="loadtimeline1">
              Loading...
            </div>
          </div>
          <?php include('right-sidebar.php'); ?>
        </div>
      </div>
    </div>
    <?php include('footer.php'); ?>
  </div>
  <div id="commonaction" style="display:none;"></div>
  <script>
    loadtimelineActivitfun(1, 0, 20, <?php if ($_REQUEST['view'] == '') {
      echo '0';
    } else {
      echo $_REQUEST['view'];
    } ?>);
    function countpostview(id) {
      $('#commonaction').load('<?php echo $fullurl; ?>common_action.php?action=allpostview&postId=' + id);
    }

  </script>
</body>

</html>