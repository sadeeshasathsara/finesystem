<?php
include '../../app/connection.php'; // Include your database connection file

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $police_id = $_SESSION["licenseNumber"];

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $profile_picture = $_FILES['profile_picture'];
        $upload_dir = '../src/profile_photo/';
        $file_ext = pathinfo($profile_picture['name'], PATHINFO_EXTENSION);
        $file_name = $police_id . '.' . $file_ext; // Save the file with the police ID as the file name
        $upload_path = $upload_dir . $file_name;

        // Move the uploaded file to the destination folder
        if (move_uploaded_file($profile_picture['tmp_name'], $upload_path)) {
            // Update the database with the new file path
            $sql = "UPDATE license_holder SET profile_picture = '$file_name' WHERE license_number = '$police_id'";
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['success' => true, 'new_path' => $upload_path]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to update the database.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to move the uploaded file.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No file uploaded or file upload error.']);
    }
}