<?php
include "../../app/connection.php";

$sql = "SELECT COUNT(*) as total_fines, SUM(total_fine) as total_amount, 
               SUM(CASE WHEN payment_status = 'paid' THEN 1 ELSE 0 END) as paid_fines,
               SUM(CASE WHEN payment_status = 'unpaid' THEN 1 ELSE 0 END) as unpaid_fines
        FROM penalty_sheet";

$result = $conn->query($sql);
echo mysqli_error($conn);

$data = $result->fetch_assoc();
$conn->close();

echo json_encode($data);