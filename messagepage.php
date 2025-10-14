<?php
include_once('inc.php');
$_SESSION['loginredirectpageurl'] = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
include_once('config/session-check.inc.php'); // check user login session
$pageIndex = 3;
$msg = 1;
?>
<!DOCTYPE html>
<html>

<head>
  <title>Messaging - <?php echo $companNameTitle; ?></title>
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/responsive.css">
  <link rel="stylesheet" type="text/css" href="<?php echo $fullurl; ?>css/style.css">
  <link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
  <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
  <link rel="stylesheet" type="text/css"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
  <script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
  <script src="<?php echo $fullurl; ?>js/main.js"></script>
  <style>
    .center_content {
      margin-bottom: 0;
      padding-left: 0;
      width: 75%;
    }

    @media only screen and (min-width: 800px) and (max-width: 1024px) {
      .center_content {
        margin-bottom: 0;
        padding-right: 0;
        width: 100%;
        padding-left: 0;
      }
    }

    ul.cht_mmbr_list.message li .chat-cont-user-list.active1 {
      background-color: rgb(231, 231, 231);
    }

    @media only screen and (max-width: 767px) {
      .copyright_cont {
        display: none;
      }
    }
  </style>
</head>

<body>
  <div id="wrapper" class="active">
    <?php include('header.php'); ?>
    <div class="container main">
      <div class="ffsdf" style="margin-top: 0 !important;">
        <div class="center_content">
          <div class="my-message grup-dtail">
            <div class="chat_list" <?php if ($mobile == 'y') { ?>style="display:block;" <?php } ?>>
              <h3>Conversations <a href="#" class="bulkmsg"><i class="fa fa-pencil-square-o" aria-hidden="true"
                    onClick="funcommonpopupwin('520px','auto','<?php echo $fullurl; ?>/common_popup_inner.php?type=sendbulkemails','New message');"></i></a>
              </h3>
              <div class="search-friend"><input type="text" name="searchmsgcontacts" id="searchmsgcontacts" value=""
                  onKeyUp="msgsearch();" placeholder="Search contacts"><img src="images/search_icon.png"
                  onClick="msgsearch();"></div>

              <ul class="cht_mmbr_list message" id="msgusers">

              </ul>
            </div>
            <div class="chat_box" id="msgchat" <?php if ($mobile == 'y') { ?>style="display:none;" <?php } ?>>

            </div>
          </div>
        </div>
        <?php include('right-sidebar.php'); ?>
      </div>
    </div>

    <div id="textchatactiondiv" style="display:none;"></div>
    <?php include('footer.php'); ?>
  </div>

  <?php
  $openChatUserId = "";

  // Fetch last user from chatMaster
  $sqlMessage = mysqli_query(
    $conn,
    "SELECT * FROM chatMaster WHERE contactId='" . mysqli_real_escape_string($conn, $_SESSION['sessUserId']) . "' ORDER BY id DESC LIMIT 0,1"
  );

  if ($sqlMessage && mysqli_num_rows($sqlMessage) > 0) {
    $getlastuser = mysqli_fetch_array($sqlMessage, MYSQLI_ASSOC);
  }

  // Determine which chat user to open
  if (isset($_GET["u"]) && $_GET["u"] != '') {
    $openChatUserId = htmlspecialchars($_GET["u"], ENT_QUOTES, "UTF-8");
  } elseif (!empty($getlastuser['userId'])) {
    $openChatUserId = encodeStr($getlastuser['userId']);
  } else {
    $openChatUserId = null;
  }

  // Debug comment output (safe)
  echo "<!-- DEBUG: openChatUserId = " . htmlspecialchars($openChatUserId ?? 'NULL') . " -->";
  ?>
  <script>
    // ✅ Debug log
    console.log("DEBUG: openChatUserId =", "<?php echo $openChatUserId; ?>");

    // ✅ Ensure $fullurl is defined
    const baseUrl = "<?php echo isset($fullurl) ? rtrim($fullurl, '/') . '/' : ''; ?>";
    if (!baseUrl) console.error("DEBUG: $fullurl not defined in PHP.");

    function msgsearch() {
      const searchmsgcontacts = encodeURIComponent($("#searchmsgcontacts").val() || "");
      console.log("DEBUG: Searching contacts for", searchmsgcontacts);
      $("#msgusers").load(baseUrl + "msgusers.php?searchmsgcontacts=" + searchmsgcontacts);
    }

    // ✅ Initial load of users list
    $("#msgusers").load(baseUrl + "msgusers.php", function (response, status, xhr) {
      if (status === "error") {
        console.error("msgusers.php load failed:", xhr.status, xhr.statusText);
        console.log("Response preview:", response.substring(0, 300));
      } else {
        console.log("msgusers.php loaded OK");
      }
    });


    // ✅ Fixed function (no recursion)
    function openuserchatbox(id) {
      if (!id || id === "null" || id === "") {
        console.error("Invalid chat ID");
        return;
      }

      $("#msgchat").html("<p style='padding:10px;'>Loading chat...</p>");

      $("#msgchat").load(baseUrl + "msgchat.php?id=" + id, function (response, status, xhr) {
        if (status === "error") {
          $("#msgchat").html("<p style='color:red;padding:10px;'>Error loading chat (" + xhr.status + ")</p>");
          console.error("msgchat.php failed:", xhr.status, xhr.statusText);
          console.log("Response preview:", response.substring(0, 200));
        } else {
          console.log("Chat loaded successfully for user", id);
        }
      });
    }


    $("#msgchat").html("Loading chat...");
    $("#msgchat").load(baseUrl + "msgchat.php?id=" + id, function (response, status, xhr) {
      if (status === "error") {
        console.error("DEBUG: msgchat.php failed →", xhr.status, xhr.statusText);
        console.log("DEBUG: msgchat.php returned:", response.slice(0, 200)); // preview
      } else {
        console.log("DEBUG: Chat loaded successfully for user", id);
      }
    });

    $("#chatfieldfooter").focus();

    function openuserchatbox(id) {
      if (!id || id === "null" || id === "") {
        console.error("DEBUG: No valid user ID provided to open chat.");
        return;
      }
      $("#msgchat").html("Loading chat...");
      $("#msgchat").load(baseUrl + "msgchat.php?id=" + id, function (response, status, xhr) {
        if (status === "error") {
          console.error("DEBUG: msgchat.php failed →", xhr.status, xhr.statusText);
        } else {
          console.log("DEBUG: Chat loaded successfully for user", id);
        }
      });
    }

    // ✅ Auto open last chat safely
    <?php if ($openChatUserId) { ?>
      $(document).ready(function () {
        console.log("DEBUG: Auto-opening chat for user →", "<?php echo $openChatUserId; ?>");
        openuserchatbox("<?php echo $openChatUserId; ?>");
      });
    <?php } else { ?>
      console.log("DEBUG: No openChatUserId found.");
    <?php } ?>

    // ✅ Window focus/blur
    var blurvalue = 2;
    var handle, handle2;

    $(window).blur(function () {
      blurvalue = 1;
      console.log("DEBUG: Window blurred");
    });

    $(window).focus(function () {
      blurvalue = 2;
      console.log("DEBUG: Window focused");
    });

    // ✅ Notifications refresh
    handle = setInterval(function () {
      console.log("DEBUG: Loading notifications...");
      $("#getnotifications").load(baseUrl + "getallnotifications.php");
    }, 10000);

    // ✅ Chat auto-refresh
    handle2 = setInterval(function () {
      if (blurvalue === 2) {
        const id = $("#chatuserid").val();
        if (id) {
          console.log("DEBUG: Auto-refreshing chat for user", id);
          $("#textchatactiondiv").load(baseUrl + "getchat.php?action=getchat&contactId=" + id);
        }
      }
    }, 1500);

    // ✅ Meeting status
    function meetingattend(id, userid, status) {
      console.log("DEBUG: Meeting status change", { id, userid, status });
      $("#" + id + " ul li a").removeClass("active");

      if (status == 1) {
        $("#" + id + " span").html("Yes I am attending");
        $("#" + id + " ul li a.yes").addClass("active");
      } else if (status == 2) {
        $("#" + id + " span").html("Maybe I am attending");
        $("#" + id + " ul li a.maybe").addClass("active");
      } else if (status == 3) {
        $("#" + id + " span").html("I am not attending");
        $("#" + id + " ul li a.no").addClass("active");
      }

      $("#textchatactiondiv").load(
        baseUrl + "common_action.php?action=meetingstatus&chatId=" + id + "&userid=" + userid + "&status=" + status
      );
    }


  </script>



</body>

</html>