<?php
session_start();
include '../config/db.php';

if ($_SESSION['user']['role'] != 'patient') {
    header("Location: ../auth/login.php");
    exit();
}

$patient_id = $_SESSION['user']['id'];
$sql = "SELECT * FROM billing WHERE patient_id = '$patient_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Billing Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Billing Information</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Amount (₱)</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['bill_date'] ?></td>
                <td>₱<?= number_format($row['amount'], 2) ?></td>
                <td><?= $row['description'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>
</body>
</html>
