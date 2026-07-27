<?php
define("_DATABASE_HOST_", "localhost");
define("_DATABASE_NAME_", "veco_db");
define("_DATABASE_USERNAME_", "veco");
define("_DATABASE_PASSWORD_", "VecoPass@351");

// Connect using mysqli
$conn = mysqli_connect(_DATABASE_HOST_, _DATABASE_USERNAME_, _DATABASE_PASSWORD_, _DATABASE_NAME_);

if (!$conn) {
    die("Database Connection Failed: " . mysqli_connect_error());
}

echo "✅ Database connection successful!";

// Close connection
mysqli_close($conn);
?>
