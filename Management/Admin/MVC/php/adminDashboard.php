<?php
session_start();
require_once "../../../Auth/MVC/db/db.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}
/* Basic admin protection */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/adminDashboard.css">
</head>
<body>

<div class="dashboard">
    <h1>Admin Dashboard</h1>
    <h3>Recent Submits</h3>
 
    <div class="cards">
        <a href="journals.php" class="card">Manage Journals</a>
        <a href="papers.php" class="card">View Papers</a>
        <a href="reviewers.php" class="card">Assign Reviewers</a>
        <a href="/Research_Project/Management/Auth/MVC/php/logout.php" class="card logout">Logout</a>
    </div>
   <div class="recentSubmit">
<?php
$journals = $conn->query("SELECT * FROM journals");

while ($journal = $journals->fetch_assoc()) {

    // count papers for this journal
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

        <p>Impact Factor: <?= $journal['impact_factor'] ?></p>

        <p>Total Papers: <?= $totalPapers ?></p>

        <a href="papers.php?journal_id=<?= $journal['journal_id'] ?>">
            View Papers
        </a>
    </div>
    <?php } ?>

    </div>
  
        <div class="journal">
            
        </div>
        <div class="journal">
            
        </div>
        <div class="journal">
            
        </div>
        <div class="journal">
            
        </div>
        <div class="journal">
            
        </div>
        <div class="journal">
            
        </div>
    </div>

</div>

<script src="../js/adminDashboard.js"></script>
</body>
</html>
