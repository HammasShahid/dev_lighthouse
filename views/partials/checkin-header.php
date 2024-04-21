<div class="checkin-header-container">
  <div class="container checkin-header">
    <div class="checkin-header-left">
      <a class="checkin-header-back-btn" href="<?= $prevLink ?>"><i class="fa fa-chevron-left" aria-hidden="true"></i></a>
      <p class="checkin-header-heading">Reservation Check-In</p>
    </div>

    <button data-search-toggle class="btn search-toggle">Search</button>
  </div>
</div>

<div data-search-form-container class="search-form-container modal-container">
  <button data-search-close class="modal-close"><i class="fas fa-close"></i></button>
  <form method="get" class="search-form">
    <input type="text" name="search" placeholder="Enter Name, Email or Phone Number" value="<?= $search ?>" class="search-input" />
    <button type="submit" class="search-submit"><i class="fas fa-search"></i></button>
  </form>
</div>

<script src="js/search-form.js"></script>