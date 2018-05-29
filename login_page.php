<?php
include "./admin/includes/functions.php";
include "includes/db.php";
include "includes/header.php";
?>

<?php
checkLogged('home.php');

if(isset($_SESSION['login_error'])){
    $_SESSION['login_error'] = array();
}

if (isset($_POST['login'])) {
    
    login_user($_POST['username'], $_POST['password']);
}

if (isset($_POST['register'])) {
                                
    redirect('registration.php');
                            
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
                            <small>Login</small>
                        </h1>
                        <form action="" method="post">
                        
                         <!--username-->
                          <div class="form-group">
                               <label for="username">Username:</label>
                               <input type="text" name="username" class="form-control" placeholder="Enter Username" required>
                          </div>
                        
                         <!--password-->
                          <div class="form-group">
                               <label for="password">Password:</label>
                               <input type="password" name="password" class="form-control" placeholder="Enter Password" required>
                          </div>
                          
                          <!--Login-->
                          <input class="btn btn-primary" type="submit" name="login" value="Login">
                          
                        </form>
                        
                            <!--register-->
 
                          <p>
                              Not yet a user? <a href="registration.php">Register</a>
                          </p>
                          
                           
                           <hr>
                           <?php
                           if (isset($_SESSION['login_error'])) {
                              echo $_SESSION['login_error'];
                           }
                           ?>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>

<hr>
<?php include "includes/footer.php" ?>