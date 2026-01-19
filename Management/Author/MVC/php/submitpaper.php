<?php
session_start();
require_once "../../../Auth/MVC/db/db.php";
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'author') {
    header("Location: /Research_Project/Management/Auth/MVC/php/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT 
        p.paper_id,
        p.title,
        p.status,
        j.journal_name,
        pv.file_path,
        r.score,
        r.comment,
        r.review_date,
        u.name AS reviewer_name
    FROM papers p
    JOIN journals j ON p.journal_id = j.journal_id
    LEFT JOIN paper_versions pv ON pv.paper_id = p.paper_id
        AND pv.version_number = (
            SELECT MAX(version_number)
            FROM paper_versions
            WHERE paper_id = p.paper_id
        )
    LEFT JOIN reviews r ON r.paper_id = p.paper_id
    LEFT JOIN users u ON u.user_id = r.reviewer_id
    WHERE p.user_id = ?
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
