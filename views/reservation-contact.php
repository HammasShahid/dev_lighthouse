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
      <?php if (!empty($errors)) : ?>
        <div class="error-box">
          <?php foreach ($errors as $error) : ?>
            <div class="error-message">
              <?= $error ?>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
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