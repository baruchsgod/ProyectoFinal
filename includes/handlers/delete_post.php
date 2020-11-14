<?php

  require '../../config/config.php';

  if(isset($_GET['post_id'])){
    $post_id = $_GET['post_id'];
    echo "<script>alert('Message');</script>";
    $query = mysqli_query($con, "UPDATE posts SET deleted='yes' WHERE id='$post_id'");

    header("Location:../../home.php");
  }

 ?>
