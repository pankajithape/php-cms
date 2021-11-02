<?php
if (isset($_GET['p_id'])) {
  $the_post_id = $_GET['p_id'];
}
global $connection;
$query = "SELECT * FROM posts WHERE post_id=$the_post_id";
$select_posts_by_id = mysqli_query($connection, $query);
while ($row = mysqli_fetch_assoc($select_posts_by_id)) {
  $post_id = $row['post_id'];
  // $post_author = $row['post_author'];
  $post_user = $row['post_user'];
  $post_title = $row['post_title'];
  $post_category_id = $row['post_category_id'];
  $post_status = $row['post_status'];
  $post_content = $row['post_content'];
  $post_image = $row['post_image'];
  $post_tags = $row['post_tags'];
  $post_comment_count = $row['post_comment_count'];
  $post_date = $row['post_date'];
}
if (isset($_POST['update_post'])) {
  // $post_author = $_POST['post_author'];
  $post_user = $_POST['post_user'];
  $post_title = $_POST['post_title'];
  $post_category_id = $_POST['post_category'];
  $post_status = $_POST['post_status'];
  $post_content = $_POST['post_content'];
  $post_tags = $_POST['post_tags'];
  if (isset($_FILES['post_image']['name'])) {
    $post_image = $_FILES['post_image']['name'];
    $post_image_temp = $_FILES['post_image']['tmp_name'];
    move_uploaded_file($post_image_temp, "../images/$post_image");
  }
  if (empty($post_image)) {
    $query = "SELECT * FROM posts WHERE post_id=$the_post_id";
    $select_image = mysqli_query($connection, $query);
    while ($row = mysqli_fetch_array($select_image)) {
      $post_image = $row['post_image'];
    }
  }
  // $query = "UPDATE `posts` SET  `post_title` = '{$post_title}', `post_author` ='{$post_author}', `post_date` = 'now()', `post_image` = '{$post_image}', `post_category_id` = '{$post_category_id}', `post_content` = '{$post_content}', `post_tags` = '{$post_tags}', `post_status` = '{$post_status}' WHERE `posts`.`post_id` = $the_post_id";
  // echo 'hell';
  $query = "UPDATE posts SET ";
  $query .= "post_title  = '{$post_title}', ";
  $query .= "post_category_id = '{$post_category_id}', ";
  $query .= "post_date   =  now(), ";
  // $query .= "post_author = '{$post_author}', ";
  $query .= "post_user = '{$post_user}', ";
  $query .= "post_status = '{$post_status}', ";
  $query .= "post_tags   = '{$post_tags}', ";
  $query .= "post_content= '{$post_content}', ";
  $query .= "post_image  = '{$post_image}' ";
  $query .= "WHERE post_id = {$the_post_id} ";
  $update_post = mysqli_query($connection, $query);
  confirmQuery($update_post);
  echo "<p class='bg-success'>Post updated. <a href='../post.php?p_id={$post_id}'>View Post</a> or <a href='./posts.php'>Edit more Posts</a></p>";
}
?>
<form action="" method="POST" enctype="multipart/form-data">
  <div class="form-group">
    <label for="post_title">Post Title</label>
    <input value="<?php echo $post_title ?>" type="text" name="post_title" class="form-control" />
  </div>
  <div class="form-group">
    <label for="post_author">Post category </label>
    <select name="post_category" id="">
      <?php
      // EDIT CATEGORY QUERY
      $query = "SELECT * FROM categories";
      $select_categories = mysqli_query($connection, $query);
      // confirmQuery($select_categories);
      while ($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        if ($cat_id == $post_category_id) {
          echo "<option value='{$cat_id}'>{$cat_title}</option>";
        } else {
          echo "<option value='{$cat_id}'>{$cat_title}</option>";
        }
      }
      ?>
    </select>
  </div>
  <div class="form-group">
    <label for="users">Users </label>
    <select name="post_user" id="">
      <!-- <?php echo "<option value='{$post_user}'>{$post_user}</option>"; ?> -->
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
  <div class="form-group">
    <label for="post_status">Post status</label>
    <select name="post_status" id="">
      <?php
      // // EDIT CATEGORY QUERY
      // $query = "SELECT * FROM categories";
      // $select_categories = mysqli_query($connection, $query);
      // // confirmQuery($select_categories);
      // while ($row = mysqli_fetch_assoc($select_categories)) {
      //   $cat_id = $row['cat_id'];
      //   $cat_title = $row['cat_title'];
      //   echo "<option value='$cat_id'>{$cat_title}</option>";
      // }
      // 
      ?>
      <!-- <option name="post_status" value='//?php echo $post_status ?>'><?php echo $post_status ?></option> -->
      <?php echo "<option value='{$post_status}'>{$post_status}</option>"; ?>
      if($post_status == 'published'){
      echo '<option value="draft"> Draft </option>';
      }else{
      echo '<option value="published"> Published </option>';
      }
    </select>
  </div>
  <!-- <div class="form-group">
    <label for="post_status">Post status</label>
    <input value="<?php echo $post_status ?>" type="text" name="post_status" class="form-control" />
  </div> -->
  <!-- <div class="form-group">
    <label for="post_category_id">Post Category Id</label>
    <input value="<?php echo $post_category_id ?>" type="text" name="post_title" class="form-control" />
  </div> -->
  <div class="form-group">
    <label for="post_image">Post Image</label>
    <img width="100" name="post_image" src="../images/<?php echo $post_image ?>">
    <input type="file" name="post_image" class="form-control" />
  </div>
  <div class="form-group">
    <label for="post_tags">Post Tags</label>
    <input value="<?php echo $post_tags ?>" type="text" name="post_tags" class="form-control" />
  </div>
  <div class="form-group">
    <label for="post_content">Post Content</label>
    <textarea class="form-control" name="post_content" id="summernote" cols="30" rows="4"> <?php echo str_replace('\r\n', '</br>', $post_content); ?> 
         </textarea>
  </div>
  <div class="form-group">
    <label for="post_comment_count">Post Comments Count</label>
    <input value="<?php echo $post_comment_count ?>" type="text" name="post_comment_count" class="form-control" />
  </div>
  <div class="form-group">
    <label for="post_date">Post Date</label>
    <input value="<?php echo $post_date ?>" type="date" name="post_date" class="form-control" />
  </div>
  <div class="form-group">
    <input class="btn btn-primary" type="submit" name="update_post" value="Update" />
  </div>
</form>