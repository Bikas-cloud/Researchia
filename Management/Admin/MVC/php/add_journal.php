<?php
session_start();
require_once "../../../Auth/MVC/db/db.php";

/* Admin protection */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $journal_name = trim($_POST['journal_name']);
    $impact_factor = trim($_POST['impact_factor']);

    if (empty($journal_name) || empty($impact_factor)) {
        $message = "All fields are required.";
    } elseif (!is_numeric($impact_factor)) {
        $message = "Impact factor must be numeric.";
    } else {

        /* Image upload */
        $imageName = $_FILES['image']['name'];
        $tmpName = $_FILES['image']['tmp_name'];

        $uploadDir = "../images/journals/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $newImageName = time() . "_" . basename($imageName);
        $imagePath = $uploadDir . $newImageName;

        if (move_uploaded_file($tmpName, $imagePath)) {

            $stmt = $conn->prepare(
                "INSERT INTO journals (journal_name, impact_factor, image, created_at)
                 VALUES (?, ?, ?, NOW())"
            );
            $stmt->bind_param("sds", $journal_name, $impact_factor, $newImageName);

            if ($stmt->execute()) {
                $message = "Journal added successfully!";
            } else {
                $message = "Database error!";
            }
        } else {
            $message = "Image upload failed!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Journal</title>
    <link rel="stylesheet" href="../css/adminDashboard.css">
</head>
<body>

<div class="dashboard">
    <h2>Add New Journal</h2>

    <?php if ($message): ?>
        <p style="color:red;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <label>Journal Name</label><br>
        <input type="text" name="journal_name" required><br><br>

        <label>Impact Factor</label><br>
        <input type="text" name="impact_factor" required><br><br>

        <label>Journal Image</label><br>
        <input type="file" name="image" accept="image/*" required><br><br>

        <button type="submit">Add Journal</button>
    </form>

    <br>
    <a href="adminDashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
