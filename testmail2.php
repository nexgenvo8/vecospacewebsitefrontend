<?php
/*error_reporting(1);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

include('mail.php');
$fromemail='noreply@deboxglobal.in';
$to='r.pahat786@gmail.com';
$subject='test';
$description='this is test description.';

send_template_mail($fromemail,$to,$subject,$description);

/*require("sendgrid/sendgrid-php.php");

$from = new SendGrid\Email('', "noreply@connecwrk.com");
$subject = "Hello World from the SendGrid PHP Library!";
$to = new SendGrid\Email('', "r.pahat786@gmail.com");
$content = new SendGrid\Content("text/plain", "Hello, Email!");
$mail = new SendGrid\Mail($from, $subject, $to, $content);

$apiKey = getenv('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');
$sg = new \SendGrid($apiKey);

$response = $sg->client->mail()->send()->post($mail);
echo $response->statusCode() . PHP_EOL;
echo $response->body() . PHP_EOL;
echo implode(', ', $response->headers()) . PHP_EOL;

echo "tttt";*/
/*
$from = new SendGrid\Email("Example User test", "noreply@connecwrk.com");
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
*/




?>