 <?php

  /** @var $pdo \PDO */
  $pdo = require_once "connection.php";

  function getLocations()
  {
    global $pdo;

    $statement = $pdo->prepare("SELECT * FROM location");

    $statement->execute();
    $locations = $statement->fetchAll(PDO::FETCH_ASSOC);

    return $locations;
  }
