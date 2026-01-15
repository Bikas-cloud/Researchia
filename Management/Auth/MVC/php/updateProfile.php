<?php
session_start();
require_once "../db/db.php";

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status"=>"error","message"=>"Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user_id'];
$field = $_POST['field'] ?? '';
$value = $_POST['value'] ?? '';

$allowed = ['affiliation','bio','research_interests'];

if (!in_array($field, $allowed)) {
    echo json_encode(["status"=>"error","message"=>"Invalid field"]);
    exit;
}

$stmt = $conn->prepare("UPDATE Users SET $field=? WHERE user_id=?");
$stmt->bind_param("si", $value, $user_id);

if ($stmt->execute()) {
    echo json_encode(["status"=>"success"]);
} else {
    echo json_encode(["status"=>"error","message"=>"DB error"]);
}
