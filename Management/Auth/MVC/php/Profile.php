<?php
session_start();
require_once "../db/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

// Default: logged-in user
$user_id = $_SESSION['user_id'];

// If admin & user_id provided → view that profile
if ($_SESSION['role'] === 'admin' && isset($_GET['user_id'])) {
    $user_id = (int) $_GET['user_id'];
}


$stmt = $conn->prepare("
    SELECT name,email,affiliation,bio,research_interests,profile_pic
    FROM Users WHERE user_id=?
");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

/* Stats */
$submitted = $conn->query("SELECT COUNT(*) FROM Papers WHERE user_id=$user_id")->fetch_row()[0];
$accepted  = $conn->query("SELECT COUNT(*) FROM Papers WHERE user_id=$user_id AND status='accepted'")->fetch_row()[0];
$review    = $conn->query("SELECT COUNT(*) FROM Papers WHERE user_id=$user_id AND status='under_review'")->fetch_row()[0];
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Author Profile</title>
<link rel="stylesheet" href="../css/Profile.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="profile-container">

    <!-- PROFILE IMAGE -->
    <div class="profile-pic">
        <img src="../uploads/profile/<?= htmlspecialchars($user['profile_pic']) ?>" id="profileImage">
        <label class="camera">
            <i class="fa fa-camera"></i>
            <input type="file" id="profilePicInput" hidden>
        </label>
    </div>

    <!-- NAME & EMAIL -->
    <h1 id="nameText"><?= htmlspecialchars($user['name']) ?></h1>
    <p class="email"><?= htmlspecialchars($user['email']) ?></p>

    <!-- AFFILIATION -->
    <div class="editable">
        <p id="affiliationText"><?= htmlspecialchars($user['affiliation']) ?></p>
        <button onclick="editField('affiliation')">Edit</button>
    </div>

    <hr>

    <!-- RESEARCH INTEREST -->
    <h3>Research Interests</h3>
    <div class="tags" id="research_interestsText">
        <?php foreach (explode(',', $user['research_interests']) as $tag): ?>
            <span><?= htmlspecialchars(trim($tag)) ?></span>
        <?php endforeach; ?>
    </div>
    <button class="edit-btn" onclick="editField('research_interests')">Edit</button>

    <hr>

    <!-- BIO -->
    <h3>Bio</h3>
    <p id="bioText"><?= nl2br(htmlspecialchars($user['bio'])) ?></p>
    <button class="edit-btn" onclick="editField('bio')">Edit</button>

    <hr>

    <!-- STATS -->
    <div class="stats">
        <div><strong><?= $submitted ?></strong><span>Submitted</span></div>
        <div><strong><?= $accepted ?></strong><span>Accepted</span></div>
        <div><strong><?= $review ?></strong><span>Under Review</span></div>
    </div>

    <!-- DARK MODE -->
    <button id="themeToggle" class="dark-btn">
        <i class="fa fa-moon"></i> Dark Mode
    </button>

</div>

<script src="../js/Profile.js"></script>
</body>
</html>
