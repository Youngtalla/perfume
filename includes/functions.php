<?php
session_start();
require_once 'db.php';

function isAdmin() {
    return isset($_SESSION['admin_id']);
}

function sanitize($data) {
    global $pdo;
    return htmlspecialchars(strip_tags(trim($data)));
}

// Get Setting Value
function getSetting($key, $default = '') {
    global $pdo;
    $stmt = $pdo->prepare("SELECT setting_value FROM settings WHERE setting_key = ?");
    $stmt->execute([$key]);
    $result = $stmt->fetchColumn();
    return $result !== false ? $result : $default;
}
?>