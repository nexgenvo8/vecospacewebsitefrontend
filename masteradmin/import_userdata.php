<?php
require("inc.php");
require("common.php");
require("website_security.php");

$resultkk =mysql_query ("select id from wfs_admin where username='".$_SESSION['username']."'");
$resultAdmin =mysql_fetch_array($resultkk);

$dateAdded=time();
$modifyDate=time();

$addedBy=$resultAdmin['id'];
$modifyBy=$resultAdmin['id'];

/*-----------------Add Commond---------------*/

if(isset($_REQUEST['add']))
{
include_once('../mail.php');

$backpage=$_POST['backpage'];

$attachmentFile=trim($_POST["attachmentFile"]);

require_once 'reader.php';

  if($_FILES['attachmentFile']['name']!=''){
  $file_name=$_FILES['attachmentFile']['name'];
  $file_name=time().'-'.$file_name;
  copy($_FILES['attachmentFile']['tmp_name'],"attachment/".$file_name);

  $data = new Spreadsheet_Excel_Reader();
  //$data->setOutputEncoding('CP1251');
  $data->setOutputEncoding('UTF-8');
  $path="attachment/".$file_name;
  $data->read($path);

    for($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
        $FirstName = trim(addslashes($data->sheets[0]["cells"][$x][1]));
        $LastName = trim(addslashes($data->sheets[0]["cells"][$x][2]));
        $EmailExcel = trim($data->sheets[0]["cells"][$x][3]);
        $EmailExcel = str_replace(' ', '', $EmailExcel);
        $EmailExcel = preg_replace('/\s+/', '', $EmailExcel);
        
        file_put_contents('emailfile.txt', $EmailExcel);
        $Email = file_get_contents("emailfile.txt");
        
        //$Password = trim(addslashes($data->sheets[0]["cells"][$x][4]));
        //$passtosent = $data->sheets[0]["cells"][$x][4];
        $passtosent = mt_rand(1000,200000000);
        $Password = md5($passtosent);
        $dateofbirth = trim(addslashes($data->sheets[0]["cells"][$x][4]));
        $DOB = date('Y-m-d',strtotime($dateofbirth));
        $Gender = trim(addslashes($data->sheets[0]["cells"][$x][5]));
        $UserType = trim(addslashes($data->sheets[0]["cells"][$x][6]));
        $Department = trim(addslashes($data->sheets[0]["cells"][$x][7]));
        $Course = trim(addslashes($data->sheets[0]["cells"][$x][8]));
        $PassingYear = trim(addslashes($data->sheets[0]["cells"][$x][9]));
        // $Univercity = trim(addslashes($data->sheets[0]["cells"][$x][11]));

        $firstNameUrl=makeContentUrl($FirstName);
		$lastNameUrl=makeContentUrl($LastName);
		
		if($UserType=="Student"){
		    $UserType = 1;
		}else if($UserType=="Faculty"){
		    $UserType = 2;
		}else if($UserType=="Alumni"){
		    $UserType = 3;
		}else if($UserType=="Industry Professional"){
		    $UserType = 4;
		}else if($UserType=="Career Enhancer / Service Provider"){
		    $UserType = 5;
		}else{
		   //
		}

		$userurl=$firstNameUrl.'-'.$lastNameUrl;
        $regDate = time();

        /////////////////////////////////MAIL BODY START////////////////////////////////////////////
        $strEmail='';
		$strEmail=base64_encode(base64_encode(base64_encode(base64_encode($Email))));
		$mailBodyContent='';

		$mailBodyContent='<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;"><a href="'.$websiteurl.'timeline.html" style="border:0px;">
		<img src="'.$websiteurl.'images/logoo.jpg" width="217" style="border:0px;"></a></div><div style="background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:scroll; padding:30px 0px;text-align:center;">
<div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
<table style="width:100%;background-color: #e8e8e8;">
<tbody><tr>
<td colspan="3" height="20" style="height:20px;font-size:0px;text-align:center">

<a style="text-decoration:underline;font-family:arial,sans-serif;font-size:11px;color:#666666">If this e-mail isn&prime;t displayed correctly, please click here.</a></td></tr>

</tbody></table>
<div style="padding:30px;">



<div style="padding:10px;background-color: #F9F9F9;border:dashed 1px #ccc;border-radius: 2px;width: 100%;
    overflow-y: scroll;">



<div style="color: #696969; font-size: 14px; line-height: 20px;">

<h2 style="
font-weight: 500;
font-size: 15px;
line-height: 23px;
color: #676767;
"><div style="display:block; font-size:18px; margin-bottom:10px;">Hello '.$FirstName.'</div>

Thank you for registering with us. We are thrilled to have you on '.$companNameTitle.'. To get you fully on board, we request you to verify your email address, by clicking on the button below.	</h2></div><div style="text-align:left; margin-top:20px; margin-bottom:30px;"><a href="'.$websiteurl.'confirm-registration.html?_j='.$strEmail.'" style="text-decoration:none;"><input name="" type="button" style="background-color:#1db055;cursor: pointer; padding:12px 30px; outline:0px; border:0px; border-radius: 3px; color:#FFFFFF; font-size:16px; cursor:pointer;" value="Confirm e-mail address"></a></div> After Confirmation Please login your account using your email id: <span style="font-weight:700;">'.$Email.'</span> and password: <span style="font-weight:700;">'.$passtosent.'</span> and change your password from account Setting -> My Account.

</div>


<table width="100%" height="90" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="
background-color: #f7f7f7;
"><tbody><tr><td colspan="3" width="100%" height="10" style="width:100%;height:10px;line-height:0px;font-size:0px">&nbsp;</td></tr><tr><td width="25" style="width:4%">&nbsp;</td><td width="480" height="80" style="width:80%;height:80px;font-family:Arial;font-size:13px;color:#808080;line-height:18px;text-align:left">Is the button not working? Please copy this link to your browser:<br><br><a href="'.$websiteurl.'confirm-registration.html?_j='.$strEmail.'" style="font-family:Helvetica,Arial,sans-serif;font-size:12px;color:#179cd0;word-break:break-all" target="_blank">'.$websiteurl.'confirm-registration.html?_j='.$strEmail.'</a></td><td width="25" style="width:4%">&nbsp;</td></tr><tr><td colspan="3" height="10" style="height:10px;line-height:0px;font-size:0px">&nbsp;</td></tr></tbody></table>

<div style="    margin-top: 20px;
text-align: right;
line-height: 30px;padding-top: 5px;
border-top: solid 1px #e7e7e7;
color: #afafaf;">Powered by '.$companNameTitle.'
</div>
</div>
</div>
</div>';


		$subject="Please confirm your ".$companNameTitle." registration now.";

		$headers = 'From: '.$companNameTitle.'<do_not_reply@scgindia.in>' . "\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    /////////////////////////////////MAIL BODY END////////////////////////////////////////////
        $result1="SELECT COUNT(*) as num FROM userMaster WHERE email='".$Email."'";
		$count=mysql_fetch_array(mysql_query($result1));
		$count1 = $count['num'];
		if($count1==0){
		  $sql_ins="insert into userMaster set firstName='$FirstName',lastName='$LastName',email='$Email',password='$Password',dob='$DOB',gender='$Gender',
		  userstype='$UserType',departmentname='$Department',coursename='$Course',passingyear='$PassingYear',userurl='$userurl',regDate='$regDate',activeYN='N';";
          mysql_query($sql_ins) or die(mysql_error());
          $lastId=mysql_insert_id();

          $sql_insSett="insert into userSettingsMaster set userId='$lastId';";
          mysql_query($sql_insSett) or die(mysql_error());
          send_template_mail_new(_FROM_EMAIL_TEMPLATE_ID_,$Email,$subject,$mailBodyContent);
            //send_template_mail(_FROM_EMAIL_TEMPLATE_ID_,$Email,$subject,$mailBodyContent);
		}else{
		    $updates = [];

            // Check each variable and add only if not empty
            if (!empty($DOB)) {
                $updates[] = "dob = '$DOB'";
            }
            if (!empty($Gender)) {
                $updates[] = "gender = '$Gender'";
            }
            if (!empty($UserType)) {
                $updates[] = "userstype = '$UserType'";
            }
            if (!empty($Department)) {
                $updates[] = "departmentname = '$Department'";
            }
            if (!empty($Course)) {
                $updates[] = "coursename = '$Course'";
            }
            if (!empty($PassingYear)) {
                $updates[] = "passingyear = '$PassingYear'";
            }
            
            // Only run query if we have something to update
            if (!empty($updates)) {
                $sql_ins = "UPDATE userMaster SET " . implode(", ", $updates) . " WHERE email = '$Email'";
                // Run query here
                mysqli_query($conn, $sql_ins);
            }
		  $sql_ins="update userMaster set email='$Email',dob='$DOB',gender='$Gender',userstype='$UserType',
		  departmentname='$Department',coursename='$Course',passingyear='$PassingYear' where email ='$Email'";
           mysql_query($sql_ins) or die(mysql_error());
          //send_template_mail_new(_FROM_EMAIL_TEMPLATE_ID_,$Email,$subject,$mailBodyContent);
		}

		//$mailSent=@mail($email,$subject,$mailBodyContent,$headers);


    }


  }



header("location:$backpage?action=add");

}

