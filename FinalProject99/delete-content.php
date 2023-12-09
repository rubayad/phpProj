<?php
require_once 'includes/config.php';

if (!isLoggedIn()) {
  header("Location: login.php");
  exit;
}

$sql = "DELETE FROM content WHERE id = 1";
mysqli_query($conn, $sql);

if (mysqli_affected_rows($conn) > 0) {
  header("Location: index.php?deleted=true");
  exit;
} else {
  header("Location: index.php");
  exit;
}
