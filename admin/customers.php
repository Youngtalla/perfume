<?php 
require_once '../includes/functions.php';
if(!isAdmin()) { header("Location: login.php"); exit; }
require_once '../includes/db.php';

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
   QUERY FILTER
========================= */
$where = "";
$params = [];

if(!empty($search)) {
    $where = "WHERE name LIKE ? OR email LIKE ? OR phone LIKE ?";
    $params = ["%$search%", "%$search%", "%$search%"];
}

/* =========================
   COUNT
========================= */
$countStmt = $pdo->prepare("SELECT COUNT(*) FROM users $where");
$countStmt->execute($params);
$totalCustomers = $countStmt->fetchColumn();
$totalPages = ceil($totalCustomers / $limit);

/* =========================
   FETCH USERS
========================= */
$stmt = $pdo->prepare("SELECT * FROM users $where ORDER BY id DESC LIMIT $limit OFFSET $offset");
$stmt->execute($params);
$customers = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customers - Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
<style>
    .admin-title {
    color: #D4AF37;
    font-family: 'Cinzel', serif;
}

.table-dark {
    background: #141414;
}

.table-dark td, .table-dark th {
    border-color: #222;
}
</style>
</head>

<body class="admin-body">

<div class="container py-4">

    <h2 class="admin-title">👥 Customers</h2>

    <a href="index.php" class="btn btn-outline-light mb-3">← Dashboard</a>

    <!-- =========================
         SEARCH BAR
    ========================== -->
    <form method="GET" class="d-flex gap-2 mb-4">
        <input type="text"
               name="search"
               value="<?= htmlspecialchars($search) ?>"
               class="form-control"
               placeholder="Search name, email, phone...">

        <button class="btn btn-warning">Search</button>
    </form>

    <!-- =========================
         CUSTOMERS TABLE
    ========================== -->
    <div class="table-responsive">

        <table class="table table-dark table-hover">

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Joined</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($customers as $c): ?>
                <tr>
                    <td>#<?= $c['id'] ?></td>
                    <td><?= htmlspecialchars($c['name']) ?></td>
                    <td><?= htmlspecialchars($c['email']) ?></td>
                    <td><?= htmlspecialchars($c['phone']) ?></td>
                    <td><?= $c['created_at'] ?></td>

                    <td>
                        <a href="send_message.php?id=<?= $c['id'] ?>" class="btn btn-sm btn-info">
                            Message
                        </a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>

        </table>

    </div>

    <!-- =========================
         PAGINATION
    ========================== -->
    <nav>
        <ul class="pagination">

            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                <a class="page-link"
                   href="?page=<?= $page-1 ?>&search=<?= urlencode($search) ?>">
                    Prev
                </a>
            </li>

            <?php for($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link"
                       href="?page=<?= $i ?>&search=<?= urlencode($search) ?>">
                        <?= $i ?>
                    </a>
                </li>
            <?php endfor; ?>

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