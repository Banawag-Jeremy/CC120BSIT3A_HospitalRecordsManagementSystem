<?php include '../includes/auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Appointment</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<div class="container">

<h3>Book Appointment</h3>
<form method="post">
    <input type="text" name="patient_name" placeholder="Patient Name" required />
    <input type="text" name="doctor" placeholder="Doctor Name" required />
    <input type="date" name="date" required />
    <button name="book">Book</button>
</form>
<?php
if (isset($_POST['book'])) {
    include '../includes/db.php';
    $patient_name = $_POST['patient_name'];
    $doctor = $_POST['doctor'];
    $date = $_POST['date'];

    $query = "INSERT INTO appointments (patient_name, doctor, date) VALUES ('$patient_name', '$doctor', '$date')";
    mysqli_query($conn, $query);
    echo "<p>Appointment booked successfully.</p>";
}
?>

</div>
</body>
</html>