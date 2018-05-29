<?php include "includes/admin_header.php"?>

    <div id="wrapper">

        <!-- Navigation -->
       <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    
                    <h1 class="page-header">
                        GTBay Category Report
                    </h1>
                    
                    <table class = "table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Category</th>
                                <th>Total Items</th>
                                <th>Min Price</th>
                                <th>Max Price</th>
                                <th>Average Price</th>
                            </tr>
                        </thead>
                        <tbody>
                           
                        <?php
                        $query = "SELECT category_name AS `Category`, COUNT(*) AS `Total Items`, MIN(get_it_now_price) AS `Min Price`, MAX(get_it_now_price) AS `Max Price`, ROUND(AVG(get_it_now_price), 2) AS `Average Price` "; 
                        $query .= "FROM Category, Items ";
                        $query .= "WHERE Category.categoryID = Items.categoryID AND Items.get_it_now_price > 0 GROUP BY  Items.categoryID";

                        $select_items = mysqli_query($connection, $query);


                        while($row = mysqli_fetch_assoc($select_items)){

                            $Category = $row['Category'];
                            $total_items = $row['Total Items'];
                            $min_price = $row['Min Price'];
                            $max_price = $row['Max Price'];
                            $average_price = $row['Average Price'];

                            echo"<tr>";
                            echo"<td>$Category</td>";
                            echo"<td>$total_items</td>";
                            echo"<td>$min_price</td>";
                            echo"<td>$max_price</td>";
                            echo"<td>$average_price</td>";
                            echo"<tr>";

                        }
                        ?>
                       
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
<?php include "includes/admin_footer.php" ?>

