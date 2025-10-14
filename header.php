<?php
if ($userAccountCloseStatus == 1) {
    header('Location:' . $fullurl . 'disabled-account.html');
    exit();
}

?>
<?php
$fullurl = "http://localhost/jmivecospace/jmi/";
?>

<script>
    function postcmnt(postId, postType, userId, postuserId, parentId, cmntid, limit) {
        if (limit == '') {
            var limit = 5;
        }

        if (postType == 1 || postType == 2) {
            var pageType = 'timeline';
        }
        if (postType == 3) {
            var pageType = 'article';
        }
        if (postType == 4) {
            var pageType = 'grouptimeline';
        }
        if ($('#commentbox' + postId + postType) != '') {

            if (parentId != 0) {
                var commentbox = encodeURIComponent($('#commentboxreply' + postId + cmntid).val());
            }
            else {
                var commentbox = encodeURIComponent($('#commentbox' + postId + postType).val());

            }

            $('#commentbox' + postId + postType).val('');
            var cmtdiv = 'postcomment';
            var cmntdivbox = postId + postType;


            $('#' + cmtdiv + cmntdivbox).load('<?php echo $fullurl; ?>post-comment.php?postId=' + postId + '&postType=' + postType + '&commentbox=' + commentbox + '&postuserId=' + postuserId + '&contactuserId=' + userId + '&parentId=' + parentId + '&cmntid=' + cmntid + '&limit=' + limit + '&action=postcomment&pageType=' + pageType);
        }
    }

    function imgError(image) {
        image.onerror = "";
        image.src = "<?php echo $fullurl; ?>uploads/user-placeholder.jpg";
        return true;
    }
</script>


