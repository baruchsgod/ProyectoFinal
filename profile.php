<?php

 include("includes/header.php");

 if(isset($_GET['profile_username'])){
   $username = $_GET['profile_username'];
   $user_details = mysqli_query($con, "SELECT * FROM users WHERE user_name = '$username'");
   $user_array = mysqli_fetch_array($user_details);

   $num_friends = (substr_count($user_array['friend_array'],",")-1);
 }
?>

    <div class="profile_left">
      <img src="<?php echo $user_array['profile_pic'];?>" > 
      <div class="profile_info">
            <p><?php echo "Posts: ".$user_array['num_posts']?></p>
            <p><?php echo "Likes: ".$user_array['num_likes']?></p>
            <p><?php echo "Friends: ".$num_friends?></p>
      </div>
    </div>
    <div class="profile_main">
          <?php echo $username?>
          
    </div>
    



</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </body>
</html>
