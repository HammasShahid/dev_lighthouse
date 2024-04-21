<form method="post">
  <input name="date" type="hidden" value="<?= $date ?>" />
  <button class="btn availability-choice-button" type="submit">
    <p><?= date("M, d", strtotime($date)); ?></p>
  </button>
</form>