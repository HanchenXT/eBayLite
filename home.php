<?php 
include "./admin/includes/functions.php";
include "includes/db.php";
include "includes/header.php";
?>

<!-- Navigation -->
<?php include "includes/navigation.php"; ?>
<?php
if  (!isset($_SESSION['username'])){
    redirect('login_page.php');
} 
?>
<!-- Page Content -->
<div class="container">

    <div class="row">

        <!-- Blog Entries Column -->
        <div class="col-md-8">
            <h1 class="page-header">
                My Item Status Summary
            </h1>
            
                <table class = "table table-bordered table-hover">
                   
                    <?php
                    $query = "SELECT Items.itemID, name, min_sale_price, get_it_now_price, buy_availability, end_time FROM User, SoldBy, Items WHERE SoldBy.userID = {$_SESSION['userID']} AND User.userID = {$_SESSION['userID']} AND Items.itemID = SoldBy.itemID";
                    
                    $myItem_query = mysqli_query($connection, $query);

                    if(!$myItem_query){
                        die("QUERY FAILED" . mysqli_error($connection));
                    }

                    $count = mysqli_num_rows($myItem_query);

                    if($count == 0){
                            echo "<h2>Your haven't list any item for sale</h2>";
                    } else {
                    ?>
                          <table class = "table table-bordered table-hover">
                            
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Min Sale Price</th>
                                    <th>Get It Now Price</th>
                                    <th>Current Bid</th>
                                    <th>Highest Bidder</th>
                                    <th>Sold Successful?</th>
                                    <th>Auction End Date</th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                   <?php
                                    foreach($myItem_query as $row){
                                        
                                        $item_ID = $row['itemID'];
                                        $min_sale = $row['min_sale_price'];

                                        $item_name = $row['name'];

                                        $query = "SELECT userID, MAX(bid_amount) FROM bid WHERE itemID = $item_ID";
                                        $get_bid = mysqli_fetch_assoc(mysqli_query($connection, $query));
                                        if(!$get_bid){
                                            die("QUERY FAILED" . mysqli_error($connection));
                                        }


                                        $query = "SELECT start_bidding from items where itemID = $item_ID";
                                        $get_start_bid = mysqli_fetch_assoc(mysqli_query($connection, $query))['start_bidding'];
                                        $item_current_bid = $get_bid['MAX(bid_amount)'] == null? $get_start_bid: $get_bid['MAX(bid_amount)'];
                                        $item_high_bidder = highest_bidder($get_bid['userID']);
                                        $item_get_it_now_price = $row['get_it_now_price'];
                                        $item_end_time = $row['end_time'];
                                        $buy_availability = $row['buy_availability'];
                                        

                                    echo"<tr>";
                                    echo"<td>$item_name</td>";
                                    echo"<td>$min_sale</td>";
                                    echo"<td>$item_get_it_now_price</td>";
                                        
                                    if ($get_start_bid === $item_current_bid) {
                                        echo"<td>No Bid</td>";
                                        echo"<td>No Bid</td>";
                                    } else {
                                        echo"<td>$item_current_bid</td>";
                                        echo"<td>$item_high_bidder</td>";
                                    }
                                        
                                    $s_query = "SELECT * FROM Transaction as t WHERE t.itemID = $item_ID";
                                    $select_sold = mysqli_query($connection, $s_query);

                                    if ($row = mysqli_fetch_assoc($select_sold)){

                                        $sold = true;

                                    } else {
                                        $sold = false;
                                    }
                                    
                                    if ($buy_availability == 0 && $sold) {
                                            echo"<td>Yes</td>";
                                        } else {
                                            echo"<td>No</td>";
                                    }
                                    
                                    echo"<td>$item_end_time</td>";
                                    echo"<tr>";
                                    }
                                    ?>
                                </tbody>
                                
                            </table>

                     <?php 
                     }            
                     ?>

                </table>

        </div>

    </div>

    <hr>

    <?php include "includes/footer.php"; ?>
</div>