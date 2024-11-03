<?php
include "../../app/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['notification_id'])) {
        $notification_id = $conn->real_escape_string($_POST['notification_id']);
        $license_number = $_SESSION["licenseNumber"];

        error_log("Received notification_id: $notification_id");
        error_log("Using license_number: $license_number");

        // Delete from license_notifications table
        $deleteSql = "
            DELETE FROM license_notifications
            WHERE notification_id = '$notification_id' AND license_number = '$license_number'
        ";

        if ($conn->query($deleteSql) === TRUE) {
            echo 'success';
        } else {
            error_log("SQL Error: " . $conn->error);
            echo 'Error: ' . $conn->error;
        }
    } else {
        error_log("Notification ID not set");
        echo 'Notification ID not set';
    }
} else {
    error_log("Invalid request method");
    echo 'Invalid request method';
}