<?php
require_once "../config/db.php";

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $first_name = trim($_POST['first_name'] ?? '');
    $last_name  = trim($_POST['last_name'] ?? '');
    $name       = $first_name . ' ' . $last_name; // merge names
    $email      = trim($_POST['email'] ?? '');
    $password   = $_POST['password'] ?? '';
    $role       = "author"; // always author

    // Server-side validation
    if (empty($first_name) || empty($last_name) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {

        // Check if email already exists
        $check = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $error = "Email already registered.";
        } else {

            // Insert user (matching your DB)
            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password, role, created_at)
                 VALUES (?, ?, ?, ?, NOW())"
            );
            $stmt->bind_param(
                "ssss",
                $name,
                $email,
                $password,
                $role
            );

            if ($stmt->execute()) {
                $success = "Registration successful. You can now login.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>

    <link rel="stylesheet" href="/WT-Fall-25-26/Research%20Project/assets/css/registerStyle.css">
</head>
<body>

<section>
    <form method="POST">
        <h1>Register</h1>

        <?php if (!empty($error)) : ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <?php if (!empty($success)) : ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>

        <div class="inputbox">
            <input type="text" name="first_name" required>
            <label>First Name</label>
        </div>

        <div class="inputbox">
            <input type="text" name="last_name" required>
            <label>Last Name</label>
        </div>

        <div class="inputbox">
            <input type="email" name="email" required>
            <label>Email</label>
        </div>

        <div class="inputbox">
            <input type="password" name="password" required>
            <label>Password</label>
        </div>

        <button type="submit">Register</button>

        <div class="register">
            <p>Already have an account?
                <a href="../login.php">Login</a>
            </p>
        </div>
    </form>
</section>
  <script src="/WT-Fall-25-26/Research%20Project/assets/js/registerValidation.js"></script>
</body>
</html>

