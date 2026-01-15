<?php
session_start();
require_once "../../../Auth/MVC/db/db.php";

// Auth check
if (!isset($_SESSION['user_id'])) {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $title = trim($_POST['title']);
    $abstract = trim($_POST['abstract']);
    $journal_id = intval($_POST['journal_id']);

}

// Fetch journals
$journals = $conn->query("SELECT journal_id, journal_name FROM journals");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Paper</title>
    <link rel="stylesheet" href="../css/addPaper.css">
</head>
<body>

<div class="paper-container">
    <h2>Submit Research Paper</h2>

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" id="paperForm">

        <label>Paper Title</label>
        <input type="text" name="title" required>

        <label>Abstract</label>
        <textarea name="abstract" rows="6" required></textarea>

        <label>Select Journal</label>
        <select name="journal_id" required>
            <option value="">-- Choose Journal --</option>
            <?php while ($j = $journals->fetch_assoc()): ?>
                <option value="<?= $j['journal_id'] ?>">
                    <?= htmlspecialchars($j['journal_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Upload Paper (PDF)</label>
        <input type="file" name="paper_file" accept=".pdf" required>

        <button type="submit">Submit Paper</button>
    </form>

    <a href="authorDashboard.php" class="back">⬅ Back to Dashboard</a>
</div>

<script src="../js/addPaper.js"></script>
</body>
</html>
