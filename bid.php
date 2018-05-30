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

if(isset($_SESSION['bid_error'])){
    $_SESSION['bid_error'] = array();
}

if(isset($_SESSION['get_it_now_error'])){
    $_SESSION['get_it_now_error'] = array();
}
// item info from database
$query = "SELECT * FROM Items WHERE itemID ={$item_id}";
$select_items_by_id = mysqli_query($connection, $query);  
while($row = mysqli_fetch_assoc($select_items_by_id)){
    
    $item_id = $row['itemID'];
    $item_name = $row['name'];
    $item_category = $row['categoryID'];
    $item_condition    = $row['condition'];
    $item_description = $row['description'];
    $item_min_sale_price = $row['min_sale_price'];
    $item_get_it_now_price = $row['get_it_now_price'];
    $item_return_accepted = $row['return_accepted'];
    $item_start_bidding_price = $row['start_bidding'];
    $item_end_date     = $row['end_time'];
    
}
  
if (isset($_POST['bid'])){

    // reload item info from database
    $query = "SELECT * FROM Items WHERE itemID ={$item_id}";
    $select_items_by_id = mysqli_query($connection, $query);  
    while($row = mysqli_fetch_assoc($select_items_by_id)){
        
        $item_end_date     = $row['end_time'];
        $item_buy_availability = $row['buy_availability'];

    }
    
    // reload item bid info
    $bid_query = "SELECT MAX(bid_amount) FROM Bid WHERE itemID  = {$item_id}";
    $all_bids_query = mysqli_query($connection, $bid_query);

    while($row = mysqli_fetch_assoc($all_bids_query)){
        $my_minimum_bid = max($item_start_bidding_price + 1, $row['MAX(bid_amount)']);
    }
    
    $bid_amount = $_POST['bid_amount'];
    $cur_time = mysqli_fetch_row(mysqli_query($connection,"SELECT NOW()"));
    $cur_time = (date("c", strtotime($cur_time[0])));
    
    $bid_error = [
      'bid_amount' => '',
      'bid_date' => '',
      'bidable' => '',
      'bid_get_it_now' => ''
    ];

      if ($bid_amount < $my_minimum_bid + 1) {

          $bid_error['bid_amount'] = 'Please bid with a higher price';
      }

      if ($cur_time > $item_end_date) {

          $bid_error['bid_date'] = 'Sorry, bidding is closed!';
      }

      if ($item_buy_availability == 0) {
          $bid_error['bidable'] = 'Sorry, bidding is closed!';
      }
    
      if ($bid_amount >= $item_get_it_now_price && $item_get_it_now_price >= $item_min_sale_price) {
          $bid_error['bid_get_it_now)'] = 'You can use GET IT NOW!';
      }
      

      foreach ($bid_error as $key => $value) {
          if (empty($value)) {
              unset($bid_error[$key]);
          }
      }
    

    if (empty($bid_error)) {
        $query = "INSERT INTO `Bid`(`itemID`,`userID`, `bid_amount`,`bid_date`) ";
        $query .= "VALUES('{$item_id}','{$_SESSION['userID']}','{$bid_amount}','{$cur_time}')" ; 
        $create_bid_query = mysqli_query($connection, $query);  
        confirmQuery($create_bid_query);

        $the_post_id = mysqli_insert_id($connection);
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } else {
        $_SESSION['bid_error'] = $bid_error;
    }
    
}


if (isset($_POST['get_it_now'])) {
    
    
    
    $get_it_now_error = [
        'buyable' => '',
        'buy_date' => '',
        'sale_price' => ''
    ];
    
    // reload item info from database
    $query = "SELECT * FROM items WHERE itemID ={$item_id}";
    $select_items_by_id = mysqli_query($connection, $query);  
    while($row = mysqli_fetch_assoc($select_items_by_id)){
        
        $item_get_it_now_price = $row['get_it_now_price'];
        $item_end_date     = $row['end_time'];
        $item_buy_availability = $row['buy_availability'];
        $item_min_sale_price = $row['min_sale_price'];

    }
    
    $cur_time = mysqli_fetch_row(mysqli_query($connection,"SELECT NOW()"));
    $cur_time = (date("c", strtotime($cur_time[0])));
    
    if ($cur_time > $item_end_date) {
        $get_it_now_error['buy_date'] = 'Sorry, sale is ended!';
      }

    if ($item_buy_availability == 0) {
        $get_it_now_error['buyable'] = 'Sorry, sale is ended!';
    }
    
    if ($item_get_it_now_price < $item_min_sale_price) {
        $get_it_now_error['sale_price'] = 'Sorry, you cannot get it at a price lower than the min sale price';
    }
    
    foreach ($get_it_now_error as $key => $value) {
          if (empty($value)) {
              unset($get_it_now_error[$key]);
          }
    }
    
    if (empty($get_it_now_error)) {
        $query = "INSERT INTO `Transaction`(`itemID`,`userID`, `type`,`price`) ";
        $query .= "VALUES('{$item_id}','{$_SESSION['userID']}', 'Get It Now','{$item_get_it_now_price}')" ; 
        $get_it_now_query = mysqli_query($connection, $query); 
        if (!$get_it_now_query) {
         die("INSERT FAILED" . mysqli_error($connection));
        }
        confirmQuery($get_it_now_query);

        $the_post_id = mysqli_insert_id($connection);
        
        $query = "UPDATE `Items` SET buy_availability = '0' WHERE itemID = {$item_id}";
        $sale_query = mysqli_query($connection, $query); 
        if (!$sale_query) {
         die("INSERT FAILED" . mysqli_error($connection));
        }
        header("Location: " . $_SERVER['REQUEST_URI']);
        exit();
    } else {
        $_SESSION['get_it_now_error'] = $get_it_now_error;
    }
}


