<?php
include_once('inc.php'); 

if(isset($_GET['id']))
{

$id=decodeStr($_REQUEST['id']);

$sqlVault="SELECT id,documentFile,userId,docsDownlods from "._VAULT_MASTER_TABLE_." WHERE id= ".$id." ";
$resVault=mysqli_query($conn, $sqlVault) or die(mysqli_error($conn)); 
$rowVault=mysqli_fetch_array($resVault);

$documentFile=$rowVault['documentFile'];

	
$file_name=str_replace(".xls","",str_replace(".doc","",str_replace(".ppt","",str_replace(".pdf","",$documentFile))));

$zip = new ZipArchive;
if ($zip->open('downloads/'.$file_name.'.zip', ZipArchive::CREATE) === TRUE)
{

    
	// Add files to the zip file inside downloads
	
	//$zip->addFile("uploads/".$documentFile);
	
	
	$zip->addFile("uploads/".$documentFile, $documentFile);
	
	// Add a file new.txt file to zip using the text specified
   // $zip->addFromString($documentFile, $documentFile);
 
    // All files are added, so close the zip file.
    $zip->close();
}
	
$zipname = 'downloads/'.$file_name.'.zip';

header('Content-Type: application/zip');
header("Content-Disposition: attachment; filename='".$zipname."'");
header('Content-Length: ' . filesize($zipname));
header("Location: ".$zipname."");	
	

//if($rowVault['userId']!=$_SESSION["sessUserId"])
//{
	if($id!=0)
	{
		unset($insertFields);
		unset($insertVals);	
		unset($whereFields);	
		unset($whereVals);					
		
		$insertFields[0]="docsDownlods";
		
		$insertVals[0]=$rowVault['docsDownlods']+1;
		
		$whereFields[0]="id";
		
		$whereVals[0]=$id;
		
		$resUpdate=updateDB(_VAULT_MASTER_TABLE_,$insertFields,$insertVals,$whereFields,$whereVals,_N_,'');
	}
//}	


}
?>