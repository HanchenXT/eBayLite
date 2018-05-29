<div class="col-md-4">

    <div class="well">
        <h3>Item Search</h3>
        <form action="search.php" method="post">
           
            <h5 for="search">Key Word:</h5>
            <div class="input-group">
                <input name="search" type="text" class="form-control" placeholder="Key Word">
            </div>

            <h5 for="category">Category:</h5>
            <div class="input-group">
                <select class = "form-control" name="item_category" id="category">
                <option value=''></option>
            
                <?php

                    $query = "SELECT * FROM category ORDER BY categoryID";
                    $select_categories = mysqli_query($connection,$query);

                    confirmQuery($select_categories);


                    while($row = mysqli_fetch_assoc($select_categories )) {
                    $cat_id = $row['categoryID'];
                    $cat_title = $row['category_name'];

                        echo "<option value='$cat_id'>{$cat_title}</option>";

                        $_POST=array(); 

                    }

                ?>
       
               </select>
           </div>
           
           <div class="input-group">
                <h5 for="item_min_sale_price">Price Range:</h5>
                <label for="from">From $</label>
                <input class = "form-control" id="from" type="number" placeholder="0.00" name="min_price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$">
                <br>
                <label for="to">To     $</label>
                <input class = "form-control"  id="to" type="number" placeholder="100.00" name="max_price" min="0" value="0" step="0.01" title="Currency" pattern="^\d+(?:\.\d{1,2})?$">
           </div>

           <div class="input-group">
                <h5 for="item_condition">Minimum Condition</h5>
                <select class = "form-control"  name="item_condition" id="item_condition">
           
                <?php
                    $table = 'items';
                    $field = 'condition';
                    $query = "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" ;
                    $select_conditions = mysqli_query($connection,$query);

                    confirmQuery($select_conditions);

                     while ($row = mysqli_fetch_row($select_conditions)) {
                        print("<option value=''></option>");
                        foreach(explode("','",substr($row[1],6,-2)) as $option) {
                            print("<option value='$option'>{$option}</option>");
                        }
                        
                    }

                ?>
     
                </select>
           </div>
            
            <span class="input-group-btn">
                <hr>
                <button name = "submit" class="btn btn-default" type="submit">
                        <span class="glyphicon glyphicon-search"> Search</span>
                </button>
            </span>

        </form>
        <!-- /.input-group -->
    </div>

</div>