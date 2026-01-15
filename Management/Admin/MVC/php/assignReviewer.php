
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

  
    <a href="allPaper.php" class="back">⬅ Back to Papers</a>
</div>

</body>
</html>
