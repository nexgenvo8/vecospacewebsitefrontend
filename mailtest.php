<?php
// using SendGrid's PHP Library
// https://github.com/sendgrid/sendgrid-php
// If you are using Composer (recommended)
//require 'vendor/autoload.php';
// If you are not using Composer
require("sendgrid-php/sendgrid-php.php");
$from = new SendGrid\Email("Example User", "noreply@deboxglobal.in");
$subject = "I am Sendgrid alim test mail";
$to = new SendGrid\Email("Example User", "r.pahat786@gmail.com");
$content = new SendGrid\Content("text/plain", "and easy to do anywhere, even with PHP");
$mail = new SendGrid\Mail($from, $subject, $to, $content);
	$apiKey = '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';
$sg = new \SendGrid($apiKey);
$response = $sg->client->mail()->send()->post($mail);
echo $response->statusCode();
print_r($response->headers());
echo $response->body();


?>