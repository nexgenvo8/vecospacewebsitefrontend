<?php
define(_DATABASE_HOST_,"localhost");
define(_DATABASE_NAME_,"vecospac_db");
define(_DATABASE_USERNAME_,"vecospac_user");
define(_DATABASE_PASSWORD_,"admin@3214");

define('CONST_SITE_NAME', 'KONECTT');
if($_SERVER['SERVER_ADDR']=='127.0.0.1'){
	define('CONST_SITE_FOLDER_NAME', '');
	define('CONST_SITE_URL', 'http://127.0.0.1/');
	define('CONST_SURL', '/');
	define('CONST_DOC_ROOT', $_SERVER['DOCUMENT_ROOT'] . CONST_SURL);
}else{
	define('CONST_SITE_FOLDER_NAME', '/');
	define('CONST_SITE_URL', 'http://jmi.vecospace.com/');
	define('CONST_SURL', '/jmi/');
	define('CONST_ABSOLUTE_SURL', '/home/public_html/jmi/');
	define('CONST_DOC_ROOT', $_SERVER['DOCUMENT_ROOT'] . CONST_SURL);
}

?>