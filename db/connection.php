<?php

$host = "localhost";
$port = "3306";
$dbname = "makixdjo_lighthouse";
$username = "makixdjo_lighthouse";
$password = "makixdjo_lighthouse";

$pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
// $pdo = new PDO('mysql:host=localhost;port=3306;dbname=lighthouse', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


return $pdo;
