<script>
function myFunction() {
    var position;
    do{
        position = prompt("Position name");
        document.cookie = "position = " + position
    }while(position == null || position == "" ); 
    
       console.log(position);
//    document.getElementById("demo").innerHTML = txt;
}
</script>
   

   <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>ID</th>
            <th>User Name</th>
            <th>First Name</th>
            <th>Last Name</th>
        </tr>
    </thead>
    <tbody>

        <?php
$query = "SELECT * FROM user";
$select_users = mysqli_query($connection, $query);
    echo "Admin Users are highlighted.";
                                    
while($row = mysqli_fetch_assoc($select_users)){
    $user_id = $row['userID'];
    $user_name = $row['user_name'];
    $password = $row['password'];
    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $get_admin_query = "SELECT position FROM adminuser WHERE userID = {$row['userID']} ";
    $get_position = mysqli_fetch_assoc(mysqli_query($connection, $get_admin_query));
    echo"<tr".(($get_position['position'])? " class=\"bg-danger\">":">");
    echo"<td >$user_id</td>";
    echo"<td>$user_name</td>";
    echo"<td>$first_name</td>";
    echo"<td>$last_name</td>";
    echo"<td><a href='users.php?adminu_id={$user_id}' ".(($get_position['position'])? "> Change to Regular User":"onclick = 'myFunction()'>Change to Admin User") .  " </a></td>";
    
    

    
    echo"<td><a href='users.php?source=edit_user&edit_user={$user_id}'> Edit </a></td>";
    
    echo"<td><a href='users.php?delete={$user_id}'> Delete </a></td>";
    echo"</tr>";

}
?>

    </tbody>
</table>


<?php
if(isset($_GET['delete'])){
    echo $_GET['delete'];
    $the_user_id = $_GET['delete'];
    $query = "DELETE FROM adminuser WHERE userID = '{$the_user_id}'";
    $delete = mysqli_query($connection, $query);
    $the_user_id = $_GET['delete'];
    $query = "DELETE FROM user WHERE userID = '{$the_user_id}'";
    $delete = mysqli_query($connection, $query);
    header('Location: users.php'); 
}
    
if(isset($_GET['adminu_id'])){
    $user_id = $_GET['adminu_id'];
    $query = "SELECT userID FROM adminuser WHERE userID = 
    {$user_id};";
    $admin = mysqli_fetch_assoc(mysqli_query($connection, $query)); 
    echo  $admin;
    if($admin){
            
        $query = "DELETE FROM adminuser WHERE userID = '{$user_id}'";
        
    } else {
        $query = "INSERT INTO `adminuser` (`userID`, `position`) VALUES ('{$user_id}','{$_COOKIE['position']}')";
    }
          $add_admin = mysqli_query($connection, $query);  
    header('Location: users.php'); 
    
}


?>
