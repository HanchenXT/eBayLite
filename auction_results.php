<?php 
include "./admin/includes/functions.php";
include "includes/header.php";
include "includes/db.php";
include "includes/navigation.php";
?>

<!-- Page Content -->
<div class="container">

        <!-- Subject -->
        <div class="col-md-8">
            <h1 class="page-header">
                My Item Status
            </h1>
        </div>
        
        <!-- Auction results table -->
        <table class = "table table-bordered table-hover">
        <thead>
            <tr>
                <th>ItemID</th>
                <th>Item</th>
                <th>Sale Price</th>
                <th>Winner</th>
<!--                <th>Type</th>-->
                <th>Auction Ended</th>
            </tr>
        </thead>
        <tbody>
        <?php
//            echo $_SESSION["username"];
            // auction ended pending!
            $query = "               
                SELECT i.itemID, name, price, userID, i.end_time FROM items i LEFT JOIN `transaction` t on t.itemID = i.itemID  WHERE EXISTS 
                
                (SELECT itemID FROM soldby 
                WHERE userID = {$_SESSION["userID"]} AND i.itemID = soldby.itemID  AND buy_availability = '0')
            ";
//            echo $query;
            $select_items = mysqli_query($connection, $query);
            while($row = mysqli_fetch_assoc($select_items)){
                
                $item_id = $row['itemID'];
                $item_name = $row['name'];
                $item_price = $row['price'];
                $item_winner = get_username($row['userID']);
                $item_end_time = $row['end_time'];
                echo"<tr>";
                echo"<td>$item_id</td>";
                echo"<td>$item_name</td>";
                echo"<td>$item_price</td>";
                echo"<td>$item_winner</td>";
                echo"<td>$item_end_time</td>";
//                echo"<td>$item_type</td>";
                // auction ended pending!
                echo"<tr>";

            }
        ?>            
        </tbody>
        </table>
        
        
        <h1 class="page-header">
                The item I win!
        </h1>
        <table class = "table table-bordered table-hover">
        <thead>
            <tr>
                <th>ItemID</th>
                <th>Item</th>
                <th>Sale Price</th>
                <th>method</th>
                <th>Auction Ended</th>
            </tr>
        </thead>
        <tbody>
        <?php

            $w_query = "SELECT * FROM Transaction as t, Items WHERE t.userID = {$_SESSION["userID"]} and t.itemID = Items.itemID ";
            $win = mysqli_query($connection, $w_query);
            
            while($row = mysqli_fetch_assoc($win)){
                
                $item_id = $row['itemID'];
                $item_name = $row['name'];
                $item_price = $row['price'];
                $item_method = $row['type'];
                $item_end_time = $row['end_time'];
                echo"<tr>";
                echo"<td>$item_id</td>";
                echo"<td>$item_name</td>";
                echo"<td>$item_price</td>";
                echo"<td>$item_method</td>";
                echo"<td>$item_end_time</td>";
                echo"<tr>";

            }
        ?>            
        </tbody>
        </table>
        
        <hr>
        <?php include "includes/footer.php"; ?>
        
</div>
