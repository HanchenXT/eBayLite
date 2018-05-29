<?php 
include "./admin/includes/functions.php";
include "includes/header.php";
include "includes/db.php";
?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>

<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">
                Item List
            </h1>
            
                
               <?php
            
                $all_condition = array(
                    "New" => 1,
                    "Very Good" => 2,
                    "Good" => 3,
                    "Fair" => 4,
                    "Poor" => 5
                );
                if(isset($_POST['submit'])){

                    $search = $_POST['search'];
                    $cat_id = $_POST['item_category'];
                    $price_from = $_POST['min_price'];
                    $price_to = $_POST['max_price'];
                    $condition = $_POST['item_condition'];
                    
                    
                    $query = "SELECT * FROM Items WHERE buy_availability ='1' AND (name LIKE '%$search%' OR description LIKE '%$search%')";
                    if ($cat_id != '') {
                        $query .= "AND categoryID = '$cat_id'";
                    }
                    if ($price_to != 0) {
                        
                        $current_bid_query = "SELECT itemID FROM Bid GROUP BY itemID HAVING MAX(bid_amount) BETWEEN $price_from and $price_to";
                        $current_bid = mysqli_query($connection, $current_bid_query);
                        if(!$current_bid_query){
                        die("QUERY FAILED" . mysqli_error($connection));
                        }
                        
                        $min_sale_query = "SELECT itemID FROM Items GROUP BY itemID HAVING MAX(min_sale_price) BETWEEN $price_from and $price_to";
                        $min_sale = mysqli_query($connection, $min_sale_query);
                        if(!$min_sale_query){
                        die("QUERY FAILED" . mysqli_error($connection));
                        }
                        
                        $query .= " AND (itemID IN (".$current_bid_query.") OR itemID IN (".$min_sale_query."))";
                    }
                    if ($condition != '') {
                        $query .= " AND `condition` <= $all_condition[$condition] ";
                    }
                    
                    $search_query = mysqli_query($connection, $query);

                    if(!$search_query){
                        die("QUERY FAILED" . mysqli_error($connection));
                    }

                    $count = mysqli_num_rows($search_query);

                    if($count == 0){
                            echo "<h1>NO RESULT</h1>";
                    } else {?>
                          <table class = "table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Item</th>
                            <th>Seller</th>
                            <th>Current Bid</th>
                            <th>Highest Bidder</th>
                            <th>Get It Now</th>
                            <th>Auction End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                           <?php
                            while($row = mysqli_fetch_assoc($search_query)){
                                $item_ID = $row['itemID'];
                                
                                
                                $query = "SELECT user_name from user, soldby where soldby.itemID = $item_ID AND soldby.userID = user.userID";
                        
                                $get_seller =mysqli_fetch_assoc(mysqli_query($connection, $query));


                                $item_seller = $get_seller['user_name'];
                                $item_name = $row['name'];
                                
                                
                                
                                
                                $query = "SELECT userID, MAX(bid_amount) cur_bid FROM bid WHERE itemID = $item_ID";
                                $get_bid = mysqli_fetch_assoc(mysqli_query($connection, $query));
                                
                                
                                $query = "SELECT start_bidding from items where itemID = $item_ID";
                                $get_start_bid = mysqli_fetch_assoc(mysqli_query($connection, $query))['start_bidding'];
                                
                       
                                
                                $item_current_bid = $get_bid['cur_bid'] == null? $get_start_bid: $get_bid['cur_bid'];
                                $item_high_bidder = highest_bidder($get_bid['userID']);
                                $item_get_it_now_price = $row['get_it_now_price'];
                                $item_end_time = $row['end_time'];

                            echo"<tr>";
                            echo"<td>$item_ID</td>";
                            echo"<td><a  href= 'bid.php?i_id={$item_ID}'>$item_name</a></td>";
                            echo"<td>$item_seller</td>";
                            echo"<td>$item_current_bid</td>";
                            echo"<td>$item_high_bidder</td>";
                            echo"<td>$item_get_it_now_price</td>";
                            echo"<td>$item_end_time</td>";
                            echo"<tr>";
                        } ?>
                        </tbody>
                    </table>
                        <?php
                        
                    }
                    
                }
                ?>

        </div>

        <!-- Blog Sidebar Widgets Column -->
        <?php include "includes/sidebar.php"          ?>

    </div>
    <!-- /.row -->

    <hr>

    <?php include "includes/footer.php"; ?>