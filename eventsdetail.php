<?php
include_once('inc.php');
$pageIndex = 10;
function addhttp($url)
{
  if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
    $url = "http://" . $url;
  }
  return $url;
}

if ($_REQUEST['eventId'] != '') {
  $sqlEvents = "SELECT * from " . _EVENT_MASTER_TABLE_ . " WHERE id= " . decodeStr($_REQUEST['eventId']) . " ";
  $resEvents = mysqli_query($conn, $sqlEvents) or die(error_found(mysqli_error($conn)));
  $rowEvents = mysqli_fetch_array($resEvents);

  if ($rowEvents['id'] == '') {
    header("Location: " . $fullurl . "404error.html");
    exit();
  }
  if ($rowEvents['eventName'] == '') {
    header('Location:events.html');
    exit();
  }

  if ($rowEvents["eventThumb"] != '') {
    $eventphoto = $rowEvents["eventThumb"];
  } else {
    $eventphoto = 'events-placeholder.jpg';
  }
  if ($rowEvents["eventBanner"] != '') {
    $eventBgphoto = $rowEvents["eventBanner"];
  } else {
    $eventBgphoto = 'events-bg-placeholder.jpg';
  }



  $a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowEvents["userId"] . "";
  $b = mysqli_query($conn, $a) or die(mysqli_error($conn));
  $userres = mysqli_fetch_array($b);

  $friendnameurl = $userres['userurl'];

  if ($userres["profilePhoto"] != '') {
    $userphoto = $userres["profilePhoto"];
  } else {
    $userphoto = 'user-placeholder.jpg';
  }



  $ac = "SELECT id, companyName 
       FROM " . _COMPANY_MASTER_TABLE_ . " 
       WHERE userId = " . intval($rowEvents["userId"]) . " 
         AND companyName != '' 
         AND status = 0 
       ORDER BY id DESC";

  $bc = mysqli_query($conn, $ac) or die(mysqli_error($conn));

  if ($cmpn = mysqli_fetch_array($bc)) {
    $usercmpid = $cmpn['id'];
    $usercmpname = stripslashes($cmpn["companyName"]);
  } else {
    $usercmpid = null;     // ya koi default value
    $usercmpname = "";     // empty string if not found
  }


}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Events - <?php echo $companNameTitle; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
  <link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

  <meta property="og:title" content="<?php echo stripslashes($rowEvents["eventName"]); ?>" />

  <meta property="og:image" content="<?php echo $fullurl; ?>uploads/<?php echo $eventBgphoto; ?>" />

  <meta property="og:site_name" content="<?php echo $fullurl; ?>" />
  <meta property="og:description"
    content="<?php echo substr(stripslashes(strip_tags($rowEvents["eventBrief"])), 0, 250); ?>" />
  <meta property="og:type" content="Events" />
  <meta property="og:url" content="http://<?php echo $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>" />



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
        <div class="center_content <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
        } else {
          echo 'nologin';
        } ?>">
          <form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post"
            target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
            <div class="evnts dtail">
              <ul class="cntr_tab">
                <li><a href="<?php echo $fullurl; ?>events.html" class="active">All Events</a></li>
                <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
                  <li><a href="<?php echo $fullurl; ?>my-events.html">My Events</a></li> <?php } ?>
                <?php if ($rowEvents['userId'] == $_SESSION["sessUserId"]) { ?>
                  <li class="evnt-crt-btn"><a
                      href="<?php echo $fullurl; ?>post-events.html?eventId=<?php echo trim($_REQUEST['eventId']); ?>">Edit
                      Event</a></li>
                <?php } else { ?>
                  <li class="evnt-crt-btn"><a href="<?php echo $fullurl; ?>post-events.html">+ Post an Event</a></li>
                <?php } ?>
              </ul>
              <div class="bgwhite">
                <div class="evnt-info-bnn" style="position:relative;">


                  <?php if ($rowEvents['userId'] == $_SESSION["sessUserId"]) { ?><span class="edit"><i
                        class="fa fa-pencil" aria-hidden="true"></i>
                      <input name="eventbannerphoto" id="eventbannerphoto" type="file"
                        onChange="$('#frmposthome').submit();$('#commonloader').show();"
                        style=" position:absolute; right:0px; top:0px; width:100%; height:100%;cursor: pointer; opacity: 0; filter: alpha(opacity=0); "
                        accept="image/x-png,image/gif,image/jpeg">
                      <input type="hidden" id="eventBannerOld" name="eventBannerOld"
                        value="<?php echo $rowEvents["eventBanner"]; ?>">
                    <?php } ?></span>
                  <img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($eventBgphoto)); ?>"
                    title="<?php echo stripslashes($rowEvents["eventName"]); ?>"
                    alt="<?php echo stripslashes(trim($rowEvents["eventName"])); ?>">

                  <div
                    style="position:absolute; left:0px; bottom:0px; background-color:rgba(0,0,0,0.7); padding:25px; color:#fff; width:100%; font-size:22px;">
                    <?php echo stripslashes($rowEvents["eventName"]); ?>
                  </div>


                </div>
                <div class="info-head" style="padding-bottom:0px; margin-top:30px; padding-left:17px; ">
                  <div class="info-img"
                    style=" position:absolute; top:-287px; left:24px; <?php if ($rowEvents['userId'] == $_SESSION["sessUserId"]) { ?>cursor:pointer;<?php } else { ?>cursor:default;<?php } ?>">
                    <?php if ($rowEvents['userId'] == $_SESSION["sessUserId"]) { ?><span class="edit"><i
                          class="fa fa-pencil" aria-hidden="true"></i></span><?php } ?><img
                      src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($eventphoto)); ?>"
                      title="<?php echo stripslashes($rowEvents["eventName"]); ?>"
                      alt="<?php echo stripslashes(trim($rowEvents["eventName"])); ?>">
                    <?php if ($rowEvents['userId'] == $_SESSION["sessUserId"]) { ?>

                      <input name="eventprofilephoto" id="eventprofilephoto" type="file"
                        onChange="$('#frmposthome').submit();$('#commonloader').show();"
                        style=" position:absolute; left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); "
                        accept="image/x-png,image/gif,image/jpeg">
                      <input type="hidden" id="eventId" name="eventId" value="<?php echo $_REQUEST["eventId"]; ?>">
                      <input type="hidden" id="action" name="action" value="profilephoto">
                      <input type="hidden" id="eventThumbOld" name="eventThumbOld"
                        value="<?php echo $rowEvents["eventThumb"]; ?>">
                    <?php } ?>
                  </div>
                  <div class="evnt-info-titl">

                    <?php if ($rowEvents["websiteurl"] != '') { ?>
                      <!-- <a href="<?php echo addhttp($rowEvents["websiteurl"]); ?>" target="_blank"><?php echo trim($rowEvents["websiteurl"]); ?></a>-->
                    <?php } ?>
                  </div>
                  <div class="featurd-evnt" style="padding-top:0px;">
                    <div class="fetrd-left">
                      <div class="evnt-timing">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <div class="tim"><label>Starts:
                          </label><?php $strstrtdate = strtotime($rowEvents["eventDate"]);
                          echo date("D, j M Y", $strstrtdate); ?>,
                          <?php echo $rowEvents["starttime"]; ?>
                        </div>
                        <div class="tim"><label>Ends:
                          </label><?php $strenddate = strtotime($rowEvents["eventTillDate"]);
                          echo date("D, j M Y", $strenddate); ?>,
                          <?php echo $rowEvents["endtime"]; ?>
                        </div>
                        <?php if ($rowEvents["eventType"] != '') { ?>
                          <div class="tim"><label>Event Type: </label><?php echo $rowEvents["eventType"]; ?></div>
                        <?php } ?>
                      </div>

                    </div>
                    <div class="fetrd-right going">
                      <div class="evnt-timing">
                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                        <div class="tim"><a
                            href="https://www.google.co.in/maps/place/<?php echo stripslashes($rowEvents["eventVenue"]); ?> <?php echo stripslashes($rowEvents["eventCountryAddress"]); ?>"
                            target="_blank"><?php echo stripslashes($rowEvents["eventVenue"]); ?><br>
                            <?php echo stripslashes($rowEvents["eventCountryAddress"]); ?></a></div>
                      </div>
                      <div class="going-btn" style="position:absolute; right:20px;    margin-right: 4px;">
                        <div style="float: none;position: absolute;top: -80px;width: 300px;right: -96px;">
                          <!-- Go to www.addthis.com/dashboard to customize your tools -->
                          <script type="text/javascript"
                            src="//s7.addthis.com/js/300/addthis_widget.js#pubid=imran190"></script>
                          <!-- Go to www.addthis.com/dashboard to customize your tools -->
                          <div class="addthis_inline_share_toolbox_tnos"></div>
                        </div>
                        <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
                          <div class="btn-going" style="margin-right:-15px;">
                            <a class="rugo">Are You Going <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                            <ul class="go-btn-list" style="display:none;">
                              <li><a
                                  href="<?php echo $fullurl; ?>events-detail.html?eventId=<?php echo trim($_REQUEST["eventId"]); ?>&status=1">Yes
                                </a></li>
                              <li><a
                                  href="<?php echo $fullurl; ?>events-detail.html?eventId=<?php echo trim($_REQUEST["eventId"]); ?>&status=2">Maybe</a>
                              </li>
                              <li><a
                                  href="<?php echo $fullurl; ?>events-detail.html?eventId=<?php echo trim($_REQUEST["eventId"]); ?>&status=3">No</a>
                              </li>
                            </ul>
                          </div> <?php } ?>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="evnt-list-cont info">
                <ul class="cntr_tab">
                  <li><a class="active" href="<?php echo $fullurl; ?>events.html">Event</a></li>
                  <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
                    <li><a href="<?php echo $fullurl; ?>contact-events.html">Your contacts' events</a></li> <?php } ?>
                </ul>
                <div class="evnt-mmbrs">
                  <div class="left-sec">
                    <?php
                    $sql_ins = "select id from " . _EVENT_GUEST_MASTER_TABLE_ . " where  eventId= " . $rowEvents["id"] . " and status=1";
                    $resresult2 = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
                    $totalimages = mysqli_num_rows($resresult2);
                    if ($totalimages > 0) {
                      ?>
                      <div class="left-guest" style="padding-left:0px;">
                        <div class="h2">Guest list</div>
                        <ul class="grupmmbrlist" style="display:block;">
                          <?php
                          $m = 0;
                          $selectFields = [];
                          $whereFields = [];
                          $whereVals = [];

                          $sqlGroupMembers = "SELECT * FROM " . _EVENT_GUEST_MASTER_TABLE_ . " WHERE eventId = " . intval($rowEvents["id"]) . " AND status = 1 ORDER BY id DESC LIMIT 0,6";
                          $resGroupMembers = getRecords(_EVENT_GUEST_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);

                          if ($resGroupMembers) {
                            while ($rowgroup = mysqli_fetch_array($resGroupMembers)) {

                              $eventfriendnameurl = '';
                              $eventuserphoto = '';
                              $eventFirstName = '';
                              $eventLastName = '';
                              $eventUserId = 0;

                              $aa = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = " . intval($rowgroup["userId"]);
                              $ba = mysqli_query($conn, $aa) or die(mysqli_error($conn));

                              if ($user = mysqli_fetch_array($ba)) {
                                $eventfriendnameurl = $user['userurl'] ?? '';
                                $eventuserphoto = !empty($user["profilePhoto"]) ? $user["profilePhoto"] : 'user-placeholder.jpg';
                                $eventFirstName = stripslashes(trim($user["firstName"] ?? ''));
                                $eventLastName = stripslashes(trim($user["lastName"] ?? ''));
                                $eventUserId = $user['userId'] ?? 0;
                              } else {
                                // Defaults if no user found
                                $eventfriendnameurl = '';
                                $eventuserphoto = 'user-placeholder.jpg';
                                $eventFirstName = '';
                                $eventLastName = '';
                                $eventUserId = 0;
                              }
                              ?>
                              <li>
                                <a
                                  href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($eventUserId); ?>/<?php echo $eventfriendnameurl; ?>.html">
                                  <img src="<?php echo $fullurl; ?>uploads/<?php echo $eventuserphoto; ?>"
                                    title="<?php echo $eventFirstName . ' ' . $eventLastName; ?>"
                                    alt="<?php echo $eventFirstName . ' ' . $eventLastName; ?>">
                                </a>
                              </li>
                              <?php
                              $m++;
                            }
                          }
                          ?>
                        </ul>
                        <span
                          class="going-mmbr"><strong><?php echo $totalimages ?? 0; ?></strong><?php echo $companNameTitle ?? ''; ?>
                          members are going to be there.</span>
                      </div>

                    <?php } ?>

                    <!--<div class="left-guest">
      <div class="h2">people2meet</div>
        <ul class="grupmmbrlist">
          <li><img src="images/knricon.png"></li>
          <li><img src="images/knricon.png"></li>
          <li><img src="images/knricon.png"></li>
          <li><img src="images/knricon.png"></li>
          <li><img src="images/knricon.png"></li>
          <li><img src="images/knricon.png"></li>
        </ul>
        <span class="going-mmbr"><strong>10</strong> Attendees may be of interest to you.</span>
      </div>-->

                    <div class="evnt-descrptn" style="padding-top:10px; padding-right:20px;">



                      <?php if ($rowEvents["eventBrief"] != '') { ?>
                        <div class="evnt-right-hdng">Brief profile of the Event</div>
                        <p><?php echo stripslashes(trim($rowEvents["eventBrief"])); ?></p><?php } ?>
                      <?php if ($rowEvents["eventDetails"] != '') { ?>
                        <div class="evnt-right-hdng">Details about the Event</div>
                        <p><?php echo stripslashes(trim($rowEvents["eventDetails"])); ?></p><?php } ?>
                      <?php if ($rowEvents["eventAgenda"] != '') { ?>
                        <div class="evnt-right-hdng">Agenda of the Event</div>
                        <p><?php echo stripslashes(trim($rowEvents["eventAgenda"])); ?></p><?php } ?>
                      <?php if ($rowEvents["websiteurl"] != '') { ?>
                        <div class="evnt-right-hdng">Website URL</div>
                        <p> <a href="<?php echo addhttp($rowEvents["websiteurl"]); ?>"
                            target="_blank"><?php echo trim($rowEvents["websiteurl"]); ?></a></p><?php } ?>

                      <?php
                      $sql_ins = "select id from " . _EVENT_IMAGE_MASTER_TABLE_ . " where  eventId= " . $rowEvents["id"] . "";
                      $resresult2 = mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
                      $totalimages = mysqli_num_rows($resresult2);
                      if ($totalimages > 0) {
                        ?>


                        <div class="evnt-right-hdng">Photographs</div>
                        <p>
                        <div class="uploadimg" id="imagebx"
                          style="border:0px; background-color:#fff; margin:0px; padding:0px; width:100%;">

                          <ul class="upld-img-list" style="display:block;">
                            <?php

                            $a = "select id,imageName from " . _EVENT_IMAGE_MASTER_TABLE_ . " where  eventId= " . $rowEvents["id"] . "";
                            $imgrows = mysqli_query($conn, $a) or die(mysqli_error($conn));
                            while ($rowName = mysqli_fetch_array($imgrows)) {

                              ?>
                              <li style="border:1px #CCCCCC solid;"><img
                                  src="<?php echo $fullurl; ?>uploads/<?php echo $rowName['imageName']; ?>"
                                  onClick="imagepopupmain('<?php echo $rowName['id']; ?>');"></li>
                              <?php

                            }
                            ?>



                          </ul>
                        </div>
                        </p>
                      <?php } ?>
                    </div>
                  </div>
                  <div class="right-sec">
                    <div class="organigr-cont" style="padding-bottom:40px;">
                      <span class="evnt-right-hdng">About the organiser</span>
                      <div class="orgnised">
                        <span class="org-img"><a
                            href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
                              src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a></span>
                        <div class="evnt-orgr-info">
                          <a
                            href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes(trim($userres["firstName"])); ?>
                            <?php echo stripslashes(trim($userres["lastName"])); ?></a><br>
                          <?php //if($usercmpid!=''){ ?><!--<strong>Founder-</strong>
            <a href="<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo encodeStr($usercmpid); ?>"><?php echo $usercmpname; ?></a>-->
                          <?php //}else{ ?>
                          <?php echo $userres['jobTitle']; ?> at
                          <?php echo $userres['companyName']; ?>
                          <?php //} ?>
                        </div>
                      </div>
                    </div>
                    <div class="organigr-cont">
                      <div class="vanue">
                        <span class="sub-hdng">Event venue</span>
                        <strong><?php echo stripslashes($rowEvents["eventVenue"]); ?></strong>
                        <span class="txt"><?php echo stripslashes($rowEvents["eventCountryAddress"]); ?></span>
                        <?php if ($rowEvents["eventVenue"] != '') { ?>
                          <a href="https://www.google.co.in/maps/place/<?php echo stripslashes($rowEvents["eventVenue"]); ?> <?php echo stripslashes($rowEvents["eventCountryAddress"]); ?>"
                            target="_blank" class="openingooglemap"> <i class="fa fa-map-marker" aria-hidden="true"></i>
                            Open in Google Maps</a>
                        <?php } ?>
                      </div>
                    </div>
                    <!--<div class="organigr-cont">
        <div class="vanue">
          <span class="sub-hdng">Event language</span>
          <span class="txt">English</span>
        </div>
      </div>-->
                  </div>
                </div>












              </div>

            </div>
          </form>
        </div>
      </div>
    </div>
    <?php include('footer.php'); ?>
  </div>
  <script>
    function reloadPage() {
      location.reload(true);
    }



    function imagepopupmain(id) {
      $('#eventimagepopup').html('<div class="postimageloading">Loading</div>');
      $('#eventimagepopup').show();
      $('#eventimagepopup').load(fullurl + 'eventsimagepopup.php?imgId=' + id);
    }

    $(".rugo").click(function () {
      $('.go-btn-list').toggleClass("open");
    });

  </script>





  <div class="img-popup" id="eventimagepopup" style="display:none;">
  </div>

  <style>
    .edit {
      position: absolute;
      right: 0;
      text-align: center;
      width: 30px;
      height: 30px;
      background-color: #ffffff;
      line-height: 30px;
      border-radius: 50%;
      top: 8px;
      right: 10px;
    }
  </style>

</body>

</html>