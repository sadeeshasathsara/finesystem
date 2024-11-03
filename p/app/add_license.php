<?php
include "../../app/connection.php";

if (isset($_POST['new_license_number'])) {
    $licenseNumber = $_POST['new_license_number'];
    $licenseName = $_POST['new_license_name'];
    $dob = $_POST['new_dob'];
    $address = $_POST['new_address'];
    $expieryDate = $_POST['expiery_date'];

    $sql = "INSERT INTO license (license_number, dob, address, name, expiry_date) 
        VALUES ('$licenseNumber', '$dob', '$address', '$licenseName', '$expieryDate')";

    if (mysqli_query($conn, $sql)) {
        header("Location: " . baseUrl . "/p/");
        exit;
    } else {
        $e = mysqli_error($conn);
        header("Location: " . baseUrl . "/p/?e2=" . $e);
        exit;
    }
}
