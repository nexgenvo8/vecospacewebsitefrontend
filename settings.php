<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$ps = 1;
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
              <ul class="setting_area_list">
                <li>
                  <dl>
                    <dt>E-mail address</dt>
                    <dd><?php echo $_SESSION['sessEmail']; ?> <a
                        onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=changeusremail','E-mail address');"
                        class="edit_btn" style="display:none;">Edit</a></dd>
                  </dl>
                </li>
                <li>
                  <dl>
                    <dt>Password</dt>
                    <dd>******** <a
                        onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=changepass','Change Password');"
                        class="edit_btn">Edit</a></dd>
                  </dl>
                </li>
                <li>
                  <dl>
                    <dt style="max-width:290px;width:40%;">Deactivate your account</dt>
                    <dd>&nbsp;<a
                        onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>common_popup_inner.php?type=closeuseraccount','Are you sure you want to deactivate your account?');"
                        class="edit_btn">Deactivate</a></dd>
                  </dl>
                </li>
                <li class="session">
                  <span class="subtitle">Your <?php echo $companNameTitle; ?> sessions</span>

                  <?php
                  $selectFields = [];
                  $whereFields = [];
                  $whereVals = [];
                  $n = 1;
                  $sqlOptions = "";
                  $sqlOptions = "SELECT * FROM " . _SESSION_MASTER_TABLE_ . " WHERE userId=" . $_SESSION["sessUserId"] . " order by id desc limit 0,10 ";
                  $resOptions = getRecords(_SESSION_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlOptions);
                  if ($resOptions) {
                    while ($rowOptions = mysqli_fetch_array($resOptions)) {

                      ?>
                      <div class="session_box <?php if ($n == 1) { ?>current<?php } ?>">
                        <span class="live">&nbsp;</span>
                        <?php if ($n == 1) { ?><label>Current session </label><?php } else { ?>
                          <?php if ($n == 2) { ?><label>Last access </label><?php }
                        } ?>
                        <span>Login from: <?php echo $rowOptions['loginFrom']; ?></span>
                        <span>Browser: <?php echo stripslashes($rowOptions['browser']); ?></span>
                        <span>IP: <?php echo $rowOptions['loginIp']; ?></span>
                        <span>Login on: <?php echo date('l j F Y  g:ia', $rowOptions['loginTime']); ?></span>
                      </div>
                      <?php
                      $n++;
                    }
                  }
                  ?>


                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php include('footer.php'); ?>
  </div>

</body>

</html>