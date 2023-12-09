<?php
require_once 'includes/config.php';

if (!isLoggedIn()) {
  header("Location: login.php");
  exit;
}

$sql = "SELECT * FROM content";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
  $content = mysqli_fetch_assoc($result);
} else {
  header("Location: index.php");
  exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $title = mysqli_real_escape_string($conn, $_POST['title']);
  $body = mysqli_real_escape_string($conn, $_POST['body']);

  $sql = "UPDATE content SET title = ?, body = ? WHERE id = 1";
  $stmt = mysqli_prepare($conn, $sql);
  mysqli_stmt_bind_param($stmt, "ss", $title, $body);
  mysqli_stmt_execute($stmt);

  if (mysqli_affected_rows($conn) > 0) {
    header("Location: index.php?updated=true");
    exit;
  } else {
    $error = "Error! Content could not be updated.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Update Content</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<body>
  <?php include 'includes/header.php'; ?>

  <main>
    <h2>Update Content</h2>

    <?php if (isset($error)) : ?>
      <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>

    <form action="update-content.php" method="post">
      <label for="title">Title:</label>
      <input type="text" name="title" id="title" value="<?php echo $content['title']; ?>" required>
      <br>
      <label for="body">Body:</label>
      <textarea name="body" id="body" rows="10" required><?php echo $content['body']; ?></textarea>
      <br>
      <button type="submit">Update</button>
    </form>
  </main>

  <?php include 'includes/footer.php'; ?>
</body>
</html>
