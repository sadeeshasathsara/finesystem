<?php
include "../../app/connection.php";

if (isset($_GET['pid'])) {
    $penalty_id = $_GET['pid'];

    // SQL query to fetch fines related to the penalty
    $sql = "
                SELECT 
                    f.fid,
                    f.fine_name AS fine_name,
                    f.fine_payment AS fine_price
                FROM fine f
                JOIN penalty_fine pf ON pf.fid = f.fid
                WHERE pf.pid = '$penalty_id'
            ";

    $result = $conn->query($sql);

    // Check if the query was successful
    if ($result === false) {
        echo "<p>Error executing query: " . $conn->error . "</p>";
        $fines = [];
    } else {
        // Check if any fines exist
        if ($result->num_rows > 0) {
            $fines = [];
            while ($row = $result->fetch_assoc()) {
                $fines[] = $row;
            }
        } else {
            $fines = [];
        }
    }

    header('Content-Type: application/json');
    echo json_encode($fines);

    $conn->close();
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'No penalty ID provided']);
}