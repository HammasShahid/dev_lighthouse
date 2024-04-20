<?php
$pdo = require_once '../db/connection.php';

session_start();
if (!isset($_SESSION['staff_account'])) {
  header("Location: staff-login.php");
}

$search = $_GET['search'] ?? '';

$fetchQuery = "SELECT * FROM reservation WHERE checked_in = '0' AND hidden = '0';";

if ($search) {
  $fetchQuery = "SELECT * FROM reservation WHERE checked_in = '0' AND hidden = '0' AND (name LIKE '%$search%' OR email LIKE '%$search%' OR phone LIKE '%$search%');";
}

$statement = $pdo->prepare($fetchQuery);
$statement->execute();
$reservations = $statement->fetchAll(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'];
  if (isset($_POST['check-in'])) {
    $statement = $pdo->prepare("UPDATE reservation SET checked_in = 1 WHERE id = :id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    // header("refresh:0");
    header("Location: checkin.php");
  } elseif (isset($_POST['no-show'])) {
    $statement = $pdo->prepare("UPDATE reservation SET hidden = 1 WHERE id = :id");
    $statement->bindValue(':id', $id);
    $statement->execute();

    header("Location: checkin.php");
    // header("refresh:0");
  }
}

?>


<?php require_once "../views/partials/header.php" ?>

<?php $prevLink = "dashboard.php" ?>
<?php require_once "../views/partials/checkin-header.php" ?>

<?php if ($search) : ?>
  <h2 class="search-query-text">Search: <span><?= $search ?></span></h2>
<?php endif; ?>
<?php if (empty($reservations)) : ?>
  <h2>No reservations found</h2>
<?php endif; ?>

<div class="container card-container">

  <?php foreach ($reservations as $reservation) : ?>
    <?php
    // var_dump($reservation);
    $dateInDb = $reservation['date'];
    $timeInDb = $reservation['time'];
    $dateTime = new DateTime("$dateInDb $timeInDb");
    ?>
    <div class="card">
      <p class="card__name"><?= $reservation['name']; ?></p>
      <p class="card__time"><?= $dateTime->format("h:i A"); ?></p>
      <p class="card__size">Party Size: <?= $reservation['guests']; ?></p>
      <form method="post" class="card-buttons">
        <input type="hidden" name="id" value="<?= $reservation['id']; ?>" />
        <input type="submit" name="check-in" value="Check In" class="btn btn--primary--outline" />
        <input type="submit" name="no-show" value="No Show" class="btn btn--primary--outline" />
      </form>
      <form data-contact-info-form class="contact-info-form" method="post">
        <input type="hidden" name="name" value="<?= $reservation['name'] ?>" />
        <input type="hidden" name="email" value="<?= $reservation['email'] ?>" />
        <input type="hidden" name="phone" value="<?= $reservation['phone'] ?>" />
        <button type="submit" type="button" class="btn btn--primary--outline">Contact Info</button>
      </form>
    </div>
  <?php endforeach; ?>
</div>

<?php include "../views/checkin/info-popup.php"; ?>

<script src="js/checkin.js"></script>
<?php require_once "../views/partials/staff-footer.php" ?>