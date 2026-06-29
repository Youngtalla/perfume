<?php 
require_once 'includes/functions.php';
require_once 'includes/db.php';

// Filters
$gender = isset($_GET['gender']) ? $_GET['gender'] : '';
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';

$sql = "SELECT p.*, c.name as cat_name 
        FROM products p 
        LEFT JOIN categories c ON p.category_id = c.id 
        WHERE 1=1";

if ($gender) $sql .= " AND p.gender = :gender";
if ($search) $sql .= " AND p.name LIKE :search";

$sql .= " ORDER BY p.featured DESC, p.created_at DESC";

$stmt = $pdo->prepare($sql);

if ($gender) $stmt->bindParam(':gender', $gender);
if ($search) $stmt->bindValue(':search', "%$search%");

$stmt->execute();
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop - Mouhdy Perfumes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

    <meta name="description" content="Luxury Arabic Oud Perfumes in Dar es Salaam, Tanzania | Original Fragrances">
    <meta name="keywords" content="perfume, arabic oud, luxury fragrance, dar es salaam">
<style>
    /* ===================================================
   MOUHDY PERFUMES — Shop Page Stylesheet
   Add to assets/css/style.css  (or link as shop.css)
   =================================================== */

/* ══════════════════════════════════
   SHOP HEADER BANNER
══════════════════════════════════ */
.shop-header {
  margin-top: 72px; /* navbar height offset */
  padding: 5rem 0 4rem;
  background:
    linear-gradient(160deg, rgba(0,0,0,0.82) 0%, rgba(10,28,20,0.88) 100%),
    url('https://picsum.photos/id/1048/1600/500') center/cover no-repeat;
  border-bottom: 1px solid rgba(212,175,55,0.18);
  position: relative;
  overflow: hidden;
}

/* art-deco corner brackets */
.shop-header::before,
.shop-header::after {
  content: '';
  position: absolute;
  width: 80px;
  height: 80px;
  border-color: rgba(212,175,55,0.3);
  border-style: solid;
  pointer-events: none;
}
.shop-header::before { top: 24px; left: 32px; border-width: 2px 0 0 2px; }
.shop-header::after  { bottom: 24px; right: 32px; border-width: 0 2px 2px 0; }

.shop-header h1 {
  font-family: 'Cinzel', serif;
  font-size: clamp(2rem, 5vw, 3.2rem);
  font-weight: 700;
  color: #D4AF37;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  margin-bottom: 0.5rem;
  text-shadow: 0 0 40px rgba(212,175,55,0.2);
}

.shop-header p {
  font-family: 'Playfair Display', serif;
  font-style: italic;
  font-size: 1.05rem;
  color: rgba(255,255,255,0.58);
  letter-spacing: 0.06em;
}

.shop-header p::before { content: '— '; color: rgba(212,175,55,0.4); }
.shop-header p::after  { content: ' —'; color: rgba(212,175,55,0.4); }

