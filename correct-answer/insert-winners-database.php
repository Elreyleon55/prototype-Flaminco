<?php
//make sure there is not user with the same Gmail
//insert user into winners database


require_once("../dbinfo.php");
session_start();

$mySqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno() != 0) {
  die("Connection Failed");
} else {
  echo "<p>Connection Sucessfull</p>";
}

$globalErrors = [];

$todaysDateS = date("Y-m-d"); // Format: Year-Month-Day

$todaysDate = new DateTime(); // Create a DateTime object for today
$sevenDaysLater = (clone $todaysDate)->modify('+7 days'); // Add 7 days
$startingTommorow = (clone $todaysDate)->modify('+1 day');

// Format the date
$sevenDaysLaterFormatted = $sevenDaysLater->format("Y-m-d");
$startingTommorowFormatted = $startingTommorow->format("Y-m-d");

$winnersCoupon = $_SESSION["copoun_code"];

$usersEmail = $_SESSION["users_email"];

$query = $mySqli->prepare("SELECT email FROM intended_option_winners WHERE email = ?");
$query->bind_param('s', $usersEmail);
$query->execute();
$query->store_result();

if ($query->num_rows > 0) {
  $globalErrors[] = "Sorry this email has already played today please try a diffrent one";
  $_SESSION['my-erros'] = $globalErrors;
  unset($_SESSION["copoun_code"]);
  unset($_SESSION['user_got_answer_right']);
  unset($_SESSION['user_got_answer_wrong']);
  header("location: ../riddle-page.php");
  exit();
} else {
  $query = $mySqli->prepare("INSERT INTO intended_option_winners (coupon, email, date_won, valid_from, valid_to) VALUES (?, ?, ?, ?, ?)");
  $query->bind_param('sssss', $winnersCoupon, $usersEmail, $todaysDateS, $startingTommorowFormatted, $sevenDaysLaterFormatted);
  $query->execute();
  $affectedRows = $mySqli->affected_rows;
  if ($affectedRows > 0) {
    echo "<p>$affectedRows records were inserted </p>";
  } else {
    echo "<p>Nothing was inserted</p>";
  }
}


















// what I need to insert into the database
