<?php
function get_enum_values( $table, $field )
{
    $type = $this->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
    preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
    $enum = explode("','", $matches[1]);
    return $enum;
}

function redirect($location){

    header("Location:" . $location);
    exit;

}


function ifItIsMethod($method=null){

    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){

        return true;

    }

    return false;

}

function deleteComment($GetDelete){
    global $connection;
    
    $the_comment_id = $GetDelete;
    $query = "DELETE FROM comments WHERE commentID = {$the_comment_id}";
    $delete = mysqli_query($connection, $query);
}


function isLoggedIn(){

    if(isset($_SESSION['username'])){

        return true;


    }


   return false;

}

function checkLogged($redirectLocation=null){

    if(isLoggedIn()){

        redirect($redirectLocation);

    }

}





function escape($string) {

global $connection;

return mysqli_real_escape_string($connection, trim($string));


}



function set_message($msg){

if(!$msg) {

$_SESSION['message']= $msg;

} else {

$msg = "";


    }


}


function display_message() {

    if(isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }


}




function users_online() {



    if(isset($_GET['onlineusers'])) {

    global $connection;

    if(!$connection) {

        session_start();

        include("../includes/db.php");

        $session = session_id();
        $time = time();
        $time_out_in_seconds = 05;
        $time_out = $time - $time_out_in_seconds;

        $query = "SELECT * FROM users_online WHERE session = '$session'";
        $send_query = mysqli_query($connection, $query);
        $count = mysqli_num_rows($send_query);

            if($count == NULL) {

            mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session','$time')");


            } else {

            mysqli_query($connection, "UPDATE users_online SET time = '$time' WHERE session = '$session'");


            }

        $users_online_query =  mysqli_query($connection, "SELECT * FROM users_online WHERE time > '$time_out'");
        echo $count_user = mysqli_num_rows($users_online_query);


    }






    } // get request isset()


}

users_online();




function confirmQuery($result) {
    
    global $connection;

    if(!$result ) {
          
          die("QUERY FAILED ." . mysqli_error($connection));
   
          
      }
    

}



function insert_categories(){
    
    global $connection;

        if(isset($_POST['submit'])){

            $cat_title = $_POST['cat_title'];

        if($cat_title == "" || empty($cat_title)) {
        
             echo "This Field should not be empty";
    
    } else {





    $stmt = mysqli_prepare($connection, "INSERT INTO categories(cat_title) VALUES(?) ");

    mysqli_stmt_bind_param($stmt, 's', $cat_title);

    mysqli_stmt_execute($stmt);


        if(!$stmt) {
        die('QUERY FAILED'. mysqli_error($connection));
        
                  }


        
             }

             
    mysqli_stmt_close($stmt);
   
        
       }

}


function findAllCategories() {
global $connection;

    $query = "SELECT * FROM categories";
    $select_categories = mysqli_query($connection,$query);  

    while($row = mysqli_fetch_assoc($select_categories)) {
    $cat_id = $row['cat_id'];
    $cat_title = $row['cat_title'];

    echo "<tr>";
        
    echo "<td>{$cat_id}</td>";
    echo "<td>{$cat_title}</td>";
   echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
   echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
    echo "</tr>";

    }


}


function deleteCategories(){
global $connection;

    if(isset($_GET['delete'])){
    $the_cat_id = $_GET['delete'];
    $query = "DELETE FROM categories WHERE cat_id = {$the_cat_id} ";
    $delete_query = mysqli_query($connection,$query);
    header("Location: categories.php");


    }
            


}


function UnApprove() {
global $connection;
if(isset($_GET['unapprove'])){
    
    $the_comment_id = $_GET['unapprove'];
    
    $query = "UPDATE comments SET comment_status = 'unapproved' WHERE comment_id = $the_comment_id ";
    $unapprove_comment_query = mysqli_query($connection, $query);
    header("Location: comments.php");
    
    
    }

    
    

}


function is_admin($username) {

    global $connection; 

    $query = "SELECT user_role FROM users WHERE username = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    $row = mysqli_fetch_array($result);


    if($row['user_role'] == 'admin'){

        return true;

    }else {


        return false;
    }

}


function get_username($userID){
    global $connection;

    $query = "SELECT user_name FROM User WHERE userID = '$userID'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);
    
    return mysqli_fetch_array($result)['user_name'];
}

function username_exists($username){

    global $connection;

    $query = "SELECT user_name FROM User WHERE user_name = '$username'";
    $result = mysqli_query($connection, $query);
    confirmQuery($result);

    if(mysqli_num_rows($result) > 0) {

        return true;

    } else {

        return false;

    }

}

function highest_bidder($userID){

     global $connection;
    
                        
    $query = "SELECT user_name FROM user WHERE userID =  $userID";

    $get_bidder =mysqli_query($connection, $query);
    if($get_bidder== null){
        $get_bidder_name = "<b>Be the first to bid!</b>";

    } else {
        $get_bidder_name = mysqli_fetch_assoc($get_bidder)['user_name'];

    }

    return $get_bidder_name;
}

function login_user($username, $password) {
    
    global $connection;
    
    $username = trim($username);
    $password = trim($password);
    $username = mysqli_real_escape_string($connection, $username);
    $password = mysqli_real_escape_string($connection, $password);
    
    $query = "SELECT * FROM User WHERE user_name = '{$username}'";
    $select_user_query = mysqli_query($connection, $query);
    if(!$select_user_query){
        die("QUERY FAILED".mysqli_error($connection));
    }

    while($row = mysqli_fetch_array($select_user_query)    ){
        $db_id = $row['userID'];
        $db_username = $row['user_name'];
        $db_password = $row['password'];
        $db_firstname = $row['first_name'];
        $db_lastname = $row['last_name'];

        $get_admin_query = "SELECT position FROM adminuser WHERE userID = {$row['userID']} ";
        $get_position = mysqli_fetch_assoc(mysqli_query($connection, $get_admin_query));
        $db_admin = ($get_position['position']);
    }

   if($username === $db_username && $password ===$db_password ){
        
        $_SESSION['userID'] = $db_id;
        $_SESSION['username'] = $db_username;
        $_SESSION['firstname'] = $db_firstname;
        $_SESSION['lastname'] = $db_lastname;
        $_SESSION['admin'] = $db_admin;
        
    header("Location: ". "admin");
    } else {
        $_SESSION['login_error'] = "Wrong username and/or password";        
    }
}

?>