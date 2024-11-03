<?php
include "../app/connection.php";
include_once "../notification.php";
include_once "../app/loading.php";

if (isset($_SESSION['policeId'])) {
  $police_id = $_SESSION["policeId"];
} else {
  header("Location: ../login.php");
  exit;
}
if (isset($_GET["penalty"]) && $_GET["penalty"] == "added") {
  callNotification("Penalty given successful.");
  $_SESSION["notification"] = false;
}
if (isset($_GET["penalty"]) && $_GET["penalty"] == "e1") {
  callNotification("License number is not in the system.");
}

if (isset($_GET["e2"])) {
  $e = $_GET["e2"];
  callNotification($e);
}
?>

<html>

<head>
  <link rel="stylesheet" href="css/stylesheet.css" />
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="js/formValidation.js"></script>
  <style>
    .error-message {
      color: red;
      font-size: 0.9em;
      margin-top: 5px;
    }
  </style>

</head>

<body>

  <!-- Nav Bar -->
  <div class="site-wrap">
    <!-- <div class="menu-toggle">&#9776;</div> -->
    <div class="menu-toggle" onclick="toggleMenu()">
      <span></span>
      <span></span>
      <span></span>
    </div>


    <nav class="site-nav">
      <div class="name">Fine System</div>



      <ul class="site-nav-ul">
        <li class="active"><a href="index.php">Dashboard</a></li>
        <li><a href="penalties.php">Penalties</a></li>
        <li><a href="fine-details.php">Fine Details</a></li>
        <li><a href="reports.php">Reports</a></li>
        <li><a href="support.php">Support</a></li>
      </ul>

      <div id="go-profile" class="note">
        <?php
        $police_id = $_SESSION['policeNumber'];
        $sql_name = "select name, profile_picture from policeman where police_id = '$police_id'";
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
        <svg onclick="logout()" id="logout-pos" class="logout-svg" xmlns="http://www.w3.org/2000/svg" width="24"
          height="24" viewBox="0 0 24 24">
          <path
            d="M12 21c4.411 0 8-3.589 8-8 0-3.35-2.072-6.221-5-7.411v2.223A6 6 0 0 1 18 13c0 3.309-2.691 6-6 6s-6-2.691-6-6a5.999 5.999 0 0 1 3-5.188V5.589C6.072 6.779 4 9.65 4 13c0 4.411 3.589 8 8 8z" />
          <path d="M11 2h2v10h-2z" />
        </svg>
        <div class="breadcrumbs">
          <a href="index.html">Home</a>
        </div>

        <h1 class="title">Dashboard</h1>
      </header>

      <!-- -------------------------------- -->

      <div id="sub-content">
        <div class="ag-format-container">
          <div class="ag-courses_box">
            <div class="ag-courses_item">
              <a href="#" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_title">
                  Daily Target
                </div>
                <div class="ag-courses-item_date-box">
                  <span class="ag-courses-item_date">
                    <?php
                    $sql_target = "select daily_target from policeman where police_id = '$police_id'";
                    $result = mysqli_query($conn, $sql_target);
                    if ($result) {
                      $row = mysqli_fetch_assoc($result);
                      $target = $row['daily_target'];
                    }
                    echo $target;
                    ?>
                  </span>
                </div>
              </a>
            </div>

            <div class="ag-courses_item">
              <a href="#" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="ag-courses-item_title">
                  Collected Today
                </div>

                <div class="ag-courses-item_date-box">
                  <span class="ag-courses-item_date">
                    <?php
                    $today = date('Y-m-d');
                    $sql_complete = "SELECT COUNT(*) AS count FROM penalty_sheet WHERE issued_date = '$today' and police_id = '$police_id'";
                    $result = mysqli_query($conn, $sql_complete);
                    if ($result) {
                      $row = mysqli_fetch_assoc($result);
                      $complete = $row['count'];

                    }
                    echo $complete;
                    ?>
                  </span>
                </div>
              </a>
            </div>

            <?php
            $dailyTargets = array_fill(0, 7, 0);

            $sql = "
          SELECT
              DATE(issued_date) as date,
              COUNT(*) as count
          FROM
              penalty_sheet
          WHERE
              police_id = '$police_id' AND
              issued_date >= CURDATE() - INTERVAL 7 DAY
          GROUP BY
              DATE(issued_date)
          ORDER BY
              DATE(issued_date);
      ";

            // Execute the query
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              // Create an associative array with the date as key
              $data = [];
              while ($row = $result->fetch_assoc()) {
                $data[$row['date']] = $row['count'];
              }

              // Fill the $dailyTargets array
              for ($i = 0; $i < 7; $i++) {
                $date = date('Y-m-d', strtotime("-$i days"));
                if (isset($data[$date])) {
                  $dailyTargets[6 - $i] = $data[$date];
                } else {
                  $dailyTargets[6 - $i] = 0;  // Ensure 0 is added for days with no penalties
                }
              }
            }

            ?>

            <div class="ag-courses_item">
              <a href="#" class="ag-courses-item_link">
                <div class="ag-courses-item_bg"></div>

                <div class="weekly-overview">
                  Weekly Overview
                </div>

                <div class="weekly-overview-text-box">

                  <span class="weekly-overview-item_date">
                    <span>
                      <canvas id="weeklyOverviewChart" width="500" height="200"></canvas>
                    </span>
                  </span>
                </div>
              </a>
            </div>
          </div>
        </div>

        <div class="form-noti">
          <form class="form" method="post" action="app/create-penalty.php">
            <div class="title">Add Penalty</div>
            <div class="subtitle">Do your job!</div>
            <div class="input-container ic1">
              <input id="firstname" class="input" name="license_number" type="text" placeholder=" " autocomplete="off"
                required />
              <div style="top:55px;" id="suggestions" class="suggestions-container lnum"></div>
              <div class="cut"></div>
              <label for="firstname" class="placeholder">License Number</label>
            </div>
            <div id="add-fines-container" class="input-container ic2">
              <textarea id="add-fines" name="charges" class="input" type="text" placeholder=" " autocomplete="off"
                required></textarea>
              <div id="suggestions" class="suggestions">
              </div>
              <div class="cut cut-short"></div>
              <label for="add-fines" class="placeholder">Fines</t>
            </div>


            <script src="js/suggest_fines.js"></script>
            <script src="js/suggest_license.js"></script>

            <button type="text" class="submit">submit</button>
          </form>

          <div class="notification-container">
            <div class="notification-header">
              <label>NOTIFICATIONS</label>
              <div class="my-moon"></div>
              <div class="notification-box">
                <?php
                $sql = "
                SELECT COUNT(*) AS notification_count
                FROM police_notification
                WHERE police_id = '$police_id'
              ";

                $result = $conn->query($sql);
                $notification_count = 0;

                if ($result && $row = $result->fetch_assoc()) {
                  $notification_count = $row['notification_count'];
                }

                echo '<span class="notification-count">' . htmlspecialchars($notification_count) . '</span>';
                ?>
                <div class="notification-bell">
                  <span class="bell-top"></span>
                  <span class="bell-middle"></span>
                  <span class="bell-bottom"></span>
                  <span class="bell-rad"></span>
                </div>
              </div>
            </div>

            <?php
            // Query to fetch the latest notifications for a specific police_id, ordered by date
            $sql = "
    SELECT n.title, n.description, n.date
    FROM notification AS n
    JOIN police_notification AS pn ON n.notification_id = pn.notification_id
    WHERE pn.police_id = '$police_id'
    ORDER BY n.date DESC
