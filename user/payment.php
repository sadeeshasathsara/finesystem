<?php
include "../app/connection.php";
$pid = $_GET["pid"];
?>

<link rel="stylesheet" href="css/payment.css">
<style>
    .popup {
        position: fixed;
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 20px;
        max-width: 300px;
        z-index: 1000;
        transition: opacity 0.3s ease;
        opacity: 1;
        text-align: center;
    }

    .popup-content {
        padding: 10px;
    }

    .popup p {
        margin: 10px 0;
    }

    .popup button {
        background-color: #007bff;
        border: none;
        color: white;
        padding: 10px 20px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        font-size: 16px;
        margin-top: 10px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .popup button:hover {
        background-color: #0056b3;
    }
</style>

<div class='container'>
    <div class='window'>
        <?php
        $sql = "
        SELECT 
            ps.pid,
            ps.total_fine,
            f.fine_name,
            f.fine_payment
        FROM 
            penalty_sheet ps
        JOIN 
            penalty_fine pf ON ps.pid = pf.pid
        JOIN 
            fine f ON pf.fid = f.fid
        where
            ps.pid = '$pid'
    ";

        // Execute the query and check for errors
        if ($result = $conn->query($sql)) {
            // Fetch the first row to get the penalty ID and total fine (assuming all rows have the same penalty ID)
            if ($row = $result->fetch_assoc()) {
                $pid = $row['pid'];
                $total_fine = $row['total_fine'];

                echo "<div class='order-info'>
                    <div class='order-info-content'>
                        <h2>Penalty Id: $pid</h2>
                        <div class='line'></div>";

                // Loop through all rows to display the fines in tables
                do {
                    echo "<table class='order-table'>
                        <tbody>
                            <tr>
                                <td><img src='src/F.png' class='full-width'></img></td>
                                <td><br> <span class='thin'>{$row['fine_name']}</span></td>
                            </tr>
                            <tr>
                                <td><div class='price'>Rs. {$row['fine_payment']}</div></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class='line'></div>";
                } while ($row = $result->fetch_assoc());

                echo "<div class='total'>
                    <span style='float:left;'>TOTAL</span>
                    <span style='float:right; text-align:right;'>Rs. $total_fine</span>
                  </div>
                </div>
              </div>";
            } else {
                echo "No results found.";
            }
        } else {
            echo "Error: " . $conn->error;
        }
        ?>

        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <div class='credit-info'>
            <div class='credit-info-content'>
                <img src='https://dl.dropboxusercontent.com/s/ubamyu6mzov5c80/visa_logo%20%281%29.png' height='80'
                    class='credit-card-image' id='credit-card-image'></img>
                Card Number
                <input id="cardNumberInput" class='input-field'></input>
                <span id="cardNumberError" class="error-message"></span> <!-- Error message for card number -->
                Card Holder
                <input id="cardholderNameInput" class='input-field'></input>
                <span id="cardholderNameError" class="error-message"></span> <!-- Error message for cardholder name -->
                <table class='half-input-table'>
                    <tr>
                        <td> Expires
                            <input id="expiryDateInput" class='input-field'></input>
                            <span id="expiryDateError" class="error-message"></span>
                            <!-- Error message for expiry date -->
                        </td>
                        <td>CVC
                            <input id="cvvInput" class='input-field'></input>
                            <span id="cvvError" class="error-message"></span> <!-- Error message for CVC -->
                        </td>
                    </tr>
                </table>
                <button id="payBtn" class='pay-btn' onclick="validateAndPay()">Pay Now</button>
            </div>
        </div>

        <script>
            function validateAndPay() {
                // Get input field values
                const cardNumberInput = document.getElementById("cardNumberInput").value.trim();
                const cardholderNameInput = document.getElementById("cardholderNameInput").value.trim();
                const expiryDateInput = document.getElementById("expiryDateInput").value.trim();
                const cvvInput = document.getElementById("cvvInput").value.trim();

                // Get error message elements
                const cardNumberError = document.getElementById("cardNumberError");
                const cardholderNameError = document.getElementById("cardholderNameError");
                const expiryDateError = document.getElementById("expiryDateError");
                const cvvError = document.getElementById("cvvError");

                // Clear previous error messages
                cardNumberError.textContent = "";
                cardholderNameError.textContent = "";
                expiryDateError.textContent = "";
                cvvError.textContent = "";

                let isValid = true;

                // Validate card number (16 digits with spaces after every 4 digits)
                const cardNumberPattern = /^(\d{4} ){3}\d{4}$/;
                if (!cardNumberPattern.test(cardNumberInput)) {
                    cardNumberError.textContent = "Card number must be 16 digits long, with spaces after every 4 digits.";
                    isValid = false;
                }

                // Validate expiry date (within the next 5 years)
                const expiryDatePattern = /^(0[1-9]|1[0-2])\/\d{2}$/; // Format MM/YY
                if (!expiryDatePattern.test(expiryDateInput)) {
                    expiryDateError.textContent = "Expiry date must be in MM/YY format.";
                    isValid = false;
                } else {
                    const currentDate = new Date();
                    const currentYear = currentDate.getFullYear() % 100; // Get last two digits of current year
                    const currentMonth = currentDate.getMonth() + 1;
                    const [month, year] = expiryDateInput.split("/").map(Number);

                    const expiryYear = 2000 + year;
                    if (
                        expiryYear < currentYear ||
                        (expiryYear === currentYear && month < currentMonth) ||
                        expiryYear > currentYear + 5
                    ) {
                        expiryDateError.textContent = "Expiry date must be within the next 5 years.";
                        isValid = false;
                    }
                }

                // Validate CVC (3 digits)
                const cvvPattern = /^\d{3}$/;
                if (!cvvPattern.test(cvvInput)) {
                    cvvError.textContent = "CVC must be exactly 3 digits.";
                    isValid = false;
                }

                // If all fields are valid, proceed with payment
                if (isValid) {
                    alert("Payment processed successfully!");
                    // Add payment processing logic here
                }
            }

            // Add event listener to format card number input as the user types
            document.getElementById("cardNumberInput").addEventListener("input", function (event) {
                let input = event.target.value.replace(/\s+/g, ""); // Remove spaces
                if (input.length > 16) {
                    input = input.slice(0, 16); // Limit to 16 digits
                }
                input = input.replace(/(\d{4})(?=\d)/g, "$1 ").trim(); // Add space after every 4 digits
                event.target.value = input;
            });

            // Add event listener to limit CVC input to 3 digits
            document.getElementById("cvvInput").addEventListener("input", function (event) {
                let input = event.target.value.replace(/\D/g, ""); // Remove non-digits
                if (input.length > 3) {
                    input = input.slice(0, 3); // Limit to 3 digits
                }
                event.target.value = input;
            });

        </script>

        <?php
        $licenseNumber = $_SESSION["licenseNumber"];

        // SQL query to get card details for the given license number
        $sql = "
        SELECT
        card_number,
        cardholder_name,
        expiry_date,
        cvv
        FROM
        payment_option
        WHERE
        license_number = '$licenseNumber'
        ";

        // Execute the query
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $cardDetails = [];
            while ($row = $result->fetch_assoc()) {
                $cardDetails[] = [
                    'card_number' => $row['card_number'],
                    'cardholder_name' => $row['cardholder_name'],
                    'expiry_date' => $row['expiry_date'],
                    'cvv' => $row['cvv']
                ];
            }

            // Output JavaScript for displaying popups
            echo "
        <script>";
            foreach ($cardDetails as $index => $card) {
                $cardNumber = htmlspecialchars($card['card_number']);
                $cardholderName = htmlspecialchars($card['cardholder_name']);
                $expiryDate = $card['expiry_date'];
                $cvv = htmlspecialchars($card['cvv']);

                $firstFour = substr($cardNumber, 0, 4);

                // Create a masked version with 'x' for the remaining digits
                $maskedSection = str_repeat('x', 12);

                // Combine and format the card number with spaces after every four characters
                $new_card = $firstFour . " " . substr($maskedSection, 0, 4) . " " . substr($maskedSection, 4, 4) . " " . substr($maskedSection, 8, 4);

                echo "
                // Create popup
                let popup = document.createElement('div');
                popup.className = 'popup';
                popup.style.top = '" . (20 + $index * 80) . "px'; // Position each popup slightly lower
                popup.style.left = '50%';
                popup.style.transform = 'translateX(-50%)';
                popup.innerHTML = `
                <div class='popup-content'>
                    <p><strong>Use this card:</strong> $new_card</p>
                    <p><strong>Cardholder:</strong> $cardholderName</p>

                    <button onclick='useCard(\"$cardNumber\", \"$cardholderName\", \"$expiryDate\", \"$cvv\")'>Use this card</button>
                </div>
            `;

                document.body.appendChild(popup);
                ";
            }
            echo "</script>";
        } else {
            echo "
        <script>console.log('No cards found for this license number.');</script>";
        }

        $conn->close();
        ?>

        <!-- Add this script to handle the card details input -->
        <script>
            function useCard(cardNumber, cardholderName, expiryDate, cvv) {
                // Add card details to input fields (ensure these IDs match your HTML input fields)
                document.getElementById('cardNumberInput').value = cardNumber;
                document.getElementById('cardholderNameInput').value = cardholderName;
                document.getElementById('expiryDateInput').value = expiryDate;
                document.getElementById('cvvInput').value = cvv;

                // Remove all popups
                const popups = document.querySelectorAll('.popup');
                popups.forEach(popup => popup.remove());
            }

            function redirectToSuccessPage() {
                // Get the PID from PHP
                var pid = '<?php echo $pid; ?>';

                // Construct the URL with the PID
                var url = 'success.php?pid=' + encodeURIComponent(pid);

                // Redirect to the success page
                window.location.href = url;
            }
        </script>


    </div>
</div>

<script src="js/payment.js"></script>