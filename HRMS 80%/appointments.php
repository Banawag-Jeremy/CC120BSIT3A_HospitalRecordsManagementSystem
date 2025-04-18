<?php 
session_start();
include '../config/db.php';

if ($_SESSION['user']['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

if (isset($_GET['complete'])) {
    $id = $_GET['complete'];
    $conn->query("UPDATE appointments SET status = 'Completed' WHERE id = $id");
    header("Location: appointments.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Appointments - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Appointments Management</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient ID</th>
                <th>Appointment Date</th>
                <th>Reason</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $appointments = $conn->query("SELECT * FROM appointments ORDER BY date DESC");
            while ($row = $appointments->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['patient_id']; ?></td>
                    <td><?php echo $row['date']; ?></td>
                    <td><?php echo $row['reason']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td>
                        <?php if ($row['status'] == 'Pending'): ?>
                            <a href="?complete=<?php echo $row['id']; ?>" class="btn btn-success btn-sm" onclick="return confirm('Mark as completed?')">Mark Completed</a>
                        <?php else: ?>
                            <span class="badge bg-success">Done</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="dashboard.php" class="btn btn-secondary btn-sm">← Back to Admin Dashboard</a>

    </a>
</div>

</body>
</html>
