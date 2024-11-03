<?php
include "../app/connection.php";
include_once "../notification.php";
include_once "../app/loading.php";
if ($_SESSION["username"] == null) {
    header("Location: http://localhost/finesystem/admin/login");
    exit;
}
if (isset($_GET["notification"]) && $_GET["notification"] == "sent") {
    callNotification("Notification Sent!");
    $_SESSION["notification"] = false;
}
?>

<link rel="stylesheet" href="css/stylesheet.css">
<link rel="stylesheet" href="css/index.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="js/formValidation.js"></script>

<div class="dashboard">
    <aside class="search-wrap">
        <button class="nav-toggle" aria-label="Toggle Navigation">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M3 12h18v2H3v-2zm0-7h18v2H3V5zm0 14h18v2H3v-2z" />
            </svg>
        </button>
        <script>
        document.querySelector('.nav-toggle').addEventListener('click', function() {
            document.querySelector('.menu-wrap').classList.toggle('active');
        });
        </script>
        <div class="search">

        </div>

        <div class="user-actions">
            <svg class="logout-svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path
                    d="M12 21c4.411 0 8-3.589 8-8 0-3.35-2.072-6.221-5-7.411v2.223A6 6 0 0 1 18 13c0 3.309-2.691 6-6 6s-6-2.691-6-6a5.999 5.999 0 0 1 3-5.188V5.589C6.072 6.779 4 9.65 4 13c0 4.411 3.589 8 8 8z" />
                <path d="M11 2h2v10h-2z" />
            </svg>
            </button>
        </div>
    </aside>

    <header class="menu-wrap">
        <figure class="user">
            <div class="user-avatar">
                <img src="https://images.unsplash.com/photo-1440589473619-3cde28941638?ixlib=rb-0.3.5&ixid=eyJhcHBfaWQiOjEyMDd9&s=42ebdb92a644e864e032a2ebccaa25b6&auto=format&fit=crop&w=100&q=80"
                    alt="Amanda King">
            </div>
            <figcaption>
                <?php echo $_SESSION["name"] ?>
            </figcaption>
        </figure>

        <nav>
            <section class="dicover">

                <ul>
                    <li>
                        <a href="index.php" class="selected">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    d="M6.855 14.365l-1.817 6.36a1.001 1.001 0 0 0 1.517 1.106L12 18.202l5.445 3.63a1 1 0 0 0 1.517-1.106l-1.817-6.36 4.48-3.584a1.001 1.001 0 0 0-.461-1.767l-5.497-.916-2.772-5.545c-.34-.678-1.449-.678-1.789 0L8.333 8.098l-5.497.916a1 1 0 0 0-.461 1.767l4.48 3.584zm2.309-4.379c.315-.053.587-.253.73-.539L12 5.236l2.105 4.211c.144.286.415.486.73.539l3.79.632-3.251 2.601a1.003 1.003 0 0 0-.337 1.056l1.253 4.385-3.736-2.491a1 1 0 0 0-1.109-.001l-3.736 2.491 1.253-4.385a1.002 1.002 0 0 0-.337-1.056l-3.251-2.601 3.79-.631z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="users.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    d="M5.707 19.707L12 13.414l4.461 4.461L14.337 20H20v-5.663l-2.125 2.124L13.414 12l4.461-4.461L20 9.663V4h-5.663l2.124 2.125L12 10.586 5.707 4.293 4.293 5.707 10.586 12l-6.293 6.293z" />
                            </svg>
                            Users
                        </a>
                    </li>

                    <li>
                        <a href="policeman.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    d="M20.205 4.791a5.938 5.938 0 0 0-4.209-1.754A5.906 5.906 0 0 0 12 4.595a5.904 5.904 0 0 0-3.996-1.558 5.942 5.942 0 0 0-4.213 1.758c-2.353 2.363-2.352 6.059.002 8.412l7.332 7.332c.17.299.498.492.875.492a.99.99 0 0 0 .792-.409l7.415-7.415c2.354-2.353 2.355-6.049-.002-8.416zm-1.412 7.002L12 18.586l-6.793-6.793c-1.562-1.563-1.561-4.017-.002-5.584.76-.756 1.754-1.172 2.799-1.172s2.035.416 2.789 1.17l.5.5a.999.999 0 0 0 1.414 0l.5-.5c1.512-1.509 4.074-1.505 5.584-.002 1.563 1.571 1.564 4.025.002 5.588z" />
                            </svg>
                            Policeman
                        </a>
                    </li>

                    <li>
                        <a href="fine-details.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    d="M12.707 2.293A.996.996 0 0 0 12 2H3a1 1 0 0 0-1 1v9c0 .266.105.52.293.707l9 9a.997.997 0 0 0 1.414 0l9-9a.999.999 0 0 0 0-1.414l-9-9zM12 19.586l-8-8V4h7.586l8 8L12 19.586z" />
                                <circle cx="7.507" cy="7.505" r="1.505" />
                            </svg>
                            Fine Details
                        </a>
                    </li>

                    <li>
                        <a href="reports.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    d="M5.707 19.707L12 13.414l4.461 4.461L14.337 20H20v-5.663l-2.125 2.124L13.414 12l4.461-4.461L20 9.663V4h-5.663l2.124 2.125L12 10.586 5.707 4.293 4.293 5.707 10.586 12l-6.293 6.293z" />
                            </svg>
                            Reports
                        </a>
                    </li>


                </ul>
            </section>
        </nav>
    </header>

    <main class="content-wrap">
        <header class="content-head">
            <h1>Dashboard</h1>


        </header>

        <div class="content">
            <section class="info-boxes">


                <div class="info-box">
                    <div class="box-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                            <path
                                d="M20 10H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1V11a1 1 0 0 0-1-1zm-1 10H5v-8h14v8zM5 6h14v2H5zM7 2h10v2H7z" />
                        </svg>
                    </div>

                    <?php
                    $sql = "SELECT COUNT(*) as total_violations
                            FROM penalty_sheet
                            WHERE DATE(issued_date) = CURDATE() - INTERVAL 1 DAY";

                    $result = $conn->query($sql);

                    if ($result && $row = $result->fetch_assoc()) {
                        $totalViolations = $row['total_violations'];
                    } else {
                        $totalViolations = 0;
                    }
                    ?>

                    <div class="box-content">
                        <span class="big"><?php echo $totalViolations; ?></span>
                        :Total Traffic Violations Yesterday
                    </div>

                </div>

                <div class="info-box">
                    <div class="box-icon">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-calendar-date" viewBox="0 0 16 16">
                            <path
                                d="M6.445 11.688V6.354h-.633A13 13 0 0 0 4.5 7.16v.695c.375-.257.969-.62 1.258-.777h.012v4.61zm1.188-1.305c.047.64.594 1.406 1.703 1.406 1.258 0 2-1.066 2-2.871 0-1.934-.781-2.668-1.953-2.668-.926 0-1.797.672-1.797 1.809 0 1.16.824 1.77 1.676 1.77.746 0 1.23-.376 1.383-.79h.027c-.004 1.316-.461 2.164-1.305 2.164-.664 0-1.008-.45-1.05-.82zm2.953-2.317c0 .696-.559 1.18-1.184 1.18-.601 0-1.144-.383-1.144-1.2 0-.823.582-1.21 1.168-1.21.633 0 1.16.398 1.16 1.23" />
                            <path
                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                        </svg>
                    </div>

                    <?php
                    $sql = "SELECT COUNT(*) as total_violations, COUNT(DISTINCT DATE(issued_date)) as days_active
                            FROM penalty_sheet
                            WHERE MONTH(issued_date) = MONTH(CURDATE() - INTERVAL 1 MONTH)
                            AND YEAR(issued_date) = YEAR(CURDATE() - INTERVAL 1 MONTH)";

                    $result = $conn->query($sql);

                    if ($result && $row = $result->fetch_assoc()) {
                        $totalViolations = $row['total_violations'];
                        $daysActive = $row['days_active'];

                        $averageDailyViolations = $daysActive > 0 ? $totalViolations / $daysActive : 0;

                        $lastMonthName = date('F', strtotime('-1 month'));
                    } else {
                        $averageDailyViolations = 0;
                        $lastMonthName = date('F', strtotime('-1 month'));
                    }
                    ?>

                    <div class="box-content">
                        <span class="big"><?php echo number_format($averageDailyViolations, 2); ?>%</span>
                        :Average Daily Violations (<?php echo $lastMonthName; ?>)
                    </div>
                </div>

                <div class="info-box">
                    <button for="popup-trigger" id="popup-trigger">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-plus-square-fill" viewBox="0 0 16 16">
                            <path
                                d="M2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2zm6.5 4.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3a.5.5 0 0 1 1 0" />
                        </svg>
                        Set Daily Target
                        <i class="uil uil-expand-arrows">

                        </i>
                    </button>

                    <div id="popup-form" class="target__popup">
                        <div class="target__popup-content">
                            <span class="close-btn">&times;</span>
                            <h2>Daily Limit</h2>
                            <form method="post">
                                <label for="limit">Limit:</label>
                                <input type="text" id="limit" name="limit" required>



                                <button type="submit">Submit</button>
                            </form>
                        </div>
                    </div>

                    <?php

                    if (isset($_POST["limit"])) {
                        $d_target = $_POST["limit"];
                        $limit_sql = "UPDATE policeman SET daily_target = '$d_target'";

                        if (mysqli_query($conn, $limit_sql)) {
                            callNotification("Daily target updated.");
                            unset($_POST['limit']);
                        } else {
                            $e = mysqli_error($conn);
                            callNotification("Error: $e");
                            unset($_POST['limit']);
                        }
                    }
                    $_POST = array();

                    ?>


                </div>

                <div class="info-box" id="notification-add-btn-cont">
                    <div class="section full-height">
                        <input class="modal-btn" type="checkbox" id="modal-btn" name="modal-btn" />
                        <label for="modal-btn">
                            <svg id="model-svg" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                fill="currentColor" class="bi bi-send" viewBox="0 0 16 16">
                                <path
                                    d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11ZM6.636 10.07l2.761 4.338L14.13 2.576zm6.787-8.201L1.591 6.602l4.339 2.76z" />
                            </svg>
                            Send Notifications
                            <i class="uil uil-expand-arrows">

                            </i>
                        </label>
                        <div class="modal">
                            <div class="modal-wrap">
                                <div class="noti-form">
                                    <form class="form" method="post" action="app/notification.php">
                                        <h2>NOTIFICATION</h2>
                                        <p type="Receiver:">
                                        <table>
                                            <tr>
                                                <td for="police">Police:</td>
                                                <td><input id="police" type="radio" value="Police" name="to_whome"
                                                        required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td for="license">License Holders:</td>
                                                <td><input id="license" type="radio" value="License Holder"
                                                        name="to_whome" required>
                                                </td>
                                            </tr>

                                            <tr>
                                                <td for="all">All:</td>
                                                <td><input id="all" type="radio" value="All" name="to_whome" required>
                                                </td>
                                            </tr>
                                        </table>

                                        </p>

                                        <p type="Title: "><input placeholder="What is this about..." name="title"
                                                required></p>
                                        <p type="Message:"><textarea type="" placeholder="Type the message here..."
                                                name="description" required></textarea></p>
                                        <button>Send Message</button>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <?php
            // Fetch the six latest notifications
            $query3 = "
    SELECT n.notification_id, n.title, n.description
    FROM notification n
    ORDER BY n.notification_id DESC
    LIMIT 6
