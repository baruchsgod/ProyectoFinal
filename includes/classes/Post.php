<?php
  /**
   *
   */
  class Post
  {
    private $user_obj;
    private $con;

    public function __construct($con,$user)
    {
      $this->con = $con;
      $this->user_obj = new User($con,$user);
    }

    public function submitPost($body, $user_to)
    {
      $body = strip_tags($body);
      $body = mysqli_real_escape_string($this->con, $body);
      $body = str_replace('\r\n','\n',$body);
      $body = nl2br($body);
      $check_query = preg_replace('/\s+/','',$body);

      if($check_query!=""){
        $date_added = date("Y-m-d H:i:s");
        $added_by = $this->user_obj->getUsername();

        if($user_to == $added_by){
          $user_to = "none";
        }

        $query = mysqli_query($this->con, "INSERT INTO POSTS VALUES ('','$body','$added_by','$user_to','$date_added','No','No','0')");
        $return_id = mysqli_insert_id($this->con);

        $num_posts = $this->user_obj->getNumPosts();
        $num_posts++;

        $update_query=mysqli_query($this->con, "UPDATE USERS SET num_posts = '$num_posts' WHERE user_name = '$added_by'");
      }
    }

    public function getPostsFriends()
    {
      $str = ""; // Inicializar variable que contendra el String
      $data = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='NO' ORDER BY id DESC");

      WHILE($row=mysqli_fetch_array($data)){
        $id = $row['id'];
        $body = $row['body'];
        $added_by = $row['added_by'];
        $user_to = $row['user_to'];
        $date_added = $row['date_added'];

        if($user_to=="none"){
          $user_to="";
        }else{
          $user_to_obj = new User($this->con,$user_to);
          $user_to_name = $user_to_obj -> getFirstAndLastName();
          $user_to_a = "<a href='".$user_to."'>".$user_to_name."</a>";
        }

        $userClosed = new User($this->con, $added_by);
        if($userClosed->isClosed()){
          continue;
        }

        $userDetails_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE user_name = '$added_by'");
        $user_row = mysqli_fetch_array($userDetails_query);


      }
    }
  }


 ?>
