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
      <input type="submit" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal" name="" value="Post Something">

      <!-- Modal -->
      <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title" id="myModalLabel">Post Something!</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

            </div>

            <div class="modal-body">
              <p>This will appear on the user's profile page and also their newsfeed for your friends to see!</p>

              <form class="profile_post" action="index.html" method="POST">
                <div class="form-group">
                  <textarea class="form-control" name="post_body"></textarea>
                  <input type="hidden" name="user_from" value="<?php echo $userLoggedIn;?>">
                  <input type="hidden" name="user_to" value="<?php echo $username;?>">
                </div>
              </form>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary">Post</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="profile_main">
          <?php echo $username?>

    </div>







</div>

<!-- Latest compiled and minified JavaScript -->
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  </body>
</html>
