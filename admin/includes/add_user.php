<?php
if (isset($_POST['create_user'])) {
  $user_firstname = $_POST['user_firstname'];
  $user_lastname = $_POST['user_lastname'];
  $user_role = $_POST['user_role'];
  $username = $_POST['username'];
  $user_email = $_POST['user_email'];
  $user_password = $_POST['user_password'];
  $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));

  // $user_email = $_POST['user_email'];
  // if (isset($_POST['post_image']) && isset($_POST['post_image_temp'])) {
  $post_image = $_FILES['image']['name'];
  $post_image_temp = $_FILES['image']['tmp_name'];
  // }
  if (isset($_POST['post_content'])) {
    $post_content      = $_POST['post_content'];
  }
  $post_date = date('d-m-y');
  // $post_comment_count = 4;
  move_uploaded_file($post_image_temp, "../images/$post_image");
  $query = "INSERT INTO `users` ( `username`, `user_password`, `user_firstname`, `user_lastname`, `user_role`, `user_email`)";
  $query .= "VALUES ('$username', '$user_password', '$user_firstname' , '$user_lastname', '$user_role', '$user_email');";
  $create_user_query = mysqli_query($connection, $query);
  confirmQuery($create_user_query);
  echo "User created " . " " . "<a href='./users.php'>View users</a>";
}
?>
<form action="" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="user_firstname">Firstname</label>
    <input type="text" name="user_firstname" class="form-control" />
    <div class="form-group">
      <label for="user_lastname">Lastname</label>
      <input type="text" name="user_lastname" class="form-control" />
    </div>
  </div>
  <!-- <div class="form-group">
    <label for="post_category_id">Post Category Id</label>
    <input type="text" name="post_category_id" class="form-control" />
  </div> -->
  <div class="form-group">
    <label for="user_role"> User role </label>
    <select name="user_role" id="">
      <option value="subscriber">Select Options</option>
      <option value="admin">admin</option>
      <option value="subscriber">subscriber</option>
    </select>
  </div>
  <div class="form-group">
    <label for="username">Username</label>
    <input type="text" name="username" class="form-control" />
  </div>
  <div class="form-group">
    <label for="user_email">Email</label>
    <input type="email" name="user_email" class="form-control" />
  </div>
  <div class="form-group">
    <label for="user_password">Password</label>
    <input type="password" name="user_password" class="form-control" />
  </div>
  <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" name="image" class="form-control" />
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_user" value="Add User" />
  </div>
</form>