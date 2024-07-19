<?php
session_start();
include('connection.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit;
}

$user_id = $_SESSION['user_id'];

$query = "SELECT * FROM voters WHERE users_id = '$user_id'";
$result = $conn->query($query);

$voter_info = $result->fetch_assoc();

$notifications_query = "SELECT * FROM notifications ORDER BY created_at DESC";
$notifications_result = $conn->query($notifications_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard</title>
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
            <li><a href="view_voters.php">View Voters</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>
</header>
<h1>My Dashboard</h1>
<form action="prvoter_dashboard.php" method="post" enctype="multipart/form-data">
    <label for="first_name">First Name:</label><br>
    <input type="text" id="first_name" name="first_name" value="<?php echo isset($voter_info['first_name']) ? htmlspecialchars($voter_info['first_name']) : ''; ?>" required><br><br>

    <label for="last_name">Last Name:</label><br>
    <input type="text" id="last_name" name="last_name" value="<?php echo isset($voter_info['last_name']) ? htmlspecialchars($voter_info['last_name']) : ''; ?>" required><br><br>

    <label for="date_of_birth">Date of Birth:</label><br>
    <input type="date" id="date_of_birth" name="date_of_birth" value="<?php echo isset($voter_info['date_of_birth']) ? $voter_info['date_of_birth'] : ''; ?>" required><br><br>

    <label for="polling_unit">Polling Unit:</label><br>
    <input type="text" id="polling_unit" name="polling_unit" value="<?php echo isset($voter_info['polling_unit']) ? htmlspecialchars($voter_info['polling_unit']) : ''; ?>" required><br><br>

    <label for="profile_picture">Photo ID:</label><br>
    <input type="file" id="profile_picture" name="profile_picture"><br><br>
    <input type="hidden" name="existing_profile_picture" value="<?php echo isset($voter_info['profile_picture']) ? htmlspecialchars($voter_info['profile_picture']) : ''; ?>">

    <input type="submit" value="Edit&update">
</form>

<h2>My Personal Information</h2>
<ul>
    <li>First Name: <?php echo isset($voter_info['first_name']) ? htmlspecialchars($voter_info['first_name']) : ''; ?></li>
    <li>Last Name: <?php echo isset($voter_info['last_name']) ? htmlspecialchars($voter_info['last_name']) : ''; ?></li>
    <li>Date of Birth: <?php echo isset($voter_info['date_of_birth']) ? $voter_info['date_of_birth'] : ''; ?></li>
    <li>Polling Unit: <?php echo isset($voter_info['polling_unit']) ? htmlspecialchars($voter_info['polling_unit']) : ''; ?></li>
    <li>Profile Picture: 
        <?php if (isset($voter_info['profile_picture']) && $voter_info['profile_picture']): ?>
            <img src="<?php echo htmlspecialchars($voter_info['profile_picture']); ?>" alt="Profile Picture" width="100">
        <?php endif; ?>
    </li>
</ul>

<h2>Notifications</h2>
<ul>
    <?php while ($notification = $notifications_result->fetch_assoc()): ?>
        <li><?php echo htmlspecialchars($notification['message']); ?> (<?php echo $notification['created_at']; ?>)</li>
    <?php endwhile; ?>
</ul>

<footer class="footer1">
    <p>2024 Voter Registration System</p>
</footer>
</body>
</html>
