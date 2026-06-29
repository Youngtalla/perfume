<?php 
require_once '../includes/functions.php';
if(!isAdmin()) {
    header("Location: login.php");
    exit;
}
require_once '../includes/db.php';

// Fetch statistics
$totalProducts = $pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();
$totalOrders = $pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();
$totalUsers = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$lowStock = $pdo->query("SELECT COUNT(*) FROM products WHERE stock < 10")->fetchColumn();

// New Orders (Pending)
$newOrders = $pdo->query("SELECT COUNT(*) FROM orders WHERE status = 'pending'")->fetchColumn();

// Recent Products
$recentProducts = $pdo->query("SELECT * FROM products ORDER BY id DESC LIMIT 5")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Mouhdy Perfumes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
    <link href="../assets/css/admin-style.css" rel="stylesheet">
            <style>:root{
    --gold:#d4af37;
    --dark:#111827;
    --dark-light:#1f2937;
    --text:#f8fafc;
}

body{
    background:#0f172a;
    color:var(--text);
    font-family:'Segoe UI',sans-serif;
}

/* Sidebar */
.sidebar{
    background:linear-gradient(180deg,#111827,#1e293b);
    min-height:100vh;
    border-right:1px solid rgba(255,255,255,.08);
}

.sidebar h4{
    color:var(--gold);
    font-weight:700;
}

.sidebar .nav-link{
    border-radius:10px;
    padding:12px 15px;
    transition:.3s;
}

.sidebar .nav-link:hover,
.sidebar .nav-link.active{
    background:rgba(212,175,55,.15);
    color:var(--gold) !important;
    transform:translateX(5px);
}

/* Cards */
.admin-card{
    background:linear-gradient(145deg,#1e293b,#0f172a);
    border:1px solid rgba(255,255,255,.08);
    box-shadow:0 5px 20px rgba(0,0,0,.3);
    transition:.3s;
}

.admin-card:hover{
    transform:translateY(-5px);
    box-shadow:0 10px 30px rgba(212,175,55,.15);
}

.admin-card h3{
    color:var(--gold);
    font-weight:700;
    margin-bottom:5px;
}

.admin-card p{
    color:#cbd5e1;
    margin:0;
}

/* Gold Button */
.btn-gold{
    background:var(--gold);
    color:#111;
    font-weight:600;
    border:none;
}

.btn-gold:hover{
    background:#f0c64f;
    color:#000;
}

/* Dashboard Heading */
h2{
    color:var(--gold);
    font-weight:700;
}

/* Tables */
.table{
    border-radius:12px;
    overflow:hidden;
}

.table-dark{
    --bs-table-bg:#1e293b;
}

.table thead{
    background:#d4af37;
    color:#111;
}

.table tbody tr{
    transition:.3s;
}

.table tbody tr:hover{
    background:rgba(212,175,55,.08);
}

/* Product Images */
.table img{
    border-radius:10px;
    border:2px solid rgba(255,255,255,.1);
}

/* Notification Dot */
.new-order-dot{
    width:12px;
    height:12px;
    background:#ff3b3b;
    border-radius:50%;
    animation:pulse 1.5s infinite;
}

@keyframes pulse{
    0%{
        transform:scale(1);
        opacity:1;
    }
    50%{
        transform:scale(1.4);
        opacity:.6;
    }
    100%{
        transform:scale(1);
        opacity:1;
    }
}

/* Badges */
.badge{
    font-size:.75rem;
}

/* Responsive */
@media(max-width:768px){
    .sidebar{
        width:80px !important;
    }

    .sidebar h4,
    .sidebar .nav-link span{
        display:none;
    }

    .sidebar .nav-link{
        text-align:center;
    }
}
    </style>
</head>
<body>

<div class="d-flex">
    <!-- Sidebar -->
    <div class="sidebar text-light p-3" style="width: 260px;">
        <h4 class="text-gold mb-4">🕌 MOUDHY ADMIN</h4>
        <ul class="nav flex-column">
            <li class="nav-item mb-2"><a href="index.php" class="nav-link text-white active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li class="nav-item mb-2">
                <a href="orders.php" class="nav-link text-white">
                    <i class="fas fa-shopping-bag"></i> Orders 
                    <?php if($newOrders > 0): ?>
                        <span class="badge bg-danger"><?= $newOrders ?></span>
                    <?php endif; ?>
                </a>
            </li>
            <li class="nav-item mb-2"><a href="products.php" class="nav-link text-white"><i class="fas fa-box"></i> Products</a></li>
            <li class="nav-item mb-2"><a href="customers.php" class="nav-link text-white"><i class="fas fa-users"></i> Customers</a></li>
            <li class="nav-item mb-2"><a href="blog.php" class="nav-link text-white"><i class="fas fa-blog"></i> Blog</a></li>
            <li class="nav-item mb-2"><a href="settings.php" class="nav-link text-white"><i class="fas fa-cog"></i> Settings</a></li>
            <li class="nav-item mb-2"><a href="profile.php" class="nav-link text-white"><i class="fas fa-user-circle"></i> Profile</a></li>
            <li class="nav-item mt-4">
                <a href="logout.php" class="btn btn-danger w-100"><i class="fas fa-sign-out-alt"></i> Logout</a>
            </li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-grow-1 p-4">
        <h2 class="mb-4">Dashboard Overview</h2>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="admin-card p-4 rounded text-center">
                    <h3><?= $totalProducts ?></h3>
                    <p>Total Products</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="admin-card p-4 rounded text-center position-relative">
                    <h3><?= $totalOrders ?></h3>
                    <p>Total Orders</p>
                    <?php if($newOrders > 0): ?>
                        <span class="new-order-dot position-absolute top-0 start-100 translate-middle"></span>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-3">
                <div class="admin-card p-4 rounded text-center">
                    <h3><?= $totalUsers ?></h3>
                    <p>Customers</p>
                </div>
            </div>
            <div class="col-md-3">
                <div class="admin-card p-4 rounded text-center text-warning">
                    <h3><?= $lowStock ?></h3>
                    <p>Low Stock Items</p>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Quick Actions -->
            <div class="col-lg-4">
                <div class="admin-card p-4 rounded">
                    <h5>Quick Actions</h5>
                    <a href="products.php" class="btn btn-gold w-100 mb-3">+ Add New Product</a>
                    <a href="orders.php" class="btn btn-outline-light w-100 mb-3">
                        View All Orders 
                        <?php if($newOrders > 0): ?>
                            <span class="badge bg-danger"><?= $newOrders ?> New</span>
                        <?php endif; ?>
                    </a>
                </div>
            </div>

            <!-- Recent Products -->
            <div class="col-lg-8">
                <div class="admin-card p-4 rounded">
                    <h5 class="mb-3">Recently Added Products</h5>
                <table class="table table-dark table-striped">
                    <thead>
                        <tr>
                            <th>Image</th>
                            <th>Product Name</th>
                            <th>Price</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($recentProducts as $p): ?>
                        <tr>
                            <td><img src="../uploads/<?=htmlspecialchars($p['image'])?>" width="50" height="50" style="object-fit:cover;"></td>
                            <td><?=htmlspecialchars($p['name'])?></td>
                            <td>TZS <?=number_format($p['price'])?></td>
                            <td>
                                <a href="products.php?edit=<?=$p['id']?>" class="btn btn-sm btn-primary">Edit</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>