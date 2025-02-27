<!-- 1. Check if riddle option was clicked -->
<!-- 2. Check if customer sign up for newsletter -->
<!-- 3. Save information about user so they cant play again -->
<!-- if customer signed up for newsletter go to diffrent page to perform this opration -->
<!-- 4. Check if customer got answer correct -->
<!-- If customer got question correct display message asking for there email -->
<!-- if customer gives email generate coupon code and save user into database -->
<!-- 5.c Collect all users and send organized email to manager -->
<?php

use WpOrg\Requests\Session;

require_once('security.php');


$globalErrors = [];
$inPageMessages = [];


echo "Request method: " . $_SERVER['REQUEST_METHOD'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {


  //checks if the a radio button was clicked && sets a cookie if not
  $required_fields = ['choices'];
  foreach ($required_fields as $field) {
    if (!isset($_POST[$field])) {
      $globalErrors[] = "Sorry you must pick a option and try to solve the riddle please try again";
    } else {
      $inPageMessages[] = "All required fields where submitted";
    }
  }
  //saves the user answer to then analize if he got it right
  if (isset($_POST['choices'])) {
    $_SESSION['user_riddle_answer'] = $_POST['choices'];
    $usersRiddleAnswer = $_SESSION['user_riddle_answer'];
  }

  //saves riddle answer
  $riddlesAnswer = $_SESSION['riddle_answer'];


  //checks if the checkbox exist and if it was clicked sending back the value "yes";
  if (isset($_POST['subscribe']) && $_POST['subscribe'] === 'yes') {
    $inPageMessages[] = "User wants to sign up to the news letter";
    $_SESSION['user-wants-to-subscribe'] = 1;
  } else {
    $inPageMessages[] = "User does not want to sign up for newsletter";
  }

  //checks if the email givin was valid
  if (empty($_POST['users-gmail'])) {
    $globalErrors[] = "Sorry you must fill in your email before submitting";
  } else {
    $email = filter_var($_POST['users-gmail'], FILTER_SANITIZE_EMAIL);
    echo $email;
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      echo "valid email";
      $_SESSION["users_email"] = $email;
    } else {
      echo "Invalid email address.";
      $globalErrors[] = "Sorry your email was not valid please try again";
    }
  }
}

//error validation if it finds a error it will send the user back and if not they can proceeed
if (count($globalErrors) > 0) {
  $_SESSION['my-erros'] = $globalErrors;
  header('location: ./riddle-page.php');
  exit();
} else {
  $inPageMessages[] = "No errors found can proceed";
  if ($riddlesAnswer === $usersRiddleAnswer) {
    $inPageMessages = "User got the riddle right";
    $_SESSION['user_got_answer_right'] = true;
    header("location: ./correct-answer/insert-history-database.php");
    exit();
  } else {
    $inPageMessages[] = "User got the riddle wrong";
    $_SESSION['user_got_answer_wrong'] = true;
    header("location: riddle-page.php?cache=" . time());
    exit();
  }
}

if ($inPageMessages) {
  echo "<ul>";
  foreach ($inPageMessages as $singleMessage) {
    echo "<li>$singleMessage</li>";
  }
  echo "</ul>";
} else {
  echo "No messages found";
}

// summery of what i do on this page
// 1. I check if all required field were submited
// 2. I set user cookies
// 3. I saver the users asnwer and riddles answer inside variable
// 4. I check if user wants to subscribe
// 5. I check if email is valid
// 6. I check if user got that aswer right

//What data do I have from the user
//1. Email
//2. If they want to sign up for the newsletter
//3. If they got the answer right or wrong
