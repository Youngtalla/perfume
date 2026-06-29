<?php require_once 'includes/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mouhdy Perfumes Store | Beautiful Mind Smell Good</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Cinzel:wght@500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/styl.css">
    <meta name="description" content="Luxury Arabic Oud Perfumes in Dar es Salaam, Tanzania">
    <meta name="description" content="Luxury Arabic Oud Perfumes in Dar es Salaam, Tanzania | Original Fragrances">
    <meta name="keywords" content="perfume, arabic oud, luxury fragrance, dar es salaam">

   <style>
            /* ===================================================
   MOUHDY PERFUMES — Client Storefront Stylesheet
   Aesthetic: Dark luxury · Art deco · Arabian nights
   =================================================== */

@import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;500;700&family=Playfair+Display:ital,wght@0,400;0,700;1,400&family=Poppins:wght@300;400;500&display=swap');

/* ── Tokens ── */
:root {
  --gold:         #D4AF37;
  --gold-light:   #F0D06A;
  --gold-dim:     #8A7020;
  --gold-glow:    rgba(212,175,55,0.18);
  --onyx:         #080808;
  --deep:         #0C0C0E;
  --surface:      #111114;
  --card-bg:      #141418;
  --border:       rgba(212,175,55,0.14);
  --border-hover: rgba(212,175,55,0.38);
  --smoke:        #C8C8D4;
  --mist:         #78788A;
  --green-forest: #0F3D2E;
  --green-dark:   #0A2B20;
  --whatsapp:     #25D366;
  --radius-sm:    6px;
  --radius-md:    12px;
  --radius-lg:    20px;
  --transition:   0.28s ease;
}

/* ── Base ── */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

html { scroll-behavior: smooth; }

body {
  background: var(--deep);
  color: var(--smoke);
  font-family: 'Poppins', system-ui, sans-serif;
  font-size: 15px;
  line-height: 1.7;
  -webkit-font-smoothing: antialiased;
  overflow-x: hidden;
}

a { color: inherit; text-decoration: none; }
img { max-width: 100%; display: block; }

/* ── Scrollbar ── */
::-webkit-scrollbar            { width: 5px; }
::-webkit-scrollbar-track      { background: var(--onyx); }
::-webkit-scrollbar-thumb      { background: rgba(212,175,55,0.25); border-radius: 4px; }
::-webkit-scrollbar-thumb:hover{ background: rgba(212,175,55,0.5); }

/* ══════════════════════════════════
   NAVIGATION
══════════════════════════════════ */
.navbar {
  background: rgba(8,8,8,0.92) !important;
  backdrop-filter: blur(14px) saturate(1.4);
  -webkit-backdrop-filter: blur(14px);
  border-bottom: 1px solid var(--border);
  padding: 0.9rem 0;
  transition: background var(--transition);
}

.navbar-brand {
  font-family: 'Cinzel', serif !important;
  font-size: 1.5rem !important;
  font-weight: 700 !important;
  color: var(--gold) !important;
  letter-spacing: 0.22em;
  text-transform: uppercase;
}

.navbar-brand::after {
  content: '';
  display: block;
  height: 1px;
  background: linear-gradient(90deg, var(--gold), transparent);
  margin-top: 2px;
}

.nav-link {
  font-size: 0.78rem !important;
  font-weight: 400 !important;
  letter-spacing: 0.14em !important;
  text-transform: uppercase;
  color: var(--smoke) !important;
  padding: 0.4rem 0.9rem !important;
  position: relative;
  transition: color var(--transition);
}

.nav-link::after {
  content: '';
  position: absolute;
  bottom: -2px;
  left: 50%;
  width: 0;
  height: 1px;
  background: var(--gold);
  transition: width var(--transition), left var(--transition);
}

.nav-link:hover {
  color: var(--gold) !important;
}

.nav-link:hover::after {
  width: 60%;
  left: 20%;
}

/* Cart icon */
.navbar .fa-shopping-cart {
  color: var(--smoke);
  transition: color var(--transition);
}
.navbar a:hover .fa-shopping-cart {
  color: var(--gold);
}

/* Account btn */
.btn-outline-light.btn-sm {
  font-size: 0.72rem;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  border: 1px solid rgba(255,255,255,0.25);
  color: var(--smoke);
  padding: 0.4rem 1.1rem;
  border-radius: var(--radius-sm);
  transition: background var(--transition), border-color var(--transition), color var(--transition);
}
.btn-outline-light.btn-sm:hover {
  background: rgba(255,255,255,0.08);
  border-color: rgba(255,255,255,0.45);
  color: #fff;
}

/* Hamburger */
.navbar-toggler {
  border: 1px solid var(--border);
  padding: 0.3rem 0.6rem;
  filter: invert(1);
  opacity: 0.7;
}

