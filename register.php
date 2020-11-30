<!DOCTYPE html>
<?php
require 'config/config.php';
require 'includes/handlers/register_handler.php';

?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Welcome to TheSocialNetwork</title>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka+One&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/register_style.css">
  </head>
  <body>
    <div class="register_box">
      <div class="header_box">
        <img class="imagen" src="assets/images/logo_transparent.png" alt="the facebook">
        Register your information
      </div>
      <form class="" action="register.php" method="post">
        <input class="" type="text" name="reg_fname" placeholder="First Name" value="<?php
          if(isset($_SESSION['reg_fname'])){
            echo $_SESSION['reg_fname'];
          };
        ?>" required>
        <?php if(in_array("Your first name must be between 2 and 35 characters<br>",$error_array)) echo "<br>Your first name must be between 2 and 35 characters<br>"?>
        <br>
        <input type="text" name="reg_lname" placeholder="Last Name" value="<?php
          if(isset($_SESSION['reg_lname'])){
            echo $_SESSION['reg_lname'];
          }
        ?>" required>
        <?php if(in_array("Your last name must be between 2 and 45 characters<br>",$error_array)) echo "<br>Your last name must be between 2 and 45 characters<br>"?>
        <br>
        <input type="email" name="reg_email" placeholder="Email" value="<?php
          if(isset($_SESSION['reg_email'])){
            echo $_SESSION['reg_email'];
          }
        ?>" required>
        <br>
        <input type="email" name="reg_email2" placeholder="Confirm Email" value="<?php
          if(isset($_SESSION['reg_email2'])){
            echo $_SESSION['reg_email2'];
          }
        ?>" required>
        <?php if(in_array("Email already exists<br>",$error_array)) {echo "<br>Email already exists<br>";}
        elseif(in_array("Email format is incorrect<br>",$error_array)) echo "<br>Email format in incorrect<br>";
        elseif(in_array("Emails dont match<br>",$error_array)) echo "<br>Emails dont match<br>";?>
        <br>
        <input type="password" name="reg_password" placeholder="Password" value="" required>
        <br>
        <input type="password" name="reg_password2" placeholder="Confirm Password" value="" required>
        <?php if(in_array("Your passwords do not match<br>",$error_array)) {echo "<br>Your passwords do not match<br>";}
        elseif(in_array("Your password only takes letter or numbers<br>",$error_array)) echo "<br>Your password only takes letter or numbers<br>";
        elseif(in_array("Your password must be between 5 and 30 characters<br>",$error_array)) echo "<br>Your password must be between 5 and 30 characters<br>";?>
        <br>
      </br>
      <div class="text-center">
        <a href="index.php" class="btn  btn-info">Back</a>
        <button type="submit" name="register_button" value="Register"class="btn btn-info">Register</button>

      </div>

        <?php
        if(in_array("<span style='color:#14C800'>You are all set! Go ahead and login!</span>",$error_array)) echo "<br><span style='color:#14C800'><a href='/Proyecto1/index.php'>You are all set! Go ahead and login!</a></span>"
        ?>

      </form>
    </div>

  </body>
</html>
