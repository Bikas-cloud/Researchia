<?php
session_start();
require_once "../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}
/* Basic admin protection */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/css/adminDashboard.css">
</head>
<body>

<div class="dashboard">
    <h1>Admin Dashboard</h1>
 
    <div class="cards">
        <a href="journals.php" class="card">Manage Journals</a>
        <a href="papers.php" class="card">View Papers</a>
        <a href="reviewers.php" class="card">Assign Reviewers</a>
        <a href="logout.php" class="card logout">Logout</a>
    </div>
    <div class="recentSubmit">
        <div class="journal">

        </div>
        <div class="journal">
            
        </div>
        <div class="journal">
            
        </div>
        <div class="journal">
            
        </div>
        <div class="journal">
            
        </div>
        <div class="journal">
            
        </div>
        <div class="journal">
            
        </div>
    </div>

</div>

<script src="../assets/js/adminDashboard.js"></script>
</body>
</html>
