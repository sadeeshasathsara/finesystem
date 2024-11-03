<?php
include "../../app/connection.php";
header('Content-Type: application/json');

// Calculate the start and end dates of the current month
$startDate = date('Y-m-01');
$endDate = date('Y-m-t');

// Query for total fines and total amount
$sql = "SELECT COUNT(*) as total_fines, SUM(total_fine) as total_amount 
        FROM penalty_sheet 
        WHERE issued_date BETWEEN '$startDate' AND '$endDate'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$totalFines = $row['total_fines'];
$totalAmount = $row['total_amount'];
$averageFine = $totalAmount / $totalFines;

// Query for violation breakdown
$sqlBreakdown = "SELECT fine_name as type, COUNT(*) as count, SUM(total_fine) as amount 
                 FROM penalty_sheet 
                 JOIN penalty_fine ON penalty_sheet.pid = penalty_fine.pid
                 JOIN fine ON penalty_fine.fid = fine.fid
                 WHERE issued_date BETWEEN '$startDate' AND '$endDate'
                 GROUP BY fine_name";
$breakdownResult = $conn->query($sqlBreakdown);
$violationBreakdown = [];
while ($rowBreakdown = $breakdownResult->fetch_assoc()) {
    $violationBreakdown[] = $rowBreakdown;
}

// Query for detailed data
$sqlDetails = "SELECT issued_date as date, fine_name as type, total_fine as amount, police_id as officer 
               FROM penalty_sheet 
               JOIN penalty_fine ON penalty_sheet.pid = penalty_fine.pid
               JOIN fine ON penalty_fine.fid = fine.fid
               WHERE issued_date BETWEEN '$startDate' AND '$endDate'";
$detailsResult = $conn->query($sqlDetails);
$fineDetails = [];
while ($rowDetails = $detailsResult->fetch_assoc()) {
    $fineDetails[] = $rowDetails;
}

$conn->close();

// Output JSON data
echo json_encode([
    'totalFines' => $totalFines,
    'totalAmount' => $totalAmount,
    'averageFine' => $averageFine,
    'violationBreakdown' => $violationBreakdown,
    'fineDetails' => $fineDetails
]);
?>