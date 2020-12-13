<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="assets/css/likes.css">
  </head>
  <body>
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

    //Obtiene ID como parametro

    if(isset($_GET['post'])){
      $post=$_GET['post'];
    }

    $get_likes = mysqli_query($con,"SELECT likes,added_by FROM posts WHERE id='$post'");
    $row = mysqli_fetch_array($get_likes);
    $total_likes = $row['likes'];
    $user_liked = $row['added_by'];

    $get_user_details = mysqli_query($con, "SELECT num_likes FROM users WHERE user_name = '$user_liked'");
    $row = mysqli_fetch_array($get_user_details);
    $total_user_likes = $row['num_likes'];


    //Boton para dar Like

    if(isset($_POST['Like'])){
      $total_likes++;
      $total_user_likes++;
      $update_posts = mysqli_query($con,"UPDATE posts SET likes='$total_likes' WHERE id='$post'");
      $update_users = mysqli_query($con,"UPDATE users SET num_likes='$total_user_likes' WHERE user_name='$user_liked'");
      $insert_user_like = mysqli_query($con, "INSERT INTO likes VALUES('','$userLoggedIn','$post')");


      //Insert Notification

      if($user_liked != $userLoggedIn){
        $notification = new Notification($con, $userLoggedIn);
        $notification-> insertNotification($post, $user_liked, "Like");
      }
    }
    //Boton para dar unlike

    if(isset($_POST['Unlike'])){
      $total_likes--;
      $total_user_likes--;
      $update_posts = mysqli_query($con,"UPDATE posts SET likes='$total_likes' WHERE id='$post'");
      $update_users = mysqli_query($con,"UPDATE users SET num_likes='$total_user_likes' WHERE user_name='$user_liked'");
      $insert_user_like = mysqli_query($con, "DELETE FROM likes WHERE username = '$userLoggedIn' AND post_id = '$post' ");
    }

    //Buscar likes previos

    $check_likes = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND post_id='$post'");
    $num_rows = mysqli_num_rows($check_likes);

    if($num_rows > 0){
      echo "<form action='likes.php?post=".$post . "' method='POST'>
              <input type='submit' class='comment_like' name='Unlike' value='Unlike' />
              <div class='like_value'>"
                .$total_likes. " Likes
              </div>
            </form>";
    }else{
      echo "<form action='likes.php?post=".$post . "' method='POST'>
              <input type='submit' class='comment_like' name='Like' value='Like' />
              <div class='like_value'>"
                .$total_likes. " Likes
              </div>
            </form>";
    }

     ?>
  </body>
</html>
