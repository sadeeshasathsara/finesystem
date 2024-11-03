<?php include "../app/connection.php";
include_once "../notification.php";
if (isset($_SESSION['licenseNumber'])) {
  $license_number = $_SESSION["licenseNumber"];
} else {
  header("Location: ../login.php");
  exit;
}
if (isset($_GET["s"]) && $_GET["s"] == "true") {
  callNotification("Successfully Added!");
} else if (isset($_GET["e"])) {
  $e = $_GET["e"];
  callNotification($e);
}
?>

<link rel="stylesheet" href="css/userdashboard.css" />
<link rel="stylesheet" href="css/payment_options.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="js/formValidation.js"></script>

<!-- Nav Bar -->
<div class="site-wrap">
  <div class="menu-toggle" onclick="toggleMenu()">
    <span></span>
    <span></span>
    <span></span>
  </div>
  <script>
    function toggleMenu() {
      document.querySelector('.site-nav').classList.toggle('show');
      document.querySelector('.site-wrap').classList.toggle('menu-open');
    }
  </script>
  <nav class="site-nav">
    <div class="name">Fine System</div>

    <ul class="site-nav-ul">
      <li><a href="index.php">Dashboard</a></li>
      <li><a href="fine-details.php">Fine Details</a></li>
      <li class="active"><a href="payment-options.php">Payment Options</a></li>
      <li><a href="support.php">Support</a></li>
    </ul>

    <div id="go-profile" class="note">
      <?php
      $license_number = $_SESSION['licenseNumber'];
      $sql_name = "SELECT l.name, lh.profile_picture
                    FROM license l
                    JOIN license_holder lh ON l.license_number = lh.license_number
                    WHERE l.license_number = '$license_number';";
      $result = mysqli_query($conn, $sql_name);
      if ($result) {

        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $profile_picture_url = 'src/profile_photo/' . $row['profile_picture'];
        ?>
        <h3><?php echo $name;
      } ?></h3>
      <?php echo '<img src="' . $profile_picture_url . ' " alt="pp" />' ?>

    </div>
  </nav>
  <!-- ---------------------------------------------------- -->

  <!-- Main Content -->
  <main>
    <!-------------- Main Header------------->
    <header>
      <div class="breadcrumbs">
        <a href="index.html">Home</a>>><a href="payment-options.html">Payment Options</a>
      </div>

      <h1 class="title">Payment Options</h1>

    </header>

    <!-- -------------------------------- -->

    <div id="sub-content">
      <div class="m-cont">
        <div class='card-container'>
          <?php
          $license_number = $_SESSION["licenseNumber"];
          // Fetch card details for this license number
          $sql = "SELECT card_number, cardholder_name, expiry_date, cvv FROM payment_option WHERE license_number = '$license_number'";
          $result = $conn->query($sql);

          // Check if any cards are available
          if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
              // Format card number for display
              $card_number = chunk_split($row['card_number'], 4, ' ');
              $expiry_date = date('m / y', strtotime($row['expiry_date']));
              $cardholder_name = strtoupper($row['cardholder_name']);
              $cvv = $row['cvv'];

              // Generate the HTML for each card
              echo "
        
            <div class='card'>
                <div class='card-inner'>
                    <div class='front'>
                        <img src='https://i.ibb.co/PYss3yv/map.png' class='map-img'>
                        <div class='row'>
                            <img src='https://i.ibb.co/G9pDnYJ/chip.png' width='60px'>
                            <img src='https://i.ibb.co/WHZ3nRJ/visa.png' width='60px'>
                        </div>
                        <div class='row card-no'>
                            <p>" . implode('</p><p>', explode(' ', $card_number)) . "</p>
                        </div>
                        <div class='row card-holder'>
                            <p>CARD HOLDER</p>
                            <p>VALID TILL</p>
                        </div>
                        <div class='row name'>
                            <p>$cardholder_name</p>
                            <p>$expiry_date</p>
                        </div>
                    </div>
                    <div class='back'>
                        <img src='https://i.ibb.co/PYss3yv/map.png' class='map-img'>
                        <div class='bar'></div>
                        <div class='row card-cvv'>
                            <div>
                                <img src='https://i.ibb.co/S6JG8px/pattern.png'>
                            </div>
                            <p>$cvv</p>
                        </div>
                        <div class='row card-text'>
                            
                        </div>
                        <div class='row signature'>
                            <p></p>
                            <img src='https://i.ibb.co/WHZ3nRJ/visa.png' width='80px'>
                        </div>
                    </div>
                </div>
            </div>
        ";
            }
          } else {
            echo "<p>No cards available for this user.</p>";
          }
          ?>
        </div>

        <div class="form-main-container">
          <div class="form-container">
            <h1>Save Payment Card Details</h1>
            <form id="payment-form" method="post" action="app/save_payment_option.php">
              <div class="form-group">
                <label for="card_number">Card Number:</label>
                <input type="text" id="card_number" name="card_number" maxlength="19" required>
                <small class="error-message" id="card_number_error"></small>
              </div>
              <div class="form-group">
                <label for="cardholder_name">Cardholder Name:</label>
                <input type="text" id="cardholder_name" name="cardholder_name" required>
                <small class="error-message" id="cardholder_name_error"></small>
              </div>
              <div class="form-group">
                <label for="expiry_date">Expiry Date:</label>
                <input type="month" id="expiry_date" name="expiry_date" required>
                <small class="error-message" id="expiry_date_error"></small>
              </div>
              <div class="form-group">
                <label for="cvv">CVV:</label>
                <input type="text" id="cvv" name="cvv" maxlength="3" required>
                <small class="error-message" id="cvv_error"></small>
              </div>
              <div class="form-group">
                <label for="billing_address">Billing Address:</label>
                <input type="text" id="billing_address" name="billing_address" required>
                <small class="error-message" id="billing_address_error"></small>
              </div>
              <button type="submit" class="submit-button">Save Details</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- --------------------------------------------------- -->
