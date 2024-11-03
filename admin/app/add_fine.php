<?php
include "../../app/connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $fineName = mysqli_real_escape_string($conn, $_POST['fineName']);
    $fineAmount = mysqli_real_escape_string($conn, $_POST['fineAmount']);
    $fineDescription = mysqli_real_escape_string($conn, $_POST['fineDescription']);

    // SQL query to insert the fine details into the database
    $sql = "INSERT INTO fine (fine_name, fine_payment, details) VALUES ('$fineName', '$fineAmount', '$fineDescription')";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        header("Location: ../fine-details.php?fine=added");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