<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="shortcut icon" href="faddsvicon.ico" type="image/x-icon">
<link rel="icon" href="favidcon.ico" type="image/x-icon">
<header id="header">
    <div class="hdr_cont container after-login" style=" min-height:50px;">
        <div class="logo">
            <a href="<?php echo $fullurl; ?>timeline.html" class="hiden-xs"><img
                    src="<?php echo $fullurl; ?>images/logo.png" style="margin-top: 10px; "></a>
            <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
                <div class="hamburger-menu">
                    <div class="bar"></div>
                </div>
            <?php } ?>


            <div class="nav-btn" style="display: none;">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </div>
            <a href="<?php echo $fullurl; ?>timeline.html" class="hiden-d"><img
                    src="<?php echo $fullurl; ?>fav1.png"></a>
        </div>



        <?php if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) { ?>
            <div class="header_right">
                <div class="hdr_search">
                    <form name="topsearchfrm" id="topsearchfrm" class="mainsearch" method="get"
                        action="<?php echo $fullurl; ?>search.html">
                        <input type="text" name="keywordsearch" id="keywordsearch"
                            value="<?php echo htmlspecialchars($_REQUEST['keywordsearch'] ?? '', ENT_QUOTES); ?>"
                            maxlength="50" class="text" autocomplete="off" placeholder="Search " onkeyup="topsearch();">

                        <button type="button" class="search_btn" onClick="subsrchfrm();"><i class="fa fa-search"
                                aria-hidden="true"></i></button>
                        <div id="showsearchbox"></div>

                    </form>

                    <script>
                        function subsrchfrm() {

                            if ($("#keywordsearch").val() != '') {
                                $("#topsearchfrm").submit();
                            }
                        }

                        $("input").keypress(function (event) {

                            if (event.which == 13) {
                                event.preventDefault();

                                if ($("#keywordsearch").val() != '') {
                                    $("#topsearchfrm").submit();
                                }
                            }
                        });

                    </script>
                    <div class="find_btn" id="requestandnotiload">

                    </div>
                    <style>
                        .topsearchlist {
                            background-color: #fff;
                            border-bottom: 1px solid #f3f3f3;
                            cursor: pointer;
                            padding: 6px;
                        }

                        .topsearchlist:hover {
                            background-color: #F7F7F7;
                        }

                        #showsearchbox {
                            width: 100%;
                            max-height: 350px;
                            overflow: auto;
                            position: absolute;
                            left: 0px;
                            top: 33px;
                            border: 1px solid #f3f3f3;
                            border-radius: 2px;
                            box-shadow: 0px 4px 4px #b7b5b5;
                            display: none;
                            background-color: #fff;
                        }

                        .topsearchheader {
                            border-bottom: 1px solid #f3f3f3;
                            padding: 6px;
                            font-weight: bold;
                            color: #1a94c3;
                        }
                    </style>
                    <script>
                        function topsearch() {

                            var keywordsearch = $("#keywordsearch").val();
                            keywordsearch = encodeURIComponent($.trim(keywordsearch));

                            $('#showsearchbox').load('<?php echo $fullurl; ?>showsearchbox.php?keywordsearch=' + keywordsearch);

                        }

                        $('#requestandnotiload').load('<?php echo $fullurl; ?>request_and_notification.php');
                    </script>


                    <script type="text/javascript">
                        var removeClass = true;
                        $(".hamburger-menu").click(function () {
                            $(".left_menu_sec").toggleClass('open');
                            removeClass = false;
                        });
                        $("html").click(function () {
                            if (removeClass) {
                                $(".left_menu_sec").removeClass('open');
                            }
                            removeClass = true;
                        });

                    </script>

                    <script type="text/javascript">
                        var deleteClass = true;
                        $(".hamburger-menu").click(function () {
                            $(".bar").toggleClass('animate');
                            deleteClass = false;
                        });
                        $("html").click(function () {
                            if (deleteClass) {
                                $(".bar").removeClass('animate');
                            }
                            deleteClass = true;
                        });

                        var bodyClass = true;
                        $(".hamburger-menu").click(function () {
                            $("body").toggleClass('over-hide');
                            bodyClass = false;
                        });
                        $("html").click(function () {
                            if (bodyClass) {
                                $("body").removeClass('over-hide');
                            }
                            bodyClass = true;
                        });



                    </script>

                    <div class="toggle hiden-xs" onclick="$('.setting_menu').show();">
                        <a href="javascript:void(0);">
                            <span class="usr_img"><img
                                    src="<?php echo $fullurl; ?>uploads/<?php echo $myprofilePhoto; ?>"></span>
                        </a>
                        <ul class="setting_menu">
                            <li><a
                                    href="<?php echo $fullurl; ?>myprofile/<?php echo encodeStr($_SESSION['sessUserId']); ?>/<?php echo $myurl; ?>.html"><i
                                        class="fa fa-user" aria-hidden="true"></i> My profile</a></li>
                            <!--<li><a href="<?php echo $fullurl; ?>myads.html"><i class="fa fa-buysellads" aria-hidden="true"></i> My Ads</a></li>-->
                            <li><a href="<?php echo $fullurl; ?>settings.html"><i class="fa fa-cog" aria-hidden="true"></i>
                                    Settings</a></li>
                            <li><a href="#1" style="display: none;">Premium membership</a></li>
                            <li><a href="<?php echo $fullurl; ?>faq.html"><i class="fa fa-question" aria-hidden="true"></i>
                                    FAQ's</a></li>
                            <li><a href="<?php echo $fullurl; ?>logout.html"><i class="fa fa-sign-out"
                                        aria-hidden="true"></i> Logout</a></li>
                        </ul>
                    </div>
                </div>



            </div>
        <?php } else { ?>



            <div class="header_right">
                <?php if ($mobile == 'y') { ?>
                    <a href="<?php echo $fullurl; ?>" style="float:right;padding: 7px 0;
    text-transform: capitalize;">Login/Register</a>
                <?php } else { ?>
                    <form class="login-form" name="kUserLogin" id="kUserLogin" method="post" action="<?php echo $fullurl; ?>">
                        <input type="text" name="txtUsername" id="txtUsername" placeholder="Email" maxlength="60"
                            value="<?php echo sanitizedboutput($username); ?>" class="validate <?php echo $className1; ?>"
                            onKeyUp="hideerrordiv(this.id);">
                        <input type="password" name="txtPassword" id="txtPassword" placeholder="Password" maxlength="60"
                            class="validate <?php echo $className1; ?>" onKeyUp="hideerrordiv(this.id);">
                        <button type="button" onClick="formValidation('kUserLogin');">Sign in</button>
                        <input type="hidden" name="txtAction" id="txtAction" value="login">
                        <a href="<?php echo $fullurl; ?>forgot-password.html">Forgot Password?</a>
                    </form>
                <?php } ?>
                <script>
                    $("input").keypress(function (event) {
                        if (event.which == 13) {
                            event.preventDefault();
                            if ($("#txtUsername").val() != '' && $("#txtPassword").val() != '') {
                                $("#kUserLogin").submit();
                            }
                        }
                    });

                    function hideerrordiv(elemId) {
                        $('#' + elemId).removeClass('redborderfield');
                    }  
                </script>
                <script src="<?php echo $fullurl; ?>js/validateform.js"></script>
            </div>
        <?php } ?>


    </div>
</header>

<script>
    $('#requestandnotiload').load('<?php echo $fullurl; ?>request_and_notification.php');	 
</script>
<style type="text/css">
    .konecttbtn {
        margin: 0 !important;
        padding: 12px 10px !important;
        width: 100% !important;
    }

    .konecttbtngbtn {
        background-color: #1db055 !important;
        color: #fff !important;
    }
</style>