<?php
// Include the necessary libraries and database connection
include "../app/connection.php";

// Get the PID from the query parameters
$pid = $_GET['pid'] ?? null;

if (!$pid) {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No PID provided.']);
    exit;
}

// Query to get payment details
$sql = "
    SELECT 
        ps.pid,
        f.fine_name,
        f.fine_payment,
        ps.total_fine
    FROM 
        penalty_sheet ps
    JOIN 
        penalty_fine pf ON ps.pid = pf.pid
    JOIN 
        fine f ON pf.fid = f.fid
    WHERE 
        ps.pid = '$pid'
";

$sql2 = "update penalty_sheet set payment_status = 'paid' where pid = '$pid'";

mysqli_query($conn, $sql2);

// Execute the query
$result = $conn->query($sql);

$details = [];
$totalAmount = 0;

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $details[] = [
            'pid' => $pid,
            'fine_name' => $row['fine_name'],
            'fine_payment' => "Rs. " . $row['fine_payment']
        ];
        $totalAmount = "Rs. " . $row['total_fine'];
    }
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No payment details found.']);
    exit;
}

// Set content type to JSON
header('Content-Type: application/json');
echo json_encode([
    'details' => $details,
    'totalAmount' => $totalAmount
]);
exit;