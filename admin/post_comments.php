<?php include 'includes/admin_header.php'; ?>
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


          <table class="table table-bordered table-hover">
            <thead>
              <tr>
                <th>Id</th>
                <th>Author</th>
                <th>Comment</th>
                <th>Email</th>
                <th>Status</th>
                <th>In Response to</th>
                <th>Date</th>
                <th>Approve</th>
                <th>Unapprove</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>

            <tbody>
              <tr>

                <?php


                global $connection;
                $query = "SELECT * FROM comments WHERE comment_post_id=" . mysqli_real_escape_string($connection, $_GET['id']) . "";
                $select_comments = mysqli_query($connection, $query);
                while ($row = mysqli_fetch_assoc($select_comments)) {
                  $comment_id = $row['comment_id'];
                  $comment_post_id = $row['comment_post_id'];
                  $comment_author = $row['comment_author'];
                  $comment_content = $row['comment_content'];
                  $comment_email = $row['comment_email'];
                  $comment_status = $row['comment_status'];
                  $comment_date = $row['comment_date'];

                  // confirmQuery($select_categories);




                  echo "<tr>
                <td>$comment_id</td>
                <td>$comment_author</td>
                <td>$comment_content</td>
                <td>$comment_email</td>
                <td>$comment_status</td>";



                  // $query = "SELECT * FROM categories where cat_id=$post_category_id";
                  // $select_categories = mysqli_query($connection, $query);

                  // while ($row = mysqli_fetch_assoc($select_categories)) {
                  //   $cat_id = $row['cat_id'];
                  //   $cat_title = $row['cat_title'];
                  //   // echo "<option value='$cat_id'>{$cat_title}</option>";
                  //   // $post_category_id = $row['post_category_id'];
                  //   echo "<td>$cat_title</td>";
                  // }

                  $query = "SELECT * FROM posts WHERE post_id=$comment_post_id";
                  // echo $comment_post_id;
                  $select_post_id_query = mysqli_query($connection, $query);
                  while ($row = mysqli_fetch_assoc($select_post_id_query)) {
                    $post_id = $row['post_id'];
                    $post_title = $row['post_title'];
                    echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
                  }



                  echo "
        <td>$comment_date</td>
                <td><a href='comments.php?approve=$comment_id'>Approve</a></td>
                <td><a href='comments.php?unapprove=$comment_id'>UnApprove</a></td>
                <td><a href='comments.php?edit=$comment_id'>Edit</a></td>
                <td><a href='post_comments.php?delete=$comment_id&id=" . $_GET['id'] . "'>Delete</a></td>
          </tr>";
                }

                ?>

                <?php

                if (isset($_GET['delete'])) {
                  $the_comment_id = $_GET['delete'];
                  $query = "DELETE FROM `comments` WHERE `comments`.`comment_id` = $the_comment_id";
                  $delete_query = mysqli_query($connection, $query);
                  header("Location: post_comments.php?id=" . $_GET['id'] . "");
                }
                if (isset($_GET['approve'])) {
                  $the_comment_id = $_GET['approve'];
                  $query = "UPDATE `comments` SET `comments`.`comment_status` = 'approved' WHERE comment_id=$the_comment_id";
                  $approve_query = mysqli_query($connection, $query);
                  header("Location: comments.php");
                }
                if (isset($_GET['unapprove'])) {
                  $the_comment_id = $_GET['unapprove'];
                  $query = "UPDATE `comments` SET `comments`.`comment_status` = 'unapproved' WHERE comment_id=$the_comment_id";
                  $unapprove_query = mysqli_query($connection, $query);
                  header("Location: comments.php");
                }

                ?>

              </tr>
            </tbody>
          </table>



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