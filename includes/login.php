<?php session_start(); ?>
<?php include "db.php"; ?>
<!-- <?php //include "../admin/functions.php"; 
      ?> -->
<!-- <?php //include "../admin/functions.php"; 
      ?> -->
<?php include "../admin/functions.php"; ?>
<?php
// echo "xxxxxxxxxxxxxxxx" . xx();
// if (isset($_POST['login'])) {
if (isset($_POST['username']) && isset($_POST['password'])) {
  login_user($_POST['username'], $_POST['password']);
}
?>