<?php
include "../../app/connection.php";
header('Content-Type: application/json');

// Calculate the start and end dates of the past year
$startDate = date('Y-01-01');
$endDate = date('Y-12-31');

// Query for total violations and percentage change
$sqlTotalViolations = "SELECT COUNT(*) as total_violations FROM penalty_sheet WHERE issued_date BETWEEN '$startDate' AND '$endDate'";
$resultTotalViolations = $conn->query($sqlTotalViolations);
$rowTotalViolations = $resultTotalViolations->fetch_assoc();
$totalViolations = $rowTotalViolations['total_violations'];

// Query for monthly violations data
$sqlMonthlyViolations = "SELECT MONTHNAME(issued_date) as month, COUNT(*) as count
                         FROM penalty_sheet
                         WHERE issued_date BETWEEN '$startDate' AND '$endDate'
                         GROUP BY MONTH(issued_date)
                         ORDER BY MONTH(issued_date)";
$resultMonthlyViolations = $conn->query($sqlMonthlyViolations);

$labels = [];
$data = [];
while ($row = $resultMonthlyViolations->fetch_assoc()) {
    $labels[] = $row['month'];
    $data[] = $row['count'];
}

// Query for violation breakdown
$sqlBreakdown = "SELECT fine_name as type, COUNT(*) as count
                 FROM penalty_sheet
                 JOIN penalty_fine ON penalty_sheet.pid = penalty_fine.pid
                 JOIN fine ON penalty_fine.fid = fine.fid
                 WHERE issued_date BETWEEN '$startDate' AND '$endDate'
                 GROUP BY fine_name";
$resultBreakdown = $conn->query($sqlBreakdown);
$violationBreakdown = [];
while ($row = $resultBreakdown->fetch_assoc()) {
    $violationBreakdown[] = $row;
}

$mostCommonViolationSql = "SELECT fine_name, COUNT(*) as count
FROM penalty_fine
JOIN fine ON penalty_fine.fid = fine.fid
GROUP BY fine_name
ORDER BY count DESC
LIMIT 1
";

$comon_result = mysqli_query($conn, $mostCommonViolationSql);
if ($comon_result) {
    while ($row = mysqli_fetch_assoc($comon_result)) {
        $commonViolation = $row['fine_name'];
    }
}

$peakedPeriod = "SELECT DATE_FORMAT(issued_date, '%m') as month, COUNT(*) as count
FROM penalty_sheet
GROUP BY month
ORDER BY count DESC
LIMIT 1
";

$peaked_result = mysqli_query($conn, $peakedPeriod);
if ($peaked_result) {
    while ($row = mysqli_fetch_assoc($peaked_result)) {
        $peakedPeriod = $row['month'];
    }
}

// Calculate percentage change (placeholder calculation)
$previousTotalViolations = $totalViolations * 0.85; // Example previous data
$percentageChange = (($totalViolations - $previousTotalViolations) / $previousTotalViolations) * 100;


$conn->close();

// Output JSON data
echo json_encode([
    'totalViolations' => $totalViolations,
    'percentageChange' => $percentageChange,
    'peakPeriod' => $peakedPeriod,
    'trendsData' => [
        'labels' => $labels,
        'data' => $data
    ],
    'violationBreakdown' => $violationBreakdown,
    'commonViolation' => $commonViolation,
    'peakedPeriod' => $peakedPeriod
]);
