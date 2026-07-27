<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

$pageIndex = 11;
$ptab = 5;

// Fix undefined "sort"
$sort = isset($_GET["sort"]) ? $_GET["sort"] : "";

if ($sort == '') {
  $sortStr = "ORDER BY id DESC";
  $sortTaxt = 'Latest projects';
}

if ($sort == 'startdate') {
  $sortStr = "ORDER BY proStartDate DESC";
  $sortTaxt = 'Project start date';
}

// Define empty arrays so they won't be undefined
$selectFields = [];
$whereFields = [];
$whereVals = [];

// My Projects
$sqlMyProject = "SELECT * FROM " . _PROJECT_MASTER_TABLE_ . " WHERE userId=" . intval($_SESSION["sessUserId"]) . " " . $sortStr;
$resMyProject = getRecords(_PROJECT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlMyProject);

// Fix mysql_num_rows → mysqli_num_rows
$totalMyproject = is_object($resMyProject) ? mysqli_num_rows($resMyProject) : 0;

// Bookmarked Projects
$sqlBookmProject = "SELECT id FROM " . _PROJECT_BOOKMARK_TABLE_ . " WHERE userId=" . intval($_SESSION["sessUserId"]);
$resBookmProject = getRecords(_PROJECT_BOOKMARK_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlBookmProject);
$totalBookmproject = is_object($resBookmProject) ? mysqli_num_rows($resBookmProject) : 0;

// Interested Projects
$sqlInterestedProject = "SELECT id FROM " . _PROJECT_INTRESTED_TABLE_ . " WHERE userId=" . intval($_SESSION["sessUserId"]);
$resInterestedProject = getRecords(_PROJECT_INTRESTED_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlInterestedProject);
$totalInterestedproject = is_object($resInterestedProject) ? mysqli_num_rows($resInterestedProject) : 0;

?>

<!DOCTYPE html>
<html>

