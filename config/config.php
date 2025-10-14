<?php
define("_DATABASE_HOST_", "localhost");
define("_DATABASE_NAME_", "vecospac_db");
define("_DATABASE_USERNAME_", "root");
define("_DATABASE_PASSWORD_", "");

// Uncomment these lines when you want to switch to the live server
// define("_DATABASE_HOST_", "154.210.160.217");
// define("_DATABASE_NAME_", "vecospace");
// define("_DATABASE_USERNAME_", "veco1");
// define("_DATABASE_PASSWORD_", "PassVeco@3456");

define("CONST_SITE_NAME", "S Network");

if ($_SERVER["SERVER_ADDR"] == "127.0.0.1") {
    define("CONST_SITE_FOLDER_NAME", "");
    define("CONST_SITE_URL", "https://127.0.0.1/");
    define("CONST_SURL", "/");
    define("CONST_DOC_ROOT", $_SERVER["DOCUMENT_ROOT"] . CONST_SURL);
} else {
    define("CONST_SITE_FOLDER_NAME", "/");
    define("CONST_SITE_URL", "https://jmi.vecospace.com/");
    define("CONST_SURL", "/");
    define("CONST_ABSOLUTE_SURL", "/home/public_html/jmi/");
    define("CONST_DOC_ROOT", $_SERVER["DOCUMENT_ROOT"] . CONST_SURL);
}

$notititle = "New%20Message%20Received";
$notimessage = "Tap%20here%20to%20read%20message";

function getDbConnection()
{
    $conn = mysqli_connect(_DATABASE_HOST_, _DATABASE_USERNAME_, _DATABASE_PASSWORD_, _DATABASE_NAME_);
    if (!$conn) {
        die("Database Connection Failed: " . mysqli_connect_error());
    }

    // Set proper charset
    mysqli_set_charset($conn, "utf8mb4");
    mysqli_query($conn, "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci");

    // ✅ remove echo in production
    // $charset = mysqli_character_set_name($conn);
    // echo "Current character set: " . $charset . "<br>";

    return $conn;
}

?>