<?php
session_start();
require 'database.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $body = $_POST['body'];

    $success = addNewBlog($title, $body);

    if ($success) {
        header("Location: all-blogs.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Add New Blog</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container mt-4">
        <h2>Add New Blog</h2>
        <form action="" method="post">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" name="title" id="title" required>
            </div>
            <div class="form-group">
                <label for="body">Body:</label>
                <textarea class="form-control" name="body" id="body" rows="5" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </main>

    <?php include 'includes/footer.php'; ?>

</body>
</html>

