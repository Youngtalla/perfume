<?php 
require_once '../includes/functions.php';

if($_POST) {
    $name = sanitize($_POST['name']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("INSERT INTO users (name, email, password, phone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $password, $phone]);
        $success = "Account created successfully! <a href='login.php' class='text-warning'>Login Now</a>";
    } catch(PDOException $e) {
        $error = "This email is already registered.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Mouhdy Perfumes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #0D0D0D 0%, #0F3D2E 100%);
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .auth-card {
            background: rgba(15, 61, 46, 0.95);
            border: 2px solid #D4AF37;
            border-radius: 24px;
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.8);
            padding: 50px 40px;
            max-width: 460px;
            margin: 0 auto;
        }
        .auth-card h2 {
            font-family: 'Cinzel', serif;
            color: #D4AF37;
            font-size: 2.2rem;
            text-align: center;
        }
        .form-control {
            background: rgba(255,255,255,0.08);
            border: 1px solid #D4AF37;
            color: white;
            padding: 14px 18px;
            border-radius: 12px;
        }
        .form-control:focus {
            background: rgba(255,255,255,0.15);
            border-color: #D4AF37;
            box-shadow: 0 0 0 4px rgba(212,175,55,0.2);
        }
        .btn-register {
            background: linear-gradient(to right, #D4AF37, #E8C670);
            color: #000;
            font-weight: 700;
            padding: 14px;
            border-radius: 12px;
            font-size: 1.1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 30px rgba(212,175,55,0.5);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="auth-card">
        <h2>Join Mouhdy</h2>
        <p class="text-center text-light mb-4">Start your luxury journey</p>

        <?php if(isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST">
            <div class="mb-3">
                <input type="text" name="name" class="form-control" placeholder="Full Name" required>
            </div>
            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="Email Address" required>
            </div>
            <div class="mb-3">
                <input type="tel" name="phone" class="form-control" placeholder="Phone Number" required>
            </div>
            <div class="mb-4">
                <input type="password" name="password" class="form-control" placeholder="Create Password" required>
            </div>
            <button type="submit" class="btn btn-register w-100">CREATE ACCOUNT</button>
        </form>

        <div class="text-center mt-4">
            <p class="text-light">Already have an account? 
                <a href="login.php" class="text-warning fw-bold">Login Here</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>