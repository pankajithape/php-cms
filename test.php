<?php include("includes/db.php") ?>
<?php include("includes/header.php") ?>
<?php include("includes/navigation.php") ?>
<?php include("admin/functions.php") ?>
<?php
// phpinfo();
// echo password_hash('secret', PASSWORD_BCRYPT, array('cost' => 10));
// echo isLoggedIn();
echo loggedInUserId();

if (userLikedThisPost(45)) {
  echo "user liked the post";
} else {
  echo "user did not liked this post";
}