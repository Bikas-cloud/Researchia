<?php
session_start();

require_once "../../../Auth/MVC/db/db.php"; 

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'reviewer') {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $conn->prepare("
    SELECT 
        p.paper_id,
        p.title,
        j.journal_name,
        ra.deadline,
        p.status
    FROM reviewer_assignment ra
    JOIN papers p ON ra.paper_id = p.paper_id
    JOIN journals j ON p.journal_id = j.journal_id
    WHERE ra.reviewer_id = ?
    ORDER BY ra.deadline ASC
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reviewer Dashboard</title>
    <link rel="stylesheet" href="../css/reviewerDashboard.css">
</head>
<body>

<div class="dashboard">
<h1>Reviewer Dashboard</h1>

    <div class="cards">
        <a href="../../../Auth/MVC/php/profile.php" class="card">Profile</a>
        
        <a href="/Research_Project/Management/Auth/MVC/php/logout.php" class="card logout">Logout</a>
    </div>
    
    <div class="recentSubmit">
        <?php if ($result->num_rows === 0): ?>
            <p>No papers assigned yet.</p>
        <?php else: ?>
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="journal">
                    <div class="journal-body">
                        <h3><?= htmlspecialchars($row['title']) ?></h3>
                        <p><strong>Journal:</strong> <?= htmlspecialchars($row['journal_name']) ?></p>
                        <p><strong>Deadline:</strong> <?= date("d M Y", strtotime($row['deadline'])) ?></p>
                        <p><strong>Status:</strong> <?= htmlspecialchars($row['status']) ?></p>

                        <a href="reviewPaper.php?paper_id=<?= $row['paper_id'] ?>">
                            Review Paper
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>

</div>

</body>
</html>
