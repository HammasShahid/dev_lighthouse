<?php require_once "../views/partials/header.php" ?>
<?php $prevLink = "reserve-time.php" ?>
<?php require_once "../views/partials/reservation-header.php" ?>

<div class="contact-container">
  <div class="content-container summary-container">
    <p class="heading--container summary-date">SUN, Mar 22 - 11:00PM - 2 Guests</p>
    <div class="reservation-text">
      <p>3600 Townline Rd.</p>
      <p>Abbotsford, B.C. V2T 5W8</p>
    </div>
    <p class="summary-heading">Reservation Summary</p>
  </div>
  <p class="content-container join-message">Join us for happy hour starting at $5 @9pm</p>
  <form class="content-container contact-form">
    <div class="contact-fields-container">
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