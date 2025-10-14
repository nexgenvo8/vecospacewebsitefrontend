<?php
/*
 * PHP Example for Google Storage Up- and Download 
 * with Google APIs Client Library for PHP:
 * https://github.com/google/google-api-php-client
 */

require 'vendor/autoload.php';

use Google\Cloud\Core\ServiceBuilder;

$serviceAccount		= "1234-xyz@developer.gserviceaccount.com";
$key_file		= "/path/to/keyfile.p12";

$bucket			= "my_bucket";
$file_name		= "test.txt";
$file_content		= "01101010 01110101 01110011 01110100 00100000 01100001 00100000 01110100 01100101 01110011 01110100";


$auth = new Google_Auth_AssertionCredentials(
					$serviceAccount,
					array('https://www.googleapis.com/auth/devstorage.read_write'),
					file_get_contents($key_file)
					);

$client = new Google_Client();
$client->setAssertionCredentials( $auth );

$storageService = new Google_Service_Storage( $client );


/***
 * Write file to Google Storage
 */
try 
{

	$postbody = array( 
			'name' => $file_name, 
			'data' => $file_content,
			'uploadType' => "media"
			);

	$gsso = new Google_Service_Storage_StorageObject();
	$gsso->setName( $file_name );

	$result = $storageService->objects->insert( $bucket, $gsso, $postbody );

	print_r($result);
	
}      
catch (Exception $e)
{
	print $e->getMessage();
}


/***
 * Read file from Google Storage
 */
try 
{

   $object = $storageService->objects->get( $bucket, $file_name );

   $request = new Google_Http_Request($object['mediaLink'], 'GET');
   $signed_request = $client->getAuth()->sign($request);
   $http_request = $client->getIo()->makeRequest($signed_request);
   echo $http_request->getResponseBody();
}      
catch (Exception $e)
{
    print $e->getMessage();
}

?>
