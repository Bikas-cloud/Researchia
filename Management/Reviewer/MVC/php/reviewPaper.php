<?php
session_start();
require_once "../../../Auth/MVC/db/db.php";

/* ---------- AUTH CHECK ---------- */
if (!isset($_SESSION['user_id'])) {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}

$reviewer_id = $_SESSION['user_id'];

if (!isset($_GET['paper_id'])) {
    die("Invalid request");
}

$paper_id = intval($_GET['paper_id']);
$message = "";

function fetchPaper($conn, $paper_id) {
    $stmt = $conn->prepare("
        SELECT 
            p.paper_id,
            p.title,
            p.status,
            j.journal_name,
            pv.file_path
        FROM papers p
        JOIN journals j ON p.journal_id = j.journal_id
        LEFT JOIN paper_versions pv 
            ON pv.paper_id = p.paper_id
            AND pv.version_number = (
                SELECT MAX(version_number)
                FROM paper_versions
                WHERE paper_id = p.paper_id
            )
        WHERE p.paper_id = ?
    ");
    $stmt->bind_param("i", $paper_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

$paper = fetchPaper($conn, $paper_id);
if (!$paper) {
    die("Paper not found");
}


if ($paper['status'] === 'Submitted') {
    $conn->query("UPDATE papers SET status = 'Under Review' WHERE paper_id = $paper_id");
    $paper = fetchPaper($conn, $paper_id);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $score    = intval($_POST['score']);
    $comment  = trim($_POST['comment']);
    $decision = $_POST['decision'];

    $valid_status = ['Accepted', 'Rejected', 'Revised'];

    if (empty($comment) || empty($decision)) {
        $message = "All fields are required.";
    } elseif (!in_array($decision, $valid_status)) {
        $message = "Invalid decision selected.";
    } else {

        $rstmt = $conn->prepare("
            INSERT INTO reviews (paper_id, reviewer_id, score, comment, review_date)
            VALUES (?, ?, ?, ?, NOW())
        ");
        $rstmt->bind_param("iiis", $paper_id, $reviewer_id, $score, $comment);

        if ($rstmt->execute()) {

            $ustmt = $conn->prepare("
                UPDATE papers SET status = ? WHERE paper_id = ?
            ");
            $ustmt->bind_param("si", $decision, $paper_id);

            if ($ustmt->execute()) {
                $message = "Review submitted successfully!";
                $paper = fetchPaper($conn, $paper_id);
            } else {
                $message = "Failed to update paper status.";
            }

        } 
    }
}
?>

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

        <label>Decision</label>
        <select name="decision" required>
            <option value="">-- Select --</option>
            <option value="Accepted">Accept</option>
            <option value="Revised">Revision Required</option>
            <option value="Rejected">Reject</option>
        </select>

        <button type="submit">Submit Review</button>
    </form>

    <a href="reviewerDashboard.php" class="back">⬅ Back to Dashboard</a>

</div>

</body>
</html>
