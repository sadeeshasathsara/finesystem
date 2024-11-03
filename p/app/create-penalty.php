<?php
include "../../app/connection.php";
include_once "../../notification.php";

if (isset($_POST["license_number"])) {
    $number = $_POST["license_number"];
    $fines = $_POST["charges"];
    $police_id = $_SESSION["policeNumber"];

    $today = date('Y-m-d');
    $date = new DateTime($today);
    $date->modify('+14 days');
    $deadLine = $date->format('Y-m-d');

    $finesArray = array_map('trim', explode(',', $fines));
    $escapedFines = array_map([$conn, 'real_escape_string'], $finesArray);
    $inClause = "'" . implode("','", $escapedFines) . "'";

    $sql = "SELECT fid FROM fine WHERE fine_name IN ($inClause)";
    $result = $conn->query($sql);
    $fids = [];

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $fids[] = $row['fid'];
        }
    } else {
        echo "Error: " . $conn->error;
    }

    $totalFine = 0;

    foreach ($fids as $fid) {
        $sql2 = "SELECT fine_payment FROM fine WHERE fid = $fid";

        $result = $conn->query($sql2);

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $finePrice = $row['fine_payment'];
            $totalFine += $finePrice;
        }
    }

    $sql3 = "INSERT INTO penalty_sheet (police_id, license_number, issued_date, deadline, total_fine) 
        VALUES ('$police_id', '$number', '$today', '$deadLine', '$totalFine')";

    if ($conn->query($sql3) === TRUE) {
        $pid = $conn->insert_id;

        foreach ($fids as $fid) {
            $sql4 = "INSERT INTO penalty_fine (pid, fid) VALUES ($pid, $fid)";
            if (!$conn->query($sql4)) {
                echo "Error inserting fid $fid: " . $conn->error;
            }
        }



        header("Location: " . baseUrl . "/p/index.php?penalty=added");
        exit;
    } else {
        header("Location: " . baseUrl . "/p/index.php?penalty=e1");
        exit;
    }

}
