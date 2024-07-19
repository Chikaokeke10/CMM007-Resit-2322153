<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'election_officer') {
    $message = $_POST['message'];

    $sql = "INSERT INTO notifications (message) VALUES ('$message')";
    if ($conn->query($sql) === TRUE) {
        header("Location: officer_dashboard.php");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
} else {
    header("Location: login.html");
    exit;
}
?>
