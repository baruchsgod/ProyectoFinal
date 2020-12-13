<?php

//this is the connection to the database

$con = mysqli_connect("localhost", "root", "", "social");

if(mysqli_connect_errno()){
  echo "failed to connect: " . mysqli_connect_errno();
}
?>
