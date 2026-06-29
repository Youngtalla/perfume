<?php 
require_once '../includes/functions.php';
if(!isAdmin()) { header("Location: login.php"); exit; }
require_once '../includes/db.php';

$message = '';

// Add New Blog Post
if($_POST && isset($_POST['add_blog'])) {
    $title = sanitize($_POST['title']);
    $content = $_POST['content']; // Allow HTML
    $category = sanitize($_POST['category']);
    
    $stmt = $pdo->prepare("INSERT INTO blog_posts (title, content, category, author) VALUES (?, ?, ?, 'Admin')");
    $stmt->execute([$title, $content, $category]);
    $message = "Blog post published successfully!";
}

// Fetch all posts
$posts = $pdo->query("SELECT * FROM blog_posts ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Blog Management - Mouhdy Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body class="bg-dark text-light">
<div class="container-fluid py-4">
    <h2>Blog Management</h2><br>
     <a href="index.php" class="btn btn-outline-light">← Back to Dashboard</a>
     <br>
    <?php if($message) echo "<div class='alert alert-success'>$message</div>"; ?>

    <!-- Add New Post -->
    <div class="card glass p-4 mb-5">
        <h4>Add New Blog Post</h4>
        <form method="POST">
            <input type="text" name="title" class="form-control mb-3" placeholder="Blog Title" required>
            <select name="category" class="form-control mb-3">
                <option value="Arabic Perfumes">Arabic Perfumes</option>
                <option value="Men Fragrances">Men Fragrances</option>
                <option value="Women Fragrances">Women Fragrances</option>
                <option value="Tips & Guides">Tips & Guides</option>
            </select>
            <textarea name="content" class="form-control mb-3" rows="8" placeholder="Write your blog content here..."></textarea>
            <button type="submit" name="add_blog" class="btn btn-gold">Publish Post</button>
        </form>
    </div>

    <!-- Existing Posts -->
    <h4>Published Posts</h4>
    <table class="table table-dark">
        <thead>
            <tr>
                <th>Title</th>
                <th>Category</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($posts as $post): ?>
            <tr>
                <td><?=htmlspecialchars($post['title'])?></td>
                <td><?=htmlspecialchars($post['category'])?></td>
                <td><?= $post['created_at'] ?></td>
                <td>
                    <a href="#" class="btn btn-sm btn-primary">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>