/* ══════════════════════════════════
   LAYOUT
══════════════════════════════════ */
body { background: #0D0D0D !important; }

.container.py-5 {
  padding-top: 3.5rem !important;
  padding-bottom: 4rem !important;
}

/* ══════════════════════════════════
   FILTER SIDEBAR
══════════════════════════════════ */
.filter-box {
  background: #111114;
  border: 1px solid rgba(212,175,55,0.13);
  border-radius: 16px;
  padding: 1.75rem 1.5rem;
  position: sticky;
  top: 88px;
}

.filter-box h5 {
  font-family: 'Cinzel', serif;
  font-size: 0.75rem;
  font-weight: 600;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  color: #D4AF37;
  margin-bottom: 1.4rem;
  display: flex;
  align-items: center;
  gap: 8px;
}

.filter-box h5 i {
  font-size: 0.8rem;
  opacity: 0.7;
}

/* Search input */
.filter-box .form-control {
  background: #0c0c0f;
  border: 1px solid rgba(212,175,55,0.16);
  border-radius: 6px;
  color: #C8C8D4;
  font-family: 'Poppins', sans-serif;
  font-size: 0.83rem;
  padding: 0.65rem 1rem;
  transition: border-color 0.2s ease, box-shadow 0.2s ease;
  width: 100%;
  outline: none;
}

.filter-box .form-control::placeholder { color: #4a4a5a; }

.filter-box .form-control:focus {
  border-color: rgba(212,175,55,0.45);
  box-shadow: 0 0 0 3px rgba(212,175,55,0.07);
  background: #0e0e12;
}

/* Gold search button */
.filter-box .btn-gold {
  display: block;
  width: 100%;
  padding: 0.65rem 1rem;
  background: #D4AF37;
  color: #080808;
  font-family: 'Cinzel', serif;
  font-size: 0.72rem;
  font-weight: 700;
  letter-spacing: 0.2em;
  text-transform: uppercase;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background 0.22s ease, transform 0.2s ease;
  text-align: center;
  text-decoration: none;
}

.filter-box .btn-gold:hover {
  background: #F0D06A;
  transform: translateY(-1px);
}

/* Divider */
.filter-box hr {
  border: none;
  border-top: 1px solid rgba(212,175,55,0.14);
  margin: 1.25rem 0;
}

/* Filter nav buttons */
.filter-box .btn-outline-light {
  display: block;
  width: 100%;
  padding: 0.6rem 1rem;
  background: transparent;
  border: 1px solid rgba(255,255,255,0.1);
  border-radius: 6px;
  color: #88889a;
  font-family: 'Poppins', sans-serif;
  font-size: 0.78rem;
  font-weight: 400;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  text-align: center;
  margin-bottom: 0.5rem;
  transition: background 0.2s ease, border-color 0.2s ease, color 0.2s ease;
  text-decoration: none;
}

.filter-box .btn-outline-light:hover,
.filter-box .btn-outline-light.active {
  background: rgba(212,175,55,0.09);
  border-color: rgba(212,175,55,0.4);
  color: #D4AF37;
}

/* ══════════════════════════════════
   PRODUCT CARDS
══════════════════════════════════ */
.product-card {
  background: #141418;
  border: 1px solid rgba(212,175,55,0.1);
  border-radius: 14px;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  height: 100%;
  transition: transform 0.28s ease, border-color 0.28s ease, box-shadow 0.28s ease;
}

.product-card:hover {
  transform: translateY(-7px);
  border-color: rgba(212,175,55,0.35);
  box-shadow:
    0 24px 60px rgba(0,0,0,0.55),
    0 0 0 1px rgba(212,175,55,0.06);
}

/* Image wrapper */
.product-image-wrapper {
  position: relative;
  overflow: hidden;
  aspect-ratio: 3 / 4;
  background: #0c0c0e;
}

.product-image-wrapper img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
  filter: saturate(0.8) brightness(0.95);
  transition: transform 0.5s ease, filter 0.4s ease;
}

.product-card:hover .product-image-wrapper img {
  transform: scale(1.06);
  filter: saturate(1.05) brightness(1.0);
}

/* Gradient fade at bottom of image */
.product-image-wrapper::after {
  content: '';
  position: absolute;
  bottom: 0; left: 0; right: 0;
  height: 60px;
  background: linear-gradient(transparent, #141418);
  pointer-events: none;
}

/* Featured badge */
.featured-badge {
  position: absolute;
  top: 12px;
  left: 12px;
  background: #D4AF37;
  color: #080808;
  font-family: 'Cinzel', serif;
  font-size: 0.6rem;
  font-weight: 700;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  padding: 0.28rem 0.7rem;
  border-radius: 3px;
  z-index: 2;
}

/* Card body */
.product-card .card-body {
  padding: 1.1rem 1.2rem 1.3rem;
  display: flex;
  flex-direction: column;
  flex: 1;
}

.product-card h5 {
  font-family: 'Playfair Display', serif;
  font-size: 1rem;
  font-weight: 700;
  color: #E0E0EC;
  margin-bottom: 0.25rem;
  line-height: 1.3;
}

.product-card small {
  font-size: 0.72rem;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  color: #555568 !important;
  font-family: 'Poppins', sans-serif;
}

.product-price {
  font-family: 'Cinzel', serif;
  font-size: 1rem;
  font-weight: 500;
  color: #D4AF37;
  letter-spacing: 0.05em;
  margin: 0.75rem 0 0.5rem;
}

/* View Details button */
.product-card .btn-gold {
  display: block;
  width: 100%;
  padding: 0.6rem 1rem;
  background: #D4AF37;
  color: #080808;
  font-family: 'Cinzel', serif;
  font-size: 0.7rem;
  font-weight: 700;
  letter-spacing: 0.16em;
  text-transform: uppercase;
  border: none;
  border-radius: 5px;
  text-align: center;
  cursor: pointer;
  text-decoration: none;
  transition: background 0.22s ease, transform 0.2s ease;
  margin-bottom: 0.5rem;
}

.product-card .btn-gold:hover {
  background: #F0D06A;
  transform: translateY(-1px);
}

/* WhatsApp order button */
.product-card .btn-success {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 7px;
  width: 100%;
  padding: 0.6rem 1rem;
  background: transparent;
  border: 1px solid rgba(37,211,102,0.3);
  border-radius: 5px;
  color: #25D366;
  font-family: 'Poppins', sans-serif;
  font-size: 0.75rem;
  font-weight: 500;
  letter-spacing: 0.08em;
  text-decoration: none;
  cursor: pointer;
  transition: background 0.22s ease, border-color 0.22s ease;
}

.product-card .btn-success:hover {
  background: rgba(37,211,102,0.1);
  border-color: rgba(37,211,102,0.6);
}

/* mt-auto helper */
.mt-auto { margin-top: auto; }
.mb-2 { margin-bottom: 0.5rem !important; }
.w-100 { width: 100% !important; }

/* ══════════════════════════════════
   EMPTY STATE
══════════════════════════════════ */
.empty-products {
  text-align: center;
  padding: 5rem 2rem;
  width: 100%;
}

.empty-products i {
  font-size: 3.5rem;
  color: rgba(212,175,55,0.2);
  margin-bottom: 1.25rem;
  display: block;
}

.empty-products h3 {
  font-family: 'Playfair Display', serif;
  font-size: 1.5rem;
  font-weight: 400;
  color: #55556A;
  margin-bottom: 0.5rem;
}

.empty-products p {
  font-size: 0.85rem;
  color: #3a3a4a;
  letter-spacing: 0.06em;
}

/* ══════════════════════════════════
   BOOTSTRAP GRID HELPERS
══════════════════════════════════ */
.row.g-4 > * { padding: 0.75rem; }
.col-lg-3 { width: 25%; }
.col-lg-9 { width: 75%; }
.col-md-4 { width: 33.3333%; }
.d-flex   { display: flex; }
.flex-column { flex-direction: column; }

@media (max-width: 992px) {
  .col-lg-3,
  .col-lg-9 { width: 100%; }
  .filter-box { position: static; margin-bottom: 2rem; }
}

@media (max-width: 768px) {
  .col-md-4 { width: 50%; }
  .shop-header::before,
  .shop-header::after { display: none; }
}

@media (max-width: 480px) {
  .col-md-4 { width: 100%; }
}
</style>
</head>

<body style="background:#0D0D0D;">

<?php include 'includes/header.php'; ?>

<!-- SHOP HEADER -->
<div class="shop-header text-center">
    <div class="container">
        <h1>Luxury Collection</h1>
        <p>Discover Premium Arabic Oud & Designer Fragrances</p>
    </div>
</div>

<!-- SHOP CONTENT -->
<div class="container py-5">
    <div class="row g-4">

        <!-- FILTERS -->
        <div class="col-lg-3">
            <div class="filter-box">
                <h5><i class="fas fa-filter"></i> Find Your Fragrance</h5>

                <form method="GET">
                    <input type="text"
                           name="search"
                           class="form-control mb-3"
                           placeholder="Search perfumes..."
                           value="<?=htmlspecialchars($search)?>">

                    <button class="btn btn-gold w-100">
                        Search
                    </button>
                </form>

                <hr style="border-color:rgba(212,175,55,.2)">

                <a href="shop.php" class="btn btn-outline-light w-100 mb-2">All Products</a>
                <a href="shop.php?gender=Men" class="btn btn-outline-light w-100 mb-2">Men</a>
                <a href="shop.php?gender=Women" class="btn btn-outline-light w-100">Women</a>
            </div>
        </div>

        <!-- PRODUCTS -->
        <div class="col-lg-9">
            <div class="row g-4">

                <?php foreach($products as $p): ?>
                <div class="col-md-4">

                    <div class="product-card">

                        <div class="product-image-wrapper">
                            <img src="uploads/<?=htmlspecialchars($p['image'])?>"
                                 alt="<?=htmlspecialchars($p['name'])?>">

                            <?php if(!empty($p['featured'])): ?>
                                <span class="featured-badge">Featured</span>
                            <?php endif; ?>
                        </div>

                        <div class="card-body d-flex flex-column">

                            <h5><?=htmlspecialchars($p['name'])?></h5>

                            <small style="color:#aaa;">
                                <?=htmlspecialchars($p['cat_name'])?>
                            </small>

                            <div class="product-price">
                                TZS <?=number_format($p['sale_price'] ?? $p['price'])?>
                            </div>

                            <div class="mt-auto">
                                <a href="product.php?id=<?=$p['id']?>"
                                   class="btn btn-gold w-100 mb-2">
                                    View Details
                                </a>

                                <a href="https://wa.me/255712345678?text=I%20want%20<?=urlencode($p['name'])?>"
                                   class="btn btn-success w-100">
                                    <i class="fab fa-whatsapp"></i> Order Now
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
                <?php endforeach; ?>

                <?php if(empty($products)): ?>
                <div class="empty-products">
                    <i class="fas fa-wine-bottle"></i>
                    <h3>No perfumes found</h3>
                    <p>Try adjusting your search or filters.</p>
                </div>
                <?php endif; ?>

            </div>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>