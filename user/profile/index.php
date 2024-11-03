<?php
include "../../app/connection.php";
include_once "../../notification.php";

if (isset($_GET["license_number"])) {
    $license_number = $_GET["license_number"];
} else if (isset($_SESSION['licenseNumber'])) {
    $license_number = $_SESSION["licenseNumber"];
} else {
    header("Location: ../../login.php");
    exit;
}
if (isset($_GET["update"]) && $_GET["update"] == "success") {
    callNotification("Successfully Updated!");
}
$sql = "SELECT *
FROM license
JOIN license_holder ON license.license_number = license_holder.license_number where license.license_number = '$license_number'";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Fetch all rows as an associative array
    while ($row = $result->fetch_assoc()) {
        // Assign each column value to a variable
        $dob = $row['dob'];
        $address = $row['address'];
        $name = $row['name'];
        $expiery_date = $row['expiry_date'];
        $profile_picture = $row['profile_picture'];
        $nic = $row['nic'];
        $mobile = $row['mobile'];
    }

    $sql = "
    SELECT 
        COUNT(*) AS total_penalties,
        SUM(CASE WHEN payment_status = 'paid' THEN 1 ELSE 0 END) AS paid_penalties,
        SUM(CASE WHEN payment_status = 'unpaid' THEN 1 ELSE 0 END) AS unpaid_penalties
    FROM penalty_sheet
    WHERE license_number = '$license_number'
";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Fetch the results
        $row = $result->fetch_assoc();

        // Extract the counts
        $total_penalties = $row['total_penalties'];
        $paid_penalties = $row['paid_penalties'];
        $unpaid_penalties = $row['unpaid_penalties'];
    }
} else {
    echo "0 results";
}
?>

<link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/profile.css">
<link rel="stylesheet" href="../css/popup.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<?php if (isset($_SESSION["licenseNumber"])) {

    echo '<svg onclick="logout()" class="logout-svg" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
    <path
        d="M12 21c4.411 0 8-3.589 8-8 0-3.35-2.072-6.221-5-7.411v2.223A6 6 0 0 1 18 13c0 3.309-2.691 6-6 6s-6-2.691-6-6a5.999 5.999 0 0 1 3-5.188V5.589C6.072 6.779 4 9.65 4 13c0 4.411 3.589 8 8 8z" />
    <path d="M11 2h2v10h-2z" />