?>
    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                <h1 class="page-header">
                    GTBay Item for Sale
                </h1>
                
                <!-- item details table-->
                <table class="table table-bordered table-hover" style="width:100%">

                    <?php 
                    
                    $query = "SELECT userID FROM Soldby WHERE itemID = $item_id";
                    $select_user_id = mysqli_query($connection, $query); 
                    

                    $query = "SELECT * FROM Category WHERE categoryID = '{$item_category}'";
                    $select_categories = mysqli_query($connection,$query);
                    $row = mysqli_fetch_assoc($select_categories);
                    $category_name = $row['category_name'];
                    
                    if ($item_return_accepted == 1) {
                        $return = "Yes";
                    } else {
                        $return = "No";
                    }
                    
                       echo "
                      <tr>
                        <th>Item ID:</th>
                        <td>$item_id \t(<a href='ratings.php?i_id={$item_id}'> view ratings</a>)</td>
                      </tr>
                      <tr>
                        <th>Item Name:</th>
                        <td>$item_name</td>
                      </tr>
                      <tr>
                        <th>Description:</th>
                        <td>$item_description \t";
                           if (mysqli_fetch_assoc($select_user_id)['userID'] == $_SESSION['userID']){
                               echo"(<a href='change_description.php?i_id=$item_id'>Change Description</a>)";
                           };
                           
                           echo"</td>
                      </tr>
                      <tr>
                        <th>Category:</th>
                        
                        
                        <td>$category_name</td>
                      </tr>
                      <tr>
                        <th>Condition:</th>
                        <td>$item_condition</td>
                      </tr>
                      <tr>
                        <th>Return Accepted:</th>
                        <td>$return</td>
                      </tr>
                      <tr>
                        <th>";
                    ?>
                    
                
                <?php if($item_get_it_now_price >= $item_min_sale_price) : ?>
                   
                        <form action="" method="post">

                        <span class="input-group-btn">


                           <button name = "get_it_now" class="btn btn-default" type="submit">
                                  <span class="glyphicon glyphicon-blackboard"> GET IT NOW </span>
                           </button>



                        </span>
                        
                        <?php
                               if (isset($_SESSION['get_it_now_error'])) {
                                    foreach ($_SESSION['get_it_now_error'] as $message) {
                                        echo $message;
                                        echo "<br>";
                                    }
                                }
                        ?>

                        </form>
                    
                <?php endif; ?>
                
                    
                    <?php
                      echo"</th>
                        <td>$item_get_it_now_price </td>
                      </tr>
                      <tr>
                        <th>Auction Ends at:</th>
                        <td>$item_end_date</td>
                      </tr>
                      <tr>
                        <th>Condition:</th>
                        <td>$item_condition</td>
                      </tr>"; 
                    ?>
                </table>
                
                <!-- bid details table-->
                <table class="table table-bordered table-hover" style="width:100%">
                    <thead>
                       <h3>Lastest Bid</h3>
                        <tr>
                            <th>Amount</th>
                            <th>Bid Time</th>
                            <th>Bidder</th>
                        </tr>
                    </thead>
                    <tbody>

                    <?php
                    $query = "SELECT * FROM Bid WHERE itemID  = {$item_id} ORDER BY bid_amount DESC LIMIT 4";
                    $select_all_bids_query = mysqli_query($connection, $query);
                    $minimum_bid = $item_start_bidding_price + 1;
                    while($row = mysqli_fetch_assoc($select_all_bids_query)){
                        $bidding_price = $row['bid_amount'];
                        $minimum_bid = max($minimum_bid, $bidding_price);
                        $time_of_bid = $row['bid_date'];
                        $userID = $row['userID'];
                        $get_name_query = "SELECT user_name FROM user WHERE userID = {$userID}";
                        $select_user_name_query = mysqli_query($connection, $get_name_query);
                        $user_name = mysqli_fetch_assoc($select_user_name_query)['user_name'];
                        echo"<tr>";
                        echo"<td>$bidding_price</td>";
                        echo"<td>$time_of_bid</td>";
                        echo"<td>$user_name</td>";
                        echo"<tr>";
            
                    }

                    ?>
                                 
                    </tbody>
                </table>
                
                <form action="" method="post">
                <label for="bid">Place Your bid here (Minimum bid is <?php echo $minimum_bid + 1?>) $</label>
                <span class="input-group-btn">
                <input name="bid_amount" type="number" step="1" class="form-control" value = "<?php echo $minimum_bid + 1?>" required>
                   
                   <button name = "bid" class="btn btn-default" type="submit">
                          <span class="glyphicon glyphicon-blackboard"> Bid </span>
                   </button>
                   
                   <button formaction="./search.php" name = "back-to-search" class="btn btn-default" type="submit">
                          <span class="glyphicon glyphicon-blackboard"> Back </span>
                </button>
                </span>
                </form>
                
                <?php
                    if (isset($_SESSION['bid_error'])) {
                        foreach ($_SESSION['bid_error'] as $message) {
                            echo $message;
                            echo "<br>";
                        }
                    }
                    
                ?>
                
            </div>
        </div>
        <!-- /.row -->

        <hr>

        <?php include "includes/footer.php"; ?>
    </div>
