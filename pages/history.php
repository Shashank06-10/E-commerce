<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="page-wrapper">
<?php
// require_once '../includes/session.php';
require_once '../components/header.php';
?>

<main>
  <section class="order-history">
    <h2>Your Order History 📦</h2>
    <table id="orderTable">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Total (₹)</th>
          <th>Status</th>
          <th>Placed At</th>
        </tr>
      </thead>
      <tbody>
        <!-- Orders will be injected here -->
      </tbody>
    </table>
    <p id="orderMsg"></p>
  </section>
</main>

<script>
async function loadOrders() {
  try {
    const res = await fetch('http://localhost/ecommerce-user/api/orders/get-orders.php');
    const orders = await res.json();
    console.log(orders)

    const tbody = document.querySelector('#orderTable tbody');
    tbody.innerHTML = '';

    if (orders.length === 0) {
      document.getElementById('orderMsg').textContent = 'You have no orders yet.';
      return;
    }

    orders.forEach(order => {
      tbody.innerHTML += `
        <tr>
          <td>${order.id}</td>
          <td>₹${order.total}</td>
          <td>${order.status}</td>
          <td>${order.placed_at}</td>
        </tr>
      `;
    });
  } catch (error) {
    document.getElementById('orderMsg').textContent = '⚠️ Failed to load orders.';
    console.error('Order history error:', error);
  }
}

loadOrders();
</script>

<?php require_once '../components/footer.php'; ?>

</div>
    
</body>
</html>