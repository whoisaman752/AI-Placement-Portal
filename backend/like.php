<?php
session_start();
include "config.php";

$user_id = $_SESSION['user_id'];
$exp_id = $_GET['id'];

$sql = "INSERT INTO likes (user_id, experience_id) VALUES ($user_id, $exp_id)";
$conn->query($sql);

header("Location: ../index.php");
?>