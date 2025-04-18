<?php
session_start();
include '../config/db.php';

if ($_SESSION['user']['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

// Add Record
if (isset($_POST['add'])) {
    $patient_id = $_POST['patient_id'];
    $diagnosis = $_POST['diagnosis'];
    $treatment = $_POST['treatment'];
    $date = $_POST['record_date'];

    $sql = "INSERT INTO medical_records (patient_id, diagnosis, treatment, record_date) 
            VALUES ('$patient_id', '$diagnosis', '$treatment', '$date')";
    $conn->query($sql);
    header("Location: records.php");
    exit();
}

// Delete Record
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM medical_records WHERE id = $id");
    header("Location: records.php");
    exit();
}

// Edit Record - Load data
$edit_record = null;
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $res = $conn->query("SELECT * FROM medical_records WHERE id = $id");
    $edit_record = $res->fetch_assoc();
}

// Update Record
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $patient_id = $_POST['patient_id'];
    $diagnosis = $_POST['diagnosis'];
    $treatment = $_POST['treatment'];
    $date = $_POST['record_date'];

    $sql = "UPDATE medical_records SET 
                patient_id='$patient_id', 
                diagnosis='$diagnosis', 
                treatment='$treatment', 
                record_date='$date' 
            WHERE id='$id'";
    $conn->query($sql);
    header("Location: records.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Medical Records - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-primary">Medical Records Management (Admin)</h2>

    <!-- Form Section -->
    <h3><?php echo $edit_record ? 'Edit Record' : 'Add New Record'; ?></h3>
    <form method="POST">
        <?php if ($edit_record): ?>
            <input type="hidden" name="id" value="<?php echo $edit_record['id']; ?>">
        <?php endif; ?>

        <div class="mb-3">
            <label>Patient ID:</label>
            <input name="patient_id" value="<?php echo $edit_record['patient_id'] ?? ''; ?>" class="form-control" required><br>
        </div>

        <div class="mb-3">
            <label>Diagnosis:</label>
            <textarea name="diagnosis" class="form-control" required><?php echo $edit_record['diagnosis'] ?? ''; ?></textarea><br>
        </div>

        <div class="mb-3">
            <label>Treatment:</label>
            <textarea name="treatment" class="form-control" required><?php echo $edit_record['treatment'] ?? ''; ?></textarea><br>
        </div>

        <div class="mb-3">
            <label>Date:</label>
            <input type="date" name="record_date" value="<?php echo $edit_record['record_date'] ?? ''; ?>" class="form-control" required><br>
        </div>

        <button type="submit" name="<?php echo $edit_record ? 'update' : 'add'; ?>" class="btn btn-primary">
            <?php echo $edit_record ? 'Update' : 'Add'; ?> Record
        </button>
    </form>

    <hr>

    <h3>All Medical Records</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Patient ID</th>
                <th>Diagnosis</th>
                <th>Treatment</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $records = $conn->query("SELECT * FROM medical_records ORDER BY record_date DESC");
            while ($row = $records->fetch_assoc()):
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['patient_id']; ?></td>
                    <td><?php echo $row['diagnosis']; ?></td>
                    <td><?php echo $row['treatment']; ?></td>
                    <td><?php echo $row['record_date']; ?></td>
                    <td>
                        <a href="?edit=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a> | 
                        <a href="?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure?')" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                <a href="dashboard.php" class="btn btn-secondary btn-sm">← Back to Admin Dashboard</a>
            <?php endwhile; ?>
        </tbody>
    </table>

</body>
</html>
