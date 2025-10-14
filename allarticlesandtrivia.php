<?php
include_once('inc.php');
$pageIndex = 7;

?>
<!DOCTYPE html>
<html>

<head>
  <title>Article and trivia - <?php echo $companNameTitle; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">

  <link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
  <script src="<?php echo $fullurl; ?>js/main.js"></script>

  <style type="text/css">
    @media only screen and (min-width: 800px) {
      .left_menu_sec {
        width: 60px;
        float: left;
        overflow: inherit;
      }

      .menu {
        width: 100%;
      }

      ul.nav_list li a span.tltp {
        display: none;
      }

      ul.nav_list li a i.micon {
        float: none !important;
        margin: auto;
      }

      ul.nav_list li a {
        overflow: inherit;
      }

      ul.nav_list li a:hover .tltp {
        display: inline-table;
        position: absolute;
        left: 100%;
        z-index: 9999;
        background-color: #000;
        line-height: 20px;
        top: 10px !important;
        padding: 0px 10px;
        white-space: nowrap;
        font-size: 13px;
        border-radius: 0 2px 2px 0;
      }

      ul.nav_list li a .coming {
        display: none;
      }

      ul.nav_list li.user .connctn {
        display: none;
      }

      ul.nav_list li.user .img {
        width: 40px;
      }

      ul.nav_list li.user .usr-right {
        display: none;
      }

      ul.nav_list li {
        padding-bottom: 5px;
      }

      ul.nav_list li:last-child {
        padding-bottom: 0;
      }
    }

    .my-message {
      padding: 0 !important
    }

    .center_content {
      float: right;
      width: 100%;
      padding-left: 73px;
    }

    .chat_list {
      width: 200px;
    }

    .chat_box {
      width: 62%;
    }

    .chat_list.mmbr {
      float: right;
    }

    .chat_list.mmbr {
      width: 207px;
      border-left: 0;
    }

    .chats {
      overflow: auto;
    }
  </style>
  <script type="text/javascript">
    $(window).scroll(function () {
      if ($(this).scrollTop() > 150) {
        $(".write-cont").addClass("fixed");
      }
      else {
        $(".write-cont").removeClass("fixed");
      }
    });
  </script>
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
          <div class="write-cont">
            <h2>Articles and Trivia</h2>
            <a href="<?php echo $fullurl; ?>post-article.html" class="writ-btn">Write an article</a>
          </div>

          <div class="trivia-shdow">
            <div class="artcle">
              <div class="cntr_cntnt popular">
                <div class="populr-artcl2">

                  <?php

                  $no = 1;
                  $select = '';
                  $where = '';
                  $rs = '';
                  $page = ($_GET['page']);
                  $limit = '12';
                  $select = 'a.*,b.imageName';
                  $where = ' a INNER JOIN ' . _IMAGE_MASTER_TABLE_ . ' b ON a.id=b.postId WHERE b.imageName!="" and a.postType=3 and b.imageType=3 and a.articleBlogStatus=0 ORDER BY a.id DESC ';
                  $targetpage = $fullurl . 'all-articles-and-trivia.html?records=' . $limit . '&';
                  $rs = GetRecordList($select, _SHAREANDUPDATES_TABLE_, $where, $limit, $page, $targetpage);
                  $totalentry = $rs[1];
                  $paging = $rs[2];
                  while ($rowViewArticle = mysqli_fetch_array($rs[0])) {


                    $a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowViewArticle["userId"] . "";
                    $b = mysqli_query($conn, $a) or die(mysqli_error($conn));
                    $userres = mysqli_fetch_array($b);

                    if ($rowViewArticle['imageName'] != '') {
                      $articlephotoltst = $rowViewArticle['imageName'];
                    } else {
                      $articlephotoltst = 'articleicon.png';
                    }

                    ?>
                    <a
                      href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowViewArticle['id']); ?>">
                      <div class="artcle-box-long">
                        <div class="image-box"
                          style="background-image: url(<?php echo $fullurl; ?>uploads/<?php echo $articlephotoltst; ?>);">
                        </div>
                        <div class="long-contnt">

                          <?php echo (strip_tags(stripslashes($rowViewArticle["postTitle"]))); ?>
                          <div class="long-cont"><?php echo (strip_tags(stripslashes($rowViewArticle["postText"]))); ?>
                          </div>
                          <div class="long-name">by <?php echo stripslashes(trim($userres["firstName"])); ?>
                            <?php echo stripslashes(trim($userres["lastName"])); ?> -
                            <?php echo makedatetime($rowViewArticle["dateAdded"]); ?>
                          </div>
                        </div>
                      </div>
                    </a>
                  <?php } ?>

                  <div style="margin-top:20px; text-align:left;">
                    <div class="pagingnumbers"><?php echo $paging; ?></div>
                  </div>

                </div>




              </div>
              <!--<div class="hm_right_sec" style="width: 320px;padding-top: 10px;">
<div class="artcl-add">
  <img src="<?php echo $fullurl; ?>images/rightad.PNG">
</div>	
  <?php include('rightarticletrivia.php'); ?>
</div>-->
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

</body>

</html>