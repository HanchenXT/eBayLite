<script type="text/javascript">
    // reference https://stackoverflow.com/questions/25870898/input-field-appear-after-selecting-a-check-box-html
    function dynInput(cbox) {
        if (cbox.checked) {
            var input = document.createElement("input");
            input.type = "text";
            input.name = "position";
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

   if(isset($_POST['submit'])){
            $user_name         = escape($_POST['user_name']);
//            $item_user         = escape($_POST['post_user']);
            $password  = escape($_POST['password']);
            $user_firstname= escape($_POST['user_firstname']);
            $user_lastname         = escape($_POST['user_lastname']);
            $admin  = escape($_POST['admin']); 

       
//        move_uploaded_file($post_image_temp, "../images/$post_image" );
       

      $query = "INSERT INTO `user`(`user_name`,`password`,`first_name`, `last_name`) ";
             
      $query .= "VALUES('{$user_name}','{$password}','{$user_firstname}','{$user_lastname}') "; 
             
      $create_item_query = mysqli_query($connection, $query);  
      confirmQuery($create_item_query);
             
       
       if($_POST['admin'] == 'admin'){
          $query = "SELECT * FROM user WHERE `user_name` = '{$user_name}' "; 

          $select_users = mysqli_query($connection, $query);  
          $row = mysqli_fetch_assoc($select_users);
          $user_id = $row['userID'];
          $admin_position = $_POST['position'];
            $query = "INSERT INTO `adminuser` (`userID`, `position`) VALUES ('{$user_id}','{$admin_position}')";
            confirmQuery($create_item_query);
          $add_admin = mysqli_query($connection, $query);  
        }
       

      $the_post_id = mysqli_insert_id($connection);
       
      $_POST=array(); 
    header("Location: " . $_SERVER['REQUEST_URI']);
      echo "<p class='bg-success'>User Created. <a href='users.php'>View All Items </a></p>";
       


   }

?>

    <!--    <form action="" method="post" enctype="multipart/form-data">    -->
    <form action="" method="post">

        <div class="form-group">
            <label for="user_name">User Name</label>
            <input type="text" class="form-control" name="user_name" id="user_name">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="user_name">
        </div>
        <div class="form-group">
            <label for="user_firstname">First Name</label>
            <input type="text" class="form-control" name="user_firstname" id="user_firstname">
        </div>

        <div class="form-group">
            <label for="user_lastname">Last Name</label>
            <input type="text" class="form-control" name="user_lastname" id="user_lastname">
        </div>

        <div class="form-group">
            <label for="admin">Administrator</label>
            <input type="checkbox" name="admin" value="admin" onclick="dynInput(this);" />
            <p id="insertinputs"></p>
        </div>
        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="Create User">
        </div>


    </form>
