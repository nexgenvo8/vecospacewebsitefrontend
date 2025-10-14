<?php
session_start();
include("lib/conn.php");

/*require("inc.php");
require("common.php");
require("website_security.php");

if(trim($_SESSION["username"])!="")
{
	header("location:index.php");
	exit();
}*/

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

if($username!="" && $password!=""){ ?>

<script>
parent.loginclick();
</script>

<?php
$result =mysql_query ("select * from wfs_admin where username='".$_REQUEST['username']."' and  password='".$_REQUEST['password']."' and type=2")  or die(mysql_error());
 	$number =mysql_num_rows($result);

	
	if($number>0)
	{
		$row =@mysql_fetch_array($result); 
		
		$_SESSION['username']=$row['username'];
		$_SESSION['usertype']=$row['type'];
		
////////////security////////////////
$customer_id=$row['id'];
$_SESSION["ors_cus_sess_login_status"]=session_id()."_".$customer_id."_login";
$_SESSION["ors_cus_sess_customer_id"]=$customer_id;
		?>
 
 

<script>
parent.window.location.href = "index.php";
</script>

<?php } else { ?>

<script>
parent.loginfaild();
</script>


<?php } } ?>


 