<?php
//$connection = mysql_connect("localhost", "vecospac_user", "admin@3214");

$connection = mysqli_connect("154.210.160.217", "veco", "Vec318%#@Pass", "vecospac_db");

if (!$connection) {
    die("Connection failed: (" . mysqli_connect_errno() . ") " . mysqli_connect_error());
}

mysql_connect("154.210.160.217", "veco", "Vec318%#@Pass");
mysql_select_db("vecospac_db");

echo "Connected successfully!";
?>