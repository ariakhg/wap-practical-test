<?php
require "createSqlConnection.php";

$sql = "CREATE TABLE IF NOT EXISTS `Users` (
    `id`          INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `username`    VARCHAR(100) NOT NULL,
    `email`       VARCHAR(100) NOT NULL,
    `password`    VARCHAR(128) NOT NULL,
    `picture`     VARCHAR(128)
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Users created successfully";
} else {
    echo "Error creating Users table: " . $conn->error;
}

$conn->close();

?>