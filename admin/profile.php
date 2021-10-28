<?php include 'includes/admin_header.php'; ?>
<?php
if (isset($_SESSION['username'])) {
  $username = $_SESSION['username'];
  $query = "SELECT * FROM users where username = '{$username}' ";
  $select_user_profile_query = mysqli_query($connection, $query);
  while ($row = mysqli_fetch_array($select_user_profile_query)) {
    $user_id = $row['user_id'];
    $username = $row['username'];
    $user_password = $row['user_password'];
    $user_firstname = $row['user_firstname'];
    $user_lastname = $row['user_lastname'];
    $user_email = $row['user_email'];
    // $user_role = $row['user_role'];
    $user_image = $row['user_image'];
  }
}
?>

<?php
if (isset($_POST['edit_user'])) {
  // echo "<button class='btn btn-primary'>Hello<button>";
  // $the_user_id = $_POST['edit_user'];
  $user_firstname = $_POST['user_firstname'];
  $user_lastname = $_POST['user_lastname'];
  // $user_role = $_POST['user_role'];
  $username = $_POST['username'];
  // $username = $_SESSION['username'];
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
  $query = "UPDATE users SET ";
  $query .= "user_firstname = '{$user_firstname}', ";
  $query .= "user_lastname = '{$user_lastname}', ";
  // $query .= "user_role = '{$user_role}', ";
  $query .= "username  = '{$username}', ";
  $query .= "user_email   = '{$user_email}', ";
  $query .= "user_password  = '{$user_password}' ";
  $query .= "WHERE username = '{$username}' ";
  $edit_user_profile_query = mysqli_query($connection, $query);
  confirmQuery($edit_user_profile_query);
  // header("Location: users.php");
}
?>
<div id="wrapper">
  <!-- Navigation -->
  <?php include 'includes/admin_navigation.php'; ?>
  <div id="page-wrapper">
    <div class="container-fluid">
      <!-- Page Heading -->
      <div class="row">
        <div class="col-lg-12">
          <h1 class="page-header">
            Welcome to Admin
            <small>Author</small>
          </h1>
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
                <option value="subscriber"><?php echo $user_role; ?></option>
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
              <input class="btn btn-primary" type="submit" name="edit_user" value="Update Profile" />
            </div>
          </form>
        </div>
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </div>
  <!-- /#page-wrapper -->
</div>
<!-- /#wrapper -->
<?php include 'includes/admin_footer.php'; ?>