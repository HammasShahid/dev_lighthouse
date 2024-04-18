<?php

session_start();

if (!isset($_SESSION['staff_account'])) {
  header("Location: index.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // $_SESSION['staff_account'] = false;
  session_destroy();
  header("Location: staff-login.php");
}

?>

<?php require_once "../views/partials/header.php" ?>

<div class="container ">
  <div class="dashboard-container">

    <h2 class="dashboard-heading">Lighthouse Central</h2>
    <div class="dashboard-buttons">
      <a class="btn btn--primary" href="checkin.php">Reservation Check-In</a>
      <form method="post">
        <button type="submit" class="btn btn--primary dashboard-logout-btn">Log-Out</button>
      </form>
    </div>
  </div>
</div>

<?php require_once "../views/partials/staff-footer.php" ?>