<?php

$pdo = require_once '../db/connection.php';
session_start();

['date' => $date, 'time' => $time, 'end_time' => $endTime, 'guests' => $guests, 'location' => $location, 'seating_location' => $seating_location] = $_SESSION['reservation'];
$dateTime = new DateTime("$date $time");

$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $phone = $_POST['phone'];

  if (!$name) {
    $errors[] = 'Please provide your name';
  }
  if (!$email) {
    $errors[] = 'Please provide your email';
  }
  if (!$phone) {
    $errors[] = 'Please provide your phone';
  }

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

<div class="contact-container">
  <div class="content-container summary-container">
    <p class="heading--container summary-date"><?= $dateTime->format("D, M d - h:i A") . " - $guests Guest" . ($guests > 1 ? 's' : '') ?></p>
    <div class="reservation-text">
      <p><?= $location['address']; ?></p>
      <p>Abbotsford, B.C. V2T 5W8</p>
    </div>
    <p class="summary-heading">Reservation Summary</p>
  </div>
  <p class="content-container join-message">Join us for happy hour starting at $5 @9pm</p>
  <form method="post" class="content-container contact-form">
    <div class="contact-fields-container">
      <?php
      if (!empty($errors)) :
        foreach ($errors as $error) :
      ?>
          <p><?= $error ?></p>
      <?php
        endforeach;
      endif;
      ?>
      <div class="contact-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" class="contact-field" />
      </div>
      <div class="contact-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" class="contact-field" />
      </div>
      <div class="contact-group">
        <label for="phone">Phone Number</label>
        <input type="text" id="phone" name="phone" class="contact-field" />
      </div>
    </div>
    <button type="submit" class="content-container btn contact-submit-btn">Submit</button>
  </form>
</div>

<?php require_once "../views/partials/footer.php" ?>