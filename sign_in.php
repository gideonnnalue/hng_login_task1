<?php
$errors = "";
if (isset($_POST['sign_in_btn'])) {
  $email = $_POST['email_address'];
  $password = $_POST['password'];

  function check_credentials($file, $username, $password)
  {
    // We convert the username to lower
    $username = strtolower($username);
    $fh = fopen($file, "r");
    if ($fh) {
      $continue = true;
      while (!feof($fh) && $continue) {
        $line = fgets($fh);
        // We withdraw the carriage return next line character
        $line = substr($line, 0, strlen($line) - 2);
        $tableau = explode(" ", $line);
        if (count($tableau) >= 2) {
          if (strcmp($username, $tableau[0]) == 0 && strcmp(md5($password), $tableau[1]) == 0) {
            $continue = false;
          }
        }
      }
      fclose($fh);

      if ($continue) {
        // We reach the end of the file without finding the username
        return "user_not_authentificated";
      } else {
        return "user_authentificated";
      }
    } else {
      return "unable_open_file";
    }
  }

  function isValidPassword($password)
  {
    if (preg_match("/^[0-9a-zA-Z_!$@#^&* ]{1,}$/", $password)) {
      return true;
    } else {
      return false;
    }
  }
  function isValidUsername($username)
  {
    if (preg_match("/^\w{1,}$/", $username)) {
      return true;
    } else {
      return false;
    }
  }
  function isValidEmail($email)
  {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return true;
    } else {
      return false;
    }
  }
  function validateCredentials($email, $password)
  {
    $validation = "<ul class='errors'>";
    if (!isValidEmail($email)) {
      $validation .= "<li>Invalid email</li>";
    }

    if (!isValidPassword($password)) {
      $validation .= "<li>Invalid password</li>";
    }
    $validation .= "</ul>";

    return $validation;
  }
  $errors = validateCredentials($email, $password);

  if (strcmp($errors, "<ul class='errors'></ul>") == 0) {
    $connected = check_credentials("database", $email, $password);
    if (strcmp($connected, "user_authentificated") == 0) {
      header("location:connected.php");
    } else {
      $errors = "<span class='info'>Your login or password don't match.</span><br/>";
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700|Poppins:400,500,600,700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="./style.css" type="text/css" />
  <title>Login Page</title>
</head>

<body>
  <div class="container">
    <section class="card">
      <div class="image_description">
        <h1 class="main_title">
          <span class="main_span">
            <span class="blue_text">TEAM</span>
            <span>
              <span class="red_text">C</span>
              <span class="orange_text"> &lt;</span>
              <span class="skyBlue_text">&frasl;</span>
              <span class="purple_text"> &gt;</span>
              <span class="orange_text">D</span>
              <span class="green_text">E</span>
            </span>
            <span class="blue_text">IT</span>
          </span>
        </h1>
        <img src="sign_in.svg" alt="sigin image">
      </div>
      <div id="login_form">
        <h4 id="welcomeText">Welcome back</h4>
        <h1>Sign in</h1>
        <p>New user? <a href="sign_up.php">Create an account</a></p>
        <?php echo $errors; ?>
        <form action="" class="form" method="POST">
          <input id="email" type="email" class="form_control" name="email_address" placeholder="Email address">
          <br>
          <input id="password" type="password" class="form_control" name="password" placeholder="Password">
          <br>
          <input id="sign_in_btn" name="sign_in_btn" type="submit" class="btn_submit" value="SIGN IN">
          <p class="bottom_text">
            <div class="forgot_password_block"><a href="#" id="forgotpassword">Forgot Password?</a></div>
          </p>
        </form>
      </div>
    </section>
  </div>
</body>

</html>