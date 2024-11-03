<link rel="icon" href="../images/favicon.png" type="image/png">

<?php
include "../app/connection.php";

if (isset($_SESSION['licenseNumber'])) {
  $license_number = $_SESSION["licenseNumber"];
} else {
  header("Location: ../login.php");
  exit;
}
?>

<link rel="stylesheet" href="css/userdashboard.css" />
<link rel="stylesheet" href="css/fines.css" />
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
      <li class="active"><a href="fine-details.php">Fine Details</a></li>
      <li><a href="payment-options.php">Payment Options</a></li>
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
        <a href="index.html">Home</a>>><a href="fine-details.html">Fine Details</a>
      </div>

      <h1 class="title">Fine Details</h1>

    </header>

    <!-- -------------------------------- -->

    <div id="sub-content">
      <div class="search-container">
        <input type="text" id="searchBar" placeholder="Search fines by name, details, or price...">
        <button id="searchBtn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
            class="bi bi-search" viewBox="0 0 16 16">
            <path
              d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
          </svg></button>
      </div>

      <table id="finesTable">
        <thead>
          <tr>
            <th>Fine Name</th>
            <th>Details</th>
            <th>Fine Payment</th>
          </tr>
        </thead>
        <tbody id="finesBody">
          <!-- Table rows will be inserted here by JavaScript -->
        </tbody>
    </div>
  </main>

  <!-- --------------------------------------------------- -->
</div>

<script src="js/userdashboard.js"></script>
<script>
  goProfile();
  document.addEventListener('DOMContentLoaded', fetchFines);
  async function fetchFines() {
    try {
      const response = await fetch('app/read_fines.php');
      const fines = await response.json();

      const finesBody = document.getElementById('finesBody');
      finesBody.innerHTML = ''; // Clear existing content

      fines.forEach(fine => {
        const row = document.createElement('tr');
        row.innerHTML = `
                        <td>${fine.fine_name}</td>
                        <td>${fine.details}</td>
                        <td>${fine.fine_payment}</td>
                    `;
        finesBody.appendChild(row);
      });
    } catch (error) {
      console.error('Error fetching fines:', error);
    }
  }

  document.addEventListener('DOMContentLoaded', fetchFines);

  document.getElementById('searchBtn').addEventListener('click', async () => {
    const query = document.getElementById('searchBar').value.toLowerCase();
    try {
      const response = await fetch('app/read_fines.php');
      const fines = await response.json();

      const filteredFines = fines.filter(fine => fine.fine_name.toLowerCase().includes(query));

      const finesBody = document.getElementById('finesBody');
      finesBody.innerHTML = ''; // Clear existing content

      filteredFines.forEach(fine => {
        const row = document.createElement('tr');
        row.innerHTML = `
                        <td>${fine.fine_name}</td>
                        <td>${fine.details}</td>
                        <td>${fine.fine_payment}</td>
                    `;
        finesBody.appendChild(row);
      });
    } catch (error) {
      console.error('Error filtering fines:', error);
    }
  });

  function filterFines(query) {
    const lowerQuery = query.toLowerCase();
    const filteredFines = fines.filter(fine => {
      return (
        fine.fine_name.toLowerCase().includes(lowerQuery) ||
        fine.details.toLowerCase().includes(lowerQuery) ||
        fine.fine_payment.toLowerCase().includes(lowerQuery)
      );
    });
    renderFines(filteredFines); // Render the filtered fines
  }

  document.getElementById('searchBar').addEventListener('input', (event) => {
    const query = event.target.value;
    filterFines(query);
  });

  document.getElementById('searchBar').addEventListener('keydown', (event) => {
    if (event.key === 'Enter') {
      const query = event.target.value;
      filterFines(query);
    }
  });

  function goProfile() {
    document.getElementById('go-profile').addEventListener('click', function () {
      window.location.href = 'profile';
    });
  }
</script>