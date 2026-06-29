<?php 
require_once '../includes/functions.php';
if(!isAdmin()) { header("Location: login.php"); exit; }
require_once '../includes/db.php';

/* =========================
   DELETE ORDER
========================= */
if(isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $pdo->prepare("DELETE FROM order_items WHERE order_id = ?")->execute([$id]);
    $pdo->prepare("DELETE FROM orders WHERE id = ?")->execute([$id]);

    header("Location: orders.php");
    exit;
}

/* =========================
   SEARCH
========================= */
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

/* =========================
   PAGINATION
========================= */
$limit = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

/* =========================
   BASE QUERY
========================= */
$where = "";
$params = [];

if(!empty($search)) {
    $where = "WHERE customer_name LIKE ? 
              OR phone LIKE ? 
              OR address LIKE ? 
              OR id LIKE ?";
    $params = [
        "%$search%",
        "%$search%",
        "%$search%",
        "%$search%"
    ];
}

/* =========================
   TOTAL ORDERS (FOR PAGES)
========================= */
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM orders $where");
$countStmt->execute($params);
$totalOrders = $countStmt->fetchColumn();
$totalPages = ceil($totalOrders / $limit);

/* =========================
   FETCH ORDERS
========================= */
$sql = "SELECT * FROM orders 
        $where 
        ORDER BY id DESC 
        LIMIT $limit OFFSET $offset";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll();
?>
<?php 
require_once '../includes/functions.php';
if(!isAdmin()) { header("Location: login.php"); exit; }
require_once '../includes/db.php';

/* =========================
   UPDATE STATUS ACTIONS
========================= */
if(isset($_GET['action']) && isset($_GET['id'])) {

    $new_status = $_GET['action'];
    $id = (int)$_GET['id'];

    $allowed = ['pending', 'processing', 'shipped', 'delivered'];

    if(in_array($new_status, $allowed)) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$new_status, $id]);
    }

    header("Location: orders.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/styl.css" rel="stylesheet">
<style>
        /* =========================
   ADMIN ORDERS
========================= */

.admin-body {
    background: #0d0d0d;
    color: white;
}

.admin-title {
    color: #D4AF37;
    font-family: 'Cinzel', serif;
    margin-bottom: 20px;
}

.admin-order-card {
    background: #141414;
    border: 1px solid rgba(212,175,55,.15);
    padding: 20px;
    border-radius: 15px;
    margin-bottom: 20px;
}

.order-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.status {
    padding: 5px 12px;
    border-radius: 20px;
    font-size: .8rem;
}

/* STATUS COLORS */
.status.pending { background: orange; color: black; }
.status.processing { background: #ffb703; color: black; }
.status.shipped { background: #219ebc; color: white; }
.status.delivered { background: #2a9d8f; color: white; }

.order-body {
    margin-top: 10px;
    color: #ccc;
}

.order-body .total {
    color: #D4AF37;
    font-weight: bold;
}

.order-actions {
    margin-top: 15px;
    display: flex;
    gap: 10px;
}
/* SEARCH BAR */
form input {
    background: #111;
    border: 1px solid #333;
    color: white;
}

/* PAGINATION */
.pagination .page-link {
    background: #141414;
    color: white;
    border: 1px solid #333;
}

.pagination .active .page-link {
    background: #D4AF37;
    border: none;
    color: black;
}
</style>
</head>

<body class="admin-body">

<div class="container py-4">

    <h2 class="admin-title">📦 Orders Management</h2>

    <a href="index.php" class="btn btn-outline-light mb-3">← Dashboard</a>

    <!-- =========================
         SEARCH BAR
    ========================== -->
    <form method="GET" class="mb-4 d-flex gap-2">
        <input type="text"
               name="search"
               value="<?= htmlspecialchars($search) ?>"
               class="form-control"
               placeholder="Search by Name, Phone, Order ID or Address">

        <button class="btn btn-warning">
            Search
        </button>
    </form>

    <!-- =========================
         ORDERS LIST
    ========================== -->
    <?php foreach($orders as $order): ?>

        <div class="admin-order-card <?= $order['status'] ?>">

            <div class="order-header">
                <div>
                    <h5>#<?= str_pad($order['id'], 5, '0', STR_PAD_LEFT) ?></h5>
                    <small><?= $order['created_at'] ?></small>
                </div>

                <span class="status <?= $order['status'] ?>">
                    <?= ucfirst($order['status']) ?>
                </span>
            </div>

            <div class="order-body">
                <p><strong>Name:</strong> <?= htmlspecialchars($order['customer_name']) ?></p>
                <p><strong>Phone:</strong> <?= htmlspecialchars($order['phone']) ?></p>
                <p><strong>Address:</strong> <?= htmlspecialchars($order['address']) ?></p>
                <p class="total">Total: TZS <?= number_format($order['total']) ?></p>
            </div>

            <div class="order-actions">

                <a href="?action=processing&id=<?= $order['id'] ?>" class="btn btn-warning btn-sm">Processing</a>

                <a href="?action=shipped&id=<?= $order['id'] ?>" class="btn btn-info btn-sm">Shipped</a>

                <a href="?action=delivered&id=<?= $order['id'] ?>" class="btn btn-success btn-sm">Delivered</a>

                <a href="?delete=<?= $order['id'] ?>"
                   class="btn btn-danger btn-sm"
                   onclick="return confirm('Delete this order permanently?')">
                   Delete
                </a>

            </div>

        </div>

    <?php endforeach; ?>

    <!-- =========================
         PAGINATION
    ========================== -->
    <nav class="mt-4">
        <ul class="pagination">

            <!-- Previous -->
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link"
                   href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">
                    Previous
                </a>
            </li>

            <!-- Pages -->
            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link"
                       href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

            <!-- Next -->
            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                <a class="page-link"
                   href="?page=<?= $page+1 ?>&search=<?= urlencode($search) ?>">
                    Next
                </a>
            </li>

        </ul>
    </nav>

</div>

</body>
</html>