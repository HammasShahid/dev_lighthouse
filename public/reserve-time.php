<?php

session_start();
if (empty($_SESSION['reservation'])) {
  header("Location: reserve.php");
}

$pdo = require_once '../db/connection.php';

$tableLimit = 5;
$barLimit = 5;

function getReservesInDb($date, $time, $seating_location)
{
  global $pdo;

  $statement =
    $pdo->prepare(
      "SELECT * FROM reservation 
    WHERE date = :date AND seating_location = :seating_location AND ((time >= :time AND time < :end_time) OR (end_time > :time AND end_time <= :end_time))"
    );
  $statement->bindValue(':date', $date);
  $statement->bindValue(':seating_location', $seating_location);
  $statement->bindValue(':time', $time);

  $timestamp = strtotime($time);
  $end_timestamp = $timestamp + 60 * 60;
  $end_time = date("H:i", $end_timestamp);
  // echo $end_time;

  $statement->bindValue(':end_time', $end_time);

  $statement->execute();
  return $statement->fetchAll(PDO::FETCH_ASSOC);
}

function getAvailabilityList($date, $time, $limit, $seating_location)
{
  $availabilityList = [];
  for ($i = 0; count($availabilityList) < 2; $i++) {

    $timeIncrement = (60 * 10) * $i;
    $timestamp = strtotime($time);
    $timeInterval = date("H:i", $timestamp + $timeIncrement);

    $reservesInDb = getReservesInDb($date, $timeInterval, $seating_location);
    $available = true;
    if (count($reservesInDb) >= $limit) {
      $available = false;
    }
    if ($available) {
      // $availabilityList[] = $time + $timeIncrement;
      $availabilityList[] = $timeInterval;
    }
  }

  return $availabilityList;
}

function getAvailableDates($date, $time, $tableLimit, $barLimit)
{
  global $pdo;

  $availableDates = [];
  for ($i = 1; count($availableDates) < 4; $i++) {

    $statement =
      $pdo->prepare(
        "SELECT * FROM reservation 
      WHERE date = :date AND time = :time"
      );

    $newDate = date("Y-m-d", strtotime($date) + ($i * 24 * 60 * 60));

    $statement->bindValue(':date', $newDate);
    $statement->bindValue(':time', $time);

    $statement->execute();
    $reservations = $statement->fetchAll(PDO::FETCH_ASSOC);

    $available = true;
    if (count($reservations) >= ($tableLimit + $barLimit)) {
      $available = false;
    }

    if ($available) {
      $availableDates[] = $newDate;
    }
  }
  return $availableDates;
}

['date' => $date, 'time' => $time, 'guests' => $guests, 'location' => $location] = $_SESSION['reservation'];

$tableAvailabilityList = getAvailabilityList($date, $time, $tableLimit, 'table');
$barAvailabilityList = getAvailabilityList($date, $time, $tableLimit, 'bar');

//
//
//
$dateTime = new DateTime("$date $time");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['date'])) {
    $_SESSION['reservation']['date'] = $_POST['date'];

    header("Location: reserve-time.php");
  } else {

    $selectedTime = $_POST['time'];
    $selectedSpot = $_POST['seating_location'];

    $newDateTime = new DateTime("$date $selectedTime");
    $_SESSION['reservation']['time'] = $newDateTime->format("H:i");
    $_SESSION['reservation']['end_time'] = date("H:i", strtotime($selectedTime) + (60 * 60));
    $_SESSION['reservation']['seating_location'] = $selectedSpot;

    header("Location: reservation-contact.php");
  }
}
?>

<?php require_once "../views/partials/header.php" ?>
<?php $prevLink = "reserve.php" ?>
<?php require_once "../views/partials/reservation-header.php" ?>

<div class="reserve-time-container content-container">
  <h2>Pick Your Time</h2>
  <div class="reserve-availability-container">
    <div class="availability-options">
      <?php
      $seating_spot = 'table';
      foreach ($tableAvailabilityList as $availableTime) {
        include "../views/reserve-time/time-availability-option.php";
      }
      $seating_spot = 'bar';
      foreach ($barAvailabilityList as $availableTime) {
        include "../views/reserve-time/time-availability-option.php";
      }
      ?>
    </div>

    <p class="date-availability-text">Other dates with availability at <?= $dateTime->format('h:i A'); ?></p>
    <div class="availability-options">
      <?php
      foreach (getAvailableDates($date, $time, $tableLimit, $barLimit) as $date) {
        include "../views/reserve-time/date-availability-option.php";
      }
      ?>
    </div>
  </div>
</div>

<?php require_once "../views/partials/footer.php" ?>