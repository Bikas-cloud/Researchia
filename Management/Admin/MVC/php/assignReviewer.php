<?php
session_start();
require_once "../../../Auth/MVC/db/db.php";

/* Admin protection */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}

$paper_id = (int)($_GET['paper_id'] ?? 0);
$message = "";

/* Fetch paper info */
$paperStmt = $conn->prepare("
    SELECT p.title, j.journal_name 
    FROM papers p
    JOIN journals j ON p.journal_id = j.journal_id
    WHERE p.paper_id = ?
");
$paperStmt->bind_param("i", $paper_id);
$paperStmt->execute();
$paper = $paperStmt->get_result()->fetch_assoc();

if (!$paper) {
    die("Invalid paper.");
}

/* Fetch reviewers (users with reviewer role) */
$reviewers = $conn->query("
    SELECT user_id, name, research_interests, email
    FROM users
    WHERE role = 'reviewer'
    ORDER BY name ASC
");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $reviewer_id = (int)$_POST['reviewer_id'];
    $deadline = $_POST['deadline'];

    if (!$reviewer_id || !$deadline) {
        $message = "All required fields must be filled.";
    } else {

        /* Prevent duplicate assignment */
        $check = $conn->prepare("
            SELECT 1 FROM reviewer_assignment
            WHERE paper_id = ? AND reviewer_id = ?
        ");
        $check->bind_param("ii", $paper_id, $reviewer_id);
        $check->execute();

        if ($check->get_result()->num_rows > 0) {
            $message = "This reviewer is already assigned to this paper.";
        } else {

            /* Assign reviewer */
            $stmt = $conn->prepare("
                INSERT INTO reviewer_assignment (paper_id, reviewer_id, deadline)
                VALUES (?, ?, ?)
            ");
            $stmt->bind_param("iis", $paper_id, $reviewer_id, $deadline);
            $stmt->execute();

            /* Update paper status */
            $update = $conn->prepare("
                UPDATE papers 
                SET status = 'under_review'
                WHERE paper_id = ?
            ");
            $update->bind_param("i", $paper_id);
            $update->execute();

            $message = "Reviewer assigned successfully!";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assign Reviewer</title>
    <link rel="stylesheet" href="../css/assignReviewer.css">
</head>
<body>

<div class="assign-container">
    <h1>Assign Reviewer</h1>

    <div class="paper-info">
        <p><strong>Paper:</strong> <?= htmlspecialchars($paper['title']) ?></p>
        <p><strong>Journal:</strong> <?= htmlspecialchars($paper['journal_name']) ?></p>
    </div>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post">

        <label>Select Reviewer</label>
        <select name="reviewer_id" required>
            <option value="">-- Choose Reviewer --</option>
            <?php while ($r = $reviewers->fetch_assoc()): ?>
                <option value="<?= (int)$r['user_id'] ?>">
                    <?= htmlspecialchars($r['name']) ?>
                    (<?= htmlspecialchars($r['research_interest'] ?? 'General') ?>)
                </option>
            <?php endwhile; ?>
        </select>

        <label>Deadline</label>
        <input type="date" name="deadline" required>

        <button type="submit">Assign Reviewer</button>
    </form>

    <a href="allPaper.php" class="back">⬅ Back to Papers</a>
</div>

</body>
</html>
