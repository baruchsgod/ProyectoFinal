<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="assets/css/home.css">
  </head>
  <body>
    <?php
      require 'config/config.php';
      include("includes/classes/User.php");
      include("includes/classes/Post.php");

      if(isset($_SESSION['username'])){
        $userLoggedIn = $_SESSION['username'];
        $userDetails = mysqli_query($con, "SELECT * FROM users WHERE user_name = '$userLoggedIn'");
        $userArray = mysqli_fetch_array($userDetails);
      }else{
        header("location:index.php");
      }
    ?>
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
      if(isset($_GET['id_post'])){
        $post = $_GET['id_post'];

        $my_query = mysqli_quer($con,"SELECT added_by, user_to FROM posts WHERE id='$post'");
        $row = mysqli_fetch_array($my_query);

        $posted_to = $row['added_by'];

        if(isset($_POST['postComment'.$post])){
          $post_body = $_POST[post_body];
          $post_body = mysqli_escape_string($con, $post_body);
          $date_now = date("Y-m-d H:i:s");
          $insert_post = mysqli_query($con, "INSERT INTO post_comments VALUES ('','$post_body',$userLoggedIn,'$posted_to','$date_now','no','$post')");
        }

      }
     ?>

     <form id="comment_form" action="comments.php?id_post=<?php echo $post?>" name="postComment<?php echo $post?>" method="post">
       <textarea name="post_body"></textarea>
       <input type="submit" name="postComment<?php echo $post ?>" value="Post">
     </form>
  </body>
</html>
