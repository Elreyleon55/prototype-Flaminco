<?php
require_once("dbinfo.php");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (mysqli_connect_errno() != 0) {
  die("DB Connection Failed");
} else {
  // echo "<p>Connection Complete</p>";
}
session_start();
// 


// Get the current hour in 24-hour format
$currentHour = date('H'); // 'H' gives the hour (00 to 23)

// // Check the time and display a message
// if ($currentHour < 7) {
//   echo "Good morning! It's early—our bakery opens at 7:00 AM.";
// } elseif ($currentHour >= 18) {
//   echo "Good evening! Our bakery is closed, but we'll reopen tomorrow at 7:00 AM.";
// } else {
//   echo "Welcome! Our bakery is open. How can we help you today?";
// }

//Getting total number of riddles to then set the index
$query = "SELECT COUNT(*) as total FROM list_riddles;";
$result = $mysqli->query($query);
if ($result) {
  $row = $result->fetch_assoc();
  $_SESSION['total_riddles'] = $row['total']; // Store the total in the session
  // echo $_SESSION['total_riddles'];
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
  <link rel="stylesheet" href="./dist/css/style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&family=Roboto+Serif:ital,opsz,wght@0,8..144,100..900;1,8..144,100..900&display=swap" rel="stylesheet">
</head>

<body>
  <header>
    <section class="header-logo">
      <h2>YOUR LOGO</h2>
    </section>
    <section class="header-menu">
      <div>
        <p>Prizes</p>
        <p>Shop</p>
        <p>About</p>
        <p>Contact</p>
      </div>
    </section>
  </header>
  <main>
    <section class="intro-section-one">
      <div class="intro-background-image">
        <div class="intro-text-box-one">
          <p>WIN A FREE COFFEE, BY SOLVING THE MONDAY RIDDLE</p>
        </div>
        <!--  -->
      </div>
    </section>
    <section class="image-of-coffe-cup">
      <div class="container-coffe-mug">
        <!-- <img class="coffe-mug" src="media/Expresso-shots.jpg" alt="Photo of coffe mug"> -->
      </div>
      <div class="svg-section">
        <svg width="433" height="222" viewBox="0 0 433 222" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M58.1295 77.9015L45.8571 59.1518C41.6139 58.244 37.1805 57.8782 32.7699 57.9048L45.8571 77.9015H58.1295Z" fill="#D9D9D9" />
          <path d="M29.7378 77.9015L17.3337 96.9575C21.2223 97.7311 25.4269 98.2834 29.7378 98.4507L43.2445 77.9015H29.7378Z" fill="#D9D9D9" />
          <path d="M3 63.2877L13.7503 77.9015H29.7378L17.3337 59.4421C11.8723 60.4594 6.91969 61.8638 3 63.2877Z" fill="#D9D9D9" />
          <path d="M98.6497 59.1518C96.8856 62.4606 101.222 73.2264 103.611 78.1957C105.395 78.1145 107.193 78.0168 109.001 77.9015C106.286 70.2729 100.414 55.843 98.6497 59.1518Z" fill="#D9D9D9" />
          <path d="M94.2393 78.4788C92.3098 69.6948 87.7341 52.7047 84.8673 55.0158C82.0006 57.327 87.5319 71.6431 90.6559 78.5123C91.8377 78.508 93.0327 78.497 94.2393 78.4788Z" fill="#D9D9D9" />
          <path d="M94.2393 78.4788C93.0327 78.497 91.8377 78.508 90.6559 78.5123C86.3374 85.4777 78.5826 99.9048 82.1108 101.89C85.6391 103.875 91.6666 87.1097 94.2393 78.4788Z" fill="#D9D9D9" />
          <path d="M109.001 77.9015C107.193 78.0168 105.395 78.1145 103.611 78.1957C100.395 83.9798 94.6252 95.8239 97.2715 96.9269C100.579 98.3055 107.775 84.2433 109.001 77.9015Z" fill="#D9D9D9" />
          <path d="M412.061 219C419.136 204.294 432.79 173.449 430.805 167.714H410.738C411.21 186.084 411.72 205.847 412.061 219Z" fill="#D9D9D9" />
          <path d="M410.314 151.17C403.546 148.229 390.395 143.009 391.939 145.656C393.482 148.303 404.893 152.825 410.406 154.755L410.314 151.17Z" fill="#D9D9D9" />
          <path d="M410.314 151.17L410.406 154.755C417.206 153.192 430.805 149.626 430.805 147.862C430.805 146.097 417.145 149.332 410.314 151.17Z" fill="#D9D9D9" />
          <path d="M13.7503 77.9015L3 63.2877C6.91969 61.8638 11.8723 60.4594 17.3337 59.4421M13.7503 77.9015L4.65389 93.3424C8.11604 94.6805 12.4786 95.9915 17.3337 96.9575M13.7503 77.9015C15.8052 77.9015 20.9443 77.9015 29.7378 77.9015M13.7503 77.9015H29.7378M70.5337 77.9015C65.5721 66.8926 56.2899 61.3839 45.8571 59.1518M70.5337 77.9015C66.9499 77.9015 63.552 77.9015 60.3347 77.9015M70.5337 77.9015C66.4077 86.0249 60.348 91.2364 53.4435 94.3853M70.5337 77.9015C76.4626 78.3033 83.3031 78.5389 90.6559 78.5123M58.1295 77.9015L45.8571 59.1518M58.1295 77.9015C53.6825 77.9015 49.5966 77.9015 45.8571 77.9015M58.1295 77.9015C58.8549 77.9015 59.59 77.9015 60.3347 77.9015M58.1295 77.9015H45.8571M45.8571 59.1518C41.6139 58.244 37.1805 57.8782 32.7699 57.9048M29.7378 77.9015L17.3337 59.4421M29.7378 77.9015L17.3337 96.9575M29.7378 77.9015C33.5411 77.9015 38.0279 77.9015 43.2445 77.9015M29.7378 77.9015H43.2445M17.3337 59.4421C22.1989 58.5358 27.4678 57.9367 32.7699 57.9048M45.8571 77.9015L32.7699 57.9048M45.8571 77.9015C44.9667 77.9015 44.0959 77.9015 43.2445 77.9015M17.3337 96.9575C21.2223 97.7311 25.4269 98.2834 29.7378 98.4507M43.2445 77.9015L29.7378 98.4507M29.7378 98.4507C37.7184 98.7604 46.0635 97.7511 53.4435 94.3853M60.3347 77.9015L53.4435 94.3853M196.78 77.9015C195.67 84.5642 194.114 90.3113 192.37 95.1844M196.78 77.9015C197.663 73.214 214.422 59.0762 218.281 74.317C223.242 104.923 215.524 122.57 206.428 125.327C199.151 127.533 194.024 106.151 192.37 95.1844M196.78 77.9015C199.261 83.4641 211.555 90.921 240.884 76.2471M192.37 95.1844C188.225 106.767 183.022 113.412 180.241 115.677C171.88 122.294 152.236 126.375 140.548 89.7579C127.758 37.2588 152.677 14.5754 166.735 9.79602C175.28 9.06074 192.37 13.2702 192.37 35.9904C190.119 65.1018 147.285 75.4595 109.001 77.9015M240.884 76.2471C240.057 56.7622 241.49 16.193 253.839 9.79602C266.188 3.39906 265.6 19.9981 263.763 29.0972C261.827 38.3634 255.341 58.939 244.094 72.6626M240.884 76.2471C244.467 109.702 257.533 176.337 281.128 175.234C301.526 172.126 294.451 148.764 289.949 138.838C285.447 130.566 275.064 113.947 270.102 107.68C266.353 102.945 254.962 88.2812 247.72 77.9015M240.884 76.2471C241.994 75.1191 243.064 73.9196 244.094 72.6626M244.094 72.6626C245.13 74.1729 246.361 75.9536 247.72 77.9015M247.72 77.9015C255.936 81.8219 273.841 81.751 291.109 59.1518M291.109 59.1518C295.702 53.1412 300.25 45.537 304.558 35.9904C316.025 6.87326 309.336 1.24835 304.558 2.07554C297.3 0.972641 284.712 16.9651 292.43 89.7579C299.597 141.32 303.152 141.722 307.866 142.698C312.828 143.726 319.03 138.081 321.097 133.875C323.302 129.388 326.653 110.336 294.223 63.5635M291.109 59.1518C292.184 60.6491 293.222 62.1195 294.223 63.5635M294.223 63.5635C315.217 63.1958 372.643 44.1868 355.278 24.9612C345.906 17.5164 335.707 34.8119 334.053 41.505C333.65 43.1332 326.059 72.3868 340.668 80.1073C349.917 84.9949 363.558 64.7133 371.558 52.81M377.699 43.1594C378.187 42.3546 380.637 37.5693 384.219 33.709C386.665 31.0742 408.753 17.4409 410.406 33.709C410.406 45.8412 389.274 48.9497 381.464 45.0895L377.699 43.1594ZM377.699 43.1594C376.466 45.1918 374.309 48.7175 371.558 52.81M371.558 52.81C377.984 57.0127 389.623 67.3482 384.772 75.0686C378.708 84.7192 382.884 97.6454 384.772 102.366C385.323 103.745 396.073 126.63 424.189 115.05C437.421 107.053 420.055 96.5756 413.991 100.16C411.752 101.483 409.304 110.011 409.58 121.943C409.667 125.683 409.953 137.037 410.314 151.17M94.2393 78.4788C92.3098 69.6948 87.7341 52.7047 84.8673 55.0158C82.0006 57.327 87.5319 71.6431 90.6559 78.5123M94.2393 78.4788C93.0327 78.497 91.8377 78.508 90.6559 78.5123M94.2393 78.4788C91.6666 87.1097 85.6391 103.875 82.1108 101.89C78.5826 99.9048 86.3374 85.4777 90.6559 78.5123M94.2393 78.4788C97.2979 78.4326 100.431 78.3404 103.611 78.1957M103.611 78.1957C101.222 73.2264 96.8856 62.4606 98.6497 59.1518C100.414 55.843 106.286 70.2729 109.001 77.9015M103.611 78.1957C105.395 78.1145 107.193 78.0168 109.001 77.9015M103.611 78.1957C100.395 83.9798 94.6252 95.8239 97.2715 96.9269C100.579 98.3055 107.775 84.2433 109.001 77.9015M412.061 219C419.136 204.294 432.79 173.449 430.805 167.714M412.061 219C411.72 205.847 411.21 186.084 410.738 167.714M412.061 219C404.122 213.485 395.338 182.512 391.939 167.714H410.738M430.805 167.714C422.866 167.714 414.119 167.714 410.738 167.714M430.805 167.714H410.738M410.738 167.714C410.624 163.275 410.512 158.918 410.406 154.755M410.314 151.17C403.546 148.229 390.395 143.009 391.939 145.656C393.482 148.303 404.893 152.825 410.406 154.755M410.314 151.17C410.344 152.347 410.375 153.543 410.406 154.755M410.314 151.17C417.145 149.332 430.805 146.097 430.805 147.862C430.805 149.626 417.206 153.192 410.406 154.755M410.314 151.17L410.406 154.755" stroke="#D9D9D9" stroke-width="3" />
        </svg>

      </div>
    </section>
    <section class="riddle-section">
      <div class="inside-riddle-section">
        <div class="error-checker">
          <?php
          if (isset($_SESSION['my-erros'])) {
            echo "<ul>";
            foreach ($_SESSION['my-erros'] as $oneError) {
              echo "<li> * $oneError </li>";
            }
            echo "</ul>";
            unset($_SESSION['my-erros']);
          }
          ?>
        </div>
        <?php
        if (
          isset($_SESSION['user_got_answer_wrong'])
          ||
          isset($_SESSION['user_got_answer_right'])
        ) {
          // echo "The sessions are set now we will determine if the user lost or won";
          if (isset($_SESSION['user_got_answer_right'])) {
            // echo "user got the answer correct";
        ?>
            <section class="player-won-game">
              <h2>Congratulations you have won the game</h2>
              <p>The coupon will send to your email and will be valid for six days<br>Thank you for playing!</p>

              <a href="">Navigate to our delicious treats and view our inventory!</a>
            </section>

          <?php
          } else if (isset($_SESSION['user_got_answer_wrong'])) {
          ?>
            <section class="player-lost-game">
              <h2>Sorry your aswer was not correct please try again next Monday</h2>
              <a href="https://uprisingbreads.com/our-products/">Navigate to our delisouse treats and view our inventory!</a>
            </section>
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
            // echo $_SESSION['riddle_answer'];
          ?>

            <div class="riddle">
              <h1>"<?php echo $row['riddle'] ?>"</h1>
            </div>
            <div class="riddle-form">
              <form action="process-riddles-info.php" method="POST">
                <div class="riddle-options">
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
                </div>
                <div>
                  <p>Enter your email to receive your prize</p>
                  <input type="text" placeholder="Email" type="gmail" id="gmail" name="users-gmail">
                </div>
                <div>
                  <input type="checkbox" id="news-letter" name="subscribe" value="yes">
                  <label for="news-letter">I would like to receive updates on new products & events</label>
                </div>
                <div class="submit-button">
                  <input type="submit" value="Submit">
                </div>
              </form>
            </div>

            <?php
            ?>


    </section>
    <section class="control-buttons">
      <div class="control-buttons">
        <div class="next-riddle">
          <form method="POST" action="next-riddle.php">
            <button type="submit">Next Riddle</button>
          </form>
          <p>--- This button is for simplification / riddles will be generated according to date and time ---</p>
        </div>
        <div class="users-want-notifications">
          <form method="POST" action="user-wants-notifications.php">
            <button type="submit">Get Users That Want to be Notified</button>
          </form>
          <p>--- This button is for simplification / list of users can be sent according to needs ---</p>
        </div>
        <div class="users-want-notifications">
          <form method="POST" action="list-of-winners.php">
            <button type="submit">Get Winners' Information</button>
          </form>
          <p> --- This button is for simplification / list of users can be sent according to time and day ---</p>
        </div>
      </div>
      </div>
    </section>

<?php
          }
          //closing dataBase Connection
          $mysqli->close();
        }

?>


  </main>
  <footer>
    <div class="my-footer-div"></div>
  </footer>
</body>

</html>