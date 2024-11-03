<?php
include "../../app/connection.php";

header('Content-Type: application/json');

$searchTerm = $_GET['term'] ?? '';

if (strlen($searchTerm) > 0) {
    // Prepare and execute SQL query
    $sql = "SELECT license_number FROM license WHERE license_number LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTermLike = '%' . $searchTerm . '%';
    $stmt->bind_param("s", $searchTermLike);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch all matching license numbers
    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['license_number'];
    }

    echo json_encode($suggestions);
}