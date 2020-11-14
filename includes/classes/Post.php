<?php
  /**
   *
   */
  class Post
  {
    private $user_obj;
    private $con;
    private $userLoggedIn;

    public function __construct($con,$user)
    {
      $this->userLoggedIn = $user;
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
          $user_to_a="";
        }else{
          $user_to_obj = new User($this->con,$user_to);
          $user_to_name = $user_to_obj -> getFirstAndLastName();
          $user_to_a = "to <a href='".$user_to."'>".$user_to_name."</a>";
        }

        $userClosed = new User($this->con, $added_by);
        if($userClosed->isClosed()){
          continue;
        }

        $friend_obj = new User($this->con,$this->userLoggedIn);

        if($friend_obj->isFriend($added_by)){

          if($this->userLoggedIn== $added_by){
            $delete_button = "<button class='btn btn-danger' id='post$id' type='submit' onClick='deletePost(this)' value='$id' >X</button>";
          }else{
            $delete_button = "";
          }
        $userDetails_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE user_name = '$added_by'");
        $user_row = mysqli_fetch_array($userDetails_query);
        $first_name = $user_row['first_name'];
        $last_name = $user_row['last_name'];
        $profile_pic = $user_row['profile_pic'];

        ?>
        <script>
        function toggle<?php echo $id;?>(){

          var target = $(event.target);
          var post_id = document.getElementById("toggleComment<?php echo $id;?>");
          if(!target.is("a")){
            if(post_id.style.display === "block"){
              post_id.setAttribute("style","display:none");
            }else{
              post_id.setAttribute("style","display:block");

            }
          }



        }
        </script>
        <?php

        $posts_num = mysqli_query($this->con, "SELECT * FROM post_comments WHERE post_id = '$id'");
        $num_post = mysqli_num_rows($posts_num);
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

        $str.= "<div class='container-fluid borders' onClick='javascript:toggle$id()'>
                  <div class='posts'>
                    <img src='$profile_pic' width='75'>
                  </div>
                  <div>
                    <a href='$added_by'>$first_name $last_name</a> $user_to_a &nbsp;&nbsp; $time_message

                      $delete_button

                  </div>
                  <div class='body_class'>
                    $body
                    <br>
                  </div>
                  <div class='numComment_likes'>
                    Comments($num_post)
                    <iframe src='likes.php?post=$id'></iframe>
                  </div>
                </div>
                <div class='comments' id='toggleComment$id' style='display:none;'>
                  <iframe src='comments.php?post=$id' id='comment_iframe' frameborder='0'></iframe>
                </div>";
              }
              ?>
              <script>

                  function deletePost(post){
                    var id = post.value;
                    var url = "includes/handlers/delete_post.php?post_id="+id;
                      bootbox.confirm("Are you sure you want to delete this post?",function(result){

                        if(result){
                          var form = $('<form></form>');

                          form.attr("method", "post");
                          form.attr("action", url);

                          var field = $('<input />');

                          field.attr("type","hidden");
                          field.attr("name",result);
                          field.attr("value", result);

                          $(document.body).append(form);

                          form.submit();

                          
                          }else{

                        }
                      })
                  }
              </script>

              <?php
      }

      echo $str;
    }
  }


 ?>
