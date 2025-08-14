<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LOGIN</title>
</head>
<body>
<div class="page-wrapper">
<?php
require_once '../includes/db.php';
// require_once '../includes/session.php';
require_once '../components/header.php';
// session_start();
$loginMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email    = trim($_POST['email'] ?? '');
  $password = $_POST['password'] ?? '';

  if ($email && $password) {
    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
      $_SESSION['user_id'] = $user['id'];

      // ✅ Redirect to homepage after successful login
      header("Location: index.php");
      exit;
    } else {
      $loginMsg = '⚠️ Invalid email or password.';
    }
  } else {
    $loginMsg = '⚠️ Both fields are required.';
  }
}
?>

<main>
  <h2 class="title">Login to Your Account</h2>
  <form method="POST" action="" class="auth-form">
  <label for="email">Email Address</label>
  <input type="email" id="email" name="email" placeholder="Email Address" required />

  <label for="password">Password</label>
  <input type="password" id="password" name="password" placeholder="Password" required />

  <button type="submit">Login</button>
  <p>Don't have an account? <a href="register.php">Register here</a></p>
</form>

  <?php if ($loginMsg): ?>
    <p class="form-message"><?= htmlspecialchars($loginMsg) ?></p>
  <?php endif; ?>
</main>

<?php require_once '../components/footer.php'; ?>

</div>
</body>
</html>