<?php
// Include the database connection file
include "../../app/connection.php";

// Retrieve the license number from the session
$license_number = $_SESSION["licenseNumber"];

// Initialize variables to hold the form data
$address = isset($_POST['address']) ? trim($_POST['address']) : null;
$mobile = isset($_POST['mobile']) ? trim($_POST['mobile']) : null;


// Prepare the SQL update queries based on which fields are set
$updateQueries = [];

if ($mobile !== null) {
    $updateQueries[] = "UPDATE license_holder SET mobile = '" . $conn->real_escape_string($mobile) . "' WHERE license_number = '" . $conn->real_escape_string($license_number) . "'";
}

if ($address !== null) {
    $updateQueries[] = "UPDATE license SET address = '" . $conn->real_escape_string($address) . "' WHERE license_number = '" . $conn->real_escape_string($license_number) . "'";
}



// Execute the update queries
foreach ($updateQueries as $query) {
    $conn->query($query);
}

$e = mysqli_error($conn);

if (!$e) {
    // Optionally, you can echo success for each query if needed
    header("Location: ../profile/index.php?update=success");
    exit;
} else {
    echo "Error updating record: " . $conn->error;
}

// Close the database connection
$conn->close();

// Redirect back to the profile page or wherever you want after update

