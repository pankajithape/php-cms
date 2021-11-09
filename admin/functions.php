<?php
function redirect($location)
{
  return header("Location:" . $location);
}
function escape($string)
{
  global $connection;
  mysqli_real_escape_string($connection, trim($string));
}
function users_online()
{
  if (isset($_GET['onlineusers'])) {
    global $connection;
    if (!$connection) {
      session_start();
      include("../includes/db.php");
      $session = session_id();
      $time = time();
      $time_out_in_seconds = 5;
      $time_out = $time - $time_out_in_seconds;
      $query = "SELECT * FROM users_online WHERE session='$session'";
      $send_query = mysqli_query($connection, $query);
      $count = mysqli_num_rows($send_query);
      if ($count == NULL) {
        mysqli_query($connection, "INSERT INTO users_online(session,time) VALUES('$session','$time')");
      } else {
        mysqli_query($connection, "UPDATE users_online SET time=$time WHERE session='$session'");
      }
      $users_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out' ");
      $count_user = mysqli_num_rows($users_online_query);
      echo $count_user;
    }  // get request isset()
  }
}
users_online();
function confirmQuery($result)
{
  global $connection;
  if (!$result) {
    die("Query failed ." . mysqli_error($connection));
  }
}
function insert_categories()
{
  global $connection;
  if (isset($_POST['submit'])) {
    $cat_title = $_POST['cat_title'];
    if ($cat_title == "" || empty($cat_title)) {
      echo " the field should not be empty";
    } else {
      $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?)");
      // $stmt1 .= "VALUE('{$cat_title}')";
      mysqli_stmt_bind_param($stmt, 's', $cat_title);
      mysqli_stmt_execute($stmt);
      // $create_category_query = mysqli_query($connection, $query);
      if (!$stmt) {
        die("qyery not working" . mysqli_error($connection));
      }
    }
    mysqli_stmt_close($stmt);
  }
}
function find_all_categories()
{
  global $connection;
  $query = "SELECT * FROM categories ";
  $select_categories = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($select_categories)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];
    echo "<tr>
      <td>{$cat_id}</td>
      <td>{$cat_title}</td>
      <td><a href='categories.php?delete={$cat_id}'>Delete</a></td>
      <td><a href='categories.php?edit={$cat_id}'>Edit</a></td>
    </tr>";
  }
}
function deleteCategories()
{
  global $connection;
  if (isset($_GET['delete'])) {
    $the_cat_id = $_GET['delete'];
    $query = "DELETE FROM categories WHERE cat_id={$the_cat_id}";
    $delete_query = mysqli_query($connection, $query);
    header("Location: categories.php ");
  }
}
function recordCount($table)
{
  global $connection;
  $query = "SELECT * FROM " . $table;
  $select_all_post = mysqli_query($connection, $query);
  $result = mysqli_num_rows($select_all_post);
  confirmQuery($result);
  return $result;
}
function checkStatus($table, $column, $status)
{
  global $connection;
  $query = "SELECT * FROM $table WHERE $column = '$status' ";
  $result = mysqli_query($connection, $query);
  confirmQuery($result);
  return mysqli_num_rows($result);
}
function checkUserRole($table, $column, $role)
{
  global $connection;
  $query = "SELECT * FROM $table WHERE $column = '$role' ";
  $result = mysqli_query($connection, $query);
  confirmQuery($result);
  return mysqli_num_rows($result);
}
// function is_admin()
function is_admin($username)
{
  global $connection;
  if (isLoggedIn()) {
    $query = "SELECT user_role FROM users WHERE username='$username'";
    // $query = "SELECT user_role FROM users WHERE username=". $_SESSION['user_id '] ."";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    $row = mysqli_fetch_array($result);
    if ($row['user_role'] == 'admin') {
      return true;
    } else {
      return false;
    }
  }
  return false;
}
function username_exists($username)
{
  global $connection;
  $query = "SELECT username from users WHERE username='$username'";
  $result = mysqli_query($connection, $query);
  confirmQuery($result);
  if (mysqli_num_rows($result) > 0) {
    return true;
  } else {
    return false;
  }
}
function email_exists($user_email)
{
  global $connection;
  $query = "SELECT user_email from users WHERE user_email='$user_email'";
  $result = mysqli_query($connection, $query);
  confirmQuery($result);
  if (mysqli_num_rows($result) > 0) {
    return true;
  } else {
    return false;
  }
}

function register_user($username, $email, $password)
{
  global $connection;

  // if (username_exists($username)) {
  //   $message = "username exists already";
  // }
  // if (email_exists($username)) {
  //   $message = "user email exists already";
  // }
  // if (!empty($username) && !empty($email) && !empty($password)) {
  $username = mysqli_real_escape_string($connection, $username);
  $email = mysqli_real_escape_string($connection, $email);
  $password = mysqli_real_escape_string($connection, $password);
  $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));
  // $query = "SELECT randSalt from users";
  // $select_randsalt_query = mysqli_query($connection, $query);
  // if (!$select_randsalt_query) {
  //   die("Query failed" . mysqli_error($connection));
  // }
  // $row = mysqli_fetch_array($select_randsalt_query);
  // $salt = $row['randSalt'];
  // $password = crypt($password, $salt);
  $query = "INSERT INTO `users` ( `username`, `user_email`, `user_password`, `user_role`)";
  $query .= "VALUES ('$username', '$email', '$password',  'subscriber');";
  $register_user_query = mysqli_query($connection, $query);
  confirmQuery($register_user_query);
  // echo "User created " . " " . "<a href='./users.php'>View users</a>";
  if (!$register_user_query) {
    die('query failed' . mysqli_query($connection, $register_user_query));
  } else {
    // echo "User created ";
  }
  $message = "Your registration has been submitted";
  // } else {
  //   $message = 'Fields can not be empty';
  // }
  // echo $message;
  // login_user($username, $password);
}

