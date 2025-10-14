<?php
include_once('inc.php');

/*$url = 'https://www.connecwrk.com/view-sme-blog.html?postId=202581501';
$query = parse_url($url, PHP_URL_QUERY);
parse_str($query);
parse_str($query, $arr);
echo $query;  // postId=202581501&myId=13*/

$pageIndex = 7;
$pag = 1;
$aa = "SELECT * from noticeBoard WHERE id= " . decodeStr($_REQUEST["postId"]) . " ";
$res5 = mysqli_query($conn, $aa) or die(error_found(mysqli_error($conn)));
$articletext = mysqli_fetch_array($res5);


if ($articletext['id'] == '') {
  header("Location: " . $fullurl . "404error.html");
  exit();
}



?>
<!DOCTYPE html>
<html>

<head>
  <title><?php echo stripslashes(strip_tags($articletext['title'])); ?> - Notice - <?php echo $companNameTitle; ?>
  </title>
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
  <link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">
  <meta property="og:title"
    content="<?php echo htmlspecialchars(stripslashes(strip_tags($postTitle)), ENT_QUOTES, 'UTF-8'); ?>" />


  <meta property="og:site_name" content="<?php echo $fullurl; ?>" />
  <?php
  $postText = $articletext['postText'] ?? '';
  ?>
  <meta property="og:description"
    content="<?php echo htmlspecialchars(substr(stripslashes(strip_tags($postText)), 0, 250), ENT_QUOTES, 'UTF-8'); ?>" />

  <meta property="og:type" content="Article" />
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
          if ($mobile == 'y') {
          } else {
            echo 'nologin';
          }
        } ?>">

          <div class="artcle bx-shadow">
            <div class="cntr_cntnt popular-dtail">

              <h2><?php echo stripslashes(strip_tags($articletext['title'])); ?></h2>
              <div style="margin-bottom:15px; overflow:hidden; line-height:35px;">
                <div style="float:left; font-size:13px; color:#999999;">Published
                  <?php echo makedatetime($articletext["addeddate"]); ?>
                </div>
                <div style=" float:right;"><!-- Go to www.addthis.com/dashboard to customize your tools -->
                  <script type="text/javascript"
                    src="//s7.addthis.com/js/300/addthis_widget.js#pubid=imran190"></script>
                  <!-- Go to www.addthis.com/dashboard to customize your tools -->
                  <div class="addthis_inline_share_toolbox_tnos"></div>
                </div>
                <div style="float:right; font-size:13px; color:#999999;">
                  <!--Published by  <a href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userresarticles['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes($userresarticles['firstName'] . ' ' . $userresarticles['lastName']); ?></a>-->
                </div>
              </div>

              <div class="detail-cntnt">

                <p><?php echo stripslashes($articletext['details']); ?></p>
              </div>











            </div>

            <div class="hm_right_sec" style="width: 320px;">


              <!--<?php include('rightarticletrivia.php'); ?>-->
            </div>

          </div>

        </div>
      </div>
    </div>
  </div>


  </div>
  </div>
  </div>
  <?php include('footer.php'); ?>
  </div>

  <script type="text/javascript">
    function reloadPage() {
      location.reload(true);
    }



    $('.more-btn a.mr').click(function (event) {
      event.stopPropagation();
    });

    $('html').click(function () {
      $('.more-list').hide();
    });
    $('.more-btn a.mr').click(function (event) {
      $('.more-list').toggle();
    });



    $(window).scroll(function () {
      if ($(this).scrollTop() > 150) {
        $(".write-cont").addClass("fixed");
      }
      else {
        $(".write-cont").removeClass("fixed");
      }
    });
  </script>
  <div id="actionpostdivs" style=" display:none;"></div>
  <iframe name="actionfrm" id="actionfrm" style="display:none;"></iframe>


  <div style="display:none;">

    <div class="timlist" id="<?php echo decodeStr($_REQUEST["postId"]); ?>">
      <div class="hedr">
        <div class="prfl_img"> <a
            href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userresarticles['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
              src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a> </div>
        <div class="hdr_right"><a
            href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userresarticles['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes($userresarticles['firstName'] . ' ' . $userresarticles['lastName']); ?></a>
          <span class="timelinecontantsubline"></span>
          <label class="time"><?php echo $user_jobTitle; ?> at <?php echo $user_companyName; ?></label>
          <label class="time">Posted an article <?php echo makedatetime($articletext["dateAdded"]); ?></label>
        </div>
      </div>



      <div id="txtarea<?php echo decodeStr(trim($_REQUEST['postId'])); ?>">
        <div style=" margin-bottom:10px;">
          <div style="font-size:15px; font-weight:bold; margin-bottom:5px;"><a
              href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo $_REQUEST["postId"]; ?>"><?php echo stripslashes(trim($articletext["postTitle"])); ?></a>
          </div>
          <div class="timelinelistingcontant">
            <?php echo substr(strip_tags(stripslashes(trim($articletext["postText"]))), 0, 250); ?>...<a
              href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo $_REQUEST["postId"]; ?>">read more</a>
          </div>
        </div>
        <?php

        $a = "";
        $a = "select * from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $articletext['id'] . "";
        $b = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $a);
        if ($b) {
          $numrows = mysqli_num_rows($b);
          $width = '100%';

          while ($rowimg = mysqli_fetch_array($b)) {
            ?>
            <img src="<?php echo $fullurl; ?>uploads/<?php echo $rowimg['imageName']; ?>"
              style="position:inline-block; cursor:pointer;"
              onClick="countpostview('<?php echo encodeStr($row['postId']); ?>');imagepopupmain('<?php echo $rowimg['id']; ?>');">
          <?php }
        }


        ?>
        <div class="timeline-img"> </div>
      </div>


    </div>

  </div>
</body>

</html>