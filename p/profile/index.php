<?php
include "../../app/connection.php";
include_once "../../notification.php";

if (isset($_GET["police_id"])) {
    $police_id = $_GET["police_id"];
} else if (isset($_SESSION['policeNumber'])) {
    $police_id = $_SESSION["policeNumber"];
} else {
    header("Location: ../../login.php");
    exit;
}

if (isset($_GET["success"]) && $_GET["success"] == "true") {
    callNotification("Successfully Updated");
} else if (isset($_GET["e"]) && $_GET["e"] == "div") {
    callNotification("Invalid police division");
}



$sql = "SELECT * FROM policeman where police_id = '$police_id'";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch all rows as an associative array
    while ($row = $result->fetch_assoc()) {
        // Assign each column value to a variable
        $police_id = $row['police_id'];
        $name = $row['name'];
        $profile_picture = $row['profile_picture'];
        $position = $row['position'];
        $did = $row['did'];
        $dob = $row['dob'];
        $mobile = $row['mobile'];
        $address = $row['address'];
        $password = $row['password'];

        $division_sql = "SELECT name FROM police_division WHERE did = '$did'";
        $data = mysqli_query($conn, $division_sql);

        if ($data) {
            if ($row = mysqli_fetch_assoc($data)) {
                $department = $row['name'];
            } else {
                $department = 'No department found'; // Handle case where no row is returned
            }
        } else {
            $department = 'Query failed'; // Handle case where query fails
        }

        $penalty_count_sql = "SELECT COUNT(*) AS penalty_count FROM penalty_sheet WHERE police_id = '$police_id'";
        $penalty_count_result = mysqli_query($conn, $penalty_count_sql);
        if ($penalty_count_result) {
            $penalty_count_row = mysqli_fetch_assoc($penalty_count_result);
            $penalty_count = $penalty_count_row['penalty_count'];
        } else {
            $penalty_count = 0; // Handle query failure
        }

        // Query to get the total charges
        $total_charges_sql = "SELECT SUM(total_fine) AS total_charges FROM penalty_sheet WHERE police_id = '$police_id'";
        $total_charges_result = mysqli_query($conn, $total_charges_sql);
        if ($total_charges_result) {
            $total_charges_row = mysqli_fetch_assoc($total_charges_result);
            $total_charges = $total_charges_row['total_charges'];
        } else {
            $total_charges = 0.00; // Handle query failure
        }

        // Query to get the earliest and latest issued dates
        $date_range_sql = "SELECT MIN(issued_date) AS min_date, MAX(issued_date) AS max_date FROM penalty_sheet WHERE police_id = '$police_id'";
        $date_range_result = mysqli_query($conn, $date_range_sql);
        if ($date_range_result) {
            $date_range_row = mysqli_fetch_assoc($date_range_result);
            $min_date = $date_range_row['min_date'];
            $max_date = $date_range_row['max_date'];

            // Calculate the number of days between min_date and max_date
            if ($min_date && $max_date) {
                $min_date_obj = new DateTime($min_date);
                $max_date_obj = new DateTime($max_date);
                $interval = $min_date_obj->diff($max_date_obj);
                $days = $interval->days + 1; // Include both start and end days
            } else {
                $days = 1; // Default to 1 day if no penalties found to avoid division by zero
            }

            // Calculate daily average
            $daily_average = $total_charges / $days;
        } else {
            $daily_average = 0.00; // Handle query failure
        }

    }
} else {
    echo "0 results";
}
?>

<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/profile.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php if (isset($_SESSION["policeId"])) {
    ?>

    <svg class="logout-svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
        <path
            d="M12 21c4.411 0 8-3.589 8-8 0-3.35-2.072-6.221-5-7.411v2.223A6 6 0 0 1 18 13c0 3.309-2.691 6-6 6s-6-2.691-6-6a5.999 5.999 0 0 1 3-5.188V5.589C6.072 6.779 4 9.65 4 13c0 4.411 3.589 8 8 8z" />
        <path d="M11 2h2v10h-2z" />
    </svg>

<?php } ?>

