<?php
session_start();
require 'database.php';

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($confirmPassword)) {
        $errors[] = "All fields are required.";
    } else {
        // Validate username
        if (!preg_match("/^[a-zA-Z0-9_]+$/", $username)) {
            $errors[] = "Invalid characters in username.";
        }

        if (strlen($username) < 4 || strlen($username) > 255) {
            $errors[] = "Username must be between 4 and 255 characters.";
        }

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Invalid email address.";
        }

        // Validate password
        if (strlen($password) < 8) {
            $errors[] = "Password must be at least 8 characters.";
        }

        // Check if passwords match
        if ($password !== $confirmPassword) {
            $errors[] = "Passwords do not match.";
        }

        // Check if the email already exists
        $existingUser = getUserByEmail($email);
        if ($existingUser) {
            $errors[] = "Email already exists.";
        }
    }

    // If no errors, proceed with registration
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $result = addUser($username, $email, $hashedPassword);

        if ($result) {
            // Registration successful
            $_SESSION['logged_in'] = true;
            $_SESSION['user_id'] = $result;

            header("Location: index.php?registered=true");
            exit;
        } else {
            $errors[] = "Error! User could not be registered.";
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <!-- Add your custom styles link after Bootstrap -->
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container mt-4">
        <h2>Register</h2>
        <?php
        // Display errors, if any
        if (!empty($errors)) {
            echo "<div class='error-container'>";
            foreach ($errors as $error) {
                echo "<p class='error'>$error</p>";
            }
            echo "</div>";
        }
        ?>
        <form action="" method="post">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" name="username" id="username" value="<?php echo isset($_POST['username']) ? $_POST['username'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" name="email" id="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ''; ?>">
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" name="password" id="password">
            </div>
            <div class="form-group">
                <label for="confirm_password">Confirm Password:</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm_password">
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
