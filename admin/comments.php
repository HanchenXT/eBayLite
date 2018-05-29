<?php include "includes/admin_header.php"?>

    <div id="wrapper">

        <!-- Navigation -->
       <?php include "includes/admin_navigation.php" ?>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    
                    <h1 class="page-header">
                        Welcome to Admin
                        <small>Author</small>
                    </h1>
<?php
    if(isset($_GET['source'])){
        $source = $_GET['source'];
        
    } else {
        $source ='';
    }
    switch($source){
//            case 'add_item';
//            include "includes/add_item.php";
//            break;
//            
//            case 'edit_item';
//            include "includes/edit_item.php";
//            break;
//            
//            case 'edit_item_success';
//            include  "includes/edit_item_success.php";
//            break;
            
        default:
            include "includes/view_all_comments.php";
            break;
    }
    
    
    ?>

                </div>
            </div>
            <!-- /.row -->

        </div>
        <!-- /.container-fluid -->

    </div>
<?php include "includes/admin_footer.php" ?>

