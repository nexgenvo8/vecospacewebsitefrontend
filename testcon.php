<?php
$host = '154.210.160.217';
$port = 3306;
$fp = @fsockopen($host, $port, $errno, $errstr, 5);

if (!$fp) {
    echo "Port $port is blocked or unreachable: $errstr ($errno)";
} else {
    echo "Port $port is open and reachable!";
    fclose($fp);
}
?>
