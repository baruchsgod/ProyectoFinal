<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");

$message_obj = new Message($con, $userLoggedIn);

if(isset($_POST['btnFindUser'])){

  $user_find = $_POST['txtUsername'];

  $found = $message_obj -> getUserIfExistsProfile($user_find);

}
 ?>

 <!-- this part contains the generic image of the user with the number of likes and posts -->
 <div class="users column">
   <a href="<?php echo $userLoggedIn; ?>">

     <img src="<?php echo $userArray['profile_pic']?>" alt="">
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

 <div class="main_post column" id="main_column">
   <h4>Find User</h4>
   <br>
   <!-- form to submit a request to find an user -->
   <form class="" action="" method="POST">
     <input class="form-control adjust_input" type="text" name="txtUsername" value="">
     <button class="btn btn-info btn-lg adjust_button" type="submit" name="btnFindUser">Find</button>
   </form>

   <?php
   //this is the result of the search
   if(isset($found)){
     echo $found;
   }

   ?>
 </div>
