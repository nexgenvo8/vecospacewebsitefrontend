<?php
include_once('inc.php'); 
require_once 'reader.php';

if(isset($_POST["importfield"]))
{

if(!empty($_FILES['importfield']['name'])){
$file_name=$_FILES['importfield']['name'];
copy($_FILES['importfield']['tmp_name'],"importfile/".$file_name);
 
$data = new Spreadsheet_Excel_Reader();
		$data->setOutputEncoding('CP1251');
	     $path="importfile/".$file_name;
		  
$data->read($path);
for ($x = 2; $x <= count($data->sheets[0]["cells"]); $x++) {
 	
$email = trim($data->sheets[0]["cells"][$x][1]);
$firstname = trim($data->sheets[0]["cells"][$x][2]);
$lastname = trim($data->sheets[0]["cells"][$x][3]);
$gender = trim($data->sheets[0]["cells"][$x][4]);
$dob = trim($data->sheets[0]["cells"][$x][5]);

$unix_date = ($dob - 25569) * 86400;
$excel_date = 25569 + ($unix_date / 86400);
$unix_date = ($excel_date - 25569) * 86400;
$dobfinal = gmdate("Y-m-d", $unix_date);

$enrollmentno = trim($data->sheets[0]["cells"][$x][6]); 
   
$query = "INSERT INTO userMaster(email,firstName,lastName,gender,dob,employmentId) VALUES ('".$email."', '".$firstname."', '".$lastname."', '".$gender."', '".$dobfinal."', '".$enrollmentno."')";


mysqli_query($conn,$query);
 
 
 }
 }
 
 ?>
 <script>
alert("Data has inserted successfully!!!!");
</script>
 <?php
 } 

?>

<html>
 <head>
  <title>Registration import Jamia</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" />
  <style>
  body
  {
   margin:0;
   padding:0;
   background-color:#f1f1f1;
  }
  .box
  {
   width:700px;
   border:1px solid #ccc;
   background-color:#fff;
   border-radius:5px;
   margin-top:100px;
  }
  
  </style>
 </head>
 <body>
  <div class="container box">
   <h3 align="center">Registration import Jamia</h3><br />
   <form method="post" enctype="multipart/form-data">
    <label>Select Excel File</label>
    <input type="file" name="importfield" />
    <br />
    <input type="submit" name="importfield" class="btn btn-info" value="Import" />
   </form>
   <?php
   echo $output;
   ?>
  </div>
 </body>
</html>