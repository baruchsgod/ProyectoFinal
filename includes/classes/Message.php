<?php
  /**
   *
   */
   // Esta es la clase para todo lo relativo a los posts que se realizan, incluidos sus comentarios
  class Message
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

    public function getUserIfExists($user_to_find)
    {
      $query = mysqli_query($this->con, "SELECT * FROM users WHERE user_name = '$user_to_find' OR first_name = '$user_to_find'");

      $num = mysqli_num_rows($query);

      if($row = mysqli_fetch_array($query)){
        return $row['user_name'];
      }else{
        return "nothing";
      }
    }

    public function getMostRecentUser()
    {
      $userLoggedIn = $this -> user_obj -> getUsername();

      $query = mysqli_query($this -> con, "SELECT user_to, user_from FROM messages WHERE user_to = '$userLoggedIn' OR user_from = '$userLoggedIn' ORDER BY id DESC LIMIT 1");

      if(mysqli_num_rows($query)==0){
        return false;
      }

      $row = mysqli_fetch_array($query);
      $user_to = $row['user_to'];
      $user_from = $row['user_from'];

      if($user_to != $userLoggedIn){
        return $user_to;
      }else{
        return $user_from;
      }
    }

    public function sendMessage($user_to, $body, $date)
    {
      if(strlen($body)>0){

        $userLoggedIn = $this->user_obj->getUsername();
        $query = mysqli_query($this->con, "INSERT INTO messages VALUES ('','$user_to','$userLoggedIn', '$body', '$date', 'no', 'no', 'no' )");
      }
    }

    public function getMessages($otherUser){
      $userLoggedIn = $this->user_obj->getUsername($otherUser);
      $data = "";

      $query = mysqli_query($this->con, "UPDATE messages SET opened = 'yes' WHERE user_to = '$userLoggedIn' AND user_from = '$otherUser'");

      $get_messages_query = mysqli_query($this->con, "SELECT * FROM messages WHERE (user_to = '$userLoggedIn' AND user_from = '$otherUser') OR (user_from ='$userLoggedIn' AND user_to='$otherUser')");

      while($row = mysqli_fetch_array($get_messages_query)){
        $user_to = $row['user_to'];
        $user_from = $row['user_from'];
        $body = $row['body'];

        $div_top = ($user_to == $userLoggedIn) ? "<div class='message' id='green'>" : "<div class='message' id='blue'>";

        $data = $data . $div_top . $body . "</div><br><br>";
      }
      return $data;
    }

    public function getLatestMessage($userLogged, $user_to)
    {
      $details_array = [];

      $query = mysqli_query($this->con, "SELECT body, user_to, date FROM messages WHERE (user_to = '$userLogged' AND user_from = '$user_to') OR (user_to = '$user_to' AND user_from = '$userLogged') ORDER BY id DESC LIMIT 1");

      $row = mysqli_fetch_array($query);
      $sent_by = ($row['user_to'] == $userLogged) ? "They said: " : "You said: ";

      //Date Diff

      $date_time_now = date("Y-m-d H:i:s");
      $date_start = new DateTime($row['date']);
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

      array_push($details_array, $sent_by);
      array_push($details_array, $row['body']);
      array_push($details_array, $time_message);

      return $details_array;
    }

    public function getConvos()
    {
      $userLoggedIn = $this -> user_obj -> getUsername();
      $return_string = "";
      $convos = array();

      $query = mysqli_query($this->con, "SELECT user_to, user_from FROM messages WHERE user_to = '$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC");

      while($row = mysqli_fetch_array($query)){
        $user_to_push = ($row['user_to'] != $userLoggedIn) ? $row['user_to'] : $row['user_from'];

        if(!in_array($user_to_push, $convos)){
          array_push($convos, $user_to_push);
        }
      }

      forEach($convos as $username){
        $user_found_obj = new User($this->con, $username);
        $latest_message_details = $this->getLatestMessage($userLoggedIn, $username);

        $dots = (strlen($latest_message_details[1] >= 12)) ? "..." : "";

        $split = str_split($latest_message_details[1],12);

        $split = $split[0] . $dots;

        $return_string .= "<a href='messages.php?u=$username'><div class='user_found_messages'>
        <img src='".$user_found_obj->getProfilePic()."' style='border-radius:5px; margin-right: 10px;'/>".
        $user_found_obj->getFirstAndLastName()."
        <span class='timestamp_smaller' id='grey'>".$latest_message_details[2]."</span>
        <p id='grey' style='margin:0;'>".$latest_message_details[0]. $split ."</p>
        </div></a>";

      }

      return $return_string;
    }
  }

 ?>
