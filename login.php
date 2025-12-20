<?php
require_once "config/db.php";

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {

        // Fetch user from DB
        $stmt = $conn->prepare("SELECT user_id, name, email, role, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if ($password === $user['password']) {
                session_start();
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];

                if($_SESSION['role'] === 'admin'){
                    header("Location: includes/adminDashboard.php");
                }
                 else if($_SESSION['role'] === 'author'){
                    header("Location: includes/authorDashboard.php");
                }
                else{
                    header("Location: includes/reviewerDashboard.php");
                }
               
                exit();

            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "No account found with this email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <title>Login</title>
  <link rel="stylesheet" href="/WT-Fall-25-26/Research%20Project/assets/css/loginStyle.css">

  </head>
  <body>
    <section>
      <form method="POST" action="" id="loginForm">
        <h1>Login</h1>
        <?php if (!empty($error)) : ?>
         <p style="color:red; text-align:center;">
          <?= $error ?>
        </p>
        <?php endif; ?>


        <div class="inputbox">
          <input type="email" name="email" id="email" required />
          <label>Email</label>
        </div>

        <div class="inputbox">
          <input type="password" name="password" id="password" required />
          <label>Password</label>
        </div>

        <div class="forget">
          <label><input type="checkbox" name="remember" /> Remember Me</label>
          <a href="includes/forgetPassword.php">Forget Password</a>
        </div>

        <button type="submit">Log in</button>

        <div class="register">
          <p>Don't have an account? <a href="includes/register.php">Register</a></p>
        </div>
      </form>
    </section>
    <script src="/WT-Fall-25-26/Research%20Project/assets/js/loginValidation.js"></script>

  </body>
</html>
