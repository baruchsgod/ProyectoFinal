<?php
include("includes/header.php");
include("includes/classes/User.php");
include("includes/classes/Post.php");
include("includes/classes/Message.php");
include("includes/classes/Notification.php");

if(isset($_GET['user'])){
  $user_receive = $_GET['user'];

  $query = mysqli_query($con, "SELECT * FROM notifications WHERE user_to = '$user_receive' AND viewed = 'no'");

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

 <div class="main_post column">
   <table class="table table-bordered table-dark">
  <thead>
    <tr>
      <th scope="col">User From</th>
      <th scope="col">Notification</th>
      <th scope="col">Date</th>
      <th scope="col">See notification</th>
    </tr>
  </thead>
  <tbody>
    <?php
    if(empty($query)){
        echo '<tr>';
        echo '<td colspan="6">'."No Notifications to show".'</td>';
        echo '</tr>';
    }else{
      while($row = mysqli_fetch_array($query)){
        echo '<tr>';
        echo '<td>'.$row['user_from'].'</td>';
        echo '<td>'.$row['message'].'</td>';
        echo '<td>'.$row['datetime'].'</td>';
        if(strpos($row['message'],"liked") == true){
          $link = $row['link']."&action=1";
        }else if(strpos($row['message'],"posted") == true){
          $link = $row['link']."&action=2";
        }else{
          $link = $row['link']."&action=3";
        }
        $id_notification = $row['id'];

        $link = $link . "&notification=".$id_notification; 
        echo '<td><a href="'.$link.'"><button class="btn btn-info">Notification</button></a></td>';
        echo '</tr>';
      }
    }
    ?>
  </tbody>
</table>
 </div>