";

            $result3 = mysqli_query($conn, $query3);

            // Check if the query execution was successful
            if (!$result3) {
                echo '<div class="past-not-container">';
                echo '<h2>Recent Notifications</h2>';
                echo '<p>Error executing query: ' . mysqli_error($conn) . '</p>';
                echo '</div>';
                exit; // Stop further execution if there's a query error
            }

            if (mysqli_num_rows($result3) > 0) {
                echo '<div class="past-not-container">';
                echo '<h2>Recent Notifications</h2>';
                echo '<ul class="responsive-table">';
                echo '<li class="table-header">';
                echo '<div class="col col-1">ID</div>';
                echo '<div class="col col-2">Receiver</div>';
                echo '<div class="col col-3">Title</div>';
                echo '<div class="col col-4">Message</div>';
                echo '</li>';

                while ($row = mysqli_fetch_assoc($result3)) {
                    $notification_id = $row['notification_id'];
                    $title = htmlspecialchars($row['title']);
                    $description = htmlspecialchars($row['description']);

                    // Determine the receiver
                    $receiver = 'Unknown';

                    // Check if the notification is in police_notification table
                    $police_check = "
            SELECT COUNT(*) as count
            FROM police_notification
            WHERE notification_id = '$notification_id'
        ";
                    $police_result = mysqli_query($conn, $police_check);

                    if (!$police_result) {
                        echo '<p>Error executing police check query: ' . mysqli_error($conn) . '</p>';
                        continue; // Skip this iteration if there's an error
                    }

                    $police_row = mysqli_fetch_assoc($police_result);
                    $police_count = $police_row['count'];

                    // Check if the notification is in license_notification table
                    $license_check = "
            SELECT COUNT(*) as count
            FROM license_notifications
            WHERE notification_id = '$notification_id'
        ";
                    $license_result = mysqli_query($conn, $license_check);

                    if (!$license_result) {
                        echo '<p>Error executing license check query: ' . mysqli_error($conn) . '</p>';
                        continue; // Skip this iteration if there's an error
                    }

                    $license_row = mysqli_fetch_assoc($license_result);
                    $license_count = $license_row['count'];

                    // Determine receiver based on counts
                    if ($police_count > 0 && $license_count > 0) {
                        $receiver = 'All Users';
                    } elseif ($police_count > 0) {
                        $receiver = 'All Officers';
                    } elseif ($license_count > 0) {
                        $receiver = 'All License Holders';
                    }

                    // Output the notification details
                    echo '<li class="table-row">';
                    echo '<div class="col col-1" data-label="ID">' . $notification_id . '</div>';
                    echo '<div class="col col-2" data-label="Receiver">' . $receiver . '</div>';
                    echo '<div class="col col-3" data-label="Title">' . $title . '</div>';
                    echo '<div class="col col-4" data-label="Message">' . $description . '</div>';
                    echo '</li>';
                }

                echo '</ul>';
                echo '</div>';
            } else {
                echo '<div class="past-not-container">';
                echo '<h2>Recent Notifications</h2>';
                echo '<p>No notifications found.</p>';
                echo '</div>';
            }
            ?>



        </div>

    </main>
</div>

<script>
document.querySelectorAll(".logout-svg").forEach(btn => {
    btn.addEventListener("click", () => {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'app/log_out.php', true);
        xhr.setRequestHeader('Content-Type', 'app/log_out.php');

        xhr.onload = function() {
            if (xhr.status === 200) {
                window.location.href = 'http://localhost/finesystem/admin/login/';
            }
        };

        xhr.send();
    });
});

document.getElementById('popup-trigger').addEventListener('click', function() {
    var popup = document.getElementById('popup-form');
    console.log('Clicked');

    popup.style.display = 'flex';
    setTimeout(function() {
        popup.classList.add('show');
    }, 10); // Delay to ensure display:flex is applied before transition
});



document.querySelector('.close-btn').addEventListener('click', function() {
    var popup = document.getElementById('popup-form');
    popup.classList.remove('show');
    setTimeout(function() {
        popup.style.display = 'none';
    }, 400); // Wait for the transition to complete before hiding
});

window.addEventListener('click', function(event) {
    var popup = document.getElementById('popup-form');
    if (event.target === popup) {
        popup.classList.remove('show');
        setTimeout(function() {
            popup.style.display = 'none';
        }, 400); // Wait for the transition to complete before hiding
    }
});
</script>