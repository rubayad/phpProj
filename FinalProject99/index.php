
<?php
session_start();
require 'database.php';

$blogs = getLatestBlogs(3); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Blog</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main class="container mt-4">
        <h2 class="mb-4">Latest Blogs</h2>
        <div class="row">
            <?php foreach ($blogs as $blog) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?php echo $blog['title']; ?></h5>
                            <p class="card-text"><?php echo substr($blog['body'], 0, 150) . '...'; ?></p>
                            <a href="view-blog.php?id=<?php echo $blog['id']; ?>" class="btn btn-primary">Read more</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <a href="all-blogs.php" class="btn btn-secondary mt-4">View All Blogs</a>
    </main>

    <?php include 'includes/footer.php'; ?>
</body>
</html>
