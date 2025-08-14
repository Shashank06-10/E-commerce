<?php
require_once '../../includes/db.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
  echo json_encode(['success' => false, 'message' => 'You must be logged in to add items to your cart.']);
  exit;
}

$userId = $_SESSION['user_id'];
$productId = $_POST['product_id'] ?? null;
$quantity = $_POST['quantity'] ?? 1;

if (!$productId || $quantity < 1) {
  echo json_encode(['success' => false, 'message' => 'Invalid product or quantity.']);
  exit;
}

// Check if product exists and has enough stock
$stmt = $pdo->prepare("SELECT stock FROM products WHERE id = ?");
$stmt->execute([$productId]);
$product = $stmt->fetch();

if (!$product) {
  echo json_encode(['success' => false, 'message' => 'Product not found.']);
  exit;
}

if ($quantity > $product['stock']) {
  echo json_encode(['success' => false, 'message' => 'Requested quantity exceeds available stock.']);
  exit;
}

// Check if item already in cart
$stmt = $pdo->prepare("SELECT quantity FROM cart WHERE user_id = ? AND product_id = ?");
$stmt->execute([$userId, $productId]);
$existing = $stmt->fetch();

$now = date('Y-m-d H:i:s');

if ($existing) {
  // Update quantity and timestamp
  $newQuantity = $existing['quantity'] + $quantity;
  if ($newQuantity > $product['stock']) {
    echo json_encode(['success' => false, 'message' => 'Total quantity exceeds available stock.']);
    exit;
  }

  $stmt = $pdo->prepare("UPDATE cart SET quantity = ?, added_at = ? WHERE user_id = ? AND product_id = ?");
  $stmt->execute([$newQuantity, $now, $userId, $productId]);
} else {
  // Insert new cart item
  $stmt = $pdo->prepare("INSERT INTO cart (user_id, product_id, quantity, added_at) VALUES (?, ?, ?, ?)");
  $stmt->execute([$userId, $productId, $quantity, $now]);
}

echo json_encode(['success' => true, 'message' => '✅ Product added to cart.']);
