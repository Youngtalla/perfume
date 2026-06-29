<?php
// Windows / XAMPP Fix
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'localhost';
$db   = 'mouhdy_perfumes';
$user = 'root';
$pass = '';           // ← Change if you set password

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Database Connection Error: " . $e->getMessage());
}
?>

<?php
$host = 'localhost';
$db   = 'mouhdy_perfumes';
$user = 'root';
$pass = '';   // change as needed

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
?>