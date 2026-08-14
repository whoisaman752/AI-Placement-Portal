<?php
session_start();
include "config.php";

// 1. Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit();
}

// 2. Ensure form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../add_experience.php");
    exit();
}

$user_id = (int)$_SESSION['user_id'];

// Get and clean form data
$placement_year = trim($_POST['placement_year'] ?? '');
$company = trim($_POST['company'] ?? '');
$role = trim($_POST['role'] ?? '');
$rounds = trim($_POST['rounds'] ?? '');
$experience = trim($_POST['experience'] ?? '');
$academic_year = trim($_POST['academic_year'] ?? '');
$package = trim($_POST['package'] ?? '');

/* ==========================
   VALIDATION logic
   ========================== */
$errors = [];

if (empty($company)) {
    $errors[] = "Company name is required.";
}

if (!is_numeric($placement_year)) {
    $errors[] = "Invalid placement year.";
}

if (empty($academic_year)) {
    $errors[] = "Academic year is required.";
}

if (!is_numeric($package) || $package <= 0) {
    $errors[] = "Package must be a valid positive number.";
}

// If validation fails, redirect back with error feedback
if (!empty($errors)) {
    $_SESSION['form_errors'] = $errors;
    header("Location: ../add_experience.php");
    exit();
}

// 3. Prepare SQL query
$stmt = $conn->prepare("
    INSERT INTO experiences (
        user_id,
        placement_year,
        company,
        role,
        rounds,
        experience,
        academic_year,
        package
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
");

if (!$stmt) {
    die("Database error: " . $conn->error);
}

// Bind parameters (i = int, s = string, d = double)
// Adjust types if placement_year is string in DB (e.g. "issssssd")
$stmt->bind_param(
    "iisssssd",
    $user_id,
    $placement_year,
    $company,
    $role,
    $rounds,
    $experience,
    $academic_year,
    $package
);

// 4. Execute query
if ($stmt->execute()) {
    $stmt->close();
    $conn->close();
    header("Location: ../index.php?added=1");
    exit();
} else {
    // Log error internally in production instead of echoing raw errors
    echo "Execution failed: " . htmlspecialchars($stmt->error);
    $stmt->close();
    $conn->close();
}
?>