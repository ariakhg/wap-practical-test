<?php
session_start();
require 'config/connection.php';

// Tells the browser to be prepared to handle JSON reponse
header('Content-Type: application/json');
// Create response array
$response = ['success' => false, 'message' => '', 'picture' => ''];

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    $response['message'] = 'User not logged in';
    echo json_encode($response);
    exit();
}

// Handle file upload
if (isset($_FILES['picture']) && $_FILES['picture']['error'] === 0) {
    $allowed = ['jpg', 'jpeg', 'png', 'gif'];
    $filename = $_FILES['picture']['name'];
    $filesize = $_FILES['picture']['size'];
    $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    
    // Validate file type
    if (!in_array($ext, $allowed)) {
        $response['message'] = 'Invalid file type. Allowed types: ' . implode(', ', $allowed);
        echo json_encode($response);
        exit();
    }

    // Create uploads directory if it doesn't exist - 0777 means perms to read, write, & execute for owner, group and others
    if (!file_exists('uploads')) {
        mkdir('uploads', 0777, true);
    }

    // Generate unique filename
    $new_filename = uniqid() . '.' . $ext;
    $upload_path = 'uploads/' . $new_filename;
    
    // Upload file path to database
    if (move_uploaded_file($_FILES['picture']['tmp_name'], $upload_path)) {
        
        // Get current profile picture
        $stmt = $conn->prepare("SELECT picture FROM Users WHERE username = ?");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        $old_picture = $user['picture'];

        // Update database with new picture
        $stmt = $conn->prepare("UPDATE Users SET picture = ? WHERE username = ?");
        $stmt->bind_param("ss", $new_filename, $_SESSION['username']);
        
        if ($stmt->execute()) {
            // Delete old picture if it exists and isn't the default
            if ($old_picture !== 'profile.png' && file_exists('uploads/' . $old_picture)) {
                unlink('uploads/' . $old_picture);
            }

            $response = [
                'success' => true,
                'message' => 'Profile picture updated successfully',
                'picture' => $new_filename
            ];
        } else {
            // Delete uploaded file if database update fails
            unlink($upload_path);
            $response['message'] = 'Database update failed: ' . $conn->error;
        }
    } else {
        $response['message'] = 'Failed to upload file';
    }
} else {
    $response['message'] = 'No file uploaded or upload error occurred';
}

echo json_encode($response);
$conn->close();
?> 