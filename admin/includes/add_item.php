<?php

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
       
            $cur_time = mysqli_fetch_row(mysqli_query($connection,"SELECT NOW()"));
            $item_end_date     = escape(date("c", strtotime($cur_time[0]. ' + '.$_POST['days'].' days')));
//            $item_end_hour         = escape(date('d-m-y'));

       
//        move_uploaded_file($post_image_temp, "../images/$post_image" );
       

      $query = "INSERT INTO `items`(`name`,`description`,`min_sale_price`, `get_it_now_price`,`buy_availability`,`categoryID`,`condition`,`start_bidding`,`return_accepted`,`end_time`) ";
             
      $query .= "VALUES('{$item_name}','{$item_description}','{$item_min_sale_price}','{$item_get_it_now_price}','{$buy_availability}','{$item_category_id}', '{$item_condition}', '{$item_start_bidding_price}', b'{$item_return_accepted}', '{$item_end_date}') "; 
             
      $create_item_query = mysqli_query($connection, $query);  
      confirmQuery($create_item_query);

      $the_post_id = mysqli_insert_id($connection);


      echo "<p class='bg-success'>Item Created. <a href='items.php'>View All Items </a></p>";
       


   }

?>

    <!--    <form action="" method="post" enctype="multipart/form-data">    -->
    <form action="" method="post">

        <div class="form-group">
            <label for="title">Name</label>
            <input type="text" class="form-control" name="name" id="title">
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
            
            echo "<option value='$cat_id'>{$cat_title}</option>";
            
            $_POST=array(); 
            
        }

?>
           
       </select>

        </div>

        <div class="form-group">
            <label for="item_description">Item Description</label>
            <textarea class="form-control " name="item_description" id="item_description" cols="10" rows="3"></textarea>
        </div>

        <div class="form-group">
            <label for="item_start_bidding_price">Start Bidding Price</label>
            <input value="<?php echo $item_start_bidding_price; ?>" id="item_start_bidding_price" type="number" placeholder="0.00" name="start_bidding_price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$">
        </div>
        <div class="form-group">
            <label for="item_min_sale_price">Min Sale Price</label>
            <input id="item_min_sale_price" type="number" placeholder="0.00" name="min_sale_price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$">
        </div>
        <div class="form-group">
            <label for="item_get_it_now_price">Get It Now Price</label>
            <input id="item_get_it_now_price" type="number" placeholder="0.00" required name="get_it_now_price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$">
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
                print("<option value='$option'>{$option}</option>");
            }
        }

?>
           
        
       </select>

        </div>

        <div class="form_group">
            <label for="item_return_accepted">Accept Return</label>
            <input id="item_return_accepted" name="return" type="checkbox">


        </div>
        <p class="marquee">
            <span id="dtText"></span>
        </p>

        <div class="form-group">
            <label for="end_date">Bidding End in
           <select name="days" id="end_date">
            <option value=1>1</option>
            <option value=3>3</option>
            <option value=5>5</option>
            <option value=7>7</option>
          </select>
            Days
            </label>
                <!--              <input type="time" name="end_time">-->
        </div>




        <div class="form-group">
            <input class="btn btn-primary" type="submit" name="submit" value="Create Item">
        </div>


    </form>
