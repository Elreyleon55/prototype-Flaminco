<?php
require_once('security.php');

//We have check that there is not repeating user
//Now we must check if the user got the answer right

$inPageMessagesAnswer = [];

$riddlesAnswer = $_SESSION['riddle_answer'];
$usersRiddleAnswer = $_SESSION['user_riddle_answer'];



if ($riddlesAnswer === $usersRiddleAnswer) {
  $inPageMessagesAnswer[] = "User got the riddle right";
  $_SESSION['user_got_answer_right'] = true;
  header("location: riddle-page.php?cache=" . time());
  exit();
} else {
  $inPageMessagesAnswer[] = "User got the riddle wrong";
  $_SESSION['user_got_answer_wrong'] = false;
  header("location: riddle-page.php?cache=" . time());
  exit();
}


if ($inPageMessagesAnswer) {
  echo "<ul>";
  foreach ($inPageMessagesAnswer as $singleMessage) {
    echo "<li>$singleMessage</li>";
  }
  echo "</ul>";
} else {
  echo "No messages found";
}









echo "you have arrived at your destination";
