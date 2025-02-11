<?php
session_start();
session_regenerate_id(true);
$inpage_messages = [];


if (isset($_COOKIE['game_played'])) {

  $timesPlayed = (int)$_COOKIE['game_played'];
  if ($timesPlayed >= 2) {
    $_SESSION['my-erros'] = ["Sorry you have alredy played the Game"];
    $inpage_messages[] = "user will be directed back to home page beacause he alredy playedthe game";
    $inpage_messages[] = "User has played: $timesPlayed";
    header('location: riddle-page.php');
    exit();
  } else {
    $inpage_messages[] = "Users first time playing the game";
    $timesPlayed++;
    setcookie('game_played', $timesPlayed, time() + 15, "/");
    $inpage_messages[] = "User has played: $timesPlayed";
  }
} else {
  $inpage_messages[] = "No cookies found user Allowed to proced";
}



if ($inpage_messages) {
  echo "<ul>";
  foreach ($inpage_messages as $singleMessage) {
    echo "<li>$singleMessage</li>";
  }
  echo "</ul>";
} else {
  echo "No messages found";
}

// echo "<pre>";
// print_r($_COOKIE);
// echo "</pre>";
