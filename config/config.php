<?php
ob_start();
session_start();
$timeZone = date_default_timezone_set('America/Costa_Rica');

$con = mysqli_connect("localhost", "root", "", "social");

if(mysqli_connect_errno()){
  echo "failed to connect: " . mysqli_connect_errno();
}
?>
