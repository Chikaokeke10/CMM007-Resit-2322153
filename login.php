<?php
session_start();
include('connection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $selected_role = $_POST['role'];
    $user_email = $_POST['email'];
    $user_password = $_POST['password'];

    $user_check_query = "SELECT id, name, password, role FROM users WHERE email = '$user_email' AND role = '$selected_role'";
    $user_check_result = $conn->query($user_check_query);

    if ($user_check_result->num_rows > 0) {
        $user_data = $user_check_result->fetch_assoc();

        if (password_verify($user_password, $user_data['password'])) {
            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['user_name'] = $user_data['name'];
            $_SESSION['user_role'] = $user_data['role'];

            switch ($user_data['role']) {
                case 'voter':
                    header('Location: voter_dashboard.php');
                    break;
                case 'election_officer':
                    header('Location: officer_dashboard.php');
                    break;
                case 'admin':
                    header('Location: admin_dashboard.php');
                    break;
                default:
                    echo "Invalid role.";
                    break;
            }
            exit;
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with the provided email and role.";
    }

    $conn->close();
}
?>
