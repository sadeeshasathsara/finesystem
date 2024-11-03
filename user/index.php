<?php include "../app/connection.php";
include_once "../app/loading.php";
if (isset($_SESSION['licenseNumber'])) {
  $license_number = $_SESSION["licenseNumber"];
} else {
  header(header: "Location: ../login.php");
  exit;
}
?>
<link rel="stylesheet" href="css/userdashboard.css" />
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
            <li class="active">
                <a href="index.php">Dashboard </a>
            </li>

            <li>
                <a href="fine-details.php"> Fine Details </a>
            </li>
            <li>
                <a href="payment-options.php"> Payment Options </a>
            </li>
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
            <svg onclick="logout()" id="logout-pos" class="logout-svg" xmlns="http://www.w3.org/2000/svg" width="24"
                height="24" viewBox="0 0 24 24">
                <path
                    d="M12 21c4.411 0 8-3.589 8-8 0-3.35-2.072-6.221-5-7.411v2.223A6 6 0 0 1 18 13c0 3.309-2.691 6-6 6s-6-2.691-6-6a5.999 5.999 0 0 1 3-5.188V5.589C6.072 6.779 4 9.65 4 13c0 4.411 3.589 8 8 8z" />
                <path d="M11 2h2v10h-2z" />
            </svg>
            <div class="breadcrumbs">
                <a href="#0/">Home</a>
            </div>

            <h1 class="title">Dashboard</h1>

            <?php
      // Assuming you have a MySQLi connection already established in $conn
      
      // License number to check
      $license_number = $_SESSION["licenseNumber"];

      // Query to count the number of unpaid fines for the specific license number
      $sql = "
                SELECT COUNT(*) AS unpaid_fines_count
                FROM penalty_sheet
                WHERE license_number = '$license_number' AND payment_status = 'unpaid'
            ";

      $result = $conn->query($sql);

      // Initialize unpaid fines count to 0
      $unpaid_fines_count = 0;

      if ($result) {
        if ($row = $result->fetch_assoc()) {
          $unpaid_fines_count = $row['unpaid_fines_count'];
        }
      } else {
        echo "Error in query: " . $conn->error; // Debugging purposes
      }

      // Now use this value in your HTML
      ?>


            <nav class="nav-tabs" id="nav-tabs">
                <a href="#0" class="active" id="fine-tab">
                    Fines
                    <span>
                        <?php echo htmlspecialchars($unpaid_fines_count); ?>
                    </span>
                </a>
                <a href="#0" id="payment-tab"> Payment History </a>
                <?php

        $sql = "
    SELECT COUNT(*) AS notification_count
    FROM license_notifications
    WHERE license_number = '$license_number'
