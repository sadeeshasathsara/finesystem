<?php
include "../../app/connection.php";

$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];

// SQL query
$sql = "SELECT DATE(issued_date) as date, COUNT(*) as total_fines, SUM(total_fine) as total_amount
        FROM penalty_sheet
        WHERE issued_date BETWEEN '$start_date' AND '$end_date'
        GROUP BY DATE(issued_date)";

// Execute the query and check for errors
$result = $conn->query($sql);

if (!$result) {
    // If the query fails, output the error message
    echo "Error: " . $conn->error;
    $conn->close();
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

$conn->close();

// Output the data as JSON
echo json_encode($data);
