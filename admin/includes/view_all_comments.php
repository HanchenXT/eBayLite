
                    <table class = "table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Item</th>
                                <th>Author</th>
                                <th>Date</th>
                                <th>Comment</th>
                                <th>Rate</th>
                            </tr>
                        </thead>
                        <tbody>
                           
<?php
$query = "SELECT * FROM comments";
$select_comments = mysqli_query($connection, $query);
                                    
while($row = mysqli_fetch_assoc($select_comments)){
    $get_item_name_query = "SELECT name FROM items WHERE itemID = {$row['itemID']} ";
    $get_item_name = mysqli_fetch_assoc(mysqli_query($connection, $get_item_name_query));
    
    $get_user_name_query = "SELECT user_name FROM user WHERE userID = {$row['userID']} ";
    $get_user_name = mysqli_fetch_assoc(mysqli_query($connection, $get_user_name_query));
    
    $comment_id = $row['commentID'];
    $comment_user = implode("|",$get_user_name);
    $comment_item = implode("|",$get_item_name);
    $comment_comment_date     = $row['comment_date'];
    $comment_content = $row['content'];
    $comment_rate = $row['rate'];
    echo"<tr>";
    echo"<td>$comment_id</td>";
    echo"<td>$comment_item</td>";
    echo"<td>$comment_user</td>";
    echo"<td>$comment_comment_date</td>";
    echo"<td>$comment_content</td>";
    echo"<td>$comment_rate</td>";
//    echo"<td><a href='comments.php?source=edit_comment&i_id={$comment_id}'> Edit </a></td>";
    echo"<td><a href='comments.php?delete={$comment_id}'> Delete </a></td>";
    echo"<tr>";

}
?>
                       
                        </tbody>
                    </table>
                    

<?php

    if(isset($_GET['delete'])){
        deleteComment($_GET['delete']);
        header('Location: comments.php'); 
    }
    
?>