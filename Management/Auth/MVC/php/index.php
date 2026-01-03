<?php
require_once "config/db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: authorDashboard.php");
} else {
    header("Location: login.php");
}
exit();
?>