<div class="reserve-page">
  <div class="content-container content-logo-container">
    <img src="images/logo.png" />
  </div>

  <p class="content-container join-message">Join us for happy hour starting at $5 @9pm</p>

  <!-- <form method="post" action="reserve-time.php" class="reserve-form"> -->
  <form method="post" class="reserve-form">
    <?php if (!empty($errors)) : ?>
      <div class="error-box">
        <?php foreach ($errors as $error) : ?>
          <div class="error-message">
            <?= $error ?>
          </div>
        <?php endforeach; ?>
      </div>
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
        <input data-time type="time" id="time" name="time" min="<?= $openingTime; ?>" max="<?= getMaxTime(); ?>" class="reserve-form-input" value="<?= getMinTime(); ?>" />
        <i data-time-next class="input-step fas fa-chevron-right"></i>
      </div>
      <label for="time" class="reserve-form-label">Time</label>
    </div>
    <input type="submit" class="btn content-container btn--secondary" value="Search" />
  </form>

</div>

<script src="js/reserve.js"></script>