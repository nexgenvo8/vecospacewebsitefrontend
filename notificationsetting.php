<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$ps = 4;
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
                  <span class="subtitle">I would like to be notified by e-mail...<a
                      onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=settings&section=3','I would like to be notified by e-mail');"
                      class="edit_btn">Edit</a></span>
                  <ul class="privacy-setting-list">
                    <li> <?php if ($getResults["sendMeEmail"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone sends me a message
                    </li>

                    <li> <?php if ($getResults["emailCommentLike"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone comments on something I posted or commented on
                    </li>

                    <li> <?php if ($getResults["emailPostLike"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone likes something I posted
                    </li>

                    <li> <?php if ($getResults["newContactRequest"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When I receive new contact requests
                    </li>

                    <li> <?php if ($getResults["pendingContactRequest"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      If I have any pending contact requests
                    </li>

                    <li style="display:none;"> <?php if ($getResults["emailFreelancerAccount"] == 1) { ?><i
                          class="fa fa-check" aria-hidden="true"></i><?php } else { ?><i class="fa fa-times"
                          aria-hidden="true"></i><?php } ?>
                      When someone send message to my freelancer account
                    </li>

                    <li> <?php if ($getResults["emailApplyProject"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone applies to the Project i posted
                    </li>

                    <li> <?php if ($getResults["emailContactNewPosition"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When a contact of mine has a new position or employer
                    </li>


                    <li> <?php if ($getResults["notiJoiningGroup"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone sends group joining request to My Group
                    </li>

                    <span class="subtitle">Notify me on <?php echo $companNameTitle; ?><a
                        onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=settings&section=4','Notify me on <?php echo $companNameTitle; ?>');"
                        class="edit_btn">Edit</a></span>
                    <li> <?php if ($getResults["notiPostGroup"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone posts in My Group
                    </li>

                    <li style="display:none;"> <?php if ($getResults["notiFollowCompany"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone follow your company
                    </li>

                    <li> <?php if ($getResults["notiTagingCompany"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone tags your company in his post
                    </li>

                    <li style="display:none;"> <?php if ($getResults["notiEventGuist"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone join your event guist list
                    </li>

                    <li> <?php if ($getResults["notiPostCommentsAllow"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone comments on something I posted or commented on
                    </li>

                    <li> <?php if ($getResults["notiPostLikesAllow"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone likes something I posted
                    </li>

                    <li> <?php if ($getResults["notiNewPositionEmployer"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When a contact of mine has a new position or employer
                    </li>

                    <li> <?php if ($getResults["notiMeetingRequest"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When a contact of mine sends me a meeting request
                    </li>

                    <li> <?php if ($getResults["notiProjectApplied"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone applies to a Project I posted
                    </li>

                    <li> <?php if ($getResults["notiJoinGroupRequestAllow"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When someone wants to Join a group that I have created
                    </li>

                    <li> <?php if ($getResults["notiNewArticlesAllow"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      When a contact of mine publishes a new article
                    </li>

                    <li> <?php if ($getResults["userBirthdayAllow"] == 1) { ?><i class="fa fa-check"
                          aria-hidden="true"></i><?php } else { ?><i class="fa fa-times" aria-hidden="true"></i><?php } ?>
                      On the Birthday of a contact of mine
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