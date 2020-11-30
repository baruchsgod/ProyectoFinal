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


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
   <link rel="stylesheet" href="assets/css/home.css">
   <link rel="stylesheet" href="css/styles.css">
    <title>Hello, world!</title>
  </head>
  <body>
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

    <div class="main_post column ">


  <img src="<?php echo $userArray['profile_pic']?>" width="200">
  <div class="post_form">

  </div>
   <?php

    ?>
  <form method="POST" action="" enctype="multipart/form-data">
    <input type="file" name="imagen" >
    <input type="submit" name="subir" value="subir" class="btn btn-info center">
  </form>

  <?php
  if(isset($_POST['subir'])){
     $ruta = "imagenes/";
     $fichero = $ruta.basename($_FILES['imagen']['name']);
     $rut = $ruta.$userArray['id'].".jpg";
     if(move_uploaded_file($_FILES['imagen']['tmp_name'], $ruta.$userArray['id'].".jpg")){

        $foto = mysqli_query($con,"UPDATE users SET profile_pic = '$rut' WHERE id = '".$userArray['id']."'");


      }
       header("Refresh:0; url=change_photo.php");
   }

   ?>

    </div>



    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>

    <!-- Option 2: jQuery, Popper.js, and Bootstrap JS
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
    -->
  </body>
</html>
