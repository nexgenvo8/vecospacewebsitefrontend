<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session

if ($_GET['sendcall'] == 1 && $_GET['u'] > 0 && $_GET['s'] != '' && $_GET['t'] != '') {

  $sessionId = isset($sessionId) ? $sessionId : '';
  $TokenRequest = isset($TokenRequest) ? $TokenRequest : '';




  unset($insertFields);
  unset($insertVals);

  $insertFields[0] = "callerId";
  $insertFields[1] = "userId";
  $insertFields[2] = "callDateTime";
  $insertFields[3] = "callStatus";
  $insertFields[4] = "roomName";
  $insertFields[5] = "requestToken";
  $insertFields[6] = "callerStatus";
  $insertFields[7] = "onlineTime";

  $insertVals[0] = $_SESSION["sessUserId"];
  $insertVals[1] = decodeStr($_GET['u']);
  $insertVals[2] = time();
  $insertVals[3] = '0';
  $insertVals[4] = $_GET['s'];
  $insertVals[5] = $_GET['t'];
  $insertVals[6] = 1;
  $insertVals[7] = date('Y-m-d H:i:s');
  $resUpdate = insertDB(_VIDEO_CALL_REQUEST_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');



  unset($insertFields);
  unset($insertVals);

  $insertFields[0] = "userId";
  $insertFields[1] = "callerId";
  $insertFields[2] = "callDateTime";
  $insertFields[3] = "callStatus";
  $insertFields[4] = "roomName";
  $insertFields[5] = "requestToken";
  $insertFields[6] = "callerStatus";
  $insertFields[7] = "onlineTime";

  $insertVals[0] = $_SESSION["sessUserId"];
  $insertVals[1] = decodeStr($_GET['u']);
  $insertVals[2] = time();
  $insertVals[3] = '1';
  $insertVals[4] = $_GET['s'];
  $insertVals[5] = $_GET['t'];
  $insertVals[6] = 1;
  $insertVals[7] = date('Y-m-d H:i:s');
  $resUpdate = insertDB(_VIDEO_CALL_REQUEST_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');


  $s = $_GET['s'];
  $t = $_GET['t'];



}

if ($_GET['ac'] == 1) {

  $a = "SELECT * from " . _VIDEO_CALL_REQUEST_MASTER_TABLE_ . " WHERE userId= " . $_SESSION['sessUserId'] . "";
  $b = mysqli_query($conn, $a) or die(mysqli_error($conn));
  $userData = mysqli_fetch_array($b);

  $s = $userData['roomName'];
  $t = $userData['requestToken'];


  unset($insertFields);
  unset($insertVals);
  unset($whereFields);
  unset($whereVals);

  $insertFields[0] = "callStatus";
  $insertVals[0] = 1;

  $whereFields[0] = "userId";
  $whereVals[0] = $_SESSION['sessUserId'];

  $resUpdate = updateDB(_VIDEO_CALL_REQUEST_MASTER_TABLE_, $insertFields, $insertVals, $whereFields, $whereVals, _N_, '');
  ?>
  <script>
    parent.stopring();
  </script>

  <?php
}

if ($_GET["u"] != '') {
  $userimg = decodeStr($_GET["u"]);
} else {
  $userimg = $userData['callerId'];
}
?>


<style>
  body {
    background-color: #000;
    color: #FFFFFF;
    font-size: 13px;
    outline: 0px;
    padding: 0px;
    margin: 0px;
  }
</style>
<title>Konnect Live</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo $fullurl; ?>favicon.ico" type="image/x-icon">
<link href="chat/css/app.css" rel="stylesheet" type="text/css">
<script src="<?php echo $fullurl; ?>js/jquery.min.js"></script>
<script>

  <?php if ($_SESSION['tok'] == $_GET['t']) {

    ?>
    opener.endvideocall();
    //window.open('', '_self', ''); window.close();
  <?php } ?>


  window.onunload = function (e) {
    opener.endvideocall();
  };

  var callyes = setInterval(function () {
    $('#getupdate').load('common_action.php?getvideouserlive=1');
  }, 5000);
</script>


<script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
<?php if ($_GET['s'] != '') {

  $a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $userimg . "";
  $b = mysqli_query($conn, $a) or die(mysqli_error($conn));
  $callerUSER = mysqli_fetch_array($b);


  if ($callerUSER["profilePhoto"] != '') {
    $userphoto = $callerUSER["profilePhoto"];
  } else {
    $userphoto = 'user-placeholder.jpg';
  }



  $a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . decodeStr($_GET["u"]) . "";
  $b = mysqli_query($conn, $a) or die(mysqli_error($conn));
  $myphoto = mysqli_fetch_array($b);


  if ($myphoto["profilePhoto"] != '') {
    $Myprofilephoto = $myphoto["profilePhoto"];
  } else {
    $userphoto = 'user-placeholder.jpg';
  }


  ?>

<?php } ?>



<div class="vdo-chat-cont">
  <div class="vdo-chat-main">
    <div class="vdo-chat-hdr">
      <div class="vdo-usr-img">
        <img src="<?php echo $fullurl; ?>images/tim.jpg">
      </div>
      <div class="vdo-usr-nm">
        <a href="">Shahrukh Khan</a>
        <span>Front End Developer at scg india</span>
      </div>
    </div>
    <div class="vdo-chat-box">
      <div class="vdo-chat user">
        <div class="writen-chat-user">
          hi SrK
        </div>
        <div class="tm">07:58 PM</div>
      </div>
      <div class="vdo-chat me">
        <div class="writen-chat-me">
          Hello How R U?
        </div>
        <div class="tm">07:58 PM</div>
      </div>
      <div class="chat-date">12 September 2017</div>
      <div class="vdo-chat user">
        <div class="writen-chat-user">
          hi SrK
        </div>
        <div class="tm">07:58 PM</div>
      </div>
      <div class="vdo-chat me">
        <div class="writen-chat-me">
          Hello How R U?
        </div>
        <div class="tm">07:58 PM</div>
      </div>
      <div class="chat-date">12 September 2017</div>
      <div class="vdo-chat user">
        <div class="writen-chat-user">
          hi SrK
        </div>
        <div class="tm">07:58 PM</div>
      </div>
      <div class="vdo-chat me">
        <div class="writen-chat-me">
          Hello How R U?
        </div>
        <div class="tm">07:58 PM</div>
      </div>
      <div class="chat-date">12 September 2017</div>
      <div class="vdo-chat user">
        <div class="writen-chat-user">
          hi SrK
        </div>
        <div class="tm">07:58 PM</div>
      </div>
      <div class="vdo-chat me">
        <div class="writen-chat-me">
          Hello How R U?
        </div>
        <div class="tm">07:58 PM</div>
      </div>
    </div>
    <div class="vdo-chat-fttr">
      <textarea placeholder="Type message..."></textarea>
      <input type="submit" value="Send">
    </div>
  </div>
</div>

<div id="videos" style="background-color:#000000;">
  <div id="subscriber" style="background-color:#000000;"></div>
  <div id="publisher" style="background-color:#000000;"></div>

  <?php if ($_GET['s'] != '') { ?>
    <div style="position:absolute; top:20%; width:100%; z-index:999999;" id="callerphoto">
      <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td align="center"><img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"
              width="147" style="border-radius: 100px;border: 10px #2a2a2a solid;"></td>
        </tr>
        <tr>
          <td align="center">
            <div
              style="text-align:center; color:#FFFFFF; font-size:18px; font-family:Arial, Helvetica, sans-serif; margin-top:10px;">
              Calling to <?php echo $callerUSER['firstName']; ?>   <?php echo $callerUSER['lastName']; ?>...</div>
          </td>
        </tr>
      </table>
    </div>
  <?php } ?>

  <div id="mediatools">
    <table border="0" align="center" cellpadding="10" cellspacing="0" width="100">
      <tr>
        <td align="center">
          <div id="mutebtn" onclick="mutesound();"><img src="images/icon-ios7-mic-32.png" /></div>
          <div id="mutebtnwhite" style="display:none;" onclick="opensound();"><img
              src="images/icon-ios7-mic-off-32.png" /></div>
        </td>

        <td align="center">
          <div id="cutcallbtn" onclick="disconnectcall();"><img src="images/cutcallicon.png" /></div>
        </td>

        <td align="center">
          <div id="camraon" onclick="mutecam();"><img src="images/camraon.png" /></div>
          <div id="camraoff" onclick="opencam();" style="display:none;"><img src="images/camraoff.png" /></div>
        </td>
      </tr>
    </table>
  </div>

</div>

<script>
  // replace these values with those generated in your TokBox Account
  var apiKey = "45964872";
  var sessionId = "<?php echo $s; ?>";
  var token = "<?php echo $t; ?>";

  // Handling all of our errors here by alerting them
  function handleError(error) {
    if (error) {
      // alert(error.message);
    }
  }

  // (optional) add server code here
  initializeSession();

  function initializeSession() {
    var session = OT.initSession(apiKey, sessionId);

    // Subscribe to a newly created stream
    session.on('streamCreated', function (event) {
      session.subscribe(event.stream, 'subscriber', {
        insertMode: 'append',
        width: '100%',
        height: '100%'
      }, handleError);
    });

    // Create a publisher




    // Connect to the session
    session.connect(token, function (error) {
      // If the connection is successful, initialize a publisher and publish to the session
      if (error) {
        handleError(error);
      } else {
        session.publish(publisher, handleError);
      }
    });
  }



  var publisher = OT.initPublisher('publisher', {
    insertMode: 'append',
    width: '100%',
    height: '100%'
  }, handleError);







</script>



<div id="getupdate" style="display:none;"></div>

<style>
  #mediatools {
    position: absolute;
    width: 100%;
    left: inherit;
    bottom: 20%;
    text-align: center;
    z-index: 999999;
  }

  #cutcallbtn {
    background-color: #db4437;
    text-align: center;
    width: 55px;
    height: 33px;
    border-radius: 60px;
    vertical-align: middle;
    padding-top: 22px;
    cursor: pointer;
  }

  #mutebtn {
    background-color: rgba(255, 255, 255, 0.16);
    text-align: center;
    width: 55px;
    height: 43px;
    border-radius: 60px;
    vertical-align: middle;
    padding-top: 13px;
    cursor: pointer;
  }

  #mutebtnwhite {
    background-color: rgba(255, 255, 255, 1);
    text-align: center;
    width: 55px;
    height: 43px;
    border-radius: 60px;
    vertical-align: middle;
    padding-top: 13px;
    cursor: pointer;
  }


  #camraon {
    background-color: rgba(255, 255, 255, 0.16);
    text-align: center;
    width: 55px;
    height: 43px;
    border-radius: 60px;
    vertical-align: middle;
    padding-top: 13px;
    cursor: pointer;
  }

  #camraoff {
    background-color: rgba(255, 255, 255, 1);
    text-align: center;
    width: 55px;
    height: 43px;
    border-radius: 60px;
    vertical-align: middle;
    padding-top: 13px;
    cursor: pointer;
  }


  #camraon:hover {
    background-color: rgba(255, 255, 255, 0.20);
  }

  #mutebtn:hover {
    background-color: rgba(255, 255, 255, 0.20);
  }

  #mutevideobtn:hover {
    background-color: rgba(255, 255, 255, 0.20);
  }

  #mutevideobtn {
    background-color: rgba(255, 255, 255, 0.16);
    text-align: center;
    width: 55px;
    height: 33px;
    border-radius: 60px;
    vertical-align: middle;
    padding-top: 22px;
    cursor: pointer;
  }
