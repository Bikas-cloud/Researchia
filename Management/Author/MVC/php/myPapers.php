

// Fetch user's papers with latest version
$stmt = $conn->prepare("
    SELECT 
        p.paper_id,
        p.title,
        p.submission_date,
        p.status,
        j.journal_name,
        pv.file_path
    FROM papers p
    JOIN journals j ON p.journal_id = j.journal_id
    JOIN paper_versions pv ON pv.paper_id = p.paper_id
    WHERE p.user_id = ?
      AND pv.version_number = (
          SELECT MAX(version_number)
          FROM paper_versions
          WHERE paper_id = p.paper_id
      )
    ORDER BY p.submission_date DESC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

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