/* ══════════════════════════════════
   HERO
══════════════════════════════════ */
.hero {
  height: 100vh !important;
  position: relative;
  display: flex !important;
  align-items: center !important;
  justify-content: center;
  text-align: center !important;
}

/* Decorative art-deco corner lines */
.hero::before,
.hero::after {
  content: '';
  position: absolute;
  width: 120px;
  height: 120px;
  border-color: rgba(212,175,55,0.35);
  border-style: solid;
  pointer-events: none;
}
.hero::before {
  top: 80px; left: 40px;
  border-width: 2px 0 0 2px;
}
.hero::after {
  bottom: 40px; right: 40px;
  border-width: 0 2px 2px 0;
}

/* Overlay shimmer line */
.hero .container {
  position: relative;
  z-index: 1;
}

.hero h1.display-1 {
  font-family: 'Cinzel', serif !important;
  font-size: clamp(2.8rem, 8vw, 6rem) !important;
  font-weight: 700 !important;
  color: var(--gold) !important;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  line-height: 1.1;
  text-shadow: 0 0 60px rgba(212,175,55,0.25);
  animation: fadeUp 1s ease both;
}

.hero .lead {
  font-family: 'Playfair Display', serif;
  font-style: italic;
  font-size: 1.3rem !important;
  color: rgba(255,255,255,0.72);
  letter-spacing: 0.08em;
  margin-bottom: 2.5rem !important;
  animation: fadeUp 1s 0.2s ease both;
}

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(28px); }
  to   { opacity: 1; transform: translateY(0); }
}

/* Hero divider */
.hero .container::before {
  content: '— ✦ —';
  display: block;
  color: var(--gold-dim);
  font-size: 0.8rem;
  letter-spacing: 0.5em;
  margin-bottom: 1.2rem;
  animation: fadeUp 1s 0.1s ease both;
}

/* ── Hero Buttons ── */
.btn-gold {
  display: inline-block;
  background: var(--gold);
  color: #0a0a0a;
  font-family: 'Cinzel', serif;
  font-size: 0.78rem;
  font-weight: 700;
  letter-spacing: 0.18em;
  text-transform: uppercase;
  padding: 1rem 2.5rem !important;
  border-radius: 2px;
  border: none;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition: background var(--transition), color var(--transition), transform var(--transition);
  animation: fadeUp 1s 0.35s ease both;
}

.btn-gold::before {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(255,255,255,0);
  transition: background var(--transition);
}

.btn-gold:hover {
  background: var(--gold-light);
  color: #000;
  transform: translateY(-2px);
}

.btn-gold:hover::before {
  background: rgba(255,255,255,0.06);
}

/* WhatsApp hero button */
.btn-success.btn-lg {
  background: transparent !important;
  border: 1px solid var(--whatsapp) !important;
  color: var(--whatsapp) !important;
  font-family: 'Cinzel', serif;
  font-size: 0.78rem;
  font-weight: 600;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  padding: 1rem 2.5rem !important;
  border-radius: 2px;
  transition: background var(--transition), color var(--transition), transform var(--transition);
  animation: fadeUp 1s 0.45s ease both;
}

.btn-success.btn-lg:hover {
  background: rgba(37,211,102,0.1) !important;
  transform: translateY(-2px);
}

/* ══════════════════════════════════
   FEATURED PRODUCTS
══════════════════════════════════ */
section.py-5[style*="background:#0F3D2E"],
section.py-5[style*="background: #0F3D2E"] {
  background: var(--green-forest) !important;
  position: relative;
  overflow: hidden;
}

/* Subtle arabesque pattern overlay */
section.py-5[style*="0F3D2E"]::before {
  content: '';
  position: absolute;
  inset: 0;
  background-image:
    repeating-linear-gradient(
      45deg,
      rgba(212,175,55,0.03) 0,
      rgba(212,175,55,0.03) 1px,
      transparent 0,
      transparent 50%
    );
  background-size: 24px 24px;
  pointer-events: none;
}

section h2.text-center {
  font-family: 'Playfair Display', serif !important;
  font-size: 2.2rem;
  font-weight: 700;
  color: var(--gold) !important;
  letter-spacing: 0.06em;
  margin-bottom: 0.5rem;
}

section h2.text-center::after {
  content: '';
  display: block;
  width: 60px;
  height: 1px;
  background: linear-gradient(90deg, transparent, var(--gold), transparent);
  margin: 0.75rem auto 0;
}

/* Product card — populated by JS */
#featured-products .card,
.product-card {
  background: var(--card-bg);
  border: 1px solid var(--border);
  border-radius: var(--radius-md);
  overflow: hidden;
  transition: transform var(--transition), border-color var(--transition), box-shadow var(--transition);
}