";

        $result = $conn->query($sql);

        if ($result && $row = $result->fetch_assoc()) {
          $notification_count = $row['notification_count'];
        } else {
          $notification_count = 0; // Default to 0 if query fails
        }
        ?>

                <a href="#0" id="notification-tab">
                    Notifications
                    <span>
                        <?php echo htmlspecialchars($notification_count, ENT_QUOTES, 'UTF-8'); ?>
                    </span>
                </a>

            </nav>
        </header>

        <!-- -------------------------------- -->

        <div id="sub-content">
            <div id="fines-content">
                <!-- Overdue Fines -->
                <div class="overdue flex items-center w-off">
                    <p id="overdue-txt">Overdue Fines</p>
                    <div class="line"></div>
                    <svg id="overdue-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                    </svg>
                </div>

                <?php
        $license_id = $_SESSION["licenseNumber"];
        // Assuming you have a MySQLi connection already established in $conn
        
        // Get today's date
        $today = date('Y-m-d');

        // Query to join penalty_sheet and policeman tables, and filter by deadlines that have passed
        $sql = "
    SELECT ps.pid, ps.issued_date, ps.deadline, ps.payment_status, p.name AS officer_name
    FROM penalty_sheet AS ps
    JOIN policeman AS p ON ps.police_id = p.police_id
    WHERE ps.deadline < '$today' and ps.payment_status = 'unpaid' and license_number = '$license_id'
    ORDER BY ps.issued_date DESC"; // Orders by latest issued date
        
        $result = $conn->query($sql);

        if ($result === false) {
          // Display the error for debugging purposes
          echo "Error in query: " . $conn->error;
        } else {
          if ($result->num_rows > 0) {
            echo '<div id="overdue-content" class="hidden">';
            echo '<div id="fine-card-header">';
            echo '<label id="fine-header">FineID</label>';
            echo '<label id="fine-policeman">Officer</label>';
            echo '<label id="route-header">IssuedDate</label>';
            echo '<label id="deadline-header">Deadline</label>';
            echo '<label id="full-payment">Status</label>';
            echo '</div>';

            while ($row = $result->fetch_assoc()) {
              $fineId = htmlspecialchars($row['pid'], ENT_QUOTES, 'UTF-8');
              $officerName = htmlspecialchars($row['officer_name'], ENT_QUOTES, 'UTF-8');
              $issuedDate = htmlspecialchars($row['issued_date'], ENT_QUOTES, 'UTF-8');
              $deadline = htmlspecialchars($row['deadline'], ENT_QUOTES, 'UTF-8');
              $payment = htmlspecialchars($row['payment_status'], ENT_QUOTES, 'UTF-8');

              echo '<div class="fine-card">';
              echo '<label>' . $fineId . '</label>';
              echo '<label class="officer-txt">' . $officerName . '</label>';
              echo '<label>' . $issuedDate . '</label>';
              echo '<label>' . $deadline . '</label>';
              echo '<label class="unpaid">' . $payment . '</label>';
              echo '<a href="overdue.php"><button class="animated-button">';
              echo '<svg xmlns="http://www.w3.org/2000/svg" class="arr-2" viewBox="0 0 24 24">';
              echo '<path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>';
              echo '</svg>';
              echo '<span class="text">PAY</span>';
              echo '<span class="circle"></span>';
              echo '<svg xmlns="http://www.w3.org/2000/svg" class="arr-1" viewBox="0 0 24 24">';
              echo '<path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>';
              echo '</svg>';
              echo '</button></a>';
              echo '</div>';
            }

            echo '</div>';
          } else {
            echo '<div id="overdue-content" class="hidden">';
            echo '<p class="fine-card">No overdue fines found.</p>';
            echo '</div>';
          }
        }
        ?>



                <!-- To be paid fines -->

                <div id="fines-content">
                    <div class="overdue flex items-center w-off">
                        <p id="tobe-txt">Fines to be paid</p>
                        <div class="line"></div>
                        <svg id="tobe-arrow" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                            fill="currentColor" class="bi bi-chevron-down" viewBox="0 0 16 16">
                            <path fill-rule="evenodd"
                                d="M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708" />
                        </svg>
                    </div>
                    <?php
          // Assuming you have a MySQLi connection already established in $conn
          
          // Get today's date
          $today = date('Y-m-d');

          // Query to join penalty_sheet and policeman tables, and filter by deadlines that have passed
          $sql = "
    SELECT ps.pid, ps.issued_date, ps.deadline, ps.payment_status, p.name AS officer_name
    FROM penalty_sheet AS ps
    JOIN policeman AS p ON ps.police_id = p.police_id
    WHERE ps.deadline > '$today' and ps.payment_status = 'unpaid'and license_number = '$license_id'
    ORDER BY ps.issued_date DESC"; // Orders by latest issued date
          
          $result = $conn->query($sql);

          if ($result === false) {
            // Display the error for debugging purposes
            echo "Error in query: " . $conn->error;
          } else {
            if ($result->num_rows > 0) {
              echo '<div id="tobe-content" class="hidden">';
              echo '<div id="fine-card-header">';
              echo '<label id="fine-header">FineID</label>';
              echo '<label id="fine-policeman">Officer</label>';
              echo '<label id="route-header">IssuedDate</label>';
              echo '<label id="deadline-header">Deadline</label>';
              echo '<label id="full-payment">Status</label>';
              echo '</div>';

              while ($row = $result->fetch_assoc()) {
                $fineId = htmlspecialchars($row['pid'], ENT_QUOTES, 'UTF-8');
                $officerName = htmlspecialchars($row['officer_name'], ENT_QUOTES, 'UTF-8');
                $issuedDate = htmlspecialchars($row['issued_date'], ENT_QUOTES, 'UTF-8');
                $deadline = htmlspecialchars($row['deadline'], ENT_QUOTES, 'UTF-8');
                $payment = htmlspecialchars($row['payment_status'], ENT_QUOTES, 'UTF-8');

                echo '<div class="fine-card">';
                echo '<label>' . $fineId . '</label>';
                echo '<label class="officer-txt">' . $officerName . '</label>';
                echo '<label>' . $issuedDate . '</label>';
                echo '<label>' . $deadline . '</label>';
                echo '<label class="unpaid">' . $payment . '</label>';
                echo '<a href="payment.php?pid=' . $fineId . '"><button class="animated-button">';
                echo '<svg xmlns="http://www.w3.org/2000/svg" class="arr-2" viewBox="0 0 24 24">';
                echo '<path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>';
                echo '</svg>';
                echo '<span class="text">PAY</span>';
                echo '<span class="circle"></span>';
                echo '<svg xmlns="http://www.w3.org/2000/svg" class="arr-1" viewBox="0 0 24 24">';
                echo '<path d="M16.1716 10.9999L10.8076 5.63589L12.2218 4.22168L20 11.9999L12.2218 19.778L10.8076 18.3638L16.1716 12.9999H4V10.9999H16.1716Z"></path>';
                echo '</svg>';
                echo '</button></a>';
                echo '</div>';
              }

              echo '</div>';
            } else {
              echo '<div id="tobe-content" class="hidden">';
              echo '<p class="fine-card">No to be paid fines found.</p>';
              echo '</div>';
            }
          }
          ?>
                </div>

                <!-- Fine Details popup -->

                <div class="details-popup hidden">
                    <div class="modal">
                        <article class="modal-container">
                            <header class="modal-container-header">
                                <h1 class="modal-container-title">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
                                        aria-hidden="true">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path fill="currentColor"
                                            d="M14 9V4H5v16h6.056c.328.417.724.785 1.18 1.085l1.39.915H3.993A.993.993 0 0 1 3 21.008V2.992C3 2.455 3.449 2 4.002 2h10.995L21 8v1h-7zm-2 2h9v5.949c0 .99-.501 1.916-1.336 2.465L16.5 21.498l-3.164-2.084A2.953 2.953 0 0 1 12 16.95V11zm2 5.949c0 .316.162.614.436.795l2.064 1.36 2.064-1.36a.954.954 0 0 0 .436-.795V13h-5v3.949z" />
                                    </svg>
                                    Terms and Services
                                </h1>
                                <button class="icon-button">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                        <path fill="none" d="M0 0h24v24H0z" />
                                        <path fill="currentColor"
                                            d="M12 10.586l4.95-4.95 1.414 1.414-4.95 4.95 4.95 4.95-1.414 1.414-4.95-4.95-4.95 4.95-1.414-1.414 4.95-4.95-4.95-4.95L7.05 5.636z" />
                                    </svg>
                                </button>
                            </header>
                            <section class="modal-container-body rtf">
                                <h1>Fine Details</h1>

                                <table>
                                    <tr>
                                        <td class="th">Fine ID</td>
                                        <td class="th-details">F0001</td>
                                    </tr>
                                    <tr>
                                        <td class="th">Fine</td>
                                        <td class="th-details">Test Fine Name</td>
                                    </tr>
                                    <tr>
                                        <td class="th">Fine details</td>
                                        <td class="th-details">
                                            Lorem ipsum dolor sit amet consectetur adipisicing elit.
                                            Sapiente assumenda praesentium repudiandae nam impedit
                                            sequi iure alias. Id dicta laudantium consequuntur
                                            delectus quas corrupti quaerat nesciunt sed accusantium,
                                            harum commodi?
                                        </td>
                                    </tr>
                                </table>
                            </section>
                            <footer class="modal-container-footer">
                                <button class="button is-primary close-btn">Close</button>
                            </footer>
                        </article>
                    </div>
                </div>
            </div>

            <div id="payment-content" class="hidden">
                <h1>Payment Content</h1>
                <?php
        $license_id = $_SESSION["licenseNumber"];
        // Assuming you have a MySQLi connection already established in $conn
        
        // Get today's date
        $today = date('Y-m-d');

        // Query to join penalty_sheet and policeman tables, and filter by deadlines that have passed
        $sql = "
    SELECT ps.pid, ps.issued_date, ps.deadline, ps.payment_status, p.name AS officer_name
    FROM penalty_sheet AS ps
    JOIN policeman AS p ON ps.police_id = p.police_id
    WHERE ps.payment_status = 'paid' and license_number = '$license_id'
    ORDER BY ps.issued_date DESC"; // Orders by latest issued date
        
        $result = $conn->query($sql);

        if ($result === false) {
          // Display the error for debugging purposes
          echo "Error in query: " . $conn->error;
        } else {
          if ($result->num_rows > 0) {
            echo '<div id="overdue-content">';
            echo '<div id="fine-card-header">';
            echo '<label id="fine-header">FineID</label>';
            echo '<label id="fine-policeman">Officer</label>';
            echo '<label id="route-header">IssuedDate</label>';
            echo '<label id="deadline-header">Deadline</label>';
            echo '<label id="full-payment">Status</label>';
            echo '</div>';

            while ($row = $result->fetch_assoc()) {
              $fineId = htmlspecialchars($row['pid'], ENT_QUOTES, 'UTF-8');
              $officerName = htmlspecialchars($row['officer_name'], ENT_QUOTES, 'UTF-8');
              $issuedDate = htmlspecialchars($row['issued_date'], ENT_QUOTES, 'UTF-8');
              $deadline = htmlspecialchars($row['deadline'], ENT_QUOTES, 'UTF-8');
              $payment = htmlspecialchars($row['payment_status'], ENT_QUOTES, 'UTF-8');

              echo '<div class="fine-card">';
              echo '<label>' . $fineId . '</label>';
              echo '<label class="officer-txt">' . $officerName . '</label>';
              echo '<label>' . $issuedDate . '</label>';
              echo '<label>' . $deadline . '</label>';
              echo '<label class="paid">' . $payment . '</label>';

              echo '</div>';
            }

            echo '</div>';
          } else {
            echo '<div id="overdue-content">';
            echo '<p class="fine-card">No paid fines found.</p>';
            echo '</div>';
          }
        }
        ?>
            </div>

            <div id="notificaton-content" class="hidden">
                <h1>Notifications</h1>
                <?php
        // Assuming you have a MySQLi connection already established in $conn
