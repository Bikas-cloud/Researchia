<?php
require_once "../db/db.php";

if (isset($_SESSION['user_id'])) {
    header("Location: login.php");
} else {
    header("Location: ../html/Dashboard.php");
}
exit();
?>