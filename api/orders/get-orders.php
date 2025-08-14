<?php
require_once '../../includes/db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
  echo json_encode([]);
  exit;
}

$userId = $_SESSION['user_id'];

try {
  $stmt = $pdo->prepare("SELECT id, total, status, placed_at FROM orders WHERE user_id = ? ORDER BY placed_at DESC");
  $stmt->execute([$userId]);
  $orders = $stmt->fetchAll();

  echo json_encode($orders);
} catch (PDOException $e) {
  echo json_encode([]);
  error_log("Order history error: " . $e->getMessage());
}
