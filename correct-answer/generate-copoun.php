<!-- genereate copoun -->
<!-- check if there is alredy a copoun if not -->
<!-- Add a Copoun and go from the last one -->

<?php
require_once('../dbinfo.php');
$mySqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno() != 0) {
  die("DB connection failed");
} else {
  echo "Connection Successful";
}

$newCouponCode;

function generateCouponCode($mySqli)
{
  $query = "SELECT Coupon_code FROM history_of_customers ORDER BY id DESC LIMIT 1";
  $result = $mySqli->query($query);
  if ($result) {
    $lastCouponCode = $result->fetch_column();
    if (!$lastCouponCode) {
      $lastCouponCode = "COOKIES_001";
    } else {
      preg_match('/\d+$/', $lastCouponCode, $match);
      $lastNumber = (int)$match[0];
      $newNumber = $lastNumber + 1;
      $newCouponCode = sprintf("COOKIES_%03d", $newNumber);
    }
  }
  echo "New Coupon Code" . $newCouponCode;
}

generateCouponCode($mySqli);


function addUserToDataBase($mySqli, $newCouponCode)
{
  $todaysDate = date("Y-m-d");
  $usersEmail = $_SESSION["users_email"];
  $newsLetterDecision = $_SESSION['user-wants-to-subscribe'];
  $query = "INSERT INTO history_of_customers (gmail, date_registration, notify_other_events, Coupon_code) VALUES ('$usersEmail', '$todaysDate', '$newsLetterDecision', '$newCouponCode')";
  $mySqli->query($query);
  $affectedRows = $mySqli->affected_rows;
  if ($affectedRows > 0) {
    echo "<p>$affectedRows records were inserted </p>";
  } else {
    echo "<p>Nothing was inserted</p>";
  }
}

addUserToDataBase($mySqli, $newCouponCode);




?>