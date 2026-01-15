<?php
session_start();
require_once "../../../Auth/MVC/db/db.php"; 
/* Reviewer protection */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'reviewer') {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}


?>
<html>
    <head>
        <title>
            Author Dashboard
        </title>
    </head>
    <body>
        <h1>Welcome to Author Dashboard</h1>

        
         <a href="../../../Auth/MVC/php/Profile.php">View Profile</a>
    </body>
</html>