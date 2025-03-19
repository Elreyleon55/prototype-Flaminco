<?php
require_once("dbinfo.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno() != 0) {
  die("DB Connection Failed");
} else {
  echo "<p>Connection Complete</p>";
}
session_start();
// session_destroy();


//Setting global session to check for errors
if (isset($_SESSION['my-erros'])) {
  echo "<ul>";
  foreach ($_SESSION['my-erros'] as $oneError) {
    echo "<li> $oneError </li>";
  }
  echo "</ul>";
  unset($_SESSION['my-erros']);
}

// Get the current hour in 24-hour format
$currentHour = date('H'); // 'H' gives the hour (00 to 23)

// Check the time and display a message
if ($currentHour < 7) {
  echo "Good morning! It's early—our bakery opens at 7:00 AM.";
} elseif ($currentHour >= 18) {
  echo "Good evening! Our bakery is closed, but we'll reopen tomorrow at 7:00 AM.";
} else {
  echo "Welcome! Our bakery is open. How can we help you today?";
}

//Getting total number of riddles to then set the index
$query = "SELECT COUNT(*) as total FROM list_riddles;";
$result = $mysqli->query($query);
if ($result) {
  $row = $result->fetch_assoc();
  $_SESSION['total_riddles'] = $row['total']; // Store the total in the session
  echo $_SESSION['total_riddles'];
} else {
  // Handle query failure
  die("Query Failed: " . $mysqli->error);
}


//setting the current index of riddles for the sessions
if (!isset($_SESSION['riddle_index'])) {
  $_SESSION['riddle_index'] = 0; // Start from the first riddle
}



?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Intended Option</title>
  <link rel="stylesheet" href="./styles/front-page.css">
</head>

<body>
  <header></header>
  <main>
    <?php
    if (
      isset($_SESSION['user_got_answer_wrong'])
      ||
      isset($_SESSION['user_got_answer_right'])
    ) {
      echo "The sessions are set now we will determine if the user lost or won";
      if (isset($_SESSION['user_got_answer_right'])) {
        echo "user got the answer correct";
    ?>
        <h2>Congratulations you have won the game</h2>
        <p>The copoun will be valid starting tomorrow and before the next monday <br>Thank you for playing!</p>
        <a href="">Navigate to our delisouse treats and view our inventory!</a>

      <?php
      } else if (isset($_SESSION['user_got_answer_wrong'])) {
        echo "user got the answer wrong";
      ?>
        <h2>Sorry your aswer was not correct please try again next time</h2>
        <a href="https://uprisingbreads.com/our-products/">Navigate to our delisouse treats and view our inventory!</a>
      <?php
      } else {
        echo "error we were not able to determine if the user got the answer right or wrong";
      }
    } else {
      $query = "SELECT * FROM list_riddles LIMIT 1 OFFSET " . $_SESSION['riddle_index'];
      $result = $mysqli->query($query);

      if ($result->num_rows) {
        $row = $result->fetch_assoc();
        $_SESSION['riddle_answer'] = $row['answer'];
        echo $_SESSION['riddle_answer'];
      ?>
        <div class="riddle-displayed">
          <h1>Riddle Days</h1>
          <h2><?php echo $row['riddle'] ?></h2>
          <form action="process-riddles-info.php" method="POST">
            <ul class="riddle-options-list">
              <li>
                <input type="radio" id="option_1" name="choices" value="<?php echo $row['option_1'] ?>">
                <label for="option_1"><?php echo $row['option_1'] ?></label>
              </li>
              <li>
                <input type="radio" id="option_2" name="choices" value="<?php echo $row['option_2'] ?>">
                <label for="option_2"><?php echo $row['option_2'] ?></label>
              </li>
              <li>
                <input type="radio" id="option_3" name="choices" value="<?php echo $row['option_3'] ?>">
                <label for="option_3"><?php echo $row['option_3'] ?></label>
              </li>
              <li>
                <input type="radio" id="option_4" name="choices" value="<?php echo $row['option_4'] ?>">
                <label for="option_4"><?php echo $row['option_4'] ?></label>
              </li>
            </ul>
            <div>
              <input type="text" placeholder="Gmail" type="gmail" id="gmail" name="users-gmail">
              <p>Enter your email to recive your copoun</p>
            </div>
            <div>
              <input type="checkbox" id="news-letter" name="subscribe" value="yes">
              <label for="news-letter">Would you like to recive new updates on Uprisings products & events</label>
            </div>
            <div class="submit-button">
              <input type="submit" value="Submit">
            </div>

          </form>
        </div>
    <?php
      }
      //closing dataBase Connection
      $mysqli->close();
    }

    ?>
    <section class="control-buttons">
      <div class="next-riddle">
        <form method="POST" action="next-riddle.php">
          <button type="submit">Next Riddle</button>
        </form>
        <p> --- The button is for simplification / riddles will be generated according to time and day</p>
      </div>
      <div class="users-want-notifications">
        <form method="POST" action="user-wants-notifications.php">
          <button type="submit">Get Users that Want to be Notified</button>
        </form>
        <p>--- The button is for simplification / list of users can be send according to desire</p>
      </div>
      <div class="users-want-notifications">
        <form method="POST" action="list-of-winners.php">
          <button type="submit">Get end of the day Winners</button>
        </form>
        <p> --- The button is for simplification / list of users can be send according to time and day</p>
      </div>
    </section>
    <?php
    ?>

  </main>
  <footer></footer>
</body>

</html>