<?php

  require '../../config/config.php';
  include("../includes/classes/User.php");
  include("../includes/classes/Post.php");

  if(isset($_POST['post_body'])){
    $post_class = new Post($con,$_POST['user_from']);
    $post_class -> submitPost($_POST['post_body'],$_POST['user_to']);
  }

 ?>
