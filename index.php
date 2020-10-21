
<!doctype html>
<?php
  require 'includes/handlers/database.php';
?>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
    integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
  <link rel="stylesheet" href="css/styles.css">
  <title>Hello, world!</title>
</head>

<body>
  <div class="contenedor">
    <div class="row justify-content-center pt-5 mt-5 m-1">
      <div class="col-md-6 col-sm-8 col-xl-4 col-lg-5 formulario">

        <form  action="index.php" method="post">
          <div class="form-group text-center pt-1">
            <h1 class="text-light">Login</h1>
          </div>
          <div class="form-group mx-sm-5 pt-3">
            <input type="email" class="form-control" name="userEmail" placeholder="Enter your email" value="<?php
              if(isset($SESSION['userEmail'])){
                echo $SESSION['userEmail'];
              }
            ?>" required>
          </div>
          <div class="form-group mx-sm-5">
            <input type="password" class="form-control" name="userpassword" placeholder="Enter your password" autocomplete="off" required>
          </div>
          <!--la clase padre del boton lleva "mx-sm-5" da tamano de la caja-->
          <div class="form-group mx-sm-5 pb-3">
            <input type="submit" class="btn btn-block boton-ingresar" name="userButton" value="INGRESAR">

          </div>
          <div class="form-group text-center">
            <?php
              if(in_array("Email or Password was incorrect<br>",$error_array)){
                echo "<p style='color:red'>Email or Password was incorrect<br></p>";
              }
            ?>
          </div>

          <div class="form-group text-center">
            <span><a href="#" class="olvide">Forgot password?</a></span>
          </div>
          <div class="form-group text-center">
          <p class="par">Don't have an account?</p>
          <a id="aSignup" href="register.php" >Sign Up</a>
             </span>

          </div>
        </form>
      </div>
    </div>

  </div>

  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"
    integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
  </script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
    integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous">
  </script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"
    integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous">
  </script>
</body>

</html>
