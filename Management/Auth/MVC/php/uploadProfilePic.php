<?php
session_start();
require_once "../db/db.php";

if (!isset($_SESSION['user_id'])) exit;

$dir = "../uploads/profile/";
if (!is_dir($dir)) mkdir($dir,0755,true);

$file = $_FILES['profile_pic'];
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($ext, ['jpg','jpeg','png'])) exit("error");

$name = "profile_" . time() . "." . $ext;
move_uploaded_file($file['tmp_name'], $dir.$name);

$stmt = $conn->prepare("
    UPDATE Users SET profile_pic=? WHERE user_id=?
");
$stmt->bind_param("si", $name, $_SESSION['user_id']);
$stmt->execute();

echo $name;