<div class="profile-page">
    <div class="content">
        <?php
        $path = "../src/profile_photo/" . $profile_picture;
        ?>

        <div class="content__cover">
            <div class="content__avatar" style="
        background: #8f6ed5 url('<?php echo $path; ?>') center center no-repeat; 
        background-size: cover;">
            </div>
            <div class="content__bull">
                <span></span>
                <span></span>
                <span></span>
                <span></span>
                <span></span>
            </div>

        </div>
        <form id="upload-form" enctype="multipart/form-data" method="post">
            <input type="file" id="upload-profile-picture" name="profile_picture" style="display: none;"
                accept="image/*">
            <input type="hidden" name="police_id" value="<?php echo $police_id; ?>">
        </form>
        <div class="content__actions">
            <?php if (isset($_SESSION["policeId"])) { ?>
                <a href="../../p/">
                    <span id="go-back">
                        <svg id="go-back-svg" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1" />
                        </svg><span>Go Back</span></a>
            <?php } ?>
            <?php if (isset($_SESSION["username"])) { ?>
                <a href="../../admin/policeman.php">
                    <span id="go-back">
                        <svg id="go-back-svg" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                            <path
                                d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1" />
                        </svg><span>Go Back</span></a>
            <?php } ?>
            <a></span>
                <span id="share"><svg id="share-svg" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5" />
                        <path fill-rule="evenodd"
                            d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z" />
                    </svg><span>Share</span></span></a>
        </div>
        <div class="content__title">
            <h1><?php echo $name ?></h1><span><?php echo $position ?></span>
        </div>
        <div class="content__description">
            <table id="content-table">
                <tr>
                    <td class="t-head">Police ID</td>
                    <td><?php echo $police_id ?></td>
                </tr>
                <tr>
                    <td class="t-head">Department</td>
                    <td><?php echo $department ?></td>
                </tr>
                <tr>
                    <td class="t-head">Date Of Birth</td>
                    <td><?php echo $dob ?></td>
                </tr>
                <tr>
                    <td class="t-head">Address</td>
                    <td><?php echo $address ?></td>
                </tr>
                <tr>
                    <td class="t-head">Mobile</td>
                    <td><?php echo $mobile ?></td>
                </tr>
            </table>
        </div>
        <ul class="content__list">
            <li><span><?php echo $penalty_count ?></span>Given Penalties</li>
            <li><span><?php echo "Rs." . $total_charges ?></span>Total Charges</li>
            <li><span><?php echo number_format($daily_average, 2) ?></span>Daily Average</li>
        </ul>

        <?php
        if (isset($_GET["police_id"])) {
            echo "
         <div class='content__button'><a class='button' href='#'>
        <div class='button__border'></div>
        <div class='button__bg'></div>
        <p class='button__text'>Edit Details</p></a></div>
        
        ";
        }
        ?>

    </div>

    <div class="bg">
        <div><span></span><span></span><span></span><span></span><span></span><span></span><span></span>
        </div>
    </div>
    <div class="theme-switcher-wrapper" id="theme-switcher-wrapper"><span>Themes color</span>
        <ul>
            <li><em class="is-active" data-theme="orange"></em></li>
            <li><em data-theme="green"></em></li>
            <li><em data-theme="purple"></em></li>
            <li><em data-theme="blue"></em></li>
        </ul>
    </div>
    <div class="theme-switcher-button hidden" id="theme-switcher-button">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
            <path fill="currentColor"
                d="M352 0H32C14.33 0 0 14.33 0 32v224h384V32c0-17.67-14.33-32-32-32zM0 320c0 35.35 28.66 64 64 64h64v64c0 35.35 28.66 64 64 64s64-28.65 64-64v-64h64c35.34 0 64-28.65 64-64v-32H0v32zm192 104c13.25 0 24 10.74 24 24 0 13.25-10.75 24-24 24s-24-10.75-24-24c0-13.26 10.75-24 24-24z">
            </path>
        </svg>
    </div>
</div>

