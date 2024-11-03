<?php
include "../../app/connection.php";
// Retrieve POST data
$license_number = $_SESSION["licenseNumber"];
$card_number = $_POST['card_number'];
$cardholder_name = $_POST['cardholder_name'];
$expiry_date = $_POST['expiry_date'];
$cvv = $_POST['cvv'];
$billing_address = $_POST['billing_address'];

$date = DateTime::createFromFormat('Y-m', $expiry_date);

// Format the date as MM/YY
$formatted_date = $date->format('m/y');

// Format card number to remove spaces for storage
$formatted_card_number = str_replace(' ', '', $card_number);

// SQL query to insert data
$sql = "INSERT INTO payment_option (license_number, card_number, cardholder_name, expiry_date, cvv, billing_address)
        VALUES ('$license_number', '$formatted_card_number', '$cardholder_name', '$formatted_date', '$cvv', '$billing_address')";

// Execute query
if ($conn->query($sql) === TRUE) {
    $_SESSION["notification"] = true;
    header("Location: " . baseUrl . "/user/payment-options.php?s=true");
    exit();
} else {
    $e = mysqli_error($conn);
    header("Location: " . baseUrl . "/user/payment-options.php?e=" . $e);
    exit();
}