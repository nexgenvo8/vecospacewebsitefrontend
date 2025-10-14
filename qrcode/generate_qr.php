<?php
// Include the QR code library
include('phpqrcode/qrlib.php');


// Your registration page URL
$registrationUrl = "https://jmi.vecospace.com/registration-form.html";

// Define the file path
$qrFilePath = "qrcodes/jmi_registration_qr.png";



// Check if the QR code already exists
if (!file_exists($qrFilePath)) {
    // Generate and save QR code only if it doesn't exist
    QRcode::png($registrationUrl, $qrFilePath, QR_ECLEVEL_L, 10);
}

// Display the existing QR code
echo "<h2>Scan the QR Code to Register:</h2>";
echo "<img src='$qrFilePath' alt='QR Code'>";


?>