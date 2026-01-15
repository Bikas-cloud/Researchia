
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Journal</title>
    <link rel="stylesheet" href="../css/addJournal.css">
</head>
<body>

<div class="dashboard">
    <h2>Add New Journal</h2>

    <?php if ($message): ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data">

        <label>Journal Name</label><br>
        <input type="text" name="journal_name" required><br><br>

        <label>Impact Factor</label><br>
        <input type="text" name="impact_factor" required><br><br>

        <label>Journal Image</label><br>
        <input type="file" name="image" accept="image/*" required><br><br>

        <button type="submit">Add Journal</button>
    </form>

    <br>
    <a href="adminDashboard.php">⬅ Back to Dashboard</a>
</div>

</body>
</html>
