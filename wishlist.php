<?php 
require_once 'includes/functions.php';
if(!isset($_SESSION['user_id'])) {
    header("Location: account/login.php"); exit;
}

$user_id = $_SESSION['user_id'];

// Add to Wishlist
if(isset($_GET['action']) && $_GET['action'] == 'add' && isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $stmt = $pdo->prepare("INSERT IGNORE INTO wishlist (user_id, product_id) VALUES (?, ?)");
    $stmt->execute([$user_id, $product_id]);
    $message = "Added to wishlist!";
}

// Remove from Wishlist
if(isset($_GET['action']) && $_GET['action'] == 'remove' && isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $stmt = $pdo->prepare("DELETE FROM wishlist WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
}

// Get Wishlist Items
$stmt = $pdo->prepare("SELECT p.* FROM wishlist w JOIN products p ON w.product_id = p.id WHERE w.user_id = ? ORDER BY w.created_at DESC");
$stmt->execute([$user_id]);
$wishlist_items = $stmt->fetchAll();
?>

<?php include 'includes/header.php'; ?>

<div class="container py-5 mt-5">
    <h2 class="text-gold mb-4">❤️ My Wishlist (<?= count($wishlist_items) ?> items)</h2>

    <?php if(isset($message)): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>

    <?php if(empty($wishlist_items)): ?>
        <div class="alert alert-info text-center py-5">
            Your wishlist is empty.<br>
            <a href="shop.php" class="btn btn-gold mt-3">Browse Perfumes</a>
        </div>
    <?php else: ?>
        <div class="row g-4">
            <?php foreach($wishlist_items as $p): ?>
            <div class="col-md-4">
                <div class="card glass h-100">
                    <img src="uploads/<?=htmlspecialchars($p['image'])?>" class="card-img-top" style="height:260px;object-fit:cover;">
                    <div class="card-body d-flex flex-column">
                        <h5><?=htmlspecialchars($p['name'])?></h5>
                        <p class="text-gold">TZS <?=number_format($p['price'])?></p>
                        
                        <div class="mt-auto d-grid gap-2">
                            <a href="product.php?id=<?=$p['id']?>" class="btn btn-outline-light">
                                View Details
                            </a>
                            <a href="https://wa.me/<?= getSetting('whatsapp_number', '255712345678') ?>?text=I%20want%20to%20buy%20<?=urlencode($p['name'])?>" 
                               class="btn btn-success">
                                Order Now via WhatsApp
                            </a>
                            <a href="wishlist.php?action=remove&id=<?=$p['id']?>" class="btn btn-danger btn-sm">
                                Remove from Wishlist
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>