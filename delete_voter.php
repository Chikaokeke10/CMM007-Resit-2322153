<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.html");
    exit;
}

if (isset($_GET['id'])) {
    $voter_id = $_GET['id'];
    $delete_query = "DELETE FROM voters WHERE id = '$voter_id'";
    if ($conn->query($delete_query) === TRUE) {
        header("Location: admin_dashboard.php");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    echo "Invalid voter ID.";
}

$conn->close();
?>
