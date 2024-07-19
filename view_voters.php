<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    echo "Please log in to view this page.";
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetching the search term from the query parameters
$search_term = isset($_GET['search']) ? $_GET['search'] : '';
$like_term = '%' . $search_term . '%';
$sql = "SELECT * FROM voters WHERE users_id = '$user_id' AND (first_name LIKE '$like_term' OR last_name LIKE '$like_term')";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Voters</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
    <h1>Voter Registration Portal</h1>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="voter_dashboard.php">Dashboard</a></li>
            <li><a href="logout.php">Log Out</a></li>
            <li>
                <form action="" method="get" style="display:inline;">
                    <input type="text" name="search" placeholder="Search by name" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                    <button type="submit">Search</button>
                </form>
            </li>
        </ul>
    </nav>
</header>

<?php

if ($result->num_rows > 0) {
    echo "<h1>List of Voters</h1>";
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
