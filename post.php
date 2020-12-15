<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");

if(isset($_GET['id'])){
  $post_id = $_GET['id'];
  $action = $_GET['action'];
  $notification_id = $_GET['notification'];
  $query = mysqli_query($con, "SELECT * FROM posts WHERE id = '$post_id'"); //finds the correct post id

  $details = mysqli_fetch_array($query);

  //this will let the user know what action is related to one post from the notification stand point
  $query_notifications = mysqli_query($con, "SELECT * FROM notifications WHERE id = '$notification_id'");
  $noti = mysqli_fetch_array($query_notifications);
  if($action == 1){
    $title_details = $noti['user_from']." liked";
  }else if($action == 2){
    $title_details = $noti['user_from']." talked about";
  }else{
    $title_details = $noti['user_from']." commented";
  }

  $update_query = mysqli_query($con, "UPDATE notifications SET viewed = 'yes' WHERE id = '$notification_id'");

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

<!-- this will display a table with the notification information -->
 <div class="main_post column">
   <h3>This is the post that <?php echo $title_details;?> </h3>
   <table class="table table-bordered table-dark">
  <thead>
    <tr>
      <th scope="col">Added By</th>
      <th scope="col">User To</th>
      <th scope="col">Post</th>
      <th scope="col">Date</th>
      <th scope="col">Likes</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <th><?php echo $details['added_by'];?></th>
      <td><?php echo $details['user_to'];?></td>
      <td><?php echo $details['body'];?></td>
      <td><?php echo $details['date_added'];?></td>
      <td><?php echo $details['likes'];?></td>
    </tr>
  </tbody>
</table>
 </div>
