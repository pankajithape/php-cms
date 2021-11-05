<?php include("./includes/db.php") ?>
<?php include("./includes/header.php") ?>
<?php include("./includes/navigation.php") ?>
<?php include("./admin/functions.php") ?>
<!-- Page Content -->
<div class="container">
  <div class="row">
    <!-- Blog Entries Column -->
    <div class="col-md-8">
      <?php

      if (isset($_GET['category'])) {
        $post_category_id = $_GET['category'];

        if (is_admin($_SESSION['username'])) {
          $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title , post_user , post_date , post_image , post_content FROM posts WHERE post_category_id=?");
        } else {
          $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title , post_user , post_date , post_image , post_content FROM posts WHERE post_category_id=$post_category_id AND post_status=?");
          $published = 'published';
        }


        if (isset($stmt1)) {
          mysqli_stmt_bind_param($stmt1, "i", $post_category_id);
          mysqli_stmt_execute($stmt1);
          mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
          $stmt = $stmt1;
        } else {
          mysqli_stmt_bind_param($stmt2, "is", $post_category_id, $published);
          mysqli_stmt_execute($stmt2);
          mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
          $stmt = $stmt2;
        }



        // echo $the_post_id;
        // $query = "SELECT * FROM posts WHERE post_id=$the_post_id";
        // $select_all_posts_query = mysqli_query($connection, $query);

        // $count = mysqli_num_rows($select_all_posts_query);

        // if ($count < 1) {
        //   echo "<h1 class='text-center'>no posts available</h1>";
        // } else {

        // $query = "SELECT * FROM posts WHERE post_category_id=$post_category_id AND post_status='published'";
        $select_all_posts_query = mysqli_query($connection, $query);
        if (mysqli_stmt_num_rows($stmt) === 0) {
          echo "<h1 class='text-center'>no posts available</h1>";
        }
        while ($row = mysqli_stmt_fetch($stmt)) :
          // $post_id = $row['post_id'];
          // $post_title = $row['post_title'];
          // $post_author = $row['post_author'];
          // $post_date = $row['post_date'];
          // $post_image = $row['post_image'];
          // $post_content = substr($row['post_content'], 0, 10);
      ?>
      <h1 class="page-header">
        Page Heading
        <small>Secondary Text</small>
      </h1>
      <!-- First Blog Post -->
      <h2>
        <a href="post.php?p_id=<?php echo $post_id; ?>"><?php echo $post_title ?></a>
      </h2>
      <p class="lead">
        <!-- by <a href="index.php"><?php // echo $post_author 
                                        ?></a> -->
        by <a href="index.php"><?php echo $post_user; ?></a>
      </p>
      <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date ?></p>
      <hr>
      <img class="img-responsive" src="/cms/images/<?php echo $post_image; ?>" alt="">
      <hr>
      <p><?php echo $post_content ?>
      </p>
      <a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
      <hr>
      <?php
        endwhile;
        mysqli_stmt_close($stmt);
      } else {
        header("Location: index.php");
      }
      ?>
    </div>
    <?php include("./includes/sidebar.php") ?>
  </div>
  <hr>
  <!-- /.row -->
  <?php include("./includes/footer.php") ?>