<!-- 1. Check if riddle option was clicked -->
<!-- 2. Check if customer sign up for newsletter -->
<!-- 3. Save information about user so they cant play again -->
<!-- if customer signed up for newsletter go to diffrent page to perform this opration -->
<!-- 4. Check if customer got answer correct -->
<!-- If customer got question correct display message asking for there email -->
<!-- if customer gives email generate coupon code and save user into database -->
<!-- 5.c Collect all users and send organized email to manager -->
<?php
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
      setcookie('game_played', '1', time() + (15), "/");
    }
  }
  //saves the user answer to then analize if he got it right
  if (isset($_POST['choices'])) {
    $_SESSION['user_riddle_answer'] = $_POST['choices'];
  }

  //checks if the checkbox exist and if it was clicked sending back the value "yes";
  if (isset($_POST['subscribe']) && $_POST['subscribe'] === 'yes') {
    $inPageMessages[] = "User wants to sign up to the news letter";
  } else {
    $inPageMessages[] = "User does not want to sign up for newsletter";
  }
} else {
  $inPageMessages[] = "Form did not find a POST method";
}


//error validation if it finds a error it will send the user back and if not they can proceeed
if (count($globalErrors) > 0) {
  $_SESSION['my-erros'] = $globalErrors;
  header('location: ./riddle-page.php');
  exit();
} else {
  $inPageMessages[] = "No errors found can proceed";
  header("location: answer-check.php");
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