function login_user($username, $password)
{
  global $connection;
  $username = trim($username);
  $password = trim($password);
  $username = mysqli_real_escape_string($connection, $username);
  $password = mysqli_real_escape_string($connection, $password);
  $query = "SELECT * FROM users WHERE username='{$username}'";
  // echo 'xxxxxxxx';
  $select_user_query = mysqli_query($connection, $query);
  if (!$select_user_query) {
    die("query failed " . mysqli_error($connection));
  }
  while ($row = mysqli_fetch_array($select_user_query)) {
    $db_user_id = $row['user_id'];
    $db_username = $row['username'];
    $db_user_password = $row['user_password'];
    $db_user_firstname = $row['user_firstname'];
    $db_user_lastname = $row['user_lastname'];
    $db_user_role = $row['user_role'];
  }
  // $password = crypt($password, $db_user_password);
  // if ($username !== $db_username && $password !== $db_user_password) {
  //   header("Location: ../index.php");
  // } else  {
  //   $_SESSION['username'] =  $db_username;
  //   $_SESSION['user_firstname'] =  $db_user_firstname;
  //   $_SESSION['user_lastname'] =  $db_user_lastname;
  //   $_SESSION['user_role'] =  $db_user_role;p
  //   header("Location: ../admin");
  // }
  if (password_verify($password, $db_user_password)) {
    // if (true) {
    $_SESSION['user_id'] =  $db_user_id;
    $_SESSION['username'] =  $db_username;
    $_SESSION['user_firstname'] =  $db_user_firstname;
    $_SESSION['user_lastname'] =  $db_user_lastname;
    $_SESSION['user_role'] =  $db_user_role;
    // header("Location: ../admin");
    redirect("/cms/admin");
  } else {
    // echo 'xxxxxxxx';

    // header("Location: ../index.php");
    redirect("/cms/index.php");

    // echo 'xxxxxxxx';
  }
}

function isLoggedIn()
{
  // echo 'bbb';
  if (isset($_SESSION['username'])) {
    // return $_SESSION['user_role'];
    return true;
    // echo 'x1';
  } else {
    return false;
    // echo 'x2';
  }
}

function loggedInUserId()
{
  // echo "xxxxxx";
  if (isLoggedIn()) {
    $result = query("SELECT * FROM users WHERE username='" . $_SESSION['username'] . "'");
    confirmQuery($result);
    // echo $_SESSION['username']; 
    $user = mysqli_fetch_array($result);
    if (mysqli_num_rows($result) >= 1) {
      return $user['user_id'];
      // return 'yyyy';
    }
  }
  return false;
}

function query($query)
{
  global $connection;
  return mysqli_query($connection, $query);
}

function userLikedThisPost($post_id = '')
{
  $result = query("SELECT * FROM likes WHERE user_id=" . loggedInUserId() . " AND post_id={$post_id}");

  return mysqli_num_rows($result) >= 1 ? true : false;
  // if (mysqli_num_rows($result) >= 1) {
  //   return true;
  // } else {
  //   return false;
  // }
}

function getPostLikes($post_id)
{
  $result = query("SELECT * FROM likes WHERE post_id=$post_id");
  confirmQuery($result);
  echo mysqli_num_rows($result);
}

// Functions for user specific dashboard

function checkStatusForUserPublishedPosts($table, $column, $status)
{
  global $connection;
  $username = $_SESSION['username'];
  $query = "SELECT * FROM $table WHERE $column = '$status' AND post_user='$username'";
  $result = mysqli_query($connection, $query);
  confirmQuery($result);
  return mysqli_num_rows($result);
}
function checkStatusForUserDraftPosts($table, $column, $status)
{
  global $connection;
  $username = $_SESSION['username'];
  $query = "SELECT * FROM $table WHERE $column = '$status' AND post_user='$username'";
  $result = mysqli_query($connection, $query);
  confirmQuery($result);
  return mysqli_num_rows($result);
}
function checkStatusForUnapprovedCommentsCount()
{
  global $connection;
  $username = $_SESSION['username'];
  $query = "SELECT * FROM comments WHERE comment_status = 'unapproved' AND comment_author='$username' ";
  $result = mysqli_query($connection, $query);
  confirmQuery($result);
  return mysqli_num_rows($result);
}
function checkStatusForApprovedCommentsCount()
{
  global $connection;
  $username = $_SESSION['username'];
  $query = "SELECT * FROM posts INNER JOIN comments ON posts.post_id=comments.comment_post_id WHERE  comment_author='$username' AND comment_status='approved'";
  $select_all_comments = mysqli_query($connection, $query);
  $comments_counts = mysqli_num_rows($select_all_comments);
  return $comments_counts;
}