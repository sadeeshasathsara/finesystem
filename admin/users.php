<?php
include "../app/connection.php";
if ($_SESSION["username"] == null) {
    header("Location: http://localhost/finesystem/admin/login");
    exit;
}
?>
<link rel="stylesheet" href="css/stylesheet.css">
<link rel="stylesheet" href="css/police.css">
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
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <path
                                    d="M6.855 14.365l-1.817 6.36a1.001 1.001 0 0 0 1.517 1.106L12 18.202l5.445 3.63a1 1 0 0 0 1.517-1.106l-1.817-6.36 4.48-3.584a1.001 1.001 0 0 0-.461-1.767l-5.497-.916-2.772-5.545c-.34-.678-1.449-.678-1.789 0L8.333 8.098l-5.497.916a1 1 0 0 0-.461 1.767l4.48 3.584zm2.309-4.379c.315-.053.587-.253.73-.539L12 5.236l2.105 4.211c.144.286.415.486.73.539l3.79.632-3.251 2.601a1.003 1.003 0 0 0-.337 1.056l1.253 4.385-3.736-2.491a1 1 0 0 0-1.109-.001l-3.736 2.491 1.253-4.385a1.002 1.002 0 0 0-.337-1.056l-3.251-2.601 3.79-.631z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="reports.php" class="selected">
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
            <h1>Users</h1>


        </header>

        <div class="content">
            <div class="m-res">
                <section class="info-boxes">
                    <div id="add-officer-container" class="hidden">
                        <div class="login-root">
                            <div class="box-root flex-flex flex-direction--column"
                                style="min-height: 100vh; flex-grow: 1;">

                                <div class="box-root padding-top--24 flex-flex flex-direction--column"
                                    style="flex-grow: 1; z-index: 9;">
                                    <div
                                        class="box-root padding-top--48 padding-bottom--24 flex-flex flex-justifyContent--center">
                                        <h1><a href="http://blog.stackfindover.com/" rel="dofollow">ADD OFFICERS</a>
                                        </h1>
                                    </div>
                                    <div class="formbg-outer">
                                        <div class="formbg">
                                            <div class="formbg-inner padding-horizontal--48">

                                                <form id="stripe-login">
                                                    <div class="field padding-bottom--24">
                                                        <label for="police_id">Police ID</label>
                                                        <input type="text" id="police_id" name="police_id">
                                                        <span style="color: red;" class="error"
                                                            id="police_id_error"></span>
                                                    </div>
                                                    <div class="field padding-bottom--24">
                                                        <label for="name">Name</label>
                                                        <input type="text" id="name" name="name">
                                                        <span style="color: red;" class="error" id="name_error"></span>
                                                    </div>
                                                    <div class="field padding-bottom--24">
                                                        <label for="posision">Position</label>
                                                        <select id="posision" name="posision">
                                                            <option value="">Select Position</option>
                                                            <option value="Sergeant">Sergeant</option>
                                                            <option value="Sub-Inspector of Police (SI)">Sub-Inspector
                                                                of
                                                                Police (SI)</option>
                                                            <option value="Inspector of Police (IP)">Inspector of Police
                                                                (IP)</option>
                                                            <option value="Chief Inspector (CI)">Chief Inspector (CI)
                                                            </option>
                                                        </select>
                                                        <span style="color: red;" class="error"
                                                            id="posision_error"></span>
                                                    </div>
                                                    <div class="field padding-bottom--24">
                                                        <label for="department">Department</label>
                                                        <input type="text" id="department" name="department">
                                                        <span style="color: red;" class="error"
                                                            id="department_error"></span>
                                                    </div>
                                                    <div class="field padding-bottom--24">
                                                        <label for="dob">Date Of Birth</label>
                                                        <input type="date" id="dob" name="dob">
                                                        <span style="color: red;" class="error" id="dob_error"></span>
                                                    </div>
                                                    <div class="field padding-bottom--24">
                                                        <label for="mobile">Mobile Number</label>
                                                        <input type="text" id="mobile" name="mobile">
                                                        <span style="color: red;" class="error"
                                                            id="mobile_error"></span>
                                                    </div>
                                                    <div class="field padding-bottom--24">
                                                        <label for="address">Address</label>
                                                        <input type="text" id="address" name="address">
                                                        <span style="color: red;" class="error"
                                                            id="address_error"></span>
                                                    </div>
                                                    <div class="field padding-bottom--24">
                                                        <label for="pwd">Password</label>
                                                        <input type="password" id="pwd" name="pwd">
                                                        <span style="color: red;" class="error" id="pwd_error"></span>
                                                    </div>
                                                    <div class="field padding-bottom--24">
                                                        <label for="cpwd">Confirm Password</label>
                                                        <input type="password" id="cpwd" name="cpwd">
                                                        <span style="color: red;" class="error" id="cpwd_error"></span>
                                                    </div>
                                                    <div class="field padding-bottom--24">
                                                        <label for="profile-picture">Profile Picture</label>
                                                        <input type="file" id="profile-picture" accept="image/*"
                                                            name="profile_picture">
                                                        <span style="color: red;" class="error"
                                                            id="profile-picture_error"></span>
                                                    </div>
                                                    <div class="field padding-bottom--24">
                                                        <input type="submit" id="submit" name="submit" value="Continue">
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <br><br>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php
                    // Fetch all policemen
                    $query = "SELECT l.name, lh.profile_picture, l.license_number, l.expiry_date
                        FROM license l
                        JOIN license_holder lh ON l.license_number = lh.license_number
                        ";
                    $result = mysqli_query($conn, $query);

                    if ($result && mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $police_id = htmlspecialchars($row['license_number']);
                            $name = htmlspecialchars($row['name']);
                            $position = htmlspecialchars($row['expiry_date']);
                            $profile_picture = htmlspecialchars($row['profile_picture']);

                            // Default image or initials if no profile picture is found
                            if ($profile_picture) {
                                $profile_picture_url = '../user/src/profile_photo/' . $profile_picture;
                                $avatar_content = '<img src="' . $profile_picture_url . '" alt="' . $name . '">';
                            } else {
                                // Get initials (first letter of first and last name)
                                $name_parts = explode(' ', $name);
                                $initials = '';
                                if (count($name_parts) >= 2) {
                                    $initials = strtoupper($name_parts[0][0] . $name_parts[1][0]);
                                } else {
                                    $initials = strtoupper($name_parts[0][0]); // Only one name provided
                                }
                                $avatar_content = '<span class="no-name">' . $initials . '</span>';
                            }

                            echo '<div id="' . $police_id . '" class="person-box">';
                            echo '    <div class="box-avatar">';
                            echo $avatar_content;
                            echo '    </div>';

                            echo '    <div class="box-bio">';
                            echo '        <h2 class="bio-name">' . $name . '<span class="police-id-display">(' . $police_id . ')</span></h2>';
                            echo '        <p class="bio-position">' . $position . '</p>';
                            echo '    </div>';

                            echo '    <div class="box-actions">';
                            echo '        <button>';
                            echo '            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">';
                            echo '                <path d="M6.855 14.365l-1.817 6.36a1.001 1.001 0 0 0 1.517 1.106L12 18.202l5.445 3.63a1 1 0 0 0 1.517-1.106l-1.817-6.36 4.48-3.584a1.001 1.001 0 0 0-.461-1.767l-5.497-.916-2.772-5.545c-.34-.678-1.449-.678-1.789 0L8.333 8.098l-5.497.916a1 1 0 0 0-.461 1.767l4.48 3.584zm2.309-4.379c.315-.053.587-.253.73-.539L12 5.236l2.105 4.211c.144.286.415.486.73.539l3.79.632-3.251 2.601a1.003 1.003 0 0 0-.337 1.056l1.253 4.385-3.736-2.491a1 1 0 0 0-1.109-.001l-3.736 2.491 1.253-4.385a1.002 1.002 0 0 0-.337-1.056l-3.251-2.601 3.79-.631z" />';
                            echo '            </svg>';
                            echo '        </button>';

                            echo '        <button>';
                            echo '            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">';
                            echo '                <path d="M18 18H6V6h7V4H5a1 1 0 0 0-1 1v14a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-8h-2v7z" />';
                            echo '                <path d="M17.465 5.121l-6.172 6.172 1.414 1.414 6.172-6.172 2.12 2.121L21 3h-5.657z" />';
                            echo '            </svg>';
                            echo '        </button>';

                            echo '        <button>';
                            echo '            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">';
                            echo '                <path d="M12 3C6.486 3 2 6.364 2 10.5c0 2.742 1.982 5.354 5 6.678V21a.999.999 0 0 0 1.707.707l3.714-3.714C17.74 17.827 22 14.529 22 10.5 22 6.364 17.514 3 12 3zm0 13a.996.996 0 0 0-.707.293L9 18.586V16.5a1 1 0 0 0-.663-.941C5.743 14.629 4 12.596 4 10.5 4 7.468 7.589 5 12 5s8 2.468 8 5.5-3.589 5.5-8 5.5z" />';
                            echo '            </svg>';
                            echo '        </button>';

                            echo '        <button>';
                            echo '            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">';
                            echo '                <path d="M19 8L17 8 17 11 14 11 14 13 17 13 17 16 19 16 19 13 22 13 22 11 19 11zM3 20h10c.553 0 1-.447 1-1v-.5c0-2.54-1.212-4.651-3.077-5.729C11.593 12.063 12 11.1 12 10c0-2.28-1.72-4-4-4s-4 1.72-4 4c0 1.1.407 2.063 1.077 2.771C3.212 13.849 2 15.96 2 18.5V19C2 19.553 2.448 20 3 20zM6 10c0-1.178.822-2 2-2s2 .822 2 2-.822 2-2 2S6 11.178 6 10zM8 14c2.43 0 3.788 1.938 3.977 4H4.023C4.212 15.938 5.57 14 8 14z" />';
                            echo '            </svg>';
                            echo '        </button>';

                            echo '    </div>';
                            echo '</div>';
                        }
                    } else {
                        echo '<p>No policemen found.</p>';
                    }

                    mysqli_close($conn);
                    ?>

                </section>
            </div>
        </div>
    </main>
