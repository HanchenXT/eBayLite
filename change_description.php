<?php 
include "./admin/includes/functions.php";
include "includes/db.php";
include "includes/header.php";
?>
<?php include "includes/navigation.php"; ?>

   <?php
if(isset($_GET['i_id'])){
    $item_id = $_GET['i_id'];
} else {
    header("Location: home.php");
}
$query = "SELECT * FROM items WHERE itemID ={$item_id}";
$select_items_by_id = mysqli_query($connection, $query);
                                    
while($row = mysqli_fetch_assoc($select_items_by_id)){
//    $get_category_name_query = "SELECT category_name FROM category WHERE categoryID = {$row['categoryID']} ";
//    $get_category_name = mysqli_fetch_assoc(mysqli_query($connection, $get_category_name_query));
    
//    $item_id = $row['itemID'];
    $item_name = $row['name'];
    $item_category = $row['categoryID'];//implode("|",$get_category_name);
    $item_condition    = $row['condition'];
    $item_description = $row['description'];
    $item_min_sale_price = $row['min_sale_price'];
    $item_get_it_now_price = $row['get_it_now_price'];
    $item_return_accepted = $row['return_accepted'];
    $item_start_bidding_price = $row['start_bidding'];
    $item_end_date     = $row['end_time'];
    
}?>
<?php

   if(isset($_POST['submit'])){
       
            $item_description  = escape($_POST['item_description']);
       

      $query = "UPDATE items `items` SET `description` = '{$item_description}'; ";
             
      $create_item_query = mysqli_query($connection, $query);  
      confirmQuery($create_item_query);
      $_POST=array(); 
//    header("Location: " . $_SERVER['REQUEST_URI']);
       header("LOCATION: bid.php?i_id=$item_id ");
    exit();
       


   }

?>

    <!--    <form action="" method="post" enctype="multipart/form-data">    -->
    <div class = "container">
    <form action="" method="post">

        <table class="table table-bordered table-hover" style="width:100%">

            <tr>
                <th>Name:</th>
                <td><?php echo $item_name;?></td>
            </tr>
            <tr>
                <th>Category:</th>
                <td><?php echo $item_category;?></td>
            </tr>
            <tr>
                <th>Item Description:</th>
                <td><textarea class="form-control " name="item_description" id="item_description" cols="10" rows="3"  ><?php echo $item_description ?> </textarea></td>
            </tr>
            <tr>
                <th>Start Bidding Price:</th>
                <td>$<?php echo $item_start_bidding_price;?></td>
            </tr>
            <tr>
                <th>Min Sale Price:</th>
                <td>$<?php echo $item_min_sale_price;?></td>
            </tr>
            <tr>
                <th>Get It Now Price:</th>
                <td>$<?php echo $item_get_it_now_price;?></td>
            </tr>
            <tr>
                <th>Condition:</th>
                <td><?php echo $item_condition;?></td>
            </tr>
            <tr>
                <th>Accept Return:</th>
                <td><input id="item_return_accepted" name="return" type="checkbox"  onclick="return false;" <?php if ($item_return_accepted == 1) {echo "checked";} else {echo "";}?> readonly="readonly"></td>
            </tr>
            <tr>
                <th>Bidding End :</th>
                <td>
                <?php echo $item_end_date?>
            </td>
            </tr>;



        </table>





        <p class="marquee">
            <span id="dtText"></span>
        </p>


        <?php
        $previous = "javascript:history.go(-1)";
if(isset($_SERVER['HTTP_REFERER'])) {
    $previous = $_SERVER['HTTP_REFERER'];
}
        ?>

        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="Submit">
            <a class="btn btn-primary" href="bid.php?i_id=<?php echo $item_id?>">Back</a>
        </div>


    </form>
    <?php include "includes/footer.php"; ?>
</div>