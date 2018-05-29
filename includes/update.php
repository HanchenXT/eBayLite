<?php

$query = "INSERT into `transaction` SELECT itemID, userID, 'Bid' ,MAX(bid_amount) FROM bid WHERE EXISTS (SELECT * FROM items where items.itemID = bid.itemID AND NOW()> items.end_time AND items.buy_availability = '1') GROUP BY itemID;";

$query .= "HAVING MAX(bid_amount) >= items.min_sale_price ORDER BY MAX(bid_amount)";

mysqli_query($connection, $query);
//echo $query;
$query = "UPDATE items SET buy_availability = '0' WHERE end_time < NOW();";
mysqli_query($connection, $query);
?>