<?php
session_start();
include '../config/db.php';

if ($_SESSION['user']['role'] != 'patient') {
    header("Location: ../auth/login.php");
    exit();
}

$patient_id = $_SESSION['user']['id'];
$sql = "SELECT * FROM medical_records WHERE patient_id = '$patient_id'";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medical Records</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Medical Records</h2>

    <table class="table table-bordered table-striped">
        <thead class="table-dark">
            <tr>
                <th>Date</th>
                <th>Diagnosis</th>
                <th>Treatment</th>
            </tr>
        </thead>
        <tbody>
        <?php while ($row = $result->fetch_assoc()) { ?>
            <tr>
                <td><?= $row['record_date'] ?></td>
                <td><?= $row['diagnosis'] ?></td>
                <td><?= $row['treatment'] ?></td>
            </tr>
        <?php } ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
</div>
</body>
</html>
