<?php

 include("includes/header.php");
 include("includes/classes/User.php");
 include("includes/classes/Post.php");

 if(isset($_POST['post_text'])){
   $post = new Post($con,$userLoggedIn);
   $post -> submitPost($_POST['post_text'],"none");
   header("Location:home.php");
 }

?>

  <div class="users column">
    <a href="<?php echo $userLoggedIn; ?>">
      <img src="assets/images/profile_pics/defaults/profile_2.jpg" alt="">
      <!-- <img src="<?php echo user['profile_pic']?>" alt=""> -->
    </a>
    <div class="users_left_right">
      <a href="<?php echo $userLoggedIn; ?>">
         <?php echo $userArray['first_name']." ".$userArray['last_name'];?>

      </a>
      <p>
         <?php echo 'Posts: '.$userArray['num_posts'];?>

      </p>
      <p>
         <?php echo 'Likes: '.$userArray['num_likes'];?>

      </p>

    </div>
  </div>
  <div class="main_post column">
    <form class="post_form" action="home.php" method="post">
      <textarea class="" name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
      <input class="btn btn-warning btn-lg" type="submit" name="post" id="post_button" value="Post">
      <br>
    </form>
    <?php
      $user_obj = new User($con, $userLoggedIn);
      echo $user_obj->getFirstAndLastName();
    ?>
  </div>


  </div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </body>
</html>
