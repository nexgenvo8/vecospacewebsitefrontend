<?php 
include("inc.php");
include("common.php");
error_reporting(0);
 

//----------upload multiple images-------

 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }




$datef=date("Y-m-d-H-i-s");	  

if(isset($_FILES['files'])){ 

    $errors= array();
	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){
	  $file_name = $key.$_FILES['files']['name'][$key];
		  $file_size =$_FILES['files']['size'][$key];
		$file_tmp =$_FILES['files']['tmp_name'][$key];
		$file_type=$_FILES['files']['type'][$key];	
/*?> if($file_size > 2097152){
			$errors[]='File size must be less than 2 MB';
        }<?php */	
		
		    <<<EOF

EOF;



	
$add_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$adduser=$_SESSION['username'];	
$cid=$_REQUEST['cid'];	


$reimage=$datef.$file_name;
 
		
mysql_query("insert into `wfs_pageimages` SET 
`name` = '$name',  
`image` = '$reimage', 
`add_date` = '$add_date',
`lastip` = '$lastip', 
`adduser` = '$adduser',
`type` = 'pageimg',
`category` = '$cid'");
		
		
        $desired_dir="../upload";
        if(empty($errors)==true){
            if(is_dir($desired_dir)==false){
                mkdir("$desired_dir", 0700);		// Create directory if it does not exist
            }
            if(is_dir("$desired_dir/".$datef.$file_name)==false){
                move_uploaded_file($file_tmp,"$desired_dir/".$datef.$file_name);
				
				
				//thumb starts
				
				
				
$image =$datef.$file_name;


if ($image) 
{

$file_name=$datef.$file_name;

$filename = $file_name;

$extension = getExtension($filename);
$extension = strtolower($extension);


if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
{

$change='<div class="msgdiv">Unknown Image extension </div> ';
$errors=1; ?>


<?php }
else
{

$size=filesize("../upload/".$file_name);


 



if($extension=="jpg" || $extension=="jpeg" )
{
$src = imagecreatefromjpeg("../upload/".$file_name);

}
else if($extension=="png")
{
$src = imagecreatefrompng("../upload/".$file_name);

}
else 
{
$src = imagecreatefromgif("../upload/".$file_name);
}



list($width,$height)=getimagesize("../upload/".$file_name);




$newwidth1=100;
$newheight1=($height/$width)*$newwidth1;
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

$newwidth2=670;
$newheight2=315;
$tmp2=imagecreatetruecolor($newwidth2,$newheight2);
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);

imagecopyresampled($tmp2,$src,0,0,0,0,$newwidth2,$newheight2,$width,$height);

$finimgname=$file_name;



$filename1 = "../upload/thumb/small".$finimgname;



imagejpeg($tmp,$filename,100);

imagejpeg($tmp1,$filename1,100);

imagejpeg($tmp2,$filename2,100);

imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);
imagedestroy($tmp2);

}}

				
				// thumb ends
            }else{									// rename the file if another one exist
                $new_dir="$desired_dir/".$file_name.time();
                 rename($file_tmp,$new_dir) ;				
            }
		 mysql_query($query);			
        }else{
               // print_r($errors);
        }
    }
	if(empty($error)){ ?>
<script>
window.opener.location.reload();
</script>
		
	<?php }
}



 

?>

<script language="javascript">
parent.location.reload();
</script>