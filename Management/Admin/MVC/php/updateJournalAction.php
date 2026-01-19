<?php
session_start();
require_once "../../../Auth/MVC/db/db.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    exit("Unauthorized");
}

$journal_id = (int)$_POST['journal_id'];
$name = trim($_POST['journal_name']);
$impact = trim($_POST['impact_factor']);

/* Handle image upload */
$imageName = null;

if (!empty($_FILES['image']['name'])) {
    $dir = "../images/journals/";
    if (!is_dir($dir)) mkdir($dir, 0755, true);

    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $imageName = "journal_" . time() . "." . $ext;
    move_uploaded_file($_FILES['image']['tmp_name'], $dir . $imageName);

    $stmt = $conn->prepare(
        "UPDATE journals SET journal_name=?, impact_factor=?, image=? WHERE journal_id=?"
    );
    $stmt->bind_param("sdsi", $name, $impact, $imageName, $journal_id);
} else {
    $stmt = $conn->prepare(
        "UPDATE journals SET journal_name=?, impact_factor=? WHERE journal_id=?"
    );
    $stmt->bind_param("sdi", $name, $impact, $journal_id);
}

if ($stmt->execute()) {
    echo "success";
} else {
    echo "Update failed";
}
