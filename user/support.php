<?php include "../app/connection.php";
if (isset($_SESSION['licenseNumber'])) {
  $license_number = $_SESSION["licenseNumber"];
} else {
  header("Location: ../login.php");
  exit;
}
?>
<link rel="stylesheet" href="css/userdashboard.css" />
<link rel="stylesheet" href="css/support.css" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

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
      <li><a href="payment-options.php">Payment Options</a></li>
      <li class="active"><a href="support.php">Support</a></li>
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
        <a href="index.html">Home</a>>><a href="support.html">Support</a>
      </div>

      <h1 class="title">Support</h1>
    </header>

    <!-- -------------------------------- -->

    <div id="sub-content">
      <div class="support">
        <header>
          <h1>User Support</h1>
          <p>Welcome to the support page for users. Here you'll find everything you need to manage your fines
            efficiently.</p>
        </header>
        <div class="container">
          <button class="toggle-btn" onclick="toggleSidebar()">☰</button>
          <script>
            function toggleSidebar() {
              const sidebar = document.querySelector('.support .sidebar');
              sidebar.style.display = sidebar.style.display === 'none' || sidebar.style.display === '' ? 'block' : 'none';
            }

          </script>
          <aside class="sidebar">
            <h2>Sections</h2>
            <ul>
              <li><a href="#overview" class="selected">Overview</a></li>
              <li><a href="#view-fines">View Fines</a></li>
              <li><a href="#pay-fines">Pay Fines</a></li>
              <li><a href="#user-guides">User Guides</a></li>
              <li><a href="#technical-support">Technical Support</a></li>
              <li><a href="#feedback">Feedback</a></li>
            </ul>
          </aside>
          <main>
            <section id="overview" class="card">
              <h2>Overview</h2>
              <p>Welcome to the User Support page. This section provides an overview of the features available to you as
                a user, including viewing and paying fines.</p>

              <h3>System Features</h3>
              <ul>
                <li><strong>View Fines:</strong> Access a detailed list of all the fines you have incurred.</li>
                <li><strong>Pay Fines:</strong> Easily pay any outstanding fines online.</li>
              </ul>

              <h3>Quick Tips</h3>
              <ul>
                <li><strong>Viewing Fines:</strong> Check the list regularly to stay updated on any fines you may have.
                </li>
                <li><strong>Paying Fines:</strong> Make sure to complete payments by the due date to avoid additional
                  penalties.</li>
              </ul>
            </section>

            <section id="view-fines" class="card">
              <h2>View Fines</h2>
              <p>To view the fines you have incurred, navigate to the "View Fines" section. Here, you can see a list of
                all your fines along with details such as the date of the fine, description, and amount.</p>

              <h3>How to View Your Fines</h3>
              <ol>
                <li>Go to the "View Fines" section from the sidebar.</li>
                <li>Review the list of fines displayed.</li>
                <li>Click on any fine to view more details, including the description and the due date.</li>
              </ol>
            </section>

            <section id="pay-fines" class="card">
              <h2>Pay Fines</h2>
              <p>Paying your fines is simple and straightforward. Follow these steps to complete your payment.</p>

              <h3>How to Pay Your Fines</h3>
              <ol>
                <li>Navigate to the "Pay Fines" section from the sidebar.</li>
                <li>Select the fine you wish to pay from the list of outstanding fines.</li>
                <li>Choose your payment method and enter the required payment details.</li>
                <li>Submit your payment and confirm the transaction.</li>
              </ol>

              <h3>Payment Tips</h3>
              <ul>
                <li><strong>Ensure Accuracy:</strong> Double-check payment details before submission.</li>
                <li><strong>Keep Confirmation:</strong> Save the payment confirmation for your records.</li>
                <li><strong>Contact Support:</strong> Reach out if you encounter any issues during the payment process.
                </li>
              </ul>
            </section>

            <section id="user-guides" class="card">
              <h2>User Guides</h2>
              <p>Find detailed guides and tutorials on how to use the Fine System effectively. Learn how to navigate the
                system, view fines, and manage payments.</p>
            </section>

            <section id="technical-support" class="card">
              <h2>Technical Support</h2>
              <p>If you experience any technical issues or need help with the Fine System, please visit our Technical
                Support section for troubleshooting tips and contact information.</p>
            </section>

            <section id="feedback" class="card">
              <h2>Feedback</h2>
              <p>Your feedback is important to us. Please use the form below to share your experiences and suggestions
                for improving the Fine System.</p>
              <form class="feedback-form">
                <h2>Feedback Form</h2>
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="message">Your Feedback:</label>
                <textarea id="message" name="message" required></textarea>

                <button type="submit">Submit Feedback</button>
              </form>
            </section>
          </main>
        </div>
        <footer>
          <p>&copy; 2024 Fine System. All rights reserved.</p>
        </footer>
      </div>

    </div>
  </main>

  <!-- --------------------------------------------------- -->
</div>

<script src="js/userdashboard.js"></script>
<script>
  goProfile();

  document.addEventListener('DOMContentLoaded', function () {
    const faqQuestions = document.querySelectorAll('.faq-question');

    faqQuestions.forEach(question => {
      question.addEventListener('click', function () {
        const answer = this.nextElementSibling;

        // Toggle the visibility of the answer
        if (answer.classList.contains('hidden')) {
          answer.classList.remove('hidden');
        } else {
          answer.classList.add('hidden');
        }
      });
    });

    // Sidebar active tab management
    const links = document.querySelectorAll('.sidebar ul li a');

    links.forEach(link => {
      link.addEventListener('click', function () {
        links.forEach(link => link.classList.remove('selected'));
        this.classList.add('selected');
      });
    });
  });

  function goProfile() {
    document.getElementById('go-profile').addEventListener('click', function () {
      window.location.href = 'profile';
    });
  }

</script>