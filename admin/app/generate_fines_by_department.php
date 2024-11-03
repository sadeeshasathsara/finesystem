<?php
include "../../app/connection.php";

// Assuming $department is set from the query parameters or some other source
$department = isset($_GET['department']) ? $_GET['department'] : 'all';

// Build the SQL condition based on department
$condition = $department === 'all' ? '' : "WHERE pd.did = '$department'";

// Prepare the SQL query
$sql = "SELECT 
            pd.name AS department_name,
            COUNT(ps.pid) AS total_fines,
            SUM(ps.total_fine) AS total_amount
        FROM 
            police_division pd
        JOIN 
            policeman p ON pd.did = p.did
        JOIN 
            penalty_sheet ps ON p.police_id = ps.police_id
        $condition
        GROUP BY 
            pd.name";

// Execute the query
$result = $conn->query($sql);

// Check for SQL errors
if ($conn->error) {
    echo json_encode(['error' => $conn->error]);
    exit;
}

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close the connection
$conn->close();

// Return the data as JSON
header('Content-Type: application/json');
echo json_encode($data);
?>