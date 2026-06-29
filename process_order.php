<?php 
require_once 'includes/functions.php';

if($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$name    = sanitize($_POST['name'] ?? '');
$phone   = sanitize($_POST['phone'] ?? '');
$address = sanitize($_POST['address'] ?? '');

if(empty($name) || empty($phone) || empty($address)) {
    die("Please fill all required fields.");
}

/* =========================
   CALCULATE TOTAL
========================= */
$total = 0;
$ids = array_keys($_SESSION['cart']);

$placeholders = str_repeat('?,', count($ids)-1) . '?';
$stmt = $pdo->prepare("SELECT id, price FROM products WHERE id IN ($placeholders)");
$stmt->execute($ids);
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach($products as $p) {
    $total += $p['price'] * $_SESSION['cart'][$p['id']];
}

/* =========================
   CREATE ORDER (STANDARDIZED)
========================= */
$stmt = $pdo->prepare("
    INSERT INTO orders 
    (customer_name, phone, address, total, status, created_at) 
    VALUES (?, ?, ?, ?, 'pending', NOW())
");

$stmt->execute([$name, $phone, $address, $total]);

$order_id = $pdo->lastInsertId();

/* =========================
   ORDER ITEMS
========================= */
foreach($_SESSION['cart'] as $product_id => $qty) {
    $stmt = $pdo->prepare("
        INSERT INTO order_items (order_id, product_id, quantity)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$order_id, $product_id, $qty]);
}

/* =========================
   CLEAR CART
========================= */
unset($_SESSION['cart']);
?>

<?php include 'includes/header.php'; ?>
<style>
    /* =========================
   ORDER SUCCESS PAGE
========================= */

.order-success {
    min-height: 70vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #0d0d0d;
    padding: 40px;
}

.success-card {
    background: #141414;
    border: 1px solid rgba(212,175,55,.2);
    padding: 40px;
    border-radius: 20px;
    text-align: center;
    max-width: 500px;
    width: 100%;
    color: white;
}

.success-card .icon {
    font-size: 4rem;
    margin-bottom: 10px;
}

.success-card h1 {
    color: #D4AF37;
    font-family: 'Cinzel', serif;
}

.order-id {
    margin-top: 15px;
    font-size: 1.1rem;
    color: #ccc;
}

.status-badge {
    display: inline-block;
    margin-top: 15px;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: .85rem;
}

.status-badge.pending {
    background: #ff9800;
    color: black;
}
</style>

<div class="order-success">
    <div class="success-card">
        <div class="icon">🎉</div>

        <h1>Order Confirmed</h1>

        <p>Your order has been placed successfully.</p>

        <div class="order-id">
            Order ID: #<?= str_pad($order_id, 5, '0', STR_PAD_LEFT) ?>
        </div>

        <span class="status-badge pending">Status: Pending</span>

        <a href="shop.php" class="btn btn-gold mt-4">
            Continue Shopping
        </a>
    </div>
</div>

<?php include 'includes/footer.php'; ?>