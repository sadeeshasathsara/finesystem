<?php
include "../app/connection.php";
if ($_SESSION["username"] == null) {
    header("Location: http://localhost/finesystem/admin/login");
    exit;
}
?>
<link rel="stylesheet" href="css/stylesheet.css">
<link rel="stylesheet" href="css/reports.css">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<div class="dashboard">
    <aside class="search-wrap">
        <button class="nav-toggle" aria-label="Toggle Navigation">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                <path d="M3 12h18v2H3v-2zm0-7h18v2H3V5zm0 14h18v2H3v-2z" />
            </svg>
        </button>
        <script>
            document.querySelector('.nav-toggle').addEventListener('click', function () {
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
                        <a href="index.php">
                            <svg xmlns=" http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
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
                        <a href="reports.php" class="selected">
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


        <div class="content">

            <div class="container">
                <h1>Generate Reports</h1>

                <div class="report-form">
                    <h2>Fine Overview Report</h2>
                    <button class="report-button" onclick="generateReport('fine-overview')">Generate Report</button>
                </div>

                <?php
                $sql = "SELECT did, name FROM police_division";
                $result = $conn->query($sql);

                // Generate options for the department select element
                $departmentOptions = '<option value="all">All Departments</option>';
                while ($row = $result->fetch_assoc()) {
                    $departmentOptions .= '<option value="' . $row['did'] . '">' . htmlspecialchars($row['name']) . '</option>';
                }
                ?>

                <div class="report-form">
                    <h2>Fines by Department Report</h2>
                    <label for="department">Select Department:</label>
                    <select id="department" name="department" class="form-select">
                        <?php echo $departmentOptions; ?>
                    </select>
                    <button class="report-button" onclick="generateReport('fines-by-department')">Generate
                        Report</button>
                </div>

                <div class="report-form">
                    <h2>Fines by Date Range Report</h2>
                    <label for="start-date">Start Date:</label>
                    <input type="date" id="start-date" name="start-date" class="form-input">
                    <label for="end-date">End Date:</label>
                    <input type="date" id="end-date" name="end-date" class="form-input">
                    <button class="report-button" onclick="generateReport('fines-by-date-range')">Generate
                        Report</button>
                </div>

                <div id="report-output" class="report-output">
                    <!-- Report results will be displayed here -->
                </div>
            </div>

        </div>
    </main>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.18/jspdf.plugin.autotable.min.js"></script>

<script src="js/reports.js"></script>
<script>
    document.querySelectorAll(".logout-svg").forEach(btn => {
        btn.addEventListener("click", () => {
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'app/log_out.php', true);
            xhr.setRequestHeader('Content-Type', 'app/log_out.php');

            xhr.onload = function () {
                if (xhr.status === 200) {
                    window.location.href = 'http://localhost/finesystem/admin/login/';
                }
            };

            xhr.send();
        });
    });


</script>