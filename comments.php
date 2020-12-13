<!DOCTYPE html>
<?php
  require 'config/config.php';
  include("includes/classes/User.php");
  include("includes/classes/Post.php");
  include("includes/classes/Notification.php");

  if(isset($_SESSION['username'])){
    $userLoggedIn = $_SESSION['username'];
    $userDetails = mysqli_query($con, "SELECT * FROM users WHERE user_name = '$userLoggedIn'");
    $userArray = mysqli_fetch_array($userDetails);
  }else{
    header("location:index.php");
  }
?>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/comments.css">
  </head>
  <body>

    <script>
      function toggle(){
        var post_id = document.getElementById("comments");

        if(post_id.style.display == "block"){
          post_id.style.display == "none";
        }else{
          post_id.style.display == "block";
        }
      }
    </script>
    <?php
      if(isset($_GET['post'])){
        $post = $_GET['post'];
        $my_query = mysqli_query($con,"SELECT added_by, user_to FROM posts WHERE id='$post'");
        $row = mysqli_fetch_array($my_query);

        $posted_to = $row['added_by'];
        $user_to = $row['user_to'];

        if(isset($_POST['postComment'.$post])){
          $post_body = $_POST['post_body'];
          $post_body = mysqli_escape_string($con, $post_body);
          $date_now = date("Y-m-d H:i:s");
          $insert_post = mysqli_query($con, "INSERT INTO post_comments VALUES ('','$post_body','$userLoggedIn','$posted_to','$date_now','no','$post')");

          //Insert Notification

          if($posted_to != $userLoggedIn){
            $notification = new Notification($con, $userLoggedIn);
            $notification-> insertNotification($post, $posted_to, "comment");
          }

          if($user_to != 'none' && $user_to != $userLoggedIn){
            $notification = new Notification($con, $userLoggedIn);
            $notification-> insertNotification($post, $user_to, "profile_comment");
          }

          $get_commenters = mysqli_query($con, "SELECT * FROM post_comments WHERE post_id = '$post'");
          $notified_users = array();

          while($row = mysqli_fetch_array($get_commenters)) {
            if($row['posted_by']!= $posted_to && $row['posted_by'] != $user_to && $row['posted_by'] != $userLoggedIn && !in_array($row['posted_by'], $notified_users)){
              $notification = new Notification($con, $userLoggedIn);
              $notification-> insertNotification($post, $row['posted_by'], "comment_non_owner");

              array_push($notified_users, $row['posted_by']);
            }
          }

          echo "<p>
          Comment Posted!
          </p>";
          //Esto es una prueba
        }

      }
     ?>

     <form id="comment_form" action="comments.php?post=<?php echo $post?>" name="postComment<?php echo $post?>" method="post">
       <textarea name="post_body"></textarea>
       <input class="btn btn-lg btn-info" type="submit" name="postComment<?php echo $post ?>" value="Post">

     </form>

     <?php
        $get_comment = mysqli_query($con, "SELECT * FROM post_comments WHERE post_id = '$post'");
        $count = mysqli_num_rows($get_comment);

        if($count != 0){

          while($comment=mysqli_fetch_array($get_comment)){
            $comment_body = $comment['post_body'];
            $posted_by = $comment['posted_by'];
            $posted_to = $comment['posted_to'];
            $date_added = $comment['date_added'];
            $removed = $comment['removed'];

            //Date Diff
            $date_time_now = date("Y-m-d H:i:s");
            $date_start = new DateTime($date_added);
            $date_end = new DateTime($date_time_now);
            $interval = $date_start->diff($date_end);

            if($interval->y >=1){
              if($interval->y==1){
                $time_message = $interval->y . " year ago";
              }else{
                $time_message = $interval->y . " years ago";
              }
            }else if($interval->m>=1){
              if($interval->d ==0){
                $days = " ago";
              }else if($interval->d ==1){
                $days = $interval->d . " day ago";
              }else{
                $days = $interval->d . " days ago";
              }

              if($interval->m ==1){
                $time_message = $interval->m . " month ". $days;
              }else{
                $time_message = $interval->m." months ".$days;
              }
            }else if($interval->d>=1){
              if($interval->d ==1){
                $time_message = "Yesterday";
              }else{
                $time_message = $interval->d . " days ago";
              }
            }else if($interval->h >=1){
              if($interval->h ==1){
                $time_message = "An hour ago";
              }else{
                $time_message = $interval->h . " hours ago";
              }
            }else if($interval->i>=1){
              if($interval->i ==1){
                $time_message = " a minute ago";
              }else{
                $time_message = $interval->i . " minutes ago";
              }
            }else{
              $time_message = "less than a minute ago";
            }

            // End Date diff

            $user_obj = new User($con, $posted_by);
            ?>
            <div class="comment_section">
              <a href="<?php echo $posted_by?>" target="_parent"><img src="<?php echo $user_obj -> getProfilePic()?>" height="30" /></a>
              <a href="<?php echo $posted_by?>" target="_parent"><?php echo $user_obj-> getFirstAndLastName()?></a>

              <p id="tiempo"><?php echo $time_message?></p>
              <p class="comentario"><?php echo $comment_body?></p>

            </div>
            <?php
          }
        }else{
          echo "<center>
          <br />
          No comments to show
          </center>";
        }
     ?>


  </body>
</html>
