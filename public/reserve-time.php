<?php

session_start();
if (empty($_SESSION['reservation'])) {
  header("Location: reserve.php");
}

$pdo = require_once '../db/connection.php';
$constants = require_once '../helpers/constants.php';

// $tableLimit = 5;
// $barLimit = 5;

['tableLimit' => $tableLimit, 'barLimit' => $barLimit, 'maxReservationTime' => $maxReservationTime, 'closingTime' => $closingTime] = $constants;

function getReservesInDb($date, $time, $maxReservationTime, $seating_location)
{
  global $pdo;

  $statement =
    $pdo->prepare(
      "SELECT * FROM reservation 
    WHERE date = :date AND seating_location = :seating_location AND checked_in = '0' AND hidden = '0' AND ((time >= :time AND time < :end_time) OR (end_time > :time AND end_time <= :end_time))"
    );
  $statement->bindValue(':date', $date);
  $statement->bindValue(':seating_location', $seating_location);
  $statement->bindValue(':time', $time);

  $timestamp = strtotime($time);
  $end_timestamp = $timestamp + $maxReservationTime;
  $end_time = date("H:i", $end_timestamp);
  // echo $end_time;

  $statement->bindValue(':end_time', $end_time);

  $statement->execute();
  return $statement->fetchAll(PDO::FETCH_ASSOC);
}

// get available time slots
function getAvailabilityList($date, $time, $maxReservationTime, $limit, $seating_location, $closingTime)
{
  $availabilityList = [];
  for ($i = 0; count($availabilityList) < 2; $i++) {

    $timeIncrement = (60 * 10) * $i;
    $timestamp = strtotime($time);
    $timeInterval = $timestamp + $timeIncrement;
    $timeSlot = date("H:i", $timeInterval);

    if ($timeInterval > strtotime($closingTime) - $maxReservationTime) {
      break;
    }

    $reservesInDb = getReservesInDb($date, $timeSlot, $maxReservationTime, $seating_location);
    // $available = true;
    // if (count($reservesInDb) >= $limit) {
    //   $available = false;
    // }
    // if ($available) {
    //   $availabilityList[] = $timeInterval;
    // }
    if (count($reservesInDb) < $limit) {
      $availabilityList[] = $timeSlot;
    }
  }

  return $availabilityList;
}
// Get other available dates for the time provided
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

$tableAvailabilityList = getAvailabilityList($date, $time, $maxReservationTime,  $tableLimit, 'table', $closingTime);
$barAvailabilityList = getAvailabilityList($date, $time, $maxReservationTime, $tableLimit, 'bar', $closingTime);

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
    $_SESSION['reservation']['end_time'] = date("H:i", strtotime($selectedTime) + ($maxReservationTime));
    $_SESSION['reservation']['seating_location'] = $selectedSpot;

    header("Location: reservation-contact.php");
  }
}
?>

<?php require_once "../views/partials/header.php" ?>
<?php $prevLink = "reserve.php" ?>
<?php require_once "../views/partials/reservation-header.php" ?>

<!-- View -->
<?php require_once "../views/reserve-time/index.php" ?>
<!-- -->

<?php require_once "../views/partials/footer.php" ?>