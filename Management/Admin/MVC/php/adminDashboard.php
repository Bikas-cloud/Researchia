<?php
session_start();
require_once "../../../Auth/MVC/db/db.php";
$themeClass = "";
if (isset($_COOKIE['theme']) && $_COOKIE['theme'] === 'dark') {
    $themeClass = "dark";
}
// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}

// Basic admin protection
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Research_Project/Management/Auth/MVC/php/index.php");
    exit;
}


$stmt = $conn->prepare("SELECT name, profile_pic FROM users WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../css/adminDashboard.css">
</head>

<body class="<?= $themeClass ?>">

<div class="dashboard">
    <div class="dashboard-header">
       <h1>Admin Dashboard</h1>
       <div class="admin-info">
        <span class="admin-name">
            <?= htmlspecialchars($admin['name']) ?>
        </span>

        <img src="../../../Auth/MVC/uploads/profile/<?= htmlspecialchars($admin['profile_pic'] ?: 'default.png') ?>"
             class="admin-avatar"
             alt="Profile">
        </div>
    </div>
    <div class="cards">

        <div class="card menu">
            <span id="manageJournalBtn">Manage Journals</span>

            <div class="submenu" id="journalMenu">
                <a href="add_journal.php">Add Journal</a>
                <a href="../html/deleteJournal.php">Delete Journal</a>
            </div>
        </div>
        

        <a href="allPaper.php" class="card">View Papers</a>
        <a href="addReviewer.php" class="card">Add Reviewers</a>
         <a href="../../../Auth/MVC/php/Profile.php" class="card">View Profile</a>
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
                    <img src="../images/journals/<?= htmlspecialchars($journal['image']) ?>" alt="Journal">
                </div>

                <div class="journal-body">
                    <h3><?= htmlspecialchars($journal['journal_name']) ?></h3>
                    <p>Impact Factor: <?= htmlspecialchars($journal['impact_factor']) ?></p>
                    <p>Total Papers: <?= $totalPapers ?></p>

                    <a href="allPaper.php?journal_id=<?= (int)$journal['journal_id'] ?>">
                        View Papers
                    </a>
                     <a href="updateJournal.php?journal_id=<?= (int)$journal['journal_id'] ?>">
                     Edit Journal
                     </a>
                </div>
            </div>
        <?php
            $stmt->close();
        }
        ?>
    </div>
</div>

<script src="../js/adminDashboard.js"></script>
</body>
</html>
