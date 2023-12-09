<?php
include 'conn.php';



function getAllUsers() {
    global $conn;
    $sql = "SELECT * FROM users";
    $result = mysqli_query($conn, $sql);
  
    if (mysqli_num_rows($result) > 0) {
      $users = [];
      while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
      }
      return $users;
    } else {
      return [];
    }
  }
  
  function updateUser($id, $username, $email) {
    global $conn;
    if (!validateUsername($username) || !validateEmail($email)) {
      return false;
    }
  
    $sql = "UPDATE users SET username = ?, email = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "sss", $username, $email, $id);
    mysqli_stmt_execute($stmt);
  
    if (mysqli_affected_rows($conn) > 0) {
      return true;
    } else {
      return "Error! User could not be updated.";
    }
  }
  
  function deleteUser($id) {
    global $conn;
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
  
    if (mysqli_affected_rows($conn) > 0) {
      return true;
    }else {
        return "Error! User could not be deleted.";
      }
}  


function displayContent() {
    global $conn;
    $sql = "SELECT * FROM content";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<h1>" . $row['title'] . "</h1>";
            echo "<p>" . $row['body'] . "</p>";

            $comments = getComments($row['id']);
            echo "<h3>Comments</h3>";
            echo "<div id='comments'>";
            if (count($comments) > 0) {
                foreach ($comments as $comment) {
                    echo "<div class='comment'>";
                    echo "<p>" . $comment['body'] . "</p>";
                    echo "<span class='comment-author'>" . $comment['username'] . "</span>";
                    echo "</div>";
                }
            } else {
                echo "<p>No comments yet. Be the first to leave one!</p>";
            }
            echo "</div>";
        }
    } else {
        echo "No content found!";
    }
}


function getComments($postId) {
    global $conn; 
    $sql = "SELECT c.*, u.username FROM comments c
            JOIN users u ON c.user_id = u.id
            WHERE c.post_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $postId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        $comments = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $comments[] = $row;
        }
        return $comments;
    } else {
        return [];
    }
}

  
  // Function to post a comment to the database
function postComment($postId, $userId, $comment) {
    global $conn; // Declare $conn as a global variable

    $sql = "INSERT INTO comments (post_id, user_id, body) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "iis", $postId, $userId, $comment);

    return mysqli_stmt_execute($stmt);
}

  
  function isLoggedIn() {
    // Replace with your actual logic to check user session
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
      return true;
    } else {
      return false;
    }
  }

  // Add these functions to your database.php file

function getLatestBlogs($limit = 3) {
    global $conn;
    $sql = "SELECT * FROM content ORDER BY created_at DESC LIMIT ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $limit);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    $blogs = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $blogs[] = $row;
    }

    return $blogs;
}

function getBlogById($blogId) {
    global $conn;
    $sql = "SELECT * FROM content WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $blogId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    return mysqli_fetch_assoc($result);
}

function getAllBlogs() {
    global $conn;
    $sql = "SELECT * FROM content";
    $result = mysqli_query($conn, $sql);

    $blogs = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $blogs[] = $row;
    }

    return $blogs;
}


function addNewBlog($title, $body) {
    global $conn;
    $sql = "INSERT INTO content (title, body) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $title, $body);

    return mysqli_stmt_execute($stmt);
}

// Add this function to your database.php file

function updateBlog($blogId, $title, $body) {
    global $conn;
    $sql = "UPDATE content SET title = ?, body = ? WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "ssi", $title, $body, $blogId);

    return mysqli_stmt_execute($stmt);
}

// Add this function to your database.php file

function deleteBlog($blogId) {
    global $conn;
    $sql = "DELETE FROM content WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $blogId);

    return mysqli_stmt_execute($stmt);
}

