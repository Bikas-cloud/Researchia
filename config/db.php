<?php
$hostname = "localhost";
$username = "root";
$password = "";
$dbname   = "researchdb";

$conn = new mysqli($hostname, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

