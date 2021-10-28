<?php
if (isset($_POST['create_post'])) {
  $post_title = escape($_POST['title']);
  // $post_author = $_POST['post_user'];
  $post_user = $_POST['post_user'];
  $post_category_id = $_POST['post_category'];
  $post_status = $_POST['post_status'];
  // if (isset($_POST['post_image']) && isset($_POST['post_image_temp'])) {
  $post_image = $_FILES['image']['name'];
  $post_image_temp = $_FILES['image']['tmp_name'];
  // }
  $post_tags = $_POST['post_tags'];
  // $post_content = $_POST['post_content'];
  if (isset($_POST['post_content'])) {
    $post_content      = $_POST['post_content'];
  }
  $post_date = date('d-m-y');
  // $post_date = $_POST['post_date'];
  // echo $post_Date;
  // $post_comment_count = 4;
  move_uploaded_file($post_image_temp, "../images/$post_image");
  $query = "INSERT INTO `posts` (`post_category_id`, `post_title`, `post_user`, `post_date`, `post_image`, `post_content`, `post_tags`, `post_status`)";
  $query .= "VALUES ($post_category_id, '$post_title', '$post_user', now(), '$post_image', '$post_content', '$post_tags',  '$post_status');";
  $create_post_query = mysqli_query($connection, $query);
  confirmQuery($create_post_query);
  $the_post_id = mysqli_insert_id($connection);
  echo "<p class='bg-success'>Post Created. <a href='../post.php?p_id={$the_post_id}'>View Post</a> or <a href='./posts.php'>Edit more Posts</a></p>";
}
?>
<form action="" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="title">Post Title</label>
    <input type="text" name="title" class="form-control" />
  </div>
  <!-- <div class="form-group">
    <label for="post_category_id">Post Category Id</label>
    <input type="text" name="post_category_id" class="form-control" />
  </div> -->
  <div class="form-group">
    <label for="post_category">Post category </label>
    <select name="post_category" id="">
      <option value="">select category</option>
      <?php
      // EDIT CATEGORY QUERY
      $query = "SELECT * FROM categories";
      $select_categories = mysqli_query($connection, $query);
      // confirmQuery($select_categories);
      while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        echo "<option value='$cat_id'>{$cat_title}</option>";
      }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="users">Users </label>
    <select name="post_user" id="">
      <option value="">select Users</option>
      <?php
      // EDIT CATEGORY QUERY
      $users_query = "SELECT * FROM users";
      $select_users = mysqli_query($connection, $users_query);
      confirmQuery($select_users);
      while ($row = mysqli_fetch_assoc($select_users)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        echo "<option value='$username'>{$username}</option>";
      }
      ?>
    </select>
  </div>
  <!-- <div class="form-group">
    <label for="author">Post Author</label>
    <input type="text" name="author" class="form-control" />
  </div> -->
  <div class="form-group">
    <!-- <label for="post_status">Post status</label> -->
    <!--<input type="text" name="post_status" class="form-control" /> -->
    <select name='post_status' id=''>
      <option value="draft">Post status</option>
      <option value="draft">Draft</option>
      <option value="publish"> Published</option>
    </select>
  </div>
  <div class="form-group">
    <label for="post_image">Post Image</label>
    <input type="file" name="image" class="form-control" />
  </div>
  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input type="text" name="post_tags" class="form-control" />
  </div>
  <div class="form-group">
    <label for="summernote">Post Content</label>
    <textarea class="form-control" id="summernote" name="post_content" cols="30" rows="4">
         </textarea>
  </div>
  <div class="form-group">
    <label for="post_comment_count">Post Comments Count</label>
    <input type="text" name="post_comment_count" class="form-control" />
  </div>
  <div class="form-group">
    <label for="post_date">Post Date</label>
    <input type="date" name="post_date" class="form-control" />
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="create_post" />
  </div>
</form>