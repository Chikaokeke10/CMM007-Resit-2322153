<?php

$servername = "localhost";
$username = "root"; // 
$password = ""; // 
$dbname = "voter_registration"; // My database name

// Create connection using MySQL
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "";
?>
