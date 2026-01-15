<?php
session_start();
require_once "../../../Auth/MVC/db/db.php";

/* Admin protection */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name       = trim($_POST['name']);
    $email      = trim($_POST['email']);
    $password   = trim($_POST['password']);
    $expertise  = trim($_POST['research_interest']);

    if ($name && $email && $password && $expertise) {

        /* check existing email */
        $check = $conn->prepare("SELECT user_id FROM Users WHERE email=?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "Email already exists!";
        } else {

            $stmt = $conn->prepare("
                INSERT INTO Users 
                (name, email, password, role, research_interests)
                VALUES (?, ?, ?, 'reviewer', ?)
            ");
            $stmt->bind_param("ssss", $name, $email, $password, $expertise);
            $stmt->execute();

            $message = "Reviewer added successfully!";
        }
    } else {
        $message = "All fields are required!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Reviewer</title>
<link rel="stylesheet" href="../css/addReviewer.css">
</head>
<body>

<div class="container">
    <h1>Add Reviewer</h1>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">

        <label>Reviewer Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Manual Password (given by Admin)</label>
        <input type="text" name="password" required>

        <label>Research Expertise</label>
        <input type="text" name="research_interest"
               placeholder="AI, ML, Networks" required>

        <button type="submit">Add Reviewer</button>
    </form>

    <a href="adminDashboard.php" class="back">⬅ Back</a>
</div>

</body>
</html>
