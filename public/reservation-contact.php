<?php

$pdo = require_once '../db/connection.php';
session_start();

['date' => $date, 'time' => $time, 'end_time' => $endTime, 'guests' => $guests, 'location' => $location, 'seating_location' => $seating_location] = $_SESSION['reservation'];
$dateTime = new DateTime("$date $time");

$validations = require_once '../helpers/validations.php';
['errors' => $errors, 'validateName' => $validateName, 'validateEmail' => $validateEmail, 'validatePhone' => $validatePhone] = $validations;

// $errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  $validateName($name);
  $validateEmail($email);
  $validatePhone($phone);

  if (empty($errors)) {
    $_SESSION['reservation']['name'] = $name;
    $_SESSION['reservation']['email'] = $email;
    $_SESSION['reservation']['phone'] = $phone;


    $statement = $pdo->prepare("INSERT INTO reservation (guests, date, time, end_time, location_id, name, email, phone, seating_location) VALUES (:guests, :date, :time, :end_time, :location_id, :name, :email, :phone, :seating_location);");
    $statement->bindValue(':guests', $guests);
    $statement->bindValue(':date', $date);
    $statement->bindValue(':time', $time);
    $statement->bindValue(':end_time', $endTime);
    $statement->bindValue(':location_id', $location['id']);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':phone', $phone);
    $statement->bindValue(':seating_location', $seating_location);

    $statement->execute();

    header('Location: reservation-success.php');
  }
}

?>

<?php require_once "../views/partials/header.php" ?>
<?php $prevLink = "reserve-time.php" ?>
<?php require_once "../views/partials/reservation-header.php" ?>

<!-- Views -->
<?php require_once "../views/reservation-contact.php" ?>
<!-- -->

<?php require_once "../views/partials/footer.php" ?>