<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Products</title>
</head>
<body>
  <div class = "page-wrapper">
  <?php
require_once '../includes/db.php';
require_once '../components/header.php';

$product = null;
$productId = $_GET['id'] ?? null;

if ($productId) {
  $stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
  $stmt->execute([$productId]);
  $product = $stmt->fetch();
}

if (!$product) {
  echo "<main><p>Product not found.</p></main>";
  require_once '../components/footer.php';
  exit;
}
?>

<main>
  <section class="product-detail">
    <div class="product-info">
      <h2><?= htmlspecialchars($product['name']) ?></h2>
      <p class="price">₹<?= number_format($product['price'], 2) ?></p>
      <p class="description"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
      <p class="stock">Stock: <?= $product['stock'] ?></p>

      <?php if (isset($_SESSION['user_id'])): ?>
        <form id="addToCartForm">
          <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
          <label for="quantity">Quantity:</label>
          <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $product['stock'] ?>" required>
          <button type="submit">Add to Cart</button>
        </form>
        <p id="cartMsg"></p>
      <?php else: ?>
        <p><a href="login.php">Login</a> to add this product to your cart.</p>
      <?php endif; ?>
    </div>
  </section>
</main>

<script>
document.getElementById('addToCartForm')?.addEventListener('submit', async function(e) {
  e.preventDefault();
  const formData = new FormData(this);
  document.getElementById('cartMsg').textContent = '';
  try {
    const res = await fetch('http://localhost/ecommerce-user/api/cart/add-to-cart.php', {
      method: 'POST',
      body: formData
    });
    const data = await res.json();
    document.getElementById('cartMsg').textContent = data.message;
  } catch (error) {
    document.getElementById('cartMsg').textContent = 'Failed to add to cart.';
    console.error('Cart error:', error);
  }
});
</script>

<?php require_once '../components/footer.php'; ?>
  </div>
</body>
</html>
