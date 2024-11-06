<?php
// 4. Create Hackathons table

require 'connection.php';

// Create the Hackathons table
$sql = "CREATE TABLE IF NOT EXISTS `Hackathons` (
    `id`          INT(5) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    `title`       VARCHAR(100) NOT NULL,
    `description` TEXT NOT NULL,
    `start_date`  DATE NOT NULL,
    `end_date`    DATE NOT NULL,
    `location`    VARCHAR(100) NOT NULL,
    `image`       VARCHAR(255) DEFAULT 'defaultHackathon.svg',
    `status`      ENUM('upcoming', 'ongoing', 'completed') NOT NULL,
    `url`         VARCHAR(255) NOT NULL
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Hackathons created successfully<br>";
} else {
    echo "Error creating Hackathons table: " . $conn->error . "<br>";
}

// Sample data insertion
$sql = "INSERT INTO Hackathons (title, description, start_date, end_date, location, status, url) VALUES
('Hackathon 1', 'This is a description for Hackathon 1.', '2024-11-10', '2024-11-12', 'Kuala Lumpur', 'upcoming', 'https://example.com/hackathon1'),
('Hackathon 2', 'This is a description for Hackathon 2.', '2024-11-15', '2024-11-18', 'Penang', 'upcoming', 'https://example.com/hackathon2'),
('Hackathon 3', 'This is a description for Hackathon 3.', '2024-12-01', '2024-12-03', 'Johor Bahru', 'upcoming', 'https://example.com/hackathon3'),
('Hackathon 4', 'This is a description for Hackathon 4.', '2024-12-05', '2024-12-07', 'Selangor', 'upcoming', 'https://example.com/hackathon4'),
('Hackathon 5', 'This is a description for Hackathon 5.', '2024-12-10', '2024-12-12', 'Kuala Lumpur', 'upcoming', 'https://example.com/hackathon5'),
('Hackathon 6', 'This is a description for Hackathon 6.', '2024-12-15', '2024-12-17', 'Kuala Lumpur', 'upcoming', 'https://example.com/hackathon6')";

if ($conn->query($sql) === TRUE) {
    echo "Sample data inserted successfully<br>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error . "<br>";
}

$conn->close();
?>
