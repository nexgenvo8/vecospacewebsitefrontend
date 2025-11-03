<?php
require("inc.php");
require("common.php");
require("website_security.php");
include '../config/config.php';



//----Page Settings-----
//$type="partner";
$pagetitle = "Users";
//$backpage = "manage_country.php";
$targetpage = "subscription_list.php";
$tableName = "userMaster";
//$addeditpage = "add_country.php";
$limit = 100;

//----change status-----

if ($_REQUEST['status'] != "" && $_GET['unino'] == $_SESSION["cust_session_token"] . "_console") {
  $id = base64_decode($_REQUEST['id']);
  $status = $_REQUEST['status'];

  $sql_ins = "update " . $tableName . " set activeYN='$status' where userId = " . $id . "";
  mysql_query($sql_ins) or die(mysql_error());

}


if ($_REQUEST['makeAdmin'] != "" && $_GET['unino'] == $_SESSION["cust_session_token"] . "_console") {
  $id = base64_decode($_REQUEST['id']);
  $makeAdmin = $_REQUEST['makeAdmin'];

  $sql_ins = "update " . $tableName . " set makeAdmin='$makeAdmin' where userId = " . $id . "";
  mysql_query($sql_ins) or die(mysql_error());

  $queryadmin = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " where  1 and userAccountCloseStatus=0 and userId='" . $id . "' order by userId desc ";
  $queryResult = mysql_fetch_array(mysql_query($queryadmin));


  if ($makeAdmin == 1) {
    $sql_ins = "insert into wfs_admin set name='" . $queryResult['firstName'] . ' ' . $queryResult['lastName'] . "',company='" . $queryResult['firstName'] . ' ' . $queryResult['lastName'] . "',email='" . $queryResult['email'] . "',username='" . $queryResult['email'] . "',password='" . $queryResult['password'] . "'";
    mysql_query($sql_ins) or die(mysql_error());
  } else {

    $sql_del = "delete from wfs_admin where username='" . $queryResult['email'] . "'";
    mysql_query($sql_del) or die(mysql_error());

  }


}


/*********login token start**********/
$session_token = rand(100000000000, 999999999999);
$_SESSION["cust_session_token"] = $session_token;
$actionId = '_console';
/*********login token end**********/
?>
<!DOCTYPE html
  PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Manage <?php echo $pagetitle; ?> - <?php echo $profile['company']; ?></title>
  <link href="css/main.css" rel="stylesheet" type="text/css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
    integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script type="text/javascript" src="js/jquery-1.6.js"></script>
  <script type="text/javascript" src="js/ddaccordion.js"></script>
  <script type="text/javascript" src="js/js.js"></script>
</head>


</head>

