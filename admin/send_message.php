<?php 
require_once '../includes/functions.php';
if(!isAdmin()) { header("Location: login.php"); exit; }
require_once '../includes/db.php';

$id = (int)$_GET['id'];

/* GET CUSTOMER */
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if(!$user) die("Customer not found");

/* SEND MESSAGE */
if($_POST) {

    $title = sanitize($_POST['title']);
    $message = sanitize($_POST['message']);

    /* SAVE MESSAGE IN SYSTEM */
    $stmt = $pdo->prepare("
        INSERT INTO messages (customer_id, title, message)
        VALUES (?, ?, ?)
    ");
    $stmt->execute([$id, $title, $message]);

    /* OPTIONAL EMAIL SEND */
    if(!empty($user['email'])) {
        mail(
            $user['email'],
            $title,
            $message,
            "From: Mouhdy Perfumes <no-reply@yourstore.com>"
        );
    }

    $success = "Message sent successfully!";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Send Message</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

<body class="bg-dark text-light">

<div class="container py-5">

    <h2>Send Message to <?= htmlspecialchars($user['name']) ?></h2>

    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST" class="card p-4 bg-dark">

        <input type="text"
               name="title"
               class="form-control mb-3"
               placeholder="Message Title"
               required>

        <textarea name="message"
                  class="form-control mb-3"
                  rows="6"
                  placeholder="Write your message..."
                  required></textarea>

        <button class="btn btn-warning">Send Message</button>

    </form>

</div>

</body>
</html>