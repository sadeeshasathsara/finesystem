<?php
include "connection.php";

session_start();

$licenseNumber = $_POST["license_number"];
$pwd = $_POST["pwd"];

// Check if user is a license holder
$sql = "SELECT * FROM license_holder WHERE license_number = '$licenseNumber' AND password = '$pwd'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $_SESSION["licenseNumber"] = $licenseNumber;
    $_SESSION["accountCreation"] = 0;
    $_SESSION["loginError"] = 0;
    header("Location: " . baseUrl . "/user");
    exit;
}

// Check if user is a policeman
$sql2 = "SELECT * FROM policeman WHERE police_id = '$licenseNumber' AND password = '$pwd'";
$result2 = mysqli_query($conn, $sql2);

if (mysqli_num_rows($result2) > 0) {
    $_SESSION["policeNumber"] = $licenseNumber;
    $_SESSION["policeId"] = $licenseNumber;
    $_SESSION["accountCreation"] = 0;
    $_SESSION["loginError"] = 0;
    header("Location: " . baseUrl . "/p"); // Update the URL
    exit;
}

// If login fails
$_SESSION["loginError"] = 1;
header("Location: " . baseUrl . "/login.php");
exit;