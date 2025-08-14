<?php
require_once '../../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header('Location: login.php');
  exit;
}

$userId = $_SESSION['user_id'];

// Fetch cart items
$stmt = $pdo->prepare("
  SELECT c.product_id, c.quantity, p.price, p.stock
  FROM cart c
  JOIN products p ON c.product_id = p.id
  WHERE c.user_id = ?
");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll();

if (count($cartItems) === 0) {
  echo "<main><p>Your cart is empty. <a href='products.php'>Shop now</a>.</p></main>";
  require_once '../components/footer.php';
  exit;
}

// Calculate total and validate stock
$total = 0;
foreach ($cartItems as $item) {
  if ($item['quantity'] > $item['stock']) {
    echo "<main><p>⚠️ Not enough stock for product ID {$item['product_id']}.</p></main>";
    require_once '../components/footer.php';
    exit;
  }
  $total += $item['price'] * $item['quantity'];
}

$pdo->beginTransaction();

try {
  // Insert order
  $placedAt = date('Y-m-d H:i:s');
  $status = 'Pending';

  $stmt = $pdo->prepare("INSERT INTO orders (user_id, total, status, placed_at) VALUES (?, ?, ?, ?)");
  $stmt->execute([$userId, $total, $status, $placedAt]);
  $orderId = $pdo->lastInsertId();

  // Deduct stock
  foreach ($cartItems as $item) {
    $stmt = $pdo->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
    $stmt->execute([$item['quantity'], $item['product_id']]);
  }

  // Clear cart
  $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = ?");
  $stmt->execute([$userId]);

  $pdo->commit();

  echo "
<main>
  <p>✅ Order placed successfully! Your order ID is <strong>$orderId</strong>.</p>
  <p>Redirecting to homepage...</p>
</main>
<script>
  setTimeout(() => {
    window.location.href = 'http://localhost/ecommerce-user/pages/index.php'
  }, 3000); // Redirect after 3 seconds
</script>
";

} catch (Exception $e) {
  $pdo->rollBack();
  echo "<main><p>❌ Failed to place order. Please try again later.</p></main>";
  error_log("Order error: " . $e->getMessage());
}

// require_once '../components/footer.php';
