
                    <table class = "table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>ItemID</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Condition</th>
                                <th>Description</th>
                                <th>Min Sale Price</th>
                                <th>Get It Now Price</th>
                                <th>Accept Return</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                           
<?php
$query = "SELECT * FROM items";
$select_items = mysqli_query($connection, $query);
                                    
while($row = mysqli_fetch_assoc($select_items)){
    $get_category_name_query = "SELECT category_name FROM category WHERE categoryID = {$row['categoryID']} ";
    $get_category_name = mysqli_fetch_assoc(mysqli_query($connection, $get_category_name_query));
    
    $item_id = $row['itemID'];
    $item_name = $row['name'];
    $item_category = implode("|",$get_category_name);
    $item_description = $row['description'];
    $item_min_sale_price = $row['min_sale_price'];
    $item_get_it_now_price = $row['get_it_now_price'];
    $item_return_accepted = $row['return_accepted'];
    $item_end_date     = $row['end_time'];
    $item_condition    = $row['condition'];
    echo"<tr>";
    echo"<td>$item_id</td>";
    echo"<td>$item_name</td>";
    echo"<td>$item_category</td>";
    echo"<td>$item_condition</td>";
    echo"<td>$item_description</td>";
    echo"<td>$item_min_sale_price</td>";
    echo"<td>$item_get_it_now_price</td>";
    echo"<td>$item_return_accepted</td>";
    echo"<td>$item_end_date</td>";
    echo"<td><a href='items.php?source=edit_item&i_id={$item_id}'> Edit </a></td>";
    echo"<td><a href='items.php?delete={$item_id}'> Delete </a></td>";
    echo"<tr>";

}
?>
                       
                        </tbody>
                    </table>
                    

<?php
if(isset($_GET['delete'])){
    $the_item_id = $_GET['delete'];
    $query = "DELETE FROM items WHERE itemID = {$the_item_id}";
    $delete = mysqli_query($connection, $query);
    header('Location: items.php'); 
    
}

?>