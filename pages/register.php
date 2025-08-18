<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>REGISTER</title>
</head>
<body>
<div class="page-wrapper">
<?php
require_once '../includes/db.php';
require_once '../components/header.php';

$registerMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name     = trim($_POST['name'] ?? '');
  $email    = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($name && $email && $password) {
    $hashed = password_hash($password, PASSWORD_DEFAULT);

    try {
      $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
      $stmt->execute([$name, $email, $hashed]);

      header("Location: login.php");
      exit;
    } catch (PDOException $e) {
      $registerMsg = 'Email already exists or registration failed.';
    }
  } else {
    $registerMsg = 'All fields are required.';
  }
}
?>

<main>
  <h2 class="rtitle">Create Your Account</h2>
  <form method="POST" action="" class="auth-form">
  <label for="name">Full Name</label>
  <input type="text" id="name" name="name" placeholder="Full Name" required />

  <label for="email">Email Address</label>
  <input type="email" id="email" name="email" placeholder="Email Address" required />

  <label for="password">Password</label>
  <input type="password" id="password" name="password" placeholder="Password" required />

  <button type="submit">Register</button>
  <p>Already have an account? <a href="login.php">Login here</a></p>
</form>

  <?php if ($registerMsg): ?>
    <p class="form-message"><?= htmlspecialchars($registerMsg) ?></p>
  <?php endif; ?>
</main>

<?php require_once '../components/footer.php'; ?>

</div>
</body>
</html>
