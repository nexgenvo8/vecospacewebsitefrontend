<?php
require 'vendor/autoload.php';

use Google\Cloud\Core\ServiceBuilder;
use Google\Cloud\Storage\StorageClient;
// Authenticate using a keyfile path
$cloud = new ServiceBuilder([
    'keyFilePath' => 'konectt-194102186ad9.json'
]);

// Authenticate using keyfile data
$cloud = new ServiceBuilder([
    'keyFile' => json_decode(file_get_contents('konectt-194102186ad9.json'), true)
]);



$projectId = 'konectt-179912';

# Instantiates a client
$storage = new StorageClient([
    'projectId' => $projectId
]);

# The name for the new bucket
$bucketName = 'scg-test';

# Creates the new bucket
$bucket = $storage->createBucket($bucketName);

//echo 'Bucket ' . $bucket->name() . ' created.';

var_dump($cloud);


?>