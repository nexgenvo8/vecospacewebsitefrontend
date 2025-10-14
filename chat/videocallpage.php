<?php
include_once('inc.php');  
include_once('config/session-check.inc.php'); // check user login session

if($_GET['sendcall']==1 && $_GET['u']>0 && $_GET['s']!='' && $_GET['t']!=''){






unset($insertFields);
		unset($insertVals);					
		
		$insertFields[0]="callerId";
		$insertFields[1]="userId"; 
		$insertFields[2]="callDateTime";
		$insertFields[3]="callStatus";
		$insertFields[4]="roomName";
		$insertFields[5]="requestToken";
		$insertFields[6]="callerStatus";
		$insertFields[7]="onlineTime";
		
		$insertVals[0]=$_SESSION["sessUserId"];
		$insertVals[1]=decodeStr($_GET['u']); 
		$insertVals[2]=time();
		$insertVals[3]='0';
		$insertVals[4]=$_GET['s'];
		$insertVals[5]=$_GET['t'];
		$insertVals[6]=1;
		$insertVals[7]=date('Y-m-d H:i:s');
		$resUpdate=insertDB(_VIDEO_CALL_REQUEST_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
		
		
		
		unset($insertFields);
		unset($insertVals);					
		
		$insertFields[0]="userId";
		$insertFields[1]="callerId"; 
		$insertFields[2]="callDateTime";
		$insertFields[3]="callStatus";
		$insertFields[4]="roomName";
		$insertFields[5]="requestToken";
		$insertFields[6]="callerStatus";
		$insertFields[7]="onlineTime";

		$insertVals[0]=$_SESSION["sessUserId"];
		$insertVals[1]=decodeStr($_GET['u']); 
		$insertVals[2]=time();
		$insertVals[3]='1';
		$insertVals[4]=$_GET['s'];
		$insertVals[5]=$_GET['t'];
		$insertVals[6]=1;
		$insertVals[7]=date('Y-m-d H:i:s');
		$resUpdate=insertDB(_VIDEO_CALL_REQUEST_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');


$s=$_GET['s'];
$t=$_GET['t'];



}

if($_GET['ac']==1){

$a="SELECT * from "._VIDEO_CALL_REQUEST_MASTER_TABLE_." WHERE userId= ".$_SESSION['sessUserId']."";
$b=mysql_query($a) or die(mysql_error()); 
$userData=mysql_fetch_array($b); 

$s=$userData['roomName'];
$t=$userData['requestToken'];


unset($insertFields);
unset($insertVals);	
unset($whereFields);	
unset($whereVals);				

$insertFields[0]="callStatus";  
$insertVals[0]=1; 

$whereFields[0]="userId"; 
$whereVals[0]=$_SESSION['sessUserId'];

$resUpdate=updateDB(_VIDEO_CALL_REQUEST_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,''); 
 ?>
 <script>
 parent.stopring();
 </script>
 
 <?php
}



 
 ?>


<style>
body{background-color:#000; color:#FFFFFF; font-size:13px; outline:0px; padding:0px; margin:0px;}
</style>
<title>Konnect Live</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="shortcut icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
<link rel="icon" href="<?php echo $fullurl;?>favicon.ico" type="image/x-icon">
 <link href="chat/css/app.css" rel="stylesheet" type="text/css">
 <script src="<?php echo $fullurl; ?>js/jquery.min.js"></script> 
 <script>




 window.onunload = function (e) { 
    opener.endvideocall();
};
 
 var callyes = setInterval(function () {  
$('#getupdate').load('common_action.php?getvideouserlive=1'); 
}, 5000);
 </script>
 
 
    <script src="https://static.opentok.com/v2/js/opentok.min.js"></script>
	<?php if($_GET['s']!=''){
	
$a="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= ".decodeStr($_GET["u"])."";
$b=mysql_query($a) or die(mysql_error()); 
$callerUSER=mysql_fetch_array($b); 


if($callerUSER["profilePhoto"]!='')
{
$userphoto=$callerUSER["profilePhoto"];
} else {
$userphoto='user-placeholder.jpg';
}	



$a="SELECT * from "._USERS_MASTER_TABLE_." WHERE userId= ".decodeStr($_GET["u"])."";
$b=mysql_query($a) or die(mysql_error()); 
$myphoto=mysql_fetch_array($b); 


if($myphoto["profilePhoto"]!='')
{
$Myprofilephoto=$myphoto["profilePhoto"];
} else {
$userphoto='user-placeholder.jpg';
}	
	
	
	 ?>
<div style="position:fixed; top:20%; width:100%; z-index:999999;" id="callerphoto">
<table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($userphoto));?>" width="147" style="border-radius: 100px;border: 10px #2a2a2a solid;"></td>
  </tr>
  <tr>
    <td align="center"><div style="text-align:center; color:#FFFFFF; font-size:18px; font-family:Arial, Helvetica, sans-serif; margin-top:10px;">Calling to <?php echo $callerUSER['firstName']; ?> <?php echo $callerUSER['lastName']; ?>...</div></td>
  </tr>
  
</table>

</div>
<?php } ?>


  <div id="videos" style="background-color:#000000;">
        <div id="subscriber"style="background-color:#000000;"></div>
        <div id="publisher"style="background-color:#000000;"></div>
</div>

<script>
// replace these values with those generated in your TokBox Account
var apiKey = "45958552";
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
  session.on('streamCreated', function(event) {
    session.subscribe(event.stream, 'subscriber', {
      insertMode: 'append',
      width: '100%',
      height: '100%'
    }, handleError);
  });

  // Create a publisher
  var publisher = OT.initPublisher('publisher', {
    insertMode: 'append',
    width: '100%',
    height: '100%'
  }, handleError);

publisher.publishAudio(false);  



  // Connect to the session
  session.connect(token, function(error) {
    // If the connection is successful, initialize a publisher and publish to the session
    if (error) {
      handleError(error);
    } else {
      session.publish(publisher, handleError);
    }
  });
}



function maudio(){  
}

 

</script>

 <script>
        function errorMessage(message, e) {
            console.error(message, typeof e == 'undefined' ? '' : e);
          
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
 
<div id="getupdate" style="display:none;"></div>


<script>

</script>
<a href="#" onclick="maudio()">Mute Audio</a>