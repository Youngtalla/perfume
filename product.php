<?php 
require_once 'includes/functions.php'; 
$page_title = "Product Details";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$id]);
$product = $stmt->fetch();

if(!$product) {
    header("Location: shop.php"); 
    exit;
}

// ADD TO CART
if($_POST && isset($_POST['add_to_cart'])) {
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

    if(isset($_SESSION['cart'][$product['id']])) {
        $_SESSION['cart'][$product['id']] += $quantity;
    } else {
        $_SESSION['cart'][$product['id']] = $quantity;
    }

    // OPTIONAL: store message
    $_SESSION['success'] = $product['name'] . " added to cart!";

    // REDIRECT TO CART PAGE
    header("Location: cart.php");
    exit;
}
// ADD REVIEW
if($_POST && isset($_POST['add_review'])) {
    $name = sanitize($_POST['name']);
    $rating = (int)$_POST['rating'];
    $comment = sanitize($_POST['comment']);

    $stmt = $pdo->prepare("INSERT INTO reviews (product_id, name, rating, comment) VALUES (?, ?, ?, ?)");
    $stmt->execute([$product['id'], $name, $rating, $comment]);

    $review_success = "Thank you for your review!";
}

// REVIEWS
$reviews = $pdo->prepare("SELECT * FROM reviews WHERE product_id = ? ORDER BY created_at DESC");
$reviews->execute([$product['id']]);
?>

<?php include 'includes/header.php'; ?>

<style>
    /* =========================
   PRODUCT HERO
========================= */

.product-hero {
    background: #0D0D0D;
    padding-bottom: 60px;
}

.product-image-box {
    background: #141414;
    border-radius: 20px;
    padding: 20px;
    border: 1px solid rgba(212,175,55,.2);
}

.product-image-box img {
    width: 100%;
    border-radius: 15px;
    object-fit: cover;
}

/* =========================
   PRODUCT INFO CARD
========================= */

.product-info-card {
    background: rgba(255,255,255,0.03);
    border: 1px solid rgba(212,175,55,.2);
    border-radius: 20px;
    padding: 30px;
    backdrop-filter: blur(10px);
}

.product-info-card h1 {
    font-family: 'Cinzel', serif;
    color: #D4AF37;
    margin-bottom: 10px;
}

.price {
    font-size: 1.8rem;
    color: #D4AF37;
    font-weight: bold;
    margin-bottom: 15px;
}

.description {
    color: #ccc;
    margin-bottom: 20px;
}

.badge-luxury {
    background: #D4AF37;
    color: #000;
    padding: 5px 12px;
    border-radius: 20px;
    font-size: .8rem;
    display: inline-block;
    margin-bottom: 10px;
}

/* =========================
   NOTES BOX
========================= */

.notes-box {
    background: #141414;
    padding: 15px;
    border-radius: 15px;
    margin-bottom: 20px;
    color: #ccc;
    border: 1px solid rgba(212,175,55,.15);
}

.notes-box div {
    margin-bottom: 5px;
}

/* =========================
   CART
========================= */

.cart-box {
    display: flex;
    gap: 10px;
    margin-bottom: 15px;
}

.cart-box input {
    width: 80px;
    padding: 10px;
    background: #141414;
    border: 1px solid rgba(212,175,55,.2);
    color: white;
    border-radius: 10px;
}

.cart-box button {
    flex: 1;
    background: #D4AF37;
    border: none;
    color: black;
    font-weight: bold;
    border-radius: 10px;
    transition: .3s;
}

.cart-box button:hover {
    transform: translateY(-3px);
}

/* =========================
   BUTTONS
========================= */

.btn-whatsapp {
    display: block;
    background: #25D366;
    color: white;
    text-align: center;
    padding: 12px;
    border-radius: 10px;
    margin-top: 10px;
    text-decoration: none;
}

.btn-wishlist {
    display: block;
    border: 1px solid #D4AF37;
    color: #D4AF37;
    text-align: center;
    padding: 12px;
    border-radius: 10px;
    margin-top: 10px;
    text-decoration: none;
}

/* =========================
   REVIEWS
========================= */

.section-title {
    color: #D4AF37;
    font-family: 'Cinzel', serif;
    margin-bottom: 30px;
}

.review-card {
    background: #141414;
    border: 1px solid rgba(212,175,55,.15);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 15px;
}

.review-header {
    display: flex;
    justify-content: space-between;
    color: white;
}

