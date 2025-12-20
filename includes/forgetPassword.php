<?php
require_once "../config/db.php";

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $email      = trim($_POST['email'] ?? '');
    $password   = $_POST['password'] ?? '';
    $retypePassword   = $_POST['retypePassword'] ?? '';

    // Server-side validation
    if($password !== $retypePassword){
        $error = "Passwords do not match.";
    }
    else
    if (empty($email) || empty($password)) {
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

        if ($check->num_rows < 1) {
            $error = "Email not registered.";
        } else {

            // Insert user (matching your DB)
            $stmt = $conn->prepare(
                "UPDATE users SET password = ? WHERE email = ?"
            );
            $stmt->bind_param(
                "ss",
                $password,
                $email
            );

            if ($stmt->execute()) {
                $success = "Password updated successfully. You can now login.";
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
    <form method="POST" action="">
        <h1>Fixed Your Password</h1>

        <?php if (!empty($error)) : ?>
            <p class="error"><?= $error ?></p>
        <?php endif; ?>

        <?php if (!empty($success)) : ?>
            <p class="success"><?= $success ?></p>
        <?php endif; ?>


        <div class="inputbox">
            <input type="email" name="email" required>
            <label>Email</label>
        </div>

        <div class="inputbox">
            <input type="password" name="password" required>
            <label>Password</label>
        </div>
        
        <div class="inputbox">
            <input type="password" name="retypePassword" required>
            <label>Retype Password</label>
        </div>

        <button type="submit">Submit</button>

        <div class="register">
            <p>Remember your password?
                <a href="../login.php">Login</a>
            </p>
        </div>
    </form>
</section>
 
</body>
</html>

