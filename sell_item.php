<?php 
include "./admin/includes/functions.php";
include "includes/db.php";
include "includes/header.php";
include "includes/navigation.php";
?>

<?php

if(isset($_POST['submit'])){

    $item_name         = escape($_POST['name']);
    $item_description  = escape($_POST['item_description']);
    $item_min_sale_price = escape($_POST['min_sale_price']);
    $item_get_it_now_price = escape($_POST['get_it_now_price']);
    $buy_availability  = 1;
    $item_category_id  = escape($_POST['item_category']);
    $item_condition    = escape($_POST['item_condition']);
    $item_start_bidding_price = escape($_POST['start_bidding_price']);
    $item_return_accepted = isset($_POST['return']);
    
    $list_error = [
      'item_min_sale_price' => '',
      'item_get_it_now_price' => ''
    ];

    if ($item_get_it_now_price <= $item_min_sale_price) {

        $list_error['item_get_it_now_price'] = 'You may want to select a higher Get It Now price!';
    }

    if ($item_min_sale_price <= $item_start_bidding_price) {

        $list_error['item_min_sale_price'] = 'You may consider either a lower Start Bidding Price or higher Min Sale Price !';
    }

    foreach ($list_error as $key => $value) {
        if (empty($value)) {
             unset($list_error[$key]);
        }
    }

    $cur_time = mysqli_fetch_row(mysqli_query($connection,"SELECT NOW()"));
    $item_end_date = escape(date("c", strtotime($cur_time[0]. ' + '.$_POST['days'].' days')));
    
    if (empty($register_error)) {
        
        $query = "INSERT INTO `items`(`name`,`description`,`min_sale_price`, `get_it_now_price`,`buy_availability`,`categoryID`,`condition`,`start_bidding`,`return_accepted`,`end_time`) ";

        $query .= "VALUES('{$item_name}','{$item_description}','{$item_min_sale_price}','{$item_get_it_now_price}','{$buy_availability}','{$item_category_id}', '{$item_condition}', '{$item_start_bidding_price}', b'{$item_return_accepted}', '{$item_end_date}') "; 

        $create_item_query = mysqli_query($connection, $query);  
        confirmQuery($create_item_query);

        $the_post_id = mysqli_insert_id($connection);

        $query = "INSERT INTO `soldby` (`itemID`, `userID`) VALUES ('$the_post_id', '{$_SESSION['userID']}');";
        $create_item_sell_query = mysqli_query($connection, $query);
        if (!$create_item_sell_query) {
         die("INSERT FAILED" . mysqli_error($connection));
        }
        confirmQuery($create_item_query);  
        $_POST=array();
?>
      <div class = "container">
          <h3>
              <?php
                echo "<p class='bg-success'> Your item is on sale! </p>";
                echo "<a href='home.php'>View my item list </a>";
              ?>
          </h3>
      </div>
<?php        
        exit();
        
    } else {
        
        $_SESSION['list_error'] = $list_error;
        header("Location: " . $_SERVER['REQUEST_URI']);
    }

}

?>

<div class = "container">
    <form action="" method="post">
        <h3>Item Search</h3>
        <h10>Fields marked with * are required</h10>

        <table class="table table-bordered table-hover" style="width:100%">

            <tr>
                <th>*Name:</th>
                <td><input type="text" class="form-control" name="name" id="title" required> </td>
            </tr>
            <tr>
                <th>*Category:</th>
                <td><select name="item_category" id="category" required>
           
            <?php

            $query = "SELECT * FROM category";
            $select_categories = mysqli_query($connection,$query);

            confirmQuery($select_categories);


            while($row = mysqli_fetch_assoc($select_categories )) {
            $cat_id = $row['categoryID'];
                echo "{$cat_id}";
            $cat_title = $row['category_name'];

                echo "<option value='$cat_id'>{$cat_title}</option>";

                $_POST=array(); 

            }

            ?>
           
               </select></td>
            </tr>
            <tr>
                <th>*Item Description:</th>
                <td><textarea class="form-control " name="item_description" id="item_description" cols="10" rows="3" required></textarea></td>
            </tr>
            
            <tr>
                <th>*Start Bidding Price:</th>
                <td>$<input value="<?php echo $item_start_bidding_price; ?>" id="item_start_bidding_price" type="number" placeholder="0.00" name="start_bidding_price" min="0" value="" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" required></td>
            </tr>
            
            <tr>
                <th>*Min Sale Price:</th>
                <td>$<input id="item_min_sale_price" type="number" placeholder="0.00" name="min_sale_price" min="0" value="" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$" required></td>
            </tr>
            
            <tr>
                <th>Get It Now Price:</th>
                <td>$<input id="item_get_it_now_price" type="number" placeholder="0.00" name="get_it_now_price" min="0.00" value="" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$"></td>
            </tr>
            
            <tr>
                <th>*Condition:</th>
                <td>
                <select name="item_condition" id="item_condition" required>
           
                <?php
                $table = 'items';
                $field = 'condition';
                $query = "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" ;
                $select_conditions = mysqli_query($connection,$query);

                confirmQuery($select_conditions);

                 while ($row = mysqli_fetch_row($select_conditions)) {
                    foreach(explode("','",substr($row[1],6,-2)) as $option) {
                        print("<option value='$option'>{$option}</option>");
                    }
                }
                ?>

                </select></td>
            </tr>
            
            <tr>
                <th>Accept Return:</th>
                <td><input id="item_return_accepted" name="return" type="checkbox"></td>
            </tr>
            
            <tr>
                <th>*Bidding End in (days):</th>
                <td><select name="days" id="end_date">
                    <option value=1>1</option>
                    <option value=3>3</option>
                    <option value=5>5</option>
                    <option value=7>7</option>
                </select>
            </td>
            </tr>
            
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
            <input class="btn btn-primary" type="submit" name="submit" value="List Item">
            <a class="btn btn-primary" href="home.php">Cancel</a>
        </div>
        
        <?php
        if (isset($_SESSION['list_error'])) {
            foreach ($_SESSION['list_error'] as $message) {
            echo $message;
            echo "<br>";
            }
        }
        ?>

    </form>
    <hr>
    <?php include "includes/footer.php"; ?>
</div>