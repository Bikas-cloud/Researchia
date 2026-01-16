




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Papers</title>
    <link rel="stylesheet" href="../css/myPapers.css">
</head>
<body>

<div class="paper-container">
    <h2>My Submitted Papers</h2>

    <?php if ($result->num_rows === 0): ?>
        <p>No papers submitted yet.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Journal</th>
                    <th>Submitted On</th>
                    <th>Status</th>
                    <th>File</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['title']) ?></td>
                        <td><?= htmlspecialchars($row['journal_name']) ?></td>
                        <td><?= date("d M Y", strtotime($row['submission_date'])) ?></td>
                        <td><?= htmlspecialchars($row['status']) ?></td>
                        <td>
                            <a href="../uploads/papers/<?= htmlspecialchars($row['file_path']) ?>" target="_blank">
                                Download
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="authorDashboard.php" class="back">⬅ Back to Dashboard</a>
    
</div>

</body>
</html>
