<?php
include "../../app/connection.php";

if (!isset($_GET['q']) || empty($_GET['q'])) {
    http_response_code(400); // Bad Request
    echo json_encode(['error' => 'Query parameter "q" is missing or empty.']);
    $conn->close();
    exit;
}

$query = $_GET['q'];
$query = $conn->real_escape_string($query);

$sql = "SELECT name FROM police_division WHERE name LIKE '%$query%'";
$result = $conn->query($sql);

$suggestions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $suggestions[] = $row['name'];
    }
}

header('Content-Type: application/json');
echo json_encode($suggestions);