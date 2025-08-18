<?php
require_once '../../includes/db.php';
header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT id, name, price FROM products ORDER BY id DESC");
    $products = $stmt->fetchAll();

    echo json_encode($products);
} catch (PDOException $e) {
    echo json_encode([
        'error' => true,
        'message' => 'Failed to fetch products',
        'details' => $e->getMessage()
    ]);
}
