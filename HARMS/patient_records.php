<?php include '../includes/auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Patient Records</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<div class="container">

<h3>Patient Appointments</h3>
<?php
include '../includes/db.php';
$result = mysqli_query($conn, "SELECT * FROM appointments");

echo "<table><tr><th>Name</th><th>Doctor</th><th>Date</th></tr>";
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr><td>{$row['patient_name']}</td><td>{$row['doctor']}</td><td>{$row['date']}</td></tr>";
}
echo "</table>";
?>

</div>
</body>
</html>