<!doctype html>
<?php

 include("includes/header.php");
 include("includes/classes/User.php");
 include("includes/classes/Post.php");

 if(isset($_POST['post_text'])){
   $post = new Post($con,$userLoggedIn);
   $post -> submitPost($_POST['post_text'],"none");
   header("Location:home.php");
 }

?>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
     integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">

    <title>Welcome</title>
  </head>
  <body>
    <div class="users column">
      <a href="<?php echo $userLoggedIn; ?>">
        <img src="assets/images/profile_pics/defaults/profile_2.jpg" alt="">
        <!-- <img src="<?php echo user['profile_pic']?>" alt=""> -->
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
          <form class="post_form" action="home.php" method="post">
            <textarea class="" name="post_text" id="post_text" placeholder="Got something to say?"></textarea>
            <input class="btn btn-warning btn-lg" type="submit" name="post" id="post_button" value="Post">
            <br>
          </form>
          <?php
          $posts = new Post($con, $userLoggedIn);
          $posts->getPostsFriends();
          ?>
        </div>
        <div class="secondary_posts">
  <input type="submit" class="btn btn-block boton-ingresar" onclick="obtenerDatos(1);" value="INGRESAR">
              <div id="myCarousel" class="carousel slide"
              data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#myCarousel"
                data-slide-to="0" class="active" onclick="obtenerDatos(1);"> </li>
                <li data-target="#myCarousel"
                data-slide-to="1" onclick="obtenerDatos(1);"></li>
                <li data-target="#myCarousel"
                data-slide-to="2"></li>
              </ol>
              <div class="carousel-inner">
                  <div class="carousel-item active">
                  <div class="container" style="background-image:url();" id="noticia1">
                    <input type="text" id="txttitle" class="form-control">
                  </div>
                  </div>
                  <div class="carousel-item">
                  <div class="container">
                    <p>kjferjflejrfljrflkjrekjflkerjflkrje
                    ejfklerjkflj
                  felrjkfklerjflkjrelkfjlkr </p>
                  <a href="#" class="btn btn-lg btn-primary">Slide</a>
                  </div>
                  </div>
              </div>
              <a href="#myCarousel"
              class="carousel-control-prev" role="button"
              data-slide="prev">
              <span class="sr-only">Previous</span>
              <span class="carousel-control-prev-icon"
              aria-hidden="true"></span>
            </a>
            <a href="#myCarousel"
            class="carousel-control-next" role="button"
            data-slide="next">
            <span class="sr-only">Previous</span>
            <span class="carousel-control-next-icon"
            aria-hidden="true"></span>
            </a>
            </div>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    <script src="js/noticias.js"></script>
    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
  </body>
</html>
