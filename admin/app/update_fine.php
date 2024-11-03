<?php
include '../../app/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fineId = $_POST['fine_id'];
    $fineName = isset($_POST['fine_name']) ? trim($_POST['fine_name']) : null;
    $fineDescription = isset($_POST['fine_description']) ? trim($_POST['fine_description']) : null;
    $finePayment = isset($_POST['fine_payment']) ? trim($_POST['fine_payment']) : null;

    $fieldsToUpdate = [];
    $params = [];
    $types = '';

    if (!empty($fineName)) {
        $fieldsToUpdate[] = 'fine_name = ?';
        $params[] = $fineName;
        $types .= 's';
    }

    if (!empty($fineDescription)) {
        $fieldsToUpdate[] = 'details = ?';
        $params[] = $fineDescription;
        $types .= 's';
    }

    if (!empty($finePayment)) {
        $fieldsToUpdate[] = 'fine_payment = ?';
        $params[] = $finePayment;
        $types .= 'd'; // assuming fine_payment is a decimal
    }

    if (!empty($fieldsToUpdate)) {
        $params[] = $fineId;
        $types .= 'i';

        $sql = "UPDATE fine SET " . implode(', ', $fieldsToUpdate) . " WHERE fid = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param($types, ...$params);

        if ($stmt->execute()) {
            echo "Fine updated successfully.";
        } else {
            echo "Error updating fine: " . $conn->error;
        }

        $stmt->close();
    } else {
        echo "No fields to update.";
    }

    $conn->close();
}