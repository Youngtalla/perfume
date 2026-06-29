<?php 
require_once '../includes/functions.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php"); exit;
}

$user_id = $_SESSION['user_id'];
$message = '';

if($_POST) {
    $name = sanitize($_POST['name']);
    $phone = sanitize($_POST['phone']);
    $address = sanitize($_POST['address']);

    $stmt = $pdo->prepare("UPDATE users SET name=?, phone=?, address=? WHERE id=?");
    $stmt->execute([$name, $phone, $address, $user_id]);
    $message = "Profile updated successfully!";
    $_SESSION['user_name'] = $name;
}

$user = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$user->execute([$user_id]);
$user = $user->fetch();
?>

<?php include '../includes/header.php'; ?>

<div class="container py-5 mt-5">
    <h2 class="text-gold">My Profile</h2>

    <?php if($message) echo "<div class='alert alert-success'>$message</div>"; ?>

    <div class="card glass p-4" style="max-width:600px;">
        <form method="POST">
            <div class="mb-3">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($user['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label>Phone Number</label>
                <input type="tel" name="phone" class="form-control" value="<?= htmlspecialchars($user['phone']) ?>" required>
            </div>
            <div class="mb-4">
                <label>Delivery Address</label>
                <textarea name="address" class="form-control" rows="3"><?= htmlspecialchars($user['address'] ?? '') ?></textarea>
            </div>
            <button type="submit" class="btn btn-gold">Save Changes</button>
        </form>
    </div>
</div>

<?php include '../includes/footer.php'; ?>