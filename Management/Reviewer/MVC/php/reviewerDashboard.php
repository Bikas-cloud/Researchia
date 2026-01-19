

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
