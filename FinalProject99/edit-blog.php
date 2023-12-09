<?php
session_start();
require 'database.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blogId = $_POST['blog_id'];
    $title = $_POST['title'];
    $body = $_POST['body'];

    $success = updateBlog($blogId, $title, $body);

    if ($success) {
        header("Location: view-blog.php?id=$blogId");
        exit;
    }
} else {
    // Fetch the current blog data
    if (isset($_GET['id']) && !empty($_GET['id'])) {
        $blogId = $_GET['id'];
        $blog = getBlogById($blogId);

        if (!$blog) {
            header("Location: index.php");
            exit;
        }
    } else {
        header("Location: index.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Blog</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container mt-4">
        <h2>Edit Blog</h2>
        <form action="" method="post">
            <input type="hidden" name="blog_id" value="<?php echo $blogId; ?>">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" class="form-control" name="title" id="title" value="<?php echo $blog['title']; ?>" required>
            </div>
            <div class="form-group">
                <label for="body">Body:</label>
                <textarea class="form-control" name="body" id="body" required><?php echo $blog['body']; ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>

