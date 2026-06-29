<?php 
require_once '../includes/functions.php';
if(!isAdmin()) { header("Location: login.php"); exit; }
require_once '../includes/db.php';

$message = '';

// Add / Update Product
if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $name = sanitize($_POST['name']);
    $price = (float)$_POST['price'];
    $description = sanitize($_POST['description']);
    $top_notes = sanitize($_POST['top_notes']);
    $middle_notes = sanitize($_POST['middle_notes']);
    $base_notes = sanitize($_POST['base_notes']);
    $longevity = sanitize($_POST['longevity']);
    $gender = sanitize($_POST['gender']);

    $image = $_POST['old_image'] ?? 'placeholder.jpg';
    
    if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image = time() . '.' . $ext;
        move_uploaded_file($_FILES['image']['tmp_name'], '../uploads/' . $image);
    }

    if($id > 0) {
        // Update
        $stmt = $pdo->prepare("UPDATE products SET name=?, price=?, description=?, image=?, top_notes=?, middle_notes=?, base_notes=?, longevity=?, gender=? WHERE id=?");
        $stmt->execute([$name, $price, $description, $image, $top_notes, $middle_notes, $base_notes, $longevity, $gender, $id]);
        $message = "Product updated successfully!";
    } else {
        // Insert
        $stmt = $pdo->prepare("INSERT INTO products (name, price, description, image, top_notes, middle_notes, base_notes, longevity, gender) VALUES (?,?,?,?,?,?,?,?,?)");
        $stmt->execute([$name, $price, $description, $image, $top_notes, $middle_notes, $base_notes, $longevity, $gender]);
        $message = "Product added successfully!";
    }
}

// Delete
if(isset($_GET['delete'])) {
    $pdo->prepare("DELETE FROM products WHERE id = ?")->execute([$_GET['delete']]);
    $message = "Product deleted!";
}

// Fetch all products
$products = $pdo->query("SELECT * FROM products ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Products - Mouhdy Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container-fluid py-4">
    <h2>Products Management</h2>
    <?php if($message) echo "<div class='alert alert-success'>$message</div>"; ?>

    <!-- Add / Edit Form -->
    <div class="card glass p-4 mb-5">
        <h4><?= isset($_GET['edit']) ? 'Edit Product' : 'Add New Product' ?></h4>
        <form method="POST" enctype="multipart/form-data">
            <?php if(isset($_GET['edit'])): 
                $editProduct = $pdo->prepare("SELECT * FROM products WHERE id = ?");
                $editProduct->execute([$_GET['edit']]);
                $p = $editProduct->fetch();
            ?>
                <input type="hidden" name="id" value="<?= $p['id'] ?>">
                <input type="hidden" name="old_image" value="<?= $p['image'] ?>">
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <input type="text" name="name" class="form-control mb-3" placeholder="Product Name" value="<?= $p['name'] ?? '' ?>" required>
                    <input type="number" name="price" class="form-control mb-3" placeholder="Price (TZS)" value="<?= $p['price'] ?? '' ?>" required>
                </div>
                <div class="col-md-6">
                    <input type="file" name="image" class="form-control mb-3">
                    <select name="gender" class="form-control mb-3">
                        <option value="Unisex" <?= ($p['gender']??'')=='Unisex'?'selected':'' ?>>Unisex</option>
                        <option value="Men" <?= ($p['gender']??'')=='Men'?'selected':'' ?>>Men</option>
                        <option value="Women" <?= ($p['gender']??'')=='Women'?'selected':'' ?>>Women</option>
                    </select>
                </div>
            </div>

            <textarea name="description" class="form-control mb-3" placeholder="Description"><?= $p['description'] ?? '' ?></textarea>
            
            <div class="row">
                <div class="col-md-3"><input type="text" name="top_notes" class="form-control mb-3" placeholder="Top Notes" value="<?= $p['top_notes'] ?? '' ?>"></div>
                <div class="col-md-3"><input type="text" name="middle_notes" class="form-control mb-3" placeholder="Middle Notes" value="<?= $p['middle_notes'] ?? '' ?>"></div>
                <div class="col-md-3"><input type="text" name="base_notes" class="form-control mb-3" placeholder="Base Notes" value="<?= $p['base_notes'] ?? '' ?>"></div>
                <div class="col-md-3"><input type="text" name="longevity" class="form-control mb-3" placeholder="Longevity" value="<?= $p['longevity'] ?? '' ?>"></div>
            </div>

            <button type="submit" class="btn btn-gold">Save Product</button>
        </form>
    </div>

    <!-- Products List -->
    <h4>All Products</h4>
    <table class="table table-dark table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Gender</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
            <tr>
                <td><img src="../uploads/<?=htmlspecialchars($product['image'])?>" width="60" height="60"></td>
                <td><?=htmlspecialchars($product['name'])?></td>
                <td>TZS <?=number_format($product['price'])?></td>
                <td><?= $product['gender'] ?></td>
                <td>
                    <a href="?edit=<?= $product['id'] ?>" class="btn btn-sm btn-primary">Edit</a>
                    <a href="?delete=<?= $product['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this product?')">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>