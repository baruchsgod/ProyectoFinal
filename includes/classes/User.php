<?php
  /**
   *
   */
  class User
  {
    private $user;
    private $con;

    public function __construct($con,$user)
    {

      $this->con = $con;
      $user_details_query = mysqli_query($con,"SELECT * FROM users WHERE user_name='$user'");
      $this->user = mysqli_fetch_array($user_details_query);

    }

    public function getFirstAndLastName()
    {
      $username = $this->user['user_name'];
      $query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE user_name = '$username'");
      $row = mysqli_fetch_array($query);
      return $row['first_name']." ".$row['last_name'];
    }

    public function getProfilePic()
    {
      $username = $this->user['user_name'];
      $query = mysqli_query($this->con, "SELECT profile_pic FROM users WHERE user_name = '$username'");
      $row = mysqli_fetch_array($query);
      return $row['profile_pic'];
    }

    public function getFriendArray()
    {
      $username = $this->user['user_name'];
      $query = mysqli_query($this->con, "SELECT friend_array FROM users WHERE user_name = '$username'");
      $row = mysqli_fetch_array($query);
      return $row['friend_array'];
    }

    public function getNumPosts()
    {
        $username = $this->user['user_name'];
        $query = mysqli_query($this->con, "SELECT num_posts FROM users WHERE user_name = '$username'");
        $row = mysqli_fetch_array($query);
        return $row['num_posts'];
    }

    public function getUsername()
    {
      return $this->user['user_name'];
    }

    public function isClosed()
    {
      $username = $this->user['user_name'];
      $close = mysqli_query($this->con, "SELECT user_closed FROM users WHERE user_name = '$username'");
      $row=mysqli_fetch_array($close);
      if($row['user_closed']=="yes"){
        return true;
      }else{
        return false;
      }
    }

    public function isFriend($user_to_check)
    {
      $userComma = $user_to_check;
      if(strstr($this->user['friend_array'],$userComma)|| $user_to_check==$this->user['user_name']){
        return true;
      }else{
        return false;
      }
    }

    public function didReceiveRequest($user_from)
    {
      $user_to = $this->user['user_name'];
      $check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to ='$user_to' AND user_from = '$user_from'");
      if(mysqli_num_rows($check_request_query)>0){
        return true;
      }else{
        return false;
      }
    }

    public function didSendRequest($user_to)
    {
      $user_from = $this->user['user_name'];
      $check_request_query = mysqli_query($this->con, "SELECT * FROM friend_requests WHERE user_to ='$user_to' AND user_from = '$user_from'");
      if(mysqli_num_rows($check_request_query)>0){
        return true;
      }else{
        return false;
      }
    }

    public function removeFriend($user_to_remove)
    {
      $loggedIn_user = $this->user['user_name'];

      $query = mysqli_query($this->con, "SELECT friend_array FROM users WHERE user_name='$user_to_remove'");
      $row = mysqli_fetch_array($query);
      $friend_list = $row['friend_array'];

      $new_friend_list = str_replace($user_to_remove.",", "", $this->user['friend_array']);

      $remove = mysqli_query($this->con, "UPDATE users SET friend_array = '$new_friend_list' WHERE user_name = '$loggedIn_user' ");

      $new_users_friend_list = str_replace($loggedIn_user.",","",$friend_list);
      $removeUser = mysqli_query($this->con, "UPDATE users SET friend_array = '$new_users_friend_list' WHERE user_name = '$user_to_remove' ");
    }

    public function sendRequest($user_to)
    {
      $user_from = $this->user['user_name'];
      $query = mysqli_query($this->con, "INSERT INTO friend_requests VALUES ('','$user_to','$user_from')");
    }

    public function getMutualFriends($user_to_check)
    {
      $mutual_friends = 0;
      $user_array = $this->user['friend_array'];
      $user_array_explode = explode(',', $user_array);

      $query = mysqli_query($this->con, "SELECT friend_array FROM users WHERE user_name = '$user_to_check'");

      $row = mysqli_fetch_array($query);

      $user_to_check_array = $row['friend_array'];
      $user_to_check_array_explode = explode(',', $user_to_check_array);

      foreach($user_array_explode as $i)
      {
        if(empty($i) || $i == NULL || $i == FALSE){

        }else{
          foreach($user_to_check_array_explode as $j){
            if(empty($j) || $j == NULL || $j == FALSE){

            }else{
              if(trim($i) == trim($j) ){
                $mutual_friends++;
              }
            }

          }

        }
      };
      return $mutual_friends;
    }
  }

 ?>
