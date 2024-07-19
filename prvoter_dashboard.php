<?php
session_start();
include('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $users_id = $_SESSION['user_id'];

        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $date_of_birth = $_POST['date_of_birth'];
        $polling_unit = $_POST['polling_unit'];
        $profile_picture = $_FILES['profile_picture']['name'];

        if ($profile_picture) {
            $target_dir = "uploads/";
            $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
            if (!move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
                echo "Error uploading file.";
                exit;
            }
        } else {
            $target_file = $_POST['existing_profile_picture'];
        }

        $query = "SELECT * FROM voters WHERE users_id = '$users_id'";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $sql = "UPDATE voters SET first_name='$first_name', last_name='$last_name', date_of_birth='$date_of_birth', polling_unit='$polling_unit', profile_picture='$target_file' WHERE users_id='$users_id'";
        } else {
            $sql = "INSERT INTO voters (users_id, first_name, last_name, date_of_birth, polling_unit, profile_picture) VALUES ('$users_id', '$first_name', '$last_name', '$date_of_birth', '$polling_unit', '$target_file')";
        }

        if ($conn->query($sql) === TRUE) {
            $_SESSION['voter_first_name'] = $first_name;
            $_SESSION['voter_last_name'] = $last_name;
            $_SESSION['voter_date_of_birth'] = $date_of_birth;
            $_SESSION['voter_polling_unit'] = $polling_unit;
            $_SESSION['voter_profile_picture'] = $target_file;

            header("Location: voter_dashboard.php");
            exit;
        } else {
            echo "Error updating/creating record: " . $conn->error;
        }
    } else {
        echo "User is not logged in.";
    }
}

$conn->close();
?>
