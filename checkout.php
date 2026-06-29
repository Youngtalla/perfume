<?php 
require_once 'includes/functions.php'; 
$page_title = "Checkout";

if(!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit;
}

$total = 0;
$ids = array_keys($_SESSION['cart']);

if(!empty($ids)) {
    $placeholders = str_repeat('?,', count($ids)-1) . '?';

    $stmt = $pdo->prepare("SELECT id, name, price FROM products WHERE id IN ($placeholders)");
    $stmt->execute($ids);

    $products = $stmt->fetchAll();

    foreach($products as $p) {
        $total += $p['price'] * $_SESSION['cart'][$p['id']];
    }
}
?>

<?php include 'includes/header.php'; ?>
<style>
    /* =========================
   CHECKOUT HEADER (BRIGHT LUXURY)
========================= */

.checkout-header {
    padding: 120px 0 60px;
    background: linear-gradient(135deg, #111 0%, #1a1a1a 50%, #111 100%);
    text-align: center;
    border-bottom: 1px solid rgba(212,175,55,.2);
}

.checkout-header h1 {
    font-family: 'Cinzel', serif;
    color: #D4AF37;
    font-size: 3.2rem;
    letter-spacing: 1px;
}

.checkout-header p {
    color: #ccc;
    font-size: 1.1rem;
}

/* =========================
   LAYOUT BACKGROUND
========================= */

body {
    background: #0d0d0d;
}

/* =========================
   MAIN CARDS (LIGHT GLASS STYLE)
========================= */

.checkout-card,
.checkout-summary {
    background: #ffffff;
    border-radius: 18px;
    padding: 30px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    border: 1px solid rgba(212,175,55,.2);
}

/* =========================
   SECTION HEADINGS
========================= */

.section-heading {
    color: #111;
    font-family: 'Cinzel', serif;
    margin-bottom: 20px;
    font-size: 1.3rem;
}

.section-heading i {
    color: #D4AF37;
    margin-right: 8px;
}

/* =========================
   INPUT FIELDS (CLEAN & READABLE)
========================= */

.luxury-input {
    background: #f8f8f8;
    border: 1px solid #ddd;
    padding: 14px;
    border-radius: 10px;
    color: #111;
    transition: .3s;
}

.luxury-input:focus {
    border-color: #D4AF37;
    box-shadow: 0 0 0 3px rgba(212,175,55,.2);
    outline: none;
}

.luxury-input::placeholder {
    color: #888;
}

/* =========================
   PAYMENT OPTIONS (VISIBLE CARDS)
========================= */

.payment-options {
    display: grid;
    gap: 12px;
}

.payment-card {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #f7f7f7;
    border: 1px solid #ddd;
    border-radius: 12px;
    padding: 15px;
    cursor: pointer;
    transition: .3s;
    color: #111;
    font-weight: 500;
}

.payment-card:hover {
    border-color: #D4AF37;
    background: #fff;
    transform: translateY(-2px);
}

.payment-card input {
    accent-color: #D4AF37;
}

/* =========================
   ORDER SUMMARY (GOLD ACCENT)
========================= */

.checkout-summary h4 {
    font-family: 'Cinzel', serif;
    color: #111;
    margin-bottom: 15px;
}

.summary-item {
    display: flex;
    justify-content: space-between;
    margin-bottom: 10px;
    color: #444;
    font-size: 0.95rem;
}

.summary-total {
    display: flex;
    justify-content: space-between;
    font-size: 1.4rem;
    font-weight: bold;
    color: #D4AF37;
}

/* =========================
   BUTTONS
========================= */

.btn-gold {
    background: #D4AF37;
    color: #111;
    font-weight: bold;
    border-radius: 12px;
    border: none;
    transition: .3s;
}

.btn-gold:hover {
    transform: translateY(-2px);
    box-shadow: 0 10px 20px rgba(212,175,55,.25);
}

/* =========================
   RESPONSIVE
========================= */

@media(max-width:768px){
    .checkout-header h1 {
        font-size: 2.3rem;
    }
}
</style>

<!-- CHECKOUT HERO -->
<div class="checkout-header">
    <div class="container text-center">
        <h1>Secure Checkout</h1>
        <p>Complete your luxury fragrance order</p>
    </div>
</div>

<div class="container py-5">

    <div class="row g-4">

        <!-- CUSTOMER INFO -->
        <div class="col-lg-7">

            <div class="checkout-card">

                <h4 class="section-heading">
                    <i class="fas fa-user"></i>
                    Shipping Information
                </h4>

                <form action="process_order.php" method="POST">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <input type="text"
                                   name="name"
                                   class="form-control luxury-input"
                                   placeholder="Full Name"
                                   required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <input type="tel"
                                   name="phone"
                                   class="form-control luxury-input"
                                   placeholder="Phone Number"
                                   required>
                        </div>
                    </div>

                    <textarea
                        name="address"
                        rows="4"
                        class="form-control luxury-input mb-4"
                        placeholder="Full Delivery Address"
                        required></textarea>

                    <h4 class="section-heading">
                        <i class="fas fa-credit-card"></i>
                        Payment Method
                    </h4>

                    <div class="payment-options">

                        <label class="payment-card">
                            <input type="radio"
                                   name="payment_method"
                                   value="mpesa"
                                   checked>
                            <span>M-Pesa</span>
                        </label>

                        <label class="payment-card">
                            <input type="radio"
                                   name="payment_method"
                                   value="tigopesa">
                            <span>Tigo Pesa</span>
                        </label>

                        <label class="payment-card">
                            <input type="radio"
                                   name="payment_method"
                                   value="airtel">
                            <span>Airtel Money</span>
                        </label>

                        <label class="payment-card">
                            <input type="radio"
                                   name="payment_method"
                                   value="cash">
                            <span>Cash on Delivery</span>
                        </label>

                    </div>

                    <button type="submit" class="btn btn-gold w-100 py-3 mt-4">
                        Place Order
                    </button>

                </form>

            </div>

        </div>

        <!-- ORDER SUMMARY -->
        <div class="col-lg-5">

            <div class="checkout-summary">

                <h4>Order Summary</h4>

                <hr>

                <?php foreach($products as $p): ?>
                    <div class="summary-item">
                        <span>
                            <?= htmlspecialchars($p['name']) ?>
                            × <?= $_SESSION['cart'][$p['id']] ?>
                        </span>

                        <span>
                            TZS <?= number_format($p['price'] * $_SESSION['cart'][$p['id']]) ?>
                        </span>
                    </div>
                <?php endforeach; ?>

                <hr>

                <div class="summary-total">
                    <span>Total</span>
                    <strong>
                        TZS <?= number_format($total) ?>
                    </strong>
                </div>

            </div>

        </div>

    </div>

</div>

<?php include 'includes/footer.php'; ?>