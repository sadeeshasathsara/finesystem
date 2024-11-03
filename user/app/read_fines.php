<?php
include '../../app/connection.php';

$sql = "SELECT fid, fine_name, details, fine_payment FROM fine";
$result = $conn->query($sql);

$fines = [];

if ($result) {
    // Fetch all results into an array
    while ($row = $result->fetch_assoc()) {
        $fines[] = $row;
    }
} else {
    echo mysqli_error($conn) . "<br>";
    echo "0 results";
}
$conn->close();

// Encode the results as JSON for use in JavaScript
echo json_encode($fines);