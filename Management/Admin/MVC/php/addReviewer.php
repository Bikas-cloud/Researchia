
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Reviewer</title>
<link rel="stylesheet" href="../css/addReviewer.css">
</head>
<body>

<div class="container">
    <h1>Add Reviewer</h1>

    <?php if ($message): ?>
        <div class="message"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="POST">

        <label>Reviewer Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Manual Password (given by Admin)</label>
        <input type="text" name="password" required>

        <label>Research Expertise</label>
        <input type="text" name="research_interest"
               placeholder="AI, ML, Networks" required>

        <button type="submit">Add Reviewer</button>
    </form>

    <a href="adminDashboard.php" class="back">⬅ Back</a>
</div>

</body>
</html>
