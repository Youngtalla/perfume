<?php 
require_once '../includes/functions.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Get real order count
$stmt = $pdo->prepare("SELECT COUNT(*) FROM orders WHERE user_id = ?");
$stmt->execute([$user_id]);
$order_count = $stmt->fetchColumn();
?>

<?php include '../includes/header.php'; ?>

<div class="container py-5 mt-5">

    <!-- Enhanced Welcome Section -->
    <div class="p-5 rounded mb-5 position-relative overflow-hidden" 
         style="background: linear-gradient(135deg, #0F3D2E 0%, #0D0D0D 100%), 
                url('https://picsum.photos/id/1015/1200/400') center/cover;
                border: 2px solid #D4AF37; min-height: 220px;">
        
        <div style="background: rgba(0,0,0,0.6); position: absolute; top:0; left:0; right:0; bottom:0;"></div>
        
        <div class="position-relative">
            <h1 class="display-4 text-gold fw-bold">Welcome back, <?= htmlspecialchars($_SESSION['user_name']) ?> 👋</h1>
            <p class="lead text-light">What fragrance will define your day today?</p>
        </div>
    </div>

    <div class="row g-4">

        <!-- Main Content -->
        <div class="col-lg-8">
            
            <!-- Quick Access Buttons -->
            <div class="row g-3 mb-5">
                <div class="col-md-4">
                    <a href="../shop.php" class="btn btn-gold w-100 py-4 fs-5 fw-bold shadow">
                        🛍️ Browse Perfumes
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="../offers.php" class="btn btn-outline-warning w-100 py-4 fs-5 fw-bold shadow">
                        🔥 Special Offers
                    </a>
                </div>
                <div class="col-md-4">
                    <a href="../cart.php" class="btn btn-outline-light w-100 py-4 fs-5 fw-bold shadow">
                        🛒 My Cart
                    </a>
                </div>
            </div>

            <!-- Recommendations -->
            <h4 class="text-gold mb-4">💎 Recommended For You</h4>
            <div class="row g-4">
                <?php
                $recommended = $pdo->query("SELECT * FROM products ORDER BY RAND() LIMIT 2")->fetchAll();
                foreach($recommended as $perfume):
                ?>
                <div class="col-md-6">
                    <div class="card glass overflow-hidden h-100">
                        <img src="../uploads/<?= htmlspecialchars($perfume['image']) ?>" 
                             class="card-img-top" style="height: 260px; object-fit: cover;" alt="">
                        <div class="card-body d-flex flex-column">
                            <h5><?= htmlspecialchars($perfume['name']) ?></h5>
                            <p class="text-gold fs-5">TZS <?= number_format($perfume['price']) ?></p>
                            <a href="../product.php?id=<?= $perfume['id'] ?>" class="btn btn-gold mt-auto">
                                Order Now
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <div class="card glass p-4">
                <h5 class="text-gold">Account Summary</h5>
                <div class="my-4">
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Total Orders</span>
                        <strong><?= $order_count ?></strong>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Wishlist Items</span>
                        <strong>0</strong>
                    </div>
                </div>
                
                <a href="../shop.php" class="btn btn-outline-light w-100 py-3">
                    Continue Shopping
                </a>
            </div>
        </div>

    </div>
</div>

<?php include '../includes/footer.php'; ?>