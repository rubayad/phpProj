<?php
$servername = "172.31.22.43";
$username = "Rubayad200550045";
$password = "DW3YsyvRqh";
$dbname = "Rubayad200550045";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>