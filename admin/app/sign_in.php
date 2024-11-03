<?php
include '../../app/connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve posted data
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Validate input
    if (empty($username) || empty($password)) {
        header('Location: http://localhost/finesystem/admin/login/');
        exit;
    }

    // Escape input to prevent SQL injection
    $username = $conn->real_escape_string($username);
    $password = $conn->real_escape_string($password);

    // Query to find the user
    $sql = "SELECT name, password FROM admin WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        // Fetch user data
        $admin = $result->fetch_assoc();
        $storedPassword = $admin['password'];

        // Verify the password
        if ($password === $storedPassword) {
            // Store user session information
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $admin['name'];

            // Redirect to admin dashboard
            header('Location: http://localhost/finesystem/admin');
            exit;
        }
    } else {
        header('Location: http://localhost/finesystem/admin/login/index.php?e=1');
        exit;
    }

    header('Location: http://localhost/finesystem/admin/login/index.php?e=1');
    exit;

    // Redirect to login page on unsuccessful login


} else {
    $_SESSION["adminError"] = "DB connection error";
    header('Location: http://localhost/finesystem/admin/login/');
    exit;
}