<div id="content_update" class="popup">
    <div class="popup__content">
        <span class="popup__close">&times;</span>
        <h2>Edit Officer Details</h2>
        <form id="edit-officer-form" class="popup__form" method="post" action="../app/update_officer.php">
            <?php echo '<input type="hidden" id="hidden-police-id" name="police_id" value="' . $police_id . '">'; ?>

            <div class="form-group">
                <label for="edit-police-id">Police ID</label>
                <input type="text" id="edit-police-id" name="new_police_id" placeholder="Enter new Police ID">
            </div>
            <div class="form-group">
                <label for="edit-department">Department</label>
                <select style="padding: 10px; border-radius: 5px;" id="edit-department" name="department">
                    <option value="" disabled selected>Select a department</option>

                    <?php
                    // Query to fetch all department names from the police_division table
                    $sql = "SELECT name FROM police_division";
                    $result = mysqli_query($conn, $sql);

                    // Check if there are results
                    if (mysqli_num_rows($result) > 0) {
                        // Loop through each row to generate the options
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '<option value="' . htmlspecialchars($row['name']) . '">' . htmlspecialchars($row['name']) . '</option>';
                        }
                    } else {
                        echo '<option value="" disabled>No departments available</option>';
                    }

                    // Close the database connection
                    mysqli_close($conn);
                    ?>
                </select>
                <div id="error-message" style="color: red; display: none;"></div>
            </div>
            <div class="form-group">
                <label for="edit-dob">Date of Birth</label>
                <input type="date" id="edit-dob" name="dob">
            </div>
            <div class="form-group">
                <label for="edit-address">Address</label>
                <input type="text" id="edit-address" name="address" placeholder="Enter new Address">
            </div>
            <div class="form-group">
                <label for="edit-mobile">Mobile Number</label>
                <input type="text" id="edit-mobile" name="mobile" placeholder="Enter new Mobile Number">
            </div>
            <div class="form-group">
                <button type="submit" class="submit-btn">Save Changes</button>
            </div>
        </form>

        <script>
            document.getElementById('edit-officer-form').addEventListener('submit', function (event) {
                let valid = true;

                // Validate DOB - Officer should be at least 20 years old
                const dob = document.getElementById('edit-dob').value;
                if (dob) {
                    const dobDate = new Date(dob);
                    const today = new Date();
                    const age = today.getFullYear() - dobDate.getFullYear();
                    const monthDiff = today.getMonth() - dobDate.getMonth();
                    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < dobDate.getDate())) {
                        age--;
                    }

                    if (age < 20) {
                        valid = false;
                        alert("The officer must be at least 20 years old.");
                    }
                }

                // Validate mobile number - Should contain exactly 10 digits
                const mobile = document.getElementById('edit-mobile').value;
                const mobilePattern = /^\d{10}$/;
                if (mobile && !mobilePattern.test(mobile)) {
                    valid = false;
                    alert("The mobile number must contain exactly 10 digits.");
                }

                // Prevent form submission if any validation fails
                if (!valid) {
                    event.preventDefault();
                }
            });
        </script>

    </div>
</div>


<script src="../js/suggest_department.js"></script>
<script src="../js/update_popup.js"></script>
<?php
if (isset($_SESSION["policeNumber"])) {
    echo "<script>updatePhoto();</script>";
}
?>
<script>
    svg();

    logout();
    function svg() {
        document.getElementById('go-back').addEventListener('click', function () {
            window.history.back();
        });

        document.getElementById('share').addEventListener('click', function () {
            html2canvas(document.body).then(function (canvas) {
                var imageURL = canvas.toDataURL('image/png');

                var link = document.createElement('a');
                link.href = imageURL;

                link.download = 'profile.png';

                link.click();
            });
        });

    }

    function updatePhoto() {
        document.querySelector('.content__cover').addEventListener('click', function () {
            document.getElementById('upload-profile-picture').click();
        });

        document.getElementById('upload-profile-picture').addEventListener('change', function (event) {
            if (event.target.files && event.target.files[0]) {
                var formData = new FormData();
                formData.append('profile_picture', event.target.files[0]);

                // Perform an AJAX request to upload the image
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '../app/upload_profile_picture.php', true); // Adjusted path to match your directory structure

                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Update the avatar with the new image
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            document.querySelector('.content__avatar').style.backgroundImage = 'url(' + response.new_path + ')';
                        } else {
                            alert('Failed to upload image: ' + response.message);
                        }
                    } else {
                        alert('An error occurred while uploading the image.');
                    }
                };

                xhr.send(formData);
            }
        });
    }

    function logout() {
        document.querySelector('.logout-svg').addEventListener('click', function () {
            // Send a request to the logout script
            var xhr = new XMLHttpRequest();
            xhr.open('GET', '../../app/logout.php', true);
            xhr.send();

            // Redirect the user after logout
            xhr.onload = function () {
                if (xhr.status === 200) {
                    window.location.href = '../../login.php'; // Redirect to login page
                }
            };
        });

    }

</script>
