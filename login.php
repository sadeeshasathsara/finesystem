<?php
include "app/connection.php";
include_once "notification.php";
include_once "app/loading.php";

if (isset($_GET["pwd"]) && $_GET["pwd"] == "updated") {
  callNotification("Password Updated!");
} else if (isset($_GET["e"]) && $_GET["e"] == "1") {
  callNotification("License number is not registered to the system!");
} else if (isset($_GET["e"]) && $_GET["e"] == "2") {
  callNotification("You already has an account. Please log in.");
} else if (isset($_GET["c"]) && $_GET["c"] == "1") {
  callNotification("Account created successfully! Please login.");
} else if (isset($_GET["e"])) {
  $e = $_GET["e"];
  callNotification($e);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <link rel="icon" href="images/favicon.png" type="image/png">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>SignIn&SignUp</title>
  <link rel="stylesheet" type="text/css" href="css/signin_sign_up.css" />
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <script src="https://kit.fontawesome.com/530acc1f39.js" crossorigin="anonymous"></script>

</head>

<body>
  <div class="container">
    <div class="forms-container">
      <div class="signin-signup">
        <form method="post" action="app/sign_in.php" class="sign-in-form">
          <h2 class="title">Sign In</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" placeholder="License Number/Police ID" name="license_number" />
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" placeholder="Password" name="pwd" />
          </div>
          <a id="pwd-reset" href="password_reset.php">Forgot password?</a>
          <input type="submit" value="Login" class="btn solid" />

          <?php
          if (isset($_SESSION["loginError"]) && $_SESSION["loginError"] == 1) {
            echo "<label id='login-error'>License Number or password is incorrect</label>";
            $_SESSION["loginError"] = 0;
          }
          ?>

          <p class="social-text">Or Sign in with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>


        <form action="app/sign_up.php" method="post" class="sign-up-form" id="sign-up-form">
          <h2 class="title">Sign Up</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input type="text" id="license-number-input" placeholder="License number" name="licenseNumber" />
            <label class="error-msg" id="license-error" class="error-message"></label>
          </div>
          <div class="input-field">
            <i class="fa fa-address-card"></i>
            <input type="text" id="nic-input" placeholder="NIC number" name="nic" />
            <label class="error-msg" id="nic-error" class="error-message"></label>
          </div>
          <div class="input-field">
            <i class="fa fa-id-badge"></i>
            <input type="text" id="phone-number-input" placeholder="Phone number" name="phoneNumber" />
            <label class="error-msg" id="phone-error" class="error-message"></label>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" id="password-input" placeholder="Password" name="pwd" />
            <label class="error-msg" id="password-error" class="error-message"></label>
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input type="password" id="confirm-password-input" placeholder="Confirm password" name="cpwd" />
            <label class="error-msg" id="confirm-password-error" class="error-message"></label>
          </div>
          <input type="submit" id="sign-up-btn" value="Sign Up" class="btn solid" />


          <?php
          if (isset($_SESSION["accountCreation"]) && $_SESSION["accountCreation"] == 1) {
            echo "<label class='account-creation'>Account successfully created! Please log in.</label>";
          }
          ?>

          <p class="social-text">Or Sign up with social platforms</p>
          <div class="social-media">
            <a href="#" class="social-icon">
              <i class="fab fa-facebook-f"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-twitter"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
            <a href="#" class="social-icon">
              <i class="fab fa-linkedin-in"></i>
            </a>
          </div>
        </form>
      </div>
    </div>
    <div class="panels-container">

      <div class="panel left-panel">
        <div class="content">
          <h3>New here?</h3>
          <p>Create your account and pay fines just by a click! Click sign up button.</p>
          <button class="btn transparent" id="sign-up-btnn">Sign Up</button>
        </div>
        <img src="./img/log.svg" class="image" alt="">
      </div>

      <div class="panel right-panel">
        <div class="content">
          <h3>One of us?</h3>
          <p>Already have an account? Click sign in button to log in to your account!</p>

          <button class="btn transparent" id="sign-in-btnn">Sign In</button>
        </div>
        <img src="./img/register.svg" class="image" alt="">
      </div>
    </div>
  </div>

  <script src="js/signin_signup.js"></script>
  <script src="js/sign_form_validation.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const inputs = document.querySelectorAll('.input-field input');

      inputs.forEach(input => {
        input.addEventListener('blur', function () {
          if (!input.value.trim()) {
            input.style.borderColor = 'red';
          } else {
            input.style.borderColor = '';
          }
        });

        input.addEventListener('input', function () {
          if (input.value.trim()) {
            input.style.borderColor = '';
          }
        });
      });
    });

  </script>
</body>

</html>