<?php
include "../app/connection.php";
if (isset($_SESSION['policeId'])) {
    $police_id = $_SESSION["policeId"];
} else {
    header("Location: ../login.php");
    exit;
}
?>
<link rel="stylesheet" href="css/stylesheet.css" />
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <li class="active"><a href="penalties.php">Penalties</a></li>
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
            <div class="breadcrumbs">
                <a href="index.html">Home</a>
            </div>

            <h1 class="title">Penalties</h1>
        </header>

        <!-- -------------------------------- -->

        <div id="sub-content">
            <div class="Card">
                <div class="CardInner">
                    <label>Search for panalties you gave</label>
                    <div class="container">
                        <div class="Icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="#657789" stroke-width="3" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-search">
                                <circle cx="11" cy="11" r="8" />
                                <line x1="21" y1="21" x2="16.65" y2="16.65" />
                            </svg>
                        </div>
                        <div class="InputContainer">
                            <input placeholder="Eg: Failing to stop at a red traffic light fines..." />
                        </div>
                    </div>
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
                    <div id="no-search-results" style="display: none;">
                        <label>Oops! No search results found.</label>
                        <div></div>
                    </div>
                    <?php
                    // Query to fetch all penalty sheets issued by P00001
                    $sql = "SELECT pid, license_number, issued_date, total_fine FROM penalty_sheet WHERE police_id = 'P00001' ORDER BY issued_date DESC";
                    $result = $conn->query($sql);

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        // Loop through the results and display each penalty sheet
                        while ($row = $result->fetch_assoc()) {
                            $id = $row['pid'];
                            echo '<div class="fine-card recent-fine-card">';
                            echo '<label>' . $row['pid'] . '</label>';
                            echo '<label>' . $row['license_number'] . '</label>';
                            echo '<label>' . $row['issued_date'] . '</label>';
                            echo '<label>' . $row['total_fine'] . '</label>';
                            echo '<button class="show-de" id=show-details-' . $id . '>Show Details</button>';
                            echo '</div>';
                        }

                    } else {
                        echo "No penalty sheets found.";
                    }
                    ?>
                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                    <script src="js/get_penalty_details.js"></script>
                </div>
            </div>
            <div class="penalty-sheet-popup-overlay"></div>
            <div id="penalty-sheet-popup" class="penalty-sheet-popup hidden">
                <div class="penalty-sheet-popup-content">
                    <span id="close-penalty-popup" class="close-penalty-popup">&times;</span>
                    <h2>Penalty Details</h2>
                    <div id="penalty-details"></div>
                    <button id="print-penalty-sheet">Print</button>
                </div>
            </div>


        </div>
    </main>

    <!-- --------------------------------------------------- -->
</div>


<script>
    console.log('hi');
    let btns = document.querySelectorAll('.show-de');

    for (let btn of btns) {
        btn.addEventListener("click", () => {
            document.querySelector(".penalty-sheet-popup-overlay").style.visibility = "visible";
        });
    }

    document.querySelector("#close-penalty-popup").addEventListener("click", () => {
        document.querySelector(".penalty-sheet-popup-overlay").style.visibility = "hidden";
    });

</script>
<script src="js/script.js"></script>
<script src="js/search.js"></script>
<script>
    goProfile();
    function goProfile() {
        document.getElementById("go-profile").addEventListener("click", function () {
            window.location.href = "profile";
        });
    }
</script>