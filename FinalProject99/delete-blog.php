<?php
session_start();
require 'database.php';

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $blogId = $_POST['blog_id'];

    $success = deleteBlog($blogId);

    if ($success) {
        header("Location: all-blogs.php");
        exit;
    }
} else {
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
<body>
  <?php include 'includes/header.php'; ?>

  <main>
    <h2>Delete Blog</h2>
    <p>Are you sure you want to delete the blog titled "<?php echo $blog['title']; ?>"?</p>
    <form action="" method="post">
      <input type="hidden" name="blog_id" value="<?php echo $blogId; ?>">
      <button type="submit">Yes, Delete</button>
    </form>
    <a href="view-blog.php?id=<?php echo $blogId; ?>">No, Cancel</a>
  </main>

  <?php include 'includes/footer.php'; ?>
</body>
</html>
