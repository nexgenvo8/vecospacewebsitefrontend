<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$ps = 3;
?>
<!DOCTYPE html>
<html>

<head>
  <title>Settings - <?php echo $companNameTitle; ?></title>
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

      <div class="home_container">
        <?php include('left-sidebar.php'); ?>
        <div class="center_content">
          <div class="setting" id="settingpage">
            <div class="sttng-wraper">

              <?php include('settingtop.inc.php'); ?>
              <?php

              $sql = "SELECT * from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE userId= " . $_SESSION['sessUserId'] . " ";
              $getSql = mysqli_query($conn, $sql) or die(error_found(mysqli_error($conn)));

              $getResults = mysqli_fetch_array($getSql);

              ?>
              <ul class="setting_area_list">
                <li>
                  <span class="subtitle">Profile settings<a
                      onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=settings&section=1','Profile settings');"
                      class="edit_btn">Edit</a></span>
                  <ul class="privacy-setting-list">

                    <li><i class="fa fa-check" aria-hidden="true"></i>
                      The "Contacts" tab in my profile is visible to:
                      <strong><?php echo $getResults["contactTabvisible"]; ?></strong>
                    </li>
                    <li><i class="fa fa-check" aria-hidden="true"></i>
                      The "Activity" tab in my profile is visible to:
                      <strong><?php echo $getResults["activityTabVisible"]; ?></strong>
                    </li>

                    <li> <?php if ($getResults["allowSearchEngines"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      Allow search engines to find my profile
                    </li>

                    <li> <?php if ($getResults["contactListVisible"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      Let other people can see
                    </li>
                    <span class="subtitle">General settings<a
                        onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=settings&section=2','General settings');"
                        class="edit_btn">Edit</a></span>
                    <li style="display:none;"><i class="fa fa-check" aria-hidden="true"></i>
                      I want to receive messages from:
                      <strong><?php echo $getResults["iWantRecieveMsg"]; ?></strong>
                    </li>
                    <li><?php if ($getResults["postGroupSearchEngine"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      Make my public groups and articles available to search engines
                    </li>

                    <li><?php if ($getResults["newOpportunities"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      Let recruiters know that you are open to new opportunities
                    </li>

                    <li><?php if ($getResults["allowFuturePostsComments"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      Allow other members to mention you in future posts or comments
                    </li>


                  </ul>
                </li>
              </ul>
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
</body>

</html>