</svg>';

}
?>

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
            <input type="hidden" name="police_id"
                value="<?php echo isset($_SESSION['licenseNumber']) ? $_SESSION['licenseNumber'] : ''; ?>">
        </form>

        <div class="content__actions">
            <?php if (isset($_SESSION["licenseNumber"])) {

                ?>
            <a href="../../user/">
                <span id="go-back">
                    <svg id="go-back-svg" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1" />
                    </svg><span>Go Back</span></a>
            <?php } ?>

            <?php if (isset($_SESSION["username"])) {

                ?>
            <a href="../../admin/users.php">
                <span id="go-back">
                    <svg id="go-back-svg" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-arrow-left-square-fill" viewBox="0 0 16 16">
                        <path
                            d="M16 14a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2zm-4.5-6.5H5.707l2.147-2.146a.5.5 0 1 0-.708-.708l-3 3a.5.5 0 0 0 0 .708l3 3a.5.5 0 0 0 .708-.708L5.707 8.5H11.5a.5.5 0 0 0 0-1" />
                    </svg><span>Go Back</span></a>
            <?php } ?>
            <a href=""></span>
                <span id="share"><svg id="share-svg" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                        fill="currentColor" class="bi bi-box-arrow-up-right" viewBox="0 0 16 16">
                        <path fill-rule="evenodd"
                            d="M8.636 3.5a.5.5 0 0 0-.5-.5H1.5A1.5 1.5 0 0 0 0 4.5v10A1.5 1.5 0 0 0 1.5 16h10a1.5 1.5 0 0 0 1.5-1.5V7.864a.5.5 0 0 0-1 0V14.5a.5.5 0 0 1-.5.5h-10a.5.5 0 0 1-.5-.5v-10a.5.5 0 0 1 .5-.5h6.636a.5.5 0 0 0 .5-.5" />
                        <path fill-rule="evenodd"
                            d="M16 .5a.5.5 0 0 0-.5-.5h-5a.5.5 0 0 0 0 1h3.793L6.146 9.146a.5.5 0 1 0 .708.708L15 1.707V5.5a.5.5 0 0 0 1 0z" />
                    </svg><span>Share</span></span></a>
        </div>
        <div class="content__title">
            <h1><?php echo $name ?></h1><span><?php echo $nic ?></span>
        </div>
        <div class="content__description">
            <table id="content-table">
                <tr>
                    <td class="t-head">License Number</td>
                    <td><?php echo $license_number ?></td>
                </tr>
                <tr>
                    <td class="t-head">Expiery Date</td>
                    <td><?php echo $expiery_date ?></td>
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
            <li><span><?php echo $total_penalties ?></span>Number of Fines</li>
            <li><span><?php echo $paid_penalties ?></span>Paid Penalties</li>
            <li><span><?php echo $unpaid_penalties ?></span>Unpaid Penalties</li>
        </ul>

        <div id="profile-update-container">
            <div id="profile-update-content">
                <div id="profile-update-header">
                    Update Profile
                </div>
                <form class="update-profile" id="update-profile-form" method="post" action="../app/update_profile.php">
                    <div class="form-group">
                        <label for="address">Address:</label>
                        <input type="text" id="address" name="address">
                    </div>
                    <div class="form-group">
                        <label for="mobile">Mobile Number:</label>
                        <input type="tel" id="mobile" name="mobile">
                        <small id="mobile-error" style="color: red; display: none;">Mobile number must be exactly 10
                            digits and cannot include letters or special characters.</small>
                    </div>
                    <div id="profile-update-footer">
                        <button type="button" id="close-popup">Close</button>
                        <button type="submit">Save</button>
                    </div>
                </form>
            </div>
        </div>


        <div class="btn-cont">
            <?php
            if (isset($_SESSION["licenseNumber"])) {
                echo "<div onclick='openUpdateProfile();' id='update-profile-btn' class='content__button'>
                        <div class='button'>
                            <div class='button__border'></div>
                            <div class='button__bg'></div>
                            <p class='button__text'>Edit Details</p>
                        </div>
                    </div>";
            }

            ?>


            <div class='content__button' id="open-popup"><a class='button' href='#'>
                    <div class='button__border'></div>
                    <div class='button__bg'></div>
                    <p class='button__text'>Show Penalties</p>
                </a></div>
        </div>




        <?php
        $sql_penalty = "
        SELECT 
        ps.pid, 
        pm.name AS policeman_name, 
        ps.issued_date, 
        ps.deadline, 
        ps.payment_status, 
        ps.total_fine 
    FROM penalty_sheet ps
    JOIN policeman pm ON ps.police_id = pm.police_id
    WHERE ps.license_number = '$license_number'
    ";

        $result = $conn->query($sql_penalty);

        // Check if any penalties exist
        if ($result->num_rows > 0) {
            $penalties = [];
            while ($row = $result->fetch_assoc()) {
                $penalties[] = $row;
            }
        } else {
            echo "<p>Error executing query: " . $conn->error . "</p>";
            $penalties = [];
        }

        ?>

        <div id="popupContainer" class="popup-container">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <h2>Penalty Details</h2>
                <?php if (!empty($penalties)): ?>
                <table class="penalty-table">
                    <thead>
                        <tr>
                            <th>Penalty ID</th>
                            <th>Policeman Name</th>
                            <th>Issued Date</th>
                            <th>Deadline</th>
                            <th>Payment Status</th>
                            <th>Total Fine</th>
                            <!-- <th>Show Fines</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($penalties as $penalty): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($penalty['pid']); ?></td>
                            <td><?php echo htmlspecialchars($penalty['policeman_name']); ?></td>
                            <td><?php echo htmlspecialchars($penalty['issued_date']); ?></td>
                            <td><?php echo htmlspecialchars($penalty['deadline']); ?></td>
                            <td><?php echo htmlspecialchars($penalty['payment_status']); ?></td>
                            <td><?php echo "Rs." . htmlspecialchars($penalty['total_fine']); ?></td>
                            <td><?php echo "<button id='" . $penalty['pid'] . "' class='show-fines-btn'> Show Fines </button>" ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php else: ?>
                <p>No penalties found for this license number.</p>
                <?php endif; ?>
                <button onclick="closePenaltyDetails()" id="close-penalty-details" class="action-btn">Close</button>
                <script>
                function closePenaltyDetails() {
                    document.getElementById("popupContainer").style.display = "none";
                }
                </script>
            </div>
        </div>

        <div id="finesPopup" class="fines-popup">
            <div class="popup-content">
                <span class="close-btn">&times;</span>
                <h2>Fines Details</h2>
                <table class="fines-table">
                    <thead>
                        <tr>
                            <th>Fine Name</th>
                            <th>Fine Price</th>
                        </tr>
                    </thead>
                    <tbody id="finesTableBody">
                        <!-- Fines data will be inserted here by JavaScript -->
                    </tbody>
                </table>
                <button class="action-btn" onclick="closeFinesPopup()">Close</button>
                <script>
                function closeFinesPopup() {
                    document.getElementById("finesPopup").style.display = "none";
                }
                </script>
            </div>
        </div>


        <?php
        if (isset($_GET["license_number"])) {
            echo "
         
        
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
        <form id="edit-officer-form" class="popup__form" method="post" action="../app/update_profile.php">
            <?php echo '<input type="hidden" id="hidden-police-id" name="police_id" value="' . $police_id . '">'; ?>

            <div class="form-group">
                <label for="edit-police-id">Police ID</label>
                <input type="text" id="edit-police-id" name="new_police_id" placeholder="Enter new Police ID">
            </div>
            <div class="form-group">
                <label for="edit-department">Department</label>
                <input type="text" id="edit-department" name="department" placeholder="Enter new Department">
                <ul id="suggestions-list"
                    style="display: none; border: 1px solid #ccc; list-style-type: none; padding: 0; margin: 0; max-height: 150px; overflow-y: auto;">
                </ul>
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
    </div>
</div>




<script src="../js/penalty_popup.js"></script>
<script src="../js/update_popup.js"></script>

<script>
svg();
updatePhoto();



function svg() {
    document.getElementById('go-back').addEventListener('click', function() {
        window.history.back();
    });

    document.getElementById('share').addEventListener('click', function() {
        html2canvas(document.body).then(function(canvas) {
            var imageURL = canvas.toDataURL('image/png');

            var link = document.createElement('a');
            link.href = imageURL;

            link.download = 'profile.png';

            link.click();
        });
    });

}

function updatePhoto() {
    document.querySelector('.content__cover').addEventListener('click', function() {
        document.getElementById('upload-profile-picture').click();
    });

    document.getElementById('upload-profile-picture').addEventListener('change', function(event) {
        if (event.target.files && event.target.files[0]) {
            var formData = new FormData();
            formData.append('profile_picture', event.target.files[0]);

            // Perform an AJAX request to upload the image
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '../app/upload_profile_picture.php',
                true); // Adjusted path to match your directory structure

            xhr.onload = function() {
                if (xhr.status === 200) {
                    // Update the avatar with the new image
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        document.querySelector('.content__avatar').style.backgroundImage = 'url(' + response
                            .new_path + ')';
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

    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../../app/logout.php', true);
    xhr.send();

    xhr.onload = function() {
        if (xhr.status === 200) {
            window.location.href = '../../login.php';
        }
    };



}

function openUpdateProfile() {
    const updateProfileBtn = document.getElementById('update-profile-btn');
    const profileUpdateContainer = document.getElementById('profile-update-container');
    const closePopupBtn = document.getElementById('close-popup');

    // Show the popup

    profileUpdateContainer.style.display = 'flex';
    var addressValue = "<?php echo htmlspecialchars($address, ENT_QUOTES, 'UTF-8'); ?>";
    document.getElementById('address').value = addressValue;
    var mobileValue = "<?php echo htmlspecialchars($mobile, ENT_QUOTES, 'UTF-8'); ?>";
    document.getElementById('mobile').value = mobileValue;


    // Close the popup
    closePopupBtn.addEventListener('click', () => {
        profileUpdateContainer.style.display = 'none';
    });

    // Optionally, handle form submission
    document.getElementById('update-profile-form').addEventListener('submit', function(event) {
        var mobileInput = document.getElementById('mobile').value;
        var mobileError = document.getElementById('mobile-error');
        var mobilePattern = /^[0-9]{10}$/;

        if (!mobilePattern.test(mobileInput)) {
            mobileError.style.display = 'block';
            event.preventDefault(); // Prevent form submission
        } else {
            mobileError.style.display = 'none';
        }
    });
}
</script>