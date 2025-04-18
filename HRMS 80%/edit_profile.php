<?php
session_start();
include '../config/db.php';

if ($_SESSION['user']['role'] !== 'patient') {
    header("Location: ../auth/login.php");
    exit();
}

$patient_id = $_SESSION['user']['id'];
$success = false;
$message = '';

$query = $conn->query("SELECT * FROM users WHERE id = '$patient_id'");
$user = $query->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $age = $_POST['age'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $profile_picture = $user['profile_picture'];

    if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
        $filename = uniqid() . '.' . $ext;
        $target = '../uploads/' . $filename;

        if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $target)) {
            $profile_picture = $filename;
        }
    }

    $hashedPassword = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : $user['password'];

    $update = $conn->query("UPDATE users SET 
        name='$name', 
        email='$email', 
        age='$age', 
        contact='$contact', 
        profile_picture='$profile_picture', 
        password='$hashedPassword' 
        WHERE id='$patient_id'");

    if ($update) {
        $success = true;
        $message = "✅ Profile updated successfully!";
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['email'] = $email;
    } else {
        $message = "❌ Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Profile</h2>

    <?php if ($message): ?>
        <div class="alert alert-<?php echo $success ? 'success' : 'danger'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" class="bg-light p-4 rounded shadow-sm">
        <div class="mb-3">
            <?php if (!empty($user['profile_picture'])): ?>
                <img src="../uploads/<?php echo $user['profile_picture']; ?>" alt="Profile Picture" width="100" class="mb-2 rounded">
            <?php endif; ?>
            <label class="form-label">Profile Picture</label>
            <input type="file" name="profile_picture" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Age</label>
            <input type="number" name="age" value="<?php echo $user['age'] ?? ''; ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Contact Number</label>
            <input type="text" name="contact" value="<?php echo $user['contact'] ?? ''; ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">New Password (leave blank to keep current)</label>
            <input type="password" name="password" class="form-control">
        </div>

        <button type="submit" class="btn btn-primary">Update Profile</button>
        <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
    </form>
</div>
</body>
</html>
