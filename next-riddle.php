<?php

session_start();

// Check if session is set
if (!isset($_SESSION['riddle_index'])) {
  $_SESSION['riddle_index'] = 0;
}
if (!isset($_SESSION['total_riddles'])) {
  die("<p class='bad'>Total riddles count missing.</p>"); // Prevent errors if session is lost
}

// Increment the riddle index
if ($_SESSION['riddle_index'] >= $_SESSION['total_riddles'] - 1) {
  $_SESSION['riddle_index'] = 0;
} else {
  $_SESSION['riddle_index']++;
}

// Redirect back to the riddles page
header("Location: riddle-page.php");
exit();
