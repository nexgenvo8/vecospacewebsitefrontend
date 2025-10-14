<?php
require __DIR__ . '/vendor/autoload.php';

use Google\Client;
use Google\Service\Gmail;
use Google\Service\Gmail\Message;

function getClient()
{
    $client = new Client();
    $client->setApplicationName('Gmail API PHP Quickstart');
    $client->setScopes(Gmail::GMAIL_SEND);
    $client->setAuthConfig('credentials.json');
    $client->setAccessType('offline');
    $client->setPrompt('select_account consent');
    //$redirect_uri = 'http://localhost/email/run.php';
   // $client->setRedirectUri($redirect_uri);
    // Load previously authorized token from a file, if it exists.
    $tokenPath = 'token.json';
    if (file_exists($tokenPath)) {
        $accessToken = json_decode(file_get_contents($tokenPath), true);
        $client->setAccessToken($accessToken);

    }
    $token="";
    if (isset($_GET['code'])) {
        $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
    }

    // If there is no previous token or it's expired, get a new one.
    if ($client->isAccessTokenExpired()) {
        if ($client->getRefreshToken()) {
            $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        } else {

            $authUrl = $client->createAuthUrl();
            printf("Open the following link in your browser:\n%s\n", $authUrl);
            print 'Enter verification code: ';
            $authCode = trim(fgets($token));

            // Exchange authorization code for an access token.
            $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);

            $client->setAccessToken($accessToken);

            // Check to see if there was an error.
            if (array_key_exists('error', $accessToken)) {
                throw new Exception(join(', ', $accessToken));
            }
        }
        // Save the token to a file.
        if (!file_exists(dirname($tokenPath))) {
            mkdir(dirname($tokenPath), 0700, true);
        }
        file_put_contents($tokenPath, json_encode($client->getAccessToken()));
    }
    return $client;
}

function createMessage($to, $subject, $messageText)
{
    $message = new Message();
    $rawMessageString = "From: me\r\n";
    $rawMessageString .= "To: $to\r\n";
    $rawMessageString .= "Subject: $subject\r\n\r\n";
    $rawMessageString .= $messageText;
    $rawMessage = strtr(base64_encode($rawMessageString), array('+' => '-', '/' => '_'));
    $message->setRaw($rawMessage);
    return $message;
}

function sendMessage($service, $userId, $message)
{
    try {
        $message = $service->users_messages->send($userId, $message);
        printf("Message sent! Message ID: %s\n", $message->getId());
        return $message;
    } catch (Exception $e) {
        print 'An error occurred: ' . $e->getMessage();
    }
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Gmail($client);

// Create and send the email.
$to = 'satendragurjar844@gmail.com';
$subject = 'Test email';
$messageText = 'This is a test email sent from PHP!';
$message = createMessage($to, $subject, $messageText);

$redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF']; $client->setRedirectUri($redirect_uri);
sendMessage($service, 'me', $message);

?>