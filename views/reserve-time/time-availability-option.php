<form method="post">
  <input name="time" type="hidden" value="<?= $availableTime ?>" />
  <input name="seating_location" type="hidden" value="<?= $seating_spot ?>" />
  <button class="btn availability-choice-button" type="submit">
    <p><?= date("g:i A", strtotime($availableTime)); ?></p>
    <p class="seating-spot"><?= $seating_spot ?></p>
  </button>
</form>