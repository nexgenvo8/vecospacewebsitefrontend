<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 11;
$ptab = 2;

// Fix undefined $_GET keys
$sort = $_GET["sort"] ?? '';
$searchproject = $_GET["searchproject"] ?? '';
$citycountry = $_GET["citycountry"] ?? '';
$proNature = $_GET["proNature"] ?? '';
$page = $_GET["page"] ?? 1;

if ($sort == '') {
  $sortStr = "ORDER BY id DESC";
  $sortTaxt = 'Latest projects';
}

if ($sort == 'startdate') {
  $sortStr = "ORDER BY proStartDate DESC";
  $sortTaxt = 'Project start date';
}

$strProWhere = "";
if (trim($searchproject) != '') {
  $strProWhere .= " AND (projectTitle LIKE '%" . mysqli_real_escape_string($conn, trim($searchproject)) . "%' 
                    OR proSkills LIKE '%" . mysqli_real_escape_string($conn, trim($searchproject)) . "%')";
}

if (trim($citycountry) != '') {
  $strProWhere .= " AND (proCity LIKE '%" . mysqli_real_escape_string($conn, trim($citycountry)) . "%' 
                    OR proCountry LIKE '%" . mysqli_real_escape_string($conn, trim($citycountry)) . "%') ";
}

if (trim($proNature) != '') {
  $strProWhere .= " AND proNature LIKE '%" . mysqli_real_escape_string($conn, trim($proNature)) . "%' ";
}

$no = 0;
$select = '*';
$where = "WHERE status=1 AND finalPost=1 AND projectStatus=1 " . $strProWhere . " " . $sortStr;
$limit = 10;
$targetpage = $fullurl . 'search-projects.html?searchproject=' . urlencode($searchproject) .
  '&records=' . $limit . '&citycountry=' . urlencode($citycountry) .
  '&proNature=' . urlencode($proNature) . '&page=' . intval($page);

// **Replace GetRecordList() call**
$sql = "SELECT $select FROM " . _PROJECT_MASTER_TABLE_ . " $where LIMIT " . intval(($page - 1) * $limit) . ", $limit";
$rs_data = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$total_sql = "SELECT COUNT(*) as total FROM " . _PROJECT_MASTER_TABLE_ . " $where";
$total_result = mysqli_query($conn, $total_sql) or die(mysqli_error($conn));
$total_row = mysqli_fetch_assoc($total_result);
$totalentry = $total_row['total'];

