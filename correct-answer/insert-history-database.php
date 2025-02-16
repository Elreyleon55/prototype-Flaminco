<!-- genereate copoun -->
<!-- check if there is alredy a copoun if not -->
<!-- Add a Copoun and go from the last one -->

<?php

use PgSql\Connection;

session_start();
require_once('../dbinfo.php');
$mySqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno() != 0) {
  die("DB connection failed");
} else {
  echo "Connection Successful";
}

$usersEmail = $_SESSION["users_email"];

$query = $mySqli->prepare("SELECT email FROM history_of_customers WHERE email = ?");
$query->bind_param('s', $usersEmail);
$query->execute();
$query->store_result();

if ($query->num_rows > 0) {
  header("location: insert-winners-database.php");
  exit;
} else {
  echo "<p>Can continue and add user to history of users databse</p>";
  $todaysDate = date("Y-m-d");
  $usersEmail = $_SESSION["users_email"];
  $newsLetterDecision = $_SESSION['user-wants-to-subscribe'];
  $query = "INSERT INTO history_of_customers (email, date_registration, notify_other_events) VALUES ('$usersEmail', '$todaysDate', '$newsLetterDecision')";
  $mySqli->query($query);
  $affectedRows = $mySqli->affected_rows;
  if ($affectedRows > 0) {
    echo "<p>$affectedRows records were inserted </p>";
  } else {
    echo "<p>Nothing was inserted</p>";
  }
}

header("location: insert-winners-database.php");
exit();






?>