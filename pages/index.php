<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ragula Shop</title>
</head>
<body>
<div class="page-wrapper">
<?php require_once '../components/header.php';?>
  <main>
    <section class="hero">
      <h1>Welcome to RagulaShop </h1>
      <p>Discover our latest products and exclusive deals!</p>
    </section>

    <section class="product-grid" id="product-list">
      <!-- Product cards will be injected here -->
    </section>
  </main>

  <?php require_once '../components/footer.php'; ?>


<script>
async function loadProducts() {
  try {
    const res = await fetch('http://localhost/ecommerce-user/api/products/get-products.php');
    const products = await res.json();

    const container = document.getElementById('product-list');
    container.innerHTML = '';

    products.forEach(product => {
      container.innerHTML += `
        <div class="product-card">
          <div class="product-info">
            <h3>${product.name}</h3>
            <p class="price">₹${product.price}</p>
            <a href="product.php?id=${product.id}" class="view-btn">View Details</a>
          </div>
        </div>
      `;
    });
  } catch (error) {
    container.innerHTML = '<p> Failed to load products.</p>';
    console.error('Product load error:', error);
  }
}

loadProducts();
</script>
</div>
</body>
</html>