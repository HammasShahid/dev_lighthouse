<?php
require_once "../views/partials/header.php";
$prevLink = "reservation-contact.php";
require_once "../views/partials/reservation-header.php";

session_start();

if (empty($_SESSION['reservation'])) {
  header("Location: index.php");
}

['name' => $name, 'email' => $email, 'date' => $date, 'time' => $time, 'guests' => $guests, 'location' => $location] = $_SESSION['reservation'];

$to = $email;
$from = "lighthouse@lighthouse.stagingwordpressweb.site";
$subject = "Your Reservation at Lighthouse Bar and Grill - Confirmation";
$headers = "From:$from";

require "../views/email-template.php";

mail($to, $subject, $message, $headers);

$_SESSION['reservation'] = [];

?>

<!-- View  -->
<?php
require_once "../views/reservation-success.php";
require_once "../views/partials/footer.php";
?>
<!-- -->