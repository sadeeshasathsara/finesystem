<?php
include "../../app/connection.php";

// Query to get the total number of fines and total amount for P00001
$today = date('Y-m-d');
$id = $_SESSION["policeNumber"];

$sql = "
    SELECT COUNT(*) AS total_fines, SUM(total_fine) AS total_amount
    FROM penalty_sheet
    WHERE police_id = '$id' AND issued_date = '$today'
";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $totalFines = $row['total_fines'];
    $totalAmount = $row['total_amount'];
} else {
    $totalFines = 0;
    $totalAmount = 0;
}

$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'totalFines' => $totalFines,
    'totalAmount' => $totalAmount
]);