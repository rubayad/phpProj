<?php
session_start();
require 'database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the id parameter from the form
    $postId = $_POST['postId'];
    $userId = $_SESSION['user_id'];
    $comment = $_POST['comment'];

    // Call the postComment function with the id parameter
    $result = postComment($postId, $userId, $comment);

    // Handle the result as needed
    if ($result) {
        // Comment posted successfully, redirect to the view-blog page
        header("Location: view-blog.php?id=$postId");
        exit;
    } else {
        // Handle error
        echo "Error posting the comment.";
    }
} else {
    // Handle other HTTP methods (GET, etc.) if needed
    echo "Invalid request method.";
}
?>
