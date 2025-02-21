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

$_SESSION["VALID_FROM"] = $startingTommorowFormatted;
$_SESSION["VALID_TO"] = $sevenDaysLaterFormatted;

$winnersCoupon;

$usersEmail = $_SESSION["users_email"];

$query = $mySqli->prepare("SELECT email FROM intended_option_winners WHERE email = ?");
$query->bind_param('s', $usersEmail);
$query->execute();
$query->store_result();

if ($query->num_rows > 0) {
  $globalErrors[] = "Sorry this email has already played today please try a diffrent one";
  $_SESSION['my-erros'] = $globalErrors;
  unset($_SESSION['user_got_answer_right']);
  unset($_SESSION['user_got_answer_wrong']);
  header("location: ../riddle-page.php");
  exit();
} else {
  generateCouponCode($mySqli);
  $winnersCoupon = $_SESSION["copoun_code"];
  $query = $mySqli->prepare("INSERT INTO intended_option_winners (coupon, email, date_won, valid_from, valid_to) VALUES (?, ?, ?, ?, ?)");
  $query->bind_param('sssss', $winnersCoupon, $usersEmail, $todaysDateS, $startingTommorowFormatted, $sevenDaysLaterFormatted);
  $query->execute();
  $affectedRows = $mySqli->affected_rows;
  if ($affectedRows > 0) {
    echo "<p>$affectedRows records were inserted </p>";
    header("location: send-user-email.php");
    exit();
  } else {
    echo "<p>Nothing was inserted</p>";
  }
}

function generateCouponCode($mySqli)
{
  $query = "SELECT coupon FROM intended_option_winners ORDER BY id DESC LIMIT 1";
  $result = $mySqli->query($query);
  if ($result) {
    $lastCouponCode = $result->fetch_column();
    if (!$lastCouponCode) {
      $lastCouponCode = "COOKIES_001";
    } else {
      preg_match('/\d+$/', $lastCouponCode, $match);
      $lastNumber = (int)$match[0];
      $newNumber = $lastNumber + 1;
      $winnersCoupon = sprintf("COOKIES_%03d", $newNumber);
      $_SESSION["copoun_code"] = $winnersCoupon;
    }
  }
}


















// what I need to insert into the database
