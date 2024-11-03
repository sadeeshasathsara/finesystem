<?php
include "../../app/connection.php";

$pid = $_GET['pid'];

// Query to get penalty sheet details
$sql = "SELECT * FROM penalty_sheet WHERE pid = '$pid'";
$result = mysqli_query($conn, $sql);

if ($row = mysqli_fetch_assoc($result)) {
    echo "<p><strong>Penalty ID:</strong> " . $row['pid'] . "</p>";
    echo "<p><strong>License Number:</strong> " . $row['license_number'] . "</p>";
    echo "<p><strong>Issued Date:</strong> " . $row['issued_date'] . "</p>";
    echo "<p><strong>Deadline:</strong> " . $row['deadline'] . "</p>";
    echo "<p><strong>Total Fine:</strong> Rs." . $row['total_fine'] . "</p>";

    // Query to get fines and their charges
    $fine_sql = "SELECT fine_name, fine_payment FROM fine WHERE fid IN (SELECT fid FROM penalty_fine WHERE pid = '$pid')";
    $fine_result = mysqli_query($conn, $fine_sql);

    if (mysqli_num_rows($fine_result) > 0) {
        echo "<h3>Fines & Charges</h3>";
        echo "<table>";
        echo "<tr><th>Fine</th><th>Charge</th></tr>";
        while ($fine_row = mysqli_fetch_assoc($fine_result)) {
            echo "<tr><td>" . $fine_row['fine_name'] . "</td><td>Rs." . $fine_row['fine_payment'] . "</td></tr>";
        }
        echo "</table>";
    } else {
        echo "<p>No fines found for this penalty.</p>";
    }
} else {
    echo "<p>No details found for this penalty.</p>";
}
?>