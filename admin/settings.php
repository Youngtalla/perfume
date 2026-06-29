<?php 
require_once '../includes/functions.php';
if(!isAdmin()) { header("Location: login.php"); exit; }
require_once '../includes/db.php';

$message = '';

// Handle form submission
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $settings = [
        'whatsapp_number' => sanitize($_POST['whatsapp_number']),
        'store_email'      => sanitize($_POST['store_email']),
        'store_phone'      => sanitize($_POST['store_phone']),
        'store_address'    => sanitize($_POST['store_address']),
        'store_name'       => sanitize($_POST['store_name']),
        'slogan'           => sanitize($_POST['slogan'])
    ];

    foreach($settings as $key => $value) {
        $stmt = $pdo->prepare("INSERT INTO settings (setting_key, setting_value) 
                              VALUES (?, ?) 
                              ON DUPLICATE KEY UPDATE setting_value = ?");
        $stmt->execute([$key, $value, $value]);
    }
    
    $message = "✅ Settings updated successfully!";
}

// Fetch current settings
$settings = [];
$stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
while($row = $stmt->fetch()) {
    $settings[$row['setting_key']] = $row['setting_value'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Settings - Mouhdy Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="fas fa-cog"></i> Website Settings</h2>
        <a href="index.php" class="btn btn-outline-light">← Back to Dashboard</a>
    </div>

    <?php if($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <form method="POST" class="card glass p-4">
        <div class="row">
            <!-- General Info -->
            <div class="col-lg-6">
                <h5 class="text-gold mb-3">Store Information</h5>
                
                <div class="mb-3">
                    <label>Store Name</label>
                    <input type="text" name="store_name" class="form-control" value="<?= htmlspecialchars($settings['store_name'] ?? 'Mouhdy Perfumes Store') ?>">
                </div>

                <div class="mb-3">
                    <label>Slogan</label>
                    <input type="text" name="slogan" class="form-control" value="<?= htmlspecialchars($settings['slogan'] ?? 'Beautiful Mind Smell Good') ?>">
                </div>

                <div class="mb-3">
                    <label>Store Email</label>
                    <input type="email" name="store_email" class="form-control" value="<?= htmlspecialchars($settings['store_email'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label>Store Phone</label>
                    <input type="text" name="store_phone" class="form-control" value="<?= htmlspecialchars($settings['store_phone'] ?? '') ?>">
                </div>

                <div class="mb-3">
                    <label>Physical Address</label>
                    <textarea name="store_address" class="form-control" rows="3"><?= htmlspecialchars($settings['store_address'] ?? '') ?></textarea>
                </div>
            </div>

            <!-- WhatsApp & Social -->
            <div class="col-lg-6">
                <h5 class="text-gold mb-3">WhatsApp & Contact</h5>
                
                <div class="mb-3">
                    <label class="form-label">WhatsApp Number <small>(with country code, e.g. 255712345678)</small></label>
                    <div class="input-group">
                        <span class="input-group-text">🇹🇿</span>
                        <input type="text" name="whatsapp_number" class="form-control" value="<?= htmlspecialchars($settings['whatsapp_number'] ?? '255712345678') ?>" required>
                    </div>
                </div>

                <div class="alert alert-info">
                    <strong>Important:</strong> This number will be used across the entire website for all "Order via WhatsApp" buttons.
                </div>
            </div>
        </div>

        <hr>
        <button type="submit" class="btn btn-gold btn-lg px-5">Save All Settings</button>
    </form>
</div>
</body>
</html>