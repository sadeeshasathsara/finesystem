<?php
include "../../app/connection.php";

// Retrieve the search term from the query string
$searchTerm = isset($_GET['term']) ? $_GET['term'] : '';

// Prepare SQL statement with placeholder
$sql = "SELECT fine_name FROM fine WHERE fine_name LIKE ?";

// Prepare the statement
$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

// Bind the parameter
$searchTermLike = '%' . $searchTerm . '%';
$stmt->bind_param("s", $searchTermLike);

// Execute the statement
$stmt->execute();

// Get the result set
$result = $stmt->get_result();

// Fetch all matching fine names
$suggestions = [];
while ($row = $result->fetch_assoc()) {
    $suggestions[] = $row['fine_name'];
}

// Debug output
header('Content-Type: application/json');
echo json_encode($suggestions);