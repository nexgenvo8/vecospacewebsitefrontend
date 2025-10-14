<?php
session_start();
include("lib/conn.php");
include("common.php");

if(trim($_SESSION["username"])!="")
{
	header("location:index.php");
	exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login - Jamia Millia Islamia</title>
<link href="css/main.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script> 
<script type="text/javascript" src="js/js.js"></script></head>
</head>

<body>
<div id="loginboxouter">
<div id="loginbox">
  <form  method="post" action="loginaction.php" target="postfrm"><table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" style="font-size:25px; text-align:center; padding-bottom:10px;">Master Admin</td>
    </tr>
    <tr>
      <td align="center"> <div class="loading" id="msgload" style="display:none;">Please Wait Working...</div>
	  <div class="loading" id="wrongloginclick" style="display:none;">Login failure, please retry</div></td>
    </tr>
    
    <tr>
      <td><input name="username" type="text" class="login_input" id="username" style="width:224px;"   placeholder="Username"  /></td>
    </tr>
    
    <tr>
      <td><input name="password" type="password" class="login_input" id="password" style="width:224px;"  placeholder="Password" /></td>
    </tr>
    <tr>
      <td align="center"><input type="submit" name="Submit" value="Login" class="bluebutton" style="width:100px;" /></td>
    </tr>
  </table></form>
</div>
</div>

<div class="copyright">  </div>
<iframe id="postfrm" name="postfrm" src="" style="display:none;"></iframe>
</body>
</html>
