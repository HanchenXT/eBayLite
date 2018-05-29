<?php 
include "./admin/includes/functions.php";
include "includes/header.php";
include "includes/db.php";
include "includes/navigation.php";
?>

<?php
if(isset($_GET['i_id'])){
    $item_id = $_GET['i_id'];
}

if (isset($_SESSION['rate_error'])) {
    $_SESSION['rate_error'] = array();
}

// display comments and ratings
$query = "SELECT * FROM comments WHERE itemID ={$item_id} order by comment_date DESC";
$get_item_name_query = "SELECT name FROM items WHERE itemID = {$item_id}";
$select_item_name_query = mysqli_query($connection, $get_item_name_query);
$item_name = mysqli_fetch_assoc($select_item_name_query)['name'];
$select_comments = mysqli_query($connection, $query);  
$sum_rattings = 0;
$num_rows = mysqli_num_rows($select_comments);

while($row = mysqli_fetch_assoc($select_comments)){
    
    $user_id = $row['userID'];
    $get_user_name_query = "SELECT user_name FROM user WHERE userID = {$user_id}";
    $select_user_name_query = mysqli_query($connection, $get_user_name_query);
    $user_name = mysqli_fetch_assoc($select_user_name_query)['user_name'];
    $comment_date = $row['comment_date'];
    $content    = $row['content'];
    $rate = $row['rate'];
    $sum_rattings =$sum_rattings + $rate;
    
}

// display avg_rate
if($num_rows == 0) $avg_rating = "No rating so far.";
else $avg_rating = $sum_rattings/$num_rows;

// if current user has commented?
$comment_query = "SELECT * FROM Comments WHERE itemID = {$item_id} AND userID = {$_SESSION['userID']}";
$my_comment_query = mysqli_query($connection, $comment_query);
if(!$my_comment_query){
    die("QUERY FAILED".mysqli_error($connection));
}
$row = mysqli_fetch_array($my_comment_query);

$rate_error = ['rate_again' => ''];

  if ($row['rate']) {
      
      $rate_error['rate_again'] = 'Please delete your comment before adding a new one!';
  } else {
      unset($rate_error['rate_again']);
  }

// add comments and ratings
if(isset($_POST['submit_comment'])) {
    
    if (empty($rate_error)) {
        $user_id = $_SESSION['userID'];
    $rate = $_POST['rate'];
    $comment = $_POST['comment'];
    $cur_time = mysqli_fetch_row(mysqli_query($connection,"SELECT NOW()"));
    $query = "INSERT INTO `comments`(`userID`,`itemID`, `comment_date`,`content`,`rate`)";
    $comment_time = (date("c", strtotime($cur_time[0])));
    $query .= "VALUES('{$user_id}','{$item_id}','{$comment_time}','{$comment}','{$rate}')"; 
    $create_item_query = mysqli_query($connection, $query);  
    confirmQuery($create_item_query);

    $the_post_id = mysqli_insert_id($connection);
    header("Location: ratings.php?i_id={$item_id}");
    } else {
         $_SESSION['rate_error'] = $rate_error;
    }   
}

if(isset($_GET['delete'])){
    deleteComment($_GET['delete']);
    header("Location: ratings.php?i_id={$item_id}"); 
}

?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    Item
                </h1>

                <table class="table table-bordered table-hover" style="width:100%">

                    <?php 
                       echo "
                      <tr>
                        <th>Item ID:</th>
                        <td>$item_id </td>
                      </tr>
                      <tr>
                        <th>Item Name:</th>
                        <td>$item_name</td>
                      </tr>
                      <tr>
                        <th>Average Rating:</th>
                        <td>$avg_rating</td>
                      </tr>";
                        
                    
                    ?>


                </table>
                <thead>
                    <h4>Latest comments</h4>
                </thead>

                <?php
$query = "SELECT * FROM comments WHERE itemID ={$item_id} order by comment_date DESC";
$select_comments = mysqli_query($connection, $query);  
while($row = mysqli_fetch_assoc($select_comments)){
    $comment_id = $row['commentID'];
    $user_id = $row['userID'];
    $get_user_name_query = "SELECT user_name FROM user WHERE userID = {$user_id}";
        $select_user_name_query = mysqli_query($connection, $get_user_name_query);
        $user_name = mysqli_fetch_assoc($select_user_name_query)['user_name'];
    $comment_date = $row['comment_date'];//implode("|",$get_category_name);
    $content    = $row['content'];
    $rate = $row['rate'];
   ?>

                    <table class="table table-bordered table-hover" style="width:100%">
                        <tr>
                            <td><label for="">Rated By:</label>
                                <?php echo $user_name ?>
                            </td>
                            <td><label for="">Date:</label>
                                <?php echo date("F j, Y, g:i a",strtotime($comment_date)) ?>
                            </td>
                            <td><label for="">Rate:</label>
                                <?php echo $rate ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="3">
                                <?php echo $content?>
                            </td>
                        </tr>
                        <?php 
                        if($user_id == $_SESSION['userID']){
                               echo" <a href='ratings.php?i_id={$item_id}&delete={$comment_id}'> Delete </a>";
                            
                        }

                        
                        ?>
                    </table>



                    <?php
}
?>
                    <form action="" method="post">

                        <div class="form-group">
                            <div class="col-xs-10">
                                <div class="col-xs-5 vcenter">
                                    <h4 for="comment">Comment</h4>
                                </div>
                                <div class="col-xs-5 vcenter">
                                    <select name="rate" required>
                                        <option value=""> rate </option>
                                        <option value="5">5</option>
                                        <option value="4">4</option>
                                        <option value="3">3</option>
                                        <option value="2">2</option>
                                        <option value="1">1</option>
                                        </select>
                                </div>
                            </div>
                            <textarea class="form-control " name="comment" id="comment" cols="10" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <span class="pull-right">
                            <input class="btn btn-primary" type="submit" name="submit_comment" value="Comment">
                            </span>
                        </div>
                        
                        <hr>
                        <?php
                            if (isset($_SESSION['rate_error'])) {
                                foreach ($_SESSION['rate_error'] as $message) {
                                    echo $message;
                                }
                            }
                        ?>
                        
                    </form>

            </div>


            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"          ?>

        </div>
        <!-- /.row -->

        <hr>

        <?php include "includes/footer.php"; ?>
    </div>