</style>
<script>
  function mutesound() {
    $('#mutebtn').hide();
    $('#mutebtnwhite').show();
    publisher.publishAudio(false);
  }

  function opensound() {
    $('#mutebtn').show();
    $('#mutebtnwhite').hide();
    publisher.publishAudio(true);
  }

  function mutecam() {
    $('#camraon').hide();
    $('#camraoff').show();
    publisher.publishVideo(false);
  }

  function opencam() {
    $('#camraon').show();
    $('#camraoff').hide();
    publisher.publishVideo(true);
  }



  function disconnectcall() {
    opener.endvideocall();
    window.open('', '_self', ''); window.close();
  }
</script>










<script>
  function errorMessage(message, e) {
    console.error(message, typeof e == 'undefined' ? '' : e);

    if (message == 1) {
      $('#camraon').hide();
      $('#publisher').hide();
    }
  }

  if (location.protocol == 'http:' || location.protocol == 'https:') {
    navigator.getUserMedia = navigator.getUserMedia || navigator.webkitGetUserMedia || navigator.mozGetUserMedia || navigator.msGetUserMedia;
    if (navigator.getUserMedia) {
      navigator.getUserMedia({ audio: true, video: true }, function (stream) {
        document.querySelector('video').src = window.URL.createObjectURL(stream);
        var mediaStreamTrack = stream.getVideoTracks()[0];
        if (typeof mediaStreamTrack != "undefined") {
          mediaStreamTrack.onended = function () {//for Chrome.
            errorMessage('Your webcam is busy!')
          }
        } else errorMessage('Permission denied!');
      }, function (e) {
        var message;
        switch (e.name) {
          case 'NotFoundError':
          case 'DevicesNotFoundError':
            message = '1';
            break;
          case 'SourceUnavailableError':
            message = 'Your webcam is busy';
            break;
          case 'PermissionDeniedError':
          case 'SecurityError':
            message = 'Permission denied!';
            break;
          default: errorMessage('Reeeejected!', e);
            return;
        }
        errorMessage(message);
      });
    } else errorMessage('Uncompatible browser!');
  } else errorMessage('Use https protocol for open this page.');
</script>


<?php
$_SESSION['tok'] = $_GET['t'];
?>