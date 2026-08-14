<?php
session_start();
include "config.php";

$user_id = $_SESSION['user_id'];
$exp_id = $_POST['exp_id'];
$comment = $_POST['comment'];

$sql = "INSERT INTO comments (user_id, experience_id, comment)
        VALUES ($user_id, $exp_id, '$comment')";

$conn->query($sql);

header("Location: ../index.php");
?>