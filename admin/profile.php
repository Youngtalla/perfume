<?php 
require_once '../includes/functions.php';
if(!isAdmin()) { header("Location: login.php"); exit; }
require_once '../includes/db.php';

$message = '';

if($_POST) {
    $old_pass = $_POST['old_password'];
    $new_pass = $_POST['new_password'];
    $confirm  = $_POST['confirm_password'];

    $stmt = $pdo->prepare("SELECT password FROM admins WHERE id = ?");
    $stmt->execute([$_SESSION['admin_id']]);
    $admin = $stmt->fetch();

    if(password_verify($old_pass, $admin['password'])) {
        if($new_pass === $confirm) {
            $hash = password_hash($new_pass, PASSWORD_DEFAULT);
            $pdo->prepare("UPDATE admins SET password = ? WHERE id = ?")
                ->execute([$hash, $_SESSION['admin_id']]);
            $message = "✅ Password changed successfully!";
        } else {
            $message = "❌ New passwords do not match!";
        }
    } else {
        $message = "❌ Incorrect old password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile - Mouhdy</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container py-5">
    <h2>Admin Profile</h2>
    <br>
     <a href="index.php" class="btn btn-outline-light">← Back to Dashboard</a>
     <br><br>
    <?php if($message) echo "<div class='alert alert-info'>$message</div>"; ?>

    <div class="card glass p-4" style="max-width:500px;">
        <form method="POST">
            <div class="mb-3">
                <label>Old Password</label>
                <input type="password" name="old_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-gold">Change Password</button>
        </form>
    </div>
</div>
</body>
</html>