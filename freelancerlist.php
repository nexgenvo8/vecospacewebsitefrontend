    <?php
    include_once('inc.php');
    include_once('config/session-check.inc.php'); // check user login session
    
    $pageIndex = 11;
    $ptab = 3;

    $no = 0;
    $select = '';
    $where = '';
    $rs = '';

    // Fix undefined "page"
    $page = isset($_GET['page']) ? clean($_GET['page']) : 1;
    $limit = 15;

    $select = 'userId, serviceOffered, jobSkills, experienceLevel, professionalTitle, professionalBrief, freelancerStatus, userurl, firstName, lastName, profilePhoto';
    $where = 'where freelancerStatus=1 and userId!=' . intval($_SESSION["sessUserId"]);
    $targetpage = $fullurl . 'freelancers.html?records=' . $limit;

    // === FIX: Check if GetRecordList() exists before calling ===
    if (function_exists('GetRecordList')) {
      $rs = GetRecordList($select, _USERS_MASTER_TABLE_, $where, $limit, $page, $targetpage);
      $totalentry = $rs[1];
      $paging = $rs[2];
    } else {
      die("Error: GetRecordList() function is not defined. Please include the file where it is defined.");
    }

    // Check Freelancer
    $checkFrelnce = "SELECT userId FROM " . _USERS_MASTER_TABLE_ . " WHERE serviceOffered!=0 and userId='" . intval($_SESSION["sessUserId"]) . "' ";
    $rescheckFrelnce = mysqli_query($conn, $checkFrelnce); // Changed to mysqli_query
    $totalcheckFrelnce = is_object($rescheckFrelnce) ? mysqli_num_rows($rescheckFrelnce) : 0;
    ?>

<!DOCTYPE html>
<html>

<head>
  <title>Internship Seekers - <?php echo $companNameTitle; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/default.css">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

  <link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
  <script src="<?php echo $fullurl; ?>js/main.js"></script>
  <style type="text/css">
    ul.prjct-list li a.active {
      color: #C02621;
    }

    ul.prjct-list li a.active i.fa {
      background-color: #C02621;
    }

    ul.prjct-list li a.active:hover i.fa {
      background-color: #1280ab;
    }

    ul.prjct-list li a.active:hover {
      color: #1280ab;
    }
  </style>
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

      </div>
      <div class="center_content">

        <div class="groups">
          <?php include('project_top.inc.php'); ?>

          <div class="frlncer">


            <div class="hding">
              <h2>Internship Seekers <?php if ($totalentry > 0) {
                echo '(' . $totalentry . ')';
              } ?></h2>
              <?php if ($totalcheckFrelnce > 0) { ?>
                  <a class="rgstr-btn"
                    href="<?php echo $fullurl; ?>freelancer-profile.html?fid=<?php echo encodeStr($_SESSION["sessUserId"]); ?>">My
                    Project Seeker profile</a>
              <?php } else { ?>
                  <a href="<?php echo $fullurl; ?>register-freelancer.html" class="rgstr-btn">Register as a Internship
                    Seeker</a>
              <?php } ?>
            </div>

            <ul class="frlncer-list">
              <?php
              while ($getResults = mysqli_fetch_array($rs[0], MYSQLI_ASSOC)) {


                $no = 1;
                ?>
                  <li>
                    <div class="frlncr_box">
                      <div class="frlncr-hd">
                        <div class="img"><img
                            src="<?php echo $fullurl; ?>uploads/<?php echo $getResults["profilePhoto"]; ?>">
                        </div>
                        <div class="nm">
                          <a
                            href="<?php echo $fullurl; ?>freelancer-profile.html?fid=<?php echo encodeStr($getResults['userId']); ?>"><?php echo $getResults['firstName']; ?>
                            <?php echo $getResults['lastName']; ?></a>
                        </div>
                      </div>
                      <div class="srvc-offer">
                        <span>Service offered</span>
                        <h3><?php
                        $selectFields = [];
                        $whereFields = [];
                        $whereVals = [];

                        $sqlOptions1 = "";
                        $sqlOptions1 = "SELECT optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='projectindustries' AND id='" . intval($getResults["serviceOffered"]) . "' ";
                        $resOptions1 = getRecords(_OPTION_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions1);

                        // Fix: mysql_num_rows → mysqli_num_rows
                        $totalpost1 = is_object($resOptions1) ? mysqli_num_rows($resOptions1) : 0;

                        if ($totalpost1) {
                          while ($rowOptions1 = mysqli_fetch_array($resOptions1, MYSQLI_ASSOC)) {
                            echo trim($rowOptions1['optionName']);
                          }
                        }

                        ?></h3>
                      </div>
                      <div class="srvc-offer">
                        <span>Work Experience</span>
                        <h3><?php echo $getResults['experienceLevel']; ?></h3>
                      </div>
                      <a href="<?php echo $fullurl; ?>freelancer-profile.html?fid=<?php echo encodeStr($getResults['userId']); ?>"
                        class="full-dtail">View Full Profile</a>
                    </div>
                  </li>
                  <?php

              }

              ?>
              <?php if ($no == 1) { ?>
                  <div class="pagingnumbers"><?php echo $paging; ?></div>

              <?php }
              if ($no == 0) { ?>

                  <div style="padding:20px; width:100%; text-align:center; float:left;">Sorry, we didn't find any Internship
                    Seeker with these search terms.</div>

              <?php } ?>
            </ul>
          </div>



        </div>


      </div>
    </div>
    <?php include('footer.php'); ?>
  </div>
</body>

</html>