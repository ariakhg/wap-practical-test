<?php
// 2. Create connection to phpMyAdmin

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wapDB";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
