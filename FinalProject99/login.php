<?php
require 'database.php';

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = mysqli_real_escape_string($conn, $_POST['username']);
  $password = mysqli_real_escape_string($conn, $_POST['password']);

  // Validate username and password
  if (empty($username) || empty($password)) {
    $error = "Please enter your username and password.";
  } else {
    // Check if user exists
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
      $user = mysqli_fetch_assoc($result);
      if (password_verify($password, $user['password'])) {
        // Login successful
        session_start();
        $_SESSION['logged_in'] = true;
        $_SESSION['user_id'] = $user['id'];
        header("Location: index.php");
        exit;
      } else {
        $error = "Invalid username or password.";
      }
    } else {
      $error = "User does not exist.";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Add your custom styles link after Bootstrap -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container mt-4">
        <h1>Login</h1>

        <?php if (!empty($error)) : ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form action="login.php" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <p class="mt-3">Don't have an account? <a href="register.php">Register now.</a></p>
    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>