<head>
  <title>Internship - <?php echo $companNameTitle; ?></title>
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

      </div>
      <div class="center_content">

        <div class="groups" style="min-height:500px; background-color:#fff;">
          <?php include('project_top.inc.php'); ?>
          <ul class="manage-tab">

            <li><a href="<?php echo $fullurl; ?>manage-projects.html" class="active">My Internship
                <?php if ($totalMyproject > 0) {
                  echo '(' . $totalMyproject . ')';
                } ?></a></li>
            <li><a href="<?php echo $fullurl; ?>bookmarked-projects.html">Bookmarked Internship
                <?php if ($totalBookmproject > 0) {
                  echo '(' . $totalBookmproject . ')';
                } ?></a></li>
            <li><a href="<?php echo $fullurl; ?>interested-projects.html">Internship I am interested
                in<?php if ($totalInterestedproject > 0) {
                  echo '(' . $totalInterestedproject . ')';
                } ?></a></li>
            <li class="post-prjct-btn"><a href="<?php echo $fullurl; ?>post-project.html" class="btn">Post a Internship
              </a></li>
          </ul>


          <?php
          if ($totalMyproject == 0) {
            ?>
            <div class="crtnw-prjct" style="text-align:center; padding-top:15%;">
              <strong>You have not posted any project currently.</strong>
              <p>All the projects that you will post will appear here. </p>
            </div>
          <?php } else { ?>

            <div class="reslt">
              <span class="rslt-count"><?php echo $totalMyproject; ?> Result</span>
              <div class="short-sec">
                <label>Sort:</label>
                <div class="hddn_dropdwn">
                  <span><?php echo $sortTaxt; ?><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                  <ul>
                    <li>
                      <a href="manage-projects.html?sort=">Latest projects</a>
                    </li>
                    <li>
                      <a href="manage-projects.html?sort=startdate">Project start date</a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <ul class="project-list">
              <?php

              if ($totalMyproject > 0) {
                while ($rowProject = mysqli_fetch_array($resMyProject)) {

                  $totalbookmarks = '';
                  $aa = "SELECT * from " . _PROJECT_BOOKMARK_TABLE_ . " WHERE projectId= " . $rowProject['id'] . " ";
                  $res5 = mysqli_query($conn, $aa);
                  $totalbookmarks = mysqli_num_rows($res5);
                  ?>
                  <?php
                  if ($rowProject["proDuration"] == '1 day') {
                    $first = '1';
                    $last = 'day';
                  }
                  if ($rowProject["proDuration"] == '2 days') {
                    $first = '2';
                    $last = 'days';
                  }
                  if ($rowProject["proDuration"] == '3 days') {
                    $first = '3';
                    $last = 'days';
                  }
                  if ($rowProject["proDuration"] == '7 days(1 week)') {
                    $first = '1';
                    $last = 'week';
                  }
                  if ($rowProject["proDuration"] == '14 days(2 weeks)') {
                    $first = '2';
                    $last = 'weeks';
                  }
                  if ($rowProject["proDuration"] == '21 days(3 weeks)') {
                    $first = '3';
                    $last = 'weeks';
                  }
                  if ($rowProject["proDuration"] == '28 days(1 month)') {
                    $first = '1';
                    $last = 'month';
                  }
                  if ($rowProject["proDuration"] == '60 days(2 months)') {
                    $first = '2';
                    $last = 'months';
                  }
                  if ($rowProject["proDuration"] == '90 days(3 months)') {
                    $first = '3';
                    $last = 'months';
                  }

                  ?>
                  <li>
                    <div class="prjct-post manage">
                      <div class="prjct-tm">
                        <?php echo $first; ?><span><?php echo $last; ?></span>
                      </div>
                      <div class="project-nm">
                        <span><?php
                        $selectFields = [];
                        $whereFields = [];
                        $whereVals = [];
                        $sqlOptionspost = "SELECT optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='industry' AND id='" . $rowProject["protIndusCategory"] . "'";


                        // Pass "yes" explicitly so getRecords() uses custom SQL
                        $resOptionspost = getRecords(_OPTION_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, "yes", $sqlOptionspost);

                        if ($resOptionspost === false) {
                          echo "Query failed: " . mysqli_error(getDbConnection());
                        } else {
                          $totalpost = mysqli_num_rows($resOptionspost);
                          if ($totalpost > 0) {
                            while ($rowOptionspost = mysqli_fetch_array($resOptionspost)) {
                              echo trim($rowOptionspost['optionName']);
                            }
                          } else {
                            echo "No industry found.";
                          }
                        }

                        ?></span>
                        <a
                          href="<?php echo $fullurl; ?>preview-project.html?projId=<?php echo encodeStr($rowProject['id']); ?>"><?php echo stripslashes($rowProject["projectTitle"]); ?></a>
                        <div class="posted">Posted: <span><?php echo date("d/m/Y", $rowProject["dateAdded"]); ?></span> Start:
                          <span><?php echo date("d/m/Y", strtotime($rowProject["proStartDate"])); ?></span>
                        </div>

                      </div>
                      <div class="prjct-location">
                        <span
                          class="pending <?php if ($rowProject["finalPost"] == 1) { ?>active<?php } ?>"><?php if ($rowProject["finalPost"] == 1) { ?>active<?php } else { ?>Pending<?php } ?></span>
                        <div class="viw"><i class="fa fa-eye" aria-hidden="true"></i>
                          (<?php echo stripslashes($rowProject["projectViews"]); ?>) <i class="fa fa-bookmark"
                            aria-hidden="true"></i> (<?php if ($totalbookmarks > 0) {
                              echo $totalbookmarks;
                            } else {
                              echo '0';
                            } ?>)
                        </div>

                      </div>

                      <div class="prjct-ownr">
                        <div class="edit-btn">
                          <a title="Edit"
                            href="<?php echo $fullurl; ?>post-project.html?projId=<?php echo encodeStr($rowProject['id']); ?>"><i
                              class="fa fa-pencil" aria-hidden="true"></i></a>
                          <a title="Delete project"
                            onClick="$('#commonpopupwinouter').hide();alertpopupmain('<?php echo encodeStr($rowProject['id']); ?>','delproject');"><i
                              class="fa fa-trash-o" aria-hidden="true"></i></a>

                        </div>
                      </div>
                    </div>


                  </li>
                  <?php

                }

              }
              ?>
            </ul>

          <?php } ?>


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
    if ($_SESSION["s"] == 2) {
      ?>
      showsusmsg('SUCCESS', 'Thank you for posting your Project on <?php echo $companNameTitle; ?>. We are reviewing the same and will come back to you shortly.', '');
      <?php
      $_SESSION["s"] = '';
    }

    if ($_SESSION["d"] == 1) {
      ?>
      showerrormsg('SUCCESS', 'Project page deleted successfully', '');
      <?php
      $_SESSION["d"] = '';
    }

    ?>
  </script>
</body>

</html>