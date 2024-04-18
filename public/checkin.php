<?php

session_start();
if (!isset($_SESSION['staff_account'])) {
  header("Location: staff-login.php");
}

?>


<?php require_once "../views/partials/header.php" ?>

<?php $prevLink = "dashboard.php" ?>
<?php require_once "../views/partials/checkin-header.php" ?>

<div class="container card-container">
  <div class="card">
    <p class="card__name">Matthew Martinez</p>
    <p class="card__time">7:55 PM</p>
    <p class="card__size">Party Size: 2</p>
    <form method="post" class="card-buttons">
      <input type="submit" name="check-in" value="Check In" class="btn btn--primary--outline" />
      <input type="submit" name="no-show" value="No Show" class="btn btn--primary--outline" />
      <input type="submit" name="contact-info" value="Contact Info" class="btn btn--primary--outline" />
    </form>
  </div>
</div>
<?php require_once "../views/partials/staff-footer.php" ?>