// Simple paging calculation (replace your GetRecordList paging)
$paging = ceil($totalentry / $limit);
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

        <div class="groups">
          <?php include('project_top.inc.php'); ?>

          <div class="prjct-srch">
            <div class="grp_banner"
              style="background-image: none;background-color: #8c8c8c;height: 150px;text-shadow: inherit;">
              <form name="searchprojectfrm" id="searchprojectfrm" class="grp-search"
                action="<?php echo $fullurl; ?>search-projects.html" method="get" style=" padding-top:30px;">
                <div class="srchinput">
                  <label>What? <span> Internship name or task</span></label>
                  <input type="text" name="searchproject" id="searchproject"
                    value="<?php echo $_GET["searchproject"] ?? ''; ?>" placeholder="e.g. SAP, marketing, sales, etc.">
                </div>

                <div class="srchinput">
                  <label>Where? <span> City or country</span></label>
                  <input type="text" name="citycountry" id="citycountry"
                    value="<?php echo $_GET["citycountry"] ?? ''; ?>" placeholder="e.g. Berlin, Vienna, Berne, etc.">
                </div>

                <div class="srchinput radius">
                  <label><span>Nature of Internship </span></label>
                  <select name="proNature" id="proNature">
                    <option value="">-</option>
                    <option value="Part time" <?php if (($_GET["proNature"] ?? '') == "Part time")
                      echo "selected"; ?>>
                      Part time</option>
                    <option value="Full time" <?php if (($_GET["proNature"] ?? '') == "Full time")
                      echo "selected"; ?>>
                      Full time</option>
                  </select>

                </div>
                <button type="button" class="srch" onClick="subsrchfrm();">Search</button>
              </form>

              <script>
                function subsrchfrm() {

                  if ($("#searchproject").val() != '') {
                    $("#searchprojectfrm").submit();
                  }
                }

                $("input").keypress(function (event) {

                  if (event.which == 13) {
                    event.preventDefault();

                    if ($("#searchproject").val() != '') {
                      $("#searchprojectfrm").submit();
                    }
                  }

                });

              </script>
            </div>
            <div class="mmbrof_group_list">
              <h2 style="margin-top:30px; padding-right:22px; padding-left:22px; text-align:left;">All Internship <span
                  style="font-size:13px; padding-left:10px;"><?php echo $totalentry; ?> results</span>
                <div class="short-sec">
                  <label>Sort:</label>
                  <div class="hddn_dropdwn">
                    <span><?php echo $sortTaxt; ?> <i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                    <ul>
                      <li>
                        <a
                          href="search-projects.html?searchproject=<?php echo $_GET["searchproject"] ?? ''; ?>&citycountry=<?php echo $_GET["citycountry"] ?? ''; ?>&proNature=<?php echo $_GET["proNature"] ?? ''; ?>&records=<?php echo $_GET["records"] ?? ''; ?>&sort=">
                          Latest projects
                        </a>
                      </li>
                      <li>
                        <a
                          href="search-projects.html?searchproject=<?php echo $_GET["searchproject"] ?? ''; ?>&citycountry=<?php echo $_GET["citycountry"] ?? ''; ?>&proNature=<?php echo $_GET["proNature"] ?? ''; ?>&records=<?php echo $_GET["records"] ?? ''; ?>&sort=startdate">
                          Project start date
                        </a>
                      </li>
                    </ul>

                  </div>
                </div>
              </h2>
              <ul class="project-list" style="padding-bottom:0px;">
                <?php
                // Example: before your loop
                $sql = "SELECT * FROM " . _PROJECT_MASTER_TABLE_ . " WHERE status=1 AND finalPost=1 AND projectStatus=1 $strProWhere $sortStr 
        LIMIT " . intval(($page - 1) * $limit) . ", $limit";

                $rs = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                $p = 0;
                while ($rowProject = mysqli_fetch_array($rs)) {
                  $no = 1;
                  $friendnameurl = '';
                  $userphoto = '';

                  $a = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " WHERE userId = " . intval($rowProject["userId"]);
                  $b = mysqli_query($conn, $a) or die(mysqli_error($conn));
                  $userres = mysqli_fetch_array($b);

                  $friendnameurl = $userres['userurl'];

                  if ($userres["profilePhoto"] != '') {
                    $userphoto = $userres["profilePhoto"];
                  } else {
                    $userphoto = 'user-placeholder.jpg';
                  }
                  ?>
                  <li
                    onClick="location.href='<?php echo $fullurl; ?>preview-project.html?projId=<?php echo encodeStr($rowProject['id']); ?>';"
                    style="cursor:pointer;">
                    <div class="prjct-post">
                      <div class="prjct-tm">
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
                        <?php echo $first; ?><span><?php echo $last; ?></span>
                      </div>
                      <div class="project-nm">
                        <span>
                          <?php
                          $sqlOptionspost = "SELECT optionName FROM " . _OPTION_MASTER_TABLE_ . " WHERE optionType='projectindustries' AND id='" . intval($rowProject["protIndusCategory"]) . "'";
                          $resOptionspost = mysqli_query($conn, $sqlOptionspost) or die(mysqli_error($conn));
                          $totalpost = mysqli_num_rows($resOptionspost);

                          if ($totalpost) {
                            while ($rowOptionspost = mysqli_fetch_array($resOptionspost)) {
                              echo trim($rowOptionspost['optionName']);
                            }
                          }
                          ?>
                        </span>
                        <a
                          href="<?php echo $fullurl; ?>preview-project.html?projId=<?php echo encodeStr($rowProject['id']); ?>"><?php echo stripslashes($rowProject["projectTitle"]); ?></a>
                        <div class="posted">Posted: <span><?php echo date("d/m/Y", $rowProject["dateAdded"]); ?></span>
                          Start: <span><?php echo date("d/m/Y", strtotime($rowProject["proStartDate"])); ?></span></div>
                      </div>
                      <div class="prjct-location"><i class="fa fa-map-marker"
                          aria-hidden="true"></i><span><?php echo $rowProject["proCity"]; ?></span></div>
                      <div class="prjct-ownr">
                        <a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
                          class="ownr"><img
                            src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a>
                        <a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"
                          class="ownr-nm"><?php echo $userres['firstName']; ?>   <?php echo $userres['lastName']; ?></a>
                        <span><?php echo $userres['jobTitle']; ?> at <?php echo $userres['companyName']; ?></span>
                      </div>
                    </div>
                  </li>
                  <?php
                  $p++;
                }



                ?>

              </ul>
              <?php if ($p > 10) { ?>
                <div class="pagingnumbers"><?php echo $paging; ?></div>

              <?php }
              if ($no == 0) { ?>

                <div style="padding:20px; width:100%; text-align:center; float:left;">Sorry, we didn't find any internship
                  with these search terms.</div>

              <?php } ?>
            </div>
          </div>



        </div>


      </div>
    </div>
    <?php include('footer.php'); ?>
  </div>

</body>

</html>