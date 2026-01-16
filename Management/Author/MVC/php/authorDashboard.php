<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Author Dashboard</title>
    <link rel="stylesheet" href="../css/authorDashboard.css">
</head>
<body>
<div class="dashboard">
    <h1>Author Dashboard</h1>
    <div class="cards">
        <a href="addPaper.php" class="card">Submit Papers</a>
        <a href="mypapers.php" class="card">My Papers</a>
        <a href="submitpaper.php" class="card">Reviewer Feedback</a>
        <a href="../../../Auth/MVC/php/profile.php" class="card">Profile</a>        
        
        <a href="/Research_Project/Management/Auth/MVC/php/logout.php" class="card logout">Logout</a>
    </div>
    <div class="recentSubmit">
        <?php
        $journals = $conn->query("SELECT * FROM journals");

        while ($journal = $journals->fetch_assoc()) {

            // Count papers for this journal
            $stmt = $conn->prepare(
                "SELECT COUNT(*) AS total FROM papers WHERE journal_id = ?"
            );
            $stmt->bind_param("i", $journal['journal_id']);
            $stmt->execute();
            $countResult = $stmt->get_result()->fetch_assoc();
            $totalPapers = $countResult['total'];
        ?>

        <div class="journal">
                <div class="journal-thumb">
                    <img src="../images/ijcs.png" alt="Journal">
                </div>

                <div class="journal-body">
                    <h3><?= htmlspecialchars($journal['journal_name']) ?></h3>
                    <p>Impact Factor: <?= htmlspecialchars($journal['impact_factor']) ?></p>
                    <p>Total Papers: <?= $totalPapers ?></p>

                    <a href="addPaper.php?journal_id=<?= (int)$journal['journal_id'] ?>">
                        Submit Papers
                    </a>
                </div>
            </div>
</div>

<script src="../js/adminDashboard.js"></script>
</body>
</html>