</div>

<script>
    setupPersonBoxRedirect();
    logout();
    let click = 1;

    document.querySelector("#add-officer-popup").addEventListener("click", () => {
        if (click == 1) {
            document.querySelector("#add-officer-container").classList.remove("hidden");
            click = 0;
        } else if (click == 0) {
            document.querySelector("#add-officer-container").classList.add("hidden");
            click = 1;
        }
    });

    function validateForm(event) {
        // Prevent form submission
        event.preventDefault();

        // Clear previous errors
        const errorElements = document.querySelectorAll('.error');
        errorElements.forEach(el => el.textContent = '');

        let isValid = true;

        // Validate Police ID
        const policeId = document.getElementById('police_id').value;
        if (!policeId.startsWith('P')) {
            document.getElementById('police_id_error').textContent = 'Police ID must start with "p".';
            isValid = false;
        }

        // Validate Date of Birth
        const dob = new Date(document.getElementById('dob').value);
        const age = new Date().getFullYear() - dob.getFullYear();
        if (age < 20) {
            document.getElementById('dob_error').textContent = 'You must be at least 20 years old.';
            isValid = false;
        }

        // Validate Password
        const pwd = document.getElementById('pwd').value;
        const cpwd = document.getElementById('cpwd').value;
        const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
        if (!passwordPattern.test(pwd)) {
            document.getElementById('pwd_error').textContent = 'Password must be at least 8 characters long and include an uppercase letter, a lowercase letter, a number, and a special character.';
            isValid = false;
        }
        if (pwd !== cpwd) {
            document.getElementById('cpwd_error').textContent = 'Passwords do not match.';
            isValid = false;
        }

        // If form is valid, submit it
        if (isValid) {
            document.getElementById('stripe-login').method = "post";
            document.getElementById('stripe-login').action = "app/add_officer.php";
            document.getElementById('stripe-login').enctype = "multipart/form-data";
            document.getElementById('stripe-login').submit();
        }
    }

    function setupPersonBoxRedirect() {
        var personBoxes = document.querySelectorAll('.person-box');

        personBoxes.forEach(function (box) {
            box.addEventListener('click', function () {
                var policeId = box.id;

                // Construct the URL with the police_id as a GET parameter
                var redirectUrl = 'http://localhost/finesystem/user/profile/index.php?license_number=' + encodeURIComponent(policeId);
                //console.log(redirectUrl)

                // Redirect to the constructed URL
                window.location.href = redirectUrl;
            });
        });
    }

    function logout() {
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
    }




</script>