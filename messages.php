<?php

  include("includes/header.php");
  include("includes/classes/User.php");
  include("includes/classes/Post.php");
  include("includes/classes/Message.php");

  $message_obj = new Message($con, $userLoggedIn);

  if(isset($_GET['u'])){
    $user_to = $_GET['u'];
  }else{
    $user_to = $message_obj -> getMostRecentUser();
    if($user_to == false){
      $user_to = 'New';
    }
  }

  if($user_to != 'New'){
    $user_to_obj = new User($con, $user_to);

    if(isset($_POST['post_message'])){
      if(isset($_POST['message_body'])){
        $body = mysqli_real_escape_string($con, $_POST['message_body']);
        $date = date("Y-m-d H:i:s");
        $message_obj->sendMessage($user_to, $body, $date);
      }
    }
  }

 ?>

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
   <?php
      if($user_to != 'New'){
        echo "<h4>You and <a href='$user_to'>" . $user_to_obj -> getFirstAndLastName() . "</a></h4><hr><br>";
        echo "<div class='loaded_messages'>";
        echo $message_obj->getMessages($user_to);
        echo "</div>";
      }else{
        echo "<h4>New Message</h4>";
      }
    ?>

    <div class="message_post">
      <form class="" action="" method="POST">
        <?php
          if($user_to == 'New'){
            echo "Select the friend you would like to message <br><br>";
            echo "To: <input type='Text'>";
            echo "<div class='results'></div>";
          }else{
            echo "<textarea name='message_body' id='message_textarea' placeholder='Write your message ...'></textarea>";
            echo "<input type='submit' name='post_message' class='btn btn-lg btn-info' id='message_submit' value='Send' />";
          }
         ?>
      </form>
    </div>


 </div>

 <div class="secondary_posts column">
   <h4>Conversations</h4>
   <div class="loaded_conversations">
     <?php echo $message_obj -> getConvos(); ?>
   </div>
   <br>
   <a href="messages.php?u=new">New Message</a>
 </div>
