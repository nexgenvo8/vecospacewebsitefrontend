<?php
include("inc.php");
 
if($_REQUEST['p1']=="p1")
 
{?>
<script>
parent.loginclick();
</script>

<?php
$sql3="select * from wfs_admin  where username='".$_SESSION['username']."'";
$rs3=mysql_query($sql3) or die(mysql_error());
$profile=mysql_fetch_array($rs3);


$oldpassword=$_REQUEST['oldpassword'];

$password=$_REQUEST['password'];
$copassword=$_REQUEST['copassword'];

if($oldpassword==$profile['password']){

if($password==$copassword){

echo $sql_ins="update wfs_admin set password='$password' where username='".$_SESSION['username']."'";
mysql_query($sql_ins) or die(mysql_error());

$errorpass=1; ?>

<script>
parent.successactoin();
</script>

<?php
} else { $errorpass=2; }

} else { $errorpass=2; ?>

 
<?php
} }
if($errorpass!=1){
?>


<script>
parent.loginfaild();
</script>

<?php } ?>