<?php
include_once('inc.php');
$pageIndex = 75;

?>
<!DOCTYPE html>
<html>

<head>
    <title>All Notice - <?php echo $companNameTitle; ?></title>
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

            @media only screen and (max-width: 1024px) {
                .artcle-box-long .long-contnt {
                    float: left !important;
                    text-align: left !important;
                }

            }

            @media only screen and (max-width: 800px) {
                .artcle-box-long .long-contnt {
                    padding-left: 0;
                    text-align: left !important;
                }
            }

            @media only screen and (max-width: 480px) {
                .artcle-box-long .long-contnt {
                    text-align: left !important;
                }
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

        .artcle-box-long .long-contnt {
            float: right;
            text-align: left !important;
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
                        <h2>Notice Board</h2>
                        <!--<a href="<?php echo $fullurl; ?>post-article.html" class="writ-btn">Write an article</a>-->
                    </div>

                    <div class="trivia-shdow">
                        <div class="artcle">
                            <div class="cntr_cntnt popular">
                                <div class="populr-artcl2">
                                    <?php
                                    $no = 1;
                                    $select = '*';
                                    $where = ' ';
                                    $limit = 12;

                                    // fix: default page
                                    $page = $_GET['page'] ?? 1;

                                    $targetpage = $fullurl . 'all-notice.html?records=' . $limit . '&';

                                    // make sure GetRecordList uses mysqli_query internally
                                    $rs = GetRecordList($select, _NOTICEBOARD_TABLE_, $where, $limit, $page, $targetpage);


                                    $totalentry = $rs[1];
                                    $paging = $rs[2];

                                    // fix: mysqli_fetch_assoc instead of mysql_fetch_array
                                    while ($rowViewArticle = mysqli_fetch_assoc($rs[0])) {
                                        ?>
                                        <a
                                            href="<?php echo $fullurl; ?>view-notice.html?postId=<?php echo encodeStr($rowViewArticle['id']); ?>">
                                            <div class="artcle-box-long">
                                                <div class="long-contnt" style="float: left !important;">
                                                    <?php echo strip_tags(stripslashes($rowViewArticle["title"])); ?>
                                                    <div class="long-cont" style="float: left !important; padding: 5px;">
                                                        <?php echo strip_tags(stripslashes($rowViewArticle["details"])); ?>
                                                    </div>
                                                    <div class="long-name">
                                                        Notice Date
                                                        <?php
                                                        if (!empty($rowViewArticle["addeddate"])) {
                                                            echo date('d M, Y', strtotime($rowViewArticle["addeddate"]));
                                                        } else {
                                                            echo "N/A";
                                                        }
                                                        ?>
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