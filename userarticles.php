<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session 
$pageIndex = 7;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$articlephoto = '';
$sqlTotalUserArticle = "";
$sqlTotalUserArticle = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE postTitle!=''  and postType=3 and userId=" . decodeStr($_REQUEST["id"]) . " ORDER BY viewStatus DESC ";
$resTotalUserArticle = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlTotalUserArticle);
if ($resTotalUserArticle) {
  $totalUserArticles = mysqli_num_rows($resTotalUserArticle);
}

$a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . decodeStr($_REQUEST["id"]) . "";
$b = mysqli_query($conn, $a) or die(mysqli_error($conn));
$userresarticles = mysqli_fetch_array($b);

$userphoto = '';
$friendnameurl = '';
$user_jobTitle = stripslashes(strip_tags($userresarticles['jobTitle']));
$user_companyName = stripslashes(strip_tags($userresarticles['companyName']));
$friendnameurl = $userresarticles['userurl'];

if ($userresarticles["profilePhoto"] != '') {
  $userphoto = $userresarticles["profilePhoto"];
} else {
  $userphoto = 'user-placeholder.jpg';
}
?>
<!DOCTYPE html>
<html>

<head>
  <title>Articles and Trivia - <?php echo $companNameTitle; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
  <link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
  <script src="<?php echo $fullurl; ?>js/main.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/smallnav.css">


</head>

