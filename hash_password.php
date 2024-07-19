<?php
$password = 'Admin'; // Replace with the actual password
$hashed_password = password_hash($password, PASSWORD_BCRYPT);
echo 'Plain password: ' . $password . '<br>';
echo 'Hashed password: ' . $hashed_password;
?>