#featured-products .card:hover,
.product-card:hover {
  transform: translateY(-6px);
  border-color: var(--border-hover);
  box-shadow: 0 20px 50px rgba(0,0,0,0.5), 0 0 0 1px rgba(212,175,55,0.08);
}

#featured-products .card img,
.product-card img {
  width: 100%;
  aspect-ratio: 3/4;
  object-fit: cover;
  filter: saturate(0.85);
  transition: filter var(--transition), transform 0.5s ease;
}

#featured-products .card:hover img,
.product-card:hover img {
  filter: saturate(1.05);
  transform: scale(1.04);
}

.card-body {
  padding: 1.1rem 1.25rem;
}

.card-title {
  font-family: 'Playfair Display', serif;
  font-size: 1rem;
  font-weight: 700;
  color: var(--smoke);
  margin-bottom: 0.3rem;
}

.card-text, .product-price {
  font-size: 0.85rem;
  color: var(--mist);
}

.price, .product-price strong {
  font-family: 'Cinzel', serif;
  color: var(--gold);
  font-weight: 500;
  font-size: 0.95rem;
  letter-spacing: 0.05em;
}

/* Add to cart button on product cards */
.btn-add-cart, .btn-card-gold {
  display: block;
  width: 100%;
  padding: 0.55rem;
  background: transparent;
  border: 1px solid var(--border);
  color: var(--gold-dim);
  font-family: 'Cinzel', serif;
  font-size: 0.7rem;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  border-radius: var(--radius-sm);
  cursor: pointer;
  margin-top: 0.75rem;
  transition: background var(--transition), border-color var(--transition), color var(--transition);
}

.btn-add-cart:hover, .btn-card-gold:hover {
  background: var(--gold-glow);
  border-color: var(--gold);
  color: var(--gold-light);
}

/* ══════════════════════════════════
   COLLECTIONS / CATEGORIES
══════════════════════════════════ */
section.py-5:not([style]) {
  background: var(--deep);
}

/* Category blocks */
.col-md-4 a > div[style*="background:#0D0D0D"],
.col-md-4 a > div[style*="background: #0D0D0D"] {
  background: var(--card-bg) !important;
  border: 1px solid var(--border);
  border-radius: var(--radius-lg);
  font-family: 'Cinzel', serif;
  font-size: 0.85rem;
  font-weight: 500;
  letter-spacing: 0.22em;
  text-transform: uppercase;
  color: var(--smoke);
  padding: 4rem 2rem !important;
  transition: background var(--transition), border-color var(--transition), color var(--transition), transform var(--transition);
  position: relative;
  overflow: hidden;
}

.col-md-4 a > div::before {
  content: '';
  position: absolute;
  bottom: 0; left: 0;
  width: 100%;
  height: 2px;
  background: linear-gradient(90deg, transparent, var(--gold), transparent);
  transform: scaleX(0);
  transition: transform var(--transition);
}

.col-md-4 a:hover > div {
  background: #1a1a1e !important;
  border-color: var(--border-hover);
  color: var(--gold-light);
  transform: translateY(-4px);
}

.col-md-4 a:hover > div::before {
  transform: scaleX(1);
}

/* Section heading for Collections */
.py-5:not([style]) h2.text-center {
  color: var(--smoke);
  font-family: 'Playfair Display', serif;
  font-size: 2rem;
  font-weight: 400;
  font-style: italic;
}

/* ══════════════════════════════════
   FLOATING WHATSAPP BUTTON
══════════════════════════════════ */
a.position-fixed.btn-success {
  background: var(--whatsapp) !important;
  border: none !important;
  width: 58px !important;
  height: 58px !important;
  border-radius: 50% !important;
  display: flex !important;
  align-items: center !important;
  justify-content: center !important;
  font-size: 1.6rem !important;
  color: #fff !important;
  box-shadow: 0 4px 20px rgba(37,211,102,0.35) !important;
  transition: transform var(--transition), box-shadow var(--transition) !important;
  z-index: 999;
}

a.position-fixed.btn-success:hover {
  transform: scale(1.1) !important;
  box-shadow: 0 8px 30px rgba(37,211,102,0.5) !important;
}

/* ══════════════════════════════════
   FOOTER (generic polish)
══════════════════════════════════ */
footer {
  background: var(--onyx);
  border-top: 1px solid var(--border);
  color: var(--mist);
  font-size: 0.83rem;
}

footer a {
  color: var(--mist);
  transition: color var(--transition);
}

footer a:hover {
  color: var(--gold);
}

