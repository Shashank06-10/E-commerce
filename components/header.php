
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Ragula's eCommerce</title>
  <link rel="stylesheet" href="../assests/css/main.css">
  <!-- <link rel="stylesheet" href="../assets/css/responsive.css"> -->
</head>
<body>
  <header>
    <div class="logo">
      <a href="index.php">🛍️ RagulaShop</a>
    </div>
    <nav>
      <ul>
        <li><a href="index.php">Products</a></li>
        <li><a href="cart.php">Cart</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="history.php">Order History</a></li>
          <li><a href="../api/auth/logout.php">Logout</a></li>
        <?php else: ?>
          <li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </header>
