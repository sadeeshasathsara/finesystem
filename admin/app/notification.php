<?php
// Assuming you have already established a connection to the database
include '../../app/connection.php'; // Make sure this file contains the connection to your database

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the form inputs
    $to_whome = $_POST['to_whome'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    // Sanitize inputs to prevent SQL injection
    $to_whome = mysqli_real_escape_string($conn, $to_whome);
    $title = mysqli_real_escape_string($conn, $title);
    $description = mysqli_real_escape_string($conn, $description);

    // Insert the notification into the notification table
    $sql = "INSERT INTO notification (title, description) VALUES ('$title', '$description')";

    if (mysqli_query($conn, $sql)) {

        // Get the last inserted notification ID
        $notification_id = mysqli_insert_id($conn);

        if ($to_whome === 'Police' || $to_whome === 'All') {
            // Get all police_id's from the policeman table
            $police_sql = "SELECT police_id FROM policeman";
            $police_result = mysqli_query($conn, $police_sql);

            if ($police_result && mysqli_num_rows($police_result) > 0) {
                // Insert the notification ID and each police_id into police_notification table
                while ($row = mysqli_fetch_assoc($police_result)) {
                    $police_id = $row['police_id'];
                    $police_notification_sql = "INSERT INTO police_notification (notification_id, police_id) VALUES ('$notification_id', '$police_id')";
                    if (!mysqli_query($conn, $police_notification_sql)) {
                        echo "Error inserting into police_notification: " . mysqli_error($conn) . "<br>";
                    }
                }
                echo "<script>
                window.location.href = 'http://localhost/finesystem/admin/index.php?notification=sent';
                
                </script>";

            } else {
                echo "No police officers found!";
            }
        }

        if ($to_whome === 'License Holder' || $to_whome === 'All') {
            // Get all license_numbers from the license table
            $license_sql = "SELECT license_number FROM license";
            $license_result = mysqli_query($conn, $license_sql);

            if (mysqli_num_rows($license_result) > 0) {
                // Insert the notification ID and each license_number into license_notification table
                while ($row = mysqli_fetch_assoc($license_result)) {
                    $license_number = $row['license_number'];
                    $license_notification_sql = "INSERT INTO license_notifications (notification_id, license_number) VALUES ('$notification_id', '$license_number')";
                    if (!mysqli_query($conn, $license_notification_sql)) {
                        echo "Error inserting into license_notification: " . mysqli_error($conn) . "<br>";
                    }
                }
                echo "<script>
                
                window.location.href = 'http://localhost/finesystem/admin/index.php?notification=sent';
                
                </script>";
            } else {
                echo "No license holders found!";
            }
        }

    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }

    // Close the database connection
    mysqli_close($conn);
}
?>