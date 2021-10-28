<?php
if (isset($_GET['edit_user'])) {
  $the_user_id = $_GET['edit_user'];
  global $connection;
  $query = "SELECT * FROM users WHERE user_id=$the_user_id ";
  $select_users_query = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_assoc($select_users_query)) {
    $user_id = $row['user_id'];
    $username = $row['username'];
    $user_password = $row['user_password'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    $user_role = $row['user_role'];
    $user_image = $row['user_image'];
  }

  if (isset($_POST['edit_user'])) {
    // $the_user_id = $_POST['edit_user'];
    $user_firstname = $_POST['user_firstname'];
    $user_lastname = $_POST['user_lastname'];
    $user_role = $_POST['user_role'];
    $username = $_POST['username'];
    $user_email = $_POST['user_email'];
    $user_password = $_POST['user_password'];
    // $user_email = $_POST['user_email'];
    // if (isset($_POST['post_image']) && isset($_POST['post_image_temp'])) {
    // $post_image = $_FILES['image']['name'];
    // $post_image_temp = $_FILES['image']['tmp_name'];
    // // }
    // if (isset($_POST['post_content'])) {
    //   $post_content      = $_POST['post_content'];
    // }
    // $post_date = date('d-m-y');
    //   // $post_comment_count = 4;
    // $query = "SELECT randSalt from users";
    // $select_randsalt_query = mysqli_query($connection, $query);
    // if (!$select_randsalt_query) {
    //   die("Query failed" . mysqli_error($connection));
    // }
    // $row = mysqli_fetch_array($select_randsalt_query);
    // $salt = $row['randSalt'];
    // $hashed_password = crypt($user_password, $salt);
    if (!empty($user_password)) {
      $query_password = "SELECT user_password FROM users WHERE user_id=$the_user_id";
      $get_user_query = mysqli_query($connection, $query_password);
      confirmQuery($get_user_query);
      $row = mysqli_fetch_array($get_user_query);
      $db_user_password = $row['user_password'];
      if ($db_user_password != $user_password) {
        $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 12));
      }

      $query = "UPDATE users SET ";
      $query .= "username  = '{$username}', ";
      $query .= "user_firstname = '{$user_firstname}', ";
      $query .= "user_lastname = '{$user_lastname}', ";
      $query .= "user_role = '{$user_role}', ";
      $query .= "user_email   = '{$user_email}', ";
      $query .= "user_password  = '{$hashed_password}' ";
      $query .= "WHERE user_id = {$the_user_id} ";
      $edit_user_query = mysqli_query($connection, $query);
      header("Location: users.php");
      confirmQuery($edit_user_query);
    }
  }
} else {  // If the user id is not present in the URL we redirect to the home page
  header("Location: index.php");
}
?>
<form action="" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="user_firstname">Firstname</label>
    <input type="text" name="user_firstname" value="<?php echo $user_firstname; ?>" class="form-control" />
  </div>
  <div class="form-group">
    <label for="user_lastname">Lastname</label>
    <input type="text" name="user_lastname" value="<?php echo $user_lastname; ?>" class="form-control" />
  </div>
  <div class="form-group">
    <select name="user_role" id="">
      <option value="<?php echo $user_role; ?>"><?php echo $user_role; ?></option>
      <?php
      if ($user_role == 'admin') {
        echo "<option value='subscriber'>subscriber</option>";
      } else {
        echo "<option value='admin'>admin</option>";
      }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" name="username" value="<?php echo $username; ?>" class="form-control" />
  </div>
  <div class="form-group">
    <label for="user_email">Email</label>
    <input type="email" name="user_email" value="<?php echo $user_email; ?>" class="form-control" />
  </div>
  <div class="form-group">
    <label for="user_password">Password</label>
    <input autocomplete="off" type="password" name="user_password" class="form-control" />
  </div>
  <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" name="image" class="form-control" />
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User" />
  </div>
</form>