<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php include "./admin/includes/functions.php";?>

<?php

if (isset($_SESSION['register_error'])) {
    $_SESSION['register_error'] = array();
 }

if(isset($_POST['register'])){
  
  $user_name = trim($_POST['user_name']);
  $password  = trim($_POST['password']);
  $confirm_password = trim($_POST['confirm_password']);
  $user_firstname = trim($_POST['user_firstname']);
  $user_lastname = trim($_POST['user_lastname']);

  $register_error = [
      'user_name' => '',
      'password' => '',
      'confirm_password' => ''
  ];

  if (username_exists($user_name)) {
      
      $register_error['user_name'] = 'Username already exists, please pick another one or login';
  }
    
  if ($password != $confirm_password) {
      
      $register_error['password'] = 'Password does not match the confirm password';
  }

  foreach ($register_error as $key => $value) {
      if (empty($value)) {
          unset($register_error[$key]);
      }
  }

  if (empty($register_error)) {
    
      $user_name = mysqli_real_escape_string($connection, $user_name);
      $password = mysqli_real_escape_string($connection, $password); 
      $user_firstname = mysqli_real_escape_string($connection, $user_firstname);
      $user_lastname = mysqli_real_escape_string($connection, $user_lastname);
      
      // if we need password encrypt, uncomment this
      //$password = password_hash( $password, PASSWORD_BCRYPT, array('cost' => 12));
      
      $query = "INSERT INTO `user`(`user_name`,`password`,`first_name`, `last_name`) ";

      $query .= "VALUES('{$user_name}','{$password}','{$user_firstname}','{$user_lastname}') "; 

      $register_user_query = mysqli_query($connection, $query);
      if (!$register_user_query) {
         die("INSERT FAILED" . mysqli_error($connection));
      }
      confirmQuery($register_user_query);
      
      $the_post_id = mysqli_insert_id($connection);
      session_destroy();
      session_start();
      $_POST=array();
      
      login_user($user_name, $password);
      
  } else {
      $_SESSION['register_error'] = $register_error;
  }    
}
   
if(isset($_POST['cancel'])){
   redirect('login_page.php');
}

?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1 class="page-header">
                    Welcome to GTBay
                    <small>Registration</small>
                </h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="user_name" id="username" class="form-control" placeholder="Enter Desired Username" required>
                        </div>
                         <div class="form-group">
                            <label for="user_firstname" class="sr-only">First Name</label>
                            <input type="text" name="user_firstname" id="user_firstname" class="form-control" placeholder="First Name" required>
                        </div>
                         <div class="form-group">
                            <label for="emauser_lastnameil" class="sr-only">Last Name</label>
                            <input type="text" name="user_lastname" id="user_lastname" class="form-control" placeholder="Last Name" required>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password" required>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Confirm Password</label>
                            <input type="password" name="confirm_password" id="key" class="form-control" placeholder="Confirm Password" required>
                        </div>
                        
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit" name="register">Register</button>
<!--                            <button class="btn btn-dark" type="submit" name="cancel">Cancel</button>-->
                        </span>
                        
                        <a href="login_page.php">Cancel</a>
                    
                    <hr>
                        <?php
                            if (isset($_SESSION['register_error'])) {
                                foreach ($_SESSION['register_error'] as $message) {
                                    echo $message;
                                    echo "<br>";
                                }
                            }
                        ?>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<hr>
<?php include "includes/footer.php";?>
