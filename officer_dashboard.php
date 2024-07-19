<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] != 'election_officer') {
    header("Location: login.html");
    exit;
}

// Fetching the search term from the query parameters
$search_term = isset($_GET['search']) ? $_GET['search'] : '';
$like_term = '%' . $search_term . '%';
$sql = "SELECT * FROM voters WHERE polling_unit LIKE '$like_term'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Election Officer Dashboard</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Voter Registration Portal</h1>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="officer_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Log Out</a></li>
            <li>
                <form action="" method="get" style="display:inline;">
                    <input type="text" name="search" placeholder="Search by polling unit" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit">Search</button>
                </form>
            </li>
        </ul>
    </nav>
</header>

<h1>Election Officer Dashboard</h1>
<form action="publish_notification.php" method="post">
    <label for="message">Publish Notification:</label><br>
    <textarea id="message" name="message" required></textarea><br><br>
    <input type="submit" value="Publish">
</form>

<h2>Users Information</h2>
<?php
if ($result->num_rows > 0) {
    echo "<table border='1'><tr><th>ID</th><th>First Name</th><th>Last Name</th><th>Date of Birth</th><th>Polling Unit</th><th>Profile Picture</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . htmlspecialchars($row["id"]) . "</td><td>" . htmlspecialchars($row["first_name"]) . "</td><td>" . htmlspecialchars($row["last_name"]) . "</td><td>" . htmlspecialchars($row["date_of_birth"]) . "</td><td>" . htmlspecialchars($row["polling_unit"]) . "</td><td><img src='" . htmlspecialchars($row["profile_picture"]) . "' alt='Profile Picture' width='100'></td></tr>";
    }
    echo "</table>";
} else {
    echo "No records found.";
}

$conn->close();
?>
<footer>
    <p>2024 Voter Registration Portal</p>
</footer>
</body>
</html>
