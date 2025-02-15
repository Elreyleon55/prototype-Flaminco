<!-- sanatize the users gmail to pprevent sql attacks -->
<!-- send user into database id	coupon	email	device_id	date_won	valid_from	valid_to -->
<?php
session_start();
$globalErrorsEmailValidation = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = filter_var($_POST['users-gmail'], FILTER_SANITIZE_EMAIL);
  echo $email;
  if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "valid email";
    $_SESSION["users_email"] = $email;
    header("location: generate-copoun.php");
    exit();
  } else {
    echo "Invalid email address.";
    $globalErrorsEmailValidation[] = "Sorry your email was not valid please try again";
    $_SESSION['my-erros'] = $globalErrorsEmailValidation;
    header("location: ../riddle-page.php");
    exit();
  }
}
?>