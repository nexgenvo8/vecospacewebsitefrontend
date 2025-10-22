<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 10;
?>

<!DOCTYPE html>
<html>

<head>
  <title>Events - <?php echo $companNameTitle; ?></title>
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
          <div class="evnts">
            <ul class="cntr_tab">
              <li><a href="<?php echo $fullurl; ?>events.html">All Events</a></li>
              <li><a class="active">My Events</a></li>
              <li class="evnt-crt-btn"><a href="<?php echo $fullurl; ?>post-events.html">+ Post an event</a></li>
            </ul>


            <div class="evnt-list-cont">
              <ul class="evnts-list">
                <?php
                $n = 0;

                // mysqli connection assumed as $conn
// remove unset of undefined variables
                
                $sqlEvents = "SELECT * FROM " . _EVENT_MASTER_TABLE_ . " 
    WHERE userId = " . intval($_SESSION["sessUserId"]) . " 
    AND eventName != '' 
    ORDER BY id DESC";

                $resEvents = mysqli_query($conn, $sqlEvents);

                if ($resEvents && mysqli_num_rows($resEvents) > 0) {
                  while ($rowEvents = mysqli_fetch_assoc($resEvents)) {

                    $a = "SELECT id, imageName FROM " . _EVENT_IMAGE_MASTER_TABLE_ . " 
              WHERE eventId = " . intval($rowEvents["id"]);
                    $imgrows = mysqli_query($conn, $a);
                    $rowName = mysqli_fetch_assoc($imgrows);

                    if (!empty($rowName['imageName'])) {
                      $eventphoto = $rowName['imageName'];
                    } else {
                      $eventphoto = 'events-placeholder.jpg';
                    }
                    ?>
                    <li id="<?php echo trim($rowEvents['id']); ?>">
                      <a href="<?php echo $fullurl; ?>events-detail.html?eventId=<?php echo encodeStr($rowEvents['id']); ?>"
                        class="block">
                        <div class="evnt_box">
                          <div class="evnt-img">
                            <img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($eventphoto)); ?>"
                              title="<?php echo stripslashes($rowEvents["eventName"]); ?>"
                              alt="<?php echo stripslashes(trim($rowEvents["eventName"])); ?>">
                          </div>
                          <div class="evnt-dtail">
                            <span class="ttl"><?php echo stripslashes($rowEvents["eventName"]); ?></span>
                            <span class="evnt-dration">
                              <?php
                              $strstrtdate = strtotime($rowEvents["eventDate"]);
                              echo date("D, j M Y", $strstrtdate);
                              ?> -
                              <?php
                              $strenddate = strtotime($rowEvents["eventTillDate"]);
                              echo date("D, j M Y", $strenddate);
                              ?>
                            </span>
                            <span class="locat"><?php echo stripslashes($rowEvents["eventCountryAddress"]); ?></span>

                            <div class="dropdwn">
                              <a href="javascript:void(0);" class="open"
                                onclick="$('.remove-list').hide();$('#openc<?php echo trim($rowEvents['id']); ?>').show();">
                                <i class="fa fa-ellipsis-h" aria-hidden="true"></i>
                              </a>

                              <div style="display:none;" id="clipboard<?php echo ($rowEvents['id']); ?>">
                                <?php echo $fullurl . "events-detail.html?eventId=" . encodeStr($rowEvents['id']); ?>
                              </div>

                              <ul class="remove-list" id="openc<?php echo trim($rowEvents['id']); ?>"
                                style="display: none;">
                                <li><a
                                    href="<?php echo $fullurl; ?>post-events.html?eventId=<?php echo encodeStr($rowEvents['id']); ?>"><i
                                      class="fa fa-pencil" aria-hidden="true"></i>Edit</a></li>
                                <li><a style="cursor:pointer;"
                                    onclick="copyToClipboard('#clipboard<?php echo ($rowEvents['id']); ?>');"><i
                                      class="fa fa-link" aria-hidden="true"></i> Copy link to post</a></li>
                                <li><a onclick="alertpopupmain('<?php echo encodeStr($rowEvents['id']); ?>','delevnt');"><i
                                      class="fa fa-trash-o" aria-hidden="true"></i> Remove Event</a></li>
                              </ul>
                            </div>
                          </div>
                        </div>
                        <?php
                        $n++;
                  }
                }
                ?>
              </ul>

              <?php if ($n == 0) { ?>
                <div style="padding:20px; text-align:center;">There is no event currently to display.</div>
              <?php } ?>
            </div>

          </div>
        </div>
      </div>

      <?php
      $strDiv = 'none';
      if (isset($_SESSION['poe']) && $_SESSION["poe"] == 1) {
        $strDiv = 'block';
      } else {
        $strDiv = 'none';
      }

      $_SESSION["poe"] = '';
      ?>
      <div class="crt-grp-popup" id="commonpopupwinouter" style="display: <?php echo $strDiv; ?>;">
        <div class="popup-inner" id="commonpopupwin" style="width: 450px; max-width: 450px; height: auto;">
          <div class="invit">
            <a class="grp-close" onClick="closefuncommonpopupwin();"><i class="fa fa-times" aria-hidden="true"></i></a>

            <div class="nw-grup">
              <div id="commonpopupwinfile">
                <div style="text-align:center;">
                  <div style="
    padding: 10px;
    float: left;
    line-height: 22px;
">Thank you for your interest in posting your event on our platform. We are reviewing the details submitted by you.
                    Upon approval, we would send you an email and your event will be uploaded within 24 hours. We wish
                    you a successful event.<br>

                  </div>
                </div>
                <style>
                  .nw-grup {
                    padding: 0;
                  }
                </style>
              </div>
            </div>


          </div>

        </div>
      </div>


    </div>
    <?php include('footer.php'); ?>
  </div>
  <script>
    function reloadPage() {
      location.reload(true);
    }

  </script>

  <script>
    <?php
    $cmsg = 'Thank you for posting an Event on ' . $companNameTitle . '. We are reviewing the same and will come back to you shortly.';
    if ($_SESSION["s"] == 1) {
      ?>
      showsusmsg('SUCCESS', '<?php echo $cmsg; ?>', '');
      <?php
      $_SESSION["s"] = '';
    }
    ?>
  </script>
</body>

</html>