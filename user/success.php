<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<style>
    /* styles.css */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 0;
    }

    .container {
        max-width: 800px;
        margin: 50px auto;
        padding: 20px;
        background-color: #fff;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    h1 {
        text-align: center;
        color: #4CAF50;
    }

    .details {
        margin-top: 20px;
    }

    .details table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    .details table,
    th,
    td {
        border: 1px solid #ddd;
    }

    .details th,
    td {
        padding: 10px;
        text-align: left;
    }

    .details th {
        background-color: #f2f2f2;
    }

    .btn {
        display: block;
        width: 200px;
        margin: 20px auto;
        padding: 10px;
        background-color: #4CAF50;
        color: #fff;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        transition: background-color 0.3s;
    }

    .btn:hover {
        background-color: #45a049;
    }
</style>

<?php
// Start output buffering to capture any unexpected output
ob_start();

// Include the necessary libraries and database connection
include "../app/connection.php";
require('../FPDF/fpdf.php');

// Get the PID from the query parameters
$pid = $_GET['pid'] ?? null;

if (!$pid) {
    die("No PID provided.");
}

// Query to get payment details
$sql = "
    SELECT 
        ps.pid,
        f.fine_name,
        f.fine_payment,
        ps.total_fine
    FROM 
        penalty_sheet ps
    JOIN 
        penalty_fine pf ON ps.pid = pf.pid
    JOIN 
        fine f ON pf.fid = f.fid
    WHERE 
        ps.pid = '$pid'
";

$sql2 = "update penalty_sheet set payment_status = 'paid' where pid = '$pid'";

mysqli_query($conn, $sql2);

// Execute the query
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $details = [];
    while ($row = $result->fetch_assoc()) {
        $details[] = [
            'fine_name' => $row['fine_name'],
            'fine_payment' => $row['fine_payment']
        ];
        $totalAmount = $row['total_fine'];
    }
} else {
    die("No payment details found.");
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</head>

<body>
    <div class="container">
        <h1>Payment Successful!</h1>
        <div class="details">
            <h2>Payment Details</h2>
            <table>
                <thead>
                    <tr>
                        <th>PID</th>
                        <th>Fine Name</th>
                        <th>Fine Payment</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($details as $detail): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($pid); ?></td>
                            <td><?php echo htmlspecialchars($detail['fine_name']); ?></td>
                            <td>Rs. <?php echo htmlspecialchars($detail['fine_payment']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2"><strong>Total Amount</strong></td>
                        <td><strong>Rs. <?php echo htmlspecialchars($totalAmount); ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <button id="download-pdf" class="btn">Download PDF</button>
    </div>

    <script>
        document.getElementById('download-pdf').addEventListener('click', function () {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF();

            // Define table header and data
            const headers = ['Fine Name', 'Fine Payment'];
            const data = <?php echo json_encode($details); ?>.map(detail => [
                detail.fine_name,
                'Rs. ' + detail.fine_payment
            ]);
            data.push(['Total Amount', 'Rs. ' + <?php echo json_encode($totalAmount); ?>]);

            // Define table position and size
            const startX = 20;
            const startY = 40;
            const rowHeight = 10;
            const columnWidths = [120, 50];
            const headerHeight = 12;
            const fontSize = 10;
            const lineWidth = 0.5; // Lighter border color

            // Draw table headers
            doc.setFontSize(fontSize + 2);
            doc.setFont('bold');
            doc.setFillColor(200, 200, 200); // Light grey background for header
            doc.rect(startX, startY, columnWidths[0] + columnWidths[1], headerHeight, 'F');
            doc.setTextColor(0, 0, 0); // Reset text color
            doc.text(headers[0], startX + 5, startY + 8);
            doc.text(headers[1], startX + columnWidths[0] + 5, startY + 8);

            // Draw table rows
            doc.setFontSize(fontSize);
            doc.setFont('normal');
            data.forEach((row, index) => {
                const y = startY + headerHeight + rowHeight * index;
                doc.text(row[0], startX + 5, y + 8);
                doc.text(row[1], startX + columnWidths[0] + 5, y + 8);
            });

            // Draw table border with light color
            doc.setDrawColor(180, 180, 180); // Light grey border color
            doc.setLineWidth(lineWidth);
            doc.rect(startX, startY, columnWidths[0] + columnWidths[1], headerHeight + rowHeight * data.length);

            // Horizontal lines
            data.forEach((_, index) => {
                doc.line(startX, startY + headerHeight + rowHeight * (index + 1), startX + columnWidths[0] + columnWidths[1], startY + headerHeight + rowHeight * (index + 1));
            });

            // Vertical lines
            doc.line(startX + columnWidths[0], startY, startX + columnWidths[0], startY + headerHeight + rowHeight * data.length);

            doc.save('payment_details.pdf');
        });
    </script>
</body>

</html>