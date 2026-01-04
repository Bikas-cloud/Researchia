<?php
session_start();
require_once "../../../Auth/MVC/db/db.php";

/* Admin protection */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}

$message = "";

$journals = $conn->query("SELECT journal_id, journal_name FROM journals");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $journal_id = (int)($_POST['journal_id'] ?? 0);
    $reason = trim($_POST['reason'] ?? '');

    if ($journal_id === 0 || empty($reason)) {
        $message = "Please select a journal and provide a reason.";
    } else {

        $stmt = $conn->prepare("DELETE FROM journals WHERE journal_id = ?");
        $stmt->bind_param("i", $journal_id);

        if ($stmt->execute()) {
            $message = "Journal deleted successfully.";
        } else {
            $message = "Failed to delete journal.";
        }
        $stmt->close();
    }
}
?>