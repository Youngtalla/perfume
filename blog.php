<?php require_once 'includes/functions.php'; ?>
<?php include 'includes/header.php'; ?>

<div class="container py-5 mt-5">
    <h1 class="text-center text-gold mb-5">Mouhdy Blog</h1>
    
    <div class="row g-4">
        <?php
        $posts = $pdo->query("SELECT * FROM blog_posts ORDER BY id DESC LIMIT 6")->fetchAll();
        foreach($posts as $post):
        ?>
        <div class="col-md-6">
            <div class="card glass h-100">
                <div class="card-body">
                    <span class="badge bg-warning"><?= htmlspecialchars($post['category']) ?></span>
                    <h4 class="mt-3"><?= htmlspecialchars($post['title']) ?></h4>
                    <p><?= substr(strip_tags($post['content']), 0, 150) ?>...</p>
                    <a href="#" class="text-gold">Read More →</a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>