";

            // Execute the query
            $result = $conn->query($sql);

            // Check if there are any notifications
            if ($result && $result->num_rows > 0) {
              // Display each notification
              while ($row = $result->fetch_assoc()) {
                $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
                $description = htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');
                $date = htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8'); // Fetch and sanitize the date
            
                echo '<div class="notification-body">';
                echo '<div class="notification">';
                echo '<label class="n-head">' . $title . ':</label>';
                echo '<label class="n-body">' . $description . '</label>';
                echo '</div></div>';
              }
            } else {
              echo 'No notifications found.';
            }

            // Calculate the date 7 days ago
            $date_limit = date('Y-m-d', strtotime('-7 days'));

            // SQL query to delete notifications older than 7 days
            $del_sql = "
    DELETE n.*
    FROM notification AS n
    JOIN police_notification AS pn ON n.notification_id = pn.notification_id
    WHERE n.date < '$date_limit'
";

            // Execute the query
            // if ($conn->query($del_sql) === TRUE) {
            //   echo "Old notifications deleted successfully.";
            // } else {
            //   echo "Error deleting old notifications: " . $conn->error;
            // }
            ?>



          </div>
        </div>

        <div class="recent-fines-container">
          <label class="header">Recent fines</label>
          <div class="fine-main-cont recent-fine">
            <div class="thead">
              <label>Fine ID</label>
              <label>License Number</label>
              <label>Issued Date</label>
              <label>Full Charge</label>
              <label></label>
            </div>

            <?php
            $sql = "
            SELECT pid, license_number, issued_date, total_fine
            FROM penalty_sheet
            WHERE police_id = '$police_id'
            ORDER BY issued_date DESC
            LIMIT 5
          ";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
              while ($row = $result->fetch_assoc()) {
                echo '<div class="fine-card recent-fine-card">';
                echo '<label>' . htmlspecialchars($row['pid']) . '</label>';
                echo '<label>' . htmlspecialchars($row['license_number']) . '</label>';
                echo '<label>' . htmlspecialchars($row['issued_date']) . '</label>';
                echo '<label>' . htmlspecialchars($row['total_fine']) . '</label>';
                echo '<a href="penalties.php"><button>Show Details</button></a>';
                echo '</div>';
              }
            } else {
              echo "No recent penalty sheets found.";
            }
            ?>

          </div>

        </div>
        <div id="popup-form" class="popup-form">
          <div class="popup-form-content">
            <span class="close-popup">&times;</span>
            <h2>Add New License</h2>
            <form id="add-license-form" action="app/add_license.php" method="post">
              <div>
                <label for="new-license-number">License Number:</label>
                <input type="text" id="new-license-number" name="new_license_number" required />
                <div class="error-message" id="error-license-number"></div>
              </div>

              <div>
                <label for="new-license-name">License Holder Name:</label>
                <input type="text" id="new-license-name" name="new_license_name" required />
                <div class="error-message" id="error-license-name"></div>
              </div>

              <div>
                <label for="new-dob">Date of Birth:</label>
                <input type="date" id="new-dob" name="new_dob" required />
                <div class="error-message" id="error-dob"></div>
              </div>

              <div>
                <label for="new-address">Address:</label>
                <input type="text" id="new-address" name="new_address" required />
                <div class="error-message" id="error-address"></div>
              </div>

              <div>
                <label for="expiery-date">Expiry Date:</label>
                <input type="date" id="expiery-date" name="expiery_date" required />
                <div class="error-message" id="error-expiry-date"></div>
              </div>

              <button type="submit">Add License</button>
            </form>





          </div>
        </div>
      </div>
    </main>

    <!-- --------------------------------------------------- -->
  </div>

  <body>

