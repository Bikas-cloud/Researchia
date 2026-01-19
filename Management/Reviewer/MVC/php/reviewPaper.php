<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Paper</title>
    <link rel="stylesheet" href="../css/reviewPaper.css">
</head>
<body>
<div class="review-container">
    <h2>Review Paper</h2>

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <div class="paper-info">
        <p><strong>Title:</strong> <?= htmlspecialchars($paper['title']) ?></p>
        <p><strong>Journal:</strong> <?= htmlspecialchars($paper['journal_name']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($paper['status']) ?></p>

        <?php if (!empty($paper['file_path'])): ?>
            <a class="download"
             href="../../../Author/MVC/uploads/papers/<?=htmlspecialchars($paper['file_path'])?>"
             target="_blank">
             Download Latest PDF
            </a>

        <?php else: ?>
            <p style="color:red;">No file uploaded.</p>
        <?php endif; ?>
    </div>

    <form method="post">

        <label>Score (1–10)</label>
        <input type="number" name="score" min="1" max="10" required>

        <label>Review Comment</label>
        <textarea name="comment" rows="6" required></textarea>
    </form>

    <a href="reviewerDashboard.php" class="back">⬅ Back to Dashboard</a>

</div>

</body>
</html>
