<footer>
  <div class="footer-container">
    <p>&copy; <?= date('Y') ?> RagulaMart. All rights reserved.</p>
    <nav class="footer-nav">
      <a href="/pages/about.php">About</a>
      <a href="/pages/contact.php">Contact</a>
      <a href="/pages/privacy.php">Privacy Policy</a>
    </nav>
  </div>
</footer>

<style>
footer {
  background-color: #222;
  color: #eee;
  padding: 20px 0;
  text-align: center;
  font-size: 14px;
}

.footer-container {
  max-width: 960px;
  margin: 0 auto;
  padding: 0 20px;
}

.footer-nav {
  margin-top: 10px;
}

.footer-nav a {
  color: #ccc;
  margin: 0 10px;
  text-decoration: none;
}

.footer-nav a:hover {
  color: #fff;
  text-decoration: underline;
}
html, body {
  height: 100%;
  margin: 0;
}

.page-wrapper {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
}

main {
  flex: 1;
}

</style>