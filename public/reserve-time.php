<?php

session_start();
if (empty($_SESSION['reservation'])) {
  header("Location: reserve.php");
}

$pdo = require_once '../db/connection.php';

['date' => $date, 'time' => $time, 'guests' => $guests, 'location' => $location] = $_SESSION['reservation'];

$reservesInDb = [];
if (empty($errors)) {
  $statement = $pdo->prepare("SELECT * FROM reservation WHERE date = :date AND time = :time");
  $statement->bindValue(':date', $date);
  $statement->bindValue(':time', $time);
  $statement->execute();
  $reservesInDb = $statement->fetchAll(PDO::FETCH_ASSOC);

  // foreach($reservesInDb )
  // $statement = $pdo->prepare("INSERT INTO reservation (guests, date, time, location) VALUES (:guests, :date, :time, :location)");
  // $statement->bindValue(':guests', $guests);
  // $statement->bindValue(':date', $date);
  // $statement->bindValue(':time', $time);
  // $statement->bindValue(':location', $location);
  $dateTime = new DateTime("$date $time");
}
?>

<?php require_once "../views/partials/header.php" ?>
<?php $prevLink = "reserve.php" ?>
<?php require_once "../views/partials/reservation-header.php" ?>

<?= "date: $date" ?>
<?= "time: $time" ?>
<div class="content-container">
  <h2>Pick Your Time</h2>
  <?php if (count($reservesInDb)) {  ?>
    Sorry your selected time is not available
  <?php } else { ?>
    <div class="reserve-available-times">
      <form action="" method="post">
        <input type="hidden" value="<?= $time ?>" />
        <button type="submit">
          <p><?= $dateTime->format("g:i A"); ?></p>
          <p>Table</p>
        </button>
      </form>
    </div>
  <?php } // end else 
  ?>
</div>

<?php require_once "../views/partials/footer.php" ?>