// And that the user's license number is available in a variable $license_number
        
        // Fetch notifications for the given license number
        
        $sql = "
    SELECT n.notification_id, n.title, n.description, n.date
    FROM notification AS n
    JOIN license_notifications AS ln ON n.notification_id = ln.notification_id
    WHERE ln.license_number = '$license_number'
    ORDER BY n.date DESC
";

        $result = $conn->query($sql);

        if ($result === false) {
          echo "Error in query: " . $conn->error;
        } else {
          if ($result->num_rows > 0) {
            echo '<div class="notification-container">';

            while ($row = $result->fetch_assoc()) {
              $notificationId = htmlspecialchars($row['notification_id'], ENT_QUOTES, 'UTF-8');
              $title = htmlspecialchars($row['title'], ENT_QUOTES, 'UTF-8');
              $description = htmlspecialchars($row['description'], ENT_QUOTES, 'UTF-8');
              $date = htmlspecialchars($row['date'], ENT_QUOTES, 'UTF-8');

              echo '<div class="notification-card" data-id="' . $notificationId . '">';
              echo '<div class="notification-header">';
              echo '<h3 class="notification-title">' . $title . '</h3>';
              echo '<span class="notification-date">' . $date . '</span>';
              echo '</div>';
              echo '<div class="notification-body">';
              echo '<p class="notification-description">' . $description . '</p>';
              echo '</div>';
              echo '</div>';
            }

            echo '</div>';
          } else {
            echo '<p>No notifications found.</p>';
          }
        }
        ?>


            </div>
        </div>
    </main>

    <!-- --------------------------------------------------- -->
