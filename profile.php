<?php

 include("includes/header.php");
 include("includes/classes/User.php");
 include("includes/classes/Post.php");

 if(isset($_GET['profile_username'])){
   $username = $_GET['profile_username'];
   $user_details = mysqli_query($con, "SELECT * FROM users WHERE user_name = '$username'");
   $user_array = mysqli_fetch_array($user_details);

   $num_friends = (substr_count($user_array['friend_array'],",")-1);
 }

 if(isset($_POST['remove_Friend'])){
   $user = new User($con,$userLoggedIn);
   $user -> removeFriend($username);
 }

 if(isset($_POST['add_friend'])){
   $user = new User($con,$userLoggedIn);
   $user -> sendRequest($username);
 }

 if(isset($_POST['respond_request'])){
   header("Location:requests.php");
 }


?>

    <div class="profile_left">
      <img src="<?php echo $user_array['profile_pic'];?>" >
      <div class="profile_info">
            <p><?php echo "Posts: ".$user_array['num_posts']?></p>
            <p><?php echo "Likes: ".$user_array['num_likes']?></p>
            <p><?php echo "Friends: ".$num_friends?></p>
      </div>

      <form class="" action="<?php echo $username;?>" method="post">
        <?php
          $new_user_obj = new User($con, $username);
          if($new_user_obj->isClosed()){
            header("Location:user_closed.php");
          }

          $user_logged = new User($con, $userLoggedIn);

          if($userLoggedIn != $username){
            if($user_logged->isFriend($username)){
              echo "<input type='submit' name='remove_Friend' class='btn btn-lg btn-danger' value='Remove Friend'/>";
            }else if($user_logged->didReceiveRequest($username)){
              echo "<input type='submit' name='respond_request' class='btn btn-lg btn-primary' value='Respond to Request'/>";
            }else if($user_logged->didSendRequest($username)){
              echo "<input type='submit' name='sent_request' class='btn btn-lg btn-info' value='Request Sent'/>";
            }else{
              echo "<input type='submit' name='add_friend' class='btn btn-lg btn-success' value='Add Friend'/>";
            }
          }
        ?>
      </form>
    </div>
    <div class="profile_main">
          <?php echo $username?>

    </div>




</div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </body>
</html>
