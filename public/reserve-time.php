<?php

session_start();
if (empty($_SESSION['reservation'])) {
  header("Location: reserve.php");
}

$pdo = require_once '../db/connection.php';

['date' => $date, 'time' => $time, 'guests' => $guests, 'location' => $location] = $_SESSION['reservation'];

$reservesInDb = [];
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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $selectedTime = $_POST['time'];

  $newDateTime = new DateTime("$date $selectedTime");
  $_SESSION['reservation']['time'] = $newDateTime->format("H:i");

  header("Location: reservation-contact.php");
}
?>

<?php require_once "../views/partials/header.php" ?>
<?php $prevLink = "reserve.php" ?>
<?php require_once "../views/partials/reservation-header.php" ?>

<div class="reserve-time-container content-container">
  <h2>Pick Your Time</h2>
  <div class="reserve-availability-container">
    <div class="time-availability">
      <form action="" method="post">
        <input name="time" type="hidden" value="<?= $time ?>" />
        <button class="btn time-choice-button" type="submit">
          <p><?= $dateTime->format("g:i A"); ?></p>
          <p class="seating-spot">Table</p>
        </button>
      </form>
    </div>
  </div>
</div>

<?php require_once "../views/partials/footer.php" ?>