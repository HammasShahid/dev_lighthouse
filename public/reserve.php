<?php

date_default_timezone_set("America/Los_Angeles");

session_start();
$pdo = require_once '../db/connection.php';
$constants = require_once '../helpers/constants.php';
$validations = require_once '../helpers/validations.php';

['errors' => $errors, 'validateGuests' => $validateGuests, 'validateLocation' => $validateLocation, 'validateTime' => $validateTime, 'validateDate' => $validateDate] = $validations;

['openingTime' => $openingTime, 'closingTime' => $closingTime, 'maxReservationTime' => $maxReservationTime, 'barLimit' => $barLimit] = $constants;

function getMinDate()
{
  $dateTime = new DateTime('now');
  return $dateTime->format("Y-m-d");
}
function getMaxTime()
{
  global $closingTime, $maxReservationTime;
  return date("H:i", strtotime($closingTime) - $maxReservationTime);
}
function getMinTime()
{
  global $openingTime, $closingTime;

  if (time() < strtotime($openingTime) || time() > strtotime($closingTime)) {
    return $openingTime;
  } else {
    $hours = date("H", strtotime("now"));
    $minutes = intval(date("i", strtotime("now")));

    while (true) {
      // for correct hour
      if ($minutes > 50 && $minutes < 60) {
        $minutes = "00";
        if (intval($hours) < 23) {
          $hours = intval($hours) + 1;
          if (intval($hours) < 10) {
            $hours = "0$hours";
          }
        } else {
          $hours = "00";
        }
        break;
      }

      // for correct minutes
      if ($minutes % 10 === 0 || $minutes === 0) {
        break;
      }
      $minutes++;
    }
    return "$hours:$minutes";
  }
}

function getLocations()
{
  global $pdo;

  $statement = $pdo->prepare("SELECT * FROM location");

  $statement->execute();
  $locations = $statement->fetchAll(PDO::FETCH_ASSOC);

  return $locations;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $guests = $_POST['guests'];
  $location = $_POST['location'];
  $date = $_POST['date'];
  $time = $_POST['time'];

  $validateGuests($guests);
  $validateDate($date);
  $validateTime($time, $date, $openingTime, $closingTime, $maxReservationTime);
  $validateLocation($location);

  if (empty($errors)) {
    $_SESSION['reservation'] = [];

    // getLocations()
    $selectedLocation = array_filter(getLocations(), function ($loc) {
      global $location;
      if ($loc['id'] == $location) {
        return true;
      }
    })[0];

    $_SESSION['reservation']['location'] = $selectedLocation;
    $_SESSION['reservation']['time'] = $time;
    $_SESSION['reservation']['date'] = $date;
    $_SESSION['reservation']['guests'] = $guests;

    header('Location: reserve-time.php');
  }
}

?>

<?php require_once "../views/partials/header.php" ?>
<?php $prevLink = "index.php" ?>
<?php require_once "../views/partials/reservation-header.php" ?>

<!-- View -->
<?php require_once "../views/reserve.php" ?>

<?php require_once "../views/partials/footer.php" ?>