<?php


class Notification
{
  private $user_obj;
  private $con;


  //this is the constructor for the Notification class, it accepts the connection and the username of the current user.
  public function __construct($con,$user)
  {

    $this->con = $con;
    $this->user_obj = new User($con,$user);
  }

  //this allows the user to obtain the unread notifications

  public function getUnreadNumber()
  {
    $userLoggedIn = $this->user_obj->getUsername();
    $query = mysqli_query($this->con, "SELECT * FROM notifications WHERE viewed = 'no' AND user_to = '$userLoggedIn'");
    return mysqli_num_rows($query);
  }

  //this allows the system to insert notifications into the inbox of the different users whenever an event happens.

  public function insertNotification($post_id, $user_to, $type)
  {
    $userLoggedIn = $this->user_obj->getUsername();
    $userLoggedInName = $this->user_obj->getFirstAndLastName();

    $date_time = date("Y-m-d H:i:s");

    switch ($type) {
      case 'comment':
        $message = $userLoggedInName . " commented on your post";
        break;
      case 'Like':
        $message = $userLoggedInName . " liked your post";
      break;
      case 'Profile_post':
        $message = $userLoggedInName . " posted on your profile";
      break;
      case 'comment_non_owner':
        $message = $userLoggedInName . " commented on a post you commented on";
      break;
      case 'profile_comment':
        $message = $userLoggedInName . " commented on your profile post";
      break;
    }

    $link = "post.php?id=" . $post_id;

    $insert_query = mysqli_query($this->con, "INSERT INTO notifications VALUES ('', '$user_to', '$userLoggedIn', '$message', '$link', '$date_time', 'no', 'no')");
  }


  //this function retrieves all the latest notifications which are not viewed

  public function getMyNotifications()
  {
    $userLoggedIn = $this->user_obj->getUsername();

    $get_notifications = mysqli_query($this->con, "SELECT * FROM notifications WHERE user_to = '$userLoggedIn' AND viewed = 'no'");

    $row = mysqli_fetch_array($get_notifications);

    return $row;
  }

}
?>
