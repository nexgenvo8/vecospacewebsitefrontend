<?php
include_once('inc.php');
$_SESSION['loginredirectpageurl'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];

include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 1;


$aa = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE id= " . decodeStr($_REQUEST["postId"]) . " ";
$res5 = mysqli_query($conn, $aa);
$articletext = mysqli_fetch_array($res5);



unset($insertFields);
unset($insertVals);
unset($whereFields);
unset($whereVals);

$insertFields[0] = "viewStatus";

$insertVals[0] = $articletext['viewStatus'] + 1;

$whereFields[0] = "id";

$whereVals[0] = decodeStr($_REQUEST["postId"]);

$resUpdate = updateDB(_SHAREANDUPDATES_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, ''); //Count article views

?>
<!DOCTYPE html>
<html>

<head>
  <title>Post - <?php echo $companNameTitle; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
  <link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
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
            <div class="cntr_cntnt_tab">
              <div class="timeline_cont">
                <div id="loadtimeline1">
                  Loading...
                </div>
              </div>


            </div>

          </div><?php include('right-sidebar.php'); ?>
        </div>


      </div>
    </div>
  </div>
  <?php include('footer.php'); ?>
  </div>
  <script>
    loadtimelinesinglepost2(1, 0, 20, '<?php echo $_GET["postId"]; ?>', '<?php echo $_GET["postType"]; ?>');
  </script>
</body>

</html>