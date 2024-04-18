<?php
require_once "../views/partials/header.php";
$prevLink = "reservation-contact.php";
require_once "../views/partials/reservation-header.php";
?>

<div class="content-container success-container">
  <i class="success-icon fas fa-check-circle"></i>
  <p class="heading--container">Reservation Success</p>
  <div class="success-text">
    <p>We look forward to serving you soon. </p>
    <p>Please find a confirmation in your email.</p>
  </div>
  <a href="index.php" class="btn btn--primary success-home-btn">Home</a>
</div>

<?php require_once "../views/partials/footer.php" ?>