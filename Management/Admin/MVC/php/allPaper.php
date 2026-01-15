<?php
session_start();
require_once "../../../Auth/MVC/db/db.php";
require_once "../db/paperDb.php";

/* Admin protection */
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}

$journal_id = $_GET['journal_id'] ?? null;
$papers = getAllPapers($conn, $journal_id);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Papers</title>
    <link rel="stylesheet" href="../css/allPaper.css">
</head>
<body>

<div class="container">
    <h1>All Submitted Papers</h1>

    <div class="paper-table">

        <div class="table-head">
            <span>Title</span>
            <span>Journal</span>
            <span>Author</span>
            <span>Status</span>
            <span>Submitted</span>
            <span>Action</span>
            <span>Reviewer</span>
        </div>

        <?php while ($row = $papers->fetch_assoc()): ?>
        <div class="table-row">

            <span><?= htmlspecialchars($row['title']) ?></span>
            <span><?= htmlspecialchars($row['journal_name']) ?></span>
            <span><?= htmlspecialchars($row['author_name']) ?></span>

            <span class="status <?= strtolower($row['status']) ?>">
                <?= ucfirst($row['status']) ?>
            </span>

            <span><?= date("d M Y", strtotime($row['submission_date'])) ?></span>

            <!-- ACTION -->
            <span class="action-cell">
                <?php if (!empty($row['file_path'])): ?>
                    <a href="../../Author/MVC/uploads/papers/<?= urlencode(basename($row['file_path'])) ?>"
                       target="_blank"
                       class="btn view-btn">View Full Paper</a>
                <?php endif; ?>

                <?php if (!$row['reviewer_id']): ?>
                    <a href="assignReviewer.php?paper_id=<?= (int)$row['paper_id'] ?>"
                       class="btn assign-btn">Assign Reviewer</a>
                <?php endif; ?>
            </span>

            <!-- REVIEWER -->
            <span class="reviewer-cell">
                <?php if ($row['reviewer_id']): ?>
                    <strong><?= htmlspecialchars($row['reviewer_name']) ?></strong>
                    <a href="../../../Auth/MVC/php/Profile.php?id=<?= (int)$row['reviewer_id'] ?>"
                       class="btn reviewer-btn">Reviewer Profile</a>
                <?php else: ?>
                    <span style="color:#999;">Not Assigned</span>
                <?php endif; ?>
            </span>

        </div>
        <?php endwhile; ?>

    </div>

    <a href="adminDashboard.php" class="back">⬅ Back to Dashboard</a>
</div>

<script src="../js/allPaper.js"></script>
</body>
</html>
