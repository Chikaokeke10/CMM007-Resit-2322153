<?php
require 'connection.php';

if ($_SERVER['REQUEST_METHOD'] ===  'POST') {
    $role = 'voter'; // only voter can registers
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        die("Passwords do not match");
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email_query = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($check_email_query);

    if ($result-> num_rows > 0) {
        echo "Email already exists. Please use a different email.";
    } else {
        // Insert user into database
        $sql = "INSERT  INTO users (name, email, password, role) VALUES ('$name', '$email', '$hashed_password', '$role')";

        if ($conn-> query($sql) === TRUE) {
            echo "User registered successfully. <a href='login.html'>Login here</a>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    
}


$conn->close();
?>
