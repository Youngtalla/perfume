<?php 
require_once 'includes/functions.php'; 
$page_title = "My Cart";

/* =========================
   CART SETUP
========================= */
if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

/* REMOVE ITEM */
if(isset($_GET['remove'])) {
    unset($_SESSION['cart'][$_GET['remove']]);
    header("Location: cart.php");
    exit;
}

/* =========================
   CART ITEMS
========================= */
$cart_items = [];
$total = 0;

if(!empty($_SESSION['cart'])) {
    $ids = array_keys($_SESSION['cart']);
    $placeholders = str_repeat('?,', count($ids)-1) . '?';

    $stmt = $pdo->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach($products as $p) {
        $qty = $_SESSION['cart'][$p['id']];
        $subtotal = $p['price'] * $qty;

        $cart_items[] = [
            'id' => $p['id'],
            'name' => $p['name'],
            'price' => $p['price'],
            'image' => $p['image'],
            'qty' => $qty,
            'subtotal' => $subtotal
        ];

        $total += $subtotal;
    }
}

/* =========================
   ORDER TRACKING (BY PHONE)
========================= */
if(isset($_POST['track_phone'])) {
    $_SESSION['track_phone'] = sanitize($_POST['track_phone']);
    header("Location: cart.php");
    exit;
}

$orders = [];

if(isset($_SESSION['track_phone']) && !empty($_SESSION['track_phone'])) {
    $stmt = $pdo->prepare("SELECT * FROM orders WHERE phone = ? ORDER BY id DESC");
    $stmt->execute([$_SESSION['track_phone']]);
    $orders = $stmt->fetchAll();
}
?>

<?php include 'includes/header.php'; ?>
<style>
    
<style>
    /* =========================
   CART HEADER
========================= */

.cart-header {
    padding: 120px 0 60px;
    background: linear-gradient(rgba(0,0,0,.8), rgba(0,0,0,.9)),
    url('../images/cart-bg.jpg') center/cover;
    text-align: center;
}

.cart-header h1 {
    font-family: 'Cinzel', serif;
    color: #D4AF37;
    font-size: 3.5rem;
}

.cart-header p {
    color: #ccc;
}

/* =========================
   CART TITLE
========================= */

.cart-title {
    color: #D4AF37;
    font-family: 'Cinzel', serif;
    margin-bottom: 30px;
}

/* =========================
   EMPTY CART
========================= */

.empty-cart {
    text-align: center;
    padding: 80px 20px;
    background: #141414;
    border-radius: 20px;
    border: 1px solid rgba(212,175,55,.2);
}

.empty-cart i {
    font-size: 4rem;
    color: #D4AF37;
    margin-bottom: 20px;
}

/* =========================
   CART ITEM
========================= */

.cart-item {
    display: flex;
    align-items: center;
    gap: 20px;
    background: #141414;
    border: 1px solid rgba(212,175,55,.15);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 15px;
    transition: .3s;
}

.cart-item:hover {
    transform: translateY(-5px);
    border-color: #D4AF37;
}

.cart-item img {
    width: 90px;
    height: 90px;
    object-fit: cover;
    border-radius: 10px;
}

.cart-details {
    flex: 1;
}

.cart-details h5 {
    color: white;
    margin: 0;
}

.cart-details p {
    color: #aaa;
    margin: 5px 0 0;
}

.cart-right {
    text-align: right;
}

.cart-right h5 {
    color: #D4AF37;
}

/* REMOVE BUTTON */

.remove-btn {
    color: #ff4d4d;
    font-size: 0.9rem;
    text-decoration: none;
}

.remove-btn:hover {
    text-decoration: underline;
}

/* =========================
   CART SUMMARY
========================= */

.cart-summary {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(212,175,55,.2);
    padding: 25px;
    border-radius: 20px;
    position: sticky;
    top: 100px;
}

.cart-summary h5 {
    color: #D4AF37;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    margin-top: 10px;
    color: white;
}

/* =========================
   BUTTONS
========================= */

.btn-gold {
    background: #D4AF37;
    color: #000;
    font-weight: bold;
    border-radius: 10px;
}

.btn-gold:hover {
    transform: translateY(-3px);
}

.btn-outline-light {
    border: 1px solid #ccc;
    color: #ccc;
}

.btn-outline-light:hover {
    background: #fff;
    color: #000;
}

/* =========================
   ORDER TRACKING BOX (REFINED)
========================= */

.orders-box {
    background: #141414;
    padding: 25px;
    border-radius: 18px;
    border: 1px solid rgba(212,175,55,.15);
}

/* TITLE */
.section-title {
    color: #D4AF37;
    font-family: 'Cinzel', serif;
    margin-bottom: 20px;
}

/* =========================
   ORDER CARD (IMPROVED LOOK)
========================= */

