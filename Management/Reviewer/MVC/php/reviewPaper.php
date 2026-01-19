<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Review Paper</title>
    <link rel="stylesheet" href="../css/reviewPaper.css">
</head>
<body>
    <h2>Review Paper</h2>

    <?php if ($message): ?>
        <p class="message"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <div class="paper-info">
        <p><strong>Title:</strong> <?= htmlspecialchars($paper['title']) ?></p>
        <p><strong>Journal:</strong> <?= htmlspecialchars($paper['journal_name']) ?></p>
        <p><strong>Status:</strong> <?= htmlspecialchars($paper['status']) ?></p>
    </div>

    

</body>
</html>
