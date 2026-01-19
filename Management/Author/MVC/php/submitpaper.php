
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reviewer Feedback</title>
    <link rel="stylesheet" href="../css/submitpaper.css">
</head>
<body>
<div class="feedback-container">
    <h2>Reviewer Feedback</h2>

    <?php if ($result->num_rows === 0): ?>
        <p>No papers submitted yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Journal</th>
                    <th>Status</th>
                    <th>Latest PDF</th>
                    <th>Reviewer</th>
                    <th>Score</th>
                    <th>Comment</th>
                    <th>Review Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['title']) ?></td>
                    <td><?= htmlspecialchars($row['journal_name']) ?></td>
                    <td><?= htmlspecialchars($row['status']) ?></td>
                    <td>
                        <?php if (!empty($row['file_path'])): ?>
                        <a href="../uploads/papers/<?= htmlspecialchars($row['file_path']) ?>" target="_blank">Download</a>
                        <?php else: ?>
                        N/A
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['reviewer_name'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['score'] ?? '-') ?></td>
                    <td><?= htmlspecialchars($row['comment'] ?? '-') ?></td>
                    <td>
                        <?= !empty($row['review_date']) ? date("d M Y", strtotime($row['review_date'])) : '-' ?>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="authorDashboard.php" class="back">⬅ Back to Dashboard</a>
</div>
<script src="../js/submitpaper.js"></script>
</body>
</html>
