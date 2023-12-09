<?php
session_start();
require 'database.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$blogId = $_GET['id'];
$blog = getBlogById($blogId);
$comments = getComments($blogId);

if (!$blog) {
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <?php include 'includes/header.php'; ?>

    <main>
        <h2><?php echo $blog['title']; ?></h2>
        <p><?php echo $blog['body']; ?></p>

        <a class="btn btn-primary" href="edit-blog.php?id=<?php echo $blog['id']; ?>">Edit</a>
        <a class="btn btn-danger" href="delete-blog.php?id=<?php echo $blog['id']; ?>">Delete</a>

        <h3>Comments</h3>
        <div id="comments">
            <?php if (count($comments) > 0) : ?>
                <?php foreach ($comments as $comment) : ?>
                    <div class="comment card">
                        <p><?php echo $comment['body']; ?></p>
                        <span class="comment-author"><?php echo $comment['username']; ?></span>
                    </div>
                <?php endforeach; ?>
            <?php else : ?>
                <p>No comments yet. Be the first to leave one!</p>
            <?php endif; ?>
        </div>

        <?php if (isLoggedIn()) : ?>
            <form action="post-comment.php" method="post">
                <input type="hidden" name="postId" value="<?php echo $blogId; ?>">
                <textarea class="form-control" name="comment" placeholder="Leave your comment here..." required></textarea>
                <button class="btn btn-success" type="submit">Comment</button>
            </form>
        <?php else : ?>
            <p>Please <a href="login.php">login</a> to leave a comment.</p>
        <?php endif; ?>
    </main>

    <?php include 'includes/footer.php'; ?>


</body>
</html>
