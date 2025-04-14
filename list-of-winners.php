<?php
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once("./dbinfo.php");
require("./vendor/autoload.php");
require("./config.php");

$config = require './config.php';

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno() != 0) {
  die("DB Connection Failed");
} else {
  echo "<p>Connection Complete</p>";
}
// $query = "SELECT id, firstname, lastname FROM students ORDER BY lastname;";
// $query = "SELECT email FROM history_of_customers WHERE notify_other_events = TRUE";
$query = "SELECT coupon, email, date_won, valid_from, valid_to FROM intended_option_winners;";
$result = $mysqli->query($query);

if (!$result) {
  die("Query failed: " . $mysqli->error);
}

$arrayOfWinners = $result->fetch_fields();

if ($result->num_rows > 0) {

  $emailTemplate = "
   <div>
   <h1>Todays Winners</h1>
        <p>Here is a list of today's game winners:</p>
        <table>
            {WINNERS_LIST}
        </table>
        <p>Total Winners: {TOTAL_WINNERS}</p>
        <div class='footer'>
            <p>If you have any questions, feel free to contact us.</p>
        </div>
  </div>
    ";

  $totalWinners = 0;

  $winnersList .= "<tr>";
  foreach ($arrayOfWinners as $onefield) {
    $winnersList .= "<td>" . $onefield->name . "<td>";
  };
  $winnersList .= "</tr>";

  while ($oneRecord = $result->fetch_row()) {
    $winnersList .= "<tr>";

    foreach ($oneRecord as $field) {
      $totalWinners++;
      $winnersList .= "<td style='padding: 10px;'>" . $field . "</td>";
    }
    $winnersList .= "</tr>";
  }

  $data = [
    "{WINNERS_LIST}" => $winnersList,
    "{TOTAL_WINNERS}" => $totalWinners,
  ];

  $emailBody = str_replace(array_keys($data), array_values($data), $emailTemplate);

  $mail = new PHPMailer(true);

  try {
    // Server settings
    $mail->isSMTP(); // Use SMTP
    $mail->Host = 'smtp.gmail.com'; // SMTP server (e.g., Gmail)
    $mail->SMTPAuth = true; // Enable SMTP authentication
    $mail->Username = $config['email_username']; // SMTP username (your email)
    $mail->Password = $config['email_password']; // SMTP password (or app password)
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // Enable TLS encryption
    $mail->Port = 587; // TCP port (587 for TLS)

    // Recipients
    $mail->setFrom($config['email_username'], 'Gamified QR Code Campaign'); // Sender
    $mail->addAddress('benjiroks@gmail.com', 'Recipient Name'); // Recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Uprising Subcribers';
    $mail->Body = $emailBody;
    $mail->AltBody = 'Hello! This is a test email sent using PHPMailer.'; // Plain text for non-HTML clients

    // Send the email
    if ($mail->send()) {
      echo 'Email sent successfully!';
      header("location: ./riddle-page.php");
      exit();
    }
  } catch (Exception $e) {
    echo "Failed to send email. Error: {$mail->ErrorInfo}";
  }
} else {
  echo "Could not find rows";
}

$mysqli->close();
