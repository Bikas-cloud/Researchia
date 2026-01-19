
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Update Journal</title>
<link rel="stylesheet" href="../css/updateJournal.css">
</head>
<body>

<div class="container">
    <h1>Update Journal</h1>

    <form id="updateJournalForm" enctype="multipart/form-data">
        <input type="hidden" name="journal_id" value="<?= $journal_id ?>">

        <label>Journal Name</label>
        <input type="text" name="journal_name"
               value="<?= htmlspecialchars($journal['journal_name']) ?>" required>

        <label>Impact Factor</label>
        <input type="number" step="0.01" name="impact_factor"
               value="<?= htmlspecialchars($journal['impact_factor']) ?>" required>

        <label>Journal Image (optional)</label>
        <input type="file" name="image" accept="image/*">

        <button type="submit">Update Journal</button>

        <p id="formMsg"></p>
    </form>

    <a href="adminDashboard.php" class="back">⬅ Back</a>
</div>

<script src="../js/updateJournal.js"></script>
</body>
</html>
