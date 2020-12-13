<?php

require 'config/config.php';

$error_array = array();

if(isset($_POST['userButton'])){

  $email = filter_var($_POST["userEmail"],FILTER_SANITIZE_EMAIL);
  $_SESSION['userEmail'] = $email;
  $pass = md5($_POST["userpassword"]);

  $query = mysqli_query($con,"call select_login('$email','$pass')");  // Procedimiento almacenado
  $nr = mysqli_num_rows($query);

  if($nr == 1){
    echo "Bienvenido" .$nombre;

   $row = mysqli_fetch_array($query);

   $username = $row['user_name'];
   $user_closed = mysqli_connect($con,"SELECT * FROM USERS WHERE EMAIL='$email' and USER_CLOSED='yes'");
   if(mysqli_num_rows($user_closed)==1){
     $reopen_account = mysqli_query($con,"UPDATE USERS SET USER_CLOSED='no' WHERE EMAIL='$email'");
   }
   $_SESSION['username'] = $username;


    header("location:home.php");
    exit();


  }
  else {
    //echo "No ingreso";
    array_push($error_array,"Email or Password was incorrect<br>");

  }

}



?>
