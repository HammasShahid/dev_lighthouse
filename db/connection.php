<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=lighthouse', 'root', '');
// $pdo = new PDO('mysql:host=localhost;port=3306;dbname=makixdjo_lighthouse', 'makixdjo_lighthouse', 'makixdjo_lighthouse');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

return $pdo;