</html>

<script>

  document.getElementById('add-license-form').addEventListener('submit', function (event) {
    // Clear previous error messages
    document.querySelectorAll('.error-message').forEach(function (errorDiv) {
      errorDiv.textContent = '';
    });

    let formIsValid = true;

    // License number validation
    const licenseNumber = document.getElementById('new-license-number').value;
    if (!licenseNumber.startsWith('B')) {
      document.getElementById('error-license-number').textContent = 'License Number must start with the letter B.';
      formIsValid = false;
    }

    // Date of Birth and Age validation (18 years old)
    const dob = new Date(document.getElementById('new-dob').value);
    const today = new Date();
    const age = today.getFullYear() - dob.getFullYear();
    const monthDifference = today.getMonth() - dob.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < dob.getDate())) {
      age--;
    }
    if (age < 18) {
      document.getElementById('error-dob').textContent = 'License holder must be at least 18 years old.';
      formIsValid = false;
    }

    // Expiry date validation (within 5 years)
    const expiryDate = new Date(document.getElementById('expiery-date').value);
    const maxExpiryDate = new Date();
    maxExpiryDate.setFullYear(maxExpiryDate.getFullYear() + 5);
    if (expiryDate > maxExpiryDate) {
      document.getElementById('error-expiry-date').textContent = 'Expiry Date must be within 5 years from today.';
      formIsValid = false;
    }

    // Prevent form submission if any validation fails
    if (!formIsValid) {
      event.preventDefault();
    }
  });

  function logout() {

    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../app/logout.php', true);
    xhr.send();

    xhr.onload = function () {
      if (xhr.status === 200) {
        window.location.href = '../login.php';
      }
    };
  }
</script>

<script>
  document.addEventListener("DOMContentLoaded", function () {
    closePopup();
    goProfile();


    var dailyTargets = <?php echo json_encode($dailyTargets); ?>;

    var ctx = document.getElementById('weeklyOverviewChart').getContext('2d');
    var weeklyOverviewChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: getLast7Days(),
        datasets: [{
          label: 'Fines Issued',
          data: dailyTargets,
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });
  });

  function getLast7Days() {
    let dates = [];
    let today = new Date();

    for (let i = 0; i < 7; i++) {
      let date = new Date();
      date.setDate(today.getDate() - i);
      dates.push(formatDate(date));
    }

    return dates.reverse();
  }

  function formatDate(date) {
    let day = String(date.getDate()).padStart(2, '0');
    let month = String(date.getMonth() + 1).padStart(2, '0');
    return `${month}/${day}`;
  }

  function closePopup() {
    document.querySelector(".close-popup").addEventListener("click", () => {
      document.querySelector("#popup-form").style.display = "none";
    });
  }

  function goProfile() {
    document.getElementById('go-profile').addEventListener('click', function () {
      window.location.href = 'profile';
    });
  }

  function menuToggle() {
    document.querySelector('.menu-toggle').addEventListener('click', function () {
      document.querySelector('.site-nav').classList.toggle('show');
    });

    document.querySelector('.close-nav').addEventListener('click', function () {
      document.querySelector('.site-nav').classList.remove('show');
    });

  }

</script>

<script>
  function toggleMenu() {
    document.querySelector('.site-nav').classList.toggle('show');
    document.querySelector('.site-wrap').classList.toggle('menu-open');
  }
</script>

<script src="js/script.js"></script>
