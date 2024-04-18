<?php

date_default_timezone_set("America/Los_Angeles");

session_start();
$pdo = require_once '../db/connection.php';
// require_once '../db/reserve_query.php';

function getMinDate()
{
  $dateTime = new DateTime('now');
  return $dateTime->format("Y-m-d");
}
function getMinTime()
{
  $dateTime = new DateTime('now');
  return $dateTime->format("H:i");
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

    // getLocations()
    $selectedLocation = array_filter(getLocations(), function ($loc) {
      global $location;
      if ($loc['id'] == $location) {
        return true;
      }
    })[0];

    // $_SESSION['reservation']['location'] = $location;
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
      <div class="reserve-input-group">
        <i data-location-prev class="input-step fas fa-chevron-left"></i>
        <select data-location id="location" name="location" class="reserve-form-input reserve-form-select">

          <?php foreach (getLocations() as $location) : ?>
            <option value="<?= $location['id']; ?>">
              <?= $location['address']; ?>
            </option>
          <?php endforeach; ?>
        </select>
        <i data-location-next class="input-step fas fa-chevron-right"></i>
      </div>
      <label for="location" class="reserve-form-label">Location</label>
    </div>
    <div class="content-container reserve-form-group">
      <div class="reserve-input-group">
        <i data-date-prev class="input-step fas fa-chevron-left"></i>
        <input data-date type="date" id="date" name="date" min="<?= getMinDate(); ?>" value="<?= getMinDate(); ?>" class="reserve-form-input" />
        <i data-date-next class="input-step fas fa-chevron-right"></i>
      </div>
      <label for="date" class="reserve-form-label">Date</label>
    </div>
    <div class="content-container reserve-form-group">
      <div class="reserve-input-group">
        <i data-guests-prev class="input-step fas fa-chevron-left"></i>
        <input data-guests type="number" id="guests" name="guests" class="reserve-form-input" value="1" step="1" />
        <i data-guests-next class="input-step fas fa-chevron-right"></i>
      </div>
      <label for="guests" class="reserve-form-label">Guests</label>
    </div>
    <div class="content-container reserve-form-group">
      <div class="reserve-input-group">
        <i data-time-prev class="input-step fas fa-chevron-left"></i>
        <input data-time type="time" id="time" name="time" class="reserve-form-input" value="<?= getMinTime(); ?>" />
        <i data-time-next class="input-step fas fa-chevron-right"></i>
      </div>
      <label for="time" class="reserve-form-label">Time</label>
    </div>
    <input type="submit" class="btn content-container btn--secondary" value="Search" />
  </form>

</div>

<script src="/js/reserve.js"></script>
<script>
  const timeField = document.querySelector('[data-time]');
  const timeNext = document.querySelector('[data-time-next]');
  const timePrev = document.querySelector('[data-time-prev]');

  const dateField = document.querySelector('[data-date]');
  const dateNext = document.querySelector('[data-date-next]');
  const datePrev = document.querySelector('[data-date-prev]');

  const guestsField = document.querySelector('[data-guests]');
  const guestsNext = document.querySelector('[data-guests-next]');
  const guestsPrev = document.querySelector('[data-guests-prev]');

  function stepUp(stepBtn, field) {
    stepBtn.addEventListener('click', () => {
      field.stepUp();
    });
  }

  function stepDown(stepBtn, field) {
    stepBtn.addEventListener('click', () => {
      field.stepDown();
    });
  }

  stepUp(timeNext, timeField);
  stepDown(timePrev, timeField);

  stepUp(dateNext, dateField);
  stepDown(datePrev, dateField);


  stepUp(guestsNext, guestsField);
  stepDown(guestsPrev, guestsField);
</script>
<?php require_once "../views/partials/footer.php" ?>