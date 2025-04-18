<link rel="stylesheet" href="../includes/style.css">

<?php
session_start();
if ($_SESSION['user']['role'] != 'patient') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] != 'patient') {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Patient Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4 text-success">Welcome, <?php echo $_SESSION['user']['name']; ?></h2>

        <div class="row g-4">
            <div class="col-md-4">
            <a href="book_appointment.php" class="btn btn-outline-success w-100 py-3">Book Appointment</a>

            </div>
            <div class="col-md-4">
                <a href="medical_records.php" class="btn btn-outline-success w-100 py-3">View Medical Records</a>
            </div>
            <div class="col-md-4">
                <a href="billing.php" class="btn btn-outline-success w-100 py-3">View Billing</a>
            </div>
        </div>

        <div class="mt-4">
            <a href="edit_profile.php" class="btn btn-secondary me-2">Edit Profile</a>
            <a href="../auth/logout.php" class="btn btn-danger">Logout</a>
        </div>
    </div>
</body>
</html>