.order-card-track {
    background: linear-gradient(145deg, #1a1a1a, #111);
    border: 1px solid rgba(255,255,255,.05);
    border-left: 4px solid #D4AF37;
    padding: 18px;
    border-radius: 14px;
    margin-bottom: 15px;
    transition: all 0.25s ease;
}

.order-card-track:hover {
    transform: translateY(-4px);
    border-color: rgba(212,175,55,.4);
    box-shadow: 0 10px 25px rgba(0,0,0,.4);
}

/* =========================
   ORDER HEADER ROW
========================= */

.order-card-track h5 {
    margin: 0;
    color: #fff;
    font-size: 1rem;
}

.order-card-track p {
    margin: 5px 0;
    color: #bbb;
    font-size: 0.9rem;
}

/* =========================
   STATUS BADGE (BETTER LOOK)
========================= */

.status-badge {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: bold;
    letter-spacing: 0.3px;
}

/* STATUS COLORS */
.status-badge.pending {
    background: #ff9800;
    color: #111;
}

.status-badge.processing {
    background: #ffc107;
    color: #111;
}

.status-badge.shipped {
    background: #2196f3;
    color: #fff;
}

.status-badge.delivered {
    background: #2ecc71;
    color: #111;
}

/* =========================
   DETAILS DROPDOWN
========================= */

.order-card-track details {
    margin-top: 10px;
    color: #ccc;
    cursor: pointer;
}

.order-card-track summary {
    color: #D4AF37;
    font-weight: 500;
    outline: none;
}

.order-card-track ul {
    margin-top: 10px;
    padding-left: 18px;
}

.order-card-track li {
    color: #ddd;
    font-size: 0.9rem;
    margin-bottom: 4px;
}

/* =========================
   TRACK INPUT CLEANUP
========================= */

.orders-box input {
    background: #0d0d0d;
    border: 1px solid rgba(212,175,55,.2);
    color: white;
    padding: 12px;
    border-radius: 10px;
}

.orders-box input:focus {
    border-color: #D4AF37;
    box-shadow: 0 0 0 3px rgba(212,175,55,.15);
    outline: none;
}
</style>



<!-- =========================
   CART HEADER
========================= -->
<div class="cart-header">
    <div class="container text-center">
        <h1>Your Luxury Cart</h1>
        <p>Manage your order & track deliveries</p>
    </div>
</div>

<div class="container py-5">

<!-- =========================
   CART SECTION
========================= -->

<h2 class="cart-title">🛒 Shopping Bag (<?= count($cart_items) ?> items)</h2>

<?php if(empty($cart_items)): ?>

    <div class="empty-cart">
        <i class="fas fa-shopping-bag"></i>
        <h3>Your cart is empty</h3>
        <p>Explore our luxury perfumes and add your signature scent.</p>
        <a href="shop.php" class="btn btn-gold mt-3">Browse Collection</a>
    </div>

<?php else: ?>

<div class="row g-4">

    <!-- CART ITEMS -->
    <div class="col-lg-8">

        <?php foreach($cart_items as $item): ?>
        <div class="cart-item">

            <img src="uploads/<?=htmlspecialchars($item['image'])?>"
                 alt="<?=htmlspecialchars($item['name'])?>">

            <div class="cart-details">
                <h5><?=htmlspecialchars($item['name'])?></h5>
                <p>TZS <?=number_format($item['price'])?> × <?= $item['qty'] ?></p>
            </div>

            <div class="cart-right">
                <h5>TZS <?=number_format($item['subtotal'])?></h5>

                <a href="cart.php?remove=<?= $item['id'] ?>" class="remove-btn">
                    Remove
                </a>
            </div>

        </div>
        <?php endforeach; ?>

    </div>

    <!-- SUMMARY -->
    <div class="col-lg-4">

        <div class="cart-summary">
            <h5>Order Summary</h5>

            <hr>

            <div class="summary-row">
                <span>Total</span>
                <strong>TZS <?=number_format($total)?></strong>
            </div>

            <a href="checkout.php" class="btn btn-gold w-100 mt-3 py-3">
                Proceed to Checkout
            </a>

            <a href="shop.php" class="btn btn-outline-light w-100 mt-2">
                Continue Shopping
            </a>
        </div>

    </div>

</div>

<?php endif; ?>

<!-- =========================
   ORDER TRACKING SECTION
========================= -->

<div class="orders-box mt-5">

    <h3 class="section-title">📦 Track Your Orders</h3>

    <form method="POST" class="mb-4">
        <input type="text"
               name="track_phone"
               class="form-control mb-2"
               placeholder="Enter your phone number to track orders"
               required>

        <button class="btn btn-gold w-100">
            Track Orders
        </button>
    </form>

    <?php if(!empty($orders)): ?>

        <?php foreach($orders as $o): ?>

            <div class="order-card-track">

                <div class="d-flex justify-content-between">
                    <h5>#<?= str_pad($o['id'], 5, '0', STR_PAD_LEFT) ?></h5>

                    <span class="status-badge <?= $o['status'] ?>">
                        <?= ucfirst($o['status']) ?>
                    </span>
                </div>

                <p><strong>Total:</strong> TZS <?= number_format($o['total']) ?></p>
                <p><strong>Date:</strong> <?= $o['created_at'] ?></p>

                <details>
                    <summary>View Order Details</summary>

                    <ul class="mt-2">
                        <?php
                        $items = $pdo->prepare("
                            SELECT oi.quantity, p.name 
                            FROM order_items oi
                            JOIN products p ON p.id = oi.product_id
                            WHERE oi.order_id = ?
                        ");
                        $items->execute([$o['id']]);

                        foreach($items as $i):
                        ?>
                            <li><?= $i['name'] ?> × <?= $i['quantity'] ?></li>
                        <?php endforeach; ?>
                    </ul>

                </details>

            </div>

        <?php endforeach; ?>

    <?php elseif(isset($_SESSION['track_phone'])): ?>

        <p class="text-muted">No orders found for this phone number.</p>

    <?php endif; ?>

</div>

</div>

<?php include 'includes/footer.php'; ?>