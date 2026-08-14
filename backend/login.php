<?php
session_start();
include "config.php";

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows == 1) {
    $user = $result->fetch_assoc();

    if (password_verify($password, $user['password'])) {
        
        // Store session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        header("Location: ../index.php");
        exit();
    } else {
        echo "Invalid password!";
    }
} else {
    echo "User not found!";
}

$conn->close();
?>