</div>

<script src="js/userdashboard.js"></script>

<script>
  goProfile();

  document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('payment-form');
    const cardNumberInput = document.getElementById('card_number');
    const cardHolderInput = document.getElementById('cardholder_name');
    const expiryDateInput = document.getElementById('expiry_date');
    const cvvInput = document.getElementById('cvv');

    form.addEventListener('submit', (event) => {
      event.preventDefault(); // Prevent form from submitting

      // Clear previous errors
      clearErrors();

      let isValid = true;

      // Get the raw value of card number without formatting spaces
      const rawCardNumber = cardNumberInput.value.replace(/\s+/g, '');

      // Validate card number
      if (!validateCardNumber(rawCardNumber)) {
        displayError('card_number_error', 'Card number must be 16 digits.');
        isValid = false;
      }

      // Validate card holder name
      if (!validateCardHolderName(cardHolderInput.value)) {
        displayError('cardholder_name_error', 'Card holder name cannot include numbers or special characters.');
        isValid = false;
      }

      // Validate expiry date
      if (!validateExpiryDate(expiryDateInput.value)) {
        displayError('expiry_date_error', 'Expiry date must be valid and within 5 years from today.');
        isValid = false;
      }

      // Validate CVV
      if (!validateCVV(cvvInput.value)) {
        displayError('cvv_error', 'CVV must be 3 digits and cannot include special characters or letters.');
        isValid = false;
      }

      if (isValid) {
        // Submit form or proceed with further actions
        form.submit();
      }
    });

    function validateCardNumber(value) {
      return /^\d{16}$/.test(value);
    }

    function validateCardHolderName(value) {
      return /^[A-Za-z\s]+$/.test(value);
    }

    function validateExpiryDate(value) {
      const today = new Date();
      const expiryDate = new Date(value + '-01'); // Adding day to convert "YYYY-MM" to "YYYY-MM-DD"
      const fiveYearsFromNow = new Date();
      fiveYearsFromNow.setFullYear(today.getFullYear() + 5);
      return expiryDate >= today && expiryDate <= fiveYearsFromNow;
    }

    function validateCVV(value) {
      return /^\d{3}$/.test(value);
    }

    function formatCardNumber(value) {
      // Remove all non-digit characters
      value = value.replace(/\D/g, '');
      // Add spaces every 4 digits
      return value.replace(/(.{4})/g, '$1 ').trim();
    }

    function displayError(id, message) {
      const errorElement = document.getElementById(id);
      if (errorElement) {
        errorElement.textContent = message;
      } else {
        console.error(`Error element with ID ${id} not found.`);
      }
    }

    function clearErrors() {
      const errorMessages = document.querySelectorAll('.error-message');
      errorMessages.forEach(error => error.textContent = '');
    }

    function debounce(func, wait) {
      let timeout;
      return function (...args) {
        clearTimeout(timeout);
        timeout = setTimeout(() => func.apply(this, args), wait);
      };
    }

    // Format card number on input with debounce
    const formatCardNumberDebounced = debounce((event) => {
      const input = event.target;
      const cursorPosition = input.selectionStart;
      const rawValue = input.value.replace(/\s+/g, '');
      const formattedValue = formatCardNumber(rawValue);

      // Update input value
      input.value = formattedValue;

      // Adjust cursor position
      let newCursorPosition = cursorPosition;
      if (cursorPosition >= formattedValue.length) {
        newCursorPosition = formattedValue.length;
      } else {
        const lengthDiff = formattedValue.length - rawValue.length;
        newCursorPosition = cursorPosition + lengthDiff;
      }
      input.selectionStart = newCursorPosition;
      input.selectionEnd = newCursorPosition;
    }, 100);

    cardNumberInput.addEventListener('input', formatCardNumberDebounced);

    // Optionally, format card number on paste
    cardNumberInput.addEventListener('paste', (event) => {
      event.preventDefault();
      const pastedData = event.clipboardData.getData('text').replace(/\D/g, '');
      cardNumberInput.value = formatCardNumber(pastedData);
      cardNumberInput.setSelectionRange(pastedData.length, pastedData.length);
    });
  });




  function goProfile() {
    document.getElementById('go-profile').addEventListener('click', function () {
      window.location.href = 'profile';
    });
  }




</script>