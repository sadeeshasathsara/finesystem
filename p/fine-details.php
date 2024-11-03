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
            <li><a href="penalties.php">Penalties</a></li>
            <li class="active"><a href="fine-details.php">Fine Details</a></li>
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

            <h1 class="title">Fine Details</h1>
        </header>

        <!-- -------------------------------- -->

        <div id="sub-content">
            <div class="search-bar-fine">
                <form onsubmit="event.preventDefault();" role="search">
                    <label for="search">Search for stuff</label>
                    <input id="search" type="search" placeholder="Search..." autofocus required />
                    <button type="submit">Go</button>
                </form>
            </div>
            <div id="no-search-results" style="display: none;">
                <label>Oops! No search results found.</label>
                <div></div>
            </div>
            <div class="fine-details-container">


                <?php
                // Query to get all fines
                $sql = "SELECT fid, fine_name, details, fine_payment FROM fine";
                $result = $conn->query($sql);

                // Check if query was successful and if there are results
                if ($result && $result->num_rows > 0) {
                    while ($fine = $result->fetch_assoc()) {
                        $fineId = htmlspecialchars($fine['fid']);
                        $fineName = htmlspecialchars($fine['fine_name']);
                        $fineDescription = htmlspecialchars($fine['details']);
                        $finePayment = htmlspecialchars($fine['fine_payment']);

                        // Count total penalties this fine has (Assuming penalty_fine table)
                        $penaltyCountSql = "SELECT COUNT(*) as penalty_count FROM penalty_fine WHERE fid = $fineId";
                        $penaltyCountResult = $conn->query($penaltyCountSql);
                        $penaltyCount = $penaltyCountResult ? $penaltyCountResult->fetch_assoc()['penalty_count'] : 0;

                        // Output the fine details in the required format
                        echo "<div class='nft'>
                <div class='main'>
                    <div class='mainscroll'>
                        <h2>$fineName #$fineId</h2>
                        <p class='description'>$fineDescription</p>
                        <div class='tokenInfo'>
                            <div class='price'>
                                <ins>
                                    <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-wallet' viewBox='0 0 16 16'>
                                        <path d='M0 3a2 2 0 0 1 2-2h13.5a.5.5 0 0 1 0 1H15v2a1 1 0 0 1 1 1v8.5a1.5 1.5 0 0 1-1.5 1.5h-12A2.5 2.5 0 0 1 0 12.5zm1 1.732V12.5A1.5 1.5 0 0 0 2.5 14h12a.5.5 0 0 0 .5-.5V5H2a2 2 0 0 1-1-.268M1 3a1 1 0 0 0 1 1h12V2H2a1 1 0 0 0-1 1'/>
                                    </svg>
                                </ins>
                                <p>Rs. $finePayment</p>
                            </div>
                            <div class='duration'>
                                <ins>◷</ins>
                                <p>$penaltyCount</p>
                            </div>
                        </div>
                    </div>
                    <hr />
                    <div class='creator'>
                        <div class='wrapper'>
                            <img src='https://images.unsplash.com/photo-1620121692029-d088224ddc74?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1932&q=80' alt='Creator' />
                        </div>
                        <p><ins>Department of Motor Traffic</ins></p>
                    </div>
                </div>
            </div>";
                    }
                } else {
                    echo "<p>No fines available.</p>";
                    echo mysqli_error($conn);
                }
                ?>
            </div>
        </div>
    </main>

    <!-- --------------------------------------------------- -->
</div>

<script src="js/script.js"></script>
<script src="js/fine_search.js"></script>
<script>
    goProfile();
    function goProfile() {
        document.getElementById("go-profile").addEventListener("click", function () {
            window.location.href = "profile";
        });
    }
</script>