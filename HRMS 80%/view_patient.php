<?php
session_start();
include '../config/db.php';

if ($_SESSION['user']['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    echo "No patient ID specified.";
    exit();
}

$id = $_GET['id'];
$res = $conn->query("SELECT * FROM users WHERE id = $id AND role = 'patient'");

if ($res->num_rows == 0) {
    echo "Patient not found.";
    exit();
}

$patient = $res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-primary">Patient Profile</h2>
    <div class="card p-4 mt-3 shadow-sm">
        <p><strong>Full Name:</strong> <?= $patient['name']; ?></p>
        <p><strong>Email:</strong> <?= $patient['email']; ?></p>
        <p><strong>Age:</strong> <?= $patient['age'] ?? 'N/A'; ?></p>
        <p><strong>Address:</strong> <?= $patient['address'] ?? 'N/A'; ?></p>
        <p><strong>Contact:</strong> <?= $patient['contact'] ?? 'N/A'; ?></p>
    </div>
    <a href="patients.php" class="btn btn-secondary mt-3">← Back to Patient List</a>
</div>
</body>
</html>
