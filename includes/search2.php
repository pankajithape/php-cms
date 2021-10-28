<?php
  if (isset($_POST['submit'])) {
    $search = $_POST['search'];
    $query = "SELECT * FROM posts where post_tags LIKE '%$search%' ";
    $search_query = mysqli_query($connection, $query);
    if (!$search_query) {
      die('Query failed' . mysqli_error($connection));
    }
    $count = mysqli_num_rows($search_query);
    if ($count == 0) {
      echo "result not found";
    } else {
      echo "result";
    }
  }
