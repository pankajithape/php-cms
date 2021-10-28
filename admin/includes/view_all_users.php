<table class="table table-bordered table-hover">
  <thead>
    <tr>
      <th>Id</th>
      <th>Username</th>
      <th>Firstname</th>
      <th>Lastname</th>
      <th>Email</th>
      <th>Role</th>
      <!-- <th>Date</th> -->
    </tr>
  </thead>

  <tbody>
    <tr>

      <?php


      global $connection;
      $query = "SELECT * FROM users ";
      $select_users = mysqli_query($connection, $query);
      while ($row = mysqli_fetch_assoc($select_users)) {
        $user_id = $row['user_id'];
        $username = $row['username'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_role = $row['user_role'];
        $user_image = $row['user_image'];
        // $user_date = $row['user_date'];

        // confirmQuery($select_categories);




        echo "<tr>
                <td>$user_id</td>
                <td>$username</td>
                <td>$user_firstname</td>
                <td>$user_lastname</td>
                <td>$user_email</td>";



        // $query = "SELECT * FROM categories where cat_id=$post_category_id";
        // $select_categories = mysqli_query($connection, $query);

        // while ($row = mysqli_fetch_assoc($select_categories)) {
        //   $cat_id = $row['cat_id'];
        //   $cat_title = $row['cat_title'];
        //   // echo "<option value='$cat_id'>{$cat_title}</option>";
        //   // $post_category_id = $row['post_category_id'];
        //   echo "<td>$cat_title</td>";
        // }

        // $query = "SELECT * FROM posts WHERE post_id=$comment_post_id";
        // $select_post_id_query = mysqli_query($connection, $query);
        // while ($row = mysqli_fetch_assoc($select_post_id_query)) {
        //   $post_id = $row['post_id'];
        //   $post_title = $row['post_title'];
        //   echo "<td><a href='../post.php?p_id=$post_id'>$post_title</a></td>";
        // }



        echo "
        <td>$user_role</td>
        <td>$user_image</td>
        <td><a href='users.php?change_to_admin=$user_id'>Admin</a></td>
        <td><a href='users.php?change_to_sub=$user_id'>Subscriber</a></td>
        <td><a href='users.php?source=edit_user&edit_user=$user_id'>Edit</a></td>
        <td><a href='users.php?delete=$user_id'>Delete</a></td>
          </tr>";
      }

      ?>

      <?php

      if (isset($_GET['delete'])) {
        if (isset($_SESSION['user_role'])) {
          if ($_SESSION['user_role'] == 'admin') {
            $the_user_id = mysqli_real_escape_string($connection, $_GET['delete']);
            $query = "DELETE FROM `users` WHERE `users`.`user_id` = $the_user_id";
            $delete_user_query = mysqli_query($connection, $query);
            header("Location: users.php");
          }
        }
      }
      if (isset($_GET['change_to_admin'])) {
        $the_user_id = $_GET['change_to_admin'];
        $query = "UPDATE `users` SET `users`.`user_role` = 'admin' WHERE user_id=$the_user_id";
        $change_to_admin_query = mysqli_query($connection, $query);
        header("Location: users.php");
      }
      if (isset($_GET['change_to_sub'])) {
        $the_user_id = $_GET['change_to_sub'];
        $query = "UPDATE `users` SET `users`.`user_role` = 'subscriber' WHERE user_id=$the_user_id";
        $change_to_subscriber_query = mysqli_query($connection, $query);
        header("Location: users.php");
      }

      ?>

    </tr>
  </tbody>
</table>