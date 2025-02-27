<!-- Get users input of email and send them a email with the coupon -->
<!-- delete all unessecary or uncovinent SESSIONS -->
<!-- Loop back to the riddle page -->
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require("../vendor/autoload.php");
require("../config.php");


$config = require '../config.php';

session_start();

$_COOKIE['game_played'] = 1;

$usersEmail = $_SESSION["users_email"];
$usersCoupon = $_SESSION["copoun_code"];

$validFrom = $_SESSION["VALID_FROM"];
$validTo = $_SESSION["VALID_TO"];


if ($usersEmail) {

  $emailTemplate = "
  <div class='email-container'>
        <h1>Hello!</h1>
        <p>Thank you for participating in our riddle game. Here is your coupon code:</p>
        <div class='coupon-code'>{COUPON_CODE}</div>
        <p>Use this code to get a FREE COOKIE</p>
        <p>This Coupon is valid from <strong>{VALID_FROM}</strong> to <strong>{VALID_TO}</strong>.</p>
        <div class='footer'>
            <p>If you have any questions, feel free to contact us.</p>
        </div>
    </div>
  ";
  $data = [
    "{COUPON_CODE}" => $usersCoupon,
    "{VALID_FROM}" => $validFrom,
    "{VALID_TO}" => $validTo,
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
    $mail->setFrom($config['email_username'], 'Cookie Monster'); // Sender
    $mail->addAddress($usersEmail, 'Recipient Name'); // Recipient

    // Content
    $mail->isHTML(true); // Set email format to HTML
    $mail->Subject = 'Congratulations Uprising Cookies';
    $mail->Body = $emailBody;
    $mail->AltBody = 'Hello! This is a test email sent using PHPMailer.'; // Plain text for non-HTML clients

    // Send the email
    if ($mail->send()) {
      echo 'Email sent successfully!';
      header("location: ../riddle-page.php");
      exit();
    }
  } catch (Exception $e) {
    echo "Failed to send email. Error: {$mail->ErrorInfo}";
  }
} else {
  echo "<p>Sorry No email was found</p>";
}

?>