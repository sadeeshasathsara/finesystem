<?php
include "connection.php";

$id = $_POST["nic"];
$licenseNumber = $_POST["licenseNumber"];
$number = $_POST["phoneNumber"];
$pwd = $_POST["pwd"];
$nic = $_POST["nic"];

$sql = "INSERT INTO license_holder (nic, password, mobile, license_number)
VALUES ('$id', '$pwd', '$number', '$licenseNumber')";



if (mysqli_query($conn, $sql)) {
    $_SESSION["accountCreation"] = 1;
    header("Location: " . baseUrl . "/login.php?c=1");
    exit;
} else {
    if (mysqli_error($conn) == "Cannot add or update a child row: a foreign key constraint fails (`finesystem`.`license_holder`, CONSTRAINT `fk_license_license_holder` FOREIGN KEY (`license_number`) REFERENCES `license` (`license_number`) ON DELETE SET NULL ON UPDATE SET NULL)") {
        header("Location: " . baseUrl . "/login.php?e=1");
        exit;
    } else if (mysqli_error($conn) == "Duplicate entry '$nic' for key 'PRIMARY'") {
        header("Location: " . baseUrl . "/login.php?e=2");
        exit;
    } else if (mysqli_error($conn)) {
        $e = mysqli_error($conn);
        header("Location: " . baseUrl . "/login.php?e=" . $e);
        exit;
    }
    echo mysqli_error(($conn));
}