/* ══════════════════════════════════
   BOOTSTRAP UTILITY HELPERS
══════════════════════════════════ */
.container { max-width: 1200px; margin: 0 auto; padding: 0 1.5rem; }
.py-5     { padding-top: 5rem !important; padding-bottom: 5rem !important; }
.mb-5     { margin-bottom: 3rem !important; }
.mb-4     { margin-bottom: 1.5rem !important; }
.me-3     { margin-right: 1rem !important; }
.row      { display: flex; flex-wrap: wrap; margin: 0 -0.75rem; }
.row.g-4  { gap: 0; }
.row.g-4 > * { padding: 0.75rem; }
.col-md-4 { width: 33.3333%; }
.d-flex   { display: flex; }
.gap-3    { gap: 1rem; }
.align-items-center { align-items: center; }
.justify-content-center { justify-content: center; }
.text-center { text-align: center; }
.text-decoration-none { text-decoration: none; }
.rounded  { border-radius: var(--radius-md); }
.shadow   { box-shadow: 0 4px 16px rgba(0,0,0,0.4); }
.position-fixed { position: fixed; }
.bottom-0 { bottom: 0; }
.end-0    { right: 0; }
.m-4      { margin: 1.5rem; }
.ms-auto  { margin-left: auto; }

@media (max-width: 768px) {
  .col-md-4 { width: 100%; }
  .hero::before, .hero::after { display: none; }
  .hero h1.display-1 { font-size: 2.5rem !important; }
}
        </style> 
   
</head>
<body>


<!-- Sticky Navigation -->
<nav class="navbar navbar-expand-lg fixed-top" style="background: rgba(13,13,13,0.95); backdrop-filter: blur(10px);">
    <div class="container">
        <a class="navbar-brand text-white fw-bold" href="index.php" style="font-family: 'Cinzel', serif; color: #D4AF37 !important;">MOUDHY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav ms-auto">
                <li><a href="index.php" class="nav-link text-white">Home</a></li>
                <li><a href="shop.php" class="nav-link text-white">Shop</a></li>
                <li><a href="offers.php" class="nav-link text-white">Offers</a></li>
                <li><a href="blog.php" class="nav-link text-white">Blog</a></li>
                <li><a href="about.php" class="nav-link text-white">About</a></li>
                <li><a href="contact.php" class="nav-link text-white">Contact</a></li>
            </ul>
            <div class="d-flex gap-3 align-items-center">
                <a href="cart.php" class="text-white"><i class="fas fa-shopping-cart fa-lg"></i></a>
                <a href="account/login.php" class="btn btn-outline-light btn-sm">Account</a>
            </div>
        </div>
    </div>
</nav>

<!-- Hero -->
<section class="hero d-flex align-items-center text-center" style="height:100vh; background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.75)), url('https://picsum.photos/id/1015/1920/1080') center/cover no-repeat;">
    <div class="container">
        <h1 class="display-1 fw-bold" style="font-family: 'Cinzel', serif; color:#D4AF37;">Mouhdy Perfumes</h1>
        <p class="lead mb-4" style="font-size:1.4rem;">Beautiful Mind Smell Good</p>
        <div>
            <a href="shop.php" class="btn btn-gold btn-lg px-5 py-3 me-3">Shop Now</a>
            <a href="https://wa.me/255712345678?text=Hello%20Mouhdy%20Perfumes" class="btn btn-success btn-lg px-5 py-3">
                <i class="fab fa-whatsapp"></i> Order on WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- Featured Products -->
<section class="py-5" style="background:#0F3D2E;">
    <div class="container">
        <h2 class="text-center mb-5" style="color:#D4AF37; font-family:'Playfair Display',serif;">Featured Masterpieces</h2>
        <div class="row" id="featured-products">
            <!-- Populated by JS/PHP below -->
        </div>
    </div>
</section>

<!-- Categories -->
<section class="py-5">
    <div class="container">
        <h2 class="text-center mb-5">Collections</h2>
        <div class="row g-4 text-center">
            <div class="col-md-4"><a href="shop.php?gender=Men" class="text-decoration-none"><div class="p-5 rounded" style="background:#0D0D0D;">Men</div></a></div>
            <div class="col-md-4"><a href="shop.php?gender=Women" class="text-decoration-none"><div class="p-5 rounded" style="background:#0D0D0D;">Women</div></a></div>
            <div class="col-md-4"><a href="shop.php?category=Arabic Oud" class="text-decoration-none"><div class="p-5 rounded" style="background:#0D0D0D;">Arabic Oud</div></a></div>
        </div>
    </div>
</section>

<!-- Floating WhatsApp -->
<a href="https://wa.me/255712345678" class="position-fixed bottom-0 end-0 m-4 btn btn-success rounded-circle shadow" style="width:60px;height:60px;display:flex;align-items:center;justify-content:center;font-size:1.8rem;z-index:999;">
    <i class="fab fa-whatsapp"></i>
</a>

<?php require_once 'includes/footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>