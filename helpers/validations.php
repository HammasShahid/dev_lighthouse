<?php

$errors = [];

function validateGuests($guests)
{
  global $errors;

  if (!$guests) {
    $errors[] = 'Please provide the number of guests';
  }

  if ($guests < 0 ||  intval($guests) != $guests) {
    $errors[] = 'Invalid guests number';
  }
}

function validateDate($date)
{
  global $errors;

  if (!$date) {
    $errors[] = 'Please provide reservation date';
  }
  if ($date < date("Y-m-d", time())) {
    $errors[] = 'You are entering a date that has passed';
  }
}

function validateTime($time, $date, $openingTime, $closingTime)
{
  global $errors;

  if (!$time) {
    $errors[] = 'Please choose a time';
  }
  // Only allow 10 minute intervals in time.
  $minutes = intval(date("i", strtotime($time)));
  if ($minutes % 10 !== 0) {
    $errors[] = 'Please only use 10 minute intervals in time.';
  }

  // Check if the time entered is within the required opening and closing times.
  if (strtotime($time) > strtotime($closingTime) || strtotime($time) < strtotime($openingTime)) {
    $errors[] = "Please choose a time between $openingTime :::" . date("h:i A", strtotime($openingTime)) . " and " . date("h:i A", strtotime($closingTime));
  }
  // Check if the date is today's date and user is not entering a time that has passed.
  if (date("Y-m-d", strtotime($date)) == date("Y-m-d", strtotime("now")) && strtotime($time) < strtotime("now")) {
    $errors[] = "You are entering a time that has passed";
  }
}

function validateLocation($location)
{
  global $errors;

  if (!$location) {
    $errors[] = 'Please provide location';
  }
}

function validateName($name)
{
  global $errors;

  if (!$name) {
    $errors[] = 'Please provide your name';
  }
}

function validateEmail($email)
{
  global $errors;

  if (!$email) {
    $errors[] = 'Please provide your email';
  } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
  }
}
function validatePhone($phone)
{
  global $errors;

  if (!$phone) {
    $errors[] = 'Please provide your phone';
  } elseif (!preg_match('/^\d+$/', $phone)) {
    $errors[] = 'Invalid phone number';
  }
}
return [
  "errors" => $errors,
  "validateGuests" => 'validateGuests',
  "validateDate" => 'validateDate',
  "validateTime" => 'validateTime',
  "validateLocation" => 'validateLocation',
  "validateEmail" => 'validateEmail',
  "validateName" => 'validateName',
  "validatePhone" => 'validatePhone',
];
