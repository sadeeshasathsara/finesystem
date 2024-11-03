<?php
// Include database connection
include '../../app/connection.php'; // Adjust the path as needed

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
    $confirmPassword = mysqli_real_escape_string($conn, $_POST['confirmPassword']);

    // Check if passwords match
    if ($newPassword !== $confirmPassword) {
        echo "Passwords do not match.";
        exit();
    }

    // Validate the new password (example: minimum 8 characters, must include uppercase letter and number)
    if (strlen($newPassword) < 8 || !preg_match('/[A-Z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
        echo "Password must be at least 8 characters long, and include at least one uppercase letter and one number.";
        exit();
    }

    // Create SQL query
    $sql = "UPDATE admin SET password = '$newPassword' WHERE username = '$username'";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        header("Location: ../login/index.php?pwd=updated");
    } else {
        echo "Error updating password: " . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}