


    <?php
if(isset($_GET['i_id'])){
    $item_id = $_GET['i_id'];
} else {
    header("Location: items.php");
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
    
}
    


   if(isset($_POST['submit'])){
            $item_name         = escape($_POST['name']);
//            $item_user         = escape($_POST['post_user']);
            $item_description  = escape($_POST['item_description']);
            $item_min_sale_price= escape($_POST['min_sale_price']);
            $item_get_it_now_price         = escape($_POST['get_it_now_price']);
            $buy_availability  = 1;
            $item_category_id  = escape($_POST['item_category']);
            $item_condition    = escape($_POST['item_condition']);
            $item_start_bidding_price = escape($_POST['start_bidding_price']);
            $item_return_accepted= isset($_POST['return']);
            $item_end_date     = escape($_POST['end_date']);
//            $item_end_hour         = escape(date('d-m-y'));

       
//        move_uploaded_file($post_image_temp, "../images/$post_image" );
       


        $query = "UPDATE items SET ";
        $query .= "`name` = '{$item_name}', ";
        $query .= "`description` = '{$item_description}', ";
        $query .= "`min_sale_price` = '{$item_min_sale_price}', ";
        $query .= "`get_it_now_price` = '{$item_get_it_now_price}', ";
        $query .= "`buy_availability` = '{$buy_availability}', ";
        $query .= "`categoryID` = '{$item_category_id}', ";
        $query .= "`condition` = '{$item_condition}', ";
        $query .= "`start_bidding` = '{$item_start_bidding_price}', ";
        $query .= "`return_accepted` = b'{$item_return_accepted}', ";
        $query .= "`end_time` = '{$item_end_date}' ";
        $query .= "where items.itemID = {$item_id }";
       
      $create_item_query = mysqli_query($connection, $query);  
      confirmQuery($create_item_query);

      $the_post_id = mysqli_insert_id($connection);
       
       header( "Location: items.php?source=edit_item_success" );


   }

?>

            <!--    <form action="" method="post" enctype="multipart/form-data">    -->
            <form action="" method="post">

                <div class="form-group">
                    <label for="title">Name</label>
                    <input value="<?php echo $item_name; ?>" type="text" class="form-control" name="name" id="title">
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <select name="item_category" id="category">
           
<?php
           
        $query = "SELECT * FROM category";
        $select_categories = mysqli_query($connection,$query);
        
        confirmQuery($select_categories);


        while($row = mysqli_fetch_assoc($select_categories )) {
        $cat_id = $row['categoryID'];
            echo "{$cat_id}";
        $cat_title = $row['category_name'];
            
            
                print("<option value='$cat_id'");
                if ($cat_id == $item_category){
                    print(" selected");
                }
                print (">{$cat_title}</option>");
            
            $_POST=array(); 
            
        }

?>
           
       </select>

                </div>

                <div class="form-group">
                    <label for="item_description">Item Description</label>
                    <textarea class="form-control " name="item_description" id="item_description" cols="10" rows="3"><?php echo $item_description; ?>
         </textarea>
                </div>
                <div class="form-group">
                    <label for="item_start_bidding_price">Start Bidding Price</label>
                    <input value="<?php echo $item_start_bidding_price; ?>" id="item_start_bidding_price" type="number" placeholder="0.00" name="start_bidding_price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$">
                </div>
                <div class="form-group">
                    <label for="item_min_sale_price">Min Sale Price</label>
                    <input value="<?php echo $item_min_sale_price; ?>" id="item_min_sale_price" type="number" placeholder="0.00" name="min_sale_price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$">
                </div>
                <div class="form-group">
                    <label for="item_get_it_now_price">Get It Now Price</label>
                    <input value="<?php echo $item_get_it_now_price; ?>" id="item_get_it_now_price" type="number" placeholder="0.00" required name="get_it_now_price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$">
                </div>



                <div class="form-group">
                    <label for="item_condition">Condition</label>
                    <select name="item_condition" id="item_condition">
           
<?php
        $table = 'items';
        $field = 'condition';
        $query = "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" ;
        $select_conditions = mysqli_query($connection,$query);
        
        confirmQuery($select_conditions);
        
         while ($row = mysqli_fetch_row($select_conditions)) {
            foreach(explode("','",substr($row[1],6,-2)) as $option) {
                print("<option value='$option'");
                if ($option == $item_condition){
                    print(" selected");
                }
                print (">{$option}</option>");
            }
        }

?>
           
        
       </select>

                </div>

                <div class="form_group">
                    <label for="item_return_accepted">Accept Return</label>
                    <input <?php if ($item_return_accepted) echo "checked"; ?> id="item_return_accepted" name="return" type="checkbox">


                </div>

                <div class="form-group">
                    <label for="end_date">Bidding End Time</label>
                    <input value="<?php echo substr(date('c', strtotime($item_end_date)),0,16); ?>" id= "end_date" type="datetime-local" name="end_date">
                    <!--              <input type="time" name="end_time">-->
                </div>




                <div class="form-group">
                    <input class="btn btn-primary" type="submit" name="submit" value="Update Item">
                </div>


            </form>