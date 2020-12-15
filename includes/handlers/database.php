<?php

require 'config/config.php'; //link to the connection

$error_array = array();

if(isset($_POST['userButton'])){


  $email = filter_var($_POST["userEmail"],FILTER_SANITIZE_EMAIL); //clears the email string received
  $_SESSION['userEmail'] = $email; //session variable for the email received
  $pass = md5($_POST["userpassword"]); //encripts the password to be able to use it in the comparison

  $query = mysqli_query($con,"call select_login('$email','$pass')");  // stored procedure
  $nr = mysqli_num_rows($query);

  if($nr == 1){
    echo "Bienvenido" .$nombre;

   $row = mysqli_fetch_array($query);

   $username = $row['user_name'];

   $user_closed = mysqli_connect($con,"SELECT * FROM USERS WHERE EMAIL='$email' and USER_CLOSED='yes'"); //this was in case an account needs to reopen
   if(mysqli_num_rows($user_closed)==1){
     $reopen_account = mysqli_query($con,"UPDATE USERS SET USER_CLOSED='no' WHERE EMAIL='$email'");
   }
   $_SESSION['username'] = $username; //session variable for the username


    header("location:home.php"); //gets me to the home
    exit();


  }
  else {
    //echo "No ingreso";
    array_push($error_array,"Email or Password was incorrect<br>"); //if password or email do not match this is the message the user will receive. 

  }

}



?>
