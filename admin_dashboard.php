<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'admin') {
    header("Location: login.html");
    exit;
}

// Fetch all voters from the database
$sql = "SELECT * FROM voters";
$result = $conn->query($sql);

// Count the number of voters
$count_voters_sql = "SELECT COUNT(*) as total_voters FROM voters";
$count_voters_result = $conn->query($count_voters_sql);
$total_voters = $count_voters_result->fetch_assoc()['total_voters'];

// Count the number of notifications
$count_notifications_sql = "SELECT COUNT(*) as total_notifications FROM notifications";
$count_notifications_result = $conn->query($count_notifications_sql);
$total_notifications = $count_notifications_result->fetch_assoc()['total_notifications'];

// Count the number of election officers
$count_officers_sql = "SELECT COUNT(*) as total_officers FROM users WHERE role = 'election_officer'";
$count_officers_result = $conn->query($count_officers_sql);
$total_officers = $count_officers_result->fetch_assoc()['total_officers'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <style>
.footer1 {
    background-color:#0b4d10;
    color: rgb(247, 245, 245);
    text-align: center;
    padding: 10px 0;
    position:relative;
    width: 100%;
    bottom: 0;
}
</style>
<header>
    <h1>Voter Registration Portal</h1>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="admin_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>
</header>

<main>
<h1>Admin Dashboard</h1>

<h2>System Information</h2>
<p>Total Number of Voters: <?php echo htmlspecialchars($total_voters); ?></p>
<p>Total Number of Notifications: <?php echo htmlspecialchars($total_notifications); ?></p>
<p>Total Number of Election Officers: <?php echo htmlspecialchars($total_officers); ?></p>

<h2>Manage Voters</h2>
<?php
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th><th>Polling Unit</th><th>Profile Picture</th><th>Actions</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>" . htmlspecialchars($row["id"]) . "</td>
                <td>" . htmlspecialchars($row["first_name"]) . "</td>
                <td>" . htmlspecialchars($row["last_name"]) . "</td>
                <td>" . htmlspecialchars($row["date_of_birth"]) . "</td>
                <td>" . htmlspecialchars($row["polling_unit"]) . "</td>
                <td><img src='" . htmlspecialchars($row["profile_picture"]) . "' alt='Profile Picture' width='100'></td>
                <td>
                    <a href='delete_voter.php?id=" . $row["id"] . "'>Delete</a>
                </td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

$conn->close();
?>
</main>

<footer>
    <p>2024 Voter Registration Portal</p>
</footer>
</body>
</html>
