<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order History</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 2rem;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 2rem;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 0.75rem;
      text-align: left;
    }
    .item-row td {
      background-color: #f9f9f9;
      padding-left: 2rem;
      font-size: 0.9rem;
      color: #555;
    }
    .order-row {
      background-color: #eef;
    }
  </style>
</head>
<body>
<div class="page-wrapper">
  <?php require_once '../components/header.php'; ?>

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

        const tbody = document.querySelector('#orderTable tbody');
        tbody.innerHTML = '';

        if (orders.length === 0) {
          document.getElementById('orderMsg').textContent = 'You have no orders yet.';
          return;
        }

        orders.forEach(order => {
          const itemRows = order.items.map(item => `
            <tr class="item-row">
              <td colspan="4">🛒 ${item.product_name} — Qty: ${item.quantity}, Price: ₹${item.price}</td>
            </tr>
          `).join('');

          tbody.innerHTML += `
            <tr class="order-row">
              <td><strong>${order.id}</strong></td>
              <td>₹${order.total}</td>
              <td>${order.status}</td>
              <td>${order.placed_at}</td>
            </tr>
            ${itemRows}
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
