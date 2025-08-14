<?php
require_once '../includes/db.php';
// session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Your Cart</title>
  <link rel="stylesheet" href="../assests/css/main.css">
</head>
<body>
  <div class="page-wrapper">
    <?php require_once '../components/header.php'; ?>

    <?php
    if (!isset($_SESSION['user_id'])) {
      echo "<main><p>Please <a href='login.php'>login</a> to view your cart.</p></main>";
      require_once '../components/footer.php';
      exit;
    }

    $userId = $_SESSION['user_id'];

    // Fetch cart items with product details
    $stmt = $pdo->prepare("
      SELECT c.id AS cart_id, c.quantity, c.added_at,
             p.id AS product_id, p.name, p.price, p.stock
      FROM cart c
      JOIN products p ON c.product_id = p.id
      WHERE c.user_id = ?
    ");
    $stmt->execute([$userId]);
    $cartItems = $stmt->fetchAll();
    $total = 0;
    ?>

    <main>
      <section class="cart">
        <h2>Your Cart 🛒</h2>

        <?php if (count($cartItems) === 0): ?>
          <p>Your cart is empty.</p>
        <?php else: ?>
          <table>
            <thead>
              <tr>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Subtotal</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($cartItems as $item): 
                $subtotal = $item['price'] * $item['quantity'];
                $total += $subtotal;
              ?>
                <tr>
                  <td><?= htmlspecialchars($item['name']) ?></td>
                  <td>₹<?= number_format($item['price'], 2) ?></td>
                  <td><?= $item['quantity'] ?></td>
                  <td>₹<?= number_format($subtotal, 2) ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>

          <p><strong>Total: ₹<?= number_format($total, 2) ?></strong></p>

          <form method="POST" action="../api/orders/place-order.php">
            <button type="submit">🧾 Place Order</button>
          </form>
        <?php endif; ?>
      </section>
    </main>

    <?php require_once '../components/footer.php'; ?>
  </div>
</body>
</html>
