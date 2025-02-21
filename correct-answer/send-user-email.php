<!-- Get users input of email and send them a email with the coupon -->
<!-- delete all unessecary or uncovinent SESSIONS -->
<!-- Loop back to the riddle page -->
<?php
session_start();

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

  $to = $usersEmail;
  $subject = "Uprising Coupon Code";
  $headers = [
    "MIME-Version: 1.0",
    "Content-type: text/html; charset=UTF-8",
    "From: Your Company <benjamin.4179@gmail.com>",
    "Reply-To: benjamin.4179@gmail.com"
  ];

  $header = implode("\r\n", $headers);
  if (mail($to, $subject, $emailBody, $header)) {
    echo "Email Send succesfully";
  } else {
    echo "<p>Error accured</p>";
  }
} else {
  echo "<p>Sorry No email was found</p>";
}

?>