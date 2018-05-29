<?php include "includes/admin_header.php"?>

    <div id="wrapper">

        <!-- Navigation -->
       <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">
                        <h1 class="page-header">
                            Welcome to Admin
                            <small>Author</small>
                        </h1>
                        
                        <div class="col-xs-6">
                           
                            <form action="" method = "post">
                                <div class="form-group">
                                   <label for="cat-title">Add Category</label>
                                    <input type="text" class ="form-control" name = "cat_title">
                                </div>
                                <div class="form-group">
                                    <input class ="btn btn-primary" type="submit" value = "Add Category" name = "submit">
                                </div>
                            </form>
                           
                           <?php 
                            if(isset($_POST['submit'])){
                                $cat_title = $_POST['cat_title'];
                                if($cat_title == "" || empty($cat_title)){
                                    echo"This field chould not be empty";
                                }else {
                                    $query = "INSERT INTO category(category_name) ";
                                    $query .= "VALUE('{$cat_title}')";
                                    
                                    $create_category_query = mysqli_query($connection, $query);
                                    
                                    if(!$create_category_query){
                                        if (mysqli_errno($connection)==1062){   
//                                 echo "<meta http-equiv='refresh' content='0'>";
                                                echo "This value already exist ! ";
                                        }else{
                                            die('Query failed ' . mysqli_errno($connection) . " description : " . mysqli_error($connection));
                                        }
                                    }
                                }
                                header('Location: categories.php'); 
                            }
                            
                            ?>
                            
                            
                        </div>
                        <div class="col-xs-6">

                            <table class = "table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Category Title</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                    

<?php // FIND ALL CATEGORIES QUERY
$query = "SELECT * FROM category";
$select_categories = mysqli_query($connection, $query);
                                    
                                    
while($row = mysqli_fetch_assoc($select_categories)){
$cat_id = $row['categoryID'];
$cat_name = $row['category_name'];

echo "<tr>";
echo "<td>{$cat_id}</td>";
echo "<td>{$cat_name}</td>";
echo "<td><a href = 'categories.php?delete={$cat_id}'> Delete </a></td>";
echo "</tr>";

}


?>
                               
                               
<?php 
 //DELETE QUERY
  if(isset($_GET['delete'])){
      $the_cat_id = $_GET['delete'];
      $query = "DELETE FROM category WHERE categoryID = {$the_cat_id} ";
      $delete_query = mysqli_query($connection, $query);
      header('Location: categories.php'); 
      
          
  }
?>
                                    
                                </tbody>
                            </table>
                            
                            
                        </div>
<!--
                        
                        <ol class="breadcrumb">
                            <li>
                                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
                            </li>
                            <li class="active">
                                <i class="fa fa-file"></i> Blank Page
                            </li>
                        </ol>
-->
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
   <?php include "includes/admin_footer.php" ?>

