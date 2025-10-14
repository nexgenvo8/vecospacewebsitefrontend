<?php
include_once('inc.php'); 
include_once('mail.php');
$companNameTitle="Jamia Millia Islamia VECOSPACE";
$fullurl="http://jamia.vecospace.com/";
$subject="Please confirm your ".$companNameTitle." registration now.";
$query = "select * from userMaster where activeYN='N' and userId>1037 order by userId asc LIMIT 50";
$querylist=mysqli_query($conn, $query);
while($querydata=mysqli_fetch_array($querylist)){
$firstName=$querydata['firstName'];
$strEmail=$querydata['email'];
$email=$strEmail;

$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%&*_";
$password = substr( str_shuffle( $chars ), 0, 8 );

$queryy="UPDATE userMaster SET password='".md5($password)."',activeYN='Y' WHERE userId='".$querydata['userId']."'";

mysqli_query($conn, $queryy);

$mailBodyContent='<div style="padding:20px 0px; text-align:center; background-color:#FFFFFF;"><a href="'.$fullurl.'timeline.html" style="border:0px;"><img src="'.$fullurl.'images/logo.jpg" width="217" style="border:0px;"></a></div><div style="background-color:#f4f4f4; font-family:Arial, Helvetica, sans-serif; font-size:13px; overflow:hidden; padding:30px 0px;text-align:center;">
<div style="margin:auto; width:600px; background-color:#FFFFFF; text-align:left;">
<table style="width:100%;background-color: #e8e8e8;">
<tbody><tr>
<td colspan="3" height="20" style="height:20px;font-size:0px;text-align:center">

    <a style="text-decoration:underline;font-family:arial,sans-serif;font-size:11px;color:#666666">If this e-mail isn&prime;t displayed correctly, please click here.</a></td></tr>

    </tbody></table>
<div style="padding:30px;">



<div style="padding:10px;background-color: #F9F9F9;border:dashed 1px #ccc;border-radius: 2px;">



<div style="color: #696969; font-size: 14px; line-height: 20px;">
    
    <h2 style="
    font-weight: 500;
    font-size: 15px;
    line-height: 23px;
    color: #676767;
"><div style="display:block; font-size:18px; margin-bottom:10px;">Hello '.$firstName.'</div>

Thank you for registering with us. We are thrilled to have you on '.$companNameTitle.'. To get you fully on board, please login from the below mentioned credetials. </h2></div><div style="text-align:left; margin-top:20px; margin-bottom:0px;"><div></div><table width="100%" height="90" bgcolor="#ffffff" border="0" cellpadding="0" cellspacing="0" style="
    background-color: #f7f7f7;"><tbody><tr><td>URL</td><td>'.$fullurl.'</td></tr><tr><td>Email Address</td><td>'.$email.'</td></tr><tr>
  <td>Password</td>
  <td>'.$password.'</td>
</tr></tbody></table></div>
</div>


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
				
				//$mailSent=@mail($email,$subject,$mailBodyContent,$headers);
				send_template_mail(_FROM_EMAIL_TEMPLATE_ID_,$email,$subject,$mailBodyContent);
 
}
?>