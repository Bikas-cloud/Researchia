<?php
require_once "../php/deleteJournal.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Delete Journal</title>
    <link rel="stylesheet" href="../css/deleteJournal.css">
</head>
<body>

<div class="container">
    <h2>Delete Journal</h2>

    <?php if (!empty($message)): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">

        <label>Select Journal</label>
        <select name="journal_id" required>
            <option value="">-- Select Journal --</option>
            <?php while ($row = $journals->fetch_assoc()): ?>
                <option value="<?= $row['journal_id'] ?>">
                    <?= htmlspecialchars($row['journal_name']) ?>
                </option>
            <?php endwhile; ?>
        </select>

        <label>Reason for Deletion</label>
        <textarea name="reason" placeholder="Explain why this journal is being removed..." required></textarea>

        <button type="submit" class="delete-btn">Delete Journal</button>
    </form>

    <a href="../php/adminDashboard.php" class="back-link">⬅ Back to Dashboard</a>
</div>

</body>
</html>