<?php
///////////////image script start/////////////////
function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
 
 
$datef=date("Fj-Y-g-ia"); 


 if($_SERVER["REQUEST_METHOD"] == "POST")
 {
 	$image =$_FILES["file1"]["name"];
	$uploadedfile = $_FILES['file']['tmp_name'];
     
 
 	if ($image) 
 	{
 	
 		$filename = stripslashes($_FILES['file1']['name']);
 	
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
		
		
 if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 		{
		
 			$change='<div class="msgdiv">Unknown Image extension </div> ';
 			$errors=1;
			header("location: $targetpage?action=add");
 		}
 		else
 		{

 $size=filesize($_FILES['file1']['tmp_name']);


if ($size > MAX_SIZE*2040)
{
	$change='<div class="msgdiv">You have exceeded the size limit!</div> ';
	$errors=1;
	header("location: $targetpage?action=add");
}



if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['file1']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);

}
else if($extension=="png")
{
$uploadedfile = $_FILES['file1']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);

}
else 
{
$src = imagecreatefromgif($uploadedfile);
}

echo $scr;

list($width,$height)=getimagesize($uploadedfile);


$newwidth=150;
$newheight=($height/$width)*$newwidth;
$tmp=imagecreatetruecolor($newwidth,$newheight);


$newwidth1=98;
$newheight1=($height/$width)*$newwidth1;
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

//$newwidth2=670;
//$newheight2=315;
//$tmp2=imagecreatetruecolor($newwidth2,$newheight2);

$newwidth2=216;
$newheight2=($height/$width)*$newwidth2;
$tmp2=imagecreatetruecolor($newwidth2,$newheight2);

$newwidth3=299;
$newheight3=($height/$width)*$newwidth3;
$tmp3=imagecreatetruecolor($newwidth3,$newheight3);

$newwidth4=85;
$newheight4=($height/$width)*$newwidth4;
$tmp4=imagecreatetruecolor($newwidth4,$newheight4);

$newwidth5=172;
$newheight5=($height/$width)*$newwidth5;
$tmp5=imagecreatetruecolor($newwidth5,$newheight5);

$newwidth6=121;
$newheight6=($height/$width)*$newwidth6;
$tmp6=imagecreatetruecolor($newwidth6,$newheight6);

$newwidth7=320;
$newheight7=($height/$width)*$newwidth7;
$tmp7=imagecreatetruecolor($newwidth7,$newheight7);

$newwidth8=320;
$newheight8=($height/$width)*$newwidth8;
$tmp8=imagecreatetruecolor($newwidth8,$newheight8);


$newwidth9=288;
$newheight9=($height/$width)*$newwidth9;
$tmp9=imagecreatetruecolor($newwidth9,$newheight9);



imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);

imagecopyresampled($tmp2,$src,0,0,0,0,$newwidth2,$newheight2,$width,$height);

imagecopyresampled($tmp3,$src,0,0,0,0,$newwidth3,$newheight3,$width,$height);

imagecopyresampled($tmp4,$src,0,0,0,0,$newwidth4,$newheight4,$width,$height);

imagecopyresampled($tmp5,$src,0,0,0,0,$newwidth5,$newheight5,$width,$height);

imagecopyresampled($tmp6,$src,0,0,0,0,$newwidth6,$newheight6,$width,$height);

imagecopyresampled($tmp7,$src,0,0,0,0,$newwidth7,$newheight7,$width,$height);

imagecopyresampled($tmp8,$src,0,0,0,0,$newwidth8,$newheight8,$width,$height);

imagecopyresampled($tmp9,$src,0,0,0,0,$newwidth9,$newheight9,$width,$height);

$finimgname=$datef.$_FILES['file1']['name'];






//$filename = "../upload/".$finimgname;


$filename = "../upload/thumb/small".$finimgname;

$filename1 = "../upload/image98/".$finimgname;
$filename2 = "../upload/image216/".$finimgname;
$filename3 = "../upload/image299/".$finimgname;
$filename4 = "../upload/image85x63/".$finimgname;
$filename5 = "../upload/image172x206/".$finimgname;
$filename6 = "../upload/image121x157/".$finimgname;
$filename7 = "../upload/image320x261/".$finimgname;
$filename8 = "../upload/image320x130/".$finimgname;
$filename9 = "../upload/image288x175/".$finimgname;

//$filename2 = "0

imagejpeg($tmp,$filename,100);

imagejpeg($tmp1,$filename1,100);

imagejpeg($tmp2,$filename2,100);

imagejpeg($tmp3,$filename3,100);

imagejpeg($tmp4,$filename4,100);

imagejpeg($tmp5,$filename5,100);

imagejpeg($tmp6,$filename6,100);

imagejpeg($tmp7,$filename7,100);

imagejpeg($tmp8,$filename8,100);

imagejpeg($tmp9,$filename9,100);

imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);
imagedestroy($tmp2);
imagedestroy($tmp3);
imagedestroy($tmp4);
imagedestroy($tmp5);
imagedestroy($tmp6);
imagedestroy($tmp7);
imagedestroy($tmp8);
imagedestroy($tmp9);

}}


//////////////full size image script/////////////////
if($_FILES['file1']['name']!=''){
$file_name_real=$_FILES['file1']['name'];
$ext=$file_name_real;
$file_name=$datef.$ext;
$file_name1=$datef.$ext;
copy($_FILES['file1']['tmp_name'],"../upload/".$file_name1);}

if($_FILES['file2']['name']!=''){
$file_name=$_FILES['file2']['name'];
$ext=$file_name;
$file_name2=$datef.$ext;
copy($_FILES['file2']['tmp_name'],"../upload/".$file_name2);}

if($_FILES['file3']['name']!=''){
$file_name=$_FILES['file3']['name'];
$ext=$file_name;
$file_name3=$datef.$ext;
copy($_FILES['file3']['tmp_name'],"../upload/".$file_name3);}

if($_FILES['file4']['name']!=''){
$file_name=$_FILES['file4']['name'];
$ext=$file_name;
$file_name4=$datef.$ext;
copy($_FILES['file4']['tmp_name'],"../upload/".$file_name4);}
}
///////////////image script end///////////////// ?>