?>
<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title><?php if($_REQUEST['id']!=""){ echo "Edit"; } else {  echo "Add"; } ?> -
        <?php echo $_REQUEST['pagetitle']; ?> - <?php echo $profile['company']; ?></title>
    <link href="css/main.css" rel="stylesheet" type="text/css" />

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js" type="text/javascript"></script>
    <script language="JavaScript" type="text/javascript" src="ckeditor/ckeditor.js"></script>
    <script language="JavaScript" type="text/javascript" src="ckeditor/ckfinder/ckfinder.js"></script>
    <script type="text/javascript" src="js/jquery.js"></script>
    <script type="text/javascript" src="js/ddaccordion.js"></script>
    <script type="text/javascript" src="js/js.js"></script>
</head>

<body id="leftbgblack">
    <?php include "header.php"; ?>
    <table width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td width="9%" align="left" valign="top" style="width:176px;"> <?php include "left.php"; ?> </td>
            <td width="91%" align="left" valign="top">

                <div class="innerouter">
                    <div class="innertitlebox">
                        <table width="100%" border="0" cellpadding="0" cellspacing="0">
                            <tr>
                                <td width="36"><img src="images/addpage.png" width="32" height="32" /></td>
                                <td>
                                    <h3><?php if($_REQUEST['id']!=""){ echo "Edit"; } else {  echo ""; } ?>
                                        IMPORT USER</h3>
                                </td>
                                <td width="151" align="right" style="width:150px;"><a
                                        href="attachment/userUploadFormat1.xls" class="gradiantbtn">Download Format</a>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="loading" id="globalpageloding" style="display:none;">Please Wait Working...</div>
                    <form action="" method="post" enctype="multipart/form-data">

                        <div class="listingbox addeditpage">
                            <table width="100%" border="0" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td width="77%" align="left" valign="top">
                                        <table width="100%" border="0" cellpadding="8" cellspacing="0">
                                            <tr>
                                                <td width="19%" align="left" valign="top">Upload File</td>
                                                <td width="81%" align="left" valign="top">
                                                    <input name="attachmentFile" type="file" id="attachmentFile"
                                                        value="" style="width:98%;" required>
                                                </td>
                                            </tr>




                                        </table>
                                    </td>
                                    <td width="23%" align="left" valign="top" style="width:250px;">
                                        <div style="margin-left:10px;" class="featureimagebox">
                                            <table width="100%" border="0" align="center" cellpadding="0"
                                                cellspacing="0">
                                                <tr>
                                                    <td align="center"><input name="Submit" type="submit"
                                                            class="bluebutton" id="Submit" value="   Upload Data   "
                                                            onclick="globalloading();" />
                                                        <?php if($_REQUEST['id']!=""){ ?>
                                                        <input name="edit" type="hidden" id="edit" value="edit" />
                                                        <input name="id" type="hidden" id="id"
                                                            value="<?php echo $_REQUEST['id']; ?>" />
                                                        <?php } else { ?>
                                                        <input name="add" type="hidden" id="add" value="add" />
                                                        <?php } ?>
                                                        <input name="backpage" type="hidden" id="backpage"
                                                            value="subscription_list.php" />
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                        <br />
                                        <?php if($_REQUEST['id']!=""){ ?>
                                        <div class="gradiantbtn"
                                            style="padding-top:20px; font-size:12px; margin-left:10px;">
                                            <div align="center" style="padding-bottom:10px;">Added on: <em>
                                                    <?php
	echo date("g:ia jS F Y", $post_result['dateAdded']);?>
                                                </em></div>
                                            <?php if($post_result['modifyDate']!=0){ ?>
                                            <div align="center" style="padding-bottom:10px;">Last update: <em>
                                                    <?php
	echo date("g:ia jS F Y", $post_result['modifyDate']);?>
                                                </em></div>
                                        </div>
                                        <?php } } ?>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </form>
                </div>
            </td>
        </tr>
    </table>

    <?php include "footer.php"; ?>

</body>

</html>