</div>

<script src="js/userdashboard.js"></script>
<script>
goProfile();

function logout() {

    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../app/logout.php', true);
    xhr.send();

    xhr.onload = function() {
        if (xhr.status === 200) {
            window.location.href = '../login.php';
        }
    };
}

document.addEventListener("DOMContentLoaded", function() {
    const fineCard = document.querySelector(".fine-card");
    const fineCardHeader = document.getElementById("fine-card-header");

    if (fineCard && fineCardHeader) {
        const fineCardLabels = fineCard.querySelectorAll("label");
        const headerLabels = fineCardHeader.querySelectorAll("label");

        fineCardLabels.forEach((label, index) => {
            if (headerLabels[index]) {
                const labelWidth = label.offsetWidth;

                // Set the width of the header label to match the fine-card label
                headerLabels[index].style.width = labelWidth + "px";
                headerLabels[index].style.textAlign = "center";
            }
        });

        // Align the header slightly above the fine-card
        fineCardHeader.style.position = "absolute";
        fineCardHeader.style.top = (fineCard.offsetTop - 30) + "px"; // Move the header 10px higher
        fineCardHeader.style.left = fineCard.offsetLeft + "px";
    }
});

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.notification-card').forEach(card => {
        card.addEventListener('click', function() {
            const notificationId = this.getAttribute('data-id');

            card.style.opacity = '0';
            setTimeout(() => {
                card.style.display = 'none';
            }, 300);

            fetch('app/delete_notification.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `notification_id=${notificationId}`
                })
                .then(response => response.text())
                .then(result => {
                    if (result === 'success') {
                        this.remove();
                    } else {
                        alert('Failed to delete notification: ' + result);
                    }
                })
                .catch(error => console.error('Error:', error));
        });
    });
});

function goProfile() {
    document.getElementById('go-profile').addEventListener('click', function() {
        window.location.href = 'profile';
    });
}
</script>