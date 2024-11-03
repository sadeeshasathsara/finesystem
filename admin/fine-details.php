<?php
include "../app/connection.php";
include_once "../notification.php";
if ($_SESSION["username"] == null) {
    header("Location: http://localhost/finesystem/admin/login");
    exit;
}
if (isset($_GET["fine"]) && $_GET["fine"] == "added") {
    callNotification("New fine added!");
}
?>

<link rel="stylesheet" href="css/stylesheet.css">
<link rel="stylesheet" href="css/fine-details.css">
<script src="js/formValidation.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
                        <a href="index.php">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    d="M6.855 14.365l-1.817 6.36a1.001 1.001 0 0 0 1.517 1.106L12 18.202l5.445 3.63a1 1 0 0 0 1.517-1.106l-1.817-6.36 4.48-3.584a1.001 1.001 0 0 0-.461-1.767l-5.497-.916-2.772-5.545c-.34-.678-1.449-.678-1.789 0L8.333 8.098l-5.497.916a1 1 0 0 0-.461 1.767l4.48 3.584zm2.309-4.379c.315-.053.587-.253.73-.539L12 5.236l2.105 4.211c.144.286.415.486.73.539l3.79.632-3.251 2.601a1.003 1.003 0 0 0-.337 1.056l1.253 4.385-3.736-2.491a1 1 0 0 0-1.109-.001l-3.736 2.491 1.253-4.385a1.002 1.002 0 0 0-.337-1.056l-3.251-2.601 3.79-.631z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="reports.php">
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
                        <a href="fine-details.php" class="selected">
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
            <h1>Fine Details</h1>

            <div class="action">
                <button id="addFineBtn">
                    Add Fine
                </button>
            </div>
        </header>

        <div class="content">

            <div class="add_fine__popup" id="addFinePopup">
                <div class="add_fine__popup-content">
                    <span class="add_fine__popup-close" id="closePopup">&times;</span>
                    <h2>Add Fine</h2>
                    <form method="post" action="app/add_fine.php">
                        <label for="fineName">Fine Name</label>
                        <input type="text" id="fineName" name="fineName" required>

                        <label for="fineAmount">Fine Amount</label>
                        <input type="number" id="fineAmount" name="fineAmount" required>

                        <label for="fineDescription">Description</label>
                        <textarea id="fineDescription" name="fineDescription" required></textarea>

                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>

            <div class="search-bar-fine">
                <form onsubmit="event.preventDefault();" role="search">
                    <label for="search">Search for stuff</label>
                    <input id="search" type="search" placeholder="Search..." autofocus />
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
                        echo "<div id='$fineId' class='nft'>
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

    <div id="fine-update-container" class="overlay close">
        <div class="fine-update-form">
            <span class="close-btn">&times;</span>
            <h2>Update Fine Details</h2>
            <form id="update-fine-form">
                <input type="hidden" id="update-fine-id" name="fine_id" />
                <label for="fine_name">Fine Name:</label>
                <input type="text" id="fine_name" name="fine_name" required />

                <label for="fine_description">Description:</label>
                <textarea id="fine_description" name="fine_description" required></textarea>

                <label for="fine_payment">Payment (Rs):</label>
                <input type="number" id="fine_payment" name="fine_payment" required />

                <button type="submit" class="update-btn">Update</button>
            </form>
        </div>
    </div>
</div>

<script src="../p/js/script.js"></script>
<script src="../p/js/fine_search.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    if (sessionStorage.getItem('fineUpdate') == "true") {
        showNotification('Updated Successfully!');
        sessionStorage.setItem('fineUpdate', 'false');
    }

    // Show the update form when an item is clicked
    document.querySelectorAll('.nft').forEach(item => {
        item.addEventListener('click', function() {
            const fineId = this.id;
            const fineName = this.querySelector('h2').textContent.split(' #')[0];
            const fineDescription = this.querySelector('.description').textContent;
            const finePayment = this.querySelector('.price p').textContent.replace('Rs. ', '');

            document.getElementById('update-fine-id').value = fineId;
            document.getElementById('fine_name').value = fineName;
            document.getElementById('fine_description').value = fineDescription;
            document.getElementById('fine_payment').value = finePayment;

            document.getElementById('fine-update-container').style.visibility = 'visible';
        });
    });

    // Close the form
    document.querySelector('.close-btn').addEventListener('click', function() {
        document.getElementById('fine-update-container').style.visibility = 'hidden';
    });

    // Handle form submission
    document.getElementById('update-fine-form').addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(this);

        fetch('app/update_fine.php', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.text())
            .then(data => {
                sessionStorage.setItem('fineUpdate', 'true');
                document.getElementById('fine-update-container').classList.add('hidden');
                location.reload(); // Refresh the page to reflect the updates
            })
            .catch(error => console.error('Error:', error));
    });
});
</script>

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

// Get the button that opens the popup
const addFineBtn = document.getElementById('addFineBtn');

// Get the popup
const addFinePopup = document.getElementById('addFinePopup');

// Get the close button
const closePopup = document.getElementById('closePopup');

// Open the popup when the button is clicked
addFineBtn.onclick = function() {
    addFinePopup.style.display = 'flex';
}

// Close the popup when the close button is clicked
closePopup.onclick = function() {
    addFinePopup.style.display = 'none';
}

// Close the popup when clicking outside of the popup content
window.onclick = function(event) {
    if (event.target === addFinePopup) {
        addFinePopup.style.display = 'none';
    }
}
</script>