<body id="leftbgblack">
  <?php include "header.php"; ?>
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td width="9%" align="left" valign="top" style="width:176px;"> <?php include "left.php"; ?> </td>
      <td width="91%" align="left" valign="top">

        <div class="innerouter">
          <div class="innertitlebox">
            <table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="616">
                  <h3>Manage <?php echo $pagetitle; ?></h3>
                </td>
                <td width="355" align="right">&nbsp; </td>
                <td width="150" align="right" style="width:150px;"><em><strong>
                      <?php

                      if ($_GET['searchkeywords'] != '') {

                        $a = explode(' ', $_GET['searchkeywords']);
                        $firstName = trim($a[0]);
                        if ($a[1] != "") {
                          $lastName = trim($a[1]);
                          $lstnamequery = 'or lastName like  ' % ". $lastName ." % '';
                        }


                        $searchname = "and (firstName like  '%" . $firstName . "%' '" . $lstnamequery . "' or email like  '%" . trim($_REQUEST['searchkeywords']) . "%')";

                      }

                      if ($_GET['userType'] != '') {
                        $userQuery = "and userstype='" . $_GET['userType'] . "'";
                      }

                      $classlist = 1;

                      $query = "SELECT COUNT(*) as num FROM " . _USERS_MASTER_TABLE_ . " where  1 and userAccountCloseStatus=0 " . $userQuery . " " . $searchname . " order by userId desc ";

                      $total_pages = mysql_fetch_array(mysql_query($query));

                      echo $total_pages = $total_pages[num];


                      $stages = 3;

                      $page = mysql_escape_string($_GET['page']);

                      if ($page) {

                        $start = ($page - 1) * $limit;

                      } else {

                        $start = 0;

                      }


                      // Get page data
                      
                      $query1 = "SELECT * FROM " . _USERS_MASTER_TABLE_ . " where  1 and userAccountCloseStatus=0 " . $userQuery . " " . $searchname . " order by userId desc LIMIT $start, $limit";

                      $result = mysql_query($query1);


                      // Initial page num setup
                      
                      if ($page == 0) {
                        $page = 1;
                      }

                      $prev = $page - 1;

                      $next = $page + 1;

                      $lastpage = ceil($total_pages / $limit);

                      $LastPagem1 = $lastpage - 1;



                      $paginate = '';

                      if ($lastpage > 1) {






                        $paginate .= "<div class='paginate'>";

                        // Previous
                      
                        if ($page > 1) {

                          $paginate .= "<a href='$targetpage?page=$prev'>previous</a>";

                        } else {

                          $paginate .= "<span class='disabled'>previous</span>";
                        }


                        // Pages
                      
                        if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
                        {

                          for ($counter = 1; $counter <= $lastpage; $counter++) {

                            if ($counter == $page) {

                              $paginate .= "<span class='current'>$counter</span>";

                            } else {
                              $searchkeywordsdata = $_GET['searchkeywords'];
                              $userTypedata = $_GET['userType'];
                              $paginate .= "<a href='$targetpage?page=$counter&searchkeywords=$searchkeywordsdata&userType=$userTypedata'>$counter</a>";

                            }

                          }

                        } elseif ($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
                        {

                          // Beginning only hide later pages
                      
                          if ($page < 1 + ($stages * 2)) {

                            for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {

                              if ($counter == $page) {

                                $paginate .= "<span class='current'>$counter</span>";

                              } else {

                                $paginate .= "<a href='$targetpage?page=$counter'>$counter</a>";
                              }

                            }

                            $paginate .= "...";

                            $paginate .= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";

                            $paginate .= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";

                          }

                          // Middle hide some front and some back
                          elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {

                            $paginate .= "<a href='$targetpage?page=1'>1</a>";

                            $paginate .= "<a href='$targetpage?page=2'>2</a>";

                            $paginate .= "...";

                            for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {

                              if ($counter == $page) {

                                $paginate .= "<span class='current'>$counter</span>";

                              } else {

                                $paginate .= "<a href='$targetpage?page=$counter'>$counter</a>";
                              }

                            }

                            $paginate .= "...";

                            $paginate .= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";

                            $paginate .= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";

                          }

                          // End only hide early pages
                          else {

                            $paginate .= "<a href='$targetpage?page=1'>1</a>";

                            $paginate .= "<a href='$targetpage?page=2'>2</a>";

                            $paginate .= "...";

                            for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {

                              if ($counter == $page) {

                                $paginate .= "<span class='current'>$counter</span>";

                              } else {

                                $paginate .= "<a href='$targetpage?page=$counter'>$counter</a>";
                              }

                            }

                          }

                        }



                        // Next
                      
                        if ($page < $counter - 1) {

                          $paginate .= "<a href='$targetpage?page=$next'>next</a>";

                        } else {

                          $paginate .= "<span class='disabled'>next</span>";

                        }



                        $paginate .= "</div>";


                      }

                      ?>
                    </strong> items </em></td>
              </tr>
            </table>

          </div>
          <div class="loading" id="globalpageloding" style="display:none;">Please Wait Working...</div>
          <?php if ($_REQUEST['action'] == "add") { ?>
            <div class="successmsg" id="wrongloginclick" style="display:block;">Data Imported Successfully </div>
          <?php } ?>
          <?php if ($_REQUEST['action'] == "edit") { ?>
            <div class="successmsg" id="wrongloginclick" style="display:block;">Update Successfully </div><?php } ?>
          <?php if ($_REQUEST['action'] == "dlt") { ?>
            <div class="successmsg" id="wrongloginclick" style="display:block;">Deleted Successfully </div><?php } ?>


          <form action="subscription_list.php" method="get">

            <div class="srchfcontct">

              <div class="srch-field">
                <input type="text" name="searchkeywords" id="searchkeywords" maxlength="60"
                  placeholder="Enter name or email address" autocomplete="off"
                  value="<?php echo $_REQUEST['searchkeywords']; ?>">

              </div>

              <div class="srch-field">
                <select name="userType" id="userType">
                  <option value="" <?php if ($_GET['userType'] == "") { ?> selected="selected" <?php } ?>>All Users
                  </option>
                  <option value="1" <?php if ($_GET['userType'] == 1) { ?> selected="selected" <?php } ?>>Student</option>
                  <option value="2" <?php if ($_GET['userType'] == 2) { ?> selected="selected" <?php } ?>>Faculty</option>
                  <option value="3" <?php if ($_GET['userType'] == 3) { ?> selected="selected" <?php } ?>>Alumni</option>
                  <option value="4" <?php if ($_GET['userType'] == 4) { ?> selected="selected" <?php } ?>>Industry
                    Professional</option>
                  <option value="5" <?php if ($_GET['userType'] == 5) { ?> selected="selected" <?php } ?>>Career Enhancer
                    /
                    Service Provider</option>
                  <option value="0" <?php if ($_GET['userType'] == 0 && $_GET['userType'] != "") { ?> selected="selected"
                    <?php } ?>>Not Yet Selected</option>
                </select>
              </div>

              <div class="srch-field">
                <button type="submit">Search</button>
              </div>
            </div>

          </form>

          <?php

          $a = "SELECT userId FROM " . _USERS_MASTER_TABLE_ . " where  1 and userAccountCloseStatus=0 and  userstype=1 " . $userQuery . " " . $searchname . "";

          $totalStudents = mysql_num_rows(mysql_query($a));


          $b = "SELECT userId FROM " . _USERS_MASTER_TABLE_ . " where  1 and userAccountCloseStatus=0 and userstype=2 " . $userQuery . " " . $searchname . "";

          $totalFaculty = mysql_num_rows(mysql_query($b));


          $c = "SELECT userId FROM " . _USERS_MASTER_TABLE_ . " where  1 and userAccountCloseStatus=0 and userstype=3 " . $userQuery . " " . $searchname . "";

          $totalAlumni = mysql_num_rows(mysql_query($c));


          $d = "SELECT userId FROM " . _USERS_MASTER_TABLE_ . " where  1 and userAccountCloseStatus=0 and userstype=4 " . $userQuery . " " . $searchname . "";

          $totalIndustry = mysql_num_rows(mysql_query($d));


          $e = "SELECT userId FROM " . _USERS_MASTER_TABLE_ . " where  1 and userAccountCloseStatus=0 and userstype=5 " . $userQuery . " " . $searchname . "";

          $totalEnhancer = mysql_num_rows(mysql_query($e));


          $f = "SELECT userId FROM " . _USERS_MASTER_TABLE_ . " where  1 and userAccountCloseStatus=0 and userstype=0 " . $userQuery . " " . $searchname . "";

          $totalnotyetselected = mysql_num_rows(mysql_query($f));

          ?>

          <form action="" method="post">
            <div class="optionsec">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" align="left" valign="middle">

                    <div style=" width:100%; display:block;">
                      <div class="box-div">
                        <div class="color-box"
                          style="padding:10px; color:#fff; font-size:12px; background-color:#26A69A;border-left: 4px solid #ececec;border-radius: 4px; overflow: hidden; height:60px;">
                          <div style="font-size:20px; font-weight:600;">
                            <div align="center"><?php echo $totalStudents; ?></div>
                          </div>
                          <div style="font-size:12px; font-weight:500;">
                            <div align="center">Students</div>
                          </div>
                        </div>
                      </div>
                      <div class="box-div">
                        <div class="color-box"
                          style="padding:10px; color:#fff; font-size:12px; background-color:#2ca1cc;border-left: 4px solid #ececec;border-radius: 4px; overflow: hidden; height:60px;">
                          <div style="font-size:20px; font-weight:600;">
                            <div align="center"><?php echo $totalFaculty; ?></div>
                          </div>
                          <div style="font-size:12px; font-weight:500;">
                            <div align="center">Faculty</div>
                          </div>
                        </div>
                      </div>
                      <div class="box-div">
                        <div class="color-box"
                          style="padding:10px; color:#fff; font-size:12px; background-color:#9466be;border-left: 4px solid #ececec;border-radius: 4px; overflow: hidden;height:60px;">
                          <div style="font-size:20px; font-weight:600;">
                            <div align="center"><?php echo $totalAlumni; ?></div>
                          </div>
                          <div style="font-size:12px; font-weight:500;">
                            <div align="center">Alumni</div>
                          </div>
                        </div>
                      </div>

                      <div class="box-div">
                        <div class="color-box"
                          style="padding:10px; color:#fff; font-size:12px; background-color:#82b767;border-left: 4px solid #ececec;border-radius: 4px; overflow: hidden;height:60px;">
                          <div style="font-size:20px; font-weight:600;">
                            <div align="center"><?php echo $totalIndustry; ?></div>
                          </div>
                          <div style="font-size:12px; font-weight:500;">
                            <div align="center">Industry Professional</div>
                          </div>
                        </div>
                      </div>

                      <div class="box-div">
                        <div class="color-box"
                          style="padding:10px; color:#fff; font-size:12px; background-color:#03c28d;border-left: 4px solid #ececec;border-radius: 4px; overflow: hidden;height:60px;">
                          <div style="font-size:20px; font-weight:600;">
                            <div align="center"><?php echo $totalEnhancer; ?></div>
                          </div>
                          <div style="font-size:12px; font-weight:500;">
                            <div align="center">Career Enhancer / Service Provider</div>
                          </div>
                        </div>
                      </div>

                      <div class="box-div">
                        <div class="color-box"
                          style="padding:10px; color:#fff; font-size:12px; background-color:#c75858;border-left: 4px solid #ececec;border-radius: 4px; overflow: hidden;height:60px;">
                          <div style="font-size:20px; font-weight:600;">
                            <div align="center"><?php echo $totalnotyetselected; ?></div>
                          </div>
                          <div style="font-size:12px; font-weight:500;">
                            <div align="center" style="width:85%; margin:auto;">Not Yet Selected</div>
                          </div>
                        </div>
                      </div>




                    </div>


                  </td>

                  <style>
                    .srchfcontct {
                      float: left;
                      width: 100%;
                      border-radius: 2px;
                      background-color: #fff;
                      padding: 0px;
                      margin-bottom: 16px;
                    }

                    .srch-field {
                      width: 20%;
                      float: left;
                      overflow: hidden;
                      position: relative;
                      margin-right: 10px;
                    }

                    .srch-field input,
                    select {
                      width: 100%;
                      border: solid 1px #e7e7e7 !important;
                      font-size: 12px !important;
                      padding: 9px !important;
                      border-radius: 2px;
                      box-sizing: border-box;
                      height: 35px;
                    }

                    .srch-field button {
                      position: relative;
                      padding: 11px 20px;
                      border: 0;
                      height: 35px;
                      background-color: #860E66;
                      color: #fff;
                      border-radius: 0px 3px 3px 0;
                      box-sizing: border-box;
                      cursor: pointer;
                    }

                    .box-div {
                      width: 16.6%;
                      float: left;
                      margin: 0px;
                      margin-bottom: 10px;
                    }
                  </style>
                </tr>
              </table>
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="100%" align="right" valign="middle">
                    <div style=" overflow:hidden; text-align:right;">
                      <?php echo $paginate; ?>
                    </div>
                  </td>
                </tr>
              </table>
            </div>
            <div class="listingbox" style="position:relative; min-height:300px;">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <!--<td width="6%" align="left" valign="top" class="listingheaddr">Select</td>-->
                  <td width="6%" align="left" valign="top" class="listingheaddr">S. N.</td>
                  <!--<td width="2%" align="center" valign="top" class="listingheaddr"><input type="checkbox" id="chkAll" /></td>-->
                  <td width="14%" align="left" valign="top" class="listingheaddr">Name</td>
                  <td width="14%" align="left" valign="top" class="listingheaddr">Type</td>
                  <td width="14%" align="left" valign="top" class="listingheaddr">Course</td>
                  <td width="14%" align="left" valign="top" class="listingheaddr">Branch</td>
                  <td width="14%" align="left" valign="top" class="listingheaddr">Year&nbsp;Of&nbsp;Passing </td>
                  <td width="16%" align="left" valign="top" class="listingheaddr">Industry</td>
                  <!--<td width="18%" align="left" valign="top" class="listingheaddr">Job Title </td>-->
                  <td width="23%" align="left" valign="top" class="listingheaddr">Email id</td>
                  <td width="" align="left" valign="top" class="listingheaddr">Mobile</td>
                  <td width="10%" class="listingheaddr" align="left" valign="top">Resend Email</td>
                  <td width="7%" align="center" valign="top" class="listingheaddr"> Date </td>
                  <td width="7%" align="center" valign="top" class="listingheaddr">Status</td>
                  <td align="center" valign="top" class="listingheaddr">Action</td>
                  <?php if ($querywfs['id'] == 1) { ?>
                    <td width="7%" align="center" valign="top" class="listingheaddr">Admin</td>
                  <?php } ?>
                  <td width="5%" align="center" valign="top" class="listingheaddr">Open</td>
                </tr>
                <?php while ($res_post = mysql_fetch_array($result)) { ?>
                  <tr <?php if ($classlist == 1) { ?>style="background-color:#f7f7f7;" <?php } else { ?>style="background-color:#FFFFFF;" <?php } ?>>
                    <!--<td align="left" valign="top" class="graylist">
            <input type="checkbox" name="check_list[]" class="chk" id="check_list[]"  value="<?php echo $res_post['userId']; ?>" />       </td>-->
                    <td align="left" valign="top" class="graylist"><?php echo $start = $start + 1; ?></td>

                    <td align="left" valign="middle" class="graylist"><?php echo stripslashes($res_post['firstName']); ?>
                      <?php echo stripslashes($res_post['lastName']); ?>
                    </td>
                    <td align="left" valign="middle" class="graylist">

                      <?php
                      if ($res_post['userstype'] == 1) {
                        echo "Student";
                      } elseif ($res_post['userstype'] == 2) {
                        echo "Faculty";
                      } elseif ($res_post['userstype'] == 3) {
                        echo "Alumni";
                      } elseif ($res_post['userstype'] == 4) {
                        echo "Industry Professional";
                      } elseif ($res_post['userstype'] == 5) {
                        echo "Career Enhancer / Service Provider";
                      } else {
                        echo "Not Yet Selected";
                      }


                      ?>
                    </td>
                    <td align="left" valign="middle" class="graylist">
                      <?php echo stripslashes($res_post['coursename']); ?>
                    </td>
                    <td align="left" valign="middle" class="graylist">
                      <?php echo stripslashes($res_post['departmentname']); ?>
                    </td>
                    <td align="left" valign="middle" class="graylist">
                      <?php echo stripslashes($res_post['passingyear']); ?>
                    </td>
                    <td align="left" valign="middle" class="graylist">
                      <?php $re = "select * from " . _OPTION_MASTER_TABLE_ . "  where id='" . $res_post['industryId'] . "'";
                      $re2 = mysql_query($re) or die(mysql_error());
                      $industry_res = mysql_fetch_array($re2);
                      echo $industry_res['optionName'];
                      ?>
                    </td>
                    <!--<td align="left" valign="middle" class="graylist"><?php echo stripslashes($res_post['jobTitle']); ?></td>-->
                    <td align="left" valign="middle" class="graylist">
                      <?php echo stripslashes($res_post['email']); ?>
                      <?php $ee = stripslashes(trim($res_post['email'])); ?>
                    </td>
                    <td align="center" valign="middle" class="graylist"><?php echo $res_post['mobile']; ?></td>
                    <td align="left" valign="middle" class="graylist"><input type="button" class="gradiantbtn"
                        id="sendbutton<?php echo $res_post['userId']; ?>"
                        onclick="funcResendEmail('<?php echo $res_post['userId']; ?>');" value="Resend Email" /></td>
                    <td align="center" valign="middle" class="graylist">
                      <?php echo date('m/d/Y H:i:s', $res_post['regDate']); ?>
                    </td>
                    <td align="center" valign="middle" class="graylist"><?php if ($res_post['activeYN'] == 'Y') { ?>
                        <a href="<?php echo $backpage; ?>?status=N&id=<?php echo base64_encode($res_post['userId']); ?>&page=<?php echo $_GET['page']; ?>&unino=<?php echo $_SESSION["cust_session_token"] . "_console"; ?>"
                          onclick="globalloading();"><img src="images/unlock.png" width="30" border="0" /></a>
                      <?php } else { ?><a
                          href="<?php echo $backpage; ?>?status=Y&id=<?php echo base64_encode($res_post['userId']); ?>&page=<?php echo $_GET['page']; ?>&unino=<?php echo $_SESSION["cust_session_token"] . "_console"; ?>"
                          onclick="globalloading();"><img src="images/lock.png" /></a><?php } ?>
                    </td>
                    <?php if ($querywfs['id'] == 1) { ?>
                      <td align="center" valign="middle" class="graylist"><?php if (1 == '1') { ?>
                          <a href="<?php echo $backpage; ?>?makeAdmin=0&id=<?php echo base64_encode($res_post['userId']); ?>&unino=<?php echo $_SESSION["cust_session_token"] . "_console"; ?>"
                            onclick="globalloading();"><img src="images/unlock.png" width="30" border="0" /></a>
                        <?php } else { ?><a
                            href="<?php echo $backpage; ?>?makeAdmin=1&id=<?php echo base64_encode($res_post['userId']); ?>&unino=<?php echo $_SESSION["cust_session_token"] . "_console"; ?>"
                            onclick="globalloading();"><img src="images/lock.png" /></a><?php } ?>
                      </td>
                    <?php } ?>
                    <td class="graylist" align="center">
                      <button type="button" class="gradiantbtn"
                        onclick='openEditModal(<?php echo json_encode($res_post); ?>)'>
                        Edit
                      </button>
                    </td>


                    <td align="center" valign="top" class="graylist"><a
                        href="<?php echo $websiteurl; ?>profile/<?php echo encodeStr($res_post['userId']); ?>/<?php echo $res_post['userurl']; ?>.html"
                        target="_blank"><img src="images/eye_inv.png" alt="View" width="30" height="32" border="0" /></a>
                    </td>

                  </tr>
                  <?php $classlist = $classlist + 1;
                  if ($classlist == 3) {
                    $classlist = 1;
                  }
                } ?>
              </table>

              <?php
              $conn = mysqli_connect(_DATABASE_HOST_, _DATABASE_USERNAME_, _DATABASE_PASSWORD_, _DATABASE_NAME_);
              ?>
              <!-- Edit User Modal -->
              <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">

                    <div class="modal-header">
                      <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <!-- Form directly posts to update_user.php -->
                      <form id="editUserForm" method="POST" action="">
                        <input type="hidden" id="edit_userId" name="userId">

                        <!-- First Name -->
                        <div class="mb-3">
                          <label for="edit_firstName" class="form-label">First Name</label>
                          <input type="text" id="edit_firstName" name="firstName" class="form-control">
                        </div>

                        <!-- Last Name -->
                        <div class="mb-3">
                          <label for="edit_lastName" class="form-label">Last Name</label>
                          <input type="text" id="edit_lastName" name="lastName" class="form-control">
                        </div>

                        <!-- Passing Year -->
                        <div class="col-6 col-md-4" id="stpassingyeardiv" style="margin-bottom: 10px;">
                          <label for="edit_passingYear" class="form-label">Passing Year</label>
                          <select class="form-select" name="passingYear" id="edit_passingYear" required>
                            <option selected value="">Passing Year</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                            <?php
                            $currentYear = date("Y", strtotime('+1 years'));
                            $endYear = date("Y", strtotime('+5 years'));
                            while ($currentYear <= $endYear) {
                              $selected = ($currentYear == '2025') ? 'selected' : '';
                              echo "<option value='{$currentYear}' {$selected}>{$currentYear}</option>";
                              $currentYear++;
                            }
                            ?>
                          </select>
                        </div <!-- Course Name -->
                        <div class="mb-3">
                          <label for="edit_courseName" class="form-label">Course Name</label>
                          <select id="edit_courseName" name="courseName" class="form-select" required>
                            <option value="">Select Course</option>
                            <?php

                            if (!$conn) {
                            }
                            // Fetch courses
                            $sqlCourses = "SELECT * FROM courseMaster WHERE status=1 ORDER BY course_name";
                            $resCourses = mysqli_query($conn, $sqlCourses);

                            if ($resCourses) {
                              while ($rowCourse = mysqli_fetch_assoc($resCourses)) {
                                $courseName = htmlspecialchars(trim($rowCourse['course_name']));
                                echo "<option value='{$courseName}'>{$courseName}</option>";
                              }
                            }

                            // Close connection
                            mysqli_close($conn);
                            ?>
                          </select>
                        </div>

                        <!-- Department Name -->
                        <div class="mb-3">
                          <label for="edit_departmentName" class="form-label">Department Name</label>
                          <select id="edit_departmentName" name="departmentName" class="form-select" required>
                            <option value="">Select Department</option>
                            <?php

                            // Database connection
                            $conn = mysqli_connect(_DATABASE_HOST_, _DATABASE_USERNAME_, _DATABASE_PASSWORD_, _DATABASE_NAME_);
                            if (!$conn) {
                            }
                            // Fetch departments
                            $sqlDepartments = "SELECT * FROM departmentMaster WHERE status=1  order by department_name";
                            $resDepartments = mysqli_query($conn, $sqlDepartments);

                            if ($resDepartments) {
                              while ($rowDept = mysqli_fetch_assoc($resDepartments)) {
                                $deptName = htmlspecialchars(trim($rowDept['department_name']));
                                echo "<option value='{$deptName}'>{$deptName}</option>";
                              }
                            }

                            // Close connection (optional)
                            mysqli_close($conn);
                            ?>
                          </select>
                        </div>


                        <!-- User Type -->
                        <div class="mb-3">
                          <label for="edit_userType" class="form-label">User Type</label>
                          <select id="edit_userType" name="userType" class="form-select">
                            <option value="1">Student</option>
                            <option value="2">Faculty</option>
                            <option value="3">Alumni</option>
                            <option value="4">Industry Professional</option>
                            <option value="5">Career Enhancer / Service Provider</option>
                          </select>
                        </div>

                        <!-- Submit Button inside Form -->
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-primary" name="submit">Update</button>
                        </div>

                      </form>
                    </div>

                  </div>
                </div>
              </div>


              <div id="confdlt" style="display:none;">
                <div align="left" style="font-size:18px; line-height:25px; margin-bottom:10px;"><img
                    src="images/-trash.png" width="50" height="50" style="float:left; padding-right:10px;" />Do you want
                  to permanently
                  delete the selected items?</div>
                <div style="text-align:center;">
                  <input name="Submit2" type="submit" class="redbutton" value="  Yes  " onclick="globalloading();" />
                  <input name="Submit22" type="button" class="gradiantbtn" value="  No  "
                    onclick="closeconfirmdlt();" />
                </div>

              </div>
              <?php if ($total_pages == 0) { ?>
                <div style="padding:10px; background-color:#FFFFFF; text-align:center; color:#CCCCCC;"><em>No Item</em>
                </div>
              <?php } ?>
            </div>


            <div class="optionsec">
              <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                  <td width="62%" align="left" valign="middle">
                    <!--<a href="<?php echo $addeditpage; ?>?backpage=<?php echo $backpage; ?>&pagetitle=<?php echo $pagetitle; ?>"  onclick="globalloading();" ><input type="button" name="Submit" value="Add New" class="greenbtn"  /></a><input type="button" name="Submit3" value="Delete Selected Items" class="redbutton" onclick="confirmdlt();" />-->
                  </td>
                  <td width="38%" align="right" valign="middle">
                    <div style="  overflow:hidden; text-align:right;">
                      <?php echo $paginate; ?>
                    </div>
                  </td>
                </tr>
              </table>
            </div>


          </form>
        </div>

      </td>
    </tr>
  </table>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


  <script>
    function openEditModal(user) {
      document.getElementById('edit_userId').value = user.userId;
      document.getElementById('edit_firstName').value = user.firstName;
      document.getElementById('edit_lastName').value = user.lastName;
      document.getElementById('edit_courseName').value = user.coursename || '';
      document.getElementById('edit_departmentName').value = user.departmentname || '';
      document.getElementById('edit_userType').value = user.usertype || user.userstype || '1';
      document.getElementById('edit_passingYear').value = user.passingyear || ''; // Added passing year

      var myModal = new bootstrap.Modal(document.getElementById('editUserModal'));
      myModal.show();
    }
  </script>


  <?php
  if (isset($_POST['submit'])) {

    $id = $_POST['userId'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $courseName = $_POST['courseName'];
    $departmentName = $_POST['departmentName'];
    $userType = $_POST['userType'];
    $passingYear = $_POST['passingYear']; // Added passing year
  
    // Make values safe for query (if using old mysql_* functions)
    $firstName = mysql_real_escape_string($firstName);
    $lastName = mysql_real_escape_string($lastName);
    $courseName = mysql_real_escape_string($courseName);
    $departmentName = mysql_real_escape_string($departmentName);
    $userType = mysql_real_escape_string($userType);
    $passingYear = mysql_real_escape_string($passingYear); // Escape passing year
  
    // Update query
    $sql_ins = "UPDATE " . $tableName . " 
                SET firstname='$firstName',
                    lastname='$lastName',
                    coursename='$courseName',
                    departmentname='$departmentName',
                    userstype='$userType',
                    passingyear='$passingYear'
                WHERE userId = " . $id;

    mysql_query($sql_ins) or die(mysql_error());

    // Redirect after success
    header("Location: subscription_list.php?msg=success");
    exit;
  }
  ?>

  <script>
    function funcResendEmail(id) {
      $('#sendbutton' + id).val('Sending...');
      $('#sendbutton' + id).load("resendemail.php?id=" + id);
    }
  </script>


  <?php include "footer.php"; ?>
</body>

</html>