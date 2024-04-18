<?php

session_start();
$pdo = require_once '../db/connection.php';
// require_once '../db/reserve_query.php';



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

  if (!$date) {
    $errors[] = 'Please provide reservation date';
  }

  if (!$time) {
    $errors[] = 'Please provide reservation time';
  }

  if (!$location) {
    $errors[] = 'Please provide location';
  }

  if (empty($errors)) {
    $_SESSION['reservation'] = [];
    $_SESSION['reservation']['location'] = $location;
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


<div class="reserve-page">
  <div class="content-container content-logo-container">
    <img src="images/logo.png" />
  </div>

  <p class="content-container join-message">Join us for happy hour starting at $5 @9pm</p>

  <!-- <form method="post" action="reserve-time.php" class="reserve-form"> -->
  <form method="post" class="reserve-form">
    <?php // if (!empty($_SESSION['errors']['reserve'])): 
    ?>
    <?php if (!empty($errors)) : ?>
      <?php // foreach ($_SESSION['errors']['reserve'] as $error) : 
      ?>
      <?php foreach ($errors as $error) : ?>
        <div class="error"><?= $error ?></div>
      <?php endforeach; ?>
      <?php // session_destroy(); 
      ?>
    <?php endif; ?>
    <div class="content-container reserve-form-group">
      <select id="location" name="location" class="reserve-form-input">

        <?php foreach (getLocations() as $location) : ?>
          <option value="<?= $location['id']; ?>">
            <?= $location['address']; ?>
          </option>
        <?php endforeach; ?>
      </select>
      <label for="location" class="reserve-form-label">Location</label>
    </div>
    <div class="content-container reserve-form-group">
      <input type="date" id="date" name="date" class="reserve-form-input" />
      <label for="date" class="reserve-form-label">Date</label>
    </div>
    <div class="content-container reserve-form-group">
      <input type="text" id="guests" name="guests" class="reserve-form-input" value="1" />
      <label for="guests" class="reserve-form-label">Guests</label>
    </div>
    <div class="content-container reserve-form-group">
      <input type="time" id="time" name="time" class="reserve-form-input" value="12:00" />
      <label for="time" class="reserve-form-label">Time</label>
    </div>
    <input type="submit" class="btn content-container btn--secondary" value="Search" />
  </form>

</div>

<script src="/js/reserve.js"></script>
<?php require_once "../views/partials/footer.php" ?>