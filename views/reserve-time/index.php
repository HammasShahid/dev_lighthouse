<div class="reserve-time-container content-container">
  <h2>Pick Your Time</h2>
  <div class="reserve-availability-container">
    <div class="availability-options">
      <?php
      $seating_spot = 'table';
      if (!count($tableAvailabilityList) && !count($barAvailabilityList)) {
        echo "<p class='no-reservation'>Sorry, no time slot available in the selected date</p>";
      }
      foreach ($tableAvailabilityList as $availableTime) {
        include "../views/reserve-time/time-availability-option.php";
      }
      $seating_spot = 'bar';
      foreach ($barAvailabilityList as $availableTime) {
        include "../views/reserve-time/time-availability-option.php";
      }
      ?>
    </div>

    <p class="date-availability-text">Other dates with availability at <?= $dateTime->format('h:i A'); ?></p>
    <div class="availability-options date-availability-options">
      <?php
      foreach (getAvailableDates($date, $time, $tableLimit, $barLimit) as $date) {
        include "../views/reserve-time/date-availability-option.php";
      }
      ?>
    </div>
  </div>
</div>