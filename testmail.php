<?php
require("sendgrid-php/sendgrid-php.php"); 

error_reporting(1);


$from = new SendGrid\Email("Example User test", "noreply@deboxglobal.in");
$subject = "test mail";
$to = new SendGrid\Email("Imran", "r.pahat786@gmail.com");
$content = new SendGrid\Content("text/plain", "Imran test mail");
$mail = new SendGrid\Mail($from, $subject, $to, $content);
    $apiKey = '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';
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);
echo $response->statusCode();
print_r($response->headers());
echo $response->body();

/*require_once('PHPMailer/class.phpmailer.php'); 
include("PHPMailer/class.smtp.php");  */



/*
function send_template_mail($fromemail,$to,$subject,$description) 
{
//echo $fromemail.$to.$subject.$description;

$from = new SendGrid\Email("ConnecWRK", "noreply@connecwrk.com");
$subject = $subject;
$to = new SendGrid\Email($to, $to);
$content = new SendGrid\Content("text/html", $description);
$mail = new SendGrid\Mail($from, $subject, $to, $content);
	$apiKey = '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';
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);

print_r($response);


/*



        $mail = new PHPMailer();

		$mail->IsSMTP();

		$mail->SMTPAuth = true;

		$mail->SMTPSecure = "tls";

		$mail->Host = 'mail.scgindia.in';

		$mail->Port = '587';  

		$mail->Username = 'support@scgindia.in';

		$mail->Password = 'admin@123'; 

		$mail->From = 'support@scgindia.in';

		$mail->FromName = 'Konectt';

		$mail->Subject = $subject;

		$mail->AltBody = "";

		$mail->MsgHTML($description); 

		$mail->AddAddress($to, "");

		$mail->IsHTML(true);

		$mail->SMTPOptions = array(
		'ssl' => array(
		'verify_peer' => false,
		'verify_peer_name' => false,
		'allow_self_signed' => true
		)
		);
		$mail->Send();
		

}

echo send_template_mail('alimhali01@gmail.com','r.pahat786@gmail.com','test','hello there');
*/

?>