<body>
  <div id="wrapper" class="active">
    <?php include('header.php'); ?>
    <div class="container main">

      <div class="home_container">
        <?php include('left-sidebar.php'); ?>
        <div class="center_content">
          <div class="write-cont">
            <h2>Articles and Trivia</h2>
            <a href="<?php echo $fullurl; ?>post-article.html" class="writ-btn">Write an article</a>
          </div>
          <div class="usrartcle">
            <div class="request-contct">
              <div class="rimg"> <a
                  href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userresarticles['userId']); ?>/<?php echo $friendnameurl; ?>.html">
                  <img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"> </a></div>
              <div class="reqst-rdtail">
                <div class="middl-nm">
                  <div class="left"> <a
                      href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userresarticles['userId']); ?>/<?php echo $friendnameurl; ?>.html"
                      class="nm"><?php echo stripslashes($userresarticles['firstName'] . ' ' . $userresarticles['lastName']); ?></a>
                    <span class="comp"><?php echo $user_jobTitle; ?> at <?php echo $user_companyName; ?></span>
                  </div>
                </div>
              </div>
            </div>

            <ul class="artcl-likes">
              <li>
                <h1> <?php echo $totalUserArticles; ?> </h1>
                <span>Articles</span>
              </li>
              <li>
                <h1>
                  <?php
                  $totaluserviews = 0; // initialize
                  
                  if ($totalUserArticles > 0) {
                    while ($rowTotalUserArticle3 = mysqli_fetch_array($resTotalUserArticle)) {
                      $totaluserviews += trim($rowTotalUserArticle3['viewStatus']);
                    }
                    echo $totaluserviews;
                  }


                  ?>
                </h1>
                <span>Views</span>
              </li>
              <li>
                <h1>
                  <?php
                  if ($totalUserArticles > 0) {
                    $totaluserlike = 0;

                    $aa2 = "";
                    $aa2 = "SELECT id from " . _LIKE_MASTER_TABLE_ . " WHERE postId IN(select id from " . _SHAREANDUPDATES_TABLE_ . " where userId=" . decodeStr($_REQUEST["id"]) . " and postType= 3)";
                    $res52 = mysqli_query($conn, $aa2);
                    $totaluserlike = mysqli_num_rows($res52);
                    echo $totaluserlike;
                  }

                  ?>
                </h1>
                <span>Likes</span>
              </li>
              <li>
                <h1>
                  <?php
                  if ($totalUserArticles > 0) {
                    $totalusercomment = 0;

                    $aa2 = "";
                    $aa2 = "SELECT id from " . _COMMENT_MASTER_TABLE_ . " WHERE postId IN(select id from " . _SHAREANDUPDATES_TABLE_ . " where userId=" . decodeStr($_REQUEST["id"]) . " and postType= 3)";
                    $res52 = mysqli_query($conn, $aa2);
                    $totalusercomment = mysqli_num_rows($res52);
                    echo $totalusercomment;
                  }

                  ?>
                </h1>
                <span>Comments</span>
              </li>
              <li>
                <h1><?php $aas5 = "SELECT id from " . _SHARE_MASTER_TABLE_ . " WHERE postId IN(select id from " . _SHAREANDUPDATES_TABLE_ . " where userId=" . decodeStr($_REQUEST["id"]) . " and postType= 3)";
                $res5s5 = mysqli_query($conn, $aas5);
                echo $totalpostshared1 = mysqli_num_rows($res5s5); ?></h1>
                <span>Shares</span>
              </li>
            </ul>

            <div class="ttl-artcls">
              <h2><?php echo stripslashes($userresarticles['firstName'] . ' ' . $userresarticles['lastName']); ?>'s
                Article
              </h2>
              <ul class="news-half">
                <?php
                $selectFields = [];
                $whereFields = [];
                $whereVals = [];
                $sqlTotalUserArticle = "";
                $sqlTotalUserArticle = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE postTitle!=''  and postType=3 and userId=" . decodeStr($_REQUEST["id"]) . " ORDER BY viewStatus DESC ";
                $resTotalUserArticle = getRecords(_SHAREANDUPDATES_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlTotalUserArticle);
                if ($resTotalUserArticle && mysqli_num_rows($resTotalUserArticle) > 0) {

                  while ($rowTotalUserArticle = mysqli_fetch_array($resTotalUserArticle)) {

                    $aimg = "SELECT * 
         FROM " . _IMAGE_MASTER_TABLE_ . " 
         WHERE postId = " . intval($rowTotalUserArticle['id']) . " 
           AND imageType = 3";

                    $bimg = mysqli_query($conn, $aimg);

                    if ($bimg && mysqli_num_rows($bimg) > 0) {
                      $rowimg = mysqli_fetch_array($bimg);

                      if (!empty($rowimg['imageName'])) {
                        $articlephoto = $rowimg['imageName'];
                      } else {
                        $articlephoto = 'articleicon.png';
                      }
                    } else {
                      $articlephoto = 'articleicon.png';
                    }

                    $totalpostlike = '';
                    $aa = "";
                    $aa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= " . $rowTotalUserArticle["id"] . " and postType= 3";
                    $res5 = mysqli_query($conn, $aa);
                    $totalpostlike = mysqli_num_rows($res5);

                    $totalpostcomment = '';
                    $aa = "";
                    $aa = "SELECT * from " . _COMMENT_MASTER_TABLE_ . " WHERE postId= " . $rowTotalUserArticle["id"] . " and postType= " . $rowTotalUserArticle["postType"] . "";
                    $res5 = mysqli_query($conn, $aa);
                    $totalpostcomment = mysqli_num_rows($res5);


                    ?>
                    <li>
                      <div class="news2box">
                        <a class="bgimg"
                          href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowTotalUserArticle['id']); ?>"><img
                            src="<?php echo $fullurl; ?>uploads/<?php echo $articlephoto; ?>"></a>
                        <div class="ttl-head">
                          <div class="artcl-hdng"><a
                              href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($rowTotalUserArticle['id']); ?>"><?php echo getStrLength(strip_tags(stripslashes($rowTotalUserArticle["postTitle"])), 60); ?></a>
                          </div>
                          <ul class="likes-show">
                            <li>
                              <i class="fa fa-thumbs-up" aria-hidden="true"></i><span><?php if ($totalpostlike != '') {
                                echo $totalpostlike;
                              } else {
                                echo '0';
                              } ?></span>
                            </li>
                            <li>
                              <i class="fa fa-commenting" aria-hidden="true"></i><span><?php if ($totalpostcomment != '') {
                                echo $totalpostcomment;
                              } else {
                                echo '0';
                              } ?></span>
                            </li>
                            <li>
                              <i class="fa fa-share" aria-hidden="true"></i><span><?php $aas = "SELECT * from " . _SHARE_MASTER_TABLE_ . " WHERE postId= " . $rowTotalUserArticle["id"] . " and postType= " . $rowTotalUserArticle["postType"] . "";
                              $res5s = mysqli_query($conn, $aas);
                              echo $totalpostshared = mysqli_num_rows($res5s); ?></span>
                            </li>
                            <li>
                              <i class="fa fa-eye"
                                aria-hidden="true"></i><span><?php echo $rowTotalUserArticle["viewStatus"]; //$tagArray = explode(",",$rowTotalUserArticle['viewStatus']); echo $arrayCount = count($tagArray); ?></span>
                            </li>
                          </ul>
                        </div>
                      </div>
                    </li>
                    <?php
                  }
                }

                ?>
              </ul>
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
</body>

</html>