<?php 
session_start();
include '../config/db.php';

if ($_SESSION['user']['role'] != 'patient') {
    header("Location: ../auth/login.php");
    exit();
}

$success = false;
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_SESSION['user']['id'];
    $doctor = $_POST['doctor'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $reason = $_POST['reason'];

    $sql = "INSERT INTO appointments (patient_id, doctor_name, date, time, reason)
            VALUES ('$patient_id', '$doctor', '$date', '$time', '$reason')";
    if ($conn->query($sql)) {
        $success = true;
        $message = "✅ Appointment booked successfully! Redirecting to dashboard...";
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php if ($success): ?>
    <meta http-equiv="refresh" content="3;url=dashboard.php">
    <?php endif; ?>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Book Appointment</h2>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if (!$success): ?>
        <form method="POST" class="bg-light p-4 rounded shadow-sm">
            <div class="mb-3">
                <label class="form-label">Doctor's Name</label>
                <input type="text" name="doctor" class="form-control" placeholder="Enter Doctor's Name" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Appointment Date</label>
                <input type="date" name="date" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Appointment Time</label>
                <input type="time" name="time" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Reason for Appointment</label>
                <textarea name="reason" class="form-control" rows="3" placeholder="Describe your reason" required></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Book Appointment</button>
            <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
