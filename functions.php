<?php
    function add_user($file, $username, $password, $name){
        // We convert the username to lower
        $username = strtolower($username);
        $fh = fopen($file, "r+");
        if ($fh){
            $continue = true;
            while (!feof($fh) && $continue){
                $line = fgets($fh);
                $tableau = explode(" ", $line);
                if (count($tableau) >= 1){
                    if (strcmp($username, $tableau[0]) == 0){
                        $continue = false;
                    }
                }
            }
            if ($continue){
                fwrite($fh, $username." ".md5($password)." ".urlencode($name).PHP_EOL);
                fclose($fh);
                return "succes";
            }else{
                fclose($fh);
                return "username_exists";
            }
           
        }else{
            return "unable_open_file";
        }
    }

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
      if (preg_match("/^\w[\w ]*$/", $username)) {
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
    function validateCredentialsSignUp($email, $password, $name)
    {
      $validation = "<ul class='errors'>";
      if (!isValidEmail($email)) {
        $validation .= "<li>Invalid email</li>";
      }
  
      if (!isValidPassword($password)) {
        $validation .= "<li>Invalid password</li>";
      }

      if (!isValidUsername($name)){
        $validation .= "<li>Invalid name</li>";
      }
      $validation .= "</ul>";
  
      return $validation;
    }
?>