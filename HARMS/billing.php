<?php include '../includes/auth.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Billing</title>
    <link rel="stylesheet" type="text/css" href="../style.css">
</head>
<body>
<div class="container">

<h3>Billing</h3>
<form method="post">
    <input type="text" name="patient" placeholder="Patient Name" required />
    <input type="number" name="amount" placeholder="Amount" required />
    <button name="submit">Submit</button>
</form>
<?php
if (isset($_POST['submit'])) {
    include '../includes/db.php';
    $patient = $_POST['patient'];
    $amount = $_POST['amount'];

    mysqli_query($conn, "INSERT INTO bills (patient, amount) VALUES ('$patient', '$amount')");
    echo "<p>Bill recorded!</p>";
}
?>

</div>
</body>
</html>