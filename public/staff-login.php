<?php

session_start();
if (isset($_SESSION['staff_account'])) {
  header("Location: dashboard.php");
}

$constants = require_once "../helpers/constants.php";
['staffPassword' => $staffPassword] = $constants;

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $accessKey = $_POST['access-key'] ?? '';
  if (!$accessKey) {
    $errors[] = 'Please enter the access key';
  } else {
    if ($accessKey === $staffPassword) {
      $_SESSION['staff_account'] = true;
      header("Location: dashboard.php");
    } else {
      $errors[] = 'Wrong access key';
    }
  }
}

?>

<?php require_once "../views/partials/header.php" ?>

<div class="container back-btn">
  <a href="index.php" class="btn btn--primary">Home</a>
</div>

<div class="staff-login-page">
  <div class="content-container content-logo-container">
    <img src="images/logo.png" />
    <form class="access-key-form" method="post">
      <div class="staff-form-group">
        <label>Access Key</label>
        <input name="access-key" type="password" class="staff-login-input" />
        <?php if (count($errors)) : ?>
          <div>
            <?php foreach ($errors as $error) : ?>
              <p><?= $error ?></p>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>
      <button type="submit" class="btn--primary staff-login-btn">Login</button>
    </form>
  </div>
</div>