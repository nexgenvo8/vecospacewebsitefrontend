<?php
include("inc.php");
error_reporting(0);



if($_REQUEST['action']=="del"){
$sql_del="delete from  wfs_pageimages  where id='".$_REQUEST['id']."' and type = 'pageimg'";
mysql_query($sql_del) or die(mysql_error());


}
 
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Select Image</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<div style="display:none;">
<?php
if(isset($_REQUEST['add']))
{
if($_FILES["file"]["name"]!=""){

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
$image =$_FILES["file"]["name"];
$uploadedfile = $_FILES['file']['tmp_name'];


if ($image) 
{

$filename = stripslashes($_FILES['file']['name']);

$extension = getExtension($filename);
$extension = strtolower($extension);

 
$size=filesize($_FILES['file']['tmp_name']);


 



if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['file']['tmp_name'];
$src = imagecreatefromjpeg($uploadedfile);

}
else if($extension=="png")
{
$uploadedfile = $_FILES['file']['tmp_name'];
$src = imagecreatefrompng($uploadedfile);

}
else 
{
$src = imagecreatefromgif($uploadedfile);
}



list($width,$height)=getimagesize($uploadedfile);




$newwidth1=200;
$newheight1=($height/$width)*$newwidth1;
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

$newwidth2=670;
$newheight2=315;
$tmp2=imagecreatetruecolor($newwidth2,$newheight2);
imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);

imagecopyresampled($tmp2,$src,0,0,0,0,$newwidth2,$newheight2,$width,$height);

$finimgname=$datef.$_FILES['file']['name'];




$filename1 = "../upload/thumb/small".$finimgname;



imagejpeg($tmp,$filename,100);

imagejpeg($tmp1,$filename1,100);

imagejpeg($tmp2,$filename2,100);

imagedestroy($src);
imagedestroy($tmp);
imagedestroy($tmp1);
imagedestroy($tmp2);

 }

}
$file_name=$_FILES['file']['name'];
$ext=$file_name;
$file_name=$datef.$ext;
copy($_FILES['file']['tmp_name'],"../upload/".$file_name);

$add_date=date("Y-m-d H:i:s");
$lastip=$_SERVER['REMOTE_ADDR'];
$adduser=$_SESSION['username'];


mysql_query("insert into `wfs_pageimages` SET 
`name` = '$name', 
`image` = '$file_name', 
`add_date` = '$add_date',
`lastip` = '$lastip', 
`adduser` = '$adduser',
`type` = 'pageimg'
");
header("location:pageimg.php?action=add");		
 
}}





?>
 </div>
<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/js.js"></script>
</head>



<script type="text/JavaScript">

function cmd_del(){

var x= confirm("Do you want to delete this record?");

if(x)

return true;

else 

return false;



}
</script>

<body>

<?php if($_REQUEST['action']=="add"){ ?><div class="successmsg" id="wrongloginclick" style="display:block;">Added Successfully </div><?php } ?>
<div class="loading" id="globalpageloding" style="display:none;">Please Wait Working...</div>
<div style="overflow:hidden;">
<div class="optionsec addeditpage">
<form action="" method="post" enctype="multipart/form-data">
  <table border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td style="padding-right:10px;">Upload Image </td>
      <td><input type="file" name="file" />
        <input name="add" type="hidden" id="add" value="add" /></td>
      <td><input name="Submit" type="submit" class="bluebutton" value="   Upload   "  onclick="globalloading();"/></td>
    </tr>
  </table>
  </form>
</div>

</div>
<div class="selectimagebox">

 


<?php 
	$tableName = "wfs_pageimages";
