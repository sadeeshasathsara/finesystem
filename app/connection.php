<?php
session_start();

$host = "localhost";
$username = "root";
$password = "";
$dbname = "finesystem";

// Define base URL
define('baseUrl', 'http://localhost/finesystem');

$conn = mysqli_connect($host, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}