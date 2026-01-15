
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Papers</title>
    <link rel="stylesheet" href="../css/allPaper.css">
</head>
<body>

<div class="container">
    <h1>All Submitted Papers</h1>

    <div class="paper-table">

        <div class="table-head">
            <span>Title</span>
            <span>Journal</span>
            <span>Author</span>
            <span>Status</span>
            <span>Submitted</span>
            <span>Action</span>
            <span>Reviewer</span>
        </div>

        <?php while ($row = $papers->fetch_assoc()): ?>
        <div class="table-row">

            <span><?= htmlspecialchars($row['title']) ?></span>
            <span><?= htmlspecialchars($row['journal_name']) ?></span>
            <span><?= htmlspecialchars($row['author_name']) ?></span>

            <span class="status <?= strtolower($row['status']) ?>">
                <?= ucfirst($row['status']) ?>
            </span>

            <span><?= date("d M Y", strtotime($row['submission_date'])) ?></span>

         
        
        </div>
        <?php endwhile; ?>

    </div>

    <a href="adminDashboard.php" class="back">⬅ Back to Dashboard</a>
</div>

<script src="../js/allPaper.js"></script>
</body>
</html>