$limit = 21;		
 			
			
$classlist=1;
	 $query = "SELECT COUNT(*) as num FROM $tableName where  type='pageimg' order by id desc ";

	$total_pages = mysql_fetch_array(mysql_query($query));

 $total_pages = $total_pages[num];

	

	$stages = 3;

	$page = mysql_escape_string($_GET['page']);

	if($page){

		$start = ($page - 1) * $limit; 

	}else{

		$start = 0;	

		}	

	

    // Get page data

	$query1 = "SELECT * FROM $tableName where   type='pageimg'  order by id desc LIMIT $start, $limit";

	$result = mysql_query($query1);

	

	// Initial page num setup

	if ($page == 0){$page = 1;}

	$prev = $page - 1;	

	$next = $page + 1;							

	$lastpage = ceil($total_pages/$limit);		

	$LastPagem1 = $lastpage - 1;					

	

	

	$paginate = '';

	if($lastpage > 1)

	{	

	



	

	

		$paginate .= "<div class='paginate'>";

		// Previous

		if ($page > 1){

			$paginate.= "<a href='$targetpage?page=$prev'>previous</a>";

		}else{

			$paginate.= "<span class='disabled'>previous</span>";	}

			



		

		// Pages	

		if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up

		{	

			for ($counter = 1; $counter <= $lastpage; $counter++)

			{

				if ($counter == $page){

					$paginate.= "<span class='current'>$counter</span>";

				}else{

					$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					

			}

		}

		elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?

		{

			// Beginning only hide later pages

			if($page < 1 + ($stages * 2))		

			{

				for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)

				{

					if ($counter == $page){

						$paginate.= "<span class='current'>$counter</span>";

					}else{

						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					

				}

				$paginate.= "...";

				$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";

				$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";		

			}

			// Middle hide some front and some back

			elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))

			{

				$paginate.= "<a href='$targetpage?page=1'>1</a>";

				$paginate.= "<a href='$targetpage?page=2'>2</a>";

				$paginate.= "...";

				for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)

				{

					if ($counter == $page){

						$paginate.= "<span class='current'>$counter</span>";

					}else{

						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					

				}

				$paginate.= "...";

				$paginate.= "<a href='$targetpage?page=$LastPagem1'>$LastPagem1</a>";

				$paginate.= "<a href='$targetpage?page=$lastpage'>$lastpage</a>";		

			}

			// End only hide early pages

			else

			{

				$paginate.= "<a href='$targetpage?page=1'>1</a>";

				$paginate.= "<a href='$targetpage?page=2'>2</a>";

				$paginate.= "...";

				for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)

				{

					if ($counter == $page){

						$paginate.= "<span class='current'>$counter</span>";

					}else{

						$paginate.= "<a href='$targetpage?page=$counter'>$counter</a>";}					

				}

			}

		}

					

				// Next

		if ($page < $counter - 1){ 

			$paginate.= "<a href='$targetpage?page=$next'>next</a>";

		}else{

			$paginate.= "<span class='disabled'>next</span>";

			}

			

		$paginate.= "</div>";		

 
}
 
?>  <?php  while($res_post = mysql_fetch_array($result)) { ?>
  <div class="imgb" style="position:relative;"><table width="100%" border="0" cellpadding="0" cellspacing="0" style="height:100px; width:100px;">
  <tr>
    <td align="center" valign="middle"><a href="#" onclick="parent.pageimageselect('<?php echo $res_post['id'] ?>');"><img src="../upload/thumb/small<?php echo $res_post['image'] ?>" alt="<?php echo $res_post['image'] ?>"   border="0" /></a></td>
    </tr>
</table>

<a href="pageimg.php?action=del&id=<?php echo $res_post['id']; ?>&name=<?php echo $res_post['image']; ?>" onclick="return cmd_del();"><img src="images/dlt.png" width="54" style=" position:absolute; right:-1px; top:-1px; width:20px; height:20px; background-color:#FF0000; padding:3px 2px; border:2px #000000 solid; border-radius:50px;" /></a></div>
<?php } ?>
</div>

<div style=" overflow:hidden; text-align:center;">
   <?php  echo $paginate; ?>
 </div>
</body>
</html>
