<?php
include "../../app/connection.php";
// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $police_id = $_POST['police_id'];
    $name = $_POST['name'];
    $position = $_POST['posision'];
    $department_name = $_POST['department'];
    $dob = $_POST['dob'];
    $mobile = $_POST['mobile'];
    $address = $_POST['address'];
    $password = $_POST['pwd'];
    $confirm_password = $_POST['cpwd'];

    // Find the department ID from the police_division table
    $department_query = "SELECT did FROM police_division WHERE name = '$department_name' LIMIT 1";
    $department_result = mysqli_query($conn, $department_query);
    if ($department_result && mysqli_num_rows($department_result) > 0) {
        $department_row = mysqli_fetch_assoc($department_result);
        $department_id = $department_row['did'];
    } else {
        header("Location: http://localhost/finesystem/admin/policeman.php?e=1");
        exit;
    }

    // Handle profile picture upload
    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $profile_picture = $_FILES['profile_picture'];
        $upload_dir = 'p/src/profile_photo/';
        $file_ext = pathinfo($profile_picture['name'], PATHINFO_EXTENSION);
        $file_name = $police_id . '.' . $file_ext; // Save the file with the police ID as the file name
        $upload_path = $_SERVER['DOCUMENT_ROOT'] . '/finesystem' . '/' . $upload_dir . $file_name;

        // Move the uploaded file to the destination folder
        if (!move_uploaded_file($profile_picture['tmp_name'], $upload_path)) {
            die('Failed to upload the profile picture. Error: ' . error_get_last()['message']);
        }
    } else {
        $file_name = null; // No profile picture uploaded
    }

    // Insert data into the policeman table
    $query = "INSERT INTO policeman (police_id, name, position, did, dob, mobile, address, password, profile_picture) 
              VALUES ('$police_id', '$name', '$position', '$department_id', '$dob', '$mobile', '$address', '$password', '$file_name')";

    if (mysqli_query($conn, $query)) {
        header("Location: http://localhost/finesystem/admin/policeman.php?officer=added");
        exit;
    } else {
        $error = mysqli_error($conn);
        header("Location: http://localhost/finesystem/admin/policeman.php?e=" . $error);
        exit;
    }
}