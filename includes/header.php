<!DOCTYPE html>
<?php
  require 'config/config.php';


  //if user is properly logged it will get into the home.php otherwise it will head it back to the login page
  if(isset($_SESSION['username'])){
    $userLoggedIn = $_SESSION['username'];
    $userDetails = mysqli_query($con, "SELECT * FROM users WHERE user_name = '$userLoggedIn'");
    $userArray = mysqli_fetch_array($userDetails);
  }else{
    header("location:index.php");
  }
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>The Facebook</title>
    <link rel="shortcut icon" href="assets/images/favicon.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">

    <link rel="stylesheet" href="assets/css/home.css">
    <link rel="stylesheet" href="assets/css/message.css">
    <script src="https://use.fontawesome.com/f58802a848.js"></script>
  </head>
  <body>
  <div class="top_bar dropdown">
    <div class="logo">
      <img class="imagenes" src="assets/images/logo_transparent.png" alt="">
      <a id="titleLogo" href="/Proyecto1/home.php">The Facebook</a>
    </div>
    <nav>


<!-- this is the navigation bar -->
      <a href="<?php echo $userLoggedIn; ?>">
        <?php
           echo $userArray['first_name'];

        ?>
      </a>
      <a href="find.php">
        <i class="fa fa-search fa-2x"></i>
      </a>
      <a href="home.php">
        <i class="fa fa-home fa-2x"></i>
      </a>
      <a href="messages.php">
        <i class="fa fa-comment fa-2x"></i>
      </a>
      <a href="notifications.php?user=<?php echo $userLoggedIn?>">
        <i class="fa fa-bell-o fa-2x"></i>
        <?php
          if(isset($num_notifications)){
            if($num_notifications>0){
              echo "<span class='notification_badge' id='unread_notification'>".$num_notifications."</span>";
            }
          }
        ?>
      </a>
      <a href="requests.php">
        <i class="fa fa-users fa-2x"></i>
      </a>
      <a href="change_photo.php">
        <i class="fa fa-wrench fa-2x"></i>
      </a>
      <a href="includes/handlers/logout.php">
        <i class="fa fa-sign-out fa-2x"></i>
      </a>

    </nav>
  </div>
  <div class="container-fluid back">
