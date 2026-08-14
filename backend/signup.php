<?php
include "config.php";

$name = $_POST['name'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

// Check if email already exists
$check = $conn->query("SELECT * FROM users WHERE email='$email'");

if ($check->num_rows > 0) {
    echo "Email already exists!";
    exit();
}

$sql = "INSERT INTO users (name, email, password, role)
        VALUES ('$name', '$email', '$password', '$role')";

if ($conn->query($sql) === TRUE) {
    header("Location: ../login.php");
    exit();
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>