<?php 
require_once 'functions.php'; 
$whatsapp = getSetting('whatsapp_number', '255712345678');
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $_SESSION['user_name'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?? 'Mouhdy Perfumes Store' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Cinzel:wght@500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar-expand-lg fixed-top" style="background: rgba(13,13,13,0.95); backdrop-filter: blur(12px); z-index: 1030;">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="index.php" style="color:#D4AF37; font-family:'Cinzel',serif;">MOUDHY</a>
        
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link text-white" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="shop.php">Shop</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="offers.php">Offers</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="blog.php">Blog</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="about.php">About</a></li>
                <li class="nav-item"><a class="nav-link text-white" href="contact.php">Contact</a></li>
            </ul>
            
            <div class="d-flex align-items-center gap-3">
                <a href="cart.php" class="text-white position-relative">
                    <i class="fas fa-shopping-cart fa-lg"></i>
                </a>
                
                <?php if($isLoggedIn): ?>
                    <div class="dropdown">
                        <a href="#" class="btn btn-outline-light dropdown-toggle" data-bs-toggle="dropdown">
                            Hi, <?= htmlspecialchars($userName) ?>
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="account/dashboard.php">Dashboard</a></li>
                            <li><a class="dropdown-item" href="account/orders.php">My Orders</a></li>
                            <li><a class="dropdown-item" href="account/profile.php">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item text-danger" href="../logout.php">Logout</a></li>
                        </ul>
                    </div>
                <?php else: ?>
                    <a href="account/login.php" class="btn btn-outline-light btn-sm">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>