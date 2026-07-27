<?php
/* ini_set('display_errors', 1);
error_reporting(E_ALL); */
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session
$stmtSafeId = 0;

if (!empty($_REQUEST['stmtId'])) {
    $stmtSafeId = intval(decodeStr($_REQUEST['stmtId']));
}

if(isset($_POST['action']) && $_POST['action'] === 'edit'){



    $msgId = intval($_POST['stmtId']);
    $html  = mysqli_real_escape_string($conn, $_POST['html']);

    if(!$msgId){
        echo "Invalid ID";
        exit;
    }

    $sql_up = "UPDATE "._STUDENT_MENTOR_CHAT_MASTER_TABLE_."
               SET chatText='".$html."'
               WHERE id='".$msgId."'";

    mysqli_query($conn, $sql_up) or die(mysqli_error($conn));

 
    exit; // 🔥 CRITICAL
}
// ================== SAVE TESTIMONIAL ==================
if(isset($_POST['action']) && $_POST['action'] === 'testimonial'){

    $msgId = intval($_POST['msgId']);
    $text  = mysqli_real_escape_string($conn, $_POST['text']);

    mysqli_query($conn,"
        UPDATE "._STUDENT_MENTOR_CHAT_MASTER_TABLE_."
        SET testimonial='".$text."'
        WHERE id='".$msgId."'
    ");

    exit;
}

// ================== SAVE FEEDBACK ==================
if(isset($_POST['action']) && $_POST['action'] === 'feedback'){

    $msgId = intval($_POST['msgId']);
    $text  = mysqli_real_escape_string($conn, $_POST['text']);

    mysqli_query($conn,"
        UPDATE "._STUDENT_MENTOR_CHAT_MASTER_TABLE_."
        SET feedback='".$text."'
        WHERE id='".$msgId."'
    ");

    exit;
}
// ================== SAVE ATTENDANCE ==================
// ================== SAVE ATTENDANCE ==================
if(isset($_POST['attendance'])){

    $msgId = intval($_POST['msgId']);
    $attendance = ($_POST['attendance'] == 'yes') ? 'Yes' : 'No';

    $q = mysqli_query($conn,"
        UPDATE "._STUDENT_MENTOR_CHAT_MASTER_TABLE_."
        SET attendance='".$attendance."'
        WHERE id='".$msgId."'
    ");

    if(!$q){
        echo "SQL ERROR: " . mysqli_error($conn);
    } else {
        echo "success";
    }

    exit;
}


if(isset($_POST['action']) && $_POST['action'] === 'recording'){

    $stmtId = decodeStr($_POST['stmtId']);

    if(isset($_FILES['recording']) && $_FILES['recording']['error'] == 0){

        $folder = "uploads/recordings/";

        if(!is_dir($folder)){
            mkdir($folder,0777,true);
        }

        $name = time().'_'.basename($_FILES['recording']['name']);
        $path = $folder.$name;

        move_uploaded_file($_FILES['recording']['tmp_name'], $path);

        $chatText = "[recording]".$path;

        $sql = "INSERT INTO "._STUDENT_MENTOR_CHAT_MASTER_TABLE_." SET
            userId='".$_SESSION['sessUserId']."',
            contactId='".$stmtId."',
            chatText='".mysqli_real_escape_string($conn,$chatText)."',
            status='0',
            meeting='0',
            shareId='0',
            alertStatus='0',
            chatBy='".$_SESSION['sessUserId']."',
            chatFileName='',
            dateAdded='".time()."',
            readDate='0',
            postShare='0'";

        mysqli_query($conn,$sql) or die(mysqli_error($conn));
    }

    exit;
}


if($_REQUEST['stmtId']!='' && $_REQUEST['action']=='chat' && trim($_REQUEST['text'])!=''){
include('mail.php');

 
$dateAdded=time();
$text=normalclean($_REQUEST["text"]);
//$text=ltrim($text,"<br />");
$text=preg_replace('/^(?:<br\s*\/?>\s*)+/', '', $text);
if(trim($_REQUEST['text'])!=''){

$sql_ins="insert into "._STUDENT_MENTOR_CHAT_MASTER_TABLE_." set status=1,userId='".$_SESSION["sessUserId"]."',contactId='".decodeStr($_REQUEST["stmtId"])."',chatBy='".$_SESSION["sessUserId"]."',dateAdded='$dateAdded',chatText= '".$text."'";
mysqli_query($conn, $sql_ins) or die(mysqli_error($conn)); 
$lastchatid=mysqli_insert_id($conn);

chattimelineentry($_SESSION["sessUserId"],decodeStr($_REQUEST["stmtId"]),1);

$a="";
$a="select blockUser from "._STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_." where studentId='".$_SESSION["sessUserId"]."' AND userId='".decodeStr($_REQUEST["stmtId"])."' ";
$b=mysqli_query($conn,$a);
$c=mysqli_fetch_array($b); 
if($c["blockUser"]!=1)
{

$sql_ins="insert into "._STUDENT_MENTOR_CHAT_MASTER_TABLE_." set status=0,userId='".decodeStr($_REQUEST["stmtId"])."',contactId='".$_SESSION["sessUserId"]."',chatBy='".$_SESSION["sessUserId"]."',dateAdded='$dateAdded',chatText= '".$text."'";
mysqli_query($conn,$sql_ins) or die(mysqli_error($conn)); 


}
/*$sql_ins="UPDATE "._STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_." SET chatStatus=1 WHERE contactId= ".$_SESSION["sessUserId"]." AND userId='".decodeStr($_REQUEST["contactId"])."' ";
mysqli_query($sql_ins) or die(mysqli_error($conn)); */

$sql_ins="UPDATE "._USERS_MASTER_TABLE_." SET onlineLastUpdate=".time()." WHERE userId=".$_SESSION["sessUserId"]."  ";
mysqli_query($conn,$sql_ins) or die(mysqli_error($conn)); 


$sql_ins="UPDATE "._STUDENT_MENTOR_CHAT_MASTER_TABLE_." SET status=1 WHERE contactId= '".decodeStr($_REQUEST['stmtId'])."' AND userId='".$_SESSION["sessUserId"]."' ";
mysqli_query($conn,$sql_ins) or die(mysqli_error($conn));
if(isset($_REQUEST['shb']) && trim($_REQUEST['shb']) == 1)
{
    $sql_ins = "UPDATE "._STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_." 
                SET birthdayStatus=1 
                WHERE contactId= '".decodeStr($_REQUEST['contactId'])."' 
                AND userId='".$_SESSION["sessUserId"]."' ";

    mysqli_query($conn, $sql_ins) or die(mysqli_error($conn)); 
?>
<script>
parent.$('#saybirthday<?php echo decodeStr($_REQUEST['contactId']); ?>').slideUp();
</script>
<?php
}
$token='';
$sqlMsgToken="";
$sqlMsgToken="select token from "._MOBILE_NOTIFICATION_TABLE_." where userId='".decodeStr($_REQUEST["stmtId"])."' ORDER BY id desc ";
$resMsgToken=mysqli_query($conn,$sqlMsgToken);
$getLastToken=mysqli_fetch_array($resMsgToken); 
$token=$getLastToken["token"];
?>
<div id="sendalert" style="display:none;"></div>
<script>
$('#loadstmtchat').append('<div class="userchatboxmain"><div class="userchatboxmain_me"><div  class="userchatboxmain_name_me" >&nbsp;</div><div class="userchatboxmain_text_me"><div class="chatmsg"><?php echo showsmily($text); ?></div><div  class="userchatboxmain_time_me" id="usermsgid<?php echo $lastchatid;?>"><?php echo date("h:i A");?></div></div></div></div>');
$("#loadstmtchat").scrollTop($("#loadstmtchat")[0].scrollHeight);
$("#loadstmtchat").load('<?php echo $fullurl; ?>load_stmtchat.php?stmtId=<?php echo $_REQUEST['stmtId']; ?>');

<?php
$a="";
$a="select blockUser from "._STUDENT_REQUEST_MENTOR_FRND_MASTER_TABLE_." where studentId='".$_SESSION["sessUserId"]."' AND userId='".decodeStr($_REQUEST["stmtId"])."' ";
$b=mysqli_query($conn,$a);
$c=mysqli_fetch_array($b); 
if($c["blockUser"]!=1)
{
?>
$("#sendalert").load('app/firebase/Send.php?title=<?php echo $notititle.','.$_SESSION["sessUserId"]; ?>&message=<?php echo $notimessage; ?>&token=<?php echo $token; ?>');
<?php } ?>


</script>

<?php

}

}



if(trim($_REQUEST['stmtId'])!='' && $_REQUEST['action']=='getchat'){ 

 
$dateAdded=time();

$n=0;
	$selectFields =[];
	$whereFields =[];
	$whereVals =[];
	
$sqlLogin="";
$sqlLogin="select * from "._STUDENT_MENTOR_CHAT_MASTER_TABLE_." where userId='".$_SESSION['sessUserId']."' and contactId=$stmtSafeId and status=0 ORDER BY dateAdded asc LIMIT 0,1";
	$resLogin=getRecords(_STUDENT_MENTOR_CHAT_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlLogin); 	
	if($resLogin)
	{
		while($row=mysqli_fetch_array($resLogin))
			{
				
if(!empty($row["chatFileName"]) && function_exists('findExtension')){

    $fileExt = strtolower(findExtension($row["chatFileName"]));


if($fileExt=='jpeg'  || $fileExt=='JPEG' || $fileExt=='jpg'  || $fileExt=='JPG' || $fileExt=='png'  || $fileExt=='PNG')
{

$img=1;

} else {

$img=0;

}

} else {

$img=0;
}

$msgid=$row["id"];

$contentimg= 'x_'.$row["chatFileName"];
  ?>

<script>
var contentimg='<?php echo $contentimg;?>';


$('#loadstmtchat').append('<div class="userchatboxmain"><div class="userchatboxmain_user"><div class="userchatboxmain_name">&nbsp;</div><div class="userchatboxmain_text" <?php if($img==1){ ?>style=" padding:0px !important;"<?php } ?>><?php if($img==0){?><div class="chatmsg<?php if (strpos($row["chatText"], 'maps/place') !== false) { ?> iframehave<?php } ?>"><?php echo nl2br(showsmily(str_replace("'","&#39;",$row["chatText"])));?></div><?php } else { ?><div class="imgbox"><img src="<?php echo $fullurl;?>uploads/<?php echo $row["chatFileName"]; ?>" style="width:200px;" onClick="imagepopupmain(\''+contentimg+'\');" /></div><?php } ?><div class="userchatboxmain_time"><?php echo date("h:i A",$row['dateAdded']); ?></div></div></div></div>');

$('#chatlist<?php echo ($_REQUEST['stmtId']); ?>').removeClass('active');

$("#loadstmtchat").scrollTop($("#loadstmtchat")[0].scrollHeight);
</script>

<?php
$sql_ins="UPDATE "._STUDENT_MENTOR_CHAT_MASTER_TABLE_." SET status=1 WHERE contactId= $stmtSafeId AND userId='".$_SESSION["sessUserId"]."' and id='".$msgid."' ";
mysqli_query($conn,$sql_ins) or die(mysqli_error($conn));  

if($row["meeting"]==1 && $row["status"]==0){
?>
<script>
parent.$('#loadstmtchat').load("<?php echo $fullurl; ?>load_chat_user_msg.php?userId2=<?php echo $_REQUEST['stmtId'];?>");
</script>
<?php }?>

<?php

} } 

$a="";
$a="select blockUser from "._CONTACT_MASTER_TABLE_." where contactId='".$_SESSION['sessUserId']."' AND userId=$stmtSafeId ";
$b=mysqli_query($conn,$a);
$c=mysqli_fetch_array($b); 
if($c["blockUser"]!=1)
{	

	
$sqlLogin2="";
$sqlLogin2="select id,readDate,dateAdded from "._STUDENT_MENTOR_CHAT_MASTER_TABLE_." where userId='".$_SESSION['sessUserId']."' and contactId=$stmtSafeId and status=1 ORDER BY dateAdded desc LIMIT 0,1";
	$resLogin2=getRecords(_STUDENT_MENTOR_CHAT_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlLogin2); 	
	if($resLogin2)
	{
		while($row2=mysqli_fetch_array($resLogin2))
			{
			
		$aa="SELECT readDate from "._STUDENT_MENTOR_CHAT_MASTER_TABLE_." where contactId='".$_SESSION['sessUserId']."' and userId=$stmtSafeId  ORDER BY dateAdded desc						 LIMIT 0,1"; 
			$res5 = mysqli_query($conn,$aa);
			
			$getread=mysqli_fetch_array($res5);
			if($getread['readDate']!=0 && $getread['readDate']!='')
			{
				 
				?>
				<script> 
				$('.fa-check-circle span').remove();
			$('.fa-check-circle').removeClass('fa-check-circle'); 
			$('#usermsgid<?php echo $row2['id']; ?>').html('<i class="fa fa-check-circle" aria-hidden="true"> <span>Read</span></i><?php echo date("h:i A",$row2['dateAdded']); ?>');
			</script>
				<?php
				 
			}
		

 $sql_ins="UPDATE "._STUDENT_MENTOR_CHAT_MASTER_TABLE_." SET readDate=".time()." WHERE readDate=0 and  contactId= $stmtSafeId AND userId='".$_SESSION["sessUserId"]."' ";
mysqli_query($conn,$sql_ins) or die(mysqli_error($conn));
	
			
			
			}
			
	}
	
	
}


 $sql_ins="UPDATE "._STUDENT_MENTOR_CHAT_MASTER_TABLE_." SET chatStatus=0 WHERE contactId= $stmtSafeId AND userId='".$_SESSION["sessUserId"]."' ";
mysqli_query($conn,$sql_ins) or die(mysqli_error($conn));



}



closeConn();
?>