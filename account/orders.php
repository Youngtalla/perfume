<?php 
require_once '../includes/functions.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php"); exit;
}

$user_id = $_SESSION['user_id'];

// Fetch customer's orders
$stmt = $pdo->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY id DESC");
$stmt->execute([$user_id]);
$orders = $stmt->fetchAll();
?>

<?php include '../includes/header.php'; ?>

<div class="container py-5 mt-5">
    <h2 class="text-gold mb-4">My Orders</h2>

    <?php if(empty($orders)): ?>
        <div class="alert alert-info text-center py-5">
            You haven't placed any orders yet. <a href="../shop.php">Start Shopping</a>
        </div>
    <?php else: ?>
        <?php foreach($orders as $order): ?>
            <div class="card glass mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h5>Order #<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></h5>
                    <span class="badge bg-<?= $order['status']=='delivered' ? 'success' : ($order['status']=='shipped' ? 'info' : 'warning') ?>">
                        <?= ucfirst($order['status']) ?>
                    </span>
                </div>
                <div class="card-body">
                    <p><strong>Date:</strong> <?= $order['created_at'] ?></p>
                    <p><strong>Total:</strong> TZS <?= number_format($order['total']) ?></p>
                    
                    <!-- Show items -->
                    <strong>Items:</strong>
                    <ul>
                        <?php
                        $items = $pdo->prepare("SELECT p.name, oi.quantity FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
                        $items->execute([$order['id']]);
                        foreach($items as $item):
                        ?>
                            <li><?= htmlspecialchars($item['name']) ?> × <?= $item['quantity'] ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>