

<?php
if (isset($_GET['edit_user'])){
    $the_user_id = $the_user_id = $_GET['edit_user'];
    
    $query = "SELECT * FROM user WHERE userID = $the_user_id";
$select_users = mysqli_query($connection, $query);
                                    
while($row = mysqli_fetch_assoc($select_users)){
    $user_id = $row['userID'];
    $user_name = $row['user_name'];
    $password = $row['password'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $get_admin_query = "SELECT position FROM adminuser WHERE userID = {$row['userID']} ";
     $get_position = mysqli_fetch_assoc(mysqli_query($connection, $get_admin_query));
    ?>
    
    <script type="text/javascript">
    // reference https://stackoverflow.com/questions/25870898/input-field-appear-after-selecting-a-check-box-html
    function dynInput(cbox) {
    var position = "<?php echo $get_position['position']; ?>";
        if (cbox.checked) {
            var input = document.createElement("input");
            input.type = "text";
            input.name = "position";
            input.value = position;
            var div = document.createElement("div");
            div.id = cbox.name;
            div.innerHTML = "<label>Position: </label> ";
            div.appendChild(input);
            document.getElementById("insertinputs").appendChild(div);
        } else {
            document.getElementById(cbox.name).remove();
        }
    }

</script>
<?php
//    echo"<tr".(($get_position['position'])? " class=\"bg-danger\">":">");
//    echo"<td >$user_id</td>";
//    echo"<td>$user_name</td>";
//    echo"<td>$first_name</td>";
//    echo"<td>$last_name</td>";
//    echo"<td><a href='users.php?adminu_id={$user_id}' ".(($get_position['position'])? "> Cancel Admin":"onclick = 'myFunction()'>Admin") .  " </a></td>";
//    
//    
//
//    
//    echo"<td><a href='users.php?source=edit_user&edit_user={$user_id}'> Edit </a></td>";
//    
//    echo"<td><a href='users.php?delete={$user_id}'> Delete </a></td>";
//    echo"</tr>";

}
    
    
    
    
}
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

        <div class="form-group">
            <label for="admin">Administrator</label>
            <input type="checkbox" name="admin" value="admin" onclick="dynInput(this);"  <?php echo $get_position?'checked':'' ?>/>
            <p id="insertinputs"></p>
        </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="edit_user" value="Edit User">
        </div>


    </form>
