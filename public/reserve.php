<?php

date_default_timezone_set("America/Los_Angeles");

session_start();
$pdo = require_once '../db/connection.php';
$constants = require_once '../helpers/constants.php';
// require_once '../db/reserve_query.php';

['openingTime' => $openingTime, 'closingTime' => $closingTime] = $constants;

function getMinDate()
{
  $dateTime = new DateTime('now');
  return $dateTime->format("Y-m-d");
}
function getMinTime()
{
  global $openingTime, $closingTime;
  // $dateTime = new DateTime('now');
  // return $dateTime->format("H:i");
  if (time() < strtotime($openingTime) || time() > strtotime($closingTime)) {
    return "11:00";
  } else {
    return date("H:i", strtotime("now"));
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

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $guests = $_POST['guests'];
  $location = $_POST['location'];
  $date = $_POST['date'];
  $time = $_POST['time'];

  if (!$guests) {
    $errors[] = 'Please provide the number of guests';
  }

  if ($guests < 0 ||  intval($guests) != $guests) {
    $errors[] = 'Invalid guests number';
  }

  if (!$date) {
    $errors[] = 'Please provide reservation date';
  }

  // Only allow 10 minute intervals in time.
  $minutes = intval(date("i", strtotime($time)));
  if ($minutes % 10 !== 0) {
    $errors[] = 'Please only use 10 minute intervals in time.';
  }

  if (!$time) {
    $errors[] = 'Please choose a time';
  }
  // Check if the time entered is within the required opening and closing times.
  if (strtotime($time) > strtotime($closingTime) || strtotime($time) < strtotime($openingTime)) {
    $errors[] = "Please choose a time between " . date("h:i A", strtotime($openingTime)) . " and " . date("h:i A", strtotime($closingTime));
  }
  // Check if the date is today's date and user is not entering a time that has passed.
  if (date("Y-m-d", strtotime($date)) == date("Y-m-d", strtotime("now")) && strtotime($time) < strtotime("now")) {
    $errors[] = "You are entering a time that has passed";
  }

  if (!$location) {
    $errors[] = 'Please provide location';
  }

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