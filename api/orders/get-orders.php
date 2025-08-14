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
  // Fetch orders
  $stmt = $pdo->prepare("
    SELECT id, total, status, placed_at
    FROM orders
    WHERE user_id = ?
    ORDER BY placed_at DESC
  ");
  $stmt->execute([$userId]);
  $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // If no orders, return empty
  if (count($orders) === 0) {
    echo json_encode([]);
    exit;
  }

  // Get all order IDs
  $orderIds = array_column($orders, 'id');
  $inClause = implode(',', array_fill(0, count($orderIds), '?'));

  // Fetch order items with product names
  $stmt = $pdo->prepare("
    SELECT oi.order_id, oi.product_id, oi.quantity, oi.price, p.name AS product_name
    FROM order_items oi
    JOIN products p ON oi.product_id = p.id
    WHERE oi.order_id IN ($inClause)
  ");
  $stmt->execute($orderIds);
  $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

  // Group items by order_id
  $groupedItems = [];
  foreach ($items as $item) {
    $groupedItems[$item['order_id']][] = $item;
  }

  // Attach items to orders
  foreach ($orders as &$order) {
    $order['items'] = $groupedItems[$order['id']] ?? [];
  }

  echo json_encode($orders);
} catch (PDOException $e) {
  echo json_encode([]);
  error_log("Order history error: " . $e->getMessage());
}
