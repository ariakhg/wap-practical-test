<?php
require "sql.php";

$sql = "CREATE TABLE IF NOT EXISTS `Users` (
    `id`            INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username`      VARCHAR(50) NOT NULL,
    `email`        VARCHAR(50) NOT NULL,
    `password`    VARCHAR(50) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Users created successfully";
} else {
    echo "Error creating Users table: " . $conn->error;
}

$conn->close();

?>