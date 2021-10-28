<?php include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>


<?php

// the message
$msg = "First line of text\nSecond line of text";

// use wordwrap() if lines are longer than 70 characters
$msg = wordwrap($msg, 70);

// send email

if (isset($_POST['submit'])) {
  // echo "submit successful";
  $to = "pankajithape95@gmail.com";
  $subject = wordwrap($_POST['subject'], 70);
  $body = $_POST['body'];
  $header = "From: " . $_POST['email'];

  mail($to, $subject, $body, $header);

  //   if (!empty($username) && !empty($email) && !empty($password)) {

  //     $username = mysqli_real_escape_string($connection, $username);
  //     $email = mysqli_real_escape_string($connection, $email);
  //     $password = mysqli_real_escape_string($connection, $password);


  //     $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12));

  //     // $query = "SELECT randSalt from users";
  //     // $select_randsalt_query = mysqli_query($connection, $query);

  //     // if (!$select_randsalt_query) {
  //     //   die("Query failed" . mysqli_error($connection));
  //     // }

  //     // $row = mysqli_fetch_array($select_randsalt_query);
  //     // $salt = $row['randSalt'];

  //     // $password = crypt($password, $salt);

  //     $query = "INSERT INTO `users` ( `username`, `user_email`, `user_password`, `user_role`)";
  //     $query .= "VALUES ('$username', '$email', '$password',  'subscriber');";
  //     $register_user_query = mysqli_query($connection, $query);
  //     // confirmQuery($register_user_query);
  //     // echo "User created " . " " . "<a href='./users.php'>View users</a>";
  //     if (!$register_user_query) {
  //       die('query failed' . mysqli_query($connection, $register_user_query));
  //     } else {
  //       // echo "User created ";
  //     }

  //     $message = "Your registration has been submitted";
  //   } else {
  //     $message = 'Fields can not be empty';
  //   }
  //   // echo $message;
  // } else {
  //   $message = '';
  // }
}
?>

<!-- Navigation -->

<?php include "includes/navigation.php"; ?>


<!-- Page Content -->
<div class="container">

  <section id="login">
    <div class="container">
      <div class="row">
        <div class="col-xs-6 col-xs-offset-3">
          <div class="form-wrap">
            <h1>Register</h1>
            <form role="form" action="" method="post" id="login-form" autocomplete="off">
              <!-- <h6 class="text-center"><?php echo $message; ?></h6>
              <div class="form-group">
                <label for="username" class="sr-only">username</label>
                <input type="text" name="username" id="username" class="form-control"
                  placeholder="Enter Desired Username">
              </div> -->
              <div class="form-group">
                <label for="email" class="sr-only">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Enter your email">
              </div>
              <div class="form-group">
                <label for="subject" class="sr-only">Subject</label>
                <input type="text" name="subject" id="subject" class="form-control" placeholder="Enter your subject">
              </div>
              <div class="form-group">
                <!-- <label for="my-textarea">Text</label> -->
                <textarea id="my-textarea" class="form-control" name="" rows="10" cols="5"></textarea>
              </div>

              <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
            </form>

          </div>
        </div> <!-- /.col-xs-12 -->
      </div> <!-- /.row -->
    </div> <!-- /.container -->
  </section>


  <hr>



  <?php include "includes/footer.php"; ?>