.stars {
    color: gold;
}

.review-form {
    margin-top: 40px;
    background: rgba(255,255,255,0.03);
    padding: 25px;
    border-radius: 20px;
    border: 1px solid rgba(212,175,55,.15);
}

.review-form input,
.review-form select,
.review-form textarea {
    width: 100%;
    margin-bottom: 10px;
    padding: 10px;
    background: #141414;
    border: 1px solid rgba(212,175,55,.2);
    color: white;
    border-radius: 10px;
}

.review-form button {
    background: #D4AF37;
    border: none;
    padding: 12px 20px;
    font-weight: bold;
    border-radius: 10px;
}
</style>

<!-- ================= HERO PRODUCT SECTION ================= -->
<div class="product-hero">
    <div class="container py-5 mt-5">
        <?php if(isset($success)): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>

        <div class="row g-5 align-items-center">

            <!-- IMAGE -->
            <div class="col-lg-6">
                <div class="product-image-box">
                    <img src="uploads/<?=htmlspecialchars($product['image'])?>"
                         alt="<?=htmlspecialchars($product['name'])?>">
                </div>
            </div>

            <!-- INFO -->
            <div class="col-lg-6">
                <div class="product-info-card">

                    <span class="badge-luxury">Luxury Perfume</span>

                    <h1><?=htmlspecialchars($product['name'])?></h1>

                    <div class="price">
                        TZS <?=number_format($product['price'])?>
                    </div>

                    <p class="description">
                        <?=nl2br(htmlspecialchars($product['description']))?>
                    </p>

                    <!-- NOTES -->
                    <div class="notes-box">
                        <div><strong>Top:</strong> <?=htmlspecialchars($product['top_notes'] ?? '-')?></div>
                        <div><strong>Middle:</strong> <?=htmlspecialchars($product['middle_notes'] ?? '-')?></div>
                        <div><strong>Base:</strong> <?=htmlspecialchars($product['base_notes'] ?? '-')?></div>
                        <div><strong>Longevity:</strong> <?=htmlspecialchars($product['longevity'] ?? '-')?></div>
                    </div>

                    <!-- CART -->
                    <form method="POST" class="cart-box">
                        <input type="number" name="quantity" value="1" min="1">

                        <button type="submit" name="add_to_cart">
                            Add to Cart
                        </button>
                    </form>

                    <!-- WHATSAPP -->
                    <a href="https://wa.me/<?= getSetting('whatsapp_number','255712345678') ?>?text=I%20want%20<?=urlencode($product['name'])?>"
                       class="btn-whatsapp">
                        <i class="fab fa-whatsapp"></i> Order on WhatsApp
                    </a>

                    <!-- WISHLIST -->
                    <a href="wishlist.php?action=add&id=<?= $product['id'] ?>"
                       class="btn-wishlist">
                        ❤️ Add to Wishlist
                    </a>

                </div>
            </div>

        </div>
    </div>
</div>

<!-- ================= REVIEWS ================= -->
<div class="container py-5">

    <h2 class="section-title">Customer Reviews</h2>

    <?php if(isset($review_success)): ?>
        <div class="alert alert-success"><?= $review_success ?></div>
    <?php endif; ?>

    <!-- LIST -->
    <div class="reviews">
        <?php if($reviews->rowCount() > 0): ?>
            <?php foreach($reviews as $r): ?>
                <div class="review-card">
                    <div class="review-header">
                        <strong><?= htmlspecialchars($r['name']) ?></strong>
                        <span class="stars"><?= str_repeat("★", $r['rating']) ?></span>
                    </div>
                    <p><?= nl2br(htmlspecialchars($r['comment'])) ?></p>
                    <small><?= $r['created_at'] ?></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-light">No reviews yet. Be the first to review this fragrance.</p>
        <?php endif; ?>
    </div>

    <!-- FORM -->
    <div class="review-form">
        <h4>Write a Review</h4>

        <form method="POST">
            <input type="text" name="name" placeholder="Your Name" required>

            <select name="rating" required>
                <option value="">Rating</option>
                <option value="5">★★★★★</option>
                <option value="4">★★★★☆</option>
                option value="3">★★★☆☆</option>
            </select>

            <textarea name="comment" rows="4" placeholder="Share your experience..." required></textarea>

            <button type="submit" name="add_review">Submit Review</button>
        </form>
    </div>

</div>

<?php include 'includes/footer.php'; ?>