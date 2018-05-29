<?php include "includes/admin_header.php" ?>
        







    <div id="wrapper">



        <!-- Navigation -->
 
        <?php include "includes/admin_navigation.php" ?>
        
        
    

<div id="page-wrapper">

<div class="container-fluid">

    <!-- Page Heading -->
    <div class="row">
        <div class="col-lg-12">

            <h1 class="page-header">
                GTBay User Report
            </h1>
            
    <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Username</th>
            <th>Listed</th>
        </tr>
        
        
    </thead>
    <tbody>
        <?php
            $l_query = "SELECT user_name, COUNT(s.itemID) AS Listed FROM User AS u, SoldBy as s WHERE u.userID = s.userID GROUP BY u.user_name ";
            $select_Listed = mysqli_query($connection, $l_query);

            while($row = mysqli_fetch_assoc($select_Listed)){
    
            $user_name = $row['user_name'];
            $listed = $row['Listed'];

            echo"<tr>";
            echo"<td>$user_name</td>";
            echo"<td>$listed</td>";
            echo"<tr>";
            }
        ?>
    </tbody>
    </table>
    

    <table class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>Username</th>
            <th>Sold</th>
        </tr>
    </thead>
        <?php
            $s_query = "SELECT user_name, COUNT(s.itemID) AS sold FROM User AS u, SoldBy as s WHERE u.userID = s.userID AND s.itemID IN (SELECT t.itemID FROM Transaction as t) GROUP BY u.user_name ";
            $select_sold = mysqli_query($connection, $s_query);

            while($row = mysqli_fetch_assoc($select_sold)){

                $user_name = $row['user_name'];
                $sold = $row['sold'];

                echo"<tr>";
                echo"<td>$user_name</td>";
                echo"<td>$sold</td>";
                echo"<tr>";
            }
        ?>
    </table>
    
    <table class="table table-bordered table-hover">
    <thead>
        <tr3>
            <th>Username</th>
            <th>Purchased</th>
        </tr3>
    </thead>
        <?php
            $p_query = "SELECT user_name, COUNT(itemID) AS Purchased FROM User, Transaction WHERE User.userID = Transaction.userID GROUP BY user_name ";
            $select_purchased = mysqli_query($connection, $p_query);
        
            while($row = mysqli_fetch_assoc($select_purchased)){

                $user_name = $row['user_name'];
                $purchased = $row['Purchased'];

                echo"<tr>";
                echo"<td>$user_name</td>";
                echo"<td>$purchased</td>";
                echo"<tr>";
            }
        ?>
    </table>
    
    <table class="table table-bordered table-hover">
    <thead>
        <tr4>
            <th>Username</th>
            <th>Rated</th>
        </tr4>
    </thead>
        <?php
            $c_query = "SELECT user_name, COUNT(itemID) AS comment FROM User, Comments WHERE User.userID = Comments.userID GROUP BY user_name ";
            $select_comment = mysqli_query($connection, $c_query);
        
            while($row = mysqli_fetch_assoc($select_comment)){

                $user_name = $row['user_name'];
                $comment = $row['comment'];

                echo"<tr>";
                echo"<td>$user_name</td>";
                echo"<td>$comment</td>";
                echo"<tr>";
            }
        ?>
    <tbody>
    </table>



            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->

</div>

     
        <!-- /#page-wrapper -->
        
    <?php include "includes/admin_footer.php" ?>
