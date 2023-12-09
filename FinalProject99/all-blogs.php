<?php
session_start();
require 'database.php';

$blogs = getAllBlogs();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>All Blogs</title>
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container mt-4">
        <h2>All Blogs</h2>
        <?php foreach ($blogs as $blog) : ?>
            <div class="blog-preview card mb-3">
                <div class="card-body">
                    <h3 class="card-title"><?php echo $blog['title']; ?></h3>
                    <p class="card-text"><?php echo substr($blog['body'], 0, 150) . '...'; ?></p>
                    <a href="view-blog.php?id=<?php echo $blog['id']; ?>" class="btn btn-primary">Read more</a>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if (isLoggedIn()) : ?>
            <a href="add-blog.php" class="btn btn-success">Add New Blog</a>
        <?php endif; ?>
    </main>

    <?php include 'includes/footer.php'; ?>


</body>
</html>

