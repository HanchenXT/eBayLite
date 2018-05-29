<?php include "includes/admin_header.php" ?>
        
<?php 
    if (isset($_SESSION['username'])){
        echo $_SESSION['username'];
        $username =  $_SESSION['username'];
        $query = "SELECT * FROM user WHERE user_name = '{$username}'";
        
        $select_user_profile_query = mysqli_query($connection, $query);
        
        while($row = mysqli_fetch_array($select_user_profile_query)){
            $user_id = $row['userID'];
            $user_name = $row['user_name'];
            $password = $row['password'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $get_admin_query = "SELECT position FROM adminuser WHERE userID = {$row['userID']} ";
            $get_position = mysqli_fetch_assoc(mysqli_query($connection, $get_admin_query));
            
        }
    }




?>

    <div id="wrapper">



        <!-- Navigation -->
 
        <?php include "includes/admin_navigation.php" ?>
        
        
    




<div id="page-wrapper">

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">

  <h1 class="page-header">
                Welcome to admin
                <small>Author</small>
            </h1>
            
            
<?php

if(isset($_GET['source'])){

$source = $_GET['source'];

} else {

$source = '';

}








?>

 

<?php
   if(isset($_POST['edit_user'])){
            $user_name         = escape($_POST['user_name']);
//            $item_user         = escape($_POST['post_user']);
            $password  = escape($_POST['password']);
            $user_firstname= escape($_POST['user_firstname']);
            $user_lastname         = escape($_POST['user_lastname']);
            $admin  = escape($_POST['admin']); 
//            $item_end_hour         = escape(date('d-m-y'));

       
//        move_uploaded_file($post_image_temp, "../images/$post_image" );
       


        $query = "UPDATE user SET ";
        $query .= "`user_name` = '{$user_name}', ";
        $query .= "`password` = '{$password}', ";
        $query .= "`first_name` = '{$user_firstname}', ";
        $query .= "`last_name` = '{$user_lastname}'";
       
       $query .= " WHERE `userID` = {$user_id} ;";
       
       
      $create_item_query = mysqli_query($connection, $query);  
      confirmQuery($create_item_query);
        if($_POST['admin'] == 'admin'){
          $admin_position = $_POST['position'];
            
            
              
              
          $query = "SELECT * FROM user WHERE `user_name` = '{$user_name}' "; 
            
            $select_users = mysqli_query($connection, $query);  
            $row = mysqli_fetch_assoc($select_users);
            $user_id = $row['userID'];
//            $admin_position = $_POST['position'];
          $query  = "INSERT INTO adminuser (userID, position)";
          $query .= "VALUES({$user_id}, '{$admin_position}') ";
          $query .= "ON DUPLICATE KEY UPDATE position = '{$admin_position}';";
            
            confirmQuery($create_item_query);
//            echo $query;
        } else {
            $query = "DELETE FROM adminuser WHERE userID = '{$user_id}'";
       }
          $add_admin = mysqli_query($connection, $query);  
       

      $the_post_id = mysqli_insert_id($connection);
       
      $_POST=array(); 
       
       header( "Location: users.php" );


   }

//   if(isset($_POST['edit_user'])){
//            $user_name         = escape($_POST['user_name']);
////            $item_user         = escape($_POST['post_user']);
//            $password  = escape($_POST['password']);
//            $user_firstname= escape($_POST['user_firstname']);
//            $user_lastname         = escape($_POST['user_lastname']);
//            $admin  = escape($_POST['admin']); 
//
//       
////        move_uploaded_file($post_image_temp, "../images/$post_image" );
//       
//
//      $query = "INSERT INTO `user`(`user_name`,`password`,`first_name`, `last_name`) ";
//             
//      $query .= "VALUES('{$user_name}','{$password}','{$user_firstname}','{$user_lastname}') "; 
//             
//      $create_item_query = mysqli_query($connection, $query);  
//      confirmQuery($create_item_query);
//             
//       
//       if($_POST['admin'] == 'admin'){
//          $query = "SELECT * FROM user WHERE `user_name` = '{$user_name}' "; 
//
//          $select_users = mysqli_query($connection, $query);  
//          $row = mysqli_fetch_assoc($select_users);
//          $user_id = $row['userID'];
//          $admin_position = $_POST['position'];
//            $query = "INSERT INTO `adminuser` (`userID`, `position`) VALUES ('{$user_id}','{$admin_position}')";
//        }
//            confirmQuery($create_item_query); 
//          $add_admin = mysqli_query($connection, $query); 
//       
//
//      $the_post_id = mysqli_insert_id($connection);
//       
//      $_POST=array(); 
//    header("Location: " . $_SERVER['REQUEST_URI']);
//       
//
//
//   }

?>

    <!--    <form action="" method="post" enctype="multipart/form-data">    -->
    <form action="" method="post">

        <div class="form-group">
            <label for="user_name">User Name</label>
            <input type="text" class="form-control" name="user_name" id="user_name" value= "<?php echo $user_name?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="user_name" value= "<?php echo $password?>">
        </div>
        <div class="form-group">
            <label for="user_firstname">First Name</label>
            <input type="text" class="form-control" name="user_firstname" id="user_firstname" value= "<?php echo $first_name?>">
        </div>

        <div class="form-group">
            <label for="user_lastname">Last Name</label>
            <input type="text" class="form-control" name="user_lastname" id="user_lastname" value= "<?php echo $last_name?>">
        </div>

<!--
        <div class="form-group">
            <label for="admin">Administrator</label>
            <input type="checkbox" name="admin" value="admin" onclick="dynInput(this);"  <?php echo $get_position?'checked':'' ?>/>
            <p id="insertinputs"></p>
        </div>
-->
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="edit_user" value="Update Profile">
        </div>


    </form>

            
    
            

            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>

     
        <!-- /#page-wrapper -->
        
    <?php include "includes/admin_footer.php" ?>
