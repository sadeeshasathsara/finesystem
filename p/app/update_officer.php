<?php
// Database connection
require_once '../../app/connection.php'; // Adjust path as needed

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve and sanitize form data
    $police_id = isset($_POST['police_id']) ? mysqli_real_escape_string($conn, $_POST['police_id']) : null;
    $new_police_id = isset($_POST['new_police_id']) ? trim(mysqli_real_escape_string($conn, $_POST['police_id'])) : null;
    $department = isset($_POST['department']) ? trim(mysqli_real_escape_string($conn, $_POST['department'])) : null;
    $dob = isset($_POST['dob']) ? trim(mysqli_real_escape_string($conn, $_POST['dob'])) : null;
    $address = isset($_POST['address']) ? trim(mysqli_real_escape_string($conn, $_POST['address'])) : null;
    $mobile = isset($_POST['mobile']) ? trim(mysqli_real_escape_string($conn, $_POST['mobile'])) : null;

    // Prepare SQL update statement
    $update_fields = [];
    $update_values = [];

    if ($new_police_id) {
        $update_fields[] = "police_id = '$new_police_id'";
    }

    if ($department) {
        $did_sql = "SELECT did FROM police_division WHERE name LIKE '%$department%'";
        if ($data = mysqli_query($conn, $did_sql)) {
            $row = mysqli_fetch_assoc($data);
            $did = $row['did'];
        }
        $update_fields[] = "did = '$did'";
    }

    if ($dob) {
        $update_fields[] = "dob = '$dob'";
    }

    if ($address) {
        $update_fields[] = "address = '$address'";
    }

    if ($mobile) {
        $update_fields[] = "mobile = '$mobile'";
    }



    // Create SQL query
    $sql = "UPDATE policeman SET " . implode(', ', $update_fields) . " WHERE police_id = '$police_id'";

    // Execute the SQL statement
    if (mysqli_query($conn, $sql)) {
        $redirection = baseUrl . "/p/profile/?police_id=" . $police_id . "&success=true";
        header("Location: $redirection");
        exit;

    } else {
        $redirection = baseUrl . "/p/profile/?police_id=" . $police_id . "&e=div";
        header("Location: $redirection");
        exit;
    }
} else {
    $redirection = baseUrl . "/p/profile/?police_id=" . $police_id . "&e=2";
    header("Location: $redirection");
    exit;
}